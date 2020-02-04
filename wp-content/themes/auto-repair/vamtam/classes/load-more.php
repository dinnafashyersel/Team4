<?php

/**
 * VamTam load more for Cube Portfolio
 *
 * @author Nikolay Yordanov <me@nyordanov.com>
 * @package vip-restaurant
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class VamtamLoadMore {
	private static $instance;

	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		add_action( 'wp_ajax_vamtam-load-more', array( $this, 'get_items' ) );
		add_action( 'wp_ajax_nopriv_vamtam-load-more', array( $this, 'get_items' ) );
	}

	public function get_items() {
		$query_args = array_intersect_key(
			$_POST['query'],
			array_flip( array( 'post_type', 'orderby', 'order', 'posts_per_page', 'paged', 'tax_query', 'post__in', 'post__not_in', 'category__in' ) )
		);

		if ( ! isset( $query_args['post_type'] ) ) {
			$query_args['post_type'] = 'post';
		}

		$other_vars = array();

		$GLOBALS['vamtam_inside_cube'] = true;

		ob_start();

		$query = new WP_Query( $query_args );

		while ( $query->have_posts() ) {
			$query->the_post();

			if ( 'portfolio' === $query_args['post_type'] ) {
				$other_vars = $vamtam_loop_vars = array_intersect_key(
					$_POST['other_vars'],
					array_flip( array( 'layout', 'nopaging', 'column', 'max', 'desc', 'cat', 'ids' ) ) // allowed keys
				);

				extract( $other_vars );

				include locate_template( 'templates/portfolio/loop/item.php' );
			} else if ( 'post' === $query_args['post_type'] ) {
				global $vamtam_loop_vars;

				$vamtam_loop_vars = $other_vars = array_intersect_key(
					$_POST['other_vars'],
					array_flip( array( 'show_content', 'news', 'column', 'layout' ) )
				);

				extract( $other_vars );

				$post_class = array(
					'page-content post-header',
					"grid-1-$column",
					'list-item',
					'cbp-item',
				);

				?>
				<div <?php post_class( implode( ' ', $post_class ) ) ?> >
					<div>
						<?php get_template_part( 'templates/post' );	?>
					</div>
				</div>
				<?php
			}
		}

		header( 'Content-Type: application/json' );

		echo json_encode( array(
			'content' => ob_get_clean(),
			'button'  => VamtamTemplates::pagination( 'load-more', false, $other_vars, $query ),
		) );

		exit;
	}
}
