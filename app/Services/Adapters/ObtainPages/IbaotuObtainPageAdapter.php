<?php


namespace App\Services\Adapters\ObtainPages;

class IbaotuObtainPageAdapter implements ObtainPageRegexInterface
{
    public function titleRegex(){
        return '/<h1 class="works-name">(.*?)<\/h1>/s';
    }

    public function formatRegex(){
        return '/<b class="type_icont (.*?)">(.*?)<\/b>/s';
    }
}