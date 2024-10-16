<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\User;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data['title'] = 'Successful Registration';
        $data['name'] = 'Suraj Kumar';
        $data['email'] = 'suraj.enact@gmail.com';
        $data['body'] = 'Cron Testing mail';
        Mail::send('forgetPasswordMail',['data'=>$data],function($message) use($data){
            $message->to($data['email'])->subject($data['title']);
         });
    }
}
