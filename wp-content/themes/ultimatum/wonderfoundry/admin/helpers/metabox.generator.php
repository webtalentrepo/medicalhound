<?php
/*
 WARNING: This file is part of the core Ultimatum framework. DO NOT edit
 this file under any circumstances.
 */

/**
 *
 * This file is a core Ultimatum file and should not be edited.
 *
 * @package  Ultimatum
 * @author   Wonder Foundry http://www.wonderfoundry.com
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://ultimatumtheme.com
 * @version 2.38
 */

class metaboxesGenerator {
	var $config;
	var $options;
	var $saved_options;

	/**
	 * Constructor
	 *
	 * @param string $name
	 * @param array $options
	 */
	function metaboxesGenerator($config, $options) {
		$this->config = $config;
		$this->options = $options;

		add_action('admin_menu', array(&$this, 'create'));
		add_action('save_post', array(&$this, 'save'));
	}

	function create() {
		if (function_exists('add_meta_box')) {
			if (! empty($this->config['callback']) && function_exists($this->config['callback'])) {
				$callback = $this->config['callback'];
			} else {
				$callback = array(&$this, 'render');
			}
			foreach($this->config['pages'] as $page) {
				add_meta_box($this->config['id'], $this->config['title'], $callback, $page, $this->config['context'], $this->config['priority']);
			}
		}
	}

	function save($post_id) {
		if (! isset($_POST[$this->config['id'] . '_noncename'])) {
			return $post_id;
		}

		if (! wp_verify_nonce($_POST[$this->config['id'] . '_noncename'], plugin_basename(__FILE__))) {
			return $post_id;
		}

		if ('page' == $_POST['post_type']) {
			if (! current_user_can('edit_page', $post_id)) {
				return $post_id;
			}
		} else {
			if (! current_user_can('edit_post', $post_id)) {
				return $post_id;
			}
		}

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}
		add_post_meta($post_id, 'textfalse', false, true);

		foreach($this->options as $option) {
			if (isset($option['id']) && ! empty($option['id'])) {

				if (isset($_POST[$option['id']])) {
					if ($option['type'] == 'multidropdown') {
						$value = array_unique(explode(',', $_POST[$option['id']]));
					} else {
						$value = $_POST[$option['id']];
					}
				} else if ($option['type'] == 'toggle') {
					$value = - 1;
				} else {
					$value = false;
				}

				if (get_post_meta($post_id, $option['id']) == "") {
					add_post_meta($post_id, $option['id'], $value, true);
				} elseif ($value != get_post_meta($post_id, $option['id'], true)) {
					update_post_meta($post_id, $option['id'], $value);
				} elseif ($value == "") {
					delete_post_meta($post_id, $option['id'], get_post_meta($post_id, $option['id'], true));
				}
			}
		}
	}

	function render() {
		global $post;

		foreach($this->options as $option) {
			if (method_exists($this, $option['type'])) {
				if (isset($option['id'])) {
					$default = get_post_meta($post->ID, $option['id'], true);
					if ($default != "") {
						$option['default'] = $default;
					}
				}
				$this->$option['type']($option);
			}
		}

		echo '<input type="hidden" name="' . $this->config['id'] . '_noncename" id="' . $this->config['id'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
	}

	/**
	 * prints the title and desc
	 */
	function title($value) {
		echo '<div class="meta-box-item">';
		if (isset($value['name'])) {
			echo '<div class="meta-box-item-title"><h4>' . $value['name'] . '</h4></div>';
		}
		if (isset($value['desc'])) {
			echo '<p>' . $value['desc'] . '</p>';
		}
		echo '</div>';
	}

	/**
	 * displays a text input
	 */
	function text($value) {
		$size = isset($value['size']) ? $value['size'] : '10';

		echo '<div class="meta-box-item">';
		echo '<div class="meta-box-item-title"><h4>' . $value['name'] . '</h4>';
		if (isset($value['desc'])) {
			echo '<a class="switch" href="">[+] more info</a></div><p class="description">' . $value['desc'] . '</p>';
		} else {
			echo '</div>';
		}
		echo '<div class="meta-box-item-content">';
		echo '<input'.(isset($value['class'])?' class="'.$value['class'].'"':'').' name="' . $value['id'] . '" id="' . $value['id'] . '" type="text" size="' . $size . '" value="' . $value['default'] . '" />';
		echo '<br /></div>';
		echo '</div>';
	}

	/**
	 * displays a textarea
	 */
	function textarea($value) {
		$rows = isset($value['rows']) ? $value['rows'] : '7';

		echo '<div class="meta-box-item">';
		echo '<div class="meta-box-item-title"><h4>' . $value['name'] . '</h4>';
		if (isset($value['desc'])) {
			echo '<a class="switch" href="">[+] more info</a></div><p class="description">' . $value['desc'] . '</p>';
		} else {
			echo '</div>';
		}
		echo '<div class="meta-box-item-content"><textarea rows="' . $rows . '" name="' . $value['id'] . '" type="' . $value['type'] . '" class="code">' . $value['default'] . '</textarea>';
		echo '<br /></div>';
		echo '</div>';

	}

	/**
	 * displays a select
	 */
	function select($value) {
		if (isset($value['target'])) {
			if (isset($value['options'])) {
				$value['options'] = $value['options'] + $this->get_select_target_options($value['target']);
			} else {
				$value['options'] = $this->get_select_target_options($value['target']);
			}
		}

		echo '<div class="meta-box-item">';
		echo '<div class="meta-box-item-title"><h4>' . $value['name'] . '</h4>';
		if (isset($value['desc'])) {
			echo '<a class="switch" href="">[+] more info</a></div><p class="description">' . $value['desc'] . '</p>';
		} else {
			echo '</div>';
		}
		echo '<div class="meta-box-item-content"><select name="' . $value['id'] . '" id="' . $value['id'] . '">';
		if(isset($value['prompt'])){
			echo '<option value="">'.$value['prompt'].'</option>';
		}

		foreach($value['options'] as $key => $option) {
			echo '<option value="' . $key . '"';
			if ($key == $value['default']) {
				echo ' selected="selected"';
			}
				
			echo '>' . $option . '</option>';
		}

		echo '</select><br /></div>';
		echo '</div>';

	}

	/**
	 * displays a multiselect
	 */
	function multiselect($value) {
		$size = isset($value['size']) ? $value['size'] : '5';
		if (isset($value['target'])) {
			if (isset($value['options'])) {
				$value['options'] = $value['options'] + $this->get_select_target_options($value['target']);
			} else {
				$value['options'] = $this->get_select_target_options($value['target']);
			}
		}

		echo '<div class="meta-box-item">';
		echo '<div class="meta-box-item-title"><h4>' . $value['name'] . '</h4>';
		if (isset($value['desc'])) {
			echo '<a class="switch" href="">[+] more info</a></div><p class="description">' . $value['desc'] . '</p>';
		} else {
			echo '</div>';
		}
		echo '<div class="meta-box-item-content"><select name="' . $value['id'] . '[]" id="' . $value['id'] . '" multiple="multiple" size="' . $size . '" style="height:auto">';

		foreach($value['options'] as $key => $option) {
			echo '<option value="' . $key . '"';
			if (in_array($key, $value['default'])) {
				echo ' selected="selected"';
			}
			echo '>' . $option . '</option>';
		}

		echo '</select><br /></div>';
		echo '</div>';

	}

	/**
	 * displays a multidropdown
	 */
	function multidropdown($value) {
		if (isset($value['target'])) {
			if (isset($value['options'])) {
				$value['options'] = $value['options'] + $this->get_select_target_options($value['target']);
			} else {
				$value['options'] = $this->get_select_target_options($value['target']);
			}
		}
		if (! is_array($value['default'])) {
			$value['default'] = array();
		}

		echo '<div class="meta-box-item">';
		echo '<div class="meta-box-item-title"><h4>' . $value['name'] . '</h4>';
		if (isset($value['desc'])) {
			echo '<a class="switch" href="">[+] more info</a></div><p class="description">' . $value['desc'] . '</p>';
		} else {
			echo '</div>';
		}

		echo '<div class="meta-box-item-content">';
		echo '<input type="hidden" id="' . $value['id'] . '" name="' . $value['id'] . '" value="' . implode(',', $value['default']) . '"/>';
		echo '<div class="multidropdown-wrap">';

		$i = 0;
		if (is_array($value['default'])) {
			foreach($value['default'] as $selected) {
				echo '<select name="' . $value['id'] . '_' . $i . '" id="' . $value['id'] . '_' . $i . '">';
				echo '<option value="">Choose one...</option>';
				foreach($value['options'] as $key => $option) {
					echo '<option value="' . $key . '"';
					if ($selected == $key) {
						echo ' selected="selected"';
					}
					echo '>' . $option . '</option>';
				}
				$i++;
				echo '</select>';
			}
		}

		echo '<select name="' . $value['id'] . '_' . $i . '" id="' . $value['id'] . '_' . $i . '">';
		echo '<option value="">Choose one...</option>';
		foreach($value['options'] as $key => $option) {
			echo '<option value="' . $key . '">' . $option . '</option>';
		}
		echo '</select></div></div>';
		echo '</div>';
	}

	function superlink($value) {
		$target = '';
		if (! empty($value['default'])) {
			list($target, $target_value) = explode('||', $value['default']);
		}
		if ( empty($value['shows'])) {
			$value['shows'] = array('page','cat','post','gallery','manually');
		}

		echo '<div class="meta-box-item">';
		echo '<div class="meta-box-item-title"><h4>' . $value['name'] . '</h4>';
		if (isset($value['desc'])) {
			echo '<a class="switch" href="">[+] more info</a></div><p class="description">' . $value['desc'] . '</p>';
		} else {
			echo '</div>';
		}

		echo '<div class="meta-box-item-content">';
		echo '<input type="hidden" id="' . $value['id'] . '" name="' . $value['id'] . '" value="' . $value['default'] . '"/>';

		$method_options = array(
				'page' => 'Link to page',
				'cat' => 'Link to category',
				'post' => 'Link to post',
				'gallery'=> 'Link to gallery',
				'manually' => 'Link manually'
		);

		foreach ($method_options as $key => $v){
			if(!in_array($key,$value['shows'])){
				unset($method_options[$key]);
			}
		}

		echo '<select name="' . $value['id'] . '_selector" id="' . $value['id'] . '_selector">';
		echo '<option value="">Select Linking method</option>';
		foreach($method_options as $key => $option) {
			echo '<option value="' . $key . '"';
			if ($key == $target) {
				echo ' selected="selected"';
			}
			echo '>' . $option . '</option>';
		}
		echo '</select>';

		echo '<div class="superlink-wrap">';

		if(in_array('page',$value['shows'])){
			//render page selector
			$hidden = ($target != "page") ? 'class="hidden"' : '';
			echo '<select name="' . $value['id'] . '_page" id="' . $value['id'] . '_page" ' . $hidden . '>';
			echo '<option value="">Select Page</option>';
				
			$selected = ($target == "page")?$target_value:0;
			$args = array(
					'depth' => 0, 'child_of' => 0,
					'selected' => $selected, 'echo' => 1,
					'name' => 'page_id', 'id' => '',
					'show_option_none' => '', 'show_option_no_change' => '',
					'option_none_value' => ''
			);
			$pages = get_pages($args);
			echo walk_page_dropdown_tree($pages,$args['depth'],$args);
				
			/*
			 foreach($this->get_select_target_options('page') as $key => $option) {
			echo '<option value="' . $key . '"';
			if ($target == "page" && $key == $target_value) {
			echo ' selected="selected"';
			}
			echo '>' . $option . '</option>';
			}
			*/
			echo '</select>';
		}

		if(in_array('gallery',$value['shows'])){
			//render gallery selector
			$hidden = ($target != "gallery") ? 'class="hidden"' : '';
			echo '<select name="' . $value['id'] . '_page" id="' . $value['id'] . '_gallery" ' . $hidden . '>';
			echo '<option value="">Select gallery</option>';
			foreach($this->get_select_target_options('gallery') as $key => $option) {
				echo '<option value="' . $key . '"';
				if ($target == "gallery" && $key == $target_value) {
					echo ' selected="selected"';
				}
				echo '>' . $option . '</option>';
			}
			echo '</select>';
		}

		if(in_array('cat',$value['shows'])){
			//render category selector
			$hidden = ($target != "cat") ? 'class="hidden"' : '';
			echo '<select name="' . $value['id'] . '_cat" id="' . $value['id'] . '_cat" ' . $hidden . '>';
			echo '<option value="">Select Category</option>';
			foreach($this->get_select_target_options('cat') as $key => $option) {
				echo '<option value="' . $key . '"';
				if ($target == "cat" && $key == $target_value) {
					echo ' selected="selected"';
				}
				echo '>' . $option . '</option>';
			}
			echo '</select>';
		}

		if(in_array('post',$value['shows'])){
			//render post selector
			$hidden = ($target != "post") ? 'class="hidden"' : '';
			echo '<select name="' . $value['id'] . '_post" id="' . $value['id'] . '_post" ' . $hidden . '>';
			echo '<option value="">Select Post</option>';
			foreach($this->get_select_target_options('post') as $key => $option) {
				echo '<option value="' . $key . '"';
				if ($target == "post" && $key == $target_value) {
					echo ' selected="selected"';
				}
				echo '>' . $option . '</option>';
			}
			echo '</select>';
		}

		if(in_array('manually',$value['shows'])){
			//render manually
			$hidden = ($target != "manually") ? 'class="hidden"' : '';
			echo '<input name="' . $value['id'] . '_manually" id="' . $value['id'] . '_manually" type="text" value="';
			if ($target == 'manually') {
				echo $target_value;
			}
			echo '" size="35" ' . $hidden . '/>';
		}

		echo '</div>';
		echo '</div>';
		echo '</div>';
	}

	/**
	 * displays a checkbox
	 */
	function checkbox($value) {
		echo '<div class="meta-box-item">';
		echo '<div class="meta-box-item-title"><h4>' . $value['name'] . '</h4>';
		if (isset($value['desc'])) {
			echo '<a class="switch" href="">[+] more info</a></div><p class="description">' . $value['desc'] . '</p>';
		} else {
			echo '</div>';
		}

		echo '<div class="meta-box-item-content">';
		$i = 0;
		foreach($value['options'] as $key => $option) {
			$i++;
			$checked = '';
			if (is_array($value['default']) && in_array($key, $value['default'])) {
				$checked = ' checked="checked"';
			}
			echo '<input type="checkbox" name="' . $value['id'] . '[]" id="' . $value['id'] . '_' . $i . '" value="' . $key . '" ' . $checked . ' />';
			echo '<label for="' . $value['id'] . '_' . $i . '">' . $option . '</label><br />';
		}
		echo '</div>';
		echo '</div>';

	}

	/**
	 * displays a radio
	 */
	function radio($value) {
		echo '<div class="meta-box-item">';
		echo '<div class="meta-box-item-title"><h4>' . $value['name'] . '</h4>';
		if (isset($value['desc'])) {
			echo '<a class="switch" href="">[+] more info</a></div><p class="description">' . $value['desc'] . '</p>';
		} else {
			echo '</div>';
		}
		echo '<div class="meta-box-item-content">';
		$i = 0;
		foreach($value['options'] as $key => $option) {
			$i++;
			$checked = '';
			if ($key == $value['default']) {
				$checked = ' checked="checked"';
			}
				
			echo '<input type="radio" id="' . $value['id'] . '_' . $i . '" name="' . $value['id'] . '" value="' . $key . '" ' . $checked . ' />';
			echo '<label for="' . $value['id'] . '_' . $i . '">' . $option . '</label><br />';
		}
		echo '</div>';
		echo '</div>';

	}

	/**
	 * displays a upload field
	 */
	function upload($value) {
		$size = isset($value['size']) ? $value['size'] : '25';
		global $post_ID, $temp_ID;
		$postid = (int) (0 == $post_ID ? $temp_ID : $post_ID);

		echo '<div class="meta-box-item">';
		echo '<div class="meta-box-item-title"><h4>' . $value['name'] . '</h4>';
		if (isset($value['desc'])) {
			echo '<a class="switch" href="">[+] more info</a></div><p class="description">' . $value['desc'] . '</p>';
		} else {
			echo '</div>';
		}

		echo '<div class="meta-box-item-content">';

		echo '<div id="' . $value['id'] . '_preview" class="option-image-preview">';
		if (! empty($value['default'])) {
			echo '<a class="thickbox" href="' . $value['default'] . '?"><img src="' . $value['default'] . '"/></a>';
		}
		echo '</div>';

		echo '<input type="text" class="input_uploader" id="' . $value['id'] . '" name="' . $value['id'] . '" size="' . $size . '"  value="';
		echo $value['default'];
		echo '" /><div class="theme-upload-buttons"><a class="thickbox button theme-upload-button" id="' . $value['id'] . '" href="media-upload.php?&post_id=' . $postid . '&target=' . $value['id'] . '&option_image_upload=1&type=image&TB_iframe=1&width=640&height=644">' . $value['button'] . '</a></div>';
		echo '</div>';
		echo '</div>';
	}

	/**
	 * displays a color input
	 */
	function color($value) {
		$size = isset($value['size']) ? $value['size'] : '10';

		echo '<div class="meta-box-item">';
		echo '<div class="meta-box-item-title"><h4>' . $value['name'] . '</h4>';
		if (isset($value['desc'])) {
			echo '<a class="switch" href="">[+] more info</a></div><p class="description">' . $value['desc'] . '</p>';
		} else {
			echo '</div>';
		}
		echo '<div class="meta-box-item-content">';
		echo '<div class="color-input-wrap"><input'.(isset($value['class'])?' class="'.$value['class'].'"':'').' name="' . $value['id'] . '" id="' . $value['id'] . '" type="color" data-hex="true" size="' . $size . '" value="' . $value['default'] . '" /></div>';
		echo '<br /></div>';
		echo '</div>';
	}

	/**
	 * displays a toggle button
	 */
	function toggle($value) {
		$checked = '';
		if ($value['default'] == true && $value['default'] != "-1") {
			$checked = 'checked="checked"';
		}

		echo '<div class="meta-box-item">';
		echo '<div class="meta-box-item-title"><h4>' . $value['name'] . '</h4>';
		if (isset($value['desc'])) {
			echo '<a class="switch" href="">[+] more info</a></div><p class="description">' . $value['desc'] . '</p>';
		} else {
			echo '</div>';
		}

		echo '<div class="meta-box-item-content"><input type="checkbox" class="toggle-button" name="' . $value['id'] . '" id="' . $value['id'] . '" value="true" ' . $checked . ' />';
		echo '</div>';
		echo '</div>';

	}

	/**
	 * displays a editor
	 */
	function editor($value) {
		echo '<div class="meta-box-item">';
		echo '<div class="meta-box-item-title"><h4>' . $value['name'] . '</h4>';
		if (isset($value['desc'])) {
			echo '<a class="switch" href="">[+] more info</a></div><p class="description">' . $value['desc'] . '</p>';
		} else {
			echo '</div>';
		}
		echo '<div class="meta-box-item-content">';
		the_editor($value['default'],$value['id']);
		echo '</div>';
		echo '</div>';
	}

	/**
	 * displays a custom field
	 */
	function custom($value) {
		if(isset($value['layout']) && $value['layout']==false){
			if (isset($value['function']) && function_exists($value['function'])) {
				$value['function']($value, $value['default']);
			} else {
				echo $value['html'];
			}
		}else{
			echo '<div class="meta-box-item">';
			echo '<div class="meta-box-item-title"><h4>' . $value['name'] . '</h4>';
			if (isset($value['desc'])) {
				echo '<a class="switch" href="">[+] more info</a></div><p class="description">' . $value['desc'] . '</p>';
			} else {
				echo '</div>';
			}
			echo '<div class="meta-box-item-content">';

			if (isset($value['function']) && function_exists($value['function'])) {
				$value['function']($value, $value['default']);
			} else {
				echo $value['html'];
			}
			echo '</div>';
			echo '</div>';
		}

	}

	function get_select_target_options($type) {
		$options = array();
		switch($type){
			case 'page':
				$entries = get_pages('title_li=&orderby=name');
				foreach($entries as $key => $entry) {
					$options[$entry->ID] = $entry->post_title;
				}
				break;
			case 'cat':
				$entries = get_categories('title_li=&orderby=name&hide_empty=0');
				foreach($entries as $key => $entry) {
					$options[$entry->term_id] = $entry->name;
				}
				break;
			case 'post':
				$entries = get_posts('orderby=title&numberposts=-1&order=ASC');
				foreach($entries as $key => $entry) {
					$options[$entry->ID] = $entry->post_title;
				}
				break;
			case 'gallery':
				$entries = get_posts('post_type=gallery&orderby=title&numberposts=-1&order=ASC');
				foreach($entries as $key => $entry) {
					$options[$entry->ID] = $entry->post_title;
				}
				break;
			case 'gallery_category':
				$entries = get_terms('gallery_category','orderby=name&hide_empty=0');
				foreach($entries as $key => $entry) {
					$options[$entry->slug] = $entry->name;
				}
				break;
			case 'slideshow_category':
				$entries = get_terms('slideshow_category','orderby=name&hide_empty=0');
				foreach($entries as $key => $entry) {
					$options[$entry->slug] = $entry->name;
				}
				break;
		}

		return $options;
	}
}
