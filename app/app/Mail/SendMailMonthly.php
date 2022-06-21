<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailMonthly extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->subject = "Thông Báo Key hết hạn";
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $email = $this->subject($this->subject)
        //         ->markdown('emails.mail_month') //pass here your email blade file
        //         ->with('keys',$this->data);
        $email = $this->subject($this->subject)
                ->view('emails.monthly.mail',['keys' => $this->data]);
        return $email;
    }
}
