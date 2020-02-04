<?php

$fields = array(
	'color'      => __( 'Color:', 'auto-repair' ),
	'opacity'    => __( 'Opacity:', 'auto-repair' ),
	'image'      => __( 'Image / pattern:', 'auto-repair' ),
	'repeat'     => __( 'Repeat:', 'auto-repair' ),
	'attachment' => __( 'Attachment:', 'auto-repair' ),
	'position'   => __( 'Position:', 'auto-repair' ),
	'size'       => __( 'Size:', 'auto-repair' ),
);

$sep = isset( $sep ) ? $sep : '-';

$current = array();

if ( ! isset( $only ) ) {
	if ( isset( $show ) ) {
		$only = explode( ',', $show );
	} else {
		$only = array();
	}
} else {
	$only = explode( ',', $only );
}

$show = array();

global $post;
foreach ( $fields as $field => $fname ) {
	if ( isset( $GLOBALS['wpv_in_metabox'] ) ) {
		$current[$field] = get_post_meta( $post->ID, "$id-$field", true );
	} else {
		$current[$field] = wpv_get_option( "$id-$field" );
	}
	$show[$field] = ( in_array( $field, $only ) || sizeof( $only ) == 0 );
}

$selects = array(
	'repeat' => array(
		'no-repeat' => __( 'No repeat', 'auto-repair' ),
		'repeat-x'  => __( 'Repeat horizontally', 'auto-repair' ),
		'repeat-y'  => __( 'Repeat vertically', 'auto-repair' ),
		'repeat'    => __( 'Repeat both', 'auto-repair' ),
	),
	'attachment' => array(
		'scroll' => __( 'scroll', 'auto-repair' ),
		'fixed'  => __( 'fixed', 'auto-repair' ),
	),
	'position' => array(
		'left center'   => __( 'left center', 'auto-repair' ),
		'left top'      => __( 'left top', 'auto-repair' ),
		'left bottom'   => __( 'left bottom', 'auto-repair' ),
		'center center' => __( 'center center', 'auto-repair' ),
		'center top'    => __( 'center top', 'auto-repair' ),
		'center bottom' => __( 'center bottom', 'auto-repair' ),
		'right center'  => __( 'right center', 'auto-repair' ),
		'right top'     => __( 'right top', 'auto-repair' ),
		'right bottom'  => __( 'right bottom', 'auto-repair' ),
	),
);

?>

<div class="wpv-config-row background clearfix <?php echo esc_attr( $class ) ?>">

	<div class="rtitle">
		<h4><?php echo $name // xss ok ?></h4>

		<?php wpv_description( $id, $desc ) ?>
	</div>

	<div class="rcontent">
		<div class="bg-inner-row">
			<?php if ( $show['color'] ) : ?>
				<div class="bg-block color">
					<div class="single-desc"><?php _e( 'Color:', 'auto-repair' ) ?></div>
					<input name="<?php echo esc_attr( $id . $sep . 'color' ) // xss ok ?>" id="<?php echo esc_attr( $id ) ?>-color" type="text" data-hex="true" value="<?php echo esc_attr( $current['color'] ) ?>" class="wpv-color-input" />
				</div>
			<?php endif ?>

			<?php if ( $show['opacity'] ) : ?>
				<div class="bg-block opacity range-input-wrap clearfix">
					<div class="single-desc"><?php _e( 'Opacity:', 'auto-repair' ) ?></div>
					<span>
						<input name="<?php echo esc_attr( $id . $sep . 'opacity' ) // xss ok ?>" id="<?php echo esc_attr( $id ) ?>-opacity" type="range" value="<?php echo esc_attr( $current['opacity'] )?>" min="0" max="1" step="0.05" class="wpv-range-input" />
					</span>
				</div>
			<?php endif ?>
		</div>

		<div class="bg-inner-row">
			<?php if ( $show['image'] ) : ?>
				<div class="bg-block bg-image">
					<div class="single-desc"><?php _e( 'Image / pattern:', 'auto-repair' ) ?></div>
					<?php $_id = $id;	$id .= $sep.'image'; // temporary change the id so that we can reuse the upload field ?>
					<div class="image <?php wpv_static( $value ) ?>">
						<?php include 'upload-basic.php'; ?>
					</div>
					<?php $id = $_id; unset( $_id ); ?>
				</div>
			<?php endif ?>

			<?php if ( $show['size'] ) : ?>
				<div class="bg-block bg-size">
					<div class="single-desc"><?php _e( 'Cover:', 'auto-repair' ) ?></div>
					<label class="toggle-radio">
						<input type="radio" name="<?php echo esc_attr( $id.$sep ) ?>size" value="cover" <?php checked( $current['size'], 'cover' ) ?>/>
						<span><?php _e( 'On', 'auto-repair' ) ?></span>
					</label>
					<label class="toggle-radio">
						<input type="radio" name="<?php echo esc_attr( $id.$sep ) ?>size" value="auto" <?php checked( $current['size'], 'auto' ) ?>/>
						<span><?php _e( 'Off', 'auto-repair' ) ?></span>
					</label>
				</div>
			<?php endif ?>

			<?php foreach ( $selects as $s => $options ) : ?>
				<?php if ( $show[$s] ) : ?>
					<div class="bg-block bg-<?php echo esc_attr( $s )?>">
						<div class="single-desc"><?php echo $fields[$s] // xss ok ?></div>
						<select name="<?php echo esc_attr( $id.$sep.$s ) ?>" class="bg-<?php echo esc_attr( $s ) ?>">
							<?php foreach ( $options as $val => $opt ) : ?>
								<option value="<?php echo esc_attr( $val ) ?>" <?php selected( $val, $current[$s] ) ?>><?php echo $opt // xss ok ?></option>
							<?php endforeach ?>
						</select>
					</div>
				<?php endif ?>
			<?php endforeach ?>
		</div>
	</div>
</div>