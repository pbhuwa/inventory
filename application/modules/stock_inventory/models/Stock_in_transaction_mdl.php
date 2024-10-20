<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock_in_transaction_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		//$this->table='eqli_equipmentlist';
	}
	public function purchase_report($srchcol=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
       	$sql = "SELECT
				dist_distributor,
				SUM(amount) AS amount,
				SUM(ramt) AS ramt,
				SUM(amount - ramt) AS totalamnt
			FROM
				(
					SELECT
						s.dist_distributor,
						SUM(rm.recm_clearanceamount) amount,
						0 AS ramt
					FROM
					xw_recm_receivedmaster rm 
				 LEFT JOIN 	xw_dist_distributors s ON s.dist_distributorid = rm.recm_supplierid
				WHERE
					rm.recm_receiveddatebs BETWEEN '$fromdate' AND '$todate' AND
				 rm.recm_dstat != 'M'
					GROUP BY
						s.dist_distributor

					UNION

						SELECT 
							s.dist_distributor,
							0 AS amount,
							SUM(
								pr.purr_returnamount - pr.purr_discount + pr.purr_vatamount
							) ramt
						FROM
							xw_purr_purchasereturn pr
					LEFT JOIN 	xw_dist_distributors s ON s.dist_distributorid = pr.purr_supplierid 
					WHERE pr.purr_st = 'N'
					AND pr.purr_returndatebs BETWEEN '$fromdate' AND '$todate' 
						GROUP BY
							s.dist_distributor
				) X
			WHERE
				X.amount > 0
			GROUP BY
				X.dist_distributor
			ORDER BY
				dist_distributor";  
		$query=$this->db->query($sql);
		//echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}
	public function issue_report()
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
       	$sql = "SELECT
				department,
				SUM(issueamount) AS issueamount,
				SUM(returnamt) AS returnamt,
				SUM(issueamount - returnamt) AS totalissueval
			FROM
				(
					SELECT 
						sama_depname AS department,
						SUM(sama_totalamount) AS issueamount,
						0 AS returnamt
					FROM
					 xw_sama_salemaster
					WHERE
						sama_duedatebs  BETWEEN '$fromdate' AND '$todate' 
					GROUP BY
						sama_depname

					UNION

						SELECT
						d.dept_depname AS department,
							0 AS issueamt,
							SUM(rd.rede_total) AS returnamt
						FROM
							xw_rema_returnmaster rm
						JOIN  xw_rede_returndetail rd ON rd.rede_returnmasterid = rm.rema_returnmasterid
						LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=rd.rede_itemsid
						LEFT JOIN xw_dept_department d ON d.dept_depid = rm.rema_depid
						WHERE
							rm.rema_returndatebs  BETWEEN '$fromdate' AND '$todate' 
						GROUP BY
							d.dept_depname
				) X
			GROUP BY
				department
			ORDER BY
				department";  
		$query=$this->db->query($sql);
		//echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}
	public function strock_intransaction($srchcol=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
		$this->db->select('il.itli_itemname,SUM(md.trde_requiredqty) as stock, SUM(md.trde_requiredqty * md.trde_unitprice) as stockvalue');
			$this->db->from('trma_transactionmain mt');
	    	$this->db->join('trde_transactiondetail md','md.trde_trmaid = mt.trma_trmaid','LEFT');
	    	$this->db->join('itli_itemslist il','il.itli_itemlistid = md.trde_itemsid','LEFT');
	    	//$this->db->where('trma_todepartmentid', '');

		$this->db->where('mt.trma_received', '0');
			
	    if($srchcol)
	    {
	      $this->db->where($srchcol);
	    }
	    if($fromdate &&  $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          $this->db->where('md.trde_transactiondatebs >=', $fromdate);
	          $this->db->where('md.trde_transactiondatebs <=', $todate);
	        }
	        else
	        {
	          $this->db->where('md.trde_transactiondatead >=', $fromdate);
	          $this->db->where('md.trde_transactiondatead <=', $todate);
	        }
	    }
	    $this->db->group_by('il.itli_itemname');
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