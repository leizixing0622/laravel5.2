<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use Closure;

class Permission{
	
	protected $except = [
		'/index'
	];
	
	public function handle($request, Closure $next){
		if(){
			
		}
	}
	
}