<?php

namespace App\Listeners;

use App\Events\newProductMail;
use App\Mail\productMailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class sendProductMail
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
     * @param  \App\Events\newProductMail  $event
     * @return void
     */
    public function handle(newProductMail $event)
    {
        Mail::to(Auth::user()->email)->send(new productMailable($event->product));
    }
}
