<?php
class UltimatumTwitter extends WP_Widget {

	function UltimatumTwitter() {
		parent::WP_Widget(false, $name = 'Ultimatum Twitter');
    }

    function widget( $args, $instance ) {
    	
		extract( $args );
		wp_enqueue_script('jquery-tweets');
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		$username= $instance['username'];
		
		$user_array = explode(',',$username);
		foreach($user_array as $key => $user){
			$user_array[$key] = '"'.$user.'"';
		}
		
		$query= empty($instance['query'])?'null':'"'.$instance['query'].'"';
		$avatar_size = (int)$instance['avatar_size'];
		if(empty($avatar_size)){
			$avatar_size = 'null';
		}
		$count = (int)$instance['count'];
		if($count < 1){
			$count = 1;
		}
		
		if ( !empty( $user_array )|| $query!="null" ) {
			echo $before_widget;
			if ( $title)
				echo $before_title . $title . $after_title;
				
		$id = rand(1,1000);
		$interval = isset($instance['interval']) ? absint($instance['interval']) : 3;
		$interval = $interval*60;
		?>
		
		<script type="text/javascript">
				jQuery(document).ready(function($) {
					 jQuery("#twitter_wrap_<?php echo $id;?>").tweet({
						modpath: "<?php echo ULTIMATUM_URL.'/wonderfoundry/helpers/tweets.php';?>",
						username: [<?php echo implode(',',$user_array);?>],
						count: <?php echo $count;?>,
						query: <?php echo $query;?>,
						refresh_interval : <?php echo $interval;?>,
						avatar_size: <?php echo $avatar_size;?>,
						seconds_ago_text: "<?php _e('about %d seconds ago', 'ultimatum');?>",
						a_minutes_ago_text: "<?php _e('about a minute ago', 'ultimatum');?>",
						minutes_ago_text: "<?php _e('about %d minutes ago', 'ultimatum');?>",
						a_hours_ago_text: "<?php _e('about an hour ago', 'ultimatum');?>",
						hours_ago_text: "<?php _e('about %d hours ago', 'ultimatum');?>",
						a_day_ago_text: "<?php _e('about a day ago','ultimatum');?>",
						days_ago_text: "<?php _e('about %d days ago', 'ultimatum');?>",
						view_text: "<?php _e('view tweet on twitter', 'ultimatum');?>"
					 });
				});
		</script>
		<div id="twitter_wrap_<?php echo $id;?>"<?php if($avatar_size != 'null'):?> class="with_avatar"<?php endif;?>></div>
		<div class="clearfix"></div>
		<?php
			echo $after_widget;
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['username'] = strip_tags($new_instance['username']);
		$instance['avatar_size'] = $new_instance['avatar_size']?(int) $new_instance['avatar_size']:'';
		$instance['count'] = (int) $new_instance['count'];
		$instance['interval'] = (int) $new_instance['interval'];
		$instance['query'] = strip_tags($new_instance['query']);
		return $instance;
	}

	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$username = isset($instance['username']) ? esc_attr($instance['username']) : '';
		$avatar_size = isset($instance['avatar_size']) ? absint($instance['avatar_size']) : '';
		$query = isset($instance['query']) ? esc_attr($instance['query']) : '';
		$count = isset($instance['count']) ? absint($instance['count']) : 3;
		$interval = isset($instance['interval']) ? absint($instance['interval']) : 3;
		$display = isset( $instance['display'] ) ? $instance['display'] : 'latest';
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title ', 'ultimatum'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username','ultimatum'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>" /></p>
		
		<p>
			<?php _e("Note: Use ',' separate multi user.<br> (e.g <code>user1,user2</code>)",'ultimatum');?>
		</p>
		
		<p><label for="<?php echo $this->get_field_id('avatar_size'); ?>"><?php _e('height and width of avatar if displayed (48px max)(optional)',  'ultimatum'); ?></label>
		<input id="<?php echo $this->get_field_id('avatar_size'); ?>" name="<?php echo $this->get_field_name('avatar_size'); ?>" type="text" value="<?php echo $avatar_size; ?>" size="3" /></p>
		
		
		<p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('How many tweets to display?','ultimatum'); ?></label>
		<input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" size="3" /></p>
		<p><label for="<?php echo $this->get_field_id('interval'); ?>"><?php _e('Refresh Time in Minutes :','ultimatum'); ?></label>
		<input id="<?php echo $this->get_field_id('interval'); ?>" name="<?php echo $this->get_field_name('interval'); ?>" type="text" value="<?php echo $interval; ?>" size="3" /></p>
		
		<p><label for="<?php echo $this->get_field_id('query'); ?>"><?php _e('Query (optional):', 'ultimatum'); ?></label>
		<textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('query'); ?>" name="<?php echo $this->get_field_name('query'); ?>"><?php echo $query; ?></textarea>
		
		<p>
			<?php _e("Query uses <a href='https://dev.twitter.com/docs/using-search' target='_blank'>Twitter's Search API</a>, so you can display any tweets you like.", 'ultimatum');?>
		</p>
<?php
	}
}

add_action('widgets_init', create_function('', 'return register_widget("UltimatumTwitter");'));