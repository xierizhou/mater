<?php


namespace App\Services\Adapters\ObtainPages;


interface ObtainPageRegexInterface
{
    public function titleRegex();

    public function formatRegex();
}