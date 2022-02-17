<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>{{$user->name}} - Cambiar Contraseña</title>
		<script src = "{{url('/js/URL_Fixer.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/FormFieldHandler.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Page Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Go Back Button/Go Back Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Home Button/Home Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Logout Button/Logout Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Form Elements Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/My Account General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/Password/Password General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/Password/Password Change Style.css')}}">
	</head>

	<body>
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

		<button title="Descartar Cambios y Volver" class="page-button go-back-button" onclick="location.href='/my-account'"></button>
		<button title="Descartar Cambios e Ir al Inicio" class="page-button home-button" onclick="location.href='/'"></button>
		
		<h1>Cambiar mi Contraseña</h1>

		<form class="input-form" method="POST" action=""+url enctype="multipart/form-data">
		@csrf

			<label for="password">Nueva Contraseña</label>
			<div>
				<input id="password" type="password" class="field {{old('password') ? 'active-field' : 'default-field'}}" name="password" placeholder="Contraseña" required autofocus onkeypress="activateField(this); enableSubmitIfAllActive(2, 'password-change-submit')" onclick="activateField(this); enableSubmitIfAllActive(2, 'password-change-submit')">
				@error('password')
					<label class="invalid-feedback" role="alert">
						<strong>La nueva contraseña debe incluir por lo menos:<br>
								* Una letra mayúscula.<br>
								* Una letra minúscula.<br>
								* Un número.<br>
								* Ocho caracteres.<br>
								Además, debe ser validada correspondientemente (ambos campos deben tener el mismo contenido), y no debe haber sido comprometida en ninguna filtración conocida.</strong>
					</label>
				@enderror
			</div>

			<label for="password_confirmation">Confirmar Nueva Contraseña</label>
			<div>
				<input id="password_confirmation" type="password" class="field {{old('password_confirmation') ? 'active-field' : 'default-field'}}" name="password_confirmation" placeholder="Contraseña" required onkeypress="activateField(this); enableSubmitIfAllActive(2, 'password-change-submit')" onclick="activateField(this); enableSubmitIfAllActive(2, 'password-change-submit')">
			</div>

			<input type="submit" id="password-change-submit" class="submit disabled-submit @error('password') send-down-submit @enderror" disabled="disabled" value="Aceptar Cambios">
		</form>		
	</body>
</html>
