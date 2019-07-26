<?php

namespace App\Jobs;

use App\Models\ReplaceDownload;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Channel;
use App\Services\ChannelService;
use App\Services\MaterialDownloadUploadOssService;
class MaterialReplaceDownloadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 任务最大尝试次数。
     *
     * @var int
     */
    public $tries = 5;

    /**
     * @var ReplaceDownload
     */
    private $replaceDownload;

    /**
     * MaterialReplaceDownloadJob constructor.
     * @param ReplaceDownload $replaceDownload
     */
    public function __construct(ReplaceDownload $replaceDownload)
    {
        $this->replaceDownload = $replaceDownload;
    }

    /**
     * @throws \Throwable
     */
    public function handle()
    {

        try{
            $channel = Channel::find(3);
            $materialFile = ChannelService::getInstance($channel)->setSaveOss(false)->download($this->replaceDownload->download_url);
            if($materialFile){
                $material_name = $materialFile->material->site;
                foreach($materialFile->attachments as $item){
                    $save = MaterialDownloadUploadOssService::getInstance()
                        ->downLoad($item->source,$material_name)
                        ->uploadOss(true);
                    $item->is_oss = 1;
                    $item->oss = $save;
                    $item->save();
                }
                $this->replaceDownload->material_file_id = $materialFile->id;
                $this->replaceDownload->save();
                MaterialSendEmailJob::dispatch($this->replaceDownload,$materialFile);
            }else{
                throw new \Exception("素材解析失败");
            }
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }


    }
}
