<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserMaterial;
use App\Models\User;
use App\Models\Material;
use Validator;
class UserMaterialController extends Controller
{
    private $userMaterial;

    private $user;

    public function __construct(UserMaterial $userMaterial,User $user)
    {
        $this->userMaterial = $userMaterial;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->has('user_id') && $request->input('user_id')){

            $this->userMaterial = $this->userMaterial->where("user_id",$request->input('user_id'));
        }

        $userMaterial = $this->userMaterial->paginate(15);
        $user = $this->user->get();
        return view('admin.userMaterial.index')->with('data',$userMaterial)->with('user',$user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user = $this->user->where('status',1)->get();
        $material = Material::get();

        return view('admin.userMaterial.add')->with('user',$user)->with('material',$material);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'material_id' => 'required',
            'current'=>'required',
            'total'=>'required',
            'is_daily_reset'=>'required',
            'start_time'=>'required|date',
            'end_time'=>'required|date',
        ],[
            'start_time.date'=>'开始时间日期格式有误',
            'end_time.date'=>'结束时间日期格式有误',
        ]);

        if($validator->fails()){
            return response()->json(['status_code'=>400,'message'=>$validator->errors()->first()],400);
        }

        if($userMaterial = $this->userMaterial->where('user_id',$request->user_id)->where('material_id',$request->material_id)->first()){
            return response()->json(['status_code'=>400,'message'=>"该用户已添加".$userMaterial->material->name."的权限"],400);
        }

        $insert = $request->except(['_token']);
        $insert['start_time'] = strtotime($insert['start_time']);
        $insert['end_time'] = strtotime($insert['end_time']);

        if($this->userMaterial->create($insert)){
            return response()->json(['status_code'=>200,'message'=>'添加成功']);
        }else{
            return response()->json(['status_code'=>400,'message'=>'添加失败'],400);
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

        $user = $this->user->where('status',1)->get();
        $material = Material::get();
        $userMaterial = $this->userMaterial->find($id);
        return view('admin.userMaterial.edit')->with('user',$user)->with('material',$material)->with('userMaterial',$userMaterial);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'material_id' => 'required',
            'current'=>'required',
            'total'=>'required',
            'is_daily_reset'=>'required',
            'start_time'=>'required|date',
            'end_time'=>'required|date',
        ],[
            'start_time.date'=>'开始时间日期格式有误',
            'end_time.date'=>'结束时间日期格式有误',
        ]);

        $userMaterial = $this->userMaterial->find($id);


        if(!$userMaterial){
            return response()->json(['status_code'=>400,'message'=>"系统错误"],400);
        }

        if($validator->fails()){
            return response()->json(['status_code'=>400,'message'=>$validator->errors()->first()],400);
        }

        if($userMaterialIs = $this->userMaterial->where('user_id',$request->user_id)->where('material_id',$request->material_id)->where('material_id','<>',$userMaterial->material_id)->first()){
            return response()->json(['status_code'=>400,'message'=>"该用户已添加".$userMaterialIs->material->name."的权限"],400);
        }
        $update = $request->except(['_token','_method','user_id']);

        $update['start_time'] = strtotime($update['start_time']);
        $update['end_time'] = strtotime($update['end_time']);

        if($this->userMaterial->where('id',$userMaterial->id)->update($update)){
            return response()->json(['status_code'=>200,'message'=>'修改成功']);
        }else{
            return response()->json(['status_code'=>400,'message'=>'修改失败'],400);
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
        if($this->userMaterial->find($id)->delete()){
            return response()->json(['status_code'=>204,'message'=>'删除成功']);
        }else{
            return response()->json(['status_code'=>400,'message'=>'删除失败'],400);
        }
    }
}
