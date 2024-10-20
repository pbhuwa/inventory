<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receiver_wise_issue_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
	}
	public function get_receiver_wise_issue_lists($cond= false)
	{
		$get = $_GET;
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}

        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(itli_itemcode) like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(sama_receivedby) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(dept_depname) like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(unit_unitname) like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(issueqty) like  '%".$get['sSearch_6']."%'  ");
        }
        // if(!empty($get['sSearch_7'])){
        //     $this->db->where("atstock like  '%".$get['sSearch_7']."%'  ");
        // }
        // if(!empty($get['sSearch_8'])){
        //     $this->db->where("trde_unitprice like  '%".$get['sSearch_8']."%'  ");
        // }
        // if(!empty($get['sSearch_9'])){
        //     $this->db->where("unit_unitname like  '%".$get['sSearch_9']."%'  ");
        // }
        
        if($cond) {
            $this->db->where($cond);
        }
        $frmDate = !empty($get['FrmDate'])?$get['FrmDate']:$this->input->post('FrmDate');
        $toDate = !empty($get['ToDate'])?$get['ToDate']:$this->input->post('ToDate');
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
       
        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        $depid = !empty($get['depid'])?$get['depid']:$this->input->post('depid');
        $catid = !empty($get['catid'])?$get['catid']:$this->input->post('catid');
        $maty_materialtypeid = !empty($get['maty_materialtypeid'])?$get['maty_materialtypeid']:$this->input->post('maty_materialtypeid');
        $cond = '';
        if(!empty(($store_id)))
        {  
           $cond = (" AND sm.sama_storeid = $store_id");
        }
        if(!empty($depid)){
            $cond = (" AND sm.sama_depid =$depid");
        }
        if(!empty($maty_materialtypeid)){
            $cond = (" AND it.itli_materialtypeid = $maty_materialtypeid");
        }
        if(!empty($catid)){
            $cond = (" AND sm.sama_storeid = $catid");
        }
         if(!empty($locationid)){
            $cond = (" AND sm.sama_locationid = $locationid");
        }
	    $sql ="SELECT
					COUNT(*) AS cnt
				FROM
					(
				SELECT
					itli_itemlistid,
					itli_itemcode,
					itli_itemname,
					unit_unitname,
					SUM(qty) AS issueqty,
					dept_depname,
					sama_receivedby
				FROM
					(
						SELECT
							mt.maty_material,
							eq.eqty_equipmenttype,
							sm.sama_soldby,
							sm.sama_receivedby,
							sm.sama_requisitionno,
							it.itli_itemlistid,
							it.itli_itemname,
							sm.sama_storeid,
							u.unit_unitname,
							sm.sama_depid,
							it.itli_itemcode,
							it.itli_catid,
							SUM(sd.sade_qty) AS qty,
							d.dept_depname,
							d.dept_depcode
						FROM
							xw_sama_salemaster sm
						LEFT JOIN xw_sade_saledetail sd ON sd.sade_salemasterid = sm.sama_salemasterid
						LEFT JOIN xw_itli_itemslist it ON it.itli_itemlistid = sd.sade_itemsid
						LEFT JOIN xw_maty_materialtype mt ON mt.maty_materialtypeid = it.itli_materialtypeid
						LEFT JOIN xw_unit_unit u ON u.unit_unitid = it.itli_unitid
						INNER JOIN xw_dept_department d ON d.dept_depid = sm.sama_depid
						LEFT JOIN xw_eqty_equipmenttype eq ON eq.eqty_equipmenttypeid = sm.sama_storeid
						WHERE
							sm.sama_st = 'N' AND sm.sama_billdatebs BETWEEN '$frmDate' AND '$toDate' AND itli_itemlistid IS NOT NULL  $cond
						GROUP BY
							d.dept_depname,
							sm.sama_storeid,
							eq.eqty_equipmenttype,
							sm.sama_soldby,
							sm.sama_receivedby,
							sm.sama_requisitionno,
							it.itli_itemlistid,
							it.itli_itemname,
							it.itli_itemcode,
							u.unit_unitname,
							sm.sama_depid
					) p
				GROUP BY
					p.itli_itemlistid,
					p.itli_itemcode,
					p.itli_itemname,
					p.unit_unitname,
					p.dept_depname,
					p.sama_receivedby
				ORDER BY
					p.itli_itemname
				) as k";

            $query=$this->db->query($sql);
	        if($query->num_rows() > 0) 
	        {
	            $data=$query->row();     
	            $totalfilteredrecs=  $data->cnt;       
	        } 
        //echo $this->db->last_query();die(); 
      	//$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = '';
      	$order = 'asc';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==1)
        	$order_by = 'itli_itemcode';
      	else if($this->input->get('iSortCol_0')==2)
       		$order_by = 'itli_itemname';
       	else if($this->input->get('iSortCol_0')==3)
      	 	$order_by = 'sama_receivedby';
      	else if($this->input->get('iSortCol_0')==4)
      	 	$order_by = 'dept_depname';
      	else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'unit_unitname';
      	else if($this->input->get('iSortCol_0')==6)
      	 	$order_by = 'issueqty';
        // else if($this->input->get('iSortCol_0')==7)
        //     $order_by = 'atstock';
        // else if($this->input->get('iSortCol_0')==8)
        //     $order_by = 'trde_unitprice';
        // else if($this->input->get('iSortCol_0')==9)
        //     $order_by = 'unit_unitname';
        
      	$totalrecs='';
      	$limit = 15;
      	$offset = 1;
      	$get = $_GET;
 
	    foreach ($get as $key => $value) {
	        $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
	    }
      
        if(!empty($_GET["iDisplayLength"])){
           $limit = $_GET['iDisplayLength'];
           if($limit < 0){
           	$limit = $totalfilteredrecs;
           }
           $offset = $_GET["iDisplayStart"];
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(itli_itemcode) like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(sama_receivedby) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(dept_depname) like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(unit_unitname) like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(issueqty) like  '%".$get['sSearch_6']."%'  ");
        }

        // if(!empty($get['sSearch_7'])){
        //     $this->db->where("atstock like  '%".$get['sSearch_7']."%'  ");
        // }
        // if(!empty($get['sSearch_8'])){
        //     $this->db->where("trde_unitprice like  '%".$get['sSearch_8']."%'  ");
        // }

        // if(!empty($get['sSearch_9'])){
        //     $this->db->where("unit_unitname like  '%".$get['sSearch_9']."%'  ");
        // }
       
	        // if($cond) {
	        //   $this->db->where($cond);
	        // }

        	// $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
	        // $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

	        // $supplier = !empty($get['supplier'])?$get['supplier']:$this->input->post('supplier');
	        
	        // $items = !empty($get['items'])?$get['items']:$this->input->post('items');

	        // if(!empty(($store_id)))
	        // {  
	        //    $this->db->where('c.eqca_equiptypeid',$store_id);
	           
	        // }

	        // if(!empty($supplier)){
	        //     $this->db->where('supp_supplierid',$supplier);
	        // }

	        // if(!empty($items)){
	        //     $this->db->where('itli_itemlistid',$items);
	        // }
        $sql1 ="SELECT
					itli_itemlistid,
					itli_itemcode,
					itli_itemname,
					unit_unitname,
					SUM(qty) AS issueqty,
					dept_depname,
					sama_receivedby
				FROM
					(
						SELECT
							sm.sama_storeid,
							eq.eqty_equipmenttype,
							sm.sama_depid,
							d.dept_depname,
							sm.sama_soldby,
							sm.sama_receivedby,
							sm.sama_requisitionno,
							it.itli_itemlistid,
							it.itli_itemname,
							u.unit_unitname,
							mt.maty_materialtypeid,
							it.itli_itemcode,
							it.itli_catid,
							ec.eqca_category,
							SUM(sd.sade_qty) AS qty
						FROM
							xw_sama_salemaster sm
						LEFT JOIN xw_sade_saledetail sd ON sd.sade_salemasterid = sm.sama_salemasterid
						LEFT JOIN xw_itli_itemslist it ON it.itli_itemlistid = sd.sade_itemsid
						LEFT JOIN xw_maty_materialtype mt ON mt.maty_materialtypeid = it.itli_materialtypeid
						LEFT JOIN xw_unit_unit u ON u.unit_unitid = it.itli_unitid
						INNER JOIN xw_dept_department d ON d.dept_depid = sm.sama_depid
						LEFT JOIN xw_eqty_equipmenttype eq ON eq.eqty_equipmenttypeid = sm.sama_storeid
						LEFT JOIN xw_eqca_equipmentcategory ec on ec.eqca_equipmentcategoryid = it.itli_catid
						WHERE
							sm.sama_st = 'N' AND sm.sama_billdatebs BETWEEN '$frmDate' AND '$toDate' $cond
						GROUP BY
							sm.sama_storeid,
							eq.eqty_equipmenttype,
							sm.sama_depid,
							d.dept_depname,
							sm.sama_soldby,
							sm.sama_receivedby,
							sm.sama_requisitionno,
							it.itli_itemlistid,
							it.itli_itemcode,
							it.itli_itemname,
							u.unit_unitname,
							it.itli_catid,
							ec.eqca_category
					) p
				GROUP BY
					p.itli_itemlistid,
					p.itli_itemcode,
					p.itli_itemname,
					p.unit_unitname,
					p.dept_depname,
					p.sama_receivedby
				ORDER BY
					p.itli_itemname LIMIT $limit OFFSET $offset
				";
		$nquery=$this->db->query($sql1);
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
	   // echo $this->db->last_query();die();
	   return $ndata;
	}
	// public function get_category_wise_report($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	// {
	// 	$fromdate = $this->input->post('fromdate');
 //        $todate = $this->input->post('todate');

 //        $this->db->select('p.*, bm.bmin_equipmentkey, rsk.riva_risk, d.dept_depname');
	// 	$this->db->from('pmta_pmtable p');
	// 	$this->db->join('bmin_bmeinventory bm', 'bm.bmin_equipid = p.pmta_equipid');
	// 	$this->db->join('riva_riskvalues rsk', 'rsk.riva_riskid = bm.bmin_riskid', "LEFT");
	// 	$this->db->join('dept_department d', 'd.dept_depid  = bm.bmin_departmentid', "LEFT");

	// 	if($fromdate &&  $todate){
	//         if(DEFAULT_DATEPICKER=='NP')
	//         {
	//           $this->db->where('pmta_pmdatebs >=', $fromdate);
	//           $this->db->where('pmta_pmdatebs <=', $todate);
	//         }
	//         else
	//         {
	//           $this->db->where('pmta_pmdatead >=', $fromdate);
	//           $this->db->where('pmta_pmdatead <=', $todate);
	//         }
	//     }
 //        if($srchcol)
 //        {
 //         	$this->db->where($srchcol); 
 //        }
	// 	$query = $this->db->get();
	// 	//echo $this->db->last_query();die();
	// 	if ($query->num_rows() > 0) 
	// 	{
	// 		$data=$query->result();		
	// 		return $data;		
	// 	}		
	// 	return false;
	// }

	// public function get_received_data()
	// {
	// 	$sql ="";
	// 	$query = $this->db->get();
	// 	if ($query->num_rows() > 0) 
	// 	{
	// 		$data=$query->result();		
	// 		return $data;		
	// 	}		
	// 	return false;
	// }
}