window.addEvent('domready', function() {
	document.formvalidator.setHandler('!fieldname!',
		function (value) {
			return true;
			//regex=/^[^0-9]+$/;
			//return regex.test(value);
	});
});
