<?php

namespace App\Listeners;

use App\Models\MessageLog;
use App\Jobs\MarkCustomerOptOut;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Bus\Dispatcher;
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
        $this->checkForOptOuts($event);
    }

    /**
     * @param $event
     */
    private function checkForOptOuts($event)
    {
        Log::debug('MessageDispatchCompletedEventListener Response Log');
        Log::debug(json_encode($event->response));
        if($event->response->status === 500 &&
            $event->response->message->reason === "Number has opted-out") {
            app(Dispatcher::class)->dispatch(new MarkCustomerOptOut($event->shop, $event->message->recipient));
        }
    }

    /**
     * @param $event
     */
    private function logMessage($event)
    {
        Log::debug('Number of Messages');
        Log::debug(json_encode($event->response->numberOfMessages));
        $log = (array) $event->message;

        var_dump('logg', $log);
        $log['status'] = $event->response->status;
        $log['shop'] = $event->shop;
        $log['channel'] = $event->channel;
        $log['recipients'] = $log['recipient']['phone'];
        $log['responseMessage'] = json_encode($event->response->body);
        $log['sendCount'] = $event->response->numberOfMessages;
       // $log['cost'] = isset($responseBody->cost) ? $responseBody->cost : 0;

        unset($log['recipient']);

        (new MessageLog($log))->save();
    }
}
