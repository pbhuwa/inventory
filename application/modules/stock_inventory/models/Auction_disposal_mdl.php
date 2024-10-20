<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Auction_disposal_mdl extends CI_Model
{

    public function __construct()
    {

        parent::__construct();

        $this->tableMaster = 'asde_assetdesposalmaster';

        $this->tableDetail = 'asdd_assetdesposaldetail';
        $this->tran_masterTable='trma_transactionmain';

        $this->tran_detailsTable='trde_transactiondetail';

        $this->curtime = $this->general->get_currenttime();

        $this->userid = $this->session->userdata(USER_ID);

        $this->username = $this->session->userdata(USER_NAME);

        $this->userdepid = $this->session->userdata(USER_DEPT); //storeid

        $this->mac = $this->general->get_Mac_Address();

        $this->ip = $this->general->get_real_ipaddr();

        $this->locationid = $this->session->userdata(LOCATION_ID);

        $this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);

        $this->orgid = $this->session->userdata(ORG_ID);

    }

    public $validate_settings_auction_disposal = array(

      array('field' => 'asde_fiscalyrs', 'label' => 'Fiscal Year', 'rules' => 'trim|required|xss_clean'),
      array('field' => 'asde_desposaltypeid', 'label' => 'Disposal Type', 'rules' => 'trim|required|xss_clean'),
      array('field' => 'asde_disposalno', 'label' => 'Disposal Order No', 'rules' => 'trim|required|xss_clean'),
      array('field' => 'asde_desposaldate', 'label' => 'Disposal Date ', 'rules' => 'trim|required|xss_clean'),
      array('field' => 'itemid[]', 'label' => 'Items', 'rules' => 'trim|required|xss_clean'),
      array('field' => 'auction_disposalqty[]', 'label' => 'Disposal/Auction Qty', 'rules' => 'trim|is_natural_no_zero|required|xss_clean')
     );

    public function auction_disposal_save(){       

      try{

        // echo "<pre>";

        // print_r($this->input->post());

        // die();         

        $id = $this->input->post('id');
        $fyear=$this->input->post('asde_fiscalyrs');
        $asde_disposalno =$this->input->post('asde_disposalno');
        $asde_manualno =$this->input->post('asde_manualno');
        $asde_desposaldate =$this->input->post('asde_desposaldate');
        $asde_desposaltypeid =$this->input->post('asde_desposaltypeid');
        $asde_customer_name =$this->input->post('asde_customer_name');
        $full_remarks  =$this->input->post('full_remarks');
        $assets_code =$this->input->post('assets_code');
        $itemid =$this->input->post('itemid');
        $itemname =$this->input->post('itemname');
        $unit =$this->input->post('unit');
        $purchaseqty=$this->input->post('purchaseqty');
        $dep_issueqty =$this->input->post('dep_issueqty');
        $remqty =$this->input->post('remqty');
        $auction_disposalqty=$this->input->post('auction_disposalqty');
        $salecost  =$this->input->post('salecost');
        $tcost  =$this->input->post('tcost');
        $remarks  =$this->input->post('remarks');

        if(DEFAULT_DATEPICKER == 'NP')

        {

          $asde_deposaldatebs=$asde_desposaldate;

          $asde_desposaldatead=$this->general->NepToEngDateConv($asde_desposaldate);

        }
        else
        {

          $asde_desposaldatead=$asde_desposaldate;

          $asde_deposaldatebs=$this->general->EngToNepDateConv($asde_desposaldate);
        }

        $locationid=$this->session->userdata(LOCATION_ID);

        $currentfyrs=CUR_FISCALYEAR;
        $cur_fiscalyrs_invoiceno = $this->db->select('prin_code,prin_fiscalyrs')
            ->from('prin_projectinfo')
            ->where('prin_locationid', $locationid)
            ->order_by('prin_fiscalyrs', 'DESC')
            ->limit(1)
            ->get()->row(); 

        if (!empty($cur_fiscalyrs_invoiceno)) {
            $invoice_format = $cur_fiscalyrs_invoiceno->prin_code;
            $invoice_string = str_split($invoice_format);
            $invoice_prefix_len = strlen(ITEM_DISPOSAL_NO_PREFIX);
            $chk_first_string_after_invoice_prefix = !empty($invoice_string[$invoice_prefix_len]) ? $invoice_string[$invoice_prefix_len] : '';
            
            if ($chk_first_string_after_invoice_prefix == '0') {
                $invoice_no_prefix = ITEM_DISPOSAL_NO_PREFIX . CUR_FISCALYEAR;
            } else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs == $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
                $invoice_no_prefix = ITEM_DISPOSAL_NO_PREFIX . CUR_FISCALYEAR;
            } else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs != $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
                $invoice_no_prefix = ITEM_DISPOSAL_NO_PREFIX . CUR_FISCALYEAR;
            } else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs != $currentfyrs && $chk_first_string_after_invoice_prefix != '0') {
                $invoice_no_prefix = ITEM_DISPOSAL_NO_PREFIX . CUR_FISCALYEAR;
            } else {
                $invoice_no_prefix = ITEM_DISPOSAL_NO_PREFIX;
            }
        } else {
            $invoice_no_prefix = ITEM_DISPOSAL_NO_PREFIX . CUR_FISCALYEAR;
        }

        $disposal_code = $this->general->generate_invoiceno('asde_disposalno', 'asde_disposalno', 'asde_assetdesposalmaster', $invoice_no_prefix, ITEM_DISPOSAL_NO_LENGTH, false, 'asde_locationid');

        $disposalMaster=array(

        'asde_fiscalyrs'=>$fyear,

        'asde_desposaltypeid'=>$asde_desposaltypeid,

        'asde_disposalno'=>$disposal_code,

        'asde_manualno'=>$asde_manualno,

        'asde_desposaldatead'=>$asde_desposaldatead,

        'asde_deposaldatebs'=>$asde_deposaldatebs,

        'asde_customer_name'=>$asde_customer_name,

        'asde_remarks'=>$full_remarks,

        'asde_status'=>'O',

        'asde_postdatead'=>CURDATE_EN,

        'asde_postdatebs'=>CURDATE_NP,

        'asde_posttime'=>$this->curtime,

        'asde_postby'=> $this->userid,

        'asde_postip'=> $this->ip,

        'asde_postmac'=>$this->mac,

        'asde_locationid'=> $this->locationid,

        'asde_orgid'=>$this->orgid

        );
         $insertid = 0;

        if(!empty($disposalMaster)){

            $this->db->insert('asde_assetdesposalmaster',$disposalMaster);

            $insertid = $this->db->insert_id();

            $disposalDetail = array();

            if(!empty($insertid)){

            if(!empty($itemid)):

                foreach ($itemid as $kdw => $item) {

                    $ass_desp_arr[]=array(

                        'asen_asenid' => !empty($item) ? $item : '',

                        'asen_isdispose' => 'Y'

                    );

            $disposal_qty = !empty($auction_disposalqty[$kdw]) ? $auction_disposalqty[$kdw] : 0;
            $sales_cost = !empty($salecost[$kdw]) ? $salecost[$kdw] : 0;
            $total_sales_amt = $disposal_qty * $sales_cost;
            $rmks=!empty($remarks[$kdw])?$remarks[$kdw]:'';

            $this->insert_into_disposal_detail_tbl($item,$disposal_qty, $sales_cost,$insertid,$rmks);

            }
            endif;

          }

        }

        $this->db->trans_complete();

        $this->db->trans_commit();

        return $insertid;

    }catch(Exception $e){

        $this->db->trans_rollback();

        return false;
    }

}

public function insert_into_disposal_detail_tbl($items_id,$disposal_qty,$sales_cost,$desposalmasteid,$remarks)
    {
        $scost=!empty($salecost)?$salecost:'0.0';
        $total_sales_amt=$disposal_qty*$scost;
        $this->db->select('mtd.trde_trdeid,mtd.trde_requiredqty, mtd.trde_unitprice, mtd.trde_selprice, mtd.trde_controlno, mtd.trde_expdatebs, mtd.trde_issueqty');
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
        $purchaseqty=$data->trde_requiredqty;
        $dep_issueqty=$purchaseqty-$db_issueqty;
        $rem_issue=$disposal_qty-$db_issueqty;
        if($rem_issue>0){
                $issueqty=$db_issueqty;
        }
        else{ 
            if($rem_issue<=0){
            $rm_issue=-($rem_issue);
            $issueqty= $db_issueqty-$rm_issue;
            }
        }

          $disposalDetail=array(
               'asdd_assetdesposalmasterid'=>$desposalmasteid,
               'asdd_assetid'=>!empty($items_id)?$items_id:'',
               'asdd_purchaseqty'=> $purchaseqty,
               'asdd_storeqty'=>$db_issueqty,
               'asdd_depissqty'=>$dep_issueqty,
              'asdd_disposalqty' => $disposal_qty, 
              'asdd_sales_amount'=> $scost,
              'asdd_sales_totalamt'=> $total_sales_amt,
              'asdd_remarks'=>!empty($remarks)?$remarks:'',
              'asdd_trandetailid'=>$mattransdetailid,
              'asdd_status'=>'O',
              'asdd_postdatead'=>CURDATE_EN,
              'asdd_postdatebs'=>CURDATE_NP,
              'asdd_posttime'=>$this->curtime,
              'asdd_postby'=>$this->userid,
              'asdd_postip'=>$this->ip,
              'asdd_postmac'=>$this->mac,
              'asdd_locationid'=>$this->locationid,
              'asdd_orgid'=>$this->orgid
            ); 

     if(!empty($disposalDetail)){  
        $this->db->insert('asdd_assetdesposaldetail',$disposalDetail);
        }

        if($rem_issue>0)
        {
            $issueqty=$db_issueqty;
            $this->update_trde_issue_qty(0,$data->trde_trdeid);
            $this->insert_into_disposal_detail_tbl($items_id,$rem_issue,$sales_cost,$desposalmasteid,$remarks);
        }
        else{
            if($rem_issue<=0)
            {
                $rem_issue=-($rem_issue);
                $issueqty=$rem_issue;
                $this->update_trde_issue_qty($rem_issue,$data->trde_trdeid);
                return $data->trde_trdeid;
            }
        }
    }

    }

public function update_trde_issue_qty($rem_qty, $trde_id){
        $update_array = array(
                        'trde_issueqty' => $rem_qty,
                        'trde_stripqty'=>$rem_qty,
                    );
        $this->general->save_log($this->tran_detailsTable,'trde_trdeid',$trde_id,$update_array,'Update');
        $this->db->update($this->tran_detailsTable,$update_array,array('trde_trdeid'=>$trde_id));
    }

    public function get_auction_disposal_summary_list($cond=false){

        $get = $_GET;
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

        }

        $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
        $range=!empty($get['range'])?$get['range']:'all';
        $search_text=!empty($get['search_text'])?$get['search_text']:'';
        $disposal_type=!empty($get['disposal_type'])?$get['disposal_type']:'';

        $this->db->start_cache();
        if($this->location_ismain == 'Y'){
            if($input_locationid)
            {
                $this->db->where('asde.asde_locationid',$input_locationid);
            }
        }
        else
        {
            $this->db->where('asde.asde_locationid',$this->locationid);
        }

        if($range == 'range'){
            if(!empty(($frmDate && $toDate))){
                if(DEFAULT_DATEPICKER == 'NP'){
                    $this->db->where('asde.asde_deposaldatebs >=',$frmDate);
                    $this->db->where('asde.asde_deposaldatebs <=',$toDate);    
                }else{
                    $this->db->where('asde.asde_desposaldatead >=',$frmDate);
                    $this->db->where('asde.asde_desposaldatead <=',$toDate);
                }
            }

        }

        if(!empty($disposal_type)){

            $this->db->where("asde.asde_desposaltypeid =",$disposal_type);

        }

        if(!empty($search_text)){

            $this->db->where("asde.asde_customer_name like '%$search_text%'")

            ->or_where("asde.asde_manualno like '%$search_text%'")

            ->or_where("asde.asde_disposalno like '%$search_text%'");

        }

        if(!empty($get['sSearch_1'])){

            $this->db->where("asde_desposaldatead like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("asde_deposaldatebs like  '%".$get['sSearch_2']."%'  ");

        }

        if(!empty($get['sSearch_3'])){

            $this->db->where("dety_name like  '%".$get['sSearch_3']."%'  ");

        }

        if(!empty($get['sSearch_4'])){

            $this->db->where("asde_disposalno like  '%".$get['sSearch_4']."%'  ");

        }

        if(!empty($get['sSearch_5'])){

            $this->db->where("asde_customer_name like  '%".$get['sSearch_5']."%'  ");

        }

        if(!empty($get['sSearch_6'])){

            $this->db->where("asdd_sales_totalamt like  '%".$get['sSearch_6']."%'  ");

        }

        if(!empty($get['sSearch_7'])){

            $this->db->where("asdd_sales_amount like  '%".$get['sSearch_7']."%'  ");

        }

        if($cond) {

          $this->db->where($cond);

        }

        $this->db->stop_cache();

        $resltrpt=$this->db->select("COUNT('*') as cnt")
                    ->from('asde_assetdesposalmaster asde')
                    ->join('asdd_assetdesposaldetail asdd','asdd.asdd_assetdesposalmasterid = asde.asde_assetdesposalmasterid','LEFT')
                    ->join('dety_desposaltype dety','dety.dety_detyid = asde.asde_desposaltypeid','LEFT')
                    ->group_by('asde_assetdesposalmasterid')
                    ->get()->result();

         $totalfilteredrecs=0;
         if(!empty($resltrpt)){
            $totalfilteredrecs=count($resltrpt);      
         }

        $order_by = 'asde_assetdesposalmasterid';
        $order = 'desc';

        if($this->input->get('sSortDir_0'))
        {
            $order = $this->input->get('sSortDir_0');
        }

        if($this->input->get('iSortCol_0')==1)
            $order_by = 'asde_desposaldatead';

        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'asde_deposaldatebs';

        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'asde_desposaltypeid';

        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'asde_disposalno';

        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'asde_customer_name';

        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'asdd.asdd_sales_totalamt';

        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'asdd.asdd_sales_amount';

        $totalrecs='';
        $limit = 15;
        $offset = 1;
        
        if(!empty($_GET["iDisplayLength"])){
           $limit = $_GET['iDisplayLength'];
           $offset = $_GET["iDisplayStart"];
        }

       $this->db->select("asde.*,SUM(asdd_sales_totalamt) as asdd_sales_totalamt ,SUM(asdd_sales_amount) as asdd_sales_amount,SUM(asdd_currentvalue) as asdd_currentvalue,SUM(asdd_sales_amount) as asdd_sales_amount,dety.dety_name,SUM(asdd_disposalqty) as item_count")
       ->from('asde_assetdesposalmaster asde')
       ->join('asdd_assetdesposaldetail asdd','asdd.asdd_assetdesposalmasterid = asde.asde_assetdesposalmasterid','LEFT')
       ->join('dety_desposaltype dety','dety.dety_detyid = asde.asde_desposaltypeid','LEFT');
         
        $this->db->order_by($order_by,$order);

        if($limit && $limit>0)

        {  
            $this->db->limit($limit);

        }

        if($offset)

        {

            $this->db->offset($offset); 

        }

        $this->db->group_by('asde_assetdesposalmasterid');
        $nquery=$this->db->get();
        $num_row=$nquery->num_rows();
        $this->db->flush_cache();

        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = count($nquery);
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

    public function get_action_disposal_detail_list($cond = false)

    { 

        $get = $_GET;

        $frmDate=$this->input->get('frmDate');

        $toDate=$this->input->get('toDate');

        $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

        $range=!empty($get['range'])?$get['range']:'all';

        $search_text=!empty($get['search_text'])?$get['search_text']:'';

        $disposal_type=!empty($get['disposal_type'])?$get['disposal_type']:'';

        $department_id=!empty($get['department_id'])?$get['department_id']:'';

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

        }

        $this->db->start_cache();

        if($this->location_ismain=='Y')
          {
            if($input_locationid)
            {
                $this->db->where('asde.asde_locationid',$input_locationid);
            }
        }
        else
        {
             $this->db->where('asde.asde_locationid',$this->locationid);
        }

        if($range == 'range'){

            if(!empty(($frmDate && $toDate))){
                if(DEFAULT_DATEPICKER == 'NP'){
                    $this->db->where('asde.asde_deposaldatebs >=',$frmDate);
                    $this->db->where('asde.asde_deposaldatebs <=',$toDate);    
                }else{
                    $this->db->where('asde.asde_desposaldatead >=',$frmDate);
                    $this->db->where('asde.asde_desposaldatead <=',$toDate);
                }
            }
        }

        if(!empty($disposal_type)){

            $this->db->where("asde.asde_desposaltypeid =",$disposal_type);

        }

        if(!empty($department_id)){

            $this->db->where("dept.dept_depid =",$department_id);

        }

        if(!empty($search_text)){

            $this->db->where("asde.asde_customer_name like '%$search_text%'")

            ->or_where("asde.asde_manualno like '%$search_text%'")

            ->or_where("asde.asde_disposalno like '%$search_text%'");

        }

        if(!empty($get['sSearch_1'])){

            $this->db->where("asde_desposaldatead like  '%".$get['sSearch_1']."%'  ");

        }
        if(!empty($get['sSearch_2'])){

            $this->db->where("asde_desposaldatebs like  '%".$get['sSearch_2']."%'  ");

        }
        if(!empty($get['sSearch_3'])){

            $this->db->where("dety_name like  '%".$get['sSearch_3']."%'  ");

        }

        if(!empty($get['sSearch_4'])){

            $this->db->where("itli_itemcode like  '%".$get['sSearch_4']."%'  ");

        } 
        if(!empty($get['sSearch_5'])){

            $this->db->where("itli_itemname like  '%".$get['sSearch_5']."%'  ");

        }

        if(!empty($get['sSearch_6'])){

            $this->db->where("asdd_purchaseqty like  '%".$get['sSearch_6']."%'  ");

        }

        if(!empty($get['sSearch_7'])){

            $this->db->where("asdd_disposalqty like  '%".$get['sSearch_7']."%'  ");

        }

        if(!empty($get['sSearch_8'])){

            $this->db->where("asdd.asdd_sales_amount like  '%".$get['sSearch_8']."%'  ");

        }

        if(!empty($get['sSearch_9'])){

            $this->db->where("asdd.asdd_remarks like  '%".$get['sSearch_9']."%'  ");

        }

        if($cond) {

        $this->db->where($cond);

        }

        $this->db->stop_cache();

        $resltrpt = $this->db->select("COUNT('asdd_asddid') as cnt")
                    ->from('asdd_assetdesposaldetail asdd')
                    ->join('asde_assetdesposalmaster  asde','asdd.asdd_assetdesposalmasterid = asde.asde_assetdesposalmasterid','LEFT')
                    ->join('dety_desposaltype dety','dety.dety_detyid = asde.asde_desposaltypeid','LEFT')
                    ->join('itli_itemslist il','asdd.asdd_assetid = il.itli_itemlistid','LEFT')
                    ->get()->row();

         $totalfilteredrecs=0;

         if(!empty($resltrpt)){

            $totalfilteredrecs=$resltrpt->cnt;      

         }

        $order_by = 'asde_assetdesposalmasterid';

        $order = 'desc';

        if($this->input->get('sSortDir_0')){

            $order = $this->input->get('sSortDir_0');

        }

        $where='';

        if($this->input->get('iSortCol_0')==1)

            $order_by = 'asde_desposaldatead';

        else if($this->input->get('iSortCol_0')==2)

            $order_by = 'asde_desposaldatebs';

        else if($this->input->get('iSortCol_0')==3)

            $order_by = 'dety_name';

        else if($this->input->get('iSortCol_0')==4)

            $order_by = 'itli_itemcode';

        else if($this->input->get('iSortCol_0')==5)

            $order_by = 'itli_itemname';

        else if($this->input->get('iSortCol_0')==6)

            $order_by = 'asdd_purchaseqty';         

        else if($this->input->get('iSortCol_0')==7)

            $order_by = 'asdd_disposalqty';

        else if($this->input->get('iSortCol_0')==8)

            $order_by = 'asdd_sales_amount';

        else if($this->input->get('iSortCol_0')==9)

            $order_by = 'asdd_remarks';

        $totalrecs='';

        $limit = 15;

        $offset = 1;

        if(!empty($_GET["iDisplayLength"])){

           $limit = $_GET['iDisplayLength'];

           $offset = $_GET["iDisplayStart"];

        }

       $this->db->select("asde.*,asdd.*,dety.dety_name,il.itli_itemcode,il.itli_itemname")
       ->from('asdd_assetdesposaldetail  asdd')
       ->join('asde_assetdesposalmaster asde','asdd.asdd_assetdesposalmasterid = asde.asde_assetdesposalmasterid','LEFT')
       ->join('dety_desposaltype dety','dety.dety_detyid = asde.asde_desposaltypeid','LEFT')
        ->join('itli_itemslist il','asdd.asdd_assetid = il.itli_itemlistid','LEFT');
        
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

        } else {

            $ndata=array();
            $ndata['totalrecs'] = 0;
            $ndata['totalfilteredrecs'] = 0;
        }

        $this->db->flush_cache();
        // echo $this->db->last_query();die();

      return $ndata; 

    }

    public function get_db_item_list_form_master_table($srch = false, $storeid = false)
    {
        $storeid = $storeid;
        $get     = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        $this->db->start_cache();
        if (!empty($get['sSearch_1'])) {
            $this->db->where("lower(itli_itemcode) like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {
            $this->db->where("lower(itli_itemname) like  '%" . $get['sSearch_2'] . "%'  ");
        }
        if (!empty($get['sSearch_3'])) {
            $this->db->where("lower(itli_itemnamenp) like  '%" . $get['sSearch_3'] . "%'  ");
        }
        if (!empty($get['sSearch_7'])) {
            $this->db->where("lower(ec.eqca_category) like  '%" . $get['sSearch_7'] . "%'  ");
        }

        $searchtext = !empty($get['searchtext']) ? trim($get['searchtext']) : '';
       
        if ($srch) {
            $this->db->where($srch); 
        }
        if (!empty($searchtext)) {
            $this->db->where("(lower(itli_itemcode) like  '%" . $searchtext . "%' OR lower(itli_itemname) like  '%" . $searchtext . "%' OR lower(itli_itemnamenp) like  '%" . $searchtext . "%' )");
        }
        $this->db->stop_cache();

        $resltrpt = $this->db->select("COUNT(trde_itemsid) as cnt")
            ->from('trma_transactionmain tm')
            ->join('trde_transactiondetail td', 'tm.trma_trmaid=td.trde_trmaid ', 'INNER')
            ->join('itli_itemslist il', 'il.itli_itemlistid=td.trde_itemsid', 'INNER')
            ->join('eqca_equipmentcategory eq', 'eq.eqca_equipmentcategoryid=il.itli_catid', 'LEFT')
            ->where(array('tm.trma_status !=' => 'M', 'td.trde_status !=' => 'M'))
            ->where(array('trde_issueqty >'=>'0'))
            ->group_by('td.trde_itemsid')
            ->get();

        $totalfilteredrecs = $resltrpt->num_rows();

        $order_by = 'il.itli_itemname';
        $order    = 'asc';
        if ($this->input->get('sSortDir_0')) {
            $order = $this->input->get('sSortDir_0');
        }

        if ($this->input->get('iSortCol_0') == 1) {
            $order_by = 'il.itli_itemcode';
        } else if ($this->input->get('iSortCol_0') == 2) {
            $order_by = 'il.itli_itemname';
        } else if ($this->input->get('iSortCol_0') == 3) {
            $order_by = 'il.itli_itemnamenp';
        } else if ($this->input->get('iSortCol_0') == 7) {
            $order_by = 'ec.eqca_category';
        }

        $totalrecs = '';
        $limit     = 0;
        $offset    = 0;

        if (!empty($_GET["iDisplayLength"])) {
            $limit  = $_GET['iDisplayLength'];
            $offset = $_GET["iDisplayStart"];
        }

        $this->db->select("td.trde_itemsid,il.itli_itemcode,itli_itemname,eqca_category,SUM(trde_requiredqty) as purqty ,(SUM(trde_requiredqty) - SUM(trde_issueqty )) as dep_issqty,SUM(trde_issueqty ) as remqty,itli_purchaserate as purrate,unit_unitname,unit_unitid,itli_materialtypeid");
        $this->db->from('trma_transactionmain tm');
        $this->db->join('trde_transactiondetail td', 'tm.trma_trmaid=td.trde_trmaid ', 'INNER');
        $this->db->join('itli_itemslist il', 'il.itli_itemlistid=td.trde_itemsid', 'INNER');
        $this->db->join('eqca_equipmentcategory eq', 'eq.eqca_equipmentcategoryid=il.itli_catid', 'LEFT');
        $this->db->join('unit_unit ut', 'ut.unit_unitid = il.itli_unitid', 'LEFT');
        $this->db->where(array('tm.trma_status !=' => 'M', 'td.trde_status !=' => 'M'));
        $this->db->where(array('trde_issueqty >'=>'0'));
      
        // if ($srch) {
        //     $this->db->where($srch);
        // }

        $this->db->order_by($order_by, $order);
        if ($limit && $limit > 0) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }
        $this->db->group_by('td.trde_itemsid');
        $nquery = $this->db->get();
        $this->db->flush_cache();

        $num_row = $nquery->num_rows();
        if (!empty($_GET['iDisplayLength']) && $num_row > 0) {
            $totalrecs = $num_row;
        }

        // echo $num_row;
        // die();

        if ($num_row > 0) {
            $ndata                      = $nquery->result();
            $ndata['totalrecs']         = $totalrecs;
            $ndata['totalfilteredrecs'] = $totalfilteredrecs;
        } else {
            $ndata                      = array();
            $ndata['totalrecs']         = 0;
            $ndata['totalfilteredrecs'] = 0;
        }

        // echo "<pre>";
        // print_r($ndata);
        // die();
        // echo $this->db->last_query();
        // die();
        return $ndata;
    }

    public function get_master_data_auction_disposal($srchcol){
        $this->db->select('asde_fiscalyrs,asde_desposaltypeid,
                            asde_disposalno,
                            asde_manualno,
                            asde_desposaldatead,
                            asde_deposaldatebs,
                            asde_customer_name,
                            asde_sale_taxper,
                            asde_remarks,
                            asde_status,
                            dety_name');
        $this->db->from('asde_assetdesposalmaster as adm');
        $this->db->join('dety_desposaltype as dp','dp.dety_detyid=adm.asde_desposaltypeid','LEFT');
        if(!empty($srchcol)){
        $this->db->where($srchcol);    
        }
        
        $result=$this->db->get()->result();
        if(!empty($result)){
            return $result;
        }
        return false; 
    }

    // public function get_detail_data_auction_disposal($srchcol){
    //     $this->db->select('SUM(asdd_purchaseqty) as purqty,SUM(asdd_storeqty) storeqty,
    //         SUM(asdd_depissqty) as depissqty,SUM(asdd_disposalqty) as disposalqty');
    //     $this->db->from('asdd_assetdesposaldetail as aad');
    //     $this->db->join('itli_itemslist as it','it.itli_itemlistid=aad.asdd_assetid','LEFT');
    //     if(!empty($srchcol)){
    //     $this->db->where($srchcol);    
    //     }
        
    //     $result=$this->db->get()->result();
    //     if(!empty($result)){
    //         return $result;
    //     }
    //     return false; 
    // }

}