<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>{{$student->name}}</title>
		<script src = "{{url('/js/Toaster.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/URL_Fixer.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/Confirmer.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Toast Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Page Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/My Account/My Account Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Table Page General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Mission/Mission Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Student/Student Welcome Style.css')}}">
	</head>
	
	<body>
		@if (Session::has('success'))
			<div class="alert-toast-wrapper-div" id="student-welcome-alert-toast">
				<div class="alert-toast">
					<p class="toast-text">{{ session('success') }}</p>
					<div class="toast-closer" onclick="closeToast('student-welcome-alert-toast')">&#10006;</div>
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
			
			<button title="Administrar los datos de mi cuenta" class="my-account-button" onclick="location.href='/my-account'">
				Mi Cuenta
			</button>
		@endif
		
		<p id="name-p">{{$student->name}} - {{$student->rpg_class}}</p>
		
		<div class="page-container-div">
			<table class="main-table">
				<tr class="table-header-row">
					<td class="table-header-cell" id="inventory-tag-cell">INVENTARIO</td>
					<td class="table-header-cell">Daño</td>
					<td class="table-header-cell">Salud</td>
					<td class="table-header-cell">Oro</td>
				</tr>
				
				<tr>
					<td class="main-table-cell" id="inner-table-container">
						<table id="inner-table">
							<tr>
								<td class="inner-table-cell-with-border">
									<b>Arma:</b>
									@if ($student->weapon != null)
										{{$student->weapon}}
									@else
										Ninguna
									@endif
								</td>
								<td class="inner-table-cell-with-border"><b>Daño Añadido:</b> {{$weapon_damage}}</td>
							</tr>
							<tr>
								<td class="inner-table-cell-with-border">
									<b>Ítem:</b>
									@if ($student->item != null)
										{{$student->item}}
									@else
										Ninguno
									@endif
								</td>
								<td class="inner-table-cell-with-border"><b>Daño Añadido:</b> {{$item_damage}}<br><b>Salud Añadida:</b> {{$item_health}}</td>
							</tr>
							<tr>
								<td>
									<b>Armadura:</b>
									@if ($student->armor != null)
										{{$student->armor}}
									@else
										Ninguna
									@endif
								</td>
								<td><b>Salud Añadida:</b> {{$armor_health}}</td>
							</tr>
						</table>
					</td>
					<td class="main-table-cell">{{$damage}}</td>
					<td class="main-table-cell">{{$student->health}} / {{$max_health}}</td>
					<td class="main-table-cell">{{$student->coins}}</td>
				</tr>
			</table>

			<button id="market-button" onclick="location.href='/market'">Ir al Mercado</button>

			@foreach ($missions as $mission)
				<div class="mission-div {{$mission->current_health > 0 ? 'active-mission' : 'completed-mission'}}">
					<h2 class="mission-name-h2 {{$mission->current_health > 0 ? 'active-mission-h2' : 'completed-mission-h2'}}">{{$mission->name}}</h2>
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
					<p>Causa {{$mission->damage_caused}} @if ($mission->damage_caused == 1) punto @else puntos @endif de daño cada {{$mission->damage_period}}.</p>
					<p><b>Salud de la Misión:</b> {{$mission->current_health}} / {{$mission->max_health}}</p>
					<p>
						<b>@if ($mission->other_rewards != null) Recompensas: @else Recompensa: @endif</b><br>
						<span class="rewards-span">{{$mission->coins_reward}} Monedas de Oro.</span>
						@if ($mission->other_rewards != null)
							<br><span class="rewards-span">{{$mission->other_rewards}}</span>
						@endif
					</p>
					@if ($mission->current_health > 0)
						<button class="text-button damage-button attack-button" onclick="confirmMissionAttack('{{$student->health}}', '{{$mission->id}}', '{{$mission->name}}')">¡Atacar!</button>
					@endif
				</div>
			@endforeach
		</div>
		
	</body>
</html>
