@extends('admin.app')
@section('title', '修改素材网站')
@section('content')
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form" method="POST" action="{{ url('admin/agent') }}/{{ $data->id }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="layui-form-item">
                        <label class="layui-form-label">
                            <span class="x-red">*</span>代理等级</label>
                        <div class="layui-input-inline">
                            <select name="grade_id" lay-filter="grade_id">
                                @foreach($grade as $item)
                                <option {{ $item->id == $data->grade_id ? "selected":"" }} value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>登录名</label>
                        <div class="layui-input-inline">
                            <input type="text" value="{{ $data->username }}"  name="username" required="" lay-verify="required" autocomplete="off" class="layui-input"></div>
                    </div>
                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>登录密码</label>
                        <div class="layui-input-inline">
                            <input type="text" placeholder="若为空则不修改密码"  name="password" autocomplete="off" class="layui-input"></div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            手机</label>
                        <div class="layui-input-inline">
                            <input type="text" value="{{ $data->mobile }}" name="mobile" required="" lay-verify="required" autocomplete="off" class="layui-input"></div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            邮箱</label>
                        <div class="layui-input-inline">
                            <input type="text" value="{{ $data->email }}"  name="email" required="" lay-verify="required" autocomplete="off" class="layui-input"></div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            主域名</label>
                        <div class="layui-input-inline">
                            <input type="text" value="{{ $data->domain }}" placeholder="若无，留空" name="domain" required="" lay-verify="required" autocomplete="off" class="layui-input"></div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label"><span class="x-red">*</span>子域前缀</label>
                        <div class="layui-input-inline">
                            <input type="text" value="{{ $data->sub_domain }}" name="sub_domain" required="" lay-verify="required" autocomplete="off" class="layui-input"></div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>状态</label>
                        <div class="layui-input-inline">
                            <select name="status" lay-filter="state">
                                <option {{ $data->status ? "selected":"" }} value="1">正常</option>
                                <option {{ $data->status ? "":"selected" }} value="0">冻结</option>
                            </select>
                        </div>
                    </div>


                    <div class="layui-form-item layui-form-text">
                        <label for="desc" class="layui-form-label">备注</label>
                        <div class="layui-input-block">
                            <textarea id="desc" name="remarks" class="layui-textarea"> {{ $data->remarks }}</textarea>
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