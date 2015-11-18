<style>
    #<?php echo $this->id.'-responsive-menu';?> .slicknav_btn {float:<?php echo ''.str_replace('#','',$instance['mdmfloat']);?>;?>}
</style>
<div style="display:none">
    <?php wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu, 'container' => false ,'menu_id'=> $this->id.'-resonsive') ); ?>
</div>
<div id="<?php echo $this->id.'-responsive-menu';?>" <?php if($instance['menustyle'] !='mdm') { $label = $instance['mobilelabel']; echo ' class="ultimatum-responsive-menu"'; } else { $label = $instance['mdmlabel']; } ?>></div>
<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready(function() {
	    jQuery('#<?php echo $this->id.'-resonsive';?>').slicknav({
            label:'<?php echo $label; ?>',
            <?php
            if($intance['mdmparent']!='no'){
                echo 'allowParentLinks: true,';
            }
            ?>
            prependTo:'#<?php echo $this->id.'-responsive-menu';?>'
        });
	});
//]]>
</script>