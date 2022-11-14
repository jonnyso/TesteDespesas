<?php

namespace App\Listeners;

class RenewBearerTokenExpiration
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $event->token->expires_at = now()->addMinutes(config('sanctum.expiration'));
        $event->token->save();
    }
}
