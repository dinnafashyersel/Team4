<?php foreach ( $results as $tweet ): WPV_Twitter::format_tweet( $tweet ) ?>
	<div class="single-tweet">
		<p class="tweet-text">
			<?php echo $tweet->text // xss ok ?>
		</p>
		<span class="tweet-time"><?php printf( __( '%s ago', 'auto-repair' ), human_time_diff( strtotime( $tweet->created_at ) ) ) ?></span>
	</div>
	<div class="tweet-divider"></div>
<?php endforeach; ?>