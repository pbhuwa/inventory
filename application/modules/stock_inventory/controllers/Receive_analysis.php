<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Receive_analysis extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('receive_analysis_mdl');
		$this->locationid=$this->session->userdata(LOCATION_ID);
		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
	}
	public function index()
	{	
		$this->data['equipmenttype']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','DESC');
		//echo $this->db->last_query();  die;
		$this->data['receive_analysis'] = 'summary';
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
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('receive_analysis/v_current_stock_details_main', $this->data);
	}


//Receive analysis summary start
public function receive_analysis_search()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	        
	        if(MODULES_VIEW=='N')
					{
						print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
					} 

	        $template = $this->receive_analysis_search_common();

	        // echo $temp; die();
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

public function receive_analysis_search_common()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
	      	$this->data['excel_url'] = "stock_inventory/receive_analysis/excel_receive";
			$this->data['pdf_url'] = "stock_inventory/receive_analysis/receive_pdf";
			$this->data['report_title'] = $this->lang->line('receive_summary');	

	      	$this->data['fromdate'] = $this->input->post('fromdate');
        	$this->data['todate'] = $this->input->post('todate');
        	$storeid = $this->input->post('store_id');
	      	$locationid = $this->input->post('locationid');
        	$trma_todepartmentid = $this->input->post('eqty_equipmenttypeid');

        	$srchcol='';

        	if($trma_todepartmentid)
        	{
        		$srchcol = array('mt.trma_todepartmentid'=>$trma_todepartmentid);
        	}
	      	$this->data['purchase']=$this->receive_analysis_mdl->strock_intransaction($srchcol);

	      	$this->data['equipmenttype']=$this->general->get_tbl_data('eqty_equipmenttype,eqty_equipmenttypeid','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$trma_todepartmentid),'eqty_equipmenttypeid','DESC');
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

				//

	        $template='';
		    if($this->data['purchase'])
		    {
		    	$template=$this->load->view('receive_analysis/v_purchase_report',$this->data,true);
		    }
		    else
		    {
		        $template='<span class="col-sm-12 alert alert-danger text-center" style="margin-top: -10px;">No Record Found!!!</span>';
		    }
	        // echo $temp; die();
	        return $template;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }



	}

	public function excel_receive()
	{
		header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_in_transaction_excel_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $response = $this->receive_analysis_search_common();
        if($response){
        	echo $response;	
        }
        return false;
	}

	public function receive_pdf()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$html = $this->receive_analysis_search_common();

			$filename = 'receive_analysis'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4'; //A4-L for landscape

	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,false,$pdfsize);

	        exit();
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}
//receive analysis summary end


	public function dispatch_wise()
	{
		$this->data['equipmenttype']=$this->general->get_tbl_data('eqty_equipmenttype,eqty_equipmenttypeid','eqty_equipmenttype',false,'eqty_equipmenttypeid','DESC');
		$this->data['receive_analysis'] = 'dispatchwise';
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
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('receive_analysis/v_current_stock_details_main', $this->data);
	}

	//dispatch wise search starts
	public function dispatch_wise_search()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			if(MODULES_VIEW=='N')
			{
				
 				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}
	        
	        $template = $this->dispatch_wise_search_common();

	        // echo $temp; die();
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}
	
	public function dispatch_wise_search_common()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
	      	$this->data['excel_url'] = "stock_inventory/receive_analysis/excel_dispatch_wise";
			$this->data['pdf_url'] = "stock_inventory/receive_analysis/dispatch_wise_pdf";
			$this->data['report_title'] = $this->lang->line('dispatch_wise');	

	      	$this->data['fromdate'] = $this->input->post('fromdate');
        	$this->data['todate'] = $this->input->post('todate');
        	//$storeid = $this->input->post('store_id');
	      	$locationid = $this->input->post('locationid');
        	$trma_todepartmentid = $this->input->post('eqty_equipmenttypeid')?$this->input->post('eqty_equipmenttypeid'):$this->input->post('store_id');
        	$srchcol='';
        	if($trma_todepartmentid)
        	{
        		$srchcol = array('mt.trma_todepartmentid'=>$trma_todepartmentid);
        		$this->data['store_type']=$this->general->get_tbl_data('eqty_equipmenttype,eqty_equipmenttypeid','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$trma_todepartmentid));
        	}
        	else{
	    		$this->data['store_type'] = 'All';
	    	}

	      	$this->data['purchase']=$this->receive_analysis_mdl->get_dispatch_wise_search($srchcol);
	      	//echo"<pre>";print_r($this->data['purchase']);die;
	      	$this->data['equipmenttype']=$this->general->get_tbl_data('eqty_equipmenttype,eqty_equipmenttypeid','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$trma_todepartmentid),'eqty_equipmenttypeid','DESC');

	     //  	if($storeid):
	    	// 	$this->data['store_type']=$this->general->get_tbl_data('eqty_equipmenttype,eqty_equipmenttypeid','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$storeid));
	    	// else:
	    	// 	$this->data['store_type'] = 'All';
	    	// endif;

	    	if($locationid):
				$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
			else:
				$this->data['location'] = 'All';
			endif;
	      	//print_r($this->data['equipmenttype']);die;
	        $template='';
		    if($this->data['purchase'])
		    {
		    	$template=$this->load->view('dispatch_wise/v_dispatch_wise_report',$this->data,true);
		    }
		    else
		    {
		        $template='<span class="col-sm-12 alert alert-danger text-center" style="margin-top: -10px;">No Record Found!!!</span>';
		    }
	        // echo $temp; die();
	         return $template;
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function excel_dispatch_wise()
	{
		header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=dispatch_wise_excel_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $response = $this->dispatch_wise_search_common();
        if($response){
        	echo $response;	
        }
        return false;
	}

	public function dispatch_wise_pdf()
	{
		
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$html = $this->dispatch_wise_search_common();

			$filename = 'dispatch_wise'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4'; //A4-L for landscape

	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,false,$pdfsize);

	        exit();
	    }else
	    {
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}
	// dispatch wise search ends
		
	public function item_wise()
	{
		$this->data['equipmenttype']=$this->general->get_tbl_data('eqty_equipmenttype,eqty_equipmenttypeid','eqty_equipmenttype',false,'eqty_equipmenttypeid','DESC');
		$this->data['receive_analysis'] = 'itemwise';
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
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('receive_analysis/v_current_stock_details_main', $this->data);
	}
	//item wise search starts
	public function item_wise_search()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	        if(MODULES_VIEW=='N')
			{
				
 				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}
	        $template = $this->item_wise_search_common();

	        // echo $temp; die();
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}



	public function item_wise_search_common()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	      		
			$this->data['excel_url'] = "stock_inventory/receive_analysis/excel_item_wise";
			$this->data['pdf_url'] = "stock_inventory/receive_analysis/item_wise_pdf";
			$this->data['report_title'] = $this->lang->line('itemwise');	


	      	$this->data['fromdate'] = $this->input->post('fromdate');
        	$this->data['todate'] = $this->input->post('todate');
        	//$storeid = $this->input->post('store_id');
	      	$locationid = $this->input->post('locationid');
        	$trma_todepartmentid = $this->input->post('eqty_equipmenttypeid')?$this->input->post('eqty_equipmenttypeid'):$this->input->post('store_id');
        	$srchcol='';$cond="";
        	if($trma_todepartmentid)
        	{
        		$srchcol = array('mt.trma_todepartmentid'=>$trma_todepartmentid);
        		$cond = 'AND mt.trma_todepartmentid ='. "$trma_todepartmentid";
        		$this->data['store_type']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$trma_todepartmentid));
        	}
        	else{
        		$this->data['store_type'] = 'All';
        	}
        	$this->data['items'] = $this->receive_analysis_mdl->get_items_only($cond);

	      	$this->data['purchase']=$this->receive_analysis_mdl->get_item_wise_search($srchcol);
	      	//echo"<pre>";print_r($this->data['items']);die;
	      	$this->data['equipmenttype']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$trma_todepartmentid),'eqty_equipmenttypeid','DESC');
	      	//echo"<pre>";print_r($this->data['purchase']);die;
	     //  	if($storeid):
	    	// 	$this->data['store_type']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$storeid));
	    	// else:
	    	// 	$this->data['store_type'] = 'All';
	    	// endif;

	    	if($locationid):
				$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
			else:
				$this->data['location'] = 'All';
			endif;

			//echo $this->db->last_query(); die;
	        $template='';
		    if($this->data['purchase'])
		    {
		    	$template=$this->load->view('dispatch_wise/v_item_wise_report',$this->data,true);
		    }
		    else
		    {
		        $template='<span class="col-sm-12 alert alert-danger text-center" style="margin-top: -10px;">No Record Found!!!</span>';
		    }
	        // echo $temp; die();
	        return $template;
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}


	public function excel_item_wise()
	{
		header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=item_wise_excel_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
         $response = $this->item_wise_search_common();
        if($response){
        	echo $response;	
        }
        return false;
	}


	public function item_wise_pdf()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$html = $this->item_wise_search_common();
			//echo $this->db->last_query(); die;
			$filename = 'itemwise'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4'; //A4-L for landscape

	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,false,$pdfsize);

	        exit();
	    }else
	    {
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}
	//item wise search ends		
}