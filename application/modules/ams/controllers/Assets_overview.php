<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assets_overview extends CI_Controller

{

	function __construct()

	{

			

		parent::__construct();

		

		$this->load->Model('assets_mdl');

		$this->load->Model('assets_transfer_mdl');

		$this->load->Model('deprecation_report_mdl');

		$this->load->library('upload');

		$this->load->library('image_lib');

		$this->load->helper('file');

		$this->load->helper('form');

		$this->load->library('zend');

	    $this->zend->load('Zend/Barcode');

	    $this->load->library('ciqrcode');



	}



	

	public function index()

	{

		//echo "aa";die;

		$assets_code=!empty($_GET['asscode'])?$_GET['asscode']:'';

		// echo $assets_code;

		// die();



		$this->data['assets_code']=!empty($assets_code)?$assets_code:'';

		$seo_data='';



		if($seo_data)

		{

			//set SEO data

			$this->page_title = $seo_data->page_title;

			$this->data['meta_keys']= $seo_data->meta_key;

			$this->data['meta_desc']= $seo_data->meta_description;

		}

		else

		{

			//set SEO data

		    $this->page_title = ORGA_NAME;

		    $this->data['meta_keys']= ORGA_NAME;

		    $this->data['meta_desc']= ORGA_NAME;

		}

		$this->data['breadcrumb']='Assets Overview';
		$this->data['tab_type']="entry";
		$this->page_title='Assets Overview';
		if($this->session->userdata(USER_ID)){
			$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('assets_overview/v_assets_overview_search_form', $this->data);
		}else{
			$_POST['id']=$assets_code;
			$assets_rec_data=$this->assets_mdl->get_assets_detail();
			$asen_asenid=$assets_rec_data[0]->asen_asenid;
			$this->data['assets_rec_data']=$assets_rec_data;
			$this->load->view('assets_overview/v_assets_overview_basic',$this->data);
		}

		

	}



	public function get_overview_report()

	{

	  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	  	$asstscode=$this->input->post('id');
	  	if(empty($asstscode)){
	  	print_r(json_encode(array('status'=>'error','message'=>'Assets Code is Required')));
    	exit;
	  	}

	  	$assets_rec_data=$this->assets_mdl->get_assets_detail();

	  	// echo $this->db->last_query();

	  	// die();

	  	if(!empty($assets_rec_data)){

	  		$asen_asenid=$assets_rec_data[0]->asen_asenid;

	  		$this->data['assets_rec_data']=$assets_rec_data;

	  		$this->data['lease_data_rec']=$this->assets_mdl->get_assets_lease_record(array('lede_assetid'=>$asen_asenid));
	  		$this->data['insurance_data_rec']=$this->assets_mdl->get_assets_insurance_record(array('asin_assetid'=>$asen_asenid));

	  		if(ORGANIZATION_NAME=='KU'){
	  			$this->data['assets_transfer_data_rec']= $this->assets_transfer_mdl->get_assets_transfer_detail_data_ku(array('astd_assetsid'=>$asen_asenid));
	  		}else{
	  			$this->data['assets_transfer_data_rec']= $this->assets_transfer_mdl->get_assets_transfer_detail_data(array('astd_assetsid'=>$asen_asenid));
	  		}
	  		
	  		// echo $this->db->last_query();
	  		// echo "<pre>";
	  		// print_r($this->data['assets_transfer_data_rec']);
	  		// die();

	  		$this->data['depreciation_report_data']=$this->deprecation_report_mdl->get_depreciation_list_data(array('dete_assetid'=>$asen_asenid),false,false,false,'ASC',false,false); 
	  	}

	  	// echo "<pre>";

	  	// print_r($this->data['lease_data_rec']);

	  	// die();

	  	$this->data['qr_link'] =ASSETS_QR_CODE_URL.'/ams/assets_overview'.'/?assets_code='.$asstscode;

	  	if(!empty($assets_rec_data)){

	  		  $tempform= $this->load->view('assets_overview/v_assets_overview_detail',$this->data,true);

	  	}else{

	  		  $tempform='<p class="alert alert-danger">Record is not availavble</p>';

	  	}

    

      // echo $tempform;die();

      if($tempform)

      {

        print_r(json_encode(array('status'=>'success','tempform'=>$tempform,'message'=>'Successfully Selected!!')));

            exit; 

      }

      else

      {

        $tempform='<span class="text-danger">Record Not Found!!</span>';

        print_r(json_encode(array('status'=>'success','message'=>'Unsuccessfully Selected')));

            exit; 
      }


    }else{

        print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

        exit;

    }

}



	





}

