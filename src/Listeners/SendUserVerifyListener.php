<?php

namespace EbayIntegration\EbayLaravel\Listeners;

use Illuminate\Support\Facades\Mail;
use EbayIntegration\EbayLaravel\Events\UserVerifyEvent;
use EbayIntegration\EbayLaravel\Mail\UserVerifyEmail;

class SendUserVerifyListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Send the user a link so we can verify the email.
     *
     * @param UserVerifyEvent $event
     *
     * @return void
     */
    public function handle(UserVerifyEvent $event)
    {
        Mail::to($event->user)->send(new UserVerifyEmail($event->user));
    }
}
