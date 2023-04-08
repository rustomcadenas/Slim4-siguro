<?php 

namespace App\Action;

use App\Db\DB;
use Firebase\JWT\JWT; 
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
 

class LoginAction
{
    public function __invoke(Request $request, Response $response)
    {
        $body = $request->getParsedBody();

        $result = "select * from tbl_users where user_username=:user_username";
        $result = DB::query($result, ['user_username' => $body['user_username']]);

        if ($result['count'] == 1 && password_verify($body['user_userpass'], $result['result'][0]['user_userpass'])){
            unset($result['result'][0]['user_userpass']);
            unset($result['result'][0][5]);
            $payload = [
                'iat' => time(),
                'exp' => time()+86400, //60sec*60mins*24h = 1day
                'data' => [
                    "user_id" => $result['result'][0]['user_id']                
                ]
            ];
            $jwt = JWT::encode($payload, $_ENV['JWT_KEY'], 'HS256'); 
            $response->getBody()->write(json_encode([
                'status' => '1',
                'token' => $jwt,
                'data'  => $result['result']
            ]));
        }else{
            $response->getBody()->write(json_encode([ 
                "status" => '0',
                "msg" => "Username or Password is incorrect."
            ]));
        }  
        return $response;
    }
}
