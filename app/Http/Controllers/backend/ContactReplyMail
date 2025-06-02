<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $replyContent;

    public function __construct($contact, $replyContent)
    {
        $this->contact = $contact;
        $this->replyContent = $replyContent;
    }

    public function build()
    {
        return $this->markdown('emails.contact-reply')
                    ->subject('Trả lời: ' . $this->contact->subject);
    }
}