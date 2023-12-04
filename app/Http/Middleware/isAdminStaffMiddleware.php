<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAdminStaffMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()->role_id == Role::IS_ADMIN || auth()->user()->role_id == Role::IS_STAFF){
            return $next($request);
        }else{

            return response()->json(['message'=>'You are not allowed to this route'],403);
        }



    }
}
