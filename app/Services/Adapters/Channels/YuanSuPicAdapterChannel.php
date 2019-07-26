<?php


namespace App\Services\Adapters\Channels;


use App\Exceptions\ChannelFailException;
use App\Exceptions\ChannelLoginFailException;
use App\Models\ChannelCookie;
use App\Services\Interfaces\ChannelInterface;
use App\Services\MaterialUrlAnalysisService;

class YuanSuPicAdapterChannel extends ChannelsAdapter implements ChannelInterface
{
    /**
     * @var string
     */
    private $login = "/api/user/login";

    /**
     * @var string
     */
    private $download = '/api/download/download';

    /**
     * @var
     */
    private $cookie;

    /**
     * @var
     */
    private $downloadUrl;

    /**
     * @var
     */
    private $restartLoginCount=0;

    /**
     * 解析失败尝试次数
     * @var int
     */
    private $tries = 5;

    /**
     * 当前重新解析次数
     * @var int
     */
    private $tries_current = 0;

    /**
     * 每次重新尝试间隔几秒
     * @var int
     */
    private $tries_second = 10;


    /**
     * @param bool $refresh
     * @return mixed|void
     * @throws ChannelFailException
     * @throws ChannelLoginFailException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function login($refresh = false)
    {
        if($refresh || !$this->channel->cookie){
            $postData = [
                'username'=>$this->channel->username,
                'pwd'=>$this->channel->password,
            ];
            $postLoginUrl = $this->channel->domain.$this->login;
            $result = $this->client->request('POST',$postLoginUrl,[
                'json'=>$postData
            ]);

            $cookie = $result->getHeader('Set-Cookie');
            if($cookie){
                $res = explode(';',implode(';',$cookie));
                $this->cookie = array_get($res,0);
                $this->channel->cookie = $this->cookie;
                $this->channel->save();
                $this->restartLoginCount = 0;
            }
        }else{
            $this->cookie = $this->channel->cookie;
        }

        if($this->downloadUrl){
            if($this->restartLoginCount < 3){
                $this->restartLoginCount++;
                $this->download($this->downloadUrl);
            }else{
                throw new ChannelLoginFailException($this->channel->name.'重新登录超过'.$this->restartLoginCount.'次');
            }

        }

    }

    /**
     * @param string $url
     * @return mixed
     * @throws ChannelFailException
     * @throws ChannelLoginFailException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function download(string $url)
    {
        $this->cookie = $this->channel->cookie;
        $this->downloadUrl = $url;
        $this->check($url);

        $postUrl = $this->channel->domain.$this->download;
        $item_no = $this->parseUrlItemNo($url);
        $material = MaterialUrlAnalysisService::getBuildMaterial($url);
        $postData = [
            'typ'=>$material->site,
            'picid'=>$item_no,
            'url'=>$url,
        ];

        $result = $this->client->request('POST',$postUrl,[
            'json'=>$postData,
            'headers'=>[
                'Accept'=>'application/json, text/javascript, */*; q=0.01',
                'Accept-Encoding'=>'gzip, deflate',
                'Accept-Language'=>'zh-CN,zh;q=0.9',
                'Connection'=>'keep-alive',
                'Content-Length'=>84,
                'Content-Type'=>'application/x-www-form-urlencoded; charset=UTF-8',
                'Cookie'=>[$this->cookie],
                'Host'=>'15cheng.yuansupic.com',
                'Origin'=>'http://15cheng.yuansupic.com',
                'Referer'=>'http://15cheng.yuansupic.com/',
                'User-Agent'=>'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36',
                'X-Requested-With'=>'XMLHttpRequest'
            ],
        ]);

        $setCookie = $result->getHeader('Set-Cookie');
        foreach ($setCookie as $item){
            $tmp = explode(';',$item);
            $reCookie = explode('=',array_get($tmp,0));
            if(array_get($reCookie,0) == 'tk'){
                $channel_cookie = ChannelCookie::where("channel_id",$this->channel->id)->where('type','tk')->first();
                if($channel_cookie){
                    $channel_cookie->cookie = array_get($tmp,0);
                    $channel_cookie->save();
                }else{
                    ChannelCookie::create([
                        'channel_id'=>$this->channel->id,
                        'type'=>'tk',
                        'cookie'=>array_get($tmp,0),
                    ]);
                }

            }

        }
        $body = json_decode($result->getBody(),true);
        dd($body);
        if(array_get($body,'status') == 0){
            //正常下载
            $this->tries_current = 0; //复原
            return array_get($body,'url');
        }elseif(array_get($body,'status') == 403){
            $this->login(true);
        }else{

            if($this->tries_current > $this->tries){
                $this->tries_current = 0; //复原
                throw new ChannelFailException(array_get($body,'description'));
            }
            $this->tries_current++;
            sleep($this->tries_second);
            $this->download($this->downloadUrl);
        }

    }


    /**
     * @param string $url
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function check(string $url){
        $this->cookie = $this->channel->cookie;
        $this->downloadUrl = $url;
        $postUrl = $this->channel->domain.'/api/download/check';
        $postData = [
            'url'=>$url,
        ];
        $result = $this->client->request('POST',$postUrl,[
            'json'=>$postData,
            'headers'=>[
                'Cookie'=>[$this->cookie],
                'Host'=>'15cheng.yuansupic.com',
                'Origin'=>'http://15cheng.yuansupic.com',
                'Referer'=>'http://15cheng.yuansupic.com/',
                'User-Agent'=>'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36',
                'X-Requested-With'=>'XMLHttpRequest'
            ],
        ]);

        return json_decode($result->getBody(),true);
    }
}