<template>
	<div v-if="rpgClasses != 0">
		<table id="rpg_classes_table" ref="rpg_classes_table" class="main-table">
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
				<tr v-for="rpgClass in rpgClasses" :key="rpgClass.name" :id="rpgClass.name" class="table-inner-row">
					<td class="main-table-cell clickable-cell name-cell" @click="setSelected(rpgClass)">{{ rpgClass.name }}</td>
					<td class="main-table-cell clickable-cell damage-cell" @click="setSelected(rpgClass)">{{ rpgClass.base_damage }}</td>
					<td class="main-table-cell clickable-cell health-cell" @click="setSelected(rpgClass)">{{ rpgClass.base_health }}</td>
					<td class="main-table-cell clickable-cell" @click="setSelected(rpgClass)">{{ rpgClass.users }}</td>
					<td class="main-table-cell"><button class="deleter-button" title="Eliminar la Clase" @click="confirmClassDelete(rpgClass.name, rpgClass.users)">&#128465;</button></td>
				</tr>
			</tbody>
		</table>

		<p id="loading" ref="loading" class="loading-p">(Refrescando tabla...)</p>

		<form class="input-form" v-if="selectedClass != null" :key="formBody" ref="form" method="POST" :action="'/manage-classes/edit-class/' + selectedClass.name" @load="resetFields()">
			<input type="hidden" name="_token" v-bind:value="csrf">

			<h2 class="selection-name-h2">{{ selectedClass.name }}</h2>

			<div v-if="selectedClass.base_damage != null">
				<label for="base_damage">Daño Base:</label>
				<input class="field default-field" id="base_damage" ref="base_damage" :value="selectedClass.base_damage" name="base_damage" type="number" @keypress="activateFieldShell('base_damage'); resizeFieldShell('base_damage'); enableSubmitShell('rpg-classes-table-edition-submit')" @click="activateFieldShell('base_damage'); resizeFieldShell('base_damage'); enableSubmitShell('rpg-classes-table-edition-submit')">
			</div>

			<div v-if="selectedClass.base_health != null">
				<label for="base_health">Salud Base:</label>
				<input class="field default-field" id="base_health" ref="base_health" :value="selectedClass.base_health" name="base_health" type="number" @keypress="activateFieldShell('base_health'); resizeFieldShell('base_health'); enableSubmitShell('rpg-classes-table-edition-submit')" @click="activateFieldShell('base_health'); resizeFieldShell('base_health'); enableSubmitShell('rpg-classes-table-edition-submit')">
			</div>

			<input type="submit" id="rpg-classes-table-edition-submit" class="submit disabled-submit" disabled="disabled" value="Aceptar" @click="submitForm()">
		</form>
	</div>
	<div v-else>
		<div><p class="no-data-p">¡Aún no hay clases en el sistema!</p></div>
	</div>
</template>

<script>
	export default {
		props: ['csrf'],

		data() {
			return {
				rpgClasses: null,
				selectedClass: null,
				tableBody: 0,
				formBody: 0
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
				this.formBody++
			},

			resetFields() {
				this.resetFieldClassAndWidth(this.$refs['base_damage'])
				this.resetFieldClassAndWidth(this.$refs['base_health'])
			},
			resetFieldClassAndWidth(field) {
				deactivateField(field)
				field.style.width = '5ch'
			},

			activateFieldShell(fieldRef) {
				activateField(this.$refs[fieldRef])
			},
			enableSubmitShell(toEnableID) {
				enableSubmit(toEnableID)
			},

			resizeFieldShell(fieldRef) {
				resizeField(this.$refs[fieldRef])
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