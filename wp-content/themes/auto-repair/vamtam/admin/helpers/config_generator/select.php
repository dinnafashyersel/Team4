<?php
/**
 * combobox
 */
?>

<?php
	if ( isset( $target ) ) {
		if ( isset( $options ) ) {
			$options = $options + WpvConfigGenerator::get_select_target_config( $target );
		} else {
			$options = WpvConfigGenerator::get_select_target_config( $target );
		}
	}

	$selected = wpv_get_option( $id, $default );

	$ff = empty( $field_filter ) ? '' : 'data-field-filter="' . esc_attr( $field_filter ) . '"';
?>

<div class="wpv-config-row clearfix <?php echo esc_attr( $class ) ?>" <?php echo $ff // xss ok ?>>
	<div class="rtitle">
		<h4><label for="<?php echo esc_attr( $id ) ?>"><?php echo $name // xss ok ?></label></h4>

		<?php wpv_description( $id, $desc ) ?>
	</div>

	<div class="rcontent">
		<select name="<?php echo esc_attr( $id ) ?>" id="<?php echo esc_attr( $id ) ?>" class="<?php wpv_static( $value )?>">

			<?php if ( isset( $prompt ) ) : ?>
				<option value=""><?php echo $prompt // xss ok ?></option>
			<?php endif ?>

			<?php foreach ( $options as $key => $option ) : ?>
				<option value="<?php echo esc_attr( $key )?>" <?php selected( $selected, $key ) ?>><?php echo $option // xss ok ?></option>
			<?php endforeach ?>

			<?php if ( isset( $page ) ) : ?>
				<?php
				$args = array(
					'depth'                 => $page,
					'child_of'              => 0,
					'selected'              => $selected,
					'echo'                  => 1,
					'name'                  => 'page_id',
					'id'                    => '',
					'show_option_none'      => '',
					'show_option_no_change' => '',
					'option_none_value'     => '',
				);

				$pages = get_pages( $args );

				echo walk_page_dropdown_tree( $pages,$depth,$args ); // xss ok
				?>
			<?php endif ?>

		</select>
		<br />

	</div>
</div>
