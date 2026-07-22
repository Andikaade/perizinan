<?php

namespace App\Mail;

use App\Models\Permohonan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class StatusDisetujuiMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $permohonan;
    protected $namaFile;

    /**
     * Create a new message instance.
     */
    public function __construct(Permohonan $permohonan, $namaFile)
    {
        $this->permohonan = $permohonan;
        $this->namaFile = $namaFile;
    }

    // public function build()
    // {
    //     return $this->subject('Permohonan Perizinan Disetujui - ' . $this->permohonan->no_pengajuan)
    //                 ->view('emails.status_disetujui'); // Sesuaikan dengan nama view email Anda
    // }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Surat Izin Berhasil Diterbitkan - ' . $this->permohonan->no_pengajuan,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.status_disetujui',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $relativePath = 'surat_izin/' . $this->namaFile;

        if (Storage::disk('public')->exists($relativePath)) {
            $fullPath = Storage::disk('public')->path($relativePath);

            return [
                Attachment::fromPath($fullPath)
                    ->as($this->namaFile)
                    ->withMime('application/pdf'),
            ];
        }

        return [];
    }
}
