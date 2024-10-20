<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_requisition extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('purchase_requisition_mdl');
		$this->storeid = $this->session->userdata(STORE_ID);
		$this->userid = $this->session->userdata(USER_ID);
		$this->locationid=$this->session->userdata(LOCATION_ID);

		$this->usergroup = $this->session->userdata(USER_GROUPCODE);
		$this->mattypeid = $this->session->userdata(USER_MAT_TYPEID);
	}

	public function index($reload=false)
	{   
		$this->data['reqno']= $this->input->post('id');
		$reqmasterid=$this->input->post('reqmasterid');

		if(defined('PUR_REQ_TO')){
			$this->data['pur_req_to']=PUR_REQ_TO;
		}else{
			$this->data['pur_req_to']='Superintendent';
		}
		// echo $reqmasterid;
		// die();
		$this->data['default_material_typeid']=array();
		if(!empty($reqmasterid)){
			$default_selection=$this->general->get_tbl_data('rema_mattypeid','rema_reqmaster',array('rema_reqmasterid'=>$reqmasterid));
			if(!empty($default_selection)){
				$this->data['default_material_typeid']=!empty($default_selection[0]->rema_mattypeid)?$default_selection[0]->rema_mattypeid:'1';
			}
		}
		// echo "<pre>";
		// print_r($this->data['default_material_typeid']);
		// die();

		$this->data['reqmasterid']=$reqmasterid;
		if(!empty($this->mattypeid))
		{
			$srchmat=array('maty_materialtypeid'=>$this->mattypeid,'maty_isactive'=>'Y');
		}else{
			$srchmat=array('maty_isactive'=>'Y');
		}
		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material','maty_materialtype',$srchmat,'maty_materialtypeid','ASC');
		
		$id = $this->input->post('id'); 
		$this->data['requisition_approved']=array();
		$this->data['requisition_details']=array();
		if($id)
		{   $this->data['reqno']=''; 
			$this->data['requisition_approved'] = $this->general->get_tbl_data('*','pure_purchaserequisition',array('pure_purchasereqid'=>$id),'pure_purchasereqid','DESC'); 
			if(!empty($this->data['requisition_approved'])){
				$this->data['default_material_typeid']=!empty($this->data['requisition_approved'][0]->pure_mattypeid)?$this->data['requisition_approved'][0]->pure_mattypeid:'1';
			}
			$this->purchase_requisition_mdl->get_purchase_requisition_list(array('cm.pure_purchasereqid'=>$id));
			$this->data['requisition_details'] = $this->purchase_requisition_mdl->get_purchase_requisition_details(array('rd.purd_reqid'=>$id));
			//echo $this->db->last_query(); die();
		}else{
			if(ORGANIZATION_NAME =='KU' || ORGANIZATION_NAME=='ARMY' || ORGANIZATION_NAME =='PU'){
				$this->data['reqno'] = $this->get_purchase_req_no_by_mat_type('Y',$this->data['default_material_typeid']);
			}else{

			$this->data['reqno']=$this->general->get_tbl_data('MAX(pure_reqno) as id','pure_purchaserequisition',array('pure_fyear'=>CUR_FISCALYEAR,'pure_locationid'=>$this->locationid),'pure_reqno','DESC');
			}
		}
		
		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','DESC');
	
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC','2');
		$this->data['current_user']=$this->session->userdata(USER_NAME);
		// print_r($this->data['reqno']);die;
		$input_req=$this->input->post('req_no');
		$input_itemlist=$this->input->post('itemlist');
		$input_fyear =$this->input->post('fyear');
		// echo "<pre>";
		// print_r($input_itemlist);
		// die();
		$this->data['purchase_item_list']=array();
		$this->data['req_num_from_dmd']='';
		if(!empty($input_req))
		{	
			$this->data['req_num_from_dmd']=$input_req;
			if(!empty($input_itemlist))
			{
				$itemid=explode(",", $input_itemlist);
				
			$this->data['purchase_item_list']=$this->purchase_requisition_mdl->get_item_name_by_reqno($input_req,$itemid,$input_fyear);
			if(!empty($this->data['purchase_item_list'])){
					$reqmasterid=!empty($this->data['purchase_item_list'][0]->rema_reqmasterid)?$this->data['purchase_item_list'][0]->rema_reqmasterid:'';
						$this->data['reqmasterid']=$reqmasterid;
					$default_selection=$this->general->get_tbl_data('rema_mattypeid','rema_reqmaster',array('rema_reqmasterid'=>$reqmasterid));
					if(!empty($default_selection)){
						$this->data['default_material_typeid']=!empty($default_selection[0]->rema_mattypeid)?$default_selection[0]->rema_mattypeid:'1';
					}
				if(ORGANIZATION_NAME =='KU' || ORGANIZATION_NAME=='ARMY' || ORGANIZATION_NAME =='PU'){
				$this->data['reqno'] = $this->get_purchase_req_no_by_mat_type('Y',$this->data['default_material_typeid']);
				}
			}
			}
		}
		// echo $this->db->last_query();
		// die();
		// echo "<pre>";
		// print_r($this->data['purchase_item_list']);
		// die();
		$this->data['current_tab']='entry';
		$this->data['new_issue'] ="";

		if($reload=='reload'){
			$this->data['load_select2'] = 'Y';
            if(ORGANIZATION_NAME == 'KUKL'){
                $this->load->view('purchase/'.REPORT_SUFFIX.'/v_purchase_requisition_form',$this->data);
            }else{
                if(defined('PURCHASE_REQ_FORM')):
                   if(PURCHASE_REQ_FORM == 'DEFAULT'){
                     $this->load->view('purchase/v_purchase_requisition_form',$this->data);
                        }else{
                            $this->load->view('purchase/'.REPORT_SUFFIX.'/v_purchase_requisition_form',$this->data);
                        }
                    else:
                         $this->load->view('purchase/v_purchase_requisition_form',$this->data);
                    endif;
                }
   
		}else{
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
				->build('purchase/v_purchse_requisition', $this->data);
		}
		
	}

	public function get_purchase_req_no_by_mat_type($direct_access=false,$default_mattype=false){
	try{
		// echo "<pre>";
		// print_r($this->input->post());
		// die();
		$cur_fiscalyear = CUR_FISCALYEAR;

		$fyear = !empty($this->input->post('fyear'))?$this->input->post('fyear'):$cur_fiscalyear;
			$mattype=!empty($this->input->post('mattype'))?$this->input->post('mattype'):'1';
		 if($this->mattypeid){    
               $mattype= $this->mattypeid;
            }
            if(!empty($default_mattype)){
            	$mattype=$default_mattype;
            }

		// $reqno = $this->generate_stock_reqno();
            $this->db->select('max(pure_reqno) as reqno');
            $this->db->from('pure_purchaserequisition');
            $this->db->where(array('pure_locationid'=>$this->locationid,'pure_fyear'=>$fyear,'pure_mattypeid'=>$mattype));
            $result = $this->db->get()->row();
            if(!empty($result))
            {
            	$reqno=$result->reqno +1;
            }else{
            	$reqno=1;
            }
           
			if($direct_access=='Y'){
				return $reqno;
			}else{
				print_r(json_encode(array('status'=>'success','reqno'=>$reqno)));
		exit;
			}
		
	}catch(Exception $e){
		echo $e->getMessage();
	}
}

	public function form_purchase_requisition()
	{	
		$this->data['requisition_approved'] ='';
		$this->data['reqno']=$this->general->get_tbl_data('MAX(pure_reqno) as id','pure_purchaserequisition',array('pure_fyear'=>CUR_FISCALYEAR,'pure_locationid'=>$this->locationid),'pure_reqno','DESC');
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','ASC');
		$this->data['current_user']=$this->session->userdata(USER_NAME);
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','DESC');
		$this->data['reqno']=$this->general->get_tbl_data('MAX(pure_reqno) as id','pure_purchaserequisition',array('pure_fyear'=>CUR_FISCALYEAR,'pure_locationid'=>$this->locationid),'pure_reqno','DESC');
	
		$this->data['requisition_details']=array();
		if(!empty($this->mattypeid))
		{
			$srchmat=array('maty_materialtypeid'=>$this->mattypeid,'maty_isactive'=>'Y');
		}else{
			$srchmat=array('maty_isactive'=>'Y');
		}
		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material','maty_materialtype',$srchmat,'maty_materialtypeid','ASC');

		if(ORGANIZATION_NAME == 'KUKL'){
			$this->load->view('purchase/'.REPORT_SUFFIX.'/v_purchase_requisition_form');
		}else{
			$this->load->view('purchase/v_purchase_requisition_form',$this->data);
		}
		
	}

	public function save_requisition($print = false)
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
			// echo "<pre>"; print_r($this->input->post());die;
			$this->form_validation->set_rules($this->purchase_requisition_mdl->validate_settings_stock_requisition);
			if($this->form_validation->run()==TRUE)
			{
				$trans = $this->purchase_requisition_mdl->purchase_requisition_save();
				if($trans)
				{   
					$print_report = "";
					if($print = "print")
					{ 
						$requisition_details = $this->data['requisition_details'] = $this->general->get_tbl_data('*','pure_purchaserequisition',array('pure_purchasereqid'=>$trans),'pure_purchasereqid','DESC');
						$this->data['purchase_requisition'] = $this->purchase_requisition_mdl->get_purchase_requisition_data(array('rd.purd_reqid'=>$trans));

						$storeid = $requisition_details[0]->pure_storeid;

						$store_name = $this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype', array('eqty_equipmenttypeid'=>$storeid));
						$this->data['store_name'] = $store_name[0]->eqty_equipmenttype;

						$this->data['user_signature'] = $this->general->get_signature($this->userid);

						$approvedby = $requisition_details[0]->pure_approvaluser;

						$this->data['approver_signature'] = $this->general->get_signature($approvedby);

						// $print_report = $this->load->view('purchase/v_purchase_report', $this->data, true);
						$pur_date = !empty($requisition_details[0]->pure_reqdatebs)?$requisition_details[0]->pure_reqdatebs:CURDATE_NP; 

						$store_head_id = $this->general->get_store_post_data($pur_date,'store_head');

						$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);

						if(defined('PUR_REQ_REPORT_TYPE')){
						if(PUR_REQ_REPORT_TYPE == 'DEFAULT'){

							$print_report=$this->load->view('purchase_requisition_details/v_purchase_report',$this->data,true);

						}else{
							
							$print_report=$this->load->view('purchase_requisition_details/'.REPORT_SUFFIX.'/v_purchase_report',$this->data,true);
						}
					}else{

						$print_report=$this->load->view('purchase_requisition_details/v_purchase_report',$this->data,true);
					}
					
						// if(PUR_REQ_REPORT_TYPE == 'DEFAULT'){
						// 	$print_report = $this->load->view('purchase/'.REPORT_SUFFIX.'/v_purchase_report', $this->data, true);

						// 	// $this->load->view('purchase/'.REPORT_SUFFIX.'/v_purchase_requisition_form');

						// }else{
						// 	// $this->load->view('purchase/'.REPORT_SUFFIX.'/v_purchase_requisition_form');

						// 	$print_report = $this->load->view('purchase/v_purchase_report', $this->data, true);
						// 	// $print_report = $this->load->view('purchase/v_purchase_report'.'_'.REPORT_SUFFIX, $this->data, true);
						// }
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
				$array='';
				
				// $this->general->permission_denial_message();
				 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
				exit;
			}
		}
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
			// if($orgid){
			// 	$org_id=$orgid;
			// }
			// else
			// {
			// 	$org_id = $this->session->userdata(ORG_ID); 
			// }
			
			// if($useraccess == 'B')
			// {
			// 	if($orgid)
			// 	{
			// 		$srchcol=array('dist_orgid'=>$org_id);
			// 	}
			// 	else
			// 	{
			// 		$srchcol='';
			// 	}

			// 	$data = $this->analysis_mdl->get_deletedistributors_list($srchcol);
			// }else{
			// 	$data = $this->analysis_mdl->get_deletedistributors_list(array('dist_orgid'=> $org_id));
			// }	
        
	        // echo $this->db->last_query();
	        // die();
	
			// if($result == 'bmin_equipid') {

			// 	$cond = array('dist_postdatead'=>date("Y/m/d"),'dist_orgid'=>$org_id);
			// 	$data = $this->analysis_mdl->get_deletedistributors_list($cond);
			// }
		    // echo "<pre>"; print_r($data); die();
	  	$i = 0;
	  	$data = $this->purchase_requisition_mdl->get_requisition_list();
	  	//echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {
			    $array[$i]["pure_purchasereqid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->pure_purchasereqid.'>'.$row->pure_purchasereqid.'</a>';
			    $array[$i]["reqno"] = $row->pure_reqno;
			   // $array[$i]["manualno"] = $row->rema_manualno;
			    $array[$i]["equipmenttype"] = $row->eqty_equipmenttype; 
			    $array[$i]["requestto"] = $row->pure_requestto;
			    $array[$i]["postdatead"] = $row->pure_reqdatead;
			    $array[$i]["postdatebs"] = $row->pure_reqdatebs;
			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->pure_purchasereqid.' data-displaydiv="orderDetails" data-viewurl='.base_url('purchase_receive/purchase_requisition/purchase_requisition_views/').' class="view" data-heading="View Order Details"  ><i class="fa fa-eye" aria-hidden="true" ></i></a>';
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function purchase_requisition_views()
	{	
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		$this->data['reqno']=$this->general->get_tbl_data('MAX(rema_reqmasterid) as id','rema_reqmaster',false,'rema_reqmasterid','DESC');
		$this->data['items']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','DESC');
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				if($id)
				{ 
					$this->data['purchase_requisition'] = $this->purchase_requisition_mdl->get_purchase_requisition_selected();
					//print_r($this->data['purchase_requisition']);die();
					$template=$this->load->view('purchase/v_purchase_requisition_details',$this->data,true);
				
				if($this->data['purchase_requisition']>0)
				{
						print_r(json_encode(array('status'=>'success','message'=>'','tempform'=>$template)));
		            	exit;
				}
				else{
					print_r(json_encode(array('status'=>'error','message'=>'')));
		            	exit;
				}
					print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','tempform'=>$template)));
		   		 exit;	
				}
			}
		 	else
		    {
		    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		            exit;
		    }
	    }else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}
	
	public function pur_req_book()
	{
		// $this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		 $frmDate = CURMONTH_DAY1;
    	 $toDate = CURDATE_NP;
		if(ORGANIZATION_NAME=='KUKL'){
         $cond='';
		if($frmDate){
			$cond .=" WHERE pure_postdatebs >='".$frmDate."'";
		}
		if($toDate){
				$cond .=" AND pure_postdatebs<='".$toDate."'";
		}else{
			$cond .=" AND pure_postdatebs <='".$frmDate."'";
		}

	 $this->data['status_count'] = $this->purchase_requisition_mdl->getColorStatusCount($cond);
     }else{
	 $this->data['status_count'] = $this->purchase_requisition_mdl->getStatusCountRequisition(array('pure_reqdatebs >='=>$frmDate, 'pure_reqdatebs <='=>$toDate));
	     }

	    if(!empty($this->mattypeid))
		{
			$srchmat=array('maty_materialtypeid'=>$this->mattypeid,'maty_isactive'=>'Y');
		}else{
			$srchmat=array('maty_isactive'=>'Y');
		}
		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material','maty_materialtype',$srchmat,'maty_materialtypeid','ASC');

		//print_r($this->data['reqno']);die;
		$this->data['current_tab']='pur_req_book';
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
			->build('purchase/v_purchse_requisition', $this->data);
	}

	public function generate_pdfReq()
    {
    	$page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}

        $this->data['searchResult'] = $this->purchase_requisition_mdl->get_purchase_requisition_list();

          // echo "<pre>";
          // print_r( $this->data['searchResult']);
          // echo "/pre>";
          // die();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        
        if (ORGANIZATION_NAME == 'KU') {
        	 // echo "<pre>";
          // 	print_r( $this->data['searchResult']);
          // 	echo "/pre>";
          // 	die();
        	$html = $this->load->view('purchase/ku/v_purchase_requisition_download', $this->data, true);
        }
        else
        {
        $html = $this->load->view('purchase/v_purchase_requisition_download', $this->data, true);

        }

        // print_r($html);
        // die();

        $output = 'purchase_requisition_mdl'.date('Y_m_d_H_i').'.pdf';
        
        $this->general->generate_pdf($html,'',$page_size);
    }

    public function exportToExcelReq(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=purchase_requisition_mdl".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->purchase_requisition_mdl->get_purchase_requisition_list();

        $this->data['searchResult'] = $this->purchase_requisition_mdl->get_purchase_requisition_list();
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('purchase/v_purchase_requisition_download', $this->data, true);

        echo $response;
    }

	public function purchase_requisition_summary()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		    $frmDate = !empty($this->input->post('frmdate'))?$this->input->post('frmdate'):'';
        	$toDate = !empty($this->input->post('todate'))?$this->input->post('todate'):'';
        	if(ORGANIZATION_NAME=='KUKL')
        	{
        		$status_count = $this->purchase_requisition_mdl->getStatusCountRequisition_kukl();
        	}
        	else
        	{
        		$status_count = $this->purchase_requisition_mdl->getStatusCountRequisition();
        	}
        	// echo $this->db->last_query();
        	// die();
		    
		     // $color_codeclass=$this->purchase_requisition_mdl->getColorStatusCount();
		    // print_r($status_count);die;

		    print_r(json_encode(array('status'=>'success','status_count'=>$status_count)));
		}

	}

	public function pur_req_list()
	{ 	

		// echo "asd";
		// die();
		$type = !empty($get['apptype'])?$get['apptype']:$this->input->get('apptype');

		$approve_heading_var=$this->lang->line('requisition_information');
		
		if(MODULES_VIEW=='N')
			{
				$array=array();

				// $this->general->permission_denial_message();
				 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
				exit;
			}

		$srch = '';
		 if(ORGANIZATION_NAME=='KUKL'){
		 $color_codeclass=$this->purchase_requisition_mdl->getColorStatusCount();
		    	 foreach ($color_codeclass as $key => $color) {

		    	 	if($type==$color->coco_statusname)
		         	{

		    		$status_val=$color->coco_statusval;
		    		if($status_val=='all'){
		    			$srch =array('pure_isapproved !='=>'');

		    		}else{
		    			$srch =array('pure_isapproved'=>$status_val);
		    		}
		    		
		    	     }
		    	   }
		}else{
			if($type =='approved')
		{
			$srch =array('pure_isapproved'=>'Y');
			//print_r($srch);die;
		}
		if($type =='pending'){
			$srch =array('pure_isapproved'=>'N');
		}
		if($type =='cancel'){
			$srch =array('pure_isapproved'=>'C');
		}

		if($type =='verified'){
			$srch =array('pure_isapproved'=>'V');
		}
		
		}

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	  	$i = 0;
	  	$data = $this->purchase_requisition_mdl->get_purchase_requisition_list($srch);
	  	// echo $this->db->last_query();
	  	// die();
	  	//$data = $this->purchase_requisition_mdl->get_purchase_requisition_list($srch);
	  	// echo "<pre>"; print_r($data); die();
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
			// echo"<pre>";print_r($filtereddata);
			// echo"<pre>";print_r($data);die;
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  		foreach($data as $row)
			{
		    	$approved=$row->pure_isapproved;
		    	$appclass='';
		    	
          if(ORGANIZATION_NAME=='KUKL'){
          	 $color_codeclass=$this->purchase_requisition_mdl->getColorStatusCount();
		    	 foreach ($color_codeclass as $key => $color) {

		    	 	if($approved==$color->coco_statusval)
		         	{
		    		$appclass = $color->coco_button;
		    
		    	     }
		    	   }

          }else{
          	if($approved=='Y')
		    	{
		    		$appclass='success';
		    	}else if($approved == 'C'){
		    		$appclass = 'danger';
		    	}else if($approved == 'V'){
		    		$appclass = 'primary';
		    	}
		    	else{
		    		$appclass='warning';
		    	}

          }

		    	$approvedby = $row->pure_approvaluser;
		    	if(defined('APPROVEBY_TYPE')):
			    	if(APPROVEBY_TYPE == 'USER'){
			    		$approvedby = $row->usma_username;
			    	}else{
			    		$approvedby = (defined('APPROVER_USERNAME') && !empty($row->pure_approvaluser))?APPROVER_USERNAME:$row->pure_approvaluser;
			    	}
		    	endif;

		    	$array[$i]["approvedclass"] = $appclass;
			 	$array[$i]['pure_reqno']=$row->pure_reqno;
			 	$array[$i]['pure_reqmasterid']=!empty($row->pure_reqmasterid)?$row->pure_reqmasterid:'';

			 	// $array[$i]['pure_streqno']=$row->pure_streqno;
			 	if(!empty($row->pure_reqmasterid)){
			 		$array[$i]['pure_streqno']='<a href="javascript:void(0)" data-id='.$row->pure_reqmasterid.' data-displaydiv="orderDetails" data-viewurl='.base_url('issue_consumption/stock_requisition/stock_requisition_views_details').' title="View" class="view " data-heading="View Demand Detail">'.$row->pure_streqno.'</a>';
			 	}else{
			 		$array[$i]['pure_streqno']=$row->pure_streqno;
			 	}

		 		$array[$i]["pure_reqdatead"]=$row->pure_reqdatead;
				$array[$i]["pure_reqdatebs"]=$row->pure_reqdatebs;
				$array[$i]["pure_posttime"]=$row->pure_posttime;
				$array[$i]["pure_fyear"]=$row->pure_fyear;
		 		$array[$i]["requestto"] = '<span style="">'.$row->pure_requestto.'</span>';
		 		$array[$i]["pure_appliedby"]= $row->rema_reqby;
				$array[$i]["user"]=$row->user;
			 	$array[$i]["approvaluser"]=$approvedby;
		 		if(DEFAULT_DATEPICKER=='NP')
		 		{
					$array[$i]["pure_approveddatebs"]=$row->pure_approveddatebs;
		 		}else{
					$array[$i]["pure_approveddatebs"]=$row->pure_approveddatead;
		 		}
			 	$array[$i]["issuetime"]=$row->pure_reqtime;
			 	$array[$i]['mattypename']=!empty($row->maty_material)?$row->maty_material:'';
			 	//$array[$i]['postdate'] = $row->pure_posttime;
			 	//$array[$i]['postdate'] = $row->pure_postdatebs;

			 	 if(DEFAULT_DATEPICKER == 'NP'){
				$array[$i]["postdate"] = $row->pure_postdatebs.'</br> '.$row->pure_posttime;
				}else{
				$array[$i]["postdate"] = $row->pure_postdatead.'</br> '.$row->pure_posttime;
				}
			 	
			 	$disp_var=$this->lang->line('purchase_requisition_detail'); //requested by

			 	if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY' ){
			 		$editbtn='<a href="javascript:void(0)" data-id="'.$row->pure_purchasereqid.'"" data-date="'.$row->pure_purchasereqid.'" data-viewurl="'.base_url('purchase_receive/purchase_requisition').'" class="redirectedit btn-info btn-xxs"><i class="fa fa-edit " title="Edit Requisition" aria-hidden="true"></i></a>';
			 	}else{
			 		$pur_req_edit_group = array('SA');

			 	if(in_array($this->usergroup, $pur_req_edit_group)):
			 		$editbtn='<a href="javascript:void(0)" data-id="'.$row->pure_purchasereqid.'"" data-date="'.$row->pure_purchasereqid.'" data-viewurl="'.base_url('purchase_receive/purchase_requisition').'" class="redirectedit btn-info btn-xxs"><i class="fa fa-edit " title="Edit Requisition" aria-hidden="true"></i></a>';
			 	else:
			 		$editbtn = '';
			 	endif;
			 	}
			 	
			 	$approvedbtn='<a href="javascript:void(0)" title="Approve Requisition" data-viewurl='.base_url('purchase_receive/purchase_requisition/view_requisition').' data-heading="'.$approve_heading_var.'"  class="view  btn-success btn-xxs" data-id='.$row->pure_purchasereqid.'><i class="fa fa-check" aria-hidden="true"></i></a>';

			 	if(MODULES_VIEW=='Y'){

			 		$viewbtn='<a href="javascript:void(0)" data-id='.$row->pure_purchasereqid.' data-displaydiv="orderDetails" data-viewurl='.base_url('purchase_receive/purchase_requisition/purchase_requisition_views_details').' class="view btn-primary btn-xxs" data-heading="'.$disp_var.'" title="Purchase Requisition Details"><i class="fa fa-eye " aria-hidden="true" ></i></a>';
			 	}else{
			 		$viewbtn='';
			 	}
		 		
			 	if($approved == 'Y' || $approved == 'C' || $approved == 'V'){
			 		$array[$i]["action"]=$approvedbtn.$viewbtn;
			 	}else{
			 		if(ORGANIZATION_NAME == 'KUKL'){
			 			$get_puor_from_pure_reqno = $this->general->get_tbl_data('puor_purchaseordermasterid','puor_purchaseordermaster',array('puor_requno'=>$row->pure_reqno,'puor_fyear'=>$row->pure_fyear, 'puor_locationid'=>$row->pure_locationid));
			 			// echo "<pre>";
			 			// print_r ($get_puor_from_pure_reqno);
			 			// echo "</pre>";
			 			// die();
			 			// echo $this->db->last_query();
			 			// die();
			 			$puor_purchaseordermasterid = !empty($get_puor_from_pure_reqno[0]->puor_purchaseordermasterid)?$get_puor_from_pure_reqno[0]->puor_purchaseordermasterid:0;

			 			$ordermasterid = !empty($row->puor_purchaseordermasterid)?$row->puor_purchaseordermasterid:0;

			 			$purd_items_count = $this->purchase_requisition_mdl->get_purd_items_count(array('purd_reqid'=>$row->pure_purchasereqid));

			 			$ttl_count = $purd_items_count[0]->ttl_count;

			 			$proceed_ord_count = $purd_items_count[0]->proceed_ord_count;

			 			$check_request_items = $this->general->get_count_data('purd_itemsid','purd_purchasereqdetail',array('purd_reqid'=>$row->pure_purchasereqid));

			 			$check_purchased_items = $this->general->get_count_data('pude_itemsid','pude_purchaseorderdetail',array('pude_purchasemasterid'=>$puor_purchaseordermasterid));

			 			$pur_btn = '<a href="javascript:void(0)" title="View" data-id='.$ordermasterid.' data-displaydiv="orderDetails" data-viewurl='.base_url('purchase_receive/purchase_order/details_order_views/').' class="view btn-warning btn-xxs" data-heading="'.$this->lang->line('order_detail').'"  ><i class="fa fa-check " aria-hidden="true" ></i></a>';

			 			if($ttl_count >= $proceed_ord_count){
			 				$ver_app_btn = '<a href="javascript:void(0)" title="Verify/Approve Requisition" data-viewurl='.base_url('purchase_receive/purchase_requisition/view_requisition').' data-heading="'.$approve_heading_var.'"  class="view  btn-success btn-xxs" data-id='.$row->pure_purchasereqid.'><i class="fa fa-check" aria-hidden="true"></i></a>';
			 			}else{
			 				$ver_app_btn = ''; // should be '' only for test
			 			}
			 			
			 			if($get_puor_from_pure_reqno == 0){
			 				
			 				if(in_array($this->usergroup, array('BM'))){
			 					if($approved == 'M'){
			 						$array[$i]["action"]=$editbtn.$ver_app_btn.$viewbtn;
			 					}else{
			 						$array[$i]["action"]=$editbtn.$viewbtn;
			 					}
			 					
			 				}else if(in_array($this->usergroup, array('AV'))){
			 					if($row->pure_accountverify > 0){
			 						$array[$i]["action"]=$editbtn.$ver_app_btn.$viewbtn;
			 					}else{
			 						$array[$i]["action"]=$editbtn.$viewbtn;
			 					}
			 				}else{
			 					$array[$i]["action"]=$editbtn.$ver_app_btn.$viewbtn;
			 				}
			 				
			 			}else{
			 				if($check_purchased_items >= $check_request_items){
			 					$array[$i]["action"]=$editbtn.$pur_btn.$viewbtn;
			 				}else{
			 					$array[$i]["action"]=$editbtn.$ver_app_btn.$pur_btn.$viewbtn;
			 				}
			 				
			 			}
			 			
			 		}else{
			 			$array[$i]["action"]=$editbtn.'<a href="javascript:void(0)" title="Verify/Approve Requisition" data-viewurl='.base_url('purchase_receive/purchase_requisition/view_requisition').' data-heading="'.$approve_heading_var.'"  class="view  btn-success btn-xxs" data-id='.$row->pure_purchasereqid.'><i class="fa fa-check" aria-hidden="true"></i></a>'.$viewbtn;
			 		}
			 		
			 	}
		 		
				$i++;
			}
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function view_requisition()
	{
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
		$mastid_id=$this->input->post('id');
		// $this->data['requistion_data']=$this->stock_requisition_mdl->get_requisition_master_data(array('rm.rema_reqmasterid'=>$mastid_id));
		// // echo $this->db->last_query();echo $id;die();
		// $this->data['req_detail_list'] = $this->stock_requisition_mdl->get_requisition_details_data(array('rd.rede_reqmasterid'=>$mastid_id));
		//echo "<pre>";print_r($this->data['req_detail_list']);die();

		$this->data = array();
		// echo "test";
		// die();

		// $this->data['requistion_data'] = $this->general->get_tbl_data('*','pure_purchaserequisition',array('pure_purchasereqid'=>$mastid_id),'pure_purchasereqid','DESC');

		$this->data['requistion_data'] = $this->purchase_requisition_mdl->get_purchase_requisition_master_data(array('pure_purchasereqid'=>$mastid_id));
		$this->data['req_detail_list'] = $this->purchase_requisition_mdl->get_purchase_requisition_data(array('rd.purd_reqid'=>$mastid_id));
		// echo "<pre>";print_r($this->data['req_detail_list']);die();

		$is_account_verify = $this->data['requistion_data'][0]->pure_accountverify;
		// if verified by accountant, show capital items only
		if(!empty($is_account_verify) && $this->usergroup == 'AV'){
			// $this->data['mat_type']=$this->general->get_tbl_data('*','maty_materialtype',array('maty_isactive'=>'Y', 'maty_materialtypeid'=>'2'));	
			$this->data['mat_type']=$this->general->get_tbl_data('*','maty_materialtype',array('maty_isactive'=>'Y', 'maty_materialtypeid !='=>'3'));	
		}else{
			$this->data['mat_type']=$this->general->get_tbl_data('*','maty_materialtype',array('maty_isactive'=>'Y',  'maty_materialtypeid !='=>'3'));
		}

		$this->data['proceed_purchase_count'] = 0;
		if($this->usergroup == 'PR'){
			$this->data['proceed_purchase_count'] = $this->general->get_count_data('purd_proceedorder','purd_purchasereqdetail',array('purd_reqid'=>$mastid_id,'purd_proceedorder'=>'Y'));

		}

		$this->data['purd_items_count'] = $this->purchase_requisition_mdl->get_purd_items_count(array('purd_reqid'=>$mastid_id));
		$this->data['purd_items_count_new'] = $this->purchase_requisition_mdl->get_purd_items_count_new(array('purd_reqid'=>$mastid_id));

		// echo $this->db->last_query();
		// die();

		if($this->usergroup == 'AV'):
			$user_data = $this->general->get_tbl_data('usma_accountlvl','usma_usermain',array('usma_userid'=>$this->userid));

			$this->data['user_accountlvl'] = $user_data[0]->usma_accountlvl;
		else:
			$this->data['user_accountlvl'] = 0;
		endif;

		$this->data['accountant_verification_history'] = $this->purchase_requisition_mdl->get_account_verification_history($mastid_id, 'pure_accountverify');

		$this->data['account_verifier_list'] = $this->general->get_user_list_by_group(false, false,'usma_accountlvl',false,array('BM','AV'),$this->userid);

		$tempform='';
		// $tempform=$this->load->view('purchase/v_purchase_requisition_view',$this->data,true);
		// echo PURCHASE_REQ_VIEW;
		// die();
		if(defined('PURCHASE_REQ_VIEW')):
            if(PURCHASE_REQ_VIEW == 'DEFAULT'){
                $tempform=$this->load->view('purchase_requisition_details/v_purchase_requisition_view',$this->data,true);
            }else{
            	
            	$tempform=$this->load->view('purchase_requisition_details/'.REPORT_SUFFIX.'/v_purchase_requisition_view',$this->data,true);
            }
        else:
            $tempform=$this->load->view('purchase_requisition_details/v_purchase_requisition_view',$this->data,true);
        endif;

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
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}

	public function purchase_requisition_reprint()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				if($id)
				{ 
					$requisition_details = $this->data['requisition_details'] = $this->general->get_tbl_data('*','pure_purchaserequisition',array('pure_purchasereqid'=>$id),'pure_purchasereqid','DESC');
					$this->data['purchase_requisition'] = $this->purchase_requisition_mdl->get_purchase_requisition_data(array('rd.purd_reqid'=>$id));
					//echo"<pre>";print_r($this->data['purchase_requisition']);die();

					$storeid = $requisition_details[0]->pure_storeid;

					$store_name = $this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype', array('eqty_equipmenttypeid'=>$storeid));
					$this->data['store_name'] = !empty($store_name[0]->eqty_equipmenttype)?$store_name[0]->eqty_equipmenttype:'';

					$this->data['user_signature'] = $this->general->get_signature($this->userid);

					$approvedby = $requisition_details[0]->pure_approvaluser;

					$this->data['approver_signature'] = $this->general->get_signature($approvedby);

					// $template=$this->load->view('purchase/v_purchase_report',$this->data,true);

					$pur_date = !empty($requisition_details[0]->pure_reqdatebs)?$requisition_details[0]->pure_reqdatebs:CURDATE_NP; 
					$store_head_id = $this->general->get_store_post_data($pur_date,'store_head');
					$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);

					// FOR KUKL

					if(ORGANIZATION_NAME == 'KUKL'):
						$this->data['account_action_log'] = $this->general->get_username_from_actionlog(array('aclo_masterid'=>$id, 'aclo_tablename'=>'pure_purchaserequisition','aclo_fieldname'=>'pure_accountverify'));
					endif;
					// echo PUR_REQ_REPORT_TYPE;
					// die();
					if(defined('PUR_REQ_REPORT_TYPE')){

						// echo "sasdasded";
						// die();
						if(PUR_REQ_REPORT_TYPE == 'DEFAULT'){

							$template=$this->load->view('purchase_requisition_details/v_purchase_report',$this->data,true);

						}else{
							
							$template=$this->load->view('purchase_requisition_details/'.REPORT_SUFFIX.'/v_purchase_report',$this->data,true);
						}
					}else{
						// echo "sed";
						// die();
						$template=$this->load->view('purchase_requisition_details/v_purchase_report',$this->data,true);
					}

				if($this->data['purchase_requisition']>0)
				{
					print_r(json_encode(array('status'=>'success','message'=>'','tempform'=>$template)));
		            exit;
				}
				else{
					print_r(json_encode(array('status'=>'error','message'=>'')));
		            	exit;
				}
					print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','tempform'=>$template)));
		   		 exit;	
				}
			}
		 	else
		    {
		    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		            exit;
		    }
	    }else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}

	public function purchase_requisition_views_details()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				if($id)
				{  
					// $this->data['requisition_details'] = $this->general->get_tbl_data('*','pure_purchaserequisition',array('pure_purchasereqid'=>$id),'pure_purchasereqid','DESC');
					$requisition_details = $this->data['requisition_details'] = $this->purchase_requisition_mdl->get_purchase_requisition_master_data(array('pure_purchasereqid'=>$id));
					  // echo"<pre>";print_r($this->data['requisition_details']);die();

					$this->data['purchase_requisition'] = $this->purchase_requisition_mdl->get_purchase_requisition_data(array('rd.purd_reqid'=>$id));
					 // echo"<pre>";print_r($this->data['requisition_details']);die();

					$is_account_verify = $requisition_details[0]->pure_accountverify;
					// if verified by accountant, show capital items only
					if(!empty($is_account_verify) && $this->usergroup == 'AV'){
						$this->data['mat_type']=$this->general->get_tbl_data('*','maty_materialtype',array('maty_isactive'=>'Y', 'maty_materialtypeid'=>'2'));	
					}else{
						$this->data['mat_type']=$this->general->get_tbl_data('*','maty_materialtype',array('maty_isactive'=>'Y'));
					}

					$this->data['accountant_verification_history'] = $this->purchase_requisition_mdl->get_account_verification_history($id, 'pure_accountverify');

					$this->data['account_verifier_list'] = $this->general->get_user_list_by_group(false, false,'usma_accountlvl',false,array('AO','AV'),$this->userid);
					
					if($this->usergroup == 'AV'):
						$user_data = $this->general->get_tbl_data('usma_accountlvl','usma_usermain',array('usma_userid'=>$this->userid));

						$this->data['user_accountlvl'] = $user_data[0]->usma_accountlvl;
					else:
						$this->data['user_accountlvl'] = 0;
					endif;

					$template=$this->load->view('purchase_requisition_details/v_purchase_requisition_details_view',$this->data,true);

					if(defined('PURCHASE_REQ_VIEW')):
			            if(PURCHASE_REQ_VIEW == 'DEFAULT'){
			                $template=$this->load->view('purchase_requisition_details/v_purchase_requisition_details_view',$this->data,true);
			            }else{
			            	$template=$this->load->view('purchase_requisition_details/'.REPORT_SUFFIX.'/v_purchase_requisition_details_view',$this->data,true);
			            }
			        else:
			            $template=$this->load->view('purchase_requisition_details/v_purchase_requisition_details_view',$this->data,true);
			        endif;

					if($this->data['purchase_requisition']>0)
					{
						print_r(json_encode(array('status'=>'success','message'=>'','tempform'=>$template)));
			            exit;
					}
					else{
						print_r(json_encode(array('status'=>'error','message'=>'')));
			            	exit;
					}
						print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','tempform'=>$template)));
			   		 exit;	
				}
			}
		 	else
		    {
		    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		            exit;
		    }
	    }else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}

	public function purchase_requisition_details()
	{
		
		$this->data['current_tab']='detail_list';

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
			->build('purchase/v_purchse_requisition', $this->data);
	}

	public function generate_pdfReqDetail()
    {
    	  $page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}

        $this->data['searchResult'] = $this->purchase_requisition_mdl->get_purchase_requisition_details_list();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        /* echo "<pre>";
         print_r($this->data['searchResult']);
         echo "</pre>";*/
        
        if (ORGANIZATION_NAME == 'KU') {

        		// echo "string";
        	 //    die();
        	$html = $this->load->view('purchase/ku/v_purchse_requisition_datail_download', $this->data, true);

        }
        else
        {

        $html = $this->load->view('purchase/v_purchase_requisition_detail_download', $this->data, true);
        }

        $output = 'purchase_requisition_mdl'.date('Y_m_d_H_i').'.pdf';
        
        $this->general->generate_pdf($html,'',$page_size);
    }

    public function exportToExcelReqDetail(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=purchase_requisition_mdl".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->purchase_requisition_mdl->get_purchase_requisition_details_list();

        $this->data['searchResult'] = $this->purchase_requisition_mdl->get_purchase_requisition_details_list();
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('purchase/v_purchase_requisition_detail_download', $this->data, true);

        echo $response;
    }

	public function purchase_requisition_details_list()
	{
		//echo MODULES_VIEW;die;

		if(MODULES_VIEW=='N')
			{
				$array=array();
			 // $this->general->permission_denial_message();
			 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
			}
		
		$type = !empty($get['apptype'])?$get['apptype']:$this->input->get('apptype');

		$srch = '';
		if($type =='approved')
		{
			$srch =array('pure_isapproved'=>'Y');
			//print_r($srch);die;
		}
		if($type =='pending'){
			$srch =array('pure_isapproved'=>'N');
		}
		if($type =='cancel'){
			$srch =array('pure_isapproved'=>'C');
		}
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	  	$i = 0;
	  	$data = $this->purchase_requisition_mdl->get_purchase_requisition_details_list($srch);
	  	// echo "<pre>";print_r($data); die();
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  		foreach($data as $row)
			{
				if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
                }else{ 
                    $req_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
                }
                
		    	$approved=$row->pure_isapproved;
		    	if($approved=='Y')
		    	{
		    		$appclass='success';
		    	}else if($approved == 'C'){
		    		$appclass = 'danger';
		    	}else{
		    		$appclass='warning';
		    	}
		    	$array[$i]["approvedclass"] = $appclass;
			 	$array[$i]['pure_reqno']=$row->pure_reqno;
		 		if(DEFAULT_DATEPICKER=='NP')
		 		{
					$array[$i]["pure_reqdatebs"]=$row->pure_reqdatebs;
		 		}else{
					$array[$i]["pure_reqdatebs"]=$row->pure_reqdatead;
		 		}
			 	$array[$i]["user"]=$row->user;
			 	$array[$i]["itli_itemname"]=$req_itemname;;
			 	$array[$i]["purd_qty"]=sprintf('%g',$row->purd_qty);
			 	$array[$i]["purd_remarks"]=$row->purd_remarks;
			 	$array[$i]["purd_unit"]=$row->purd_unit;
			 	$array[$i]["pure_posttime"]=$row->pure_posttime;
			 	$array[$i]["pure_fyear"]=$row->pure_fyear;
			 	$array[$i]["approvaluser"]=$row->usma_username;
		 		if(DEFAULT_DATEPICKER=='NP')
		 		{
					$array[$i]["pure_approveddatebs"]=$row->pure_approveddatebs;
		 		}else{
					$array[$i]["pure_approveddatebs"]=$row->pure_approveddatead;
		 		}
			 	$array[$i]["issuetime"]=$row->pure_reqtime;
			 	$array[$i]["pure_appliedby"]=$row->pure_appliedby;
				$i++;
			}
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
    }

    public function load_pur_reqisition_for_quotation(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {	
				$this->data['requistion_departments']= '';
				$this->data['detail_list'] = '';
				$this->data['fiscal_yrs']=$this->input->post('fiscalyear');
				// echo $this->fiscal_yrs;
				// die();

				$tempform=$this->load->view('purchase_requisition_details/v_pur_requisition_list_modal_quot',$this->data,true);

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

	public function get_pur_requisition_list_quot(){
		if(MODULES_VIEW=='N')
		{
		  	$array=array();
            echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));
            exit;
		}
		
		$fiscalyear= !empty($this->input->get('fiscalyear'))?$this->input->get('fiscalyear'):$this->input->post('fiscalyear');

		$searcharray = array('pr.pure_fyear'=>$fiscalyear,'pr.pure_storeid'=>$this->storeid,'pr.pure_locationid'=>$this->locationid);

		$this->data['detail_list'] = '';

		$data = $this->purchase_requisition_mdl->get_pur_requisition_list_db_quot($searcharray);
		// echo $this->db->last_query();
		// die()
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
		    	$array[$i]["masterid"] = !empty($row->pure_purchasereqid)?$row->pure_purchasereqid:'';
			    $array[$i]["req_no"] = !empty($row->pure_reqno)?$row->pure_reqno:'';
			    $array[$i]["date_bs"] = !empty($row->pure_reqdatebs)?$row->pure_reqdatebs:'';
			    $array[$i]["date_ad"] = !empty($row->pure_reqdatead)?$row->pure_reqdatead:'';
			    $array[$i]["appliedby"] = !empty($row->pure_appliedby)?$row->pure_appliedby:'';
			    $array[$i]["store"] = !empty($row->eqty_equipmenttype)?$row->eqty_equipmenttype:'';
			    $array[$i]["storeid"] = !empty($row->eqty_equipmenttypeid)?$row->eqty_equipmenttypeid:'';
			    $array[$i]["requestto"] = !empty($row->pure_requestto)?$row->pure_requestto:'';
			    
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function load_detail_list_quot($new_order = false){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->load->Model('purchase_order_mdl');
			$masterid = $this->input->post('masterid');

			$detail_list = $this->data['detail_list'] = $this->purchase_order_mdl->get_pur_requisition_details(array('purd_reqid'=>$masterid, 'purd_remqty >'=>0));

			// echo $this->db->last_query();
			// die();

			$this->data['distributor']=$this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');
			if(empty($detail_list)){
				$isempty = 'empty';
			}else{
				$isempty = 'not_empty';
			}
			if($new_order == 'new_detail_list'){
				$tempform=$this->load->view('purchase/v_pur_requisition_detail_append_quot',$this->data,true);
			}else{
				$tempform=$this->load->view('purchase/v_pur_requisition_detail_modal_quot',$this->data,true);
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

	public function load_detail_list_req($new_order = false){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->load->model('purchase_order_mdl');
			$requisitionno = $this->input->post('requisitionno');
		// 	print_r($requisitionno);
		// die();
			$fiscalyear = $this->input->post('fiscalyear');

			$reqmaster_data=$this->general->get_tbl_data('*','pure_purchaserequisition',array('pure_fyear'=>$fiscalyear,'pure_reqno'=>$requisitionno,'pure_locationid'=>$this->locationid ));

			if(!empty($reqmaster_data))
			{
				$masterid=$reqmaster_data[0]->pure_purchasereqid;

				$this->data['detail_list'] = $this->purchase_order_mdl->get_pur_requisition_details(array('purd_reqid'=>$masterid, 'purd_remqty >'=>0));

				$tempform=$this->load->view('purchase/v_pur_requisition_detail_append_quot',$this->data,true);
			
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
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Requisition Number Cannnot Match')));
		            exit;
			}

		}else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}

	public function change_status()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// echo MODULES_APPROVE;
			// die();
			if(MODULES_APPROVE=='N')
			{
 				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}

			$get_approve_status = $this->input->post('pure_isapproved');
			if($get_approve_status =='')
			{
				print_r(json_encode(array('status'=>'error','message'=>'You Need to Select Atleast One Option !!! ')));
				exit;
			}
			
			$status='';
			if($get_approve_status == "N")
			{
				$status = "N";
			}
			if($get_approve_status == "Y")
			{
				$status = "Y";
			}

			if($get_approve_status == "C")
			{
				$status = "C";
			}

			if($get_approve_status == "V")
			{
				$status = "V";
			}

			//print_r($status);die;
			$trans  = $this->purchase_requisition_mdl->purchase_requisition_change_status($status);
			if($trans)
			{
				print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
				exit;
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful. Please try again!')));
				exit;
			}
		}else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}
	public function load_supplier_list(){
		try{
			$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');

			$reqno = $this->input->post('requisitionno');
			$fyear = $this->input->post('fiscalyear');

			if($reqno){
				$quotation_supplier = $this->quotation_mdl->get_suppliers_by_fyear_reqno($reqno, $fyear);

				$dist = '';
				if(!empty($quotation_supplier)){
					foreach($quotation_supplier as $supp){
						$dist.= $supp->dist_distributorid.',';
					}
				}
				
				$dist = rtrim($dist,',');

				$dist = explode(',',$dist);
				$this->data['quotation_supplier'] = $dist;
			}else{
				$this->data['quotation_supplier'] = array();
			}

			$tempform = $this->load->view('purchase/v_purchase_requisition_list',$this->data,true);	

			if(!empty($tempform))
			{
					print_r(json_encode(array('status'=>'success','message'=>'View Open Success','tempform'=>$tempform)));
	            	exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));
	            	exit;
			}
			
		}catch(Exception $e){
			throw $e;
		}
	}

	public function update_estimate_amount(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$status = "V";

			$trans  = $this->purchase_requisition_mdl->update_estimate_amount($status);
			if($trans)
			{
				$streqno = $this->input->post('streqno');
				// send message to accont after updating estimate amount

				$msg_params = array(
	            	'DEMAND_NO'=>$streqno
	            );
	            $this->general->send_message_params('update_estimate_amount', $msg_params);

				print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
				exit;
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful. Please try again!')));
				exit;
			}
		}else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}	
	}

	public function update_qty_to_provide(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// $status = "V";
			$trans  = $this->purchase_requisition_mdl->update_qty_to_provide();
			if($trans)
			{
				$streqno = $this->input->post('streqno');
				$fyear = $this->input->post('fyear');
				// send message to store after updating demand quantity

				$get_post_by = $this->general->get_tbl_data('rema_postby','rema_reqmaster',array('rema_reqno'=>$streqno, 'rema_fyear' => $fyear, 'rema_locationid'=>$this->locationid));
				$mess_userid = $get_post_by[0]->rema_postby;
				$message = 'Budget was not available for this product';
				$mess_title = $mess_message = $message;
				$mess_path = 'issue_consumption/stock_requisition/requisition_list';
				$this->general->send_message_to_user($mess_userid, $mess_title, $mess_message, $mess_path, 'S');

				print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
				exit;
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful. Please try again!')));
				exit;
			}
		}else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}	
	}

	public function proceed_to_purchase_order(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$trans  = $this->purchase_requisition_mdl->proceed_to_purchase_order();

			 // $trans  = $this->purchase_requisition_mdl->save_pur_req_log();

			if($trans)
			{
				$streqno = $this->input->post('streqno');
				// send message to procurement dep if budget available

				$mess_user = array('PR');

				$message = "Budget is available for items in demand No. $streqno";

				$mess_title = $mess_message = $message;

				$mess_path = 'purchase_receive/purchase_requisition/pur_req_book';

				$this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'G');

				print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
				exit;

				print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
				exit;
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Operation Error')));
				exit;
			}

		}else
	    {
	      	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	    	exit;
	    }
	}

	public function notify_budget_unavailable(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$trans  = $this->purchase_requisition_mdl->notify_budget_unavailable();
			
			$req_no = $this->input->post('req_no');
			$fyear = $this->input->post('fyear');

			$get_post_by = $this->general->get_tbl_data('rema_postby','rema_reqmaster',array('rema_reqno'=>$req_no, 'rema_fyear' => $fyear,'rema_locationid'=>$this->locationid));

			$mess_userid = $get_post_by[0]->rema_postby;

			$message = 'Budget was not available for this product';

			$mess_title = $mess_message = $message;

			$mess_path = 'issue_consumption/stock_requisition/requisition_list';

			$this->general->send_message_to_user($mess_userid, $mess_title, $mess_message, $mess_path, 'S');

			if($trans)
			{
				print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
				exit;
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Operation Error')));
				exit;
			}

		}else
	    {
	      	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	    	exit;
	    }
	}

	public function send_to_purchase_order_approval(){
		// print_r($this->input->post());
		// die();
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$trans  = $this->purchase_requisition_mdl->send_to_purchase_order_approval();

			if($trans)
			{
				$approve_status = $this->input->post('approve_status');
				$streqno = $this->input->post('req_no');

				if($approve_status == 'M'):
					// send to approval from branch manager

					$msg_params = array(
		            	'DEMAND_NO'=>$streqno
		            );
		            $this->general->send_message_params('send_to_purchase_order_approval_bm', $msg_params);
		        elseif($approve_status == 'P'):
					// approved message

					$msg_params = array(
		            	'DEMAND_NO'=>$streqno
		            );
		            $this->general->send_message_params('send_to_purchase_order_approval_pr', $msg_params);
				
				elseif($approve_status == 'S'):
					// approved message

					$mess_user = array('PH');

					$message = "Request for procurement for demand No. $streqno has been approved By Procurement Head. please Approve this.";

					$mess_title = $mess_message = $message;

					$mess_path = 'purchase_receive/purchase_requisition/pur_req_book';

					$this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'G');
				elseif($approve_status == 'D'):
					// approved message

					$mess_user = array('PH');

					$message = "Request for procurement for demand No. $streqno has been approved By Procurement Head. Please Verify it.";

					$mess_title = $mess_message = $message;

					$mess_path = 'purchase_receive/purchase_requisition/pur_req_book';

					$this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'G');
					
				elseif($approve_status == 'Y'):
					// approved message

					$mess_user = array('PR');

					$message = "Request for procurement for demand No. $streqno has been approved by procurement head You can order.";

					$mess_title = $mess_message = $message;

					$mess_path = 'purchase_receive/purchase_requisition/pur_req_book';

					$this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'G');

				elseif($approve_status == 'R'):
					
					// reject message

					$mess_user = array('PR');

					$message = "Request for procurement for demand No. $streqno has been rejected.";

					$mess_title = $mess_message = $message;

					$mess_path = 'purchase_receive/purchase_requisition/pur_req_book';

					$this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'G');
				endif;

				print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
				exit;
			}
			else
			{
				// need to check trans 
				// print_r(json_encode(array('status'=>'error','message'=>'Operation Error')));
				print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
				exit;
			}

		}else
	    {
	      	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	    	exit;
	    }
	}

	public function procced_to_next_accountant(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$trans  = $this->purchase_requisition_mdl->procced_to_next_accountant();

			if($trans)
			{

				print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
				exit;
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Operation Error')));
				exit;
			}

		}else
	    {
	      	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	    	exit;
	    }
	}

	public function procced_to_next_accountant_verifier(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$trans  = $this->purchase_requisition_mdl->procced_to_next_accountant_verifier();

			if($trans)
			{

				print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
				exit;
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Operation Error')));
				exit;
			}

		}else
	    {
	      	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	    	exit;
	    }
	}

}