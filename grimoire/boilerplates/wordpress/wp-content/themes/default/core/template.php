<?php

function madtd_get_block($name = null){
	do_action('madtd_get_block', $name);

	$templates = array();
	$name = (string) $name;
	if('' !== $name){
		$templates[] = "block-{$name}.php";
	}

	$templates[] = 'block.php';

	locate_template($templates, true, false);
}