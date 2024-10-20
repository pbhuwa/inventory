
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Transfer_analysis_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
	}
	public function summary($srchcol=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid=$this->input->post('locationid');
		$sql = "SELECT mt.trma_trmaid,eq.eqty_equipmenttype,
				mt.trma_transactiondatebs as issuedate,
				mt.trma_issueno,
				(
				SELECT
					SUM(
						md.trde_requiredqty * md.trde_unitprice	
						)
					FROM
						xw_trde_transactiondetail md
					WHERE
						md.trde_trmaid = mt.trma_trmaid
				) AS billamt,
				mt.trma_reqno,
				mt.trma_receivedby
			FROM
				xw_trma_transactionmain mt
				LEFT JOIN `xw_eqty_equipmenttype` `eq` ON `eq`.`eqty_equipmenttypeid` = `mt`.`trma_fromdepartmentid`
			WHERE
				mt.trma_transactiondatebs BETWEEN '$fromdate'
			AND '$todate' $srchcol AND mt.trma_transactiontype = 'ISSUE'";
		$query = $this->db->query($sql);
		// echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}

	public function get_summaries_wise_search($cond=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
       $locationid = $this->input->post('locationid');
        // 		echo "dfsdf";
	      	// print_r($locationid);
	      	// die();
        
		$sql = "SELECT 
				trde_itemsid,itli_itemname,itli_itemcode,trma_transactiondatebs,
				SUM(qty) qty,SUM(rate) rate,SUM(amount) totalamt
				FROM
				(
				SELECT
					`mt`.`trma_transactiondatebs`,
					`md`.`trde_itemsid`,
					`il`.`itli_itemname`,
					`il`.`itli_itemcode`,
					`md`.`trde_requiredqty` as qty,
					`md`.`trde_unitprice` as rate,
					(
						md.trde_requiredqty * md.trde_unitprice
					) AS amount,
					`mt`.`trma_receivedby`
				FROM
					`xw_trma_transactionmain` `mt`
				LEFT JOIN `xw_trde_transactiondetail` `md` ON `md`.`trde_trmaid` = `mt`.`trma_trmaid`
				LEFT JOIN `xw_itli_itemslist` `il` ON `il`.`itli_itemlistid` = `md`.`trde_itemsid`
				WHERE
					`mt`.`trma_transactiontype` = 'ISSUE'
				AND `mt`.`trma_fromdepartmentid` = '1'
				AND mt.trma_transactiondatebs BETWEEN '$fromdate'
				AND '$todate'   $cond
				) x
				GROUP BY
				trde_itemsid,
				itli_itemname,
				itli_itemcode";
		$query = $this->db->query($sql);
		// echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
				
	}
	public function get_items_only($cond=false)
	{ 	
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid = $this->input->post('locationid');
		$sql = "SELECT DISTINCT
					(trma_issueno) AS issueno, requisitionno,trma_receiveddatebs,trma_receivedby
				FROM
					(
						SELECT
							`mt`.`trma_issueno`,
							`mt`.`trma_reqno` AS `requisitionno`,
							`mt`.`trma_receiveddatebs`,
							`eq`.`eqty_equipmenttype`,
							`il`.`itli_itemname`,
							`il`.`itli_itemcode`,
							`md`.`trde_requiredqty`,
							`md`.`trde_unitprice`,
							`md`.`trde_controlno` AS `batchno`,
							`mt`.`trma_receivedby`
						FROM
							`xw_trma_transactionmain` `mt`
						LEFT JOIN `xw_trde_transactiondetail` `md` ON `md`.`trde_trmaid` = `mt`.`trma_trmaid`
						LEFT JOIN `xw_itli_itemslist` `il` ON `il`.`itli_itemlistid` = `md`.`trde_itemsid`
						LEFT JOIN `xw_eqty_equipmenttype` `eq` ON `eq`.`eqty_equipmenttypeid` = `mt`.`trma_fromdepartmentid`
						WHERE
							`mt`.`trma_fromdepartmentid` <> 'mt.trma_todepartmentid'
						AND `mt`.`trma_transactiontype` = 'ISSUE'
						AND `mt`.`trma_todepartmentid` = '2'
						AND `mt`.`trma_receiveddatebs` >= '$fromdate'
						AND `mt`.`trma_receiveddatebs` <= '$todate'
						AND `mt`.`trma_locationid` = '$locationid' $cond
					) x";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
		
	}
	public function get_item_wise_search($srchcol=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid=$this->input->post('locationid');

		$this->db->select('mt.trma_transactiondatebs,md.trde_itemsid,il.itli_itemname,il.itli_itemcode, md.trde_requiredqty, md.trde_unitprice, (md.trde_requiredqty * md.trde_unitprice) as amount,mt.trma_receivedby');
			$this->db->from('trma_transactionmain mt');
	    	$this->db->join('trde_transactiondetail md','md.trde_trmaid = mt.trma_trmaid','LEFT');
	    	$this->db->join('itli_itemslist il','il.itli_itemlistid = md.trde_itemsid','LEFT');
			$this->db->where('mt.trma_transactiontype', 'ISSUE');
		
	    if($srchcol)
	    {
	      $this->db->where($srchcol);
	    }
	    if($fromdate &&  $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          $this->db->where('mt.trma_transactiondatebs >=', $fromdate);
	          $this->db->where('mt.trma_transactiondatebs <=', $todate);
	        }
	        else
	        {
	          $this->db->where('mt.trma_transactiondatead >=', $fromdate);
	          $this->db->where('mt.trma_transactiondatead <=', $todate);
	        }
	    }
	    if($locationid){
	    	$this->db->where('mt.trma_locationid',$locationid);
	    }
	    $query = $this->db->get();
	   	//echo $this->db->last_query();die();
	    if ($query->num_rows() > 0) 
	    {
	      $data=$query->result();   
	      return $data;   
	    }   
	    return false;
	}
}