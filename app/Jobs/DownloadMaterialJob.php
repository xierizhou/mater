<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\MaterialFile;
use App\Services\MaterialDownloadUploadOssService;
class DownloadMaterialJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $materialFile;

    /**
     * Create a new job instance.
     *
     * @param MaterialFile $materialFile
     * @return void
     */
    public function __construct(MaterialFile $materialFile)
    {
        $this->materialFile = $materialFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        $material_name = $this->materialFile->material->site;
        foreach($this->materialFile->attachments as $item){
            $save = MaterialDownloadUploadOssService::getInstance()
                ->downLoad($item->path?:$item->source,$material_name)
                ->uploadOss(true);
            $item->is_oss = 1;
            $item->oss = $save;
            $item->save();
        }

    }
}
