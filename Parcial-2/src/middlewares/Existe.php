<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use \Firebase\JWT\JWT;
use App\Models\Users;

class Existe
{
    /**
     * Example middleware invokable class
     *
     * @param  ServerRequest  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        
        $response = new Response();

        $body = $request->getParsedBody();
        $user = new Users();

        $existe = $user->where('legajo', $body['legajo'])->where('email',  $body['email'])->exists();

     
       
        
           
        if ($existe) {

            $response->getBody()->write('User repetido');

        } else {
            $existingContent = (string) $response->getBody();
            $response = $handler->handle($request);     
            $response->getBody()->write($existingContent);
        }
        
        return $response;
    }
}


?>