<?php

class MetaBox {

	protected $metabox;
	protected $fields;

	public function __construct($metabox, $fields) {
		$this->metabox = $metabox;
		$this->fields = $fields;

		add_action('add_meta_boxes', array($this, 'add_meta_box'), 10, 2);
		add_action('save_post_'.$this->metabox['screen'],  array($this, 'save'), 10, 3);
		add_action('rest_api_init', array($this, 'rest'));
		add_action('rss2_item', array($this, 'rss'));
		add_action('commentsrss2_head', array($this, 'rss'));
	}

	public function get_name() {
		$args = func_get_args();
		array_unshift($args, $this->metabox['id']);
		return join('_', $args);
	}

	public function add_meta_box() {
		add_meta_box(
			$this->metabox['id'],
			$this->metabox['title'],
			array($this, 'display_meta_box'),
			$this->metabox['screen'],
			$this->metabox['context'],
			$this->metabox['priority']
		);
	}

	public function save($post_id, $post, $update) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		foreach ($this->fields as $field) {
			$option = isset($field['name']) ? $field['name'] : $this->get_name($field['id']);

			if (!isset($_POST[$option]) || $_POST[$option] == '') {
				delete_post_meta($post_id, $option);
			} else {
				$value = method_exists($this, 'sanitize_'.$field['type']) ? call_user_func(array($this, 'sanitize_'.$field['type']), $post, $field, $_POST) : $_POST[$option];

				if (get_post_meta($post_id, $option, false)) {
					update_post_meta($post_id, $option, $value);
				} else {
					add_post_meta($post_id, $option, $value);
				}
			}
		}
	}

	public function rest() {
		foreach ($this->fields as $field) {
			$option = isset($field['name']) ? $field['name'] : $this->get_name($field['id']);

			$field['name'] = $option;

			register_rest_field($this->metabox['screen'], $option, array(
				'get_callback'    => function($object, $field_name, $request) use ($field) {
					return get_post_meta($object['id'], $field_name, !(isset($field['single']) && !$field['single']));
				},
				'update_callback' => null,
				'schema'          => null
			));
		}
	}

	public function rss() {
		global $post;

	    if ($post->post_type == $this->metabox['screen']) {
            foreach ($this->fields as $field) {
                $option = isset($field['name']) ? $field['name'] : $this->get_name($field['id']);

	            $field['name'] = $option;

                $value = get_post_meta($post->ID, $option, !(isset($field['single']) && !$field['single']));

                if ($value) $field['value'] = $value;

                if (method_exists($this, 'prepare_'.$field['type'])) {
                    $field = call_user_func(array($this, 'prepare_'.$field['type']), $post, $field);
                }

                switch ($field['type']) {
	                case 'checkbox':
		                $rss_type = 'checkbox';
		                break;
	                case 'media':
		                $rss_type = 'media';
		                break;
	                case 'gallery':
		                $rss_type = 'gallery';
		                break;
	                case 'datetime':
		                $rss_type = 'date';
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

	public function display_meta_box($post) {
		foreach ($this->fields as $field) {
			$option = isset($field['name']) ? $field['name'] : $this->get_name($field['id']);

			$field['name'] = $option;

			$value = get_post_meta($post->ID, $option, !(isset($field['single']) && !$field['single']));

			if ((!is_bool($value) || $value != false) && $value != '' && (!is_array($value) || count($value) != 0)) $field['value'] = $value;

			if (method_exists($this, 'prepare_'.$field['type'])) {
				$field = call_user_func(array($this, 'prepare_'.$field['type']), $post, $field);
			}

			?>
			<div class="components-base-control">
				<?php if (isset($field['title'])) : ?>
					<label <?php echo isset($field['id']) ? sprintf('%s="%s"', 'for', $field['id']) : ''; ?> class="components-base-control__label">
						<?php echo $field['title']; ?>
					</label>
				<?php endif; ?>
				<?php call_user_func(array($this, 'display_'.$field['type']), $field); ?>
			</div>
			<?php
		}
	}

	// TODO: Implement Field::text
	public function display_text($args) {
		$described = isset($args['description']) ? ''.$args['id'].'-description' : null;
		?>
        <div class="components-base-control__field dem-field dem-field_text">
			<?php printf('<input %s />', implode(' ', array_filter(array(
				sprintf('%s="%s"', 'class', implode(' ', array_filter(array(
					'components-text-control__input',
					'dem-field__input',
					'dem-field__input_text',
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
                <p class="description dem-field__description" id="<?php echo $described; ?>"><?php echo $args['description']; ?></p>
			<?php endif; ?>
        </div>
		<?php
	}

	// TODO: Implement Field::textarea
	public function display_textarea($args) {
		$described = isset($args['description']) ? ''.$args['id'].'-description' : null;
		?>
        <div class="components-base-control__field dem-field dem-field_text">
			<?php printf('<textarea %s></textarea>', implode(' ', array_filter(array(
				sprintf('%s="%s"', 'class', implode(' ', array_filter(array(
					'components-textarea-control__input',
					'dem-field__input',
					'dem-field__input_textarea',
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
                <p class="description dem-field__description" id="<?php echo $described; ?>"><?php echo $args['description']; ?></p>
			<?php endif; ?>
        </div>
		<?php
	}

	// TODO: Implement Field::number
	public function display_number($args) {
		$described = isset($args['description']) ? ''.$args['id'].'-description' : null;

		$decimals = 0;
		if (isset($args['options']) && isset($args['options']['step'])) {
			for ($number = floatval($args['options']['step']); $number != round($number, $decimals); $decimals++);
        }
		?>
        <div class="components-base-control__field dem-field dem-field_number">
			<?php printf('<input %s />', implode(' ', array_filter(array(
				sprintf('%s="%s"', 'class', implode(' ', array_filter(array(
					'components-number-control__input',
					'dem-field__input',
					'dem-field__input_number',
					isset($args['class']) ? $args['class'] : null
				)))),
				isset($args['id']) ? sprintf('%s="%s"', 'id', $args['id']) : null,
				isset($args['name']) ? sprintf('%s="%s"', 'name', $args['name']) : null,
				sprintf('%s="%s"', 'type', 'number'),
				isset($args['value']) ? sprintf('%s="%s"', 'value', $args['value']) : null,
				isset($args['placeholder']) ? sprintf('%s="%s"', 'placeholder', $args['placeholder']) : null,
				isset($args['options']) && isset($args['options']['min']) ? sprintf('%s="%s"', 'min', $args['options']['min']) : null,
				isset($args['options']) && isset($args['options']['max']) ? sprintf('%s="%s"', 'max', $args['options']['max']) : null,
				isset($args['options']) && isset($args['options']['step']) ? sprintf('%s="%s"', 'step', $args['options']['step']) : null,
				$described ? sprintf('%s="%s"', 'aria-describedby', $described) : null
			)))); ?>

			<?php if ($described) : ?>
                <p class="description dem-field__description" id="<?php echo $described; ?>"><?php echo $args['description']; ?></p>
			<?php endif; ?>
        </div>
		<?php
	}

	// TODO: Implement Field::datetime
	public function display_datetime($args) {
		$id = isset($args['id']) ? $args['id'] : '';
		$name = isset($args['name']) ? $args['name'] : '';

		$value = isset($args['value']) ? intval($args['value']) : null;

		$dd = $value ? date('d', $value) : '';
		$mm = $value ? date('m', $value) : '';
		$yy = $value ? date('Y', $value) : '';
		$hh = $value ? date('H', $value) : '';
		$mn = $value ? date('i', $value) : '';
		$ss = $value ? date('s', $value) : '';
		?>
        <div class="components-base-control__field dem-field dem-field_datetime">
            <?php if (in_array('mm', $args['options'])) : ?>
                <select id="<?php echo $id; ?>-mm" name="<?php echo $name; ?>[mm]">
                    <?php foreach (array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec') as $i => $month) {
                        $num = $i + 1;
                        $num = $num < 10 ? "0{$num}" : $num;
                        printf('<option value="%s" %s>%s</option>', $num, selected($num, $mm, false), sprintf(__('%s-%s', 'dem'), $num, $month));
                    } ?>
                </select>
	        <?php endif; ?>
	        <?php if (in_array('dd', $args['options'])) : ?>
                <input type="number" id="<?php echo $id; ?>-dd" name="<?php echo $name; ?>[dd]" value="<?php echo $dd; ?>" size="2" maxlength="2" min="1" max="31" step="1" autocomplete="off">
            <?php endif; ?>
		    <?php if ((in_array('dd', $args['options']) || in_array('mm', $args['options'])) && in_array('yy', $args['options'])) : ?>
                ,
		    <?php endif; ?>
	        <?php if (in_array('yy', $args['options'])) : ?>
                <input type="number" id="<?php echo $id; ?>-yy" name="<?php echo $name; ?>[yy]" value="<?php echo $yy; ?>" size="4" maxlength="4" min="1900" step="1" autocomplete="off">
            <?php endif; ?>
		    <?php if ((in_array('dd', $args['options']) || in_array('mm', $args['options']) || in_array('yy', $args['options'])) && (in_array('hh', $args['options']) || in_array('mn', $args['options']) || in_array('ss', $args['options']))) : ?>
                @
		    <?php endif; ?>
		    <?php if (in_array('hh', $args['options'])) : ?>
                <input type="number" id="<?php echo $id; ?>-hh" name="<?php echo $name; ?>[hh]" value="<?php echo $hh; ?>" size="2" maxlength="2" min="0" max="23" step="1" autocomplete="off">
	        <?php endif; ?>
	        <?php if (in_array('hh', $args['options']) && in_array('mn', $args['options'])) : ?>
                :
            <?php endif; ?>
	        <?php if (in_array('mn', $args['options'])) : ?>
                <input type="number" id="<?php echo $id; ?>-mn" name="<?php echo $name; ?>[mn]" value="<?php echo $mn; ?>" size="2" maxlength="2" min="0" max="59" step="1" autocomplete="off">
	        <?php endif; ?>
	        <?php if (in_array('mn', $args['options']) && in_array('ss', $args['options'])) : ?>
                :
	        <?php endif; ?>
	        <?php if (in_array('ss', $args['options'])) : ?>
                <input type="number" id="<?php echo $id; ?>-ss" name="<?php echo $name; ?>[ss]" value="<?php echo $ss; ?>" size="2" maxlength="2" min="0" max="59" step="1" autocomplete="off">
		    <?php endif; ?>
			<?php if (isset($args['description'])) : ?>
                <p class="description dem-field__description"><?php echo $args['description']; ?></p>
			<?php endif; ?>
        </div>
		<?php
	}

	// TODO: Implement Field::checkbox
	public function display_checkbox($args) {
		$described = isset($args['description']) ? ''.$args['id'].'-description' : null;
		?>
        <div class="components-base-control__field dem-field dem-field_checkbox">
		<?php printf('<input %s />', implode(' ', array_filter(array(
			sprintf('%s="%s"', 'class', implode(' ', array_filter(array(
				'components-checkbox-control__input',
				'dem-field__input',
				'dem-field__input_checkbox',
				isset($args['class']) ? $args['class'] : null
			)))),
			isset($args['id']) ? sprintf('%s="%s"', 'id', $args['id']) : null,
			isset($args['name']) ? sprintf('%s="%s"', 'name', $args['name']) : null,
			sprintf('%s="%s"', 'type', 'checkbox'),
			sprintf('%s="%s"', 'value', 1),
			checked(isset($args['value']), true, false),
			$described ? sprintf('%s="%s"', 'aria-describedby', $described) : null
		)))); ?>

		<?php if ($described) : ?>
            <p class="description dem-field__description" id="<?php echo $described; ?>"><?php echo $args['description']; ?></p>
		<?php endif; ?>
        </div>
		<?php
	}

	// TODO: Implement Field::select
	public function display_select($args) {
		$described = isset($args['description']) ? ''.$args['id'].'-description' : null;
		?>
		<div class="components-base-control__field dem-field dem-field_select">
            <?php if (count($args['options']) == 0) : ?>
                <?php if ($args['empty']) : ?>
                    <span class="dem-field__empty"><?php echo $args['empty']; ?></span>
                    <?php printf('<input %s />',
                        implode(' ', array_filter(array(
                            sprintf('%s="%s"', 'class', implode(' ', array_filter(array(
                                'components-hidden-control__input',
                                'dem-field__input',
	                            'dem-field__input_hidden',
                                isset($args['class']) ? $args['class'] : null
                            )))),
	                        sprintf('%s="%s"', 'type', 'hidden'),
	                        isset($args['id']) ? sprintf('%s="%s"', 'id', $args['id']) : null,
                            isset($args['name']) ? sprintf('%s="%s"', 'name', $args['name']) : null,
                            $described ? sprintf('%s="%s"', 'aria-describedby', $described) : null
                        )))
                    ); ?>
                <?php endif; ?>
            <?php else : ?>
                <?php printf('<select %s>%s</select>',
                    implode(' ', array_filter(array(
                        sprintf('%s="%s"', 'class', implode(' ', array_filter(array(
                            'components-select-control__input',
                            'dem-field__input',
	                        'dem-field__input_select',
                            isset($args['class']) ? $args['class'] : null
                        )))),
                        isset($args['id']) ? sprintf('%s="%s"', 'id', $args['id']) : null,
	                    isset($args['name']) ? sprintf('%s="%s%s"', 'name', $args['name'], isset($args['multiple']) && $args['multiple'] ? '[]' : '') : null,
	                    isset($args['multiple']) && $args['multiple'] ? 'multiple' : null,
	                    $described ? sprintf('%s="%s"', 'aria-describedby', $described) : null
                    ))),
                    $this->display_options($args, isset($args['value']) ? $args['value'] : null)
                ); ?>

                <?php if ($described) : ?>
                    <p class="description dem-field__description" id="<?php echo $described; ?>"><?php echo $args['description']; ?></p>
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
					$result .= sprintf('<option value="%s" %s>%s</option>', $o['value'], selected(is_array($value) ? in_array($o['value'], $value) : $o['value'], is_array($value) ? true : $value, false), $o['title']);
				}
				$result .= '</optgroup>';
			} else {
				$result .= sprintf('<option value="%s" %s>%s</option>', $option['value'], selected(is_array($value) ? in_array($option['value'], $value) : $option['value'], is_array($value) ? true : $value, false), $option['title']);
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
        <div class="components-base-control__field dem-field dem-field_media <?php echo $attachment ? 'dem-field_value' : 'dem-field_empty'; ?>" data-type="<?php echo $args['options']['type']; ?>">
			<?php printf('<input %s />', implode(' ', array_filter(array(
				sprintf('%s="%s"', 'class', implode(' ', array_filter(array(
					'components-hidden-control__input',
					'dem-field__input',
					'dem-field__input_hidden',
					isset($args['class']) ? $args['class'] : null
				)))),
				isset($args['id']) ? sprintf('%s="%s"', 'id', $args['id']) : null,
				isset($args['name']) ? sprintf('%s="%s"', 'name', $args['name']) : null,
				sprintf('%s="%s"', 'type', 'hidden'),
				isset($args['value']) ? sprintf('%s="%s"', 'value', $args['value']) : null,
				isset($args['placeholder']) ? sprintf('%s="%s"', 'placeholder', $args['placeholder']) : null,
				$described ? sprintf('%s="%s"', 'aria-describedby', $described) : null
			)))); ?>
            <span class="dem-field__value">
                <?php
                if ($attachment) :
                    switch (array_shift(explode('/', $attachment['mime']))) :
                        case 'video':
                            ?>
                            <video class="dem-field__value__img" src="<?php echo $attachment['src']; ?>"></video>
                            <?php
                            break;
                        case 'image':
                            ?>
                            <img class="dem-field__value__img" src="<?php echo $attachment['src']; ?>" alt="<?php echo isset($args['placeholder']) ? $args['placeholder'] : '' ?>" />
                            <?php
                            break;
                    endswitch;
                endif;
                ?>
            </span>
            <span class="dem-field__actions">
                <a class="dem-field__action dem-field__action_add" href="#" title="<?php _e('Add icon', 'dem'); ?>"></a>
                <a class="dem-field__action dem-field__action_edit" href="#" title="<?php _e('Edit icon', 'dem'); ?>"></a>
                <a class="dem-field__action dem-field__action_remove" href="#" title="<?php _e('Remove icon', 'dem'); ?>"></a>
            </span>
			<?php if ($described) : ?>
                <span class="description dem-field__description" id="<?php echo $described; ?>"><?php echo $args['description']; ?></span>
			<?php endif; ?>
        </div>
		<?php
	}

	// TODO: Implement Field::media
	public function display_gallery($args) {
		?>
        <div class="components-base-control__field dem-field dem-field_gallery" <?php echo implode(' ', array_filter(array(
	        isset($args['name']) ? sprintf('%s="%s[]"', 'data-name', $args['name']) : null,
	        isset($args['class']) ? sprintf('%s="%s"', 'data-class', $args['class']) : null
        ))); ?>>
            <?php
            $attachment = null;

            if (isset($args['value']) && $args['value'] != '' && count($args['value']) > 0) :
	            $value = is_array($args['value']) ? $args['value'] : array($args['value']);

                foreach ($value as $v) :
                    ?>
                    <div class="dem-field__item">
                    <?php
                    if (is_numeric($v)) :
	                    $attachment_post = get_post($v);
	                    $attachment_meta = get_post_meta($v);
	                    $attachment_src  = wp_get_attachment_image_src($v, 'full');

	                    $attachment = $attachment_post ? array(
		                    'id'    => $attachment_post->ID,
		                    'title' => $attachment_post->post_title,
		                    'alt'   => isset($attachment_meta['_wp_attachment_image_alt']) ? $attachment_meta['_wp_attachment_image_alt']['0'] : '',
		                    'src'   => $attachment_src[0],
		                    'mime'  => get_post_mime_type($v),
		                    'path'  => get_attached_file($v)
	                    ) : wp_get_attachment_metadata($v, true);

	                    printf('<input %s />', implode(' ', array_filter(array(
		                    sprintf('%s="%s"', 'class', implode(' ', array_filter(array(
			                    'components-hidden-control__input',
			                    'dem-field__input',
			                    'dem-field__input_hidden',
			                    isset($args['class']) ? $args['class'] : null
		                    )))),
		                    isset($args['name']) ? sprintf('%s="%s[]"', 'name', $args['name']) : null,
		                    sprintf('%s="%s"', 'type', 'hidden'),
		                    sprintf('%s="%s"', 'value', $v)
	                    ))));
	                    ?>
                        <span class="dem-field__value">
                            <img class="dem-field__value__img" src="<?php echo $attachment ? $attachment['src'] : ''; ?>" alt="<?php echo isset($args['placeholder']) ? $args['placeholder'] : '' ?>" />
                        </span>
                        <span class="dem-field__actions">
                            <a class="dem-field__action dem-field__action_edit" href="#" title="<?php _e('Edit icon', 'dem'); ?>"></a>
                            <a class="dem-field__action dem-field__action_remove" href="#" title="<?php _e('Remove icon', 'dem'); ?>"></a>
                        </span>
                        <?php
                    else:
	                    printf('<input %s />', implode(' ', array_filter(array(
		                    sprintf('%s="%s"', 'class', implode(' ', array_filter(array(
			                    'dem-field__input',
			                    'dem-field__input_url',
			                    isset($args['class']) ? $args['class'] : null
		                    )))),
		                    isset($args['name']) ? sprintf('%s="%s[]"', 'name', $args['name']) : null,
		                    sprintf('%s="%s"', 'type', 'url'),
		                    sprintf('%s="%s"', 'value', $v)
	                    ))));
                        ?>
                        <span class="dem-field__actions">
                            <a class="dem-field__action dem-field__action_remove" href="#" title="<?php _e('Remove icon', 'dem'); ?>"></a>
                        </span>
                        <?php
                    endif;
                    ?>
                    </div>
                    <?php
                endforeach;
            endif;
            ?>
            <span class="dem-field__actions">
                <a class="dem-field__action dem-field__action_add-image" href="#" title="<?php _e('Add icon', 'dem'); ?>"></a>
                <a class="dem-field__action dem-field__action_add-url" href="#" title="<?php _e('Add url', 'dem'); ?>"></a>
            </span>
        </div>
		<?php
	}

	// TODO: Implement Field::editor
	public function display_editor($args) {
		$described = isset($args['description']) ? ''.$args['id'].'-description' : null;
		?>
        <div class="components-base-control__field dem-field dem-field_editor">
            <?php wp_editor(isset($args['value']) ? $args['value'] : '', $args['name'], array(
                    'textarea_rows' => 15,
                    'media_buttons' => false,
                    'teeny'         => true,
                    'tinymce'       => true
            )); ?>

            <?php if ($described) : ?>
                <p class="description dem-field__description" id="<?php echo $described; ?>"><?php echo $args['description']; ?></p>
            <?php endif; ?>
        </div>
		<?php
    }

	public function rss2_text($args) {
		if (isset($args['name']) && isset($args['value'])) {
			printf('<%1$s>%2$s</%1$s>', $args['name'], isset($args['value']) ? $args['value'] : '');
		}
	}

	public function rss2_checkbox($args) {
		if (isset($args['name']) && isset($args['value'])) {
			printf('<%1$s>%2$d</%1$s>', $args['name'], isset($args['value']));
		}
	}

	public function rss2_date($args) {
		if (isset($args['name']) && isset($args['value'])) {
			printf('<%1$s>%2$s</%1$s>', $args['name'], isset($args['value']) ? date('r', $args['value']) : '');
		}
	}

	public function rss2_media($args) {
		if (isset($args['name']) && isset($args['value'])) {
			if (isset($args['name']) && isset($args['value'])) {
				$src = wp_get_attachment_url($args['value']);

				printf('<%1$s id="%3$s">%2$s</%1$s>', $args['name'], $src, isset($args['value']) ? $args['value'] : '');
			}
		}
	}

	public function rss2_gallery($args) {
		if (isset($args['name']) && isset($args['value'])) {
		    $value = is_array($args['value']) ? $args['value'] : array($args['value']);
		    echo "<{$args['name']}>";
		    foreach ($value as $v) {
		        if (is_numeric($v)) {
			        list($src, $width, $height) = wp_get_attachment_image_src($v, 'full');

			        printf('<%1$s-item id="%3$s" width="%4$d" height="%5$d">%2$s</%1$s-item>', $args['name'], $src, $v, $width, $height);
                } else {
			        printf('<%1$s-item>%2$s</%1$s-item>', $args['name'], $v);
                }
            }
			echo "</{$args['name']}>";
		}
	}

	public function rss2_select($args) {
		if (isset($args['name']) && isset($args['value'])) {
			printf('<%1$s>%2$s</%1$s>', $args['name'], isset($args['value']) ? is_array($args['value']) ? join(',', $args['value']) : $args['value'] : '');
		}
	}

    public function prepare_editor($post, $field) {
	    if (isset($field['value'])) {
		    $field['value'] = str_replace(array('&lt;', '&gt;', '&quot;', '&amp;', '&nbsp;', '&amp;nbsp;'), array('<', '>', '"', '&', ' ', ' '), $field['value']);
	    }

	    return $field;
    }

	public function sanitize_number($post, $field, $values) {
		$option = isset($field['name']) ? $field['name'] : $this->get_name($field['id']);

		$decimals = 0;
		if (isset($field['options']) && isset($field['options']['step'])) {
			for ($number = floatval($field['options']['step']); $number != round($number, $decimals); $decimals++);
		}

		return number_format(floatval($values[$option]), $decimals, '.', '');
	}

	public function sanitize_datetime($post, $field, $values) {
		$option = isset($field['name']) ? $field['name'] : $this->get_name($field['id']);

		$value = $values[$option];

	    return mktime(isset($value['hh']) ? intval($value['hh']) : 0, isset($value['mn']) ? intval($value['mn']) : 0, isset($value['ss']) ? intval($value['ss']) : 0, isset($value['mm']) ? intval($value['mm']) : 1, isset($value['dd']) ? intval($value['dd']) : 1, isset($value['yy']) ? intval($value['yy']) : 0);
	}
}