<?php


namespace App\Services\Adapters\Channels;


use App\Models\Channel;
use App\Models\ChannelAccount;
use App\Models\ChannelAccountAuth;
use GuzzleHttp\Client;
class ChannelsAdapter
{
    /**
     * @var Channel $channel
     */
    protected $channel;

    protected $account;

    protected $auth;

    /**
     * @var Client
     */
    protected $client;


    /**
     * ChannelsAdapter constructor.
     * @param Channel $channel
     * @param ChannelAccount $account
     * @param ChannelAccountAuth $auth
     */
    public function __construct(Channel $channel,ChannelAccount $account,ChannelAccountAuth $auth)
    {
        $this->channel = $channel;
        $this->account = $account;
        $this->auth = $auth;
        $this->client = new Client();
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