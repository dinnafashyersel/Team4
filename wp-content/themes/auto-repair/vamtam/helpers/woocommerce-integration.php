<?php

/**
 * WooCommerce-related functions and filters
 *
 * @package wpv
 */

/**
 * Alias for function_exists('is_woocommerce')
 * @return bool whether WooCommerce is active
 */
function wpv_has_woocommerce() {
	return function_exists( 'is_woocommerce' );
}

if ( wpv_has_woocommerce() ) {
	// we have woocommerce
	add_theme_support( 'woocommerce' );

	// replace the default pagination with ours
	function woocommerce_pagination() {
		VamtamTemplates::pagination_list();
	}

	function vamtam_woocommerce_columns() {
		return 4;
	}

	// remove the WooCommerce breadcrumbs
	// we're still using their breadcrumbs, but a little higher in the HTML
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20,0 );

	// remove the WooCommerve sidebars
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

	/**
	 * Redefine woocommerce_output_related_products()
	 */
	function woocommerce_output_related_products() {
		woocommerce_related_products(array(
			'columns'        => 4,
			'posts_per_page' => 4,
		) );
	}

	/**
	 * Catalog products per page
	 */
	function vamtam_wc_loop_shop_per_page( $per_page ) {
		return 9;
	}
	add_filter( 'loop_shop_per_page', 'vamtam_wc_loop_shop_per_page', 10 );

	function vamtam_wc_loop_shop_columns( $cols ) {
		return 3;
	}
	add_filter( 'loop_shop_columns', 'vamtam_wc_loop_shop_columns', 10 );

	/**
	 * Set the number of gallery thumbnails per row
	 */
	add_filter( 'woocommerce_product_thumbnails_columns', 'vamtam_woocommerce_columns' );

	/**
	 * star rating used in the single product template
	 */
	function wpv_woocommerce_rating() {
		global $product;

		if ( !isset($product) || get_option( 'woocommerce_enable_review_rating' ) != 'yes' ) return;

		$count = $product->get_rating_count();

		if ( $count > 0 ) {

			$average = $product->get_average_rating();

			echo '<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';

			echo '<div class="star-rating" title="' . esc_attr( sprintf( __( 'Rated %s out of 5', 'woocommerce' ), $average ) ) . '"><span style="width:' . esc_attr( ( ( $average / 5 ) * 100 ) ) . '%"><strong itemprop="ratingValue" class="rating">' . $average . '</strong> <span class="visuallyhidden">' . __( 'out of 5', 'woocommerce' ) . '</span></span></div>'; // xss ok

			echo '</div>';

		}
	}
	add_action( 'woocommerce_single_product_summary', 'wpv_woocommerce_rating', 25, 0 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

	/**
	 * star rating for the shop loop, related product, etc.
	 */
	function woocommerce_template_loop_rating() {
		global $product;

		if ( !isset($product) || get_option( 'woocommerce_enable_review_rating' ) != 'yes' ) return;

		$count = $product->get_rating_count();

		if ( $count > 0 ) {

			$average = $product->get_average_rating();

			echo '<div class="aggregateRating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';

			echo '<div class="star-rating" title="' . esc_attr( sprintf( __( 'Rated %s out of 5', 'woocommerce' ), $average ) ) . '"><span style="width:' . ( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">' . $average . '</strong> <span class="visuallyhidden">' . __( 'out of 5', 'woocommerce' ) . '</span></span></div>'; // xss ok

			echo '</div>';

		}
	}

	/**
	 * wrap the product thumbnails in div.product-thumbnail
	 */
	function woocommerce_template_loop_product_thumbnail() {
		echo '<div class="product-thumbnail">' . woocommerce_get_product_thumbnail() . '</div>'; // xss ok
	}

	/**
	 * Show the product title in the product loop. By default this is an H3.
	 */
	function woocommerce_template_loop_product_title() {
		echo '<h3 class="woocommerce-loop-product__title">' . get_the_title() . '</h3>';
	}

	/**
	 * WooCommerce catalog/related products excerpt
	 */
	function wpv_woocommerce_catalog_excerpt() {
		global $post;

		if ( ! $post->post_excerpt ) return;

		$excerpt_length = apply_filters( 'wpv_woocommerce_catalog_excerpt_length', 60 );

		$excerpt = explode( "\n", wordwrap( $post->post_excerpt, $excerpt_length ) );
		if (count( $excerpt ) > 1)
			$excerpt[0] .= '...';
		$excerpt = $excerpt[0];
		?>

		<?php
	}
	add_action( 'woocommerce_after_shop_loop_item_title','wpv_woocommerce_catalog_excerpt', 0 );

	/**
	 * Single product social sharing
	 */
	function wpv_woocommerce_share() {
		VamtamTemplates::share( 'product' );
	}
	add_action( 'woocommerce_single_product_summary', 'wpv_woocommerce_share', 35, 0 );

	function wpv_woocommerce_cart_dropdown() {
		get_template_part( 'templates/cart-dropdown' );
	}
	add_action( 'wpv_header_cart', 'wpv_woocommerce_cart_dropdown' );

	function wpv_woocommerce_body_class($class) {
		if ( is_cart() || is_checkout() ) {
			$class[] = 'woocommerce';
		}

		return $class;
	}
	add_action( 'body_class', 'wpv_woocommerce_body_class' );

	function wpv_woocommerce_product_review_comment_form_args( $comment_form ) {
		$comment_form['comment_field'] = '';

		if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
			$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating">' . __( 'Your Rating', 'woocommerce' ) .'</label><select name="rating" id="rating">
				<option value="">' . __( 'Rate&hellip;', 'woocommerce' ) . '</option>
				<option value="5">' . __( 'Perfect', 'woocommerce' ) . '</option>
				<option value="4">' . __( 'Good', 'woocommerce' ) . '</option>
				<option value="3">' . __( 'Average', 'woocommerce' ) . '</option>
				<option value="2">' . __( 'Not that bad', 'woocommerce' ) . '</option>
				<option value="1">' . __( 'Very Poor', 'woocommerce' ) . '</option>
			</select></p>'; // xss ok
		}

		$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . __( 'Your Review', 'woocommerce' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required></textarea></p>';

		return $comment_form;
	}
	add_filter( 'woocommerce_product_review_comment_form_args', 'wpv_woocommerce_product_review_comment_form_args' );

	function wpv_product_loop_item_attributes() {
		global $post, $product;

		$attribute_names = apply_filters( 'wpv_product_loop_item_attributes', array( 'pa_brand' ) );

		foreach ( $attribute_names as $attribute_name ) {
			$taxonomy = get_taxonomy( $attribute_name );

			if ( $taxonomy && ! is_wp_error( $taxonomy ) ) {
				$terms = wp_get_post_terms( $post->ID, $attribute_name );
				$terms_array = array();

				if ( ! empty( $terms ) ) {
					foreach ( $terms as $term ) {
						array_push( $terms_array, $term->name );
					}

					echo apply_filters( 'wpv_product_loop_item_attributes_output', '<h5>' . implode( $terms_array, ', ' ) . '</h5>' ); // xss ok
				}
			}
		}
	}
	add_action( 'woocommerce_before_shop_loop_item_title', 'wpv_product_loop_item_attributes', 20 );

	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
	add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_price', 11 );

	/**
	 * Show a shop page description on product archives
	 *
	 * @access public
	 * @subpackage	Archives
	 * @return void
	 */
	function woocommerce_product_archive_description() {
		if ( is_post_type_archive( 'product' ) && get_query_var( 'paged' ) == 0 && ! is_search() ) {
			$shop_page   = get_post( wc_get_page_id( 'shop' ) );
			if ( $shop_page ) {
				// this IS content, why not apply the filters anyway?
				echo apply_filters( 'the_content', $shop_page->post_content ); // xss ok
			}
		}
	}

	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
	add_action( 'woocommerce_after_cart_table', 'woocommerce_cross_sell_display' );

	function vamtam_woocommerce_proceed_to_checkout_early() {
		echo '<input type="submit" class="button" name="update_cart" value="' . esc_attr__( 'Update cart', 'auto-repair' ) . '" />';
	}
	add_action( 'woocommerce_proceed_to_checkout', 'vamtam_woocommerce_proceed_to_checkout_early', 5 );
}