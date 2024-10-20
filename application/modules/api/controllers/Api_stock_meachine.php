<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_stock_meachine extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->ipadd=$this->general->get_real_ipaddr();
		$this->mac=$this->general->get_Mac_Address();
			
	}
	
	
	public function index()
	{

	}

	public function get_department_machine()
	{
		$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
		$context = stream_context_create($opts);
		// $json = file_get_contents('https://dtecc.app.dolphin.com.np/_api/item/all',false,$context);
		$json = file_get_contents('https://nphl.app.dolphin.com.np/_api/department/active_list',false,$context);
		$data_depname = json_decode($json);

		// echo "<pre>";
		// print_r($data_depname);
		// die();
		if(!empty($data_depname))
		{
			$result=$data_depname->data->department_list;
			// echo "<pre>";
			// print_r($result);
			// die();
			// echo "<pre>";
			// print_r($result);
			// die();
			if(!empty($result))
			{
				$arrResult=array();
				foreach ($result as $kr => $res) {
				$chkval=$this->check_previous_department($res->id,$res->code);
				if($chkval!=1)
				{
					$arrResult=array(
					'apde_departmentid' =>$res->id,
					'apde_departmentcode' =>$res->code,
					'apde_departmentname'=>$res->department,
					'apde_postdatead'=>CURDATE_EN,
					'apde_postdatebs'=>CURDATE_NP,
					'apde_posttime'=>CURDATE_NP,
					'apde_postby'=>1,
					'apde_postip'=>$this->ipadd,
					'apde_postmac'=>$this->mac
						);
					if(!empty($arrResult))
					{
						$this->db->insert('apde_apidepartment',$arrResult);
					}
				}
				
				}

				
			}
		}
	}

	public function check_previous_department($dpid,$depcode)
	{	
		if(!empty($dpid) && !empty($depcode)){
		$this->db->select('*');
		$this->db->from('apde_apidepartment');
		$this->db->where(array('apde_departmentid'=>$dpid,'apde_departmentcode'=>$depcode));
		$qry=$this->db->get();
		if($qry->num_rows()>0)
        {
            return 1;
        }
        return 0;
	}
	}

	public function get_items_name_machine()
	{

		$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
		$context = stream_context_create($opts);
		// $json = file_get_contents('https://dtecc.app.dolphin.com.np/_api/item/all',false,$context);
		$json = file_get_contents('https://nphl.app.dolphin.com.np/_api/item/all',false,$context);
		$data_cat = json_decode($json);

		// echo "<pre>";
		// print_r($data_cat);
		// die();
		if(!empty($data_cat))
		{
			$result=$data_cat->data->item_list;
			// echo "<pre>";
			// print_r($result);
			// die();
			// echo "<pre>";
			// print_r($result);
			// die();
			if(!empty($result))
			{
				$arrResult=array();
				foreach ($result as $kr => $res) {
				$chkval=$this->check_previous_item($res->item_id,$res->item_code);
				if($chkval!=1)
				{
					$arrResult=array(
					'tena_mid'=>$res->item_id,
					'tena_code'=>$res->item_code,
					'tena_name'=>$res->item_name,
					'tena_apidepid'=> !empty($res->department_id)?$res->department_id:'',
					'tena_isactive'=>'Y',
					'tena_postdatead'=>CURDATE_EN,
					'tena_postdatebs'=>CURDATE_NP,
					'tena_posttime'=>date('H:i:s'),
					'tena_postby'=>1,
					'tena_postip'=>$this->ipadd,
					'tena_postmac'=>$this->mac
						);
					if(!empty($arrResult))
					{
						$this->db->insert('tena_testname',$arrResult);
					}
				}
				
				}

				
			}
		}
}

public function check_previous_item($mid,$tena_code)
{
	if(!empty($mid) && !empty($tena_code)){
		$this->db->select('*');
		$this->db->from('tena_testname');
		$this->db->where(array('tena_mid'=>$mid,'tena_code'=>$tena_code));
		$qry=$this->db->get();
		if($qry->num_rows()>0)
        {
            return 1;
        }
        return 0;
	}
}

public function get_test_count()
{
		// $date='2019-05-01';
		$date=date('Y-m-d');
		// echo $date;
		// die();
		$date_en=str_replace('-','/',$date);
		$date_np=$this->general->EngToNepDateConv($date_en);

		$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
		$context = stream_context_create($opts);
		// $json = file_get_contents('https://dtecc.app.dolphin.com.np/_api/item/count/'.$date.'/true',false,$context);
		$json = file_get_contents('https://nphl.app.dolphin.com.np/_api/item/count/'.$date.'/true',false,$context);
		$data_testcnt = json_decode($json);

		// echo "<pre>";
		// print_r($data_testcnt);
		// die();
		if(!empty($data_testcnt))
		{
			$result=$data_testcnt->data->item_list;
			if(!empty($result))
			{
				$arrResult=array();
				foreach ($result as $kr => $res) {
				$chkval=$this->check_previous_test_log_item($res->test_id,$res->code,$date_en);
				if($chkval!=1)
				{
					$arrResult=array(
					'telo_testid'=>$res->test_id,
					'telo_itemid'=>$res->item_id,

					'telo_testcode'=>$res->code,
					'telo_testname' =>$res->test_name,
					'telo_cnt'=>$res->item_count,
					'telo_apidepid'=> !empty($res->department_id)?$res->department_id:'',
					'telo_datadatead'=>$date_en,
					'telo_datadatebs'=>$date_np,
					'telo_postdatead'=>CURDATE_EN,
					'telo_postdatebs'=>CURDATE_NP,
					'telo_posttime'=>date('H:i:s'),
					'telo_postby'=>1,
					'telo_postip'=>$this->ipadd,
					'telo_postmac'=>$this->mac
						);
					if(!empty($arrResult))
					{
						$this->db->insert('telo_testlog',$arrResult);
					}
				  }
				}			
			}
		}
}

public function check_previous_test_log_item($testid,$tena_code,$testdate)
{
	if(!empty($testid) && !empty($tena_code)){
		$this->db->select('*');
		$this->db->from('telo_testlog');
		$this->db->where(array('telo_testid'=>$testid,'telo_testcode'=>$tena_code,'telo_datadatead'=>$testdate));
		$qry=$this->db->get();
		if($qry->num_rows()>0)
        {
            return 1;
        }
        return 0;
	}
}


}