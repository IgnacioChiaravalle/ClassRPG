<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Confirmar Contraseña</title>
		<script src = "{{url('/js/FormFieldHandler.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Page Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Go Back Button/Go Back Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Home Button/Home Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Logout Button/Logout Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Form Elements Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/My Account General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/Password/Password General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/Password/Password Confirm Style.css')}}">
	</head>

	<body>
		@if (Route::has('login'))
			<button title="Cerrar Sesión" class="page-button logout-button" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"></button>
			<form id="logout-form" action="{{ route('logout') }}" method="POST">
				@csrf
			</form>
		@endif

		<button title="Cancelar y Volver" class="page-button go-back-button" onclick="location.href='/my-account'"></button>
		<button title="Cancelar e Ir al Inicio" class="page-button home-button" onclick="location.href='/'"></button>

		<h1>Confirmar Contraseña</h1>

		<form class="input-form" method="POST" action="{{route('password.confirm')}}">
			@csrf

			<label for="password">Por favor, ingresá tu contraseña actual para continuar.</label>
			<div>
				<input id="password" type="password" class="field {{old('password') ? 'active-field' : 'default-field'}}" name="password" placeholder="Contraseña" required autocomplete="current-password" autofocus onkeypress="activateField(this); enableSubmit('password-confirm-submit')" onclick="activateField(this); enableSubmit('password-confirm-submit')">
				@error('password')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<input type="submit" id="password-confirm-submit" class="submit disabled-submit" disabled="disabled" value="Confirmar&#32;&#32;Contraseña">
			
			@if (Route::has('password.request'))
				<a href="{{route('password.request')}}">¿Olvidaste tu contraseña?</a>
			@endif
		</form>
	</body>
</html>
