<?php
    class meta{
        
        function get( $postID , $group , $name = null , $deff = null )
        {
            $meta = get_post_meta( $postID , $group );
            
            if( !empty( $name ) ){
                if( isset( $meta[ $name ] ) ){
                    return $meta[ $name ];
                }
                else{
                    return $deff;
                }
            }
            else{
                return $meta;
            }
        }
        
        function logic( $postID , $group , $name , $deff = null )
        {
            $value = self::get( $postID , $group , $name , $deff );
            
            if( !empty( $value ) && $value == 'yes' ){
                return true;
            }
            else{
                return false;
            }
        }
    }
?>