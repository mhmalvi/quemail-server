<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ScheduledMarketingMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $subject;
    public $template;
    public $id;
    public $email;
    // public $file_url;
    /**
     * Create a new message instance.
     */
    public function __construct($subject, $template, $id, $email)
    {
        $this->subject = $subject;
        $this->template = $template;
        $this->id = $id;
        $this->email = $email;
        // $this->file_url = $file_url;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.scheduledMail',
            with: ['id' => $this->id, 'template' => $this->template],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments()
    {
        // if ($this->file_url) {
        //     foreach ($this->file_url as $file) {
        //         $this->attach(public_path($file));
        //     }
        // }
    }
}
