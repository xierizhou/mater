@extends('admin.app')
@section('title', '添加单网价格')
@section('content')
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form" method="POST" action="{{ url('admin/material_price') }}">
                    {{ csrf_field() }}
                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>素材网站</label>
                        <div class="layui-input-inline">
                            <select name="material_id" >
                                @foreach($material as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>销售名称</label>
                        <div class="layui-input-inline">
                            <input type="text"  name="name" required="" lay-verify="required" placeholder="如：千图网(15天)" autocomplete="off" class="layui-input"></div>
                    </div>
                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>价格(￥)</label>
                        <div class="layui-input-inline">
                            <input type="text"  name="price" required="" lay-verify="required" autocomplete="off" placeholder="请填写价格" class="layui-input"></div>
                    </div>
                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>售出周期(天)</label>
                        <div class="layui-input-inline">
                            <input type="text"  name="cycle" required="" lay-verify="required" autocomplete="off" placeholder="填0表示永久" class="layui-input"></div>
                    </div>



                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>状态</label>
                        <div class="layui-input-inline">
                            <select name="status" lay-filter="state">
                                <option value="1">正常</option>
                                <option value="0">下架</option>
                            </select>
                        </div>
                    </div>


                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label"></label>
                        <button class="layui-btn" lay-filter="add" lay-submit="">增加</button>
                    </div>
                </form>
            </div>
        </div>
        <script>layui.use(['form', 'layer'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;




                //监听提交
                form.on('submit(add)', function(data) {


                    $.ajax({
                        url:data.form.action,
                        method:'post',
                        data:data.field,
                        dataType:'json',
                        success:function(data){
                            parent.layer.msg(data.message,{icon:6});
                            // 获得frame索引
                            var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                            parent.layer.close(index);
                            parent.location.reload();
                        },
                        error:function (data) {
                            if(data.status == 422){
                                layer.msg(data.responseJSON.message,{icon:5});
                            }else{
                                layer.msg(data.responseJSON.message,{icon:5});
                            }

                        }
                    })



                    //发异步，把数据提交给php
                    /*layer.alert("增加成功", {
                        icon: 6
                    },
                    function() {
                        // 获得frame索引
                        var index = parent.layer.getFrameIndex(window.name);
                        //关闭当前frame
                        parent.layer.close(index);
                    });*/
                    return false;
                });

            });
        </script>

    </body>

    @endsection