<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Users;
use \Firebase\JWT\JWT;

class UsuariosController{

    public function add(Request $request, Response $response, $args){


        $body = $request->getParsedBody();

    
                    $user = new Users();
    
                    $user->nombre =$body['nombre'];
                    $user->clave =$body['clave'];
                    $user->tipo_id =$body['tipo'];
                    $user->email =$body['email'];
                    $user->legajo =$body['legajo'];
    
                    $rta = json_encode(array("OK"=>$user->save()));
              

         $response->getBody()->write( $rta);
        
         return $response;//parsea la respuesta completamenta a json

    }

    public function loginUser(Request $request, Response $response, $args){

         $key = "pro3-parcial";

        $body = $request->getParsedBody();
        $user = new Users();

            
            $payload = array(
                "email" => $body['email'],
                "clave" => $body['clave'],  
                "tipo" => $tipo = $user->where('email', $body['email'])->value('tipo_id')            
            );

            $token= JWT::encode($payload, $key);

            $rta = json_encode(array("OK"=>$token));

            $response->getBody()->write($rta);

         return $response;

    }
}



?>