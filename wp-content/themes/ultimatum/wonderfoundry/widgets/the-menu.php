<?php
class UltimatumMenu extends WP_Widget {
	function UltimatumMenu() {
        parent::WP_Widget(false, $name = 'Ultimatum Menu');
    }

    function widget($args, $instance) {
       	extract( $args );
        echo $before_widget;
       	$nav_menu = wp_get_nav_menu_object( $instance['nav_menu'] );
       	$menu_style= ULTIMATUM_WIDGETS.DS.'menus'.DS.$instance['menustyle'].'.php';
       	if($instance['menustyle']!='tbs' && $instance['menustyle']!='sidr' && $instance['menustyle']!='mdm' && $instance['responsivepx']!=0){
       		echo '<div class="ultimatum-menu-container" data-menureplacer="'.$instance['responsivepx'].'">';
       		echo '<div class="ultimatum-regular-menu">';
       	}
       	if(file_exists($menu_style)){
       		include ($menu_style);
       	}
       	if($instance['menustyle']!='tbs' && $instance['menustyle']!='sidr' && $instance['menustyle']!='mdm' && $instance['responsivepx']!=0){
       		echo '</div>';
       		$menu_style_mobile = ULTIMATUM_WIDGETS.DS.'menus'.DS.$instance['responsive_type'].'.php';
       		if(file_exists($menu_style_mobile)){
       		    include ($menu_style_mobile);
       		}
       		echo '</div>';//close main selector
       	}
        echo $after_widget;
       	?><div class="clearfix"></div><?php 
    }

 function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['menustyle'] = strip_tags( stripslashes($new_instance['menustyle']) );
		$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		$instance['rowItems'] = $new_instance['rowItems'];
		$instance['subMenuWidth'] = $new_instance['subMenuWidth'];
		$instance['direction'] =$new_instance['direction'];
		$instance['skin'] = $new_instance['skin'];
		$instance['speed'] = $new_instance['speed'];
		$instance['effect'] = $new_instance['effect'];
		
		$instance['vrowItems'] = $new_instance['vrowItems'];
		$instance['vdirection'] =$new_instance['vdirection'];
		$instance['vspeed'] = $new_instance['vspeed'];
		$instance['veffect'] = $new_instance['veffect'];
		
		$instance['depth'] = (int) $new_instance['depth'];
		$instance['only_related'] = (int) $new_instance['only_related'];
		$instance['float'] = $new_instance['float'];
		$instance['hndfloat'] = $new_instance['hndfloat'];
		
		$instance['tbsstyle'] =  $new_instance['tbsstyle'];
		$instance['tbsposition'] = $new_instance['tbsposition'];
		$instance['tbslogo'] = $new_instance['tbslogo'];
		$instance['tbssearch'] = $new_instance['tbssearch'];
		$instance['tbsresponsive'] = $new_instance['tbsresponsive'];
		$instance['responsivepx'] = $new_instance['responsivepx'];
		$instance['responsive_type'] = $new_instance['responsive_type'];
		$instance['sidr_type'] = $new_instance['sidr_type'];
		$instance['sidr_position'] = $new_instance['sidr_position'];
		$instance['sidr_top_widget'] = $new_instance['sidr_top_widget'];
		$instance['sidr_bottom_widget'] = $new_instance['sidr_bottom_widget'];
		$instance['ultimatum_menu_search'] = $new_instance['ultimatum_menu_search'];
		$instance['ultimatum_menu_wc_login'] = $new_instance['ultimatum_menu_wc_login'];
		$instance['ultimatum_menu_wc_cart'] = $new_instance['ultimatum_menu_wc_cart'];
        $instance['mobilelabel'] = $new_instance['mobilelabel'];
        $instance['mdmlabel'] = $new_instance['mdmlabel'];
        $instance['mdmfloat'] = $new_instance['mdmfloat'];
        $instance['mdmparent'] = $new_instance['mdmparent'];

		return $instance;
	}
function form($instance) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$menustyle = isset( $instance['menustyle'] ) ? $instance['menustyle'] : '';
		$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
		$subMenuWidth = isset( $instance['subMenuWidth'] ) ? $instance['subMenuWidth'] : '';
		$rowItems = isset( $instance['rowItems'] ) ? $instance['rowItems'] : '';
		$skin = isset( $instance['skin'] ) ? $instance['skin'] : '';
		$speed = isset( $instance['speed'] ) ? $instance['speed'] : 'normal';
		$direction = isset( $instance['direction'] ) ? $instance['direction'] : '';
		$effect = isset( $instance['effect'] ) ? $instance['effect'] : 'slide';
		
		$vrowItems = isset( $instance['vrowItems'] ) ? $instance['vrowItems'] : '';
		$vspeed = isset( $instance['vspeed'] ) ? $instance['vspeed'] : 'normal';
		$vdirection = isset( $instance['vdirection'] ) ? $instance['vdirection'] : '';
		$veffect = isset( $instance['veffect'] ) ? $instance['veffect'] : 'slide';
		
		$only_related = isset( $instance['only_related'] ) ? (int) $instance['only_related'] : 1;
		$depth = isset( $instance['depth'] ) ? (int) $instance['depth'] : 0;
		$float = isset( $instance['float'] ) ?  $instance['float'] : 'left';
		$hndfloat = isset( $instance['hndfloat'] ) ?  $instance['hndfloat'] : 'left';
		$tbsstyle = isset( $instance['tbsstyle'] ) ? $instance['tbsstyle'] : 'false';
		$tbsposition = isset( $instance['tbsposition'] ) ? $instance['tbsposition'] : 'false';
		$tbslogo = isset( $instance['tbslogo'] ) ? $instance['tbslogo'] : 'OFF';
		$tbssearch = isset( $instance['tbssearch'] ) ? $instance['tbssearch'] : 'OFF';
		$tbsresponsive = isset( $instance['tbsresponsive'] ) ? $instance['tbsresponsive'] : 'OFF';
		$responsivepx = isset($instance['responsivepx'])?$instance['responsivepx']:0;
		$responsive_type = isset($instance['responsive_type'])?$instance['responsive_type']:'dropdown';
		$sidr_type = isset($instance['sidr_type'])?$instance['sidr_type']:'light';
		$sidr_position = isset($instance['sidr_position'])?$instance['sidr_position']:'left';
		$sidr_top_widget = isset($instance['sidr_top_widget'])?$instance['sidr_top_widget']:0;
		$sidr_bottom_widget = isset($instance['sidr_bottom_widget'])?$instance['sidr_bottom_widget']:0;
		$ultimatum_menu_search = isset($instance['ultimatum_menu_search'])?$instance['ultimatum_menu_search']:'no';
		$ultimatum_menu_wc_login = isset($instance['ultimatum_menu_wc_login'])?$instance['ultimatum_menu_wc_login']:'no';
		$ultimatum_menu_wc_cart = isset($instance['ultimatum_menu_wc_cart'])?$instance['ultimatum_menu_wc_cart']:'no';
        $mobilelabel = isset($instance['mobilelabel'])?$instance['mobilelabel']:'Menu';
        $mdmlabel = isset($instance['mdmlabel'])?$instance['mdmlabel']:'Menu';
        $mdmfloat = isset($instance['mdmfloat'])?$instance['mdmfloat']:'left';
        $mdmparent = isset($instance['mdmparent'])?$instance['mdmparent']:'no';
		// Get menus
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

		// If no menus exists, direct the user to go and create some.
		if ( !$menus ) {
			echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.', 'ultimatum'), admin_url('nav-menus.php') ) .'</p>';
			return;
		}
		?>
	
	   <p>
		<label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu', 'ultimatum'); ?></label>
		<select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>" class="widefat">
		<?php
			foreach ( $menus as $menu ) {
				$selected = $nav_menu == $menu->term_id ? ' selected="selected"' : '';
				echo '<option'. $selected .' value="'. $menu->term_id .'">'. $menu->name .'</option>';
			}
		?>
		</select>
		</p>
    	<div class="menu-select-wrapper">
    	  
			<label for="<?php echo $this->get_field_id('menustyle'); ?>"><?php _e('Menu Script', 'ultimatum') ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name('menustyle'); ?>" id="<?php echo $this->get_field_id('menustyle'); ?>" onchange="menuOpts(this);">
				<option value="hormega" <?php selected( $menustyle, 'hormega'); ?>><?php _e('Horizontal Mega Menu', 'ultimatum') ?></option>
				<option value="h" <?php selected( $menustyle, 'h'); ?>><?php _e('Horizontal DropDown Menu', 'ultimatum') ?></option>
				<option value="hnd" <?php selected( $menustyle, 'hnd'); ?>><?php _e('Horizontal Menu', 'ultimatum') ?></option>
				<option value="vermega" <?php selected( $menustyle, 'vermega'); ?>><?php _e('Vertical Mega Menu', 'ultimatum') ?></option>
				<option value="v" <?php selected( $menustyle, 'v'); ?>><?php _e('Vertical DropDown Menu', 'ultimatum') ?></option>
				<option value="vnd" <?php selected( $menustyle, 'vnd'); ?>><?php _e('Vertical Menu', 'ultimatum') ?></option>
				<option value="tbs" <?php selected( $menustyle, 'tbs'); ?>><?php _e('Bootstrap Menu', 'ultimatum') ?></option>
				<option value="ultimatum-menu" <?php selected( $menustyle, 'ultimatum-menu'); ?>><?php _e('NEW - Ultimatum Menu', 'ultimatum') ?></option>
				<option value="mdm" <?php selected( $menustyle, 'mdm'); ?>><?php _e('NEW - Mobile Drop Menu', 'ultimatum') ?></option>
				<option value="sidr" <?php selected( $menustyle, 'sidr'); ?>><?php _e('NEW - Side Menu', 'ultimatum') ?></option>
			</select>
		   <p></p>
		<div class="menu_options">
			<div class="hormega options" style="<?php if($menustyle!='hormega'){ echo 'display:none'; }?>">
				<p>
				  <label for="<?php echo $this->get_field_id('rowItems'); ?>"><?php _e( 'Number Items Per Row' , 'ultimatum'); ?></label>
					<select class="widefat" name="<?php echo $this->get_field_name('rowItems'); ?>" id="<?php echo $this->get_field_id('rowItems'); ?>" >
						<option value='1' <?php selected( $rowItems, '1'); ?> >1</option>
						<option value='2' <?php selected( $rowItems, '2'); ?> >2</option>
						<option value='3' <?php selected( $rowItems, '3'); ?> >3</option>
						<option value='4' <?php selected( $rowItems, '4'); ?> >4</option>
						<option value='5' <?php selected( $rowItems, '5'); ?> >5</option>
						<option value='6' <?php selected( $rowItems, '6'); ?> >6</option>
						<option value='7' <?php selected( $rowItems, '7'); ?> >7</option>
						<option value='8' <?php selected( $rowItems, '8'); ?> >8</option>
						<option value='9' <?php selected( $rowItems, '9'); ?> >9</option>
						<option value='10' <?php selected( $rowItems, '10'); ?> >10</option>
					</select>
				</p>
			    
				<p>
    				<label for="<?php echo $this->get_field_id('subMenuWidth'); ?>"><?php _e( 'Hor. Mega Width' , 'ultimatum'); ?></label>
    				<input class="widefat" type="text" value="<?php echo $subMenuWidth; ?>" size="3" id="<?php echo $this->get_field_id('subMenuWidth'); ?>" name="<?php echo $this->get_field_name('subMenuWidth'); ?>" />
    				<i><?php _e('To align Horizontal Mega menu to right you need to set a width otherwise leave empty', 'ultimatum');?></i>
				</p>
			    <p>
			        <label for="<?php echo $this->get_field_id('effect'); ?>"><?php _e('Animation Effect', 'ultimatum'); ?></label>
				       <select class="widefat" name="<?php echo $this->get_field_name('effect'); ?>" id="<?php echo $this->get_field_id('effect'); ?>" >
					      <option value='fade' <?php selected( $effect, 'fade'); ?> ><?php _e('Fade In', 'ultimatum'); ?></option>
					      <option value='slide' <?php selected( $effect, 'slide'); ?> ><?php _e('Slide Down', 'ultimatum'); ?></option>
				       </select>		
			    </p>
			    <p>
			       <label for="<?php echo $this->get_field_id('direction'); ?>"><?php _e('Animation Direction', 'ultimatum'); ?></label>
				   <select class="widefat" name="<?php echo $this->get_field_name('direction'); ?>" id="<?php echo $this->get_field_id('direction'); ?>" >
				       <option value='right' <?php selected( $direction, 'right'); ?> ><?php _e('Right', 'ultimatum'); ?></option>
					  <option value='left' <?php selected( $direction, 'left'); ?> ><?php _e('Left', 'ultimatum'); ?></option>
				   </select>
			    </p>
			    <p>
				   <label for="<?php echo $this->get_field_id('speed'); ?>"><?php _e('Animation Speed', 'ultimatum'); ?></label>
				       <select class="widefat" name="<?php echo $this->get_field_name('speed'); ?>" id="<?php echo $this->get_field_id('speed'); ?>" >
					      <option value='fast' <?php selected( $speed, 'fast'); ?> ><?php _e('Fast', 'ultimatum'); ?></option>
					      <option value='normal' <?php selected( $speed, 'normal'); ?> ><?php _e('Normal', 'ultimatum'); ?></option>
					      <option value='slow' <?php selected( $speed, 'slow'); ?> ><?php _e('Slow', 'ultimatum'); ?></option>
				       </select>
			    </p>
			</div>
			<div class="vermega options" style="<?php if($menustyle!='vermega'){ echo 'display:none'; }?>">
				<p>
				  <label for="<?php echo $this->get_field_id('vrowItems'); ?>"><?php _e( 'Number Items Per Row' , 'ultimatum'); ?></label>
					<select class="widefat" name="<?php echo $this->get_field_name('vrowItems'); ?>" id="<?php echo $this->get_field_id('vrowItems'); ?>" >
						<option value='1' <?php selected( $vrowItems, '1'); ?> >1</option>
						<option value='2' <?php selected( $vrowItems, '2'); ?> >2</option>
						<option value='3' <?php selected( $vrowItems, '3'); ?> >3</option>
						<option value='4' <?php selected( $vrowItems, '4'); ?> >4</option>
						<option value='5' <?php selected( $vrowItems, '5'); ?> >5</option>
						<option value='6' <?php selected( $vrowItems, '6'); ?> >6</option>
						<option value='7' <?php selected( $vrowItems, '7'); ?> >7</option>
						<option value='8' <?php selected( $vrowItems, '8'); ?> >8</option>
						<option value='9' <?php selected( $vrowItems, '9'); ?> >9</option>
						<option value='10' <?php selected( $vrowItems, '10'); ?> >10</option>
					</select>
				</p>
				<p>
				    <label for="<?php echo $this->get_field_id('veffect'); ?>"><?php _e('Animation Effect', 'ultimatum'); ?></label>
					<select class="widefat" name="<?php echo $this->get_field_name('veffect'); ?>" id="<?php echo $this->get_field_id('veffect'); ?>" >
						<option value='fade' <?php selected( $veffect, 'fade'); ?> ><?php _e('Fade In', 'ultimatum'); ?></option>
						<option value='slide' <?php selected( $veffect, 'slide'); ?> ><?php _e('Slide', 'ultimatum'); ?></option>
					</select>
				</p>
				<p><label for="<?php echo $this->get_field_id('vdirection'); ?>"><?php _e('Animation Direction', 'ultimatum'); ?></label>
					<select class="widefat" name="<?php echo $this->get_field_name('vdirection'); ?>" id="<?php echo $this->get_field_id('vdirection'); ?>" >
						<option value='right' <?php selected( $vdirection, 'right'); ?> ><?php _e('Right', 'ultimatum'); ?></option>
						<option value='left' <?php selected( $vdirection, 'left'); ?> ><?php _e('Left', 'ultimatum'); ?></option>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('vspeed'); ?>"><?php _e('Animation Speed', 'ultimatum'); ?></label>
					<select class="widefat" name="<?php echo $this->get_field_name('vspeed'); ?>" id="<?php echo $this->get_field_id('vspeed'); ?>" >
						<option value='fast' <?php selected( $vspeed, 'fast'); ?> ><?php _e('Fast', 'ultimatum'); ?></option>
						<option value='normal' <?php selected( $vspeed, 'normal'); ?> ><?php _e('Normal', 'ultimatum'); ?></option>
						<option value='slow' <?php selected( $vspeed, 'slow'); ?> ><?php _e('Slow', 'ultimatum'); ?></option>
					</select>
				</p>
			</div>
			<div class="h options" style="<?php if($menustyle!='h'){ echo 'display:none'; }?>">
				<p>
					<label for="<?php echo $this->get_field_id('float'); ?>"><?php _e('Alignment', 'ultimatum'); ?></label>
					<select name="<?php echo $this->get_field_name('float'); ?>" id="<?php echo $this->get_field_id('float'); ?>" class="widefat">
						<option value="left" <?php selected( $float, 'left' ); ?>><?php _e('Left', 'ultimatum'); ?></option>
						<option value="right" <?php selected( $float, 'right' ); ?>><?php _e('Right', 'ultimatum'); ?></option>
						<option value="center" <?php selected( $float, 'center' ); ?>><?php _e('Center', 'ultimatum'); ?></option>
					</select>
				</p>
			</div>
			<div class="hnd options" style="<?php if($menustyle!='hnd'){ echo 'display:none'; }?>">
				<p>
					<label for="<?php echo $this->get_field_id('hndfloat'); ?>"><?php _e('Alignment', 'ultimatum'); ?></label>
					<select class="widefat" name="<?php echo $this->get_field_name('hndfloat'); ?>" id="<?php echo $this->get_field_id('hndfloat'); ?>" class="widefat">
						<option value="left" <?php selected( $hndfloat, 'left' ); ?>><?php _e('Left', 'ultimatum'); ?></option>
						<option value="right" <?php selected( $hndfloat, 'right' ); ?>><?php _e('Right', 'ultimatum'); ?></option>
						
					</select>
				</p>
			</div>
			<div class="v options" style="<?php if($menustyle!='v'){ echo 'display:none'; }?>">
			</div>
			<div class="vnd options" style="<?php if($menustyle!='vnd'){ echo 'display:none'; }?>">
				<p>
					<label for="<?php echo $this->get_field_id('only_related'); ?>"><?php _e('Show hierarchy', 'ultimatum'); ?></label>
					<select name="<?php echo $this->get_field_name('only_related'); ?>" id="<?php echo $this->get_field_id('only_related'); ?>" class="widefat">
						<option value="1" <?php selected( $only_related, 1 ); ?>><?php _e('Display all', 'ultimatum'); ?></option>
						<option value="2" <?php selected( $only_related, 2 ); ?>><?php _e('Only related sub-items', 'ultimatum'); ?></option>
						<option value="3" <?php selected( $only_related, 3 ); ?>><?php _e( 'Only strictly related sub-items', 'ultimatum' ); ?></option>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('depth'); ?>"><?php _e('How many levels to display', 'ultimatum'); ?></label>
					<select name="<?php echo $this->get_field_name('depth'); ?>" id="<?php echo $this->get_field_id('depth'); ?>" class="widefat">
						<option value="0"<?php selected( $depth, 0 ); ?>><?php _e('Unlimited depth', 'ultimatum'); ?></option>
						<option value="1"<?php selected( $depth, 1 ); ?>><?php _e( '1 level deep', 'ultimatum' ); ?></option>
						<option value="2"<?php selected( $depth, 2 ); ?>><?php _e( '2 levels deep', 'ultimatum' ); ?></option>
						<option value="3"<?php selected( $depth, 3 ); ?>><?php _e( '3 levels deep', 'ultimatum' ); ?></option>
						<option value="4"<?php selected( $depth, 4 ); ?>><?php _e( '4 levels deep', 'ultimatum' ); ?></option>
						<option value="5"<?php selected( $depth, 5 ); ?>><?php _e( '5 levels deep', 'ultimatum' ); ?></option>
						<option value="-1"<?php selected( $depth, -1 ); ?>><?php _e( 'Flat display', 'ultimatum' ); ?></option>
					</select>
				<p>
			</div>
			<div class="tbs options" style="<?php if($menustyle!='tbs'){ echo 'display:none'; }?>">
				<p>
					<label for="<?php echo $this->get_field_id('tbsstyle'); ?>"><?php _e('Menu Style', 'ultimatum'); ?></label>
					<select name="<?php echo $this->get_field_name('tbsstyle'); ?>" id="<?php echo $this->get_field_id('tbsstyle'); ?>" class="widefat">
						<option value="false" <?php selected( $tbsstyle, 'false' ); ?>><?php _e('Default','ultimatum'); ?></option>
						<option value="navbar-inverse" <?php selected( $tbsstyle, 'navbar-inverse' ); ?>><?php _e('Inverse','ultimatum'); ?></option>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('tbsposition'); ?>"><?php _e('Menu Position', 'ultimatum'); ?></label>
					<select name="<?php echo $this->get_field_name('tbsposition'); ?>" id="<?php echo $this->get_field_id('tbsposition'); ?>" class="widefat">
						<option value="false" <?php selected( $tbsposition, 'false' ); ?>><?php _e('Default','ultimatum'); ?></option>
						<option value="navbar-fixed-top" <?php selected( $tbsposition, 'navbar-fixed-top' ); ?>><?php _e('Fixed Top','ultimatum'); ?></option>
						<option value="navbar-fixed-bottom" <?php selected( $tbsposition, 'navbar-fixed-bottom' ); ?>><?php _e('Fixed Bottom','ultimatum'); ?></option>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('tbslogo'); ?>"><?php _e('Show Logo', 'ultimatum'); ?></label>
					<select name="<?php echo $this->get_field_name('tbslogo'); ?>" id="<?php echo $this->get_field_id('tbslogo'); ?>" class="widefat">
						<option value="0" <?php selected( $tbslogo, 0 ); ?>><?php _e('OFF','ultimatum'); ?></option>
						<option value="1" <?php selected( $tbslogo, 1 ); ?>><?php _e('ON','ultimatum'); ?></option>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('tbssearch'); ?>"><?php _e('Show Search', 'ultimatum'); ?></label>
					<select name="<?php echo $this->get_field_name('tbssearch'); ?>" id="<?php echo $this->get_field_id('tbssearch'); ?>" class="widefat">
						<option value="0" <?php selected( $tbssearch, 0 ); ?>><?php _e('OFF','ultimatum'); ?></option>
						<option value="1" <?php selected( $tbssearch, 1 ); ?>><?php _e('ON','ultimatum'); ?></option>
					</select>
				</p>
				
			</div>
            <div class="mdm options" style="<?php if($menustyle!='mdm'){ echo 'display:none'; }?>">
                <p>
                    <label for="<?php echo $this->get_field_id('mdmlabel'); ?>"><?php _e('Navigation Title', 'ultimatum'); ?></label>
                    <input  class="widefat" id="<?php echo $this->get_field_id('mdmlabel'); ?>" name="<?php echo $this->get_field_name('mdmlabel'); ?>" type="text" value="<?php echo $mdmlabel; ?>"  />
                    <i><?php _e('What would button or option would say? Navigation,Menu etc.','ultimatum');?></i>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('mdmfloat'); ?>"><?php _e('Align Button', 'ultimatum'); ?></label>
                    <select class="widefat" name="<?php echo $this->get_field_name('mdmfloat'); ?>" id="<?php echo $this->get_field_id('mdmfloat'); ?>" >
                        <option value='right' <?php selected( $mdmfloat, 'right'); ?> ><?php _e('Right', 'ultimatum'); ?></option>
                        <option value='left' <?php selected( $mdmfloat, 'left'); ?> ><?php _e('Left', 'ultimatum'); ?></option>
                    </select>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('mdmparent'); ?>"><?php _e('Allow Parent Links', 'ultimatum'); ?></label>
                    <select class="widefat" name="<?php echo $this->get_field_name('mdmparent'); ?>" id="<?php echo $this->get_field_id('mdmparent'); ?>" >
                        <option value='no' <?php selected( $mdmparent, 'no'); ?> ><?php _e('No', 'ultimatum'); ?></option>
                        <option value='yes' <?php selected( $mdmparent, 'yes'); ?> ><?php _e('Yes', 'ultimatum'); ?></option>
                    </select>
                </p>
            </div>
			<div class="sidr options" style="<?php if($menustyle!='sidr'){ echo 'display:none'; }?>">
				<p>
					<label for="<?php echo $this->get_field_id('sidr_position'); ?>"><?php _e('Menu Position', 'ultimatum'); ?></label>
					<select name="<?php echo $this->get_field_name('sidr_position'); ?>" id="<?php echo $this->get_field_id('sidr_position'); ?>" class="widefat">
						<option value="left" <?php selected( $sidr_position, 'left' ); ?>><?php _e('Left','ultimatum'); ?></option>
						<option value="right" <?php selected( $sidr_position, 'right' ); ?>><?php _e('Right','ultimatum'); ?></option>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('sidr_type'); ?>"><?php _e('Menu Style', 'ultimatum'); ?></label>
					<select name="<?php echo $this->get_field_name('sidr_type'); ?>" id="<?php echo $this->get_field_id('sidr_type'); ?>" class="widefat">
						<option value="light" <?php selected( $sidr_type, 'light' ); ?>><?php _e('Light','ultimatum'); ?></option>
						<option value="dark" <?php selected( $sidr_type, 'dark' ); ?>><?php _e('Dark','ultimatum'); ?></option>
					</select>
				</p>
				<p>
        			<label for="<?php echo $this->get_field_id('sidr_top_widget'); ?>">
        				<?php _e( 'Top Widget Area', 'ultimatum' ); ?>
        				<select id="<?php echo $this->get_field_id('sidr_top_widget'); ?>>" class="widefat" name="<?php echo $this->get_field_name('sidr_top_widget'); ?>">
        					<option value="0"><?php _e( 'Select Widget Area', 'ultimatum' ); ?></option>
        					<?php
        					global $wp_registered_sidebars;
        					if( ! empty( $wp_registered_sidebars ) && is_array( $wp_registered_sidebars ) ):
        					foreach( $wp_registered_sidebars as $sidebar ):
        					?>
        					<option value="<?php echo $sidebar['id']; ?>" <?php selected( $sidr_top_widget, $sidebar['id'] ); ?>><?php echo $sidebar['name']; ?></option>
        					<?php endforeach; endif; ?>
        				</select>
        			</label>
        		</p>
        		<p>
        			<label for="<?php echo $this->get_field_id('sidr_bottom_widget'); ?>">
        				<?php _e( 'Bottom Widget Area', 'ultimatum' ); ?>
        				<select id="<?php echo $this->get_field_id('sidr_bottom_widget'); ?>>" class="widefat" name="<?php echo $this->get_field_name('sidr_bottom_widget'); ?>">
        					<option value="0"><?php _e( 'Select Widget Area', 'ultimatum' ); ?></option>
        					<?php
        					global $wp_registered_sidebars;
        					if( ! empty( $wp_registered_sidebars ) && is_array( $wp_registered_sidebars ) ):
        					foreach( $wp_registered_sidebars as $sidebar ):
        					?>
        					<option value="<?php echo $sidebar['id']; ?>" <?php selected( $sidr_bottom_widget, $sidebar['id'] ); ?>><?php echo $sidebar['name']; ?></option>
        					<?php endforeach; endif; ?>
        				</select>
        			</label>
        		</p>
			</div>
			<div class="ultimatum-menu options" style="<?php if($menustyle!='ultimatum-menu'){ echo 'display:none'; }?>">
				<p>
					<label for="<?php echo $this->get_field_id('ultimatum_menu_search'); ?>"><?php _e('Show Search', 'ultimatum'); ?></label>
					<select name="<?php echo $this->get_field_name('ultimatum_menu_search'); ?>" id="<?php echo $this->get_field_id('ultimatum_menu_search'); ?>" class="widefat">
						<option value="no" <?php selected( $ultimatum_menu_search, 'no' ); ?>><?php _e('OFF','ultimatum'); ?></option>
						<option value="search" <?php selected( $ultimatum_menu_search, 'search' ); ?>><?php _e('ON','ultimatum'); ?></option>
					</select>
				</p>
			</div>
			<div class="h v hnd vnd vermega hormega ultimatum-menu options" style="<?php if(($menustyle!='h') && ($menustyle!='v') && ($menustyle!='hnd') && ($menustyle!='vnd') && ($menustyle!='hormega') && ($menustyle!='vermega') && ($menustyle!='ultimatum-menu') ){ echo 'display:none'; }?>">
            	<p>
            	   <label for="<?php echo $this->get_field_id('responsivepx'); ?>"><?php _e('Convert to Mobile Menu below width as pixels', 'ultimatum'); ?></label>
            	   <input  class="widefat" id="<?php echo $this->get_field_id('responsivepx'); ?>" name="<?php echo $this->get_field_name('responsivepx'); ?>" type="text" value="<?php echo $responsivepx; ?>"  />
            	   <i><?php _e('Type in the pixel value where you want your menu to be converted to mobile menu','ultimatum');?></i>
            	</p>
            	<p>
                    <label for="<?php echo $this->get_field_id('responsive_type'); ?>"><?php _e('Mobile Menu Script', 'ultimatum'); ?></label>
            		<select name="<?php echo $this->get_field_name('responsive_type'); ?>" id="<?php echo $this->get_field_id('responsive_type'); ?>" class="widefat">
            		  <option value="selection" <?php selected( $responsive_type, 'selection' ); ?>><?php _e('Dropdown Select','ultimatum'); ?></option>
            		  <option value="mdm" <?php selected( $responsive_type, 'mdm' ); ?>><?php _e('Mobile On Top','ultimatum'); ?></option>
            		  <option value="sidr" <?php selected( $responsive_type, 'sidr' ); ?>><?php _e('Mobile on side','ultimatum'); ?></option>
            		</select>
            		<i><?php _e('If you want to change settings of side menu switch Menu Script to side do your settings and switch back to your desired menu.','ultimatum')?></i>
            	</p>
                <p>
                    <label for="<?php echo $this->get_field_id('mobilelabel'); ?>"><?php _e('Navigation Title', 'ultimatum'); ?></label>
                    <input  class="widefat" id="<?php echo $this->get_field_id('mobilelabel'); ?>" name="<?php echo $this->get_field_name('mobilelabel'); ?>" type="text" value="<?php echo $mobilelabel; ?>"  />
                    <i><?php _e('What would button or option would say? Navigation,Menu etc.','ultimatum');?></i>
                </p>
        	</div>
		</div>	
	</div>
		

	
	
	<?php 
	}
   
}
add_action('widgets_init', create_function('', 'return register_widget("UltimatumMenu");'));


