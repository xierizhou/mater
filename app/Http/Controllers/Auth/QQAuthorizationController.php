<?php

namespace App\Http\Controllers\Auth;

use App\Models\AuthorizationCookie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cookie;
class QQAuthorizationController extends Controller
{

    private $pt_3rd_aid = 101252414;

    /**
     * 显示登录二维码
     **/
    public function showQR(){

        $appid = 716027609; //一般是固定

        $e = 2;  //这个是二维码白边

        $l = 'm';   //暂时不知道是什么

        $s = 3; // 这个是二维码的size

        $d = 72; //暂时不知道是什么

        $t = lcg_value(); //0~1之间的随机数

        $daid = 383;

        $pt_3rd_aid = $this->pt_3rd_aid; //这个是授权的id

        $url = "https://ssl.ptlogin2.qq.com/ptqrshow?appid=$appid&e=$e&l=$l&s=$s&d=$d&t=$t&daid=$daid&pr_3rd_aid=$pt_3rd_aid";

        $client = new Client();
        $qr_time = time();
        $response = $client->request('GET',$url,[
            'save_to'=>public_path('downloads').'/'.$qr_time.'.png',
        ]);
        $setCookie = $response->getHeader('Set-Cookie');
        $dataCookie = [];
        foreach($setCookie as $item){
            $cookie = explode('=',array_get(explode(';',$item),0));
            if(array_get($cookie,1)){
                Cookie::queue(array_get($cookie,0), array_get($cookie,1));
                $dataCookie[array_get($cookie,0)] = array_get($cookie,1);
            }
        }

        return view('auth.qq')->with('qr_url',url('downloads/'.$qr_time.'.png'))->with('data',$dataCookie);
    }

    public function checkSweepCode(Request $request){

        $url = "https://ssl.ptlogin2.qq.com/ptqrlogin?u1=https%3A%2F%2Fgraph.qq.com%2Foauth2.0%2Flogin_jump&ptqrtoken={$request->ptqrtoken}&ptredirect=0&h=1&t=1&g=1&from_ui=1&ptlang=2052&action={$request->action}&js_ver=19062020&js_type=1&login_sig=&pt_uistyle=40&aid=716027609&daid=383&pt_3rd_aid={$this->pt_3rd_aid}&";

        $client = new Client();
        $response = $client->request('GET',$url,[
            'headers'=>[
                'Cookie'=>'qrsig='.Cookie::get('qrsig'),
            ],
        ]);
        $setCookie = $response->getHeader('Set-Cookie');
        foreach($setCookie as $item){
            $cookie = explode('=',array_get(explode(';',$item),0));
            if(array_get($cookie,1)){
                Cookie::queue(array_get($cookie,0), array_get($cookie,1));
            }

        }

        $content = $response->getBody()->getContents();
        return response($content);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function loginSuccess(Request $request){
        $request_url = $request->url;

        $client = new Client();
        $response = $client->request('GET',$request_url,[
            'headers'=>[
                'Cookie'=>'ptcz='.Cookie::get('ptcz').';RK='.Cookie::get('RK'),
            ],
            'allow_redirects'=>false,
        ]);
        $setCookie = $response->getHeader('Set-Cookie');
        $dataCookie = [];

        //删除旧cookie，以免重复
        AuthorizationCookie::where('authorization_id',1)->where('uin','384860859')->delete();
        foreach($setCookie as $item){
            $cookie = explode('=',array_get(explode(';',$item),0));
            if(array_get($cookie,1)){
                Cookie::queue(array_get($cookie,0), array_get($cookie,1));
                $dataCookie[array_get($cookie,0)] = array_get($cookie,1);
                AuthorizationCookie::create([
                    'authorization_id'=>1,
                    'uin'=>'384860859',
                    'key'=>array_get($cookie,0),
                    'value'=>array_get($cookie,1),
                ]);
            }
        }


        return response()->json($dataCookie);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function gtk(Request $request){

        AuthorizationCookie::create([
            'authorization_id'=>1,
            'uin'=>'384860859',
            'key'=>'g_tk',
            'value'=>$request->g_tk,
        ]);
        return response('ok');
    }


}
