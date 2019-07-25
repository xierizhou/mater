@extends('admin.app')
@section('title', '修改素材网站')
@section('content')
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form" method="POST" action="{{ url('admin/materials') }}/{{ $data->id }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>名称</label>
                        <div class="layui-input-inline">
                            <input type="text" value="{{ $data->name }}" name="name" required="" lay-verify="required" autocomplete="off" class="layui-input"></div>
                    </div>
                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>URL</label>
                        <div class="layui-input-inline">
                            <input type="text" value="{{ $data->domain }}" name="domain" required="" lay-verify="required" autocomplete="off" class="layui-input"></div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>下载渠道</label>
                        <div class="layui-input-block">
                            @foreach($channel as $item)
                                <input type="checkbox" {{ in_array($item->id,$channel_channel->toArray())?"checked":"" }} name="channel[]" value="{{ $item->id }}" lay-skin="primary" title="{{ $item->name }}" >
                            @endforeach
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>状态</label>
                        <div class="layui-input-inline">
                            <select name="state" lay-filter="state">
                                <option {{ $data->state?"selected":"" }} value="1">正常</option>
                                <option {{ $data->state?"":"selected" }} value="0">停用</option>
                            </select>
                        </div>
                    </div>


                    <div class="layui-form-item layui-form-text" id="state_cause" style="{{ $data->state?"display: none":"" }}">
                        <label for="desc" class="layui-form-label"><span class="x-red">*</span>停用原因</label>
                        <div class="layui-input-block">
                            <textarea placeholder="请输入停用内容，停用原因将会用于提示给用户" {{ $data->state?"":"lay-verify='required'" }} name="state_cause" class="layui-textarea">{{ $data->state_cause }}</textarea>
                        </div>
                    </div>

                    <div class="layui-form-item layui-form-text">
                        <label for="desc" class="layui-form-label">{{--<span class="x-red">*</span>--}}下载说明</label>
                        <div class="layui-input-block">
                            <textarea placeholder="下载说明，将会提示给用户，如：支持全站下载" id="desc" name="instructions" class="layui-textarea">{{ $data->instructions }}</textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label"></label>
                        <button class="layui-btn" lay-filter="add" lay-submit="">修改</button>
                    </div>
                </form>
            </div>
        </div>
        <script>layui.use(['form', 'layer'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;

                form.on("select(state)", function(data){
                    if(data.value == 0){
                        $("#state_cause").show();
                        $("textarea[name='state_cause']").attr('lay-verify','required');
                    }else{
                        $("#state_cause").hide();
                        $("textarea[name='state_cause']").removeAttr('lay-verify');
                    }
                });

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