<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
class CheckAuthorization extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:auth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $url = 'https://ssl.ptlogin2.qq.com/pt_open_login?openlogin_data=which%3D%26refer_cgi%3Dauthorize%26response_type%3Dcode%26client_id%3D101252414%26state%3D%26display%3D%26openapi%3D1010_1011%26switch%3D0%26src%3D1%26sdkv%3D%26sdkp%3D%26tid%3D1564728110%26pf%3D%26need_pay%3D0%26browser%3D0%26browser_error%3D%26serial%3D%26token_key%3D%26redirect_uri%3Dhttps%253A%252F%252F588ku.com%252Fdlogin%252Fcallback%252Fqq%26sign%3D%26time%3D%26status_version%3D%26status_os%3D%26status_machine%3D%26page_type%3D1%26has_auth%3D1%26update_auth%3D1%26auth_time%3D1564728109357&auth_token=1883723884&pt_vcode_v1=0&pt_verifysession_v1=&verifycode=&u=&pt_randsalt=0&ptlang=2052&low_login_enable=0&u1=http%3A%2F%2Fconnect.qq.com&from_ui=1&fp=loginerroralert&device=2&aid=716027609&daid=383&pt_3rd_aid=101252414&ptredirect=1&h=1&g=1&pt_uistyle=35&regmaster=&';
        $client = new Client();
        $res = $client->request('GET',$url,[
            'headers'=>[
                'Cookie'=>'superuin=o0384860859;supertoken=2644047089; superkey=CJYXjHU4P*76hLizU3u0IqnhB9BW9ZJ3Y-OpY2IR9aU_;',
            ],
        ]);
        $content = $res->getBody()->getContents();

        $contents = strstr($content, '588ku');
        if($contents){
            //$subject = "正常";
        }else{
            $subject = "失效";
            $to = '384860859@qq.com';
            Mail::send(
                'emails.test',
                [],
                function ($message) use($to, $subject) {
                    $message->to($to)->subject($subject);
                }
            );
        }



    }
}
