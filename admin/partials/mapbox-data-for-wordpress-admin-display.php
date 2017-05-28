<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       raquelmsmith.com
 * @since      1.0.0
 *
 * @package    Mapbox_Data_For_Wordpress
 * @subpackage Mapbox_Data_For_Wordpress/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php 
		$custom_meta_fields = $this->create_custom_meta_fields_array();

		// Use nonce for verification
		echo '<input type="hidden" name="map_data_point_meta_box_nonce" value="'.wp_create_nonce('map_data_point_meta_box_nonce_value').'" />';
	     
	    // Begin the field table and loop
	    echo '<table class="form-table">';
	    foreach ($custom_meta_fields as $field) {
	        // get value of this field if it exists for this post
	        $meta = get_post_meta( get_the_ID() , '_' . strtolower($field['id']), true);
	        // begin a table row with
	        echo '<tr>
	                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
	                <td>';
	                switch($field['type']) {
	                    // case items will go here
	                    // text
						case 'text':
						    echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
						        <br /><span class="description">'.$field['desc'].'</span>';
							break;
						// textarea
						case 'textarea':
						    echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
						        <br /><span class="description">'.$field['desc'].'</span>';
							break;
						// checkbox
						case 'checkbox':
						    echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
						        <label for="'.$field['id'].'">'.$field['desc'].'</label>';
							break;
						// select
						case 'select':
						    echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
						    foreach ($field['options'] as $option) {
						        echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						    }
						    echo '</select><br /><span class="description">'.$field['desc'].'</span>';
							break;
	                } //end switch
	        echo '</td></tr>';
	    } // end foreach
	    echo '</table>'; // end table