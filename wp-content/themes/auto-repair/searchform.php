<?php
/**
 * Search form template
 *
 * @package wpv
 */
?>
<form role="search" method="get" class="searchform clearfix" action="<?php echo esc_url( home_url( '/' ) ) ?>">
	<label for="search-text-widget" class="visuallyhidden"><?php _e( 'Search for:', 'auto-repair' ) ?></label>
	<input id="search-text-widget" type="text" value="" name="s" placeholder="<?php _e( 'Search', 'auto-repair' )?>" required="required" />
	<input type="submit" value="<?php _e( 'Search', 'auto-repair' )?>" />
	<?php if ( defined( 'ICL_LANGUAGE_CODE' ) ) : ?>
		<input type="hidden" name="lang" value="<?php echo esc_attr( ICL_LANGUAGE_CODE ) ?>"/>
	<?php endif ?>
</form>