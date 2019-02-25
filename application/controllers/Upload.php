<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller{

  function __construct(){
    parent::__construct();
    $this->load->library('upload');
    //load model Upload_model.php
    $this->load->model('Upload_model','upload_model');
  }

  function index(){
    $this->load->view('upload_view');
  }

  function do_upload(){
      $config['upload_path'] = './assets/images/'; //path folder
	    $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
	    $config['encrypt_name'] = TRUE;

	    $this->upload->initialize($config);

      if(!empty($_FILES['filefoto']['name'])){
		        if ($this->upload->do_upload('filefoto')){
		            $img = $this->upload->data();
	              //Compress Image
                $this->_create_thumbs($img['file_name']);

                $title = $this->input->post('title',TRUE);
                $image_large = $img['file_name'];
                $image_medium = $img['file_name'];
                $image_small = $img['file_name'];

                $this->upload_model->insert_images($title,$image_large,$image_medium,$image_small);
                $this->session->set_flashdata('msg','<div class="alert alert-info">Image Upload Successful.</div>');
                redirect('upload/show_images');
				    }else{
		            echo $this->upload->display_errors();
		    	  }

		    }else{
				    echo "image is empty or type of image not allowed";
			}
  }

  function _create_thumbs($file_name){
        // Image resizing config
        $config = array(
            // Large Image
            array(
                'image_library' => 'GD2',
                'source_image'  => './assets/images/'.$file_name,
                'maintain_ratio'=> FALSE,
                'width'         => 700,
                'height'        => 467,
                'new_image'     => './assets/images/large/'.$file_name
                ),
            // Medium Image
            array(
                'image_library' => 'GD2',
                'source_image'  => './assets/images/'.$file_name,
                'maintain_ratio'=> FALSE,
                'width'         => 600,
                'height'        => 400,
                'new_image'     => './assets/images/medium/'.$file_name
                ),
            // Small Image
            array(
                'image_library' => 'GD2',
                'source_image'  => './assets/images/'.$file_name,
                'maintain_ratio'=> FALSE,
                'width'         => 100,
                'height'        => 67,
                'new_image'     => './assets/images/small/'.$file_name
            ));

        $this->load->library('image_lib', $config[0]);
        foreach ($config as $item){
            $this->image_lib->initialize($item);
            if(!$this->image_lib->resize()){
                return false;
            }
            $this->image_lib->clear();
        }
    }

    //function to show images to view
    function show_images(){
      $data['images']=$this->upload_model->show_images();
      $this->load->view('images_view', $data);
    }

}
