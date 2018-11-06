<?php
namespace App\Http\Controllers\Api;

use App\Jobs\DispatchMessage;
use App\Services\BurstSms\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageDispatchRequest;

class MessageController extends Controller
{
    /**
     * @param MessageDispatchRequest $request
     * @param Client $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(MessageDispatchRequest $request, Client $client)
    {
        foreach ($request->json('channels') as $channel) {

            DispatchMessage::dispatch($channel,
                $request->json('recipients'),
                $request->json('message'),
                $request->input('shop'));

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
