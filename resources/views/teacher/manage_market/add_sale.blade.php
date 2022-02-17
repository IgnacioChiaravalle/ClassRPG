<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Crear Artículo</title>
		<script src = "{{url('/js/FormFieldHandler.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/URL_Fixer.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Page Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Go Back Button/Go Back Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Form Elements Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Checkbox Cursor Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Select Element Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Market Management/Market Management General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Market Management/Add Sale Style.css')}}">
	</head>

	<body class="antialiased">
		@if (Session::has('message'))
			<script type="text/javascript">alert("{{ Session::get('message') }}");</script>
		@endif

		<script> var url = removeSectionsOfURL(0); </script>
		
		<button title="Descartar Cambios y Volver" class="page-button go-back-button" onclick="location.href='/manage-market/{{$rpgClass}}'"></button>

		<p class="title-p">Crear un Nuevo Artículo</p>
		<form class="input-form" method="POST" action=""+url enctype="multipart/form-data">
		@csrf

			<div>
				<label for="name">Nombre:</label>
				<div>
					<input id="name" type="text" class="field text-field {{old('name') ? 'active-field' : 'default-field'}}" name="name" value="{{old('name')}}" placeholder="Nombre del Artículo" required autocomplete="name" autofocus onkeypress="activateField(this); enableSubmit('add-sale-submit')" onclick="activateField(this); enableSubmit('add-sale-submit')">
					@error('name')
						<label class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</label>
					@enderror
				</div>
			</div>

			<div>
				<label for="type">Tipo:</label>
				<select id="type" name="type" value="{{old('type') ? old('type') : 'Item'}}" onchange="updateEnabledFields(this); resizeManyFields(['added_damage', 'added_health', 'cost'])">
					<option value="Item">Ítem</option>
					<option value="Weapon">Arma</option>
					<option value="Armor">Armadura</option>
				</select>
			</div>

			<div>
				<label for="added_damage">Daño que Añade:</label>
				<input id="added_damage" type="number" class="field number-field active-field" name="added_damage" value="{{old('added_damage') ? old('added_damage') : 0}}" autocomplete="added_damage" onkeypress="resizeField(this)" onclick="resizeField(this)">
				@error('added_damage')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<div>
				<label for="added_health">Salud que Añade:</label>
				<input id="added_health" type="number" class="field number-field active-field" name="added_health" value="{{old('added_health') ? old('added_health') : 0}}" autocomplete="added_health" onkeypress="resizeField(this)" onclick="resizeField(this)">
				@error('added_health')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<div>
				<label for="cost">Costo:</label>
				<input id="cost" type="number" class="field number-field active-field" name="cost" value="{{old('cost') ? old('cost') : 0}}" autocomplete="cost" onkeypress="resizeField(this)" onclick="resizeField(this)">
				@error('cost')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>
			
			<div>
				<label class="checkbox-label" for="marketable">¿Estará a la Venta?</label>
				<input id="marketable" type="checkbox" class="checkbox" name="marketable" value="marketable">
			</div>

			<input type="submit" id="add-sale-submit" class="submit disabled-submit" disabled="disabled" value="Aceptar">
		</form>
	</body>
</html>
