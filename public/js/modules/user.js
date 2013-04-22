$(document).ready(function($) {
	$('#master').toggleClass('container container-fluid');

	var $products = $('#friends-list li');
	$('#friend-search').keyup(function() {
		var re = new RegExp($(this).val(), "i"); // "i" means it's case-insensitive
		$products.show().filter(function() {
			return !re.test($(this).text());
		}).hide();
	});

	var header_height = $('.navbar').height();
	var container_height = $('#master').css('marginTop').replace('px', '')*2;

	//$('#friends-list').css({'max-height': $(window).height() - header_height - container_height - $('.form-friends > .form-horizontal').height()});
	$('#user-bucket').height($(window).height() - header_height - container_height - 40);
	$('#list-buckets').height($(window).height() - header_height - container_height);
});