<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>一站式下载</title>
    <style>
        ul {
            list-style-type: none;
        }
        body{

            color:#4e5361;
            font-family: Helvetica Neue,Helvetica,PingFang SC,Hiragino Sans GB,Microsoft YaHei,Arial,sans-serif;
        }
        .model{
            min-width: 500px;
            background-color: #fff;
            background-clip: padding-box;
        }
        .model-body{
            padding: 16px;
        }
        .model-list{
            padding: 15px;
            visibility: visible;
            transition: all .2s linear;
            width: 100%;
            opacity: 1;
        }
        .model-list a{

        }

        .model-list ul{
            padding: 0;
            margin-bottom: 15px;
        }

        .model-list ul li{
            height: 34px;
            width: 100%;
            font-size: 12px;
            line-height: 34px;
            border-bottom: 1px solid rgba(0,0,0,.1);
        }
        .btn{
            /*display: flex;*/
        }

        .btn a{
            color: #fff;
            background-color: #2d8cf0;
            border-color: #2d8cf0;
            border-radius: 3px;
            text-align: center;
            padding: 6px 15px!important;

        }
        .btn a span{
            vertical-align: middle;
            font-size: 12px;
        }

    </style>
</head>
<body>
    <div class="model">

        <div class="model-body">
            <div class="model-list">
                <ul>
                    <li>
                        <span>网站名称：</span>
                        <span><a target="_blank" href="{{ $material->domain }}">{{ $material->name }}</a></span>
                    </li>

                    <li>
                        <span>素材标题：</span>
                        <span><a target="_blank" href="{{ array_get($data,'url') }}" title="{{ array_get($data,'title') }}">{{ str_limit(array_get($data,'title'),55,'....') }}</a></span>
                    </li>

                    <li>
                        <span>素材链接：</span>
                        <span><a target="_blank" href="{{ array_get($data,'url') }}">{{ array_get($data,'url') }}</a></span>
                    </li>
                </ul>

                <div class="btn">
                    <a href="javascript:;" data-is-download="{{ $is_download }}" data-download-url="{{ array_get($data,'url') }}" class="confirm"><span>确认</span></a>
                    <a href="javascript:;" class="cancel" style="background-color: #a9bed4;"><span>取消</span></a>
                </div>

            </div>
        </div>
    </div>



</body>

</html>