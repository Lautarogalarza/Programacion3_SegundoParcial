<?php

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UsuariosController;
use App\Controllers\MateriasController;
use App\Controllers\InscriptosController;
use App\Middleware\ValidarToken;
use App\Middleware\ValidarAdmin;
use App\Middleware\ValidarEntrada;
use App\Middleware\Existe;
use App\Middleware\ValidarEntradaToken;
use App\Middleware\ValidarEntradaMateria;

return function($app){//forma ordenada de tener las utas
  

    $app->group('/materias', function (RouteCollectorProxy $group) {
        $group->post('[/]', MateriasController::class . ':add')->add(ValidarEntradaMateria::class)->add(ValidarAdmin::class);
        $group->get('/{id}', MateriasController::class . ':TraerMaterias');
        $group->put('/{id}/{profesor}', MateriasController::class . ':addProfesor');
        $group->put('/{id}', InscriptosController::class . ':addInscripto');
        $group->get('[/]', MateriasController::class . ':addrrr');

     });

     $app->post('/usuario', UsuariosController::class . ':add')->add(Existe::class)->add(ValidarEntrada::class);
     $app->post('/login', UsuariosController::class . ':loginUser')->add(ValidarEntradaToken::class);


};

?>