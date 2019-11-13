<?php

class TaxonomyMeta {

    protected $taxonomy;
    protected $fields;

    public function __construct($taxonomy, $fields = array()) {
        $this->taxonomy = $taxonomy;
        $this->fields = $fields;

        add_action("{$this->taxonomy}_add_form_fields", array($this, 'add_form_fields'), 10, 1);
        add_action("{$this->taxonomy}_edit_form_fields", array($this, 'edit_form_fields'), 10, 2);
        add_action("created_{$this->taxonomy}", array($this, 'save'), 10, 2);
        add_action("edited_{$this->taxonomy}", array($this, 'save'), 10, 2);
    }

    public function get_name() {
        $args = func_get_args();
        array_unshift($args, $this->taxonomy);
        return join('_', $args);
    }

    public function add_form_fields($taxonomy) {
        foreach ($this->fields as $field) {
            $option = $this->get_name($field['id']);

            if (!isset($field['name'])) $field['name'] = $option;

            ?>
            <div class="form-field">
              <?php

              if (isset($field['title'])) {

                  ?>
                  <label <?php echo isset($field['id']) ? sprintf('%s="%s"', 'for', $field['id']) : ''; ?>>
                    <?php echo $field['title']; ?>
                  </label>
                  <?php

              }

              ?>
              <?php call_user_func(array($this, 'display_'.$field['type']), $field); ?>
            </div>
            <?php

        }
    }

    public function edit_form_fields($term, $taxonomy) {
        $term_id = $term->term_id;

        foreach ($this->fields as $field) {
            $option = $this->get_name($field['id']);

            $value = get_term_meta($term_id, $option, true);

            if (!isset($field['name']) && isset($field['id'])) $field['name'] = $this->get_name($field['id']);

            if (!isset($field['value']) && $value) $field['value'] = $value;

            ?>
            <tr class="form-field">
              <th>
                <?php

                if (isset($field['title'])) {

                    ?>
                    <label <?php echo isset($field['name']) ? sprintf('%s="%s"', 'for', $field['name']) : ''; ?>>
                      <?php echo $field['title']; ?>
                    </label>
                    <?php

                }

                ?>
              </th>
              <td>
                <?php call_user_func(array($this, 'display_'.$field['type']), $field); ?>
              </td>
            </tr>
            <?php

        }
    }

    public function save($term_id, $tt_id) {
        foreach ($this->fields as $field) {
            $option = $this->get_name($field['id']);

            if (!isset($_POST[$option])) {
                delete_term_meta($term_id, $option);
            } else {
                $value = $_POST[$option];

                if (get_term_meta($term_id, $option, false)) {
                    update_term_meta($term_id, $option, $value);
                } else {
                    add_term_meta($term_id, $option, $value);
                }
            }
        }
    }

    // TODO: Implement Field::text
    public function display_text($args) {
        $described = isset($args['description']) ? ''.$args['id'].'-description' : null;

        ?>
        <div class"dem-field dem-field_text">
          <?php printf('<input %s />', implode(' ', array_filter(array(
              sprintf('%s="%s"', 'class', implode(' ', array_filter(array(
                  'dem-field__input',
                  isset($args['class']) ? $args['class'] : null
              )))),
              isset($args['id']) ? sprintf('%s="%s"', 'id', $args['id']) : null,
              isset($args['name']) ? sprintf('%s="%s"', 'name', $args['name']) : null,
              sprintf('%s="%s"', 'type', 'text'),
              isset($args['value']) ? sprintf('%s="%s"', 'value', $args['value']) : null,
              isset($args['placeholder']) ? sprintf('%s="%s"', 'placeholder', $args['placeholder']) : null,
              $described ? sprintf('%s="%s"', 'aria-describedby', $described) : null
          )))); ?>

          <?php

          if ($described) {
              
              ?>
              <p class="description dem-field__description" id="<?php echo $described; ?>"><?php echo $args['description']; ?></p>
              <?php

          }

          ?>
        </div>
        <?php
    }

    // TODO: Implement Field::select
    public function display_select($args) {
        $described = isset($args['description']) ? ''.$args['id'].'-description' : null;

        ?>
        <div class"dem-field dem-field_select">
          <?php printf('<select %s>%s</select>',
              implode(' ', array_filter(array(
                  sprintf('%s="%s"', 'class', implode(' ', array_filter(array(
                      'dem-field__input',
                      isset($args['class']) ? $args['class'] : null
                  )))),
                  isset($args['id']) ? sprintf('%s="%s"', 'id', $args['id']) : null,
                  isset($args['name']) ? sprintf('%s="%s"', 'name', $args['name']) : null,
                  $described ? sprintf('%s="%s"', 'aria-describedby', $described) : null
              ))),
              $this->display_options($args['options'], isset($args['value']) ? $args['value'] : null)
          ); ?>

          <?php

          if ($described) {

              ?>
              <p class="description dem-field__description" id="<?php echo $described; ?>"><?php echo $args['description']; ?></p>
              <?php

          }

          ?>
        </div>
        <?php
    }

    public function display_options($options, $value = null) {
        $result = '';

        foreach ($options as $i => $option) {
            if (count(array_filter(array_keys($option), 'is_string')) == 0) {
                $result .= '<optgroup label="'.$i.'">';
                foreach ($option as $o) {
                    $result .= sprintf('<option value="%s" %s>%s</option>', $o['value'], $o['value'] == $value ? 'selected' : '', $o['title']);
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
            $attachment_src  = wp_get_attachment_image_src($value, 'full');

            $attachment = $attachment_post ? array(
                'id'    => $attachment_post->ID,
                'title' => $attachment_post->post_title,
                'alt'   => isset($attachment_meta['_wp_attachment_image_alt']) ? $attachment_meta['_wp_attachment_image_alt']['0'] : '',
                'src'   => $attachment_src[0],
                'mime'  => get_post_mime_type($value),
                'path'  => get_attached_file($value)
            ) : wp_get_attachment_metadata($value, true);
        }
        ?>
        <div class="dem-field dem-field_media <?php echo $attachment ? 'dem-field_value' : 'dem-field_empty'; ?>">
          <?php printf('<input %s />', implode(' ', array_filter(array(
              sprintf('%s="%s"', 'class', implode(' ', array_filter(array(
                  'dem-field__input',
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
            <img class="dem-field__value__img" src="<?php echo $attachment ? $attachment['src'] : ''; ?>" alt="<?php echo isset($args['placeholder']) ? $args['placeholder'] : '' ?>" />
          </span>
          <span class="dem-field__actions">
            <a class="dem-field__action dem-field__action_add" href="#" title="<?php _e('Add icon', 'dem'); ?>"></a>
            <a class="dem-field__action dem-field__action_edit" href="#" title="<?php _e('Edit icon', 'dem'); ?>"></a>
            <a class="dem-field__action dem-field__action_remove" href="#" title="<?php _e('Remove icon', 'dem'); ?>"></a>
          </span>
          <?php

          if ($described) {

              ?>
              <span class="description dem-field__description" id="<?php echo $described; ?>"><?php echo $args['description']; ?></span>
              <?php

          }

          ?>
        </div>
        <?php
    }

}