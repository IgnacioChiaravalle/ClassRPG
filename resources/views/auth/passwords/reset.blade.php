<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Restablecer Contraseña</title>
		<script src = "{{url('/js/FormFieldHandler.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Form Elements Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/My Account General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/Password/Password General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/Password/Password Reset Style.css')}}">
	</head>

	<body>
		<h1>Restablecer mi Contraseña</h1>

		<form class="input-form" method="POST" action="{{ route('password.update') }}">
			@csrf
			<input type="hidden" name="token" value="{{ $token }}">

			<label for="email">Dirección de Correo Electrónico</label>
			<div>
				<input id="email" type="email" class="field {{$email || old('email') ? 'active-field' : 'default-field'}}" name="email" value="{{ $email ?? old('email') }}" placeholder="ejemplo@mail.com" required autocomplete="email" onkeypress="activateField(this); enableSubmitIfAllActive(3, 'password-reset-submit')" onclick="activateField(this); enableSubmitIfAllActive(3, 'password-reset-submit')">
				@error('email')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<label for="password">Nueva Contraseña</label>
			<div>
				<input id="password" type="password" class="field {{old('password') ? 'active-field' : 'default-field'}}" name="password" placeholder="Contraseña" required autocomplete="new-password" autofocus onkeypress="activateField(this); enableSubmitIfAllActive(3, 'password-reset-submit')" onclick="activateField(this); enableSubmitIfAllActive(3, 'password-reset-submit')">
				@error('password')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<label for="password-confirm">Confirmar Nueva Contraseña</label>
			<div>
				<input id="password-confirm" type="password" class="field {{old('password_confirmation') ? 'active-field' : 'default-field'}}" name="password_confirmation" placeholder="Contraseña" required autocomplete="new-password" onkeypress="activateField(this); enableSubmitIfAllActive(3, 'password-reset-submit')" onclick="activateField(this); enableSubmitIfAllActive(3, 'password-reset-submit')">
			</div>

			<input type="submit" id="password-reset-submit" class="submit disabled-submit" disabled="disabled" value="Restablecer Contraseña">
		</form>
	</body>
</html>
