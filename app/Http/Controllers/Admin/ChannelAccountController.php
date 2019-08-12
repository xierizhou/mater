<?php

namespace App\Http\Controllers\Admin;

use App\Models\Channel;
use App\Models\ChannelAccountAuth;
use App\Models\Material;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ChannelAccount;
use Illuminate\Support\Facades\DB;
class ChannelAccountController extends Controller
{
    private $channel_account;
    public function __construct(ChannelAccount $channel_account)
    {
        $this->channel_account = $channel_account;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('channel_id') && $request->input('channel_id')){

            $this->channel_account = $this->channel_account->where("channel_id",$request->input('channel_id'));
        }
        return view('admin.channelAccount.index')->with('data',$this->channel_account->get());
    }

    /**
     * @return $this
     */
    public function create()
    {
        $material = Material::get();

        $channel = Channel::get();


        return view('admin.channelAccount.add')->with('material',$material)->with('channel',$channel);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(Request $request)
    {

        try{
            DB::transaction(function () use ($request) {
                $account = $this->channel_account->create([
                    'channel_id' => $request->channel_id,
                    'username' => $request->username,
                    'password' => $request->password,
                    'extra' => $request->extra,
                    'status' => $request->status,
                ]);
                foreach ($request->material_ids as $v) {
                    ChannelAccountAuth::create([
                        'channel_account_id' => $account->id,
                        'material_id' => $v,
                        'total' => array_get($request->auth, $v . '.total'),
                        'current' => array_get($request->auth, $v . '.total'),
                        'is_daily_reset' => array_get($request->auth, $v . '.reset_number'),
                        'reset_number' => array_get($request->auth, $v . '.reset_number'),
                    ]);
                }
            });
        }catch (MassAssignmentException $exception){
            return response()->json(['status_code'=>400,'message'=>'添加失败，请联系管理员'],400);
        }catch (\Exception $exception){

            return response()->json(['status_code'=>400,'message'=>'添加失败'],400);
        }
        return response()->json(['status_code'=>200,'message'=>'添加成功']);

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

        $material = Material::get();
        $channel = Channel::get();
        $channel_account = $this->channel_account->find($id);

        $auth = [];
        foreach($channel_account->auth as $item){
            $auth[$item['material_id']] = $item;
        }


        return view('admin.channelAccount.edit')->with('auth',$auth)->with('material',$material)->with('channel',$channel)->with('data',$channel_account);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(Request $request, $id)
    {

        try{
            DB::transaction(function () use ($request,$id) {
                $this->channel_account->find($id)->update([
                    'channel_id' => $request->channel_id,
                    'username' => $request->username,
                    'password' => $request->password,
                    'extra' => $request->extra,
                    'status' => $request->status,
                ]);
                ChannelAccountAuth::where('channel_account_id',$id)->delete();
                foreach ($request->material_ids as $v) {
                    ChannelAccountAuth::create([
                        'channel_account_id' => $id,
                        'material_id' => $v,
                        'total' => array_get($request->auth, $v . '.total'),
                        'current' => array_get($request->auth, $v . '.total'),
                        'is_daily_reset' => array_get($request->auth, $v . '.reset_number'),
                        'reset_number' => array_get($request->auth, $v . '.reset_number'),
                    ]);
                }
            });
        }catch (MassAssignmentException $exception){
            return response()->json(['status_code'=>400,'message'=>'修改失败，请联系管理员'],400);
        }catch (\Exception $exception){
            return response()->json(['status_code'=>400,'message'=>'修改失败'],400);
        }
        return response()->json(['status_code'=>200,'message'=>'修改成功']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->channel_account->find($id)->delete()){
            return response()->json(['status_code'=>204,'message'=>'删除成功']);
        }else{
            return response()->json(['status_code'=>400,'message'=>'删除失败'],400);
        }
    }
}
