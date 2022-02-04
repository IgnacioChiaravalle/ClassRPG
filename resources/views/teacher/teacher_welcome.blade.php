<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>{{$teacher->name}}</title>
		<script src = "{{url('/js/Toaster.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Toast Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Logout Button/Logout Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/My Account Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Users/Teacher/Teacher Welcome Style.css')}}">
	</head>

	<body>
		@if (Session::has('success'))
			<div class="alert-toast-wrapper-div" id="teacher-welcome-alert-toast">
				<div class="alert-toast">
					<p class="toast-text">{{ session('success') }}</p>
					<div class="toast-closer" onclick="closeToast('teacher-welcome-alert-toast')">&#10006;</div>
				</div>
			</div>
		@endif
		@if (Session::has('message'))
			<script type="text/javascript">alert("{{ Session::get('message') }}");</script>
		@endif

		@if (Route::has('login'))
		<button title="Cerrar Sesión" class="logout-button" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"></button>
			<form id="logout-form" action="{{ route('logout') }}" method="POST">
				@csrf
			</form>
			
			<button title="Administrar los datos de mi cuenta" class="my-account-button" onclick="location.href='/my-account'">
				Mi Cuenta
			</button>
		@endif
		
		<p id="name-p">{{$teacher->name}}</p>
		
		@if (isset ($my_students))
			<p>Mis Alumnos:</p>
			
			<table class="main-table">
				<tr class="table-header-row">
					<td class="table-header-cell">Nombre</td>
					<td class="table-header-cell">Correo Electrónico</td>
					<td class="table-header-cell">Nombre de Usuario</td>
					<td class="table-header-cell">Salud</td>
					<td class="table-header-cell">Oro</td>
				</tr>

				@foreach ($my_students as $studentUser)
					<tr title="Ver detalles del alumno" class="table-inner-row" onclick="location.href='/manage-students/handle-student-data/{{$studentUser->name}}'">
						<td>{{$studentUser->real_name}}</td>
						<td>{{$studentUser->email}}</td>
						<td>{{$studentUser->name}}</td>
						<td>{{$studentUser->current_health}} / {{$studentUser->max_health}}</td>
						<td>{{$studentUser->coins}}</td>
					</tr>
				@endforeach
			</table>
		@else
			<p>¡Aún no tenés alumnos asignados!</p>
		@endif

		<button onclick="location.href='/manage-students/add-student'">Crear un Nuevo Alumno</button>

		@if ($teacher->can_manage_teachers)
			<button onclick="location.href='/manage-teachers'">Ver Docentes Activos</button>
		@endif

		<button onclick="location.href='/manage-market'">Stock del Mercado</button>

		<button onclick="location.href='/manage-classes'">Administrar Clases</button>

	</body>
</html>
