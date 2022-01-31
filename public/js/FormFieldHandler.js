const DAMAGE_ADDERS = ["Weapon", "Item"];
const HEALTH_ADDERS = ["Armor", "Item"];

function updateEnabledFields(dropDownMenu) {
	damageField = document.getElementById("added_damage");
	healthField = document.getElementById("added_health");
	selectedValue = dropDownMenu.value;
	if (DAMAGE_ADDERS.includes(selectedValue))
		damageField.disabled = false;
	else {
		damageField.disabled = true;
		damageField.value = 0;
	}
	
	if (HEALTH_ADDERS.includes(selectedValue))
		healthField.disabled = false;
	else {
		healthField.disabled = true;
		healthField.value = 0;
	}
}

function clearFieldIfDefault(field) {
	if (field.classList.contains("default-field"))
		field.value = "";
}

function activateField(field) {
	if (field.classList.contains("default-field")) {
		field.classList.remove("default-field");
		field.classList.add("active-field");
	}
}

function enableSubmitIfAllActive(minimum, toEnableID) {
	if (document.getElementsByClassName("active-field").length >= minimum)
		enableSubmit(toEnableID);
}

function enableSubmit(toEnableID) {
	submitElement = document.getElementById(toEnableID);
	if (submitElement.disabled) {
		submitElement.classList.remove("disabled-submit");
		submitElement.classList.add("enabled-submit");
		submitElement.disabled = false;
	}
}