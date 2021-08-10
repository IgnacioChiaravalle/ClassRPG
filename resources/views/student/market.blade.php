<!doctype html>
<html>
<head>

	<meta charset="utf-8">
	<title>Mercado</title>
	<script src = "{{url('/js/Confirmer.js')}}" type = "text/javascript"></script>
	
</head>
<body>

	@if (Session::has('message'))
		<script type="text/javascript">alert("{{ Session::get('message') }}");</script>
	@endif

	<p>Tu Oro: {{$student->coins}}</p>
	
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
				<tr onclick="confirmPurchase('{{$sale->name}}', '{{$sale->cost}}')">
					<td>{{$sale->name}}</td>
					<td>{{$sale->type}}</td>
					@if ($sale->added_damage != null)
						<td>{{$sale->added_damage}}</td>
					@else
						<td>0</td>
					@endif
					@if ($sale->added_health != null)
						<td>{{$sale->added_health}}</td>
					@else
						<td>0</td>
					@endif
					<td>{{$sale->cost}}</td>
				</tr>
			@endforeach
		</table>

	@else
		<p>¡Aún no artículos para vos disponibles en el mercado! ¡Volvé pronto!</p>
	@endif


	<button onclick="location.href='/market/heal-student/5'">Curar Salud (Costo: 5 Monedas de Oro)</button>
	<button onclick="location.href='/'">Volver</button>

</body>
</html>