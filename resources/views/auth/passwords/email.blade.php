<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Recuperación de Contraseña</title>
		<script src = "{{url('/js/Toaster.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/FormFieldHandler.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Toast Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Go Back Button/Go Back Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/My Account General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/Password/Password General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/Password/Password Reset Email Request Style.css')}}">
	</head>

	<body>
		@if (session('status'))
			<div class="alert-toast-wrapper-div" id="password-reset-email-request-alert-toast">
				<div class="alert-toast">
					<p class="toast-text">{{ session('status') }}</p>
					<div class="toast-closer" onclick="closeToast('password-reset-email-request-alert-toast')">&#10006;</div>
				</div>
			</div>
		@endif

		<button title="Cancelar y Volver" class="go-back-button" onclick="location.href='/'"></button>

		<h1>Recuperación de Contraseña</h1>

		<form class="input-form" method="POST" action="{{ route('password.email') }}">
			@csrf
			
			<label for="email">Dirección de Correo Electrónico</label>
			<div>
				<input id="email" type="email" class="field {{old('email') ? 'active-field' : 'default-field'}}" name="email" value="{{ old('email') }}" placeholder="ejemplo@mail.com" required autocomplete="email" autofocus onkeypress="activateField(this); enableSubmit('password-reset-email-request-submit')" onclick="activateField(this); enableSubmit('password-reset-email-request-submit')">
				@error('email')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<input type="submit" id="password-reset-email-request-submit" class="submit disabled-submit" disabled="disabled" value="Enviar enlace de recuperación de contraseña">
		</form>
	</body>
</html>
