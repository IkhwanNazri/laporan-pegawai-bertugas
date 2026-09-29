<?php

namespace App\Mail;

use App\Models\Jadual;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JadualBertugasMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Jadual $jadual
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Jadual Bertugas Baharu',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.jadual-bertugas',
        );
    }
}
