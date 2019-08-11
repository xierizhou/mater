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
     * 显示下载页面
     *
     * @param MaterialFile $materialFile
     * @return
     **/
    public function showDownload(MaterialFile $materialFile){

        return view('home.download')->with('data',$materialFile);
    }



}
