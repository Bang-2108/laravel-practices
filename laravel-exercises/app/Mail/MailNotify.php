<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNotify extends Mailable
{
    use Queueable, SerializesModels;

    // Thêm các thuộc tính cần thiết
    public $data;

    // Khởi tạo các tham số
    public function __construct($data)
    {
        $this->data = $data;
    }

    // Xây dựng nội dung email
    public function build()
    {
        return $this->subject('Thông báo từ hệ thống')
                    ->view('emails.verify-email')
                    ->with([
                        'data' => $this->data,
                    ]);
    }
}