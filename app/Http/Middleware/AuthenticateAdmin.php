<?php
namespace App\Http\Middleware;

use Closure;
use Route,URL,Auth;

class AuthenticateAdmin {
	
	public function handle($request, Closure $next, $guard = null){
	}
	
}