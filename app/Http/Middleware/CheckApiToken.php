<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Customer;

class CheckApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Authorization');
        if($header){
            $explode = explode('Bearer ',$header);
            $check = Customer::where('token',$explode[1])->first();
            if($check){
                return $next($request);
            }
            else{
                return apiResponse(false, 'Invalid Token', [], 401);
            }
        }
        
        return apiResponse(false, 'Request Fail!', [], 500);
    }
}
