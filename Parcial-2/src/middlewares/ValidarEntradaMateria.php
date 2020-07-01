<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use \Firebase\JWT\JWT;
use App\Models\Materias;

class ValidarEntradaMateria
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

        $user = new Materias();

        $body = $request->getParsedBody();

        if (isset($body['materia'])&& isset($body['cuatrimestre'])&& isset($body['vacantes']) && isset($body['profesor'])) {

 
                   $existingContent = (string) $response->getBody();
                    $response = $handler->handle($request);     
                    $response->getBody()->write($existingContent);
            
        }
        else {
            $response->getBody()->write('Datos erroneos"');
        }
 
        return $response;
    }
}


?>