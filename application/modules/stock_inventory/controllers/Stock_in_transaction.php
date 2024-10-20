<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stock_in_transaction extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('stock_in_transaction_mdl');
	}
	public function index()
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
		$this->data['tab']='stock_in_transaction';
		// $this->template
		// 	->set_layout('general')
		// 	->enable_parser(FALSE)
		// 	->title($this->page_title)
		// 	->build('stock_in_transaction/v_purchase_sale', $this->data);
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('stock/v_stock_common_tab', $this->data);
	}
	public function stock_transactioin()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	        if(MODULES_VIEW=='N')
			{
				
 				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}
	        $template = $this->stock_transactioin_common();

	        // echo $temp; die();
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}


	public function stock_transactioin_common()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
	      	$this->data['excel_url'] = "stock_inventory/stock_in_transaction/excel_stock";
			$this->data['pdf_url'] = "stock_inventory/stock_in_transaction/stock_pdf";
			$this->data['report_title'] = $this->lang->line('stock_in_transaction');

	      	$this->data['fromdate'] = $this->input->post('fromdate');
        	$this->data['todate'] = $this->input->post('todate');
        	$storeid = $this->input->post('store_id');

        	$trma_todepartmentid = $this->input->post('eqty_equipmenttypeid');
        	$srchcol='';
        	if($trma_todepartmentid)
        	{
        		$srchcol = array('mt.trma_todepartmentid'=>$trma_todepartmentid);
        	}
	      	$this->data['purchase']=$this->stock_in_transaction_mdl->strock_intransaction($srchcol);
	      	//echo"<pre>";print_r($this->data['purchase']);die;
	      	$this->data['equipmenttype']=$this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$trma_todepartmentid),'eqty_equipmenttypeid','DESC');
	      	//print_r($this->data['equipmenttype']);die;
	      	if($storeid):
	    		$this->data['store_type']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$storeid));
	    	else:
	    		$this->data['store_type'] = 'All';
	    	endif;
	      	
	        $template='';
		    if($this->data['purchase'])
		    {
		    	$template=$this->load->view('stock_in_transaction/v_purchase_report',$this->data,true);
		    }
		    else
		    {
		        $template='<span class="col-sm-12 alert alert-danger text-center" style="margin-top: -25px;">No Record Found!!!</span>';
		    }
	        // echo $temp; die();
	       return $template;
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}









	public function excel_stock()
	{
		header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_in_transaction_excel_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        $response = $this->stock_transactioin_common();
        if($response){
        	echo $response;	
        }
        return false;
	}



	public function stock_pdf()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$html = $this->stock_transactioin_common();

			$filename = 'stock_in_transaction'. date('Y_m_d_H_i_s') . '_.pdf'; 
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