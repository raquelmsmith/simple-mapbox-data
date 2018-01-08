<?php
/**
 * Provide the markup for the options page for the plugin.
 *
 *
 * @link       raquelmsmith.com
 * @since      1.0.0
 *
 * @package    Mapbox_Data_For_Wordpress
 * @subpackage Mapbox_Data_For_Wordpress/admin/partials
 */
?>

<h2><?php _e( 'Mapbox Data for WordPress', 'mapbox-data-for-wordpress' ); ?></h2>

<div class="wrap">

	<div id="icon-options-general" class="icon32"></div>
	<h1><?php esc_attr_e( 'Settings', 'mapbox-data-for-wordpress' ); ?></h1>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">

						<h2><span><?php esc_html_e( 'Mapbox Info', 'mapbox-data-for-wordpress' ); ?></span></h2>

						<div class="inside">
							<p><?php esc_html_e(
									'We need this info to send data to your Mapbox account.',
									'mapbox-data-for-wordpress'
								); ?></p>
							<form name="mdfw_mapbox_info_form" method="post" action="">
								<input type="hidden" name="mdfw_mapbox_info_form_submitted" value="Y">
								<table class="form-table">
									<tr>
										<td scope="row">
											<label for="tablecell"><?php esc_html_e('Mapbox Account Username', 'mapbox_data_for_wordpress'); ?></label>
										</td>
										<td>
											<input type="text" name="mapbox_account_username" value="<?php esc_attr_e( $mapbox_account_username ); ?>" class="regular-text" />
										</td>
									</tr>
									<tr>
										<td scope="row">
											<label for="tablecell"><?php esc_html_e('Mapbox Access Token', 'mapbox-data-for-wordpress'); ?></label>
										</td>
										<td>
											<input type="text" name="mapbox_access_token" value="<?php esc_attr_e( $mapbox_access_token ); ?>" class="regular-text" />
										</td>
									</tr>
									<tr>
										<td scope="row">
											<label for="tablecell"><?php esc_html_e('Mapbox Dataset ID', 'mapbox-data-for-wordpress'); ?></label>
										</td>
										<td>
											<input type="text" name="mapbox_dataset_id" value="<?php esc_attr_e( $mapbox_dataset_id ); ?>" class="regular-text" />
										</td>
									</tr>
									<tr>
										<td scope="row">
											<label for="tablecell"><?php esc_html_e('Mapbox Tileset ID', 'mapbox-data-for-wordpress'); ?></label>
										</td>
										<td>
											<input type="text" name="mapbox_tileset_id" value="<?php esc_attr_e( $mapbox_tileset_id ); ?>" class="regular-text" />
										</td>
									</tr>
									<tr>
										<td scope="row">
											<label for="tablecell"><?php esc_html_e('Send Categories', 'mapbox-data-for-wordpress'); ?></label>
										</td>
										<td>
											<input type="checkbox" name="mdfw_send_categories" value="1" <?php checked( $mdfw_send_categories, '1', TRUE ); ?> />
										</td>
									</tr>
									<tr>
										<td scope="row">
											<label for="tablecell"><?php esc_html_e('Send Tags', 'mapbox-data-for-wordpress'); ?></label>
										</td>
										<td>
											<input type="checkbox" name="mdfw_send_tags" value="1" <?php checked( $mdfw_send_tags, '1', TRUE ); ?> />
										</td>
									</tr>
								</table>

								<h2><span><?php esc_html_e( 'Custom Fields', 'mapbox-data-for-wordpress' ); ?></span></h2>

								<table class="form-table">
									<tr>
										<th class="row-title"><?php esc_html_e( 'Value Name', 'mapbox-data-for-wordpress' ); ?></th>
										<th><?php esc_html_e( 'Value Type', 'mapbox-data-for-wordpress' ); ?></th>
										<th><?php esc_html_e( 'Include in GeoJSON?', 'mapbox-data-for-wordpress' ); ?></th>
									</tr>

									<?php 
									for ($i=0; $i < $number_fields; $i++) { 
										$field_name = 'mdfw_custom_field_' . $i;
										$field_type = $field_name . '_type';
										$field_json = $field_name . '_json';
										?>
										<tr valign="top">

										<td scope="row">
											<input type="text" name="mdfw_custom_field_<?php esc_attr_e( $i ); ?>" value="<?php esc_attr_e( $$field_name ); ?>" class="regular-text" />
										</td>
										<td>
											<select name="<?php esc_attr_e( $field_type ); ?>" id="">
												<option <?php if ( $$field_type == 'text' ) : ?> selected="<?php esc_attr_e( 'selected' ); ?>"<?php endif; ?> value="text">Text</option>
												<option <?php if ( $$field_type == 'textarea' ) : ?> selected="<?php esc_attr_e( 'selected' ); ?>"<?php endif; ?> value="textarea">Textarea</option>
												<option <?php if ( $$field_type == 'checkbox' ) : ?> selected="<?php esc_attr_e( 'selected' ); ?>"<?php endif; ?> value="checkbox">Checkbox</option>
												<option <?php if ( $$field_type == 'radio' ) : ?> selected="<?php esc_attr_e( 'selected' ); ?>"<?php endif; ?> value="radio">Radio</option>
											</select>
										</td>
										<td>
											<input type="checkbox" value="1" name="mdfw_custom_field_<?php esc_attr_e( $i ); ?>_json" <?php checked( $$field_json, '1', TRUE ); ?> />
										</td>
									</tr>
									<?php } ?>
								</table>
								<p>
									<?php submit_button(
										'Save', 
										$type = 'primary', 
										$name = 'mdfw-settings-submit', 
										$wrap = FALSE, 
										$other_attributes = NULL
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

						<h2><span><?php esc_html_e(
									'About Mapbox Data for WordPress', 'mapbox-data-for-wordpress'
								); ?></span></h2>

						<div class="inside">
							<p><?php esc_html_e(
									'Mapbox Data for WordPress allows you to manage your Mapbox data points from right within your WordPress installation.',
									'mapbox-data-for-wordpress'
								); ?></p>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

					<div class="postbox">

						<h2><span><?php esc_html_e(
									'Send all existing data to Mapbox', 'mapbox-data-for-wordpress'
								); ?></span></h2>

						<div class="inside">
							<p><?php esc_html_e(
									'If you have updated your Mapbox data in bulk or changed your settings, use the button below to send all existing data to Mapbox again. If you want to limit the post range, include post IDs in the boxes below. Do not close the page while the data is being updated.',
									'mapbox-data-for-wordpress'
								); ?></p>
								<h4><?php esc_html_e(
									'Post Range', 'mapbox-data-for-wordpress'
								); ?></h4>
								<div class="post-range-fields">
									<div class="low"><input type="text" name="low" placeholder="<?php esc_html_e( 'Low', 'mapbox-data-for-wordpress' ); ?>"/></div>
									<div class="separator">-</div>
									<div class="high"><input type="text" name="high" placeholder="<?php esc_html_e( 'High', 'mapbox-data-for-wordpress' ); ?>"  /></div>
								</div>

								<?php $nonce = wp_create_nonce("mdfw_update_all_nonce"); ?>
								<a class="button-secondary mdfw-update-all" href="<?php echo esc_url( admin_url( 'admin-ajax.php?action=mdfw_update_all&nonce=' . $nonce ) ); ?>" data-nonce="<?php esc_attr_e( $nonce, 'mapbox-data-for-wordpress' ); ?>"><?php esc_html_e( 'Send all data to Mapbox' ); ?></a>
								<p class="sending-data"><span class="dashicons dashicons-update loader"></span><?php esc_html_e( 'Working... please leave the window open.', 'mapbox-data-for-wordpress' ); ?></p>
								<p class="data-sent"><span class="dashicons dashicons-yes"></span><?php esc_html_e( 'Done! You may now close this window.', 'mapbox-data-for-wordpress' ); ?></p>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

					<div class="postbox">

						<h2><span><?php esc_html_e(
									'Update Mapbox Tileset', 'mapbox-data-for-wordpress'
								); ?></span></h2>

						<div class="inside">
							<p><?php esc_html_e(
									'Update the Tileset from the Dataset. Clicking the below button will send the update request to Mapbox. After the request is sent, it may take a few minutes for the Mapbox servers to update the tileset.',
									'mapbox-data-for-wordpress'
								); ?></p>
								<?php $nonce = wp_create_nonce("mdfw_update_tileset_nonce"); ?>
								<a class="button-secondary mdfw-update-tileset" href="<?php echo esc_url( admin_url('admin-ajax.php?action=mdfw_update_tileset&nonce=' . $nonce ) ); ?>" data-nonce="<?php esc_attr_e( $nonce ); ?>"><?php esc_html_e( 'Update Tileset' ); ?></a>
								<p class="sending-data"><span class="dashicons dashicons-update loader"></span><?php esc_html_e( 'Working... please leave the window open.', 'mapbox-data-for-wordpress' ); ?></p>
								<p class="data-sent"><span class="dashicons dashicons-yes"></span><?php esc_html_e( 'The update request has been sent.', 'mapbox-data-for-wordpress' ); ?></p>
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