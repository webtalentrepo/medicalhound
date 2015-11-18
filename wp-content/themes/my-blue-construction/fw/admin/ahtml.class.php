<?php

class ahtml {
    /*
     * 
        DEFINE DEFAULT VALUE FOR FIELDS
     
        sett::$deff[ 'mytheme_social' ] = array();
        $deff = & sett::$deff[ 'page-slug' ];
        $def[ 'field-name' ] = 'defaultValue';


        ALL POSSIBLE SETTINGS FOR FIELD

        $sett = array(
            'pageSlug'      => 'general',
            'fieldName'     => 'twitter'
            'label'         => 'label',
            'type'          => array(
                'template'  => 'templateType',
                'input'     => 'inputType'
                'validator' => 'int'
            ),
            'btnType'       => 'primary|secondary',
            'hint'          => 'hint',
            'inputID'       => 'inputID',                         
            'templateID'    => 'templateID',
            'inputClass'    => 'inputClass',
            'templateClass' => 'templateClass',
            'action'        => 'javascriptAction',
            'value'         => 'inputValue',
            'values'        => 'selectValues',
            'defaultValue'  => 'defaultValue',  // will be use with meta
            'title'         => 'H3 Title',
            'description'   => 'paragraf',
            'content'       => 'HTML Code',
            'query'         => array( 'WP_Query' ),
        );
     */
    
    /* CHECK ATTRIBUTES ( $sett ) */
    function getInputType( $sett )
    {
        return isset( $sett[ 'type' ][ 'input' ] ) && method_exists( new ahtml() , $sett[ 'type' ][ 'input' ] ) ? $sett[ 'type' ][ 'input' ] : exit;
    }
    
    function getInputTypeClass( $sett )
    {
        return 'my-field-' . self::getInputType( $sett );
    }
    
    function getInputID( $sett , $attr = false )
    {
        /* SET INPUT NAME */
        $inputName = tools::getInputName( $sett );
        
        if( !empty( $inputName ) ){
            /* SET INPUT ID */
            $inputID = isset( $sett[ 'inputID' ] ) && !empty( $sett[ 'inputID' ] ) ? $sett[ 'inputID' ] : 'my-field-' . $inputName;
            if( !$attr ){
                return $inputID;
            }
            else{
                return !empty( $inputID ) ? 'id="' . $inputID . '"' : 'id="my-field-' . $inputName . '"';
            }
        }else{
            /* SET INPUT ID */
            $inputID = isset( $sett[ 'inputID' ] ) && !empty( $sett[ 'inputID' ] ) ? $sett[ 'inputID' ] : '';
            if( !$attr ){
                return $inputID;
            }
            else{
                return !empty( $inputID ) ? 'id="' . $inputID . '"' : '';
            }
        }
    }
    
    function getInputClass( $sett , $attr = false , $additionalClass = '' )
    {
        /* SET INPUT CLASS */
        $inputClass = isset( $sett[ 'inputClass' ] ) && !empty( $sett[ 'inputClass' ] ) ? $sett[ 'inputClass' ] : $additionalClass;
        
        if( !$attr ){
            if( !empty( $additionalClass ) ){
                return $inputClass . ' ' . $additionalClass  ;
            }
            else{
                return $inputClass;
            }
        }
        else{
            return !empty( $inputClass ) ? 'class="my-field ' . $inputClass . ' ' . self::getInputTypeClass( $sett ). ' ' . $additionalClass . '"' : ' class="my-field ' . self::getInputTypeClass( $sett ). ' ' . $additionalClass . '"';
        }
    }
    
    function getButtonClass( $sett , $attr = false , $additionalClass = '' )
    {
        /* SET BUTTON CLASS */
        $buttonClass = isset( $sett[ 'btnType' ] ) ? 'button-' . $sett[ 'btnType' ] : 'button-primary';
        
        /* ADD ADDITIONAL CLASS */
        if( !empty( $additionalClass ) ){
            $result = $buttonClass . ' ' . $additionalClass;
        }
        else{
            $result = $buttonClass;
        }
            
        if( !$attr ){
            return $result;
        }
        else{
            return 'class="' . $result . '"';
        }
    }
    
    function getInputLabel( $sett )
    {
        /* SET INPUT ID */
        $inputID = self::getInputID( $sett );
        
        /* SET INPUT LABEL */
        $label = isset( $sett[ 'label' ] ) && !empty( $sett[ 'label' ] ) ? $sett[ 'label' ] : '';
        
        /* SET LABEL ATTRIBUTE ID */
        $labelID = !empty( $inputID ) ? 'for="' . $inputID . '"' : '';
        
        if( !empty( $label ) ){
            return '<label ' . $labelID . '>' . $label . '</label>';
        }
    }
    
    function getTemplateID( $sett , $attr = false )
    {
        /* SET INPUT NAME */
        $inputName = tools::getInputName( $sett );
        
        if( !empty( $inputName ) ){
            /* SET TEMPLATE ID */
            $templateID = isset( $sett[ 'templateID' ] ) && !empty( $sett[ 'templateID' ] ) ? $sett[ 'templateID' ] : 'my-template-' . $inputName;
            if( !$attr ){
                return $templateID;
            }
            else{
                return !empty( $templateID ) ? 'id="' . $templateID . '"' : 'id="my-template-' . $inputName . '"';
            }
        }else{
            /* SET TEMPLATE ID */
            $templateID = isset( $sett[ 'templateID' ] ) && !empty( $sett[ 'templateID' ] ) ? $sett[ 'templateID' ] : '';
            if( !$attr ){
                return $templateID;
            }
            else{
                return !empty( $templateID ) ? 'id="' . $templateID . '"' : '';
            }
        }
    }
    
    function getTemplateClass( $sett , $additionalClass , $attr = false )
    {
        /* SET TEMPLATE CLASS */
        $templateClass = isset( $sett[ 'templateClass' ] ) && !empty( $sett[ 'templateClass' ] ) ? $sett[ 'templateClass' ] : '';
        
        if( !$attr ){
            return $templateClass;
        }
        else{
            if( strlen( $templateClass . $additionalClass ) ){
                return !empty( $templateClass ) ? 'class="' . $templateClass . ' ' . $additionalClass . '"' : 'class="' . $additionalClass . '"';
            }
        }
    }

    function getSelectValues( $sett )
    {
        if( isset( $sett[ 'type' ][ 'input' ] ) && $sett[ 'type' ][ 'input' ] == 'select' ){
            $result = '';
                
            if( !isset( $sett[ 'value' ] ) ){
                if( isset( $sett[ 'defaultValue' ] ) ){
                    if( isset( $sett[ 'values' ] ) && !empty( $sett[ 'values' ] ) && is_array( $sett[ 'values' ] ) ){
                        foreach( $sett[ 'values' ] as $value => $label ){
                            $result .= '<option value="' . esc_attr( $value ) . '" ' . selected( $sett[ 'defaultValue' ] , esc_attr( $value ) , false ) . '>' . $label . '</option>';
                        }
                    }

                    return $result;
                }
                else{
                    if( isset( $sett[ 'values' ] ) && !empty( $sett[ 'values' ] ) && is_array( $sett[ 'values' ] ) ){
                        foreach( $sett[ 'values' ] as $value => $label ){
                            $result .= '<option value="' . esc_attr( $value ) . '">' . $label . '</option>';
                        }
                    }

                    return $result;
                }
            }
            else{
                if( isset( $sett[ 'values' ] ) && !empty( $sett[ 'values' ] ) && is_array( $sett[ 'values' ] ) ){
                    foreach( $sett[ 'values' ] as $value => $label ){
                        $result .= '<option value="' . esc_attr( $value ) . '" ' . selected( $sett[ 'value' ] , esc_attr( $value ) , false ) . '>' . $label . '</option>';
                    }
                }

                return $result;
            }
        }
    }
    
    function getLogicValue( $sett )
    {
        if( isset( $sett[ 'type' ][ 'input' ] ) && $sett[ 'type' ][ 'input' ] == 'logic' ){
            if( !isset( $sett[ 'value' ] ) ){
                if( isset( $sett[ 'defaultValue' ] ) ){
                    return 'value="' . ( (int)$sett[ 'defaultValue' ] ) . '"';
                }
            }
            else{
                return 'value="' . ( (int) $sett[ 'value' ] ) . '"';
            }
        }
    }
    
    function getLogicCheckValue( $sett )
    {
        if( isset( $sett[ 'type' ][ 'input' ] ) && $sett[ 'type' ][ 'input' ] == 'logic' ){
            if( !isset( $sett[ 'value' ] ) ){
                if( isset( $sett[ 'defaultValue' ] ) ){
                    return checked( $sett[ 'defaultValue' ] , 1 , false );
                }
            }
            else{
                return checked( $sett[ 'value' ] , 1 , false );
            }
        }
    }
    
    function getTextareaValue( $sett )
    {
        if( isset( $sett[ 'type' ][ 'input' ] ) && $sett[ 'type' ][ 'input' ] == 'textarea' ){
            if( !isset( $sett[ 'value' ] ) ){
                if( isset( $sett[ 'defaultValue' ] ) ){
                    return esc_attr( $sett[ 'defaultValue' ] );
                }
            }
            else{
				return esc_attr( $sett[ 'value' ] );
            }
        }
    }
    
    /* TEXT, SEARCH, UPLOAD, UPLOAD-ID, DIGIT */
    function getValue( $sett , $attr = false )
    {
        if( !isset( $sett[ 'value' ] ) ){
            if( isset( $sett[ 'defaultValue' ] ) ){
                if( !$attr ){
                    return esc_attr( $sett[ 'defaultValue' ] );
                }
                else{                    
                    return 'value="' . esc_attr( $sett[ 'defaultValue' ] ) . '"';
                }
            }
        }
        else{   
            if( !$attr ){
                return $sett[ 'value' ];
            }
            else{
                return 'value="' . esc_attr( $sett[ 'value' ] ) . '"';
            }
        }
    }
    
    /* AUTO COMPLETE RESULT ( AJAX REQUEST ) */
    function getSearchValues()
    {
        $query = isset( $_GET[ 'params' ] ) ? (array)json_decode( stripslashes( $_GET[ 'params' ] )) : exit;
        $query[ 's' ] = isset( $_GET[ 'query' ] ) ? $_GET[ 'query' ] : exit;
        
        global $wp_query;
        $result = array();
        $result[ 'query' ] = $query[ 's' ];
        
        $wp_query = new WP_Query( $query );
        
        if( $wp_query -> have_posts() ){
            foreach( $wp_query -> posts as $post ){
                $result['suggestions'][] = $post -> post_title;
                $result['data'][] =  $post -> ID;
            }
        }
        
        echo json_encode( $result );
        exit();
    }
    
    /* TEMPLATES TYPE */
    function template( $sett )
    {
        if( isset( $sett[ 'type' ][ 'template' ] ) && method_exists( new ahtml() , $sett[ 'type' ][ 'template' ] ) ) {
            return call_user_method_array( $sett[ 'type' ][ 'template' ] , new ahtml() , array( $sett ) );
        }
        else{
            return 'Template not exist : [ ' . tools::getPageSlug( $sett ) .' , ' . tools::getFieldName( $sett ) . ' ]';
        }
    }
    
	/* TEMPLATE TYPE INLINE */
    function inline( $sett )
    {
        $result  = '<div ' . self::getTemplateID( $sett , true ) . ' ' . self::getTemplateClass( $sett , 'inline-type' , true ) . '>';
        
        /* ADD LABEL */
        $result .= '<div class="label">' . self::getInputLabel( $sett ) . '</div>';
        
        /* ADD INPUT */
        $result .= '<div class="input">';
        $result .= call_user_method_array( self::getInputType( $sett ) , new ahtml() , array( $sett ) );
        $result .= '</div>';
        
        $result .= '<div class="clear"></div>';
        
        /* ADD HINT ( ADDITIONAL INFO ) */
        if( isset( $sett[ 'hint' ] ) && !empty( $sett[ 'hint' ] ) ){
            $result .= '<div class="hint"><small>' . $sett[ 'hint' ] . '</small></div>';
        }
        
        $result .= '</div>';
        
        return $result;
    }
    
    /* TEMPLATE TYPE INLIST */
    function inlist( $sett )
    {
        $result  = '<div ' . self::getTemplateID( $sett , true ) . ' ' . self::getTemplateClass( $sett , 'inlist-type' , true ) . '>';
        
        /* ADD LABEL */
        $result .= '<div class="label">' . self::getInputLabel( $sett ) . '</div>';
        
        /* ADD INPUT */
        $result .= '<div class="input">';
        echo call_user_method_array( self::getInputType( $sett ) , new ahtml() , array( $sett ) );
        $result .= '</div>';
        
        /* ADD HINT ( ADDITIONAL INFO ) */
        if( isset( $sett[ 'hint' ] ) && !empty( $sett[ 'hint' ] ) ){
            $result .= '<div class="clear"></div>';
            $result .= '<div class="hint"><small>' . $sett[ 'hint' ] . '</small></div>';
        }
        
        $result .= '</div>';
        
        return $result;
    }
    
	/* TEMPLATE TYPE CODE */
    function code( $sett )
    {
        $result = '<div ' . self::getTemplateID( $sett , true ) . ' ' . self::getTemplateClass( $sett , 'code-type' , true ) . '>';
        
        if( isset( $sett[ 'title' ] ) ){
            $result .= '<h3 class="title">' . $sett[ 'title' ] . '</h3>';
        }
        
        if( isset( $sett[ 'description' ] ) ){
            $result .= '<p class="description">' . $sett[ 'description' ] . '</p>';
        }
        
        if( isset( $sett[ 'content' ] ) ){
            $result .= $sett[ 'content' ];
        }
        
        $result .= '</div>';
        
        return $result;
    }
    
    /* INPUTS TYPE */
    /* INPUT TYPE TEXT */
    function text( $sett )
    {
        $result  = '<input type="text" ';
        $result .= self::getInputID( $sett , true ) . ' ';
        $result .= self::getInputClass( $sett , true ) . ' ';
        $result .= tools::getInputName( $sett , true ) . ' ';
        $result .= self::getValue( $sett , true ) . '/>';       
        return $result;
    }
    
    /* INPUT TYPE LIMITED TEXT */
    function limitedText( $sett )
    {
        $result  = '<input type="text" ';
        $result .= self::getInputID( $sett , true ) . ' ';
        $result .= self::getInputClass( $sett , true ) . ' ';
        $result .= tools::getInputName( $sett , true ) . ' ';
        
        if( !isset( $sett[ 'limit' ] ) ){
            $limit = 50;
        }
        else{
            $limit = (int)$sett[ 'limit' ];
        }
        
        $result .= self::getLimitStringAction( 'this' , $limit );
        $result .= self::getValue( $sett , true ) . '/>';

        return $result;
    }
    
    /* INPUT TYPE SEARCH ( AUTO COMPLETE ) */
    function search( $sett )
    {
        /* SET INPUT VALUE */
        $value  = self::getValue( $sett );
        $title  = '';
        $postID = '';
        
        if( !empty( $value ) && (int)$value > 0 ){
            $p = get_post( $value );
            if( !is_wp_error( $p ) && is_object( $p ) ){
                $title = $p -> post_title;
                $postID = $p -> ID;
            }
        }
        
        /* POST TITLE */
        $result  = '<input type="text" ' . self::getInputClass( $sett , true ) . ' value="' . esc_attr( $title ) . '"/>';
        
        /* DEFAULT VALIDATOR */
        if( !isset( $sett[ 'type' ][ 'validator' ] ) ){
            $sett[ 'type' ][ 'validator' ] = 'int';
        }
        
        /* POST ID */
        $result .= '<input type="hidden" class="my-field-search-postID"';
        $result .= self::getInputID( $sett , true ) . ' ';
        $result .= tools::getInputName( $sett , true ) . ' ';
        $result .= self::getValue( $sett , true ) . '/>';
        
        /* POSTS FROM QUERY */
        $result .= '<input type="hidden" class="my-field-params" value="' . urlencode( json_encode( $sett[ 'query' ] ) ) . '" />';
        $result .= '<a class="search-clean" href="javascript:fields.clean( \'#' . self::getTemplateID( $sett ) . '\'  )" ';
        $result .= 'title="' . esc_attr__( 'Remove data from this field' , "mythemes" ) . '">';
        $result .= '<img src="' . get_template_directory_uri() . '/media/admin/images/clear-hover.png" height="0" width="0"/></a>';
        
        return $result;
    }
    
    /* INPUT TYPE DIGIT ( ACCEPT ONLY DIGITS ) */
    function digit( $sett )
    {
        /* DEFAULT VALIDATOR */
        if( !isset( $sett[ 'type' ][ 'validator' ] ) ){
            $sett[ 'type' ][ 'validator' ] = 'int';
        }
        
        $result  = '<input type="text" ';
        $result .= self::getInputID( $sett , true ) . ' ';
        $result .= self::getInputClass( $sett , true ) . ' ';
        $result .= tools::getInputName( $sett , true ) . ' ';
        $result .= self::getValue( $sett , true ) . '/>';
        
        return $result;
    }
    
    /* INPUT TYPE UPLOAD ( URL OR UPLOADED FILE PATH ) */
    function upload( $sett )
    {
        /* DEFAULT VALIDATOR */
        if( !isset( $sett[ 'type' ][ 'validator' ] ) ){
            $sett[ 'type' ][ 'validator' ] = 'url';
        }
        
        /* UPLOAD URL / FILE PATH */
        $result  = '<input type="text" ';
        $result .= self::getInputID( $sett , true ) . ' ';
        $result .= self::getInputClass( $sett , true ) . ' ';
        $result .= tools::getInputName( $sett , true ) . ' ';
        $result .= self::getValue( $sett , true ) . '/>';
        
        /* UPLOAD BUTTON */
        $result .= '<input type="button" ';
        $result .= self::getButtonClass( $sett , true , 'button-upload' ) . ' ';
        $result .= ' value="' . __( 'Choose File' , "mythemes" ) . '" ';
        $result .= self::getUploadAction( self::getInputID( $sett ) ) . ' />';
        
        return $result;
    }
    
    /* INPUT TYPE UPLOAD ID ( SAVE ID OF ATTACHED FILE ) */
    function uploadID( $sett )
    {
        /* SET UPLOAD ID VALUE */
        $value = '';
        
        if( (int)self::getValue( $sett ) > 0 ){
            $src = wp_get_attachment_image_src( self::getValue( $sett ) , 'full' );
            if( isset( $src[ 0 ] ) && !empty( $src[ 0 ] ) ){
                $value = $src[ 0 ];
            }
        }
        
        /* DEFAULT VALIDATOR */
        if( !isset( $sett[ 'type' ][ 'validator' ] ) ){
            $sett[ 'type' ][ 'validator' ] = 'int';
        }
        
        /* UPLOAD URL */
        $result  = '<input type="text" ';
        $result .= 'id="' . self::getInputID( $sett ) . '" ';
        $result .= self::getInputClass( $sett , true ) . ' ';
        $result .= 'value="' . esc_url( $value ). '"/>';
        
        /* UPLOAD BUTTON */
        $result .= '<input type="button" ';
        $result .= self::getButtonClass( $sett , true , 'button-upload' ) . ' ';
        $result .= ' value="' . __( 'Choose File' , "mythemes" ) . '" ';
        $result .= self::getUploadIDAction( self::getInputID( $sett ) ) . ' />';
        
        /* UPLOAD ID */
        $result .= '<input type="hidden" ';
        $result .= ' id="' . self::getInputID( $sett ) . '-ID" ';
        $result .= tools::getInputName( $sett , true ) . ' ';
        $result .= self::getValue( $sett , true ) . '"/>';
        
        return $result;
    }
    
    /* INPUT TYPE PICK COLOR */
    function pickColor( $sett )
    {
        /* SET INPUT NAME */
        $inputName = self::getInputName( $sett );
        
        /* COLOR */
        $result  = '<input type="text" ';
        $result .= self::getInputID( $sett , true ) . ' ';
        $result .= self::getInputClass( $sett , true ) . ' ';
        $result .= tools::getInputName( $sett , true ) . ' ';
        $result .= 'op_name="' . $inputName . '" ';
        $result .= self::getValue( $sett , true ) . '/>';

        /* PICK ICON */
        $result .= '<a href="javascript:void(0);" class="pickcolor hide-if-no-js" id="link-pick-' . $inputName . '"></a>';
        
        /* COLOR PANEL */
        $result .= '<div id="color-panel-' . $inputName . '" class="color-panel">a</div>';
        
        return $result;
    }
    
    /* INPUT TYPE TEXTAREA */
    function textarea( $sett )
    {
        $result  = '<textarea ';
        $result .= self::getInputID( $sett , true ) . ' ';
        $result .= self::getInputClass( $sett , true ) . ' ';
        $result .= tools::getInputName( $sett , true ) . ' ';
        $result .= '>' . self::getTextareaValue( $sett ) . '</textarea>';
        
        return $result;
    }
    
    /* INPUT TYPE LIMITED TEXTAREA */
    function limitedTextarea( $sett )
    {
        $result  = '<textarea ';
        $result .= self::getInputID( $sett , true ) . ' ';
        $result .= self::getInputClass( $sett , true ) . ' ';
        $result .= tools::getInputName( $sett , true ) . ' ';
        
        if( !isset( $sett[ 'limit' ] ) ){
            $limit = 150;
        }
        else{
            $limit = (int)$sett[ 'limit' ];
        }
        
        $result .= self::getLimitStringAction( 'this' , $limit );
        $result .= '>' . self::getTextareaValue( $sett ) . '</textarea>';
        
        return $result;
    }
    
    /* INPUT TYPE LIMITED NUMBER OF WORDS */
    function limitedWords( $sett )
    {
        $result  = '<textarea ';
        $result .= self::getInputID( $sett , true ) . ' ';
        $result .= self::getInputClass( $sett , true ) . ' ';
        $result .= tools::getInputName( $sett , true ) . ' ';
        
        if( !isset( $sett[ 'limit' ] ) ){
            $limit = 10;
        }
        else{
            $limit = (int)$sett[ 'limit' ];
        }
        
        $result .= self::getLimitWordsAction( 'this' , $limit );
        $result .= '>' . self::getTextareaValue( $sett ) . '</textarea>';
        
        return $result;
    }
    
    /* INPUT TYPE SELECT */
    function select( $sett )
    {
        $result  = '<select ';
        $result .= self::getInputID( $sett , true ) . ' ';
        $result .= self::getInputClass( $sett , true ) . ' ';
        $result .= tools::getInputName( $sett , true ) . ' ';
        $result .= self::getSelectAction( $sett );
        $result .= '>' . self::getSelectValues( $sett ) . '</select>';
        
        return $result;
    }
    
    /* INPUT TYPE LOGIC */
    function logic( $sett )
    {
        /* DEFAULT VALIDATOR */
        if( !isset( $sett[ 'type' ][ 'validator' ] ) ){
            $sett[ 'type' ][ 'validator' ] = 'int';
        }
        
        $result  = '<input type="checkbox"';
        $result .= self::getInputID( $sett , true ) . ' ';
        $result .= self::getInputClass( $sett , true ) . ' ';
        $result .= self::getLogicAction( $sett );
        $result .= self::getLogicCheckValue( $sett ) . '/>';
        $result .= '<input type="hidden"';
        $result .= tools::getInputName( $sett , true ) . ' ';
        $result .= self::getLogicValue( $sett ) . '/>';
        
        return $result;
    }
    
    /* FIELDS ACTIONS */
    /* UPLOAD ACTION */
    function getLimitStringAction( $obj , $nr ){
        return 'onkeyup="javascript:fields.limitString( ' . $obj . ' , ' . $nr . ' );"';
    }
    
    function getLimitWordsAction( $obj , $nr ){
        return 'onkeyup="javascript:fields.limitWords( ' . $obj . ' , ' . $nr . ' );"';
    }
    
    function getUploadAction( $id )
    {
        return 'onclick="javascript:fields.upload(\'input#' . $id . '\' );"';
    }
    
    function getUploadIDAction( $id )
    {
        return 'onclick="javascript:fields.uploadID(\'input#' . $id . '\' , \'\' );"';
    }
    
    function getSelectAction( $sett )
    {
        if( isset( $sett[ 'action' ] ) && !empty( $sett[ 'action' ] ) ){
            return 'onchange="javascript:' . $sett[ 'action' ] . ';"';
        }
    }
    
    function getLogicAction( $sett )
    {
        if( isset( $sett[ 'action' ] ) && !empty( $sett[ 'action' ] ) ){
            return 'onclick="javascript:fields.check( this , ' . $sett[ 'action' ] . ' );" ';
        }else{
            return 'onclick="javascript:fields.check( this , { \'t\' : \'-\' , \'f\' : \'-\' } );" ';
        }
    }
    
    function getValidator( $sett )
    {
        if( !isset( $sett[ 'type' ][ 'validator' ] ) ){ /* DEFAULT VALIDATOR TYPE */
            switch( $sett[ 'type' ][ 'input' ] ){
                case 'digit' : {
                    return 'int';
                }
                case 'logic' : {
                    return 'int';
                }
                case 'uploadID' : {
                    return 'int';
                }
                case 'upload' : {
                    return 'url';
                }
                case 'search' : {
                    return 'int';
                }
            }
        }
        else{
            return $sett[ 'type' ][ 'validator' ];
        }
    }
    
    function validator( $value , $type )
    {   
        switch( $type ){
            case 'int' : {
                if( empty( $value ) ){
                    return '';
                }
                if( is_array( $value ) ){
                    return '';
                }else{
                    return (int) $value;
                }
                break;
            }
            
            case 'url' : {
                return esc_url( $value );
                break;
            }
            
            case 'email' : {
                if( is_email( $value ) ){
                    return $value;
                }
                else{
                    return '';
                }
                break;
            }
            
            case 'noesc' : {
                return $value;
                break;
            }
            
            default : {
                return esc_attr( $value );
                break;
            }
        }
    }
};

    add_action( 'wp_ajax_search' , array( 'ahtml' , 'getSearchValues' ) );
?>