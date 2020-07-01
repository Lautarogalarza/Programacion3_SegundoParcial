<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Materias;
use App\Models\Inscriptos;
use App\Models\Users;
use \Firebase\JWT\JWT;

class InscriptosController{


    public function addInscripto(Request $request, Response $response , array $args){



        $headers = getallheaders();
        $token = $headers['token'] ?? '';
         $key = "pro3-parcial";   ;
        try {
            $decoded = JWT::decode($token, $key, array('HS256'));
        } catch (\Throwable $th) {
            $decoded= null;
          }

          if ( $decoded->tipo==1) {
              
              $materias = new Materias();
              $inscripto = new Inscriptos();
              $alumno = new Users();
    
    
    
            $materia= $materias->find($args["id"]);
    
    
    
            if ($materia!=null) {

               if(  $materia->vacantes>0)
                {

                    $materia->vacantes = $materia->vacantes-1;
                    $inscripto->materia_id =$args["id"];
                    $inscripto->alumno_id =$alumno->where('email', $decoded->email)->value("id");
                    $materia->save();
                    
          
                    $rta = json_encode(array("OK"=>$inscripto->save()));
                }
                else {
                    $rta = json_encode(array("ERROR"=>"Vacantes ocupadas"));
                }
            
            }
            else {
              $rta = json_encode(array("ERROR"=>"La materia no existe"));
            }
          }
          else {
            $rta = json_encode(array("ERROR"=>"user erroneo(solo alumno)"));
          }


         $response->getBody()->write( $rta);
        
         return $response;//parsea la respuesta completamenta a json

    }

}


?>