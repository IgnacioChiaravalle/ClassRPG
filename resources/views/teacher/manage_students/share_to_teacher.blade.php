<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Compartir Alumno</title>
		<script src = "{{url('/js/URL_Fixer.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/Confirmer.js')}}" type = "text/javascript"></script>
		<script src = "{{url('/js/FormFieldHandler.js')}}" type = "text/javascript"></script>
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Document Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Page Buttons/Page Button Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Form Elements Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Table Page General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Select Element Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Student Management/Student Management General Style.css')}}">
		<link rel = "stylesheet" type = "text/css" href = "{{url('/css/Teacher/Student Management/Share Student Style.css')}}">
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
			var shareURL = removeSectionsOfURL(2);
		</script>

		<button title="Descartar Cambios y Volver" class="page-button go-back-button" onclick="location.href=shareURL + 'handle-student-data/{{$studentName}}'"></button>
		<button title="Descartar Cambios e Ir al Inicio" class="page-button home-button" onclick="location.href='/'"></button>
		
		<p id="title-p">Compartir a {{$studentName}}</p>
		
		<div class="page-container-div">
			@if (isset ($unrelatedTeachers))
				<form class="input-form" method="POST" action=""+url enctype="multipart/form-data">
				@csrf

					<div>
						<label for="teacher_name">Seleccioná al Docente con el que desees compartir a {{$studentName}}:</label>
						<select id="teacher_name" name="teacher_name" onchange="if (this.selectedIndex != 0) enableSubmit('share-student-submit'); else disableSubmit('share-student-submit')">
							<option>[Ninguno]</option>
							@foreach ($unrelatedTeachers as $teacher)
								<option value="{{$teacher->name}}">{{$teacher->real_name}} ({{$teacher->name}})</option>
							@endforeach
						</select>
						@error('name')
							<label class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</label>
						@enderror
					</div>

					<input type="submit" id="share-student-submit" class="submit disabled-submit" disabled="disabled" value="Aceptar">
				</form>
			@else
				<p class="no-data-p">No hay docentes a los que compartirles este alumno.</p>
			@endif

			@if (isset ($relatedTeachers))
				<div class="teacher-list-div {{isset ($unrelatedTeachers) ? 'higher-teacher-list-div' : 'lower-teacher-list-div'}}">{{$studentName}} ya es alumno de:</div>
				@foreach ($relatedTeachers as $teacher)
					<div class="teacher-list-div">* {{$teacher->real_name}} ({{$teacher->name}})</div>
				@endforeach
			@else
				<p class="only-teacher-p {{isset ($unrelatedTeachers) ? 'higher-only-teacher-p' : 'lower-only-teacher-p'}}">Hasta el momento, sos el único docente de {{$studentName}}.</p>
			@endif
		</div>		
	</body>
</html>
