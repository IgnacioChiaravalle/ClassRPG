<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Crear Clase</title>
		<script src = "{{url('/js/URL_Fixer.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/FormFieldHandler.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Page Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Go Back Button/Go Back Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Home Button/Home Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Logout Button/Logout Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Form Elements Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Add Numeric Content Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Classes Management/Classes Management General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Classes Management/Add Class Style.css')}}">
	</head>

	<body class="antialiased">
		@if (Session::has('message'))
			<script type="text/javascript">alert("{{ Session::get('message') }}");</script>
		@endif
		
		@if (Route::has('login'))
			<button title="Cerrar Sesión" class="page-button logout-button" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"></button>
			<form id="logout-form" action="{{ route('logout') }}" method="POST">
				@csrf
			</form>
		@endif

		<script> var url = removeSectionsOfURL(0); </script>

		<button title="Descartar Cambios y Volver" class="page-button go-back-button" onclick="location.href='/manage-classes'"></button>
		<button title="Descartar Cambios e Ir al Inicio" class="page-button home-button" onclick="location.href='/'"></button>

		<p id="name-p">Crear un Nuevo Artículo</p>
		<form class="input-form" method="POST" action=""+url enctype="multipart/form-data">
		@csrf

			<label for="name">Nombre:</label>
			<div>
				<input id="name" type="text" class="field text-field default-field" name="name" value="{{old('name')}}" placeholder="Nombre de la Clase" required autocomplete="name" autofocus onkeypress="activateField(this); enableSubmit('add-class-submit')" onclick="activateField(this); enableSubmit('add-class-submit')">
				@error('name')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<div>
				<label for="base_damage">Daño Base:</label>
				<input id="base_damage" type="number" class="field number-field active-field" name="base_damage" value="{{old('base_damage') ? old('base_damage') : 0}}" required autocomplete="base_damage" onkeypress="resizeField(this)" onclick="resizeField(this)">
				@error('base_damage')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<div>
				<label for="base_health">Salud Base:</label>
				<input id="base_health" type="number" class="field number-field active-field" name="base_health" value="{{old('base_health') ? old('base_health') : 0}}" required autocomplete="base_health" onkeypress="resizeField(this)" onclick="resizeField(this)">
				@error('base_health')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<input type="submit" id="add-class-submit" class="submit disabled-submit" disabled="disabled" value="Aceptar">
		</form>
	</body>
</html>
