<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Transfer_analysis extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('transfer_analysis_mdl');
	}
	public function index()
	{	
		$this->data['equipmenttype']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','DESC');
		$this->data['transfer_analysis'] = 'summary';
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
			->build('transfer_analysis/v_current_stock_details_main', $this->data);
	}



	public function transfer_analysis_search()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			if(MODULES_VIEW=='N')
			{
				
 				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}
	        
	        $template = $this->transfer_analysis_search_common();

	        // echo $temp; die();
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function transfer_analysis_search_common()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
	      	$this->data['excel_url'] = "stock_inventory/transfer_analysis/excel_transfer";
			$this->data['pdf_url'] = "stock_inventory/transfer_analysis/transfer_pdf";
			$this->data['report_title'] = $this->lang->line('transfer_analysis_summary');

	      	$this->data['fromdate'] = $this->input->post('fromdate');
        	$this->data['todate'] = $this->input->post('todate');
        	$storeid = $this->input->post('store_id');
	      	$locationid = $this->input->post('locationid');
        	$trma_todepartmentid = $this->input->post('eqty_equipmenttypeid');


        	$srchcol='';
        	if($storeid)
        	{
        		$srchcol .= "AND mt.trma_fromdepartmentid ='$storeid'";
        	}

        		if($locationid)
        	{
        		$srchcol .= "AND mt.trma_locationid='$locationid'";

	      	
	      }

	      	$this->data['summary']=$this->transfer_analysis_mdl->summary($srchcol);
	      	// echo "<pre>";
	      	// echo $this->db->last_query();
	      	// die();


	      	$this->data['equipmenttype']=$this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$trma_todepartmentid),'eqty_equipmenttypeid','DESC');
	      	//echo"<pre>";print_r($this->data['summary']);die;

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

	        $template='';
		    if($this->data['summary'])
		    {
		    	$template=$this->load->view('transfer_analysis/v_summary_report',$this->data,true);
		    }
		    else
		    {
		        $template='<span class="col-sm-12 alert alert-danger text-center" >No Record Found!!!</span>';
		    }
	        // echo $temp; die();
	        return $template;
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}







	public function excel_transfer()
	{
		header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_in_transaction_excel_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
         header("Expires: 0");
         $response = $this->transfer_analysis_search_common();
        if($response){
        	echo $response;	
        }
        return false;
	}




	public function transfer_pdf()
	{
		 $page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$html = $this->transfer_analysis_search_common();

			$filename = 'summary'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4'; //A4-L for landscape

	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,false,$pdfsize,$page_size);

	        exit();
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function item_wise_summary()
	{
		$this->data['equipmenttype']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','DESC');
		$this->data['transfer_analysis'] = 'itemwisesummary';
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
			->build('transfer_analysis/v_current_stock_details_main', $this->data);
	}





	public function item_wise_summary_search()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
	        if(MODULES_VIEW=='N')
			{
				
 				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}
	        $template = $this->item_wise_summary_search_common();

	        // echo $temp; die();
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function item_wise_summary_search_common()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
	     	$this->data['excel_url'] = "stock_inventory/transfer_analysis/excel_item_wise_summary";
			$this->data['pdf_url'] = "stock_inventory/transfer_analysis/item_wise_summary_pdf";
			$this->data['report_title'] = $this->lang->line('item_wise_transfer_analysis_summary');

	      	$this->data['fromdate'] = $this->input->post('fromdate');
        	$this->data['todate'] = $this->input->post('todate');
        	$storeid = $this->input->post('store_id');
	      	$locationid = $this->input->post('locationid');

	      	// print_r($locationid);
	      	// die();

        	$trma_todepartmentid = $this->input->post('eqty_equipmenttypeid');
        	$cond='';
        	if($trma_todepartmentid)
        	{
        		$cond = 'AND mt.trma_todepartmentid ='. "$trma_todepartmentid";
        	}
        
        	if($locationid)
        	{
        		$cond .= "AND mt.trma_locationid='$locationid'";

	      	
	      }
	      $this->data['purchase']=$this->transfer_analysis_mdl->get_summaries_wise_search($cond);



	      	$this->data['equipmenttype']=$this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$trma_todepartmentid),'eqty_equipmenttypeid','DESC');
	      	// echo"<pre>";print_r($this->data['purchase']);die;

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



	        $template='';
		    if($this->data['purchase'])
		    {
		    	$template=$this->load->view('transfer_analysis/v_itemwise_summary_report',$this->data,true);
		    }
		    else
		    {
		        $template='<span class="col-sm-12 alert alert-danger text-center" >No Record Found!!!</span>';
		    }
	        // echo $temp; die();
	         return $template;
	      	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}




	public function excel_item_wise_summary()
	{
		header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=item_wise_summary_excel_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
         $response = $this->item_wise_summary_search_common();
        if($response){
        	echo $response;	
        }
        return false;
	}




	public function item_wise_summary_pdf()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$html = $this->item_wise_summary_search_common();

			$filename = 'item_wise'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4'; //A4-L for landscape

	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,false,$pdfsize);

	        exit();
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}




	public function item_wise()
	{
		$this->data['equipmenttype']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','DESC');
		
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
		
		$this->data['transfer_analysis'] = 'itemwise';
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('transfer_analysis/v_current_stock_details_main', $this->data);
	}




	public function item_wise_search()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			if(MODULES_VIEW=='N')
			{
				
 				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}
	        
	        $template = $this->item_wise_search_commom();

	        // echo $temp; die();
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}


	public function item_wise_search_commom()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			$this->data['excel_url'] = "stock_inventory/transfer_analysis/excel_item_wise";
			$this->data['pdf_url'] = "stock_inventory/transfer_analysis/item_wise_pdf";
			$this->data['report_title'] = $this->lang->line('item_wise_transfer_analysis');
	      	
	      	$this->data['fromdate'] = $this->input->post('fromdate');
        	$this->data['todate'] = $this->input->post('todate');
        	$storeid = $this->input->post('store_id');

	      	$locationid = $this->input->post('locationid');

        	$trma_todepartmentid = $this->input->post('eqty_equipmenttypeid');
        	$srchcol='';$cond="";
        	if($trma_todepartmentid)
        	{
        		$srchcol = array('mt.trma_fromdepartmentid'=>$trma_todepartmentid);
        		//$cond = 'AND mt.trma_todepartmentid ='. "$trma_todepartmentid";
        	}
        		//$this->data['items'] = $this->transfer_analysis_mdl->get_items_only($cond);
	      	$this->data['purchase']=$this->transfer_analysis_mdl->get_item_wise_search($srchcol);
	      	//echo"<pre>";print_r($this->data['purchase']);die;
	      	$this->data['equipmenttype']=$this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$trma_todepartmentid),'eqty_equipmenttypeid','DESC');
	      	//echo"<pre>";print_r($this->data['purchase']);die;

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

	        $template='';
		    if($this->data['purchase'])
		    {
		    	$template=$this->load->view('transfer_analysis/v_item_wise_report',$this->data,true);
		    }
		    else
		    {
		        $template='<span class="col-sm-12 alert alert-danger text-center" >No Record Found!!!</span>';
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
         $response = $this->item_wise_search_commom();
        if($response){
        	echo $response;	
        }
        return false;



	}
	public function item_wise_pdf()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$html = $this->item_wise_search_commom();

			$filename = 'item_wise'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4'; //A4-L for landscape

	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,false,$pdfsize);

	        exit();
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }
}