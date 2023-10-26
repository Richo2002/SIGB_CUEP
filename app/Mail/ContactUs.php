<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUs extends Mailable
{
    use Queueable, SerializesModels;

    public $mailContent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $mailContent)
    {
        $this->mailContent = $mailContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->mailContent['email'], $this->mailContent['name'])
                ->subject("Demande d'assistance depuis ".config('app.name'))
                ->markdown('emails.contactUs', [
                    'message' => $this->mailContent['message'],
                ]);
    }
}
