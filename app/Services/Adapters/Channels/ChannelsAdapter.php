<?php


namespace App\Services\Adapters\Channels;


use App\Models\Channel;
use GuzzleHttp\Client;
class ChannelsAdapter
{
    /**
     * @var Channel $channel
     */
    protected $channel;

    /**
     * @var Client
     */
    protected $client;

    /**
     * ChannelsAdapter constructor.
     * @param Channel $channel
     */
    public function __construct(Channel $channel)
    {
        $this->channel = $channel;
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