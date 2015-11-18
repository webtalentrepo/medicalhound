<?php
/*
    Version : 0.0.2
 */

class layout {
    public $layout = '';
    public $sidebars = '';
    public $sidebarsNr = '';
    public $contentClass = '';
    public $itemid = '';
    public $template = '';
    public $containerClass = '';
    public $width = 960;
	
    function _get( $setting, $template, $itemId ) {
        
        /* ONLYR FOR CATEGORY TEMPLATE */
        $rett = '';
        $id = $itemId;
        $temp = $template;
			
        switch( $template ){
	
            case 'front-page':
            case 'single':
            case 'page':
                $rett = meta::get( $itemId , 'post-' . $setting );
                
                if( $rett ) break;
                $rett = myThemes::get( $template . '-' . $setting  );
                
                if( $rett ) break;
                $rett = myThemes::get( $setting  );
                break;
            default: {		
                $rett = myThemes::get( $setting  );
                break;
            }
        }
		
        return $rett;
    }

    function layout( $template = '', $itemId = 0 )
    {   
        $this -> itemid = $itemId;
        $this -> template = $template;
        
        $this -> layout = $this -> _get( 'layout' , $template, $itemId );
        
        if( $this -> layout == 'left' || $this -> layout == 'right' ){
            $layout = 'left';
            if( $this -> layout == 'left' )
                $layout = 'right';
            
            $this -> contentClass = 'template medium to-' . $layout;
            $this -> width = 630;
            return;
        }
        
        $this -> contentClass = 'template full';
    }
	
    function echoSidebar( )
    {
        $sidebar = $this -> _get( 'sidebar', $this -> template, $this -> itemid );
        
        if( $this -> layout == 'left' || $this -> layout == 'right' ){
            echo '<aside class="large to-' . $this -> layout . '">';
                dynamic_sidebar( $sidebar );
            echo '<div class="clear"></div>';
            echo '</aside>';
            return;
        }
    }
	
    function contentClass( ) {
        return $this -> contentClass;
    }
    
    function countSidebars( $layout )
    {
        return count( explode( '+', $layout ) ) - 2;
    }
}
?>