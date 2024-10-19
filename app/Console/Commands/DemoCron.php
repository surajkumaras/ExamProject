<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Models\User;

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
        // $data['title'] = 'Successful Registration';
        // $data['name'] = 'Suraj Kumar';
        // $data['email'] = 'suraj.enact@gmail.com';
        // $data['body'] = 'Cron Testing mail';
        // $data['url'] = 'surajdeveloper-net.stackstaging.com';
        // Mail::send('forgetPasswordMail',['data'=>$data],function($message) use($data){
        //     $message->to($data['email'])->subject($data['title']);
        //  });

        //Do here cron task code

        $users = User::select('name','email')->get();

        $emails = [];

        foreach($users as $user)
        {
            // $emails[] = $user->email;

            $data['title'] = 'Cron job Test Mail';
            $data['name'] = $user->name;
            $data['email'] = $user->email;
            $data['body'] = 'Cron Testing mail';

            Mail::send('mail.test-mail',['data'=>$data],function($message) use($data)
            {
                $message->to($data['email'])->subject($data['title']);
            });
        }

        // Mail::send('mail.test-mail',['data'=>$users],function($message) use($emails)
        // {
        //     $message->to($emails)->subject('Cron job Test Mail');
        // });
    }
}
