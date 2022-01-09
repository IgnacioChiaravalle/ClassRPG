function removeSectionsOfURL(sectionsToRemove) {
	currentURL = window.location.href;
	if (currentURL.slice(-1) == "/")
		currentURL = currentURL.slice(0, -1);
	splitURL = currentURL.split("/");
	toReturn = "";
	for (i = 0; i < splitURL.length - sectionsToRemove; i++)
		toReturn += splitURL[i] + "/";
	return toReturn;
}