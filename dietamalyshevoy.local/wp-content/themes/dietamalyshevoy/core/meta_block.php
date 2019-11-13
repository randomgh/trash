<?php

class MetaBlock {

	private $metabox;
	private $fields;

	public function __construct($metabox, $fields) {
		$this->metabox = $metabox;
		$this->fields = $fields;

		add_action('init', array($this, 'register_meta'));
		add_action('enqueue_block_editor_assets', array($this, 'enqueue_script'));
	}

	public function get_name() {
		$args = func_get_args();
		array_unshift($args, $this->metabox['id']);
		return join('_', $args);
	}

	function register_meta() {
		foreach ($this->fields as $field) {
			register_meta($this->metabox['screen'], $this->get_name($field['id']), array(
				'show_in_rest' => $field['rest'],
				'single' => $field['single'],
				'type' => $field['type']
			));
		}
	}

	function enqueue_script() {
		wp_enqueue_script('metabox-'.$this->metabox['id'].'-script', get_theme_file_uri('/js/meta_box/'.$this->metabox['id'].'.js'), array('wp-blocks', 'wp-element', 'wp-components'));
	}

}