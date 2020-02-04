<?php

return array(
	"name" => __( "Styled List", 'auto-repair' ) ,
	"value" => "list",
	"options" => array(
		array(
			'name' => __( 'Style', 'auto-repair' ) ,
			'id' => 'style',
			'default' => '',
			'type' => 'icons',
		) ,
		array(
			"name" => __( "Color", 'auto-repair' ) ,
			"id" => "color",
			"default" => "",
			"options" => array(
				'accent1' => __( 'Accent 1', 'auto-repair' ),
				'accent2' => __( 'Accent 2', 'auto-repair' ),
				'accent3' => __( 'Accent 3', 'auto-repair' ),
				'accent4' => __( 'Accent 4', 'auto-repair' ),
				'accent5' => __( 'Accent 5', 'auto-repair' ),
				'accent6' => __( 'Accent 6', 'auto-repair' ),
				'accent7' => __( 'Accent 7', 'auto-repair' ),
				'accent8' => __( 'Accent 8', 'auto-repair' ),
			) ,
			"type" => "select",
		) ,
		array(
			"name" => __( "Content", 'auto-repair' ) ,
			"desc" => __( "Please insert a valid HTML unordered list", 'auto-repair' ) ,
			"id" => "content",
			"default" => "<ul>
				<li>list item</li>
				<li>another item</li>
			</ul>",
			"type" => "textarea"
		) ,
	)
);