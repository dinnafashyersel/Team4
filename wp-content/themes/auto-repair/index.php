<?php
/**
 * Catch-all template
 *
 * @package wpv
 * @subpackage auto-repair
 */



$format = get_query_var( 'format_filter' );
$wpv_title = $format ? sprintf( __( 'Post format: %s', 'auto-repair' ), $format ) : __( 'Blog', 'auto-repair' );
get_header();
?>
<div class="row page-wrapper">
	<?php VamtamTemplates::left_sidebar() ?>

	<article <?php post_class( VamtamTemplates::get_layout() ) ?>>
		<?php
		global $wpv_has_header_sidebars;
		if ( $wpv_has_header_sidebars ) {
			VamtamTemplates::header_sidebars();
		}
		?>
		<div class="page-content">
			<?php get_template_part( 'loop', 'index' ); ?>
		</div>
	</article>

	<?php VamtamTemplates::right_sidebar() ?>
</div>
<?php get_footer(); ?>
