<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Handover_issue_mdl extends CI_Model
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
		$this->harm_masterTable='xw_haov_handovermaster';
		$this->hard_detailTable='xw_hard_handoverdetail';

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
		$this->sess_usercode = $this->session->userdata(USER_GROUPCODE);
		// echo $this->orgid;
		// die();
	}
	public $validate_handover_issue = array(
		array('field' => 'locationid', 'label' => 'Branch ', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'depid', 'label' => 'Department ', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'sama_requisitionno', 'label' => 'Requisition No. ', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'requisition_date', 'label' => 'Requisition Date ', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'issue_date', 'label' => 'Issue Date ', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'sade_itemsid[]', 'label' => 'Items  ', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'sade_qty[]', 'label' => 'Qty  ', 'rules' => 'trim|required|numeric|greater_than[0]|xss_clean'),
		array('field' => 'qtyinstock[]', 'label' => 'Stock Qty  ', 'rules' => 'trim|required|numeric|greater_than[0]|xss_clean'),
	);

	public $validate_issue_return = array(
		array('field' => 'rema_returnby', 'label' => 'Return by', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'rema_returndate', 'label' => 'Return Date', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'rema_invoiceno', 'label' => 'Return Invoice', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'returnqty[]', 'label' => 'Return Qty.', 'rules' => 'trim|numeric|xss_clean'),
	);
	public $validate_direct_handover_issue = array(
		array('field' => 'locationid', 'label' => 'Branch ', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'sama_depid', 'label' => 'Department ', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'issue_date', 'label' => 'Issue Date ', 'rules' => 'trim|required|xss_clean')
	);

	public function save_handover_issue()
	{
		try{
			$postdata=$this->input->post();
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
			$get_last_billno = $this->general->get_tbl_data('sama_billno','sama_salemaster',array('sama_fyear'=>CUR_FISCALYEAR),'sama_salemasterid','DESC');
			$billno = !empty($get_last_billno[0]->sama_billno)?$get_last_billno[0]->sama_billno:0;
			//master table data
			$depid=$this->input->post('depid');
			$depname = $this->input->post('sama_depname');
			$locationid = !empty($this->input->post('locationid'))?$this->input->post('locationid'):$this->locationid;
			$req_no=$this->input->post('sama_requisitionno');
			if(empty($req_no)){
             $req_no=0;
			}
			$fiscal_year = $this->input->post('sama_fyear');
			// $issue_no = $this->input->post('sama_invoiceno');

			$issue_no = $this->general->generate_invoiceno('haov_handoverno','haov_handoverno','haov_handovermaster',HANDOVER_NO_PREFIX,HANDOVER_NO_LENGTH, false, 'haov_locationid');
			// print_r($issue_no);
			// die();
			$received_by = $this->input->post('sama_receivedby');
			$unit = $this->input->post('unit');
			//detail table data
			$itemsid = $this->input->post('sade_itemsid');
			$qtyinstock = $this->input->post('qtyinstock');
			$unitrate = $this->input->post('sade_unitrate'); //save in unitrate,nrate,purchaserate
			$qty = $this->input->post('sade_qty');
			$remarks = $this->input->post('sade_remarks');
			$sama_remarks = $this->input->post('sama_remarks');
			$itemsname = $this->input->post('sade_itemsname');
			$my_rem_qty=$this->input->post('my_rem_qty');
			$volume = $this->input->post('volume');
			$s_no = $this->input->post('s_no');
			$hard_handoverdetailid = $this->input->post('rede_reqdetailid');

			$this->db->trans_begin();

			if($id){

			} // end if id
			else{
				// insert case
				$samaMasterArray = array(
					'sama_requisitionno'=>$req_no,
						'sama_depid'=>$depid, //depid
						'sama_depname'=>$depname, //depname
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
						'sama_postdatead'=>CURDATE_EN,
						'sama_postdatebs'=>CURDATE_NP,
						'sama_postby'=>$this->userid,
						'sama_postmac'=>$this->mac,
						'sama_postip'=>$this->ip,
						'sama_locationid'=>$this->locationid,
						'sama_ishandover'=>'Y', 
						'sama_orgid'=>$this->orgid                             
					);
				if(!empty($samaMasterArray))
				{  
				     // echo "<pre>";
				     // print_r($samaMasterArray);die;
					// insert into sale master
					$this->db->insert($this->sama_masterTable,$samaMasterArray);
					// $this->general->insert_query_log();
					$salesmasterid=$this->db->insert_id();
					if($salesmasterid){

						$trmaid=$this->insert_into_transaction_main_tbl_by_handover($locationid );
						$this->general->insert_query_log();
						$handovermasterid=$this->insert_into_handover_master_tbl($trmaid);
						$this->general->insert_query_log();

						$ReqMasterArray = array(
							'harm_ishandover'=>'Y'
						);
						if($ReqMasterArray){
							$this->db->update('harm_handoverreqmaster',$ReqMasterArray,array('harm_handoverreqno'=>$req_no,'harm_fyear'=>$fiscal_year,'harm_storeid'=>$this->storeid));
						}
						//update remqty of req detail
						if(!empty($itemsid)):
							foreach($itemsid as $key => $val){
							$reqdtlid = !empty($hard_handoverdetailid[$key])?$hard_handoverdetailid[$key]:'';
								$reqDetail = array(
								'hard_remqty' => !empty($my_rem_qty[$key])?$my_rem_qty[$key]:'',
								'hard_modifydatead'=>CURDATE_EN,
								'hard_modifydatebs'=>CURDATE_NP,
								'hard_modifytime'=>$this->curtime,
								'hard_modifyby'=>$this->userid,
								'hard_modifymac'=>$this->mac,
								'hard_modifyip'=>$this->ip,
								);
							if($reqDetail){
								$this->db->update('hard_handoverreqdetail',$reqDetail,array('hard_handoverdetailid'=>$reqdtlid));
								$this->general->insert_query_log();
							   }
							} // end foreach item
							
						endif;
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
								$reqdetailid=!empty($rede_reqdetailid[$key])?$rede_reqdetailid[$key]:'';
								$rmks=!empty($remarks[$key])?$remarks[$key]:'';
								$sno=!empty($s_no[$key])?$s_no[$key]:'';
								// $volume = !empty($volume[$key])?$volume[$key]:'';
								$volume = 0;
								$microunitid = 0;

								// $mattransdetailid = $this->get_mat_trans_detail_id($items_id,$volume,$microunitid,$issue_qty);

								$this->insert_into_sale_detail($items_id,$issue_qty,$salesmasterid,$reqdetailid,$rmks,$sno,$trmaid,$handovermasterid);

								// $checkSalesMaster = $this->update_mat_trans_detailid($mattransdetailid,$issue_qty,'new_issue');

								$urate = !empty($unitrate[$key])?$unitrate[$key]:0;
								$tprice=$urate*$issue_qty;

								$totalAmount += $tprice; 
							}
							// die();
							$updateMasterSaleArray = array(
								'sama_discountpc'=>$discountpc,
								'sama_discount'=>$totalDiscount,
								'sama_vat'=>$totalVat,
								'sama_taxrate'=>$totalTaxrate,
								'sama_totalamount'=>$totalAmount
							);
							if($updateMasterSaleArray){
						 // $this->db->where('sama_salemasterid',$salesmasterid);
							$this->db->update($this->sama_masterTable,$updateMasterSaleArray,array('sama_salemasterid'=>$salesmasterid));
								$this->general->insert_query_log();
							}

							$updateMastHandoverArray = array(
								'haov_discount'=>$totalDiscount,
								'haov_vat'=>$totalVat,
								'haov_taxrate'=>$totalTaxrate,
								'haov_totalamount'=>$totalAmount
							);
							if($updateMastHandoverArray){
						 // $this->db->where('sama_salemasterid',$salesmasterid);
							$this->db->update('haov_handovermaster',$updateMastHandoverArray,array('haov_handovermasterid'=>$handovermasterid));
								$this->general->insert_query_log();
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
					return $salesmasterid;
				}
			}
		}catch(Exception $e){
			throw $e;
		}
	}

	public function insert_into_handover_master_tbl($tramid = false)
	{
		$reqno=$this->input->post('sama_requisitionno');
		$haov_handoverno=$this->input->post('sama_invoiceno');
		$req_date=$this->input->post('requisition_date');
		$issue_date=$this->input->post('issue_date');
		$fyear =$this->input->post('sama_fyear');
		$sama_remarks=$this->input->post('sama_remarks');
		$sama_depid=$this->input->post('sama_depid');
		$reqlocationid=$this->input->post('locationid');

		// $unit = $this->input->post('unit');
		// $itemsid = $this->input->post('sade_itemsid');
		// $qtyinstock = $this->input->post('qtyinstock');
		// $unitrate = $this->input->post('sade_unitrate'); //save in unitrate,nrate,purchaserate
		// $qty = $this->input->post('sade_qty');
		// $remarks = $this->input->post('sade_remarks');
		$sama_remarks = $this->input->post('sama_remarks');
		// $itemsname = $this->input->post('sade_itemsname');

		// $rede_reqdetailid=$this->input->post('rede_reqdetailid');

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
		$received_by = $this->input->post('sama_receivedby');

		$handoverMaster=array(
			'haov_handoverno'=>$haov_handoverno,
			'haov_handoverreqno'=>$reqno,
			'haov_trmaid' => $tramid,
			'haov_reqdatead'=>$reqdateEn,
			'haov_reqdatebs'=>$reqdateNp,
			'haov_handoverdatead'=>$issuedateEn,
			'haov_handoverdatebs'=>$issuedateNp,
			'haov_handovertime'=>$this->curtime,
			'haov_fromlocationid'=>$this->locationid,
			'haov_tolocationid'=>$reqlocationid,
			'haov_depid'=>$sama_depid,
			'haov_fyear'=>$fyear,
			'haov_discount'=>'',
			'haov_taxrate'=>'',
			'haov_vat'=>'',
			'haov_totalamount'=>'',
			'haov_remarks'=>$sama_remarks,
			'haov_username'=>$this->username,
			'haov_status'=>'O',
			'haov_storeid'=>$this->storeid,
			'haov_postdatead'=>CURDATE_EN,
			'haov_postdatebs'=>CURDATE_NP,
			'haov_postby'=>$this->userid,
			'haov_postmac'=>$this->mac,
			'haov_postip'=>$this->ip,
			'haov_posttime'=>$this->curtime,
			'haov_locationid'=>$this->locationid,
			'haov_orgid'=>$this->orgid,
			'haov_receivedby'=>strtoupper($received_by)	
		);
		if(!empty($handoverMaster)){
			$this->db->insert('haov_handovermaster',$handoverMaster);
			// $this->general->insert_query_log();
			 $insertid=$this->db->insert_id();
			 if(!empty($insertid))
			 {
			 	return $insertid;
			 }
			 return false;
		}
	}

	public function insert_into_transaction_main_tbl_by_handover($tolocid=false)
	{
		$fiscalyear=$this->input->post('sama_fyear');
		$issue_date=$this->input->post('issue_date');
		$received_no='';
			if(DEFAULT_DATEPICKER=='NP')
			{   
				
				$issuedateNp = $issue_date;
				$issuedateEn = $this->general->NepToEngDateConv($issue_date);
			}
			else
			{
				$issuedateEn = $issue_date;
				$issuedateNp = $this->general->EngtoNepDateConv($issue_date);
			}

		$mattransMasterArray = array(
                            'trma_transactiondatead' => $issuedateEn,
                            'trma_transactiondatebs' => $issuedateNp,
                            'trma_transactiontype' => 'HANDOVER',
                            'trma_fromdepartmentid' => $this->storeid, //recheck
                            'trma_todepartmentid' => $this->storeid, //recheck
                            'trma_status' => 'O',
                            'trma_received' => '0', // if received set 1
                            'trma_fyear' => $fiscalyear,
                            'trma_fromby' => $this->userid, //recheck
                            'trma_toby' => $this->userid, //recheck
                            'trma_sttransfer' => 'N', //N
                            'trma_issueno' => $received_no,
                            'trma_postby' => $this->userid,
                            'trma_postdatead' => CURDATE_EN,
                            'trma_postdatebs' => CURDATE_NP,
                            'trma_posttime' => $this->curtime,
                            'trma_postmac' => $this->mac,
                            'trma_postip' => $this->ip,
                            'trma_locationid'=>$tolocid,
                            'trma_orgid'=>$this->orgid
                        );
               if(!empty($mattransMasterArray)){
                    $this->db->insert('trma_transactionmain',$mattransMasterArray);
                    
                    $master_insertid = $this->db->insert_id();

                  // echo $this->db->last_query();
                  // die();
                    if(!empty($master_insertid)){
                    	return $master_insertid;
                    }
                    return false;                
	}
}

	public function insert_into_transaction_detail_tbl_by_handover($trmaid=false,$qty=false,$trid=false,$handovermid=false)
	{	
		$tolocationid=$this->input->post('locationid');
			if(!empty($trmaid)){

				// $trresult=$this->db->get_where('trde_transactiondetail',array('trde_trmaid'=>$trid))->row();
				$trresult=$this->db->select('td.*,il.itli_itemname as itemname,ut.unit_unitid,ut.unit_unitname as unitname')
									->from('trde_transactiondetail td')
									->join('itli_itemslist il','il.itli_itemlistid=td.trde_itemsid','LEFT')
									->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT')
									->where(array('trde_trdeid'=>$trid))
									->get()->row();
				// echo $this->db->last_query();
				// die();

				if(!empty($trresult)){
					// $tr_MasterArray=
					$tr_detaillArray=array(
						'trde_trmaid'=>$trmaid,
						'trde_transactiondatead'=>CURDATE_NP,
						'trde_transactiondatebs'=>CURDATE_EN,
						'trde_expdatead'=>$trresult->trde_expdatead,
						'trde_expdatebs'=>$trresult->trde_expdatebs,
						'trde_itemsid'=>$trresult->trde_itemsid,
						'trde_controlno'=>$trresult->trde_controlno,
						'trde_mfgdatead'=>$trresult->trde_mfgdatead,
						'trde_mfgdatebs'=>$trresult->trde_mfgdatebs,
						'trde_packingtypeid'=>$trresult->trde_packingtypeid,
						'trde_mtdid'=>$trresult->trde_mtdid,
						'trde_batchno'=>$trresult->trde_batchno,
						'trde_unitpercase'=>$trresult->trde_unitpercase,
						'trde_noofcases'=>$trresult->trde_noofcases,
						'trde_caseno'=>$trresult->trde_caseno,
						'trde_requiredqty'=>$qty,
						'trde_issueqty'=>0, // issue update only when receive???
						'trde_transferqty'=>$qty,
						'trde_batchsize'=>$trresult->trde_batchsize,
						'trde_packing'=>$trresult->trde_packing,
						'trde_stripqty'=>$qty,
						'trde_status'=>'O',
						'trde_sysdate'=>CURDATE_EN,
						'trde_lastchangedate'=>$trresult->trde_lastchangedate,
						'trde_lastchangeby'=>$trresult->trde_lastchangeby,
						'trde_mtmid'=>$trresult->trde_mtmid,
						'trde_transactiontype'=>'HANDOVER',
						'trde_statusupdatedatebs'=>$trresult->trde_statusupdatedatebs,
						'trde_statusupdatedatead'=>$trresult->trde_statusupdatedatead,
						'trde_unitprice'=>$trresult->trde_unitprice,
						'trde_selprice'=>$trresult->trde_selprice,
						'trde_remarks'=>'Branch Handover',
						'trde_supplierid'=>$trresult->trde_supplierid,
						'trde_supplierbillno'=>$trresult->trde_supplierbillno,
						'trde_transtime'=>$trresult->trde_transtime,
						'trde_mtdtime'=>$trresult->trde_mtdtime,
						'trde_unitvolume'=>$trresult->trde_unitvolume,
						'trde_microunitid'=>$trresult->trde_microunitid,
						'trde_totalvalue'=>$trresult->trde_totalvalue,
						'trde_description'=>'Stock Transfer From Location :'.$this->locationid.'To'.$tolocationid,
						'trde_free'=>$trresult->trde_free,
						'trde_newissueqty'=>$qty,
						'trde_postip'=>$this->ip,
						'trde_postdatead'=>CURDATE_EN,
						'trde_postdatebs'=>CURDATE_NP,
						'trde_postmac'=>$this->mac,
						'trde_posttime'=>$this->curtime,
						'trde_postby'=>$this->user,
						'trde_locationid'=>$tolocationid,
						'trde_orgid'=>$this->orgid,
						'trde_isassetsync'=>'N'
					);
					if(!empty($tr_detaillArray)){
						$this->db->insert('trde_transactiondetail',$tr_detaillArray);

						$trdid=$this->db->insert_id();
						if(!empty($trdid))
						{
							$total_amt=$qty*($trresult->trde_unitprice);

							$handoverDetailArray= array(
						 	'haod_handovermasterid' => $handovermid,	
						 	'haod_trdid'=>$trdid,
							'haod_itemsid'=> !empty($trresult->trde_itemsid)?$trresult->trde_itemsid:'',
							'hoad_itemname'=> !empty($trresult->itemname)?$trresult->itemname:'',
							'haod_unit' =>!empty($trresult->unitname)?$trresult->unitname:'',
							'haod_qty'=>$qty,
							'haod_remqty'=>$qty,
							'haod_unitprice' =>$trresult->trde_unitprice,
							'haod_remarks' =>'',
							'haod_totalamt' =>$total_amt,
							'haod_postip' =>$this->ip,
							'haod_postmac' =>$this->mac,
							'haod_posttime' =>$this->curtime,
							'haod_postdatead' =>CURDATE_EN,
							'haod_postdatebs' =>CURDATE_NP,
							'haod_postby'=>$this->userid,
							'haod_fromlocationid'=>$this->locationid,
							'haod_tolocationid'=>$tolocationid,
							'haod_orgid'=>$this->orgid,
							'haod_locationid'=>$this->locationid );
							if(!empty($handoverDetailArray)){
								$this->db->insert('haod_handoverdetail',$handoverDetailArray);
								$this->general->insert_query_log();
								}
						}
					}
				}
        }
	}

	public function insert_into_sale_detail($items_id,$issue_qty,$salesmasteid,$rede_reqdetailid,$remarks,$s_no,$trmid=false,$handovermid=false)
	{
		$issue_no = $this->input->post('sama_invoiceno');
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
				'sade_orgid'=>$this->orgid
			);
			if(!empty($saleDetail))
			{   
 // echo"<pre>";print_r($saleDetail);die;
				$this->db->insert($this->sade_detailTable,$saleDetail);
				$this->insert_into_transaction_detail_tbl_by_handover($trmid,$issueqty,$data->trde_trdeid,$handovermid);
				$this->general->insert_query_log();

			}

			if($rem_issue>0)
			{
			// $data->trde_trdeid;    

				// $issueqty=$db_issueqty;
				$this->update_trde_issue_qty(0,$data->trde_trdeid);
				$this->general->insert_query_log();

				$this->insert_into_sale_detail($items_id,$rem_issue,$salesmasteid,$rede_reqdetailid,$remarks,$s_no,$trmid,$handovermid);
				$this->general->insert_query_log();
			 // return   

			}
			else{
				if($rem_issue<=0)
				{

					$rem_issue=-($rem_issue);
					$issueqty=$rem_issue;

					$this->update_trde_issue_qty($rem_issue,$data->trde_trdeid);
					$this->general->insert_query_log();
				// $this->insert_into_sale_detail($items_id,$rem_issue,$salesmasteid,$rede_reqdetailid,$remarks,$s_no);
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
	public function get_handover_issue_book_details_list($cond = false)
	{
		$frmDate=$this->input->get('frmDate');
		$toDate=$this->input->get('toDate');
		$get = $_GET;
		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}
		if(!empty(($frmDate && $toDate)))
		{
			if(DEFAULT_DATEPICKER == 'NP'){
				$this->db->where('haov_handoverdatebs >=',$frmDate);
				$this->db->where('haov_handoverdatebs <=',$toDate);    
			}else{
				$this->db->where('haov_handoverdatead >=',$frmDate);
				$this->db->where('haov_handoverdatead <=',$toDate);
			}
		}
		if(!empty($get['sSearch_1'])){
			$this->db->where("haov_handoverno like  '%".$get['sSearch_1']."%'  ");
		}
		if(!empty($get['sSearch_2'])){
			$this->db->where("haov_handoverdatebs like  '%".$get['sSearch_2']."%'  ");
		}
		if(!empty($get['sSearch_3'])){
			$this->db->where("haov_handoverreqno like  '%".$get['sSearch_3']."%'  ");
		}
		if(!empty($get['sSearch_4'])){
			$this->db->where("itli_itemcode like  '%".$get['sSearch_4']."%'  ");
		}
		if(!empty($get['sSearch_5'])){
			$this->db->where("itli_itemname like  '%".$get['sSearch_5']."%' OR itli_itemnamenp like  '%".$get['sSearch_5']."%' ");
		}
		if(!empty($get['sSearch_6'])){
			$this->db->where("dept_depname like  '%".$get['sSearch_6']."%'  ");
		}
		if(!empty($get['sSearch_7'])){
			$this->db->where("haov_username like  '%".$get['sSearch_7']."%'  ");
		}
		if(!empty($get['sSearch_8'])){
			$this->db->where("haov_receivedby like  '%".$get['sSearch_8']."%'  ");
		}
		if(!empty($get['sSearch_11'])){
			$this->db->where("haod_unitprice like  '%".$get['sSearch_11']."%'  ");
		}
		if(!empty($get['sSearch_10'])){
			$this->db->where("haod_qty like  '%".$get['sSearch_10']."%'  ");
		}

		if($cond) {
			$this->db->where($cond);
		}
		$input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

		if($this->location_ismain=='Y')
		{
			if($input_locationid)
			{
				$this->db->where('sd.haod_locationid',$input_locationid);
			}

		}
		else
		{
			$this->db->where('sd.haod_locationid',$this->locationid);
		}

		$resltrpt=$this->db->select("COUNT(*) as cnt")
		->from('haod_handoverdetail sd')
		->join('haov_handovermaster rn','rn.haov_handovermasterid = sd.haod_handovermasterid','LEFT')
		->join('itli_itemslist eq','eq.itli_itemlistid = sd.haod_itemsid','LEFT')
	   ->join('loca_location loc1','loc1.loca_locationid=sd.haod_fromlocationid','LEFT')
	   ->join('loca_location loc2','loc2.loca_locationid=sd.haod_tolocationid','LEFT')
	    ->join('dept_department dp','dp.dept_depid=rn.haov_depid','LEFT')

		->get()->row();
		// echo $this->db->last_query();die(); 
		$totalfilteredrecs=($resltrpt->cnt); 
		$order_by = 'haov_handoverreqno';
		$order = 'desc';
		if($this->input->get('sSortDir_0'))
		{
			$order = $this->input->get('sSortDir_0');
		}

		$where='';
		if($this->input->get('iSortCol_0')==1)
			$order_by = 'haov_handoverno';
		else if($this->input->get('iSortCol_0')==2)
			if(DEFAULT_DATEPICKER=='NP')
			{
				$order_by = 'haov_handoverdatebs';
			}else{
				$order_by = 'haov_handoverdatead';
			}
			else if($this->input->get('iSortCol_0')==3)
				$order_by = 'haov_handoverreqno';
			else if($this->input->get('iSortCol_0')==4)
				$order_by = 'itli_itemcode';
			else if($this->input->get('iSortCol_0')==5)
				$order_by = 'itli_itemname';
			else if($this->input->get('iSortCol_0')==6)
				$order_by = 'dept_depname';
			else if($this->input->get('iSortCol_0')==7)
				$order_by = 'haov_username';
			else if($this->input->get('iSortCol_0')==8)
				$order_by = 'haov_receivedby';
			else if($this->input->get('iSortCol_0')==9)
				$order_by = 'haov_billtime';
			else if($this->input->get('iSortCol_0')==10)
				$order_by = 'haod_qty';
			else if($this->input->get('iSortCol_0')==11)
				$order_by = 'haod_unitprice';
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
			if(!empty(($frmDate && $toDate)))
			{
				if(DEFAULT_DATEPICKER == 'NP'){
					$this->db->where('haov_handoverdatebs >=',$frmDate);
					$this->db->where('haov_handoverdatebs <=',$toDate);    
				}else{
					$this->db->where('haov_handoverdatead >=',$frmDate);
					$this->db->where('haov_handoverdatead <=',$toDate);
				}
			}

			if(!empty($get['sSearch_1'])){
				$this->db->where("haov_handoverno like  '%".$get['sSearch_1']."%'  ");
			}
			if(!empty($get['sSearch_2'])){
				if(DEFAULT_DATEPICKER=='NP')
				{
					$this->db->where("haov_handoverdatebs like  '%".$get['sSearch_2']."%'  ");
				}else{
					$this->db->where("haov_handoverdatead like  '%".$get['sSearch_2']."%'  ");
				}
			}
			if(!empty($get['sSearch_3'])){
				$this->db->where("haov_handoverreqno like  '%".$get['sSearch_3']."%'  ");
			}
			if(!empty($get['sSearch_4'])){
				$this->db->where("itli_itemcode like  '%".$get['sSearch_4']."%'  ");
			}
			if(!empty($get['sSearch_5'])){
				$this->db->where("itli_itemname like  '%".$get['sSearch_5']."%' OR itli_itemnamenp like  '%".$get['sSearch_5']."%' ");
			}
			if(!empty($get['sSearch_6'])){
				$this->db->where("dept_depname like  '%".$get['sSearch_6']."%'  ");
			}
			if(!empty($get['sSearch_7'])){
				$this->db->where("haov_username like  '%".$get['sSearch_7']."%'  ");
			}
			if(!empty($get['sSearch_8'])){
				$this->db->where("haov_receivedby like  '%".$get['sSearch_8']."%'  ");
			}
			if(!empty($get['sSearch_10'])){
				$this->db->where("haod_qty like  '%".$get['sSearch_10']."%'  ");
			}
			if(!empty($get['sSearch_11'])){
				$this->db->where("haod_unitprice like  '%".$get['sSearch_11']."%'  ");
			}

			if($cond) {
				$this->db->where($cond);
			}

			if($this->location_ismain=='Y')
			{
				if($input_locationid)
				{
					$this->db->where('sd.haod_locationid',$input_locationid);
				}

			}
			else
			{
				$this->db->where('sd.haod_locationid',$this->locationid);
			}
			$this->db->select('rn.haov_handoverreqno,rn.haov_handovertime,sd.haod_qty,sd.haod_unitprice,sd.haod_remarks,rn.haov_handovermasterid,rn.haov_handoverno,rn.haov_handoverdatebs,rn.haov_handoverdatead,dp.dept_depname,rn.haov_totalamount,rn.haov_username,rn.haov_receivedby,(sd.haod_qty*sd.haod_unitprice) as issueamt,eq.itli_itemname,rn.haov_isreceived,eq.itli_itemnamenp,eq.itli_itemcode,eq.itli_itemlistid,loc1.loca_name as fromlocation,loc2.loca_name as tolocation');
			$this->db->from('haod_handoverdetail sd');
			$this->db->join('haov_handovermaster rn','rn.haov_handovermasterid = sd.haod_handovermasterid','LEFT');
			$this->db->join('dept_department dp','dp.dept_depid=rn.haov_depid','LEFT');
			$this->db->join('itli_itemslist eq','eq.itli_itemlistid = sd.haod_itemsid','LEFT');
			$this->db->join('loca_location loc1','loc1.loca_locationid=sd.haod_fromlocationid','LEFT');
			$this->db->join('loca_location loc2','loc2.loca_locationid=sd.haod_tolocationid','LEFT');
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
	   // echo $this->db->last_query();
	   // die();
			$num_row=$nquery->num_rows();

			// if(!empty($_GET['iDisplayLength'])) {
			// 	$totalrecs = sizeof( $nquery);
			// }
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
		
		public function get_mat_trans_detail_id($itemsid,$vol=0,$unit=0,$issueqty=false)
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
					$this->update_trde_issue_qty($rem_issue,$data->trde_trdeid);
					$this->get_mat_trans_detail_id($itemsid,$vol,$unit,$rem_issue);
			 // return   

				}
				else{
					if($rem_issue<0)
					{
						$rem_issue=-($rem_issue);
						$this->update_trde_issue_qty($rem_issue,$data->trde_trdeid);
					}

					return $data->trde_trdeid;
				}

		// return array(
		//     'mattransdetailid' => $data->trde_trdeid,
		//     'trde_issue_qty' => $data->trde_issueqty
		// );
			} 
		}

		public function update_trde_issue_qty($rem_qty, $trde_id){
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

			$locationid=$this->input->post('locationid');
			$this->db->select('sm.*');
			$this->db->from('sama_salemaster sm');

			if($srchcol)
			{
				$this->db->where($srchcol);
			}
			if(!empty($locationid)){
				$this->db->where('sama_locationid',$locationid);
			}else{
				$this->db->where('sama_locationid',$this->locationid);
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
			$this->db->select('sd.*, sum(sd.haod_qty) as totalcurqty, sum(sd.haod_qty) as totalqty, il.itli_itemcode,il.itli_itemname,il.itli_itemnamenp,il.itli_itemlistid,ut.unit_unitname,hm.haov_handoverno,sum(sd.haod_unitprice * sd.haod_qty) as subtotal');
			$this->db->from('haod_handoverdetail sd');
			$this->db->join('haov_handovermaster hm','hm.haov_handovermasterid=sd.haod_handovermasterid','LEFT');
			$this->db->join('itli_itemslist il','il.itli_itemlistid=sd.haod_itemsid','INNER');
			$this->db->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT');
			$this->db->group_by('il.itli_itemlistid');
			if($srchcol)
			{
				$this->db->where($srchcol);
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
			public function get_handover_data($srchcol=false)
		{
			$this->db->select('hm.*,hd.*,loc1.loca_name as fromlocation,loc2.loca_name as tolocation');
			$this->db->from('haov_handovermaster hm');
			$this->db->join('haod_handoverdetail hd','hd.haod_handovermasterid=hm.haov_handovermasterid','LEFT');
			$this->db->join('loca_location loc1','loc1.loca_locationid=hm.haov_fromlocationid','left');
			$this->db->join('loca_location loc2','loc2.loca_locationid=hm.haov_tolocationid','left');
			// $this->db->join('itli_itemslist il','il.itli_itemlistid=hm.haod_itemsid','INNER');
			// $this->db->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT');
			// $this->db->group_by('il.itli_itemlistid');
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
					'rema_locationid'=>$this->locationid,
					'rema_orgid'=>$this->orgid
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
				'rede_locationid'=>$this->locationid
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
		$locationid=$this->input->get('locationid')?$this->input->get('locationid'):'';

		$get = $_GET;
		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}

		if(!empty($get['sSearch_1'])){
			$this->db->where("rema_invoiceno like  '%".$get['sSearch_1']."%'  ");
		}
		if(!empty($get['sSearch_2'])){
			$this->db->where("rema_returndatebs like  '%".$get['sSearch_2']."%'  ");
		}
		if(!empty($get['sSearch_3'])){
			$this->db->where("sama_depname like  '%".$get['sSearch_3']."%'  ");
		}
		if(!empty($get['sSearch_4'])){
			$this->db->where("sama_totalamount like  '%".$get['sSearch_4']."%'  ");
		}
		if(!empty($get['sSearch_5'])){
			$this->db->where("sama_username like  '%".$get['sSearch_5']."%'  ");
		}
		if(!empty($get['sSearch_6'])){
			$this->db->where("sama_receivedby like  '%".$get['sSearch_6']."%'  ");
		}
		if(!empty($get['sSearch_7'])){
			$this->db->where("sama_requisitionno like  '%".$get['sSearch_7']."%'  ");
		}
		if(!empty($get['sSearch_8'])){
			$this->db->where("sama_billtime like  '%".$get['sSearch_8']."%'  ");
		}
		if(!empty($get['sSearch_9'])){
			$this->db->where("sama_billno like  '%".$get['sSearch_9']."%'  ");
		}

		if($cond) {
			$this->db->where($cond);
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
		if($this->location_ismain=='Y')
		{

			if(!empty($locationid))
			{
				$this->db->where('rema_locationid',$locationid);
			}else{
				$this->db->where('rema_locationid',$this->locationid);
			}
		}
		else
		{
			$this->db->where('rema_locationid',$this->locationid);
		}

		$resltrpt=$this->db->select("COUNT(*) as cnt")
		->from('rema_returnmaster rm')
		->join('dept_department d','rm.rema_depid = d.dept_depid','left')
		->get()->row();

		// echo $this->db->last_query();die(); 
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
			$this->db->where("sama_invoiceno like  '%".$get['sSearch_1']."%'  ");
		}
		if(!empty($get['sSearch_2'])){
			$this->db->where("rema_returndatebs like  '%".$get['sSearch_2']."%'  ");
		}
		if(!empty($get['sSearch_3'])){
			$this->db->where("sama_depname like  '%".$get['sSearch_3']."%'  ");
		}
		if(!empty($get['sSearch_4'])){
			$this->db->where("sama_totalamount like  '%".$get['sSearch_4']."%'  ");
		}
		if(!empty($get['sSearch_5'])){
			$this->db->where("sama_username like  '%".$get['sSearch_5']."%'  ");
		}
		if(!empty($get['sSearch_6'])){
			$this->db->where("sama_receivedby like  '%".$get['sSearch_6']."%'  ");
		}
		if(!empty($get['sSearch_7'])){
			$this->db->where("sama_requisitionno like  '%".$get['sSearch_7']."%'  ");
		}
		if(!empty($get['sSearch_8'])){
			$this->db->where("sama_billtime like  '%".$get['sSearch_8']."%'  ");
		}
		if(!empty($get['sSearch_9'])){
			$this->db->where("sama_billno like  '%".$get['sSearch_9']."%'  ");
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

		if($this->location_ismain=='Y')
		{

			if(!empty($locationid))
			{
				$this->db->where('rema_locationid',$locationid);
			}else{
				$this->db->where('rema_locationid',$this->locationid);
			}
		}
		else
		{
			$this->db->where('rema_locationid',$this->locationid);
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
		// if(!empty($_GET['iDisplayLength'])) {
		// 	$totalrecs = sizeof( $nquery);
		// }
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

	public function get_return_master($srchcol=false)
	{
		$locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

		$this->db->select('rm.*,d.dept_depname');
		$this->db->from('haov_handovermaster rm');
		$this->db->join('dept_department d','rm.haov_tolocationid = d.dept_depid','left');
		
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		if($this->location_ismain=='Y')
		{
			if($locationid)
			{
				$this->db->where('rm.haov_locationid',$locationid);
			}
		}
		else
		{
			$this->db->where('rm.haov_locationid',$this->locationid);
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
        // echo $this->db->last_query();die;
		if($query->num_rows() > 0){
			$result = $query->row();
			return $result->stockqty;
		}
		return false;
	}

	public function get_approve_data($id = false){
		$this->db->select('rm.rema_approvedby, rm.rema_approvedid, rm.rema_approved, rm.rema_approveddatead, rm.rema_approveddatebs');
		$this->db->from('sama_salemaster sm');
		$this->db->join('rema_reqmaster rm','sm.sama_requisitionno = rm.rema_reqno and sm.sama_fyear = rm.rema_fyear');
		$this->db->where('sm.sama_salemasterid',$id);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$result = $query->result();
			return $result;
		}
		return false;
	}
	public function get_handover_req_no_list($srchcol = false, $order_by = false, $order = false){
		$this->db->select('rm.harm_handoverreqno, d.dept_depname');
		$this->db->from('harm_handoverreqmaster rm');
		$this->db->join('dept_department d','d.dept_depid = rm.harm_fromdepid','left');
		if($srchcol){
			$this->db->where($srchcol);
		}
		if($order_by && $order){
			$this->db->order_by($order_by,$order);    
		}

		$query = $this->db->get();
         // echo $this->db->last_query();die();
		if($query->num_rows() > 0){
			$result = $query->result();
			return $result;
		}
		return false;
	}
	
	public function get_handover_requisition_details($srchcol = false){
		$this->db->select('it.itli_itemcode, it.itli_itemname, it.itli_itemnamenp, it.itli_itemlistid, it.itli_purchaserate, it.itli_salesrate, rd.hard_handoverdetailid, rd.hard_itemsid, rd.hard_qty,rd.hard_remqty,rd.hard_handovermasterid, ut.unit_unitname, rd.hard_qtyinstock,(SELECT IFNULL(SUM(md.trde_issueqty),0) FROM xw_trde_transactiondetail md LEFT JOIN xw_trma_transactionmain mt   on md.trde_trmaid =mt.trma_trmaid
			WHERE it.itli_itemlistid=md.trde_itemsid AND mt.trma_received=1 AND md.trde_locationid='.$this->locationid.' AND mt.trma_fromdepartmentid='.$this->storeid.' ) as stockqty,rd.hard_remarks');
		$this->db->from('hard_handoverreqdetail rd');
		$this->db->join('itli_itemslist it','it.itli_itemlistid = rd.hard_itemsid','left');
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
	public function get_issue_handover_list($cond=false)
		{
		
			$get = $_GET;
			foreach ($get as $key => $value) {
				$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
			}

			if(!empty($get['sSearch_1'])){
				$this->db->where("haov_handoverno like  '%".$get['sSearch_1']."%'  ");
			}
			if(!empty($get['sSearch_2'])){
				$this->db->where("haov_handoverreqno like  '%".$get['sSearch_2']."%'  ");
			}
			if(!empty($get['sSearch_3'])){
				$this->db->where("haov_handoverdatead like  '%".$get['sSearch_3']."%'  ");
			}
			if(!empty($get['sSearch_4'])){
				$this->db->where("haov_handoverdatebs like  '%".$get['sSearch_4']."%'  ");
			}
			if(!empty($get['sSearch_5'])){
				$this->db->where("haov_handovertime like  '%".$get['sSearch_5']."%'  ");
			}
			if(!empty($get['sSearch_6'])){
				$this->db->where("haov_isreceived like  '%".$get['sSearch_6']."%'  ");
			}
			if(!empty($get['sSearch_7'])){
				$this->db->where("tolocation like  '%".$get['sSearch_7']."%'  ");
			}
			if(!empty($get['sSearch_8'])){
				$this->db->where("haov_fyear like  '%".$get['sSearch_8']."%'  ");
			}
		
			if($cond) {
				$this->db->where($cond);
			}
			$input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->get('locationid');
            $frmDate= !empty($get['frmDate'])?$get['frmDate']:$this->input->get('frmDate');
            $toDate= !empty($get['toDate'])?$get['toDate']:$this->input->get('toDate');
            $apptype = !empty($get['apptype'])?$get['apptype']:$this->input->get('apptype');
            // echo $apptype;die;

            if($apptype=='handover')
            {
                $status='N';
            }
              if($apptype=='received')
            {
                $status='Y';
            }

        if(!empty($apptype))
         {
            $this->db->where('hm.haov_isreceived',$status);
         }
        
			if(!empty(($frmDate && $toDate)))
			{
				if(DEFAULT_DATEPICKER == 'NP'){
					$this->db->where('haov_handoverdatebs >=',$frmDate);
					$this->db->where('haov_handoverdatebs <=',$toDate);    
				}else{
					$this->db->where('haov_handoverdatead >=',$frmDate);
					$this->db->where('haov_handoverdatead <=',$toDate);
				}
			}

			if($this->location_ismain=='Y')
			{
				if(!empty($input_locationid))
				{
					$this->db->where('hm.haov_tolocationid',$input_locationid);
				}else{
					$this->db->where('hm.haov_locationid',$this->locationid);
				}
			} 
			else{
				$this->db->where('haov_tolocationid',$this->locationid);
			}

			$resltrpt=$this->db->select("COUNT(*) as cnt,")
		    ->from('haov_handovermaster hm')
			// $this->db->join('sade_saledetail sd','sd.sade_salemasterid =sm.sama_salemasterid','LEFT');
	       ->join('loca_location loc1','loc1.loca_locationid=hm.haov_fromlocationid','left')
		   ->join('loca_location loc2','loc2.loca_locationid=hm.haov_tolocationid','left')
			->get()->row();
		// echo $this->db->last_query();die(); 
			$totalfilteredrecs=($resltrpt->cnt); 
			$order_by = 'haov_handovermasterid';
			$order = 'desc';
			if($this->input->get('sSortDir_0'))
			{
				$order = $this->input->get('sSortDir_0');
			}

			$where='';
			if($this->input->get('iSortCol_0')==1)
				$order_by = 'haov_handoverno';
			else  if($this->input->get('iSortCol_0')==2)
				$order_by = 'haov_handoverreqno';
			else  if($this->input->get('iSortCol_0')==3)
				$order_by = 'haov_handoverdatead';

			else if($this->input->get('iSortCol_0')==4)
				$order_by = 'haov_handoverdatebs';
			else if($this->input->get('iSortCol_0')==5)
				$order_by = 'haov_handovertime';
			else if($this->input->get('iSortCol_0')==6)
				$order_by = 'haov_isreceived';
			else if($this->input->get('iSortCol_0')==7)
				$order_by = 'tolocation';
			else if($this->input->get('iSortCol_0')==8)
				$order_by = 'haov_fyear';
		
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
				$this->db->where("haov_handoverno like  '%".$get['sSearch_1']."%'  ");
			}
			if(!empty($get['sSearch_2'])){
				$this->db->where("haov_handoverreqno like  '%".$get['sSearch_2']."%'  ");
			}
			if(!empty($get['sSearch_3'])){
				$this->db->where("haov_handoverdatead like  '%".$get['sSearch_3']."%'  ");
			}
			if(!empty($get['sSearch_4'])){
				$this->db->where("haov_handoverdatebs like  '%".$get['sSearch_4']."%'  ");
			}
			if(!empty($get['sSearch_5'])){
				$this->db->where("haov_handovertime like  '%".$get['sSearch_5']."%'  ");
			}
			if(!empty($get['sSearch_6'])){
				$this->db->where("haov_isreceived like  '%".$get['sSearch_6']."%'  ");
			}
			if(!empty($get['sSearch_7'])){
				$this->db->where("tolocation like  '%".$get['sSearch_7']."%'  ");
			}
			if(!empty($get['sSearch_8'])){
				$this->db->where("haov_fyear like  '%".$get['sSearch_8']."%'  ");
			}
		
			$input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->get('locationid');
            $frmDate= !empty($get['frmDate'])?$get['frmDate']:$this->input->get('frmDate');
            $toDate= !empty($get['toDate'])?$get['toDate']:$this->input->get('toDate');
            $apptype = !empty($get['apptype'])?$get['apptype']:$this->input->get('apptype');

            if($apptype=='handover')
            {
                $status='N';
            }
              if($apptype=='received')
            {
                $status='Y';
            }

        if(!empty($apptype))
         {
            $this->db->where('haov_isreceived',$status);
         }
        
			if(!empty(($frmDate && $toDate)))
			{
				if(DEFAULT_DATEPICKER == 'NP'){
					$this->db->where('haov_handoverdatebs >=',$frmDate);
					$this->db->where('haov_handoverdatebs <=',$toDate);    
				}else{
					$this->db->where('haov_handoverdatead >=',$frmDate);
					$this->db->where('haov_handoverdatead <=',$toDate);
				}
			}
			
			if($this->location_ismain=='Y')
			{
				if(!empty($input_locationid))
				{
					$this->db->where('hm.haov_tolocationid',$input_locationid);
				}else{
					$this->db->where('hm.haov_locationid',$this->locationid);
				}
			}
			else
			{
				$this->db->where('hm.haov_tolocationid',$this->locationid);
			}
			if($cond) {
				$this->db->where($cond);
			}
			
			$this->db->select("hm.*,loc1.loca_name as fromlocation,loc2.loca_name as tolocation");
			$this->db->from('xw_haov_handovermaster hm');
			// $this->db->join('sade_saledetail sd','sd.sade_salemasterid =sm.sama_salemasterid','LEFT');
			$this->db->join('loca_location loc1','loc1.loca_locationid=hm.haov_fromlocationid','left');
			$this->db->join('loca_location loc2','loc2.loca_locationid=hm.haov_tolocationid','left');

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
			// if(!empty($_GET['iDisplayLength'])) {
			// 	$totalrecs = sizeof( $nquery);
			// }
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
		public function getStatusCount($srchcol = false){
   try{
      $this->db->select("SUM(CASE WHEN haov_isreceived='N' THEN 1 ELSE 0 END ) handover, SUM(CASE WHEN haov_isreceived='Y' THEN 1 ELSE 0 END ) received");
      $this->db->from('haov_handovermaster');

      if($srchcol){
         $this->db->where($srchcol);
     }

     $query = $this->db->get();
     // echo $this->db->last_query();die;

     if($query->num_rows() > 0){
         return $query->result();
     }
     return false;
 }catch(Exception $e){
  throw $e;
}
}

public function received_handover_status_change()
	{   
		$this->userid = $this->session->userdata(USER_ID);
		$this->username = $this->session->userdata(USER_NAME);
		$id=$this->input->post('handoverid');
		$locationid = $this->input->post('locationid');
		$receiver_name = $this->input->post('haov_receivedby');
		$trmaid = $this->input->post('haov_trmaid');
		$received_date = $this->input->post('haov_receiveddate');

		if(DEFAULT_DATEPICKER=='NP')
		{   
			$received_date_Np = $received_date;
			$received_date_En = $this->general->NepToEngDateConv($received_date);
		}
		else
		{
			$received_date_En = $received_date;
			$received_date_Np = $this->general->EngtoNepDateConv($received_date);
		}

		$postdata = array(
			'haov_isreceived'=>'Y',
			'haov_modifydatead'=>CURDATE_EN,
			'haov_modifydatebs'=> CURDATE_NP,
			'haov_modifytime'=>date('H:i:s'),
			'haov_modifymac'=>$this->general->get_real_ipaddr(),
			'haov_modifyip'=>$this->general->get_Mac_Address(),
			'haov_receivedby'=>$receiver_name,
			'haov_receiveddatead'=>$received_date_En,
			'haov_receiveddatebs'=>$received_date_Np,
			'haov_tolocationid'=>$locationid
		);

     //echo"<pre>";print_r($postdata);die;
		$this->db->update('haov_handovermaster',$postdata,array('haov_handovermasterid'=>$id));
        //echo  $this->db->last_query();die;

		$trma_array = array(
			'trma_received' => '1'
		);

		$this->db->where('trma_trmaid',$trmaid);
		$this->db->update('trma_transactionmain',$trma_array);

		$rowaffected=$this->db->affected_rows();
		if($rowaffected)
		{
			return $rowaffected;
		}
		else
		{
			return false;
		}

	}
		public function get_handovermaster_date_id($srchcol = false){
		try{
			$this->db->select('hm.*,loc1.loca_name as fromlocation,loc2.loca_name as tolocation,d.dept_depname');
			$this->db->from('haov_handovermaster hm');
			$this->db->join('loca_location loc1','loc1.loca_locationid=hm.haov_fromlocationid','left');
			$this->db->join('loca_location loc2','loc2.loca_locationid=hm.haov_tolocationid','left');
			$this->db->join('dept_department d','d.dept_depid = hm.haov_depid','left');
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

		public function get_all_handover_issue_details($srchcol=false)
		{
			$this->db->select('sd.*, sum(haod_qty) as haod_qty, sum(haod_remqty) as haod_remqty, il.itli_itemcode,il.itli_itemname,il.itli_itemnamenp,il.itli_itemlistid,ut.unit_unitname');
			$this->db->from('haod_handoverdetail sd');
		     // $this->db->join('haov_handovermaster hm','hm.haov_handovermasterid=sd.haod_handovermasterid','LEFT');
			$this->db->join('itli_itemslist il','il.itli_itemlistid=sd.haod_itemsid','INNER');
			$this->db->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT');
			$this->db->group_by('il.itli_itemlistid');
			if($srchcol)
			{
				$this->db->where($srchcol);
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
 public function getColorStatusCount($srchcol = false){

 if($srchcol){
     $con1= $srchcol;
 }
 else{
     $con1='';
 }
$sql="SELECT * FROM
     xw_coco_colorcode cc
    LEFT JOIN (
     SELECT
         haov_isreceived,
         COUNT('*') AS statuscount
     FROM
         xw_haov_handovermaster hm
     ".$con1."
     GROUP BY
         haov_isreceived
    ) X ON X.haov_isreceived = cc.coco_statusval
    WHERE
     cc.coco_listname = 'handover_issuelist'
    AND cc.coco_statusval <> ''
    AND cc.coco_isactive = 'Y'";
            
         $query = $this->db->query($sql);
         // echo $this->db->last_query();
         // die();
         return $query->result();
        
    }

    public function get_harm_data_from_haov_id($id = false){
    	$this->db->select('harm_handovermasterid,haov_handoverno, haov_reqdatead, haov_reqdatebs, haov_handoverdatead, haov_handoverdatebs, haov_username, haov_receivedby, haov_receiveddatead, haov_receiveddatebs, harm_requestedby, harm_username');
    	$this->db->from('haov_handovermaster ho');
    	$this->db->join('harm_handoverreqmaster hr','hr.harm_handoverreqno = ho.haov_handoverreqno and hr.harm_fyear = ho.haov_fyear');
    	if($id){
    		$this->db->where('haov_handovermasterid',$id);
    	}
    	$query = $this->db->get();

		if ($query->num_rows() > 0) 
		{
			$data=$query->result();     
			return $data;       
		}       
		return false;
    }

    public function receive_handover_items(){
    	$receiver_name = $this->input->post('haov_receivedby');
		$received_date = $this->input->post('haov_receiveddate');
		$haov_handovermasterid = $this->input->post('haov_handovermasterid');
		$haod_trdid = $this->input->post('haod_trdid');
		$trmaid = $this->input->post('haov_trmaid');
		$handoverreqno = $this->input->post('harm_reqno');
		$fyear = $this->input->post('fyear');
		$locationid = $this->input->post('locationid');
		$requested_qty = $this->input->post('requested_qty');

		$handoverdetailid = $this->input->post('handoverdetailid');
		$itemsid = $this->input->post('items_id');
		$unitprice = $this->input->post('unitprice');
		$receive_qty = $this->input->post('receive_qty');

		if(DEFAULT_DATEPICKER=='NP')
		{   
			$received_date_Np = $received_date;
			$received_date_En = $this->general->NepToEngDateConv($received_date);
		}
		else
		{
			$received_date_En = $received_date;
			$received_date_Np = $this->general->EngtoNepDateConv($received_date);
		}

		$ttl_amt = 0;
		if(!empty($unitprice)){
			foreach($unitprice as $pricekey=>$priceval){
				$ttl_amt = $ttl_amt + ($unitprice[$pricekey]*$receive_qty[$pricekey]);
			}
		}

		$get_receive_no = $this->general->get_tbl_data('MAX(hrem_receivedno) as receivedno','hrem_handoverrecmaster', array('hrem_locationid'=>$this->locationid, 'hrem_fyear'=>CUR_FISCALYEAR),'hrem_receivedno','DESF');
		$receive_no = !empty($get_receive_no[0]->receivedno+1)?$get_receive_no[0]->receivedno:0;

		// insert in handover receive master
		$hrem_array = array(
			'hrem_receiveddatebs' => CURDATE_NP,
			'hrem_receiveddatead' => CURDATE_EN,
			'hrem_fyear' => CUR_FISCALYEAR,
			'hrem_handovermasterid' => $haov_handovermasterid,
			'hrem_amount' => $ttl_amt,
			'hrem_handoverno' => $handoverreqno,
			'hrem_receivedno' => $receive_no+1,
			'hrem_storeid' => $this->storeid,
			'hrem_status' => 'O',
			'hrem_postby' => $this->userid,
			'hrem_postdatead' => CURDATE_EN,
			'hrem_postdatebs' => CURDATE_NP,
			'hrem_posttime' => $this->curtime,
			'hrem_postmac' => $this->mac,
			'hrem_postip' => $this->ip,
			'hrem_locationid'=>$this->locationid,
			'hrem_orgid'=>$this->orgid
		);

		if(!empty($hrem_array)){
			$this->db->insert('hrem_handoverrecmaster', $hrem_array);
			$hrem_insertid=$this->db->insert_id();
		}

		// insert in handover receive detail
		if($hrem_insertid){
			if(!empty($itemsid)){
				foreach($itemsid as $reckey=>$recval){
					$hred_array = array(
						'hred_handoverrecmasterid' => $hrem_insertid,
						'hred_itemsid' => !empty($itemsid[$reckey])?$itemsid[$reckey]:'',
						'hred_receivedqty' => !empty($receive_qty[$reckey])?$receive_qty[$reckey]:'',
						'hred_unitprice' => !empty($unitprice[$reckey])?$unitprice[$reckey]:'', 
						'hred_handoverdetailid' => !empty($handoverdetailid[$reckey])?$handoverdetailid[$reckey]:'', 
						'hred_postby' => $this->userid,
						'hred_postdatead' => CURDATE_EN,
						'hred_postdatebs' => CURDATE_NP,
						'hred_posttime' => $this->curtime,
						'hred_postmac' => $this->mac,
						'hred_postip' => $this->ip,
						'hred_locationid'=>$this->locationid,
						'hred_orgid'=>$this->orgid 
					);

					if(!empty($hred_array)){
						$this->db->insert('hred_handoverrecdetail',$hred_array);
					}
				}
			}
		}

		//get rem qty
		// $get_remain_items = $this->general->get_tbl_data('haod_remqty','haod_handoverdetail',array('haod_remqty !='=>0, 'haod_handovermasterid'=>$haov_handovermasterid));

		// $count_input_items = count($haod_trdid);
		// $count_remain_items = count($get_remain_items);

		// if(!empty($haod_trdid)){
		// 	$all_total_qty = 0;
		// 	foreach($haod_trdid as $tkey=>$tvalue){
		// 		$requestedqty = !empty($requested_qty[$tkey])?$requested_qty[$tkey]:0;
		// 	 	$receiveqty = !empty($receive_qty[$tkey])?$receive_qty[$tkey]:0;

		// 	 	$total_qty = $requestedqty - $receiveqty;

		// 	 	$all_total_qty = $all_total_qty+$total_qty;
		// 	}
		// }

		// if($count_input_items >= $count_remain_items){
  //           if($all_total_qty == 0){
  //               $received_status = 'Y';
  //           }else{
  //               $received_status = 'P';
  //           }
  //       }else{
  //           $received_status = 'P';
  //       }

		//update haod rem qty
		if(!empty($itemsid)){
			foreach($itemsid as $itkey => $itval){
				$trde_id_list = $this->get_trdeid_from_handovermasterid($haov_handovermasterid, $itemsid[$itkey]);

				// print_r($trde_id_list);

				$total_haod_receive_qty = $receive_qty[$itkey];

				if($total_haod_receive_qty > 0):
					$first_call = 0;
					if(!empty($trde_id_list)):
						foreach($trde_id_list as $trkey => $trval){
							if($total_haod_receive_qty > 0):
								$new_haod_receive_qty = $this->update_hoad_remqty_from_trdeid($first_call,$trval->haod_trdid, $itemsid[$itkey], $trval->haod_remqty, $trval->haod_qty, $total_haod_receive_qty);
							endif;

							$total_haod_receive_qty = $new_haod_receive_qty;
							$first_call++;
						}

					endif;
				endif;
			}
		}
		// update haod rem qty end

		$trma_array = array(
			'trma_received' => '1'
		);

		$this->db->where('trma_trmaid',$trmaid);
		$this->db->update('trma_transactionmain',$trma_array);

		if(!empty($itemsid)){
			foreach($itemsid as $itkey => $itval){
				$trde_id_list = $this->get_trdeid_from_trmaid($trmaid, $itemsid[$itkey]);

				$total_receive_qty = $receive_qty[$itkey];

				if($total_receive_qty > 0):
					$first_call = 0;
					if(!empty($trde_id_list)):
						foreach($trde_id_list as $trkey => $trval){
							if($total_receive_qty > 0):
								$new_receive_qty = $this->update_issue_qty_from_trdeid($first_call,$trval->trde_trdeid, $itemsid[$itkey], $trval->trde_issueqty, $trval->trde_requiredqty, $total_receive_qty);
							endif;

							$total_receive_qty = $new_receive_qty;
							$first_call++;
						}
					endif;
				endif;
			}
		}

		$check_received_qty = $this->general->get_tbl_data('sum(haod_remqty) as sum_remqty','haod_handoverdetail',array('haod_handovermasterid'=>$haov_handovermasterid));

		if($check_received_qty[0]->sum_remqty =='0'){
			$received_status = 'Y';
		}else{
			$received_status = 'P';
		}
		//update handover status
		$postdata = array(
			'haov_isreceived'=>$received_status,
			'haov_modifydatead'=>CURDATE_EN,
			'haov_modifydatebs'=> CURDATE_NP,
			'haov_modifytime'=>date('H:i:s'),
			'haov_modifymac'=>$this->general->get_real_ipaddr(),
			'haov_modifyip'=>$this->general->get_Mac_Address(),
			'haov_receivedby'=>$receiver_name,
			'haov_receiveddatead'=>$received_date_En,
			'haov_receiveddatebs'=>$received_date_Np,
			// 'haov_tolocationid'=>$locationid
		);

		$this->db->update('haov_handovermaster',$postdata,array('haov_handovermasterid'=>$haov_handovermasterid));

		return true;
    }

    public function get_trdeid_from_trmaid($trmaid, $itemsid){
    	$this->db->select('trde_trdeid, trde_requiredqty, trde_issueqty');
    	$this->db->from('trde_transactiondetail td');
    	$this->db->where('trde_requiredqty <>', 'trde_issueqty', false);
    	$this->db->where('trde_trmaid', $trmaid);
    	$this->db->where('trde_itemsid', $itemsid);
    	$this->db->order_by('trde_trdeid','asc');
    	$query = $this->db->get();

    	if ($query->num_rows() > 0) 
		{
			$data=$query->result();     
			return $data;       
		}       
		return false;
    }

    public function update_issue_qty_from_trdeid($first_call,$trdeid, $itemsid, $issueqty, $requiredqty, $receiveqty){

    	if($issueqty == '0' && $issueqty < $requiredqty){
    		if($requiredqty <= $receiveqty){
	    		$total_received = $requiredqty;
	    		$new_receive_qty = $receiveqty - $requiredqty;
	    	}else{
	    		$total_received = $receiveqty;
	    		$new_receive_qty = 0;
	    	}

    	}else{
    		if($requiredqty <= $receiveqty){
	    		$total_received = $requiredqty;

	    		$new_receive_qty = $receiveqty - ($requiredqty - $issueqty);
	    	}else{
	    		$total_received = $issueqty+$receiveqty;

	    		if($total_received > $requiredqty){
	    			$total_received = $requiredqty;
	    		}else{
	    			$total_received = $total_received;
	    		}

	    		$new_receive_qty = $receiveqty - ($requiredqty - $issueqty);
	    	}	
    	}

    	$trdeArray = array(
				'trde_issueqty' => $total_received
			);

    	$this->db->where('trde_itemsid',$itemsid);
		$this->db->where('trde_trdeid',$trdeid);
		$this->db->update('trde_transactiondetail',$trdeArray);

		return $new_receive_qty;

    }

    public function get_trdeid_from_handovermasterid($haov_handovermasterid, $itemsid){
    	$this->db->select('haod_trdid, haod_qty, haod_remqty');
    	$this->db->from('haod_handoverdetail hd');
    	$this->db->where('haod_qty >=', 'haod_remqty', false);
    	$this->db->where('haod_handovermasterid', $haov_handovermasterid);
    	$this->db->where('haod_itemsid', $itemsid);
    	$this->db->order_by('haod_trdid','asc');
    	$query = $this->db->get();

    	if ($query->num_rows() > 0) 
		{
			$data=$query->result();     
			return $data;       
		}       
		return false;
    }

    public function update_hoad_remqty_from_trdeid($first_call,$trdeid, $itemsid, $remqty, $requiredqty, $receiveqty){
    
    	if($remqty > $receiveqty){
    		$total_received = $remqty - $receiveqty;
    	}else{
    		$total_received = 0;
    	}
    	$new_haod_receive_qty = $receiveqty - $remqty;

    	$haodArray = array(
				'haod_remqty' => $total_received
			);

    	$this->db->where('haod_itemsid',$itemsid);
		$this->db->where('haod_trdid',$trdeid);
		$this->db->update('haod_handoverdetail',$haodArray);

		return $new_haod_receive_qty;
    }

}