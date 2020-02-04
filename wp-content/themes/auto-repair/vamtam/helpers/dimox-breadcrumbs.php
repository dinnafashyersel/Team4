<?php

function dimox_breadcrumbs( $delimiter = '&gt;' ) {
	global $post;

	$home = __( 'Home', 'auto-repair' );
	$before = '<span class="current">'; // tag before the current crumb
	$after = '</span>'; // tag after the current crumb
	$delim_before = " <span class='delim'>";
	$delim_after = "</span> ";
	$delimiter = $delim_before.$delimiter.$delim_after;

	$homeLink = home_url();

	if ( wpv_has_woocommerce() && is_woocommerce() ) {
		woocommerce_breadcrumb( array(
			'delimiter' => $delimiter,
			'wrap_before' => '',
			'wrap_after' => '',
			'before' => '',
			'after' => '',
			'home' => $home,
		) );

		return;
	}

		echo '<a href="' . esc_url( $homeLink ) . '">' . $home . '</a> ' . $delimiter; // xss ok

	if ( ( ! is_home() && ! is_front_page() ) || is_paged() ) {


		if ( is_category() ) {
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$thisCat = get_category( $cat_obj->term_id );
			$parentCat = get_category( $thisCat->parent );

	  		if ( 0 !== $thisCat->parent ) {
	  			echo get_category_parents( $parentCat, true, ' ' . $delimiter . ' ' ); // xss ok
	  		}

	  		echo $before . __( 'Archive by category', 'auto-repair' ).' "' . single_cat_title( '', false ) . '"' . $after; // xss ok

		} elseif ( is_day() ) {
			echo '<a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' '; // xss ok
			echo '<a href="' . esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ) . '">' . get_the_time( 'F' ) . '</a> ' . $delimiter . ' '; // xss ok
			echo $before . get_the_time( 'd' ) . $after; // xss ok

		} elseif ( is_month() ) {
			echo '<a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' '; // xss ok
			echo $before . get_the_time( 'F' ) . $after; // xss ok

		} elseif ( is_year() ) {
			echo $before . get_the_time( 'Y' ) . $after; // xss ok

		} elseif ( is_single() && !is_attachment() ) {
			$post_type = get_post_type_object( get_post_type() );

			if ( get_post_type() != 'post' ) {
				if ( get_post_type() == 'portfolio' ) {
					echo '<a href="' . esc_url( trailingslashit( wpv_get_option( 'portfolio-all-items' ) ) ) . '">' . $post_type->labels->singular_name . '</a> '; // xss ok
				} else {
					$slug = $post_type->rewrite;
					echo '<a href="' . esc_url( trailingslashit( $homeLink . '/' . $slug['slug'] ) ) . '">' . $post_type->labels->singular_name . '</a> '; // xss ok
				}

				echo $delim_before.': '.$delim_after; // xss ok
				echo $before . get_the_title() . $after; // xss ok
			} else {
				echo '<a href="' . esc_url( trailingslashit( wpv_get_option( 'post-all-items' ) ) ) . '">' . __( 'Blog', 'auto-repair' ) . '</a> '; // xss ok
				$cat = get_the_category();
				if ( isset( $cat[0] ) ) {
					echo $delimiter . ' '; // xss ok
					$cat = $cat[0];
					if ( $cat !== null ) {
						get_category_parents( $cat, true, ' ' . $delimiter . ' ' );
					}
					echo "<a href='" . esc_url( get_category_link( $cat->term_id ) ) . "' title='" . esc_attr( $cat->name ) . "'>{$cat->name}</a>"; // xss ok
				}
				echo $delim_before.': '.$delim_after; // xss ok
				echo $before . get_the_title() . $after; // xss ok
	  		}
} elseif ( ! is_single() && ! is_page() && 'post' !== get_post_type() && is_object( $post ) ) {
			$post_type = get_post_type_object( get_post_type() );
			echo $before . $post_type->labels->singular_name . $after; // xss ok

		} elseif ( is_attachment() ) {
			$parent = get_post( $post->post_parent );
			$cat = get_the_category( $parent->ID );
			if ( count( $cat ) && null !== $cat[0] ) {
				get_category_parents( $cat[0], true, ' ' . $delimiter . ' ' );
			}
			echo '<a href="' . esc_url( get_permalink( $parent ) ) . '">' . $parent->post_title . '</a> ' . $delimiter . ' '; // xss ok
			echo $before . get_the_title() . $after; // xss ok

		} elseif ( is_page() && ! $post->post_parent ) {
			echo $before . get_the_title() . $after; // xss ok

		} elseif ( is_page() && $post->post_parent ) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ( $parent_id ) {
				$page = get_page( $parent_id );
				$breadcrumbs[] = '<a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . get_the_title( $page->ID ) . '</a>'; // xss ok
				$parent_id  = $page->post_parent;
			}
			$breadcrumbs = array_reverse( $breadcrumbs );
			echo implode( " $delimiter ", $breadcrumbs ); // xss ok
			echo $delim_before.': '.$delim_after; // xss ok
			echo $before . get_the_title() . $after; // xss ok

		} elseif ( is_search() ) {
			echo $before . __( 'Search results for', 'auto-repair' ).' "' . get_search_query() . '"' . $after; // xss ok

		} elseif ( is_tag() ) {
			echo $before . __( 'Posts tagged', 'auto-repair' ).' "' . single_tag_title( '', false ) . '"' . $after; // xss ok

		} elseif ( is_author() ) {
			global $author;
			$userdata = get_userdata( $author );
			echo $before . __( 'Articles posted by', 'auto-repair' ).' ' . $userdata->display_name . $after; // xss ok

		} elseif ( is_404() ) {
			echo $before . __( 'Error 404', 'auto-repair' ) . $after; // xss ok
		}

		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );

		if ( $paged ) {
			$braced = ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() );
			if ( $braced )
				echo ' ( ';

			echo ' ( '.__( 'Page', 'auto-repair' ) . ' ' . $paged.' )'; // xss ok

			if ( $braced )
				echo ' )';
		}
	}
}