function confirmPurchase(saleName, saleCost) {
	if(confirm("¿Querés comprar este artículo: " + saleName + "?"))
		window.location.replace("/market/buy-item/" + saleName + "/" + saleCost);
}

function confirmStudentDelete(userName) {
	if(confirm("¿Estás seguro de que querés eliminar a " + userName + "? Esto es irreversible."))
		window.location.replace("../delete-student/" + userName);
}