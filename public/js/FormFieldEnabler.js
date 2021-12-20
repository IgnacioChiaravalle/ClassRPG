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