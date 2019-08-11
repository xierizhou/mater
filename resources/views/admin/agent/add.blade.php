@extends('admin.app')
@section('title', '添加代理商')
@section('content')
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form" method="POST" action="{{ url('admin/agent') }}">
                    {{ csrf_field() }}
                    <div class="layui-form-item">
                        <label class="layui-form-label">
                            <span class="x-red">*</span>代理等级</label>
                        <div class="layui-input-inline">
                            <select name="grade_id" lay-filter="grade_id">
                                @foreach($grade as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>登录名</label>
                        <div class="layui-input-inline">
                            <input type="text"  name="username" required="" lay-verify="required" autocomplete="off" class="layui-input"></div>
                    </div>
                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>登录密码</label>
                        <div class="layui-input-inline">
                            <input type="text"  name="password" required="" lay-verify="required" autocomplete="off" class="layui-input"></div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            手机</label>
                        <div class="layui-input-inline">
                            <input type="text"  name="mobile" required="" lay-verify="required" autocomplete="off" class="layui-input"></div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            邮箱</label>
                        <div class="layui-input-inline">
                            <input type="text"  name="email" required="" lay-verify="required" autocomplete="off" class="layui-input"></div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                           主域名</label>
                        <div class="layui-input-inline">
                            <input type="text" placeholder="若无，留空" name="domain" required="" lay-verify="required" autocomplete="off" class="layui-input"></div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label"><span class="x-red">*</span>子域前缀</label>
                        <div class="layui-input-inline">
                            <input type="text"  name="sub_domain" required="" lay-verify="required" autocomplete="off" class="layui-input"></div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>状态</label>
                        <div class="layui-input-inline">
                            <select name="status" lay-filter="state">
                                <option value="1">正常</option>
                                <option value="0">冻结</option>
                            </select>
                        </div>
                    </div>


                    <div class="layui-form-item layui-form-text">
                        <label for="desc" class="layui-form-label">备注</label>
                        <div class="layui-input-block">
                            <textarea placeholder="" id="desc" name="remarks" class="layui-textarea"></textarea>
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