<?php
/**
 * 404 page template
 *
 * @package wpv
 * @subpackage auto-repair
 */

get_header(); ?>

<div class="clearfix">
	<div id="header-404">
		<div class="line-1">404</div>
		<div class="line-2"><?php _e( 'Holy guacamole!', 'auto-repair' ) ?></div>
		<div class="line-3"><?php _e( 'Looks like this page is kaput. Or on vacation. Or just playing hard to get. At any rate...it is not here.', 'auto-repair' ) ?></div>
		<div class="line-4"><?php printf( __( '<a href="%s">&larr; Go to the home page</a> or just search...', 'auto-repair' ), home_url() ) ?></div>
	</div>
	<div class="page-404">
		<?php get_search_form(); ?>
	</div>
</div>

<?php get_footer(); ?>