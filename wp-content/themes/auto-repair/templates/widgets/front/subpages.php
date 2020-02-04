<?php
echo $before_widget; // xss ok

if($title)
	echo $before_title . $title . $after_title; // xss ok
?>

<ul>
	<?php
		wp_list_pages(array(
	  'title_li' => '',
	  'echo' => 1,
	  'child_of' => $parent,
	  'sort_column' => $sortby,
	  'exclude' => $exclude,
	  'depth' => 1
		));
	?>
</ul>

<?php
	echo $after_widget; // xss ok