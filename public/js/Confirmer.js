function confirmPurchase(saleName, saleCost) {
	if(confirm("¿Querés comprar este artículo: " + saleName + "?"))
		window.location.replace("/market/buy-item/" + saleName + "/" + saleCost);
}

function confirmStudentDelete(userName) {
	continueURL = removeSectionsOfURL(2);
	if(confirm("¿Estás seguro de que querés eliminar a " + userName + "? Esto es irreversible."))
		window.location.replace(continueURL + "delete-student/" + userName);
}

function confirmSelfDelete() {
	if(confirm("¿Estás seguro de que querés eliminar tu cuenta? Esto es irreversible."))
		window.location.replace("/my-account/delete-self");
}	

function confirmMissionDelete(missionID, missionName) {
	continueURL = removeSectionsOfURL(1);
	if(confirm("¿Estás seguro de que querés eliminar la misión " + missionName + "? Esto es irreversible."))
		window.location.replace(continueURL + "handle-mission/" + missionID + "/delete-mission");
}