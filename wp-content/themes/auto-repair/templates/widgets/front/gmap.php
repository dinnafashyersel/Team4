<?php

echo $before_widget; // xss ok

if ($title)
	echo $before_title . $title . $after_title; // xss ok

$id = rand( 0, 10000 );

?>

<div class="frame"><div id="gmap_widget_<?php echo intval( $id ); ?>" class="google_map clearfix" style="height:<?php echo intval( $height ); ?>px"></div></div>
<script type="text/javascript">
	jQuery(function($) {
		$("#gmap_widget_<?php echo intval( $id ); ?>").gMap({
		    zoom: <?php echo intval( $zoom ); ?>,
		    markers:[{
				address: "<?php echo esc_attr( $address ); ?>",
				latitude: <?php echo $latitude; // xss ok ?>,
		    	longitude: <?php echo $longitude; // xss ok ?>,
		    	html: '<?php echo str_replace( "'", "\\'", $html ); // xss ok ?>',
		    	popup: <?php echo $popup; // xss ok ?>
			}],
			controls: false
		});
	});
</script>

<?php
echo $after_widget; // xss ok