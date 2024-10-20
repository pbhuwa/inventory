<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Asset_issue_mdl extends CI_Model
{
	public function __construct(){
        parent::__construct();
        $this->userid = $this->session->userdata(USER_ID);
        $this->username = $this->session->userdata(USER_NAME);
        $this->curtime = $this->general->get_currenttime();
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
        $this->locationid = $this->session->userdata(LOCATION_ID);
        $this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
        $this->orgid = $this->session->userdata(ORG_ID);
        $this->assetIssueMasterTable = 'asim_assetissuemaster';
        $this->assetIssueDetailTable = 'asid_assetissuedetail';
    }

    public $validate_asset_issue = array(
		array('field' => 'asim_depid', 'label' => 'Department ', 'rules' => 'trim|required'),
		array('field' => 'asim_requisitionno', 'label' => 'Requisition No. ', 'rules' => 'trim|required'),
		array('field' => 'requisition_date', 'label' => 'Requisition Date ', 'rules' => 'trim|required'),
		array('field' => 'issue_date', 'label' => 'Issue Date ', 'rules' => 'trim|required'),
		array('field' => 'asid_itemsid[]', 'label' => 'Items  ', 'rules' => 'trim|required'),
		array('field' => 'assetslist[][]', 'label' => 'Issued Assets', 'rules' => 'required'),
		array('field' => 'qtyinstock[]', 'label' => 'Stock Qty  ', 'rules' => 'trim|required|numeric|greater_than[0]'),
	);

	public $validate_asset_issue_edit = array(
		array('field' => 'asim_depid', 'label' => 'Department ', 'rules' => 'trim|required'),
		array('field' => 'asim_requisitionno', 'label' => 'Requisition No. ', 'rules' => 'trim|required'),
		array('field' => 'requisition_date', 'label' => 'Requisition Date ', 'rules' => 'trim|required'),
		array('field' => 'issue_date', 'label' => 'Issue Date ', 'rules' => 'trim|required'),
		array('field' => 'asid_itemsid[]', 'label' => 'Items  ', 'rules' => 'trim|required'),
		array('field' => 'assetslist[][]', 'label' => 'Issued Assets', 'rules' => 'required'),
	);

    public function get_requisition_details($srchcol = false){

    	$stock_count = "SELECT COUNT('*') as cnt FROM xw_asen_assetentry ae WHERE asen_staffid = 0 AND ae.asen_description=it.itli_itemlistid";
		$asset_list = "SELECT GROUP_CONCAT(CONCAT_WS('@',asen_asenid,asen_assetcode)) FROM xw_asen_assetentry ae WHERE asen_staffid = 0 AND ae.asen_description = it.itli_itemlistid";

		// $this->db->select("rd.*,($stock_count) as stock_qty, ($asset_list) as asset_list");
		// $this->db->from('rede_reqdetail rd');
		// $this->db->join('itli_itemslist il', 'il.itli_itemlistid=rd.rede_itemsid', 'LEFT');
		// $this->db->where(array('rede_reqmasterid' => $reqmasterid));
		// $rslt_detail = $this->db->get()->result();
 
        $this->db->select("it.itli_itemcode, it.itli_itemname, it.itli_itemnamenp, it.itli_itemlistid, it.itli_purchaserate, it.itli_salesrate, rd.rede_reqdetailid, rd.rede_itemsid, rm.*,rd.rede_qty,rd.rede_remqty,rd.rede_reqmasterid, ut.unit_unitname, rd.rede_qtyinstock,($stock_count) as stockqty,($asset_list) as asset_list,rd.rede_remarks");
        $this->db->from('rede_reqdetail rd');
        $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid=rd.rede_reqmasterid','LEFT');
        $this->db->join('itli_itemslist it','it.itli_itemlistid = rd.rede_itemsid','left');
        $this->db->join('unit_unit ut','it.itli_unitid = ut.unit_unitid','left');

        if($srchcol){
            $this->db->where($srchcol);
        }
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
        return false;
    }

    public function check_issue_asset_stock($itemsid)
    {
    	// $stock_count = "SELECT COUNT('*') as cnt FROM xw_asen_assetentry ae WHERE asen_staffid = 0 AND ae.asen_description=it.itli_itemlistid";

    	$this->db->select("COUNT('*') as stockqty");
        $this->db->from('xw_asen_assetentry ae');
        $this->db->where('asen_staffid',0);
       
        if($itemsid){
            $this->db->where(array('ae.asen_description'=>$itemsid));
        }

        $query = $this->db->get();
        
        if($query->num_rows() > 0){
            $result = $query->row();
            return $result->stockqty;
        }
        return false;
    }

    public function save_asset_issue()
    {
    	try{
			// $postdata=$this->input->post();
			// echo "<pre>";print_r($postdata);die();
			$id = $this->input->post('id');
			$req_date=$this->input->post('requisition_date');
			$issue_date=$this->input->post('issue_date');
			if(DEFAULT_DATEPICKER=='NP')
			{   
				$reqdateNp = $req_date;
				$reqdateEn = $this->general->NepToEngDateConv($req_date);
				$issuedateNp = $issue_date;
				$issuedateEn = $this->general->NepToEngDateConv($issue_date);
			}
			else
			{
				$reqdateEn = $req_date;
				$reqdateNp = $this->general->EngtoNepDateConv($req_date);
				$issuedateEn = $issue_date;
				$issuedateNp = $this->general->EngtoNepDateConv($issue_date);
			}
			
			$depid=$this->input->post('asim_depid');
			$depname = $this->input->post('asim_depname');
			$locationid = !empty($this->input->post('asim_locationid'))?$this->input->post('asim_locationid'):$this->locationid;
			if($depid){
				$depdata=$this->general->get_tbl_data('dept_depname','dept_department',array('dept_depid'=>$depid),'dept_depid','DESC');
				if(!empty($depdata)){
					$depname=!empty($depdata[0]->dept_depname)?$depdata[0]->dept_depname:'Y';
				}
			}else{
				$depname='';
			}
			$req_no=$this->input->post('asim_requisitionno');
			$fiscal_year = $this->input->post('asim_fyear');
			$issue_no = $this->input->post('asim_issueno');
			$locationid=$this->session->userdata(LOCATION_ID);
			$currentfyrs=CUR_FISCALYEAR;

			$cur_fiscalyrs_invoiceno = $this->db->select('asim_issueno,asim_fyear')
			->from('asim_assetissuemaster')
			->where('asim_locationid', $locationid)
			->order_by('asim_fyear', 'DESC')
			->limit(1)
			->get()->row();
		
			if (!empty($cur_fiscalyrs_invoiceno)) {
				$invoice_format = $cur_fiscalyrs_invoiceno->asim_issueno;
				$invoice_string = str_split($invoice_format);
				$invoice_prefix_len = strlen(INVOICE_NO_PREFIX);
				$chk_first_string_after_invoice_prefix = $invoice_string[$invoice_prefix_len];
				if ($chk_first_string_after_invoice_prefix == '0') {
					$invoice_no_prefix = INVOICE_NO_PREFIX . CUR_FISCALYEAR;
				} else if ($cur_fiscalyrs_invoiceno->asim_fyear == $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
					$invoice_no_prefix = INVOICE_NO_PREFIX . CUR_FISCALYEAR;
				} else if ($cur_fiscalyrs_invoiceno->asim_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
					$invoice_no_prefix = INVOICE_NO_PREFIX . CUR_FISCALYEAR;
				} else if ($cur_fiscalyrs_invoiceno->asim_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix != '0') {
					$invoice_no_prefix = INVOICE_NO_PREFIX . CUR_FISCALYEAR;
				} else {
					$invoice_no_prefix = INVOICE_NO_PREFIX;
				}
			} else {
				$invoice_no_prefix = INVOICE_NO_PREFIX . CUR_FISCALYEAR;
			}
		
			$issue_no = $this->general->generate_invoiceno('asim_issueno', 'asim_issueno', 'asim_assetissuemaster', $invoice_no_prefix, INVOICE_NO_LENGTH, false, 'asim_locationid', 'asim_asimid', 'S', 'DESC'); 

			// $issue_no = $this->input->post('asim_issueno');
			$unit = $this->input->post('unit');
			$reqmasterid = $this->input->post('asim_remamasterid');
			$received_by = $this->input->post('received_by');
			$staff_id = '';
			$staff_name = '';
			if(!empty($received_by)){
				$staff = explode('@',$received_by);
				$staff_id = $staff[0];
				$staff_name = $staff[1];
			}
			//detail table data
			$itemsid = $this->input->post('asid_itemsid');
			$qtyinstock = $this->input->post('qtyinstock');
			$unitrate = $this->input->post('asid_unitrate'); 
			$issued_assets = $this->input->post('assetslist');
			$remarks = $this->input->post('asid_remarks');
			$asim_remarks = $this->input->post('asim_remarks');
			$itemsname = $this->input->post('asid_itemsname');
			$my_rem_qty=$this->input->post('my_rem_qty');
			$volume = $this->input->post('volume');
			$reqqty = $this->input->post('reqqty');
			$s_no = $this->input->post('s_no');
			$rede_reqdetailid = $this->input->post('rede_reqdetailid');
			$this->db->trans_begin();
			
			$assetIssueMaster = array(
					'asim_depid' => $depid, 
					'asim_fyear' => $fiscal_year,
					'asim_reqno' => $req_no,
					'asim_issueno' => $issue_no,
					'asim_issuedatead' => $issuedateEn,
					'asim_issuedatebs' => $issuedateNp,
					'asim_reqdatead' => $reqdateEn,
					'asim_reqdatebs' => $reqdateNp,
					'asim_remamasterid' => $reqmasterid,
					'asim_staffid' => $staff_id,
					'asim_staffname' => $staff_name,
					'asim_remarks'=>$asim_remarks,
					'asim_status'=>'O',
					'asim_postdatead'=>CURDATE_EN,
					'asim_postdatebs'=>CURDATE_NP,
					'asim_posttime' => $this->curtime,
					'asim_postby'=>$this->userid,
					'asim_postmac'=>$this->mac,
					'asim_postip'=>$this->ip,
					'asim_locationid'=>$locationid, 
					'asim_orgid'=>$this->orgid                             
				);

				if(!empty($assetIssueMaster)){

					$this->db->insert($this->assetIssueMasterTable,$assetIssueMaster);
					$insertid = $this->db->insert_id();
					if($insertid){
						$ReqMasterArray = array('rema_received'=>'1');
						if($ReqMasterArray){
							$this->general->save_log('rema_reqmaster','rema_reqno',$req_no,$ReqMasterArray,'Update');
							$this->db->update('rema_reqmaster',$ReqMasterArray,array('rema_reqno'=>$req_no,'rema_fyear'=>$fiscal_year,'rema_reqmasterid' => $reqmasterid));
						}

						if(!empty($itemsid)){
						$assets_id = [];
						foreach($itemsid as $key => $val){
							$issue_qty = count($issued_assets[$key]);
							foreach($issued_assets[$key] as $asset){
								$assets_id[] = $asset; 
							} 
							$assetIssueDetail[] = array(
								'asid_asimid' => $insertid,
								'asid_itemid' => $val,
								'asid_assdesc' => $itemsname[$key],
								'asid_redeid' => $rede_reqdetailid[$key],
								'asid_reqqty' => $reqqty[$key],
								'asid_duringstoreqty' => $qtyinstock[$key],
								'asid_issqty' => $issue_qty,
								'asid_curissqty' => $issue_qty,
								'asid_assetid' => implode(',', $issued_assets[$key]),
								'asid_remarks' => $remarks[$key],
								'asid_postdatead'=>CURDATE_EN,
								'asid_postdatebs'=>CURDATE_NP,
								'asid_posttime' => $this->curtime,
								'asid_postby'=>$this->userid,
								'asid_postmac'=>$this->mac,
								'asid_postip'=>$this->ip,
								'asid_locationid'=>$locationid, 
								'asid_orgid'=>$this->orgid 

							);
								
							$reqDetail[] = array(
								'rede_reqdetailid' => !empty($rede_reqdetailid[$key])?$rede_reqdetailid[$key]:'',
								'rede_remqty' => !empty($my_rem_qty[$key])?$my_rem_qty[$key]:'',
								'rede_modifydatead'=>CURDATE_EN,
								'rede_modifydatebs'=>CURDATE_NP,
								'rede_modifytime'=>$this->curtime,
								'rede_modifyby'=>$this->userid,
								'rede_modifymac'=>$this->mac,
								'rede_modifyip'=>$this->ip,
								'rede_locationid'=>$locationid
								);
							}

							//insert into asset issue detail
							if($assetIssueDetail){
								$this->db->insert_batch('asid_assetissuedetail',$assetIssueDetail);
							}

							//update remqty of req detail
							if($reqDetail){
								$this->db->update_batch('rede_reqdetail',$reqDetail,'rede_reqdetailid');
							}

							//update the asset entry list
							if(!empty($assets_id)){
							$assetEntryDetail = array(
								'asen_staffid' => $staff_id,
							);
							$this->db->where_in('asen_asenid',$assets_id);
							$this->db->update('asen_assetentry',$assetEntryDetail);
							}
						}
					} 
				}

			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				trigger_error("Commit failed");
				// return false;
			}
			else{
				$this->db->trans_commit();
				if($id){
					return $id;
				}else{
					return $insertid;
				}
			}
		}catch(Exception $e){
			throw $e;
		}
    }

    public function get_asset_issue_list($cond = false)
	{
		$get = $_GET;
		
		$frmDate= $this->input->get('frmDate');
		$toDate=$this->input->get('toDate');
		$input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
		$received_by = $this->input->get('received_by');
		$departmentid = $this->input->get('depid');

		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}

		$this->db->start_cache();

		if(!empty($get['sSearch_1'])){
			$this->db->where("lower(asim_issuedatebs) like  '%".$get['sSearch_1']."%'  ");
		}
		if(!empty($get['sSearch_2'])){
			$this->db->where("lower(asim_issuedatead) like  '%".$get['sSearch_2']."%'  ");
		}
		 if(!empty($get['sSearch_3'])){
			$this->db->where("lower(asim_issueno) like  '%".$get['sSearch_3']."%'  ");
		}
		if(!empty($get['sSearch_4'])){
			$this->db->where("lower(dept_depname) like  '%".$get['sSearch_4']."%'  ");
		}
		if(!empty($get['sSearch_5'])){
			$this->db->where("lower(asim_reqno) like  '%".$get['sSearch_5']."%'  ");
		}
		  if(!empty($get['sSearch_6'])){
			$this->db->where("lower(asim_staffname) like  '%".$get['sSearch_6']."%'  ");
		}
		if(!empty($get['sSearch_7'])){
			$this->db->where("lower(asim_fyear) like  '%".$get['sSearch_7']."%'  ");
		}

		if($this->location_ismain == 'Y')
          {
            if(!empty($input_locationid))
            {
                  $this->db->where('asim_locationid',$input_locationid);
            }else{
            	 $this->db->where('asim_locationid',$this->locationid);
            }
          } 
          else{
              $this->db->where('asim_locationid',$this->locationid);
         }
		
		if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('asim_issuedatebs >=',$frmDate);
                $this->db->where('asim_issuedatebs <=',$toDate);    
            }else{
                $this->db->where('asim_issuedatead >=',$frmDate);
                $this->db->where('asim_issuedatead <=',$toDate);
            }
        }

        if(!empty($received_by)){
        	$this->db->where('asim_staffid',$received_by);
        }
        if(!empty($departmentid)){
        	$this->db->where('asim_depid',$departmentid);
        }

        $this->db->stop_cache();
      
		$resltrpt=$this->db->select("COUNT(*) as cnt")
					->from('asim_assetissuemaster am')
					->get()->row();
		$totalfilteredrecs=($resltrpt->cnt); 
		
		$order_by = 'asim_asimid';
		$order = 'desc';

		if($this->input->get('sSortDir_0'))
		{
			$order = $this->input->get('sSortDir_0');
		}
		$where='';
		if($this->input->get('iSortCol_0')==1)
			$order_by = 'asim_issuedatebs';
		else  if($this->input->get('iSortCol_0')==2)
			$order_by = 'asim_issuedatead';
	    else  if($this->input->get('iSortCol_0')==3)
			$order_by = 'asim_issueno';
		else if($this->input->get('iSortCol_0')==4)
			$order_by = 'dept_depname';
		else if($this->input->get('iSortCol_0')==5)
			$order_by = 'asim_reqno';
		else if($this->input->get('iSortCol_0')==6)
			$order_by = 'asim_staffname';
		else if($this->input->get('iSortCol_0')==7)
			$order_by = 'asim_fyear';
		
		$totalrecs='';
		$limit = 15;
		$offset = 1;
		
		if(!empty($_GET["iDisplayLength"])){
		   $limit = $_GET['iDisplayLength'];
		   $offset = $_GET["iDisplayStart"];
		}
		
		$this->db->select("am.*,dept_depname");
		$this->db->from('asim_assetissuemaster am');
		$this->db->join('dept_department dp','dp.dept_depid = am.asim_depid','left');
		$this->db->group_by('asim_asimid');
		$this->db->order_by($order_by,$order);

		if($limit && $limit>0)
		{  
			$this->db->limit($limit);
		}
		if($offset)
		{
			$this->db->offset($offset);
		}
	   $nquery=$this->db->get();
	   $num_row=$nquery->num_rows();
		 if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = sizeof($nquery);
        }
	   if($num_row>0){
		  $ndata=$nquery->result();
		  $ndata['totalrecs'] = $totalrecs;
		  $ndata['totalfilteredrecs'] = $totalfilteredrecs;
		} 
		else
		{
			$ndata=array();
			$ndata['totalrecs'] = 0;
			$ndata['totalfilteredrecs'] = 0;
		}
		$this->db->flush_cache();
	  	return $ndata;
	}

	public function get_assetissuemaster_date_id($srchcol = false){

		$this->db->select('am.*,lo.loca_name,dept_depname');
		$this->db->from('asim_assetissuemaster am');
		$this->db->join('loca_location lo','lo.loca_locationid = am.asim_locationid','LEFT');
		$this->db->join('dept_department d','am.asim_depid = d.dept_depid','LEFT');
		if($srchcol){
			$this->db->where($srchcol);
		}
		$result = $this->db->get()->result();
		return $result;
	}

	public function get_assetissue_detail($srchcol=false){

		$stock_count = "SELECT COUNT('*') as cnt FROM xw_asen_assetentry ae WHERE asen_staffid = 0 AND ae.asen_description=il.itli_itemlistid";
		$asset_list = "SELECT GROUP_CONCAT(CONCAT_WS('@',asen_asenid,asen_assetcode)) FROM xw_asen_assetentry ae WHERE asen_staffid = 0 AND ae.asen_description = il.itli_itemlistid";

		$this->db->select("ad.*, il.itli_itemcode,il.itli_materialtypeid,il.itli_itemname,il.itli_itemnamenp,il.itli_itemlistid,ut.unit_unitname,ec.eqca_code,ec.eqca_category,rd.rede_qty,rd.rede_remqty,($stock_count) as stockqty, sum(ad.asid_reqqty) as totalqty,SUM(ad.asid_issqty) as issued_qty,SUM(rd.rede_qty) as totaldemandqty");
		$this->db->from('asid_assetissuedetail ad');
		$this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = ad.asid_redeid','LEFT');
		$this->db->join('itli_itemslist il','il.itli_itemlistid = ad.asid_itemid','INNER');
		$this->db->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT');
		$this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=il.itli_catid','LEFT');
		$this->db->group_by('il.itli_itemlistid');
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		$query = $this->db->get();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();     
			return $data;       
		}       
		return false;
	}

	public function get_approve_data($id = false){
    	$this->db->select('rm.rema_approvedby, rm.rema_approvedid, rm.rema_approved, rm.rema_approveddatead, rm.rema_approveddatebs');
    	$this->db->from('asim_assetissuemaster am');
    	$this->db->join('rema_reqmaster rm','am.asim_reqno = rm.rema_reqno and am.asim_fyear = rm.rema_fyear and am.asim_locationid = rm.rema_locationid');
    	$this->db->where('am.asim_asimid',$id);
    	$this->db->where('asim_locationid',$this->locationid);
    	$query = $this->db->get();
    	if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
        return false;
    }

    public function get_user_list_for_issue_report($id){
    	$this->db->select('r.rema_reqno, asim_reqno, asim_issueno, u.usma_fullname as demander, asim_asimid, rema_postby, r.rema_verifiedby, u2.usma_fullname as supervisor, asim_staffname as receiver, u3.usma_fullname as storekeeper, u.usma_employeeid as demander_userid, u2.usma_employeeid as supervisor_userid, u3.usma_employeeid as storekeeper_userid');
    	$this->db->from('asim_assetissuemaster am');
    	$this->db->join('rema_reqmaster r','r.rema_reqno = am.asim_reqno and r.rema_fyear = am.asim_fyear','left');
    	$this->db->join('usma_usermain u','r.rema_postby = u.usma_userid','left');
    	$this->db->join('usma_usermain u2','r.rema_verifiedby = u2.usma_userid','left');
    	$this->db->join('usma_usermain u3','am.asim_postby = u3.usma_userid','left');
    	$this->db->where('asim_asimid',$id);
    	$this->db->where('asim_locationid',$this->locationid);
    	$query = $this->db->get();
    	// echo $this->db->last_query();
    	// die();
    	if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
        return false;
    }

    public function get_requisition_data_from_asset_issue_masterid($id){
    	$this->db->select('r.rema_reqmasterid, r.rema_workdesc, r.rema_workplace,r.rema_reqdatead,r.rema_reqdatebs,r.rema_reqby');
    	$this->db->from('asim_assetissuemaster a');
    	$this->db->join('rema_reqmaster r','r.rema_reqno = a.asim_reqno and r.rema_fyear=a.asim_fyear','left');
    	$this->db->where('asim_asimid',$id);
    	$this->db->where('asim_locationid',$this->locationid);
    	$query = $this->db->get();
    	// echo $this->db->last_query();
    	// die();
    	if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
        return false;
    }

    public function get_equipment_category($id){
    	$this->db->select('itli_catid, ec.eqca_code');
    	$this->db->from('asid_assetissuedetail ad');
    	$this->db->join('asim_assetissuemaster am','am.asim_asimid = ad.asid_asimid','left');
    	$this->db->join('itli_itemslist il','il.itli_itemlistid = ad.asid_itemid','left');
    	$this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid = il.itli_catid','left');
    	$this->db->where('asim_asimid', $id);
    	$this->db->group_by('itli_catid');
    	$query = $this->db->get();
    	// echo $this->db->last_query();
    	// die();
    	if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
        return false;
    }
}