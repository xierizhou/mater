<?php


namespace App\Services;

use OSS\OssClient;
use OSS\Core\OssException;
class AliOssService
{
    static private $instance;

    private $ossClient;

    private function __construct($accessKeyId,$accessKeySecret,$endpoint,$isCName=false)
    {
        try{

            $this->ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint,$isCName);
        }catch (OssException $exception){
            dd($exception->getMessage());
        }

    }

    private function __clone(){}


    static public function getInstance(){
        //判断$instance是否是Uni的对象
        //没有则创建
        if (!self::$instance instanceof self) {
            $config = config('oss');
            self::$instance = new self(array_get($config,'accessKeyId'),array_get($config,'accessKeySecret'),array_get($config,'endpoint'));
        }
        return self::$instance;

    }

    /**
     * 创建存储桶
     *
     * @param string $bucket 存储桶名称
     * @param string $acl 存储桶权限，默认是私有读写
     * @param string $storage  存储类型 默认是标准类型
     * @return null
     **/
    public function createBucket($bucket,$acl=OssClient::OSS_ACL_TYPE_PRIVATE,$storage=OssClient::OSS_STORAGE_STANDARD){
        // 设置存储空间的存储类型，默认是标准类型。
        $options = array(
            OssClient::OSS_STORAGE => $storage,
        );
        // 设置存储空间的权限为公共读，默认是私有读写。
        return $this->ossClient->createBucket($bucket, $acl, $options);
    }

    /**
     * 上传文件
     *
     * @param string $filePath 由本地文件路径加文件名包括后缀组成，例如/users/local/myfile.txt
     * @param string $saveName 存储的文件名称
     * @param string $bucket 存储空间名称
     * @return null
     **/
    public function upload($filePath,$saveName,$bucket='razee'){
        try{
            return $this->ossClient->uploadFile($bucket,$saveName,$filePath);
        }catch (OssException $exception){
            dd($exception->getMessage());
        }

    }

    /**
     * 使用签名URL进行临时授权访问
     *
     * @param string $object 访问的文件名名称
     * @param int $timeout 有效时间，单位秒
     * @param string $bucket
     * @return string
     **/
    public function getObject($object,$timeout=3600,$bucket='razee'){
        try{
            return $this->ossClient->signUrl($bucket, $object, $timeout);
        }catch (OssException $e){
            dd($e->getMessage());
        }

    }


}