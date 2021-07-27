<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherAuth {
	public function handle($request, Closure $next) {
		$isAuthenticatedTeacher = (Auth::check() && Auth::user()->type == 'teacher');
		if (!$isAuthenticatedTeacher)
			return redirect('/')->with('message', 'Para acceder al sitio solicitado es necesario ingresar como usuario docente.');
		return $next($request);
	}
}