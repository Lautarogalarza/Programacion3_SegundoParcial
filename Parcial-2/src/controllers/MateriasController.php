<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Materias;
use App\Models\Inscriptos;
use \Firebase\JWT\JWT;

class MateriasController{



    public function add(Request $request, Response $response, $args){

    
                    $materia = new Materias();
                    $body = $request->getParsedBody();
    
                    $materia->materia =$body['materia'];
                    $materia->cuatrimestre =$body['cuatrimestre'];
                    $materia->vacantes =$body['vacantes'];
                    $materia->profesor_id =$body['profesor'];

                    $rta = json_encode(array("OK"=>$materia->save()));
              

         $response->getBody()->write( $rta);
        
         return $response;//parsea la respuesta completamenta a json

    }

    public function addProfesor(Request $request, Response $response , array $args){


        $body = $request->getParsedBody();

    
                    $materias = new Materias();



                  $materia= $materias->find($args["id"]);

                  if ($materia!=null) {
                    $materia->profesor_id =$args["profesor"];

                    $rta = json_encode(array("OK"=>$materia->save()));
                  }
                  else {
                    $rta = json_encode(array("ERROR"=>"La materia no existe"));
                  }
    
        

         $response->getBody()->write( $rta);
        
         return $response;//parsea la respuesta completamenta a json

    }

    public function TraerMaterias(Request $request, Response $response , array $args){

        $materia = new Materias();
        $inscripto = new Inscriptos();
        $idMateria = $args['id'];

        $headers = getallheaders();
        $token = $headers['token'] ?? '';
         $key = "pro3-parcial";
        try {
            $payload = JWT::decode($token, $key, array('HS256'));
        } catch (\Throwable $th) {
            $msg = "Error: " .$th->getMessage();
        }

        if($payload->tipo == 1) {
            $materia = $materia->find($idMateria)->join('users','profesor_id','=','users.id')->select('materia','cuatrimestre','vacantes','users.nombre')->get();$success = true;
    
            $rta = json_encode(array("Materia"=> $materia));

        } else {
            $materia = $materia->find($idMateria)->join('users','profesor_id','=','users.id')->select('materia','cuatrimestre','vacantes','users.nombre')->get();
            $inscripto = $inscripto->where('materia_id','=',$idMateria)->join('users','alumno_id','=','users.id')->select('users.email','users.nombre','users.legajo')->get();
    


            $rta = json_encode(array("Materia"=> $materia, "Inscriptos"=> $inscripto));
        }


        $rtaJson = json_encode($rta);
        $response->getBody()->write($rtaJson);
    
        return $response;

    }

}


?>