<?php

namespace App\Console\Commands;

use App\Key;
use App\User;
use App\Setting;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailDaily;
use Illuminate\Console\Command;

class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:key';

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
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       
        $i=0;

        $setting = Setting::find(1);
        $today = date('Y-m-d');
        $so_ngay = $setting->daily;
        $ngay_cb = date('Y-m-d', strtotime($today . " +$so_ngay days"));
        $keys = Key::whereDate('ngay_het_han', '=', $ngay_cb)->get();

        
        
        foreach($keys as $key)
        {
            $mails = User::where('mail', '=', '1')->select('email')->get();
            foreach($mails as $mail)
            {
                Mail::to($mail)->send(new SendMailDaily($key));
            }
            $i++; 
        }

        $this->info($i.' Key đã hết hạn!');
    }
}
