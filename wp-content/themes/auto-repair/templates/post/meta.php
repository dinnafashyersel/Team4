<?php
/**
 * Post metadata template
 *
 * @package  wpv
 */
?>
<div class="post-meta">
	<nav class="clearfix">
		<?php if(wpv_get_optionb( 'show-post-author' )): ?>
			<div class="author"><span class="icon theme"><?php wpv_icon( 'ink-tool' );?></span><?php the_author_posts_link()?></div>
		<?php endif ?>

		<?php if(!post_password_required()): ?>
			<?php if(wpv_get_optionb( 'meta_comment_count' ) && comments_open()): ?>
				<div class="comment-count">
					<a href="<?php comments_link() ?>" class="icon theme"><?php wpv_icon( 'bubble' )?></a><?php comments_popup_link( __( '0 <span class="comment-word">Comments</span>', 'auto-repair' ), __( '1 <span class="comment-word">Comment</span>', 'auto-repair' ), __( '% <span class="comment-word">Comments</span>', 'auto-repair' ) ); ?>
				</div>
			<?php endif; ?>

			<?php if(wpv_get_optionb( 'meta_posted_in' )): ?>
				<div><span class="icon"><?php wpv_icon( 'folder1' ); ?></span><span class="visuallyhidden"><?php _e( 'Category', 'auto-repair' ) ?></span><?php the_category( ', ' ); ?></div>
				<?php
				// Tags
				the_tags( '<div class="the-tags"><span class="icon">' . wpv_get_icon( 'tag' ) . '</span><span class="visuallyhidden">'.__( 'Tags', 'auto-repair' ).'</span>', ', ', '</div>' )?>
			<?php endif ?>
		<?php endif ?>

		<?php if (!is_single()): ?>
			<div class="blog-buttons">
				<?php edit_post_link( '<span class="icon">' . wpv_get_icon( 'pencil' ) . '</span><span>'. __( 'Edit', 'auto-repair' ) .'</span>' ) ?>
			</div>
		<?php endif ?>

		<?php if(function_exists( 'wpv_li_love_link' )): ?>
			<?php echo wpv_li_love_link('<span class="visuallyhidden">'.__( 'Love it', 'auto-repair' ).'</span>',
'<span class="visuallyhidden">'.__( 'You have loved this.', 'auto-repair' ).'</span>'); // xss ok ?>
		<?php endif ?>
	</nav>
</div>