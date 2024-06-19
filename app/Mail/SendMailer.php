<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMailer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public $name, public $email, public $type, public $ticket)
    {
        $this->name = $name;
        $this->email = $email;
        $this->type = $type;
        $this->ticket = $ticket;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), env('APP_NAME')),
            subject: 'Send Mailer',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if ($this->type == "done") {
            return new Content(
                markdown: 'user.mail.mailer',
                with: [
                    'name' => $this->name,
                    'email' => $this->email,
                    'type' => $this->type,
                    'ticket' => $this->ticket
                ]
            );
        } elseif ($this->type == "failure") {
            return new Content(
                markdown: 'user.mail.mailer2',
                with: [
                    'name' => $this->name,
                    'email' => $this->email,
                    'type' => $this->type,
                    'ticket' => $this->ticket
                ]
            );
        }
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
