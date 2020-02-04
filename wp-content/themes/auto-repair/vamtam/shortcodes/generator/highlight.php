<?php

return array(
	"name" => __( "Highlight", 'auto-repair' ) ,
	"value" => "highlight",
	"options" => array(
		array(
			"name" => __( "Type", 'auto-repair' ) ,
			"id" => "type",
			"default" => '',
			"options" => array(
				"light" => __( "light", 'auto-repair' ) ,
				"dark" => __( "dark", 'auto-repair' ) ,
			) ,
			"type" => "select",
		) ,
		array(
			"name" => __( "Content", 'auto-repair' ) ,
			"id" => "content",
			"default" => "",
			"type" => "textarea"
		) ,
	)
);