<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assets_sales_desposal extends CI_Controller

{

	function __construct()

	{

			

		parent::__construct();

		

		$this->load->Model('assets_sales_desposal_mdl');

		$this->load->library('upload');

		$this->load->library('image_lib');

		$this->load->helper('file');

		$this->load->helper('form');   



	}

  

	

	public function index()  

	{   

		//echo "aa";die;  

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

		$this->data['breadcrumb']='Assets Maintenance';



		$this->data['tab_type']="entry";

		$this->page_title='Work Order Entry';

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('assets_sales_desposal/v_assets_sales_desposal_common', $this->data);



	}



	public function entry($reload=false)

	{

		//echo "aa";die;

		$locationid=$this->session->userdata(LOCATION_ID);

		$currentfyrs=CUR_FISCALYEAR;





		$cur_fiscalyrs_invoiceno=$this->db->select('prin_code,prin_fiscalyrs')

									->from('prin_projectinfo')

									->where('prin_locationid',$locationid)

									// ->where('prin_fiscalyrs',$currentfyrs)

									->order_by('prin_fiscalyrs','DESC')

									->limit(1)

									->get()->row();



		// echo "<pre>";

		// print_r($cur_fiscalyrs_invoiceno);

		// die();



		if(!empty($cur_fiscalyrs_invoiceno)){

			$invoice_format=$cur_fiscalyrs_invoiceno->prin_code;

			

			$invoice_string=str_split($invoice_format);

			// echo "<pre>";

			// print_r($invoice_string);

			// die();

			$invoice_prefix_len=strlen(ASSET_DISPOSAL_NO_PREFIX);

			$chk_first_string_after_invoice_prefix=!empty($invoice_string[$invoice_prefix_len])?$invoice_string[$invoice_prefix_len]:'';

			// echo $chk_first_string_after_invoice_prefix;

			// die();

			if($chk_first_string_after_invoice_prefix =='0'){

				$invoice_no_prefix=ASSET_DISPOSAL_NO_PREFIX.CUR_FISCALYEAR;

			}

			else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs==$currentfyrs && $chk_first_string_after_invoice_prefix =='0' ) {

				$invoice_no_prefix=ASSET_DISPOSAL_NO_PREFIX.CUR_FISCALYEAR;

			}

			else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs!=$currentfyrs && $chk_first_string_after_invoice_prefix =='0' ) {

				$invoice_no_prefix=ASSET_DISPOSAL_NO_PREFIX.CUR_FISCALYEAR;

			}

			else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs!=$currentfyrs && $chk_first_string_after_invoice_prefix !='0' ) {

				$invoice_no_prefix=ASSET_DISPOSAL_NO_PREFIX.CUR_FISCALYEAR;

			}

			else{

				$invoice_no_prefix=ASSET_DISPOSAL_NO_PREFIX;

			}

			

		}

		else{

			$invoice_no_prefix=ASSET_DISPOSAL_NO_PREFIX.CUR_FISCALYEAR;

		}

		// die();





		



		$this->data['disposal_code'] = $this->general->generate_invoiceno('asde_disposalno','asde_disposalno','asde_assetdesposalmaster',$invoice_no_prefix,ASSET_DISPOSAL_NO_LENGTH,false,'asde_locationid');



		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC',16);

		$this->data['distributor']=$this->general->get_tbl_data('*','dist_distributors',array('dist_isactive'=>'Y'),'dist_distributor','ASC');

		$this->data['desposaltype']=$this->general->get_tbl_data('*','dety_desposaltype',array('dety_isactive'=>'Y'),'dety_detyid','ASC');





		// echo "<pre>";

		// print_r($this->data);

		// die();

		if($reload=='reload'){



			$this->load->view('assets_sales_desposal/v_assets_sales_desposal_form',$this->data);

		}else{

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

			$this->data['breadcrumb']='Sales/Disposal Entry';



			$this->data['tab_type']="entry";



			$this->session->unset_userdata('id');

			$this->page_title='Assets Assets';

			$this->template

				->set_layout('general')

				->enable_parser(FALSE)

				->title($this->page_title)

				->build('assets_sales_desposal/v_assets_sales_desposal_common', $this->data);

		}



		



	}



	public function summary()

	{

		// $frmDate = CURMONTH_DAY1;

		// $toDate = CURDATE_NP;

		$this->data['desposaltype']=$this->general->get_tbl_data('*','dety_desposaltype',array('dety_isactive'=>'Y'),'dety_detyid','ASC');



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

		$this->data['breadcrumb']='Sales/Disposal Summary';



		$this->data['tab_type']="summary";



		$this->session->unset_userdata('id');

		$this->page_title='Sales/Disposal Summary';

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('assets_sales_desposal/v_assets_sales_desposal_common', $this->data);



	}



	public function detail()

	{

		$this->data['desposaltype']=$this->general->get_tbl_data('*','dety_desposaltype',array('dety_isactive'=>'Y'),'dety_detyid','ASC');

		$this->data['department_list']=$this->general->get_tbl_data('dept_depid,dept_depname','dept_department',array('dept_isactive'=>'Y'),'dept_depid','ASC');

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

		$this->data['breadcrumb']='Sales/Disposal Detail';



		$this->data['tab_type']="detail";



		$this->session->unset_userdata('id');

		$this->page_title='Sales/Disposal Detail';

		$this->template

			->set_layout('general') 

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('assets_sales_desposal/v_assets_sales_desposal_common', $this->data);





	}





	public function save_sales_desposal($print=false){

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		try {


			if($this->input->post('id'))

			{

				if(MODULES_UPDATE=='N')

				{

					$this->general->permission_denial_message();

					exit;

				}



				$action_log_message = "edit";

			}

			else

			{

				if(MODULES_INSERT=='N')

				{

					$this->general->permission_denial_message();

					exit;

				}

				$action_log_message = "";

			}



			$this->form_validation->set_rules($this->assets_sales_desposal_mdl->validate_settings_assets_desposal);

			if($this->form_validation->run()==TRUE)

			{  

			$trans = $this->assets_sales_desposal_mdl->sales_desposal_assets_save();

			if($trans){		

				if($print == "print")

				{	



				$print_report='';

				

				print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully.', 'print_report'=>$print_report)));

				exit;

				}

				print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully.')));

				exit;

			}

			else{

				print_r(json_encode(array('status'=>'error','message'=>'Unsuccessful Operation.')));

				exit;

			}

	}

	else

	{

		print_r(json_encode(array('status'=>'error','message'=>validation_errors())));

		exit;

	}

} catch (Exception $e) {

	print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));

 }

}else{

	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	exit;

 }



}



public function get_summary_list()

{

	if(MODULES_VIEW=='N'){

		$array=array();

		echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			

		exit;

	}

	$useraccess= $this->session->userdata(USER_ACCESS_TYPE);

	$i = 0;



	$data = $this->assets_sales_desposal_mdl->get_sales_disposal_summary_list(false);

	$array = array();

	$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);

	$totalrecs = $data["totalrecs"];

	unset($data["totalfilteredrecs"]);

	unset($data["totalrecs"]);



	foreach($data as $row) 

	{	

		$array[$i]['id'] = $row->asde_assetdesposalmasterid;

		$array[$i]['datead']=$row->asde_desposaldatead;

		$array[$i]['datebs']=$row->asde_deposaldatebs;  

		$array[$i]['disposal_type']=$row->dety_name;

		$array[$i]['disposal_no']=$row->asde_disposalno;	

		$array[$i]['customer_name']=$row->asde_customer_name;

		$array[$i]['grand_total']=$row->asdd_sales_totalamt;

		$array[$i]['original_cost']=$row->asdd_originalvalue;

		$array[$i]['current_cost']=$row->asdd_currentvalue;

		$array[$i]['sales_cost']=$row->asdd_sales_amount;  



		$array[$i]['action']='<a href="javascript:void(0)" class="view" data-id='.$row->asde_assetdesposalmasterid.' title="View" data-viewurl="'.base_url("/ams/assets_sales_desposal/show_summary_view").'" title="Sales/Desposal Summary View" data-heading="Sales/Desposal Summary View"><i class="fa fa-eye"></i></a>&nbsp;

		'; 

		$array[$i]['viewurl']=base_url().'issue_consumption/stock_requisition';

		$i++;

	}

	$get = $_GET;

	echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

}



public function get_detail_list()

{

	if(MODULES_VIEW=='N'){

		$array=array();

		echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			

		exit;

	}

	$useraccess= $this->session->userdata(USER_ACCESS_TYPE);

	$i = 0;



	$data = $this->assets_sales_desposal_mdl->get_sales_disposal_detail_list(false);

	$array = array();

	$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);

	$totalrecs = $data["totalrecs"];

	unset($data["totalfilteredrecs"]);

	unset($data["totalrecs"]);



	foreach($data as $row) 

	{	

		$array[$i]['id'] = $row->asde_assetdesposalmasterid;

		$array[$i]['asset_code']=$row->asen_assetcode;

		$array[$i]['asset_description']=$row->asen_description;  

		$array[$i]['department_name']=$row->dept_depname;

		$array[$i]['room_no']=$row->asen_room;	 

		$array[$i]['original_cost']=$row->asdd_originalvalue;

		$array[$i]['current_cost']=$row->asdd_currentvalue;

		$array[$i]['sales_cost']=$row->asdd_sales_amount;  

		$array[$i]['remarks']=$row->asdd_remarks;  

		$array[$i]['action']=''; 

		// $array[$i]['action']='<a href="javascript:void(0)" class="view" data-id='.$row->asde_assetdesposalmasterid.' title="View" data-viewurl="'.base_url("/ams/assets_sales_desposal/show_summary_view").'" title="Sales/Desposal Summary View" data-heading="Sales/Desposal Summary View"><i class="fa fa-eye"></i></a>&nbsp;

		// '; 

		$array[$i]['viewurl']=base_url().'issue_consumption/stock_requisition';

		$i++;

	}

	$get = $_GET;

	echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

}





public function show_summary_view()

{

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$id = $this->input->post('id');

		if($id)

		{ 

			$this->data['sales_disposal_master']=$this->assets_sales_desposal_mdl->get_sales_desposal_master_data(array('asde.asde_assetdesposalmasterid'=>$id));



			$template='';

			if($this->data['sales_disposal_master']>0)

			{

			$this->data['sales_disposal_detail'] =  $this->assets_sales_desposal_mdl->get_sales_desposal_detail_data(array('asdd.asdd_assetdesposalmasterid'=>$id));

 

			$template=$this->load->view('assets_sales_desposal/v_assets_sales_desposal_summary_view',$this->data,true);

			

			print_r(json_encode(array('status'=>'success','message'=>'','tempform'=>$template)));

				exit;

			}

			else{

				print_r(json_encode(array('status'=>'error','message'=>'')));

				exit;

			}

			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','tempform'=>$template)));

			exit;	

		}

	}

	else

	{

		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

		exit;

	}

}



//** ============================================================================================== ==================================== Export to Excel and Pdf =================================== */ 



public function excel_export_summary()

{

	header("Content-Type: application/xls");    

        header("Content-Disposition: attachment; filename=sales_disposal_summary".date('Y_m_d_H_i').".xls");  

        header("Pragma: no-cache"); 

        header("Expires: 0");



        // $data = $this->assets_sales_desposal_mdl->get_sales_disposal_summary_list(false);



        $this->data['searchResult'] = $this->assets_sales_desposal_mdl->get_sales_disposal_summary_list(false);

        

        $array = array();

        unset($this->data['searchResult']['totalfilteredrecs']);

        unset($this->data['searchResult']['totalrecs']);

        $response = $this->load->view('assets_sales_desposal/v_assets_sales_desposal_summary_download', $this->data, true);



        echo $response;

	}



	public function pdf_export_summary()

	{

		$this->data['searchResult'] = $this->assets_sales_desposal_mdl->get_sales_disposal_summary_list(false);

        unset($this->data['searchResult']['totalfilteredrecs']);

        unset($this->data['searchResult']['totalrecs']);



        $html = $this->load->view('assets_sales_desposal/v_assets_sales_desposal_summary_download', $this->data, true);

      	$filename = 'sales_disposal_summary'. date('Y_m_d_H_i_s') . '_.pdf'; 

        $pdfsize = 'A4-L'; //A4-L for landscape

        //if save and download with default filename, send $filename as parameter

        $this->general->generate_pdf($html,false,$pdfsize);

        exit();

	}

public function excel_export_detail()

{

	header("Content-Type: application/xls");    

        header("Content-Disposition: attachment; filename=sales_disposal_detail".date('Y_m_d_H_i').".xls");  

        header("Pragma: no-cache"); 

        header("Expires: 0");



        // $data = $this->assets_sales_desposal_mdl->get_sales_disposal_detail_list(false);



        $this->data['searchResult'] = $this->assets_sales_desposal_mdl->get_sales_disposal_detail_list(false);

        

        $array = array();

        unset($this->data['searchResult']['totalfilteredrecs']);

        unset($this->data['searchResult']['totalrecs']);

        $response = $this->load->view('assets_sales_desposal/v_assets_sales_desposal_detail_download', $this->data, true);



        echo $response;

	}



	public function pdf_export_detail()

	{

		$this->data['searchResult'] = $this->assets_sales_desposal_mdl->get_sales_disposal_detail_list(false);

        unset($this->data['searchResult']['totalfilteredrecs']);

        unset($this->data['searchResult']['totalrecs']);



        $html = $this->load->view('assets_sales_desposal/v_assets_sales_desposal_detail_download', $this->data, true);

      	$filename = 'sales_disposal_detail'. date('Y_m_d_H_i_s') . '_.pdf'; 

        $pdfsize = 'A4-L'; //A4-L for landscape

        //if save and download with default filename, send $filename as parameter

        $this->general->generate_pdf($html,false,$pdfsize);

        exit();

	}





}

