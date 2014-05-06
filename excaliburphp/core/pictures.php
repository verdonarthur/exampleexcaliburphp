<?php
/**
 * Manage picture
 * 
 */
class pictures{
    /**
     * create a new image with dimension that you chose
     * @param string $img_src
     * @param int $img_width
     * @param int $img_height
     * @param string $save_path
     * @return boolean
     */
    public static function resize($img_src,$img_width,$img_height,$save_path){
        $is_img_create = true;
        
        list($old_img_width,$old_img_height) = getimagesize($img_src);
        
       if(strpos($img_src,'.jpg') != false){
            $old_image = imagecreatefromjpeg($img_src);
       }
       else if(strpos($img_src,'.jpeg')  != false){
           $old_image = imagecreatefromjpeg($img_src);
       }
       else if(strpos($img_src,'.png') != false){
            $old_image = imagecreatefrompng($img_src);
       }
       else if(strpos($img_src,'.gif') != false){
            $old_image = imagecreatefromgif($img_src);
       }
       else if(strpos($img_src,'.bmp') != false){
            $old_image = imagecreatefrombmp($img_src);
       }
       
        if(!$old_image){
            $is_img_create = false;
        }
        else{
            $new_image = imagecreatetruecolor($img_width, $img_height);

            if(!$new_image){
                $is_img_create = false;
            }
            else{
                if(!imagecopyresized($new_image, $old_image, 0, 0, 0, 0, $img_width, $img_height, $old_img_width, $old_img_height)){
                    $is_img_create = false;
                }
                else{
                    if(!imagejpeg($new_image,$save_path,75))
                            $is_img_create = FALSE;
                }
            }
        }
        
        return $is_img_create;
    }
}