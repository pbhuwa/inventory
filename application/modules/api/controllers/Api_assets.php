<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Api_assets extends CI_Controller {



	function __construct() {

		parent::__construct();

			$this->load->model('api_mdl');

	}

	

	

	public function excel_to_db()

	{

		$result=$this->db->query("SELECT * FROM excel_assets")->result();

		echo "<pre>";

		print_r($result);

		die();

		if(!empty($result)){

			foreach($result as $rslt){

				$qtycnt=$rslt->qty;

				$excelid=$rslt->excelid;

	            $purchase_date=$rslt->purchase_date;

	            $eqtype=$rslt->eqtype;

	            $eqcatid=$rslt->eqcatid;

	            $suppbill=$rslt->suppbill;

	            $suppliers=$rslt->suppliers;

	            $goodsname=$rslt->goodsname;

	            $model=$rslt->model;

	            $qty=$rslt->qty;

	            $rate=$rslt->rate;

	            $org_cost=$rslt->org_cost;

	            $opening_balance=$rslt->opening_balance;

	            $dep_per=$rslt->dep_per;

	            $dep_fyear=$rslt->dep_fyear;

	            $acu_dep_prev_yrs=$rslt->acu_dep_prev_yrs;

	            $total_depn=$rslt->total_depn;

	            $net_value=$rslt->net_value;

	            $location=$rslt->location;

	            $user=$rslt->user;

	            $condition=$rslt->condition;

	            $remarks=$rslt->remarks;

	            $gname=$rslt->gname;

	            $x = str_replace( ',', '', $rate);

				if( is_numeric($x))

				  {

				  // echo $x."\n";

				  	$rate=$x;

				  }

				

				  // echo date('y/m/d',$new_date);

				  // echo "<br>";

				  // echo $new_date;

				  if($purchase_date){

				  $exp_purdate=explode('/', $purchase_date);

				  $new_date=$exp_purdate[2].'/'.$exp_purdate[0].'/'.$exp_purdate[1];



				  $pdate = sprintf('%s/%02s/%02s', $exp_purdate[2], $exp_purdate[0],$exp_purdate[1]);	

				  }

				  else

				  {

				  	$pdate='';

				  }

				  



				  // echo $stamp;

				  // echo "<br>";







				for($i=1;$i<=$qtycnt;$i++){

					$assetsArray[]=array(

						'asen_assettype'=>$eqcatid,

						'asen_description'=> $goodsname,

						'asen_supplier'=> $suppliers,

						'asen_supplierbilno'=> $suppbill,

						'asen_manufacture'=>'',

						'asen_brand'=>'',

						'asen_modelno'=> $model,

						'asen_serialno'=>$i,

						'asen_status'=>'',

						'asen_condition'=> $condition,

						'asen_user'=>$user,

						'asen_notes'=>'',

						'asen_vendor'=>'',

						'asen_purchaserate'=> $rate,

						'asen_marketvalue'=>'',

						'asen_scrapvalue'=>'',

						'asen_purchasedatebs'=>$pdate,

						'asen_purchasedatead'=>'',

						'asen_inservicedatebs'=>'',

						'asen_inservicedatead'=>'',

						'asen_warrentydatebs'=>'',

						'asen_warrentydatead'=>'',

						'asen_expectedlife'=>'',

						'asen_recoveryperiod'=>'',

						'asen_deppercentage'=>$dep_per,

						'asen_depreciation'=>'',

						'asen_fiscalyrs'=>$remarks,

						'asen_remarks'=>$gname,

					);

				

				}





			}

			// echo "<pre>";

			// print_r($assetsArray);

			// die();

			if(!empty($assetsArray)){

					$this->db->insert_batch('asen_assetentry',$assetsArray);

				}

		}	

	}



public function assest_code(){

// echo "e";	

	$distinct_qry=$this->db->query("SELECT DISTINCT(asen_description) asen_description from xw_asen_assetentry WHERE asen_assettype<>7 AND asen_assettype<>12 AND asen_description <>'' AND asen_assetcode IS NULL;

")->result();

	// echo "<pre>";

	// print_r($distinct_qry);

	// die();

	if(!empty($distinct_qry))

	{

			$updateqry='';

		foreach ($distinct_qry as $kd => $des) {

			$desname=$des->asen_description;

			$this->db->select('*');

	$this->db->from("asen_assetentry");

	// $this->db->join('')

	// $this->db->where('asen_assettype','7');

	$this->db->where('asen_description',$desname);

	$this->db->order_by('asen_description','ASC');

	$rslt=$this->db->get()->result();

	// echo "<pre>";

	// print_r($rslt);

	// die();

	if($rslt)

	{

		$i=1;

	

		foreach ($rslt as $kr => $val) {

		$ass_desc=$val->asen_description;

		$assid=$val->asen_asenid;

		$ass_desc_cnt=str_word_count($ass_desc);

		if($ass_desc_cnt==1)

		{

			$asscd= substr($ass_desc, 0, 3);

				$new_i=str_pad($i,4,"0",STR_PAD_LEFT);

			$asscode= strtoupper($asscd.'-'.$new_i);



		}

		if($ass_desc_cnt==2)

		{

			$list_ass_desc=explode(' ', $ass_desc);

			if($list_ass_desc)

			{

				$frt_ass_desc=$list_ass_desc[0];

				$sec_ass_desc=$list_ass_desc[1];

				$asscode1= substr($frt_ass_desc, 0, 3);

				$asscode2= substr($sec_ass_desc, 0, 3);

				$new_i=str_pad($i,4,"0",STR_PAD_LEFT);

				$asscode=strtoupper($asscode1.'-'.$asscode2.'-'.$new_i);



			}

		}

		if($ass_desc_cnt==3)

		{

			$list_ass_desc=explode(' ', $ass_desc);

			if($list_ass_desc)

			{

				$frt_ass_desc=$list_ass_desc[0];

				$sec_ass_desc=$list_ass_desc[1];

				$thr_ass_desc=$list_ass_desc[2];



				$asscode1= substr($frt_ass_desc, 0, 3);

				$asscode2= substr($sec_ass_desc, 0, 3);

				$asscode3= substr($thr_ass_desc, 0, 3);

				$new_i=str_pad($i,4,"0",STR_PAD_LEFT);

				$asscode=strtoupper($asscode1.'-'.$asscode2.'-'.$asscode3.'-'.$new_i);



				// $asscode=strtoupper($asscode1.$asscode2.$asscode3.$i);





			}

		}

		$i++;

$updateqry.= "UPDATE xw_asen_assetentry SET asen_assetcode='".$asscode."' where asen_asenid=$assid ;";

		}

	}





		



		// $this->db->update('asen_assetentry',array('asen_assetcode'=>$asscode),array('asen_asenid'=>$assid));





	}

	echo "<pre>";

	echo $updateqry;

	die();

	

}







}



public function change_assets_description()

{

	

}



public function assets_location_set()

{

	// echo "sad";

	// die();

	// $result=$this->db->query("SELECT * FROM xw_asen_assetentry_temp WHERE asen_serialno=1")->result();

	// 	// echo "<pre>";

	// 	// print_r($result);

	// 	// die();

	// 	if(!empty($result)){

	// 		$i=1;

	// 		$qry='';

	// 		foreach($result as $rslt){

	// 			$mid=$rslt->asen_asenid;



	// 			$qry.="UPDATE xw_asen_assetentry_temp SET asen_mainid=$i WHERE asen_asenid=$mid; ";

	// 		$i++;

	// 		}

	// 		echo $qry;

	// 		// $this->db->query($qry);

	// 	}

		$result=$this->db->query("SELECT * FROM excel_assets")->result();

		if(!empty($result)){

			 $qry='';

			$j=1;

			foreach($result as $rslt){

				$mid=$rslt->id;

				$qtycnt=$rslt->qty;

				$locname=!empty($rslt->location)?$rslt->location:'';

				$model_no= !empty($rslt->model)?$rslt->model:'';

				if($qtycnt>0){

					for($i=1;$i<=$qtycnt;$i++){

						$qry.="UPDATE xw_asen_assetentry_temp SET asen_location='".$locname."', asen_mainid='".$mid."', asen_modelno='".$model_no."' WHERE asen_asenid=$j; ";

						$j++;

					}

				}

					// $save_val=0;

					// $qry.="UPDATE xw_asen_assetentry_temp SET asen_mainid=$save_val WHERE asen_asenid=$mid; ";

			}

			echo $qry;

	}

}



public function other_db_assets(){

	$this->db->query("INSERT INTO xw_asen_assetentry(asen_asenid,

asen_assetcode,

asen_serialno,

asen_description,

asen_depid,

asen_purchasedatebs,

asen_masterid,

asen_postdatead,

asen_purchaserate,

asen_isdispose,

asen_manufacture,

asen_modelno,

asen_assettype,

asen_vno,

asen_mrn,

asen_supplierbilno,

asen_distributor,

asen_locationid,

asen_budgetid,

asen_manualcode,

asen_remarks,

asen_desc,

asen_isinsurance,

asen_staffid,

asen_room,

asen_blockid)

SELECT 

ASSETID	As	asen_asenid,

ASSETCODE	As	asen_assetcode,	

SERIALNO	As	asen_serialno,

ITEMSID	As	asen_description,

DEPARTMENTID	As	asen_depid,

RECEIVEDDATE	As	asen_purchasedatebs,

MASTERID	As	asen_masterid,

ENTRYDATE	As	asen_postdatead,

UNITPRICE	As	asen_purchaserate,

DISPOSED	As	asen_isdispose,

MANUFACTURERID	As	asen_manufacture,

MODELNO	As	asen_modelno,	

ACATEGORYID	As	asen_assettype,	

VNO	As	asen_vno,

MRN	As	asen_mrn,

SUPPLIERBILLNO	As	asen_supplierbilno,

SUPPLIERID	As	asen_distributor,

LOCATIONID	As	asen_locationid,

BUDGETID	As	asen_budgetid,	

MANUALCODE	As	asen_manualcode,

REMARKS	As	asen_remarks,

DESCRIPTION	As	asen_desc,

INSURABLE	As	asen_isinsurance,

STAFFID	As	asen_staffid,

ROOMNO	As	asen_room,

BLOCKID	As	asen_blockid

FROM ASSETS 

");

}

	

}



/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */