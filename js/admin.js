window.addEventListener('load', function() {
	document.getElementById('pushdemo').addEventListener('submit', function (ev) {
		ev.preventDefault();

		/** @type {HTMLInputElement} */
		const endpointField = document.getElementById('director_endpoint');
		const endpoint = endpointField.value;

		const xhr = new XMLHttpRequest();
		xhr.open("GET", `/index.php/settings/admin/pushdemo?director_endpoint=${endpoint}`, true);
		xhr.setRequestHeader('Content-Type', 'application/json');
		xhr.onreadystatechange = function () {
			if (this.readyState !== 4) return;

			if (this.status === 200) {
				if (this.responseText.includes('push-endpoint-updated-correctly')) {
					alert('Changes saved!');
				} else {
					alert('Could not save changes!');
				}
			} else {
				console.error('got error')
			}

			// end of state change: it can be after some time (async)
		};
		xhr.send();
	});
});
