<?php


namespace App\Services;


use App\Jobs\DownloadMaterialJob;
use App\Models\Channel;
use App\Models\MaterialFile;
use App\Models\MaterialFileAttachments;
use App\Services\Interfaces\ChannelInterface;
use Illuminate\Support\Facades\DB;
use OSS\OssClient;

class ChannelService implements ChannelInterface
{
    static private $instance;

    private $object;

    private $saveOss = true;

    private $channel;

    private function __clone(){}

    static public function getInstance(Channel $channel){
        if (!self::$instance instanceof self) {
            self::$instance = new self($channel);
        }
        return self::$instance;
    }

    /**
     * ChannelService constructor.
     * @param Channel $channel
     * @throws \Exception
     */
    private function __construct(Channel $channel)
    {
        $config = config('channel');

        $this->channel = $channel;
        if(array_has($config,$channel->alias_name)){
            $class = array_get($config,$channel->alias_name);
            $this->object = new $class($channel);
        }else{
            throw new \Exception("未找到".$channel->name."通道");
        }
    }

    /**
     * @param bool $refresh
     * @return mixed|void
     */
    public function login($refresh = false)
    {
        $this->object->login($refresh);
    }

    /**
     * @param bool $bool
     * @return $this
     */
    public function setSaveOss($bool = true){
        $this->saveOss = $bool;
        return $this;
    }

    /**
     * @param string $url
     * @return mixed|void
     * @throws \Throwable
     */
    public function download(string $url)
    {

        //提取下载文件中的编号
        $item_no = MaterialUrlAnalysisService::parseUrlItemNo($url);

        $material = MaterialUrlAnalysisService::getBuildMaterial($url);


        $file = MaterialFile::where('material_id',$material->id)->where('item_no',$item_no)->first();

        if($file){
            $return = true;
            foreach($file->attachments as $val){
                if(!$val->oss){
                    $return = false;
                    break;
                }
                $val->path = AliOssService::getInstance()->getObject($val->oss);
                $val->save();

            }
            if($return){
                return $file;
            }

        }


        $source = $this->object->download($url);

        try{
            $file = $this->saveMaterialFile($url,$source);
            if(!$file->is_oss && $this->saveOss){
                DownloadMaterialJob::dispatch($file);
            }

            return $file;
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
            //dd($exception->getMessage());
        }


    }

    /**
     * @param $url
     * @param $source
     * @return mixed
     * @throws \Throwable
     */
    private function saveMaterialFile($url,$source){

        return DB::transaction(function ()use($url,$source) {

            //提取下载文件中的编号
            $item_no = MaterialUrlAnalysisService::parseUrlItemNo($url);
            $material = MaterialUrlAnalysisService::getBuildMaterial($url);


            MaterialFile::where('material_id',$material->id)->where('item_no',$item_no)->delete();

            $Obtain = new ObtainPageService();
            $obtain_config = config('obtain.'.$material->site);
            $attachments = $Obtain->build(new $obtain_config,$url);
            $file = MaterialFile::create([
                'material_id'=>$material->id,
                'channel_id'=>$this->channel->id,
                'item_no'=>$item_no,
                'source'=>$url,
                'title'=>trim(array_get($attachments,'title',''))
            ]);
            MaterialFileAttachments::create([
                'material_file_id'=>$file->id,
                //'title'=>'',
                'source'=>$source,
                //'format'=>trim(array_get($attachments,'format','')),
            ]);
            return $file;
        });
    }
}