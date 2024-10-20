<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Assets_maintenance_log extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		//$this->load->Model('bio_medical_mdl');
		$this->load->Model('Assets_maintenance_mdl');
		$this->load->Model('settings/department_mdl','department_mdl');
		$this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        $this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->helper('file');
		$this->load->helper('form');
		$this->load->library('ciqrcode');

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
		$this->data['breadcrumb']=$this->lang->line('maintenance_logs');

		$this->data['tab_type']="Log";

		$this->session->unset_userdata('id');
		$this->page_title='Assets Assets';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('assets/v_assets_common', $this->data);

		// $this->template
		// 	->set_layout('general')
		// 	->enable_parser(FALSE)
		// 	->title($this->page_title)
		// 	->build('assets_maintenance_log/v_assets_maintenance_log', $this->data);
	}

	public function actual_mlog()
	{
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
		$this->data['breadcrumb']=$this->lang->line('maintenance_logs');
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('assets_maintenance_log/v_assets_maintenance_log_list_bck', $this->data);
	}
	public function search_result()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	      	
	        $template='';
	      	$this->data['fromdate'] = $this->input->post('fromdate');
        	$this->data['todate'] = $this->input->post('todate');
        	$srchcol='';
	      	$this->data['mlog_report']=$this->Assets_maintenance_mdl->get_mlog_report($srchcol);

		    if($this->data['mlog_report'])
		    {
		    	$template=$this->load->view('assets_maintenance_log/v_assets_maintenance_log_list_bck',$this->data,true);
		    }
		    else
		    {
		        $template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
		    }
	        // echo $temp; die();
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

  	public function get_mlog_summary()
    {   
     	$data = $this->Assets_maintenance_mdl->get_all_mlog_summary();
		//print_r($data);die;
    	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  	foreach($data as $row)
		    {
		    	  //$array[$i]["equipid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->amta_amctableid.'>'.$row->amta_amctableid.'</a>';
			   
		    	$array[$i]["equipid"] = $row->malo_equipid;	
			    $array[$i]["equipmentkey"] = $row->bmin_equipmentkey;
			    $array[$i]["equidesc"] = $row->eqli_description;
			 	$array[$i]["department"] = $row->dept_depname;
			 	$array[$i]["room"] = $row->rode_roomname;
			    $array[$i]["problem"] = $row->malo_comment;
			    $array[$i]["solution"] = $row->malo_remark;
			    $array[$i]["maintained_by"] = $row->usma_username;
			    $array[$i]["posted_time"] = $row->malo_posttime;
			    $array[$i]["posted_date"] = $row->malo_postdatebs;
			    // $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->amta_equipid.' data-displaydiv="displyblock" data-viewurl='.base_url('biomedical/amc_data/amc_summary_view').' class="view" data-heading="AMC Summmary " ><i class="fa fa-eye" aria-hidden="true" ></i></a>';
			    
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
    } 


    public function search_mlog()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
		  	$html = $this->search_mlog_common();
		  	
		  	if($html)
		  	{
		  		$template=$html;
		  	}
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function search_mlog_common()
	{
		$this->data['excel_url'] = "ams/assets_maintenance_log/search_mlog_excel";
		$this->data['pdf_url'] = "ams/assets_maintenance_log/search_mlog_pdf";
		$this->data['report_title'] = $this->lang->line('assets_maintenance_logs');

		$this->data['searchResult'] = $this->Assets_maintenance_mdl->get_all_mlog();
		
		$this->data['fromdate'] = $this->input->post('fromdate');
    	$this->data['todate'] = $this->input->post('todate');
		
		unset($this->data['searchResult']["totalfilteredrecs"]);
		unset($this->data['searchResult']["totalrecs"]);
		
		$html = $this->load->view('assets_maintenance_log/v_assets_maintenance_log_report', $this->data, true);
        return $html;
	}

	public function search_mlog_excel()
	{	
		header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=assets_maintenance_log_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
	    $response = $this->search_mlog_common();
	    if($response){
        	echo $response;	
        }
        return false;
	}
	
	public function search_mlog_pdf()
	{	
		$html = $this->search_mlog_common();
		
        $filename = 'assets_maintenance_log_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4'; 
        $this->general->generate_pdf($html,false,$pdfsize);
	}


}
