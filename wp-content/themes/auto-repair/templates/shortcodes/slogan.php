<?php
	/**
	 * Slogan shortcode template
	 *
	 * @package wpv
	 * @subpackage auto-repair
	 */
?>
<div class="slogan clearfix <?php echo ( ! empty( $button_text ) ) ? ' has-button' : '' // xss ok ?>">
	<div class="slogan-content"<?php if ( ! empty( $text_color ) ) echo " style=\"color:$text_color;\""; // xss ok ?>>
		<?php echo do_shortcode( $content ); // xss ok ?>
	</div>
	<?php if ( ! empty( $button_text ) ): ?>
	<div class="button-wrp">
		<?php echo do_shortcode( '[button link="'.$link.'" bgColor="accent2" icon="'.$button_icon.'" icon_color="'.$button_icon_color.'" icon_placement="'.$button_icon_placement.'"]'.$button_text.'[/button]' ) // xss ok ?>
	</div>
	<?php endif ?>
</div>
