<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $message ='';

        try{

            JWTAuth::parseToken()->authenticate();
            return $next($request);

        }catch(\Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
            $message = 'Token expired';

        }catch(\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
            $message ='Invalid Token';

        }catch(\Tymon\JWTAuth\Exceptions\JWTException $e){
            $message = 'Provide Token ';
            
        }
        return response()->json([
            'success' =>false,
            'message' =>$message
        ]);
      
    }
}
