<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>
        正在为您跳转
    </title>
    <script src="/js/jquery.min.js"></script>
</head>
<body>

</body>
</html>
<script>
    var height = window.screen.height;
    var weight = window.screen.width;
    var availHeight = window.screen.availHeight;
    var availWeight = window.screen.availWidth;
    var colorDepth = screen.colorDepth;
    $.post("/automatic",{height:height,weight:weight,availHeight:availHeight,availWeight:availWeight,colorDepth:colorDepth,_token:"{{ csrf_token() }}"},function(res){
        location.href = "/";
    },'json');
</script>