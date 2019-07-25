<?php


namespace App\Services\Adapters\ObtainPages;

class QianTuWangObtainPageAdapter implements ObtainPageRegexInterface
{
    public function titleRegex(){
        return '/<span class="pic-title fl">(.*?)<\/span>/s';
    }

    public function formatRegex(){
        return '/<span class="ext">(.*?)<\/span>/s';
    }
}