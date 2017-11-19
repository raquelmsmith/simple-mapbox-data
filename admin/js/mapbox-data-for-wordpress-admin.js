(function( $ ) {
	'use strict';

	$(document).ready( function() {
		var i = 0;
		function update_all_data_points() {
			if( (typeof mdfwAjax.map_data_points.posts[i] == 'undefined') ) {
				$(".sending-data").hide();
				$(".data-sent").show();
				return;
			}
			console.log('Updating post number: ' + mdfwAjax.map_data_points.posts[i].ID);
			$.ajax({
				type: "post",
				url: ajaxurl,
				data: {
					'action': 'get_id_send_data',
					'data_point_id': mdfwAjax.map_data_points.posts[i].ID
				},
				success: function(response_code) {
					if (response_code == 200) {
						console.log("Post updated successfully.");
					} else {
						console.log("There was a problem updating the post. The response code was: " + response_code);
					}
					i++;
					update_all_data_points();
				}
			});	
		}
	
		$(".mdfw-update-all").click( function(e) {
			e.preventDefault(); 
			$(".sending-data").show();
			update_all_data_points();
			

		})
	})

})( jQuery );
