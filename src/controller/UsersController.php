<?php

namespace App\Controller;

use App\Db\DB;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
 

class UsersController{ 

    public function getUsers(Request $request, Response $response){ 
        $result = "select * from tbl_users";
        $result = DB::query($result); 
        $response->getBody()->write(json_encode($result));
        return $response; 
    }

    public function createNewUser(Request $request, Response $response){ 
        $data = $request->getParsedBody();
        $data['user_userpass'] = password_hash($data['user_userpass'], PASSWORD_DEFAULT);
        $result = "Insert into tbl_users(user_firstname, user_middlename, user_lastname, user_username, user_userpass, user_status) 
        values(:user_firstname, :user_middlename, :user_lastname, :user_username, :user_userpass, :user_status)";
        $result = DB::query($result, $data);
        $response->getBody()->write(json_encode($result));
        return $response;         
    }

    // public function updateUser(Request $request, Response $response){
        
    // }
    public function deleteUser(Request $request, Response $response){
        $data = $request->getParsedBody();

        $result = "delete from tbl_users where user_id=:user_id";
        $result = DB::query($result, $data);

        $response->getBody()->write(json_encode($result));
        return $response;
    }
} 
       
