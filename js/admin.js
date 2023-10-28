// SPDX-FileCopyrightText: bitfire web engineering GmbH <info@bitfire.at>
// SPDX-License-Identifier: AGPL-3.0-or-later

function submitForm(id, confirmationKeyword) {
	/** @type {HTMLInputElement} */
	const endpointField = document.getElementById(id);
	const endpoint = endpointField.value;

	const xhr = new XMLHttpRequest();
	xhr.open("GET", `${window.location.href}?${id}=${endpoint}`, true);
	xhr.setRequestHeader('Content-Type', 'application/json');
	xhr.onreadystatechange = function () {
		if (this.readyState !== 4) return;

		if (this.status === 200) {
			if (this.responseText.includes(confirmationKeyword)) {
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
}

window.addEventListener('load', function() {
	document.getElementById('pushdemo-director').addEventListener('submit', function (ev) {
		ev.preventDefault();

		submitForm('director_endpoint', 'push-endpoint-updated-correctly');
	});

	document.getElementById('pushdemo-auth_arg').addEventListener('submit', function (ev) {
		ev.preventDefault();

		submitForm('auth_arg', 'auth-arg-updated-correctly');
	});
});
