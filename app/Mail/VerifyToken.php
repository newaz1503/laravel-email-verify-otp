<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyToken extends Mailable
{
    use Queueable, SerializesModels;

    public $get_user_name, $get_user_email, $validToken;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($get_user_name, $get_user_email, $validToken)
    {
        $this->get_user_name = $get_user_name;
        $this->get_user_email = $get_user_email;
        $this->validToken = $validToken;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Verify Token',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'email.verify-token',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
