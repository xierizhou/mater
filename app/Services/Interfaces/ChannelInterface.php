<?php


namespace App\Services\Interfaces;


interface ChannelInterface
{
    /**
     * 登录
     *
     * @param boolean $refresh 是否强制刷新cookie
     * @return mixed
     **/
    public function login($refresh = false);

    /**
     * @param string $url
     * @return mixed
     */
    public function download( string  $url);
}