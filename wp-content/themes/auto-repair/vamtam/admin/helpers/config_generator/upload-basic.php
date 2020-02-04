<?php
	global $post;

	$video   = isset($value['video']) ? !!$value['video'] : false;
	$button  = isset($value['button']) ? $value['button'] : __( 'Insert', 'auto-repair' );
	$remove  = isset($value['remove']) ? $value['remove'] : __( 'Remove', 'auto-repair' );
	$default = isset($GLOBALS['wpv_in_metabox']) ? get_post_meta( $post->ID, $id, true ) : wpv_get_option( $id, $default );

	$name = $id;
	$id   = preg_replace( '/[^\w]+/', '', $id );
?>

<div class="upload-basic-wrapper <?php echo esc_attr( ! empty( $default ) ? 'active' : '' ) ?>">
	<div class="image-upload-controls <?php if ( $video ) echo 'wpv-video-upload-controls' // xss ok ?>">
		<input type="text" id="<?php echo esc_attr( $id ) ?>" name="<?php echo esc_attr( $name ) ?>" value="<?php echo esc_attr( $default ) ?>" class="image-upload <?php wpv_static( $value )?> <?php if ( ! $video ) echo 'hidden' // xss ok ?>" />

		<a class="button wpv-upload-button <?php if ( $video ) echo 'wpv-video-upload' // xss ok ?>" href="#" data-target="<?php echo esc_attr( $id ) ?>">
			<?php echo $button // xss ok ?>
		</a>

		<a class="button wpv-upload-clear <?php if ( empty( $default ) ) echo 'hidden' // xss ok ?>" href="#" data-target="<?php echo esc_attr( $id ) ?>"><?php echo $remove // xss ok ?></a>
		<a class="wpv-upload-undo hidden" href="#" data-target="<?php echo esc_attr( $id ) ?>"><?php echo __( 'Undo', 'auto-repair' ) // xss ok ?></a>
	</div>
	<div id="<?php echo esc_attr( $id ) ?>_preview" class="image-upload-preview <?php if ( $video ) echo 'hidden' // xss ok ?>">
		<img src="<?php echo esc_url( $default ) ?>" />
	</div>
</div>