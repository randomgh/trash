<?php

function dem_widgets_init() {
	foreach ($GLOBALS['wp_widget_factory']->widgets as $id => $widget) {
		unregister_widget($id);
	}
}
add_action('widgets_init', 'dem_widgets_init');