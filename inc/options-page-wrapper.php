<h2><?php _e( 'Mapbox Data for WordPress', 'wp_admin_style' ); ?></h2>

<div class="wrap">

	<div id="icon-options-general" class="icon32"></div>
	<h1><?php esc_attr_e( 'Settings', 'wp_admin_style' ); ?></h1>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">

						<h2><span><?php esc_attr_e( 'Custom Fields', 'wp_admin_style' ); ?></span></h2>

						<div class="inside">
							<p><?php esc_attr_e(
									'Add custom fields here to include in the Mapbox data points.',
									'wp_admin_style'
								); ?></p>
							<form method="post" action="">
								<table class="form-table">
									<tr>
										<th class="row-title"><?php esc_attr_e( 'Value Name', 'wp_admin_style' ); ?></th>
										<th><?php esc_attr_e( 'Value Type', 'wp_admin_style' ); ?></th>
										<th><?php esc_attr_e( 'Include in GeoJSON?', 'wp_admin_style' ); ?></th>
									</tr>
									<tr valign="top">
										<td scope="row">
											<input type="text" value="Year" class="regular-text" />
										</td>
										<td>
											<select name="" id="">
												<option selected="selected" value="number">Number</option>
												<option value="string">String</option>
												<option value="string">Boolean</option>
											</select>
										</td>
										<td>
											<input type="checkbox" value="1" name="checkbox" <?php checked( $value, '1', TRUE ); ?> />
										</td>
									</tr>
									<tr valign="top">
										<td scope="row">
											<input type="text" value="" class="regular-text" /><br>
										</td>
										<td>
											<select name="" id="">
												<option selected="selected" value="number">Number</option>
												<option value="string">String</option>
												<option value="string">Boolean</option>
											</select>
										</td>
										<td>
											<input type="checkbox" value="1" name="checkbox" <?php checked( $value, '1', TRUE ); ?> />
										</td>
									</tr>
									<tr valign="top">
										<td scope="row">
											<input type="text" value="" class="regular-text" /><br>
										</td>
										<td>
											<select name="" id="">
												<option selected="selected" value="number">Number</option>
												<option value="string">String</option>
												<option value="string">Boolean</option>
											</select>
										</td>
										<td>
											<input type="checkbox" value="1" name="checkbox" <?php checked( $value, '1', TRUE ); ?> />
										</td>
									</tr>
								</table>
								<p>
									<?php submit_button(
										'Save', $type = 'primary', $name = 'mdfw-settings-submit', $wrap = FALSE, $other_attributes = NULL
									); ?>
								</p>
							</form>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables .ui-sortable -->

			</div>
			<!-- post-body-content -->

			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">

				<div class="meta-box-sortables">

					<div class="postbox">

						<h2><span><?php esc_attr_e(
									'About Mapbox Data for WordPress', 'wp_admin_style'
								); ?></span></h2>

						<div class="inside">
							<p><?php esc_attr_e(
									'Mapbox Data for WordPress allows you to manage your Mapbox data points from right within your WordPress installation.',
									'wp_admin_style'
								); ?></p>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables -->

			</div>
			<!-- #postbox-container-1 .postbox-container -->

		</div>
		<!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->