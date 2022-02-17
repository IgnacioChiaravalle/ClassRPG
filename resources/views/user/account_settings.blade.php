<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>{{$user->name}} - Mi Cuenta</title>
		<script src = "{{url('/js/URL_Fixer.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/Confirmer.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/FormFieldHandler.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Page Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Go Back Button/Go Back Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Logout Button/Logout Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Form Elements Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/My Account General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/Account Settings Style.css')}}">
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
		
		<button title="Descartar Cambios y Volver" class="page-button go-back-button" onclick="location.href='/'"></button>
		
		<h1>Administrar Mis Datos</h1>
		<form class="input-form" method="POST" action=""+url enctype="multipart/form-data">
		@csrf

			<div>
				<label for="name">Nombre de Usuario</label>
				<div>
					<input id="name" type="name" class="field {{old('name') ? 'active-field' : 'default-field'}}" name="name" value="{{old('name') ? old('name') : $user->name}}" autocomplete="name" onkeypress="activateField(this); enableSubmit('my-account-submit')" onclick="activateField(this); enableSubmit('my-account-submit')">
					@error('name')
						<label class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</label>
					@enderror
				</div>
			</div>

			<div>
				<label for="real_name">Nombre Real</label>
				<div>
					<input id="real_name" type="real_name" class="field {{old('real_name') ? 'active-field' : 'default-field'}}" name="real_name" value="{{old('real_name') ? old('real_name') : $user->real_name}}" autocomplete="real_name" onkeypress="activateField(this); enableSubmit('my-account-submit')" onclick="activateField(this); enableSubmit('my-account-submit')">
					@error('real_name')
						<label class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</label>
					@enderror
				</div>
			</div>

			<div>
				<label for="email">Correo Electrónico</label>
				<div>
					<input id="email" type="email" class="field {{old('email') ? 'active-field' : 'default-field'}}" name="email" value="{{old('email') ? old('email') : $user->email}}" autocomplete="email" onkeypress="activateField(this); enableSubmit('my-account-submit')" onclick="activateField(this); enableSubmit('my-account-submit')">
					@error('email')
						<label class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</label>
					@enderror
				</div>
			</div>

			<input type="submit" id="my-account-submit" class="submit disabled-submit" disabled="disabled" value="Aceptar&#32;&#32;Cambios">
		</form>

		<button id="change-password-button" class="side-button" onclick="location.href='/my-account/change-password'">Cambiar mi Contraseña</button>
		<button id="delete-account-button" class="side-button" onclick="confirmSelfDelete()">Eliminar mi Cuenta</button>

	</body>
</html>
