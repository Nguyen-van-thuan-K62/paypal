<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp; // Khai báo biến otp

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($otp)
    {
        // Gán giá trị mã OTP cho biến $otp
        $this->otp = $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Xác định tiêu đề email và view của email
        return $this->subject('Your OTP Code')
                    ->view('auth.otp');
    }
}
