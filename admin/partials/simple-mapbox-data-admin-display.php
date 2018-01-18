<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the custom meta box fields 
 * for posts of the map_data_point post type.
 *
 * @link       raquelmsmith.com
 * @since      1.0.0
 *
 * @package    Simple_Mapbox_Data
 * @subpackage Simple_Mapbox_Data/admin/partials
 */
?>

<?php
	$custom_meta_fields = $this->create_custom_meta_fields_array();
?>
	<input type="hidden" name="map_data_point_meta_box_nonce" value="<?php esc_attr_e( wp_create_nonce('map_data_point_meta_box_nonce_value') ); ?>" />
     
    <table class="form-table">
    <?php foreach ($custom_meta_fields as $field) {
    	$field_id =  strtolower( preg_replace( "/\s/", "_", $field[ 'id' ] ) );
        // get value of this field if it exists for this post
        $meta = get_post_meta( get_the_ID() , '_' . $field_id , true); ?>
        <tr>
            <th><label for="<?php esc_attr_e( $field_id ); ?>"><?php esc_html_e( $field['label'] ); ?></label></th>
            <td>
            <?php switch($field['type']) {
                // text
				case 'text':
				    echo '<input type="text" name="' . esc_attr( $field_id ) . '" id="' . esc_attr( $field_id ) . '" value="' . esc_attr( $meta ) . '" size="30" />
				        <br />';
				        if ( isset( $field['desc'] ) ) {
				        	echo '<span class="description">' . esc_html( $field['desc'] ) . '</span>';
				        }
					break;
				// textarea
				case 'textarea':
				    echo '<textarea name="' . esc_attr( $field_id ) . '" id="' . esc_attr( $field_id ) . '" cols="60" rows="4">' . esc_html( $meta ) . '</textarea>
				        <br />';
				        if ( isset( $field['desc'] ) ) {
				        	echo '<span class="description">' . esc_html( $field['desc'] ) . '</span>';
				        }
					break;
				// checkbox
				case 'checkbox':
				    echo '<input type="checkbox" name="' . esc_attr( $field_id ) . '" id="' . esc_attr( $field_id ) .'" ',$meta ? ' checked="checked"' : '','/>
				        <label for="' . esc_attr( $field_id ) . '">' . esc_html( $field['desc'] ) . '</label>';
					break;
				// select
				case 'select':
				    echo '<select name="' . esc_attr( $field_id ) . '" id="' . esc_attr( $field_id ) . '">';
				    foreach ($field['options'] as $option) {
				        echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="' . $option['value'] . '">' . $option['label'] . '</option>';
				    }
				    echo '</select><br />';
				        if ( isset( $field['desc'] ) ) {
				        	echo '<span class="description">' . esc_html( $field['desc'] ) . '</span>';
				        }
					break;
                } //end switch ?>
        	</td>
        </tr>
    <?php } //end foreach ?>
	</table>