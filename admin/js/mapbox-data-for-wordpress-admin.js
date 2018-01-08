(function( $ ) {
	'use strict';

	$(document).ready( function() {
		var query;
		var mapDataPoints;
		var numPosts;
		var i = 0;
		function getDataPoints() {
			$.ajax({
				type: "post",
				url: ajaxurl,
				data: {
					'action': 'get_all_data_points',
					'low': $('input[name="low"]').val(),
					'high': $('input[name="high"]').val()
				},
				success: function(response) {
					query = JSON.parse(response);
					numPosts = query.found_posts;
					mapDataPoints = query.posts;
					update_all_data_points();
				}
			});	
		}

		function update_all_data_points() {
			if( (typeof mapDataPoints[i] == 'undefined') ) {
				$(".mdfw-update-all + .sending-data").hide();
				$(".mdfw-update-all + .sending-data + .data-sent").show();
				return;
			}
			console.log('Updating post number: ' + mapDataPoints[i].ID);
			$.ajax({
				type: "post",
				url: ajaxurl,
				data: {
					'action': 'get_id_send_data',
					'data_point_id': mapDataPoints[i].ID
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

		function update_tileset() {
			$.ajax({
				type: "post",
				url: ajaxurl,
				data: {
					'action': 'update_tileset',
				},
				success: function(response) {
					console.log(response);
					$(".mdfw-update-tileset + .sending-data").hide();
					$(".mdfw-update-tileset + .sending-data + .data-sent").show();
				}
			});	
		}
	
		$(".mdfw-update-all").click( function(e) {
			e.preventDefault(); 
			$(".mdfw-update-all + .sending-data").show();
			getDataPoints();
		})

		$(".mdfw-update-tileset").click( function(e) {
			e.preventDefault(); 
			$(".mdfw-update-tileset + .sending-data").show();
			update_tileset();
		})
	})

})( jQuery );
