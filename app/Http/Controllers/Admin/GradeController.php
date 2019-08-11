<?php

namespace App\Http\Controllers\Admin;

use App\Models\Agent;
use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GradeController extends Controller
{
    private $grade;

    public function __construct(Grade $grade){
        $this->grade = $grade;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('name') && $request->input('name')){

            $this->grade = $this->grade->where("name",'like',"%{$request->input('name')}%");
        }

        $data = $this->grade->paginate(10);

        return view('admin.grade.index')->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.grade.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except(['_token']);

        if($this->grade->create($data)){
            return response()->json(['status_code'=>200,'message'=>'添加成功']);
        }else{
            return response()->json(['status_code'=>400,'message'=>'添加成功'],400);
        }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        return view('admin.grade.edit')->withData(
            $this->grade->find($id)
        );
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
        $update = $request->except(['_token','_method']);
        if($this->grade->where('id',$id)->update($update)){
            return response()->json(['status_code'=>200,'message'=>'修改成功']);
        }else{
            return response()->json(['status_code'=>400,'message'=>'修改成功'],400);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $count = Agent::where('grade_id',$id)->count();
        if($count){
            return response()->json(['status_code'=>400,'message'=>'删除失败：请先把代理商更换等级'],400);
        }
        if($this->grade->find($id)->delete()){

            return response()->json(['status_code'=>204,'message'=>'删除成功']);
        }else{
            return response()->json(['status_code'=>400,'message'=>'删除失败:系统错误，请联系管理员'],400);
        }

    }
}
