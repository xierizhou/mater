<?php

namespace App\Http\Controllers\Home;


use App\Models\Material;
use App\Models\MaterialFile;
use App\Models\ReplaceDownload;
use App\Services\MaterialUrlAnalysisService;
use App\Services\ObtainPageService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Replace;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
class ReplaceController extends Controller
{
    private $replace;

    private $material;

    public function __construct(Request $request,Replace $replace)
    {

        if(!$request->has('sign') || !$request->input('sign')){
            echo "<h1>本页面出现错误~</h1>";exit;
        }

        $this->replace = $replace->where('sign',$request->input('sign'))->first();
        if(!$this->replace){
            echo "<h1>本页面出现错误~</h1>";exit;
        }


    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){



        $to = '384860859@qq.com';
        $subject = '测试一封邮件';
        Mail::send(
            'emails.replace',
            ['data' => MaterialFile::find(1)],
            function ($message) use($to, $subject) {
                $message->to($to)->subject($subject);
            }
        );

        $material = Material::orderBy('state','desc')->get();
        return view('home.replace.index')
            ->with('material',$material)->with('replace',$this->replace);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function build(Request $request){

        try{
            $attachments = $this->check($request);
            $html = response($this->showDownload($request->url,array_get($attachments,'title'),$this->material))->getContent();
            return response()->json(['status_code'=>200,'message'=>'解析成功','data'=>$html]);

        }catch (\Exception $exception){
            return response()->json(['status_code'=>400,'message'=>$exception->getMessage()],400);
        }


        /*try{

            $material = MaterialUrlAnalysisService::getBuildMaterial($request->url);
            if(!$material){
                throw new \Exception('素材未找到');
            }
            if(!$material->state){
                throw new \Exception($material->name."将会在".$material->state_cause."哦~");
            }


            $channel = Channel::find(3);

            $materialFile = ChannelService::getInstance($channel)->download($request->url);

            if($materialFile){

                $html = response($this->showDownload($materialFile))->getContent();

                $this->replace->decrement("number");
                return response()->json(['status_code'=>200,'is_decrease'=>$materialFile->is_decrease,'message'=>'解析成功','data'=>$html]);
            }
            throw new \Exception("素材解析错误~");

        }catch (\Exception $exception){

            return response()->json(['status_code'=>400,'message'=>$exception->getMessage()],400);
        }*/
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(Request $request){

        DB::beginTransaction();
        try{
            $attachments = $this->check($request);

            $res = ReplaceDownload::create([
                'replace_id'=>$this->replace->id,
                'material_id'=>$this->material->id,
                'pic_no'=>MaterialUrlAnalysisService::parseUrlItemNo($request->url),
                'download_url'=>$request->url,
                'title'=>array_get($attachments,'title'),
            ]);
            $res1 = $this->replace->decrement("number");

            if($res && $res1){
                DB::commit();
                $email = $this->replace->email;
                $message = "<span style='font-size:12px'>提交成功~<br/>系统将会在5分钟内把素材发至<span style='color:blue'>$email</span>邮箱，请注意查收，如有疑问请联系客服~<br/><span style='color:red'>(该邮件由系统自动发出,有可能会在邮件垃圾箱中)</span></span>";
                return response()->json(['status_code'=>200,'message'=>$message,'data'=>['number'=>$this->replace->number]]);
            }
            throw new \Exception("保存失败，请重试或者联系客服");

        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json(['status_code'=>400,'message'=>$exception->getMessage()],400);
        }

    }

    /**
     * @param Request $request
     * @return array|mixed
     * @throws \Exception
     */
    private function check(Request $request){

        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
        ],[
            'url.required'=>'请先填写素材链接后再提交',
            'url.url'=>'请输入有效的素材链接'
        ]);
        if($validator->fails()){
            throw new \Exception($validator->messages()->first());
        }
        $material = MaterialUrlAnalysisService::getBuildMaterial($request->url);
        if(!$material){
            throw new \Exception('暂不支持该网站');
        }
        if(!$material->state){
            throw new \Exception($material->name."将会在".$material->state_cause."哦~");
        }

        $this->material = $material;

        $Obtain = new ObtainPageService();
        $obtain_config = config('obtain.58pic');
        $attachments = $Obtain->build(new $obtain_config,$request->url);
        if(!array_get($attachments,'title')){
            throw new \Exception('素材未找到');
        }
        return $attachments;
    }

    /**
     * 显示下载页面
     *
     * @param MaterialFile $materialFile
     * @return
     **/
    public function showDownload($url , $title , Material $material){
        $data = [
            'url'=>$url,
            'title'=>$title,
        ];
        $pic_no = MaterialUrlAnalysisService::parseUrlItemNo($url);
        $replace_download = ReplaceDownload::where('replace_id',$this->replace->id)->where('material_id',$this->material->id)->where('pic_no',$pic_no)->first();
        return view('home.replace.download')->with('data',$data)->with('material',$material)->with('is_download',$replace_download?1:0);
    }
}
