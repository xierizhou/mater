@extends('admin.app')
@section('title', '编辑渠道账号')
@section('content')
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form" method="POST" action="{{ url('admin/channel_account') }}/{{ $data->id }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="layui-form-item">
                        <label for="channel_id" class="layui-form-label">
                            下载渠道</label>
                        <div class="layui-input-inline">
                            <select name="channel_id" >
                                @foreach($channel as $item)
                                <option {{ $data->channel_id == $item->id?"selected":"" }} value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            登录账号</label>
                        <div class="layui-input-inline">
                            <input type="text" value="{{ $data->username }}" name="username" required="" lay-verify="required" autocomplete="off" class="layui-input"></div>
                    </div>
                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            登录密码</label>
                        <div class="layui-input-inline">
                            <input type="text" value="{{ $data->password }}" name="password" required="" lay-verify="required" autocomplete="off" class="layui-input"></div>
                    </div>
                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            其他方式登录</label>
                        <div class="layui-input-inline">
                            <input type="text" value="{{ $data->extra }}" name="extra" required="" lay-verify="required" autocomplete="off" class="layui-input"></div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            状态</label>
                        <div class="layui-input-inline">
                            <select name="status" lay-filter="state">
                                <option {{ $data->status?"selected":"" }} value="1">正常</option>
                                <option {{ $data->status?"":"selected" }} value="0">停用</option>
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
                                    <td><input type="checkbox" {{ array_has($auth,$item->id)?"checked":"" }} name="material_ids[]" value="{{ $item->id }}" lay-skin="primary" ></td>
                                    <td>{{ $item->name }}</td>
                                    <td><input type="text" value="{{ array_has($auth,$item->id)?array_get($auth,$item->id.'.total'):"" }}" name="auth[{{ $item->id }}][total]" autocomplete="off" class="layui-input"></td>
                                    <td><input type="text" value="{{ array_has($auth,$item->id)?array_get($auth,$item->id.'.reset_number'):"0" }}" name="auth[{{ $item->id }}][reset_number]" autocomplete="off" value="0" class="layui-input"></td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
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