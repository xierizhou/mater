<?php


namespace App\Services;


use App\Services\Adapters\ObtainPages\ObtainPageBaseAdapter;
use App\Services\Adapters\ObtainPages\ObtainPageRegexInterface;
use App\Services\Interfaces\ObtainPageInterface;

class ObtainPageService extends ObtainPageBaseAdapter implements ObtainPageInterface
{
    private $obtainPagePegex;
    public function build(ObtainPageRegexInterface $obtainPageRegex,string $url)
    {

        $this->obtainPagePegex = $obtainPageRegex;

        $data = $this->client->request('GET',$url);
        $html = iconv("GBK", "UTF-8", $data->getBody());

        preg_match($this->obtainPagePegex->titleRegex() ,$html,$match);
        $title = array_get($match,1);
        preg_match($this->obtainPagePegex->formatRegex() ,$html,$match);
        $format = array_get($match,1);

        return [
            'title'=>$title,
            'format'=>$format
        ];
    }


}