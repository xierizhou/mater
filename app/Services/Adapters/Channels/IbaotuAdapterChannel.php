<?php


namespace App\Services\Adapters\Channels;


use App\Exceptions\ChannelFailException;
use App\Exceptions\ChannelLoginFailException;
use App\Models\ChannelAccountCookie;
use App\Models\ChannelCookie;
use App\Services\Interfaces\ChannelInterface;
use App\Services\MaterialUrlAnalysisService;

class IbaotuAdapterChannel extends ChannelsAdapter implements ChannelInterface
{


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
     * @return mixed|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function login($refresh = false)
    {
        ChannelAccountCookie::where('channel_account_id',$this->account->id)->delete();
        $result = $this->client->request('GET',$this->account->extra,[
            'allow_redirects'=>false,
        ]);
        $setCookie = $result->getHeader('Set-Cookie');
        $auth_cookie = '';
        foreach($setCookie as $item){
            $save_cookie = array_get(explode(';',$item),0);
            $cookie = explode('=',$save_cookie);

            if(array_get($cookie,0) == 'auth_id'){
                ChannelAccountCookie::create([
                    'channel_account_id'=>$this->account->id,
                    'type'=>array_get($cookie,0),
                    'cookie'=>$save_cookie,
                ]);
                $auth_cookie = $save_cookie;
            }
        }
        return $auth_cookie;

    }

    /**
     * @param string $url
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function download(string $url)
    {
        if(!$cookie = ChannelAccountCookie::where('channel_account_id',$this->account->id)->where('type','auth_id')->first()){
            $cookie = $this->login(true);
            $this->cookie = $cookie;
        }else{
            $this->cookie = $cookie->cookie;
        }

        $this->downloadUrl = $url;
        $item_no = $this->parseUrlItemNo($url);
        $requestUrl = "https://ibaotu.com/?m=downloadopen&a=open&id=$item_no&down_type=1&&attachment_id=";

        $result = $this->client->request('GET',$requestUrl,[
            'headers'=>[
                'Accept'=>'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
                'Cookie'=>$this->cookie,
                'Host'=>'ibaotu.com',
                'Referer'=>'https://ibaotu.com/?m=download&id='.$item_no,
                'User-Agent'=>'Mozilla/5.0 (Windows NT 10.0; Win64; x64) ipad/537.36 (KHTML, like Gecko) ipad/73.0.3683.103 ',
                'Upgrade-Insecure-Requests'=>1
            ],
            'allow_redirects'=>false,
        ]);
        $location = $result->getHeader('Location');

        return array_get($location,0);


    }



}