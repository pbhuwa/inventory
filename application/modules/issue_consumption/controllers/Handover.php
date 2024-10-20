<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Handover extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('handover_mdl');
		$this->load->Model('stock_inventory/stock_requisition_mdl');

		$this->username = $this->session->userdata(USER_NAME);
		$this->storeid = $this->session->userdata(STORE_ID);
		$this->locationid=$this->session->userdata(LOCATION_ID);
		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		
	}
	public function index()
	{   
		$this->data['reqno']= $this->input->post('id');
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		 
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','ASC');
		$this->data['new_issue'] ="";
		$this->data['tab_type']='handover_issue_entry';
		// $this->data['issue_no']=$this->generate_invoiceno();

		$this->data['issue_no'] = $this->general->generate_invoiceno('sama_invoiceno','sama_invoiceno','sama_salemaster',INVOICE_NO_PREFIX,INVOICE_NO_LENGTH);

		$this->data['handover_no'] = $this->general->generate_invoiceno('sama_invoiceno','sama_invoiceno','sama_salemaster',DIRECT_ISSUE_NO_PREFIX,DIRECT_ISSUE_NO_LENGTH, array('sama_ishandover'=>'Y'));

		// echo $this->db->last_query();
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
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('issue/v_new_issue', $this->data);
	}

	public function issuedetails()
	{
		$this->data['tab_type']='issuedetails';
		$this->data['apptype'] = '';
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
			->build('issue/v_new_issue', $this->data);
	}
	public function issuebook()
	{
		$this->data['tab_type']='list';
		$this->data['apptype'] = '';
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
			->build('issue/v_new_issue', $this->data);
	}


	
	public function save_handover($print =false)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {

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

			$postdata=$this->input->post();
   			//echo "<pre>";print_r($postdata);die();
   			$req_nochk=$this->check_req_no();
   			// echo $this->db->last_query();
   			// die();
			// echo $req_nochk;
			// if(empty($req_nochk))
			// {
			// 	print_r(json_encode(array('status'=>'error','message'=>'Invalid Requisition No!!')));
			// 		exit;
			// 	// $this->form_validation->set_message('reqno', 'Invalid Requisition No!!');
			// 	// exit;
			// }
			$print_report='';
			$itemsid = $this->input->post('sade_itemsid');
			$qtyinstock = $this->input->post('qtyinstock');
			$isqty = $this->input->post('sade_qty');
			$itmname=$this->input->post('sade_itemsname');
			$reqqty=$this->input->post('remqty');

			$is_handover = $this->input->post('handover');

			$this->form_validation->set_rules($this->handover_mdl->validate_new_issue);
			if($this->form_validation->run()==TRUE)
			{	if(!empty($itemsid))
				{
					foreach($itemsid as $key=>$val){
						$stockval = !empty($qtyinstock[$key])?$qtyinstock[$key]:'';
						$issueqty= !empty($isqty[$key])?$isqty[$key]:'';
						$itemid= !empty($itemsid[$key])?$itemsid[$key]:'';
						$itemStockVal=$this->handover_mdl->check_item_stock($itemid);
						// echo $this->db->last_query();
						// die();
						// print_r($issueqty);
						// die();
						$db_item_stockval=!empty($itemStockVal)?$itemStockVal:0;

						$itmname=!empty($itmname[$key])?$itmname[$key]:'';
						$remQty=!empty($reqqty[$key])?$reqqty[$key]:'';

						if($issueqty>$db_item_stockval)
						{
							print_r(json_encode(array('status'=>'error','message'=>'Issue Qty of Item '.$itmname.' should not exceed stock qty. Please check it.')));
							exit;
						}

						// if($issueqty>$remQty)
						// {
						// 	print_r(json_encode(array('status'=>'error','message'=>'Issue Qty of Item '.$itmname.' should not exceed Req. qty. Please check it.')));
						// 	exit;
						// }
					}
				}

				$trans = $this->handover_mdl->save_handover();

				// $trans = "1";

				if($trans)
				{   
					if($print =="print")
					{	
						$this->data['issue_master'] = $this->general->get_tbl_data('*','sama_salemaster',array('sama_salemasterid'=>$trans),'sama_salemasterid','DESC');

						$this->data['issue_details'] = $this->handover_mdl->get_issue_detail(array('sd.sade_salemasterid'=>$trans));

						$this->data['store']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$this->session->userdata(STORE_ID)),'eqty_equipmenttypeid','ASC');

					$print_report = $this->load->view('handover/v_handover_print', $this->data, true);
					}
					print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully','print_report'=>$print_report)));
					exit;
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>'Unsuccessfull Operation')));
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

	public function handover_print_form()
	{
		$this->data['issue_master'] = $this->general->get_tbl_data('*','sama_salemaster',array('sama_salemasterid'=>'7968'),'sama_salemasterid','DESC');
		$this->data['issue_details'] = $this->handover_mdl->get_issue_detail(array('sd.sade_salemasterid'=>'7968'));
		$print_report = $this->load->view('handover/v_handover_print_kukl', $this->data, true);
		echo $print_report;
		die();
	}

	public function form_handover(){
		$this->data['reqno']='';
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		 $this->data['location_all'] = $this->general->get_tbl_data('*','loca_location',false,'loca_locationid','DESC');
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','ASC');
		$this->data['new_issue'] ="";
		$this->data['tab_type']='entry';
		$this->data['issue_no']=$this->generate_invoiceno();
		$this->data['handover_no'] = $this->general->generate_invoiceno('sama_invoiceno','sama_invoiceno','sama_salemaster',DIRECT_ISSUE_NO_PREFIX,DIRECT_ISSUE_NO_LENGTH, array('sama_ishandover'=>'Y'));

		$this->load->view('handover/v_handover_new_issue_form',$this->data);
	}

	public function check_req_no()
	{
		$req_no=$this->input->post('sama_requisitionno');
			$fyear=$this->input->post('sama_fyear');
			$storeid=!empty($this->session->userdata(STORE_ID))?$this->session->userdata(STORE_ID):1;
			
			$srchcol=array('rema_reqno'=>$req_no,'rema_fyear'=>$fyear,'rema_reqtodepid'=>$storeid,'rema_approved'=>'1');
			
			$this->data['req_data']=$this->stock_requisition_mdl->get_req_no_list($srchcol, 'rema_reqno','desc');
			// echo $this->db->last_query();
			// die();
			if(!empty($this->data['req_data']))
			{
				return 1;
			}
			else
			{
				return 0;
			}

	}


	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */