<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cancel_order extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('cancel_order_mdl');
		$this->storeid = $this->session->userdata(STORE_ID);

		$this->locationid = $this->session->userdata(LOCATION_ID);
		$this->orgid = $this->session->userdata(ORG_ID);
		$this->username = $this->session->userdata(USER_NAME);

		if (defined('LOCATION_CODE')) {
			$this->locationcode = $this->session->userdata(LOCATION_CODE);
		}

		$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
		$this->usergroup = $this->session->userdata(USER_GROUPCODE);

		$this->userdept = $this->session->userdata(USER_DEPT);

		$this->mattypeid = $this->session->userdata(USER_MAT_TYPEID);


	}

	public function index()
	{ 
		
		$this->data['distributor']=$this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');
		// echo "<pre>";
		// print_r($this->data['supplier_all']);
		// die();

		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		$this->data['material_type'] = $this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','ASC');




		$this->data['order_details'] = "";
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

		$this->data['current_tab']='cancel_order';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			// ->build('cancel_order/v_cancel_order', $this->data);
			->build('purchase_order/v_common_purchaseorder_tab', $this->data);
	}
	public function cancel_order_lists()
	{
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','supp_supplier',false,'supp_supplierid','DESC');
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');

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

		$this->data['current_tab']='cancel_order_list';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			// ->build('cancel_order/v_cancel_order', $this->data);
			->build('purchase_order/v_common_purchaseorder_tab', $this->data);
	}

	public function save_cancel_order()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if($this->input->post('id'))
				{
					if(MODULES_UPDATE=='N')
					{
						$this->general->permission_denial_message();
						exit;
					}
				}
				else
				{
					if(MODULES_INSERT=='N')
					{
						$this->general->permission_denial_message();
						exit;
					}
				}
		try {
				
				$this->form_validation->set_rules($this->cancel_order_mdl->validate_settings_cancelorder);
				$ordernumber=$this->input->post('orderno');
				$canceldate = $this->input->post('canceldate');
				$fiscalyear=$this->input->post('fiscalyear');
				$this->data['order_details'] = $this->cancel_order_mdl->get_cancelorder_list(array('puor_orderno'=>$ordernumber,'puor_fyear'=>$fiscalyear));
				$orddate = !empty($this->data['order_details'][0]->puor_orderdatebs)?$this->data['order_details'][0]->puor_orderdatebs:'';
 				if($canceldate < $orddate)
 				{
 					print_r(json_encode(array('status'=>'error','message'=>'Cancel Date cannot be before the opening Date')));
					exit;
 				}
 				// if($canceldate > $orddate)
 				// {
 				// 	print_r(json_encode(array('status'=>'error','message'=>'Cancel Date cannot be greater than Server Date')));
					// exit;
 				// }
				if($this->form_validation->run()==TRUE)
				{  
					$trans = $this->cancel_order_mdl->save_cancel_order();
					if($trans)
					{
						print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
					exit;
					}
					else
					{
						print_r(json_encode(array('status'=>'error','message'=>'Record Save Successfully')));
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
		}else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}

	public function form_cancel_order(){
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','supp_supplier',false,'supp_supplierid','DESC');
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		$this->data['order_details'] = "";

		$this->data['current_tab']='cancel_order';
		$this->load->view('cancel_order/v_cancel_order_form', $this->data);
	}

	public function cancel_order_details()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$ordernumber=$this->input->post('ordernumber');
			$fiscalyear=$this->input->post('fiscalyear');
			$mat_typeid=$this->input->post('mattypeid');
			$this->data['distributor']=$this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');
			$this->data['material_type'] = $this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','ASC');
			
			$default_search=array('puor_orderno'=>$ordernumber,'puor_fyear'=>$fiscalyear);

			$default_search['puor_locationid']=$this->locationid;
			$organization_name_array=array('KU','PU','ARMY','STAR','SW');
			if(in_array(ORGANIZATION_NAME,$organization_name_array) ){
				$default_search['puro_mattypeid']=	$mat_typeid;
			}
			

			$order_details = $this->data['order_details'] = $this->cancel_order_mdl->get_cancelorder_list($default_search);
			// echo $this->db->last_query();
			// die();

			$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');

			$tempform=$this->load->view('cancel_order/v_cancel_order_form',$this->data,true);
		
			if(!empty($this->data['order_details']))
			{
				$is_received = !empty($order_details[0]->puor_purchased)?$order_details[0]->puor_purchased:'';

				if($is_received == 0){
					print_r(json_encode(array('status'=>'success','message'=>'You can cancel order','tempform'=>$tempform)));
	            	exit;
				}else{
					print_r(json_encode(array('status'=>'error','message'=>'You can not cancel this order. This order is already received.','tempform'=>$tempform)));
	            	exit;
				}
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Order not found. Please try again.')));
	            exit;
			}
		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function cancel_order_list()
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
	  	$data = $this->cancel_order_mdl->get_cancel_order_list();
	  	// echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {	

		    		if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($row->itemnamenp)?$row->itemnamenp:$row->itemname;
                }else{ 
                    $req_itemname = !empty($row->itemname)?$row->itemname:'';
                }

		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]['itemcode'] = $row->itemcode;
		   		$array[$i]['itemname'] = $req_itemname;
		   		$array[$i]['suppliername'] = $row->suppliername;
		   		$array[$i]['status'] = $row->status;
		   		$array[$i]['quantity'] = $row->quantity;
		   		$array[$i]['cancelqty'] = $row->cancelqty;
		   		$array[$i]['orderno'] = $row->orderno;
		   		$array[$i]['remarks'] = $row->remarks;
		   		$array[$i]['canceldate'] = $row->canceldate;
		   		$array[$i]['orderdate'] = $row->orderdate;
		   		$array[$i]['rate'] = $row->rate;
		   		$array[$i]['vat'] = $row->vat;
		   		$array[$i]['discount'] = $row->discount;
		   		$array[$i]['cancelamount'] = $row->rate * $row->cancelqty;
		   		$array[$i]['cancel_all'] = '';
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function exportToExcel(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=cancel_order_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->cancel_order_mdl->get_cancel_order_list();

        $this->data['searchResult'] = $this->cancel_order_mdl->get_cancel_order_list();
        
        $array = array();
        unset($data["totalfilteredrecs"]);
        unset($data["totalrecs"]);

        $response = $this->load->view('cancel_order/v_cancel_order_download', $this->data, true);

        echo $response;
    }

    public function generate_pdf()
    {
        $this->data['searchResult'] = $this->cancel_order_mdl->get_cancel_order_list();

        unset($data["totalfilteredrecs"]);
        unset($data["totalrecs"]);
        
        $html = $this->load->view('cancel_order/v_cancel_order_download', $this->data, true);
        
        $filename = 'cancel_order_detail_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; 
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
    }

    public function load_order_list_for_cancel()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {	
				$this->data['requistion_departments']= '';
				$this->data['detail_list'] = '';

				$tempform=$this->load->view('cancel_order/v_order_list_modal',$this->data,true);

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

	public function get_order_list_for_cancel(){
		if(MODULES_VIEW=='N')
		{
		  	$array=array();
            echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));
            exit;
		}
		
		$fiscalyear= !empty($this->input->get('fiscalyear'))?$this->input->get('fiscalyear'):$this->input->post('fiscalyear');

		$searcharray = array('po.puor_fyear'=>$fiscalyear,'po.puor_storeid'=>$this->storeid);

		$this->data['detail_list'] = '';

		$data = $this->cancel_order_mdl->get_order_list($searcharray);
		// echo "<pre>";
		// print_r($data); die;
		// echo $this->db->last_query(); die;
	  	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  
		  	foreach($data as $row)
		    {
		    	$array[$i]["masterid"] = $row->puor_purchaseordermasterid;
			    $array[$i]["order_no"] = $row->puor_orderno;
			    $array[$i]["req_no"] = $row->puor_requno;
			    $array[$i]["date"] = $row->puor_orderdatebs;
			    $array[$i]["suppliername"] = $row->dist_distributor;
			    $array[$i]["amount"] = $row->puor_amount;
			    
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}

	public function load_detail_list($new_order = false){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$masterid = $this->input->post('masterid');

			$detail_list = $this->data['detail_list'] = $this->cancel_order_mdl->get_order_details(array('pude_purchasemasterid'=>$masterid,'pude_remqty >'=>0));
			$this->data['distributor']=$this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');

			if(empty($detail_list)){
				$isempty = 'empty';
			}else{
				$isempty = 'not_empty';
			}
			if($new_order == 'new_detail_list'){
				$tempform=$this->load->view('cancel_order/v_order_detail_append',$this->data,true);
			}else{
				$tempform=$this->load->view('cancel_order/v_order_detail_modal',$this->data,true);
			}

			if(!empty($tempform))
			{
				print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$tempform,'isempty'=>$isempty)));
	            exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));
	            exit;
			}
		}else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */