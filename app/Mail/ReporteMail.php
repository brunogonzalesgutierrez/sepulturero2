<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class ReporteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $tipoReporte,
        public string $pdfContenido,
        public string $nombreArchivo,
        public string $mensaje = ''
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reporte: ' . $this->tipoReporte . ' — El Sepulturero Juan',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reporte',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(
                fn () => $this->pdfContenido,
                $this->nombreArchivo
            )->withMime('application/pdf'),
        ];
    }
}