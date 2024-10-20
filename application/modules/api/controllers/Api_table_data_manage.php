<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('max_execution_time', 0); 
ini_set('memory_limit','2048M');

class Api_table_data_manage extends CI_Controller {

	function __construct() {
		parent::__construct();

			$this->date="2076/04/01";
	}
	
	public function index()
	{
	
	}

	public function cancel_transaction_from_receive(){

		$qry = "SELECT DISTINCT(trma_trmaid) as trma_trmaid from xw_trma_transactionmain tm LEFT JOIN xw_trde_transactiondetail td on td.trde_trmaid = tm.trma_trmaid WHERE trde_mtdid IN (select recd_receiveddetailid from xw_recm_receivedmaster rm LEFT JOIN xw_recd_receiveddetail rd on rd.recd_receivedmasterid = rm.recm_receivedmasterid WHERE recm_status != 'O');";
		$result = $this->db->query($qry)->result();
		if(!empty($result)){
		$transaction_master_ids = array();
		foreach($result as $data){
			$transaction_master_ids[] = $data->trma_trmaid;
		}
		// echo "<pre>";
		// print_r ($transaction_master_ids);
		// echo "</pre>";
		// die();
		$this->db->where_in('trma_trmaid',$transaction_master_ids);
		$this->db->update("trma_transactionmain",array('trma_status'=>'C'));
		}
	}

	public function update_rate_into_table(){
		$this->update_arate_into_received_transdetail_table();
		$this->update_unitprice_into_salesdetail_table();
	}

	public function update_arate_into_received_transdetail_table(){

		$this->db->select("rd.recd_receiveddetailid,rm.recm_receiveddatebs, recd_itemsid,recd_purchasedqty,recd_unitprice,recd_amount,recd_arate,(recd_amount/recd_purchasedqty) as arate") ;
		$this->db->from("recd_receiveddetail rd");
		$this->db->join("recm_receivedmaster rm","rm.recm_receivedmasterid=rd.recd_receivedmasterid","INNER");
		$this->db->where("rm.recm_receiveddatebs >=",$this->date);
		$this->db->order_by("recd_receiveddetailid","ASC");
		$result=$this->db->get()->result();
		if(!empty($result)){
			// echo "<pre>";
			// print_r($result);
			// die();
			foreach ($result as $kr => $value) {
				$recdid=$value->recd_receiveddetailid;
				$itemid=$value->recd_itemsid;
				$db_arate=$value->recd_arate;
				$cal_arate=round($value->arate,2);
					$rcarr=array(
					'recd_arate'=>$cal_arate);
						echo "<br>";
				if($db_arate!=$cal_arate){
					$this->db->update('recd_receiveddetail',$rcarr,array('recd_receiveddetailid'=>$recdid));
				
					echo "Update Success into xw_recd_receiveddetail Table with recd_receiveddetailid = $recdid <br>";

				}
				echo "++++++++++++++++++++++><br>";
				$this->db->update('trde_transactiondetail',array('trde_unitprice'=>$cal_arate),array('trde_mtdid'=>$recdid,'trde_itemsid'=>$itemid));
					echo "Update Success into xw_trde_transactiondetail Table with trde_mtdid = $recdid and trde_itemsid = $itemid <br> ";
					echo "---------------------------------------<br>";
					echo "<br>";
				flush();
					ob_flush();
				
			}
		}
	}

public function update_unitprice_into_salesdetail_table(){
		$this->db->select("td.trde_trdeid,td.trde_itemsid,td.trde_unitprice,td.trde_mtdid") ;
		$this->db->from("trde_transactiondetail td");
		$this->db->join("trma_transactionmain tm","tm.trma_trmaid=td.trde_trmaid","INNER");
		$this->db->where("tm.trma_transactiondatebs >=",$this->date);
		$this->db->order_by("trde_trdeid","ASC");
		$result_trde=$this->db->get()->result();
		// echo "<pre>";
		// print_r($result_trde);
		// die();
		if(!empty($result_trde)){
			echo "<br>";
			foreach ($result_trde as $kr => $val) {
			$trdeid=$val->trde_trdeid;
			$itemid=$val->trde_itemsid;
			$unitprice=$val->trde_unitprice;
			$trmtdid=$val->trde_mtdid;

			$this->db->update("sade_saledetail",array('sade_unitrate'=>$unitprice),array('sade_itemsid'=>$itemid,'sade_mattransdetailid'=>$trdeid));
			echo "<br>";
			echo "Update Success into xw_sade_saledetail Table with sade_itemsid = $itemid and sade_mattransdetailid = $trdeid <br>";
			echo "---------------------------------------<br>";

		}

		}
	}


	public function update_sales_rate_into_auction_disposal_table()
	{
		$this->db->select("asdd_asddid,asdd_trandetailid,ad.asdd_depissqty,td.trde_unitprice") ;
		$this->db->from("asde_assetdesposalmaster am");
		$this->db->join("asdd_assetdesposaldetail ad","ad.asdd_assetdesposalmasterid=am.asde_assetdesposalmasterid","INNER");
		$this->db->join("trde_transactiondetail td","td.trde_trdeid=ad.asdd_trandetailid","LEFT");
		$this->db->where(array('am.asde_status'=>'O','ad.asdd_status'=>'O'));
		$this->db->where(array('am.asde_desposaltypeid'=>2));
		$this->db->order_by("asdd_asddid","ASC");
		$result_auction_disposal=$this->db->get()->result();
		// echo "<pre>";
		// print_r($result);
		// die();
		if(!empty($result_auction_disposal)){
			foreach ($result_auction_disposal as $kr => $rval) {
				$urate=!empty($rval->trde_unitprice)?$rval->trde_unitprice:'0.00';
				$dqty= !empty($rval->asdd_depissqty)?$rval->asdd_depissqty:'0';
				$total_amt=$dqty*$urate;

				$this->db->update('asdd_assetdesposaldetail',array('asdd_sales_amount'=>$urate,'asdd_sales_totalamt'=>$total_amt),array('asdd_asddid'=>$rval->asdd_asddid));
				echo "<br>";
			echo "Update Success into asdd_assetdesposaldetail Table with sales total amount<br>";
			echo "---------------------------------------<br>";
			}
			
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */