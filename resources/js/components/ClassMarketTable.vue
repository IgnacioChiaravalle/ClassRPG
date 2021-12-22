<template>
	<div v-if="onSaleList != 0">
		<p>Stock para el {{ rpgClass }}:</p>
		<table id="class_market_table" ref="class_market_table">
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
				<tr v-for="sale in onSaleList" :key="sale.name" :id="sale.name" class="tr-body">
					<td @click="setSelected(sale)">{{ sale.name }}</td>
					<td @click="setSelected(sale)">{{ sale.type }}</td>

					<td v-if="sale.added_damage != null" @click="setSelected(sale)">
						{{ sale.added_damage }}
					</td>
					<td v-else @click="setSelected(sale)">
						0
					</td>
					<td v-if="sale.added_health != null" @click="setSelected(sale)">
						{{ sale.added_health }}
					</td>
					<td v-else @click="setSelected(sale)">
						0
					</td>

					<td @click="setSelected(sale)">{{ sale.cost }}</td>

					<td v-if="sale.marketable">
						<input type="checkbox" value="marketable" checked @change="setMarketable(sale.name, false)">
					</td>
					<td v-else>
						<input type="checkbox" value="marketable" @change="setMarketable(sale.name, true)">
					</td>

					<td @click="setSelected(sale)">{{ sale.users }}</td>

					<td><button @click="confirmSaleDelete(sale.name, sale.users)">&#128465;</button></td>
				</tr>
			</tbody>
		</table>

		<p id="loading" ref="loading">(Refrescando tabla...)</p>
		
		<p></p>

		<form v-if="selectedSale != null" ref="form" method="POST" :action="'/manage-market/edit-sale/' + selectedSale.name">
			<input type="hidden" name="_token" v-bind:value="csrf">

			<p>{{ selectedSale.name }}</p>

			<div v-if="selectedSale.added_damage != null">
				<label for="added_damage">Daño que Añade:</label>
				<input id="added_damage" v-model="selectedSale.added_damage" name="added_damage" type="number">
			</div>

			<div v-if="selectedSale.added_health != null">
				<label for="added_health">Salud que Añade:</label>
				<input id="added_health" v-model="selectedSale.added_health" name="added_health" type="number">
			</div>

			<div>
				<label for="cost">Precio:</label>
				<input id="cost" v-model="selectedSale.cost" required name="cost" type="number">
			</div>

			<button @click="submitForm()">Aceptar</button>
		</form>
	</div>
	<div v-else>
		<p>¡Aún no hay stock en el mercado para esta clase!</p>
	</div>
</template>

<script>
	export default {
		props: ['csrf'],

		data() {
			return {
				rpgClass: new URL(location.href).toString().split('/').pop(),
				onSaleList: null,
				selectedSale: null,
				tableBody: 0
			}
		},
		
		mounted() {
			this.getStock()
			this.changeLoadingVisibility('hidden')
		},

		methods: {
			async getStock() {
				await axios
					.get('/manage-market/get-stock/' + this.rpgClass)
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
				this.selectedSale = sale;
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