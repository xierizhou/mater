<?php


namespace App\Services\Adapters\Channels;


use App\Exceptions\ChannelFailException;
use App\Exceptions\ChannelLoginFailException;
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



    public function login($refresh = false)
    {


    }

    /**
     * @param string $url
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function download(string $url)
    {

        $this->cookie = $this->channel->cookie;
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