<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class AddInvoiceDb extends Notification
{
    use Queueable;
    private $invoice;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the notification's to the database.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable){
        return [
            'id' => $this->invoice->id,
            'title'=> 'تم اضافة فاتورة جديدة بواسطة:',
            'user'=>Auth::user()->name,

        ];
    }


}
