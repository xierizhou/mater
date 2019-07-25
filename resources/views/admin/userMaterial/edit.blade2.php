@extends('admin.app')
@section('title', '修改素材网站')
@section('content')
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form" method="POST" action="{{ url('admin/userMaterial') }}/{{ $data->id }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>用户名</label>
                        <div class="layui-input-inline">
                            <input type="text" value="{{ $data->username }}" name="username" required="" lay-verify="required" autocomplete="off" class="layui-input"></div>
                    </div>
                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">手机号</label>
                        <div class="layui-input-inline">
                            <input type="text" value="{{ $data->mobile }}" name="mobile" autocomplete="off" class="layui-input"></div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">邮箱</label>
                        <div class="layui-input-inline">
                            <input type="text" value="{{ $data->email }}" name="email"  autocomplete="off" class="layui-input"></div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">密码</label>
                        <div class="layui-input-inline">
                            <input type="text" value="" name="password" placeholder="如果填则修改密码，不填则不修改" autocomplete="off" class="layui-input"></div>
                    </div>


                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>状态</label>
                        <div class="layui-input-inline">
                            <select name="status" >
                                <option {{ $data->status == 1?"selected":"" }} value="1">正常</option>
                                <option {{ $data->status?"":"selected" }} value="0">停用</option>
                            </select>
                        </div>
                    </div>


                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label"></label>
                        <button class="layui-btn" lay-filter="edit" lay-submit="">修改</button>
                    </div>
                </form>
            </div>
        </div>
        <script>layui.use(['form', 'layer'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;



                //自定义验证规则
                form.verify({
                    nikename: function(value) {
                        if (value.length < 5) {
                            return '昵称至少得5个字符啊';
                        }
                    },
                    pass: [/(.+){6,12}$/, '密码必须6到12位'],
                    repass: function(value) {
                        if ($('#L_pass').val() != $('#L_repass').val()) {
                            return '两次密码不一致';
                        }
                    }
                });

                //监听提交
                form.on('submit(edit)', function(data) {


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