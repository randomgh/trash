<?php

class AdminPage {

	protected $page;
	protected $settings;

	public function __construct($page, $settings = array()) {
		$this->page = $page;
		$this->settings = $settings;

		add_action('admin_init', array($this, 'register_settings'));
		add_action('admin_menu', array($this, 'add_menu_page'));
		add_action('whitelist_options', array($this, 'whitelist_options'), 11);
		add_action('rss2_head', array($this, 'rss'));
	}

	public function rss() {
		foreach ($this->settings as $setting => $sections) {
			foreach ($sections as $section) {
				foreach ($section['fields'] as $field) {
					$option = $this->get_name($setting, $section['id'], $field['id']);

					$field['name'] = $option;

					$value = get_option($option, $field['default']);

					if ($value) $field['value'] = $value;

					switch ($field['type']) {
						case 'media':
							$rss_type = 'media';
							break;
						case 'select':
							$rss_type = 'select';
							break;
						default:
							$rss_type = 'text';
					}

					call_user_func(array($this, 'rss2_'.$rss_type), $field);
				}
			}
		}
	}

	public function whitelist_options($whitelist_options){
		foreach ($this->settings as $setting => $sections) {
			foreach ($sections as $section) {
				foreach ($section['fields'] as $field) {
					$whitelist_options[$this->page['menu_slug']][] = $this->get_name($setting, $section['id'], $field['id']);
				}
			}
		}

		return $whitelist_options;
	}

	public function get_name() {
		$args = func_get_args();
		array_unshift($args, $this->page['menu_slug']);
		return join('_', $args);
	}

	public function add_menu_page() {
		call_user_func_array(isset($this->page['parent']) ? 'add_submenu_page' : 'add_menu_page', array_values(array_filter(array(
			isset($this->page['parent']) ? $this->page['parent'] : null,
			isset($this->page['page_title']) ? $this->page['page_title'] : '',
			isset($this->page['menu_title']) ? $this->page['menu_title'] : '',
			isset($this->page['capability']) ? $this->page['capability'] : '',
			isset($this->page['menu_slug']) ? $this->page['menu_slug'] : '',
			isset($this->page['display']) && !$this->page['display'] ? '' : array($this, 'display_page'),
			isset($this->page['icon_url']) && !isset($this->page['parent']) ? $this->page['icon_url'] : '',
			isset($this->page['position']) && !isset($this->page['parent']) ? $this->page['position'] : null
		), function ($var) { return $var !== null; })));
	}

	public function register_settings() {
		foreach ($this->settings as $setting => $sections) {
			foreach ($sections as $section) {
			    $sectionName = $this->get_name($setting, $section['id']);

				add_settings_section($sectionName, $section['title'], $section['description'], $this->page['menu_slug']);

				foreach ($section['fields'] as $field) {
				    $option = $this->get_name($setting, $section['id'], $field['id']);

					register_setting($sectionName, $option, array_filter(array(
                        'default'           => isset($field['default']) ? $field['default'] : null,
                        'type'              => isset($field['type']) ? $field['type'] : null,
                        'description'       => isset($field['description']) ? $field['description'] : null,
                        'sanitize_callback' => isset($field['sanitize']) ? $field['sanitize'] : null,
                        'show_in_rest'      => isset($field['rest']) ? $field['rest'] : null
					)));

					add_settings_field($field['id'], sprintf('<label for="%s">%s</label>', $option, $field['title']), array($this, 'display_'.$field['type']), $this->page['menu_slug'], $sectionName, array_filter(array(
                        'id'          => $option,
                        'name'        => $option,
                        'value'       => get_option($option, $field['default']),
                        'placeholder' => isset($field['placeholder']) ? $field['placeholder'] : null,
                        'class'       => isset($field['class']) ? $field['class'] : null,
                        'description' => isset($field['description']) ? $field['description'] : null,
                        'empty'       => isset($field['empty']) ? $field['empty'] : null,
                        'options'     => isset($field['options']) ? $field['options'] : null
                    )));
				}
			}
		}
	}

	public function display_page() {
		?>
		<div class="wrap">
			<h1><?php echo $this->page['page_title']; ?></h1>
			<form method="post" action="options.php">
				<?php
					settings_fields($this->page['menu_slug']);
					do_settings_sections($this->page['menu_slug']);
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	// TODO: Implement Field::text
	public function display_text($args) {
		$described = isset($args['description']) ? ''.$args['id'].'-description' : null;
	    ?>
        <div class"zabit-field zabit-field_text">
            <?php printf('<input %s />', implode(' ', array_filter(array(
                sprintf('%s="%s"', 'class', implode(' ', array_filter(array(
                    'zabit-field__input',
                    isset($args['class']) ? $args['class'] : null
                )))),
                isset($args['id']) ? sprintf('%s="%s"', 'id', $args['id']) : null,
                isset($args['name']) ? sprintf('%s="%s"', 'name', $args['name']) : null,
                sprintf('%s="%s"', 'type', 'text'),
                isset($args['value']) ? sprintf('%s="%s"', 'value', $args['value']) : null,
                isset($args['placeholder']) ? sprintf('%s="%s"', 'placeholder', $args['placeholder']) : null,
                $described ? sprintf('%s="%s"', 'aria-describedby', $described) : null
            )))); ?>

            <?php if ($described) : ?>
                    <p class="description zabit-field__description" id="<?php echo $described; ?>"><?php echo $args['description']; ?></p>
            <?php endif; ?>
        </div>
        <?php
	}

	// TODO: Implement Field::select
	public function display_select($args) {
		$described = isset($args['description']) ? ''.$args['id'].'-description' : null;
		?>
        <div class"zabit-field zabit-field_select">
		<?php if (isset($args['options']) && count($args['options']) > 0) : ?>
			<?php printf('<select %s>%s</select>',
				implode(' ', array_filter(array(
					sprintf('%s="%s"', 'class', implode(' ', array_filter(array(
						'components-select-control__input',
						'zabit-field__input',
						isset($args['class']) ? $args['class'] : null
					)))),
					isset($args['id']) ? sprintf('%s="%s"', 'id', $args['id']) : null,
					isset($args['name']) ? sprintf('%s="%s"', 'name', $args['name']) : null,
					$described ? sprintf('%s="%s"', 'aria-describedby', $described) : null
				))),
				$this->display_options($args, isset($args['value']) ? $args['value'] : null)
			); ?>

			<?php if ($described) : ?>
                <p class="description zabit-field__description" id="<?php echo $described; ?>"><?php echo $args['description']; ?></p>
			<?php endif; ?>
		<?php else : ?>
			<?php if (isset($args['empty'])) : ?>
                <span class="zabit-field__empty"><?php echo $args['empty']; ?></span>
				<?php printf('<input %s />',
					implode(' ', array_filter(array(
						sprintf('%s="%s"', 'class', implode(' ', array_filter(array(
							'components-select-control__input',
							'zabit-field__input',
							isset($args['class']) ? $args['class'] : null
						)))),
						sprintf('%s="%s"', 'type', 'hidden'),
						isset($args['id']) ? sprintf('%s="%s"', 'id', $args['id']) : null,
						isset($args['name']) ? sprintf('%s="%s"', 'name', $args['name']) : null,
						$described ? sprintf('%s="%s"', 'aria-describedby', $described) : null
					)))
				); ?>
			<?php endif; ?>
		<?php endif; ?>
        </div>
		<?php
	}

	public function display_options($args, $value = null) {
		$result = isset($args['placeholder']) ? sprintf('<option value="">%s</option>', $args['placeholder']) : '';

		foreach ($args['options'] as $i => $option) {
			if (count(array_filter(array_keys($option), 'is_string')) == 0) {
				$result .= '<optgroup label="'.$i.'">';
				foreach ($option as $o) {
					$result .= sprintf('<option value="%s" %s>%s</option>', $o['value'], selected($o['value'], $value, false), $o['title']);
				}
				$result .= '</optgroup>';
			} else {
				$result .= sprintf('<option value="%s" %s>%s</option>', $option['value'], selected($option['value'], $value, false), $option['title']);
			}
		}

		return $result;
	}

	// TODO: Implement Field::media
	public function display_media($args) {
		$described = isset($args['description']) ? ''.$args['id'].'-description' : null;

		$attachment = null;

		if (isset($args['value']) && $args['value'] != '') {
			$value = $args['value'];

			$attachment_post = get_post($value);
			$attachment_meta = get_post_meta($value);
			$attachment_src  = wp_get_attachment_url($value);

			$attachment = $attachment_post ? array(
				'id'    => $attachment_post->ID,
				'title' => $attachment_post->post_title,
				'alt'   => isset($attachment_meta['_wp_attachment_image_alt']) ? $attachment_meta['_wp_attachment_image_alt']['0'] : '',
				'src'   => $attachment_src,
				'mime'  => get_post_mime_type($value),
				'path'  => get_attached_file($value)
			) : wp_get_attachment_metadata($value, true);
		}
		?>
            <div class="zabit-field zabit-field_media <?php echo $attachment ? 'zabit-field_value' : 'zabit-field_empty'; ?>" data-type="<?php echo $args['options']['type']; ?>">
                <?php printf('<input %s />', implode(' ', array_filter(array(
                    sprintf('%s="%s"', 'class', implode(' ', array_filter(array(
                        'zabit-field__input',
                        isset($args['class']) ? $args['class'] : null
                    )))),
                    isset($args['id']) ? sprintf('%s="%s"', 'id', $args['id']) : null,
                    isset($args['name']) ? sprintf('%s="%s"', 'name', $args['name']) : null,
                    sprintf('%s="%s"', 'type', 'hidden'),
                    isset($args['value']) ? sprintf('%s="%s"', 'value', $args['value']) : null,
                    isset($args['placeholder']) ? sprintf('%s="%s"', 'placeholder', $args['placeholder']) : null,
                    $described ? sprintf('%s="%s"', 'aria-describedby', $described) : null
                )))); ?>
                <span class="zabit-field__value">
                    <?php
                    if ($attachment) :
	                    $mime_array = explode('/', $attachment['mime']);
	                    $mime_type = array_shift($mime_array);
                        switch ($mime_type) :
	                        case 'video':
		                        ?>
                                <video class="zabit-field__value__img" src="<?php echo $attachment['src']; ?>"></video>
		                        <?php
		                        break;
	                        case 'image':
	                            ?>
                                <img class="zabit-field__value__img" src="<?php echo $attachment['src']; ?>" alt="<?php echo isset($args['placeholder']) ? $args['placeholder'] : '' ?>" />
                                <?php
		                        break;
                        endswitch;
                    endif;
                    ?>
                </span>
                <span class="zabit-field__actions">
                    <a class="zabit-field__action zabit-field__action_add" href="#" title="<?php _e('Add icon', 'zabit'); ?>"></a>
                    <a class="zabit-field__action zabit-field__action_edit" href="#" title="<?php _e('Edit icon', 'zabit'); ?>"></a>
                    <a class="zabit-field__action zabit-field__action_remove" href="#" title="<?php _e('Remove icon', 'zabit'); ?>"></a>
                </span>
                <?php if ($described) : ?>
                    <span class="description zabit-field__description" id="<?php echo $described; ?>"><?php echo $args['description']; ?></span>
                <?php endif; ?>
            </div>
		<?php
	}

	// TODO: Implement Field::editor
	public function display_editor($args) {
		$described = isset($args['description']) ? ''.$args['id'].'-description' : null;
		?>
        <div class"zabit-field zabit-field_editor">
            <?php wp_editor(isset($args['value']) ? $args['value'] : '', $args['name'], array(
                'textarea_rows' => 15,
                'media_buttons' => false,
                'teeny'         => true,
                'tinymce'       => true
            )); ?>

            <?php if ($described) : ?>
                <p class="description zabit-field__description" id="<?php echo $described; ?>"><?php echo $args['description']; ?></p>
            <?php endif; ?>
        </div>
		<?php
	}

	public function rss2_text($args) {
		if (isset($args['name']) && isset($args['value'])) {
			printf('<%1$s>%2$s</%1$s>', $args['name'], isset($args['value']) ? $args['value'] : '');
		}
	}

	public function rss2_media($args) {
		if (isset($args['name']) && isset($args['value'])) {
			$src = wp_get_attachment_url($args['value']);

			printf('<%1$s id="%3$s">%2$s</%1$s>', $args['name'], $src, isset($args['value']) ? $args['value'] : '');
		}
	}

	public function rss2_select($args) {
		if (isset($args['name']) && isset($args['value'])) {
			printf('<%1$s>%2$s</%1$s>', $args['name'], isset($args['value']) ? is_array($args['value']) ? join(',', $args['value']) : $args['value'] : '');
		}
	}

}