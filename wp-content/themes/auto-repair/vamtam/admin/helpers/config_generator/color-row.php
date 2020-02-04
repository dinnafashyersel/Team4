<?php
/**
 * multiple color inputs
 */
?>
<div class="wpv-config-row color-row clearfix <?php echo esc_attr( $class )  ?>">
	<div class="rtitle">
		<h4><?php echo $name // xss ok ?></h4>

		<?php wpv_description( '', $desc ) ?>
	</div>

	<div class="rcontent clearfix">
		<?php foreach ( $inputs as $id => $input ) : ?>
			<?php
				if ( ! isset( $input['default'] ) ) {
					$input['default'] = null;
				}

				$single_val = isset( $GLOBALS['wpv_in_metabox'] ) ?
					get_post_meta( $post->ID, $id, true ) :
					wpv_get_option( $id, $input['default'] );
			?>
			<div class="single-color">
				<div class="single-desc"><?php echo $input['name'] // xss ok ?></div>
				<div>
					<input name="<?php echo esc_attr( $id ) ?>" id="<?php echo esc_attr( $id ) ?>" type="text" data-hex="true" value="<?php echo esc_attr( $single_val ) ?>" class="wpv-color-input <?php wpv_static( $value )?>" />
				</div>
			</div>
		<?php endforeach ?>
	</div>
</div>