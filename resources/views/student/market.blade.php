<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Mercado</title>
		<script src = "{{url('/js/Confirmer.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Logout Button/Logout Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Go Back Button/Go Back Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/User General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Student/Market Style.css')}}">
	</head>

	<body>
		@if (Session::has('message'))
			<script type="text/javascript">alert("{{ Session::get('message') }}");</script>
		@endif
		@if (Route::has('login'))
			<button title="Cerrar Sesión" class="logout-button" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"></button>
			<form id="logout-form" action="{{ route('logout') }}" method="POST">
				@csrf
			</form>
		@endif

		<button title="Volver" class="go-back-button" onclick="location.href='/'"></button>

		<p id="current-coins-p"><b>Oro Actual:</b> {{$student->coins}} Monedas</p>
		
		@if (isset ($onSaleList))
			<table class="main-table">
				<tr class="table-header-row">
					<td class="table-header-cell">Objeto</td>
					<td class="table-header-cell">Tipo</td>
					<td class="table-header-cell">Daño que Añade</td>
					<td class="table-header-cell">Salud que Añade</td>
					<td class="table-header-cell">Costo</td>
				</tr>

				@foreach ($onSaleList as $sale)
					<tr class="table-inner-row" onclick="confirmPurchase('{{$sale->name}}', '{{$sale->cost}}')">
						<td class="main-table-cell name-cell">{{$sale->name}}</td>
						<td class="main-table-cell {{$sale->type}}-cell">{{$sale->type}}</td>
						@if ($sale->added_damage != null)
							<td class="main-table-cell number-cell">{{$sale->added_damage}}</td>
						@else
							<td class="main-table-cell number-cell">0</td>
						@endif
						@if ($sale->added_health != null)
							<td class="main-table-cell number-cell">{{$sale->added_health}}</td>
						@else
							<td class="main-table-cell number-cell">0</td>
						@endif
						<td class="main-table-cell number-cell">{{$sale->cost}}</td>
					</tr>
				@endforeach
			</table>

		@else
			<p class="no-data-p">¡Aún no artículos para vos disponibles en el mercado! ¡Volvé pronto!</p>
		@endif

		<button id="heal-self-button" onclick="location.href='/market/heal-student/5'"><span class="heal-self-sign">Poción Curativa<br></span><span class="heal-self-cost">Costo: 5 Monedas de Oro</span></button>
		
	</body>
</html>