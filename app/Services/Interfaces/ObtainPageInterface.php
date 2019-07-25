<?php


namespace App\Services\Interfaces;


use App\Services\Adapters\ObtainPages\ObtainPageRegexInterface;

interface ObtainPageInterface
{
    /**
     * @param ObtainPageRegexInterface $obtainPageRegex
     * @param string $url
     * @return mixed
     */
    public function build(ObtainPageRegexInterface $obtainPageRegex ,string $url);
}