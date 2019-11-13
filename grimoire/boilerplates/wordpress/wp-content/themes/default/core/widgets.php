<?php

function madtd_widgets_init(){
	foreach($GLOBALS['wp_widget_factory']->widgets as $id => $widget){
		unregister_widget($id);
	}
}
add_action('widgets_init', 'madtd_widgets_init');