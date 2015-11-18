<?php
    class tools
    {
        function getPageSlug( $sett )
        {
            return isset( $sett[ 'pageSlug' ] ) && !empty( $sett[ 'pageSlug' ] ) ? $sett[ 'pageSlug' ] : '';
        }

        function getFieldName( $sett )
        {
            return isset( $sett[ 'fieldName' ] ) && !empty( $sett[ 'fieldName' ] ) ? $sett[ 'fieldName' ] : '';
        }
        
        function getInputName( $sett , $attr = false )
        {
            /* SET PAGE SLUG */
            $pageSlug = self::getPageSlug( $sett );

            /* SET FIELD NAME */
            $fieldName = self::getFieldName( $sett );

            if( !empty( $pageSlug ) ) {
                if( !$attr ){
                    return !empty( $fieldName ) ? $pageSlug . '-' . $fieldName : '';
                }
                else{
                    return !empty( $fieldName ) ? 'name="' . $pageSlug . '-' . $fieldName . '"' : '';
                }
            }else{
                if( !$attr ){
                    return !empty( $fieldName ) ? $fieldName : '';
                }
                else{
                    return !empty( $fieldName ) ? 'name="' . $fieldName . '"' : '';
                }
            }
        }
        
    }
?>