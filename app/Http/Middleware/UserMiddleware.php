<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class UserMiddleware
{
    public function handle($request, Closure $next)
    {
      if($request->isMethod('OPTIONS')){
          $response=response('');
      }else{
          $response=$next($request);
      }
      return $response;
    }
}
