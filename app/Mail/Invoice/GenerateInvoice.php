<?php

namespace App\Mail\Invoice;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateInvoice extends Mailable
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
        $this->invoice      = Invoice::find($notification_data->related_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('vendor.mail.invoiceGenerated')
            ->with([
            'customer'=>$this->customer,
            'notification'=>$this->notification,
            'lang'=>($this->notification->lang)? $this->notification->lang : 'ar',
            'invoice'=>$this->invoice
        ]);
    }
}
