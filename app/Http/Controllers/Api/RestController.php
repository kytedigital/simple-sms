<?php

namespace App\Http\Controllers\Api;

use App\Http\State;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

abstract class RestController extends Controller implements RestControllerInterface
{
    /**
     * @var
     */
    protected $repository;

    /**
     * @var
     */
    protected $state;

    /**
     * Fetch all items at the resource endpoint.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function browse(Request $request) : JsonResponse
    {
        $results = ['items' => $this->up($request)->repository->browse($this->state)];

        return response()->json(array_merge((array) $this->state, $results));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request) : JsonResponse
    {
        $results = ['items' => $this->up($request)->repository->search($this->state)];

        return response()->json(array_merge((array) $this->state, $results));
    }

    /**
     * Fetch a single item from the resource endpoint.
     *
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function read($id, Request $request) : JsonResponse
    {
        $response = [
            // 'previous' => $this->repository->getPreviousRecordId($id),
            // 'next'     => $this->repository->getNextRecordId($id),
            'item'     => $this->up($request)->repository->read($id)
        ];

        return response()->json($response);
    }

    /**
     * Prep state.
     *
     * @param Request $request
     * @return ShopifyRestController
     */
    protected function up(Request $request) : RestController
    {
        $this->state = new State($request);

        return $this;
    }
}
