<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stock_adjustment_mdl extends CI_Model
{
    public function __construct()
    {
    parent::__construct();
    $this->req_noteTable='reno_requisitionnote';
    $this->req_detailNoteTable='redt_reqdetailnote';
    $this->locationid=$this->session->userdata(LOCATION_ID);
    }
    public $validate_settings_stock_adjust = array(
        array('field' => 'stma_stockdate', 'label' => 'Adjustment Date', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'stma_counterid', 'label' => 'Store', 'rules' => 'trim|required|xss_clean'),
       array('field' => 'stma_remarks', 'label' => 'Adjustment Name', 'rules' => 'trim|required|xss_clean'),
        
    );
    public $validate_settings_details = array(
        // array('field' => 'reason', 'label' => 'Reason', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'itemid', 'label' => 'Item Names', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'amount', 'label' => 'Adjustment Amount', 'rules' => 'trim|required|xss_clean'),
        
    );
    public function stock_adjustment_save()
    {
        try{
            
            $id=$this->input->post('id');
            $stockdate=$this->input->post('stma_stockdate');
            if(DEFAULT_DATEPICKER=='NP')
            {
                $stockdateNp=$stockdate;
                $stockdateEn=$this->general->NepToEngDateConv($stockdate);
            }
            else
            {
                $stockdateEn=$stockdate;
                $stockdateNp=$this->general->EngToNepDateConv($stockdate);
            }
            $counterid=$this->input->post('stma_counterid');
            $remarks=$this->input->post('stma_remarks');


            $curtime=$this->general->get_currenttime();
            $userid=$this->session->userdata(USER_ID);
            $username=$this->session->userdata(USER_NAME);
            $mac=$this->general->get_Mac_Address();
            $ip=$this->general->get_real_ipaddr();

            $InsertArray=array(
                        'stma_stockdatead'=>$stockdateEn,
                        'stma_stockdatebs'=>$stockdateNp,
                        'stma_postdatead'=>CURDATE_EN,
                        'stma_postdatebs'=>CURDATE_NP,
                        'stma_posttime'=>$curtime,
                        'stma_postmac'=>$mac,
                        'stma_postip'=>$ip,
                        'stma_postby'=>$userid,
                        'stma_counterid'=>$counterid,
                        'stma_remarks'=>$remarks,
                        'stma_operator'=>$username,
                        'stma_locationid'=>$this->locationid
            );

             $UpdateArray=array(
                        'stma_stockdatead'=>$stockdateEn,
                        'stma_stockdatebs'=>$stockdateNp,
                        'stma_modifydatead'=>CURDATE_EN,
                        'stma_modifydatebs'=>CURDATE_NP,
                        'stma_modifytime'=>$curtime,
                        'stma_modifymac'=>$mac,
                        'stma_modifyip'=>$ip,
                        'stma_modifyby'=>$userid,
                        'stma_counterid'=>$counterid,
                        'stma_remarks'=>$remarks,
                        'stma_operator'=>$username
            );

            
                if($id)
                {
                    $this->db->update('stma_stockmaster',$UpdateArray);
                      $rowaffected=$this->db->affected_rows();
                      if($rowaffected)
                      {
                        
                        return $rowaffected;
                      }
                      return false;
                }
                else
                {
                $this->db->insert('stma_stockmaster',$InsertArray);
                $insertid=$this->db->insert_id();
                if($insertid)
                {
                    return $insertid;
                }
                return false; 
                }
                return false;
            }
        catch(Exception $e){
            throw $e;
        }
    }

    public function get_stock_adjustment_details_list($cond = false)
    {
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("stde_adjustdatebs like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("stde_adjustdatead like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("stma_remarks like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("stde_postby like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("stde_adjustamount like  '%".$get['sSearch_7']."%'  ");
        }
          if($cond) {
          $this->db->where($cond);
        }
      

        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('stde_postdatebs >=', $frmDate);
              $this->db->where('stde_postdatebs <=', $toDate);
            }
            else
            {
              $this->db->where('stde_postdatead >=', $frmDate);
              $this->db->where('stde_postdatead <=', $toDate);
            }
        }


        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('stde_stockdetail sd')
                    ->join('itli_itemslist il','il.itli_itemlistid = sd.stde_itemsid',"LEFT")
                   // ->where('sd.stde_stockmasterid',$cond)
                    ->get()->row();
        //echo $this->db->last_query();die(); 
        $totalfilteredrecs=($resltrpt->cnt); 
        $order_by = 'stde_stockdetailid';
        $order = 'desc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
  
        $where='';
        if($this->input->get('iSortCol_0')==2)
            $order_by = 'itli_itemname';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'stde_adjustdatebs';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'stde_adjustdatead';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'stma_remarks';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'stde_postby';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'stde_adjustamount';
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
        if(!empty($get['sSearch_2'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("stde_adjustdatebs like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("stde_adjustdatead like  '%".$get['sSearch_4']."%'  ");
        }if(!empty($get['sSearch_5'])){
            $this->db->where("stma_remarks like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("stde_postby like  '%".$get['sSearch_6']."%'  ");
        }
          if(!empty($get['sSearch_7'])){
            $this->db->where("stde_adjustamount like  '%".$get['sSearch_7']."%'  ");
        }

        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('stde_postdatebs >=', $frmDate);
              $this->db->where('stde_postdatebs <=', $toDate);
            }
            else
            {
              $this->db->where('stde_postdatead >=', $frmDate);
              $this->db->where('stde_postdatead <=', $toDate);
            }
        }
        

        $this->db->select('sd.*,il.itli_itemcode,il.itli_itemname,il.itli_itemnamenp');
        $this->db->from('stde_stockdetail sd');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = sd.stde_itemsid',"LEFT");
       // $this->db->where('sd.stde_stockmasterid', $cond);
       
        $this->db->order_by($order_by,$order);
      

        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }
           if($cond) {
          $this->db->where($cond);
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

    public function get_stock_adjustment_list($cond = false)
    {
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');
         $locationid=$this->input->get('locationid');
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        if(!empty($get['sSearch_1'])){
            $this->db->where("stma_stockdatebs like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("stma_stockdatead like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("stma_remarks like  '%".$get['sSearch_4']."%'  ");
        }
          if(!empty($get['sSearch_5'])){
            $this->db->where("stma_operator like  '%".$get['sSearch_5']."%'  ");
        }
       
          if($cond) {
          $this->db->where($cond);
        }
      
       if(!empty(($frmDate && $toDate)))
        {
            $this->db->where('stma_stockdatebs >=',$frmDate);
            $this->db->where('stma_stockdatebs <=',$toDate);
        }
        if(!empty($locationid)){
            $this->db->where('stma_locationid',$locationid);
        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('stma_stockmaster sm')
                    ->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=sm.stma_counterid')
                    ->get()->row();
        //echo $this->db->last_query();die(); 
        $totalfilteredrecs=($resltrpt->cnt); 
        $order_by = 'stma_stockmassterid';
        $order = 'desc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
  
        $where='';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'stma_stockdatebs';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'stma_stockdatead';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'eqty_equipmenttype';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'stma_remarks';
            else if($this->input->get('iSortCol_0')==5)
            $order_by = 'stma_operator';
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
            $this->db->where("stma_stockdatebs like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("stma_stockdatead like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("stma_remarks like  '%".$get['sSearch_4']."%'  ");
        }
          if(!empty($get['sSearch_5'])){
            $this->db->where("stma_operator like  '%".$get['sSearch_5']."%'  ");
        }
       
       if(!empty(($frmDate && $toDate)))
        {
            $this->db->where('stma_stockdatebs >=',$frmDate);
            $this->db->where('stma_stockdatebs <=',$toDate);
        }
          if(!empty($locationid)){
            $this->db->where('stma_locationid',$locationid);
        }

        if($cond) {
          $this->db->where($cond);
        }

        $this->db->select('*');
        $this->db->from('stma_stockmaster sm');
        $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=sm.stma_counterid');
       
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
    public function get_details_list($cond)
    {
        $this->db->select('sd.stde_controlno,sd.stde_expiredatebs,sd.stde_qty,sd.stde_rate,sd.stde_operator,sd.stde_adjustdatebs,sd.stde_adjustamount,il.itli_itemcode, il.itli_itemname');
        $this->db->from('stde_stockdetail sd');
        $this->db->join('stma_stockmaster sm','sm.stma_stockmassterid=sd.stde_stockmasterid');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = sd.stde_itemsid','LEFT');
            
        if($cond)
        {
          $this->db->where($cond);
        }
        $query = $this->db->get();
       // echo $this->db->last_query();die();
        if ($query->num_rows() > 0) 
        {
          $data=$query->result();   
          return $data;   
        }   
        return false;
    }
    public function stock_details_save()
    {
        try{
            $date = $this->input->post('adjustdate');
            if(DEFAULT_DATEPICKER=='NP')
            {
                $adjustdateNp=$date;
                $adjustdateEn=$this->general->NepToEngDateConv($date);
            }
            else
            {
                $adjustdateEn=$date;
                $adjustdateNp=$this->general->EngToNepDateConv($date);
            }
            $curtime=$this->general->get_currenttime();
            $userid=$this->session->userdata(USER_ID);
            $username=$this->session->userdata(USER_NAME);
            $mac=$this->general->get_Mac_Address();
            $ip=$this->general->get_real_ipaddr();
            $physical_stock = $this->input->post('physical_stock');
            $bookstock = $this->input->post('bookstock');
            $stock = $this->input->post('stock');
            $reason = $this->input->post('reason');
            $expire = $this->input->post('expire');
            $item_id = $this->input->post('item');
            $amount = $this->input->post('amount');
            $masterid = $this->input->post('stde_stockmasterid');
            $InsertArray=array(
                        'stde_stockmasterid'=>$masterid,
                        'stde_postdatead'=>CURDATE_EN,
                        'stde_postdatebs'=>CURDATE_NP,
                        'stde_posttime'=>$curtime,
                        'stde_postmac'=>$mac,
                        'stde_postip'=>$ip,
                        'stde_postby'=>$stock,
                        'stde_itemsid'=>$item_id,
                        'stde_remarks'=>$reason,
                        'stde_operator'=>$username,
                        'stde_expiredatebs'=>CURDATE_NP,
                        'stde_expiredatead'=>CURDATE_EN,
                        'stde_adjustamount'=>$amount,
                        'stde_adjustdatebs'=>$adjustdateNp,
                        'stde_adjustdatead'=>$adjustdateEn,
                        'stde_locationid'=>$this->locationid,
                       // 'stde_qty'=>$stock,
                        // stde_controlno
                        // stde_rate
                        // stde_mattransdetailid
                        // stde_salerate
            );
            $this->db->insert('stde_stockdetail',$InsertArray);
                $insertid=$this->db->insert_id();
                if($insertid)
                {
                    return $insertid;
                }
                return false; 
        }
        catch(Exception $e){
            throw $e;
        }
    }
}