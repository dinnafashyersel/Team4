<?php
/**
 * Comments template
 *
 * @package wpv
 * @subpackage the-wedding-day
 */

?>

<?php if ( 'open' === $post->comment_status ) : ?>

	<div id="comments">
		<div class="respond-box">
			<?php if ( get_option( 'comment_registration' ) && ! $user_ID ) : ?>
				<p id="login-req"><?php printf( __( 'You must be <a href="%s" title="Log in">logged in</a> to post in the Guestbook.', 'shape' ), esc_url( get_option( 'siteurl' ) . '/wp-login.php?redirect_to=' . get_permalink() ) ) // xss ok ?></p>
			<?php else : ?>
				<?php
					$req = get_option( 'require_name_email' );

					// cookies consent
					$commenter = wp_get_current_commenter();
					$consent   = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

					comment_form( array(
						'title_reply' => '',
						'title_reply_to' => '',
						'logged_in_as' => '<p class="logged-in-as grid-1-1">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), wp_get_current_user()->display_name, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
						'fields' => array(
							'author' => '<div class="comment-form-author form-input grid-1-2">' . '<label for="author">' . __( 'Name:', 'auto-repair' ) . '</label>' . ( $req ? ' <span class="required">*</span>' : '' ) . // xss ok
							'<input id="author" name="author" type="text" required="required" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" placeholder="'.esc_attr( __( 'John Doe', 'auto-repair' ) ).'" /></div>',
							'email'  => '<div class="comment-form-email form-input grid-1-2"><label for="email">' . __( 'Email:', 'auto-repair' ) . '</label> ' . ( $req ? ' <span class="required">*</span>' : '' ) . '<span class="comment-note">' . __( 'Your email address will not be published.', 'auto-repair' ) . '</span>'. // xss ok
							'<input id="email" name="email" type="email" required="required" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" placeholder="email@example.com" /></div>',
							'cookies' => '<p class="comment-form-cookies-consent grid-1-1"><label for="wp-comment-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' /> ' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'auto-repair' ) . '</label></p>',
						),
						'comment_field' => '<div class="comment-form-comment grid-1-1"><label for="comment">' . __( 'Message:', 'auto-repair' ) . '</label><textarea id="comment" name="comment" required="required" aria-required="true" placeholder="' . esc_attr__( 'Write us something nice or just a funny joke...', 'auto-repair' ) . '" rows="2"></textarea></div>', // xss ok
						'comment_notes_before' => '',
						'comment_notes_after' => '',
						'label_submit' => __( 'Add message', 'auto-repair' ),
					) );
				?>

			<?php endif /* if ( get_option( 'comment_registration' ) && !$user_ID ) */ ?>
		</div><!-- .respond-box -->

		<?php
			$req = get_option( 'require_name_email' ); // Checks if fields are required.
			if ( 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
				die( 'Please do not load this page directly. Thanks!' );
			}

			if ( ! empty( $post->post_password ) ) :
				if ( post_password_required() ) :
		?>
					</div><!-- #comments -->

	<?php
					return;
				endif;
			endif;
	?>

	<?php if ( have_comments() ) : ?>
		<?php // numbers of pings and comments
		$ping_count = $comment_count = 0;
		foreach ( $comments as $comment ) {
			get_comment_type() == 'comment' ? ++$comment_count : ++$ping_count;
		}
		?>

		<h5 class="comments-title"><?php comments_popup_link( __( '0 <span class="comment-word">People wrote to us:</span>', 'auto-repair' ), __( '1 <span class="comment-word">Person wrote to us:</span>', 'auto-repair' ), __( '% <span class="comment-word">People wrote to us:</span>', 'auto-repair' ) ); ?></h5>

		<?php if ( $comment_count ) : ?>
			<?php
				$cube_options = array(
					'layoutMode'        => 'grid',
					'sortToPreventGaps' => true,
					'defaultFilter'     => '*',
					'animationType'     => 'quicksand',
					'gapHorizontal'     => 30,
					'gapVertical'       => 30,
					'gridAdjustment'    => 'responsive',
					'mediaQueries'      => VamtamTemplates::scrollable_columns( 3 ),
					'displayType'       => 'bottomToTop',
					'displayTypeSpeed'  => 100,
				);

				wp_enqueue_script( 'cubeportfolio' );
				wp_enqueue_style( 'cubeportfolio' );
			?>
			<div id="comments-list" class="comments vamtam-comments-small vamtam-cubeportfolio cbp" data-columns="3" data-options="<?php echo esc_attr( json_encode( $cube_options ) ) ?>">
				<?php
					wp_list_comments( array(
						'avatar_size'       => 0,
						'type'              => 'comment',
						'reply_allowed'     => false,
						'max_depth'         => 0,
						'vamtam-layout'     => 'small',
						'callback'          => array( 'VamtamTemplates', 'comments' ),
						'reverse_top_level' => true,
						'reverse_children'  => true,
						'style'             => 'div',
					) );
				?>
			</div><!-- #comments-list.comments -->
		<?php endif; /* if ( $comment_count ) */ ?>
	<?php endif /* if ( $comments ) */ ?>

	<?php
		$comment_pages = paginate_comments_links( array(
	  'echo' => false,
		) );

		if ( ! empty( $comment_pages ) ) :
	?>
		<div class="wp-pagenavi comment-paging"><?php echo $comment_pages // xss ok ?></div>
	<?php endif ?>
</div><!-- #comments -->

<?php endif /* if ( 'open' == $post->comment_status ) */ ?>

