

<table style="min-width: 500px;background-color: #fff;padding: 16px;">
    <tbody>
        <tr style="height: 34px;width: 100%;font-size: 12px;line-height: 34px;border-bottom: 1px solid rgba(0,0,0,.1);">
            <td>网站名称：</td>
            <td><a style="text-decoration:none;" target="_blank" href="{{ $data->material->domain }}">{{ $data->material->name }}</a></td>
        </tr>
        <tr style="height: 34px;width: 100%;font-size: 12px;line-height: 34px;border-bottom: 1px solid rgba(0,0,0,.1);">
            <td>素材标题：</td>
            <td><a style="text-decoration:none;" target="_blank" href="{{ $data->source }}" title="{{ $data->title }}">{{ str_limit($data->title,80,'....') }}</a></td>
        </tr>
        <tr style="height: 34px;width: 100%;font-size: 12px;line-height: 34px;border-bottom: 1px solid rgba(0,0,0,.1);">
            <td>素材链接：</td>
            <td><a style="text-decoration:none;" target="_blank" href="{{ $data->source }}">{{ $data->source }}</a></td>
        </tr>
        <tr style="height: 34px;width: 100%;font-size: 12px;line-height: 34px;border-bottom: 1px solid rgba(0,0,0,.1);">
            <td>下载地址：</td>
            <td>
                @foreach($data->attachments as $item)
                    <a style="text-decoration:none;color: #fff;background-color: #2d8cf0;border-color: #2d8cf0;border-radius: 3px;text-align: center;padding: 6px 15px!important;" target="_blank" href="{{ $item->path?:$item->source }}"><span style="font-size: 12px;">下载{{ $item->title?:"文件" }}</span></a>
                @endforeach
            </td>
        </tr>
        <tr style="height: 34px;width: 100%;font-size: 12px;line-height: 34px;border-bottom: 1px solid rgba(0,0,0,.1);">
            <td style="text-align: right;">下载说明：</td>
            <td>
                <span style="color:#f24747;font-size:14px;">下载链接24小时内有效，请尽快下载并保存到您的电脑上，感谢您的配合与支持~</span>
            </td>
        </tr>

    </tbody>
</table>

