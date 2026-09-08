<?php
namespace BusinessUsers\Middleware;

use CakeDC\Users\Utility\UsersUrl;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class BeforeLoginMiddleware implements MiddlewareInterface
{
    /**
     * Before login middleware process method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Server\RequestHandlerInterface $handler The request handler.
     * @return \Psr\Http\Message\ResponseInterface A response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!(new UsersUrl())->checkActionOnRequest('login', $request)) {
            return $handler->handle($request);
        }

        if (!$request->getAttribute('session')->read('Auth')) {
            // do something before login, for example log the login attempt
        }

        return $handler->handle($request);
    }

}