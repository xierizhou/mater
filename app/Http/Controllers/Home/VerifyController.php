<?php

namespace App\Http\Controllers\Home;

use App\Models\Channel;
use App\Services\MaterialUrlAnalysisService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VerifyController extends Controller
{
    /**
     * 包图验证码验证
     * @param Request $request
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function iboutu(Request $request){
        $item_no = MaterialUrlAnalysisService::parseUrlItemNo($request->url);
        $url = 'https://ibaotu.com/index.php?m=downVarify&a=index&id='.$item_no.'&kwd%20=';
        $channel = Channel::find(4);
        $client = new Client();
        $response = $client->request('GET',$url,[
            'headers'=>[
                'Cookie'=>$channel->cookie,
            ],
        ]);

        $setCookie = $response->getHeader('Set-Cookie');
        $verCookie = [];
        foreach($setCookie as $item){
            $cookie = explode('=',array_get(explode(';',$item),0));
            if(array_get($cookie,1)){
                $verCookie[array_get($cookie,0)] = array_get($cookie,1);
            }
        }
        $contents = $response->getBody()->getContents();

        $reg = '/<img src="(.*?)" data-key="(.*?)">/s';
        preg_match_all($reg,$contents,$match);
        $key = array_get($match,2);

        $reg = "/<p class=\"tips\">请点击图片中的'<span>(.*?)<\/span>'字<\/p>/s";
        preg_match($reg,$contents,$match);
        $value = array_get($match,1);

        //检测是否需要无痕验证
        $check = $client->request('GET',"https://ibaotu.com/?m=download&id=$item_no",[
            'headers'=>[
                'Cookie'=>$channel->cookie,
            ],
        ]);
        $cn = $check->getBody()->getContents();
        $reg = "/'boole':(.*?),/s";
        preg_match($reg,$cn,$match);
        $is_yz = array_get($match,1);
        return view('home.ibaotu_varify')->with('is_yz',$is_yz)->with('key',$key)->with('value',$value)->with('item_no',$item_no)->with('ver',$verCookie);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function iboutuVerify(Request $request){
        $url = "https://ajax.ibaotu.com/?m=AjaxDownload&a=verifyCaptcha&answer_key={$request->answer_key}&callback=".$request->item_no;

        $channel = Channel::find(4);
        $client = new Client();
        $response = $client->request('GET',$url,[
            'headers'=>[
                'Cookie'=>'answer_key='.$request->ver_id.';auth_id=22949972%7C%7C1565786347%7Ca8c64b984d2c43d9e39f8f3311708f58',
                'Referer'=>'https://ibaotu.com/index.php?m=downVarify&a=index&id='.$request->item_no.'&kwd%20=',
                'Origin'=>'https://ibaotu.com',
                'Host'=>'ibaotu.com',

            ],
        ]);
        $response = json_decode($response->getBody()->getContents(),true);
        return response()->json($response);
    }
}
