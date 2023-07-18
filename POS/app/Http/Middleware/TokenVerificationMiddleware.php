<?php

namespace App\Http\Middleware;

use App\Helper\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $req, Closure $next): Response
    {

       $token =  $req->header('token');

       $result = JWTToken::verifyToken($token);

       if($result === "Unauthorize"){ //JWTToken a verifyToken function er catch block return theke aseche

        return response()->json([
                'status' => 'failed',
                'message' => 'Unauthorize'
            ],status:401);

       }else{

            $req->headers->set('email', $result);
           return $next($req);
       }

    }
}
