<?php

class NavMenuWalker extends Walker_Nav_Menu {

	public function start_lvl(&$output, $depth = 0, $args = array()){
		if(isset( $args->item_spacing) && 'discard' === $args->item_spacing){
			$t = '';
			$n = '';
		}else{
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat($t, $depth);

		$classes = array('nav');

		$class_names = join(' ', apply_filters('nav_menu_submenu_css_class', $classes, $args, $depth));
		$class_names = $class_names ? ' class="'.esc_attr($class_names).'"' : '';

		$output .= "{$n}{$indent}<nav $class_names>{$n}";
	}

	public function end_lvl(&$output, $depth = 0, $args = array()){
		if(isset($args->item_spacing) && 'discard' === $args->item_spacing){
			$t = '';
			$n = '';
		}else{
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat($t, $depth);
		$output .= "{$indent}</nav>{$n}";
	}

	public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0){
		if(isset($args->item_spacing) && 'discard' === $args->item_spacing){
			$t = '';
			$n = '';
		}else{
			$t = "\t";
			$n = "\n";
		}
		$indent = ($depth) ? str_repeat($t, $depth) : '';

		$icon = get_post_meta($item->ID, 'zabit-menu-item-icon', true);

		$attachment = null;

		if ($icon != '') {
			$attachment_post = get_post($icon);
			$attachment_meta = get_post_meta($icon);
			$attachment_src  = wp_get_attachment_image_src($icon, 'full');

			$attachment = $attachment_post ? array(
				'id'    => $attachment_post->ID,
				'title' => $attachment_post->post_title,
				'alt'   => isset($attachment_meta['_wp_attachment_image_alt']) ? $attachment_meta['_wp_attachment_image_alt']['0'] : '',
				'src'   => $attachment_src[0],
				'mime'  => get_post_mime_type($icon),
				'path'  => get_attached_file($icon)
			) : wp_get_attachment_metadata($icon, true);
		}

		$atts = array();
		$atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
		$atts['target'] = !empty($item->target) ? $item->target : '';
		$atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
		$atts['href']  = !empty($item->url) ? $item->url : '';

		$atts['class'] = $attachment ? 'nav__link nav__link_imaged' : 'nav__link';

		if (isset($args->active)) {
			$active = parse_url($args->active);
			$url = parse_url($item->url);

			$atts['class'] .= trim($args->active, '/') == trim($item->url, '/') || trim($active['path'], '/') == trim($url['path'], '/') ? ' nav__link_active' : '';
		}

		$atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

		$attributes = '';
		foreach($atts as $attr => $value){
			if(!empty($value)){
				$value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
				$attributes .= ' '.$attr.'="'.$value.'"';
			}
		}

		$title = apply_filters('the_title', $item->title, $item->ID);

		$title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

		$item_output = $args->before;
		$item_output .= '<a'.$attributes.'>';

		// TODO: Implement SVG

		$item_output .= $args->link_before;
		if ($attachment) {
			switch ($attachment['mime']) {
				case 'image/svg+xml':
					$item_output .= file_get_contents($attachment['path']);
					break;
				default:
					$item_output .= '<img src="'.$attachment['src'].'" alt="'.$attachment['alt'].'" title="'.$attachment['title'].'">';
			}
		} else {
			$item_output .= $title;
		}
		$item_output .= $args->link_after;

/*
		$thumbnail_value = get_post_meta($item->ID, 'zabit-menu-item-icon', true);
		$thumbnail_value = ($thumbnail_value == -1)?(''):($thumbnail_value);

		if($thumbnail_value){
			$attachment_post = get_post($thumbnail_value);
			$attachment_meta = get_post_meta($thumbnail_value);
			$attachment_src = wp_get_attachment_image_src($thumbnail_value, 'full');

			$attachment = wp_get_attachment_metadata($thumbnail_value, true);

			$attachment['title'] = $attachment_post->post_title;
			$attachment['alt'] = $attachment_meta['_wp_attachment_image_alt']['0'];

			$attachment['src'] = $attachment_src[0];

			$item_output .= $args->link_before.'<img class="social_img" src="'.$attachment['src'].'" alt="'.$attachment['alt'].'" title="'.$attachment['title'].'">'.$args->link_after;
		}else{
			$item_output .= $args->link_before.$title.$args->link_after;
		}
*/
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}

	public function end_el(&$output, $item, $depth = 0, $args = array()){
		/*
		if(isset($args->item_spacing) && 'discard' === $args->item_spacing){
			$t = '';
			$n = '';
		}else{
			$t = "\t";
			$n = "\n";
		}
		$output .= "</li>{$n}";
		*/
	}
}