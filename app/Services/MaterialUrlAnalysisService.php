<?php


namespace App\Services;
use App\Models\Material;

class MaterialUrlAnalysisService
{

    /**
     * 获取下载的链接所属哪个素材网站
     *
     * @param string $url
     *
     * @return Material
     **/
    public static function getBuildMaterial($url){
        $domain = self::getBaseDomain($url);
        return Material::where('site',$domain->site)->first();
    }

    public static function  getBaseDomain($url){
        if(!$url){
            return $url;
        }

        if(!preg_match("/^http/is", $url)){

            $url="http://".$url;

        }


        $res = new \stdClass();

        $res->domain = null;

        $res->host = null;

        $res->site = null;

        $url_parse = parse_url(strtolower($url));

        $urlarr = explode(".", $url_parse['host']);

        $count = count($urlarr);



        if($count <= 2){
            #当域名直接根形式不存在host部分直接输出
            $res->domain = $url_parse['host'];
            $res->site = array_get($urlarr,0);

        }elseif($count > 2){

            $last = array_pop($urlarr);

            $last_1 = array_pop($urlarr);

            $last_2 = array_pop($urlarr);


            $res->site = $last_1;

            $res->domain = $last_1.'.'.$last;

            $res->host = $last_2;

            #print_r(get_defined_vars());die;

        }
        return $res;
    }

    /**
     * 提取URL中的文件编号
     *
     * @param string $url
     * @return string
     **/
    public static function parseUrlItemNo($url){
        $parse = parse_url($url);
        $path = explode('/',array_get($parse,'path'));
        $count_path = count($path)-1;
        $list = explode('.',array_get($path,$count_path));
        return array_get($list,0);
    }
}