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
    public $email_content;
    public $file_url;
    /**
     * Create a new message instance.
     */
    public function __construct($email_content,$file_url)
    {

        $this->email_content = $email_content;
        $this->file_url = $file_url;
        // dd($this->email_content);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // from: new Address('jeffrey@example.com', 'Jeffrey Way'),
            subject: $this->email_content[0],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // dd($this->template);
        return new Content(
            view: 'mail.mail',
            with: ['template' => $this->email_content[1], 'email'=>$this->email_content[2]],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments()
    {
        // return [
            if($this->file_url){
                foreach($this->file_url as $file){
                    $this->attach(public_path($file));
                }
            }
            
        // ];
    }
}
