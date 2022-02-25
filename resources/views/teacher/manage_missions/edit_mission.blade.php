<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Editar Misión</title>
		<script src = "{{url('/js/URL_Fixer.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/FormFieldHandler.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Page Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Form Elements Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Add Numeric Content Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Student Management/Student Management General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Student Management/Manage Mission Style.css')}}">
	</head>

	<body class="antialiased">
		@if (Session::has('message'))
			<script type="text/javascript">alert("{{ Session::get('message') }}");</script>
		@endif

		@if (Route::has('login'))
			<button title="Cerrar Sesión" class="page-button logout-button" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"></button>
			<form id="logout-form" action="{{ route('logout') }}" method="POST">
				@csrf
			</form>
		@endif

		<script>
			var url = removeSectionsOfURL(0);
			var returnURL = removeSectionsOfURL(3);
		</script>

		<button title="Descartar Cambios y Volver" class="page-button go-back-button" onclick="location.href=returnURL"></button>
		<button title="Descartar Cambios e Ir al Inicio" class="page-button home-button" onclick="location.href='/'"></button>
		
		<p id="title-p">Editar la Misión</p>
		<form class="input-form" method="POST" action=""+url enctype="multipart/form-data">
		@csrf

			<label for="name">Nombre:</label>
			<div>
				<input id="name" type="text" class="field text-field {{old('name') ? 'active-field' : 'default-field'}}" name="name" value="{{old('name') ? old('name') : $mission->name}}" placeholder="Nombre de la Misión" required autocomplete="name" onkeypress="activateField(this); enableSubmit('edit-mission-submit')" onclick="activateField(this); enableSubmit('edit-mission-submit')">
				@error('name')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<label for="description">Descripción:</label>
			<div>
				<textarea id="description" class="{{!old('description') ? 'default-field' : ''}}" name="description" rows="4" value="{{old('description') ? old('description') : $mission->description}}" required autocomplete="description" onkeypress="activateField(this); enableSubmit('edit-mission-submit')" onclick="activateField(this); enableSubmit('edit-mission-submit')">{{$mission->description}}</textarea>
				@error('description')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<div>
				<label for="damage_caused">Daño que Causa:</label>
				<input id="damage_caused" type="number" class="field number-field {{old('damage_caused') ? 'active-field' : 'default-field'}}" name="damage_caused" value="{{old('damage_caused') ? old('damage_caused') : $mission->damage_caused}}" required autocomplete="damage_caused" onkeypress="activateField(this); resizeField(this); enableSubmit('edit-mission-submit')" onclick="activateField(this); resizeField(this); enableSubmit('edit-mission-submit')">
				@error('damage_caused')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<label for="damage_period">Causa daño cada...</label>
			<div>
				<input id="damage_period" type="text" class="field text-field {{old('damage_period') ? 'active-field' : 'default-field'}}" name="damage_period" value="{{old('damage_period') ? old('damage_period') : $mission->damage_period}}" placeholder="¿Cuánto tiempo?" required autocomplete="damage_period" onkeypress="activateField(this); enableSubmit('edit-mission-submit')" onclick="activateField(this); enableSubmit('edit-mission-submit')">
				@error('damage_period')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<div>
				<label for="max_health">Salud Máxima:</label>
				<input id="max_health" type="number" class="field number-field {{old('max_health') ? 'active-field' : 'default-field'}}" name="max_health" value="{{old('max_health') ? old('max_health') : $mission->max_health}}" required autocomplete="max_health" onkeypress="activateField(this); resizeField(this); enableSubmit('edit-mission-submit')" onclick="activateField(this); resizeField(this); enableSubmit('edit-mission-submit')">
				@error('max_health')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<div>
				<label for="current_health">Salud Actual:</label>
				<input id="current_health" type="number" class="field number-field {{old('current_health') ? 'active-field' : 'default-field'}}" name="current_health" value="{{old('current_health') ? old('current_health') : $mission->current_health}}" required autocomplete="current_health" onkeypress="activateField(this); resizeField(this); enableSubmit('edit-mission-submit')" onclick="activateField(this); resizeField(this); enableSubmit('edit-mission-submit')">
				@error('current_health')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<div>
				<label for="coins_reward">Recompensa en Monedas de Oro:</label>
				<input id="coins_reward" type="number" class="field number-field {{old('coins_reward') ? 'active-field' : 'default-field'}}" name="coins_reward" value="{{old('coins_reward') ? old('coins_reward') : $mission->coins_reward}}" required autocomplete="coins_reward" onkeypress="activateField(this); resizeField(this); enableSubmit('edit-mission-submit')" onclick="activateField(this); resizeField(this); enableSubmit('edit-mission-submit')">
				@error('coins_reward')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<label for="other_rewards">Otras Recompensas:</label>
			<div>
				<input id="other_rewards" type="text" class="field text-field {{old('other_rewards') ? 'active-field' : 'default-field'}}" name="other_rewards" value="{{old('other_rewards') ? old('other_rewards') : $mission->other_rewards}}" placeholder="(Opcional)" onkeypress="activateField(this); enableSubmit('edit-mission-submit')" onclick="activateField(this); enableSubmit('edit-mission-submit')">
				@error('other_rewards')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<input type="submit" id="edit-mission-submit" class="submit disabled-submit" disabled="disabled" value="Aceptar Cambios">
		</form>
	</body>
</html>
