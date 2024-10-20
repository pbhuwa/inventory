<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Handover_mdl extends CI_Model
{
	public function __construct()
	{
	parent::__construct();
		$this->sama_masterTable='sama_salemaster';
		$this->sade_detailTable='sade_saledetail'; 
		$this->tran_masterTable='trma_transactionmain';
		$this->tran_detailsTable='trde_transactiondetail';
		$this->rede_detailTable='rede_reqdetail'; 
		$this->rema_masterTable = 'rema_reqmaster';

		$this->curtime = $this->general->get_currenttime();
		$this->userid = $this->session->userdata(USER_ID);
		$this->username = $this->session->userdata(USER_NAME);
		$this->userdepid = $this->session->userdata(USER_DEPT); //storeid
		$this->storeid = $this->session->userdata(STORE_ID);
		$this->mac = $this->general->get_Mac_Address();
		$this->ip = $this->general->get_real_ipaddr();
		$this->locationid=$this->session->userdata(LOCATION_ID);
		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		$this->orgid=$this->session->userdata(ORG_ID);
	}
	public $validate_new_issue = array(
		array('field' => 'sama_requisitionno', 'label' => 'Requisition No. ', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'requisition_date', 'label' => 'Requisition Date ', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'sama_fyear', 'label' => 'Fiscal Year ', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'issue_date', 'label' => 'Issue Date ', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'sade_itemsid[]', 'label' => 'Items  ', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'sade_qty[]', 'label' => 'Qty  ', 'rules' => 'trim|required|numeric|is_natural_no_zero|xss_clean'),
		array('field' => 'qtyinstock[]', 'label' => 'Stock Qty  ', 'rules' => 'trim|required|numeric|xss_clean'),
			array('field' => 'sama_invoiceno', 'label' => 'Issue No', 'rules' => 'trim|required|xss_clean'),
	);

	public $validate_issue_return = array(
		array('field' => 'rema_returnby', 'label' => 'Return by', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'rema_returndate', 'label' => 'Return Date', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'rema_invoiceno', 'label' => 'Return Invoice', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'returnqty[]', 'label' => 'Return Qty.', 'rules' => 'trim|numeric|xss_clean'),
	);

	public function save_handover()
	{
		try{
			
			$id = $this->input->post('id');
			$this->orgid=$this->session->userdata(ORG_ID);

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

			$get_last_billno = $this->general->get_tbl_data('sama_billno','sama_salemaster',array('sama_fyear'=>CUR_FISCALYEAR),'sama_salemasterid','DESC');
			$billno = !empty($get_last_billno[0]->sama_billno)?$get_last_billno[0]->sama_billno:0;

			//master table data
			$depid=$this->input->post('sama_depid');
			$locationid = $this->input->post('sama_locationid');
			$req_no=$this->input->post('sama_requisitionno');
			$fiscal_year = $this->input->post('sama_fyear');
			$received_by = $this->input->post('sama_receivedby');
			$unit = $this->input->post('unit');
			
			//detail table data
			$itemsid = $this->input->post('sade_itemsid');
		
			$unitrate = $this->input->post('sade_unitrate'); //save in unitrate,nrate,purchaserate
			$qty = $this->input->post('sade_qty');
			$remarks = $this->input->post('sade_remarks');
			$sama_remarks = $this->input->post('sama_remarks');
			$itemsname = $this->input->post('sade_itemsname');
			$my_rem_qty=$this->input->post('my_rem_qty');

			$volume = $this->input->post('volume');
			$s_no = $this->input->post('s_no');
			$rede_reqdetailid = $this->input->post('rede_reqdetailid');

			$is_handover = $this->input->post('handover');

			if($is_handover == 'Y'){
				$issue_no = $this->general->generate_invoiceno('sama_invoiceno','sama_invoiceno','sama_salemaster',DIRECT_ISSUE_NO_PREFIX,DIRECT_ISSUE_NO_LENGTH, array('sama_ishandover'=>'Y'));
			}else{
				$issue_no = $this->general->generate_invoiceno('sama_invoiceno','sama_invoiceno','sama_salemaster',INVOICE_NO_PREFIX,INVOICE_NO_LENGTH);
			}
		   
			$this->db->trans_begin();

			if($id){
				// update case
				$samaMasterArray = array(
						'sama_requisitionno'=>$req_no,
						'sama_locationid'=>$location, //depid
						'sama_billdatead'=>$issuedateEn,
						'sama_billdatebs'=>$issuedateNp,
						'sama_billtime'=>$this->curtime,
						'sama_duedatead'=>$issuedateEn,
						'sama_duedatebs'=>$issuedateNp,
						'sama_soldby'=>$this->username,
						'sama_username'=>$this->username,
						'sama_receivedby' => strtoupper($received_by),
						'sama_lastchangedate'=>'',
						'sama_orderno'=>0,
						'sama_challanno'=>0,
						'sama_billno'=>$billno + 1,
						'sama_payment'=>0, //0
						'sama_status'=>'O', //O
						'sama_fyear'=>$fiscal_year,
						'sama_discountpc'=>'',
						'sama_st'=>'N',
						'sama_invoiceno'=>$issue_no,
						'sama_manualbillno'=>'',
						'sama_requisitiondatead'=>$reqdateEn,
						'sama_requisitiondatebs'=>$reqdateNp,
						'sama_storeid'=>$this->storeid,
						'sama_remarks'=>$sama_remarks,
						'sama_ishandover'=>$is_handover,
						'sama_postdatead'=>CURDATE_EN,
						'sama_postdatebs'=>CURDATE_NP,
						'sama_postby'=>$this->userid,
						'sama_postmac'=>$this->mac,
						'sama_postip'=>$this->ip,
						'sama_orgid'=>$this->orgid,

						                             
					);

				//get old saledetail id
				$old_sade_list = $this->get_all_sade_id(array('sade_salemasterid'=>$id));
				$old_sade_array=array();
				if(!empty($old_sade_list)){
					foreach($old_sade_list as $key=>$value){
						$old_sade_array[] = $value->sade_saledetailid;
					}
				}

				if(!empty($samaMasterArray)){
					$ReqMasterArray = array(
									'rema_received'=>'1'
									);
					if($ReqMasterArray){
						$this->db->update($this->rema_masterTable,$ReqMasterArray,array('rema_reqno'=>$req_no,'rema_fyear'=>$fiscal_year,'rema_storeid'=>$this->storeid));
					}
					
					$rowaffected=$this->db->affected_rows();

					$sade_insertid = array();

					if($rowaffected){
						if(!empty($itemsid)){
							foreach($itemsid as $key=>$val){
								$sade_detailid = !empty($reqdetailid[$key])?$reqdetailid[$key]:'';

								if($sade_detailid){
									if(in_array($sade_detailid, $old_sade_array)){
										$sade_array[] = $sade_detailid;
									}

									$sade_update_array = array(

										);

									$this->db->update($this->sade_detailTable, $sade_update_array,array('sade_saledetailid'=>$sade_detailid));

								} // if sade_detailid
								else{

									$sade_insert_array = array(
										);

									$this->db->insert($this->sade_detailTable, $sade_insert_array);
									$sade_insertid[] = $this->db->insert_id();
								}
							} 
						}
					}
				}
			} // end if id
			else{
				// insert case
				$samaMasterArray = array(
						'sama_requisitionno'=>$req_no,
						//'sama_depid'=>$depid, //depid
						'sama_locationid'=>$locationid, //depname
						'sama_billdatead'=>$issuedateEn,
						'sama_billdatebs'=>$issuedateNp,
						'sama_billtime'=>$this->curtime,
						'sama_duedatead'=>$issuedateEn,
						'sama_duedatebs'=>$issuedateNp,
						'sama_soldby'=>$this->username,
						'sama_username'=>$this->username,
						'sama_lastchangedate'=>'',
						'sama_orderno'=>0,
						'sama_challanno'=>0,
						'sama_billno'=>$billno + 1,
						'sama_payment'=>0, //0
						'sama_status'=>'O', //O
						'sama_fyear'=>$fiscal_year,
						'sama_discountpc'=>'',
						'sama_st'=>'N',
						'sama_invoiceno'=>$issue_no,
						'sama_manualbillno'=>'',
						'sama_requisitiondatead'=>$reqdateEn,
						'sama_requisitiondatebs'=>$reqdateNp,
						'sama_storeid'=>$this->storeid,
						'sama_remarks'=>$sama_remarks,
						'sama_receivedby'=>strtoupper($received_by),
						'sama_ishandover'=>$is_handover,
						'sama_postdatead'=>CURDATE_EN,
						'sama_postdatebs'=>CURDATE_NP,
						'sama_postby'=>$this->userid,
						'sama_postmac'=>$this->mac,
						'sama_postip'=>$this->ip,
						'sama_locationid'=>$this->locationid, 
						'sama_orgid'=>$this->orgid,

					);
				if(!empty($samaMasterArray))
				{   
					$this->db->insert($this->sama_masterTable,$samaMasterArray);
					$insertid=$this->db->insert_id();

					if($insertid){
						
						$totalRateAmount = 0;
						$totalDiscount = 0;
						$totalVat = 0;
						$totalNetrate = 0;
						$totalAmount = 0; 
						$totalTaxrate = 0;
						$discountpc = 0;
						
						

						if(!empty($itemsid)):
							foreach ($itemsid as $key => $val) {
								$items_id = !empty($itemsid[$key])?$itemsid[$key]:'';
								$issue_qty = !empty($qty[$key])?$qty[$key]:'';
								$reqdetailid=0;
								$rmks=!empty($remarks[$key])?$remarks[$key]:'';
								$sno=!empty($s_no[$key])?$s_no[$key]:'';
								// $volume = !empty($volume[$key])?$volume[$key]:'';
								$volume = 0;
								$microunitid = 0;

								$this->insert_into_sale_master_handover($items_id,$issue_qty,$insertid,$reqdetailid,$rmks,$sno);

								$unitrate = !empty($unitrate[$key])?$unitrate[$key]:0;

								$totalAmount+= $unitrate; 
			
							}							

							$updateMasterSaleArray = array(
													'sama_discountpc'=>$discountpc,
													'sama_discount'=>$totalDiscount,
													'sama_vat'=>$totalVat,
													'sama_taxrate'=>$totalTaxrate,
													'sama_totalamount'=>$totalAmount
												);
							if($updateMasterSaleArray){
								$this->db->where('sama_salemasterid',$insertid);
								$this->db->update($this->sama_masterTable,$updateMasterSaleArray);
							}

						endif;

					} // end if insertid
				} // if samaMasterArray
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

	public function insert_into_sale_master_handover($items_id,$issue_qty,$salesmasteid,$rede_reqdetailid,$remarks,$s_no)
	{
		
		$issue_no = $this->input->post('sama_invoiceno');
		$this->orgid=$this->session->userdata(ORG_ID);

		$this->db->select('mtd.trde_trdeid, mtd.trde_unitprice, mtd.trde_selprice, mtd.trde_controlno, mtd.trde_expdatebs, mtd.trde_issueqty');
		$this->db->from('trde_transactiondetail mtd');
		$this->db->join('trma_transactionmain mtm','mtm.trma_trmaid = mtd.trde_trmaid','LEFT');
		$this->db->where(array('mtd.trde_locationid'=>$this->locationid));
		$this->db->where(array('trde_issueqty>'=>'0','trma_received'=>'1','trde_status'=>'O'));
		$this->db->where(array('trde_itemsid'=>$items_id));
		$this->db->order_by('trde_trdeid','ASC');
		$this->db->limit(1);
		$qrydata=$this->db->get();
		// echo $this->db->last_query();
		// die();
		$data=$qrydata->row();
		if($data)
		{
		$db_issueqty=$data->trde_issueqty;
		$db_unitprice=$data->trde_unitprice;
		$mattransdetailid=$data->trde_trdeid;
		$rem_issue=$issue_qty-$db_issueqty;
		if($rem_issue>0)
				{
					// $data->trde_trdeid;    
					$issueqty=$db_issueqty;
				}
		else{
		  if($rem_issue<=0)
		  {
			$rm_issue=-($rem_issue);
			$issueqty= $db_issueqty-$rm_issue;
		  }
		 }
			$saleDetail=array(
										'sade_salemasterid'=>$salesmasteid,
										'sade_itemsid'=> !empty($items_id)?$items_id:'',
										'sade_unitrate'=> $db_unitprice,
										'sade_purchaserate'=> $db_unitprice,
										'sade_qty'=> !empty($issueqty)?$issueqty:0,
										'sade_curqty' => !empty($issueqty)?$issueqty:0,
										'sade_discount'=>0,
										'sade_batchno'=>0,
										'sade_mfgdate'=>0,
										'sade_expdate'=>'',
										'sade_mattransdetailid'=>$mattransdetailid,
										'sade_status'=>'O',
										'sade_controlno'=>'',
										'sade_invoiceno'=>$issue_no,
										'sade_billdatead'=>CURDATE_EN,
										'sade_billdatebs'=>CURDATE_NP,
										'sade_billtime'=>$this->curtime,
										'sade_username'=>$this->username,
										'sade_sno'=>$s_no,
										'sade_reqdetailid'=>$rede_reqdetailid,
										'sade_remarks'=> $remarks,
										'sade_postdatead'=>CURDATE_EN,
										'sade_postdatebs'=>CURDATE_NP,
										'sade_posttime'=>$this->curtime,
										'sade_postby'=>$this->userid,
										'sade_postmac'=>$this->mac,
										'sade_postip'=>$this->ip ,
										'sade_locationid'=>$this->locationid,
										'sade_orgid'=>$this->orgid,

									);
						if(!empty($saleDetail))
											{   
												// echo"<pre>";print_r($saleDetail);die;
												$this->db->insert($this->sade_detailTable,$saleDetail);
											}

		if($rem_issue>0)
		{
			// $data->trde_trdeid;    

			$issueqty=$db_issueqty;
			$this->update_trde_issue_qty_handover(0,$data->trde_trdeid);
			$this->insert_into_sale_master_handover($items_id,$rem_issue,$salesmasteid,$rede_reqdetailid,$remarks,$s_no);
			 // return   

		}
		else{
			if($rem_issue<=0)
			{

				$rem_issue=-($rem_issue);
				$issueqty=$rem_issue;
				$this->update_trde_issue_qty_handover($rem_issue,$data->trde_trdeid);
				// $this->insert_into_sale_master_handover($items_id,$rem_issue,$salesmasteid,$rede_reqdetailid,$remarks,$s_no);
				return $data->trde_trdeid;
			}
		}

		
		}
	}

	public function get_all_sade_id($srchcol = false){
		try{
			$this->db->select('sade_saledetailid');
			$this->db->from($this->sade_detailTable);
			if($srchcol){
				$this->db->where($srchcol);
			}
			$query = $this->db->get();
			if($query->num_rows() > 0){
				$result = $query->result();
				return $result;
			}
		}catch(Exception $e){
			throw $e;
		}
	}
			

	public function get_selected_issue()
	{
		$depid = $this->input->post('depid');
		$reqno = $this->input->post('reqno');
		$this->db->select('r.*,rm.*');
	   
		if($reqno)
		{
			$this->db->where('rm.rema_reqno', $reqno);
		}
		if($depid)
		{
			$this->db->where('r.rede_storeid', $depid);
		}
		$query = $this->db->get();
		// echo $this->db->last_query(); die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();     
			return $data;       
		}       
		return false;
	}
	public function get_issue_book_details_list($cond = false)
	{
		$frmDate=$this->input->get('frmDate');
		$toDate=$this->input->get('toDate');
		$get = $_GET;
		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}
		if(!empty($get['sSearch_1'])){
			$this->db->where("lower(sama_invoiceno) like  '%".$get['sSearch_1']."%'  ");
		}
		if(!empty($get['sSearch_2'])){
			$this->db->where("lower(sama_billdatebs) like  '%".$get['sSearch_2']."%'  ");
		}
		if(!empty($get['sSearch_3'])){
			$this->db->where("lower(sama_requisitionno) like  '%".$get['sSearch_3']."%'  ");
		}
		if(!empty($get['sSearch_4'])){
			$this->db->where("lower(itli_itemcode) like  '%".$get['sSearch_4']."%'  ");
		}
		if(!empty($get['sSearch_5'])){
			$this->db->where("lower(itli_itemname) like  '%".$get['sSearch_5']."%'  ");
		}
		  if(!empty($get['sSearch_6'])){
			$this->db->where("lower(sama_depname) like  '%".$get['sSearch_6']."%'  ");
		}
		if(!empty($get['sSearch_7'])){
			$this->db->where("lower(sama_username) like  '%".$get['sSearch_7']."%'  ");
		}
		if(!empty($get['sSearch_8'])){
			$this->db->where("lower(sama_receivedby) like  '%".$get['sSearch_8']."%'  ");
		}
		 if(!empty($get['sSearch_11'])){
			$this->db->where("lower(sade_unitrate) like  '%".$get['sSearch_11']."%'  ");
		}
		if(!empty($get['sSearch_10'])){
					$this->db->where("lower(sade_qty) like  '%".$get['sSearch_10']."%'  ");
		 }

		if($cond) {
		  $this->db->where($cond);
		}
		 $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
	  
          if($this->location_ismain=='Y')
          {
            if($input_locationid)
            {
                $this->db->where('sd.sade_locationid',$input_locationid);
             }

        }
        else
        {
             $this->db->where('sd.sade_locationid',$this->locationid);
        }
	  

		if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('sama_billdatebs >=',$frmDate);
                $this->db->where('sama_billdatebs <=',$toDate);    
            }else{
                $this->db->where('sama_billdatead >=',$frmDate);
                $this->db->where('sama_billdatead <=',$toDate);
            }
        }

		$resltrpt=$this->db->select("COUNT(*) as cnt")
					->from('sade_saledetail sd')
					->join('sama_salemaster rn','rn.sama_salemasterid = sd.sade_salemasterid','LEFT')
					->join('itli_itemslist eq','eq.itli_itemlistid = sd.sade_itemsid','LEFT')
					->get()->row();
		//echo $this->db->last_query();die(); 
		$totalfilteredrecs=($resltrpt->cnt); 
		$order_by = 'sama_requisitionno';
		$order = 'desc';
		if($this->input->get('sSortDir_0'))
		{
				$order = $this->input->get('sSortDir_0');
		}
  
		$where='';
	   if($this->input->get('iSortCol_0')==1)
			$order_by = 'sama_invoiceno';
		else if($this->input->get('iSortCol_0')==2)
			if(DEFAULT_DATEPICKER=='NP')
			{
				$order_by = 'sama_billdatebs';
			}else{
				$order_by = 'sama_billdatead';
			}
		else if($this->input->get('iSortCol_0')==3)
			$order_by = 'sama_requisitionno';
		else if($this->input->get('iSortCol_0')==4)
			$order_by = 'itli_itemcode';
		else if($this->input->get('iSortCol_0')==5)
			$order_by = 'itli_itemname';
		else if($this->input->get('iSortCol_0')==6)
			$order_by = 'sama_depname';
		else if($this->input->get('iSortCol_0')==7)
			$order_by = 'sama_username';
		else if($this->input->get('iSortCol_0')==8)
			$order_by = 'sama_receivedby';
		 else if($this->input->get('iSortCol_0')==9)
			$order_by = 'sama_billtime';
		 else if($this->input->get('iSortCol_0')==10)
			$order_by = 'sade_qty';
		 else if($this->input->get('iSortCol_0')==11)
			$order_by = 'sade_unitrate';
		else if($this->input->get('iSortCol_0')==12)
			$order_by = 'issueamt';
		$totalrecs='';
		$limit = 15;
		$offset = 1;
		$get = $_GET;
 
		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}
	  
		if(!empty($_GET["iDisplayLength"])){
		   $limit = $_GET['iDisplayLength'];
		   $offset = $_GET["iDisplayStart"];
		}

		 if(!empty($get['sSearch_1'])){
			$this->db->where("lower(sama_invoiceno) like  '%".$get['sSearch_1']."%'  ");
		}
		if(!empty($get['sSearch_2'])){
			if(DEFAULT_DATEPICKER=='NP')
			{
				$this->db->where("lower(sama_billdatebs) like  '%".$get['sSearch_2']."%'  ");
			}else{
				$this->db->where("lower(sama_billdatead) like  '%".$get['sSearch_2']."%'  ");
			}
		}
		if(!empty($get['sSearch_3'])){
			$this->db->where("lower(sama_requisitionno) like  '%".$get['sSearch_3']."%'  ");
		}
		if(!empty($get['sSearch_4'])){
			$this->db->where("lower(itli_itemcode) like  '%".$get['sSearch_4']."%'  ");
		}
		if(!empty($get['sSearch_5'])){
			$this->db->where("lower(itli_itemname) like  '%".$get['sSearch_5']."%'  ");
		}
		  if(!empty($get['sSearch_6'])){
			$this->db->where("lower(sama_depname) like  '%".$get['sSearch_6']."%'  ");
		}
		if(!empty($get['sSearch_7'])){
			$this->db->where("lower(sama_username) like  '%".$get['sSearch_7']."%'  ");
		}
		if(!empty($get['sSearch_8'])){
			$this->db->where("lower(sama_receivedby) like  '%".$get['sSearch_8']."%'  ");
		}
		 if(!empty($get['sSearch_10'])){
			$this->db->where("lower(sade_qty) like  '%".$get['sSearch_10']."%'  ");
		}
		if(!empty($get['sSearch_11'])){
					$this->db->where("lower(sade_unitrate) like  '%".$get['sSearch_11']."%'  ");
		 }

	  

		if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('sama_billdatebs >=',$frmDate);
                $this->db->where('sama_billdatebs <=',$toDate);    
            }else{
                $this->db->where('sama_billdatead >=',$frmDate);
                $this->db->where('sama_billdatead <=',$toDate);
            }
        }
	if($cond) {
		  $this->db->where($cond);
		}

		if($this->location_ismain=='Y')
        {
            if($input_locationid)
            {
                $this->db->where('sd.sade_locationid',$input_locationid);
            }

        }
        else
        {
             $this->db->where('sd.sade_locationid',$this->locationid);
        }
        
		$this->db->select('rn.sama_st,rn.sama_billtime,rn.sama_requisitionno,sd.sade_qty,sd.sade_unitrate,sd.sade_remarks,rn.sama_salemasterid,rn.sama_invoiceno,rn.sama_billdatebs,rn.sama_billdatead,dp.dept_depname sama_depname,rn.sama_totalamount,rn.sama_username,rn.sama_receivedby,(sd.sade_qty*sd.sade_unitrate) as issueamt,eq.itli_itemname,eq.itli_itemnamenp,eq.itli_itemcode,eq.itli_itemlistid');
	  	$this->db->from('sade_saledetail sd');
		$this->db->join('sama_salemaster rn','rn.sama_salemasterid = sd.sade_salemasterid','LEFT');
		$this->db->join('dept_department dp','dp.dept_depid=rn.sama_depid','left');
		$this->db->join('itli_itemslist eq','eq.itli_itemlistid = sd.sade_itemsid','LEFT');
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
	//echo $this->db->last_query();die();
	  return $ndata;

	}
	public function get_issue_book_list($cond = false)
	{
		$frmDate=$this->input->get('frmDate');
		$toDate=$this->input->get('toDate');
		$get = $_GET;
		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}
	   

		if(!empty($get['sSearch_1'])){
			$this->db->where("lower(sama_invoiceno) like  '%".$get['sSearch_1']."%'  ");
		}
		if(!empty($get['sSearch_2'])){
			$this->db->where("lower(sama_billdatebs) like  '%".$get['sSearch_2']."%'  ");
		}
		if(!empty($get['sSearch_3'])){
			$this->db->where("lower(sama_depname) like  '%".$get['sSearch_3']."%'  ");
		}
		if(!empty($get['sSearch_4'])){
			$this->db->where("lower(sama_totalamount) like  '%".$get['sSearch_4']."%'  ");
		}
		  if(!empty($get['sSearch_5'])){
			$this->db->where("lower(sama_username) like  '%".$get['sSearch_5']."%'  ");
		}
		if(!empty($get['sSearch_6'])){
			$this->db->where("lower(sama_receivedby) like  '%".$get['sSearch_6']."%'  ");
		}
		if(!empty($get['sSearch_7'])){
			$this->db->where("lower(sama_requisitionno) like  '%".$get['sSearch_7']."%'  ");
		}
		 if(!empty($get['sSearch_8'])){
			$this->db->where("lower(sama_billtime) like  '%".$get['sSearch_8']."%'  ");
		}
		if(!empty($get['sSearch_9'])){
					$this->db->where("lower(sama_billno) like  '%".$get['sSearch_9']."%'  ");
		 }

		if($cond) {
		  $this->db->where($cond);
		}
	    $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
	  
	   
		if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('sama_billdatebs >=',$frmDate);
                $this->db->where('sama_billdatebs <=',$toDate);    
            }else{
                $this->db->where('sama_billdatead >=',$frmDate);
                $this->db->where('sama_billdatead <=',$toDate);
            }
        }
		
        if($input_locationid)
        {
            $this->db->where('rn.sama_locationid',$input_locationid);
        }
        else
        {
            $this->db->where('rn.sama_locationid',$this->locationid);
        }

		$resltrpt=$this->db->select("COUNT(*) as cnt")
					->from('sama_salemaster rn')
					->join('sade_saledetail sd','sd.sade_salemasterid =rn.sama_salemasterid','LEFT')
					->get()->row();
		//echo $this->db->last_query();die(); 
		$totalfilteredrecs=($resltrpt->cnt); 
		$order_by = 'sama_salemasterid';
		$order = 'desc';
		if($this->input->get('sSortDir_0'))
		{
				$order = $this->input->get('sSortDir_0');
		}
  
		$where='';
	   if($this->input->get('iSortCol_0')==1)
			$order_by = 'sama_invoiceno';
		else if($this->input->get('iSortCol_0')==2)
			$order_by = 'sama_billdatebs';
		else if($this->input->get('iSortCol_0')==3)
			$order_by = 'sama_depname';
		else if($this->input->get('iSortCol_0')==4)
			$order_by = 'totalamt';
		else if($this->input->get('iSortCol_0')==5)
			$order_by = 'sama_username';
			else if($this->input->get('iSortCol_0')==6)
			$order_by = 'sama_receivedby';
		else if($this->input->get('iSortCol_0')==7)
			$order_by = 'sama_requisitionno';
		 else if($this->input->get('iSortCol_0')==8)
			$order_by = 'sama_billtime';
		 else if($this->input->get('iSortCol_0')==9)
			$order_by = 'sama_billno';
		$totalrecs='';
		$limit = 15;
		$offset = 1;
		$get = $_GET;
 
		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}
		// echo $this->db->last_query();
	 //  die;
	  
		if(!empty($_GET["iDisplayLength"])){
		   $limit = $_GET['iDisplayLength'];
		   $offset = $_GET["iDisplayStart"];
		}

		 if(!empty($get['sSearch_1'])){
			$this->db->where("lower(sama_invoiceno) like  '%".$get['sSearch_1']."%'  ");
		}
		if(!empty($get['sSearch_2'])){
			$this->db->where("lower(sama_billdatebs) like  '%".$get['sSearch_2']."%'  ");
		}
		if(!empty($get['sSearch_3'])){
			$this->db->where("lower(sama_depname) like  '%".$get['sSearch_3']."%'  ");
		}
		if(!empty($get['sSearch_4'])){
			$this->db->where("lower(sama_totalamount) like  '%".$get['sSearch_4']."%'  ");
		}
		  if(!empty($get['sSearch_5'])){
			$this->db->where("lower(sama_username) like  '%".$get['sSearch_5']."%'  ");
		}
		if(!empty($get['sSearch_6'])){
			$this->db->where("lower(sama_receivedby) like  '%".$get['sSearch_6']."%'  ");
		}
		if(!empty($get['sSearch_7'])){
			$this->db->where("lower(sama_requisitionno) like  '%".$get['sSearch_7']."%'  ");
		}
		 if(!empty($get['sSearch_8'])){
			$this->db->where("lower(sama_billtime) like  '%".$get['sSearch_8']."%'  ");
		}
		if(!empty($get['sSearch_9'])){
					$this->db->where("lower(sama_billno) like  '%".$get['sSearch_9']."%'  ");
		 }

	   
		if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('sama_billdatebs >=',$frmDate);
                $this->db->where('sama_billdatebs <=',$toDate);    
            }else{
                $this->db->where('sama_billdatead >=',$frmDate);
                $this->db->where('sama_billdatead <=',$toDate);
            }
        }
		if($cond) {
		  $this->db->where($cond);
		}


	 
        if($input_locationid)
        {
            $this->db->where('sm.sama_locationid',$input_locationid);
        }
        else
        {
             $this->db->where('sm.sama_locationid',$this->locationid);
        }
        $issueQtycount="(SELECT COUNT(DISTINCT sd.sade_itemsid) as totcnt from xw_sade_saledetail sd WHERE sd.sade_salemasterid=sm.sama_salemasterid) as totcnt";
		$this->db->select("$issueQtycount,sama_salemasterid,(CASE WHEN sade_unitrate<>0 THEN SUM(sade_curqty*sade_unitrate) ELSE 0 END) as totalamt, sama_depid,sama_billdatead, sama_billdatebs, sama_duedatead, sama_duedatebs, sama_soldby, sama_discount, sama_taxrate, sama_vat, sama_totalamount, sama_username, sama_lastchangedate, sama_orderno, sama_challanno, sama_billno, sama_payment, sama_status, sama_fyear, sama_st, sama_stdatebs, sama_stdatead, sama_stdepid, sama_stusername, sama_stshiftid, dept_depname, sama_depname, sama_invoiceno, sama_billtime, sama_receivedby, sama_manualbillno, sama_requisitionno");
		$this->db->from('sama_salemaster sm');
		$this->db->join('sade_saledetail sd','sd.sade_salemasterid =sm.sama_salemasterid','LEFT');
		$this->db->join('dept_department dp','dp.dept_depid=sm.sama_depid','left');
		$this->db->group_by('sama_salemasterid');
	   
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
		//echo $this->db->last_query();die();
	  return $ndata;

	}

	public function get_mat_trans_detail_id_handover($itemsid,$vol=0,$unit=0,$issueqty=false)
	{
		$this->db->select('mtd.trde_trdeid, mtd.trde_unitprice, mtd.trde_selprice, mtd.trde_controlno, mtd.trde_expdatebs, mtd.trde_issueqty');
		$this->db->from('trde_transactiondetail mtd');
		$this->db->join('trma_transactionmain mtm','mtm.trma_trmaid = mtd.trde_trmaid','LEFT');
		// $this->db->where(array('trde_unitvolume'=>$vol,'trde_microunitid'=>$unit));
		$this->db->where(array('trde_issueqty>'=>'0','trma_received'=>'1','trde_status'=>'O'));
		$this->db->where(array('trde_itemsid'=>$itemsid));
		$this->db->order_by('trde_trdeid','ASC');
		$this->db->limit(1);
		$qrydata=$this->db->get();
		$data=$qrydata->row();
		if($data)
		{
		$db_issueqty=$data->trde_issueqty;
		$rem_issue=$issueqty-$db_issueqty;
		
		// foreach($data as $d):
		// echo "<pre>";
		// print_r('rem_issue '.$rem_issue);
		// echo "<br/>";
		// print_r('db_issue '.$db_issueqty);
		// echo "<br/>";
		// print_r('issue '.$issueqty);
		// echo "<br/>";
		// print_r('matd '.$data->trde_trdeid);
		// echo "<br/>";
		// echo $this->db->last_query();
		// endforeach;
		// die();
		if($rem_issue>0)
		{
			// $data->trde_trdeid;    
			$this->update_trde_issue_qty_handover($rem_issue,$data->trde_trdeid);
			$this->get_mat_trans_detail_id_handover($itemsid,$vol,$unit,$rem_issue);
			 // return   

		}
		else{
			if($rem_issue<0)
			{
				$rem_issue=-($rem_issue);
				 $this->update_trde_issue_qty_handover($rem_issue,$data->trde_trdeid);
			}

			return $data->trde_trdeid;
		}
		
		// return array(
		//     'mattransdetailid' => $data->trde_trdeid,
		//     'trde_issue_qty' => $data->trde_issueqty
		// );
		} 
	}


	public function update_trde_issue_qty_handover($rem_qty, $trde_id){
		$update_array = array(
						'trde_issueqty' => $rem_qty,
						'trde_stripqty'=>$rem_qty,
					);
		$this->db->update($this->tran_detailsTable,$update_array,array('trde_trdeid'=>$trde_id));
		// $this->db->query('UPDATE xw_trde_transactiondetail SET  trde_issueqty =(trde_issueqty-'.$rem_qty.') WHERE  trde_trdeid='.$trde_id.' ');

	}

		public function update_trde_return_to_issue_qty($rem_qty, $trde_id){
		
		$this->db->query('UPDATE xw_trde_transactiondetail SET  trde_issueqty =(trde_issueqty+'.$rem_qty.') WHERE  trde_trdeid='.$trde_id.' ');

	}


	public function get_issue_master($srchcol=false)
	{

		
		$this->db->select('sm.*');
		$this->db->from('sama_salemaster sm');
		
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
	
		

		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();     
			return $data;       
		}       
		return false;
	}
	
	public function get_issue_detail($srchcol=false)
	{
		$this->db->select('sd.*, sum(sd.sade_curqty) as totalcurqty, sum(sd.sade_qty) as totalqty, il.itli_itemcode,il.itli_itemname,il.itli_itemnamenp,il.itli_itemlistid,ut.unit_unitname,rd.rede_qty');
		$this->db->from('sade_saledetail sd');
		$this->db->join('rede_reqdetail rd','rd.rede_reqdetailid=sd.sade_reqdetailid','LEFT');
		$this->db->join('itli_itemslist il','il.itli_itemlistid=sd.sade_itemsid','LEFT');
		$this->db->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT');
		$this->db->group_by('il.itli_itemlistid');
		
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		$query = $this->db->get();
		//echo $this->db->last_query(); die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();     
			return $data;       
		}       
		return false;

	}

	public function update_mat_trans_detailid($mat_transdetailid,$qty=0,$type = false)
	{
		if($mat_transdetailid)
		{
			if($type == 'returncancel' || $type == 'new_issue'){
				$this->db->query("UPDATE xw_trde_transactiondetail SET trde_issueqty= (trde_issueqty)-$qty, trde_stripqty = (trde_issueqty)-$qty WHERE trde_trdeid=$mat_transdetailid  ");
// 				$this->db->update('',array('trde_issueqty'=>'trde_issueqty'-$qty),array('trde
// trde_trdeid'=>$mat_transdetailid));
			}else{
				// $this->db->update('trde_transactiondetail',array('trde_issueqty'=>'trde_issueqty'+$qty),array('trde_trdeid'=>$mat_transdetailid));
				$this->db->query("UPDATE xw_trde_transactiondetail SET trde_issueqty= (trde_issueqty)+$qty, trde_stripqty = (trde_issueqty)+$qty WHERE trde_trdeid=$mat_transdetailid  ");
			}
		$rwaff=$this->db->affected_rows(); 
		if($rwaff){ return true;}
		}
		return false;
	}

	public function update_salesdetail($id)
	{
		if($id)
		{
			$updateArray['sade_iscancel']='Y';
			$updateArray['sade_canceldatead']=CURDATE_EN;
			$updateArray['sade_canceldatebs']=CURDATE_NP;
			$updateArray['sade_canceldateby']= $this->userid;
			$updateArray['sade_canceluser']= $this->username;

		   $this->db->update('sade_saledetail',$updateArray,array('sade_saledetailid'=>$id));
		$rwaff=$this->db->affected_rows(); 
		if($rwaff){ return true;}
		}
		return false;
	}

	public function update_reqdetail($reqdetailid){
		if($reqdetailid){
			$updateArray = array(
				'rede_modifyby'=>$this->userid,
				'rede_modifydatead' => CURDATE_EN,
				'rede_modifydatebs' => CURDATE_NP,
				'rede_modifytime' => $this->curtime,
				'rede_modifymac' => $this->mac,
				'rede_modifyip' => $this->ip
			);
			$this->db->set('rede_remqty','rede_qty',false);
			$this->db->where('rede_reqdetailid',$reqdetailid);
			$this->db->update('rede_reqdetail',$updateArray);

			// echo $this->db->last_query();
			// die();
			$rwaff=$this->db->affected_rows(); 
			if($rwaff){ 
				return true;
			}
		}
		return false;
	}

	// public function update_reqmaster($reqno,$fyear,$storeid,$depid,$locationid){
	// 	if(empty($reqno) || empty($fyear) || empty($storeid) || empty($depid) || empty($locationid)){
	// 		echo "There was some errors. Please try again.";
	// 		return false;
	// 	}else{
	// 		$updateArray = array(
	// 					'rema_received'=>0
	// 					);
	// 		$this->db->where('rema_reqno',$reqno);
	// 		$this->db->where('rema_fyear',$fyear);
	// 		$this->db->where('rema_storeid',$storeid);
	// 		$this->db->where('rema_locationid',$locationid);
	// 		$this->db->where('rema_reqfromdepid',$depid);
	// 		$this->db->update('rema_reqmaster',$updateArray);
	// 	}
	// 	$rwaff=$this->db->affected_rows(); 
	// 	if($rwaff){ 
	// 		return true;
	// 	}
	// }

	public function update_salesmaster($id)
	{
		if($id)
		{
			$updateArray['sama_st']='C';
			$updateArray['sama_stdepid']=$this->session->userdata(STORE_ID);
			$updateArray['sama_stshiftid']=$this->session->userdata(STORE_ID);
			$updateArray['sama_stusername']=$this->username;
			$updateArray['sama_stdatebs']=CURDATE_NP;
			$updateArray['sama_stdatead']=CURDATE_EN;
			$this->db->update('sama_salemaster',$updateArray,array('sama_salemasterid'=>$id));
			$rwaff=$this->db->affected_rows(); 
			if($rwaff){ return true;}
			}
			return false;
	}


	public function save_issue_return(){
		try{
			$id = $this->input->post('id');

			$depid = $this->input->post('rema_depid');
			$issueno = $this->input->post('rema_issueno');
			$fyear = $this->input->post('rema_fyear');
			$returndate = $this->input->post('rema_returndate');
			$salesmasterid=$this->input->post('salesmasterid');

			if(DEFAULT_DATEPICKER=='NP')
			{   
				$returndatebs = $returndate;
				$returndatead = $this->general->NepToEngDateConv($returndate);
			}
			else
			{
				$returndatead = $returndate;
				$returndatebs = $this->general->EngtoNepDateConv($returndate);
			}

			$returnby = $this->input->post('rema_returnby');
			$issueto = $this->input->post('rema_issueto');
			$amount = $this->input->post('rema_amount');
			$remark_master = $this->input->post('rema_remarks');

			$return_invoice = $this->input->post('rema_invoiceno');

			//for return detail
			$itemsid = $this->input->post('itemsid');
			$mattransdetailid = $this->input->post('mattransdetailid');
			$qty = $this->input->post('qty');
			$unit_rate = $this->input->post('unit_rate');
			$issueqty = $this->input->post('issueqty');
			$returnqty = $this->input->post('returnqty');
			$ret_remarks = $this->input->post('remarks');
			$retamt_total = $this->input->post('retamt_total');
			$reqdetailid = $this->input->post('reqdetailid');

			$this->db->trans_begin();

			if($id){
				//update
			}else{
				//insert
				$returnMasterArray = array(
					'rema_fyear' => $fyear,
					'rema_receiveno' => $issueno,
					'rema_depid' =>$depid,
					'rema_amount' => $amount,
					'rema_returndatead' => $returndatead,
					'rema_returndatebs' => $returndatebs,
					'rema_returntime' => $this->curtime,
					'rema_storeid' => $this->storeid,
					'rema_type' => '1', //1
					'rema_auther' => 'check', //check
					'rema_username' => $this->username,
					'rema_invoiceno' => $return_invoice,
					'rema_st' => 'N',//N,C
					'rema_remarks' => $remark_master, //32
					'rema_returnby' => $returnby,
					'rema_postby' => $this->userid,
					'rema_postdatead' => CURDATE_EN,
					'rema_postdatebs' => CURDATE_NP,
					'rema_posttime' => $this->curtime,
					'rema_postmac' => $this->mac,
					'rema_postip' => $this->ip,
					'rema_locationid'=>$this->locationid
				);

				if(!empty($returnMasterArray)){
					$this->db->insert('rema_returnmaster', $returnMasterArray);
					$insertid = $this->db->insert_id();

					// $insertid = 5;

					if($insertid){
						if(!empty($itemsid)){
							$rema_amount_total = 0;
							foreach($itemsid as $key=>$val){
								$itmid=!empty($itemsid[$key])?$itemsid[$key]:'';
								$retn_qty=!empty($returnqty[$key])?$returnqty[$key]:'';
								$ret_remarks=!empty($ret_remarks[$key])?$ret_remarks[$key]:'';
								if($retn_qty>0)
								{
									$this->update_return_issue_item($itmid,$salesmasterid,$retn_qty,$insertid,$ret_remarks);
								}
								
							} 
						} // if itemsid

						// echo "<pre>";
						// print_r($returnDetailArray);
						// die();

						if(!empty($returnDetailArray)){
							$detail_insert = $this->db->insert_batch('rede_returndetail',$returnDetailArray);
							// $detail_insert = 1;
							//update return master for total
							$updateRemaArray = array(
								'rema_amount'=> $rema_amount_total
							);
							if($updateRemaArray){
								$this->db->where('rema_returnmasterid', $insertid);
								$this->db->update('rema_returnmaster', $updateRemaArray);
							}
						}

					} // if insertid
				} // if returnmasterarray
			} // else no id

			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				trigger_error("Commit failed");
				// return false;
			}
			else{
				$this->db->trans_commit();
				return true;
			}

		}catch(Exception $e){
			throw $e;
		}
	}


	public function update_return_issue_item($item,$salesmasterid,$rtnqty,$retmasterid,$ret_remarks)
	{
		
		$this->db->select('sade_saledetailid,sade_salemasterid,sade_itemsid,sade_qty,sade_curqty,sade_unitrate,sm.sama_depid,sm.sama_invoiceno,sm.sama_fyear,sd.sade_reqdetailid,sd.sade_mattransdetailid');
		$this->db->from('sade_saledetail sd');
		$this->db->join('sama_salemaster sm', 'sm.sama_salemasterid=sd.sade_salemasterid');
		$this->db->order_by('sade_saledetailid','ASC');
		$this->db->where(array('sade_itemsid'=>$item,'sade_salemasterid'=>$salesmasterid));
		$this->db->limit(1);
		$qrydata=$this->db->get();
		// echo $this->db->last_query();
		// die();
		$data=$qrydata->row();
		if($data)
		{
		$db_orginalqty=$data->sade_qty;
		$db_issueqty=$data->sade_curqty;
		$db_unitprice=$data->sade_unitrate;
		$mattransdetailid=$data->sade_mattransdetailid;
		$depid=$data->sama_depid;
		$issueno =$data->sama_invoiceno;
		$fyear=$data->sama_fyear;
		$reqdetailid=$data->sade_reqdetailid;
		$salesdtlid=$data->sade_saledetailid;

		$rem_ret_qty=$rtnqty-$db_issueqty;
		if($rem_ret_qty>0)
		{
			$ret_qty=$db_issueqty;
		}
		else{
			if($rem_ret_qty<=0)
			{
				$rm_issue=-($rem_ret_qty);
				$ret_qty= $db_issueqty-$rm_issue;		
			}
		}

		$UpdatesalesDetailArray=array(
			'sade_curqty'=>-($rem_ret_qty)
		);



		if(!empty($UpdatesalesDetailArray))
		{
			$this->db->update('sade_saledetail',$UpdatesalesDetailArray,array('sade_saledetailid'=>$salesdtlid));
		}
		

		$UpdatereqDetailArray = array(
									'rede_remqty' => ($db_orginalqty-$db_issueqty+$ret_qty),
									'rede_modifydatead'=>CURDATE_EN,
									'rede_modifydatebs'=>CURDATE_NP,
									'rede_modifytime'=>$this->curtime,
									'rede_modifyby'=>$this->userid,
									'rede_modifymac'=>$this->mac,
									'rede_modifyip'=>$this->ip,
									);
							
		if(!empty($UpdatereqDetailArray)){
			$this->db->update($this->rede_detailTable,$UpdatereqDetailArray,array('rede_reqdetailid'=>$reqdetailid));
		}

			// $this->db->query('UPDATE  '.$this->rede_detailTable.'  SET  rede_remqty =(rede_remqty+'.$rem_qty.') WHERE  rede_reqdetailid='.$reqdetailid.' ');


		$returnDetailArray = array(
									'rede_returnmasterid' => $retmasterid,
									'rede_itemsid'=> !empty($item)?$item:'',
									'rede_unitprice'=> !empty($db_unitprice)?$db_unitprice:'0',
									'rede_qty' => !empty($ret_qty)?$ret_qty:0,
									'rede_total' => ($db_unitprice)*($ret_qty),
									'rede_mattransdetailid' => !empty($mattransdetailid)?$mattransdetailid:'',
									'rede_newmtdid' => '',
									'rede_controlno' => 1,
									'rede_discount' => '',
									'rede_storeid' => $this->storeid,
									'rede_invoiceno' => $issueno,
									'rede_depid' => $depid,
									'rede_salefyear' => $fyear,
									'rede_remarks' => !empty($ret_remarks)?$ret_remarks:'',
									'rede_reqdetailid' => !empty($reqdetailid)?$reqdetailid:'',
									'rede_salesdetailid'=>!empty($salesdtlid)?$salesdtlid:'',
									'rede_postby' => $this->userid,
									'rede_postdatead' => CURDATE_EN,
									'rede_postdatebs' => CURDATE_NP,
									'rede_posttime' => $this->curtime,
									'rede_postmac' => $this->mac,
									'rede_postip' => $this->ip,
									'rede_locationid'=>$this->locationid
								);
		if(!empty($returnDetailArray))
		{
				$this->db->insert('rede_returndetail',$returnDetailArray);
		}
	
		if($rem_ret_qty>0)
		{
			// $data->trde_trdeid;    
			$issueqty=$db_issueqty;
			$this->update_return_issue_item($item,$salesmasterid,$rem_ret_qty,$retmasterid,$ret_remarks);
			$this->update_trde_return_to_issue_qty($issueqty,$mattransdetailid);


		}
		else{
		  if($rem_ret_qty<=0)
		  {
		  	$rm_issue=-($rem_ret_qty);
			 $issueqty= $db_issueqty-$rm_issue;	

		  	$this->update_trde_return_to_issue_qty($issueqty,$mattransdetailid);
		  }
		 }
		}		
	}





	public function get_issue_return_list($cond = false)
	{
		$frmDate=$this->input->get('frmDate');
		$toDate=$this->input->get('toDate');
		$get = $_GET;
		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}
	   
		if(!empty($get['sSearch_1'])){
			$this->db->where("lower(rema_invoiceno) like  '%".$get['sSearch_1']."%'  ");
		}
		if(!empty($get['sSearch_2'])){
			$this->db->where("lower(rema_returndatebs) like  '%".$get['sSearch_2']."%'  ");
		}
		if(!empty($get['sSearch_3'])){
			$this->db->where("lower(sama_depname) like  '%".$get['sSearch_3']."%'  ");
		}
		if(!empty($get['sSearch_4'])){
			$this->db->where("lower(sama_totalamount) like  '%".$get['sSearch_4']."%'  ");
		}
		  if(!empty($get['sSearch_5'])){
			$this->db->where("lower(sama_username) like  '%".$get['sSearch_5']."%'  ");
		}
		if(!empty($get['sSearch_6'])){
			$this->db->where("lower(sama_receivedby) like  '%".$get['sSearch_6']."%'  ");
		}
		if(!empty($get['sSearch_7'])){
			$this->db->where("lower(sama_requisitionno) like  '%".$get['sSearch_7']."%'  ");
		}
		 if(!empty($get['sSearch_8'])){
			$this->db->where("lower(sama_billtime) like  '%".$get['sSearch_8']."%'  ");
		}
		if(!empty($get['sSearch_9'])){
			$this->db->where("lower(sama_billno) like  '%".$get['sSearch_9']."%'  ");
		}

		if($cond) {
		 	$this->db->where($cond);
		}
	  
	   	if(!empty(($frmDate && $toDate)))
		{
			$this->db->where('rema_returndatebs >=',$frmDate);
			$this->db->where('rema_returndatebs <=',$toDate);
		}

		if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('rema_returndatebs >=',$frmDate);
                $this->db->where('rema_returndatebs <=',$toDate);    
            }else{
                $this->db->where('rema_returndatead >=',$frmDate);
                $this->db->where('rema_returndatead <=',$toDate);
            }
        }

		$resltrpt=$this->db->select("COUNT(*) as cnt")
					->from('rema_returnmaster rm')
					->join('dept_department d','rm.rema_depid = d.dept_depid','left')
					->get()->row();

		//echo $this->db->last_query();die(); 
		$totalfilteredrecs=($resltrpt->cnt); 
		$order_by = 'rema_returndatebs';
		$order = 'desc';
		if($this->input->get('sSortDir_0'))
		{
				$order = $this->input->get('sSortDir_0');
		}
  
		$where='';
	   if($this->input->get('iSortCol_0')==1)
			$order_by = 'rema_invoiceno';
		else if($this->input->get('iSortCol_0')==2)
			$order_by = 'rema_returndatebs';
		else if($this->input->get('iSortCol_0')==3)
			$order_by = 'sama_depname';
		else if($this->input->get('iSortCol_0')==4)
			$order_by = 'sama_totalamount';
		else if($this->input->get('iSortCol_0')==5)
			$order_by = 'sama_username';
			else if($this->input->get('iSortCol_0')==6)
			$order_by = 'sama_receivedby';
		else if($this->input->get('iSortCol_0')==7)
			$order_by = 'rema_returndatebs';
		 else if($this->input->get('iSortCol_0')==8)
			$order_by = 'sama_billtime';
		 else if($this->input->get('iSortCol_0')==9)
			$order_by = 'sama_billno';
		$totalrecs='';
		$limit = 15;
		$offset = 1;
		$get = $_GET;
 
		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}
	  
		if(!empty($_GET["iDisplayLength"])){
		   $limit = $_GET['iDisplayLength'];
		   $offset = $_GET["iDisplayStart"];
		}

		 if(!empty($get['sSearch_1'])){
			$this->db->where("lower(sama_invoiceno) like  '%".$get['sSearch_1']."%'  ");
		}
		if(!empty($get['sSearch_2'])){
			$this->db->where("lower(rema_returndatebs) like  '%".$get['sSearch_2']."%'  ");
		}
		if(!empty($get['sSearch_3'])){
			$this->db->where("lower(sama_depname) like  '%".$get['sSearch_3']."%'  ");
		}
		if(!empty($get['sSearch_4'])){
			$this->db->where("lower(sama_totalamount) like  '%".$get['sSearch_4']."%'  ");
		}
		  if(!empty($get['sSearch_5'])){
			$this->db->where("lower(sama_username) like  '%".$get['sSearch_5']."%'  ");
		}
		if(!empty($get['sSearch_6'])){
			$this->db->where("lower(sama_receivedby) like  '%".$get['sSearch_6']."%'  ");
		}
		if(!empty($get['sSearch_7'])){
			$this->db->where("lower(sama_requisitionno) like  '%".$get['sSearch_7']."%'  ");
		}
		 if(!empty($get['sSearch_8'])){
			$this->db->where("lower(sama_billtime) like  '%".$get['sSearch_8']."%'  ");
		}
		if(!empty($get['sSearch_9'])){
					$this->db->where("lower(sama_billno) like  '%".$get['sSearch_9']."%'  ");
		 }

	   

		if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('rema_returndatebs >=',$frmDate);
                $this->db->where('rema_returndatebs <=',$toDate);    
            }else{
                $this->db->where('rema_returndatead >=',$frmDate);
                $this->db->where('rema_returndatead <=',$toDate);
            }
        }
		if($cond) {
		  $this->db->where($cond);
		}

		$this->db->select('rm.*,d.dept_depname');
		$this->db->from('rema_returnmaster rm');
		$this->db->join('dept_department d','rm.rema_depid = d.dept_depid','left');
	   
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
		// echo $this->db->last_query();die();
	  return $ndata;

	}

	public function getStatusCount($srchcol = false, $type = false){
        try{
        	if($type == 'cancel'){
        		$this->db->select("SUM(CASE WHEN sama_st='N' THEN 1 ELSE 0 END ) issue, SUM(CASE WHEN sama_st='C' THEN 1 ELSE 0 END ) cancel");
            	$this->db->from('sama_salemaster');	
        	}else if($type == 'return'){
        		$this->db->select("SUM(CASE WHEN rema_st='N' THEN 1 ELSE 0 END ) issuereturn, SUM(CASE WHEN rema_st='C' THEN 1 ELSE 0 END ) returncancel");
            	$this->db->from('rema_returnmaster');
        	}

            if($srchcol){
                $this->db->where($srchcol);
            }

            $query = $this->db->get();

            if($query->num_rows() > 0){
                return $query->result();
            }
            return false;
        }catch(Exception $e){
            throw $e;
        }
    }

    public function get_return_master($srchcol=false)
	{
		$this->db->select('rm.*,d.dept_depname');
		$this->db->from('rema_returnmaster rm');
		$this->db->join('dept_department d','rm.rema_depid = d.dept_depid','left');
		
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();     
			return $data;       
		}       
		return false;
	}

	public function get_return_detail($srchcol=false)
	{
		$this->db->select('rd.*,il.itli_itemcode,il.itli_itemname,il.itli_itemnamenp,il.itli_itemlistid, ut.unit_unitname');
		$this->db->from('rede_returndetail rd');
		$this->db->join('itli_itemslist il','il.itli_itemlistid=rd.rede_itemsid','LEFT');
		$this->db->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT');
		
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();     
			return $data;       
		}       
		return false;
	}

	public function get_all_issue_details($id=false, $invoiceno = false, $fyear = false)
	{
		$sql = "
			SELECT 
			itli_itemcode,
			itli_itemname,itli_itemnamenp,  
			maty_material,
			maty_materialtypeid,
			issue_remarks,
			return_remarks,
			unit_unitname,
			SUM(
					CASE
					WHEN (tname = 'I') THEN
						(sade_qty)
					ELSE
						0
					END
				) AS IssQty,
			SUM(
				CASE
				WHEN (tname = 'R') THEN
					sade_qty
				ELSE
					0
				END
			) AS RetQty,
			(
				SUM(
					CASE
					WHEN (tname = 'I') THEN
						(sade_qty)
					ELSE
						0
					END
				) - SUM(
					CASE
					WHEN (tname = 'R') THEN
						sade_qty
					ELSE
						0
					END
				)
			) AS TotalIssue,
			SUM(
				CASE
				WHEN (tname = 'I') THEN
					amount
				ELSE
					0
				END
			) AS IssueValue,
			SUM(
				CASE
				WHEN (tname = 'R') THEN
					(amount)
				ELSE
					0
				END
			) AS ReturnValue,
			(
				SUM(
					CASE
					WHEN (tname = 'I') THEN
						(amount)
					ELSE
						0
					END
				) - SUM(
					CASE
					WHEN (tname = 'R') THEN
						amount
					ELSE
						0
					END
				)
			) AS TotalValue
		FROM
			(
				SELECT
					il.itli_itemcode,
					il.itli_itemname,
					my.maty_material,
					my.maty_materialtypeid,
					sm.sama_billdatebs,
					sm.sama_invoiceno,
					sd.sade_qty,
					sd.sade_remarks as issue_remarks,
					'' as return_remarks,
					sd.sade_unitrate AS unitrate,
					u.unit_unitname,
					(
						sd.sade_qty * sd.sade_unitrate
					) AS amount,
					'I' AS tname
				FROM
					xw_sama_salemaster sm
				LEFT JOIN xw_sade_saledetail sd ON sd.sade_salemasterid = sm.sama_salemasterid
				LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = sd.sade_itemsid
				LEFT JOIN xw_maty_materialtype my ON my.maty_materialtypeid = il.itli_materialtypeid
				LEFT JOIN xw_unit_unit u ON u.unit_unitid = il.itli_unitid
				WHERE
					sm.sama_st = 'N' AND sd.sade_salemasterid = '$id'

				UNION

					SELECT
					il.itli_itemcode,
					il.itli_itemname,
					il.itli_itemnamenp,
					my.maty_material,
					my.maty_materialtypeid,
					rm.rema_returndatebs,
					rm.rema_invoiceno AS issueno,
					rd.rede_qty,
					'' as issue_remarks,
					rd.rede_remarks as return_remarks,
					rd.rede_unitprice AS unitrate,
					u.unit_unitname,
					rd.rede_total AS amount,
						'R' AS tname
					FROM
		        xw_rema_returnmaster rm 
					LEFT JOIN xw_rede_returndetail rd ON rm.rema_returnmasterid = rd.rede_returnmasterid
					LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = rd.rede_itemsid
					LEFT JOIN xw_maty_materialtype my ON my.maty_materialtypeid = il.itli_materialtypeid
					LEFT JOIN xw_unit_unit u ON u.unit_unitid = il.itli_unitid
					WHERE rd.rede_invoiceno = '$invoiceno' AND rd.rede_salefyear = '$fyear'
			) X
			group by itli_itemname
			";

		// if($srchcol)
		// {
		// 	$this->db->where($srchcol);
		// }
		// $query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		$query = $this->db->query($sql);

		//echo $this->db->last_query();die();

		if ($query->num_rows() > 0) 
		{
			$data=$query->result();     
			return $data;       
		}       
		return false;
	}

	public function update_returnmaster($id)
	{
		if($id)
		{
			$updateArray['rema_st']='C';
			$updateArray['rema_stdepid']=$this->session->userdata(STORE_ID);
			$updateArray['rema_stusername']=$this->username;
			$updateArray['rema_stdatebs']=CURDATE_NP;
			$updateArray['rema_stdatead']=CURDATE_EN;
			$this->db->update('rema_returnmaster',$updateArray,array('rema_returnmasterid'=>$id));
			$rwaff=$this->db->affected_rows(); 
			if($rwaff){

				$rede_data=$this->get_return_detail(array('rede_returnmasterid'=>$id));
				// echo "<pre>";
				// print_r($rede_data);
				// die();
				if(!empty($rede_data))
				{
					foreach ($rede_data as $ksd => $rede) {
					$qty=$rede->rede_qty;
					$returndetailid=$rede->rede_returndetailid;
					$mat_transdetailidid=$rede->rede_returnmasterid;
					$salesdtlid=$rede->rede_salesdetailid;
					$reqdtlid=$rede->rede_reqdetailid;
					$iscancel=$rede->rede_iscancel;
					if($iscancel!='Y')
					{
						$update_rd=$this->update_returndetail_tbl($returndetailid,$mat_transdetailidid,$salesdtlid,$reqdtlid,$qty);
					}

					}
				}
			 return true;
			}
		}
		return false;
	}

	public function update_returndetail_tbl($returndetailid,$mat_transdetailidid,$salesdtlid,$reqdtlid,$qty)
	{
		if($returndetailid)
		{
			$updateArray['rede_iscancel']='Y';
			$updateArray['rede_canceldatead']=CURDATE_EN;
			$updateArray['rede_canceldatebs']=CURDATE_NP;
			$updateArray['rede_cancelby']= $this->userid;
			$updateArray['rede_cancelusername']= $this->username;
			$updateArray['rede_canceltime']= $this->curtime;
			$updateArray['rede_cancelip']= $this->ip;

		  $this->db->update('rede_returndetail',$updateArray,array('rede_returndetailid'=>$returndetailid));
		$rwaff=$this->db->affected_rows(); 
		if($rwaff){
		 $this->db->query("UPDATE xw_trde_transactiondetail SET trde_issueqty= (trde_issueqty)+$qty, trde_stripqty = (trde_stripqty)+$qty WHERE trde_trdeid=$mat_transdetailidid  ");

		$this->db->query("UPDATE xw_sade_saledetail SET sade_curqty= (sade_curqty)+$qty WHERE sade_saledetailid=$salesdtlid  ");

		$this->db->query("UPDATE xw_rede_reqdetail SET rede_remqty= (rede_remqty)+$qty WHERE rede_reqdetailid=$reqdtlid  ");
		 return true;
			}
		}
		return false;
	}


	public function check_item_stock($itemsid){
        $this->db->select('(SELECT IFNULL(SUM(md.trde_issueqty),0) FROM xw_trde_transactiondetail md LEFT JOIN xw_trma_transactionmain mt   on md.trde_trmaid =mt.trma_trmaid
  WHERE it.itli_itemlistid=md.trde_itemsid AND mt.trma_received=1 AND md.trde_locationid='.$this->locationid.' AND mt.trma_fromdepartmentid='.$this->storeid.' ) as stockqty');
        $this->db->from('itli_itemslist it');
       
        if($itemsid){
            $this->db->where(array('it.itli_itemlistid'=>$itemsid));
        }
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->row();
            return $result->stockqty;
        }
        return false;
    }

}