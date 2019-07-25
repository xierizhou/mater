<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        ul {
            list-style-type: none;
        }
        body{

            color:#4e5361;
            font-family: Helvetica Neue,Helvetica,PingFang SC,Hiragino Sans GB,Microsoft YaHei,Arial,sans-serif;
        }
        a{text-decoration:none;}
        a:hover {text-decoration:underline;}
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
                        <span><a target="_blank" href="{{ $data->material->domain }}">{{ $data->material->name }}</a></span>
                    </li>

                    <li>
                        <span>素材标题：</span>
                        <span><a target="_blank" href="{{ $data->source }}" title="{{ $data->title }}">{{ str_limit($data->title,55,'....') }}</a></span>
                    </li>

                    <li>
                        <span>素材链接：</span>
                        <span><a target="_blank" href="{{ $data->source }}">{{ $data->source }}</a></span>
                    </li>
                </ul>

                <div class="btn">
                    @foreach($data->attachments as $item)
                    <a target="_blank" href="{{ $item->path?:$item->source }}"><span>下载{{ $item->title?:"文件" }}</span></a>
                    @endforeach

                </div>

                <div style="margin-top:20px">
                    <span style="color:#f24747;font-size:14px;">下载链接24小时内有效，请尽快下载并保存到您的电脑上，感谢您的配合与支持~</span>
                </div>

                <div style="margin-top:20px">
                    <img src="http://image.uisdc.com/wp-content/uploads/2017/12/uisdc-sticker-20171210-1.jpg" />
                </div>

            </div>
        </div>

    </div>
</body>

</html>