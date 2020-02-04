<?php
/**
 * Single page template
 *
 * @package wpv
 * @subpackage auto-repair
 */

get_header();
?>

<?php if ( have_posts() ) : the_post(); ?>
	<div class="row page-wrapper">
		<?php VamtamTemplates::left_sidebar() ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( VamtamTemplates::get_layout() ); ?>>
			<?php
			global $wpv_has_header_sidebars;
			if ( $wpv_has_header_sidebars ) {
				VamtamTemplates::header_sidebars();
			}
			?>
			<div class="page-content">
				<?php the_content(); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'auto-repair' ), 'after' => '</div>' ) ); ?>
				<?php VamtamTemplates::share( 'page' ) ?>
			</div>

			<?php comments_template( '', true ); ?>
		</article>

		<?php VamtamTemplates::right_sidebar() ?>

	</div>
<?php endif;

get_footer();
