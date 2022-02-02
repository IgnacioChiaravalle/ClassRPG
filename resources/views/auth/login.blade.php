<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>ClassRPG</title>
		<script src = "{{url('/js/FormFieldHandler.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/Toaster.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Toast Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Login/Login Style.css')}}">
		<!-- <link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/Password/Password General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/Password/Password Confirm Style.css')}}"> -->
	</head>

	<body>
		@if (Session::has('success'))
			<div class="alert-toast-wrapper-div" id="login-alert-toast">
				<div class="alert-toast">
					<p class="toast-text">{{ session('success') }}</p>
					<div class="toast-closer" onclick="closeToast('login-alert-toast')">&#10006;</div>
				</div>
			</div>
		@endif
		@if (Session::has('message'))
			<script type="text/javascript">alert("{{ Session::get('message') }}");</script>
		@endif

		<h1>ClassRPG</h1>

		<div class="form-and-h2-wrapper-div">
			<h2>Iniciar Sesión</h2>

			<form method="POST" action="{{ route('login') }}">
				@csrf

				<label class="descriptive-label" for="email">Dirección de Correo Electrónico</label>
				<div>
					<input id="email" type="email" class="field {{old('email') ? 'active-field' : 'default-field'}}" name="email" value="{{old('email')}}" placeholder="ejemplo@mail.com" required autocomplete="email" autofocus onkeypress="activateField(this); enableSubmitIfAllActive(2, 'login-submit')" onclick="activateField(this); enableSubmitIfAllActive(2, 'login-submit')">
					@error('email')
						<label class="invalid-feedback-label" role="alert">
							<strong><br>{{ $message }}</strong>
						</label>
					@enderror
				</div>
				
				<label class="descriptive-label" for="password">Contraseña</label>
				<div>
					<input id="password" type="password" class="field {{old('password') ? 'active-field' : 'default-field'}}" name="password" placeholder="Contraseña" required autocomplete="current-password" onkeypress="activateField(this); enableSubmitIfAllActive(2, 'login-submit')" onclick="activateField(this); enableSubmitIfAllActive(2, 'login-submit')">
				</div>

				<div class="form-check">
					<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
					<label class="descriptive-label form-check-label" for="remember">
						Recordar mis datos
					</label>
				</div>
				
				<a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>

				<input type="submit" id="login-submit" class="submit disabled-submit" disabled="disabled" value="INGRESAR">
			</form>
		</div>
	</body>
</html>
