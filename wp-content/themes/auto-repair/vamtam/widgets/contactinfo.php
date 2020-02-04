<?php

class wpv_contactinfo extends WP_Widget {
	private $fields = array();

	function __construct() {
		$widget_ops = array(
			'classname' => 'wpv_contactinfo',
			'description' => __( 'Display contact information.', 'auto-repair' )
		);
		parent::__construct( 'wpv_contactinfo', __( 'Vamtam - Contact Info', 'auto-repair' ) , $widget_ops );

		$this->fields = array(
			'title' => array('description' => __( 'Title:', 'auto-repair' )),
			'name' => array('description' => __( 'Name:', 'auto-repair' )),
			// 'text' => array('description' => __('Introduction text:', 'auto-repair')),
			'phone' => array('description' => __( 'Phone:', 'auto-repair' )),
			'cellphone' => array('description' => __( 'Cell phone:', 'auto-repair' )),
			'mail' => array('description' => __( 'Email:', 'auto-repair' )),
			'address' => array('description' => __( 'Address:', 'auto-repair' )),
		);
	}

	public function widget($args, $instance) {
		extract( $args );
		foreach ($this->fields as $name=>&$field)
			$field['value'] = isset($instance[$name]) ? $instance[$name] : '';
		unset($field);

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$color = $instance['color'];

		include(locate_template( 'templates/widgets/front/contactinfo.php' ));
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		foreach ($this->fields as $name=>$field)
			$instance[$name] = strip_tags( $new_instance[$name] );

		$instance['color'] = $new_instance['color'];

		return $instance;
	}

	public function form($instance) {
		foreach ($this->fields as $name=>&$field)
			$field['value'] = isset($instance[$name]) ? esc_attr( $instance[$name] ) : '';
		unset($field);

		$color = $instance['color'];

		include(locate_template( 'templates/widgets/conf/contactinfo.php' ));
	}
}
register_widget( 'wpv_contactinfo' );
