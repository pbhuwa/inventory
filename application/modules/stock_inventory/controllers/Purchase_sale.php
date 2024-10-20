<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_sale extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('purchase_sale_mdl');
	}
	public function index()
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
		
		$this->data['tab']="purchase";


		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			// ->build('purchase_sale/v_purchase_sale', $this->data);
			->build('purchase_sale/v_common_purchasesales_tab', $this->data);
	}

	public function issue_display()
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
		
		$this->data['tab']="issue";


		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			// ->build('purchase_sale/v_purchase_sale', $this->data);
			->build('purchase_sale/v_common_purchasesales_tab', $this->data);
	}

	public function purchase_search()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			if(MODULES_VIEW=='N')
			{
				
 				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}

	      	
	      	$template = $this->purchase_report_common();

	        
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function purchase_report_common()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			$this->data['excel_url'] = "stock_inventory/purchase_sale/excel_purchase";
			$this->data['pdf_url'] = "stock_inventory/purchase_sale/purchase_pdf";
			$this->data['report_title'] = $this->lang->line('purchase_report');


			$this->data['fromdate'] = $this->input->post('fromdate');
        	$this->data['todate'] = $this->input->post('todate');
			$locationid = $this->input->post('locationid');

			$srchcol='';
			$cond='';
			
        	if($locationid)
        	{
        		$srchcol = " AND pr.purr_locationid='$locationid'";
        		$cond = " AND recm_locationid ='$locationid'";

	      }

	     

	      	$this->data['purchase']=$this->purchase_sale_mdl->purchase_report($srchcol,$cond);
        	
	      	

	      	if($locationid):
				$this->data['location']=$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$locationid));
			else:
				$this->data['location'] = 'All';
			endif;

			if($this->data['purchase'])
			{
				$html = $this->load->view('purchase_sale/v_purchase_report',$this->data,true);
			}else{
				$html='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
			}
			
			return $html;
		}
		else
		{
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	    	exit;
	    }
	    
	}
	public function excel_purchase()
	{
		header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=issue_report_excel_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

         $response = $this->purchase_report_common();
        if($response){
        	echo $response;	
        }
        return false;


        echo $response;
	}
	public function purchase_pdf()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$html = $this->purchase_report_common();

			$filename = 'purchase_report'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4'; //A4-L for landscape

	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,false,$pdfsize);

	        exit();
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}


	public function issue_search()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
	      	if(MODULES_VIEW=='N')
			{
				
 				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}

	      	$template = $this->issue_report_common();

	        // echo $temp; die();
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function issue_report_common()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			$this->data['excel_url'] = "stock_inventory/purchase_sale/excel_issue";
			$this->data['pdf_url'] = "stock_inventory/purchase_sale/issue_pdf";
			$this->data['report_title'] = $this->lang->line('issue_report');


			$this->data['fromdate'] = $this->input->post('fromdate');
        	$this->data['todate'] = $this->input->post('todate');
			$locationid = $this->input->post('locationid');

			$srchcol='';
			$cond='';
			
        	if($locationid)
        	{
        		$srchcol .= "AND rm.rema_locationid='$locationid'";
        		$cond = " AND sama_locationid ='$locationid'";
	      	
	      }

	      // if($cond)
       //  	{
       //  		$srchcol .= "AND rm.rema_locationid='$locationid'";

	      	
	      // }


	      	$this->data['purchase']=$this->purchase_sale_mdl->issue_report($srchcol,$cond);
        	
	      	

	      	if($locationid):
				$this->data['location']=$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$locationid));
			else:
				$this->data['location'] = 'All';
			endif;

			if($this->data['purchase'])
			{
				$html = $this->load->view('purchase_sale/v_issue_report_download',$this->data,true);
			}else{
				$html='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
			}
			
			return $html;
		}
		else
		{
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	    	exit;
	    }
	    
	}

	public function excel_issue()
	{
		header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=issue_report_excel_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

         $response = $this->issue_report_common();
        if($response){
        	echo $response;	
        }
        return false;


        echo $response;
	}
	public function issue_pdf()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$html = $this->issue_report_common();

			$filename = 'issue_report'. date('Y_m_d_H_i_s') . '_.pdf'; 
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