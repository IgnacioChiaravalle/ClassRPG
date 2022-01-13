<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Editar Misión</title>
		<script src = "{{url('/js/URL_Fixer.js')}}" type = "text/javascript"></script>

		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

		<!-- Styles -->
		<style>
			/*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}}
		</style>

		<style>
			body {
				font-family: 'Nunito', sans-serif;
			}
		</style>
	</head>

	<body class="antialiased">
		@if (Session::has('message'))
			<script type="text/javascript">alert("{{ Session::get('message') }}");</script>
		@endif

		<script>
			var url = removeSectionsOfURL(0);
			var returnURL = removeSectionsOfURL(3);
		</script>
		
		<p>Editar la Misión</p>
		<form method="POST" action=""+url enctype="multipart/form-data">
		@csrf

			<div>
				<label for="name">Nombre:</label>
				<div>
					<input id="name" type="text" class="{{old('name') ? 'active-field' : 'default-field'}}" name="name" value="{{old('name') ? old('name') : $mission->name}}" required autocomplete="name"> <!-- onkeypress="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" onclick="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" -->
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
					<textarea id="description" type="text" class="{{old('description') ? 'active-field' : 'default-field'}}" name="description" value="{{old('description') ? old('description') : $mission->description}}" required autocomplete="description">{{$mission->description}}</textarea> <!-- onkeypress="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" onclick="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" -->
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
					<input id="damage_caused" type="number" class="{{old('damage_caused') ? 'active-field' : 'default-field'}}" name="damage_caused" value="{{old('damage_caused') ? old('damage_caused') : $mission->damage_caused}}" required autocomplete="damage_caused"> <!-- onkeypress="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" onclick="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" -->
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
					<input id="damage_period" type="text" class="{{old('damage_period') ? 'active-field' : 'default-field'}}" name="damage_period" value="{{old('damage_period') ? old('damage_period') : $mission->damage_period}}" required autocomplete="damage_period"> <!-- onkeypress="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" onclick="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" -->
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
					<input id="max_health" type="number" class="{{old('max_health') ? 'active-field' : 'default-field'}}" name="max_health" value="{{old('max_health') ? old('max_health') : $mission->max_health}}" required autocomplete="max_health"> <!-- onkeypress="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" onclick="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" -->
					@error('max_health')
						<label class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</label>
					@enderror
				</div>
			</div>

			<div>
				<label for="current_health">Salud Actual:</label>
				<div>
					<input id="current_health" type="number" class="{{old('current_health') ? 'active-field' : 'default-field'}}" name="current_health" value="{{old('current_health') ? old('current_health') : $mission->current_health}}" required autocomplete="current_health"> <!-- onkeypress="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" onclick="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" -->
					@error('current_health')
						<label class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</label>
					@enderror
				</div>
			</div>

			<div>
				<label for="coins_reward">Recompensa en Monedas de Oro:</label>
				<div>
					<input id="coins_reward" type="number" class="{{old('coins_reward') ? 'active-field' : 'default-field'}}" name="coins_reward" value="{{old('coins_reward') ? old('coins_reward') : $mission->coins_reward}}" required autocomplete="coins_reward"> <!-- onkeypress="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" onclick="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" -->
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
					<input id="other_rewards" type="text" class="{{old('other_rewards') ? 'active-field' : 'default-field'}}" name="other_rewards" value="{{old('other_rewards') ? old('other_rewards') : $mission->other_rewards}}"> <!-- onkeypress="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" onclick="clearFieldIfDefault(this); activateField(this); checkAllActive(7, 'submit-btn-addgame')" -->
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
