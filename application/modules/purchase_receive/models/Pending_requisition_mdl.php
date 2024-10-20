<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pending_requisition_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
	}
	public function get_pending_requision($cond = false)
	{
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
            $this->db->where("itli_itemcode like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("unit_unitname like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("purd_qty like  '%".$get['sSearch_6']."%'  ");
        }

        // if(!empty($get['sSearch_7'])){
        //     $this->db->where("redt_remaqty like  '%".$get['sSearch_7']."%'  ");
        // }

        if(!empty($get['sSearch_7'])){
            $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_7']."%'  ");
        }
        
        if($cond) {
            $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        if(!empty(($frmDate && $toDate)))
        {
            // $this->db->where('requ_requdatebs >=',$frmDate);
            // $this->db->where('requ_requdatebs <=',$toDate);
        }
        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('pure_purchaserequisition pr')
                    ->join('purd_purchasereqdetail re', 're.purd_reqid = pr.pure_purchasereqid', "LEFT")
                    ->join('itli_itemslist il', 'il.itli_itemlistid = re.purd_itemsid', "LEFT")
                    ->join('unit_unit u', 'u.unit_unitid = il.itli_unitid', "LEFT")
                    ->join('eqty_equipmenttype c', 'c.eqty_equipmenttypeid = il.itli_typeid', "LEFT")
                    //->where('re.requ_requfyear',"073/74")
                    ->where('pr.pure_isapproved','N')
                   // ->where('r.redt_remaqty > 0')
                    ->get()
                    ->row();

      	//echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = 'pure_reqdatebs';
      	$order = 'asc';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==1)
        	$order_by = 'pure_reqno';
      	else if($this->input->get('iSortCol_0')==2)
       		$order_by = 'pure_reqdatebs';
       	else if($this->input->get('iSortCol_0')==3)
      	 	$order_by = 'itli_itemcode';
      	else if($this->input->get('iSortCol_0')==4)
      	 	$order_by = 'itli_itemname';
      	else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'unit_unitname';
      	else if($this->input->get('iSortCol_0')==6)
      	 	$order_by = 'purd_qty';
        // else if($this->input->get('iSortCol_0')==7)
        //     $order_by = 'redt_remaqty';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'eqty_equipmenttype';
        
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
            $this->db->where("pure_reqno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("pure_reqdatebs like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("unit_unitname like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("purd_qty like  '%".$get['sSearch_6']."%'  ");
        }

       

        if(!empty($get['sSearch_7'])){
            $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_7']."%'  ");
        }
       
        if($cond) {
          $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        if(!empty(($frmDate && $toDate)))
        {
            // $this->db->where('requ_requdatebs >=',$frmDate);
            // $this->db->where('requ_requdatebs <=',$toDate);
        }
        $this->db->select('pr.*,il.*, re.purd_qty, u.unit_unitname, c.eqty_equipmenttype');
        $this->db->from('pure_purchaserequisition pr');
        $this->db->join('purd_purchasereqdetail re', 're.purd_reqid = pr.pure_purchasereqid', "LEFT");
        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = re.purd_itemsid', "LEFT");
        $this->db->join('unit_unit u', 'u.unit_unitid = il.itli_unitid', "LEFT");
        $this->db->join('eqty_equipmenttype c', 'c.eqty_equipmenttypeid = il.itli_typeid', "LEFT");
       // $this->db->where('re.requ_requfyear','073/74');
        $this->db->where('pr.pure_isapproved','N');
        //$this->db->where('r.redt_remaqty > 0');
        
        // if(!empty($order_by) && !empty($order)){
        //     $order_by = 'requ_requid';
        //     $order = 'desc';
        // }
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
	    //echo $this->db->last_query();die();
	   return $ndata;
	}
}