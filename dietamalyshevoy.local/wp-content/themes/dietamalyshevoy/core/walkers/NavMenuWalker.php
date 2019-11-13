<?php

class NavMenuWalker extends Walker_Nav_Menu {

	public function start_lvl(&$output, $depth = 0, $args = array()){
		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat($t, $depth);

		$classes = array('sub-menu');

		if (!empty($args->menu_class)) {
			$classes[] = $args->menu_class;
			$classes[] = $args->menu_class.'_sub';
			$classes[] = $args->menu_class.'_sub_'.$depth;
		}

		$class_names = join(' ', apply_filters('nav_menu_submenu_css_class', $classes, $args, $depth));
		$class_names = $class_names ? ' class="'.esc_attr($class_names).'"' : '';

		$output .= "{$n}{$indent}<ul$class_names>{$n}";
	}

	public function end_lvl(&$output, $depth = 0, $args = array()){
		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent  = str_repeat($t, $depth);
		$output .= "$indent</ul>{$n}";
	}

	public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0){
		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = $depth ? str_repeat($t, $depth) : '';

		$icon = get_post_meta($item->ID, 'dem-menu-item-icon', true);

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

		$classes   = empty($item->classes) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-'.$item->ID;

		$args = apply_filters('nav_menu_item_args', $args, $item, $depth);

		if (!empty($args->item_class)) {
			$classes[] = $args->item_class;
		}

		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
		$class_names = $class_names ? ' class="'.esc_attr($class_names).'"' : '';

		$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
		$id = $id ? ' id="'.esc_attr( $id ).'"' : '';

		$output .= $indent.'<li'.$id.$class_names.'>';

		$atts = array();
		$atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
		$atts['target'] = !empty($item->target) ? $item->target : '';
		if ('_blank' === $item->target && empty($item->xfn)) {
			$atts['rel'] = 'noopener noreferrer';
		} else {
			$atts['rel'] = $item->xfn;
		}
		$atts['href'] = ! empty($item->url) ? $item->url : '';
		$atts['aria-current'] = $item->current ? 'page' : '';


		if (!empty($args->link_class)) {
			$atts['class'] = $attachment ? $args->link_class.' '.$args->link_class.'_imaged' : $args->link_class;
		}

		if (isset($args->active)) {
			$active = parse_url($args->active);
			$url = parse_url($item->url);

			if (trim($args->active, '/') == trim($item->url, '/') || trim($active['path'], '/') == trim($url['path'], '/')) {
				if (!empty($args->link_active_class)) {
					$atts['class'] .= ' '.$args->link_active_class;
				}
				$atts['tabindex'] = -1;
			}

		}

		$atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

		$attributes = '';
		foreach ($atts as $attr => $value) {
			if (!empty($value)) {
				$value = 'href' === $attr ? esc_url($value) : esc_attr($value);
				$attributes .= ' '.$attr.'="'.$value.'"';
			}
		}

		$title = apply_filters('the_title', $item->title, $item->ID);

		$title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

		$item_output = $args->before;
		$item_output .= '<a'.$attributes.'>';

		// TODO: Implement SVG
		if ($attachment) {
			switch ($attachment['mime']) {
				case 'image/svg+xml':
					$item_output .= file_get_contents($attachment['path']);
					break;
				default:
					$item_output .= '<img src="'.$attachment['src'].'" alt="'.$attachment['alt'].'" title="'.$attachment['title'].'">';
			}
		} else {
			$item_output .= $args->link_before;
			$item_output .= $title;
			$item_output .= $args->link_after;
		}

		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}

	public function end_el(&$output, $item, $depth = 0, $args = array()){
		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$output .= "</li>{$n}";
	}
}