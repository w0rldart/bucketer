$(document).ready(function($) {
	$('#master').toggleClass('container container-fluid');

	var $products = $('#friends-list li');
	$('#friend-search').keyup(function() {
		var re = new RegExp($(this).val(), "i"); // "i" means it's case-insensitive
		$products.show().filter(function() {
			return !re.test($(this).text());
		}).hide();
	});
});