<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Change_supplier extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->Model('change_supplier_mdl');
		$this->load->Model('biomedical/distributors_mdl');
	}
	public function index()
    {
    	$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear');
    	$this->data['distributor_list']=$this->distributors_mdl->get_distributor_list(false,false,false,false,'dist_distributor','ASC');
    	// echo "<pre>";
    	// print_r($this->data['distributor_list']);
    	// die();


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
		// 	->build('change_supplier/v_change_supplier_main', $this->data);
		$this->data['tab_type']='change_supplier';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('purchase_receive/pending_order_detail/v_pending_common', $this->data);
	}

	public function checkinovice()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
				$invoicedata=$this->change_supplier_mdl->invoice_no_check();
				// echo "<pre>";
				// print_r($invoicedata);
				// die();
				if($invoicedata)
				{
					$purchasemasterid=$invoicedata->recm_purchaseordermasterid;
					if($purchasemasterid<>0)
					{
						  print_r(json_encode(array('status'=>'error','message' => 'Received via an order cannot be modified')));
					}
					else
					{
						 print_r(json_encode(array('status'=>'success','data'=>$invoicedata, 'message' => 'Selected Successfully')));
					}
				}
				else
				{
					 print_r(json_encode(array('status'=>'error', 'message' => 'Invalid Receipt No.')));

				}
			} catch (Exception $e) {
	            print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
	        }
	    }else
	    {
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	            exit;
	    }
	}

	public function save_change_supplier()
	{ 
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
				
				$invoicedata=$this->change_supplier_mdl->invoice_no_check();
				// echo "<pre>";
				// print_r($invoicedata);
				// die();
				if($invoicedata)
				{

				$this->form_validation->set_rules($this->change_supplier_mdl->validate_settings_change_supplier);
				if($this->form_validation->run()==TRUE)
				{
	            	$trans = $this->change_supplier_mdl->change_supplier_save();
		            if($trans)
		            {
		            	  print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
		            	exit;
		            }
		            else
		            {
		            	 print_r(json_encode(array('status'=>'error','message'=>'Unable To Save ')));
		            	exit;
		            }
	        	}
		        else
		        {
		        	print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
		        	exit;
		        }
			}else
	        	{
	        		 print_r(json_encode(array('status'=>'error', 'message' => 'Invalid Receipt No.')));
	        	}
	        
	        } catch (Exception $e) {
	            print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
	        }
	    }else
	    {
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	            exit;
	    }
	}

public function form_change_supplier()
{
$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear');
   $this->data['distributor_list']=$this->distributors_mdl->get_distributor_list(false,false,false,false,'dist_distributor','ASC');
$this->load->view('change_supplier/v_change_supplier_form',$this->data);
}

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */