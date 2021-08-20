<!-- Show all existing teachers, button to add new teachers, and capacity to click on a teacher to edit it. -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Docentes Activos</title>

		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

	</head>

	<body>

		<div id="parent-component">
			<teacher-table ref="teacherTable"></teacher-table>
		</div>

		<script src = "{{asset('/js/app.js')}}" defer></script>
	</body>
</html>