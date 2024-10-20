<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Convert_items_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->curtime = $this->general->get_currenttime();
        $this->userid = $this->session->userdata(USER_ID);
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
    }

    public $validate_convert_items = array(
        array('field' => 'conv_factor', 'label' => 'Unit Factor', 'rules' => 'trim|numeric|greater_than[1]|required'),
    );

    public function get_parent_convert_items_list(){
        $get = $_GET;
 
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        
        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(conv_condatebs) like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(supp_suppliername) like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(quma_quotationdatebs) like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(quma_supplierquotationdatebs) like  '%".$get['sSearch_4']."%'  ");
        }
        
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(quma_supplierquotationnumber) like  '%".$get['sSearch_5']."%'  ");
        }
        
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(quma_totalamount) like  '%".$get['sSearch_6']."%'  ");
        }        
         
        $resltrpt=$this->db->select("COUNT(*) as cnt")
                        ->from('xw_conv_conversion c')
                        ->join('itli_itemslist il','c.conv_parentid = il.itli_itemlistid') 
                        ->get()
                        ->row();
        //$resltrpt=$this->db->query("SELECT COUNT(*) as cnt FROM xw_pudo_purchdonate  ")->row();
        // echo $this->db->last_query();die(); 
        $totalfilteredrecs=$resltrpt->cnt;

        $order_by = 'itli_itemname';
        $order = 'asc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
  
        $where='';
        // if($this->input->get('iSortCol_0')==0)
        //     $order_by = 'quma_quotationnumber';
        // else if($this->input->get('iSortCol_0')==1)
        //     $order_by = 'supp_suppliername';
        // else if($this->input->get('iSortCol_0')==2)
        //     $order_by = 'quma_quotationdatebs';
        // else if($this->input->get('iSortCol_0')==3)
        //     $order_by = 'quma_supplierquotationdatebs';
        // else if($this->input->get('iSortCol_0')==4)
        //     $order_by = 'quma_supplierquotationnumber';
        // else if($this->input->get('iSortCol_0')==5)
        //     $order_by = 'quma_totalamount';

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
            $this->db->where("lower(quma_quotationnumber) like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(supp_suppliername) like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(quma_quotationdatebs) like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(quma_supplierquotationdatebs) like  '%".$get['sSearch_4']."%'  ");
        }

        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(quma_supplierquotationnumber) like  '%".$get['sSearch_5']."%'  ");
        }

        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(quma_totalamount) like  '%".$get['sSearch_6']."%'  ");
        }

        $where = "";
        if(!empty(($this->input->get('frmDate') && $this->input->get('toDate'))))
        {
            $where ="quma_supplierquotationdatebs BETWEEN '".$get['frmDate']."' and '".$get['toDate']."'";
        }

        $this->db->select('c.conv_convid, il.itli_itemcode, il.itli_itemname, c.conv_parentqty, c.conv_parentrate, c.conv_condatebs, c.conv_username, (c.conv_parentqty * c.conv_parentrate) amount');
        $this->db->from('conv_conversion c');
        $this->db->join('itli_itemslist il','c.conv_parentid = il.itli_itemlistid');
        if($where){
            $this->db->where($where);   
        }       
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

        $num_row=$nquery->num_rows();
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

        // echo $this->db->last_query();
        // die();
        // echo "<pre>";
        // print_r($ndata);
        // die();
        
        return $ndata;
    }  

    public function get_child_convert_items_list($srchcol = false){
        $get = $_GET;
 
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        
        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(conv_condatebs) like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(supp_suppliername) like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(quma_quotationdatebs) like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(quma_supplierquotationdatebs) like  '%".$get['sSearch_4']."%'  ");
        }
        
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(quma_supplierquotationnumber) like  '%".$get['sSearch_5']."%'  ");
        }
        
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(quma_totalamount) like  '%".$get['sSearch_6']."%'  ");
        }        
         
        $resltrpt=$this->db->select("COUNT(*) as cnt")
                        ->from('xw_conv_conversion c')
                        ->join('itli_itemslist il','c.conv_childid = il.itli_itemlistid')
                        ->where($srchcol)
                        ->get()
                        ->row();
        //$resltrpt=$this->db->query("SELECT COUNT(*) as cnt FROM xw_pudo_purchdonate  ")->row();
        // echo $this->db->last_query();die(); 
        // $totalfilteredrecs=$resltrpt->cnt;

        $totalfilteredrecs = count($resltrpt);

        $order_by = 'itli_itemname';
        $order = 'asc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
  
        $where='';
        // if($this->input->get('iSortCol_0')==0)
        //     $order_by = 'quma_quotationnumber';
        // else if($this->input->get('iSortCol_0')==1)
        //     $order_by = 'supp_suppliername';
        // else if($this->input->get('iSortCol_0')==2)
        //     $order_by = 'quma_quotationdatebs';
        // else if($this->input->get('iSortCol_0')==3)
        //     $order_by = 'quma_supplierquotationdatebs';
        // else if($this->input->get('iSortCol_0')==4)
        //     $order_by = 'quma_supplierquotationnumber';
        // else if($this->input->get('iSortCol_0')==5)
        //     $order_by = 'quma_totalamount';

        $totalrecs='';
        $limit = 20;
        $offset = 0;
        $get = $_GET;
 
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
      
        if(!empty($_GET["iDisplayLength"])){
           $limit = $_GET['iDisplayLength'];
           $offset = $_GET["iDisplayStart"];
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(quma_quotationnumber) like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(supp_suppliername) like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(quma_quotationdatebs) like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(quma_supplierquotationdatebs) like  '%".$get['sSearch_4']."%'  ");
        }

        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(quma_supplierquotationnumber) like  '%".$get['sSearch_5']."%'  ");
        }

        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(quma_totalamount) like  '%".$get['sSearch_6']."%'  ");
        }

        $where = "";
        if(!empty(($this->input->get('frmDate') && $this->input->get('toDate'))))
        {
            $where ="quma_supplierquotationdatebs BETWEEN '".$get['frmDate']."' and '".$get['toDate']."'";
        }

        $this->db->select('il.itli_itemcode, il.itli_itemname, c.conv_childqty, c.conv_childrate, c.conv_factor, (c.conv_childqty * c.conv_childrate) amount');
        $this->db->from('conv_conversion c');
        $this->db->join('itli_itemslist il','c.conv_childid = il.itli_itemlistid');
        $this->db->where($srchcol);
        if($where){
            $this->db->where($where);   
        }       
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

        // echo $this->db->last_query();
        // die();

        $num_row=$nquery->num_rows();
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

        // echo "<pre>";
        // print_r($ndata);
        // die();
        //  echo $this->db->last_query();
        // die();
        
        return $ndata;
    }  

    public function get_convert_items(){

    }

    public function item_list_tbl($srch=false)
    {
      $get = $_GET;
            foreach ($get as $key => $value) {
              $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
            }
            if(!empty($get['sSearch_1'])){
                $this->db->where("il.itli_itemcode like  '%".$get['sSearch_1']."%'  ");
            }
            if(!empty($get['sSearch_2'])){
                $this->db->where("il.itli_itemname like  '%".$get['sSearch_2']."%'  ");
            }
            
          $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('trde_transactiondetail mtd')
                    ->join('trma_transactionmain mtm','mtm.trma_trmaid = mtd.trde_trmaid','LEFT')
                    ->join('itli_itemslist il','il.itli_itemlistid = mtd.trde_itemsid','LEFT')
                    ->join('unit_unit u','u.unit_unitid=il.itli_unitid','LEFT')

                    ->where('mtm.trma_received',1)
                    ->where('mtd.trde_issueqty >',0)
                    ->get()
                    ->row();
            

          // echo $this->db->last_query();die(); 
            $totalfilteredrecs=$resltrpt->cnt; 

            $order_by = 'il.itli_itemname';
            $order = 'ASC';
            if($this->input->get('sSortDir_0'))
          {
              $order = $this->input->get('sSortDir_0');
          }
      
            $where='';
            if($this->input->get('iSortCol_0')==1)
              $order_by = 'il.itli_itemcode';
            if($this->input->get('iSortCol_0')==2)
             $order_by = 'il.itli_itemname';
            
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
                $this->db->where("il.itli_itemcode like  '%".$get['sSearch_1']."%'  ");
            }
          if(!empty($get['sSearch_2'])){
                $this->db->where("il.itli_itemname like  '%".$get['sSearch_2']."%'  ");
            }
            
            $this->db->select('il.itli_itemlistid, il.itli_itemcode, il.itli_itemname, mtd.trde_trdeid, mtd.trde_selprice as salesrate, mtd.trde_issueqty, mtd.trde_supplierid, mtd.trde_supplierbillno, mtd.trde_unitprice, mtd.trde_mfgdatebs, mtd.trde_mfgdatead, ut.unit_unitname');
            $this->db->from('trde_transactiondetail mtd');
            $this->db->join('trma_transactionmain mtm','mtm.trma_trmaid = mtd.trde_trmaid','LEFT');
            $this->db->join('itli_itemslist il','il.itli_itemlistid = mtd.trde_itemsid','LEFT');
            $this->db->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT');

            $this->db->where('mtm.trma_received',1);
            $this->db->where('mtd.trde_issueqty >',0);

       

          $this->db->order_by($order_by,$order);
          if($limit && $limit>0)
          {  
              $this->db->limit($limit,$offset);
          }
        
          if($srch)
          {
            $this->db->where($srch);
          }
          
           $nquery=$this->db->get();
           // echo $this->db->last_query();
           // die();
           $num_row=$nquery->num_rows();
            if(!empty($_GET['iDisplayLength'])) {
              $totalrecs = sizeof( $nquery);
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

    public function save_convert_items(){
        try{
            $postdata = $this->input->post();

            // $mat_trans_detailid = $this->input->post('conv_parentmtdid');

            $mat_trans_detail = $this->general->get_tbl_data('*','trde_transactiondetail',array('trde_trdeid'=>$mat_trans_detailid));

            $mat_trans_master = $this->general->get_tbl_data('*','trma_transactionmain', array('trma_transactiontype'=>'CONVERSION'));


            $mat_trans_masterid = !empty($mat_trans_master[0]->trma_trmaid)?$mat_trans_master[0]->trma_trmaid:0;

            $itemsid = $this->input->post('conv_childid'); //itemsid
            $parentid = $this->input->post('conv_parentid');
            
            $req_qty = $this->input->post('conv_parentqty'); //req qty
            $childqty = $this->input->post('conv_childqty');

            $factor = $this->input->post('conv_factor');

            $parentmtdid = $this->input->post('conv_parentmtdid'); //mat_trans_detailid
            $childmtdid = $this->input->post('conv_childmtdid');

            $convdate = $this->input->post('conv_condate');

            if(DEFAULT_DATEPICKER == 'NP'){
                $convdatebs = $convdate;
                $convdatead = $this->general->NepToEngDateConv($convdate);
            }else{
                $convdatead = $convdate;
                $convdatebs = $this->general->EngToNepDateConv($convdate);
            }

            $supplierid = $this->input->post('supplierid');
            $supplierbillno = $this->input->post('supplierbillno');

            $selprice = $this->input->post('selprice');
            $unitprice = $this->input->post('unitprice');

            $mfgdatead = $this->input->post('mfgdatead');
            $mfgdatebs = $this->input->post('mfgdatebs');

            // $mtmid = $mat_trans_masterid;
            $mtdid = $parentmtdid;

            $this->db->trans_begin();

            $mat_trans_detail_array = array(
                        'trde_trmaid'=>$mat_trans_masterid,
                        'trde_transactiondatead'=>CURDATE_EN,
                        'trde_transactiondatebs'=>CURDATE_NP,
                        'trde_itemsid'=>$itemsid,
                        'trde_controlno'=>'',
                        'trde_mfgdatead'=>$mfgdatead,
                        'trde_mfgdatebs'=>$mfgdatebs,
                        'trde_expdatead'=>'',
                        'trde_expdatebs'=>'',
                        'trde_mtdid'=>$mtdid,
                        'trde_mtmid'=>$mat_trans_masterid,
                        'trde_requiredqty'=>$req_qty,
                        'trde_issueqty'=>$req_qty,
                        'trde_stripqty'=>0,
                        'trde_issueno'=>'',
                        'trde_transferqty'=>0,
                        'trde_status'=>'O',
                        'trde_sysdate'=>CURDATE_EN,
                        'trde_transactiontype'=>'CONVERSION',
                        'trde_unitprice'=> $unitprice/$factor,
                        'trde_selprice'=> $selprice/$factor,
                        'trde_supplierid'=>$supplierid,
                        'trde_supplierbillno'=>$supplierbillno,
                        'trde_transtime'=>$this->curtime,
                        'trde_unitvolume'=>0,
                        'trde_microunitid'=>0,
                        'trde_totalvalue'=>0,
                        'trde_postdatead'=>CURDATE_EN,
                        'trde_postdatebs'=>CURDATE_NP,
                        'trde_posttime'=>$this->curtime,
                        'trde_postby'=>$this->userid,
                        'trde_postip'=>$this->ip,
                        'trde_postmac'=>$this->mac
            );

            echo "<pre>";
            // print_r($mat_trans_detail);
            // echo "<pre>";
            print_r($mat_trans_master[0]->trma_trmaid);
            echo "<br/>";
            print_r($postdata);
            die();


            if($mat_trans_detail_array){
               // $this->db->insert('trde_transactiondetail',$mat_trans_detail_array);
            }

            $conversionArray = array(
                    'conv_parentid'=>$parentid,
                    'conv_childid'=>$itemsid,
                    'conv_factor'=>$factor,
                    'conv_parentqty'=>$req_qty,
                    'conv_childqty'=>$childqty,
                    'conv_parentrate'=>'',
                    'conv_childrate'=>'',
                    'conv_condatebs'=>$convdatebs,
                    'conv_convdatead'=>$convdatead,
                    'conv_parentmtdid'=>$parentmtdid,
                    'conv_childmtdid'=>$childmtdid,
                    'conv_departmentid'=>'',
                    'conv_postdatead'=>CURDATE_EN,
                    'conv_postdatebs'=>CURDATE_NP,
                    'conv_posttime'=>$this->curtime,
                    'conv_postby'=>$this->userid,
                    'conv_postip'=>$this->ip,
                    'conv_postmac'=>$this->mac
            );

            if($conversionArray){
               // $this->db->insert('conv_conversion',$conversionArray);
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