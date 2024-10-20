<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Consumption_report extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('consumption_report_mdl');
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
		
		$this->data['tab']='consumption';
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			// ->build('consumption/v_consumption', $this->data);
			->build('consumption/v_common_consumption_tab', $this->data);
	}

	public function current_stock_details()
	{
		$this->data['materialstypecategory']=$this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','DESC');
		$this->data['items']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
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
		$this->data['tab']='current_stock';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			// ->build('consumption/v_consumption', $this->data);
			->build('consumption/v_common_consumption_tab', $this->data);
	}
	

	/* search consumption detail start */
	public function search_common_current_stock()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			
			$this->data=array();
		$store_id = $this->input->post('store_id');
      	$locationid = $this->input->post('locationid');
      	$srchcol = "";
      	if($store_id): /* Query Incorrect */
      		// $srchcol = array('s.sama_stdepid'=>$store_id);
      		$this->data['store_type']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$store_id));
	    	else:
	    		$this->data['store_type'] = 'All';
	    	endif;


      	if($locationid):
				$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
			else:
				$this->data['location'] = 'All';
			endif;
			$this->data['fromdate'] = $this->input->post('fromdate');
	        $this->data['todate'] = $this->input->post('todate');
	      	$this->data['current_stock']=$this->consumption_report_mdl->get_current_stock_report($srchcol);
	      	$this->data['excel_url'] = "issue_consumption/consumption_report/search_current_stock_excel";
			$this->data['pdf_url'] = "issue_consumption/consumption_report/search_current_stock_pdf";
			$this->data['report_title'] = $this->lang->line('consumption_detail');
      	//echo $this->db->last_query();die;
      	//print_r($this->data['current_stock']);die;
	    if($this->data['current_stock'])
	    {
	    	$html=$this->load->view('consumption/v_current_stock_report_temp',$this->data,$this->data['pdf_url'],true);
	    	//print_r($html);die;
	    }
	    else
	    {
	        $html='<span class="col-sm-12 alert alert-danger text-center" style="margin-top: -25px;">No Record Found!!!</span>';
	    }
	    //print_r($html);die;
	   	return $html;
	   }else{
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	    	exit;
	    }
	   
	}
	public function search_current_stock()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_VIEW=='N')
			{
				$array=array();
				
 				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}	
			$html = $this->search_common_current_stock();
			///print_r($html);die;
		    if($html)
		    {
		    	$template = $html;
		    }
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }
	    else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}
	public function search_current_stock_pdf()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	      	
	    	//echo $this->db->last_query();die();
	        $html = $this->search_common_current_stock();

	        $filename = 'current_stock_details_'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4'; //A4-L for landscape
	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,false,$pdfsize);

	        	        exit();
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}
	public function search_current_stock_excel()
	{
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=consumption_report_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        
        $response = $this->search_common_current_stock();
        if($response){
        	echo $response;	
        }
        return false;
	}
	/* search consumption detail end */
	//consumption report
	public function search_consumption()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	        if(MODULES_VIEW=='N')
			{
				$array=array();
				
 				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}	
	        $template = $this->get_consumption_report_data();

	        // echo $temp; die();
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function search_consumption_pdf()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$html = $this->get_consumption_report_data();
			$filename = 'consumption_report_'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4'; //A4-L for landscape
	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,false,$pdfsize);
	        exit();
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function generate_consumption_excel()
	{
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=consumption_report_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        
        $response = $this->get_consumption_report_data();
        if($response){
        	echo $response;	
        }
        return false;
	}

	public function get_consumption_report_data(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->data['excel_url'] = "issue_consumption/consumption_report/generate_consumption_excel";
			$this->data['pdf_url'] = "issue_consumption/consumption_report/search_consumption_pdf";
			$this->data['report_title'] = $this->lang->line('consumption_report');

	      	$storeid = $this->input->post('store_id');
	      	$locationid = $this->input->post('locationid');
	      	
	      	$this->data['fromdate'] = $this->input->post('fromdate');
	        $this->data['todate'] = $this->input->post('todate');

	      	$this->data['consumption']=$this->consumption_report_mdl->get_issue_consumption_report();

	      	if($storeid):
	    		$this->data['store_type']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$storeid));
	    	else:
	    		$this->data['store_type'] = 'All';
	    	endif;

	    	if($locationid):
				$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
			else:
				$this->data['location'] = 'All';
			endif;

			if($this->data['consumption']){
				$html = $this->load->view('consumption/v_consumption_report_temp',$this->data,true);
			}else{
				$html='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
			}
			
			return $html;
		}else{
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	    	exit;
	    }
	}
}