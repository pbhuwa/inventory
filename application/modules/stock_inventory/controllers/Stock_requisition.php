<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stock_requisition extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('stock_requisition_mdl');

		$this->storeid = $this->session->userdata(STORE_ID);
		$this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
        $this->mattypeid = $this->session->userdata(USER_MAT_TYPEID);
	}
	public function index()
	{
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		$this->data['reqno']=$this->general->get_tbl_data('MAX(rema_reqmasterid) as id','rema_reqmaster',false,'rema_reqmasterid','DESC');
		$this->data['depatrment']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		//print_r($this->data['reqno']);die;
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
			->build('stock/v_stock_requisition', $this->data);
	}

	public function form_stock_requisition()
	{
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		$this->data['reqno']=$this->general->get_tbl_data('MAX(rema_reqmasterid) as id','rema_reqmaster',false,'rema_reqmasterid','DESC');
		$this->data['depatrment']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->load->view('stock/v_stockrequisition_form',$this->data);
	}

	public function save_requisition($print = false)
	{	//print_r($this->input->post());die;
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$this->form_validation->set_rules($this->stock_requisition_mdl->validate_settings_stock_requisition);
			if($this->form_validation->run()==TRUE)
			{
				$trans = $this->stock_requisition_mdl->stock_requisition_save();
				if($trans)
				{   
					if($print = "print")
					{
						//print_r($this->input->post());die;
						$report_data = $this->data['report_data'] = $this->input->post();
						$itemid = !empty($report_data['rede_itemsid'])?$report_data['rede_itemsid']:'';
						if(!empty($itemid)):
							foreach($itemid as $key=>$it):
								$itemid = !empty($report_data['rede_itemsid'][$key])?$report_data['rede_itemsid'][$key]:'';
								$unitid = !empty($report_data['puit_unitid'][$key])?$report_data['puit_unitid'][$key]:'';
								$this->data['item_name']=$this->general->get_tbl_data('*','itli_itemslist',array('itli_itemlistid'=>$itemid),false,'DESC');
							endforeach;
						endif;
						$print_report = $this->load->view('stock/v_print_report', $this->data, true);
					}
					print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully', 'print_report'=>$print_report)));
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

	public function requisition_lists()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_VIEW=='N')
			{
				$array["dist_distributorid"]='';
				$array["distributor"]='';
				$array["countryname"]='';
				$array["city"]='';
				$array["address1"]='';
				$array["action"]='';
				// $this->general->permission_denial_message();
				 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
				exit;
			}
		}
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	  	$i = 0;

	  	if($this->location_ismain=='Y'){
	  		$data = $this->stock_requisition_mdl->get_requisition_list();
	  	}else{
	  		$data = $this->stock_requisition_mdl->get_requisition_list(array('rema_locationid'=>$this->locatiionid));
	  	}
	  
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {
			    $array[$i]["rema_reqmasterid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->rema_reqmasterid.'>'.$row->rema_reqmasterid.'</a>';
			    $array[$i]["reqno"] = $row->rema_reqno;
			   	//$array[$i]["level"] = $row->rema_reqno;
			    $array[$i]["manualno"] = $row->rema_manualno;
			    $array[$i]["fromdep"] = $row->fromdep; 
			    $array[$i]["todep"] = $row->todep;
			    $array[$i]["postdatead"] = $row->rema_postdatead;
			    $array[$i]["postdatebs"] = $row->rema_postdatebs;
			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->rema_reqmasterid.' data-displaydiv="chalanDetails" data-viewurl='.base_url('issue_consumption/challan/details_chalan_views/').' class="view" data-heading="View Order Details"  ><i class="fa fa-eye" aria-hidden="true" ></i></a>';
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function load_requisition()
	{
		// echo $depid;
		// die();
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {	
				//print_r($this->input->post()); die;
				$depid= $this->input->post('id');
				// echo $depid; die();
				$mattypeid=$this->input->post('id');
				$transfer= $this->input->post('type');
				

				$fiscalyear = $this->input->post('fiscal_year');


				if($transfer == 'transfer')
				{
					$searcharry=array('rm.rema_fyear'=>$fiscalyear,'rm.rema_approved'=>'1','rm.rema_received <>'=>2,'rm.rema_storeid'=>$this->storeid,'rema_isdep'=>'N','rm.rema_locationid'=>$this->locationid);
				}elseif($transfer== 'direct_purchase'){
					$searcharry=array('rm.rema_fyear'=>$fiscalyear,'rm.rema_approved'=>'1','rm.rema_received <>'=>2,'rm.rema_isdirect <>'=>1,'rm.rema_storeid'=>$this->storeid,'rm.rema_locationid'=>$this->locationid);
				}else{
					$searcharry=array('rm.rema_fyear'=>$fiscalyear,'rm.rema_approved'=>'1','rm.rema_received <>'=>2,'rm.rema_storeid'=>$this->storeid,'rm.rema_locationid'=>$this->locationid);
				}
				if($depid)
				{
					$searcharry=array('rm.rema_fyear'=>$fiscalyear,'rm.rema_approved'=>'1','rm.rema_received <>'=>2,'rema_reqfromdepid'=>$depid,'rm.rema_storeid'=>$this->storeid,'rm.rema_locationid'=>$this->locationid);
				}
				if(!empty($this->mattypeid))
				{
					$searcharry['rm.rema_mattypeid']=$this->mattypeid;
				}
				
				// $this->data['requistion_departments']= $this->stock_requisition_mdl->get_new_issue_list($searcharry, 'rema_reqno','desc');
			        // echo $this->db->last_query();die();
				$this->data['istransfer'] = $transfer;

				$this->data['pending_list'] = '';
				//$this->data['type'] = $transfer;
				$this->data['mattypeid']=$mattypeid;
				$tempform=$this->load->view('stock/v_requisition_selection_modal',$this->data,true);
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

	public function get_stock_requisition_list($transfer=false,$mattypeid=false)
	{
		if(MODULES_VIEW=='N')
		{
		  	$array=array();
            echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));
            exit;
		}
		//print_r($this->input->post());die;
		$depid= $this->input->post('id');
		// echo $depid;
		// die();
		$fiscalyear = $this->input->get('fyear');

		if($transfer=='transfer')
		{
			$searcharry=array('rm.rema_fyear'=>$fiscalyear,'rm.rema_approved'=>'1','rm.rema_received <>'=>2,'rm.rema_storeid'=>$this->storeid,'rema_isdep'=>'N');
		}elseif($transfer=='direct_purchase'){
			$searcharry=array('rm.rema_fyear'=>$fiscalyear,'rm.rema_approved'=>'1','rm.rema_received <>'=>2,'rm.rema_isdirect <>'=>'1','rm.rema_storeid'=>$this->storeid);
		}else{
			$searcharry=array('rm.rema_fyear'=>$fiscalyear,'rm.rema_approved'=>'1','rm.rema_received <>'=>2,'rm.rema_storeid'=>$this->storeid);
		}
		
		if($depid)
		{
			$searcharry=array('rm.rema_fyear'=>$fiscalyear,'rm.rema_approved'=>'1','rm.rema_received <>'=>2,'rema_reqfromdepid'=>$depid,'rm.rema_storeid'=>$this->storeid);
		}
		if($this->locationid){
			$searcharry=array('rm.rema_fyear'=>$fiscalyear,'rm.rema_approved'=>'1','rm.rema_received <>'=>2,'rm.rema_storeid'=>$this->storeid,'rm.rema_locationid'=>$this->locationid);
		}

		$this->data['pending_list'] = '';
		
		// echo $mattypeid;
		// die();
		if(!empty($mattypeid))
		{
			$searcharry['rm.rema_mattypeid']=$mattypeid;
		}
		$data = $this->stock_requisition_mdl->get_new_issue_list($searcharry);
		// echo "<pre>"; print_r($data); die();
		// echo $this->db->last_query();
		// die();
		
	  	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  
		  	foreach($data as $row)
		    {
		   		// $cntdtl=$row->dtl_cnt;
		   		// $stkcnt = $row->stk_cnt;
		   		// if($cntdtl>=1 && $stkcnt >= 1)
		   		// {
			   		$array[$i]["req_masterid"] = $row->rema_reqmasterid;
				    $array[$i]["req_no"] = $row->rema_reqno;
				    $array[$i]["manual_no"] = $row->rema_manualno;
				    $array[$i]["req_datebs"] = $row->rema_reqdatebs;
				    $array[$i]["req_depname"] = $row->dept_depname;
				    $array[$i]["req_depid"] = $row->rema_reqfromdepid;
				    $array[$i]["req_reqby"] = $row->rema_reqby;
				    $array[$i]["cntdtl"] = $row->dtl_cnt;
				    $array[$i]["stkcnt"] = $row->stk_cnt;
				    $array[$i]["tostore"] = $row->rema_reqtodepid;
				    $array[$i]["fromstore"] = $row->rema_reqfromdepid;
				    $array[$i]["tostorename"] = $row->tostorename;
				    $array[$i]["fromstorename"] = $row->fromstorename;

		   		// }
			 
			     
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function load_pendinglist($new_issue = false){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$req_masterid = $this->input->post('req_masterid');

			if(ORGANIZATION_NAME == 'KUKL'){
				$pending_array = array('rd.rede_reqmasterid'=>$req_masterid,'rd.rede_remqty >'=>0,'rd.rede_proceedissue'=>'Y');
			}else{
				$pending_array = array('rd.rede_reqmasterid'=>$req_masterid,'rd.rede_remqty >'=>0);
			}
			$pending_list = $this->data['pending_list'] = $this->stock_requisition_mdl->get_requisition_details($pending_array);
			// echo"<pre>";print_r($pending_list);die;
			// echo $this->db->last_query();die();
			if(empty($pending_list)){
				$isempty = 'empty';
			}else{
				$isempty = 'not_empty';
			}
			if($new_issue == 'new_issue_pending_list'){
				$tempform=$this->load->view('issue_consumption/issue/v_requisition_pendinglist',$this->data,true);
			}elseif($new_issue == 'purchase_requisition_list'){
				$tempform=$this->load->view('purchase_receive/purchase/v_purchase_requisition_pendinglist',$this->data,true);
			}else if($new_issue =='new_direct_purchase'){
				$tempform=$this->load->view('purchase_receive/purchase/v_direct_req',$this->data,true);

			}else if($new_issue =='transfer'){
				$tempform=$this->load->view('stock_transfer/v_stock_transfer_appendform',$this->data,true);
			}
			else if($new_issue =='handover_issue_pending_list'){
				
				$tempform=$this->load->view('handover/handover_issue/kukl/v_handover_pendinglist',$this->data,true);
			}
			else{
				$tempform=$this->load->view('stock/v_requisition_pendinglist_modal',$this->data,true);
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