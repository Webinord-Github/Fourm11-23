<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailBody;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailBody)
    {
        $this->emailBody = $emailBody;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.custom-mail')
                    ->with(['emailBody' => $this->emailBody])
                    ->text('emails.custom-plain')
                    ->subject('Nouvel inscription');
    }
}
