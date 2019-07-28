<?php

namespace App\Http\Controllers\Home;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorizationLoginController extends Controller
{
    public function qianku(){

        $url = 'https://graph.qq.com/oauth2.0/authorize';
        $client = new Client();
        $res = $client->request('POST',$url,[
            'headers'=>[
                'Content-Type'=>'application/x-www-form-urlencoded',
                'Cookie'=>'pgv_pvi=7277396992; pgv_pvid=5886647982; RK=4CyxSFzNeC; ptcz=241fcf79f5690502d3b1dcfa1fea975f28669091659db5545d896990b2898af2; tvfe_boss_uuid=e6141b191147bcce; ui=BC4D7ACF-D96A-47CB-91D6-F048669D8A00; pac_uid=0_daa6d84acbf49; ptui_loginuin=422712228; _qpsvr_localtk=0.9054354890067988; pgv_si=s7981357056; ptisp=ctc; p_uin=o0422712228; pt4_token=o9Qjna0AVqwfb6jvjS*jNMWo4fgoS-J9-lZ519SEDRA_; p_skey=pJlxjtUklqUO8TZ4bqGqrT1zXCoB-fvVxSu5Kyfg62g_',
                'Host'=>'graph.qq.com',
                'Origin'=>'https://graph.qq.com',
                'Referer'=>'https://graph.qq.com/oauth2.0/show?which=Login&display=pc&client_id=101252414&redirect_uri=https%3A%2F%2F588ku.com%2Fdlogin%2Fcallback%2Fqq&response_type=code&scope=get_user_info%2Cadd_share%2Cadd_pic_t',
                'Upgrade-Insecure-Requests'=>1,
                'User-Agent'=>'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36'
            ],
            'form_params'=>[
                'response_type'=>'code',
                'client_id'=>101252414,
                'redirect_uri'=>'https://588ku.com/dlogin/callback/qq',
                'scope'=>'get_user_info,add_share,add_pic_t',
                'from_ptlogin'=>1,
                'src'=>1,
                'update_auth'=>1,
                'openapi'=>'80901010',
                'g_tk'=>2141655895,
                'auth_time'=>'1564188390366',
                'ui'=>'BC4D7ACF-D96A-47CB-91D6-F048669D8A00',
            ],
            'allow_redirects'=>false,
        ]);
        $location = $res->getHeader('Location');
dd($location);
        return view('home.authorization.qianku')->with('localhost',array_get($location,0));
    }




}
