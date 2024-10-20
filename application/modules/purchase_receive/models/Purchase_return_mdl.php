<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_return_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->purr_mastertable = 'purr_purchasereturn';
        $this->prde_detailtable = 'prde_purchasereturndetail';

        $this->trma_masterTable='trma_transactionmain';
        $this->trde_detailTable='trde_transactiondetail';

        $this->recm_masterTable = 'recm_receivedmaster';
        $this->recd_detailTable = 'recd_receiveddetail';

        $this->curtime = $this->general->get_currenttime();
        $this->userid = $this->session->userdata(USER_ID);
        $this->username = $this->session->userdata(USER_NAME);
        $this->depid = $this->session->userdata(USER_DEPT);
        $this->storeid = $this->session->userdata(STORE_ID);
        $this->locationid = $this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
        
    }

    public $validate_purchase_return = array(
        array('field' => 'supplierid', 'label' => 'Supplier Name', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'fyear', 'label' => 'Fiscal Year', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'returnno', 'label' => 'Return No', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'clearanceamt', 'label' => 'Clearance Amount', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'return_qty[]', 'label' => 'Return Quantity', 'rules' => 'trim|required|numeric|is_natural_no_zero|xss_clean'),
    );

    public function save_direct_purchase_return(){
    	// $id = $this->input->post('id');

        $id = $this->input->post('receivedmasterid');

    	//master data
    	$receiptno = $this->input->post('receiptno');
    	$fyear = $this->input->post('fyear');
    	$storeid = $this->input->post('storeid');
    	$receivedinvoice = $this->input->post('receivedinvoice');
    	$supplierid = $this->input->post('supplierid');
    	$remarks = $this->input->post('remarks');
    	$return_date = $this->input->post('return_date');
    	$receivedby = $this->input->post('receivedby');
    	$issueno = $this->input->post('returnno'); //issueno
    	$returnby = $this->input->post('returnby');
        // $returnno = $this->getLastReturnNo($fyear);
        $returnno = $this->general->getLastNo('purr_returnno',$this->purr_mastertable,array('purr_fyear'=>$fyear, 'purr_locationid'=>$this->locationid,'purr_departmentid'=>$this->depid,'purr_storeid'=>$this->storeid));

        $discountamt = $this->input->post('discountamt');
        $taxamt = $this->input->post('taxamt');
        $returnamount = $this->input->post('clearanceamt');

        $invoiceno = $this->input->post('invoiceno');
        $orderno = $this->input->post('orderno');

        $ret_amount = $this->input->post('amount');
        $cc = $this->input->post('cc');

        $purchase_orderno = !empty($orderno)?$orderno:$invoiceno;

    	if(DEFAULT_DATEPICKER == 'NP'){
    		$return_date_np = $return_date;
    		$return_date_en = $this->general->NepToEngDateConv($return_date_np);
    	}else{
    		$return_date_en = $return_date;
    		$return_date_np = $this->general->EngToNepDateConv($return_date_np);
    	}

    	//detail data
    	$itemsid = $this->input->post('itemsid');
    	$recid = $this->input->post('recid');
    	$received_qty = $this->input->post('received_qty');
    	$return_qty = $this->input->post('return_qty');

        $purchaserate = $this->input->post('purchase_rate');
        $salerate = $this->input->post('sales_rate');
        $receive_detailid = $this->input->post('receiveddetailid');
        $description = $this->input->post('description');
       

    	$this->db->trans_begin();

    	if($id){
    		$purReturnMasterArray = array(
    			'purr_returnno' => $returnno+1,
    			'purr_returnby'=> $returnby,
    			'purr_receivedby'=> $receivedby,
    			'purr_supplierid' =>$supplierid,
    			'purr_fyear' => $fyear,
    			'purr_returnamount' => $returnamount,
    			'purr_discount' => $discountamt,
    			'purr_vatamount' => $taxamt,
    			'purr_remarks' => $remarks,
    			'purr_receiptno' => $purchase_orderno,
    			'purr_invoiceno' => $issueno,
    			'purr_departmentid' => $this->depid,
    			'purr_locationid' => $this->locationid,
    			'purr_storeid' => $this->storeid,
    			'purr_returndatead' => $return_date_en,
    			'purr_returndatebs' => $return_date_np,
    			'purr_returntime' => $this->curtime,
    			'purr_st' => 'N',
    			'purr_postby' => $this->userid,
    			'purr_postusername' => $this->username,
    			'purr_postdatead' => CURDATE_EN,
    			'purr_postdatebs' => CURDATE_NP,
    			'purr_posttime' => $this->curtime,
    			'purr_postmac' => $this->mac,
    			'purr_postip' => $this->ip
    		);

            // echo "<pre>";
            // print_r($purReturnMasterArray);
            // $insert_id = 1;

    		if($purReturnMasterArray){
    			$this->db->insert($this->purr_mastertable, $purReturnMasterArray);

    			$insert_id = $this->db->insert_id();
    		}

    		if($insert_id){
                if(!empty($itemsid)):
                    foreach($itemsid as $key=>$value):
                        $purReturnDetailArray = array(
                            'prde_purchasereturnid' => $insert_id,
                            'prde_itemsid' => !empty($itemsid[$key])?$itemsid[$key]:'',
                            'prde_receivedqty' => !empty($received_qty[$key])?$received_qty[$key]:'',
                            'prde_returnqty' => !empty($return_qty[$key])?$return_qty[$key]:'',
                            'prde_controlno' => '',
                            'prde_purchaserate' => !empty($purchaserate[$key])?$purchaserate[$key]:'',
                            'prde_invoiceno' => '',
                            'prde_receiveddetailid' => !empty($receive_detailid[$key])?$receive_detailid[$key]:'',
                            'prde_noteqty' => '',
                            'prde_salerate' => !empty($salerate[$key])?$salerate[$key]:'',
                            'prde_free' => '',
                            'prde_supplierid' => $supplierid,
                            'prde_supplierbillno' => '',
                            'prde_remarks' => !empty($description[$key])?$description[$key]:'',
                            'prde_cc' => !empty($cc[$key])?$cc[$key]:'',
                            'prde_amount' => !empty($ret_amount[$key])?$ret_amount[$key]:'',
                            'prde_locationid' => $this->locationid,
                            'prde_postdatead'=>CURDATE_EN,
                            'prde_postdatebs'=>CURDATE_NP,
                            'prde_posttime'=>$this->curtime,
                            'prde_postby'=>$this->userid,
                            'prde_postusername'=>$this->username,
                            'prde_postmac'=>$this->mac,
                            'prde_postip'=>$this->ip 
                        );
                    
                        if($purReturnDetailArray){
                            $this->db->insert($this->prde_detailtable, $purReturnDetailArray);
                            $detail_insertArray[] =$this->db->insert_id();
                        }

                        // print_r($purReturnDetailArray);
                        // die();
                    endforeach;
                endif;
    		} //if insert_id end

            //update transaction and received detail table
            if(!empty($itemsid)){
                foreach($itemsid as $key=>$value):
                    $receiveddetailid = !empty($receive_detailid[$key])?$receive_detailid[$key]:'';
                    $recd_receivedqty = !empty($received_qty[$key])?$received_qty[$key]:0;
                    $recd_return_qty = !empty($return_qty[$key])?$return_qty[$key]:0;

                    //get transaction data
                    $mattransdetail = $this->get_transaction_detail_data($receiveddetailid, $recd_return_qty);

                    $trdeid = !empty($mattransdetail->trde_trdeid)?$mattransdetail->trde_trdeid:0;

                    $issue_qty = !empty($mattransdetail->trde_issueqty)?$mattransdetail->trde_issueqty:0;

                    //update transaction detail table
                    $new_qty = $issue_qty - $recd_return_qty;

                    $transDetailArray = array(
                        'trde_issueqty' => $new_qty
                    );

                    if($transDetailArray){
                        $this->db->where('trde_trdeid',$trdeid);
                        $this->db->update($this->trde_detailTable, $transDetailArray);
                    }

                    // update received detail table
                    $new_recd_qty = $recd_receivedqty - $recd_return_qty;

                    $recdDetailArray = array(
                        'recd_purchasedqty' => $new_recd_qty
                    );

                    if($recdDetailArray){
                        $this->db->where('recd_receiveddetailid',$receiveddetailid);
                        $this->db->update($this->recd_detailTable, $recdDetailArray);
                    }

                endforeach;
            }
             // die();
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
    }

    public function get_transaction_detail_data($receiveddetailid = false, $returnqty = false){
        $this->db->select('mtd.trde_trdeid, mtd.trde_unitprice, mtd.trde_selprice, mtd.trde_controlno, mtd.trde_expdatebs, mtd.trde_requiredqty, mtd.trde_issueqty');
        $this->db->from('trde_transactiondetail mtd');
        $this->db->join('trma_transactionmain mtm','mtm.trma_trmaid = mtd.trde_trmaid','LEFT');
        $this->db->where(array('trde_mtdid'=>$receiveddetailid));
        $this->db->order_by('trde_trdeid','ASC');
        $this->db->limit(1);

        $query = $this->db->get();



        if($query->num_rows()>0){
            $result = $query->row();
            return $result;
        }
        return false;
    }

    public function getLastReturnNo($fyear = false){
        try{
            $this->db->select('purr_returnno');
            $this->db->from($this->purr_mastertable);
            $this->db->where('purr_fyear',$fyear);
            $this->db->where('purr_locationid',$this->locationid);
            $this->db->where('purr_departmentid',$this->depid);
            $this->db->where('purr_storeid',$this->storeid);

            $query = $this->db->get();
            if($query->num_rows() > 0){
                $result = $query->row();
                return $result->purr_returnno;
            }
            return false;
        }catch(Exception $e){
            throw $e;
        }
    }

    public function save_purchase_return(){
        // $id = $this->input->post('id');

        $id = $this->input->post('receivedmasterid');

        //master data
        $receiptno = $this->input->post('receiptno');
        $fyear = $this->input->post('fyear');
        $storeid = $this->input->post('storeid');
        $receivedinvoice = $this->input->post('receivedinvoice');
        $supplierid = $this->input->post('supplierid');
        $remarks = $this->input->post('remarks');
        $return_date = $this->input->post('return_date');
        $receivedby = $this->input->post('receivedby');
        $issueno = $this->input->post('returnno'); //issueno
        $returnby = $this->input->post('returnby');
        // $returnno = $this->getLastReturnNo($fyear);
        $returnno = $this->general->getLastNo('purr_returnno',$this->purr_mastertable,array('purr_fyear'=>$fyear, 'purr_locationid'=>$this->locationid,'purr_departmentid'=>$this->depid,'purr_storeid'=>$this->storeid));

        $discountamt = $this->input->post('discountamt');
        $taxamt = $this->input->post('taxamt');
        $returnamount = $this->input->post('clearanceamt');

        if(DEFAULT_DATEPICKER == 'NP'){
            $return_date_np = $return_date;
            $return_date_en = $this->general->NepToEngDateConv($return_date_np);
        }else{
            $return_date_en = $return_date;
            $return_date_np = $this->general->EngToNepDateConv($return_date_np);
        }

        //detail data
        $itemsid = $this->input->post('itemsid');
        $recid = $this->input->post('recid');
        $received_qty = $this->input->post('received_qty');
        $return_qty = $this->input->post('return_qty');

        $purchaserate = $this->input->post('purchase_rate');
        $salerate = $this->input->post('sales_rate');
        $receive_detailid = $this->input->post('receiveddetailid');
        $description = $this->input->post('description');
       

        $this->db->trans_begin();

        if($id){
            $purReturnMasterArray = array(
                'purr_returnno' => $returnno+1,
                'purr_returnby'=> $returnby,
                'purr_receivedby'=> $receivedby,
                'purr_supplierid' =>$supplierid,
                'purr_fyear' => $fyear,
                'purr_returnamount' => $returnamount,
                'purr_discount' => $discountamt,
                'purr_vatamount' => $taxamt,
                'purr_remarks' => $remarks,
                'purr_receiptno' => $receiptno,
                'purr_invoiceno' => $issueno,
                'purr_departmentid' => $this->depid,
                'purr_locationid' => $this->locationid,
                'purr_storeid' => $this->storeid,
                'purr_returndatead' => $return_date_en,
                'purr_returndatebs' => $return_date_np,
                'purr_returntime' => $this->curtime,
                'purr_st' => 'N',
                'purr_postby' => $this->userid,
                'purr_postusername' => $this->username,
                'purr_postdatead' => CURDATE_EN,
                'purr_postdatebs' => CURDATE_NP,
                'purr_posttime' => $this->curtime,
                'purr_postmac' => $this->mac,
                'purr_postip' => $this->ip
            );

            // echo "<pre>";
            // print_r($purReturnMasterArray);
            // $insert_id = 1;

            if($purReturnMasterArray){
                $this->db->insert($this->purr_mastertable, $purReturnMasterArray);

                $insert_id = $this->db->insert_id();
            }

            if($insert_id){
                if(!empty($itemsid)):
                    foreach($itemsid as $key=>$value):
                        $purReturnDetailArray = array(
                            'prde_purchasereturnid' => $insert_id,
                            'prde_itemsid' => !empty($itemsid[$key])?$itemsid[$key]:'',
                            'prde_receivedqty' => !empty($received_qty[$key])?$received_qty[$key]:'',
                            'prde_returnqty' => !empty($return_qty[$key])?$return_qty[$key]:'',
                            'prde_controlno' => '',
                            'prde_purchaserate' => !empty($purchaserate[$key])?$purchaserate[$key]:'',
                            'prde_invoiceno' => '',
                            'prde_receiveddetailid' => !empty($receive_detailid[$key])?$receive_detailid[$key]:'',
                            'prde_noteqty' => '',
                            'prde_salerate' => !empty($salerate[$key])?$salerate[$key]:'',
                            'prde_free' => '',
                            'prde_supplierid' => $supplierid,
                            'prde_supplierbillno' => '',
                            'prde_remarks' => !empty($description[$key])?$description[$key]:'',
                            'prde_locationid' => $this->locationid,
                            'prde_postdatead'=>CURDATE_EN,
                            'prde_postdatebs'=>CURDATE_NP,
                            'prde_posttime'=>$this->curtime,
                            'prde_postby'=>$this->userid,
                            'prde_postusername'=>$this->username,
                            'prde_postmac'=>$this->mac,
                            'prde_postip'=>$this->ip 
                        );
                    
                        if($purReturnDetailArray){
                            $this->db->insert($this->prde_detailtable, $purReturnDetailArray);
                            $detail_insertArray[] =$this->db->insert_id();
                        }

                        // print_r($purReturnDetailArray);
                        // die();
                    endforeach;
                endif;
            } //if insert_id end

            //update transaction and received detail table
            if(!empty($itemsid)){
                foreach($itemsid as $key=>$value):
                    $receiveddetailid = !empty($receive_detailid[$key])?$receive_detailid[$key]:'';
                    $recd_receivedqty = !empty($received_qty[$key])?$received_qty[$key]:0;
                    $recd_return_qty = !empty($return_qty[$key])?$return_qty[$key]:0;

                    //get transaction data
                    $mattransdetail = $this->get_transaction_detail_data($receiveddetailid, $recd_return_qty);

                    $trdeid = !empty($mattransdetail->trde_trdeid)?$mattransdetail->trde_trdeid:0;

                    $issue_qty = !empty($mattransdetail->trde_issueqty)?$mattransdetail->trde_issueqty:0;

                    //update transaction detail table
                    $new_qty = $issue_qty - $recd_return_qty;

                    $transDetailArray = array(
                        'trde_issueqty' => $new_qty
                    );

                    if($transDetailArray){
                        $this->db->where('trde_trdeid',$trdeid);
                        $this->db->update($this->trde_detailTable, $transDetailArray);
                    }

                    // update received detail table
                    $new_recd_qty = $recd_receivedqty - $recd_return_qty;

                    $recdDetailArray = array(
                        'recd_purchasedqty' => $new_recd_qty
                    );

                    if($recdDetailArray){
                        $this->db->where('recd_receiveddetailid',$receiveddetailid);
                        $this->db->update($this->recd_detailTable, $recdDetailArray);
                    }

                endforeach;
            }
             // die();
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
    }

    public function get_received_master_by_order_no($srchcol=false)
    {
        $this->db->select('rm.*');
        $this->db->from('recm_receivedmaster rm');
        if($srchcol)
        {
          $this->db->where($srchcol);
        }
        $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
      if($this->location_ismain=='Y'){
            if(!empty($locationid))
            {
                  $this->db->where('rm.recm_locationid',$locationid);
            }
         }else{
            $this->db->where('rm.recm_locationid',$this->locationid);

        }
        
        $this->db->where('(rm.recm_purchasestatus != "C" OR rm.recm_purchasestatus IS NULL)');

        $query = $this->db->get();

        // echo $this->db->last_query(); die();
        if($query->num_rows()>0){
            return $query->result();
        }
        return false;
    }

    public function get_purchase_return_item_list(){
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');

        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("purr_receiptno like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("purr_fyear like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("purr_returndatebs like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("purr_returndatead like  '%".$get['sSearch_5']."%'  ");
        } 
        if(!empty($get['sSearch_6'])){
            $this->db->where("purr_invoiceno like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("purr_returnno like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("purr_discount like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("purr_vatamount like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("purr_returnamount like  '%".$get['sSearch_10']."%'  ");
        }
        if(!empty($get['sSearch_11'])){
            $this->db->where("purr_returnby like  '%".$get['sSearch_11']."%'  ");
        }
      
        if(!empty($frmDate) && !empty($toDate))
        {
            $this->db->where(array('purr_returndatebs >='=>$frmDate,'purr_returndatebs <='=>$toDate));
        }
        
        $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

       
        if($this->location_ismain=='Y'){
        if(!empty($locationid)){
            $this->db->where('purr_locationid',$locationid);
        }else{
             $this->db->where('purr_locationid',$this->locationid);

        }
        }else{
            $this->db->where('purr_locationid',$this->locationid);

        }


        $resltrpt=$this->db->select("COUNT(*) as cnt")
                            ->from('purr_purchasereturn pm')
                            ->join('dist_distributors d','d.dist_distributorid=pm.purr_supplierid','LEFT')
                            ->join('usma_usermain u','u.usma_userid=pm.purr_postby','LEFT')
                            ->get()
                            ->row(); 
        
        $totalfilteredrecs=$resltrpt->cnt; 

        $order_by = 'purr_invoiceno';
        $order = 'desc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }

        $where='';
        
        if($this->input->get('iSortCol_0')==0)
            $order_by = 'purr_invoiceno';
        else if($this->input->get('iSortCol_0')==1)
            $order_by = 'purr_receiptno';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'purr_fyear';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'dist_distributor';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'purr_returndatebs';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'purr_returndatead';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'purr_invoiceno';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'purr_returnno';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'purr_discount';
        else if($this->input->get('iSortCol_0')==9)
            $order_by = 'purr_vatamount';
        else if($this->input->get('iSortCol_0')==10)
            $order_by = 'purr_returnamount';
        else if($this->input->get('iSortCol_0')==11)
            $order_by = 'purr_returnby';
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
            $this->db->where("purr_receiptno like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("purr_fyear like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("purr_returndatebs like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("purr_returndatead like  '%".$get['sSearch_5']."%'  ");
        } 
        if(!empty($get['sSearch_6'])){
            $this->db->where("purr_invoiceno like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("purr_returnno like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("purr_discount like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("purr_vatamount like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("purr_returnamount like  '%".$get['sSearch_10']."%'  ");
        }
        if(!empty($get['sSearch_11'])){
            $this->db->where("purr_returnby like  '%".$get['sSearch_11']."%'  ");
        }

        if($frmDate &&  $toDate)
        {
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('purr_returndatebs >=', $frmDate);
              $this->db->where('purr_returndatebs <=', $toDate);
            }
            else
            {
              $this->db->where('purr_returndatead >=', $frmDate);
              $this->db->where('purr_returndatead <=', $toDate);
            }
        }
        $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

         if($this->location_ismain=='Y'){
        if(!empty($locationid)){
            $this->db->where('purr_locationid',$locationid);
        }else{
             $this->db->where('purr_locationid',$this->locationid);

        }
        }else{
            $this->db->where('purr_locationid',$this->locationid);

        }


        $this->db->select('pm.purr_purchasereturnid, pm.purr_returndatebs,  pm.purr_returndatead, pm.purr_returnno, pm.purr_returnby, pm.purr_receivedby, pm.purr_remarks, pm.purr_fyear, pm.purr_returnamount, pm.purr_discount, pm.purr_receiptno, pm.purr_invoiceno, pm.purr_vatamount, pm.purr_st, d.dist_distributor');
        $this->db->from('purr_purchasereturn pm');
        $this->db->join('dist_distributors d','d.dist_distributorid = pm.purr_supplierid','LEFT');
        $this->db->join('usma_usermain u','u.usma_userid=pm.purr_postby','LEFT');

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
       //echo $this->db->last_query();die(); 
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

    public function get_purchase_return_item_detail_list(){
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');

        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("purr_receiptno like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("purr_fyear like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("purr_returndatebs like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("purr_returndatead like  '%".$get['sSearch_5']."%'  ");
        } 
        if(!empty($get['sSearch_6'])){
            $this->db->where("purr_invoiceno like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("purr_returnno like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("purr_discount like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("purr_vatamount like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("purr_returnamount like  '%".$get['sSearch_10']."%'  ");
        }
        if(!empty($get['sSearch_11'])){
            $this->db->where("purr_returnby like  '%".$get['sSearch_11']."%'  ");
        }
      
        if(!empty($frmDate) && !empty($toDate))
        {
            $this->db->where(array('purr_returndatebs >='=>$frmDate,'purr_returndatebs <='=>$toDate));
        }
        
        $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

        // if(!empty($locationid)){
        //     $this->db->where('purr_locationid',$locationid);
        // }

         if($this->location_ismain=='Y'){
        if(!empty($locationid)){
            $this->db->where('purr_locationid',$locationid);
        }
        else{
            $this->db->where('purr_locationid',$this->locationid);

        }
        }else{
            $this->db->where('purr_locationid',$this->locationid);

        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
                            ->from('prde_purchasereturndetail pd')
                            ->join('purr_purchasereturn pr','pr.purr_purchasereturnid = pd.prde_purchasereturnid','LEFT')
                            ->join('dist_distributors d','d.dist_distributorid = pr.purr_supplierid','LEFT')
                            ->join('itli_itemslist il','il.itli_itemlistid = pd.prde_itemsid','LEFT')
                            ->get()
                            ->row(); 
        
        $totalfilteredrecs=$resltrpt->cnt; 

        $order_by = 'purr_invoiceno';
        $order = 'desc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }

        $where='';
        
        if($this->input->get('iSortCol_0')==0)
            $order_by = 'purr_invoiceno';
        else if($this->input->get('iSortCol_0')==1)
            $order_by = 'purr_receiptno';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'purr_fyear';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'dist_distributor';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'purr_returndatebs';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'purr_returndatead';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'purr_invoiceno';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'purr_returnno';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'purr_discount';
        else if($this->input->get('iSortCol_0')==9)
            $order_by = 'purr_vatamount';
        else if($this->input->get('iSortCol_0')==10)
            $order_by = 'purr_returnamount';
        else if($this->input->get('iSortCol_0')==11)
            $order_by = 'purr_returnby';
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
            $this->db->where("purr_receiptno like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("purr_fyear like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("purr_returndatebs like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("purr_returndatead like  '%".$get['sSearch_5']."%'  ");
        } 
        if(!empty($get['sSearch_6'])){
            $this->db->where("purr_invoiceno like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("purr_returnno like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("purr_discount like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("purr_vatamount like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("purr_returnamount like  '%".$get['sSearch_10']."%'  ");
        }
        if(!empty($get['sSearch_11'])){
            $this->db->where("purr_returnby like  '%".$get['sSearch_11']."%'  ");
        }

        if($frmDate &&  $toDate)
        {
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('purr_returndatebs >=', $frmDate);
              $this->db->where('purr_returndatebs <=', $toDate);
            }
            else
            {
              $this->db->where('purr_returndatead >=', $frmDate);
              $this->db->where('purr_returndatead <=', $toDate);
            }
        }
        $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

    if($this->location_ismain=='Y'){
        if(!empty($locationid)){
            $this->db->where('purr_locationid',$locationid);
        }else{
            $this->db->where('purr_locationid',$this->locationid);

        }
        }else{
            $this->db->where('purr_locationid',$this->locationid);

        }
        $this->db->select('purr_purchasereturnid,purr_locationid, purr_returndatebs,  purr_returndatead, purr_returnno, purr_returnby, purr_receivedby, purr_remarks, purr_fyear, purr_returnamount, purr_discount, purr_receiptno, purr_invoiceno, purr_vatamount, purr_st, d.dist_distributor, prde_itemsid, prde_cc, prde_amount, prde_receivedqty, prde_returnqty, prde_purchaserate, prde_salerate, prde_supplierid, prde_remarks, dist_distributor, purr_receiptno, purr_invoiceno, purr_returnno, purr_fyear, recd_vatpc, recd_discountpc, itli_itemname');
        $this->db->from('prde_purchasereturndetail pd');
        $this->db->join('purr_purchasereturn pr','pr.purr_purchasereturnid = pd.prde_purchasereturnid','LEFT');
        $this->db->join('dist_distributors d','d.dist_distributorid = pr.purr_supplierid','LEFT');
        $this->db->join('recd_receiveddetail rd','rd.recd_receiveddetailid = pd.prde_receiveddetailid','LEFT');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = pd.prde_itemsid','LEFT');

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
        //echo $this->db->last_query();die(); 
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

}