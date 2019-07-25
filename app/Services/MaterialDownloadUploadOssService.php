<?php


namespace App\Services;


class MaterialDownloadUploadOssService
{
    /** 下载素材文件并且上传到阿里云OSS **/

    private $fileInfo;

    private $materialName;

    static private $instance;
    private function __clone(){}
    private function __construct(){
    }
    static public function getInstance(){
        //判断$instance是否是Uni的对象
        //没有则创建
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 下载文件到本地
     *
     * @param string $url
     * @param string $material_name 素材网站site
     * @return MaterialDownloadUploadOssService
     **/
    public function downLoad($url,$material_name){
        $this->materialName = $material_name;

        $this->fileInfo = $this->getFile($url,public_path("downloads/$material_name"),md5(time().rand(1000,9999)));

        return $this;
    }

    /**
     * 获取下载文件后的文件保存信息
     **/
    public function getFileInfo(){
        return $this->fileInfo;
    }

    /**
     * 上传到OSS
     *
     * @param boolean $is_delete_local 上传成功之后是否删除本地文件
     * @return string
     **/
    public function uploadOss($is_delete_local = false){
        $saveName = array_get($this->fileInfo,'file_name');
        if($this->materialName){
            $saveName = $this->materialName.'/'.array_get($this->fileInfo,'file_name');
        }
        AliOssService::getInstance()->upload(array_get($this->fileInfo,'save_path'),$saveName);
        if($is_delete_local){
           @unlink(array_get($this->fileInfo,'save_path'));
        }
        return $saveName;
    }

    /**
     * 获取文件并且保存到本地
     **/
    public function getFile($url, $save_dir = '', $filename = '', $type = 0) {
        set_time_limit(0);
        $size = 0;
        if (trim($url) == '') {
            return false;
        }
        if (trim($save_dir) == '') {
            $save_dir = './';
        }
        if (0 !== strrpos($save_dir, '/')) {
            $save_dir.= '/';
        }

        $file = parse_url($url);
        $extension = pathinfo($file['path'], PATHINFO_EXTENSION);

        //如果没有设置文件名则按时间来保存
        if(!$filename){
            $filename = time().'.'.$extension;
        }

        //如果名称没有后缀名自动补全
        if(!pathinfo($filename, PATHINFO_EXTENSION)){
            $filename = $filename.'.'.$extension;
        }

        //创建保存目录
        if (!file_exists($save_dir) && !mkdir($save_dir, 0777, true)) {
            return false;
        }
        //获取远程文件所采用的方法
        if ($type) {

            $ch = curl_init();
            $timeout = 30;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $content = curl_exec($ch);
            curl_close($ch);
        } else {

            $hostfile = @fopen($url,'r');

            $fh = @fopen($save_dir . $filename, 'w');
            while (!feof($hostfile)) {
                $output = fread($hostfile, 8192);
                fwrite($fh, $output);
            }

            fclose($hostfile);
            fclose($fh);


        }




        return array(
            'file_name' => $filename,
            'save_path' => $save_dir . $filename,
            //'size'=>$size
        );
    }



}