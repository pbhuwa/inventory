<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Handover_req_direct extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->Model('handover_req_direct_mdl');
		$this->load->Model('stock_inventory/Handover_req_direct_mdl');
		$this->username = $this->session->userdata(USER_NAME);
		$this->userid = $this->session->userdata(USER_ID);
		$this->locationid=$this->session->userdata(LOCATION_ID);
		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		$this->orgid=$this->session->userdata(ORG_ID);
		$this->storeid = $this->session->userdata(STORE_ID);
		$this->usergroup = $this->session->userdata(USER_GROUPCODE);
	}


	
	public function index($type=false)
	{   
		$id = $this->input->post('id');

		$this->data['tab_type'] = $type;

		if($id){
			$this->data['handover_data'] = $this->Handover_req_direct_mdl->get_requisition_data(array('harm_handovermasterid'=>$id));
		}else{
			$this->data['handover_data'] = array();
		}
		$this->data['department']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
	    // $this->data['reqno']= $this->input->post('id');
		$this->data['handover_number']=$this->generate_handover_reqno();
		  // echo"<pre>";print_r($this->data['handover_number']);die;
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		
		$this->data['tab_type']='Direct_handover_req_entry';
	// $this->data['req_data'] = $this->Handover_req_direct_mdl->get_requisition_data(array('harm_isdelete'=>'N','hard_reqmasterid'=>$id));
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
	public function save_handover_direct($print = false)
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

				$this->form_validation->set_rules($this->Handover_req_direct_mdl->validate_settings_handover_requisition);
				if($this->form_validation->run()==TRUE)
			{   //echo "<pre>"; print_r($this->input->post());die;
		$trans = $this->Handover_req_direct_mdl->save_handover_direct();
				// echo $trans;die;
		if($trans)
				{		
					if($print = "print")
					{	
						$handover_requisition_details=$this->data['handover_master'] = $this->general->get_tbl_data('*','harm_handoverreqmaster',array('harm_handovermasterid'=>$trans),'harm_handovermasterid','DESC');
						// echo"<pre>";print_r($this->data['issue_master']);die;
						$this->data['handover_details'] = $this->Handover_req_direct_mdl->get_requisition_data(array('rd.hard_handovermasterid'=>$trans));
						
						$this->data['user_signature'] = $this->general->get_signature($this->userid);

						$approvedby = $handover_requisition_details[0]->harm_approvedby;

						$this->data['approver_signature'] = $this->general->get_signature($approvedby);

						$req_date = !empty($handover_requisition_details[0]->harm_reqdatebs)?$handover_requisition_details[0]->harm_reqdatebs:CURDATE_NP; 

						$store_head_id = $this->general->get_store_post_data($req_date,'store_head');
						
						$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);
						// $this->data['received_no'] = $this->generate_receiveno();
						if(defined('HANDOVER_LAYOUT_TYPE')):
							if(HANDOVER_LAYOUT_TYPE == 'DEFAULT'){
								$print_report = $this->load->view('handover/handover_req/v_handover_print_list',$this->data, true);
							}else{

								$print_report = $this->load->view('handover/handover_req/'.REPORT_SUFFIX.'/v_handover_print_list',$this->data, true);
							}
						else:

							$print_report = $this->load->view('handover/handover_req/v_handover_print_list',$this->data, true);
						endif;
						
					}
					print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully.', 'print_report'=>$print_report)));
					exit;
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>'Unsuccessful Operation.')));
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

	public function generate_handover_reqno()
	{
		//req no without location code
		$handoverreqno = '';
		$cur_fiscalyear = CUR_FISCALYEAR;
		$depid = !empty($this->input->post('depid'))?$this->input->post('depid'):$this->storeid;
		
	
			$get_reqno = $this->Handover_req_direct_mdl->get_req_no(array('harm_fyear'=>$cur_fiscalyear, 'harm_locationid' => $this->locationid));
			
			// print_r($get_reqno);
			// die();
		

		if(!empty($get_reqno)){
			$handoverreqno = !empty($get_reqno[0]->handoverreqno)?$get_reqno[0]->handoverreqno+1:1;
			// print_r($reqno);
			// die();
		}

	    if(defined('SHOW_FORM_NO_WITH_LOCATION')){
			if(SHOW_FORM_NO_WITH_LOCATION == 'Y'){

						//req no with location code
			  	$location_data = $this->general->get_tbl_data('loca_code','loca_location',array('loca_locationid'=>$this->locationid));

				$location_code = !empty($location_data[0]->loca_code)?$location_data[0]->loca_code:'';

				$prefix = $location_code;

			  	$this->db->select('harm_handoverreqno');
			  	$this->db->from('harm_handovermaster');
			  	$this->db->where('harm_handoverreqno LIKE '.'"%'.$prefix.'%"');
			  	$this->db->where('harm_locationid',$this->locationid);
			  	$this->db->limit(1);
			  	$this->db->order_by('harm_handoverreqno','DESC');
			  	$query = $this->db->get();
			         // echo $this->db->last_query(); die();
			  	$invoiceno=0;
			  	$dbinvoiceno='';
		      
		        if ($query->num_rows() > 0) 
		        {
		            $dbinvoiceno=$query->row()->harm_handoverreqno;         
		        }
		        if(!empty($dbinvoiceno))
		        {
		        	  $invoiceno=$this->general->stringseperator($dbinvoiceno,'number');
		        }

			    $nw_invoice = str_pad($invoiceno + 1, RECEIVED_NO_LENGTH, 0, STR_PAD_LEFT);

				return $prefix.'-'.$nw_invoice;
			}else{
				return $handoverreqno;
			}
		}else{
			return $handoverreqno;
		}
    }


	

	public function form_handover_requisition()
	{
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		// $this->data['handover_number']=$this->general->get_tbl_data('MAX(harm_handovermasterid) as id','harm_handoverreqmaster',array('harm_locationid'=>$this->locationid),'harm_handovermasterid','DESC');
		$this->data['department']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		$this->data['handover_number'] = $this->generate_handover_reqno();


		// $this->load->view('handover/v_handoverrequisition_form',$this->data);
		if(defined('HANDOVER_LAYOUT_TYPE')):
			if(HANDOVER_LAYOUT_TYPE == 'DEFAULT'){
				$this->load->view('handover/handover_req_direct/v_direct_handover_req_form', $this->data);
			}else{

				$this->load->view('handover/handover_req_direct/v_direct_handover_req_form', $this->data);
			}
		else:

			$this->load->view('handover/handover_req_direct/v_direct_handover_req_form', $this->data);
		endif;

	}

	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */