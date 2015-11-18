<?php
class UltimatumSocial extends WP_Widget {

	var $sites = array(
			'fivehundredpx','aboutme','addme','amazon','aol','appstore','apple','bebo','behance','bing','blip','blogger','coroflot','daytum','delicious','designbump','designfloat','deviantart','digg','dribble','drupal','ebay','email','emberapp','etsy','facebook','feedburner','flickr','foodspotting','forrst','foursquare','friendsfeed','friendstar',
			'gdgt','github','googlebuzz','googleplus','googletalk','gowallapin','gowalla','grooveshark','heart','hyves','icondock','icq','identica','imessage','itunes','lastfm','linkedin','meetup','metacafe','mixx','mobileme','mrwong','msn','myspace','newsvine','paypal','photobucket','picasa','pinterest','podcast','posterous','qik','quora','reddit','rss',
			'scribd','sharethis','skype','slashdot','slideshare','smugmug','soundcloud','spotify','squidoo','stackoverflow','star','stumbleupon','technorati','tumblr','twitter','viddler','vimeo','virb','www','wikipedia','windows','wordpress','xing','yahoobuzz','yahoo','yelp','youtube','instagram'
	);
	var $packages = array(
		'16px' => array(
			'name'=>'16px',
		),
		'24px' => array(
			'name'=>'24px',
		),
		'32px' => array(
			'name'=>'32px',
		),
	);
	
	
	function UltimatumSocial() {
        parent::WP_Widget(false, $name = 'Ultimatum Social');
    }
	
	
	function widget( $args, $instance ) {
		extract( $args );
		
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		$package = $instance['package'];
		$output = '';
		/*$style='';
		if($instance['style']!=0){*/
			$style=$instance['style'];
		//}
		
		if( !empty($instance['enable_sites']) ){
			foreach($instance['enable_sites'] as $site){
				$link = isset($instance[$site])?$instance[$site]:'#';
				if(($style=='rounded' || $style=='circle')){
					$output .= '<a href="'.$link.'" target="_blank" style="font-size:'.$instance['size'].'px;line-height:'.$instance['size'].'px"><i class="social-icon-'.$style.'-'.$site.'"></i></a>';
				} else {
					$output .= '<a href="'.$link.'" target="_blank" style="font-size:'.$instance['size'].'px;line-height:'.$instance['size'].'px"><i class="social-icon-'.$site.'"></i></a>';
				}
				
			}
		}
		if ( !empty( $output ) ) {
			echo $before_widget;
			if ( $title)
				echo $before_title . $title . $after_title;
		?>
		<div class="ult_social" style="text-align: <?php echo $instance['align'];?>">
			<?php echo $output; ?>
		</div>
		<?php
			echo $after_widget;
		}
	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['size'] = strip_tags($new_instance['size']);
		$instance['enable_sites'] = $new_instance['enable_sites'];
		$instance['style'] = $new_instance['style'];
		$instance['align'] = $new_instance['align'];
		if(!empty($instance['enable_sites'])){
			foreach($instance['enable_sites'] as $site){
				$instance[$site] = isset($new_instance[$site])?strip_tags($new_instance[$site]):'';
			}
		}
		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$size = isset($instance['size']) ? $instance['size'] : '32';
		$style = isset($instance['style']) ? $instance['style'] : '';
		$align = isset($instance['align']) ? $instance['align'] : 'left';
		$enable_sites = isset($instance['enable_sites']) ? $instance['enable_sites'] : array();
		foreach($this->sites as $site){
			$$site = isset($instance[$site]) ? esc_attr($instance[$site]) : '';
		}
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ultimatum'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('style'); ?>"><?php _e( 'Icon Style' ,'ultimatum' ); ?></label>
						<select name="<?php echo $this->get_field_name('style'); ?>" id="<?php echo $this->get_field_id('style'); ?>">
							<option value="" <?php selected($style,''); ?>>None</option>
							<option value="rounded" <?php selected($style,'rounded'); ?>>Rounded</option>
							<option value="circle" <?php selected($style,'circle'); ?>>Circle</option>
						</select></p>
					<p>
		<p>
			<label for="<?php echo $this->get_field_id('size'); ?>"><?php _e( 'Icon Size in px' , 'ultimatum'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" type="text" value="<?php echo $size; ?>" />
		</p>
		<em><?php _e("The social icon linkage will be shown after you select the social networks and then click save)", 'ultimatum');?></em>
		<p>
			<label for="<?php echo $this->get_field_id('enable_sites'); ?>"><?php _e( 'Enable Social Icon (use CTRL+Click to multi Select)', 'ultimatum'); ?></label>
			<select name="<?php echo $this->get_field_name('enable_sites'); ?>[]" style="height:10em" id="<?php echo $this->get_field_id('enable_sites'); ?>" class="social_icon_select_sites widefat" multiple="multiple">
				<?php foreach($this->sites as $site):?>
				<option value="<?php echo $site;?>"<?php echo in_array($site, $enable_sites)? 'selected="selected"':'';?>><?php echo $site;?></option>
				<?php endforeach;?>
			</select>
		</p>
		
		<p>
			<em><?php _e("Please input FULL URL <br/>(e.g. http://twitter.com/wonderfoundry)", 'ultimatum');?></em>
		</p>
		<div class="social_icon_wrap">
		<?php foreach($this->sites as $site):?>
		<p class="social_icon_<?php echo $site;?>" <?php if(!in_array($site, $enable_sites)):?>style="display:none"<?php endif;?>>
			<label for="<?php echo $this->get_field_id( $site ); ?>"><?php echo $site.' '.__('URL', 'ultimatum')?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( $site ); ?>" name="<?php echo $this->get_field_name( $site ); ?>" type="text" value="<?php echo $$site; ?>" />
		</p>
		<?php endforeach;?>
		<p>
			<label for="<?php echo $this->get_field_id('align'); ?>"><?php _e('Align Icons', 'ultimatum') ?></label>
			<select name="<?php echo $this->get_field_name('align'); ?>" id="<?php echo $this->get_field_id('align'); ?>"> 
	 			<option value="left" <?php selected($align,'left')?>><?php echo esc_attr( __( 'Left', 'ultimatum') ); ?></option> 
				<option value="right" <?php selected($align,'right')?>><?php echo esc_attr( __( 'Right', 'ultimatum') ); ?></option>
                <option value="center" <?php selected($align,'center')?>><?php echo esc_attr( __( 'Center', 'ultimatum') ); ?></option>
			</select>
		</p>
		</div>

		
<?php
	}
}
add_action('widgets_init', create_function('', 'return register_widget("UltimatumSocial");'));
