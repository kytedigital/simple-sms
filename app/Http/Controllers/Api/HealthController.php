<?php
namespace Dlapi\Http\Controllers;

use App\Http\Controllers\Controller;

class HealthController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHeartBeat()
    {
        return response()->json([
            "status" => "Heartbeat OK",
            "modules" => [
                "msapi" => 200,
            ]
        ]);
    }
}
