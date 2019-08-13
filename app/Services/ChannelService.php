<?php


namespace App\Services;


use App\Jobs\DownloadMaterialJob;
use App\Models\Channel;
use App\Models\ChannelAccount;
use App\Models\ChannelAccountAuth;
use App\Models\Material;
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

    private $material;

    private function __clone(){}

    static public function getInstance(Material $material){
        if (!self::$instance instanceof self) {
            self::$instance = new self($material);
        }
        return self::$instance;
    }

    /**
     * ChannelService constructor.
     * @param Material $material
     * @throws \Exception
     */
    private function __construct(Material $material)
    {
        $config = config('channel');
        $this->material = $material;


        $auth = $this->autoChannelAccountAuth();

        $account = $auth->account;

        $this->channel = Channel::find($account->channel_id);



        if(array_has($config,$this->channel->alias_name)){
            $class = array_get($config,$this->channel->alias_name);
            $this->object = new $class($this->channel,$account,$auth);
        }else{
            throw new \Exception("未找到".$this->channel->name."通道");
        }
    }

    /**
     * 自动获取下载素材的通道以及账号.权限
     */
    public function autoChannelAccountAuth(){
        $auth = ChannelAccountAuth::where('material_id',$this->material->id)->where('current','>',0)->where('status',1)->first();

        return $auth;
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
        //$item_no = MaterialUrlAnalysisService::parseUrlItemNo($url);


        //$file = MaterialFile::where('material_id',$this->material->id)->where('item_no',$item_no)->first();

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

            MaterialFile::where('material_id',$this->material->id)->where('item_no',$item_no)->delete();

            $Obtain = new ObtainPageService();
            $obtain_config = config('obtain.'.$this->material->site);
            $attachments = $Obtain->build(new $obtain_config,$url);
            $file = MaterialFile::create([
                'material_id'=>$this->material->id,
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