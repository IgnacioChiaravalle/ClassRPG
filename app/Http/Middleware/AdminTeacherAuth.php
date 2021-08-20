<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;

class AdminTeacherAuth {
	public function handle($request, Closure $next) {
		$isAuthenticatedTeacher = (Auth::check() && Auth::user()->type == 'teacher');
		if (!$isAuthenticatedTeacher)
			return redirect('/')->with('message', 'Para acceder al sitio solicitado es necesario ingresar como usuario docente.');
		$canManageTeachers = (Teacher::where('name', Auth::user()->name)->first())->can_manage_teachers;
		if (!$canManageTeachers)
			return redirect('/')->with('message', 'Usted no tiene permiso para administrar a otros docentes.');
		return $next($request);
	}
}