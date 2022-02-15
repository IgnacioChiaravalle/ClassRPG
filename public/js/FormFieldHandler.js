const DAMAGE_ADDERS = ["Weapon", "Item"];
const HEALTH_ADDERS = ["Armor", "Item"];

function updateEnabledFields(dropDownMenu) {
	damageField = document.getElementById("added_damage");
	healthField = document.getElementById("added_health");
	selectedValue = dropDownMenu.value;
	if (DAMAGE_ADDERS.includes(selectedValue)) {
		damageField.disabled = false;
		activateField(damageField);
	}
	else {
		damageField.disabled = true;
		damageField.value = 0;
		deactivateField(damageField);
	}
	
	if (HEALTH_ADDERS.includes(selectedValue)) {
		healthField.disabled = false;
		activateField(healthField);
	}
	else {
		healthField.disabled = true;
		healthField.value = 0;
		deactivateField(healthField);
	}
}

function resizeManyFields(fieldArray) {
	fieldArray.forEach(fieldID => {
		field = document.getElementById(fieldID);
		resizeField(field);
	})
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
function deactivateField(field) {
	if (field.classList.contains("active-field")) {
		field.classList.remove("active-field");
		field.classList.add("default-field");
	}
}

function resizeField(field) {
	field.style.width = field.value.length + 3 + 'ch'
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