<?php


use Slim\App;
use App\Middleware\ValidarToken;
use App\Middleware\AfterMiddleware;


return function (App $app) {
    $app->addBodyParsingMiddleware();

    $app->add(new AfterMiddleware()); //se ejecuta despues de ir a la ruta

    
};


?>