<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Docentes Activos</title>
		<script src = "{{url('/js/Toaster.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/TextCopier.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Toast Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Go Back Button/Go Back Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Logout Button/Logout Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Checkbox Cursor Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/User General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Reactive Table General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Manager Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Teacher Management/Teacher Management Body Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Teacher Management/Show Teachers Style.css')}}">
	</head>

	<body>
		@if (Session::has('success'))
			<div class="alert-toast-wrapper-div" id="show-teachers-alert-toast">
				<div class="alert-toast">
					<p class="toast-text">{{ session('success') }}</p>
					<div class="toast-closer" onclick="closeToast('show-teachers-alert-toast')">&#10006;</div>
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
		@endif

		<button title="Volver" class="go-back-button" onclick="location.href='/'"></button>

		<p id="name-p">Docentes Activos</p>

		<div class="page-container-div">
			<div id="parent-component">
				<teacher-table ref="teacherTable"></teacher-table>
			</div>
			<script src = "{{asset('/js/app.js')}}" defer></script>

			<button class="manager-button" onclick="location.href='/manage-teachers/add-teacher'">Crear un Nuevo Docente</button>
		</div>
	</body>
</html>