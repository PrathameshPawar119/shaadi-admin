<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Jobs\UserCreatedJob;
use App\Mail\UserCreated as MailUserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class UserCreatedListener  
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
     * @param  \App\Events\UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        // $data = Arr::except($event->user, ['id', 'updated_at', 'created_at']);
        $data = array("name" => $event->user->name, "email" => $event->user->email);
        dispatch(new UserCreatedJob($data));

    } 
}
