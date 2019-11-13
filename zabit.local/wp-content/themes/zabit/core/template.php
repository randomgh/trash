<?php

function get_section($name = null){
	do_action('get_section', $name);

	$templates = array();
	$name = (string) $name;
	if('' !== $name){
		$templates[] = "section-{$name}.php";
	}

	$templates[] = 'section.php';

	locate_template($templates, true, false);
}

function get_aside($name = null){
	do_action('get_aside', $name);

	$templates = array();
	$name = (string) $name;
	if('' !== $name){
		$templates[] = "aside-{$name}.php";
	}

	$templates[] = 'aside.php';

	locate_template($templates, true, false);
}

function get_block($name = null){
	do_action('get_block', $name);

	$templates = array();
	$name = (string) $name;
	if('' !== $name){
		$templates[] = "block-{$name}.php";
	}

	$templates[] = 'block.php';

	locate_template($templates, true, false);
}

function get_excerpt($name = null){
	do_action('get_excerpt', $name);

	$templates = array();
	$name = (string) $name;
	if('' !== $name){
		$templates[] = "excerpt-{$name}.php";
	}

	$templates[] = 'excerpt.php';

	locate_template($templates, true, false);
}