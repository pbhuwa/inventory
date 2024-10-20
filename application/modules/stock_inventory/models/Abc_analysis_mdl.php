<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Abc_analysis_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->curtime = $this->general->get_currenttime();
        $this->userid  = $this->session->userdata(USER_ID);
        $this->mac     = $this->general->get_Mac_Address();
        $this->ip      = $this->general->get_real_ipaddr();
        $this->locationid=$this->session->userdata(LOCATION_ID);
    }
    public $validate_settings_distributors = array(
        array(
            'field' => 'dist_distributor', 'label' => 'Distributor Name', 'rules' => 'trim|required|xss_clean'), 
        array('field' => 'dist_phone1', 'label' => 'Phone 1', 'rules' => 'trim|required|xss_clean'), 
        array('field' => 'dist_email', 'label' => 'Email', 'rules' => 'trim|valid_email|xss_clean'), 
        array('field' => 'dist_repemail', 'label' => 'Sales Resp. Email', 'rules' => 'trim|valid_email|xss_clean'));

    public $validate_settings_abc_analysis = array(
        array(
            'field' => 'consumptionA[]', 'label' => 'Consumption A ', 'rules' => 'trim|required|xss_clean'));


    public function get_abc_analysis_list($cond = false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

    if(!empty($get['sSearch_1'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
           $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("eqca_category like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("sade_qty like  '%".$get['sSearch_4']."%'  ");
        }
        
        if($cond) {
            $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = CURDATE_NP;
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

        $this->db->select('il.itli_itemlistid, SUM(sd.sade_qty) as issueqty, SUM(sd.sade_unitrate) as issunitprice, SUM(sd.sade_unitrate * sd.sade_qty) as totalamount, "" as retqty, "" as retunitprice, "" as rettoatalamount ');
        $this->db->from('sama_salemaster s');
        $this->db->join('sade_saledetail sd', 'sd.sade_salemasterid = s.sama_salemasterid');
        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = sd.sade_itemsid', "LEFT");
        $this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid = il.itli_catid',"LEFT");
        $this->db->where("sama_st !=",'C');
        $this->db->group_by('il.itli_itemlistid');
        if(!empty(($frmDate && $toDate)))
        {
            $this->db->where('s.sama_billdatebs >=',$frmDate);
            $this->db->where('s.sama_billdatebs <=',$toDate);
        }
          if(!empty($locationid))
        {
            $this->db->where('s.sama_locationid',$locationid);
            
        }
        $query1 = $this->db->get_compiled_select();

        $this->db->select('rd.rede_itemsid, ""  as issueqty, ""  as issunitprice, "" as isstotlamount, SUM(rd.rede_qty) as retqty,SUM(rd.rede_unitprice) as retunitprice, SUM(rd.rede_qty * rd.rede_unitprice) as rettoatalamount');
        $this->db->from('rema_returnmaster r');
        $this->db->join('rede_returndetail rd', 'rd.rede_returnmasterid = r.rema_returnmasterid');
        $this->db->group_by('rd.rede_itemsid');
        
        if(!empty(($frmDate && $toDate)))
        {
            $this->db->where('r.rema_returndatebs >=',$frmDate);
            $this->db->where('r.rema_returndatebs <=',$toDate);
        }
          if(!empty($locationid))
        {
            $this->db->where('r.rema_locationid',$locationid);
            
        }
        $query2 = $this->db->get_compiled_select();
        $this->db->set_dbprefix('');

        $resltrpt = $this->db->query("SELECT COUNT(*) as cnt from( SELECT X.* from ($query1 UNION $query2) X LEFT JOIN xw_itli_itemslist ilo on ilo.itli_itemlistid= X.itli_itemlistid LEFT JOIN xw_eqca_equipmentcategory eq  on eq.eqca_equipmentcategoryid = ilo.itli_catid GROUP BY X.itli_itemlistid,ilo.itli_itemcode,ilo.itli_itemname,eq.eqca_category) Y ")->row();
            
        $totalfilteredrecs=($resltrpt->cnt); 
        $order_by          = 'X.itli_itemlistid';
        $order             = 'asc';

        $where='';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'itli_itemcode';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'itli_itemname';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'eqca_category';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'sade_qty';
        
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
            $this->db->where("itli_itemcode like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
           $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("eqca_category like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("sade_qty like  '%".$get['sSearch_4']."%'  ");
        }
        $query = $this->db->query("SELECT X.itli_itemlistid, ilo.itli_itemcode,ilo.itli_itemname,ilo.itli_itemnamenp,eq.eqca_category ,SUM(issueqty-retqty) as total_issue_qty,SUM(totalamount-rettoatalamount) as TotalIsseAmt from ($query1 UNION $query2) X LEFT JOIN xw_itli_itemslist ilo on ilo.itli_itemlistid= X.itli_itemlistid LEFT JOIN xw_eqca_equipmentcategory eq  on eq.eqca_equipmentcategoryid = ilo.itli_catid GROUP BY X.itli_itemlistid,ilo.itli_itemcode,ilo.itli_itemname,eq.eqca_category LIMIT $limit OFFSET $offset");
       
        $nquery= $query;
        $this->db->set_dbprefix('xw_');
        //echo $this->db->last_query();die();
        $num_row = $nquery->num_rows($query);
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
    public function abc_analysis_save()
    {
        $postdata=$this->input->post();
        $consumptionA=$this->input->post('consumptionA');
        $revenueA=$this->input->post('revenueA');
        $id=$this->input->post('id');
        $abcUpdateArray=array();
        $this->db->trans_start();
        foreach ($id as $kd => $val) {
            $uid=!empty($id[$kd])?$id[$kd]:'';
            if(!empty($uid))
            {
                $abcUpdateArray[]=array(
                    'abse_abcsetupid'=>$id[$kd],
                    'abse_consumption'=>$consumptionA[$kd],
                    'abse_revenu'=>$revenueA[$kd],
                    'abse_modifydatead'=>CURDATE_EN,
                    'abse_modifydatebs'=>CURDATE_NP,
                    'abse_modifytime'=>date('H:i:s'),
                    'abse_modifyip'=>$this->general->get_real_ipaddr(),
                    'abse_modifymac'=>$this->general->get_Mac_Address(),
                );
            }
           $this->db->update_batch("abse_abcsetup",$abcUpdateArray,'abse_abcsetupid');  
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
                $this->db->trans_rollback();
                return false;
        }
        else
        {
                $this->db->trans_commit();
                return true;
        }
    }
}