<template>
	<div v-if="teachers != 0">
		<table id="teacher_table" ref="teacher_table">
			<thead>
				<tr class="table-header-row">
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
						<input type="checkbox" value="can_manage_teachers" checked v-on:change="setCanManageTeachers(teacher.name, false)">
					</td>
					<td v-else>
						<input type="checkbox" value="can_manage_teachers" v-on:change="setCanManageTeachers(teacher.name, true)">
					</td>

					<td><button @click="confirmTeacherDelete(teacher.name)">&#128465;</button></td>
				</tr>
			</tbody>
		</table>

		<p id="loading" ref="loading">(Refrescando tabla...)</p>

	</div>
	<div v-else>
		<p>No hay otros docentes en el sistema.</p>
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
			this.getTeachers()
			this.changeLoadingVisibility('hidden')
		},

		methods: {
			async getTeachers() {
				await axios
					.get('/manage-teachers/get-teachers')
					.then(response => {
						this.teachers = response.data
						if (this.teachers == null)
							this.teachers = 0
					})
					.catch(e => console.log("Error finding teachers:\n" + e))
			},

			async setCanManageTeachers(teacherName, can_manage_teachers) {
				await axios
					.get('/manage-teachers/update-can-manage-teachers/' + teacherName + "/" + can_manage_teachers)
					.then(
						this.changeLoadingVisibility('visible'),
						this.changeTeacherTableVisibility('hidden')
					)
					.catch(e => console.log("Error updating can_manage_teacher:\n" + e))
				await this.getTeachers()
				this.tableBody++
				this.changeLoadingVisibility('hidden')
				this.changeTeacherTableVisibility('visible')
			},

			async confirmTeacherDelete(teacherName) {
				if(confirm("¿Estás seguro de que querés eliminar a " + teacherName + "? Esto es irreversible.")) {
					await axios
						.get('/manage-teachers/delete-teacher/' + teacherName)
						.then(
							this.changeLoadingVisibility('visible'),
							this.changeTeacherTableVisibility('hidden')
						)
						.catch(e => console.log("Error deleting teacher:\n" + e))
					await this.getTeachers()
					this.tableBody++
					this.changeLoadingVisibility('hidden')
					this.changeTeacherTableVisibility('visible')
				}
			},

			changeLoadingVisibility(visibility) {
				this.$refs.loading.style.visibility = visibility
			},
			changeTeacherTableVisibility(visibility) {
				this.$refs.teacher_table.style.visibility = visibility
			}
		}
	}
</script>
