<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use \Firebase\JWT\JWT;
use App\Models\Users;

class ValidarEntradaToken
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
        if (isset($body['email']) && isset($body['clave'])) {

        $existe = $user->where('email', $body['email'])->where('clave',  $body['clave'])->exists();


        if ($existe) {

            $existingContent = (string) $response->getBody();
            $response = $handler->handle($request);     
            $response->getBody()->write($existingContent);

        } else {

            $response->getBody()->write('El user No existe');
        }

        }
        else {

            $response->getBody()->write('Datos Erroneos');
        }


            
        
        return $response;
    }
}


?>