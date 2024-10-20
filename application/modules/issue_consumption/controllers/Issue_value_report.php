<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Issue_value_report extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('report_issue_mdl');
	}
	public function index()
	{
		$this->data['materialstypecategory']=$this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','DESC');
		$this->data['items']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');

		// echo "<pre>";
		// print_r($this->data['store']);
		// die();

		$this->data['user']=$this->general->get_tbl_data('*','usma_usermain',false,'usma_userid','DESC');
		
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
		
		// $this->template
		// 	->set_layout('general')
		// 	->enable_parser(FALSE)
		// 	->title($this->page_title)
		// 	->build('issue_value_report/v_report_value_issue', $this->data);
		$this->data['issue_report'] = "Issue_by_value";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('issue_report/v_issue_report', $this->data);
	}

	public function search_issue_value()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			if(MODULES_VIEW=='N')
			{
				
 				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}

	      	
	        // echo $temp; die();
			$template=$this->issue_value_common();
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}
	public function issue_value_common()
	{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$this->data['excel_url'] = "issue_consumption/issue_value_report/generate_excel";
		$this->data['pdf_url'] = "issue_consumption/issue_value_report/generate_pdf";
		$this->data['report_title'] = $this->lang->line('issue_by_value');
		$summary = $this->input->post('is_summary');
	      	$Details = $this->input->post('Details');
	      	$storeid = $this->input->post('store_id');
	      	$issue_by = $this->input->post('userid');
	      	$locationid = $this->input->post('locationid');
	      	$userid = $this->input->post('userid');
	      	//echo"<pre>";print_r($this->input->post());die;
	      	
	      	$this->data['fromdate'] = $this->input->post('fromdate');
            $this->data['todate'] = $this->input->post('todate');
          
	      	$this->data['issue_value']=$this->report_issue_mdl->get_issue_value_report();
	        $this->data['return_report']=$this->report_issue_mdl->get_return_report();

	      	//echo"<pre>";print_r($this->data['return_report']);die;
	      	$this->data['selectedstore'] = $storeid;
	      	$this->data['detail'] = $summary;

	      	if($storeid):
	    		$this->data['store_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$storeid));
	    	endif;

	    	if($locationid):
				$this->data['location']=$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$locationid));
			endif;

			if($userid):
				$this->data['user']=$this->general->get_tbl_data('*','usma_usermain',array('usma_userid'=>$userid));
			endif;
      	
	        $template='';
	       		//echo"<pre>"; print_r($this->data['issue_value']);die;
		    if($this->data['issue_value'] || $this->data['return_report'])
		    {
		    	$template=$this->load->view('issue_value_report/v_issue_value_report',$this->data,true);
		    }
		    else
		    {
		        $template='<span class="col-sm-12 alert alert-danger text-center" style="margin-top: -25px;">No Record Found!!!</span>';
		    }
		    return $template;
		   }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}
	public function generate_pdf()
	{	
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //pdf generation
        $html = $this->issue_value_common();   
        $filename = 'issue_value_report_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
        }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function generate_excel()
	{//excel generation
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=issue_analysis_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        $response = $this->issue_value_common();   
        if($response){
        	echo $response;	
        }
        return false;
        }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}
}