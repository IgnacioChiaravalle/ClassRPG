<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Crear Alumno</title>
		<script src = "{{url('/js/URL_Fixer.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/FormFieldHandler.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Go Back Button/Go Back Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Student Creation/Add Student Style.css')}}">
	</head>

	<body class="antialiased">
		@if (Session::has('message'))
			<script type="text/javascript">alert("{{ Session::get('message') }}");</script>
		@endif
		
		<script> var url = removeSectionsOfURL(0); </script>

		<button title="Descartar Cambios y Volver" class="go-back-button" onclick="location.href='/'"></button>

		<h1>Crear un Nuevo Alumno</h1>
		<form class="input-form" method="POST" action=""+url enctype="multipart/form-data">
		@csrf

			<label for="real_name">Nombre Real:</label>
			<div>
				<input id="real_name" type="text" class="field {{old('real_name') ? 'active-field' : 'default-field'}}" name="real_name" value="{{old('real_name')}}" placeholder="Nombre Real" required autocomplete="real_name" autofocus onkeypress="activateField(this); enableSubmitIfAllActive(3, 'add-student-submit')" onclick="activateField(this); enableSubmitIfAllActive(3, 'add-student-submit')">
				@error('real_name')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<label for="name">Nombre de Usuario:</label>
			<div>
				<input id="name" type="text" class="field {{old('name') ? 'active-field' : 'default-field'}}" name="name" value="{{old('name')}}" placeholder="Nombre de Usuario" required autocomplete="name" onkeypress="activateField(this); enableSubmitIfAllActive(3, 'add-student-submit')" onclick="activateField(this); enableSubmitIfAllActive(3, 'add-student-submit')">
				@error('name')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			
			<label for="email">Correo Electrónico:</label>
			<div>
				<input id="email" type="email" class="field {{old('email') ? 'active-field' : 'default-field'}}" name="email" value="{{old('email')}}" placeholder="ejemplo@mail.com" required autocomplete="email" onkeypress="activateField(this); enableSubmitIfAllActive(3, 'add-student-submit')" onclick="activateField(this); enableSubmitIfAllActive(3, 'add-student-submit')">
				@error('email')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<label for="rpg_class">Clase del Personaje:</label>
			<select id="rpg_class" name="rpg_class">
				@foreach ($classes as $class)
					<option value="{{$class->name}}">{{$class->name}} (Daño: {{$class->base_damage}}; Salud: {{$class->base_health}})</option>
				@endforeach
			</select>


			<div></div>
			<label for="notes_on_student">¿Alguna nota o comentario que agregar?</label>
			<div>
				<textarea id="notes_on_student" type="text" name="notes_on_student" rows="7" value="{{old('notes_on_student')}}"></textarea>
				@error('notes_on_student')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>
		
			<input type="submit" id="add-student-submit" class="submit disabled-submit" disabled="disabled" value="Aceptar">
		</form>		
	</body>
</html>
