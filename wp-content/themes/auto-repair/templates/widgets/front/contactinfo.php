<?php

echo $before_widget; // xss ok

$available_icons = array(
	'phone' => 'theme-phone',
	'cellphone' => 'theme-cellphone',
	'mail' => 'theme-mail',
	'name' => 'user',
	'address' => 'theme-map',
);

if ($title)
	echo $before_title . $title . $after_title; // xss ok

$sc_data = '';

foreach($this->fields as $name=>$field) {
	if(!empty($field['value']) && $name != 'title') {
		if($name === 'mail')
			$name = 'email';
		$sc_data .= $name . '="'.$field['value'].'" ';
	}
}

echo do_shortcode( '[contact_info color="' . esc_attr( $color ) . '" ' .$sc_data.']' ); // xss ok

echo $after_widget; // xss ok