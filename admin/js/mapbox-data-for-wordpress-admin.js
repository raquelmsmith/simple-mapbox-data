(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(document).ready( function() {
	
		$(".mdfw-update-all").click( function(e) {
			e.preventDefault(); 
			$(".sending-data").show();
			var nonce = $(this).attr("data-nonce");

			$.ajax({
				type : "post",
				url : ajaxurl,
		    	data : {action: "mdfw_update_all", nonce: nonce},
				success: function(response) {
					if(response == "success") {
						$(".sending-data").hide();
						$(".data-sent").show();
					}
					else {
						alert("Not updated")
					}
				}
			})

		})

	})

})( jQuery );
