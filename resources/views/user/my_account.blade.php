<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>{{$user->name}} - Mi Cuenta</title>
		<script src = "{{url('/js/URL_Fixer.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/Confirmer.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/My Account Style.css')}}">
	</head>

	<body class="antialiased">
		@if (Session::has('message'))
			<script type="text/javascript">alert("{{ Session::get('message') }}");</script>
		@endif

		<script> var url = removeSectionsOfURL(0); </script>
		
		<p>Administrar Mis Datos</p>
		<form method="POST" action=""+url enctype="multipart/form-data">
		@csrf

			<div>
				<label for="name">Nombre de Usuario</label>
				<div>
					<input id="name" type="name" class="{{old('name') ? 'active-field' : 'default-field'}}" name="name" value="{{old('name') ? old('name') : $user->name}}" autocomplete="name"> <!-- onkeypress="clearFieldIfDefault(this); activateField(this); checkAllActive(2, 'submit-btn-editgame')" onclick="clearFieldIfDefault(this); activateField(this); checkAllActive(2, 'submit-btn-editgame')" -->
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
					<input id="real_name" type="real_name" class="{{old('real_name') ? 'active-field' : 'default-field'}}" name="real_name" value="{{old('real_name') ? old('real_name') : $user->real_name}}" autocomplete="real_name"> <!-- onkeypress="clearFieldIfDefault(this); activateField(this); checkAllActive(2, 'submit-btn-editgame')" onclick="clearFieldIfDefault(this); activateField(this); checkAllActive(2, 'submit-btn-editgame')" -->
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
					<input id="email" type="email" class="{{old('email') ? 'active-field' : 'default-field'}}" name="email" value="{{old('email') ? old('email') : $user->email}}" autocomplete="email"> <!-- onkeypress="clearFieldIfDefault(this); activateField(this); checkAllActive(2, 'submit-btn-editgame')" onclick="clearFieldIfDefault(this); activateField(this); checkAllActive(2, 'submit-btn-editgame')" -->
					@error('email')
						<label class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</label>
					@enderror
				</div>
			</div>

			<input type="submit" value="Aceptar Cambios">
		</form>

		<button onclick="location.href='/my-account/change-password'">Cambiar Contraseña</button>
		<button onclick="confirmSelfDelete()">Eliminar mi Cuenta</button>

		<button onclick="location.href='/'">Descartar Cambios y Volver</button>
	</body>
</html>
