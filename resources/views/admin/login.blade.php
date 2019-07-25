@extends('admin.app')
@section('title', '系统后台登录')
@section('style')
    @parent
    <link rel="stylesheet" href="{{ url('x-admin/css/login.css') }}">
@endsection

@section('script')
    @parent
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
@endsection
@section('content')


<body class="login-bg">
    
    <div class="login layui-anim layui-anim-up">
        <div class="message">x-admin2.0-管理登录</div>
        <div id="darkbannerwrap"></div>
        
        <form method="post" class="layui-form" action="{{ url('admin/login') }}" >
            {{ csrf_field() }}
            <input name="username" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
    </div>

    <script>
        $(function  () {
            layui.use('form', function(){
              var form = layui.form;
              //监听提交
              form.on('submit(login)', function(data){
                 /*alert(888)*/
                /*layer.msg(JSON.stringify(data.field),function(){
                    //location.href='/admin'
                });*/
                 console.log(data);
                return true;
              });
            });
        })
    </script>
    <!-- 底部结束 -->
</body>
@endsection