<?php

namespace App\Middleware;

use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

use Firebase\JWT\JWT; 
use Firebase\JWT\Key;

class AuthMiddleware{
    public function __invoke(Request $request, RequestHandler $handler){
        $response = $handler->handle($request); 
        $auth_token = substr($request->getHeader('Authorization')[0], 7);
        
        try {
             JWT::decode($auth_token, new Key($_ENV['JWT_KEY'], 'HS256')); 
             return $response;
        } catch (Exception $e) {
            $response = new Response(); //clear content
            $response->getBody()->write(json_encode([
                'status' =>  '0',
                'msg'   => 'Unauthorized People'
            ]));  //print new content
            return $response->withStatus(401); 
            // ->withHeader('Location', 'https://www.example.com')
        } 
 
       
    }
}