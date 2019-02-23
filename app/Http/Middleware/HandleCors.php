<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Events\Dispatcher;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Http\Events\RequestHandled;

class HandleCors
{
    /** @var Dispatcher $events */
    protected $events;

    public function __construct(Dispatcher $events)
    {
        $this->events = $events;
    }

    /**
     * Handle an incoming request. Based on Asm89\Stack\Cors by asm89
     * @see https://github.com/asm89/stack-cors/blob/master/src/Asm89/Stack/Cors.php
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Add the headers on the Request Handled event as fallback in case of exceptions
        if (class_exists(RequestHandled::class)) {
            $this->events->listen(RequestHandled::class, function (RequestHandled $event) {
                $this->addHeaders($event->response);
            });
        } else {
            $this->events->listen('kernel.handled', function (Response $response) {
                $this->addHeaders($response);
            });
        }

        $response = $next($request);

        return $this->addHeaders($response);
    }

    /**
     * @param Response $response
     * @return Response
     */
    protected function addHeaders(Response $response)
    {
        // Prevent double checking
        if (! $response->headers->has('Access-Control-Allow-Origin')) {
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS, HEAD');
            $response->headers->set('Access-Control-Allow-Headers', 'Authorization, Content-Type, Accept, X-CSRF-TOKEN, X-Requested-With');
        }

        return $response;
    }
}