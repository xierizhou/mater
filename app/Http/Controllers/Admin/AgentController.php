<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Agent;
class AgentController extends Controller
{
    private $agent;

    public function __construct(Agent $agent){
        $this->agent = $agent;
    }


    public function index(Request $request)
    {
        if($request->has('name') && $request->input('name')){

            $this->agent = $this->agent->where("name",'like',"%{$request->input('name')}%");
        }

        if($request->has('state') && $request->input('state')){

            $this->agent = $this->agent->where("state",$request->input('state'));
        }


        $data = $this->agent->paginate(10);


        return view('admin.agent.index')->with('data',$data);
    }


    public function create()
    {
        $grade = Grade::get();
        return view('admin.agent.add')->with('grade',$grade);
    }


    public function store(Request $request)
    {
        $data = $request->except(['_token']);
        $data['password'] = bcrypt(array_get($data,'password'));

        if($this->agent->create($data)){
            return response()->json(['status_code'=>200,'message'=>'添加成功']);
        }else{
            return response()->json(['status_code'=>400,'message'=>'添加成功'],400);
        }
    }



    public function edit($id)
    {
        $agent = $this->agent->find($id);
        $grade = Grade::get();
        return view('admin.agent.edit')->with('data',$agent)->with('grade',$grade);
    }


    public function update(Request $request, $id)
    {

        $update = $request->except(['_token','_method']);
        if(array_get($update,'password')){
            $update['password'] = bcrypt(array_get($update,'password'));
        }else{
            unset($update['password']);
        }

        if($this->agent->where('id',$id)->update($update)){
            return response()->json(['status_code'=>200,'message'=>'修改成功']);
        }else{
            return response()->json(['status_code'=>400,'message'=>'修改成功'],400);
        }
    }


    public function destroy($id)
    {
        //
    }
}
