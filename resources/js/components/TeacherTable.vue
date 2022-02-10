<template>
	<div v-if="teachers != 0">
		<table id="teacher_table" ref="teacher_table" class="main-table">
			<thead>
				<tr class="table-header-row">
					<td class="table-header-cell">Nombre</td>
					<td class="table-header-cell">Correo Electrónico</td>
					<td class="table-header-cell">Nombre de Usuario</td>
					<td class="table-header-cell">¿Puede Administrar Docentes?</td>
					<td class="table-header-cell">¿Querés Eliminar su Usuario?</td>
				</tr>
			</thead>
			<tbody :key="tableBody">
				<tr v-for="teacher in teachers" :key="teacher.name" :id="teacher.name" class="table-inner-row">
					<td class="main-table-cell">{{ teacher.real_name }}</td>
					<td @click="copyToClipboardShell(teacher.email, 'Correo electrónico')" title="Copiar correo electrónico" class="main-table-cell email-cell">{{ teacher.email }}</td>
					<td class="main-table-cell">{{ teacher.name }}</td>

					<td v-if="teacher.can_manage_teachers" class="main-table-cell">
						<input type="checkbox" class="checkbox" value="can_manage_teachers" checked v-on:change="setCanManageTeachers(teacher.name, false)">
					</td>
					<td v-else class="main-table-cell">
						<input type="checkbox" class="checkbox" value="can_manage_teachers" v-on:change="setCanManageTeachers(teacher.name, true)">
					</td>

					<td class="main-table-cell"><button @click="confirmTeacherDelete(teacher.name)" title="Eliminar al Docente" class="deleter-button">&#128465;</button></td>
				</tr>
			</tbody>
		</table>

		<p id="loading" ref="loading" class="loading-p">(Refrescando tabla...)</p>

	</div>
	<div v-else>
		<div><p class="no-data-p">No hay otros docentes en el sistema.</p></div>
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
				if (this.teachers != 0) this.$refs.loading.style.visibility = visibility
			},
			changeTeacherTableVisibility(visibility) {
				if (this.teachers != 0) this.$refs.teacher_table.style.visibility = visibility
			},

			copyToClipboardShell(textToCopy, textType) {
				copyToClipboard(textToCopy, textType)
			}
		}
	}
</script>
