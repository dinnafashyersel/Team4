<?php
/**
 * upload field
 */
?>

<div class="wpv-config-row clearfix <?php echo esc_attr( $class ) ?>">
	<div class="rtitle">
		<h4><?php echo $name // xss ok ?></h4>

		<?php wpv_description( $id, $desc ) ?>
	</div>

	<div class="rcontent">
		<?php include 'upload-basic.php' ?>
	</div>
</div>