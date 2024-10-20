<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Drict_purchaase_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->recm_masterTable='recm_receivedmaster';
        $this->recd_detailTable='recd_receiveddetail';
        $this->tran_masterTable='trma_transactionmain';
        $this->tran_detailTable='trde_transactiondetail';
    }
    
    public $validate_settings_receive_order_item = array(
        array('field' => 'receipt_no', 'label' => 'Receipt No', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'suplier_bill_no', 'label' => 'Suppliers Bill No', 'rules' => 'trim|required|xss_clean'),
    );
    
    public function order_item_receive_save()
    {
        try{
            //echo "<pre>";print_r($this->input->post());die();
            $req_date=$this->input->post('order_date');
            $received_date=$this->input->post('received_date');
            $expiredate =   $this->input->post('end_date');
            $suplier_bill_date =   $this->input->post('suplier_bill_date');
                $trde_expdate= $this->input->post('trde_expdate');
            if(DEFAULT_DATEPICKER=='NP')
	        {   $suplier_bill_dateNp=$suplier_bill_date;
                $suplier_bill_dateEn=$this->general->NepToEngDateConv($suplier_bill_date);
                //$expiredateNp=$trde_expdate;
                //$expiredateEn=$this->general->NepToEngDateConv($trde_expdate);
                $orderdateNp=$req_date;
                $orderdateEn=$this->general->NepToEngDateConv($req_date);
                $receivedateNp=$received_date;
                $receivedateEn=$this->general->NepToEngDateConv($received_date);
            }
            else
            {   
                $suplier_bill_dateEn=$suplier_bill_date;
                $suplier_bill_dateNp=$this->general->EngToNepDateConv($suplier_bill_date);
                //$expiredateEn=$trde_expdate;
                //$expiredateNp=$this->general->EngToNepDateConv($trde_expdate);
                $orderdateEn=$req_date;
                $orderdateNp=$this->general->EngToNepDateConv($req_date);
                $receivedateEn=$received_date;
                $receivedateNp=$this->general->NepToEngDateConv($received_date);
            } 
        
        	$order_number=$this->input->post('order_number');
        	$fiscal_year=$this->input->post('fiscalyearid');
            $supplierid = $this->input->post('supplier');
            $rema_manualno = $this->input->post('rema_manualno');
        	$suplier_bill_no = $this->input->post('suplier_bill_no');
            $receiveno = $this->input->post('receiveno');
            $description = $this->input->post('description');
            $code =   $this->input->post('puit_barcode');
            $batch_no =   $this->input->post('unit');
            $itemsid =   $this->input->post('trde_itemsid');
            $unit =   $this->input->post('puit_unitid');
            $qty =   $this->input->post('puit_qty');
            $taxtype =   $this->input->post('puit_taxid');
            $subottaltotal =   $this->input->post('subtotalamt');
            $grandtotal = '999';//  $this->input->post('totalamount');
            $tax =   $this->input->post('tax');
            $free =   $this->input->post('free');
            $discounttype =   $this->input->post('discounttype');
            $discountper =   $this->input->post('discountper');
            $discountamt =   $this->input->post('disamt');
            $puit_unitprice =   $this->input->post('puit_unitprice');
			//masster table 
            $remarks = $this->input->post('remarks');
            $bugetid = $this->input->post('bugetid');
            //insert form direct purchase in matrans details and master
           
           
            $cc = $this->input->post('cc');
            $vat = $this->input->post('vat');
            $receipt_no = $this->input->post('receipt_no');
            $trma_transactiontype = $this->input->post('trma_transactiontype');//form direct purchasre always PURCHASE
            $trma_status = $this->input->post('trma_status'); 
            $supplierid = $this->input->post('supplier'); 
            $matdsupplierbillno = $this->input->post('trde_supplierbillno'); 
                

            $curtime=$this->general->get_currenttime();
            $userid=$this->session->userdata(USER_ID);
            $mac=$this->general->get_Mac_Address();
            $ip=$this->general->get_real_ipaddr();

            $this->db->trans_begin();
            $ReceiveMasterArray = array(
                                'recm_purchaseorderno'=>$order_number,
                                'recm_receiveddatead'=>$receivedateEn,
                                'recm_receiveddatebs'=>$receivedateNp,
                            	'recm_fyear'=>$fiscal_year,
                            	'recm_amount'=>$grandtotal,
                            	'recm_discount'=>$discounttype,
                            	'recm_taxamount'=>$tax,
                                'recm_purchaseorderdatebs'=>$orderdateNp,
                                'received_datead'=>$receivedateEn,
                                'received_datebs'=>$receivedateNp,
                                // 'recm_received_datead'=>$suplier_bill_dateEn,
                                // 'recm_received_datebs'=>$suplier_bill_dateNp,
                            	'recm_budgetid'=>$bugetid,
                            	'recm_remarks'=>$remarks, 
                            	//recm_invoiceno
                            	'recm_status'=>'O',
                            	//recm_receivedno // not found
                                'recm_supplierbillno'=>$suplier_bill_no,
                                'recm_dstat'=>'D',
                                'recm_tstat'=>'S',
                                'recm_clearanceamount'=>$grandtotal,
                                'recm_supplierid'=>$supplierid,
                                'recm_postdatead'=>CURDATE_EN,
                                'recm_postdatebs'=>CURDATE_NP,
                                'recm_posttime'=>$curtime,
                                'recm_enteredby'=>$userid,
                                'recm_postmac'=>$mac,
                                'recm_postip'=>$ip                              
                            );
           
            if(!empty($ReceiveMasterArray))
            {   //echo"<pre>"; print_r($ReceiveMasterArray);
                $this->db->insert($this->recm_masterTable,$ReceiveMasterArray);
                $insertid=$this->db->insert_id();
                if($insertid)
                {
                foreach ($itemsid  as $key => $val) {
                $ReqDetail[]=array(
	                            'recd_receivedmasterid'=>$insertid,
	                            'recd_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
	                            'recd_purchasedqty'=>!empty($qty[$key])?$qty[$key]:'',
	                            'recd_batchno'=> !empty($batch_no[$key])?$batch_no[$key]:'',
	                            'recd_salerate'=> !empty($qty[$key])?$qty[$key]:'',
	                            'recd_cccharge'=> !empty($cc[$key])?$cc[$key]:'',
	                            'recd_arate'=> !empty($qty[$key])?$qty[$key]:'',
	                            'recd_vatpc'=> !empty($vat[$key])?$vat[$key]:'',
	                                    //'recd_controlno'=>'Not Found' 
	                            'recd_st'=>'N',
	                            'recd_free'=> !empty($free[$key])?$free[$key]:'',
	                            'recd_amount'=> !empty($grandtotal[$key])?$grandtotal[$key]:'',
	                            'recd_unitprice'=> !empty($puit_unitprce[$key])?$puit_unitprce[$key]:'',
	                            'recd_discountpc'=> !empty($discountper[$key])?$discountper[$key]:'',
	                                //'puit_taxid'=> !empty($taxtype[$key])?$taxtype[$key]:'',
	                            'recd_description'=> !empty($description[$key])?$description[$key]:'',
	                            'recd_discountamt'=> !empty($discountamt[$key])?$discountamt[$key]:'',
	                            	//'recd_expdatead'=>expiredateEn,
	                            	//'recd_expdatebs'=>expiredateNp,
                                'recd_postdatead'=>CURDATE_EN,
                                'recd_postdatebs'=>CURDATE_NP,
                                'recd_enteredby'=>$userid,
                                'recd_posttime'=>$curtime,
                                'recd_postby'=>$userid,
                                'recd_postmac'=>$mac,
                                'recd_postip'=>$ip 
                            );
                    }
                    
                    if(!empty($ReqDetail))
                    {  //echo"reqdata"; echo"<pre>";print_r($ReqDetail);
                        $this->db->insert_batch($this->recd_detailTable,$ReqDetail);
                    }
                }
            }
            $transMasterArray = array(
                                    'trma_transactiondatead'=>$receivedateEn,
                                    'trma_transactiondatebs'=>$receivedateNp,
            						// 'trma_fromdepartmentid'=>,//not found
									// 'trma_todepartmentid'=>,//not found
									'trma_fromby'=>$userid,
									'trma_toby'=>$userid,
									'trma_status'=>'O',
									'trma_received'=>'1',
									//'trma_issueno'=>,not found
                                    'trma_fyear'=>$fiscal_year,
                                    'trma_transactiontype'=>$trma_transactiontype,//form direct purchasre
                                    'trma_sttransfer'=>'N',
                                    'trma_postdatead'=>CURDATE_EN,
                                    'trma_postdatebs'=>CURDATE_NP,
                                    'trma_sysdate'=>CURDATE_NP,
                                    'trma_posttime'=>$curtime,
                                    'trma_postby'=>$userid,
                                    'trma_postmac'=>$mac,
                                    'trma_postip'=>$ip                              
                                );
            if(!empty($transMasterArray))
            {   //echo"<pre>"; print_r($transMasterArray);
                $this->db->insert($this->tran_masterTable,$transMasterArray);
                $insertidtr=$this->db->insert_id();
                if($insertidtr)
                {
                foreach ($batch_no as $key => $val) {
                $tranDetail[]=array(
	                                'trde_mattransmasterid'=>$insertidtr,
	                                'trde_itemsid'=> !empty($puit_productid[$key])?$puit_productid[$key]:'',
	                                //'trde_controlno'=> !empty($trde_unitpercase[$key])?$trde_unitpercase[$key]:'',notfound
                                	'trde_unitprice'=> !empty($puit_unitprice[$key])?$puit_unitprice[$key]:'',
                                	'trde_description'=> !empty($description[$key])?$description[$key]:'',
                                    'trde_postdatead'=>CURDATE_EN,
                                    'trde_transactiondatead'=>CURDATE_EN,
                                    'trde_transactiondatebs'=>CURDATE_NP,
                                    'trde_sysdate'=>CURDATE_EN,
                                    'trde_transactiontype'=>$trma_transactiontype,
                                    'trde_supplierbillno'=>$matdsupplierbillno,
                                    'trde_supplierid'=>$supplierid,
                                	//'trde_mtdid'=>, not found entered while direct purchase
                                	//'trde_issueno'=>not found entered while direct purchase
                                    'trde_remarks'=>!empty($description[$key])?$description[$key]:'',
                                    'trde_status'=>'O',
                                    'trde_newissueqty'=>!empty($qty[$key])?$qty[$key]:'',
                                    'trde_stripqty'=>!empty($qty[$key])?$qty[$key]:'',
                                    'trde_issueqty'=>!empty($qty[$key])?$qty[$key]:'',
                                    'trde_requiredqty'=>!empty($qty[$key])?$qty[$key]:'',
                                	'trde_postdatebs'=>CURDATE_NP,
                                    'trde_expdatebs'=>!empty($trde_expdate[$key])?$trde_expdate[$key]:'',
                                    //'trde_expdatead'=>!empty($expiredateEn[$key])?$expiredateEn[$key]:'',
                                	'trde_posttime'=>$curtime,
                                    'trde_selprice'=>!empty($puit_unitprice[$key])?$puit_unitprice[$key]:'',
                                    'trde_postby'=>$userid,
                                    'trde_postmac'=>$mac,
                                    'trde_postip'=>$ip,
                                );
                    }
                    //echo"<pre>";print_r($tranDetail);die;
                    if(!empty($tranDetail))
                    {  
                        $this->db->insert_batch($this->tran_detailTable,$tranDetail);
                    }
                }
            }

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return false;
            }
            else{
                $this->db->trans_commit();
                return true;
            }
        }catch(Exception $e){
            throw $e;
        }
    }
}