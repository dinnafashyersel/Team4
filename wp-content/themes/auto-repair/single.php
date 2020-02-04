<?php
/**
 * Single post template
 *
 * @package wpv
 * @subpackage auto-repair
 */

get_header();

?>

<?php
if ( have_posts() ) :
	while ( have_posts() ) : the_post(); ?>

		<div class="row page-wrapper">
			<?php VamtamTemplates::left_sidebar() ?>

			<article <?php post_class( 'single-post-wrapper '.VamtamTemplates::get_layout() )?>>
				<?php
					global $wpv_has_header_sidebars;
					if ( $wpv_has_header_sidebars ) {
						VamtamTemplates::header_sidebars();
					}
				?>
				<div class="page-content loop-wrapper clearfix full">
					<?php get_template_part( 'templates/post' ); ?>
					<div class="clearboth">
						<?php comments_template(); ?>
					</div>
				</div>
			</article>

			<?php VamtamTemplates::right_sidebar() ?>

			<?php if ( wpv_get_optionb( 'show-related-posts' ) && is_singular( 'post' ) ) : ?>
				<?php
					$terms = array();
					$cats  = get_the_category();
					foreach ( $cats as $cat ) {
						$terms[] = $cat->term_id;
					}
				?>
				<div class="related-posts">
					<div class="clearfix">
						<div class="grid-1-1">
							<?php echo apply_filters( 'wpv_related_posts_title', '<h2 class="related-content-title">'.wpv_get_option( 'related-posts-title' ).'</h3>' ) // xss ok ?>
							<?php
								echo WPV_Blog::shortcode( array(
									'count' => 8,
									'column' => 4,
									'cat' => $terms,
									'layout' => 'scroll-x',
									'show_content' => true,
									'post__not_in' => get_the_ID(),
								) ); // xss ok
							?>
						</div>
					</div>
				</div>
			<?php endif ?>
		</div>
	<?php endwhile;
endif;

get_footer();
