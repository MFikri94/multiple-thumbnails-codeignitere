<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_model extends CI_Model{
    //show all images
    function show_images(){
        $query = $this->db->get('images');
        return $query;
    }

    //insert to database
    function insert_images($title,$image_large,$image_medium,$image_small){
      $data = array(
            'image_title'   => $title,
            'image_large'   => $image_large,
            'image_medium'  => $image_medium,
            'image_small'   => $image_small
      );
      $this->db->insert('images', $data);
    }

}
