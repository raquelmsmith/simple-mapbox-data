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

						<h2><span><?php esc_attr_e( 'Mapbox Info', 'wp_admin_style' ); ?></span></h2>

						<div class="inside">
							<p><?php esc_attr_e(
									'We need this info to send data to your Mapbox account.',
									'wp_admin_style'
								); ?></p>
							<form name="mdfw_mapbox_info_form" method="post" action="">
								<input type="hidden" name="mdfw_mapbox_info_form_submitted" value="Y">
								<table class="form-table">
									<tr>
										<td scope="row">
											<label for="tablecell"><?php esc_attr_e('Mapbox Account Username', 'wp_admin_style'); ?></label>
										</td>
										<td>
											<input type="text" name="mapbox_account_username" value="<?php echo $mapbox_account_username; ?>" class="regular-text" />
										</td>
									</tr>
									<tr>
										<td scope="row">
											<label for="tablecell"><?php esc_attr_e('Mapbox Access Token', 'wp_admin_style'); ?></label>
										</td>
										<td>
											<input type="text" name="mapbox_access_token" value="<?php echo $mapbox_access_token; ?>" class="regular-text" />
										</td>
									</tr>
									<tr>
										<td scope="row">
											<label for="tablecell"><?php esc_attr_e('Mapbox Dataset ID', 'wp_admin_style'); ?></label>
										</td>
										<td>
											<input type="text" name="mapbox_dataset_id" value="<?php echo $mapbox_dataset_id; ?>" class="regular-text" />
										</td>
									</tr>
									<tr>
										<td scope="row">
											<label for="tablecell"><?php esc_attr_e('Send Categories', 'wp_admin_style'); ?></label>
										</td>
										<td>
											<input type="checkbox" name="mdfw_send_categories" value="1" <?php checked( $mdfw_send_categories, '1', TRUE ); ?> />
										</td>
									</tr>
									<tr>
										<td scope="row">
											<label for="tablecell"><?php esc_attr_e('Send Tags', 'wp_admin_style'); ?></label>
										</td>
										<td>
											<input type="checkbox" name="mdfw_send_tags" value="1" <?php checked( $mdfw_send_tags, '1', TRUE ); ?> />
										</td>
									</tr>
								</table>

								<h2><span><?php esc_attr_e( 'Custom Fields', 'wp_admin_style' ); ?></span></h2>

								<table class="form-table">
									<tr>
										<th class="row-title"><?php esc_attr_e( 'Value Name', 'wp_admin_style' ); ?></th>
										<th><?php esc_attr_e( 'Value Type', 'wp_admin_style' ); ?></th>
										<th><?php esc_attr_e( 'Include in GeoJSON?', 'wp_admin_style' ); ?></th>
									</tr>

									<?php 
									for ($i=0; $i < $number_fields; $i++) { 
										$field_name = 'mdfw_custom_field_' . $i;
										$field_type = $field_name . '_type';
										$field_json = $field_name . '_json';
										?>
										<tr valign="top">

										<td scope="row">
											<input type="text" name="mdfw_custom_field_<?php echo $i; ?>" value="<?php echo $$field_name; ?>" class="regular-text" />
										</td>
										<td>
											<select name="<?php echo $field_type; ?>" id="">
												<option <?php if ( $$field_type == 'text' ) { echo 'selected="selected"'; } ?> value="text">Text</option>
												<option <?php if ( $$field_type == 'textarea' ) { echo 'selected="selected"'; } ?> value="textarea">Textarea</option>
												<option <?php if ( $$field_type == 'checkbox' ) { echo 'selected="selected"'; } ?> value="checkbox">Checkbox</option>
												<option <?php if ( $$field_type == 'radio' ) { echo 'selected="selected"'; } ?> value="radio">Radio</option>
											</select>
										</td>
										<td>
											<input type="checkbox" value="1" name="mdfw_custom_field_<?php echo $i; ?>_json" <?php checked( $$field_json, '1', TRUE ); ?> />
										</td>
									</tr>
									<?php } ?>
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