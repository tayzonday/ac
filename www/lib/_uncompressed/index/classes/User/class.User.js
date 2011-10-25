// User class

function User() {

	this.key = 0;
	this.password = '';

	// Events
	
	this.events = {

		// Log the user in
		login:

			(function () {
      
				console.log('User.events.login()');

				var ajax = new AjaxRequest(9);

				ajax.params = {
					'key':this.key,
					'password':this.password
				};

				ajax.callbacks.success = (function (_response) {

					console.log('User.events.login().[ajax.callbacks.success]');


				}).bind(this);

				ajax.callbacks.error = (function (_response) {

					console.log('User.events.login().[ajax.callbacks.error]');

				}).bind(this);

		        ajax.makeRequest();

			}).bind(this),


		// Log the user out
		logout:

			(function () {
      
				console.log('User.events.logout()');

				var ajax = new AjaxRequest(7);

				ajax.params = {};

				ajax.callbacks.success = (function (_response) {

					console.log('User.events.logout().[ajax.callbacks.success]');
					
					goto('/');

				}).bind(this);

				ajax.callbacks.error = (function (_response) {

					console.log('User.events.logout().[ajax.callbacks.error]');

				}).bind(this);

		        ajax.makeRequest();

			}).bind(this),
	
	}

	return true;



}