<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MoiThamGiaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ten_phong;
    public $ma_phong;
    public $ten_nguoi_moi;
    public $ho_va_ten_nguoi_nhan;

    public function __construct($ten_phong, $ma_phong, $ten_nguoi_moi, $ho_va_ten_nguoi_nhan)
    {
        $this->ten_phong            = $ten_phong;
        $this->ma_phong             = $ma_phong;
        $this->ten_nguoi_moi        = $ten_nguoi_moi;
        $this->ho_va_ten_nguoi_nhan = $ho_va_ten_nguoi_nhan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📅 Bạn được mời tham gia cuộc họp: ' . $this->ten_phong,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.moi_tham_gia',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
