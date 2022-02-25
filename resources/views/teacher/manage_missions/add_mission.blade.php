<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Crear Misión</title>
		<script src = "{{url('/js/URL_Fixer.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/FormFieldHandler.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Page Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Form Elements Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Mission/Mission Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Manager Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Select Element Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Add Numeric Content Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Student Management/Student Management General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Student Management/Handle Student Data Style.css')}}">
	</head>

	<body class="antialiased">
		@if (Session::has('message'))
			<script type="text/javascript">alert("{{ Session::get('message') }}");</script>
		@endif

		<script>
			var url = removeSectionsOfURL(0);
			var returnURL = removeSectionsOfURL(1);
		</script>
		
		<p>Crear una Nueva Misión para {{$studentName}}</p>
		<form method="POST" action=""+url enctype="multipart/form-data">
		@csrf

			<div>
				<label for="name">Nombre:</label>
				<div>
					<input id="name" type="text" class="{{old('name') ? 'active-field' : 'default-field'}}" name="name" value="{{old('name')}}" placeholder="Nombre de la Misión" required autocomplete="name"> <!-- onkeypress="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" onclick="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" -->
					@error('name')
						<label class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</label>
					@enderror
				</div>
			</div>

			<div>
				<label for="description">Descripción:</label>
				<div>
					<textarea id="description" type="text" class="{{old('description') ? 'active-field' : 'default-field'}}" name="description" value="{{old('description')}}" required autocomplete="description"></textarea> <!-- onkeypress="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" onclick="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" -->
					@error('description')
						<label class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</label>
					@enderror
				</div>
			</div>

			<div>
				<label for="damage_caused">Daño que Causa:</label>
				<div>
					<input id="damage_caused" type="number" class="{{old('damage_caused') ? 'active-field' : 'default-field'}}" name="damage_caused" value="{{old('damage_caused') ? old('damage_caused') : 0}}" required autocomplete="damage_caused"> <!-- onkeypress="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" onclick="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" -->
					@error('damage_caused')
						<label class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</label>
					@enderror
				</div>
			</div>

			<div>
				<label for="damage_period">Causa daño cada...</label>
				<div>
					<input id="damage_period" type="text" class="{{old('damage_period') ? 'active-field' : 'default-field'}}" name="damage_period" value="{{old('damage_period')}}" required autocomplete="damage_period"> <!-- onkeypress="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" onclick="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" -->
					@error('damage_period')
						<label class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</label>
					@enderror
				</div>
			</div>

			<div>
				<label for="max_health">Salud Máxima:</label>
				<div>
					<input id="max_health" type="number" class="{{old('max_health') ? 'active-field' : 'default-field'}}" name="max_health" value="{{old('max_health') ? old('max_health') : 0}}" required autocomplete="max_health"> <!-- onkeypress="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" onclick="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" -->
					@error('max_health')
						<label class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</label>
					@enderror
				</div>
			</div>

			<div>
				<label for="coins_reward">Recompensa en Monedas de Oro:</label>
				<div>
					<input id="coins_reward" type="number" class="{{old('coins_reward') ? 'active-field' : 'default-field'}}" name="coins_reward" value="{{old('coins_reward') ? old('coins_reward') : 0}}" required autocomplete="coins_reward"> <!-- onkeypress="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" onclick="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" -->
					@error('coins_reward')
						<label class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</label>
					@enderror
				</div>
			</div>

			<div>
				<label for="other_rewards">Otras Recompensas:</label>
				<div>
					<input id="other_rewards" type="text" class="{{old('other_rewards') ? 'active-field' : 'default-field'}}" name="other_rewards" value="{{old('other_rewards')}}"> <!-- onkeypress="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" onclick="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" -->
					@error('other_rewards')
						<label class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</label>
					@enderror
				</div>
			</div>

			<input type="submit" value="Aceptar">
		</form>

		<button onclick="location.href=returnURL">Descartar Cambios y Volver</button>
	</body>
</html>
