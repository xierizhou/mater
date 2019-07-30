<html>
<head>
    <style class="vjs-styles-defaults">
        .video-js { width: 300px; height: 150px; } .vjs-fluid { padding-top: 56.25%
                                                   }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>
        通用素材解析平台
    </title>
    <link rel="stylesheet" href="x-admin/lib/layui/css/layui.css">
    <link href="css/index.css" rel="stylesheet">

</head>
<body>
<div id="app">
    <div data-css-89e166u0="" class="mfs" style="background-image: url({{ url('images/LjARn_c78e001ac75474fc4b17e19f6a6b54a0.jpg') }});">
        <div data-css-89e166u0="" class="cloud">
            <div data-css-89e166u0="" class="logo" style="background-image: url(&quot;http://sssc.co/logo.svg&quot;);">
            </div>
            <div data-css-89e166u0="" class="conts">
                <div data-css-89e166u0="" class="tab">
                    <div data-css-89e166u0="" class="tab-head">
                        <div data-css-89e166u0="" class="download">
                            <form autocomplete="off" class="form ivu-form ivu-form-label-right">
                                <div class="url ivu-form-item">
                                    <!---->
                                    <div class="ivu-form-item-content">
                                        <div class="ivu-input-wrapper ivu-input-wrapper-default ivu-input-type">
                                            <!---->
                                            <!---->
                                            <i class="ivu-icon ivu-icon-ios-loading ivu-load-loop ivu-input-icon ivu-input-icon-validate">
                                            </i>
                                            <input name="url" autocomplete="off" spellcheck="false" type="text" placeholder="请粘贴素材链接提交解析..." class="ivu-input ivu-input-default">
                                            <!---->
                                        </div>
                                        <!---->
                                        <!---->
                                    </div>
                                </div>


                                <button type="button"  class="submit btn-blue ivu-btn ivu-btn-default ivu-btn-large">
                                    <span>提交解析</span>
                                </button>
                            </form>
                            <!---->
                        </div>
                    </div>
                    <div data-css-89e166u0="" class="tab-nav">
                        {{--<div data-css-89e166u0="" class="panel clearfix">
                            <ul data-css-89e166u0="" class="pull-left clearfix">
                                <li data-css-89e166u0="" class="selected">
                                    <p data-css-89e166u0="">
                                        首页
                                    </p>
                                </li>
                                <li data-css-89e166u0="" class="">
                                    <p data-css-89e166u0="">
                                        充值
                                    </p>
                                </li>
                                <li data-css-89e166u0="" class="">
                                    <p data-css-89e166u0="">
                                        教程
                                    </p>
                                </li>



                            </ul>
                            <div data-css-89e166u0="" class="service pull-left">
                                <div data-css-89e166u0="" class="ads">
                                    <div class="ivu-carousel">

                                        <div class="ivu-carousel-list">
                                            <div class="ivu-carousel-track higher" style="width: 996px; transform: translate3d(-498px, 0px, 0px); transition: transform 500ms ease 0s;">
                                                <div class="ivu-carousel-item" style="width: 498px; height: auto; left: 0px;">
                                                    <div>
                                                        <div style="text-align:center;color:red">
                                                            24小时内10字以上五星晒图好评免费领取超级设计大礼包！
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ivu-carousel-item" style="width: 498px; height: auto; left: 0px;">
                                                    <div>
                                                        <div style="text-align:center;">
                                                            一定要记得好评哦！
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!---->
                                        </div>

                                        <ul class="ivu-carousel-dots ivu-carousel-dots-none">
                                            <li class="">
                                                <button type="button" class="">
                                                </button>
                                            </li>
                                            <li class="ivu-carousel-active">
                                                <button type="button" class="">
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>--}}
                    </div>
                    <div data-css-89e166u0="" class="tab-body">
                        <div data-css-89e166u0="" class="member panel">
                            <ul>
                                <li>
                                    <span>登录账号：</span>
                                    <b>{{ auth()->user()->username }}</b>
                                    &nbsp;
                                    <a style="color: #929ab0;" href="{{ url('logout') }}">退出登录</a>
                                </li>
                                {{--<li>
                                    <span>账号设置：</span>
                                    <span>修改密码</span>
                                    <span>绑定手机</span>
                                </li>--}}

                                <li>
									<span>使用权限：</span>
                                    <b>
                                        您可以解析下列开放的素材网站
                                        <span style="color: #4877FC;font-size:12px">
                                            (我们正在努力完善各个功能模板，我们会持续开放更多的素材网站供大家下载)
                                        </span>
                                    </b>
                                </li>
                                <li class="web clearfix">

                                    @foreach($material as $item)
                                        <a href="javascript:;" class="tips_list">
                                            <div class="ivu-tooltip">
                                                <div class="ivu-tooltip-rel">
                                                    @if(array_get($userMaterial,$item->id) && $item->state>0)
                                                        <b>
                                                            {{--@if(array_get($userMaterial,$item->id.'.is_daily_reset'))
                                                                <p class="num">每日剩余{{ array_get($userMaterial,$item->id.'.current') }}次 <i data-tips-content="{{ array_get($userMaterial,$item->id.'.end_time')>0?date('Y年m月d日',array_get($userMaterial,$item->id.'.end_time')).' 到期<br />每日凌晨复原':"永久使用<br />每日凌晨复原" }}" style="font-size:12px;font-weight: bolder;color:#e6c934" data-item-id="{{ $item->id }}" class="layui-icon layui-icon-tips tips_key_{{ $item->id }}"></i> </p>
                                                            @else
                                                                <p class="num">剩余{{ array_get($userMaterial,$item->id.'.current') }}次 <i data-tips-content="{{ array_get($userMaterial,$item->id.'.end_time')>0?date('Y年m月d日',array_get($userMaterial,$item->id.'.end_time')).' 到期':"不限时间<br />用完为止" }}" style="font-size:12px;font-weight: bolder;color:#e6c934" data-item-id="{{ $item->id }}"  class="layui-icon layui-icon-tips tips_key_{{ $item->id }}"></i> </p>
                                                            @endif--}}
                                                            <p class="num">支持全站下载</p>

                                                            <p onclick='window.open("{{ $item->domain }}");'>{{ $item->name }}</p>
                                                        </b>
                                                    @else
                                                        <s>
                                                            <p class="num">({{ $item->state?"未激活":$item->state_cause }})</p>
                                                            <p onclick='window.open("{{ $item->domain }}");'>{{ $item->name }}</p>
                                                        </s>
                                                    @endif
                                                </div>

                                            </div>
                                        </a>
                                    @endforeach

                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="x-admin/lib/layui/layui.js"></script>
<script>
    layui.use(['layer'], function(){
        var layer = layui.layer;

        $('.submit').click(function(){
            var url = $("input[name='url']").val();
            if(!url){
                layer.msg('请粘贴素材链接后再提交', {
                    offset: 't',
                    anim: 6,
                    icon: 2
                });
                return false;
            }

            var Expression=/http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/;
            var objExp=new RegExp(Expression);
            if(objExp.test(url) != true){
                layer.msg('素材链接格式有误，请重新输入', {
                    offset: 't',
                    anim: 6,
                    icon: 2
                });
                return false;
            }

            layer.open({
                type: 2,
                area: ['700px', '550px'],
                fixed: false, //不固定
                maxmin: false,
                title:false,
                content: '{{ url("/ibaout/varify/show") }}'
            });
            return false;



        });


        $('.layui-icon-tips').click(function(){
            var content = $(this).attr('data-tips-content');
            console.log(content);
            var keyId = $(this).attr('data-item-id');
            layer.tips(content, '.tips_key_'+keyId, {
                tips: [2, '#333'],
                time:3000,
                skin:'key_'+keyId,
            });

            var top = $(this).attr('data-top-px');
            if(!top){
                 top = $('.key_'+keyId).css('top').replace('px',"")-17;
                $(this).attr('data-top-px',top);
            }

            $('.key_'+keyId).css('top',top+'px');
        });

        $('.layui-icon-tips').mouseover(function(){
            var content = $(this).attr('data-tips-content');
            var keyId = $(this).attr('data-item-id');
            layer.tips(content, '.tips_key_'+keyId, {
                tips: [2, '#333'],
                time:3000,
                skin:'key_'+keyId,
            });
            var top = $(this).attr('data-top-px');
            if(!top){
                top = $('.key_'+keyId).css('top').replace('px',"")-17;
                $(this).attr('data-top-px',top);
            }

            $('.key_'+keyId).css('top',top+'px');
        });




    });

    function build(){
        var url = $("input[name='url']").val();
        var load = null;
        $.ajax({
            url:"{{ url('build') }}",    //请求的url地址
            dataType:"json",   //返回格式为json
            async:true,//请求是否异步，默认为异步，这也是ajax重要特性
            data:{url:url,_token:"{{ csrf_token() }}"},
            type:"POST",
            beforeSend:function(){
                $('.submit').attr({ disabled: "disabled" })
                load = layer.load(2,{
                    shade: [0.5] //0.1透明度的白色背景
                });
            },
            success:function(req){
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 1,
                    area:"500px",
                    shadeClose: false,
                    content: req.data
                });

                if(!req.is_decrease){
                    //layer.msg("检测到您下载过该素材，本次解析将不扣除次数");
                }

            },
            complete:function(){
                //请求完成的处理
                $(".submit").removeAttr("disabled");
                layer.close(load);
            },
            error:function(data){
                console.log(data.responseJSON.message);
                layer.msg(data.responseJSON.message);
            }
        });
    }
</script>
<script src="{{ url('js/Verification.js') }}"></script>
<script src="//g.alicdn.com/sd/nvc/1.1.112/guide.js"></script>
</body>
</html>