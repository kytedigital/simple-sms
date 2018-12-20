<?php
namespace App\Http\Controllers\Api;

use App\Jobs\DispatchMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageDispatchRequest;

class MessageController extends Controller
{
    /**
     * @param MessageDispatchRequest $request
     * @return array
     */
    public function send(MessageDispatchRequest $request)
    {
        foreach ($request->json('channels') as $channel) {

            if(!in_array($channel, $this->availableChannels())) continue;

            DispatchMessage::dispatch($channel,
                $request->json('recipients'),
                $request->json('message'),
                $request->input('shop')
            );

        }

        return ['message' => 'OK'];
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public function availableChannels()
    {
        return config('services.messaging.channels');
    }
}
