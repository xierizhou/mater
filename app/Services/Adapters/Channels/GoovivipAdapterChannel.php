<?php


namespace App\Services\Adapters\Channels;


use App\Exceptions\ChannelFailException;
use App\Exceptions\ChannelLoginFailException;
use App\Models\ChannelAccountCookie;
use App\Models\ChannelCookie;
use App\Services\Interfaces\ChannelInterface;
use App\Services\MaterialUrlAnalysisService;

class GoovivipAdapterChannel extends ChannelsAdapter implements ChannelInterface
{
    /**
     * @var string
     */
    private $login = "/api_page/login";

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
        if($refresh){

            $postLoginUrl = $this->channel->domain.$this->login."?username={$this->account->username}&password={$this->account->password}";
            $result = $this->client->request('GET',$postLoginUrl);

            $result_data = json_decode($result,true);
            if(array_get($result_data,0) != 'success'){
                throw new ChannelFailException("登录失败");
            }

            $setCookie = $result->getHeader('Set-Cookie');
            $sessionid = '';
            foreach($setCookie as $item){
                $save_cookie = array_get(explode(';',$item),0);
                $cookie = explode('=',$save_cookie);

                if(array_get($cookie,0) == 'sessionid'){
                    ChannelAccountCookie::create([
                        'channel_account_id'=>$this->account->id,
                        'type'=>array_get($cookie,0),
                        'cookie'=>$save_cookie,
                    ]);
                    $sessionid = $save_cookie;
                }
            }

            $this->cookie = $sessionid;


        }



    }


    public function download(string $url)
    {
        if(!$cookie = ChannelAccountCookie::where('channel_account_id',$this->account->id)->where('type','sessionid')->first()){
            $cookie = $this->login(true);
            $this->cookie = $cookie;
        }else{
            $this->cookie = $cookie->cookie;
        }


        $this->downloadUrl = $url;




    }



}