<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuenMatKhauMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ma_otp;
    public $ho_va_ten;

    /**
     * Create a new message instance.
     */
    public function __construct($ma_otp, $ho_va_ten)
    {
        $this->ma_otp = $ma_otp;
        $this->ho_va_ten = $ho_va_ten;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mã Xác Nhận Quên Mật Khẩu',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.quen_mat_khau',
        );
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
