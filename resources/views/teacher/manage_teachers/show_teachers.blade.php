<!-- Show all existing teachers, button to add new teachers, and capacity to click on a teacher to edit it. -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Docentes Activos</title>
		<script src = "{{url('/js/Toaster.js')}}" type = "text/javascript"></script>

		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

	</head>

	<body>
		@if (Session::has('success'))
			<div class="alert-toast" id="teacher-welcome-alert-toast">
				<div>{{ session('success') }}</div>
				<div class="toast-closer" onclick="closeToast('teacher-welcome-alert-toast')">X</div>
			</div>
		@endif
		@if (Session::has('message'))
			<script type="text/javascript">alert("{{ Session::get('message') }}");</script>
		@endif

		<div id="parent-component">
			<teacher-table ref="teacherTable"></teacher-table>
		</div>
		<script src = "{{asset('/js/app.js')}}" defer></script>

		<button onclick="location.href='/manage-teachers/add-teacher'">Crear un Nuevo Docente</button>

		<button onclick="location.href='/'">Volver</button>
	</body>
</html>