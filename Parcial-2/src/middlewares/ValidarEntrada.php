<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use \Firebase\JWT\JWT;
use App\Models\Users;

class ValidarEntrada
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

        $user = new Users();

        $body = $request->getParsedBody();

        if (isset($body['nombre'])&& isset($body['clave'])&& isset($body['tipo']) && isset($body['legajo']) && isset($body['email']) ) {

            if ($body['legajo']>=1000 && $body['legajo']<=1999 ) {

                if ($body['tipo']==3 || $body['tipo']==2 || $body['tipo']==1) {
    
                    $existingContent = (string) $response->getBody();
                    $response = $handler->handle($request);     
                    $response->getBody()->write($existingContent);
                }
                else {
                    $response->getBody()->write('Datos erroneos"');
                }
                }
                
            else {
                $response->getBody()->write('Datos erroneos"');
            }

        }
        else {
            $response->getBody()->write('Datos erroneos"');
        }
 
        return $response;
    }
}


?>