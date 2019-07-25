<?php


namespace App\Services\Channels;

use App\Models\Channel;
use GuzzleHttp\Client;
use App\Models\Material;
use App\Models\MaterialFile;
use App\Models\MaterialFileAttachments;
use Illuminate\Support\Facades\DB;
use App\Exceptions\WaitDownloadException;
class SsScChannelService
{
    private $channel;

    private $login = '/api/login';

    private $downloadCheck = '/api/download';

    private $downloadUrl;

    private $restartCount = 0;

    private $cookie;

    private $waitAfreshCount = 0;

    private $client;


    public function __construct(Channel $channel)
    {
        $this->channel = $channel;

        $this->client = new Client();

        //直接给账号登录，维持登录状态
        $this->login();
    }

    /**
     * 登录
     *
     * @param boolean $refresh 是否强制刷新cookie
     * @throws
     **/
    public function login($refresh = false){

        if($refresh || !$this->channel->cookie){

            $postData = [
                'mobile'=>$this->channel->username,
                'password'=>$this->channel->password,
            ];
            $postLoginUrl = $this->channel->domain.$this->login;


            $result = $this->client->request('POST',$postLoginUrl,[
                'json'=>$postData,
                'headers'=>[
                    'Host'=>'sssc.co',
                    'Origin'=>'http://sssc.co',
                    'Referer'=>'http://sssc.co/signIn',
                ]
            ]);
            $result_data = json_decode($result->getBody(),true);
            if(array_get($result_data,'code') == 0){
                //代表登录成功
                $this->cookie = array_get($result_data,'data.token');
                $this->channel->cookie = array_get($result_data,'data.token');
                $this->channel->save();
            }


        }else{
            $this->cookie = $this->channel->cookie;


        }

        //判断是否有下载
        if($this->downloadUrl){

            //重新cookie,计数器
            $this->restartCount = $this->restartCount+1;
            if($this->restartCount == 3){ //当重新登录达到3次之后将抛出异常，销毁本类
                throw new \Exception("渠道重登失败~");
            }

            //重新获取下载
            $this->download($this->downloadUrl);
        }


    }


    public function download($url){
        return $this->waitRecursionLoad($url);
    }

    private function waitRecursionLoad($url){

        $postUrl = $this->channel->domain.$this->downloadCheck;
        $this->downloadUrl = $url;
        $postData = [
            "url"=>$url,
            "token"=>$this->cookie,
        ];

        $result = $this->client->request('POST',$postUrl,[
            'json'=>$postData,
        ]);
        $data = json_decode($result->getBody(),true);
        if((array_get($data,'code') == 0  && array_get($data,'data.status') == 'wait') || array_get($data,'code') == 10000){
            if($this->waitAfreshCount < 10){
                sleep(2);
                $this->waitAfreshCount = $this->waitAfreshCount+1;
                return $this->waitRecursionLoad($this->downloadUrl);

            }else{
                throw new WaitDownloadException('文件已加急下载至服务器中，请稍后重试~');
            }

        }

        if(array_get($data,'code') == 0 && array_get($data,'data.status') == 'done'){


            $data = array_get($data,'data');

            $material_file = DB::transaction(function ()use($data,$url) {
                $item_no = $this->parseUrlItemNo($url);
                $material = $this->marryMaterialUrl(array_get($data,'site'));
                $material_file_data = [
                    'material_id'=>$material->id,
                    'channel_id'=>$this->channel->id,
                    'title'=>array_get($data,'title'),
                    'item_no'=>$item_no,
                    'source'=>$url,
                ];


                //查询该文件是否存在
                if($material_file = MaterialFile::where('material_id',$material->id)->where('item_no',$item_no)->first()){
                    MaterialFile::where('material_id',$material->id)->where('item_no',$item_no)->update($material_file_data);

                    //把文件的附件删除重新添加
                    MaterialFileAttachments::where('material_file_id',$material_file->id)->delete();
                }else{
                    $material_file = MaterialFile::create($material_file_data);
                }

                $attachments = array_get($data,'attachments');

                foreach($attachments as $item){


                    $file_insert = [
                        'material_file_id'=>$material_file->id,
                        'title'=>array_get($item,'title'),
                        'source'=>array_get($item,'source'),
                        'path'=>array_get($item,'path'),
                        'size'=>array_get($item,'size'),
                        'format'=>array_get($item,'meta.format'),
                        'extra'=>json_encode(array_get($item,'meta'),JSON_UNESCAPED_UNICODE),
                    ];

                    MaterialFileAttachments::create($file_insert);
                }

                return $material_file;
            });
            return $material_file;
        }elseif(array_get($data,'code') == 99999){
            //登录过期，重新登录
            $this->downloadUrl = $url;
            $this->login(true);
        }elseif(array_get($data,'code') == 10003){
            //该网站下载次数已用完
            return false;
        }else{
            return false;
        }


    }

    public function marryMaterialUrl($site){
        return Material::where('site',$site)->first();
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
}