<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchase_sale_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		//$this->table='eqli_equipmentlist';
	}


	public function purchase_report($srchcol=false,$cond=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid=$this->input->post('locationid');
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
					recm_receiveddatebs BETWEEN '$fromdate' AND '$todate' $cond AND
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
					AND pr.purr_returndatebs BETWEEN '$fromdate' AND '$todate' $srchcol 
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
		// echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}


	public function issue_report($srchcol=false,$cond=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid=$this->input->post('locationid');
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
						sama_duedatebs  BETWEEN '$fromdate' AND '$todate' $cond
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
							rm.rema_returndatebs  BETWEEN '$fromdate' AND '$todate' $srchcol
						GROUP BY
							d.dept_depname
				) X
			GROUP BY
				department
			ORDER BY
				department";  
		$query=$this->db->query($sql);
		// echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}
}