<?php

return [

    'juhe'=>[
        'api_url'=>'http://v.juhe.cn/sms/send',
        'key'=>'693a70addf0ed9677c7cd39c27b75ea1',
        'class'=>\App\Services\Adapters\Sms\JuHeCnSmsAdapterService::class,
    ],

    '5c'=>[
        'class'=>\App\Services\Adapters\Sms\MeiLianRuanTongAdapter::class,
    ],
];