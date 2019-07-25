<?php

/**
 * 渠道注册配置
 **/
return [
    'http://sssc.co'=>\App\Services\Channels\SsScChannelService::class,
    'yuansupic'=>\App\Services\Adapters\Channels\YuanSuPicAdapterChannel::class,

];