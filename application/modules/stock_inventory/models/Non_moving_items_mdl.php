<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Non_moving_items_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();

        $this->curtime = $this->general->get_currenttime();
        $this->userid = $this->session->userdata(USER_ID);
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
	}
	public $validate_settings_distributors = array(               
        array('field' => 'dist_distributor', 'label' => 'Distributor Name', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'dist_phone1', 'label' => 'Phone 1', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'dist_email', 'label' => 'Email', 'rules' => 'trim|valid_email|xss_clean'),
        array('field' => 'dist_repemail', 'label' => 'Sales Resp. Email', 'rules' => 'trim|valid_email|xss_clean')
	);

	public function get_non_moving_items_list($cond = false)
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
        
        if($cond) {
            $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = CURDATE_NP;

        

        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('sm.sama_billdatebs >=', $frmDate);
              $this->db->where('sm.sama_billdatebs <=', $toDate);
            }
            else
            {
              $this->db->where('sm.sama_billdatead >=', $frmDate);
              $this->db->where('sm.sama_billdatead <=', $toDate);
            }
        }

        $this->db->select('sd.sade_itemsid');
        $this->db->from('sade_saledetail sd');
        $this->db->join('sama_salemaster sm','sm.sama_salemasterid = sd.sade_salemasterid','left');
        $this->db->where('sm.sama_st','n');
        $this->db->distinct();
        $sub_query = $this->db->get_compiled_select();

        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('itli_itemslist il')
                    ->join('trde_transactiondetail mtd','il.itli_itemlistid = mtd.trde_itemsid','left')
                    ->where("il.itli_itemlistid NOT IN ($sub_query)",NULL,FALSE)
                    ->group_by('il.itli_itemcode, il.itli_itemname')
                    ->having('sum(mtd.trde_issueqty) >', 0)
                    ->get()
                    ->result();

        $totalfilteredrecs=sizeof($resltrpt);  

        $order_by = 'itli_itemname';
        $order = 'asc';
  
      	$where='';
      	if($this->input->get('iSortCol_0')==1)
        	$order_by = 'itli_itemcode';
      	else if($this->input->get('iSortCol_0')==2)
       		$order_by = 'itli_itemname';
        
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
            // $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  ");
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
        }
       
        if($cond) {
          $this->db->where($cond);
        }

        $this->db->select('il.itli_itemcode as itemcode, il.itli_itemname as itemname,il.itli_itemnamenp as itemnamenp, sum(mtd.trde_issueqty) as stockqty, sum(mtd.trde_issueqty * mtd.trde_unitprice) as totalamount');
        $this->db->from('itli_itemslist il');
        $this->db->join('trde_transactiondetail mtd','il.itli_itemlistid = mtd.trde_itemsid','left');
        $this->db->where("il.itli_itemlistid NOT IN ($sub_query)",NULL,FALSE);
        $this->db->group_by('il.itli_itemcode, il.itli_itemname');
        $this->db->having('sum(mtd.trde_issueqty) >', 0);
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

    public function get_stock_check_by_id($srchcol = false){
        try{
            $this->db->select('mtm.trma_todepartmentid as todepartment, sum(mtd.trde_issueqty) as stockqty');
            $this->db->from('trma_transactionmain mtm');
            $this->db->join('trde_transactiondetail mtd','mtm.trma_trmaid = mtd.trde_trmaid');
            $this->db->where('mtm.trma_received','1');
            if($srchcol){
                $this->db->where($srchcol);
            }
            $this->db->group_by('mtm.trma_todepartmentid');
            $query = $this->db->get();

            if($query->num_rows() >0){
                $result = $query->result();
                return $result;
            }
        }catch(Exception $e){
            throw $e;
        }
    }
}