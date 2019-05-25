<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class HealthController extends Controller
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return ['status' => Response::HTTP_OK];
    }
}
