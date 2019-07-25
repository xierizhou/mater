<?php


namespace App\Services\Channels;

use App\Models\Channel;
use GuzzleHttp\Client;
use mysql_xdevapi\Exception;

class WholeDownChannelService
{
    private $channel;

    private $login = '/api/user/login';

    private $downloadCheck = '/api/download/check';

    private $downloadUrl;

    private $restartCount = 0;

    private $cookie;

    public function __construct(Channel $channel)
    {
        $this->channel = $channel;

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
                'username'=>$this->channel->username,
                'pwd'=>$this->channel->password,
            ];
            $postLoginUrl = $this->channel->domain.$this->login;

            $client = new Client();
            $result = $client->request('POST',$postLoginUrl,[
                'json'=>$postData
            ]);

            $cookie = $result->getHeader('Set-Cookie');
            if($cookie){
                $res = explode(';',implode(';',$cookie));
                $this->cookie = array_get($res,0);
                $this->channel->cookie = $this->cookie;
                $this->channel->save();
            }

        }else{
            $this->cookie = $this->channel->cookie;

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




    }

    /**
     * 下载
     *
     * @param string $url 下载地址
     * @throws
     **/
    public function download($url){
        $this->downloadUrl = $this->channel->domain.$this->downloadCheck;
        $postData = [
            "url"=>$url
        ];

        $client = new Client();
        $result = $client->request('POST',$this->downloadUrl,[
            'json'=>$postData,
            'headers'=>[
                'Cookie'=>[$this->cookie],
            ],
        ]);
        $data = json_decode($result->getBody(),true);
        if(array_get($data,'status') == '403'){
            //如果登录过期，强制刷新cookie
            $this->login(true);
        }
        dd($data);
    }
}