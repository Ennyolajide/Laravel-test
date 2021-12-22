<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $sender;
    public $mailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sender, $mailData)
    {
        $this->sender = $sender;
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->sender->email, $this->sender->name)
            ->subject($this->mailData->subject)
            ->markdown('Email.demo');
    }
}
