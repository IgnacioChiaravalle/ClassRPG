<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Crear Docente</title>
		<script src = "{{url('/js/URL_Fixer.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/FormFieldHandler.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Page Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Go Back Button/Go Back Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Form Elements Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Checkbox Cursor Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Add User General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Teacher Management/Teacher Management Body Style.css')}}">
	</head>

	<body>
		@if (Session::has('message'))
			<script type="text/javascript">alert("{{ Session::get('message') }}");</script>
		@endif
		
		<script> var url = removeSectionsOfURL(0); </script>

		<button title="Descartar Cambios y Volver" class="page-button go-back-button" onclick="location.href='/manage-teachers'"></button>

		<h1>Crear un Nuevo Docente</h1>
		<form class="input-form" method="POST" action=""+url enctype="multipart/form-data">
		@csrf

			<label for="real_name">Nombre Real:</label>
			<div>
				<input id="real_name" type="text" class="field {{old('real_name') ? 'active-field' : 'default-field'}}" name="real_name" value="{{old('real_name')}}" placeholder="Nombre Real" required autocomplete="real_name" autofocus onkeypress="activateField(this); enableSubmitIfAllActive(3, 'add-teacher-submit')" onclick="activateField(this); enableSubmitIfAllActive(3, 'add-teacher-submit')">
				@error('real_name')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<label for="name">Nombre de Usuario:</label>
			<div>
				<input id="name" type="text" class="field {{old('name') ? 'active-field' : 'default-field'}}" name="name" value="{{old('name')}}" placeholder="Nombre de Usuario" required autocomplete="name" onkeypress="activateField(this); enableSubmitIfAllActive(3, 'add-teacher-submit')" onclick="activateField(this); enableSubmitIfAllActive(3, 'add-teacher-submit')">
				@error('name')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<label for="email">Correo Electrónico:</label>
			<div>
				<input id="email" type="email" class="field {{old('email') ? 'active-field' : 'default-field'}}" name="email" value="{{old('email')}}" placeholder="ejemplo@mail.com" required autocomplete="email" onkeypress="activateField(this); enableSubmitIfAllActive(3, 'add-teacher-submit')" onclick="activateField(this); enableSubmitIfAllActive(3, 'add-teacher-submit')">
				@error('email')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<div>
				<label for="can_manage_teachers" class="checkbox-label">¿Puede Administrar Docentes?</label>
				<input id="can_manage_teachers" type="checkbox" class="checkbox" name="can_manage_teachers">
			</div>

			<input type="submit" id="add-teacher-submit" class="submit disabled-submit" disabled="disabled" value="Aceptar">
		</form>
	</body>
</html>
