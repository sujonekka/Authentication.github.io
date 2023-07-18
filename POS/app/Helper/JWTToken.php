<?php


namespace App\Helper;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class JWTToken{

  public static  function createToken($useremail):string{
        $key = env('JWT_KEY');

        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time()+60*60,
            'useremail' => $useremail 
        ];

       return JWT::encode($payload, $key, 'HS256');
    }


     public static  function createTokenForSetPassword($useremail):string{
        $key = env('JWT_KEY');

        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time()+60*5,//after 5 minute otp expire
            'useremail' => $useremail 
        ];

       return JWT::encode($payload, $key, 'HS256');
    }


  public static  function verifyToken($token):string{

        try{
        $key = env('JWT_KEY');
        $decode = JWT::decode($token, new Key($key,'HS256'));
        return $decode->useremail;
        }
        catch(Exception $e){
            return "Unauthorize";
        }

    }



    





}