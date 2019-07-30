<?php

namespace App\Http\Controllers\Home;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorizationLoginController extends Controller
{
    /**
     * @return $this
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function qianku(){

        $url = 'https://graph.qq.com/oauth2.0/authorize';
        $client = new Client();
        $res = $client->request('POST',$url,[
            'headers'=>[
                'Content-Type'=>'application/x-www-form-urlencoded',
                'Cookie'=>'p_uin=o0932188443; pt4_token=pZvixj-c87HDh5puegzRJMh140FUsMM1clov5eHC0Yk_; p_skey=-ptwZJb8asnobKKHBrpi1X9jhllDEMTZIJ3oifidb38_',
                'Host'=>'graph.qq.com',
                'Origin'=>'https://graph.qq.com',
                'Referer'=>'https://graph.qq.com/oauth2.0/show?which=Login&display=pc&client_id=101252414&redirect_uri=https%3A%2F%2F588ku.com%2Fdlogin%2Fcallback%2Fqq&response_type=code&scope=get_user_info%2Cadd_share%2Cadd_pic_t',
                'Upgrade-Insecure-Requests'=>1,
                'User-Agent'=>'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36'
            ],
            'form_params'=>[
                'response_type'=>'code',
                'client_id'=>101483052,
                'redirect_uri'=>'https://access.video.qq.com/user/auth_login?vappid=11059694&vsecret=fdf61a6be0aad57132bc5cdf78ac30145b6cd2c1470b0cfe&raw=1&type=qq&appid=101483052',
                'scope'=>'get_user_info,add_share,add_pic_t',
                'from_ptlogin'=>1,
                'src'=>1,
                'update_auth'=>1,
                'openapi'=>'80901010',
                'g_tk'=>1256528630,
                'auth_time'=>'1564401638106',
                //'ui'=>'BC4D7ACF-D96A-47CB-91D6-F048669D8A00',
            ],
            'allow_redirects'=>false,
        ]);
        $location = $res->getHeader('Location');
        echo array_get($location,0);exit;
        dd($location);
        return view('home.authorization.qianku')->with('localhost',array_get($location,0));
    }




}
