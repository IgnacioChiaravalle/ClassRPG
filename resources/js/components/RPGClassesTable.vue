<template>
	<div v-if="rpgClasses != 0">
		<table id="rpg_classes_table" ref="rpg_classes_table">
			<thead>
				<tr class="table-header-row">
					<td class="table-header-cell">Clase</td>
					<td class="table-header-cell">Daño Base</td>
					<td class="table-header-cell">Salud Base</td>
					<td class="table-header-cell">Alumnos con esta Clase</td>
					<td class="table-header-cell">¿Querés Eliminar esta Clase?</td>
				</tr>
			</thead>
			<tbody :key="tableBody">
				<tr v-for="rpgClass in rpgClasses" :key="rpgClass.name" :id="rpgClass.name" class="tr-body">
					<td @click="setSelected(rpgClass)">{{ rpgClass.name }}</td>
					<td @click="setSelected(rpgClass)">{{ rpgClass.base_damage }}</td>
					<td @click="setSelected(rpgClass)">{{ rpgClass.base_health }}</td>
					<td @click="setSelected(rpgClass)">{{ rpgClass.users }}</td>
					<td><button @click="confirmClassDelete(rpgClass.name, rpgClass.users)">&#128465;</button></td>
				</tr>
			</tbody>
		</table>

		<p id="loading" ref="loading">(Refrescando tabla...)</p>
		
		<p></p>

		<form v-if="selectedClass != null" ref="form" method="POST" :action="'/manage-classes/edit-class/' + selectedClass.name">
			<input type="hidden" name="_token" v-bind:value="csrf">

			<p>{{ selectedClass.name }}</p>

			<div v-if="selectedClass.base_damage != null">
				<label for="base_damage">Daño Base:</label>
				<input id="base_damage" v-model="selectedClass.base_damage" name="base_damage" type="number">
			</div>

			<div v-if="selectedClass.base_health != null">
				<label for="base_health">Salud Base:</label>
				<input id="base_health" v-model="selectedClass.base_health" name="base_health" type="number">
			</div>

			<button @click="submitForm()">Aceptar</button>
		</form>
	</div>
	<div v-else>
		<p>¡Aún no hay clases en el sistema!</p>
	</div>
</template>

<script>
	export default {
		props: ['csrf'],

		data() {
			return {
				rpgClasses: null,
				selectedClass: null,
				tableBody: 0
			}
		},
		
		mounted() {
			this.getRPGClasses()
			this.changeLoadingVisibility('hidden')
		},

		methods: {
			async getRPGClasses() {
				await axios
					.get('/manage-classes/get-classes')
					.then(response => {
						this.rpgClasses = response.data
						if (this.rpgClasses == null)
							this.rpgClasses = 0
					})
					.catch(e => console.log("Error finding classes:\n" + e))
			},

			async confirmClassDelete(className, classUsers) {
				if (classUsers != 0)
					alert("¡No podés eliminar esta clase porque al menos un alumno pertenece a ella!")
				else if (confirm("¿Estás seguro de que querés eliminar esta clase: " + className + "? Esto es irreversible.")) {
					await axios
						.get('/manage-classes/delete-class/' + className)
						.then(
							this.changeLoadingVisibility('visible'),
							this.changeRPGClassesTableVisibility('hidden')
						)
						.catch(e => console.log("Error deleting class:\n" + e))
					if (this.selectedClass != null && this.selectedClass.name == className)
						this.selectedClass = null
					await this.getRPGClasses()
					this.tableBody++
					this.changeLoadingVisibility('hidden')
					this.changeRPGClassesTableVisibility('visible')
				}
			},

			changeLoadingVisibility(visibility) {
				if (this.rpgClasses != 0) this.$refs.loading.style.visibility = visibility
			},
			changeRPGClassesTableVisibility(visibility) {
				if (this.rpgClasses != 0) this.$refs.rpg_classes_table.style.visibility = visibility
			},

			setSelected(rpgClass) {
				this.selectedClass = rpgClass;
			},
			async submitForm() {
				await this.$refs.form.submit()
				this.selectedClass = null
				this.changeLoadingVisibility('visible'),
				this.changeRPGClassesTableVisibility('hidden')
			}
		}
	}
</script>