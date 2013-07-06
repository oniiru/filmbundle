jQuery(document).ready(function($) {
	$('.pwyw-bundle-show').click(function() {
		var id = $(this).data('id');
		var film = getFilmById(id);
		console.log(film);
		$('.pwyw-bundle-info').slideToggle('fast');
	});

	// -------------------------------------------------------------------------
	// Helpers
	// -------------------------------------------------------------------------

	/**
	 * Lookup a film in the film object array.
	 *
	 * @returns object
	 */
	function getFilmById(id)
	{
		for (var key in pwyw_films) {
			if(pwyw_films.hasOwnProperty(key)){
        		if (pwyw_films[key].id == id) {
        			return pwyw_films[key];
        		}
		    }
		}
		return false;
	}
});
