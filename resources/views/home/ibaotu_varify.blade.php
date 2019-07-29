<html>
<head></head>
<style>
    .dl-cot .yanzheng-wrap {
        text-align: center;
        color: #666;
        letter-spacing: 1px;
    }
    .dl-cot .yanzheng-wrap>h3 {
        height: 24px;
        line-height: 24px;
        font-size: 24px;
        font-weight: 400;
    }
    .dl-cot .yanzheng-wrap>.tips {
        height: 18px;
        line-height: 18px;
        margin: 25px 0 20px;
    }
    .dl-cot .yanzheng-wrap>.tips>span {
        color: #ff8a00;
    }
    .dl-cot .yanzheng-wrap .imgs-wrap {
        overflow: hidden;
        width: 532px;
        margin: 0 auto;
        letter-spacing: 0;
    }
    .dl-cot .yanzheng-wrap .imgs-wrap>img {
        width: 140px;
        height: 82px;
        margin: 6px;
        border: 1px solid transparent;
        cursor: pointer;
    }
</style>
<body>
<div class="dl-cot clearfix down-but" style="padding: 40px 0 94px 0px;">
    <div class="yanzheng-wrap">
        <h3>请您先完成验证后继续下载</h3>
        <p data-item-no="{{ $item_no }}" class="tips">请点击图片中的'<span>{{ $value }}</span>'字</p>
        <div class="imgs-wrap">
             @foreach($key as $v)
            <img src="//ibaotu.com/index.php?m=downVarify&amp;a=renderCode&amp;k={{ $v }}" data-key="{{ $v }}" />
             @endforeach
        </div>
    </div>
</div>
</body>
<script src="js/jquery.min.js"></script>
<script>
    $('.imgs-wrap img').mouseover(function(){
        $(this).css('border','1px solid #ff8a00');
        $(this).siblings().css('border','1px solid transparent');
    });

    $('.imgs-wrap').on('click','img',function(){
        var answer_key = $(this).attr('data-key');
        var item_no = $('.tips').attr('data-item-no');
        $.get('{{ url('ibaout/varify') }}?answer_key='+answer_key+'&item_no='+item_no,function(data){
            console.log(data);
        });
    });
</script>
</html>