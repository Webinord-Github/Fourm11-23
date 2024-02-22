<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AutoEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailBody;
    public $customSubject; 

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailBody, $customSubject)
    {
        $this->emailBody = $emailBody;
        $this->customSubject = $customSubject;

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
                    ->subject($this->customSubject);

    }
}
