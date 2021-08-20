<template>
	<div>
		<table>
			<thead>
				<tr>
					<td class="table-header-cell">Nombre</td>
					<td class="table-header-cell">Correo Electrónico</td>
					<td class="table-header-cell">Nombre de Usuario</td>
					<td class="table-header-cell">¿Puede Administrar Docentes?</td>
					<td class="table-header-cell">¿Desea Eliminar su Usuario?</td>
				</tr>
			</thead>
			<tbody :key="tableBody">
				<tr v-for="teacher in teachers" :key="teacher.name" :id="teacher.name" class="tr-body">
					<td>{{ teacher.real_name }}</td>
					<td>{{ teacher.email }}</td>
					<td>{{ teacher.name }}</td>

					<td v-if="teacher.can_manage_teachers">
						<input type="checkbox" value="can_manage_teachers" checked v-on:change="setCanDeleteTeachers(teacher.name, false)">
					</td>
					<td v-else>
						<input type="checkbox" value="can_manage_teachers" v-on:change="setCanDeleteTeachers(teacher.name, true)">
					</td>

					<td><button @click="confirmTeacherDelete(teacher.name)">&#128465;</button></td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				teachers: null,
				tableBody: 0
			}
		},
		
		mounted() {
			console.log('Component mounted.');
			this.getTeachers();
		},

		methods: {
			getTeachers() {
				axios
					.get('/manage-teachers/get-teachers')
					.then(response => {
						this.teachers = response.data
					})
					.catch(e => console.log("Error finding teachers:\n" + e))
			},

			setCanDeleteTeachers(teacherName, can_manage_teachers) {
				axios
					.get('/manage-teachers/update-can-manage-teachers/' + teacherName + "/" + can_manage_teachers)
					.catch(e => console.log("Error updating can_manage_teacher:\n" + e))
				this.teachers = this.getTeachers();
				this.tableBody++;
			},

			confirmTeacherDelete(teacherName) {
				if(confirm("¿Estás seguro de que querés eliminar a " + teacherName + "? Esto es irreversible.")) {
					axios
						.get('/manage-teachers/delete-teacher/' + teacherName)
						.catch(e => console.log("Error deleting teacher:\n" + e))
					this.teachers = this.getTeachers();
					this.tableBody++;
				}
			}
		}
	}
</script>
