<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grade;
use App\Models\MaterialFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Http\Requests\StoreChannelRequest;
use App\Services\AliOssService;
class ChannelController extends Controller
{
    private $channel;

    private $grade;

    public function __construct(Channel $channel,Grade $grade)
    {
        $this->channel = $channel;
        $this->grade = $grade;
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

            $this->channel = $this->channel->where("name",'like',"%{$request->input('name')}%");
        }

        if($request->has('state') && $request->input('state')){

            $this->channel = $this->channel->where("state",$request->input('state'));
        }


        $data = $this->channel->paginate(10);
        return view('admin.channel.index')->withData($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.channel.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreChannelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChannelRequest $request)
    {

        $insert = $request->except(['_token']);
        if($this->channel->create($insert)){
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
        $data = $this->channel->find($id);
        return view('admin.channel.edit')->withData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreChannelRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreChannelRequest $request, $id)
    {
        $update = $request->except(['_token','_method']);
        if($this->channel->where('id',$id)->update($update)){
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
        if($this->channel->find($id)->delete()){
            return response()->json(['status_code'=>204,'message'=>'删除成功']);
        }else{
            return response()->json(['status_code'=>400,'message'=>'删除失败'],400);
        }
    }
}
