<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Handover_direct extends CI_Controller
{
	function __construct()
	{

		parent::__construct();
		$this->load->Model('handover_issue_mdl');
		$this->load->Model('handover_req_mdl');
		$this->load->Model('stock_inventory/stock_requisition_mdl','stock_requisition_mdl');
		// $this->load->Model('stock_inventory/stock_requisition_mdl');
		$this->username = $this->session->userdata(USER_NAME);
		$this->userid = $this->session->userdata(USER_ID);
		$this->locationid=$this->session->userdata(LOCATION_ID);
		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		$this->orgid=$this->session->userdata(ORG_ID);
	}
	public function index()
	{   
		$this->data['reqno']= $this->input->post('id');
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		$this->data['department']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		$this->data['new_issue'] ="";
		$this->data['tab_type']='direct_entry';
		$this->data['handoverissue_no']=$this->general->generate_invoiceno('haov_handoverno','haov_handoverno','haov_handovermaster',HANDOVER_NO_PREFIX,HANDOVER_NO_LENGTH,false,'haov_locationid');
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
		->build('handover/v_handover_tab', $this->data);
	}
	

	public function save_direct_handover_issue($print =false)
	{
		error_reporting(0);
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
   			  // echo "<pre>";print_r($postdata);die();
				$req_nochk=$this->check_handover_req_no();
   			

				$print_report='';
				$itemsid = $this->input->post('sade_itemsid');
				$qtyinstock = $this->input->post('qtyinstock');
				$isqty = $this->input->post('sade_qty');
				$itmname=$this->input->post('sade_itemsname');
				$reqqty=$this->input->post('remqty');
				$this->form_validation->set_rules($this->handover_issue_mdl->validate_direct_handover_issue);
				if($this->form_validation->run()==TRUE)
					{	if(!empty($itemsid))
						{
							foreach($itemsid as $key=>$val){
								$stockval = !empty($qtyinstock[$key])?$qtyinstock[$key]:'';
								$issueqty= !empty($isqty[$key])?$isqty[$key]:'';
								$itemid= !empty($itemsid[$key])?$itemsid[$key]:'';
								$itemStockVal=$this->handover_issue_mdl->check_item_stock($itemid);
						// echo $this->db->last_query();
						// die();
						// echo "<per>";print_r($itemStockVal);die;
								$db_item_stockval=!empty($itemStockVal)?$itemStockVal:0;

								$itmname=!empty($itmname[$key])?$itmname[$key]:'';
								$remQty=!empty($reqqty[$key])?$reqqty[$key]:'';

								if($issueqty>$db_item_stockval)
								{
									print_r(json_encode(array('status'=>'error','message'=>'Issue Qty of Item '.$itmname.' should not exceed stock qty. Please check it.')));
									exit;
								}

								if($issueqty>$remQty)
								{
									print_r(json_encode(array('status'=>'error','message'=>'Issue Qty of Item '.$itmname.' should not exceed Req. qty. Please check it.')));
									exit;
								}
							}
						}
						$trans = $this->handover_issue_mdl->save_handover_issue();

						if($trans)
						{   
							if($print =="print")
							{	
								$this->data['issue_master'] = $this->general->get_tbl_data('*','haov_handovermaster',array('haov_handovermasterid'=>$trans),'haov_handovermasterid','DESC');
						         // echo"<pre>";print_r($this->data['issue_master']);die;
								$this->data['issue_details'] = $this->handover_issue_mdl->get_issue_detail(array('sd.haod_handoverdetailid'=>$trans));
					           // echo"<pre>";	print_r($this->data['issue_details']);die;
								$this->data['store']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$this->session->userdata(STORE_ID)),'eqty_equipmenttypeid','ASC');
								$this->data['user_signature'] = $this->general->get_signature($this->userid);
								$approve_data = $this->handover_issue_mdl->get_approve_data($trans);
								$approvedby = !empty($approve_data[0]->harm_approvedid)?$approve_data[0]->harm_approvedid:'';
								$this->data['approver_signature'] = $this->general->get_signature($approvedby);
								$issue_date = !empty($issue_details[0]->haov_handoverdatebs)?$issue_details[0]->haov_handoverdatebs:CURDATE_NP; 
								$store_head_id = $this->general->get_store_post_data($issue_date,'store_head');
								$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);
								if(defined('HANDOVER_LAYOUT_TYPE')):
									if(HANDOVER_LAYOUT_TYPE == 'DEFAULT'){
										$print_report = $this->load->view('handover/handover_issue/v_handover_issue_print', $this->data, true);
									}else{
										$print_report = $this->load->view('handover/handover_issue/'.REPORT_SUFFIX.'/v_handover_issue_print', $this->data, true);
									}
								else:
									$print_report = $this->load->view('handover/handover_issue/v_handover_issue_print', $this->data, true);
								endif;


						//echo "<pre>"; print_r($print_report);die;
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


		public function form_direct_handover_issue(){
			$this->data['reqno']='';
			$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
			$this->data['depatrment']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
			$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
			$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','ASC');
			$this->data['new_issue'] ="";
			$this->data['tab_type']='direct_entry';
			$this->data['issue_no']=$this->generate_handover_issueno();

			$this->data['handoverissue_no']=$this->general->generate_invoiceno('haov_handoverno','haov_handoverno','haov_handovermaster',HANDOVER_NO_PREFIX,HANDOVER_NO_LENGTH,false,'haov_locationid');

		
			$this->load->view('handover/handover_direct/v_handover_direct_entry_form',$this->data);
			
		}
		public function check_handover_req_no()
		{
			$req_no=$this->input->post('sama_requisitionno');
			$fyear=$this->input->post('sama_fyear');
			$storeid=!empty($this->session->userdata(STORE_ID))?$this->session->userdata(STORE_ID):1;

			// $srchcol=array('harm_handoverreqno'=>$req_no,'harm_fyear'=>$fyear,'harm_approved'=>'2','harm_storeid'=>$storeid);
			$srchcol=array('harm_handoverreqno'=>$req_no,'harm_fyear'=>$fyear,'harm_approved'=>'2','harm_storeid'=>$storeid);
			
			$this->data['req_data']=$this->handover_issue_mdl->get_handover_req_no_list($srchcol, 'harm_handoverreqno','desc');
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

		public function generate_handover_issueno()
		{
			$curmnth=CURMONTH;
			if($curmnth==1)
			{
				$prefix='A';
			}
			if($curmnth==2)
			{
				$prefix='B';
			}
			if($curmnth==3)
			{
				$prefix='C';
			}
			if($curmnth==4)
			{
				$prefix='D';
			}
			if($curmnth==5)
			{
				$prefix='E';
			}
			if($curmnth==6)
			{
				$prefix='F';
			}
			if($curmnth==7)
			{
				$prefix='G';
			}
			if($curmnth==8)
			{
				$prefix='H';
			}
			if($curmnth==9)
			{
				$prefix='I';
			}
			if($curmnth==10)
			{
				$prefix='J';
			}
			if($curmnth==11)
			{
				$prefix='K';
			}
			if($curmnth==12)
			{
				$prefix='L';
			}

			$this->db->select('sama_invoiceno');
			$this->db->from('sama_salemaster');
			$this->db->where('sama_invoiceno LIKE '.'"%'.HANDOVER_NO_ISSUE_PREFIX.$prefix.'%"');
			$this->db->limit(1);
			$this->db->order_by('sama_invoiceno','DESC');
			$query = $this->db->get();
        // echo $this->db->last_query(); die();
			$dbinvoiceno='';
			if ($query->num_rows() > 0) 
			{
				$dbinvoiceno=$query->row()->sama_invoiceno;         
			}

			$invoiceno=$this->general->stringseperator($dbinvoiceno,'number');
			$nw_invoice = str_pad($invoiceno + 1, INVOICE_NO_LENGTH, 0, STR_PAD_LEFT);
			return HANDOVER_NO_ISSUE_PREFIX.$prefix.$nw_invoice;
		}




	

	}
	/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */