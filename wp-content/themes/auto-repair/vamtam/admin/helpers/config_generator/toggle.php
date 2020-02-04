<?php
/**
 * on/off toggle
 */

$option  = $value;
$checked = wpv_get_option( $id, $default );

$ff = empty( $field_filter ) ? '' : 'data-field-filter="' . esc_attr( $field_filter ) . '"';
?>

<div class="wpv-config-row toggle <?php echo esc_attr( $class ) ?> clearfix" <?php echo $ff // xss ok ?>>
	<div class="rtitle">
		<h4><?php echo $name // xss ok ?></h4>

		<?php wpv_description( $id, $desc ) ?>
	</div>

	<div class="rcontent clearfix">
		<?php include 'toggle-basic.php' ?>
	</div>
</div>
