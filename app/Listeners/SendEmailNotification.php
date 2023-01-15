<?php

namespace App\Listeners;

use App\Events\RegisterEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\RegisterMail;
use Mail;

class SendEmailNotification
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
     * Handle the event.
     *
     * @param  \App\Events\RegisterEvent  $event
     * @return void
     */
    public function handle(RegisterEvent $event)
    {
        Mail::to($event->data['email'])->send(new RegisterMail($event->data));
    }
}
