<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAuth {
	public function handle($request, Closure $next) {
		$isAuthenticatedStudent = (Auth::check() && Auth::user()->type == 'student');
		if (!$isAuthenticatedStudent)
			return redirect('/')->with('message', 'Para acceder al sitio solicitado es necesario ingresar como usuario estudiante.');
		return $next($request);
	}
}