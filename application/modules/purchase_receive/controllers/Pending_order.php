<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pending_order extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('pending_order_mdl');
		$this->load->Model('pending_order_detail_mdl');
	}

	public function index()
	{ 
		$this->data['store_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');

		$this->data['dynamicColumn'] = '[{ "data": "sno" }, { "data": "suppliers" }, { "data": "delivery_date" }, { "data": "order_no" }, { "data": "order_date" }, { "data": "delivery_site" }, { "data": "order_amt" }, { "data": "approved" },
            ]';

        $this->data['dtable_url'] = "purchase_receive/pending_order/pending_order_list";

        $this->data['a_targets'] = "8";

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
		// 	->build('pending_order/v_pending_order', $this->data);
		$this->data['tab_type']='pending_order';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('pending_order_detail/v_pending_common', $this->data);
	}

	public function pending_order_list()
	{
		if(MODULES_VIEW=='N')
			{
			$array=array();
			 // $this->general->permission_denial_message();
			echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
			}
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		}
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
			
	  	$i = 0;
	  	$data = $this->pending_order_mdl->get_pending_order_list();

	  	// echo "<pre>";
	  	// print_r($data);
	  	// die();

		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {	
		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]['viewurl']=base_url().'/purchase_receive/pending_order/load_pending_order_detail';
		   		// $array[$i]['suppliers_name']=$row->supp_suppliername;
		   		$array[$i]["prime_id"] = $row->puor_purchaseordermasterid;
		   		$array[$i]['suppliers'] = $row->dist_distributor;
		   		$array[$i]['delivery_date'] = $row->puor_deliverydatebs;
		   		$array[$i]['order_no'] = $row->puor_orderno;
		   		$array[$i]['order_date'] = $row->puor_orderdatebs;
		   		$array[$i]['delivery_site'] = $row->puor_deliverysite;
		   		$array[$i]['order_amt'] = $row->puor_amount;
		   		$array[$i]['approved'] = $row->puor_approvedby;
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}


    public function exportToExcel()
	{
	    
	    header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=pending_order_detail_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
       	$html  = $this->pending_order_common();
        if($html)
        {
       		echo $html;
       	}
    }
    public function generate_pdf()
    {
        $html  = $this->pending_order_common();
      	$filename = 'pending_order_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
    }

    public function pending_order_common()
    {
    	$this->data['excel_url'] = "purchase_receive/demand_report/exportToExcel";
		$this->data['pdf_url'] = "purchase_receive/demand_report/generate_pdf";
		$this->data['report_title'] = $this->lang->line('pending_order');

		$this->data['searchResult'] = $this->pending_order_mdl->get_pending_order_list();

		unset($this->data['searchResult']["totalfilteredrecs"]);
		unset($this->data['searchResult']["totalrecs"]);
		//$html = $this->load->view('pending_order_detail/v_pending_order_detail_pdf', $this->data, true);
		$html = $this->load->view('pending_order/v_pending_order_pdf', $this->data, true);
        return $html;
    }



    public function load_pending_order_detail()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {	
				$id = $this->input->post('id');

				// echo $id;
				// die();
				$this->data['pending_order_detail']= $this->pending_order_detail_mdl->get_purchase_detail_by_id(array('pude_purchasemasterid'=>$id));

				$tempform=$this->load->view('pending_order/v_pending_order_detail_modal',$this->data,true);

				if(!empty($tempform))
				{
						print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$tempform)));
		            	exit;
				}
				else{
					print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));
		            	exit;
				}
			}
			catch (Exception $e) {
				print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
			}
		}else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */