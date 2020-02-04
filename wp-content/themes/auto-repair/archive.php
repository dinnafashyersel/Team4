<?php
/**
 * Archive page template
 *
 * @package wpv
 * @subpackage auto-repair
 */

global $wp_query;

$wpv_title = get_the_archive_title();

get_header(); ?>

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
				<?php rewind_posts() ?>
				<?php get_template_part( 'loop', 'archive' ) ?>
			</div>
		</article>

		<?php VamtamTemplates::right_sidebar() ?>
	</div>
<?php endif ?>

<?php get_footer(); ?>
