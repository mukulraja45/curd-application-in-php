<?php
defined('BASEPATH') OR exit('No direct script access allowed');


if(!function_exists('imageUploadWithWaterMarkHelper'))
{
    function imageUploadWithWaterMarkHelper($fileName,$uploadPath,$allowed_types,$fileSubName,$uploadPath1)
    {
        $ci =& get_instance(); 
        
        if(isset($fileName['name']) && $fileName['name']!="")
        {
            $ci->load->library(array('image_lib','upload'));
            $config['upload_path']   = $uploadPath;
            $config['allowed_types'] = $allowed_types;
            $config['encrypt_name'] = TRUE;
            $ci->upload->initialize($config);
            if($ci->upload->do_upload($fileSubName))
            {
                $imageName= $ci->upload->data();
                // $resizeconfig = array(
                //     'image_library'=>'gd2',
                //     'source_image'=>$uploadPath.$imageName['file_name'],
                //     'create_thumb'=>FALSE,
                //     'maintain_ratio'=>TRUE,
                //     'quality'=>'50%',
                //     'width'=>300,
                //     'height'=>300,
                // );
                // $ci->image_lib->initialize($resizeconfig);
                // if(!$ci->image_lib->resize()){
                //     echo $ci->image_lib->display_errors();
                // }
                $imgConfig = array();
                $imgConfig['image_library']    = 'gd2';
                $imgConfig['source_image']     = $uploadPath.$imageName['file_name'];
                                       
                $imgConfig['create_thumb']     = FALSE;
                                        
                $imgConfig['maintain_ratio']   = TRUE;
                                        
                $imgConfig['width']            = 150;
                                        
                $imgConfig['height']           = 75;   
                                     
                $ci->load->library('image_lib', $imgConfig);
                                       
                if (!$ci->image_lib->resize()){
                      
                    echo $ci->image_lib->display_errors();
                                        
                } 
                $ci->image_lib->clear();
                
                $imgConfig = array();
                        
                $imgConfig['image_library']   = 'GD2';
                                        
                $imgConfig['source_image']    = $uploadPath.$imageName['file_name'];
                                        
                $imgConfig['wm_text']         = 'Copyright 2016 - Programmr';
                                        
                $imgConfig['wm_type']         = 'text';
                                        
                $imgConfig['wm_font_size']    = '16';
                                                     
                $ci->load->library('image_lib', $imgConfig);
                                        
               $ci->image_lib->initialize($imgConfig);
                                        
               $ci->image_lib->watermark(); 
               
               
             $imgConfig = array();
                        
            $imgConfig['image_library']  = 'gd2';
                                    
            $imgConfig['source_image']   = $uploadPath.$imageName['file_name'];
                                    
            $imgConfig['height'] = '400';
                                    
            $imgConfig['width']  = '400';
                                    
            $imgConfig['rotation_angle'] = '90';
                                    
            $imgConfig['new_image']      = $uploadPath1.$imageName['file_name'];
                                    
             $ci->load->library('image_lib', $imgConfig);
                                    
             $ci->image_lib->initialize($imgConfig);
                                    
            if ( !  $ci->image_lib->rotate()){
                             
                  echo  $ci->image_lib->display_errors();                      
            } 
            
            $imgConfig = array();
 
            $imgConfig['image_library']= 'gd2';
            $imgConfig['source_image'] = $uploadPath.$imageName['file_name'];
                                    
            $imgConfig['new_image']    = $uploadPath1.$imageName['file_name'];
                                    
            $imgConfig['height'] = '300';
                                    
            $imgConfig['width']  = '200';
                                    
            $imgConfig['x_axis'] = '150';
                                    
            $imgConfig['y_axis'] = '150';
                                   
            $ci->load->library('image_lib', $imgConfig);
                                    
             $ci->image_lib->initialize($imgConfig);
            if ( !  $ci->image_lib->crop()){
                echo $ci->image_lib->display_errors();
            }
                        
            $imgConfig = array();
                        
            $imgConfig['image_library'] = 'GD2';
                                    
            $imgConfig['source_image']  = $uploadPath.$imageName['file_name'];
            $imgConfig['wm_type']       = 'overlay';    
                                    
            $imgConfig['wm_overlay_path'] = './files/overlay_programmerblog.png';
                                    
            $ci->load->library('image_lib', $imgConfig);
                                    
            $ci->image_lib->initialize($imgConfig);
                                    
            $ci->image_lib->watermark();
            
            
                return $imageName;
            }
            else{
                echo $ci->upload->display_errors();
            }

        }
        else{
            return array('file_name'=>'');
        }
    }
}