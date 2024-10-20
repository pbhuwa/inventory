<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('max_execution_time', 0); 
ini_set('memory_limit','2048M');


class Api_ku extends CI_Controller {



	function __construct() {

		parent::__construct();

	}

	

public function update_assets_code()
{

	$this->db->select('DISTINCT(asen_description) as asen_description ');
	$this->db->from('asen_assetentry ae');
	$this->db->where('asen_assetcode IS NULL');
	$this->db->order_by('asen_description','ASC');
	// $this->db->limit(10);
	// $this->db->offset(1);
	$assets_desc_rslt=$this->db->get()->result();
	// echo "<pre>";
	// print_r($assets_desc_rslt);
	// die();
	if(!empty($assets_desc_rslt)){
		foreach($assets_desc_rslt as $rslt){
			$this->db->select('asen_asenid,asen_description,asen_purchasedatebs,itli_itemname');
	$this->db->from('asen_assetentry ae');
	$this->db->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT');
	$this->db->where('asen_description',$rslt->asen_description);
	$this->db->where('asen_assetcode IS NULL');
	// $this->db->limit(10);
	$result=$this->db->get()->result();
	if(!empty($result)){
		// echo "<pre>";
		// print_r($result);
		// die();
		$i=1;
		foreach ($result as $key => $ass) {
			$pur_date=$ass->asen_purchasedatebs;
			$wordcount=str_word_count($ass->itli_itemname);
			if(!empty($pur_date)){
				$purchase_date= explode('/', $pur_date);
				$year=$purchase_date[0];
				$month=$purchase_date[1];
				$days=$purchase_date[2];
				$next_yrs=$year+1;
				$prev_yrs=$year-1;
				if($month>=4 && $month<=12){
				$fyrs=substr($year, 1).'/'.substr($next_yrs,2);
				}
				elseif($month>=1 && $month<=3){
					$fyrs=substr($prev_yrs,1).'/'.substr($year,2);
				}
			}
		// print_r('wc'.$wordcount);

		// die();

		$asset_code='';

		if($wordcount==1)

		{

			$asset_code= strtoupper(substr($ass->itli_itemname, 0, 3));

		}

		if($wordcount==2)

		{

			$stringarray= explode(' ', $ass->itli_itemname);

			// print_r($stringarray);

			$str1= strtoupper(substr($stringarray[0], 0, 2));

			$str2= strtoupper(substr($stringarray[1], 0, 1));

			$asset_code= $str1.$str2;	

		}

		if($wordcount==3)
		{
			$stringarray= explode(' ', $ass->itli_itemname);
			// print_r($stringarray);
			$str1= strtoupper(substr($stringarray[0], 0, 1));
			$str2= strtoupper(substr($stringarray[1], 0, 1));
			$str3= strtoupper(substr($stringarray[2], 0, 1));
			$asset_code= $str1.$str2.$str3;	
		}
		if($wordcount>=4)
		{
			$stringarray= explode(' ', $ass->itli_itemname);
			$str1= strtoupper(substr($stringarray[0], 0, 1));
			$str2= strtoupper(substr($stringarray[1], 0, 1));
			$str3= strtoupper(substr($stringarray[2], 0, 1));
			$str4= !empty($stringarray[3])?strtoupper(substr($stringarray[3], 0, 1)):'';
			$asset_code= $str1.$str2.$str3;	
		}
		$final_number_gen=str_pad($i, 3, 0, STR_PAD_LEFT);

		$asset_code=preg_replace('/[^A-Za-z0-9\-]/', '', $asset_code);

			$final_code= $asset_code.'-'.$final_number_gen.'-'.$fyrs;
			// echo "<br>";
			$arr_code[]=array('asen_asenid'=>$ass->asen_asenid,'asen_assetcode'=>$final_code);

			$i++;
		}
		if(!empty($arr_code)){
			// $this->db->batch_update()
			$this->db->update_batch('asen_assetentry',$arr_code, 'asen_asenid'); 
		}
	}
}
		}
	}




public function update_department_with_school()
{
	$result=$this->db->query("SELECT * FROM NEWSCHOOLID WHERE schoolid_old!=schoolid")->result();
	// echo "<pre>";
	// print_r($result);
	// die();
	if(!empty($result)){
		foreach ($result as $kr => $val) {
				$asen_asenid=$val->asen_asenid;
				$schoolid=$val->schoolid;
				$this->db->query("UPDATE xw_asen_assetentry SET asen_schoolid=$schoolid WHERE asen_asenid=$asen_asenid");
				echo 'Assets ID :'.$asen_asenid.' is updated with schoolid '.$schoolid;
				flush();
				ob_flush();
		}

		echo "All Assets Completely  Updated ";
	}

}
	



	

}



/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */