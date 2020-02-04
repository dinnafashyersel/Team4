<?php
/**
 * begin section
 */

$id = isset( $slug ) ? $slug : $name;
if ( isset( $sub ) ) {
	$id = "$sub $id";
}
$id = preg_replace( '/[^\w]+/', '-', strtolower( $id ) );

global $wpv_loaded_config_groups;

?>
<div class="wpv-config-group" style="<?php if ( $wpv_loaded_config_groups++ > 0 ) echo 'display:none' // xss ok ?>" id="<?php echo esc_attr( $id )?>-tab-<?php echo intval( $wpv_loaded_config_groups - 1 ) ?>">
