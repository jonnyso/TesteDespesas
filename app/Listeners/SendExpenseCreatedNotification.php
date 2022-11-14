<?php

namespace App\Listeners;

use App\Notifications\ExpenseCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendExpenseCreatedNotification
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $event->expense->owner
            ->notify(new ExpenseCreated($event->expense));
    }
}
