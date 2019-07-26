<?php

namespace App\Jobs;

use App\Models\Email;
use App\Models\MaterialFile;
use App\Services\AliOssService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\ReplaceDownload;
use Illuminate\Support\Facades\Mail;
class MaterialSendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var
     */
    private $replaceDownload;

    /**
     * @var
     */
    private $materialFile;

    /**
     * @var int
     */
    private $ossExpire = 86400;

    /**
     * MaterialSendEmailJob constructor.
     * @param ReplaceDownload $replaceDownload
     * @param MaterialFile $materialFile
     */
    public function __construct(ReplaceDownload $replaceDownload,MaterialFile $materialFile)
    {
        $this->replaceDownload = $replaceDownload;
        $this->materialFile = $materialFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        try{

            foreach($this->materialFile->attachments as $item){
                $item->path = AliOssService::getInstance()->getObject($item->oss,$this->ossExpire);
                $item->oss_url_expire = time()+$this->ossExpire;
                $item->save();
            }

            $to = $this->replaceDownload->replace->email;
            $subject = $this->materialFile->title;
            Mail::send(
                'emails.replace',
                ['data' => $this->materialFile],
                function ($message) use($to, $subject) {
                    $message->to($to)->subject($subject);
                }
            );
            $is_success = 1;
            $fail_message = null;
        }catch (\Exception $exception){
            $is_success = 2;
            $fail_message = $exception->getMessage();
        }
        $email = Email::create([
            'sender'=>config('mail.from.address'),
            'addressee'=>$to,
            'title'=>$subject,
            'is_success'=>$is_success,
            'fail_message'=>$fail_message,
            'content'=>response(view('emails.replace',['data'=>$this->materialFile]))->getContent(),
            'send_time'=>time(),
        ]);
        $this->replaceDownload->email_id = $email->id;
        $this->replaceDownload->save();

    }
}
