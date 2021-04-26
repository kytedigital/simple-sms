<?php
namespace SMS\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SMS\Events\ReceivedACancelMessage;

class ReceiveController extends Controller
{

    /**
     */
    public function receiveMessage(Request $request)
    {

        Log::useDailyFiles(storage_path().'/logs/messages.log');

        Log::debug(print_r($request->request, true));

        $this->checkMessageForActions($request->request->get('response'));

        var_dump($request->request->get('response'));

    }


    private function checkMessageForActions($message) {
//        event(new ReceivedACancelMessage());

        Log::useDailyFiles(storage_path().'/logs/messages.log');

        Log::debug(print_r('Received: ' . $message, true));

        if(str_contains($message, ['cancel', 'cancelled', 'stop', 'no', 'can\t', 'not coming'])) {
            event(new ReceivedACancelMessage());
        }

    }

}
