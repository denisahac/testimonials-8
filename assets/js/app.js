(function($) {

	initComponents();

	/**
	 * Initialize components.
	 */
	function initComponents() {
		rateMe();
	}

	/**
	 * Rate the testimonial.
	 */
	function rateMe() {
		// check for rateYo
		if($().rateYo) {
			$('.js-wpt8-rate').rateYo({
				normalFill: "#A0A0A0",
				halfStar: true,

				onSet: function (rating, rateYoInstance) {
		      $('.js-wpt8-rating').val(rating);
		    }
			});
		}
	}

	/**
	 * Shorthand for console.log.
	 *
	 * @param string message The mesage to log.
	 */
	function log(message) {
		console.log(message);
	}

})(jQuery);