<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Quotation_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->quma_mastertable='quma_quotationmaster';
        $this->qude_detailtable='qude_quotationdetail';
        $this->curtime = $this->general->get_currenttime();
        $this->userid = $this->session->userdata(USER_ID);
        $this->username=$this->session->userdata(USER_NAME);
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
        $this->locationid=$this->session->userdata(LOCATION_ID);
          $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
        $this->orgid=$this->session->userdata(ORG_ID);
        // echo $this->orgid;
        // die();
    }
    public $validate_settings_quotation = array(
        array('field' => 'quma_supplierid', 'label' => 'Supplier', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'quma_quotationdate', 'label' => 'Quotation Date ', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'quma_quotationnumber', 'label' => 'Quotation Number ', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'qude_itemsid[]', 'label' => 'Items ', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'qude_qty[]', 'label' => 'Qty ', 'rules' => 'trim|required|xss_clean|is_natural_no_zero'),
    );
    public function quotation_save()
    {
        // echo "<pre>";
        // print_r($this->input->post());
        // die();
        try{
            $req_no = $this->input->post('req_no');
            $fiscalyear = $this->input->post('fiscalyear');
            $quotation_date = $this->input->post('quma_quotationdate');
            $id = $this->input->post('id');
            $quo_supplier_date = $this->input->post('quma_supplierquotationdate');
            $expdate = $this->input->post('quma_expdate');
            $type=$this->input->post('type');
            if(DEFAULT_DATEPICKER=='NP')
            {
                $quotation_date_bs = $quotation_date;
                $quotation_date_ad = $this->general->NepToEngDateConv($quotation_date);
                $quo_supplier_date_bs = $quo_supplier_date;
                $quo_supplier_date_ad = $this->general->NepToEngDateConv($quo_supplier_date);
                $expdate_bs = $expdate;
                $expdate_ad = $this->general->NepToEngDateConv($expdate);
            }
            else
            {
                $quotation_date_ad = $quotation_date;
                $quotation_date_bs = $this->general->EngToNepDateConv($quotation_date);
                $quo_supplier_date_bs = $quo_supplier_date;
                $quo_supplier_date_ad = $this->general->EngToNepDateConv($quo_supplier_date);
                $expdate_ad = $expdate;
                $expdate_bs = $this->general->EngToNepDateConv($expdate);
            }
            //master data
            $supplier_id = $this->input->post('quma_supplierid');
            $quotation_number = $this->input->post('quma_quotationnumber');
            $supplier_quotation_number = $this->input->post('quma_supplierquotationnumber');
            $valid_till = $this->input->post('quma_expdate');
            $total_amount = $this->input->post('quma_totalamount');
            $quma_amount=$this->input->post('quma_amount');
            $quma_totaldiscount=$this->input->post('quma_totaldiscount');
            $quma_totaltax=$this->input->post('quma_totaltax');
            $quma_remarks=$this->input->post('quma_remarks');
            //items detail data
            $itemscode = $this->input->post('qude_itemscode');
            $itemsid = $this->input->post('qude_itemsid');
            $rate = $this->input->post('qude_rate');
            $discountpc = $this->input->post('qude_discountpc');
            $vatpc = $this->input->post('qude_vatpc');
            $netrate = $this->input->post('qude_netrate');
            //update details id
            $quotationdetailid = $this->input->post('qude_quotationdetailid');
            $this->db->trans_begin();
            if($id)
            { 
                $pre_order=$this->get_all_quotation_items(array('qude_quotationmasterid'=>$id,'qude_status'=>'Y'));
                $prev_orderlist=array();
                foreach ($pre_order as $pok => $ordr) {
                    $prev_orderlist[]=$ordr->qude_quotationdetailid;
                }     
                $quoMasterArrayUP = array(
                            'quma_supplierid'=>$supplier_id,
                            'quma_quotationnumber'=>$quotation_number,
                            'quma_supplierquotationnumber'=>$supplier_quotation_number,
                            'quma_quotationdatead'=>$quotation_date_ad,
                            'quma_quotationdatebs'=>$quotation_date_bs,
                            'quma_supplierquotationdatead'=>$quo_supplier_date_ad,
                            'quma_supplierquotationdatebs'=>$quo_supplier_date_bs,
                            'quma_expdatead'=>$expdate_ad,
                            'quma_expdatebs'=>$expdate_bs,
                            'quma_modefieddatead'=>CURDATE_EN,
                            'quma_modefieddatebs'=>CURDATE_NP,
                            'quma_amount'=>$quma_amount,
                            'quma_vat'=>$quma_totaltax,
                            'quma_remarks'=>$quma_remarks,
                            'quma_discount'=>$quma_totaldiscount,
                            'quma_totalamount'=>$total_amount,
                            'quma_username'=> $this->username,
                            'quma_modefiedtime'=>$this->curtime,
                            'quma_modefiedby'=>$this->userid,
                            'quma_modefiedmac'=>$this->mac,
                            'quma_modefiedip'=>$this->ip , 
                            'quma_reqno' => $req_no,
                            'quma_fyear' => $fiscalyear,
                            'quma_type'=>$type
                        );
                if(!empty($quoMasterArrayUP)){
                    $this->db->where(array('quma_quotationmasterid'=>$id));
                    $this->db->update('quma_quotationmaster',$quoMasterArrayUP);
                    // $insertid=$this->db->insert_id();
                    $rwaff=$this->db->affected_rows();
                    if($rwaff){
                        $or_detTable=array();
                        foreach ($itemsid as $key => $val) {
                            $orgmasterid=$id;
                            $ordetailid=!empty($quotationdetailid[$key])?$quotationdetailid[$key]:'';
                            if($ordetailid){
                                $quoDetailUp=array(
                                            'qude_quotationmasterid'=>$id,
                                            'qude_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
                                            'qude_qty'=> 1,
                                            'qude_rate'=>!empty($rate[$key])?$rate[$key]:'',
                                            'qude_discountpc'=> !empty($discountpc[$key])?$discountpc[$key]:'',
                                            'qude_vatpc'=> !empty($vatpc[$key])?$vatpc[$key]:'',
                                            'qude_netrate'=> !empty($netrate[$key])?$netrate[$key]:'',
                                            'qude_remarks'=>'',
                                            'qude_modifydatead'=>CURDATE_EN,
                                            'qude_modifydatebs'=>CURDATE_NP,
                                            'qude_modifytime'=>$this->curtime,
                                            'qude_modifyby'=>$this->userid,
                                            'qude_modifymac'=>$this->mac,
                                            'qude_modifyip'=>$this->ip 
                                        );
                                if(!empty($quoDetailUp)){
                                    $this->db->where(array('qude_quotationdetailid'=>$ordetailid));
                                    $this->db->update('qude_quotationdetail',$quoDetailUp);
                                }
                                if($ordetailid)
                                {   
                                    if((in_array($ordetailid, $prev_orderlist)))
                                    {
                                        $or_detTable[]=$ordetailid;
                                    }
                                }
                            } //endif orderdetailid
                            else{
                                $quoOrderDetail=array(
                                        'qude_quotationmasterid'=>$id,
                                        'qude_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
                                        'qude_qty'=> 1,
                                        'qude_rate'=>!empty($rate[$key])?$rate[$key]:'',
                                        'qude_discountpc'=> !empty($discountpc[$key])?$discountpc[$key]:'',
                                        'qude_vatpc'=> !empty($vatpc[$key])?$vatpc[$key]:'',
                                        'qude_netrate'=> !empty($netrate[$key])?$netrate[$key]:'',
                                        'qude_remarks'=>'',
                                        'qude_posteddatead'=>CURDATE_EN,
                                        'qude_posteddatebs'=>CURDATE_NP,
                                        'qude_postedtime'=>$this->curtime,
                                        'qude_postedby'=>$this->userid,
                                        'qude_postedmac'=>$this->mac,
                                        'qude_postedip'=>$this->ip,
                                        'qude_locationid'=>$this->locationid,
                                        'qude_orgid'=>$this->orgid
                                    );
                                if(!empty($quoOrderDetail)){
                                    $this->db->insert('qude_quotationdetail',$quoOrderDetail);
                                    $insert_dtlid[]=$this->db->insert_id();
                                }
                            }// else orderdetailid
                        } //endforeach itemid
                        if(!empty($or_detTable))
                        { 
                            if(!empty($insert_dtlid))
                            {
                                $this->db->where_not_in('qude_quotationdetailid',$insert_dtlid);
                            }
                            $this->db->where(array('qude_quotationmasterid'=>$id));
                            $this->db->where_not_in('qude_quotationdetailid',$or_detTable);
                            $this->db->update('qude_quotationdetail',array('qude_status'=>'N'));
                        }
                    }       //if rwaff
                }           //if ordermaster array
            }else{
                $quoMasterArray = array(
                                    'quma_supplierid'=>$supplier_id,
                                    'quma_quotationnumber'=>$quotation_number,
                                    'quma_supplierquotationnumber'=>$supplier_quotation_number,
                                    'quma_quotationdatead'=>$quotation_date_ad,
                                    'quma_quotationdatebs'=>$quotation_date_bs,
                                    'quma_supplierquotationdatead'=>$quo_supplier_date_ad,
                                    'quma_supplierquotationdatebs'=>$quo_supplier_date_bs,
                                    'quma_expdatead'=>$expdate_ad,
                                    'quma_expdatebs'=>$expdate_bs,
                                    'quma_posteddatead'=>CURDATE_EN,
                                    'quma_posteddatebs'=>CURDATE_NP,
                                    'quma_postedtime'=>$this->curtime,
                                    'quma_amount'=>$quma_amount,
                                    'quma_vat'=>$quma_totaltax,
                                    'quma_discount'=>$quma_totaldiscount,
                                    'quma_totalamount'=>$total_amount,
                                    'quma_remarks'=>$quma_remarks,
                                    'quma_username'=> $this->username,
                                    'quma_postedby'=>$this->userid,
                                    'quma_postedmac'=>$this->mac,
                                    'quma_postedip'=>$this->ip,
                                    'quma_locationid'=>$this->locationid,   
                                    'quma_orgid'=>$this->orgid,
                                    'quma_reqno' => $req_no,
                                    'quma_fyear' => $fiscalyear,
                                    'quma_type'=>$type
                                );
                if(!empty($quoMasterArray)){   
                    // print_r($quoMasterArray);
                    $this->db->insert($this->quma_mastertable,$quoMasterArray);
                    $insertid = $this->db->insert_id();
                    // $insertid = 1;
                    if($insertid){
                         foreach ($itemsid as $key => $val) {
                          $quoDetail[]=array(
                                            'qude_quotationmasterid'=>$insertid,
                                            'qude_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
                                            'qude_qty'=> 1,
                                            'qude_rate'=> !empty($rate[$key])?$rate[$key]:'',
                                            'qude_discountpc'=> !empty($discountpc[$key])?$discountpc[$key]:'',
                                            'qude_vatpc'=> !empty($vatpc[$key])?$vatpc[$key]:'',
                                            'qude_netrate'=> !empty($netrate[$key])?$netrate[$key]:'',
                                            'qude_remarks'=>'',
                                            'qude_posteddatead'=>CURDATE_EN,
                                            'qude_posteddatebs'=>CURDATE_NP,
                                            'qude_postedtime'=>$this->curtime,
                                            'qude_postedby'=>$this->userid,
                                            'qude_postedmac'=>$this->mac,
                                            'qude_postedip'=>$this->ip,
                                            'qude_locationid'=>$this->locationid,
                                            'qude_orgid'=>$this->orgid 
                                        );
                        }
                                // if($total_amount == $totalAmount){
                                //     $total_amount = $totalAmount;
                                // }else{
                                //     return false;
                                // }
                        //echo"call";echo"<pre>";print_r($total_amount);print_r($totalAmount);die;
                        if(!empty($quoDetail)){  
                            $this->db->insert_batch($this->qude_detailtable,$quoDetail);
                        }
                            // $updateMasterArray = array(
                                //                         'quma_amount'=>$totalRateAmount,
                                //                         'quma_discount'=>$totalDiscount,
                                //                         'quma_vat'=>$totalVat,
                                //                         'quma_totalamount'=>$totalAmount
                                //                     );
                                // if($updateMasterArray){
                                //     $this->db->where('quma_quotationmasterid',$insertid);
                                //     $this->db->update($this->quma_mastertable,$updateMasterArray);
                            // }
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
    public function get_all_quotation($srchcol=false,$limit=false,$offset=false,$order_by=false,$order=false){
        $locationid=$this->input->post('locationid')?$this->input->post('locationid'):'';
        if($this->location_ismain=='Y')
          {
           
          if(!empty($locationid))
            {
                $this->db->where('quma_locationid',$locationid);
            }else{
                $this->db->where('quma_locationid',$this->locationid);
            }
         }
        else
        {
             $this->db->where('quma_locationid',$this->locationid);
        }

        $this->db->select('qm.*, dist_distributor as supp_suppliername,lo.loca_name');
        $this->db->from('quma_quotationmaster qm');
        $this->db->join('dist_distributors su','su.dist_distributorid = qm.quma_supplierid','left');
         $this->db->join('loca_location lo','lo.loca_locationid=qm.quma_locationid','LEFT');
        if($srchcol){
            $this->db->where($srchcol);
        }
        if($limit && $limit>0){
            $this->db->limit($limit);
        }
        if($order_by){
            $this->db->order_by($order_by,$order);
        }
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        if($query->num_rows()>0){
            return $query->result();
        }
        return false;
    }
    public function get_all_quotation_items($srchcol=false,$limit=false,$offset=false,$order_by=false,$order=false){
        $this->db->select('qd.*, it.itli_itemname,it.itli_itemcode, ut.unit_unitname');
        $this->db->from('qude_quotationdetail qd');
        $this->db->join('itli_itemslist it','it.itli_itemlistid = qd.qude_itemsid','left');
        $this->db->join('unit_unit ut','ut.unit_unitid = qd.qude_units','left');
        if($srchcol){
            $this->db->where($srchcol);
        }
        if($limit && $limit>0){
            $this->db->limit($limit);
        }
        if($order_by){
            $this->db->order_by($order_by,$order);
        }
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
        return false;
    }
public function get_distinct_quotation_items($srchcol=false,$column){
        $locationid=$this->input->post('locationid');
        $this->db->select("qd.qude_itemsid,il.itli_itemname,il.itli_itemnamenp, ut.unit_unitname ,$column");
        $this->db->from('quma_quotationmaster qm');
        $this->db->join('qude_quotationdetail qd','qm.quma_quotationmasterid=qd.qude_quotationmasterid','left');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = qd.qude_itemsid','left');
        $this->db->join('unit_unit ut','ut.unit_unitid = qd.qude_units','left');
        $this->db->group_by('qd.qude_itemsid');
        if($srchcol){
            $this->db->where($srchcol);
        }
        if(!empty($locationid)){
            $this->db->where('qm.quma_locationid',$locationid);
        }
        
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
        return false;
    }

    public function get_all_quotation_list(){
        
        $frmDate=!empty($this->input->get('frmDate'))?$this->input->get('frmDate'):CURMONTH_DAY1;
        $toDate=!empty($this->input->get('toDate'))?$this->input->get('toDate'):DISPLAY_DATE;
         $dateSearch = $this->input->get('dateSearch');
         $type=$this->input->get('type');
        //print_r($dateSearch);die;

          
        if($frmDate &&  $toDate)
        {
           if(DEFAULT_DATEPICKER=='NP')
             {
             $this->db->where(array('quma_quotationdatebs >='=>$frmDate,'quma_quotationdatebs <='=>$toDate));
             }
             else
             {
                  $this->db->where(array('quma_quotationdatead >='=>$frmDate,'quma_quotationdatead <='=>$toDate));
             }

        }
     
        if($dateSearch == "validate")
        {
            if($frmDate &&  $toDate)
            {                  
                 if(DEFAULT_DATEPICKER=='NP')
                 {
                    $this->db->where(array('quma_expdatebs >='=>$frmDate,'quma_expdatebs <='=>$toDate));
                 }
                 else
                 {
                    $this->db->where(array('quma_expdatad >='=>$frmDate,'quma_expdatad <='=>$toDate));
                 }
            }
            
        }
        if($dateSearch == "supplierdate")
        {
            if($frmDate &&  $toDate)
            {
            
                if(DEFAULT_DATEPICKER=='NP')
                 {
                    $this->db->where(array('quma_supplierquotationdatebs >='=>$frmDate,'quma_supplierquotationdatebs <='=>$toDate));
                 }
                 else
                 {
                      $this->db->where(array('quma_supplierquotationdatead >='=>$frmDate,'quma_supplierquotationdatead <='=>$toDate));
                 }
            }
        }
        if($dateSearch == "quotationdate")
        {
            if($frmDate &&  $toDate)
            {
            
                if(DEFAULT_DATEPICKER=='NP')
                 {
                 $this->db->where(array('quma_quotationdatebs >='=>$frmDate,'quma_quotationdatebs <='=>$toDate));
                 }
                 else
                 {
                      $this->db->where(array('quma_quotationdatead >='=>$frmDate,'quma_quotationdatead <='=>$toDate));
                 }
            }
        }

        //echo "insidecond";print_r($cond); die;

        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        if(!empty($get['sSearch_1'])){
            $this->db->where("quma_quotationnumber like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("quma_quotationdatebs like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("quma_supplierquotationdatebs like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("quma_supplierquotationnumber like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            if(DEFAULT_DATEPICKER=='NP')
            {
            $this->db->where("quma_expdatebs like  '%".$get['sSearch_6']."%'  ");
            }
            else
            {
                $this->db->where("quma_expdatead like  '%".$get['sSearch_6']."%'  ");
            }
        } 
        if(!empty($get['sSearch_7'])){
            $this->db->where("quma_totalamount like  '%".$get['sSearch_7']."%'  ");
        } 
        
        $resltrpt=$this->db->select("COUNT(*) as cnt")
                        ->from('quma_quotationmaster qm')
                        ->join('dist_distributors su','su.dist_distributorid = qm.quma_supplierid') 
                        ->get()
                        ->row();
        //$resltrpt=$this->db->query("SELECT COUNT(*) as cnt FROM xw_pudo_purchdonate  ")->row();
        //echo $this->db->last_query();die(); 
        $totalfilteredrecs=$resltrpt->cnt;
        $order_by = 'quma_totalamount';
        $order = 'ASC';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'quma_quotationnumber';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'dist_distributor';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'quma_quotationdatebs';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'quma_supplierquotationdatebs';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'quma_supplierquotationnumber';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'quma_expdatead';
         else if($this->input->get('iSortCol_0')==7)
            $order_by = 'quma_totalamount';
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

        if($frmDate &&  $toDate)
        {
         if(DEFAULT_DATEPICKER=='NP')
             {
             $this->db->where(array('quma_quotationdatebs >='=>$frmDate,'quma_quotationdatebs <='=>$toDate));
             }
             else
             {
                  $this->db->where(array('quma_quotationdatead >='=>$frmDate,'quma_quotationdatead <='=>$toDate));
             }
        }
     
        if($dateSearch == "validate")
        {
             if(DEFAULT_DATEPICKER=='NP')
             {
                $this->db->where(array('quma_expdatebs >='=>$frmDate,'quma_expdatebs <='=>$toDate));
             }
             else
             {
                $this->db->where(array('quma_expdatad >='=>$frmDate,'quma_expdatad <='=>$toDate));
             }
            
        }
        if($dateSearch == "supplierdate")
        {
            if(DEFAULT_DATEPICKER=='NP')
             {
                $this->db->where(array('quma_supplierquotationdatebs >='=>$frmDate,'quma_supplierquotationdatebs <='=>$toDate));
             }
             else
             {
                  $this->db->where(array('quma_supplierquotationdatead >='=>$frmDate,'quma_supplierquotationdatead <='=>$toDate));
             }
        }
        if($dateSearch == "quotationdate")
        {
            if(DEFAULT_DATEPICKER=='NP')
             {
             $this->db->where(array('quma_quotationdatebs >='=>$frmDate,'quma_quotationdatebs <='=>$toDate));
             }
             else
             {
                  $this->db->where(array('quma_quotationdatead >='=>$frmDate,'quma_quotationdatead <='=>$toDate));
             }
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("quma_quotationnumber like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("quma_quotationdatebs like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("quma_supplierquotationdatebs like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("quma_supplierquotationnumber like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            if(DEFAULT_DATEPICKER=='NP')
            {
            $this->db->where("quma_expdatebs like  '%".$get['sSearch_6']."%'  ");
            }
            else
            {
                $this->db->where("quma_expdatead like  '%".$get['sSearch_6']."%'  ");
            }
        } 
        if(!empty($get['sSearch_7'])){
            $this->db->where("quma_totalamount like  '%".$get['sSearch_7']."%'  ");
        } 
        $this->db->select('qm.*, dist_distributor as supp_suppliername');
        $this->db->from('quma_quotationmaster qm');
        $this->db->join('dist_distributors su','su.dist_distributorid = qm.quma_supplierid');
        $this->db->where('quma_type',$type);

        if($order_by){
            $this->db->order_by($order_by,$order);   
        }
        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }
        $nquery=$this->db->get();
         // echo $this->db->last_query();die;
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
        // echo "<pre>";
        // print_r($ndata);
        // die();
        return $ndata;
    }

    public function get_all_quotation_details($srchcol=false,$limit=false,$offset=false,$order_by=false,$order=false){
        $this->db->select('qd.*, it.itli_itemname,it.itli_itemnamenp,it.itli_itemcode, ut.unit_unitname,qm.quma_totalamount');
        $this->db->from('qude_quotationdetail qd');
        $this->db->join('quma_quotationmaster qm','qm.quma_quotationmasterid = qd.qude_quotationmasterid','left');
        $this->db->join('itli_itemslist it','it.itli_itemlistid = qd.qude_itemsid','left');
        $this->db->join('unit_unit ut','ut.unit_unitid = qd.qude_units','left');
        if($srchcol){
            $this->db->where($srchcol);
        }
        if($limit && $limit>0){
            $this->db->limit($limit);
        }
        if($order_by){
            $this->db->order_by($order_by,$order);
        }
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
        return false;
    }

    public function get_summary_quotation($select,$srchcol=false,$limit=false,$offset=false,$order_by=false,$order=false)
    {
         $this->db->select($select);
          $this->db->from('quma_quotationmaster qm');
        $this->db->join('qude_quotationdetail qd','qm.quma_quotationmasterid = qd.qude_quotationmasterid','left');
       
        if($srchcol){
            $this->db->where($srchcol);
        }
        if($limit && $limit>0){
            $this->db->limit($limit);
        }
        if($order_by){
            $this->db->order_by($order_by,$order);
        }
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
        return false;
    }

    public function get_suppliers_by_fyear_reqno($reqno =false, $fyear =false){
        $query = $this->db->query('SELECT dist_distributorid, dist_distributorcode, dist_distributor FROM xw_dist_distributors WHERE dist_distributorid IN (select quma_supplierid from xw_quma_quotationmaster where quma_fyear ="'.$fyear.'" AND quma_reqno = "'.$reqno.'") ORDER BY dist_distributor ASC');
        if($query->num_rows()>0){
            return $query->result();
        }
        return false;
    }

    public function rate_compare_quotation($srchcol)
    {
         $this->db->select('min(qude_netrate) as minrate');
          $this->db->from('quma_quotationmaster qm');
        $this->db->join('qude_quotationdetail qd','qm.quma_quotationmasterid = qd.qude_quotationmasterid','left');
       
        if($srchcol){
            $this->db->where($srchcol);
        }
        $result = $this->db->get()->row();
       
        return $result;
    }


    public function get_supplier_summary($srchcol){

        $this->db->select("quma_reqno,quma_supplierid,SUM(qd.qude_netrate) nettotal ");
        $this->db->from('quma_quotationmaster qm');
        $this->db->join('qude_quotationdetail qd','qm.quma_quotationmasterid=qd.qude_quotationmasterid','left');
        $this->db->group_by('quma_reqno,quma_supplierid');
        $this->db->order_by('quma_supplierid','ASC');
        if($srchcol){
            $this->db->where($srchcol);
        }
        
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
        return false;
    }
}