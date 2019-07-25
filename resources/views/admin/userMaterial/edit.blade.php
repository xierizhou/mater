@extends('admin.app')
@section('title', '修改用户权限')
@section('content')
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form" method="POST" action="{{ url('admin/user_material') }}/{{ $userMaterial->id }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>选择用户</label>
                        <div class="layui-input-inline">
                            <select name="user_id" >
                                @foreach($user as $item)
                                <option {{ $item->id == $userMaterial->user_id?"selected":"" }} disabled value="{{ $item->id }}">{{ $item->username }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>选择网站</label>
                        <div class="layui-input-inline">
                            <select name="material_id" lay-search>
                                @foreach($material as $item)
                                    <option  {{ $item->id == $userMaterial->material_id?"selected":"" }} value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>开始时间</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" value="{{ $userMaterial->start_time }}" name="start_time" id="start_time" placeholder="yyyy-MM-dd HH:mm:ss">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>结束时间</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" value="{{ date('Y-m-d H:i:s',$userMaterial->end_time) }}" name="end_time" id="end_time" placeholder="yyyy-MM-dd HH:mm:ss">
                        </div>
                    </div>


                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label"><span class="x-red">*</span>当前下载量</label>
                        <div class="layui-input-inline">
                            <input type="text"  name="current" value="{{ $userMaterial->current }}" required=""  autocomplete="off" class="layui-input"></div>
                    </div>
                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label"><span class="x-red">*</span>每日刷新量</label>
                        <div class="layui-input-inline">
                            <input type="text"  name="total" value="{{ $userMaterial->total }}" required=""  autocomplete="off" class="layui-input"></div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>每日是否刷新</label>
                        <div class="layui-input-block">
                            <input type="radio" {{ $userMaterial->is_daily_reset?"checked":"" }} name="is_daily_reset" value="1" title="是" checked="">
                            <input type="radio" {{ $userMaterial->is_daily_reset?"":"checked" }} name="is_daily_reset" value="0" title="否">
                        </div>
                    </div>




                    <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>状态</label>
                        <div class="layui-input-block">
                            <input type="radio" {{ $userMaterial->status?"checked":"" }} name="status" value="1" title="正常" checked="">
                            <input type="radio" {{ $userMaterial->status?"":"checked" }} name="status" value="0" title="关闭">
                        </div>
                    </div>



                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label"></label>
                        <button class="layui-btn" lay-filter="edit" lay-submit="">修改</button>
                    </div>
                </form>
            </div>
        </div>
        <script>layui.use(['form', 'layer','laydate'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer,
                laydate = layui.laydate;

                //日期时间选择器
                laydate.render({
                    elem: '#start_time'
                    ,type: 'datetime'
                });


                laydate.render({
                    elem: '#end_time'
                    ,type: 'datetime'
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