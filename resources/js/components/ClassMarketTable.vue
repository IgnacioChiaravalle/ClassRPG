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
					<td class="table-header-cell">¿Desea Eliminar el Artículo?</td>
				</tr>
			</thead>
			<tbody :key="tableBody">
				<tr v-for="sale in onSaleList" :key="sale.name" :id="sale.name" class="tr-body">
					<td>{{ sale.name }}</td>
					<td>{{ sale.type }}</td>

					<td v-if="sale.added_damage != null">
						{{ sale.added_damage }}
					</td>
					<td v-else>
						0
					</td>
					<td v-if="sale.added_health != null">
						{{ sale.added_health }}
					</td>
					<td v-else>
						0
					</td>

					<td>{{ sale.cost }}</td>

					<td v-if="sale.marketable">
						<input type="checkbox" value="marketable" checked v-on:change="setMarketable(sale.name, false)">
					</td>
					<td v-else>
						<input type="checkbox" value="marketable" v-on:change="setMarketable(sale.name, true)">
					</td>

					<td>{{ sale.users }}</td>

					<td><button @click="confirmSaleDelete(sale.name, sale.users)">&#128465;</button></td>
				</tr>
			</tbody>
		</table>

		<p id="loading" ref="loading">(Refrescando tabla...)</p>
		
		<p></p>
	</div>
	<div v-else>
		<p>¡Aún no hay stock en el mercado para esta clase!</p>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				rpgClass: new URL(location.href).toString().split('/').pop(),
				onSaleList: null,
				tableBody: 0
			}
		},
		
		mounted() {
			this.getStock()
			this.changeLoadingVisibility('hidden')
		},

		methods: {
			getStock() {
				axios
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
				this.getStock()
				this.tableBody++
				this.changeLoadingVisibility('hidden')
				this.changeClassMarketTableVisibility('visible')
			},

			async confirmSaleDelete(saleName, saleUsers) {
				if (saleUsers != 0)
					alert("¡No podés eliminar este artículo porque al menos un alumno lo está usando!")
				else if (confirm("¿Estás seguro de que querés este artículo: " + saleName + "? Esto es irreversible.")) {
					await axios
						.get('/manage-market/delete-sale/' + saleName)
						.then(
							this.changeLoadingVisibility('visible'),
							this.changeClassMarketTableVisibility('hidden')
						)
						.catch(e => console.log("Error deleting sale:\n" + e))
					this.getStock()
					this.tableBody++
					this.changeLoadingVisibility('hidden')
					this.changeClassMarketTableVisibility('visible')
				}
			},

			changeLoadingVisibility(visibility) {
				this.$refs.loading.style.visibility = visibility
			},
			changeClassMarketTableVisibility(visibility) {
				this.$refs.class_market_table.style.visibility = visibility
			}
		}
	}
</script>