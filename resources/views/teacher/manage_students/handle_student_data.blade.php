<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>{{$studentUser->name}} - Administración</title>
		<script src = "{{url('/js/Toaster.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/URL_Fixer.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/Confirmer.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/FormFieldHandler.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Toast Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Page Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Logout Button/Logout Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Home Button/Home Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Form Elements Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Mission/Mission Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Manager Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Select Element Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Add Numeric Content Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Student Management/Student Management General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Student Management/Handle Student Data Style.css')}}">
	</head>

	<body class="antialiased">
		@if (Session::has('success'))
			<div class="alert-toast-wrapper-div" id="handle-student-data-alert-toast">
				<div class="alert-toast">
					<p class="toast-text">{{ session('success') }}</p>
					<div class="toast-closer" onclick="closeToast('handle-student-data-alert-toast')">&#10006;</div>
				</div>
			</div>
		@endif
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
			var shareURL = removeSectionsOfURL(2);
		</script>

		<button title="Descartar Cambios e Ir al Inicio" class="page-button home-button" onclick="location.href='/'"></button>

		<button title="Asignar una Nueva Misión" class="page-button add-mission-button" onclick="location.href=url + 'add-mission'"></button>
		<button title="Ver el Archivo de {{$studentUser->name}}" class="page-button view-archive-button" onclick="location.href=url + 'view-mission-archive'"></button>
		<button title="Compartir a Otro Docente" class="page-button share-button" onclick="location.href=shareURL + 'share-student/{{$studentUser->name}}'"></button>
		<button title="Eliminar al Alumno" class="page-button deleter-button" onclick="confirmStudentDelete('{{$studentUser->name}}')">&#128465;</button>

		<p id="title-p">{{$studentUser->name}} ({{$studentUser->real_name}})</p>
		<form class="input-form" method="POST" action=""+url enctype="multipart/form-data">
		@csrf

			<div>
				<label for="health">Tiene {{$studentCharacter->health}} de {{$maxStudentHealth}} puntos de salud. ¿Qué le agregamos a este valor?</label>
				<input id="health" type="number" class="field number-field active-field" name="health" value="{{old('health') ? old('health') : 0}}" onkeypress="resizeField(this); enableSubmit('handle-student-data-submit')" onclick="resizeField(this); enableSubmit('handle-student-data-submit')">
				@error('health')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>

			<div>
				<label for="coins">Tiene {{$studentCharacter->coins}} monedas de oro. ¿Qué le agregamos a este valor?</label>
				<input id="coins" type="number" class="field number-field active-field" name="coins" value="{{old('coins') ? old('coins') : 0}}" onkeypress="resizeField(this); enableSubmit('handle-student-data-submit')" onclick="resizeField(this); enableSubmit('handle-student-data-submit')">
				@error('coins')
					<label class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</label>
				@enderror
			</div>
			
			<div>
				<label for="weapon">Arma Equipada:</label>
				<select id="weapon" name="weapon" onchange="enableSubmit('handle-student-data-submit')">
					<option value=null {{null == $studentCharacter->weapon ? 'selected' : ''}}>[Ninguna]</option>
					@foreach ($weaponsForStudentClass as $weapon)
						<option value="{{$weapon->name}}" {{$weapon->name == $studentCharacter->weapon ? 'selected' : ''}}>{{$weapon->name}} (Daño que Añade: {{$weapon->added_damage}}; Costo: {{$weapon->cost}})</option>
					@endforeach
				</select>
			</div>

			<div>
				<label for="item">Ítem Equipado:</label>
				<select id="item" name="item" onchange="enableSubmit('handle-student-data-submit')">
					<option value=null {{null == $studentCharacter->item ? 'selected' : ''}}>[Ninguno]</option>
					@foreach ($itemsForStudentClass as $item)
						<option value="{{$item->name}}" {{$item->name == $studentCharacter->item ? 'selected' : ''}}>{{$item->name}} (Daño que Añade: {{$item->added_damage}}; Salud que Añade: {{$item->added_health}}; Costo: {{$item->cost}})</option>
					@endforeach
				</select>
			</div>

			<div>
				<label for="armor">Armadura Equipada:</label>
				<select id="armor" name="armor" onchange="enableSubmit('handle-student-data-submit')">
					<option value=null {{null == $studentCharacter->armor ? 'selected' : ''}}>[Ninguna]</option>
					@foreach ($armorsForStudentClass as $armor)
						<option value="{{$armor->name}}" {{$armor->name == $studentCharacter->armor ? 'selected' : ''}}>{{$armor->name}} (Salud que Añade: {{$armor->added_health}}; Costo: {{$armor->cost}})</option>
					@endforeach
				</select>
			</div>

			<div>
				<label for="notes_on_student">Mis notas sobre {{$studentUser->name}}:</label>
				<div>
					<textarea id="notes_on_student" type="text" name="notes_on_student" rows="7" onkeypress="enableSubmit('handle-student-data-submit')" onclick="enableSubmit('handle-student-data-submit')">@if($studentNotes != null){{$studentNotes}}@endif</textarea>
					@error('notes_on_student')
						<label class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</label>
					@enderror
				</div>
			</div>
			<input type="submit" id="handle-student-data-submit" class="submit disabled-submit" disabled="disabled" value="Aceptar Cambios">
		</form>

		@foreach ($missions as $mission)
			<div class="mission-div {{$mission->current_health > 0 ? 'active-mission' : 'completed-mission'}}">
				<h2 class="mission-name-h2 {{$mission->current_health > 0 ? 'active-mission-h2' : 'completed-mission-h2'}}">{{$mission->name}}</h2>
			
				<button title="Editar la Misión" class="page-button top-button left-button edit-mission-button" onclick="location.href=url + 'handle-mission/{{$mission->id}}/edit-mission'"></button>
				<button title="Archivar la Misión" class="page-button top-button right-button archive-mission-button" onclick="location.href=url + 'handle-mission/{{$mission->id}}/set-archive/true'"></button>
				
				<hr class="{{$mission->current_health > 0 ? 'active-mission-hr' : 'completed-mission-hr'}}">
				<p>{{$mission->description}}</p>
				<p>
					<b>Fecha de Inicio:</b> {{$mission->start_date}}<br>
					@if ($mission->finish_date != null)
						<b>Fecha de Finalización:</b> {{$mission->finish_date}}
					@else
						La misión aún no ha sido completada.
					@endif
				</p>
				<p>Causa <button class="text-button damage-button" onclick="location.href=url + 'handle-mission/{{$mission->id}}/do-damage'">{{$mission->damage_caused}} @if ($mission->damage_caused == 1) punto @else puntos @endif de daño</button> cada {{$mission->damage_period}}.</p>
				<p><b>Salud de la Misión:</b> {{$mission->current_health}} / {{$mission->max_health}}</p>
				<p>
					<b>@if ($mission->other_rewards != null) Recompensas: @else Recompensa: @endif</b><br>
					<button class="text-button coins-reward-button" onclick="location.href=url + 'handle-mission/{{$mission->id}}/give-coins-reward'">{{$mission->coins_reward}} Monedas de Oro.</button>
					@if ($mission->other_rewards != null)
						<br><span class="rewards-span">{{$mission->other_rewards}}</span>
					@endif
				</p>
			</div>
		@endforeach

		<hr class="space-below-hr">
	</body>
</html>
