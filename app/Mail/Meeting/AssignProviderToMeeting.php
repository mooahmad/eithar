<?php

namespace App\Mail\Meeting;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AssignProviderToMeeting extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customer,$notification_data)
    {
        $this->customer     = $customer;
        $this->notification = $notification_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('vendor.mail.assignProviderToMeeting')
            ->with([
                'customer'=>$this->customer,
                'notification'=>$this->notification,
                'lang'=>($this->notification->lang)? $this->notification->lang : 'ar',
            ]);
    }
}
