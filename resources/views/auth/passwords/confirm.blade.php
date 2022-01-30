<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Confirmar Contraseña</title>
		<script src = "{{url('/js/FormFieldHandler.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Go Back Button/Go Back Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/My Account General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/Password Confirm Style.css')}}">
	</head>

	<body>
		<button title="Volver" class="go-back-button" onclick="location.href='/my-account'"></button>

		<h1>Confirmar Contraseña</h1>

		<form class="input-form" method="POST" action="{{route('password.confirm')}}">
			@csrf

			<label for="password">Por favor, ingresá tu contraseña actual para continuar.</label>
			<div>
				<input id="password" type="password" class="field {{old('password') ? 'active-field' : 'default-field'}} @error('password') is-invalid @enderror" name="password" placeholder="Contraseña" required autocomplete="current-password" onkeypress="activateField(this); enableSubmit('password-confirm-submit')" onclick="activateField(this); enableSubmit('password-confirm-submit')">
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
