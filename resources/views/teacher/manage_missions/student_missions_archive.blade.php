<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>{{$studentName}} - Archivo</title>
		<script src = "{{url('/js/Toaster.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/URL_Fixer.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/Confirmer.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Toast Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Page Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Mission/Mission Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Table Page General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Student Management/Student Management General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Student Management/Student Archive Style.css')}}">
	</head>

	<body class="antialiased">
		@if (Session::has('success'))
			<div class="alert-toast-wrapper-div" id="student-archive-alert-toast">
				<div class="alert-toast">
					<p class="toast-text">{{ session('success') }}</p>
					<div class="toast-closer" onclick="closeToast('student-archive-alert-toast')">&#10006;</div>
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
		
		<script> var studentDataURL = removeSectionsOfURL(1); </script>

		<button title="Volver" class="page-button go-back-button" onclick="location.href=studentDataURL"></button>
		<button title="Ir al Inicio" class="page-button home-button" onclick="location.href='/'"></button>

		<p id="title-p">Archivo de {{$studentName}}</p>

		@if (isset ($missions))
			@foreach ($missions as $mission)
				<div class="mission-div {{$mission->current_health > 0 ? 'active-mission' : 'completed-mission'}}">
					<h2 class="mission-name-h2 {{$mission->current_health > 0 ? 'active-mission-h2' : 'completed-mission-h2'}}">{{$mission->name}}</h2>

					<button title="Eliminar la Misión" class="page-button top-button left-button delete-mission-button" onclick="confirmMissionDelete('{{$mission->id}}', '{{$mission->name}}')"></button>
					<button title="Desarchivar la Misión" class="page-button top-button right-button unarchive-mission-button" onclick="location.href=studentDataURL + 'handle-mission/{{$mission->id}}/set-archive/false'"></button>

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
					<p>Causa {{$mission->damage_caused}} puntos de daño cada {{$mission->damage_period}}.</p>
					<p><b>Salud de la Misión:</b> {{$mission->current_health}} / {{$mission->max_health}}</p>
					<p>
						<b>@if ($mission->other_rewards != null) Recompensas: @else Recompensa: @endif</b><br>
						<span class="rewards-span">{{$mission->coins_reward}} Monedas de Oro.</span>
						@if ($mission->other_rewards != null)
							<br><span class="rewards-span">{{$mission->other_rewards}}</span>
						@endif
					</p>
				</div>
			@endforeach
		@else
			<p class="no-data-p">¡No hay misiones en este archivo!</p>
		@endif
	</body>
</html>
