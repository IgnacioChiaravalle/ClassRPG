<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Clases de los Alumnos</title>
		<script src = "{{url('/js/Toaster.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/FormFieldHandler.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Toast Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Page Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Home Button/Home Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Logout Button/Logout Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Form Elements Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Table Page General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Reactive Table General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Manager Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Classes Management/Classes Management General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Classes Management/Classes Manager Style.css')}}">
	</head>

	<body class="antialiased">
		@if (Session::has('success'))
			<div class="alert-toast-wrapper-div" id="rpg-classes-manager-alert-toast">
				<div class="alert-toast">
					<p class="toast-text">{{ session('success') }}</p>
					<div class="toast-closer" onclick="closeToast('rpg-classes-manager-alert-toast')">&#10006;</div>
				</div>
			</div>
		@endif
		@if (Session::has('message'))
			<script type="text/javascript">alert("{{ Session::get('message') }}");</script>
		@endif

		@if (Route::has('login'))
			<button title="Cerrar Sesión" class="page-button logout-button" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"></button>
			<form id="logout-form" action="{{ route('logout') }}" method="POST">
				@csrf
			</form>
		@endif

		<button title="Ir al Inicio" class="page-button home-button" onclick="location.href='/'"></button>

		<p id="name-p">Clases del Sistema</p>

		<div class="page-container-div">
			<div id="parent-component">
				<rpg-classes-table csrf="{{csrf_token()}}" ref="classMarketTable"></rpg-classes-table>
			</div>
			<script src = "{{asset('/js/app.js')}}" defer></script>

			<button class="manager-button" onclick="location.href='/manage-classes/add-class'">Crear una Nueva Clase</button>
		</div>
		
	</body>
</html>
