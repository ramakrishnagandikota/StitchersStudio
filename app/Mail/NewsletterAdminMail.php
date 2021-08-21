<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsletterAdminMail extends Mailable
{
    use Queueable, SerializesModels;
    public  $details1;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details1)
    {
        $this->details1 = $details1;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('smtp-user@knitfitco.com','Knit Fit')->subject('Newsletter sign up')->view('Mail.Adminnewsletter');
    }
}
