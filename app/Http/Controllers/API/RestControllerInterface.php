<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

interface RestControllerInterface
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function browse(Request $request) : \Illuminate\Http\JsonResponse;

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function read($id) : \Illuminate\Http\JsonResponse;
}