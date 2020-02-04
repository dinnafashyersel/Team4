<?php

if ( !empty( $flickr_id ) ):

$url = sprintf( 'http://www.flickr.com/badge_code_v2.gne?count=%s&display=%s&size=s&layout=x&source=%s&%s=%s', $count, $display, $type, $type, $flickr_id );

echo $before_widget; // xss ok
if($title)
	echo $before_title . $title . $after_title; // xss ok
?>
	<div class="flickr_wrap clearfix">
		<script type="text/javascript" src="<?php echo esc_url( $url ) ?>"></script>
	</div>
<?php
echo $after_widget; // xss ok
endif;
