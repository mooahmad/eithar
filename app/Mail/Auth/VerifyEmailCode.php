<?php

namespace App\Mail\Auth;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyEmailCode extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('vendor.mail.verifyemail.template')
                    ->with([
                               'customerName'  => $this->user->first_name .' '. $this->user->middle_name . ' ' .$this->user->last_name,
                               'customerCode' => $this->user->email_code,
                               'lang'=>($this->user->default_language == 0) ? 'ar' : 'en',
                           ]);
    }
}
