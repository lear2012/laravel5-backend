<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvitationCodes extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $codes;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $codes)
    {
        //
        $this->user = $user;
        $this->codes = $codes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_USERNAME'), config('custom.MAIL_FROM'))
            ->subject(config('custom.MEMBER_PAID_MAIL_SUBJECT'))
            ->view('emails.invitation_codes')
            ->with([
                'user' => $this->user,
                'codes' => $this->codes,
            ]);
    }
}
