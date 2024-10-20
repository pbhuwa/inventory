<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('max_execution_time', 0); 
ini_set('memory_limit','2048M');
error_reporting(0);
class Api_kukl extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('Api_kukl_mdl');

		$this->ipadd=$this->general->get_real_ipaddr();
		$this->mac=$this->general->get_Mac_Address();
		$this->curtime= $this->general->get_currenttime();
	
	}
	
	public function index()
	{

		$seo_data='';
		if($seo_data)
		{
			//set SEO data
			$this->page_title = $seo_data->page_title;
			$this->data['meta_keys']= $seo_data->meta_key;
			$this->data['meta_desc']= $seo_data->meta_description;
		}
		else
		{
			//set SEO data
		    $this->page_title = ORGA_NAME;
		    $this->data['meta_keys']= ORGA_NAME;
		    $this->data['meta_desc']= ORGA_NAME;
		}

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('api/api/v_api', $this->data);
	}

	public function get_kukl_capital()
	{
		$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
		$context = stream_context_create($opts);
		$json = file_get_contents(KUKL_API_URL.'InventoryService/KUKLCapital'.KUKL_API_KEY,false,$context);

		// $url = KUKL_API_URL.'InventoryService/KUKLCapital'.KUKL_API_KEY;

		// $ch = curl_init();
		// curl_setopt($ch, CURLOPT_URL, $url);
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// $json = curl_exec($ch);

		$data_cat = json_decode($json);

		if(!empty($data_cat)){
			foreach($data_cat as $key => $value){
				$array = array(
					'acty_catid' => 1,
					'acty_accode' => $value->acCode,
					'acty_acname' => $value->acName,
					'acty_drcr' => $value->drCr,
					'acty_paaccode' => $value->paAcCode
				);

				if(!empty($array)){
					$this->db->insert('acty_accounttype',$array);
				}
 			}
		}

		if($this->db->affected_rows() > 0)
		{
			print_r(json_encode(array('status'=>'success','message'=>'')));
            	exit;
		}
		else{
			print_r(json_encode(array('status'=>'error','message'=>'')));
            	exit;
		}
	}

	public function get_kukl_charthead()
	{
		$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
		$context = stream_context_create($opts);
		// $json = file_get_contents(KUKL_API_URL.'InventoryService/AcChartHead'.KUKL_API_KEY,false,$context);
		
		// http://api.kathmanduwater.com:8085/api/InventoryService/FetchCostCenters/{Inv

		$cost_central_url = KUKL_API_URL.'InventoryService/FetchCostCenters/@ccessKuK!nv!ntegr@t!0n20!9';
		$json = file_get_contents($cost_central_url);
		$data_costcenter = json_decode($json);
		
		// echo "<pre>";
		// print_r ($data_costcenter);
		// echo "</pre>";
		
		if (!empty($data_costcenter)) {
			foreach($data_costcenter as $cc){
				$account_id = $cc->costcenteR_ID;  
				$account_name = $cc->costcenteR_NAME;

				$check_db = $this->db->select('buhe_bugetheadid')->from('buhe_bugethead')->where('buhe_accountid',$account_id)->get()->row();
				if (!empty($check_db)) {
					$this->db->where('buhe_bugetheadid',$check_db->buhe_bugetheadid)->update('buhe_bugethead',array('buhe_headtitle'=>$account_name,'buhe_isactive'=>'Y'));
				}else{
					$this->db->insert('buhe_bugethead',array('buhe_headtitle'=>$account_name,'buhe_accountid'=>$account_id,'buhe_isactive'=>'Y'));
				}
			}
		}

		$db_costcenters = $this->db->where('buhe_isactive','Y')->where('buhe_accountid IS NOT NULL',NULL, false)->get('buhe_bugethead')->result();
		// echo "<pre>";
		// print_r ($db_costcenters);
		// echo "</pre>";
		// die();

		if (!empty($db_costcenters)) {
			foreach($db_costcenters as $costcenter){

				$url=KUKL_API_URL.'InventoryService/FetchChartOfAccByCostCenter/@ccessKuK!nv!ntegr@t!0n20!9?costcenter_id='.$costcenter->buhe_accountid;
				$json = file_get_contents($url);
				$account_charts = json_decode($json);
				// echo "<pre>";
				// echo $costcenter->buhe_headtitle;
				// print_r ($account_charts);
				// echo "</pre>";
				// die();
				if (!empty($account_charts)) {
					foreach($account_charts as $chart){
						$accode = $chart->acCode;
						$acname = $chart->acName;
						$drcr = $chart->drCr;
						$paaccode = $chart->paAcCode;

						$check_db = $this->db->select('acty_id')->from('acty_accounttype')->where('acty_accode',$accode)->where('acty_catid',$costcenter->buhe_accountid)->get()->row();
						if (!empty($check_db)) {
							$this->db->where('acty_id',$check_db->acty_id)->update('acty_accounttype',array('acty_catid'=>$costcenter->buhe_accountid,'acty_acname'=>$acname,'acty_budgetid'=>$costcenter->buhe_bugetheadid));
						}else{

							$insertData = array(
								'acty_catid'=>$costcenter->buhe_accountid,
								'acty_accode'=>$accode,
								'acty_acname'=>$acname,
								'acty_drcr'=>$drcr,
								'acty_paaccode' => $paaccode,
								'acty_budgetid'=>$costcenter->buhe_bugetheadid
							);
							$this->db->insert('acty_accounttype',$insertData);
						}
					}
				}
			}
		}
		// die();
		print_r(json_encode(array('status'=>'success','message'=>'Success')));
    	exit;

		// echo $cost_central_url;
		// die();
		// $url=KUKL_API_URL.'InventoryService/FetchChartOfAccByCostCenter/@ccessKuK!nv!ntegr@t!0n20!9?costcenter_id=2';
		// // echo $url;
		// // die();
		// $json = file_get_contents($url);
		
		// $data_cat = json_decode($json);
		// echo "<pre>";
		// print_r($data_cat);
		// echo $data_cat;
		// die();

		// if(!empty($data_cat)){
		// 	foreach($data_cat as $key => $value){
		// 		$array = array(
		// 			'acty_catid' => 2,
		// 			'acty_accode' => $value->acCode,
		// 			'acty_acname' => $value->acName,
		// 			'acty_drcr' => $value->drCr,
		// 			'acty_paaccode' => $value->paAcCode
		// 		);

		// 		if(!empty($array)){
		// 			$this->db->insert('acty_accounttype',$array);
		// 		}
 	// 		}
		// }

		// if($this->db->affected_rows() > 0)
		// {
		// 	print_r(json_encode(array('status'=>'success','message'=>'')));
  //           	exit;
		// }
		// else{
		// 	print_r(json_encode(array('status'=>'error','message'=>'')));
  //           	exit;
		// }
	}

	public function get_individual_account_head_by_cost_center($cost_central_id){
		if(empty($cost_central_id)){
			echo "Cost central field is required !!";
			die();
		}

	$url=KUKL_API_URL.'InventoryService/FetchChartOfAccByCostCenter/@ccessKuK!nv!ntegr@t!0n20!9?costcenter_id='.$cost_central_id;
		$json = file_get_contents($url);
		$account_charts = json_decode($json);
		// echo "<pre>";
		// // echo $costcenter->buhe_headtitle;
		// print_r ($account_charts);
		// // echo "</pre>";
		// die();
		if (!empty($account_charts)) {
					foreach($account_charts as $chart){
						$accode = $chart->acCode;
						$acname = $chart->acName;
						$drcr = $chart->drCr;
						$paaccode = $chart->paAcCode;

						$check_db = $this->db->select('acty_id')->from('acty_accounttype')->where('acty_accode',$accode)->get()->row();
					echo $check_db->acty_id;
					echo "--<br>";
						// if (!empty($check_db)) {
						// 	$this->db->where('acty_id',$check_db->acty_id)->update('acty_accounttype',array('acty_catid'=>$cost_central_id,'acty_acname'=>$acname,'acty_budgetid'=>$costcenter->buhe_bugetheadid));
						// }else{

						// 	$insertData = array(
						// 		'acty_catid'=>$cost_central_id,
						// 		'acty_accode'=>$accode,
						// 		'acty_acname'=>$acname,
						// 		'acty_drcr'=>$drcr,
						// 		'acty_paaccode' => $paaccode,
						// 		'acty_budgetid'=>$costcenter->buhe_bugetheadid
						// 	);
						// 	$this->db->insert('acty_accounttype',$insertData);
						// }
					}
				}

	}

	public function subsidiary_account()
	{
		$locations = $this->db->select('loca_locationid,loca_name,loca_accountcode,loca_irdcode')->from('loca_location')->where('loca_accountcode IS NOT NULL',NULL, false)->get()->result();
		$account_charts = $this->db->select('acty_id, acty_accode, acty_acname')->from('acty_accounttype')->get()->result();
		// echo "<pre>";
		// print_r($account_charts);
		// die();

		// if (!empty($locations)) {
		// 	foreach($locations as $loc){
		// 		echo "<h4>$loc->loca_name</h4>:<hr>";
				foreach($account_charts as $ac){
				$url = "http://api.kathmanduwater.com:8085/api/InventoryService/FetchSubsidiaryAccount/@ccessKuK!nv!ntegr@t!0n20!9/80/$ac->acty_accode";
					$json = file_get_contents($url);
					$subsidiary_accounts = json_decode($json);
					echo "<h5>$ac->acty_acname</h5>:<br>";
					echo "<pre>"; 
					print_r ($subsidiary_accounts);
					echo "</pre>";
				}
		// 	}
		// }
	}

	public function get_kukl_kvwsmbcapital()
	{
		$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
		$context = stream_context_create($opts);
		$json = file_get_contents(KUKL_API_URL.'InventoryService/KVWSMBCapital'.KUKL_API_KEY,false,$context);
		
		$data_cat = json_decode($json);
		// echo "<pre>";
		// print_r($data_cat);
		// die();

		if(!empty($data_cat)){
			foreach($data_cat as $key => $value){
				$array = array(
					'acty_catid' => 3,
					'acty_accode' => $value->acCode,
					'acty_acname' => $value->acName,
					'acty_drcr' => $value->drCr,
					'acty_paaccode' => $value->paAcCode
				);

				if(!empty($array)){
					$this->db->insert('acty_accounttype',$array);
				}
 			}
		}

		if($this->db->affected_rows() > 0)
		{
			print_r(json_encode(array('status'=>'success','message'=>'')));
            	exit;
		}
		else{
			print_r(json_encode(array('status'=>'error','message'=>'')));
            	exit;
		}
	}

	public function get_current_asset_trans($tran_no){
		$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
		$context = stream_context_create($opts);
		$json = file_get_contents(KUKL_API_URL.'InventoryService/CurrentAssetsTransaction'.KUKL_API_KEY.','.$tran_no,false,$context);

		$data = json_decode($json);
		print_r($data);die;

		if(!empty($data)):
			foreach($data as $key=>$value){
				// $date = "2017.03.11";
				// $date1 = str_replace(".", "-", $date);
				// $date1 = strtotime($date1);
				// $date2 = date('d F Y',$date1);
				// echo $date2;

				$tran_date = $value->tranDate;
				$tran_date_conv = str_replace(".", "/", $tran_date);
				// $tran_date_conv = strtotime($tran_date_conv);

				$entry_date = $value->entryDate;

				$tran_date_bs = $tran_date_conv;
				$tran_date_ad = $this->general->NepToEngDateConv($tran_date_conv);;
				$tran_time = date('h:i:s', strtotime($tran_date_conv));

				$entry_date_ad = date('Y/m/d', strtotime($entry_date));
				$entry_date_bs = $this->general->EngToNepDateConv($entry_date_ad);
				$entry_time = date('h:i:s', strtotime($entry_date));

				$array = array(
					'aptr_transno' => $value->tranNo,
					'aptr_trandatead' => $tran_date_ad,
					'aptr_trandatebs' => $tran_date_bs,
					'aptr_officecode' => $value->officeCode, // branch
					'aptr_costcenter' => $value->costCenter, //by default 1
					'aptr_accode' => $value->aC_Code, // category
					'aptr_accno' => $value->acC_No, // subsidiary number
					'aptr_voucherno' => $value->voucherNumber,
					'aptr_drcr' => $value->drCr,
					'aptr_amount' => $value->amount,
					'aptr_description' => $value->description, //remarks
					'aptr_naration' => $value->naration, // comment
					'aptr_entryby' => $value->entryBy,
					'aptr_entrydatead' => $entry_date_ad,
					'aptr_entrydatebs' => $entry_date_bs,
					'aptr_entrytime' => $entry_time,
					'aptr_postby' => '', // name(employe id)
					'aptr_postdatead' => CURDATE_EN,
					'aptr_postdatebs' => CURDATE_NP,
					'aptr_posttime' => $this->curtime,
					'aptr_postip' => $this->ipadd,
					'aptr_postmac' => $this->mac
				);

				// echo "<pre>";
				// print_r($array);
				if(!empty($array)){
					$this->db->insert('aptr_apitransaction',$array);
					$insertid=$this->db->insert_id();
				}

				if($insertid){
					$api_url = KUKL_API_URL.'InventoryService/TransactionLog'.KUKL_API_KEY;

					// {
					// 	"tranNo": 0,
					// 	"status": 0,
					// 	"message": "string",
					// 	"created_By": "string",
					// 	"updated_By": "string"
					// }

					$tran_array = array(
						'tranNo' => (int)$tran_no,
						'status' => 0,
						'message' => 'export',
						'created_By' => '',
						'updated_By' => ''
					);

					$post_json = json_encode($tran_array);

					$client = curl_init($api_url);
					
					curl_setopt($client, CURLOPT_CUSTOMREQUEST, "POST");
					
					curl_setopt($client, CURLOPT_HTTPHEADER, array(
				    'Content-Type: application/json',
				    'Content-Length: ' . strlen($post_json))
				    );
				    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
				    curl_setopt($client, CURLOPT_POSTFIELDS, $post_json);
				    curl_setopt($client, CURLOPT_FOLLOWLOCATION, 1); 

				    $response = curl_exec($client);

				    curl_close($client);

				    echo $response;
				}
			}
		endif;

		if($this->db->affected_rows() > 0)
		{
			print_r(json_encode(array('status'=>'success','message'=>'')));
            	exit;
		}
		else{
			print_r(json_encode(array('status'=>'error','message'=>'')));
            	exit;
		}
	}

	public function post_api_import_asset_with_recno($rec_no){
		$req_detail_list =$this->Api_kukl_mdl->get_received_details(array('rd.recd_receivedmasterid'=>$rec_no));

		$recv_no = !empty($req_detail_list[0]->recm_invoiceno)?$req_detail_list[0]->recm_invoiceno:'';

		$recv_date = !empty($req_detail_list[0]->recm_receiveddatebs)?$req_detail_list[0]->recm_receiveddatebs:'';
		$recv_date_conv = str_replace("/", ".", $recv_date);

		$recm_departmentid = !empty($req_detail_list[0]->recm_departmentid)?$req_detail_list[0]->recm_departmentid:'';

		$recm_postusername = !empty($req_detail_list[0]->recm_postusername)?$req_detail_list[0]->recm_postusername:'';

		$recm_locationid = !empty($req_detail_list[0]->recm_locationid)?$req_detail_list[0]->recm_locationid:'';

		$recm_remarks = !empty($req_detail_list[0]->recm_remarks)?$req_detail_list[0]->recm_remarks:'';

		$post_master_array = array(
			"tranDate" => !empty($recv_date_conv)?$recv_date_conv:"0", //2076.01.20
		    "voucherType" => "1",
		    "voucherNo" => !empty($recv_no)?$recv_no:"0", 
		    "office_ID" => 40,
		    "entryBY" => !empty($recm_postusername)?$recm_postusername:"0",
		    "narration" => !empty($recm_remarks)?$recm_remarks:"test"
		);

		if(!empty($req_detail_list)):
			$drCrArray = array('Dr','Cr');
			foreach($req_detail_list as $reqkey=>$reqval){
				$recd_itemsid = !empty($reqval->recd_itemsid)?$reqval->recd_itemsid:'';

				$eqca_accode = !empty($reqval->eqca_accode)?$reqval->eqca_accode:'';

				$recd_description = !empty($reqval->recd_description)?$reqval->recd_description:'';

				$recd_amount = !empty($reqval->recd_amount)?$reqval->recd_amount:'';

				$distributor = !empty($reqval->dist_distributor)?$reqval->dist_distributor:'';

				foreach($drCrArray as $value){
					$post_detail_array[] = array(
						"aC_Code" => !empty($eqca_accode)?(int)$eqca_accode:0, // acc code according to api
						"drCr" => $value,
						"description" => !empty($recd_description)?$recd_description:"test",
						"amount" => !empty($recd_amount)?(float)$recd_amount:0,
						"costCenter_ID" => 1,
						"acC_NAME" => !empty($distributor)?$distributor:"0" // supplier name
					);
				}
			}
		endif;

		// echo "<pre>";
		// $detail_array = array(
		// 	'offTranDetModel' => $post_detail_array
		// );

		// print_r($post_detail_array);
		// die();

		// echo "-----------";
		// echo "<br/>";

		//POST ARRAY
		// echo "<pre>";

		// $master_array = array(
		// 	'offTranModel'=> $post_master_array
		// );
			$master_array=array();
			
		// if(!empty($post_detail_array)):
		// 	foreach($post_detail_array as $key=>$value){
		// 		$detail_array[] = array(
		// 			'offTranDetModel' => $value
		// 		);
				
		// 	}
		// endif;
		// echo "<pre>";
		// print_r($post_master_array);
		// die();

		$dtl_arr ='';
		$dtl_arr .= '{"offTranModel": '.json_encode($post_master_array).',';
		if(!empty($post_detail_array)):
			foreach($post_detail_array as $key=>$value){
				// $detail_array = array(
				// 	'offTranDetModel'=>array($value)
				// );
					$dtl_arr .= '"offTranDetModel":['.json_encode($value).']'.',';				
				// print_r($post_detail_array);

				// $test[] = $detail_array;
					
			}
		endif;
		$dtl_arr = rtrim($dtl_arr,',');
		$dtl_arr.= '}';
		// $dtl_arr['offTranDetModel']=$dtl_arr;
		// $master_array['offTranModel']=$dtl_arr;
		// echo "<pre>";
		// print_r($dtl_arr);
		// echo "---";

		// print_r($dtl_arr);
		// $arr_push=array_merge($master_array, $dtl_arr);

		// echo json_encode($arr_push);
		// die();

		// $post_array = array_merge($master_array,$detail_array);

		// print_r($post_array);

		// $post_json = json_encode($post_array);
		// echo $post_json;
		// die();

		// $post_json = '{
		//   "offTranModel": {
		//     "tranDate": "string",
		//     "voucherType": "1",
		//     "voucherNo": "123",
		//     "office_ID": 40,
		//     "entryBY": "awtadmin",
		//     "narration": "test for inventory transaction"
		//   },
		//   "offTranDetModel": [
		//     {
		//       "aC_Code": 202100,
		//       "drCr": "Dr",
		//       "description": "test for dr",
		//       "amount": 5000,
		//       "costCenter_ID": 1,
		//       "acC_NAME": "test supplier"
		//     }
		//   ],
		//   "offTranDetModel": [
		//     {
		//       "aC_Code": 202125,
		//       "drCr": "Cr",
		//       "description": "test for cr",
		//       "amount": 2500,
		//       "costCenter_ID": 1,
		//       "acC_NAME": "test supplier"
		//     }
		//   ],
		//   "offTranDetModel": [
		//     {
		//       "aC_Code": 202130,
		//       "drCr": "Cr",
		//       "description": "test for Cr 2nd",
		//       "amount": 2500,
		//       "costCenter_ID": 1,
		//       "acC_NAME": "test supplier"
		//     }
		//   ]
		// }';

		$post_json = $dtl_arr;

		$api_url = KUKL_API_URL.'InventoryService/CurrentAssetsImport'.KUKL_API_KEY;

		// $api_url = "http://xelwel.com.np/kukl/api/api_kukl/save_api_post_data";
		// print_r($api_url);
		// die();

		// $post_json = '{"offTranModel": {"tranDate":"string","voucherType":"1","voucherNo":"1","office_ID":40,"entryBY":"awtadmin","narration":"test"},"offTranDetModel":[{"aC_Code":202125,"drCr":"Cr","description":"test","amount":520000,"costCenter_ID":1,"acC_NAME":"test"}],"offTranDetModel":[{"aC_Code":202130,"drCr":"Dr","description":"test","amount":65000,"costCenter_ID":1,"acC_NAME":"test"}]}';

		// $post_json = '{"offTranModel": {"tranDate":"2076.08.09","voucherType":"1","voucherNo":"RCH001","office_ID":40,"entryBY":"inventory_kir","narration":"0"},"offTranDetModel":[{"aC_Code":301120,"drCr":"Cr","description":"0","amount":520000,"costCenter_ID":0,"acC_NAME":"REAL DIAGNOSTIC SUPPLIERS"}],"offTranDetModel":[{"aC_Code":301115,"drCr":"Cr","description":"0","amount":65000,"costCenter_ID":0,"acC_NAME":"REAL DIAGNOSTIC SUPPLIERS"}]}';

		// $post_json ='{"offTranModel": {"tranDate":"2076.08.09","voucherType":"1","voucherNo":"RCH001","office_ID":40,"entryBY":"inventory_kir","narration":"test"},"offTranDetModel":[{"aC_Code":301120,"drCr":"Dr","description":"test","amount":520000,"costCenter_ID":1,"acC_NAME":"REAL DIAGNOSTIC SUPPLIERS"}],"offTranDetModel":[{"aC_Code":301120,"drCr":"Cr","description":"test","amount":520000,"costCenter_ID":1,"acC_NAME":"REAL DIAGNOSTIC SUPPLIERS"}],"offTranDetModel":[{"aC_Code":301115,"drCr":"Dr","description":"test","amount":65000,"costCenter_ID":1,"acC_NAME":"REAL DIAGNOSTIC SUPPLIERS"}],"offTranDetModel":[{"aC_Code":301115,"drCr":"Cr","description":"test","amount":65000,"costCenter_ID":1,"acC_NAME":"REAL DIAGNOSTIC SUPPLIERS"}]}';

		// $post_json = '{
  // "offTranModel": {
  //   "tranDate": "string",
  //   "voucherType": "1",
  //   "voucherNo": "123",
  //   "office_ID": 40,
  //   "entryBY": "awtadmin",
  //   "narration": "test for inventory transaction"
  // },
  // "offTranDetModel": [
  //   {
  //     "aC_Code": 202100,   
  //     "drCr": "Dr",
  //     "description": "test for dr",
  //     "amount": 2000,
  //     "costCenter_ID": 1,
  //     "acC_NAME": "ABC supplier"
  //   }
  // ],
  // "offTranDetModel": [
  //   {
  //     "aC_Code": 202100, 
  //     "drCr": "Cr",
  //     "description": "test for cr",
  //     "amount": 2000,
  //     "costCenter_ID": 1,
  //     "acC_NAME": "ABC supplier"
  //   }
  // ],
  // "offTranDetModel": [
  //   {
  //     "aC_Code": 202130,  
  //     "drCr": "Dr",
  //     "description": "test for Dr 2nd",
  //     "amount": 2500,
  //     "costCenter_ID": 1,
  //     "acC_NAME": "XYZ supplier"
  //   }
  // ],
  // "offTranDetModel": [
  //   {
  //     "aC_Code": 202130, 
  //     "drCr": "Cr",
  //     "description": "test for Cr 2nd",
  //     "amount": 2500,
  //     "costCenter_ID": 1,
  //     "acC_NAME": "XYZ supplier"
  //   }
  // ]}';

		$client = curl_init($api_url);
		
		curl_setopt($client, CURLOPT_CUSTOMREQUEST, "POST");
		
		curl_setopt($client, CURLOPT_HTTPHEADER, array(
	    'Content-Type: application/json',
	    'Content-Length: ' . strlen($post_json))
	    );

	    // curl_setopt($client, CURLOPT_POST, true);
	    // curl_setopt($client, CURLOPT_POSTFIELDS, $post_json);
	    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($client, CURLOPT_POSTFIELDS, $post_json);
	    curl_setopt($client, CURLOPT_FOLLOWLOCATION, 1); 

	    $response = curl_exec($client);

	    curl_close($client);

	    echo $response;
	    return true;
		   
	}

	public function post_api_import_asset_with_issueno($issue_no){
		$issue_detail_list =$this->Api_kukl_mdl->get_issue_detail(array('sd.sade_salemasterid'=>$issue_no));

		$issue_no = !empty($issue_detail_list[0]->sama_invoiceno)?$issue_detail_list[0]->sama_invoiceno:'';

		$issue_date = !empty($issue_detail_list[0]->sama_billdatebs)?$issue_detail_list[0]->sama_billdatebs:'';

		$issue_date_conv = str_replace("/", ".", $issue_date);

		$departmentid = !empty($issue_detail_list[0]->sama_depid)?$issue_detail_list[0]->sama_depid:'';

		$postusername = !empty($issue_detail_list[0]->sama_username)?$issue_detail_list[0]->sama_username:'';

		$locationid = !empty($issue_detail_list[0]->sama_locationid)?$issue_detail_list[0]->sama_locationid:'';

		$master_remarks = !empty($issue_detail_list[0]->sama_remarks)?$issue_detail_list[0]->sama_remarks:'';

		$post_master_array = array(
			"tranDate" => !empty($issue_date_conv)?$issue_date_conv:"0", //2076.01.20
		    "voucherType" => "1",
		    "voucherNo" => !empty($issue_no)?$issue_no:"0", 
		    "office_ID" => 40,
		    "entryBY" => !empty($postusername)?$postusername:"0",
		    "narration" => !empty($master_remarks)?$master_remarks:"0"
		);

		if(!empty($issue_detail_list)):
			$drCrArray = array('Dr','Cr');
			foreach($issue_detail_list as $isskey=>$issval){
				$itemsid = !empty($issval->sade_itemsid)?$issval->sade_itemsid:'';

				$accode = !empty($issval->eqca_accode)?$issval->eqca_accode:'';

				$description = !empty($issval->sade_remarks)?$issval->sade_remarks:'';

				$qty = !empty($issval->sade_qty)?$issval->sade_qty:'';
				$unitrate = !empty($issval->sade_unitrate)?$issval->sade_unitrate:'';
				$total_amount = $qty*$unitrate;

				$issue_amount = !empty($total_amount)?$total_amount:'';

				$distributor = !empty($issval->dist_distributor)?$issval->dist_distributor:'';

				$receive_by = !empty($issval->sama_receivedby)?$issval->sama_receivedby:'';

				foreach($drCrArray as $value){
					$post_detail_array[] = array(
						"aC_Code" => !empty($accode)?(int)$accode:0, // acc code according to api
						"drCr" => $value,
						"description" => !empty($description)?$description:"0",
						"amount" => !empty($issue_amount)?(float)$issue_amount:0,
						"costCenter_ID" => 1,
						"acC_NAME" => !empty($receive_by)?$receive_by:"0" // receiver name
					);
				}
			}
		endif;
		
		$master_array=array();

		$dtl_arr ='';
		$dtl_arr .= '{"offTranModel": '.json_encode($post_master_array).',';
		if(!empty($post_detail_array)):
			foreach($post_detail_array as $key=>$value){
		
					$dtl_arr .= '"offTranDetModel":['.json_encode($value).']'.',';				
					
			}
		endif;
		$dtl_arr = rtrim($dtl_arr,',');
		$dtl_arr.= '}';
		
		$post_json = $dtl_arr;

		// $ch = curl_init("http://xelwel.com.np");    // initialize curl handle

		// // curl_setopt($ch, CURLOPT_PROXY, "http://google.com"); //your proxy url
		// // curl_setopt($ch, CURLOPT_PROXYPORT, "80"); // your proxy port number
		// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		// $data = curl_exec($ch);
		// print($data);

		print_r($post_json);
		die();

		$api_url = KUKL_API_URL.'InventoryService/CurrentAssetsImport'.KUKL_API_KEY;

		// $api_url = base_url('api/api_kukl/get_post_data_issue');

		// $api_url = "https://xelwel.com.np/kukl/api/api_kukl/get_post_data_issue";

		// echo $api_url;

		$client = curl_init($api_url);

		// var_dump($client);
		// die();

		// curl_setopt($client, CURLOPT_SSL_VERIFYPEER, 0); //used  On dev server only!
		// curl_setopt($client, CURLOPT_SSL_VERIFYPEER, FALSE);//other way
		// curl_setopt($client, CURLOPT_PROXY, FALSE);//other way
		
		curl_setopt($client, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($client, CURLOPT_HEADER, 0);
		curl_setopt($client, CURLOPT_HTTPHEADER, array(
	    'Content-Type: application/json',
	    'Content-Length: ' . strlen($post_json))
	    );

	    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($client, CURLOPT_POSTFIELDS, $post_json);
	    curl_setopt($client, CURLOPT_FOLLOWLOCATION, 1); 

	    // $httpCode = curl_getinfo($client , CURLINFO_HTTP_CODE);

	    $response = curl_exec($client);
		
		if ($response === false) {
		    $response = curl_error($client);
		}else{
			return $response;
		}

	    curl_close($client);

	    // print_r(curl_getinfo($client));

	    // echo $httpCode;

	    // print_r($response);
	    // echo $response;
	    // return true;
	}

	public function get_post_data_issue(){

		// var_dump(extension_loaded('curl'));

		// if(in_array  ('curl', get_loaded_extensions())) {
		//     echo "CURL is available on your web server";
		// }
		// else{
		//     echo "CURL is not available on your web server";
		// }

		// echo "test";

		header("Content-Type:application/json");
		$data = json_decode(file_get_contents('php://input'), true);
		// print_r($data);	

		$master_data = $data['offTranModel']['office_ID'];
		
		// print_r($master_data);

		$array = array(
			'value'=>$master_data
		);

		$this->db->insert('test_api',$array);
		
		print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));

	}

	// public function test_api_url(){
	// 	$ch = curl_init("https://xelwel.com.np");    // initialize curl handle
	// 	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	// 	$data = curl_exec($ch);

	// 	if ($data === false) {
	// 	    $response = curl_error($ch);
	// 	    print($response);
	// 	}else{
	// 		echo $data;
	// 	}
	// }

	public function post_api_direct_purchase($issue_no){
	// echo "Test";
	// die();

		$issue_detail_list =$this->Api_kukl_mdl->get_issue_direct_purchase(array('sd.sade_salemasterid'=>$issue_no));

		$issue_no = !empty($issue_detail_list[0]->sama_invoiceno)?$issue_detail_list[0]->sama_invoiceno:'';

		$issue_date = !empty($issue_detail_list[0]->sama_billdatebs)?$issue_detail_list[0]->sama_billdatebs:'';

		$issue_date_conv = str_replace("/", ".", $issue_date);

		$departmentid = !empty($issue_detail_list[0]->sama_depid)?$issue_detail_list[0]->sama_depid:'';

		$postusername = !empty($issue_detail_list[0]->sama_username)?$issue_detail_list[0]->sama_username:'';

		$locationid = !empty($issue_detail_list[0]->sama_locationid)?$issue_detail_list[0]->sama_locationid:'';

		$master_remarks = !empty($issue_detail_list[0]->sama_remarks)?$issue_detail_list[0]->sama_remarks:'';

		$post_master_array = array(
			"tranDate" => !empty($issue_date_conv)?$issue_date_conv:"0", //2076.01.20
		    "voucherType" => "1",
		    "voucherNo" => !empty($issue_no)?$issue_no:"0", 
		    "office_ID" => 40,
		    "entryBY" => !empty($postusername)?$postusername:"0",
		    "narration" => !empty($master_remarks)?$master_remarks:"0"
		);

		if(!empty($issue_detail_list)):
			$drCrArray = array('Dr','Cr');
			foreach($issue_detail_list as $isskey=>$issval){
				$itemsid = !empty($issval->sade_itemsid)?$issval->sade_itemsid:'';

				$accode = !empty($issval->eqca_accode)?$issval->eqca_accode:'';

				$description = !empty($issval->sade_remarks)?$issval->sade_remarks:'';

				$qty = !empty($issval->sade_qty)?$issval->sade_qty:'';
				$unitrate = !empty($issval->sade_unitrate)?$issval->sade_unitrate:'';
				$total_amount = $qty*$unitrate;

				$issue_amount = !empty($total_amount)?$total_amount:'';

				$distributor = !empty($issval->dist_distributor)?$issval->dist_distributor:'';

				$receive_by = !empty($issval->sama_receivedby)?$issval->sama_receivedby:'';

				foreach($drCrArray as $value){
					$post_detail_array[] = array(
						"aC_Code" => !empty($accode)?(int)$accode:0, // acc code according to api
						"drCr" => $value,
						"description" => !empty($description)?$description:"0",
						"amount" => !empty($issue_amount)?(float)$issue_amount:0,
						"costCenter_ID" => 1,
						"acC_NAME" => !empty($receive_by)?$receive_by:"0" // receiver name
					);
				}
			}
		endif;
		
		$master_array=array();

		$dtl_arr ='';
		$dtl_arr .= '{"offTranModel": '.json_encode($post_master_array).',';
		if(!empty($post_detail_array)):
			foreach($post_detail_array as $key=>$value){
		
					$dtl_arr .= '"offTranDetModel":['.json_encode($value).']'.',';				
					
			}
		endif;
		$dtl_arr = rtrim($dtl_arr,',');
		$dtl_arr.= '}';
		
		$post_json = $dtl_arr;

		// print_r($post_json);
		// die();

		// $api_url = KUKL_API_URL.'InventoryService/CurrentAssetsImport'.KUKL_API_KEY;

		$api_url = base_url('api/api_kukl/get_post_data_issue');

		// $api_url = "https://xelwel.com.np/kukl/api/api_kukl/get_post_data_issue";

		$client = curl_init($api_url);

		// var_dump($client);
		// die();
		
		curl_setopt($client, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($client, CURLOPT_HEADER, 0);
		curl_setopt($client, CURLOPT_HTTPHEADER, array(
	    'Content-Type: application/json',
	    'Content-Length: ' . strlen($post_json))
	    );

	    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($client, CURLOPT_POSTFIELDS, $post_json);
	    curl_setopt($client, CURLOPT_FOLLOWLOCATION, 1); 

	    // $httpCode = curl_getinfo($client , CURLINFO_HTTP_CODE);

	    $response = curl_exec($client);
		
		// if ($response === false) {
		//     $response = curl_error($client);
		// }else{
		// 	return $response;
		// }

	    echo "<pre>";
		// print_r(curl_getinfo($client));
		$check_response = json_decode($response);

		if($check_response->status == 'success'){
			$this->update_api_transaction($issue_no);
		}
		die();

	    curl_close($client);

	    // echo $httpCode;

	    // print_r($response);
	    // echo $response;
	    // return true;
	}
	public function get_post_data_direct_purchase(){

		// var_dump(extension_loaded('curl'));

		// if(in_array  ('curl', get_loaded_extensions())) {
		//     echo "CURL is available on your web server";
		// }
		// else{
		//     echo "CURL is not available on your web server";
		// }

		// echo "test";

		header("Content-Type:application/json");
		$data = json_decode(file_get_contents('php://input'), true);
		// print_r($data);	

		$master_data = $data['offTranModel']['office_ID'];
		
		// print_r($master_data);

		$array = array(
			'value'=>$master_data
		);

		$this->db->insert('test_api',$array);
		
		print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));

	}

	public function update_api_transaction($tran_no){
		$api_url = KUKL_API_URL.'InventoryService/TransactionLog'.KUKL_API_KEY;

		// {
		// 	"tranNo": 0,
		// 	"status": 0,
		// 	"message": "string",
		// 	"created_By": "string",
		// 	"updated_By": "string"
		// }

		$tran_array = array(
			'tranNo' => (int)$tran_no,
			'status' => 0,
			'message' => 'export',
			'created_By' => '',
			'updated_By' => ''
		);

		$post_json = json_encode($tran_array);

		// print_r($post_json);
		// die();

		$client = curl_init($api_url);
		
		curl_setopt($client, CURLOPT_CUSTOMREQUEST, "POST");
		
		curl_setopt($client, CURLOPT_HTTPHEADER, array(
	    'Content-Type: application/json',
	    'Content-Length: ' . strlen($post_json))
	    );
	    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($client, CURLOPT_POSTFIELDS, $post_json);
	    curl_setopt($client, CURLOPT_FOLLOWLOCATION, 1); 

	    $response = curl_exec($client);

	    echo "<pre>";
	    print_r($response);
	    die();

	    curl_close($client);

	    echo $response;
	}

	public function api_manage_item()
	{
		$this->db->select('DISTINCT(itli_itemname) as itemname');
		$this->db->from('itli_itemslist');
		$this->db->order_by("itli_itemname","ASC");
		$sesult_olditem=$this->db->get()->result();
		$old_itemarr=array();
		foreach ($sesult_olditem as $ki => $val) {
		$old_itemarr[]=trim($val->itemname);
		}

		// echo "<pre>";
		// print_r($old_itemarr);
		// die();

		$rslt_item_manage=$this->db->query("SELECT DISTINCT(itemname) as itemname FROM xw_manage_item")->result();
		// echo "<pre>";
		// print_r($rslt_item_manage);
		// die();
		if(!empty($rslt_item_manage)){
			foreach ($rslt_item_manage as $kim => $im) {
				if(!in_array($im->itemname, $old_itemarr)){
					$itemarr=array('itli_itemname'=>$im->itemname,'itli_materialtypeid'=>1,'itli_catid'=>4,'itli_unitid'=>35);
					$this->db->insert('itli_itemslist',$itemarr);
					$lastid=$this->db->insert_id();
					if(!empty($lastid)){
						$update_arr=array('new_itemsid'=>$lastid);
						$this->db->update('xw_manage_item',$update_arr,array('itemname'=>$im->itemname));
						$rw=$this->db->affected_rows(); 
						if($rw){
							echo "Item Update INTO  xw_manage_item with ID <br>";
						}
						else{
				            echo "Item Synch Fail !!<br>";
				            }
						flush();
						ob_flush();
					}
				}
				else{

					$this->db->select('itli_itemlistid');
					$this->db->from('itli_itemslist');
					$this->db->where('itli_itemname',$im->itemname);
					$this->db->order_by('itli_itemlistid','ASC');
					$rslt_item=$this->db->get()->row();
					if(!empty($rslt_item)){
						$update_arr=array('new_itemsid'=>$rslt_item->itli_itemlistid);
						$this->db->update('xw_manage_item',$update_arr,array('itemname'=>$im->itemname));
						$rw=$this->db->affected_rows(); 
						if($rw){
							echo "Item Update INTO  xw_manage_item with ID <br>";
						}
						else{
				            echo "Item Synch Fail !!<br>";
				            }
						flush();
						ob_flush();

					}

				}
			}
		}	
	}

	public function manage_req_detail_with_item_id(){
		$this->db->select('rede_reqdetailid,rede_itemsid,new_itemsid');
		$this->db->from('manage_item');
		$this->db->order_by('rede_reqdetailid','ASC');
		$result_manage_itemlist=$this->db->get()->result();
		// echo "<pre>";
		// print_r($result_manage_itemlist);
		// die();
		if(!empty($result_manage_itemlist)){
			foreach ($result_manage_itemlist as $kmi => $ritem) {
				$requpdatearray=array('rede_itemsid'=>$ritem->new_itemsid);
				$searcharray=array('rede_itemsid'=>$ritem->rede_itemsid,'rede_reqdetailid'=>$ritem->rede_reqdetailid);
				$this->db->update('rede_reqdetail',$requpdatearray,$searcharray);
				$rw=$this->db->affected_rows(); 
						if($rw){
							echo "Req Detail Update INTO  xw_rede_reqdetail with item ID $ritem->new_itemsid  <br>";
						}
						else{
				            echo "Req Detail Update  Fail !!<br>";
				            }
						flush();
						ob_flush();

			}
		}
	}

	public function item_code_generate(){
		$this->db->select('DISTINCT(itli_catid) as catid,eqca_code');
		$this->db->from('xw_itli_itemslist as il');
		$this->db->join('eqca_equipmentcategory as ec','ec.eqca_equipmentcategoryid=il.itli_catid','LEFT');

		// $this->db->from('')
		// $this->db->where('itli_itemcode IS NULL');
		$this->db->order_by('itli_catid','ASC');
		$result_item_cat=$this->db->get()->result();
		// echo "<pre>";
		// print_r($result_item_cat);
		// die();
		if(!empty($result_item_cat)){
			foreach ($result_item_cat as $ric => $cat) {
						$this->db->select('itli_itemlistid,itli_itemcode');
						$this->db->from('xw_itli_itemslist');
						// $this->db->from('')
						$this->db->where('itli_catid',$cat->catid);
						// $this->db->where('itli_itemcode IS NULL');
						$this->db->order_by('itli_itemname','ASC');
						$result_item=$this->db->get()->result();
						if(!empty($result_item)){
							$i=1;
							$codearr='0';
							foreach ($result_item as $kri => $itm) {
									$eqcode=$cat->eqca_code;
										$codearr=$codearr+1;
										$item_string=str_pad($codearr, ITEM_CODE_NO_LENGTH, 0, STR_PAD_LEFT);
									 			// die();
									 	$itmcode=$eqcode.$item_string;
									 	
									 	$this->db->update('xw_itli_itemslist',array('itli_itemcode'=>$itmcode),array('itli_itemlistid'=>$itm->itli_itemlistid));
									 	echo $itmcode;
									 	echo "<br>";
									 	flush();
										ob_flush();
									 	$i++;
								}
							
							}
			}
		
		}

		// }
	}

	public function manage_unknown_item_on_reqdetail()
	{
		$unknown_itemid='1339';
		$this->db->select('purd_reqid,purd_reqdetailid,purd_itemsid,rede_itemsid');
		$this->db->from('purd_purchasereqdetail pd');
		$this->db->join('rede_reqdetail rd','rd.rede_reqdetailid=pd.purd_reqdetailid');
		$this->db->where('purd_itemsid',$unknown_itemid);
		$this->db->order_by('purd_reqid');
		$result=$this->db->get()->result();
		// echo "<pre>";
		// print_r($result);
		// die();
		if(!empty($result)){
			foreach ($result as $kr => $val) {
				$purd_reqid=$val->purd_reqid;
				$purd_reqdetailid=$val->purd_reqdetailid;
				$purd_itemsid=$val->purd_itemsid;
				$rede_itemsid=$val->rede_itemsid;
				$this->db->update('purd_purchasereqdetail',array('purd_itemsid'=>$rede_itemsid),array('purd_reqid'=>$purd_reqid,'purd_reqdetailid'=>$purd_reqdetailid));
				$rw=$this->db->affected_rows(); 
				if($rw){
					echo "Update Unknown Item To known Item in  $purd_reqid <br>";
				}
				else{
		            echo "Update Fail !!<br>";
		            }
				flush();
				ob_flush();

			}
		}
	}

	public function replace_duplicate_itemcode(){
		$duplicates = $this->db->query("SELECT GROUP_CONCAT(itli_itemlistid) as items_id , itli_itemcode, count(*) as cnt FROM xw_itli_itemslist as il GROUP BY itli_itemcode HAVING cnt > 1")->result();
		
		// echo "<pre>"; 
		// print_r ($duplicates);
		// echo "</pre>";

		$this->db->trans_begin();
		try{
		if (!empty($duplicates)) {
			foreach ($duplicates as $duplicate) {
				$items = !empty($duplicate->items_id) ? explode(',', $duplicate->items_id) : [] ;
				if (!empty($items)) {
					$count = count($items);
					for($i = 1; $i <= $count; $i++){
						$item_id = $items[$i];
						$this->db->select('it.*,ec.eqca_code,ec.eqca_category');
						$this->db->from('itli_itemslist it');
						$this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid=it.itli_catid', 'LEFT');
						$this->db->where("itli_itemlistid = $item_id");
						$item_detail = $this->db->get()->row();

						if (!empty($item_detail)) {
							$new_item_code = $this->generate_itemcode($item_detail->eqca_code,$item_detail->itli_catid);
							echo "<pre>";
							print_r ($new_item_code);
							echo "</pre>"; 
							$this->db->update('itli_itemslist',['itli_itemcode' => $new_item_code],['itli_itemlistid' => $item_id]);
							$this->db->update('rede_reqdetail',['rede_code' => $new_item_code],['rede_itemsid' => $item_id]);
						}
					}	
							
				}		
			}
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {

				$this->db->trans_rollback();
				print_r("transaction commit failed");

			} else {

				$this->db->trans_commit();
				print_r("success");
			}		
			
		}

		}catch(Exception $e){
			$this->db->trans_rollback();
			print_r ($e->getLine().'-'.$e->getMessage());
		}
	}

	public function generate_itemcode($category_code = '', $category_id = 0)
	{
		$itemcode = '';
		$this->db->select('it.itli_itemcode');
		$this->db->from('itli_itemslist it');
		$this->db->where("itli_catid = $category_id");
		$this->db->where("itli_itemcode like '$category_code%'");
		$this->db->order_by("itli_itemcode DESC");
		$itemdata = $this->db->get()->row();
		// echo $this->db->last_query();		
		// echo "<pre>";
		// print_r ($itemdata);
		// echo "</pre>";
		if ($itemdata) {
			$itemcode = $itemdata->itli_itemcode  ?? '';
			
			$number = str_replace($category_code,'',$itemcode);
			$number = (int) filter_var($number, FILTER_SANITIZE_NUMBER_INT); 
			// echo $number ."<br>";
			// echo $number1; 
			if (!empty($number)) { 
				$number = $number;
			} else {
				$number = 0;
			}
			$item_string = str_pad($number + 1, ITEM_CODE_NO_LENGTH, 0, STR_PAD_LEFT);
			$itmcode = $category_code . $item_string;
		} else {
			$itmcode = $category_code . str_pad($number + 1, ITEM_CODE_NO_LENGTH, 0, STR_PAD_LEFT);
		}
		// echo $itmcode;
		return $itmcode; 
	}
	
}