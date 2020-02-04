<?php
/**
 * select row
 */

global $post;
?>
<div class="wpv-config-row <?php echo esc_attr( $class ) ?> select-row clearfix">

	<div class="rtitle">
		<h4><?php echo $name // xss ok ?></h4>

		<?php wpv_description( '', $desc ) ?>
	</div>

	<div class="rcontent">
		<?php foreach ( $selects as $id=>$s ) : ?>
			<?php
				if ( isset( $s['target'] ) ) {
					if ( isset( $s['options'] ) ) {
						$s['options'] = $s['options'] + WpvConfigGenerator::get_select_target_config( $s['target'] );
					} else {
						$s['options'] = WpvConfigGenerator::get_select_target_config( $s['target'] );
					}
				}

				if ( isset( $GLOBALS['wpv_in_metabox'] ) ) {
					$selected = get_post_meta( $post->ID, $id, true );
				} else {
					$selected = wpv_get_option( $id, $s['default'] );
				}
			?>
			<div class="single-option">
				<div class="single-desc"><?php echo $s['desc'] // xss ok ?></div>

				<select name="<?php echo esc_attr( $id ) ?>" id="<?php echo esc_attr( $id ) ?>" class="<?php wpv_static( $value )?>">

					<?php if ( isset( $s['prompt'] ) ) : ?>
						<option value=""><?php echo $s['prompt'] // xss ok ?></option>
					<?php endif ?>

					<?php foreach ( $s['options'] as $key => $option ) : ?>
						<option value="<?php echo esc_attr( $key ) ?>" <?php selected( $selected, $key ) ?>><?php echo $option // xss ok ?></option>
					<?php endforeach ?>

					<?php if ( isset( $s['page'] ) ) : ?>
						<?php
						$args = array(
							'depth' => $s['page'],
							'child_of' => 0,
							'selected' => $selected,
							'echo' => 1,
							'name' => 'page_id',
							'id' => '',
							'show_option_none' => '',
							'show_option_no_change' => '',
							'option_none_value' => ''
						);
						$pages = get_pages( $args );

						echo walk_page_dropdown_tree( $pages,$depth,$args ); // xss ok
						?>
					<?php endif ?>
				</select>
			</div>
		<?php endforeach ?>
	</div>
</div>
