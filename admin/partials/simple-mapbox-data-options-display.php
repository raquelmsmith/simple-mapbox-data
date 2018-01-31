<?php
/**
 * Provide the markup for the options page for the plugin.
 *
 *
 * @link       raquelmsmith.com
 * @since      1.0.0
 *
 * @package    Simple_Mapbox_Data
 * @subpackage Simple_Mapbox_Data/admin/partials
 */
?>

<div class="wrap">

	<h1><?php esc_attr_e( 'Simple Mapbox Data Settings', 'simple-mapbox-data' ); ?></h1>

	<p class="docs"><a href="<?php echo esc_url( 'https://raquelmsmith.com/blog/docs/simple-mapbox-data/' ); ?>" target="_blank"><?php esc_html_e( 'Documentation', 'simple-mapbox-data' ); ?></a></p>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">

						<h2><?php esc_html_e( 'Mapbox Info', 'simple-mapbox-data' ); ?></h2>

						<div class="inside">
							<p><?php esc_html_e(
									'We need this info to send data to your Mapbox account.',
									'simple-mapbox-data'
								); ?></p>
							<form name="smd_mapbox_info_form" method="post" action="">
								<input type="hidden" name="smd_mapbox_info_form_submitted" value="Y">
								<input type="hidden" name="smd_options_nonce" value="<?php esc_attr_e( wp_create_nonce('smd_options_nonce_value') ); ?>" />
								<table class="form-table">
									<tr>
										<td scope="row">
											<label for="tablecell"><?php esc_html_e('Mapbox Account Username', 'simple_mapbox_data'); ?></label>
										</td>
										<td>
											<input type="text" name="mapbox_account_username" value="<?php esc_attr_e( $mapbox_account_username ); ?>" class="regular-text" />
										</td>
									</tr>
									<tr>
										<td scope="row">
											<label for="tablecell"><?php esc_html_e('Mapbox Access Token', 'simple-mapbox-data'); ?></label>
										</td>
										<td>
											<input type="text" name="mapbox_access_token" value="<?php esc_attr_e( $mapbox_access_token ); ?>" class="regular-text" />
										</td>
									</tr>
									<tr>
										<td scope="row">
											<label for="tablecell"><?php esc_html_e('Mapbox Dataset ID', 'simple-mapbox-data'); ?></label>
										</td>
										<td>
											<input type="text" name="mapbox_dataset_id" value="<?php esc_attr_e( $mapbox_dataset_id ); ?>" class="regular-text" />
										</td>
									</tr>
									<tr>
										<td scope="row">
											<label for="tablecell"><?php esc_html_e('Mapbox Tileset ID', 'simple-mapbox-data'); ?></label>
										</td>
										<td>
											<input type="text" name="mapbox_tileset_id" value="<?php esc_attr_e( $mapbox_tileset_id ); ?>" class="regular-text" />
										</td>
									</tr>
									
								</table>

								<h2><?php esc_html_e( 'Custom Fields', 'simple-mapbox-data' ); ?></h2>

								<table class="form-table">
									<tr>
										<th class="row-title"><?php esc_html_e( 'Value Name', 'simple-mapbox-data' ); ?></th>
										<th class="row-title"><?php esc_html_e( 'Value Type', 'simple-mapbox-data' ); ?></th>
									</tr>

									<?php 
									for ($i=0; $i < $number_fields; $i++) { 
										$field_name = 'smd_custom_field_' . $i;
										$field_type = $field_name . '_type';
										?>
										<tr valign="top">

										<td scope="row">
											<input type="text" name="smd_custom_field_<?php esc_attr_e( $i ); ?>" value="<?php esc_attr_e( $$field_name ); ?>" class="regular-text" />
										</td>
										<td>
											<select name="<?php esc_attr_e( $field_type ); ?>" id="">
												<option <?php if ( $$field_type == 'text' ) : ?> selected="<?php esc_attr_e( 'selected' ); ?>"<?php endif; ?> value="text">Text</option>
												<option <?php if ( $$field_type == 'textarea' ) : ?> selected="<?php esc_attr_e( 'selected' ); ?>"<?php endif; ?> value="textarea">Textarea</option>
												<option <?php if ( $$field_type == 'checkbox' ) : ?> selected="<?php esc_attr_e( 'selected' ); ?>"<?php endif; ?> value="checkbox">Checkbox</option>
											</select>
										</td>
									</tr>
									<?php } ?>
								</table>
								<p>
									<?php submit_button(
										'Save', 
										$type = 'primary', 
										$name = 'smd-settings-submit', 
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

					<div class="postbox about">

						<h2><span><?php esc_html_e(
									'About Simple Mapbox Data', 'simple-mapbox-data'
								); ?></span></h2>

						<div class="inside">
							<p><?php esc_html_e(
									'Simple Mapbox Data allows you to manage your Mapbox data points from right within your WordPress installation.',
									'simple-mapbox-data'
								); ?></p>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

					<div class="postbox">

						<h2><span><?php esc_html_e(
									'Send all existing data to Mapbox', 'simple-mapbox-data'
								); ?></span></h2>

						<div class="inside">
							<p><?php esc_html_e(
									'If you have updated your Mapbox data in bulk or changed your settings, use the button below to send all existing data to Mapbox again. If you want to limit the post range, include post IDs in the boxes below. Do not close the page while the data is being updated.',
									'simple-mapbox-data'
								); ?></p>
								<h4><?php esc_html_e(
									'Post Range', 'simple-mapbox-data'
								); ?></h4>
								<div class="post-range-fields">
									<div class="low"><input type="text" name="low" placeholder="<?php esc_html_e( 'Low', 'simple-mapbox-data' ); ?>"/></div>
									<div class="separator">-</div>
									<div class="high"><input type="text" name="high" placeholder="<?php esc_html_e( 'High', 'simple-mapbox-data' ); ?>"  /></div>
								</div>

								<?php $nonce = wp_create_nonce("smd_update_all_nonce"); ?>
								<a class="button-secondary smd-update-all" href="<?php echo esc_url( admin_url( 'admin-ajax.php?action=smd_update_all&nonce=' . $nonce ) ); ?>" data-nonce="<?php esc_attr_e( $nonce, 'simple-mapbox-data' ); ?>"><?php esc_html_e( 'Send all data to Mapbox' ); ?></a>
								<p class="sending-data"><span class="dashicons dashicons-update loader"></span><?php esc_html_e( 'Working... please leave the window open.', 'simple-mapbox-data' ); ?></p>
								<p class="data-sent"><span class="dashicons dashicons-yes"></span><?php esc_html_e( 'Done! You may now close this window.', 'simple-mapbox-data' ); ?></p>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

					<div class="postbox">

						<h2><span><?php esc_html_e(
									'Update Mapbox Tileset', 'simple-mapbox-data'
								); ?></span></h2>

						<div class="inside">
							<p><?php esc_html_e(
									'Update the Tileset from the Dataset. Clicking the below button will send the update request to Mapbox. After the request is sent, it may take a few minutes for the Mapbox servers to update the tileset.',
									'simple-mapbox-data'
								); ?></p>
								<?php $nonce = wp_create_nonce("smd_update_tileset_nonce"); ?>
								<a class="button-secondary smd-update-tileset" href="<?php echo esc_url( admin_url('admin-ajax.php?action=smd_update_tileset&nonce=' . $nonce ) ); ?>" data-nonce="<?php esc_attr_e( $nonce ); ?>"><?php esc_html_e( 'Update Tileset' ); ?></a>
								<p class="sending-data"><span class="dashicons dashicons-update loader"></span><?php esc_html_e( 'Working... please leave the window open.', 'simple-mapbox-data' ); ?></p>
								<p class="data-sent"><span class="dashicons dashicons-yes"></span><?php esc_html_e( 'The update request has been sent.', 'simple-mapbox-data' ); ?></p>
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