window.onload = function () {
	chrome.storage.local.get({ profiles: [], selectedProfile: null, enabled: false, settings: {} }, (results) => {
		profile = results.profiles.find(profile => profile.id === results.selectedProfile);
		settings = results.settings;

		chrome.storage.local.get('StripeCheckbox', function(res){
			if (settings.enabled && res.StripeCheckbox == 1) {
				if (profile) {
					let fields = {
						// 'address.line1': `${profile.address}`,
						// 'address.line2': `${profile.address2}`,
						// 'address.city': `${profile.city}`,
						// 'address.state': `${profile.state}`,
						// 'address.postal_code': `${profile.zipcode}`,
						'cardnumber': profile.cardNumber,
						'exp-date': `${profile.expiryMonth} / ${profile.expiryYear.slice(-2)}`,
						'cvc': profile.cvv

					}

					Object.keys(fields).forEach(id => {
						fillField(id, fields[id]);
					});
					// document.getElementsById('address.line1').value = '15 rue beauregard';
					// document.getElementById('address.city').value = 'Paris';
					// document.getElementById('address.line2').value = `${profile.address2}`;
					// document.getElementById('address.city').value = profile.city;
					// document.getElementById('address.postal_code').value = profile.zipcode;
				}
			}
		})
	});
};

function fillField(name, value) {	
	let element = document.getElementsByName(name)[0];	
	if (element) {
		element.focus();
		element.value = value;
		element.dispatchEvent(new Event('change'));
		element.blur();
	}
}