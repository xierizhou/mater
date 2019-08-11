@extends('admin.app')
@section('title', '代理商列表')
@section('content')
    
    <body>
        <div class="x-nav">
            <span class="layui-breadcrumb">
                <a href="">首页</a>
                <a><cite>代理商列表</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
                <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i>
            </a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">
                            <form class="layui-form layui-col-space5">

                                <div class="layui-input-inline layui-show-xs-block">
                                    <input type="text" value="{{ request()->input('key') }}" name="key" placeholder="请输入用户名/手机/邮箱" autocomplete="off" class="layui-input"></div>
                                <div class="layui-input-inline layui-show-xs-block">
                                    <button class="layui-btn" lay-submit="" lay-filter="sreach">
                                        <i class="layui-icon">&#xe615;</i></button>
                                </div>
                            </form>
                        </div>
                        <div class="layui-card-header">
                            {{--<button class="layui-btn layui-btn-danger" onclick="delAll()">
                                <i class="layui-icon"></i>批量删除</button>--}}
                            <button class="layui-btn" onclick="xadmin.open('添加代理商','{{ url('admin/agent/create') }}',800,600)">
                                <i class="layui-icon"></i>添加</button></div>
                        <div class="layui-card-body ">
                            <table class="layui-table layui-form">
                                <thead>
                                    <tr>
                                        <th>序号</th>
                                        <th>代理商</th>
                                        <th>代理级别</th>
                                        <th>LOGO</th>
                                        <th>域名</th>
                                        <th>拥有用户</th>
                                        <th>充值总额(￥)</th>
                                        <th>进货总额(￥)</th>
                                        <th>剩余总额(￥)</th>
                                        <th>状态</th>
                                        <th>加入时间</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @foreach($data as $kk=>$item)
                                    <tr>
                                        <td>{{ ++$kk }}</td>
                                        <td>
                                            用户名：{{ $item->username }}<br/>
                                            手机号：{{ $item->mobile }}<br/>
                                            邮 箱： {{ $item->email }}<br/>
                                        </td>
                                        <td>{{ $item->grade->name }}</td>
                                        <td>{{ $item->logo }}</td>
                                        <td>
                                            <a target="_blank" href="{{ $item->domain }}">{{ $item->domain }}</a><br>
                                            <a target="_blank" href="{{ $item->sub_domain }}">{{ $item->sub_domain }}</a>
                                        </td>

                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>{{ $item->money }}</td>
                                        <td>{{ $item->status?"正常":"冻结" }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td class="td-manage">
                                            <a title="查看" onclick="xadmin.open('编辑','{{ url('admin/agent/'.$item->id.'/edit') }}',800,600)" href="javascript:;"><i class="layui-icon">&#xe63c;</i></a>
                                            {{--<a title="删除" onclick="member_del(this,'{{ $item->id }}')" href="javascript:;"><i class="layui-icon">&#xe640;</i></a>
                                        --}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            {{ $data->appends(['key'=>request('key')])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>layui.use(['laydate', 'form'],
        function() {
            var laydate = layui.laydate;

            //执行一个laydate实例
            laydate.render({
                elem: '#start' //指定元素
            });

            //执行一个laydate实例
            laydate.render({
                elem: '#end' //指定元素
            });
        });

        /*用户-停用*/
        function member_stop(obj, id) {
            layer.confirm('确认要停用吗？',
            function(index) {

                if ($(obj).attr('title') == '启用') {

                    //发异步把用户状态进行更改
                    $(obj).attr('title', '停用');
                    $(obj).find('i').html('&#xe62f;');

                    $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                    layer.msg('已停用!', {
                        icon: 5,
                        time: 1000
                    });

                } else {
                    $(obj).attr('title', '启用');
                    $(obj).find('i').html('&#xe601;');

                    $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                    layer.msg('已启用!', {
                        icon: 5,
                        time: 1000
                    });
                }

            });
        }

        /*用户-删除*/
        function member_del(obj, id) {
            layer.confirm('确认要删除吗？',
            function(index) {
                //发异步删除数据
                $.ajax({
                    url:"{{ url('admin/channel') }}/"+id,
                    method:'post',
                    data:{"_method":"delete","_token":"{{ csrf_token() }}"},
                    dataType:'json',
                    success:function(data){
                        //$(obj).parents("tr").remove();
                        layer.msg(data.message, {
                            icon: 1,
                            time: 1000
                        });
                        location.reload();
                    },
                    error:function (data) {
                        layer.msg(data.message, {
                            icon: 5,
                            time: 1000
                        });

                    }
                })


            });
        }


    </script>
@endsection
