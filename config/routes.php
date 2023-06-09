<?php

use Slim\App;  
use App\Middleware\AuthMiddleware;

return function(App $app){
 
    $app->get('/', \App\Action\HomeAction::class)->add(AuthMiddleware::class); 
    $app->get('/api/login', '\App\Controller\UsersController:LoginAPI'); 

    $app->get('/api/users', '\App\Controller\UsersController:getUsers');
    
    $app->post('/api/createnewuser', 'App\Controller\UsersController:createNewUser');
    $app->post('/api/deleteuser', 'App\Controller\UsersController:deleteUser');

    $app->post('/loginaction', \App\Action\LoginAction::class);
};