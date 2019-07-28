<html>
<head>
    <meta charset="utf-8">
    <title>
        千库授权
    </title>
    <link rel="stylesheet" href="{{ url('x-admin/lib/layui/css/layui.css') }}">
    <link href="{{ url('css/index.css') }}" rel="stylesheet">

</head>
<body>


<script src="{{ url('js/jquery.min.js') }}"></script>
<script src="{{ url('x-admin/lib/layui/layui.js') }}"></script>
<script>
    layui.use(['layer'], function(){
        var layer = layui.layer;

        var open1 = layer.open({
            type: 2,
            area: ['250px', '40px'],
            fixed: true, //不固定
            maxmin: false,
            title:"正在授权中...",
            content: '{{ $localhost }}'
        });
        $('iframe').load(function(){
            layer.close(open1);
            var loadingIndex = layer.load(2, { //icon支持传入0-2
                shade: [0.5, 'gray'], //0.5透明度的灰色背景
                content: '跳转中...',
                success: function (layero) {
                    layero.find('.layui-layer-content').css({
                        'padding-top': '39px',
                        'width': '100px'
                    });
                }
            });
            window.location.href = "https://588ku.com/";

        });

    });
</script>
</body>
</html>