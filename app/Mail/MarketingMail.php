<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class MarketingMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Get the message envelope.
     */
    public $id;
    public $email_content;
    public $email;
    public $file_url;
    /**
     * Create a new message instance.
     */
    public function __construct($id, $email_content, $email, $file_url)
    {
        $this->id = $id;
        $this->email_content = $email_content;
        $this->email = $email;
        $this->file_url = $file_url;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->email_content[0],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.mail',
            with: ['template' => $this->email_content[1], 'id' => $this->id],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments()
    {
        if ($this->file_url) {
            foreach ($this->file_url as $file) {
                $this->attach(public_path($file));
            }
        }
    }
}
