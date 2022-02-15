<template>
	<div>
		<p class="title-p">Stock para el {{ rpg_class }}:</p>
		<div v-if="onSaleList != 0">
			<table id="class_market_table" ref="class_market_table" class="main-table">
				<thead>
					<tr class="table-header-row">
						<td class="table-header-cell">Objeto</td>
						<td class="table-header-cell">Tipo</td>
						<td class="table-header-cell">Daño que Añade</td>
						<td class="table-header-cell">Salud que Añade</td>
						<td class="table-header-cell">Costo</td>
						<td class="table-header-cell">¿Está a la Venta?</td>
						<td class="table-header-cell">Alumnos que lo Usan</td>
						<td class="table-header-cell">¿Querés Eliminar el Artículo?</td>
					</tr>
				</thead>
				<tbody :key="tableBody">
					<tr v-for="sale in onSaleList" :key="sale.name" :id="sale.name" class="table-inner-row">
						<td class="main-table-cell clickable-cell" @click="setSelected(sale)">{{ sale.name }}</td>
						<td class="main-table-cell clickable-cell" :class="sale.type + '-cell'" @click="setSelected(sale)">{{ sale.type }}</td>

						<td class="main-table-cell clickable-cell" v-if="sale.added_damage != null" @click="setSelected(sale)">
							{{ sale.added_damage }}
						</td>
						<td class="main-table-cell clickable-cell" v-else @click="setSelected(sale)">
							0
						</td>
						<td class="main-table-cell clickable-cell" v-if="sale.added_health != null" @click="setSelected(sale)">
							{{ sale.added_health }}
						</td>
						<td class="main-table-cell clickable-cell" v-else @click="setSelected(sale)">
							0
						</td>

						<td class="main-table-cell clickable-cell cost-cell" @click="setSelected(sale)">{{ sale.cost }}</td>

						<td class="main-table-cell" v-if="sale.marketable">
							<input type="checkbox" class="checkbox" value="marketable" checked @change="setMarketable(sale.name, false)">
						</td>
						<td class="main-table-cell" v-else>
							<input type="checkbox" class="checkbox" value="marketable" @change="setMarketable(sale.name, true)">
						</td>

						<td class="main-table-cell clickable-cell" @click="setSelected(sale)">{{ sale.users }}</td>

						<td class="main-table-cell"><button class="deleter-button" title="Eliminar el Artículo" @click="confirmSaleDelete(sale.name, sale.users)">&#128465;</button></td>
					</tr>
				</tbody>
			</table>

			<p id="loading" ref="loading" class="loading-p">(Refrescando tabla...)</p>

			<form class="input-form" v-if="selectedSale != null" :key="formBody" ref="form" method="POST" :action="'/manage-market/edit-sale/' + selectedSale.name" @load="resetFields()">
				<input type="hidden" name="_token" v-bind:value="csrf">

				<h2 class="sale-name-h2" :class="selectedSale.type + '-h2'">{{ selectedSale.name }}</h2>

				<div v-if="selectedSale.added_damage != null">
					<label for="added_damage">Daño que Añade:</label>
					<input class="field default-field" id="added_damage" ref="added_damage" :value="selectedSale.added_damage" name="added_damage" type="number" @keypress="activateFieldShell('added_damage'); resizeInput('added_damage'); enableSubmitShell('class-market-table-edition-submit')" @click="activateFieldShell('added_damage'); resizeInput('added_damage'); enableSubmitShell('class-market-table-edition-submit')">
				</div>

				<div v-if="selectedSale.added_health != null">
					<label for="added_health">Salud que Añade:</label>
					<input class="field default-field" id="added_health" ref="added_health" :value="selectedSale.added_health" name="added_health" type="number" @keypress="activateFieldShell('added_health'); resizeInput('added_health'); enableSubmitShell('class-market-table-edition-submit')" @click="activateFieldShell('added_health'); resizeInput('added_health'); enableSubmitShell('class-market-table-edition-submit')">
				</div>

				<div>
					<label for="cost">Costo:</label>
					<input class="field default-field" id="cost" ref="cost" :value="selectedSale.cost" required name="cost" type="number" @keypress="activateFieldShell('cost'); resizeInput('cost'); enableSubmitShell('class-market-table-edition-submit')" @click="activateFieldShell('cost'); resizeInput('cost'); enableSubmitShell('class-market-table-edition-submit')">
				</div>

				<input type="submit" id="class-market-table-edition-submit" class="submit disabled-submit" :class="(selectedSale.added_damage != null && selectedSale.added_health != null) ? 'higher-submit' : 'lower-submit'" disabled="disabled" value="Aceptar" @click="submitForm()">
			</form>
		</div>
		<div v-else>
			<div><p class="no-data-p">¡Aún no hay stock en el mercado para esta clase!</p></div>
		</div>
	</div>
</template>

<script>
	export default {
		props: [
			'csrf',
			'rpg_class'
		],

		data() {
			return {
				onSaleList: null,
				selectedSale: null,
				tableBody: 0,
				formBody: 0
			}
		},
		
		mounted() {
			this.getStock()
			this.changeLoadingVisibility('hidden')
		},

		methods: {
			async getStock() {
				await axios
					.get('/manage-market/get-stock/' + this.rpg_class)
					.then(response => {
						this.onSaleList = response.data
						if (this.onSaleList == null)
							this.onSaleList = 0
					})
					.catch(e => console.log("Error finding stock:\n" + e))
			},

			async setMarketable(saleName, marketable) {
				await axios
					.get('/manage-market/update-marketable/' + saleName + "/" + marketable)
					.then(
						this.changeLoadingVisibility('visible'),
						this.changeClassMarketTableVisibility('hidden')
					)
					.catch(e => console.log("Error updating marketable field:\n" + e))
				await this.getStock()
				this.tableBody++
				this.changeLoadingVisibility('hidden')
				this.changeClassMarketTableVisibility('visible')
			},

			async confirmSaleDelete(saleName, saleUsers) {
				if (saleUsers != 0)
					alert("¡No podés eliminar este artículo porque al menos un alumno lo está usando!")
				else if (confirm("¿Estás seguro de que querés eliminar este artículo: " + saleName + "? Esto es irreversible.")) {
					await axios
						.get('/manage-market/delete-sale/' + saleName)
						.then(
							this.changeLoadingVisibility('visible'),
							this.changeClassMarketTableVisibility('hidden')
						)
						.catch(e => console.log("Error deleting sale:\n" + e))
					if (this.selectedSale != null && this.selectedSale.name == saleName)
						this.selectedSale = null
					await this.getStock()
					this.tableBody++
					this.changeLoadingVisibility('hidden')
					this.changeClassMarketTableVisibility('visible')
				}
			},

			changeLoadingVisibility(visibility) {
				if (this.onSaleList != 0) this.$refs.loading.style.visibility = visibility
			},
			changeClassMarketTableVisibility(visibility) {
				if (this.onSaleList != 0) this.$refs.class_market_table.style.visibility = visibility
			},

			setSelected(sale) {
				this.selectedSale = sale
				this.formBody++
			},

			resetFields() {
				this.resetFieldClassAndWidth(this.$refs['added_damage'])
				this.resetFieldClassAndWidth(this.$refs['added_health'])
				this.resetFieldClassAndWidth(this.$refs['cost'])
			},
			resetFieldClassAndWidth(field) {
				if (field.classList.contains("active-field")) {
					field.classList.remove("active-field")
					field.classList.add("default-field")
				}
				field.style.width = 5 + 'ch'
			},

			activateFieldShell(fieldRef) {
				activateField(this.$refs[fieldRef])
			},
			enableSubmitShell(toEnableID) {
				enableSubmit(toEnableID)
			},

			resizeInput(fieldRef) {
				var input = this.$refs[fieldRef]
				input.style.width = input.value.length + 3 + 'ch'
			},

			async submitForm() {
				await this.$refs.form.submit()
				this.selectedSale = null
				this.changeLoadingVisibility('visible'),
				this.changeClassMarketTableVisibility('hidden')
			}
		}
	}
</script>