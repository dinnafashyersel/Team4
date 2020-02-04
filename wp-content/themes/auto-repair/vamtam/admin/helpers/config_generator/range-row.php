<?php
/**
 * select row
 */

global $post;
?>
<div class="wpv-config-row <?php echo esc_attr( $class ) ?> range-row clearfix">

	<div class="rtitle">
		<h4><?php echo $name // xss ok ?></h4>

		<?php wpv_description( '', $desc ) ?>
	</div>

	<div class="rcontent">
		<?php foreach ( $ranges as $id=>$s ) : ?>
			<?php
				$min  = isset( $s['min'] ) ? "min='{$s['min']}' " : '';
				$max  = isset( $s['max'] ) ? "max='{$s['max']}' " : '';
				$step = isset( $s['step'] ) ? "step='{$s['step']}' " : '';
				$unit = isset( $s['unit'] ) ? $s['unit'] : '';
			?>
			<div class="single-option">
				<div class="single-desc"><?php echo $s['desc'] // xss ok ?></div>

				<div class="range-input-wrap clearfix">
					<span>
						<input name="<?php echo esc_attr( $id ) ?>" id="<?php echo esc_attr( $id ) ?>" type="text" value="<?php echo esc_attr( wpv_get_option( $id, $s['default'] ) ) ?>" <?php echo $min.$max.$step // xss ok ?> class="wpv-range-input <?php wpv_static( $value )?>" />
						<span><?php echo $unit // xss ok ?></span>
					</span>
				</div>
			</div>
		<?php endforeach ?>
	</div>
</div>
