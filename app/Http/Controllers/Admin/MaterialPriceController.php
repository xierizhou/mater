<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MaterialPriceStoreRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MaterialPrice;
use App\Models\Material;
class MaterialPriceController extends Controller
{
    private $materialPrice;

    public function __construct(MaterialPrice $materialPrice)
    {
        $this->materialPrice = $materialPrice;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->has('material_id') && $request->input('material_id')){

            $this->materialPrice = $this->materialPrice->where("material_id",$request->input('material_id'));
        }


        $data = $this->materialPrice->paginate(10);

        return view('admin.materialPrice.index')->with('data',$data)->with('material',Material::get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.materialPrice.add")->with('material',Material::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MaterialPriceStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MaterialPriceStoreRequest $request)
    {
        $insert = $request->except(['_token']);
        if($this->materialPrice->create($insert)){
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
        $data = $this->materialPrice->find($id);
        return view('admin.materialPrice.edit')->with('data',$data)->with('material',Material::get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MaterialPriceStoreRequest $request, $id)
    {
        $update = $request->except(['_token','_method']);
        if($this->materialPrice->where('id',$id)->update($update)){
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
        if($this->materialPrice->find($id)->delete()){
            return response()->json(['status_code'=>204,'message'=>'删除成功']);
        }else{
            return response()->json(['status_code'=>400,'message'=>'删除失败'],400);
        }
    }
}
