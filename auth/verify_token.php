<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require "../vendor/autoload.php";
require "../config/jwt.php";

$headers = getallheaders();

if(!isset($headers['Authorization'])){
http_response_code(401);
exit("Token requerido");
}

$token = str_replace("Bearer ","",$headers['Authorization']);

try{

$decoded = JWT::decode($token,new Key($jwt_secret,'HS256'));

}catch(Exception $e){

http_response_code(401);
exit("Token inválido");

}