<?php

namespace App\Listeners;

use App\Models\MessageLog;
use Illuminate\Support\Facades\Log;
use App\Events\MessageDispatchCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageDispatchCompletedEventListener implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param MessageDispatchCompleted $event
     * @return void
     */
    public function handle(MessageDispatchCompleted $event)
    {
        $this->logMessage($event);
    }

    /**
     * @param $event
     */
    private function logMessage($event)
    {
        $log = (array) $event->message;
        $log['status'] = $event->response->status;
        $log['shop'] = $event->shop;
        $log['channel'] = $event->channel;
        $log['recipients'] = $log['recipient']['phone'];
        $log['responseMessage'] = json_encode($event->response->body);
        $log['sendCount'] = 1;

        unset($log['recipient']);

        (new MessageLog($log))->save();
    }
}
