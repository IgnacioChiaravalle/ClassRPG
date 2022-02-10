<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>{{$teacher->name}}</title>
		<script src = "{{url('/js/Toaster.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/TextCopier.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Toast Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Logout Button/Logout Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/My Account Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/User General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Teacher Welcome Style.css')}}">
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
		
		<div class="page-container-div">
			@if (isset ($my_students))
				<p id="my-students-p">Mis Alumnos:</p>
				
				<table class="main-table">
					<tr class="table-header-row">
						<td class="table-header-cell">Nombre</td>
						<td class="table-header-cell">Nombre de Usuario</td>
						<td class="table-header-cell">Salud</td>
						<td class="table-header-cell">Oro</td>
						<td class="table-header-cell">Correo Electrónico</td>
					</tr>

					@foreach ($my_students as $studentUser)
						<tr class="table-inner-row">
							<td class="main-table-cell" onclick="location.href='/manage-students/handle-student-data/{{$studentUser->name}}'" title="Ver detalles del alumno">{{$studentUser->real_name}}</td>
							<td class="main-table-cell" onclick="location.href='/manage-students/handle-student-data/{{$studentUser->name}}'" title="Ver detalles del alumno">{{$studentUser->name}}</td>
							<td class="main-table-cell" onclick="location.href='/manage-students/handle-student-data/{{$studentUser->name}}'" title="Ver detalles del alumno">{{$studentUser->current_health}} / {{$studentUser->max_health}}</td>
							<td class="main-table-cell" onclick="location.href='/manage-students/handle-student-data/{{$studentUser->name}}'" title="Ver detalles del alumno">{{$studentUser->coins}}</td>
							<td class="main-table-cell email-cell" onclick="copyToClipboard('{{$studentUser->email}}', 'Correo electrónico')" title="Copiar correo electrónico">{{$studentUser->email}}</td>
						</tr>
					@endforeach
				</table>
			@else
				<p class="no-data-p">¡Aún no tenés alumnos asignados!</p>
			@endif
		</div>

		<div class="@if (!isset ($my_students)) send-down-div @endif">
			<div class="user-manager-buttons-div">
				<button class="manager-button @if (!$teacher->can_manage_teachers) centered-button @endif" onclick="location.href='/manage-students/add-student'">Crear un Nuevo Alumno</button>
				@if ($teacher->can_manage_teachers)
					<button class="manager-button" onclick="location.href='/manage-teachers'">Ver Docentes Activos</button>
				@endif
			</div>

			<div class="game-manager-buttons-div">
				<button class="manager-button" onclick="location.href='/manage-market'">Stock del Mercado</button>
				<button class="manager-button" onclick="location.href='/manage-classes'">Administrar Clases</button>
			</div>
		</div>
	</body>
</html>
