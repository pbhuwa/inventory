
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Department_issue_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
	}

	public function department_issue_report($itemsid,$depid,$fromdate=false,$todate=false)
	{
		$sql="SELECT x.itemsid,il.itli_itemcode,il.itli_itemname, depid,sum(isuqty) as issueqty,sum(isuamt) as isuamt,sum(retqty) as retqty, sum(retamt) as retamt,sum(isuqty+mtqty-retqty) totissueqty,
		sum((isuamt-retamt)/2) avgrate, sum(isuamt+mtamt-retamt) as amount
		 from(
		select sd.sade_itemsid  as itemsid,sm.sama_depid as depid,sum(sd.sade_qty) isuqty,
		sum(sd.sade_qty*sd.sade_unitrate) isuamt,0 retqty,0 retamt,0 mtqty,0 mtamt
		 from xw_sama_salemaster sm left join xw_sade_saledetail sd on sd.sade_salemasterid=sm.sama_salemasterid
		where sm.sama_billdatebs between '2074/04/02' and '2074/12/25'
		AND sd.sade_itemsid='$itemsid'
		AND sm.sama_depid='$depid'
		and sm.sama_st='N' group by sd.sade_itemsid,sm.sama_depid
		union
		select rd.rede_itemsid  as itemsid,rm.rema_depid as depid,0 isuqty,0 isuamt,sum(rd.rede_qty) retqty,sum(rd.rede_qty*rd.rede_unitprice)retqmt ,0 mtqty,0 mtamt from xw_rema_returnmaster rm 
		left join xw_rede_returndetail rd on rd.rede_returnmasterid=rm.rema_returnmasterid
		where rm.rema_returndatebs between '2074/04/02' and '2074/12/25'
		AND rm.rema_depid='$depid'
		AND rd.rede_itemsid ='$itemsid'
		and rm.rema_st='N'
		group by rd.rede_itemsid,rm.rema_depid
		union
		select mtd.trde_itemsid as itemsid,mtm.trma_fromdepartmentid as depid,0 isuqty,0 isuamt,0 retqty,0 retamt, sum(mtd.trde_requiredqty) mtqty,sum(mtd.trde_requiredqty*mtd.trde_unitprice) mtamt  from xw_trde_transactiondetail mtd left join xw_trma_transactionmain mtm on mtm.trma_trmaid=mtd.trde_trmaid
		where mtd.trde_transactiontype='issue' and mtm.trma_transactiondatebs between '2074/04/02' and '2074/12/25' and mtm.trma_fromdepartmentid='$depid'
		AND mtd.trde_itemsid ='$itemsid'
		and mtm.trma_status='O' group by mtd.trde_itemsid,mtm.trma_fromdepartmentid
		)
		x left join xw_itli_itemslist il on il.itli_itemlistid=x.itemsid WHERE x.itemsid=$itemsid and depid=$depid
		  group by x.itemsid, il.itli_itemcode,il.itli_itemname, depid";

		$query=$this->db->query($sql);
		//echo $this->db->last_query();
		if($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;

	}
	
	
    public function get_department_wise_lists($deptquery)
    {
    	$get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        $whr='';

        if(!empty($get['sSearch_1'])){
          
            $whr .=" AND  itli_itemcode like  '%".$get['sSearch_1']."%' "; 
        }
        if(!empty($get['sSearch_2'])){
            
              $whr .=" AND itli_itemname like  '%".$get['sSearch_2']."%'  "; 
        }

        $frmdate=$this->input->get('frmDate')?$this->input->get('frmDate'):CURMONTH_DAY1;
	  	$todate=$this->input->get('toDate')?$this->input->get('toDate'):DISPLAY_DATE;
	  	$locationid=$this->input->get('locationid')?$this->input->get('locationid'):0;
	  	$storeid=$this->input->get('store_id')?$this->input->get('store_id'):0;

        if($storeid == 0){
            $where_store = "";
        }else{
            $where_store = "AND storeid = $storeid";
        }

        if($locationid == 0){
            $where_location = "";
        }else{
            $where_location = "AND sade_locationid = $locationid";
        }
        	
        //print_r($billdate);die;
        $sql ="SELECT COUNT('*') as cnt FROM(SELECT sade_itemsid from xw_vw_depwiseitemissue WHERE billdate between '".$frmdate."' AND '".$todate."' $where_location $where_store  GROUP BY sade_itemsid) X";
        $query=$this->db->query($sql);
        //echo $this->db->last_query();die();
        if($query->num_rows() > 0) 
        {
            $data=$query->row();     
            $totalfilteredrecs=  $data->cnt;       
        }
        $order_by = 'itli_itemname';
        $order = 'asc';
        // if($this->input->get('sSortDir_0'))
        // {
        //         $order = $this->input->get('sSortDir_0');
        // }
  
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
          
            $whr .=" AND  itli_itemcode like  '%".$get['sSearch_1']."%' "; 
        }
        if(!empty($get['sSearch_2'])){
            
              $whr .=" AND itli_itemname like  '%".$get['sSearch_2']."%'  "; 
        }

        if($storeid == 0){
            $where_store = "";
        }else{
            $where_store = "AND storeid = $storeid";
        }

        if($locationid == 0){
            $where_location = "";
        }else{
            $where_location = "AND sade_locationid = $locationid";
        }

        $sql1 ="SELECT
					x.sade_itemsid,
					il.itli_itemcode,
					il.itli_itemname,x.sade_locationid,x.storeid,
					$deptquery
					from xw_vw_depwiseitemissue x
				LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = x.sade_itemsid
				  WHERE sade_itemsid IS NOT NULL $where_location $where_store  AND billdate between '".$frmdate."' AND '".$todate."' $whr
				GROUP BY
					sade_itemsid LIMIT $limit OFFSET $offset";
        $nquery=$this->db->query($sql1);
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
    public function distinct_department()
    {
        $fromdate= $this->input->post('fromDate');
        $todate=  $this->input->post('toDate');
        $items_id =$this->input->post('id');
        $locationid = $this->input->post('location');
        $store = $this->input->post('store_id');
        //echo"<pre>"; print_r($this->input->post());die;
        $src ='';
        if($items_id)
        {
            $src.=" AND vp.sade_itemsid = $items_id";
        }
        if($store)
        {
            $src.=" AND vp.storeid = $store";
        } 
        if($locationid)
        {
            $src.=" AND vp.sade_locationid = $locationid";
        }
        //print_r($src);die;
            $sql="SELECT x.salemasterid,dp.dept_depname,x.sama_depid from
                (
                SELECT
                    vp.sama_depid,vp.sade_itemsid,vp.salemasterid
                FROM
                    xw_vw_depwiseitemissue vp
                WHERE
                    `vp`.`billdate` BETWEEN '$fromdate'
                AND  '$todate' $src
                GROUP BY vp.sama_depid
                ) AS x LEFT JOIN `xw_dept_department` `dp` ON `dp`.`dept_depid` = `x`.`sama_depid`";
            $query=$this->db->query($sql);
        //echo $this->db->last_query();die;
        if($query->num_rows() > 0) 
        {
            $data=$query->result();     
            return $data;       
        }       
        return false;
    }
    public function get_department_wise_issue($srch=false,$cond=false)
    {
        $fromdate= $this->input->post('fromDate');
        $todate=  $this->input->post('toDate');
        $itemsid =$this->input->post('id');
        $location = $this->input->post('location');
        $this->db->select('sama_billdatebs,sama_billdatead,sm.sama_soldby,sm.sama_username,sm.sama_billno,sm.sama_invoiceno,sm.sama_fyear,sm.sama_receivedby,sd.sade_curqty,sd.sade_unitrate,sd.sade_unitrate,it.itli_itemcode,it.itli_itemname');
        $this->db->from('sade_saledetail sd');
        $this->db->join('sama_salemaster sm','sm.sama_salemasterid =sd.sade_salemasterid','LEFT');
        $this->db->join('itli_itemslist it','it.itli_itemlistid = sd.sade_itemsid','LEFT');
        $this->db->join('unit_unit ut','it.itli_unitid = ut.unit_unitid','LEFT');
        if($fromdate &&  $todate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('sm.sama_billdatebs >=', $fromdate);
              $this->db->where('sm.sama_billdatebs <=', $todate);
            }
            else
            {
              $this->db->where('sm.sama_billdate >=', $fromdate);
              $this->db->where('sm.sama_billdate <=', $todate);
            }
        }
        if($location)
        {
            $this->db->where('sm.sama_locationid',$location);
        }else{
                $this->db->where('sm.sama_locationid',LOCATION_ID);
        }
        // if($itemsid)
        // {
        //     $this->db->where('sd.sade_itemsid',$itemsid);
        // }
        if($srch){
            $this->db->where($srch);
        }
        if($cond){
            $this->db->where($cond);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
        return false;
    }
    public function get_department_wise_issue_details($srch=false)
    {
        $fromdate= $this->input->post('fromDate');
        $todate=  $this->input->post('toDate');
        $itemsid =$this->input->post('id');
        $location = $this->input->post('location');
        $this->db->select('sd.*,it.itli_itemcode,it.itli_itemname');
        $this->db->from('sade_saledetail sd');
        $this->db->join('itli_itemslist it','it.itli_itemlistid = sd.sade_itemsid','LEFT');
        $this->db->join('unit_unit ut','it.itli_unitid = ut.unit_unitid','LEFT');
        if($srch){
            $this->db->where($srch);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
        return false;
    }
}