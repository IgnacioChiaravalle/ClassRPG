function copyToClipboard(textToCopy, textType) {
	if (!navigator.clipboard){
		textArea = document.createElement('textarea');
		textArea.value = textToCopy;
		document.body.appendChild(textArea);
		textArea.select();
		document.execCommand('copy');
		document.body.removeChild(textArea);
	}
	else {
		navigator.clipboard.writeText(textToCopy).then(
			function() {
				alert(textType + " copiado al portapapeles.");
			}
		);
	}	
}