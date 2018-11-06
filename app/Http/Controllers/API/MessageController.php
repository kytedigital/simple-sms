<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageDispatchRequest;
use App\Jobs\DispatchMessage;
use App\Models\Message;
use App\Services\BurstSms\Client;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * @param MessageDispatchRequest $request
     * @param Client $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(MessageDispatchRequest $request, Client $client)
    {
        $input = (object) json_decode($request->getContent(), true);

        $message = new Message([
            'recipients' => $input->recipients,
            'message' => $input->message
        ]);

        // Chain jobs so that if the first fails the second
        // next dispatch.
        foreach ($input->channels as $channel) {
            DispatchMessage::dispatch($channel, $message, $request->input('shop'));
        }

        return response()->json(['message' => 'OK']);
    }

    /**
     * @param $message
     */
    private function messageEvent($message)
    {
        $message['channel'] = 'sms';
        $message['recipients'] = $message['to'];

        event('message.sent', ['message' => $message]);
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public function availableChannels()
    {
        return config('services.messaging.channels');
    }

}
