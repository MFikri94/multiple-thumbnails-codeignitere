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
	    $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang image yang dizinkan
	    $config['encrypt_name'] = TRUE; //enkripsi nama file

	    $this->upload->initialize($config);

      if(!empty($_FILES['filefoto']['name'])){
		        if ($this->upload->do_upload('filefoto')){
		            $gbr = $this->upload->data();
	              //Compress Image
                $this->_create_thumbs($gbr['file_name']);

                $title = $this->input->post('title',TRUE);
                $image_large = $gbr['file_name'];
                $image_medium = $gbr['file_name'];
                $image_small = $gbr['file_name'];

                $this->upload_model->insert_images($title,$image_large,$image_medium,$image_small);
                $this->session->set_flashdata('msg','<div class="alert alert-info">Image Berhasil di upload.</div>');
                redirect('upload/show_images');
				    }else{
		            echo $this->upload->display_errors();
		    	  }

		    }else{
				    echo "image kosong atau type image tidak di izinkan";
			}
  }

  function _create_thumbs($file_name){
        // Image resizing config
        $config = array(
            // Image Large
            array(
                'image_library' => 'GD2',
                'source_image'  => './assets/images/'.$file_name,
                'maintain_ratio'=> FALSE,
                'width'         => 700,
                'height'        => 467,
                'new_image'     => './assets/images/large/'.$file_name
                ),
            // image Medium
            array(
                'image_library' => 'GD2',
                'source_image'  => './assets/images/'.$file_name,
                'maintain_ratio'=> FALSE,
                'width'         => 600,
                'height'        => 400,
                'new_image'     => './assets/images/medium/'.$file_name
                ),
            // Image Small
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

    //function untuk menampilkan image ke view
    function show_images(){
      $data['images']=$this->upload_model->show_images();
      $this->load->view('images_view', $data);
    }

}
