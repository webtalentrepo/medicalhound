<?php
class optionGenerator {
	var $name;
	var $options;
	var $saved_options;
	/**
	 * Constructor
	 * 
	 * @param string $name
	 * @param array $options
	 */
	function optionGenerator($name, $options) {
		
		$this->name = $name;
		$this->options = $options;
		
		$this->save_options();
		$this->render();
	}
	
	function save_options() {
		$setter='_';
		if(isset($_GET["layout_id"])){
			$setter='_'.$_GET["layout_id"].'_';	
		}
		if(isset($_GET["template_id"])){
			$setter='_template_'.$_GET["template_id"].'_';
		}
		if(preg_match('/ultimatum_/i', $this->name)){
			$optionmane = $this->name;
		} else {
			$optionmane=THEME_SLUG .$setter. $this->name;
		}
		
		$options = get_option($optionmane);
		if('ultimatum_toolset' == $this->name){
			$options = get_site_option($optionmane);
		}
		if (isset($_POST['save_options'])) {
			
			foreach($this->options as $value) {
				
				if (isset($value['id']) && ! empty($value['id'])) {
					if (isset($_POST[$value['id']])) {
						if($value['type'] == 'toggle'){
							if($_POST[$value['id']] == 'true'){
								$options[$value['id']] = true;
							}else{
								$options[$value['id']] = false;
							}
						} else {
							$options[$value['id']] = $_POST[$value['id']];
						}
					} else {
						$options[$value['id']] = false;
					}
				}
				if (isset($value['process']) && function_exists($value['process'])) {
					$options[$value['id']] = $value['process']($value,$options[$value['id']]);
				}
			}
			if ($options != $this->options) {
				if('ultimatum_toolset' == $this->name){
					update_site_option($optionmane, $options);
				} else {
					update_option($optionmane, $options);
				}
				global $theme_options;
				$theme_options[$this->name] = $options;
				if($this->name=='css'){
					require_once (ULTIMATUM_ADMIN_HELPERS .DS. 'class.css.saver.php');
					if(isset($_GET['layout_id'])){
						WonderWorksCSS::saveCSS($_GET["layout_id"]);
					}
					if(isset($_GET['template_id'])){
						WonderWorksCSS::saveCSS($_GET["template_id"],'template');
					}	
				}
			}
			echo '<div id="message" class="updated fade"><p><strong>Updated Successfully</strong></p></div>';
		}
		$this->saved_options = $options;
	}
	
	
	function render() {
		if(isset($this->options) && is_array($this->options)):
		echo '<div class="wrap">';
		echo '<form method="post" action="" id="ult-setting-form">';
		
		foreach($this->options as $option) {
			if (isset($option['type']) && method_exists($this, $option['type'])) {
				$this->$option['type']($option);
			}
		
		}
		
		echo '<input type="hidden" name="save_options" value="true" /></form>';
		echo '</div>';
		endif;
	}
	
	/**
	 * prints the options page title
	 */
	function title($value) {
		echo '<h2>' . $value['name'] . '</h2>';
		if (isset($value['desc'])) {
			echo '<p>' . $value['desc'] . '</p>';
		}
	}
	
	
	function table_start($value){
		echo '<table width="100%">';
	}
	function table_end($value){
		echo '</table>';
	}
	function table_row_start($value){
		echo '<tr valign="top">';
	}
	function table_col_start($value){
		echo '<td width="'.$value['default'].'">';
	}
	function table_row_end($value){
		echo '</tr>';
	}
	function table_col_end($value){
		echo '</td>';
	}
	function explain($value){
		echo '<p><i>'.$value["name"].'</i></p>';
	}
	
	/**
	 * begins the group section
	 */
	function start($value) {
		echo '<div class="">';
		echo '<table cellspacing="0" class="widefat ult-tables">';
		echo '<thead><tr valign="top" class="alternate">';
		echo '<td scope="row" colspan="3"><h3>' . $value['name'] . '</h3></td>';
		echo '</tr></thead><tbody>';
	}
	
	function txtElementHead($value) {
	}
	
	function txtElement($value) {
		$values = isset($this->saved_options[$value['id']])? $this->saved_options[$value['id']]:'';
		
		echo '<table  class="widefat ult-tables" style="width:100%">';
		echo '<thead><tr class="alternate">';
		echo '<td colspan="7"><h3>' .$value["name"].'</h3></td></tr></thead><tbody>';
		if(isset($value['default']['font-family'])){
		echo '<tr>';
		echo '<td>' . __('Font Family', 'ultimatum') . '</td>';
		echo '<td>';
		$dfonts= array(
				'inherit' => 'inherit',
				'Arial,Helvetica,Garuda,sans-serif' => 'Arial,Helvetica,Garuda,sans-serif',
				'"Arial Black",Gadget,sans-serif' => '"Arial Black",Gadget,sans-serif',
				'Verdana,Geneva,Kalimati,sans-serif' => 'Verdana,Geneva,Kalimati,sans-serif',
				'"Lucida Sans Unicode","Lucida Grande",Garuda,sans-serif' => '"Lucida Sans Unicode","Lucida Grande",Garuda,sans-serif',
				'Georgia,"Nimbus Roman No9 L",serif' => 'Georgia,"Nimbus Roman No9 L",serif',
				'"Palatino Linotype","Book Antiqua",Palatino,FreeSerif,serif' => '"Palatino Linotype","Book Antiqua",Palatino,FreeSerif,serif',
				'Tahoma,Geneva,Kalimati,sans-serif' => 'Tahoma,Geneva,Kalimati,sans-serif',
				'"Trebuchet MS",Helvetica,Jamrul,sans-serif' => '"Trebuchet MS",Helvetica,Jamrul,sans-serif',
				'"Times New Roman",Times,FreeSerif,serif' => '"Times New Roman",Times,FreeSerif,serif',
			);
			// Get the enabled Fonts
			$fonts =get_option(THEME_SLUG . '_fonts');
			$cufon= isset($fonts["cufon"]) ? $fonts["cufon"]: false;
			$fontface=isset($fonts["fontface"])? $fonts["fontface"] : false;
			$google = isset($fonts["google"]) ? $fonts["google"] : false;
		//	print_r($cufon);
			echo '<select name="' . $value['id']. '[font-family]" id="' . $value['id'] . '" style="width:200px;">';
			if (isset($dfonts)) {
				foreach($dfonts as $key => $option) {
					echo "<option value='" . $key . "'";
					if (isset($values['font-family'])) {
						if (stripslashes($values['font-family']) == $key) {
							echo ' selected="selected"';
						}
					} else {
						if($key == $value['default']['font-family']) {
								echo ' selected="selected"';
						}
					}
					echo '>' . $option . '</option>';
				}
			}
			if(is_array($cufon) && count($cufon)!=0 && $value['cufon']){
				echo '<optgroup label="Cufon Fonts">';
				foreach ($cufon as $font=>$js){
					$key = 'cufon-'.$font.'-js-'.$js;
					echo '<option value="'.$key.'"';
					if (isset($values['font-family'])) {
					if (stripslashes($values['font-family']) == $key) {
							echo ' selected="selected"';
					}
					} else {
						if($key == $value['default']['font-family']) {
								echo ' selected="selected"';
						}
					}
					echo '>'.$font.'</option>';
				}
				echo '</optgroup>';
			}
			if(is_array($fontface) && count($fontface)!=0){
				echo '<optgroup label="@font-face">';
				foreach ($fontface as $font=>$js){
					$key = 'fontface-'.$font.'-css-'.$js;
					echo '<option value="'.$key.'"';
					if (isset($values['font-family'])) {
					if (stripslashes($values['font-family']) == $key) {
							echo ' selected="selected"';
					}
					} else {
						if($key == $value['default']['font-family']) {
								echo ' selected="selected"';
						}
					}
					echo '>'.$font.'</option>';
				}
				echo '</optgroup>';
			}
			if(is_array($google) && count($google)!=0){
				echo '<optgroup label="Google Fonts">';
				foreach ($google as $font=>$js){
					$key = 'google-'.$font.'-css-'.$js;
					echo '<option value="'.$key.'"';
					if (isset($values['font-family'])) {
					if (stripslashes($values['font-family']) == $key) {
							echo ' selected="selected"';
					}
					} else {
						if($key == $value['default']['font-family']) {
								echo ' selected="selected"';
						}
					}
					echo '>'.$font.'</option>';
				}
				echo '</optgroup>';
			}
			echo '</select>';
			echo '</td></tr>';
			
		}
		
		if(isset($value['default']['font-size'])){
			echo '<tr>';
			echo '<td>' . __('Font Size', 'ultimatum') . '</td>';
			echo '<td>';
			echo '<input name="' . $value['id'] . '[font-size]" id="' . $value['id'] . '" type="text" size="2" value="';
			if (isset($values['font-size'])) {
				echo stripslashes($values['font-size']);
			} else {
				echo $value['default']['font-size'];
			}
			echo '" /> px';
			echo '</td></tr>';
		}
		if(isset($value['default']['line-height'])){
			echo '<tr>';
			echo '<td>' . __('Line Height', 'ultimatum') . '</td>';
			echo '<td>';
			echo '<input name="' . $value['id'] . '[line-height]" id="' . $value['id'] . '" type="text" size="2" value="';
			if (isset($values['font-size'])) {
				echo stripslashes($values['line-height']);
			} else {
				echo $value['default']['line-height'];
			}
			echo '" /> px';
			echo '</td></tr>';
		}
		echo '<tr>';
		echo '<td>' . __('Color', 'ultimatum') . '</td>';
				if (isset($values["color"])) {
					$the_value = ($values["color"]);
					$the_value = '#'.str_replace('#', '', $the_value);
				} else {
					$the_value = $value['default']["color"];
				}
		echo '<td>';
				echo '<div style="width:255px"><input type="text" name="'.$value['id'].'[color]" value="'.$the_value.'" class="ult-color-field" /></div>';
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>' . __('Font Weight', 'ultimatum') . '</td>';
		echo '<td>';
			echo '<select name="' . $value['id'] . '[font-weight]" id="' . $value['id'] . '">';
				$options = array ('inherit' => 'inherit','normal'=>__('Normal', 'ultimatum'),'bold'=>__("Bold", 'ultimatum'));
				foreach($options as $key => $option) {
					echo "<option value='" . $key . "'";
					if (isset($values['font-weight'])) {
						if (stripslashes($values['font-weight']) == $key) {
							echo ' selected="selected"';
						}
					} else if ($key == $value['default']['font-weight']) {
						echo ' selected="selected"';
					}
						echo '>' . $option . '</option>';
				}
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>' . __('Style', 'ultimatum') . '</td>';
		
		echo '<td>';
			echo '<select name="' . $value['id'] . '[font-style]" id="' . $value['id'] . '">';
				$options = array ('inherit' => 'inherit','normal'=>__('Normal', 'ultimatum'),'italic'=>__("Italic", 'ultimatum'));
				foreach($options as $key => $option) {
					echo "<option value='" . $key . "'";
					if (isset($values['font-style'])) {
						if (stripslashes($values['font-style']) == $key) {
							echo ' selected="selected"';
						}
					} else if ($key == $value['default']['font-style']) {
						echo ' selected="selected"';
					}
						echo '>' . $option . '</option>';
				}
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>' . __('Decoration', 'ultimatum') . '</td>';
		echo '<td>';
			echo '<select name="' . $value['id'] . '[text-decoration]" id="' . $value['id'] . '">';
				$options = array ('inherit' => 'inherit','none'=>'None','underline'=>__("Underline", 'ultimatum'),'overline'=>__("Overline", 'ultimatum'),'line-through'=>__("Line-Through", 'ultimatum'));
				foreach($options as $key => $option) {
					echo "<option value='" . $key . "'";
					if (isset($values['font-style'])) {
						if (stripslashes($values['text-decoration']) == $key) {
							echo ' selected="selected"';
						}
					} else if ($key == $value['default']['text-decoration']) {
						echo ' selected="selected"';
					}
						echo '>' . $option . '</option>';
				}
		echo '</td>';
		echo '</tr></table><br />';
	}
	
	function desc($value) {
		echo '<tr valign="top"><td scope="row" colspan="2">' . $value['desc'] . '</td></tr>';
	}
	
	function tabopen($value){
		echo '<div id="'.$value[id].'">';
	}
	function tabclose($value){
		echo '</div>';
	}
	function end($value) {
		echo '</tbody></table></div><br />';
	}
	function justSave(){
		echo '<p class="submit" style="text-align:right"><input type="submit" name="save_options" class="button button-primary" value="'.__('Save Changes', 'ultimatum').'" /></p>';
	}
	function endnosave($value) {
		echo '</tbody></table></div><br />';
	}
	/**
	 * displays a text input
	 */
	function text($value) {
		$size = isset($value['size']) ? $value['size'] : '10';
        $class='';
		if(isset($value['append'])){
            $class = ' input-append';
        }
        if(isset($value['prepend'])){
            $class .= ' input-prepend';
        }
		echo '<tr valign="top">
                <td scope="row">
                    <strong>
                        <label for="'.$value['id'].'">' . $value['name'] . '</label>
                    </strong>
                </td>
                <td>';
        echo '<div class="'.$class.'">';
        if(isset($value['prepend'])){
            echo '<span class="add-on">'.$value['prepend'].'</span>';
        }
        echo '<input name="' . $value['id'] . '" id="' . $value['id'] . '" type="text" size="' . $size . '" value="';
        if (isset($this->saved_options[$value['id']])) {
            echo stripslashes($this->saved_options[$value['id']]);
        } else {
            echo $value['default'];
        }
        echo '" />';
        if(isset($value['append'])){
            echo '<span class="add-on">'.$value['append'].'</span>';
        }
		echo '</div>';

		echo '</td><td>';
		if(isset($value['desc'])){
			echo '<p class="description">' . $value['desc'] . '</p>';
		}
		echo '</td></tr>';
	}
	/**
	 * displays a text inputCSS
	 */
	function textCSS($value) {
		$size = isset($value['size']) ? $value['size'] : '10';
		$unit = 'px';
		echo '<tr valign="top"><td scope="row"><strong><label for="'.$value['id'].'-'.$value['property'].'">' . $value['name'] . '</label></strong></td><td>';
		if(isset($value['desc'])){
			echo '<p class="description">' . $value['desc'] . '</p>';
		}
        echo '<div class="input-append"><input type="text"  size="' . $size . '" value="';

		//echo '<input name="' . $value['id'].'['.$value['property'].']" id="' . $value['id'] . '-'.$value['property'].'" type="text" size="' . $size . '" value="';
		$values=$this->saved_options[$value["id"]];
		if (isset($values[$value['property']])) {
			echo stripslashes($values[$value['property']]);
		
		} else {
			echo $value['default'];
		}
        echo '" name="' . $value['id'].'['.$value['property'].']" /><span class="add-on">' . $unit . '</span></div>';

		echo '</td></tr>';
	}
	/**
	 * displays a textarea
	 */
	function textarea($value) {
		$rows = isset($value['rows']) ? $value['rows'] : '5';
		
		echo '<tr valign="top"><td scope="row"><strong><label for="'.$value['id'].'">' . $value['name'] . '</label></strong></td><td>';
		if(isset($value['desc'])){
			echo '<p class="description">' . $value['desc'] . '</p>';
		}
		echo '<textarea id="'.$value['id'].'" rows="' . $rows . '" name="' . $value['id'] . '" type="' . $value['type'] . '" style="width:100%">';
		if (isset($this->saved_options[$value['id']])) {
			echo stripslashes($this->saved_options[$value['id']]);
		} else {
			echo $value['default'];
		}
		echo '</textarea><br />';
		echo '</td></tr>';
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
		echo '<tr valign="top"><td scope="row"><strong><label for="'.$value['id'].'">' . $value['name'] . '</label></strong></td><td>';
		if(isset($value['desc'])){
			echo '<p class="description">' . $value['desc'] . '</p>';
		}
		echo '<select name="' . $value['id'] . '" id="' . $value['id'] . '">';
		
		if(isset($value['prompt'])){
			echo '<option value="">'.$value['prompt'].'</option>';
		}
		if (isset($value['options'])) {
			foreach($value['options'] as $key => $option) {
				echo "<option value='" . $key . "'";
				if (isset($this->saved_options[$value['id']])) {
					if (stripslashes($this->saved_options[$value['id']]) == $key) {
						echo ' selected="selected"';
					}
				} else if ($key == $value['default']) {
					echo ' selected="selected"';
				}
			
				echo '>' . $option . '</option>';
			}
		}
		echo '</select></td><td>';
		if(isset($value['desc'])){
			echo '<p class="description">' . $value['desc'] . '</p>';
		}
		echo '</td></tr>';
	}	
	function selectCSS($value) {
		
		if (isset($value['target'])) {
			if (isset($value['options'])) {
				$value['options'] = $value['options'] + $this->get_select_target_options($value['target']);
			} else {
				$value['options'] = $this->get_select_target_options($value['target']);
			}
		}
		echo '<tr valign="top"><td scope="row"><strong><label for="'.$value['id'].'">' . $value['name'] . '</label></strong></td><td>';
		if(isset($value['desc'])){
			echo '<p class="description">' . $value['desc'] . '</p>';
		}
		echo '<select name="' . $value['id'] . '['.$value['property'].']" id="' . $value['id'] . '">';
		
		if(isset($value['prompt'])){
			echo '<option value="">'.$value['prompt'].'</option>';
		}
		$values=$this->saved_options[$value["id"]];
		if (isset($values[$value['property']])) {
			$the_value = stripslashes($values[$value['property']]);
		}
		if (isset($value['options'])) {
			foreach($value['options'] as $key => $option) {
				echo "<option value='" . $key . "'";
				if (isset($the_value)) {
					if ($the_value == $key) {
						echo ' selected="selected"';
					}
				} else if ($key == $value['default']) {
					echo ' selected="selected"';
				}
			
				echo '>' . $option . '</option>';
			}
		}
		echo '</select><br />';
		echo '</td></tr>';
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
		echo '<tr valign="top"><td scope="row"><strong>' . $value['name'] . '</strong></td><td>';
		if(isset($value['desc'])){
			echo '<p class="description">' . $value['desc'] . '</p>';
		}
		echo '<select name="' . $value['id'] . '[]" id="' . $value['id'] . '" multiple="multiple" size="' . $size . '" style="height:auto">';
		
		if(!empty($value['options']) && is_array($value['options'])){
			foreach($value['options'] as $key => $option) {
				echo '<option value="' . $key . '"';
				if (isset($this->saved_options[$value['id']])) {
					if (is_array($this->saved_options[$value['id']])) {
						if (in_array($key, $this->saved_options[$value['id']])) {
							echo ' selected="selected"';
						}
					}
				} else if (in_array($key, $value['default'])) {
					echo ' selected="selected"';
				}
				echo '>' . $option . '</option>';
			}
		}
		
		echo '</select><br />';
		echo '</td></tr>';
	}
	/**
	 * displays a site select in MS
	 */
	function siteselect($value) {
		$size = isset($value['size']) ? $value['size'] : '10';
		if (isset($value['target'])) {
			if (isset($value['options'])) {
				$value['options'] = $value['options'] + $this->get_select_target_options($value['target']);
			} else {
				$value['options'] = $this->get_select_target_options($value['target']);
			}
		}
		echo '<tr valign="top"><td scope="row"><strong>' . $value['name'] . '</strong></td><td>';
		
		echo '<select name="' . $value['id'] . '[]" id="' . $value['id'] . '" multiple="multiple" size="' . $size . '" style="height:auto">';
	
		$blog_list = get_blog_list( 0, 'all' );
		foreach ($blog_list AS $blog) {
				echo '<option value="' . $blog['blog_id'] . '"';
				if (isset($this->saved_options[$value['id']])) {
					if (is_array($this->saved_options[$value['id']])) {
						if (in_array($blog['blog_id'], $this->saved_options[$value['id']])) {
							echo ' selected="selected"';
						}
					}
				} 
				echo '>' . $blog['domain'].$blog['path'] . '</option>';
			}
	
		echo '</select><br /></td><td>';
		if(isset($value['desc'])){
			echo '<p class="description">' . $value['desc'] . '</p>';
		}
		echo '</td></tr>';
	}
	/**
	 * displays a user selection
	 */
	function userselect($value) {
		$size = isset($value['size']) ? $value['size'] : '5';
		if (isset($value['target'])) {
			if (isset($value['options'])) {
				$value['options'] = $value['options'] + $this->get_select_target_options($value['target']);
			} else {
				$value['options'] = $this->get_select_target_options($value['target']);
			}
		}
		echo '<tr valign="top"><td scope="row"><strong>' . $value['name'] . '</strong></td><td>';
		if(isset($value['desc'])){
			echo '<p class="description">' . $value['desc'] . '</p>';
		}
		echo '<select name="' . $value['id'] . '[]" id="' . $value['id'] . '" multiple="multiple" size="' . $size . '" style="height:auto">';
		$roles = array('administrator', 'editor', 'author', 'contributor');
		
		/* Loop through users to search for the admin and editor users. */
		foreach( $roles as $role )
		{
			global $wpdb;
				$this_role = "'[[:<:]]".$role."[[:>:]]'";
				$query = "SELECT * FROM $wpdb->users WHERE ID = ANY (SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'wp_capabilities' AND meta_value RLIKE $this_role) ORDER BY user_nicename ASC LIMIT 10000";
				$users_of_this_role = $wpdb->get_results($query);
				if ($users_of_this_role)
				{
					foreach($users_of_this_role as $user)
					{
						$curuser = get_userdata($user->ID);
						echo '<option value="' . $curuser->ID . '"';
						if (isset($this->saved_options[$value['id']])) {
							if (is_array($this->saved_options[$value['id']])) {
								if (in_array($curuser->ID, $this->saved_options[$value['id']])) {
									echo ' selected="selected"';
								}
							}
						}
						echo '>' . $curuser->user_nicename . '</option>';
					}
					}
			}
		
		echo '</select><br />';
		
		echo '</td></tr>';
	}

	/**
	 * displays a checkbox
	 */
	function checkbox($value) {
		echo '<tr valign="top"><td scope="row"><strong>' . $value['name'] . '</strong></td><td>';
		if(isset($value['desc'])){
			echo '<p class="description">' . $value['desc'] . '</p>';
		}
		$i = 0;
		foreach($value['options'] as $key => $option) {
			$i++;
			$checked = '';
			if (isset($this->saved_options[$value['id']])) {
				if (is_array($this->saved_options[$value['id']])) {
					if (in_array($key, $this->saved_options[$value['id']])) {
						$checked = ' checked="checked"';
					}
				}
			} else if (in_array($key, $value['default'])) {
				$checked = ' checked="checked"';
			}
			
			echo '<input type="checkbox" id="' . $value['id'] . '_' . $i . '" name="' . $value['id'] . '[]" value="' . $key . '" ' . $checked . ' />';
			echo '<label for="' . $value['id'] . '_' . $i . '">' . $option . '</label><br />';
		}
		echo '</td></tr>';
	}
	
	/**
	 * displays checkboxs
	 */
	function checkboxs($value) {
		$size = isset($value['size']) ? $value['size'] : '5';
		if (isset($value['target'])) {
			if (isset($value['options'])) {
				$value['options'] = $value['options'] + $this->get_select_target_options($value['target']);
			} else {
				$value['options'] = $this->get_select_target_options($value['target']);
			}
		}
		echo '<tr valign="top"><td scope="row"><strong>' . $value['name'] . '</strong></td><td>';
		if(isset($value['desc'])){
			echo '<p class="description">' . $value['desc'] . '</p>';
		}
		
		if(!empty($value['options']) && is_array($value['options'])){
			foreach($value['options'] as $key => $option) {
				echo '<label><input type="checkbox" value="' . $key . '" name="' . $value['id'] . '[]"';
				if (isset($this->saved_options[$value['id']])) {
					if (is_array($this->saved_options[$value['id']])) {
						if (in_array($key, $this->saved_options[$value['id']])) {
							echo ' checked="checked"';
						}
					}
				} else if (in_array($key, $value['default'])) {
					echo ' checked="checked"';
				}
				echo '>' . $option . '</label><br/>';
			}
		}
		
		echo '</td></tr>';
	}
	
	/**
	 * displays a radio
	 */
	function radio($value) {
		
		if (isset($this->saved_options[$value['id']])) {
			$checked_key = $this->saved_options[$value['id']];
		} else {
			$checked_key = $value['default'];
		}
		echo '<tr valign="top"><td scope="row"><strong>' . $value['name'] . '</strong></td><td>';
		if(isset($value['desc'])){
			echo '<p class="description">' . $value['desc'] . '</p>';
		}
		$i = 0;
		foreach($value['options'] as $key => $option) {
			$i++;
			$checked = '';
			if ($key == $checked_key) {
				$checked = ' checked="checked"';
			}
			
			echo '<input type="radio" id="' . $value['id'] . '_' . $i . '" name="' . $value['id'] . '" value="' . $key . '" ' . $checked . ' />';
			echo '<label for="' . $value['id'] . '_' . $i . '">' . $option . '</label><br />';
		}
		
		echo '</td></tr>';
	}
	
	/**
	 * displays a upload field
	 */
	function upload($value) {
		
		$size = isset($value['size']) ? $value['size'] : '50';
		$button = isset($value['button']) ? $value['button'] : 'Insert Image';
		if (isset($this->saved_options[$value['id']])) {
			$value['default'] = stripslashes($this->saved_options[$value['id']]);
		}
		echo '<tr valign="top"><td width="200"><strong>' . $value['name'] . '</strong></td><td><table><tr valign="top"><td style="border:none">';
		
		
		echo '<input type="text" id="' . $value['id'] . '-bgi" name="' . $value['id'] .'" size="' . $size . '"  value="';
		echo $value['default'];
		echo '" /><br /><div class="option-upload-buttons"><a class="button option-upload-button" data-id="' . $value['id'] . '-bgi" href="#">'.$button.'</a></div>';
		echo '</td><td style="border:none">';
		echo '<div id="' . $value['id'] . '_preview">';
		if (! empty($value['default'])) {
			echo '<a class="thickbox" href="' . $value['default'] . '" target="_blank"><img src="' . $value['default'] . '" width="150" /></a>';
		}
		echo '</div>';
		echo '</td></tr></table>';
		echo '</td><td>';
		if(isset($value['desc'])){
			echo '<p class="description">' . $value['desc'] . '</p>';
		}
		echo '</td></tr>';
	}
	
	
	function uploadCSS($value) {
		$size = isset($value['size']) ? $value['size'] : '50';
		$button = isset($value['button']) ? $value['button'] : 'Insert Image';
		$values=$this->saved_options[$value["id"]];
		if (isset($values[$value['property']])) {
			$value['default'] = stripslashes($values[$value['property']]);
			$value['color'] = stripslashes($values['background-color']);
		}
		echo '<tr valign="top"><td scope="row"><strong>' . $value['name'] . '</strong></td><td><table><tr valign="top"><td style="border:none">';
		
		if(isset($value['desc'])){
			echo '<p class="description">' . $value['desc'] . '</p>';
		}
		echo '<input type="text" id="' . $value['id'] . '-bgi" name="' . $value['id'] . '['.$value["property"].']" size="' . $size . '"  value="';
		echo $value['default'];
		echo '" /><br /><div class="option-upload-buttons"><a class="button option-upload-button" data-id="' . $value['id'] . '-bgi" href="#">'.$button.'</a></div><br />';
		
		echo '</td><td style="border:none">';
		echo '<div id="' . $value['id'] . '_preview"'; 
		if(! empty($value['color'])){
			
			echo ' style="background-color:#'.$value['color'].'" ';
		}
		echo '>';
		if (! empty($value['default'])) {
			echo '<div style="width:150px;height:150px;background-image:url(' . $value['default'] . ');"></div>';
		}
		echo '</div>';
		echo '</td></tr></table>';
		echo '</td></tr>';
	}
	/**
	 * displays a range input
	 */
	function range($value) {
		echo '<tr valign="top"><td scope="row"><strong>' . $value['name'] . '</strong></td><td>';
		if(isset($value['desc'])){
			echo '<p class="description">' . $value['desc'] . '</p>';
		}
		echo '<div class="range-input-wrap"><input name="' . $value['id'] . '" id="' . $value['id'] . '" type="range" value="';
		if (isset($this->saved_options[$value['id']])) {
			echo stripslashes($this->saved_options[$value['id']]);
		} else {
			echo $value['default'];
		}
		if (isset($value['min'])) {
			echo '" min="' . $value['min'];
		}
		if (isset($value['max'])) {
			echo '" max="' . $value['max'];
		}
		if (isset($value['step'])) {
			echo '" step="' . $value['step'];
		}
		echo '" />';
		if (isset($value['unit'])) {
			echo '<span>' . $value['unit'] . '</span>';
		}
		echo '</div></td></tr>';
	}
	
	/**
	 * displays a color input
	 */
	function color($value) {
		echo '<tr valign="top"><td scope="row"><strong>' . $value['name'] . '</strong></td><td>';
		if(isset($value['desc'])){
			echo '<p class="description">' . $value['desc'] . '</p>';
		}
		$values=$this->saved_options[$value["id"]];
		if (isset($values[$value['property']])) {
			$the_value = stripslashes($values[$value['property']]);
		}
		if (isset($the_value)) {
			$the_value = $the_value;
		} else {
			$the_value = $value['default'];
		}

		echo '<input type="text" name="'.$value['id'].'['.$value['property'].']" value="'.$the_value.'" class="ult-color-field" />';
		echo '</td></tr>';
	}
	
	/**
	 * displays a toggle checkbox
	 */
	function toggle($value) {
		$checked = '';
		if (isset($this->saved_options[$value['id']])) {
			if ($this->saved_options[$value['id']] == true) {
				$checked = 'checked="checked"';
			}
		} elseif ($value['default'] == true) {
			$checked = 'checked="checked"';
		}
		
		echo '<tr><td width="230"><strong>' . $value['name'] . '</strong></td>';
		echo '<td width="82"><div class="make-switch switch-small" data-on="success" data-off="warning"><input type="checkbox"  name="' . $value['id'] . '" id="' . $value['id'] . '" value="true" ' . $checked . ' /></div></td>';
		echo '<td>';
		if(isset($value['desc'])){
			echo '<p class="description">' . $value['desc'] . '</p>';
		}
		echo '</td></tr>';
	}
    /*
     * Some new Fields For the CSS Editor
     */
    function background($value){
        $size = isset($value['size']) ? $value['size'] : '50';
        $button = isset($value['button']) ? $value['button'] : 'Insert Image';
        $values=$this->saved_options[$value["id"]];
        // No errors please
        $defaults = array(
            'background-color'      => false,
            'background-repeat'     => false,
            'background-attachment' => false,
            'background-position'   => false,
            'background-image'      => false,
            'background-size'       => false,

        );
        $fields = wp_parse_args( $value, $defaults );
        $thevalue = wp_parse_args( $values, $defaults );
        echo '<tr><td width="230"><strong>' . $value['name'] . '</strong></td>';
        echo '<td>';
        if($fields['background-color']){
            echo '<div style="width:100%">';
            echo '<small><i>'.__('Background Color','ultimatum').'</i></small><br />';
            echo '<input type="text" name="'.$value['id'].'[background-color]" value="'.$thevalue['background-color'].'" class="ult-color-field" data-alpha="true" data-reset-alpha="true" />';
            echo '</div>';
        }
        if ( $fields['background-repeat']) {
            $array = array(
                'no-repeat' => 'No Repeat',
                'repeat'    => 'Repeat All',
                'repeat-x'  => 'Repeat Horizontally',
                'repeat-y'  => 'Repeat Vertically',
                'inherit'   => 'Inherit',
            );
            echo'<div class="ult-select-container">';
            echo '<small><i>'.__('Background Repeat','ultimatum').'</i></small><br />';
            echo '<select data-placeholder="' . __( 'Background Repeat', 'ultimatum' ) . '" name="' .$value['id']. '[background-repeat]" class="ult-select-2">';
            echo '<option></option>';

            foreach ( $array as $k => $v ) {
                echo '<option value="' . $k . '"' . selected( $thevalue['background-repeat'], $k, false ) . '>' . $v . '</option>';
            }
            echo '</select>';
            echo '</div>';
        }

        if ( $fields['background-clip']) {
            $array = array(
                'inherit'     => 'Inherit',
                'border-box'  => 'Border Box',
                'content-box' => 'Content Box',
                'padding-box' => 'Padding Box',
            );
            echo'<div class="ult-select-container">';
            echo '<small><i>'.__('Background Clip','ultimatum').'</i></small><br />';
            echo '<select data-placeholder="' . __( 'Background Clip', 'ultimatum' ) . '" name="' .$value['id']. '[background-clip]" class="ult-select-2">';
            echo '<option></option>';

            foreach ( $array as $k => $v ) {
                echo '<option value="' . $k . '"' . selected( $thevalue['background-clip'], $k, false ) . '>' . $v . '</option>';
            }
            echo '</select>';
            echo '</div>';
        }

        if ( $fields['background-origin']) {
            $array = array(
                'inherit'     => 'Inherit',
                'border-box'  => 'Border Box',
                'content-box' => 'Content Box',
                'padding-box' => 'Padding Box',
            );
            echo'<div class="ult-select-container">';
            echo '<small><i>'.__('Background Origin','ultimatum').'</i></small><br />';
            echo '<select data-placeholder="' . __( 'Background Origin', 'ultimatum' ) . '" name="' .$value['id']. '[background-origin]" class="ult-select-2">';
            echo '<option></option>';

            foreach ( $array as $k => $v ) {
                echo '<option value="' . $k . '"' . selected( $thevalue['background-origin'], $k, false ) . '>' . $v . '</option>';
            }
            echo '</select>';
            echo '</div>';
        }

        if ( $fields['background-size']) {
            $array = array(
                'inherit' => 'Inherit',
                'cover'   => 'Cover',
                'contain' => 'Contain',
            );
            echo'<div class="ult-select-container">';
            echo '<small><i>'.__('Background Size','ultimatum').'</i></small><br />';
            echo '<select data-placeholder="' . __( 'Background Size', 'ultimatum' ) . '" name="' .$value['id']. '[background-size]" class="ult-select-2">';
            echo '<option></option>';

            foreach ( $array as $k => $v ) {
                echo '<option value="' . $k . '"' . selected( $thevalue['background-size'], $k, false ) . '>' . $v . '</option>';
            }
            echo '</select>';
            echo '</div>';
        }

        if ( $fields['background-attachment']) {
            $array = array(
                'fixed'   => 'Fixed',
                'scroll'  => 'Scroll',
                'inherit' => 'Inherit',
            );
            echo'<div class="ult-select-container">';
            echo '<small><i>'.__('Background Attachment','ultimatum').'</i></small><br />';
            echo '<select data-placeholder="' . __( 'Background Attachment', 'ultimatum' ) . '" name="' .$value['id']. '[background-attachment]" class="ult-select-2">';
            echo '<option></option>';
            foreach ( $array as $k => $v ) {
                echo '<option value="' . $k . '"' . selected( $thevalue['background-attachment'], $k, false ) . '>' . $v . '</option>';
            }
            echo '</select>';
            echo '</div>';
        }

        if ($fields['background-position']) {
            $array = array(
                'top left'      => 'Left Top',
                'left center'   => 'Left center',
                'left bottom'   => 'Left Bottom',
                'top center'    => 'Center Top',
                'center center' => 'Center Center',
                'bottom center' => 'Center Bottom',
                'top right'     => 'Right Top',
                'right center'  => 'Right center',
                'bottom right'  => 'Right Bottom',
            );
            echo'<div class="ult-select-container">';
            echo '<small><i>'.__('Background Position','ultimatum').'</i></small><br />';
            echo '<select data-placeholder="' . __( 'Background Position', 'ultimatum' ) . '" name="'.$value['id'].'[background-position]" class="ult-select-2">';
            echo '<option></option>';

            foreach ( $array as $k => $v ) {
                echo '<option value="' . $k . '"' . selected( $thevalue['background-position'], $k, false ) . '>' . $v . '</option>';
            }
            echo '</select>';
            echo '</div>';
        }
        echo '<div style="width:100%;float:left;">';
        echo '<small><i>'.__('Background Image','ultimatum').'</i></small>';
        echo '<input placeholder="'.__('Enter full URL of the image or use Insert Image button','ultimatum').'" type="text" id="' . $value['id'] . '-bgi" name="' . $value['id'] . '[background-image]"   value="';
        echo $thevalue['background-image'];
        echo '" class="widefat" /><br /><div class="option-upload-buttons"><a class="button option-upload-button" data-id="' . $value['id'] . '-bgi" href="#">'.$button.'</a></div>';
        echo '</div>';
        echo '</td></tr>';
    }

    function typography($value){
        $values = isset($this->saved_options[$value['id']])? $this->saved_options[$value['id']]:'';
        // Set field array defaults.  No errors please
        $unit='px';
        $defaults    = array(
            'font-family'     => true,
            'font-size'       => true,
            'font-weight'     => true,
            'font-style'      => true,
            'text-align'      => false,
            'text-transform'  => false,
            'font-variant'    => false,
            'text-decoration' => false,
            'color'           => true,
            'line-height'     => true,
            'word-spacing'    => false,
            'letter-spacing'  => false,
            'cufon'           => false
        );
        $value = wp_parse_args( $value, $defaults );

        // Set value defaults.
        $defaults    = array(
            'font-family'     => '',
            'text-align'      => '',
            'text-transform'  => '',
            'font-variant'    => '',
            'text-decoration' => '',
            'line-height'     => '',
            'word-spacing'    => '',
            'letter-spacing'  => '',
            'font-weight'     => '',
            'font-style'      => '',
            'color'           => '',
            'font-size'       => '',
        );
        $values = wp_parse_args( $values, $defaults );
        echo '<tr><td width="230"><strong>' . $value['name'] . '</strong></td>';
        echo '<td>';
        // Fields are here
        $dfonts= array(
            'inherit' => 'inherit',
            'Arial,Helvetica,Garuda,sans-serif' => 'Arial,Helvetica,Garuda,sans-serif',
            '"Arial Black",Gadget,sans-serif' => '"Arial Black",Gadget,sans-serif',
            'Verdana,Geneva,Kalimati,sans-serif' => 'Verdana,Geneva,Kalimati,sans-serif',
            '"Lucida Sans Unicode","Lucida Grande",Garuda,sans-serif' => '"Lucida Sans Unicode","Lucida Grande",Garuda,sans-serif',
            'Georgia,"Nimbus Roman No9 L",serif' => 'Georgia,"Nimbus Roman No9 L",serif',
            '"Palatino Linotype","Book Antiqua",Palatino,FreeSerif,serif' => '"Palatino Linotype","Book Antiqua",Palatino,FreeSerif,serif',
            'Tahoma,Geneva,Kalimati,sans-serif' => 'Tahoma,Geneva,Kalimati,sans-serif',
            '"Trebuchet MS",Helvetica,Jamrul,sans-serif' => '"Trebuchet MS",Helvetica,Jamrul,sans-serif',
            '"Times New Roman",Times,FreeSerif,serif' => '"Times New Roman",Times,FreeSerif,serif',
        );
        // Get the enabled Fonts
        $fonts =get_option(THEME_SLUG . '_fonts');
        $cufon= isset($fonts["cufon"]) ? $fonts["cufon"]: false;
        $fontface=isset($fonts["fontface"])? $fonts["fontface"] : false;
		print_r($fonts);
        $google = $this->get_google_fonts();
        if ( $value['font-family'] === true ) {
            echo '<div class="ult-select-container  font-select">';
            echo '<small><i>' . __('Font Family', 'ultimatum') . '</i></small><br />';
            echo '<select name="' . $value['id'] . '[font-family]" id="' . $value['id'] . '" data-placeholder="' . __('Font Family', 'ultimatum') . '" class="ult-select-2 font-selector">';
            echo '<option></option>';
            if (isset($dfonts)) {
                foreach ($dfonts as $key => $option) {
                    echo "<option value='" . $key . "'";
                    if (isset($values['font-family'])) {
                        if (stripslashes($values['font-family']) == $key) {
                            echo ' selected="selected"';
                        }
                    } else {
                        if ($key == $value['default']['font-family']) {
                            echo ' selected="selected"';
                        }
                    }
                    echo '>' . $option . '</option>';
                }
            }
            if (is_array($cufon) && count($cufon) != 0 && $value['cufon']) {
                echo '<optgroup label="Cufon Fonts">';
                foreach ($cufon as $font => $js) {
                    $key = 'cufon-' . $font . '-js-' . $js;
                    echo '<option value="' . $key . '"';
                    if (isset($values['font-family'])) {
                        if (stripslashes($values['font-family']) == $key) {
                            echo ' selected="selected"';
                        }
                    } else {
                        if ($key == $value['default']['font-family']) {
                            echo ' selected="selected"';
                        }
                    }
                    echo '>' . $font . '</option>';
                }
                echo '</optgroup>';
            }
            if (is_array($fontface) && count($fontface) != 0) {
                echo '<optgroup label="@font-face">';
                foreach ($fontface as $font => $js) {
                    $key = 'fontface-' . $font . '-css-' . $js;
                    echo '<option value="' . $key . '"';
                    if (isset($values['font-family'])) {
                        if (stripslashes($values['font-family']) == $key) {
                            echo ' selected="selected"';
                        }
                    } else {
                        if ($key == $value['default']['font-family']) {
                            echo ' selected="selected"';
                        }
                    }
                    echo '>' . $font . '</option>';
                }
                echo '</optgroup>';
            }
            if (is_array($google) && count($google) != 0) {
                echo '<optgroup label="Google Fonts ('.count($google).' fonts)">';
                foreach ($google as $font => $js) {
                    $key = 'google-' . $font . '-css-' . $js;
                    echo '<option value="' . $key . '"';
                    if (isset($values['font-family'])) {
                        if (stripslashes($values['font-family']) == $key) {
                            echo ' selected="selected"';
                        }
                    } else {
                        if ($key == $value['default']['font-family']) {
                            echo ' selected="selected"';
                        }
                    }
                    echo '>' . $font . '</option>';
                }
                echo '</optgroup>';
            }
            echo '</select>';
            echo '</div>';
        }
        /* Font Align */
        if ( $value['text-align'] === true ) {
            echo '<div class="ult-select-container">';
            echo '<small><i>' . __( 'Text Align', 'ultimatum' ) . '</i></small>';
            echo '<select data-placeholder="' . __( 'Text Align', 'ultimatum' ) . '" name="' .$value['id']. '[text-align]" class="ult-select-2">';
            echo '<option value=""></option>';
            $align = array(
                'inherit',
                'left',
                'right',
                'center',
                'justify',
                'initial'
            );

            foreach ( $align as $v ) {
                echo '<option value="'.$v.'" '.selected( $values['text-align'], $v, false ).'>'.ucfirst( $v ).'</option>';
            }

            echo '</select>';
            echo '</div>';
        }
        /* Font Weight */
        if ( $value['font-weight'] === true ) {
            echo '<div class="ult-select-container">';
            echo '<small><i>' . __( 'Font Weight', 'ultimatum' ) . '</i></small>';
            echo '<select data-placeholder="' . __( 'Font Weight', 'ultimatum' ) . '" name="' .$value['id']. '[font-weight]" class="ult-select-2">';
            echo '<option value=""></option>';
            $align = array(
                'inherit',
                '200',
                'normal',
                'bold',
                '900',
            );

            foreach ( $align as $v ) {
                echo '<option value="'.$v.'" '.selected( $values['font-weight'], $v, false ).'>'.ucfirst( $v ).'</option>';
            }

            echo '</select>';
            echo '</div>';
        }
        /* Font Style */
        if ( $value['font-style'] === true ) {
            echo '<div class="ult-select-container">';
            echo '<small><i>' . __( 'Font Style', 'ultimatum' ) . '</i></small>';
            echo '<select data-placeholder="' . __( 'Font Style', 'ultimatum' ) . '" name="' .$value['id']. '[font-style]" class="ult-select-2">';
            echo '<option value=""></option>';
            $align = array(
                'inherit',
                'normal',
                'italic',
            );

            foreach ( $align as $v ) {
                echo '<option value="'.$v.'" '.selected( $values['font-style'], $v, false ).'>'.ucfirst( $v ).'</option>';
            }

            echo '</select>';
            echo '</div>';
        }

        /* Text Transform */
        if ( $value['text-transform'] === true ) {
            echo '<div class="ult-select-container">';
            echo '<small><i>' . __( 'Text Transform', 'ultimatum' ) . '</i></small>';
            echo '<select data-placeholder="' . __( 'Text Transform', 'ultimatum' ) . '" name="' .$value['id']. '[text-transform]" class="ult-select-2">';
            echo '<option value=""></option>';
            $transform = array(
                'none',
                'capitalize',
                'uppercase',
                'lowercase',
                'initial',
                'inherit'
            );

            foreach ( $transform as $v ) {
                echo '<option value="' . $v . '" ' . selected( $values['text-transform'], $v, false ) . '>' . ucfirst( $v ) . '</option>';
            }

            echo '</select>';
            echo '</div>';
        }

        /* Font Variant */
        if ( $value['font-variant'] === true ) {
            echo '<div class="ult-select-container">';
            echo '<small><i>' . __( 'Font Variant', 'ultimatum' ) . '</i></small>';
            echo '<select data-placeholder="' . __( 'Font Variant', 'ultimatum' ) . '" name="' .$value['id']. '[font-variant]" class="ult-select-2">';
            echo '<option value=""></option>';
            $variant = array(
                'inherit',
                'normal',
                'small-caps'
            );

            foreach ( $variant as $v ) {
                echo '<option value="' . $v . '" ' . selected( $values['font-variant'], $v, false ) . '>' . ucfirst( $v ) . '</option>';
            }

            echo '</select></div>';
        }

        /* Text Decoration */
        if ( $value['text-decoration'] === true ) {
            echo '<div class="ult-select-container">';
            echo '<small><i>'. __( 'Text Decoration', 'ultimatum' ) . '</i></small>';
            echo '<select data-placeholder="' . __( 'Text Decoration', 'ultimatum' ) . '" name="' .$value['id']. '[text-decoration]" class="ult-select-2">';
            echo '<option value=""></option>';
            $decoration = array(
                'none',
                'inherit',
                'underline',
                'overline',
                'line-through',
                'blink'
            );

            foreach ( $decoration as $v ) {
                echo '<option value="' . $v . '" ' . selected( $values['text-decoration'], $v, false ) . '>' . ucfirst( $v ) . '</option>';
            }

            echo '</select></div>';
        }

        /* Font Size */
        if ( $value['font-size'] === true ) {
            if($values['font-size']=='inherit') $values['font-size']='';
            echo '<div class="ult-select-container minik">';
            echo '<small><i>'. __( 'Font Size', 'ultimatum' ) .'</i></small>';
            echo '<div class="input-append"><input type="text"  placeholder="' . __( 'Size', 'ultimatum' ) . '" value="' . str_replace( $unit, '', $values['font-size'] ) . '" size="2" name="' . $value['id'] . '[font-size]" /><span class="add-on">' . $unit . '</span></div>';

            echo '</div>';
        }

        /* Line Height */
        if ( $value['line-height'] === true ) {
            if($values['line-height']=='inherit') $values['line-height']='';
            echo '<div class="ult-select-container minik">';
            echo '<small><i>'. __( 'Line Height', 'ultimatum' ) . '</i></small>';
            echo '<div class="input-append"><input type="text" placeholder="' . __( 'Height', 'ultimatum' ) . '" value="' . str_replace( $unit, '', $values['line-height'] ) . '" size="2" name="' . $value['id'] . '[line-height]" /><span class="add-on">' . $unit . '</span></div>';

            echo '</div>';
        }

        /* Word Spacing */
        if ( $value['word-spacing'] === true ) {
            echo '<div class="ult-select-container minik">';
            echo '<small><i>'. __( 'Word Spacing', 'ultimatum' ) . '</i></small>';
            echo '<div class="input-append"><input type="text" size="2" name="' . $value['id'] . '[word-spacing]" placeholder="' . __( 'Word Spacing', 'ultimatum' ) . '" value="' . str_replace( $unit, '', $values['word-spacing'] ) . '" ><span class="add-on">' . $unit . '</span></div>';

            echo '</div>';
        }

        /* Letter Spacing */
        if ( $value['letter-spacing'] === true ) {
            echo '<div class="ult-select-container minik">';
            echo '<small><i>'. __( 'Letter Spacing', 'ultimatum' ) . '</i></small>';
            echo '<div class="input-append"><input type="text"  placeholder="' . __( 'Letter Spacing', 'ultimatum' ) . '" size="2" value="' . str_replace( $unit, '', $values['letter-spacing'] ) . '" name="' . $value['id'] . '[letter-spacing]"/><span class="add-on">' . $unit . '</span></div>';

            echo '</div>';
        }
        if ( $value['color'] === true ) {
            // color is the last as its a biatch
            echo '<div style="width: 100%;float:left;"><small><i>' . __('Font Color', 'ultimatum') . '</i></small><br /><input type="text" name="' . $value['id'] . '[color]" value="' . $values['color'] . '" class="ult-color-field" /></div>';

        }
        echo '</td></tr>';
    }

    /*
     * Margin field
     */
    function margins($value){
        $unit = 'px';
        $defaults = array(
            'margin-top'    => false,
            'margin-bottom' => false,
            'margin-left' => false,
            'margin-right' => false,
        );
        $value = wp_parse_args( $value, $defaults );
        $values = isset($this->saved_options[$value['id']])? $this->saved_options[$value['id']]:'';
        $defaults = array(
            'margin-top'    => '',
            'margin-bottom' => '',
            'margin-left' => '',
            'margin-right' => '',
        );
        $values = wp_parse_args( $values, $defaults );
        echo '<tr><td width="230"><strong>' . $value['name'] . '</strong></td>';
        echo '<td>';
        // Fields are here
        if ( $value['margin-top'] === true ) {
            echo '<div class="ult-select-container minik">';
            echo '<small><i>'. __( 'Margin Top', 'ultimatum' ) . '</i></small>';
            echo '<div class="input-append"><input type="text"  placeholder="' . __( 'Top', 'ultimatum' ) . '" size="2" value="' . str_replace( $unit, '', $values['margin-top'] ) . '" name="' . $value['id'] . '[margin-top]"/><span class="add-on">' . $unit . '</span></div>';

            echo '</div>';
        }
        if ( $value['margin-left'] === true ) {
            echo '<div class="ult-select-container minik">';
            echo '<small><i>'. __( 'Margin Left', 'ultimatum' ) . '</i></small>';
            echo '<div class="input-append"><input type="text"  placeholder="' . __( 'Left', 'ultimatum' ) . '" size="2" value="' . str_replace( $unit, '', $values['margin-left'] ) . '" name="' . $value['id'] . '[margin-left]"/><span class="add-on">' . $unit . '</span></div>';

            echo '</div>';
        }
        if ( $value['margin-bottom'] === true ) {
            echo '<div class="ult-select-container minik">';
            echo '<small><i>'. __( 'Margin Bottom', 'ultimatum' ) . '</i></small>';
            echo '<div class="input-append"><input type="text"  placeholder="' . __( 'Bottom', 'ultimatum' ) . '" size="2" value="' . str_replace( $unit, '', $values['margin-bottom'] ) . '" name="' . $value['id'] . '[margin-bottom]"/><span class="add-on">' . $unit . '</span></div>';

            echo '</div>';
        }
        if ( $value['margin-right'] === true ) {
            echo '<div class="ult-select-container minik">';
            echo '<small><i>'. __( 'Margin Right', 'ultimatum' ) . '</i></small>';
            echo '<div class="input-append"><input type="text"  placeholder="' . __( 'Right', 'ultimatum' ) . '" size="2" value="' . str_replace( $unit, '', $values['margin-right'] ) . '" name="' . $value['id'] . '[margin-right]"/><span class="add-on">' . $unit . '</span></div>';

            echo '</div>';
        }
        // fields done
        echo '</td></tr>';

    }
    /*
     * Padding field
     */
    function paddings($value){
        $unit = 'px';
        $defaults = array(
            'padding-top'    => false,
            'padding-bottom' => false,
            'padding-left' => false,
            'padding-right' => false,
        );
        $value = wp_parse_args( $value, $defaults );
        $values = isset($this->saved_options[$value['id']])? $this->saved_options[$value['id']]:'';
        $defaults = array(
            'padding-top'    => '',
            'padding-bottom' => '',
            'padding-left' => '',
            'padding-right' => '',
        );
        $values = wp_parse_args( $values, $defaults );
        echo '<tr><td width="230"><strong>' . $value['name'] . '</strong></td>';
        echo '<td>';
        // Fields are here
        if ( $value['padding-top'] === true ) {
            echo '<div class="ult-select-container minik">';
            echo '<small><i>'. __( 'Padding Top', 'ultimatum' ) . '</i></small>';
            echo '<div class="input-append"><input type="text"  placeholder="' . __( 'Top', 'ultimatum' ) . '" size="2" value="' . str_replace( $unit, '', $values['padding-top'] ) . '" name="' . $value['id'] . '[padding-top]"/><span class="add-on">' . $unit . '</span></div>';

            echo '</div>';
        }
        if ( $value['padding-left'] === true ) {
            echo '<div class="ult-select-container minik">';
            echo '<small><i>'. __( 'Padding Left', 'ultimatum' ) . '</i></small>';
            echo '<div class="input-append"><input type="text"  placeholder="' . __( 'Left', 'ultimatum' ) . '" size="2" value="' . str_replace( $unit, '', $values['padding-left'] ) . '" name="' . $value['id'] . '[padding-left]"/><span class="add-on">' . $unit . '</span></div>';

            echo '</div>';
        }
        if ( $value['padding-bottom'] === true ) {
            echo '<div class="ult-select-container minik">';
            echo '<small><i>'. __( 'Padding Bottom', 'ultimatum' ) . '</i></small>';
            echo '<div class="input-append"><input type="text"  placeholder="' . __( 'Bottom', 'ultimatum' ) . '" size="2" value="' . str_replace( $unit, '', $values['padding-bottom'] ) . '" name="' . $value['id'] . '[padding-bottom]"/><span class="add-on">' . $unit . '</span></div>';

            echo '</div>';
        }
        if ( $value['padding-right'] === true ) {
            echo '<div class="ult-select-container minik">';
            echo '<small><i>'. __( 'Padding Right', 'ultimatum' ) . '</i></small>';
            echo '<div class="input-append"><input type="text"  placeholder="' . __( 'Right', 'ultimatum' ) . '" size="2" value="' . str_replace( $unit, '', $values['padding-right'] ) . '" name="' . $value['id'] . '[padding-right]"/><span class="add-on">' . $unit . '</span></div>';

            echo '</div>';
        }
        // fields done
        echo '</td></tr>';

    }
    /*
     * Border field
     */
    function borders($value){
        $unit = 'px';
        $defaults = array(
            'border-top'    => false,
            'border-bottom' => false,
            'border-left' => false,
            'border-right' => false,
        );
        $value = wp_parse_args( $value, $defaults );
        $values = isset($this->saved_options[$value['id']])? $this->saved_options[$value['id']]:'';
        $defaults = array(
            'border-top'    => '',
            'border-bottom' => '',
            'border-left' => '',
            'border-right' => '',
            'border-style' => '',
            'border-color' => '',
        );
        if(!empty($values["border-width"])){
            $from_old =explode(' ',$values["border-width"]);
            $values['border-top-width'] =$from_old[0];
            $values['border-right-width'] =$from_old[1];
            $values['border-bottom-width'] =$from_old[2];
            $values['border-left-width'] =$from_old[3];
        }
        $values = wp_parse_args( $values, $defaults );
        echo '<tr><td width="230"><strong>' . $value['name'] . '</strong></td>';
        echo '<td>';
        // Fields are here
        if ( $value['border-top'] === true ) {
            echo '<div class="ult-select-container minik">';
            echo '<small><i>'. __( 'Border Top', 'ultimatum' ) . '</i></small>';
            echo '<div class="input-append"><input type="text"  placeholder="' . __( 'Top', 'ultimatum' ) . '" size="2" value="' . str_replace( $unit, '', $values['border-top-width'] ) . '" name="' . $value['id'] . '[border-top-width]"/><span class="add-on">' . $unit . '</span></div>';

            echo '</div>';
        }
        if ( $value['border-left'] === true ) {
            echo '<div class="ult-select-container minik">';
            echo '<small><i>'. __( 'Border Left', 'ultimatum' ) . '</i></small>';
            echo '<div class="input-append"><input type="text"  placeholder="' . __( 'Left', 'ultimatum' ) . '" size="2" value="' . str_replace( $unit, '', $values['border-left-width'] ) . '" name="' . $value['id'] . '[border-left-width]"/><span class="add-on">' . $unit . '</span></div>';

            echo '</div>';
        } else {
            echo '<input type="hidden"   value="0" name="' . $value['id'] . '[border-left-width]"/>';
        }
        if ( $value['border-bottom'] === true ) {
            echo '<div class="ult-select-container minik">';
            echo '<small><i>'. __( 'Border Bottom', 'ultimatum' ) . '</i></small>';
            echo '<div class="input-append"><input type="text"  placeholder="' . __( 'Bottom', 'ultimatum' ) . '" size="2" value="' . str_replace( $unit, '', $values['border-bottom-width'] ) . '" name="' . $value['id'] . '[border-bottom-width]"/><span class="add-on">' . $unit . '</span></div>';

            echo '</div>';
        }
        if ( $value['border-right'] === true ) {
            echo '<div class="ult-select-container minik">';
            echo '<small><i>'. __( 'Border Right', 'ultimatum' ) . '</i></small>';
            echo '<div class="input-append"><input type="text"  placeholder="' . __( 'Right', 'ultimatum' ) . '" size="2" value="' . str_replace( $unit, '', $values['border-right-width'] ) . '" name="' . $value['id'] . '[border-right-width]"/><span class="add-on">' . $unit . '</span></div>';

            echo '</div>';
        } else {
            echo '<input type="hidden"   value="0" name="' . $value['id'] . '[border-right-width]"/>';
        }
        echo '<div class="ult-select-container">';
        echo '<small><i>'.__('Border Style','ultimatum').'</i></small><br />';
        //border-style
        echo '<select data-placeholder="' . __( 'Border Style', 'ultimatum' ) . '" name="' .$value['id']. '[border-style]" class="ult-select-2">';
        echo '<option value=""></option>';
        $decoration = array(
            'none',
            'solid',
            'dotted',
            'dashed',
            'double',
        );

        foreach ( $decoration as $v ) {
            echo '<option value="' . $v . '" ' . selected( $values['border-style'], $v, false ) . '>' . ucfirst( $v ) . '</option>';
        }

        echo '</select>';
        echo '</div>';
        echo '<div style="width: 100%;float:left;"><small><i>' . __('Border Color', 'ultimatum') . '</i></small><br /><input type="text" name="' . $value['id'] . '[border-color]" value="' . $values['border-color'] . '" class="ult-color-field" /></div>';
        // fields done
        echo '</td></tr>';

    }

    /**
     * displays a dnd select sort field
     */

    function dnd_select_sort($value){
        if (isset($this->saved_options[$value['id']])) {
            $defaults = explode(',',$this->saved_options[$value['id']]);
        } else {
            $defaults = $value['default'];
        }
        echo '<tr><td width="230"><strong>' . $value['name'] . '</strong></td>';
        echo '<td>';
        if (isset($value['options'])) {
            echo '<div class="halfling">';
            echo '<h4>'.$value['available'].'</h4>';
            echo '<ul id="'.$value['id'].'-1" class="'.$value['id'].'-connectedSortable dnd-min">';
            foreach($value['options'] as $key => $option) {
                if(!in_array($key,$defaults)){
                    echo '<li id="'.$key.'">'.$option.'</li>';
                }
            }
            echo '</ul>';
            echo '</div>';
            echo '<div class="halfling">';
            echo '<h4>'.$value['used'].'</h4>';
            echo '<ul id="'.$value['id'].'-2" class="'.$value['id'].'-connectedSortable dnd-min">';
            foreach($defaults as $def){
                echo '<li id="'.$def.'">'.$value['options'][$def].'</li>';
            }
            echo '</ul>';
            echo '</div>';
            echo '<input type="hidden" name="'.$value["id"].'" id="'.$value["id"].'" value="'.$this->saved_options[$value['id']].'" />';
            echo ' <script>
                jQuery(function() {
                    jQuery( "#'.$value['id'].'-1, #'.$value['id'].'-2" ).sortable({
                        connectWith: ".'.$value['id'].'-connectedSortable",
                        placeholder: "dnd-placeholder",
                        stop: function(event, ui) {
                            var ids = jQuery("#' .$value['id']. '-2").sortable("toArray").toString();
                            jQuery("#' .$value['id'].'").val(ids);
                        },
                        cursor: "move"
                    }).disableSelection();
                });
            </script>';
        }
        echo '</td></tr>';
    }

	/**
	 * displays a custom field
	 */
	function custom($value) {
		if (isset($this->saved_options[$value['id']])) {
			$default = $this->saved_options[$value['id']];
		} else {
			$default = $value['default'];
		}
		if(isset($value['layout']) && $value['layout']==false){
			if (isset($value['function']) && function_exists($value['function'])) {
				$value['function']($value, $default);
			} else {
				echo $value['html'];
			}
		}else{
			echo '<tr valign="top"><td scope="row"><strong>' . $value['name'] . '</strong></td><td>';
			if(isset($value['desc'])){
				echo '<p class="description">' . $value['desc'] . '</p>';
			}
			if (isset($value['function']) && function_exists($value['function'])) {
				$value['function']($value, $default);
			} else {
				echo $value['html'];
			}
			echo '</td></tr>';
		}
	}

    /*
     * Disable Font Library add fonts here
     */
    function new_ult_fonts(){
        $json = false;
        $api_key = 'AIzaSyAWxEClR589JwSLgTNCMgseIML9576eDqs';
        $api_url = 'https://www.googleapis.com/webfonts/v1/webfonts';
        $url  =$api_url. '?key=' . $api_key;
        if(function_exists('wp_remote_get')){
            $response = wp_remote_get($url, array('sslverify' => false));
            if(!is_wp_error($response) && isset($response['body']) && $response['body']){
                if(strpos($response['body'], 'error') === false){
                    $json = $response['body'];
                }
            }
        }
        $raw_fonts = json_decode($json);
        $webfonts = array();
        foreach ($raw_fonts->items as $font) {
            unset($font->kind);
            $webfonts[$font->family] = $font;
        }

        $fonts = array();
        foreach($webfonts as $font){

            $mariant = array();
            foreach($font->variants as $variant){
                $mariant[]=$variant;
            }
            $mariants = implode(',',$mariant);
            $fonts[$font->family] = $font->family.':'.$mariants;
        }
        return $fonts;
    }
    function get_google_fonts(){
        $google_web_fonts = get_site_transient('ult_google_fonts');
        if(!$google_web_fonts){
            $google_web_fonts = $this->new_ult_fonts();
            set_site_transient('ult_google_fonts',$google_web_fonts,7 * DAY_IN_SECONDS);
        }
        return $google_web_fonts;
    }


}
