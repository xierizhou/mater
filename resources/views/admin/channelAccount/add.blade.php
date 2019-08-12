@extends('admin.app')
@section('title', '添加渠道账号')
@section('content')
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form" method="POST" action="{{ url('admin/channel_account') }}">
                    {{ csrf_field() }}

                    <div class="layui-form-item">
                        <label for="channel_id" class="layui-form-label">
                            下载渠道</label>
                        <div class="layui-input-inline">
                            <select name="channel_id" {{ request('channel_id')?'disabled':"" }}>
                                @foreach($channel as $item)
                                    <option {{ request('channel_id')==$item->id?"selected":"" }} value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                             @if(request('channel_id'))
                                <input type="hidden" value="{{ request('channel_id') }}" name="channel_id" >
                             @endif
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            登录账号</label>
                        <div class="layui-input-inline">
                            <input type="text"  name="username" required="" lay-verify="required" autocomplete="off" class="layui-input"></div>
                    </div>
                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            登录密码</label>
                        <div class="layui-input-inline">
                            <input type="text"  name="password" required="" lay-verify="required" autocomplete="off" class="layui-input"></div>
                    </div>
                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            其他方式登录</label>
                        <div class="layui-input-inline">
                            <input type="text"  name="extra" required="" lay-verify="required" autocomplete="off" class="layui-input"></div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            状态</label>
                        <div class="layui-input-inline">
                            <select name="status" lay-filter="state">
                                <option value="1">正常</option>
                                <option value="0">停用</option>
                            </select>
                        </div>
                    </div>


                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">下载权限</label>
                        <div class="layui-input-block">
                            <table class="layui-table">

                                <thead>
                                <tr>
                                    <th></th>
                                    <th>素材网</th>
                                    <th>总下载量</th>
                                    <th>每日重置量（0表示不重置）</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($material as $item)
                                <tr>
                                    <td><input type="checkbox" name="material_ids[]" value="{{ $item->id }}" lay-skin="primary" ></td>
                                    <td>{{ $item->name }}</td>
                                    <td><input type="text" name="auth[{{ $item->id }}][total]" autocomplete="off" class="layui-input"></td>
                                    <td><input type="text" name="auth[{{ $item->id }}][reset_number]" autocomplete="off" value="0" class="layui-input"></td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
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