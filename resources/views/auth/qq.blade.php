@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <img class="show_qr" src="{{ $qr_url }}" />
        <p class="message"></p>
    </div>
</div>
<script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>

<script>
    function hash33(t){
        for(var e=0,i=0,n=t.length;i<n;++i)
            e+=(e<<5)+t.charCodeAt(i);
        return 2147483647&e;
    }


    pollingCheckQRStatic();
    function pollingCheckQRStatic(){
        var ptqrtoken = hash33("{{ array_get($data,'qrsig') }}");
        var t = new Date();
        var actions = [0,0];
        var action = actions.join("-")+"-"+t.getTime();

        $.get("/auth/qq/qr_check?ptqrtoken="+ptqrtoken+"&action="+action,function(data){
            eval(data);
        });
    }

    function loginSucessRequest(url){
        $.post("/auth/qq/login_success",{url:url,_token:"{{ csrf_token() }}"},function(res){
            var g_tk = getToken(res.p_skey);
            requestGtk(g_tk);
        },'json');
    }

    function requestGtk(g_tk){
        $.post("/auth/qq/login_gtk",{g_tk:g_tk,_token:"{{ csrf_token() }}"},function(res){
            alert("整个操作完成");
        },'json');
    }

     function getToken(p_skey) {
        var str = p_skey,
            hash = 5381;
        for (var i = 0, len = str.length; i < len; ++i) {
            hash += (hash << 5) + str.charCodeAt(i);
        }
        return hash & 0x7fffffff;
    }

    function ptuiCB(t, e, i, n, o, p) {

        switch (t) {
            case "0":
                //已授权登录
                loginSucessRequest(i);
                $('.message').text("完成授权...");
                break;
            case "3":

                break;
            case "4":

                break;
            case "12":
            case "51":

                break;
            case "65":
                alert("二维码已失效，请重新扫码登录");
                setTimeout("location.reload()",500);
                //二维码已失效
                break;
            case "66":
                $('.message').text("等待扫码中...");
                setTimeout("pollingCheckQRStatic()",1000);
                //二维码未失效，等待扫码
                return;
            case "67":
                $('.message').text("检测到您已扫码，请允许登录...");
                setTimeout("pollingCheckQRStatic()",1000);
                //二维码认证中，已扫码
                break;
            case "22005":
            case "68":

                break;
            case "10005":
            case "10006":
            case "22009":

                break;
            case "10008":
                break;
            default:

        }

    }
</script>
@endsection
