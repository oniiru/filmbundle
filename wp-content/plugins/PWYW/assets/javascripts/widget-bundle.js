jQuery(document).ready(function($) {
	$('.pwyw-bundle-show').click(function() {
		var id = $(this).data('id');
		console.log(id);
		$('.pwyw-bundle-info').slideToggle('fast');
	});
});