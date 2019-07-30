<?php

namespace App\Http\Controllers\Home;

use App\Models\Channel;
use App\Models\UserMaterial;
use App\Services\Adapters\ObtainPages\QianTuWangObtainPageAdapter;
use App\Services\ChannelService;
use App\Services\MaterialDownloadUploadOssService;
use App\Services\ObtainPageService;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Services\MaterialUrlAnalysisService;
use App\Services\MaterialDownloadService;
use App\Models\MaterialFile;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cookie;
class IndexController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function show(){
        //MaterialFile::find(100);
        //$this->downVarify(MaterialFile::find(100));


        $material = Material::orderBy('state','desc')->get();

        $userMaterial = UserMaterial::where('user_id',auth()->user()->id)->where('status',1)->get()->keyBy('material_id');
        return view('home.index')
            ->with('material',$material)
            ->with('userMaterial',$userMaterial);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function build(Request $request){

        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
        ],[
            'url.required'=>'请先填写素材链接后再提交',
            'url.url'=>'请输入有效的素材链接'
        ]);
        if($validator->fails()){
            return response()->json(['status_code'=>400,'message'=>$validator->messages()->first()],400);
        }
        try{

            $material = MaterialUrlAnalysisService::getBuildMaterial($request->url);
            if(!$material){
                throw new \Exception('素材未找到');
            }
            if(!$material->state){
                throw new \Exception($material->name.$material->state_cause);
            }

            $channel = Channel::find(4);
            $materialFile = ChannelService::getInstance($channel)->download($request->url);

            if($materialFile){
                $html = response($this->showDownload($materialFile))->getContent();
                return response()->json(['status_code'=>200,'is_decrease'=>$materialFile->is_decrease,'message'=>'解析成功','data'=>$html]);

            }
            throw new \Exception("素材解析错误~");

        }catch (\Exception $exception){

            return response()->json(['status_code'=>400,'message'=>$exception->getMessage()],400);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function downVarify(Request $request){
        $item_no = MaterialUrlAnalysisService::parseUrlItemNo($request->url);
        $url = 'https://ibaotu.com/index.php?m=downVarify&a=index&id='.$item_no;
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
                //Cookie::queue(array_get($cookie,0), array_get($cookie,1));
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
        return view('home.ibaotu_varify')->with('key',$key)->with('value',$value)->with('item_no',$item_no)->with('ver',$verCookie);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function varify(Request $request){
        $url = "https://ajax.ibaotu.com/?m=AjaxDownload&a=verifyCaptcha&answer_key={$request->answer_key}&callback=".$request->item_no;
        $channel = Channel::find(4);


        $client = new Client();
        $response = $client->request('GET',$url,[
            'headers'=>[
                'Cookie'=>'answer_key='.$request->ver_id.';'.$channel->cookie,
            ],
        ]);
        $response = json_decode($response->getBody()->getContents(),true);
        return response()->json($response);
    }


    /**
     * 显示下载页面
     *
     * @param MaterialFile $materialFile
     * @return
     **/
    public function showDownload(MaterialFile $materialFile){

        $is_yz = '0';
        foreach($materialFile->attachments as $item){
            $res = parse_url($item->source);
            $path = explode('.',$res['path']);
            if(array_get($path,'1') != 'zip'){
                $is_yz = '1';
                break;
            }
        }


        return view('home.download')->with('data',$materialFile)->with('is_yz',$is_yz);
    }



}
