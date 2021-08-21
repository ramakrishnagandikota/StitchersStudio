<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Auth;
use Carbon\Carbon;

class SupportTicketResolve extends Notification
{
    use Queueable;

    public $support;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($support)
    {
        $this->support = $support;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->from('smtp-user@knitfitco.com','Stitchers Studio')->subject('Traditional Pattern Review')->view(
            'Mail.SupportTicketResolve', ['support' => $this->support]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'support' => $this->support,
            'sentBy' => 'Stitchers Studio',
            'sentTime' => Carbon::now()
        ];
    }
}
