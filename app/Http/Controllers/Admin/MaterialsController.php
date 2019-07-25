<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Http\Requests\StoreMaterialsRequest;
use App\Models\Channel;
use App\Models\MaterialChannel;
use App\Services\MaterialUrlAnalysisService;
class MaterialsController extends Controller
{
    private $material;

    public function __construct(Material $material)
    {
        $this->material = $material;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('name') && $request->input('name')){

            $this->material = $this->material->where("name",'like',"%{$request->input('name')}%");
        }
        $data = $this->material->paginate(10);


        return view('admin.materials.index')->withData($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $channel = Channel::where('state',1)->get();
        return view("admin.materials.add")->with('channel',$channel);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreMaterialsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMaterialsRequest $request)
    {

        $channel = $request->channel;

        $insert = $request->except(['_token'.'channel']);

        $insert['site'] = MaterialUrlAnalysisService::getBaseDomain(array_get($insert,'domain'))->site;

        $material = $this->material->create($insert);

        if($channel){
            $channel_insert = [];
            foreach($channel as $item){
                $channel_insert[] = [
                    'material_id'=>$material->id,
                    'channel_id'=>$item,
                ];
            }
            MaterialChannel::insert($channel_insert);
        }

        if($material->id) {
            return response()->json(['status_code'=>200,'message'=>'添加成功']);
        }else{
            return response()->json(['status_code'=>400,'message'=>'添加成功'],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->material->find($id);
        $channel_channel = MaterialChannel::where("material_id",$id)->pluck('channel_id');

        $channel = Channel::where('state',1)->get();
        return view('admin.materials.edit')->withData($data)->with('channel',$channel)->with('channel_channel',$channel_channel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreMaterialsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreMaterialsRequest $request, $id)
    {

        $channel = $request->channel;
        $update = $request->except(['_token','_method','channel']);
        $update['site'] = MaterialUrlAnalysisService::getBaseDomain(array_get($update,'domain'))->site;
        if($channel){
            MaterialChannel::where('material_id',$id)->delete();

            $channel_insert = [];
            foreach($channel as $item){
                $channel_insert[] = [
                    'material_id'=>$id,
                    'channel_id'=>$item,
                ];
            }
            MaterialChannel::insert($channel_insert);

        }


        if($this->material->where('id',$id)->update($update)){
            return response()->json(['status_code'=>200,'message'=>'修改成功']);
        }else{
            return response()->json(['status_code'=>400,'message'=>'修改成功'],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->material->find($id)->delete()){
            return response()->json(['status_code'=>204,'message'=>'删除成功']);
        }else{
            return response()->json(['status_code'=>400,'message'=>'删除失败'],400);
        }
    }
}
