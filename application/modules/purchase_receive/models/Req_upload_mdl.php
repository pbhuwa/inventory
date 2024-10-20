<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Req_upload_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->reum_mastertable = 'reum_requploadmaster';
        $this->reud_detailtable = 'reud_requploaddetail';

        $this->urem_mastertable = 'urem_uploadreqentrymaster';
        $this->ured_detailtable = 'ured_uploadreqentrydetail';

        $this->curtime = $this->general->get_currenttime();
        $this->userid = $this->session->userdata(USER_ID);
        $this->username=$this->session->userdata(USER_NAME);
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
        $this->orgid=$this->session->userdata(ORG_ID);
    }

    public $validate_settings_req_upload = array(
        array('field' => 'reum_uploadno', 'label' => 'Upload Number ', 'rules' => 'trim|required|xss_clean'),
    );

    public $validate_supplier_rate_entry = array(
        array('field' => 'req_no', 'label' => 'Upload Number ', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'supplierid', 'label' => 'Supplier ', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'supplierdate', 'label' => 'Supplier Date ', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'ured_rate[]', 'label' => 'Rate ', 'rules' => 'trim|required|xss_clean')
    );

    public function req_upload_save()
    {
        // echo "<pre>";
        // print_r($this->input->post());
        // die();
        try{
            $id = $this->input->post('id');

            $fiscalyear = $this->input->post('fiscalyear');
            $upload_no = $this->input->post('reum_uploadno');
            $manual_no = $this->input->post('reum_manualno');
            $valid_date = $this->input->post('reum_validdate');
            $remarks = $this->input->post('reum_remarks');

            if(DEFAULT_DATEPICKER == 'NP'){
                $valid_date_bs = $valid_date;
                $valid_date_ad = $this->general->NepToEngDateConv($valid_date);
            }else{
                $valid_date_bs = $this->general->EngToNepDateConv($valid_date);
                $valid_date_ad = $valid_date;
            }

            $this->db->trans_begin();
            
            if($id){
                //update query
            }else{
                $uploadMasterArray = array(
                    'reum_fyear' => $fiscalyear,
                    'reum_uploadno' => $upload_no,
                    'reum_manualno' => $manual_no,
                    'reum_validdatead' => $valid_date_ad,
                    'reum_validdatebs' => $valid_date_bs,
                    'reum_remarks' => $remarks,
                    'reum_postdatead'=>CURDATE_EN,
                    'reum_postdatebs'=>CURDATE_NP,
                    'reum_posttime'=>$this->curtime,
                    'reum_postby'=>$this->userid,
                    'reum_postmac'=>$this->mac,
                    'reum_postip'=>$this->ip,
                    'reum_locationid'=>$this->locationid,
                    'reum_orgid'=>$this->orgid
                );

                if($uploadMasterArray){
                    $this->db->insert($this->reum_mastertable,$uploadMasterArray);
                    $insertid = $this->db->insert_id();

                    if($insertid){
                        if(isset($_FILES["reum_excel"]["name"])){
                            $path = $_FILES["reum_excel"]["tmp_name"];
                            $object = PHPExcel_IOFactory::load($path);

                            foreach($object->getWorksheetIterator() as $worksheet){
                                $highestRow = $worksheet->getHighestRow();
                                $highestColumn = $worksheet->getHighestColumn();

                                for($row=2; $row<=$highestRow; $row++){
                                    $description = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                                    $manufacturer = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                                    $qty = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                                    $size = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                                    $rate = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                                    $remarks = $worksheet->getCellByColumnAndRow(5, $row)->getValue();

                                    $upload_detail_data[] = array(
                                        'reud_itemname' => $description,
                                        'reud_manufacturer' => $manufacturer,
                                        'reud_qty' => $qty,
                                        'reud_size' => $size,
                                        'reud_rate' => $rate,
                                        'reud_remarks' => $remarks,
                                        'reud_reumid' => $insertid,
                                        'reud_postdatead' => CURDATE_EN,
                                        'reud_postdatebs' => CURDATE_NP,
                                        'reud_posttime' => $this->curtime,
                                        'reud_postby' => $this->userid,
                                        'reud_postmac' => $this->mac,
                                        'reud_postip' => $this->ip,
                                        'reud_locationid' => $this->locationid,
                                        'reud_orgid' => $this->orgid
                                    );
                                }
                            }

                            $this->db->insert_batch($this->reud_detailtable,$upload_detail_data);
                        } 
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

    public function get_req_upload_list_for_modal($cond = false){
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("pure_reqno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("pure_reqdatebs like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("pure_reqdatead like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("pure_appliedby like  '%".$get['sSearch_4']."%'  ");
        }

        if(!empty($get['sSearch_5'])){
            $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_5']."%'  ");
        }

        if(!empty($get['sSearch_6'])){
            $this->db->where("pure_requestto like  '%".$get['sSearch_6']."%'  ");
        }
        

        if($cond) {
            $this->db->where($cond);
        }

        $resltrpt=$this->db->select("*")
                    ->from('reum_requploadmaster rm')
                    ->get()
                    ->result();


        $totalfilteredrecs=!sizeof($resltrpt)?$resltrpt:0; 

        $order_by = 'reum_reumid';
        $order = 'desc';
  
        $where='';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'pure_reqno';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'pure_reqdatebs';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'pure_reqdatead';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'pure_appliedby';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'eqty_equipmenttype';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'pure_requestto';
        
        $totalrecs='';
        $limit = 15;
        $offset = 1;
        $get = $_GET;
 
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        if($this->input->get('sSortDir_0'))
        {
            $order = $this->input->get('sSortDir_0');
        }
      
        if(!empty($_GET["iDisplayLength"])){
            $limit = $_GET['iDisplayLength'];
            $offset = $_GET["iDisplayStart"];
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("pure_reqno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("pure_reqdatebs like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("pure_reqdatead like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("pure_appliedby like  '%".$get['sSearch_4']."%'  ");
        }

        if(!empty($get['sSearch_5'])){
            $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_5']."%'  ");
        }

        if(!empty($get['sSearch_6'])){
            $this->db->where("pure_requestto like  '%".$get['sSearch_6']."%'  ");
        }

        $this->db->select('*');
        $this->db->from('reum_requploadmaster rm');
        if($cond) {
            $this->db->where($cond);
        }

        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        
        if($offset)
        {
            $this->db->offset($offset);
        }
        $this->db->order_by($order_by,$order);

        $nquery=$this->db->get();

         // echo $this->db->last_query();die();

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
       
       return $ndata;
    }

    public function get_req_upload_detail($srchcol = false){
        $this->db->select('rd.*, rm.reum_fyear, rm.reum_reumid, rm.reum_uploadno');
        $this->db->from('reud_requploaddetail rd');
        $this->db->join('reum_requploadmaster rm', 'rm.reum_reumid = rd.reud_reumid');

        if($srchcol){
            $this->db->where($srchcol);
        }
        $query = $this->db->get();

        if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
        return false;
    }

    public function get_all_quotation($srchcol=false,$limit=false,$offset=false,$order_by=false,$order=false){
        $this->db->select('qm.*, dist_distributor as supp_suppliername');
        $this->db->from('quma_quotationmaster qm');
        $this->db->join('dist_distributors su','su.dist_distributorid = qm.quma_supplierid','left');
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

    public function supplier_rate_entry_save()
    {
        // echo "<pre>";
        // print_r($this->input->post());
        // die();
        try{
            $id = $this->input->post('id');

            //master table data
            $fiscalyear = $this->input->post('fiscalyear');
            $upload_no = $this->input->post('req_no');
            $manual_no = $this->input->post('urem_manualno');
            $valid_date = $this->input->post('urem_validdate');
            $remarks = $this->input->post('urem_remarks');
            $supplier_date = $this->input->post('supplierdate');
            $supplierid = $this->input->post('supplierid');

            //detail table data
            $itemid = $this->input->post('itemid');
            $itemname = $this->input->post('ured_itemname');
            $manufacturer = $this->input->post('ured_manufacturer');
            $qty = $this->input->post('ured_qty');
            $size = $this->input->post('ured_size');
            $rate = $this->input->post('ured_rate');
            $detail_remarks = $this->input->post('ured_remarks');
            $status = $this->input->post('ured_status');
            $totalamount = $this->input->post('ured_totalamount');

            if(DEFAULT_DATEPICKER == 'NP'){
                $valid_date_bs = $valid_date;
                $valid_date_ad = $this->general->NepToEngDateConv($valid_date);

                $supplier_date_bs = $supplier_date;
                $supplier_date_ad = $this->general->NepToEngDateConv($supplier_date);
            }else{
                $valid_date_bs = $this->general->EngToNepDateConv($valid_date);
                $valid_date_ad = $valid_date;

                $supplier_date_bs = $supplier_date;
                $supplier_date_ad = $this->general->EngToNepDateConv($supplier_date);
            }

            $this->db->trans_begin();
            
            if($id){
                //update query
            }else{
                $uploadMasterArray = array(
                    'urem_fyear' => $fiscalyear,
                    'urem_uploadno' => $upload_no,
                    'urem_manualno' => $manual_no,
                    'urem_validdatead' => $valid_date_ad,
                    'urem_validdatebs' => $valid_date_bs,
                    'urem_supplierdatead' => $supplier_date_ad,
                    'urem_supplierdatebs' => $supplier_date_bs,
                    'urem_remarks' => $remarks,
                    'urem_supplierid' => $supplierid,
                    'urem_postdatead'=>CURDATE_EN,
                    'urem_postdatebs'=>CURDATE_NP,
                    'urem_posttime'=>$this->curtime,
                    'urem_postby'=>$this->userid,
                    'urem_postmac'=>$this->mac,
                    'urem_postip'=>$this->ip,
                    'urem_locationid'=>$this->locationid,
                    'urem_orgid'=>$this->orgid
                );

                if($uploadMasterArray){
                    $this->db->insert($this->urem_mastertable,$uploadMasterArray);
                    $insertid = $this->db->insert_id();

                    if($insertid){
                        if(!empty($itemname)){
                            foreach($itemname as $key=>$val){
                                $uploadDetailArray[] = array(
                                    'ured_uremid' => $insertid,
                                    'ured_itemid'=>!empty($itemid[$key])?$itemid[$key]:'',
                                    'ured_itemname' => !empty($itemname[$key])?$itemname[$key]:'',
                                    'ured_manufacturer' => !empty($manufacturer[$key])?$manufacturer[$key]:'',
                                    'ured_qty' => !empty($qty[$key])?$qty[$key]:'',
                                    'ured_size' => !empty($size[$key])?$size[$key]:'',
                                    'ured_rate' => !empty($rate[$key])?$rate[$key]:'',
                                    'ured_remarks' => !empty($detail_remarks[$key])?$detail_remarks[$key]:'',
                                    'ured_totalamount' => !empty($totalamount[$key])?$totalamount[$key]:'',
                                    'ured_postdatead' => CURDATE_EN,
                                    'ured_postdatebs' => CURDATE_NP,
                                    'ured_posttime' => $this->curtime,
                                    'ured_postby' => $this->userid,
                                    'ured_postmac' => $this->mac,
                                    'ured_postip' => $this->ip,
                                    'ured_locationid' => $this->locationid,
                                    'ured_orgid' => $this->orgid
                                );
                            }
                        }

                        if(!empty($uploadDetailArray)){
                            $this->db->insert_batch($this->ured_detailtable,$uploadDetailArray);
                        }
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

    public function get_suppliers_by_fyear_reqno($reqno =false, $fyear =false){
        $query = $this->db->query('SELECT dist_distributorid, dist_distributorcode, dist_distributor FROM xw_dist_distributors WHERE dist_distributorid IN (select urem_supplierid from xw_urem_uploadreqentrymaster where urem_fyear ="'. $fyear.'" AND urem_uploadno = "'.$reqno.'") ORDER BY dist_distributor ASC');
        if($query->num_rows()>0){
            return $query->result();
        }
        return false;
    }

  
    public function distinct_suppliers_req_list($srchcol=false,$limit=false,$offset=false,$order_by=false,$order=false){
        $locationid=$this->input->post('locationid');
        $this->db->select('um.*, dist_distributor as supp_suppliername');
        $this->db->from('urem_uploadreqentrymaster um ');
        $this->db->join('dist_distributors su','su.dist_distributorid = um.urem_supplierid','left');
        if($srchcol){
            $this->db->where($srchcol);
        }
        if($limit && $limit>0){
            $this->db->limit($limit);
        }
        if($order_by){
            $this->db->order_by($order_by,$order);
        }

    if($this->location_ismain=='Y'){
       if(!empty($locationid))
        {
            $this->db->where('um.urem_locationid',$locationid);
        }
        }else{
            $this->db->where('um.urem_locationid',$this->locationid);

        }

        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
        return false;
    }

    public function get_distinct_req_items($srchcol=false,$column){
        $this->db->select("ud.ured_itemid,ud.ured_itemname,ud.ured_manufacturer,ud.ured_qty,ud.ured_size,$column");
        $this->db->from('urem_uploadreqentrymaster um');
        $this->db->join('ured_uploadreqentrydetail ud','ud.ured_uremid=um.urem_uremid','left');
        $this->db->group_by('ud.ured_itemid');
        if($srchcol){
            $this->db->where($srchcol);
        }
        
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
        return false;
    }

public function get_supplier_req_summary($srchcol){
        $this->db->select("urem_uploadno,urem_supplierid,SUM(ured_totalamount) nettotal ");
        $this->db->from('urem_uploadreqentrymaster um');
        $this->db->join('ured_uploadreqentrydetail ud','ud.ured_uremid=um.urem_uremid','left');
        $this->db->group_by('urem_uploadno,urem_supplierid');
        $this->db->order_by('urem_supplierid','ASC');
        if($srchcol){
            $this->db->where($srchcol);
        }
        
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
        return false;
  }

  public function get_upload_no($srchcol = false){

        try{

            $this->db->select('max(reum_uploadno) as reqmax');

            $this->db->from('reum_requploadmaster');

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

    public function get_upload_excel_masterdata()
    {
        $requisitionno=$this->input->post('requisitionno');
        $fiscalyear=$this->input->post('fiscalyear');
        $this->db->select('reum_reumid,
                            reum_uploadno,
                            reum_fyear,
                            reum_manualno,
                            reum_supplierid,
                            reum_supplierdatead,
                            reum_supplierdatebs,
                            reum_validdatead,
                            reum_validdatebs,
                            reum_uploaddatead,
                            reum_uploaddatebs,
                            reum_status,
                            reum_remarks');
       $this->db->from('reum_requploadmaster as rm');
       $this->db->where(array('reum_fyear'=>$fiscalyear,'reum_uploadno'=>$requisitionno));
       $this->db->where('reum_locationid',$this->locationid);
       $result=$this->db->get()->row();
       return $result;
    }

    public function get_upload_excel_detaildata($srchcol=false)
    {
         $this->db->select('reud_reudid,
                            reud_reumid,
                            reud_itemname,
                            reud_manufacturer,
                            reud_qty,
                            reud_size,
                            reud_rate,
                            reud_remarks');
       $this->db->from('reud_requploaddetail as rd');
       if(!empty($srchcol)){
        $this->db->where($srchcol);
       }
       $this->db->where('reud_locationid',$this->locationid);
       $this->db->order_by('reud_reudid','ASC');
       $result=$this->db->get()->result();
       return $result;
    }


public function update_req_form_data()
{
    // echo "<pre>";
    // print_r($this->input->post());
    // die();
    try{
    $this->db->trans_begin();

    $masterid=$this->input->post('masterid');
    $manualno=$this->input->post('reum_manualno');
    $valid_date=$this->input->post('reum_validdate');
    $reum_remarks=$this->input->post('reum_remarks');
    $reudid=$this->input->post('reud_reudid');
    $itemname=$this->input->post('reud_itemname');
    $manufacturer=$this->input->post('reud_manufacturer');
    $qty=$this->input->post('reud_qty');
    $size=$this->input->post('reud_size');
    $rate=$this->input->post('reud_rate');
    $remarks=$this->input->post('reud_remarks');
    // echo "<pre>";
    // print_r($reudid);
    // die();

    if(DEFAULT_DATEPICKER == 'NP'){
            $valid_date_bs = $valid_date;
            $valid_date_ad = $this->general->NepToEngDateConv($valid_date);
        }else{
            $valid_date_bs = $this->general->EngToNepDateConv($valid_date);
            $valid_date_ad = $valid_date;
        }
  
    $master_data_updatearr=array(
        'reum_manualno'=>$manualno,
        'reum_validdatead'=>$valid_date_ad,
        'reum_validdatebs'=>$valid_date_bs,
        'reum_remarks'=>$reum_remarks,
        'reum_modifydatead'=>CURDATE_EN,
        'reum_modifydatebs'=>CURDATE_NP,
        'reum_modifytime'=>$this->curtime,
        'reum_modifyby'=>$this->userid ,
        'reum_modifyip'=>$this->ip,
        'reum_modifymac'=>$this->mac

         );
    $update_upload_detail_arr=array();  
    $inp_uparr=array(); 
    $db_reudid_data=$this->db->select('reud_reudid')
                        ->from('reud_requploaddetail rd')
                        ->where('rd.reud_reumid',$masterid)
                        ->where('rd.reud_locationid',$this->locationid)
                        ->get()->result();
        if(!empty($db_reudid_data)){
            foreach($db_reudid_data as $krdd => $db_val) {
                   $db_uparr[]= $db_val->reud_reudid;
            }
        }

    if(!empty($master_data_updatearr)){
        // echo "sad";
        // die();
        $this->db->update('reum_requploadmaster',$master_data_updatearr,array('reum_reumid'=>$masterid,'reum_locationid'=>$this->locationid));
        // echo $this->db->last_query();
       
            // echo "asdsad";
            // die();
            if(!empty($reudid)){
                foreach ($reudid as $krd => $val) {
                    $inp_value=!empty($reudid[$krd])?$reudid[$krd]:'';
                    $inp_uparr[]=!empty($reudid[$krd])?$reudid[$krd]:'';
                     $update_insert_upload_detail_arr=array(
                        'reud_reudid'=>!empty($reudid[$krd])?$reudid[$krd]:'',
                        'reud_itemname'=>!empty($itemname[$krd])?$itemname[$krd]:'',
                        'reud_manufacturer'=>!empty($manufacturer[$krd])?$manufacturer[$krd]:'',
                        'reud_qty'=>!empty($qty[$krd])?$qty[$krd]:'',
                        'reud_size'=>!empty($size[$krd])?$size[$krd]:'',
                        'reud_rate'=>!empty($rate[$krd])?$rate[$krd]:'',
                        'reud_remarks'=>!empty($remarks[$krd])?$remarks[$krd]:'',

                    );

                    if(!empty($inp_value)){
                          if(!empty($update_insert_upload_detail_arr)){
                             $update_insert_upload_detail_arr['reud_modifydatead']=CURDATE_EN;
                            $update_insert_upload_detail_arr['reud_modifydatebs']=CURDATE_NP;
                            $update_insert_upload_detail_arr['reud_modifytime']= $this->curtime;
                            $update_insert_upload_detail_arr['reud_modifyby']=  $this->userid ;
                            $update_insert_upload_detail_arr['reud_modifyip']=  $this->ip;
                            $update_insert_upload_detail_arr['reud_modifymac']=$this->mac;
                            $this->db->update('reud_requploaddetail',$update_insert_upload_detail_arr, array('reud_reudid'=>$inp_value)); 
                        }
                    }
                    else{
                    $update_insert_upload_detail_arr['reud_reumid']=$masterid;
                    $update_insert_upload_detail_arr['reud_postdatead']=CURDATE_EN;
                    $update_insert_upload_detail_arr['reud_postdatebs']=CURDATE_NP;
                    $update_insert_upload_detail_arr['reud_posttime']= $this->curtime;
                    $update_insert_upload_detail_arr['reud_postby']=  $this->userid ;
                    $update_insert_upload_detail_arr['reud_postip']=  $this->ip;
                    $update_insert_upload_detail_arr['reud_postmac']=$this->mac;
                    $update_insert_upload_detail_arr['reud_locationid']=$this->locationid;
                    $update_insert_upload_detail_arr['reud_storeid']=1;
                    $update_insert_upload_detail_arr['reud_orgid']=$this->orgid;
                     $this->db->insert('reud_requploaddetail',$update_insert_upload_detail_arr);
                    }
                }

            }
      
        // echo "<pre>";
        // print_r($db_reudid_data);
        // echo "-------";
        // print_r($inp_uparr);
        // die();
      
         $deleted_items=array();
         if(is_array($inp_uparr)){
            $deleted_items = array_diff($db_uparr, $inp_uparr);
         }

         // echo "<pre>";
         // print_r($deleted_items);
         // die();
            $del_items_num = count($deleted_items);
         if(!empty($deleted_items)){
           if(!empty($del_items_num)){
                    $del_items_num = count($deleted_items);
                    for($i = 0; $i<$del_items_num; $i++){
                        $deleted_array = array_values($deleted_items);
                        // print_r($deleted_array);
                        // die();
                        foreach($deleted_array as $key=>$del){
                            $this->db->where(array('reud_reudid'=>$del));
                            $this->db->delete('reud_requploaddetail');
                        }

                    }

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
            return $masterid;

        }
    }catch (Exception $e) {
          $this->db->trans_rollback();
          return false;
    }
}


public function search_supply_upload_record_master()
{
    $requisitionno=$this->input->post('requisitionno');
    $fiscalyear=$this->input->post('fiscalyear');
    $supplierid=$this->input->post('supplierid');
    $this->db->select("urem_uremid,urem_uploadno,urem_fyear,urem_manualno,urem_supplierid,urem_supplierdatead,urem_supplierdatebs,urem_validdatead,urem_validdatebs,urem_uploaddatead,urem_uploaddatebs,urem_remarks,urem_status,ds.dist_distributor");
    $this->db->from('urem_uploadreqentrymaster um');
    $this->db->join('dist_distributors ds','ds.dist_distributorid=um.urem_supplierid','LEFT');
    $this->db->where(array('urem_uploadno'=>$requisitionno,'urem_fyear'=>$fiscalyear,'urem_supplierid'=>$supplierid));
  
    $query = $this->db->get();
    if($query->num_rows()>0){
        return $query->row();
    }
    return false;
}

public function search_supply_upload_record_detail($srchcol=false){
 $this->db->select("ured_uredid,
    ured_uremid,
    ured_itemid,
    ured_itemname,
    ured_manufacturer,
    ured_qty,
    ured_size,
    ured_rate,
    ured_vatpc,
    ured_vatamt,
    ured_totalamount,
    ured_remarks,
    ured_status");
    $this->db->from('ured_uploadreqentrydetail ud');
   if(!empty($srchcol)){
    $this->db->where($srchcol);
   }
   $this->db->order_by('ured_uredid','ASC');
    $query = $this->db->get();
    if($query->num_rows()>0){
        return $query->result();
    }
    return false;

}



public function update_supplier_item_rate(){
 
 try{
    $this->db->trans_begin();
    $masterid=$this->input->post('id');
    $manualno=$this->input->post('urem_manualno');
    $valid_date=$this->input->post('urem_validdate');
    $supplierdate=$this->input->post('supplierdate');
    $urem_remarks=$this->input->post('urem_remarks');
    
    $reudid=$this->input->post('ured_uredid');
  
    $qty=$this->input->post('ured_qty');
    $size=$this->input->post('ured_size');

    $rate=$this->input->post('ured_rate');
    $vatpc=$this->input->post('ured_vatpc');
    $vatamt=$this->input->post('ured_vatamt');
    $totalamt=$this->input->post('ured_totalamount');
    $remarks=$this->input->post('ured_remarks');
    // echo "<pre>";
    // print_r($reudid);
    // die();

    if(DEFAULT_DATEPICKER == 'NP'){
            $valid_date_bs = $valid_date;
            $valid_date_ad = $this->general->NepToEngDateConv($valid_date);
            $supplierdate_bs=$supplierdate;
            $supplierdate_ad=$this->general->NepToEngDateConv($supplierdate);
        }else{
            $valid_date_bs = $this->general->EngToNepDateConv($valid_date);
            $valid_date_ad = $valid_date;
            $supplierdate_bs=$this->general->EngToNepDateConv($supplierdate);
            $supplierdate_ad=$supplierdate;
        }
  
    $master_data_updatearr=array(
        'urem_manualno'=>$manualno,
        'urem_validdatead'=>$valid_date_ad,
        'urem_validdatebs'=>$valid_date_bs,
        'urem_supplierdatead'=>$supplierdate_ad,
        'urem_supplierdatebs'=>$supplierdate_bs,
        'urem_remarks'=>$urem_remarks,
        'urem_modifydatead'=>CURDATE_EN,
        'urem_modifydatebs'=>CURDATE_NP,
        'urem_modifytime'=>$this->curtime,
        'urem_modifyby'=>$this->userid ,
        'urem_modifyip'=>$this->ip,
        'urem_modifymac'=>$this->mac

         );
    $update_upload_detail_arr=array();  
    $inp_uparr=array(); 
    $db_reudid_data=$this->db->select('ured_uredid')
                        ->from('ured_uploadreqentrydetail rd')
                        ->where('rd.ured_uremid',$masterid)
                        ->where('rd.ured_locationid',$this->locationid)
                        ->get()->result();
        if(!empty($db_reudid_data)){
            foreach($db_reudid_data as $krdd => $db_val) {
                   $db_uparr[]= $db_val->ured_uredid;
            }
        }

    if(!empty($master_data_updatearr)){
        // echo "sad";
        // die();
        $this->db->update('urem_uploadreqentrymaster',$master_data_updatearr,array('urem_uremid'=>$masterid,'urem_locationid'=>$this->locationid));
        // echo $this->db->last_query();
      
            // echo "asdsad";
            // die();
            if(!empty($reudid)){
                foreach ($reudid as $krd => $val) {
                    $inp_value=!empty($reudid[$krd])?$reudid[$krd]:'';
                    $inp_uparr[]=!empty($reudid[$krd])?$reudid[$krd]:'';
                     $update_insert_upload_detail_arr=array(
                        'ured_uredid'=>!empty($reudid[$krd])?$reudid[$krd]:'',
                        'ured_qty'=>!empty($qty[$krd])?$qty[$krd]:'',
                        'ured_size'=>!empty($size[$krd])?$size[$krd]:'',
                        'ured_rate'=>!empty($rate[$krd])?$rate[$krd]:'',
                        'ured_vatpc'=>!empty($vatpc[$krd])?$vatpc[$krd]:'',
                        'ured_vatamt'=>!empty($vatamt[$krd])?$vatamt[$krd]:'',
                        'ured_totalamount'=>!empty($totalamt[$krd])?$totalamt[$krd]:'',
                        'ured_remarks'=>!empty($remarks[$krd])?$remarks[$krd]:'',

                    );

                    if(!empty($inp_value)){
                          if(!empty($update_insert_upload_detail_arr)){
                             $update_insert_upload_detail_arr['ured_modifydatead']=CURDATE_EN;
                            $update_insert_upload_detail_arr['ured_modifydatebs']=CURDATE_NP;
                            $update_insert_upload_detail_arr['ured_modifytime']= $this->curtime;
                            $update_insert_upload_detail_arr['ured_modifyby']=  $this->userid ;
                            $update_insert_upload_detail_arr['ured_modifyip']=  $this->ip;
                            $update_insert_upload_detail_arr['ured_modifymac']=$this->mac;
                            $this->db->update('ured_uploadreqentrydetail',$update_insert_upload_detail_arr, array('ured_uredid'=>$inp_value)); 
                        }
                    }
                    else{
                    $update_insert_upload_detail_arr['ured_reumid']=$masterid;
                    $update_insert_upload_detail_arr['ured_postdatead']=CURDATE_EN;
                    $update_insert_upload_detail_arr['ured_postdatebs']=CURDATE_NP;
                    $update_insert_upload_detail_arr['ured_posttime']= $this->curtime;
                    $update_insert_upload_detail_arr['ured_postby']=  $this->userid ;
                    $update_insert_upload_detail_arr['ured_postip']=  $this->ip;
                    $update_insert_upload_detail_arr['ured_postmac']=$this->mac;
                    $update_insert_upload_detail_arr['ured_locationid']=$this->locationid;
                    $update_insert_upload_detail_arr['ured_storeid']=1;
                    $update_insert_upload_detail_arr['ured_orgid']=$this->orgid;
                     $this->db->insert('ured_uploadreqentrydetail',$update_insert_upload_detail_arr);
                    }
                }

            }
      
        // echo "<pre>";
        // print_r($db_reudid_data);
        // echo "-------";
        // print_r($inp_uparr);
        // die();
      
             $deleted_items=array();
             if(is_array($inp_uparr)){
                $deleted_items = array_diff($db_uparr, $inp_uparr);
             }

         // echo "<pre>";
         // print_r($deleted_items);
         // die();
            $del_items_num = count($deleted_items);
             if(!empty($deleted_items)){
               if(!empty($del_items_num)){
                        $del_items_num = count($deleted_items);
                        for($i = 0; $i<$del_items_num; $i++){
                            $deleted_array = array_values($deleted_items);
                            // print_r($deleted_array);
                            // die();
                            foreach($deleted_array as $key=>$del){
                                $this->db->where(array('ured_uredid'=>$del));
                                $this->db->delete('ured_uploadreqentrydetail');
                            }

                        }

                    }
             }
  
    }

    $this->db->trans_complete();
           if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;

        }else{
        $this->db->trans_commit();
        return $masterid;
        }
    }
    catch (Exception $e) {
          $this->db->trans_rollback();
          return false;
    }
}




}