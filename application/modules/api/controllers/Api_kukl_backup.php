<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
		$json = file_get_contents(KUKL_API_URL.'InventoryService/AcChartHead'.KUKL_API_KEY,false,$context);
		
		$data_cat = json_decode($json);

		if(!empty($data_cat)){
			foreach($data_cat as $key => $value){
				$array = array(
					'acty_catid' => 2,
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

	public function get_kukl_kvwsmbcapital()
	{
		$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
		$context = stream_context_create($opts);
		$json = file_get_contents(KUKL_API_URL.'InventoryService/KVWSMBCapital'.KUKL_API_KEY,false,$context);
		
		$data_cat = json_decode($json);

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

		// $api_url = base_url('api/api_kukl/get_post_data_issue');

		$api_url = "https://xelwel.com.np/kukl/api/api_kukl/get_post_data_issue";


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
	
}