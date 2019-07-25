<?php


namespace App\Services;

use App\Models\UserDownloadLog;
use App\Models\MaterialFile;
use App\Models\User;
class MaterialUserDownloadLogs
{

    private $user;

    /** 用户下载记录服务 **/

    private function __construct()
    {
        $this->user = auth()->user();

    }

    /**
     * 记录用户下载记录
     *
     * @param MaterialFile $materialFile
     * @return UserDownloadLog
     **/
    public function log(MaterialFile $materialFile){
        $user = $this->user;
        if($userDownloadLog = $this->getLogFindFile($materialFile)){
            return $userDownloadLog;
        }
        return UserDownloadLog::create([
            'user_id'=>$user->id,
            'material_id'=>$materialFile->material_id,
            'material_file_id'=>$materialFile->id,
            'source_url'=>$materialFile->source,
        ]);
    }

    /**
     * 获取用户下载文件记录
     *
     * @param MaterialFile $materialFile
     * @return null
     **/
    public function getLogFindFile(MaterialFile $materialFile){

        return UserDownloadLog::where('user_id',$this->user->id)->where('material_file_id',$materialFile->id)->first();
    }


    public static function getInstance(){
        return new self();
    }
}