<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UserStoreRequest;
class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('username') && $request->input('username')){

            $this->user = $this->user->where("username",'like',"%{$request->input('username')}%");
        }

        if($request->has('state') && $request->input('state')){

            $this->user = $this->user->where("state",$request->input('state'));
        }

        $user = $this->user->paginate(15);

        return view('admin.user.index')->with('data',$user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.user.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $request->password = bcrypt($request->password);
        $insert = $request->except(['_token']);
        if($this->user->create($insert)){
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
        $user = $this->user->find($id);
        return view("admin.user.edit")->with('data',$user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserStoreRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserStoreRequest $request, $id)
    {
        $except = ['_token','_method'];
        if(!$request->password){
            $except[] = 'password';
        }
        $update = $request->except(['_token','_method']);
        if(array_has($update,'password')){
            $update['password'] = bcrypt(array_get($update,'password'));
        }

        if($this->user->where('id',$id)->update($update)){
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
        if($this->user->find($id)->delete()){
            return response()->json(['status_code'=>204,'message'=>'删除成功']);
        }else{
            return response()->json(['status_code'=>400,'message'=>'删除失败'],400);
        }
    }
}
