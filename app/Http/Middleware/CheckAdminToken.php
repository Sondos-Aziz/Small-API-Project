<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckAdminToken
{
    use GeneralTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user =null;
        try{
            $user = JWTAuth::parseToken()->authenticate();
        }catch(\Exception $e){
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                //  return response()->json(['success' => false, 'msg' => 'INVALID_TOKEN'],200);
                 return $this->returnError('E3001','INVALID_TOKEN');
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->returnError('E3001','EXPIRED_TOKEN');
              }else{
                return $this->returnError('E3001','TOKEN_NOTFOUND');
              }
        }catch(\Throwable $e){
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                 return $this->returnError('E3001','INVALID_TOKEN');
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->returnError('E3001','EXPIRED_TOKEN');
              }else {
                return $this->returnError('E3001','TOKEN_NOTFOUND');
              }
        }
    if(!$user)
       return  $this-> returnError('001','Unauthenticated');
    
        return $next($request);
    }
}