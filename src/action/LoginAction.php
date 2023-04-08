<?php 

namespace App\Action;

use App\Db\DB;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
 

class LoginAction
{
    public function __invoke(Request $request, Response $response)
    {
        $body = $request->getParsedBody();

        $result = "select * from tbl_users where user_username=:user_username";
        $result = DB::query($result, ['user_username' => $body['user_username']]);
        $response->getBody()->write(json_encode($result));
       
        return $response;
        } 
   
}
