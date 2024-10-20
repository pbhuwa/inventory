
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orga_setup_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='orga_organization';
	}


	

	public $validate_settings_orga_setup = array(               
         array('field' => 'orga_organame', 'label' => 'Organization Name ', 'rules' => 'trim|required|xss_clean|callback_exists_orga_organame'),
       // array('field' => 'orga_isactive', 'label' => 'Is Active', 'rules' => 'trim|required|xss_clean'),
       );
	
	public function orga_setup_save()
	{
	     $postdata=$this->input->post();
	     // print_r($_FILES);
	     // die();
	   	$id=$this->input->post('id');
	     unset($postdata['id']);
		 if($id)
		{
		  $logo =$this->input->post('old_images1');
          $header=$this->input->post('old_images2');
          $footer=$this->input->post('old_images3');
         unset($postdata['old_images1']);
         unset($postdata['old_images2']);
         unset($postdata['old_images3']); 
		$postdata['orga_modifydatead']=CURDATE_EN;
		$postdata['orga_modifydatebs']=CURDATE_NP;
		$postdata['orga_modifytime']=date('H:i:s');
		$postdata['orga_modifyip']='';
		$postdata['orga_modifyip']=$this->general->get_real_ipaddr();
		$postdata['orga_modifymac']=$this->general->get_Mac_Address();
		// $postdata['old_images']=!empty($this->logoattachment)?$this->logoattachment: $logo;
		$postdata['orga_image']=!empty($this->logoattachment)?$this->logoattachment: $logo;
        $postdata['orga_headerimg']=!empty($this->headingattachment)?$this->headingattachment:$header;
		$postdata['orga_footerimg']=!empty($this->footerattachment)?$this->footerattachment:$footer;
		$old_images=$this->input->post('old_images');
		

		//unset($postdata['old_images']);
	if(!empty($postdata))
		{ ///echo"<pre>"; print_r($postdata); die;
    $this->general->save_log($this->table,'orga_orgid',$id,$postdata,'Update');
			$this->db->update($this->table,$postdata,array('orga_orgid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			else
			{
				return false;
			}
		}
	
		}
		else
		{
			if(!empty($_FILES))
			{
			$imgfile=$this->doupload('orga_image');
			}
			else
			{
				$imgfile='';
			}

		
        $postdata['orga_postdatead']=CURDATE_EN;
		$postdata['orga_postdatebs']=CURDATE_NP;
		$postdata['orga_posttime']=date('H:i:s');
		$postdata['orga_postby']='';
		$postdata['orga_postip']=$this->general->get_real_ipaddr();
		$postdata['orga_postmac']=$this->general->get_Mac_Address();
		$postdata['orga_image']=$this->logoattachment;
        $postdata['orga_headerimg']=$this->headingattachment;
        $postdata['orga_footerimg']=$this->footerattachment;
  
    	//$postdata['orga_image']=$imgfile;
    	unset($postdata['old_images1']);
    	unset($postdata['old_images2']);
    	unset($postdata['old_images3']);
    	unset($postdata['id']);
    	try {
           if($this->db->insert('orga_organization',$postdata))
           {
            return $this->db->insert_id();
           }


         } catch (Exception $e) {
            throw $e;
    	}
		}
	}

	public function get_all_orga_setup($srorgal=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$this->db->select('*');
		$this->db->from('orga_organization pc');
		
		if($srorgal)
		{
			$this->db->where($srorgal);
		}
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}

	public function remove_orga_setup()
	{
		$id=$this->input->post('id');
		if($id)
		{
			$this->db->delete($this->table,array('orga_orgid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}



	public function check_exist_orga_organame_for_other($orga_organame = false, $id = false){
		$data = array();
		if($orga_organame)
		{
				$this->db->where('orga_organame',$orga_organame);
		}
		if($id)
		{
			$this->db->where('orga_orgid!=',$id);
		}

		$query = $this->db->get($this->table);
		// echo $this->db->last_query();
		// die();

		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
	}




	public function doupload($file) {

		$config['upload_path'] = './'.LOGO_PATH;//define in constants
		$config['allowed_types'] = 'mp4|mp4|3gp|mpg|flv|png|jpg|gif|jpeg|jpg';
        $config['encrypt_name'] = TRUE;
		$config['remove_spaces'] = TRUE;		
		$config['max_size'] = '2000000';
		$config['max_width'] = '5000';
		$config['max_height'] = '5000';
		$this->upload->initialize($config);
        $this->load->library('upload', $config);
        $this->upload->do_upload($file);
        $data = $this->upload->data();
        // print_r($data);
        // exit;
        $name_array = $data['file_name'];
        // echo $name_array;
        // exit;
        //     // $names= implode(',', $name_array);   
        //     // return $names;   
        return $name_array;
    }

	public function upload_logo()
	  {
	    $image1_name = $this->file_settings_do_upload('orga_image',LOGO_PATH);
	    
	    //print_r($image1_name);die;
	    // echo $this->session->userdata('bill_error');
	    if($image1_name!==false)
	    {
	      $this->logoattachment = $image1_name['file_name'];
	      //echo $this->logoattachment;die;
	      return FALSE;
	    }

	    return TRUE;
	  }


  	public function upload_header()
  		{
		    $image2_name = $this->file_settings_do_upload('orga_headerimg',HEADER_PATH);
		    // print_r($image2_name);
		    // die();
		    // echo $this->session->userdata('bill_error');
		    if($image2_name!==false)
		    {
		      $this->headingattachment = $image2_name['file_name'];
		      return FALSE;
		    }

		    return TRUE;
		}

	public function upload_footer()
	{
	    $image3_name = $this->file_settings_do_upload('orga_footerimg',FOOTER_PATH);
	    // print_r($image3_name);
	    // die();
	    // echo $this->session->userdata('bill_error');
	    if($image3_name!==false)
	    {
	      $this->footerattachment = $image3_name['file_name'];
	      return FALSE;
	    }

	    return TRUE;
	}

  	public function file_settings_do_upload($file,$path)
 	{

	    $config['upload_path'] = './'.$path;//define in constants
	    $config['allowed_types'] = 'gif|jpg|png|docx|pdf|bmp|doc|xls|xlsx';
	    $config['remove_spaces'] = TRUE;  
	    //$config['overwrite'] = TRUE;  
	    $config['encrypt_name'] = TRUE;
	    $config['max_size'] = '5000';
	    $config['max_width'] = '5000';
	    $config['max_height'] = '5000';
	    $this->upload->initialize($config);
	    // print_r($_FILES);
	    // die();
	    
	    $this->upload->do_upload($file);
	    if($this->upload->display_errors())
	    {
	     

	      $this->error_img=$this->upload->display_errors();
	      // $this->error_img;
	      if($file=='orga_image')
	      {
	        $this->session->set_userdata('logo_error',$this->error_img);
	      }
	      if($file=='orga_footerimg')
	      {
	        $this->session->set_userdata('footer_error',$this->error_img);
	      }

	      if($file=='orga_headerimg')
	      {
	        $this->session->set_userdata('header_error',$this->error_img);
	      }
	      return false;
	    }
	    else
	    {
	            
	      $data = $this->upload->data();
	      return $data;
	    }     
	}

	
}