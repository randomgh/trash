<?php

function get_section($name = null) {
	do_action('get_section', $name);

	$templates = array();
	$name = (string) $name;
	if ('' !== $name) {
		$templates[] = "section-{$name}.php";
	}

	$templates[] = 'section.php';

	locate_template($templates, true, false);
}