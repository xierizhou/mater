<?php


namespace App\Services;

use App\Models\Material;
use App\Exceptions\WaitDownloadException;
use App\Jobs\DownloadMaterialJob;
use App\Models\MaterialFile;
use App\Models\UserMaterial;
class MaterialDownloadService
{
    private $material;

    private $download_url;

    public function __construct(Material $material,string $download_url)
    {
        $this->material = $material;
        $this->download_url = $download_url;
    }

    /**
     * 下载素材文件
     *
     * @throws WaitDownloadException
     * @throws \Exception
     **/
    public function download(){

        //检测文件是否在OSS上
        $checkFile = $this->checkIsDownload();

        if($checkFile){
            $checkFile->is_decrease = 0;
            //如果用户没下载过，就要扣除次数
            if(!MaterialUserDownloadLogs::getInstance()->getLogFindFile($checkFile)){
                MaterialUserDownloadLogs::getInstance()->log($checkFile);
                $this->decreaseNumber($checkFile->material);
                $checkFile->is_decrease = 1;
            }

            return $checkFile;
        }


        $channel = $this->material->channel;
        if(!$channel){
            throw new \Exception("暂无可下载通道");
        }
        $config_channel = config('channel');
        $errorMessage = "下载失败";
        foreach($channel as $item){
            if(array_has($config_channel,$item->domain)){

                $channel_class = array_get($config_channel,$item->domain);

                try{
                    $object = new $channel_class($item);
                    $files = $object->download($this->download_url);
                    if(!$files){
                        continue;
                    }
                    DownloadMaterialJob::dispatch($files);
                    $files->is_decrease = 0;
                    //如果用户没下载过，就要扣除次数
                    if(!MaterialUserDownloadLogs::getInstance()->getLogFindFile($files)){
                        MaterialUserDownloadLogs::getInstance()->log($files);
                        $this->decreaseNumber($files->material);
                        $files->is_decrease = 1;
                    }

                    return $files;
                    break;
                }catch (WaitDownloadException $exception){
                    $errorMessage = $exception->getMessage();
                    continue;
                }catch (\Exception $exception){
                    $errorMessage = "文件解析失败";
                    continue;
                }


            }

        }
        throw new \Exception($errorMessage);
    }


    /**
     * 检测是否下载，如果下载了并且提交到了阿里OSS，直接获取
     **/
    public function checkIsDownload(){
        $item_no = $this->parseUrlItemNo($this->download_url);
        $file = MaterialFile::where('material_id',$this->material->id)->where('item_no',$item_no)->first();
        $is = false;
        if($file->attachments){
            foreach($file->attachments as $item){
                if($item->oss){
                    $item->path = AliOssService::getInstance()->getObject($item->oss);
                    $item->save();
                    $is = true;
                }else{
                    $is = false;
                    break;
                }
            }
        }
        if($is){
            return $file;
        }
        return $is;


    }

    /**
     * 提取URL中的文件编号
     *
     * @param string $url
     * @return string
     **/
    public function parseUrlItemNo($url){
        $parse = parse_url($url);
        $path = explode('/',array_get($parse,'path'));
        $count_path = count($path)-1;
        $list = explode('.',array_get($path,$count_path));
        return array_get($list,0);
    }

    /**
     * 减少用户的次数
     * @param Material $material
     */
    public function decreaseNumber(Material $material){
        $material_id = $material->id;
        $user_id = auth()->user()->id;
        UserMaterial::where('user_id',$user_id)->where('material_id',$material_id)->decrement('current');
    }
}