<!doctype html>
<html>
<head>

	<meta charset="utf-8">
	<title>Mercado</title>
	
</head>
<body>

	@if (Session::has('message'))
		<script type="text/javascript">alert("{{ Session::get('message') }}");</script>
	@endif

	<p>Tu Oro: {{$student->coins}}</p>

	<table class="main-table">
		<tr class="table-header-row">
			<td class="table-header-cell">Objeto</td>
			<td class="table-header-cell">Tipo</td>
			<td class="table-header-cell">Daño que Añade</td>
			<td class="table-header-cell">Salud que Añade</td>
			<td class="table-header-cell">Costo</td>
		</tr>

		@isset ($onSaleList)
			@foreach ($onSaleList as $sale)
				<tr onclick="location.href='/mercado/buyItem/{{$sale->name}}/{{$sale->cost}}'">
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
		@endisset
	</table>

	<button onclick="location.href='/mercado/healStudent/5'">Curar Salud (Costo: 5 Monedas de Oro)</button>
	<button onclick="location.href='/'">Volver</button>

</body>
</html>