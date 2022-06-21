<?php

namespace App\Console\Commands;

use App\Key;
use App\User;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailMonthly;
use Illuminate\Console\Command;

class MailMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email2:key';

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
        
        $keys = Key::whereMonth('ngay_het_han', '=', date('m')+1)->get();
        $i=$keys->count();
        
        $mails = User::where('mail', '=', '1')->select('email')->get();
        foreach($mails as $mail)
        {
            Mail::to($mail)->send(new SendMailMonthly($keys));
        }

        $this->info($i.' Key sắp hết hạn!');
    }
}
