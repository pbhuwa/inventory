<?php
ini_set('max_execution_time', 0); 
ini_set('memory_limit','2048M');
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test extends CI_Controller
{
	function __construct()
	{

		parent::__construct();
		$this->load->Model('test_mdl');
		$this->load->Model('stock_requisition_mdl','requisition_mdl');
		$this->load->Model('stock_inventory/stock_requisition_mdl');

		$this->username = $this->session->userdata(USER_NAME);
		$this->deptid = $this->session->userdata(USER_DEPT);
		$this->userid = $this->session->userdata(USER_ID);
		$this->locationid=$this->session->userdata(LOCATION_ID);
		if(defined('LOCATION_CODE')):
			$this->locationcode=$this->session->userdata(LOCATION_CODE);
		endif;
		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		$this->orgid=$this->session->userdata(ORG_ID);

		
	}
	// public function index()
	// {   

	// }
	public function issuedetails()
	{
		if($this->session->userdata(USER_GROUPCODE)=='SA'){
			$this->data['department']=$this->general->get_tbl_data('*','dept_department',false);

		}else{
			$this->data['department']=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$this->deptid));

		}
		
		$this->data['tab_type']='issuedetails';
		$this->data['apptype'] = '';
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
		->build('test/v_test_common', $this->data);
	}


	public function test_itemlist()
	{
		
		$this->data['tab_type']='testitemlist';
		$this->data['apptype'] = '';
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
		->build('test/v_test_common', $this->data);
	}
	public function edit_test_item()
	{
		$id=$this->input->post('id');
		if($id){
		// echo $id;die;
	// $this->data['test_itemdata']=$this->general->get_tbl_data('*','tena_testname',array('tena_id'=>$id));
	// print_r($this->data['test_itemdata']);die();
			$this->data['test_itemdata']=$this->test_mdl->get_all_test_item_table_all(array('tena_id'=>$id),false,false,false,false);
	 $this->data['itemmap_data']=$this->test_mdl->get_all_item_details(array('tema_testnameid'=>$id),false,false,false,false);
	 // print_r($this->data['test_itemdata']);die();
	}else{
	     $this->data['test_itemdata']='';
          $this->data['itemmap_data']='';
      }
		$this->data['tab_type']='editform';
		$this->data['apptype'] = '';
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
		->build('test/v_test_common', $this->data);
	}
	public function test_item_list()
	{	
		
		$data = $this->test_mdl->TestItemList(false);
		  // echo "<pre>"; print_r($data); die();
		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);
		foreach($data as $row)
		{
			
			if($row->tena_isactive=='1'){
				$status="Yes";
			} else {
				$status="No";
			}
			$array[$i]["sno"] = $i+1;
			$array[$i]["id"] = $row->tena_mid;
			$array[$i]["code"] = $row->tena_code;
			$array[$i]["name"] = $row->tena_name;
			$array[$i]["postdatebs"] = $row->tena_postdatebs;
			$array[$i]["postdatead"] = $row->tena_postdatead;
			$array[$i]["status"] = $status;
			$array[$i]["action"] = '<a href="javascript:void(0)" data-id='.$row->tena_id.' data-displaydiv="editform" data-viewurl='.base_url('issue_consumption/test/edit_test_item').' class="btnredirect btn-info btn-xxs" data-heading="Add Item to test item" title="Save to itemmap"  ><i class="fa fa-plus " aria-hidden="true" ></i></a><a href="javascript:void(0)" data-id='.$row->tena_id.' data-displaydiv="orderDetails" data-viewurl='.base_url('issue_consumption/test/view_test_item_details').' class="view btn-primary btn-xxs" data-heading="Item Test Details" ><i class="fa fa-eye" aria-hidden="true" ></i></a> ';
			
			$i++;
		}
		echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function view_test_item_details(){

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$id = $this->input->post('id');
		;
      $this->data['test_itemdata']=$this->general->get_tbl_data('*','tena_testname',array('tena_id'=>$id));
       $this->data['itemmap']=$this->test_mdl->get_all_item_details(array('tema_testnameid'=>$id),false,false,false,false);

		$tempform='';
		$tempform =$this->load->view('test/v_test_item_view',$this->data,true);

		if(!empty($tempform))
		{
			print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$tempform)));
			exit;
		}
		else

		{
			print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));
			exit;
		}

	}

	else

	{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}

}
public function edit_popup(){

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$id=$this->input->post('id');
		// echo $id;die;
	$this->data['test_itemdata']=$this->general->get_tbl_data('*','tena_testname',array('tena_id'=>$id));
	 $this->data['itemmap_data']=$this->test_mdl->get_all_item_details(array('tema_testnameid'=>$id),false,false,false,false);

		$tempform='';
		$tempform =$this->load->view('test/v_test_item_edit',$this->data,true);

		if(!empty($tempform))
		{
			print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$tempform)));
			exit;
		}
		else

		{
			print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));
			exit;
		}

	}

	else

	{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}

}
public function save_item_map()
	{
	 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
		  // echo "<pre>";print_r($this->input->post());
		$this->form_validation->set_rules($this->test_mdl->validate_test_item_map);

		$id = $this->input->post('tema_testmapid');

		if(!empty($id)){
			$variable="Update";

		}else{
			$variable="Save";

		}
// print_r($variable);die;
			
		if($this->form_validation->run()==TRUE)
		{   
	$trans = $this->test_mdl->save_item_name_to_map();
	 if($trans)
		{		

			print_r(json_encode(array('status'=>'success','message'=>'Record '.$variable.' Successfully.',)));
			exit;
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Unsuccessful Operation.')));
			exit;
		}
	}
	else
	{
		print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
		exit;
	}

} catch (Exception $e) {

	print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
}
}else
{
	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	exit;
}
}



public function issue_vs_expenses($analysis_type=false)
{
	// print_r($this->locationid);
	// 	die();
	$this->data['department']=$this->general->get_tbl_data('*','dept_department');

		// $this->data['department']=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$this->deptid));

	$this->data['items_name']=$this->general->get_tbl_data('*','itli_itemslist');
	$this->data['item_category']=$this->general->get_tbl_data('*','eqca_equipmentcategory');
		// print_r($this->data['department']);
	 // 	die();
	if($analysis_type)
	{
		$this->data['tab_type']=$analysis_type;
	}

		// $this->data['tab_type']=$tab_type;
	$this->data['apptype'] = '';
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
	->build('test/v_test_common', $this->data);
}



public function issue_details_list()
{  

	if(MODULES_VIEW=='N')
	{
		$array=array();
			 	// $this->general->permission_denial_message();
		echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
		exit;
	}

	$apptype = $this->input->get('apptype');
	$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	$i = 0;

	$data = $this->test_mdl->get_issue_book_details_list();
	  	// echo "<pre>";
	  	// print_r($data);
	  	// die();
	  	// echo $this->db->last_query();
	  	// die();

	$array = array();
	$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
	$totalrecs = $data["totalrecs"];
	unset($data["totalfilteredrecs"]);
	unset($data["totalrecs"]);
	if($apptype == 'cancel' || $apptype =='issue' || empty($apptype) ){
		foreach($data as $row)
		{
			if(ITEM_DISPLAY_TYPE=='NP'){
				$req_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
			}else{ 
				$req_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
			}


			$appclass='';
			$approved=$row->sama_st;
			if($approved=='C')
			{
				$appclass='cancel';
			}
			$array[$i]["approvedclass"] = $appclass;
			$array[$i]['salemasterid']=$row->sama_salemasterid;
			$array[$i]["invoiceno"]=$row->sama_invoiceno;
			$array[$i]["billdatebs"]=$row->sama_billdatebs;
			$array[$i]["billdatead"]=$row->sama_billdatead;
			$array[$i]["depname"]=$row->sama_depname;
			$array[$i]["received_qty"]=$row->sade_qty;
			$array[$i]["expenses_qty"]=!empty($row->expqty)?$row->expqty:'0.00';
			$array[$i]["remaining_qty"]=number_format((float)$row->sade_qty-$row->expqty, 2, '.', '');
			 	// round_to_2dp($row->sade_qty-$row->expqty);
			 	//number_format((float)$row->expqty, 2, '.', '');

			 	// $txt = sprintf("%f",$row->sade_qty-$row->expqty);
			$array[$i]["billtime"]=$row->sama_billtime;
			$array[$i]["unit_name"]=$row->unit_unitname;
			$array[$i]["itli_itemcode"]=$row->itli_itemcode;
			$array[$i]["itli_itemname"]=$req_itemname;
			$array[$i]["sade_remarks"]=$row->sade_remarks;
			$view_heading_var="Expenses Qty Entry";
			$array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->sama_salemasterid.'|'.$row->sade_itemsid.' data-displaydiv="orderDetails" data-viewurl='.base_url('issue_consumption/test/view_details').' class="view btn-primary btn-xxs" data-heading="'.$view_heading_var.'" ><i class="fa fa-eye" aria-hidden="true" ></i></a> ';
			$i++;


		}
	}
	echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
}




public function issue_vs_expenses_report()
{  

	if(MODULES_VIEW=='N')
	{
		$array=array();
			 	// $this->general->permission_denial_message();
		echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
		exit;
	}
			// $this->data['department']=$this->general->get_tbl_data('*','dept_department');

	$apptype = $this->input->get('apptype');
	$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	$i = 0;

	$data = $this->test_mdl->get_issue_vs_expenses_report();

	$array = array();
	$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
	$totalrecs = $data["totalrecs"];
	unset($data["totalfilteredrecs"]);
	unset($data["totalrecs"]);
	if($apptype == 'cancel' || $apptype =='issue' || empty($apptype) ){
		foreach($data as $row)
		{
			if(ITEM_DISPLAY_TYPE=='NP'){
				$req_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
			}else{ 
				$req_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
			}


			$appclass='';
			$approved=$row->sama_st;
			if($approved=='C')
			{
				$appclass='cancel';
			}
			$array[$i]["approvedclass"] = $appclass;
			$array[$i]['salemasterid']=$row->sama_salemasterid;
			$array[$i]["invoiceno"]=$row->sama_invoiceno;
			$array[$i]["billdatebs"]=$row->sama_billdatebs;
			$array[$i]["billdatead"]=$row->sama_billdatead;
			$array[$i]["depname"]=$row->sama_depname;
			$array[$i]["received_qty"]=$row->sade_qty;
			$array[$i]["expenses_qty"]='0';
			$array[$i]["remaining_qty"]='0';
			$array[$i]["billtime"]=$row->sama_billtime;
			$array[$i]["sade_unit"]=$row->unit_unitname;
			$array[$i]["itli_itemcode"]=$row->itli_itemcode;
			$array[$i]["itli_itemname"]=$req_itemname;
			$array[$i]["sade_remarks"]=$row->sade_remarks;
			$view_heading_var="Expenses Qty Entry";
			$array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->sama_salemasterid.'|'.$row->sade_itemsid.' data-displaydiv="orderDetails" data-viewurl='.base_url('issue_consumption/test/view_details').' class="view btn-primary btn-xxs" data-heading="'.$view_heading_var.'" ><i class="fa fa-eye" aria-hidden="true" ></i></a> ';
			$i++;


		}
	}
	echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
}


public function save_teststock()
{

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {

			$id=$this->input->post('id');
			$itemid=$this->input->post('test_itemid');
			$salemasterid=$this->input->post('test_salemasterid');
			$saledetailid=$this->input->post('test_saledetailid');
			$expensesqty=$this->input->post('test_expensesqty');

			$stock_rslt=$this->check_rem_qty_from_received_qty($salemasterid,$saledetailid,$itemid);
			if(!empty($stock_rslt)){
				$rem_qty=$stock_rslt->remqty;
			}
			else{
				$rem_qty=0;
			}


			if($expensesqty>$rem_qty || $expensesqty==0)
			{
				print_r(json_encode(array('status'=>'error','message'=>'Could not Allowed To Add Quantity')));
				exit;
			}


			$this->data['issue_master'] = $this->test_mdl->get_issue_book_details_list();


			// if($this->input->post('id'))
			// {
			// 	if(MODULES_UPDATE=='N')
			// 	{
			// 	$this->general->permission_denial_message();
			// 	exit;
			// 	}
			// }
			// else
			// {
			// 	if(MODULES_INSERT=='N')
			// 	{
			// 	$this->general->permission_denial_message();
			// 	exit;
			// 	}
			// }
			$this->form_validation->set_rules($this->test_mdl->validate_test_stock);
			
			if($this->form_validation->run()==TRUE)
			{
				

				$trans = $this->test_mdl->teststock_save();
				if($trans)
				{
					print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
					exit;
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
					exit;
				}

			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
				exit;
			}

		} catch (Exception $e) {

			print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
		}
	}
	else
	{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}
}

public function check_rem_qty_from_received_qty($smaterid,$sdetailid,$itemid)
{
	$result=$this->db->query("
		SELECT SUM(recqty) recqty, SUM(expqty) expqty, SUM(recqty-expqty) remqty FROM(
		SELECT SUM(sade_qty) recqty,0 as expqty  from xw_sade_saledetail 
		WHERE sade_salemasterid=$smaterid AND sade_saledetailid=$sdetailid AND sade_itemsid=$itemid  AND sade_status <>'C'
		UNION
		SELECT 0 recqty,SUM(test_expensesqty) as expqty  from xw_test_teststock
		WHERE test_salemasterid=$smaterid  AND test_saledetailid=$sdetailid AND  test_itemid=$itemid  AND test_status <> 'C' )X
		")->row();

	if(!empty($result)){
		return $result;
	}
	return false;

}

public function view_details(){

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$id = $this->input->post('id');
		$list_array=explode('|', $id);
		$salemasterid=$list_array[0];
		$itemid=$list_array[1];

		$this->data['issue_master']=$this->test_mdl->get_test_detail(array('sade_salemasterid'=>$salemasterid,'sade_itemsid'=>$itemid));		

		$this->data['test_count']=$this->test_mdl->get_all_count(array('test_itemid'=>$itemid,'test_salemasterid'=>$salemasterid));



		$this->data['test_list']=$this->test_mdl->get_all_data(array('test_itemid'=>$itemid,'test_salemasterid'=>$salemasterid));


		$tempform='';

		$tempform .=$this->load->view('test/v_test_details_view',$this->data,true);

		$tempform .=$this->load->view('test/v_test_stock_list',$this->data,true);

		if(!empty($tempform))
		{
			print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$tempform)));
			exit;
		}
		else

		{
			print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));
			exit;
		}

	}

	else

	{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}

}	

public function exportToExcelIssueDetails()
{
	header("Content-Type: application/xls");    
	header("Content-Disposition: attachment; filename=issue_details_list".date('Y_m_d_H_i').".xls");  
	header("Pragma: no-cache"); 
	header("Expires: 0");
	$data = $this->test_mdl->get_issue_book_details_list();
	$this->data['searchResult'] = $this->test_mdl->get_issue_book_details_list();
	$array = array();
	unset($this->data['searchResult']["totalfilteredrecs"]);
	unset($this->data['searchResult']["totalrecs"]);
	$response = $this->load->view('test/v_issue_details_download', $this->data, true);
	echo $response;
}

public function generate_pdfIssueDetails()
{	
	$this->data['searchResult'] = $this->test_mdl->get_issue_book_details_list();
        // echo "<pre>";
        // print_r($this->data['searchResult']);
        // die();

	unset($this->data['searchResult']["totalfilteredrecs"]);
	unset($this->data['searchResult']["totalrecs"]);

	$this->load->library('pdf');
	$mpdf = $this->pdf->load();
        //echo"<pre>"; print_r($this->data['searchResult']);die;
	ini_set('memory_limit', '256M');
	$html = $this->load->view('test/v_issue_details_download', $this->data, true);
	$mpdf = new mPDF('c', 'A4-L');
	if(PDF_IMAGEATEXT == '3')
	{
		$mpdf->SetWatermarkImage(PDF_WATERMARK);
		$mpdf->showWatermarkImage = true;
		$mpdf->showWatermarkText = true;  
		$mpdf->SetWatermarkText(ORGA_NAME);
	}
	if(PDF_IMAGEATEXT == '1')
	{
		$mpdf->SetWatermarkImage(PDF_WATERMARK);
		$mpdf->showWatermarkImage = true;
	} 
	if(PDF_IMAGEATEXT == '2')
	{
		$mpdf->showWatermarkText = true;  
		$mpdf->SetWatermarkText(ORGA_NAME);
	}
	$mpdf = new mPDF('utf-8', 'A4-L');
	$mpdf->SetAutoFont(AUTOFONT_ALL);
	$mpdf->WriteHTML($stylesheet, 1);
	$mpdf->WriteHTML($html);
	$output = 'issue_details_list'.date('Y_m_d_H_i').'.pdf';
	$mpdf->Output();
	exit();
}



public function exportToExcel(){
	header("Content-Type: application/xls");    
	header("Content-Disposition: attachment; filename=stock_requisition_".date('Y_m_d_H_i').".xls");  
	header("Pragma: no-cache"); 
	header("Expires: 0");

	$data = $this->store_requisition_mdl->get_store_requisition_list();

	$array = array();
	unset($data["totalfilteredrecs"]);
	unset($data["totalrecs"]);



	$response = '<table border="1">';
	$response .= '<tr><th colspan="7"><center>Store Requisition</center></th></tr>';
	$response .= '<tr><th >S.n.</th>
	<th>Req.No</th>
	<th>Req.Date(BS)</th>
	<th>Req.Date(AD)</th>
	<th>Req.Time</th>
	<th>Req.By</th>
	<th>F.Year</th>
	<th>Cost Center</th></tr>';

	$i=1;
	$iDisplayStart = !empty($_GET['iDisplayStart'])?$_GET['iDisplayStart']:0;
	foreach($data as $row){
		$sno = $iDisplayStart + $i; 
		$reqdatebs = $row->reno_reqdatebs;
		$reqdatead = $row->reno_reqdatead;
		$reqno = $row->reno_reqno;
		$reqtime = $row->reno_reqtime;
		$appliedby = $row->reno_appliedby;
		$fyear = $row->reno_fyear;
		$costcenter = $row->reno_costcenter;

		$response .= '<tr><td>'.$sno.'</td><td>'.$reqno.'</td><td>'.$reqdatebs.'</td><td>'.$reqdatead.'</td><td>'.$reqtime.'</td><td>'.$appliedby.'</td><td>'.$fyear.'</td><td>'.$costcenter.'</td></tr>';
		$i++;
	}

	$response .= '</table>';

	echo $response;
}


public function get_test_stock_list()
{
	
	$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
	$orgid = $this->session->userdata(ORG_ID);


	$data = $this->test_mdl->get_test_stock_list();


	$i = 0;
	$array = array();
	$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
	$totalrecs = $data["totalrecs"];

	unset($data["totalfilteredrecs"]);
	unset($data["totalrecs"]);

	foreach($data as $row)
	{


		$array[$i]["test_date_bs"] = $row->test_date_bs;
		$array[$i]["test_expenses_qty"] = $row->test_expenses_qty; 
		$array[$i]["action"] ='';

		$i++;

	}
	echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
}

public function exists_test_qty()
{
	$expenses_qty=$this->input->post('test_expensesqty');
	$input_id=$this->input->post('test_itemid');
	$expensesqty=$this->test_mdl->check_exit_test_qty_for_other($expenses_qty,$input_id);
	if($expensesqty)
	{
		$this->form_validation->set_message('exists_test_qty', 'Already Exit');
		return false;

	}
	else
	{
		return true;
	}

}


public function issue_expenses_report()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(MODULES_VIEW=='N')
		{

			print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
			exit;
		}

		$template = $this->issue_expenses_report_data();


		if(!empty($template))
		{
			print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','template'=>$template)));
			exit;
		}
		else{
			print_r(json_encode(array('status'=>'success','message'=>'No Record Found!!')));
			exit;
		}
	}else{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}  
}

public function category_wise_report()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(MODULES_VIEW=='N')
		{

			print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
			exit;
		}

		$template = $this->category_wise_report_data();


		if(!empty($template))
		{
			print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','template'=>$template)));
			exit;
		}
		else{
			print_r(json_encode(array('status'=>'success','message'=>'No Record Found!!')));
			exit;
		}
	}else{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}  
}
public function item_wise_report()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(MODULES_VIEW=='N')
		{

			print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
			exit;
		}

		$template = $this->item_wise_report_data();


		if(!empty($template))
		{
			print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','template'=>$template)));
			exit;
		}
		else{
			print_r(json_encode(array('status'=>'success','message'=>'No Record Found!!')));
			exit;
		}
	}else{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}  
}
public function department_wise_report()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(MODULES_VIEW=='N')
		{

			print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
			exit;
		}

		$template = $this->department_wise_report_data();


		if(!empty($template))
		{
			print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','template'=>$template)));
			exit;
		}
		else{
			print_r(json_encode(array('status'=>'success','message'=>'No Record Found!!')));
			exit;
		}
	}else{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}  
}
public function date_wise_report()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(MODULES_VIEW=='N')
		{

			print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
			exit;
		}

		$template = $this->date_wise_report_data();


		if(!empty($template))
		{
			print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','template'=>$template)));
			exit;
		}
		else{
			print_r(json_encode(array('status'=>'success','message'=>'No Record Found!!')));
			exit;
		}
	}else{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}  
}


public function issue_expenses_report_data(){
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$this->data['excel_url'] = "issue_consumption/test/generate_issue_expenses_report_excel";
		$this->data['pdf_url'] = "issue_consumption/test/generate_issue_expenses_report_pdf";

		$this->data['report_title'] ="Issue VS Expenses Report";


		$frmDate=$this->input->post('fromdate');
		$toDate=$this->input->post('todate');
		$locationid = $this->input->post('locationid');
		$supplierid = $this->input->post('supplierid');
		$sama_depid = $this->input->post('sama_depid');
		$sade_itemsid = $this->input->post('sade_itemsid');
		$itli_catid = $this->input->post('itli_catid');
            // echo "<pre>";
            // print_r($sade_itemsid);
            // die();


		$this->data['get_issue_expenses'] = $this->test_mdl->get_issue_expenses();


		if($this->location_ismain=='Y'){
			if($locationid){
				$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
			}else{
				$this->data['location'] = 'All';

			}
		}else{
			$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$this->locationid));

		}


		if($sama_depid):
			$this->data['department']=$this->general->get_tbl_data('dept_depname','dept_department',array('dept_depid'=>$sama_depid));
		else:
			$this->data['department'] = 'All';
		endif;

		if($sade_itemsid):
			$this->data['items_name']=$this->general->get_tbl_data('itli_itemname','itli_itemslist',array('itli_itemlistid'=>$sade_itemsid));
		else:
			$this->data['items_name'] = 'All';
		endif;

		if($itli_catid):
			$this->data['item_category']=$this->general->get_tbl_data('eqca_category','eqca_equipmentcategory',array('eqca_equipmentcategoryid'=>$itli_catid));
		else:
			$this->data['item_category'] = 'All';
		endif;

		if(!empty($this->data['get_issue_expenses'])){
			$template=$this->load->view('test/v_issue_expenses_list', $this->data,true);
		}else{
			$template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
		}

		return $template;
	}else{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}
}
public function category_wise_report_data(){
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$this->data['excel_url'] = "issue_consumption/test/generate_category_wise_report_excel";
		$this->data['pdf_url'] = "issue_consumption/test/generate_category_wise_report_pdf";

		$this->data['report_title'] ="Issue VS Expenses Report According To Category";


		$frmDate=$this->input->post('fromdate');
		$toDate=$this->input->post('todate');
		$locationid = $this->input->post('locationid');
		$itli_catid = $this->input->post('catid');



		$this->data['get_category_wise'] = $this->test_mdl->get_expenses_issue('category_wise');


		if($this->location_ismain=='Y'){
			if($locationid){
				$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
			}else{
				$this->data['location'] = 'All';

			}
		}else{
			$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$this->locationid));
		}

		if($itli_catid):
			$this->data['item_category']=$this->general->get_tbl_data('eqca_category','eqca_equipmentcategory',array('eqca_equipmentcategoryid'=>$itli_catid));
		else:
			$this->data['item_category'] = 'All';
		endif;

		if(!empty($this->data['get_category_wise'])){
			$template=$this->load->view('test/v_category_wise_report_list', $this->data,true);
		}else{
			$template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
		}

		return $template;
	}else{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}
}
public function item_wise_report_data(){
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$this->data['excel_url'] = "issue_consumption/test/generate_item_wise_report_excel";
		$this->data['pdf_url'] = "issue_consumption/test/generate_item_wise_report_pdf";

		$this->data['report_title'] ="Issue VS Expenses Report According To Item";


		$frmDate=$this->input->post('fromdate');
		$toDate=$this->input->post('todate');
		$locationid = $this->input->post('locationid');

		$sade_itemsid = $this->input->post('itemid');



		$this->data['get_item_wise'] = $this->test_mdl->get_expenses_issue('item_wise');


		if($this->location_ismain=='Y'){
			if($locationid){
				$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
			}else{
				$this->data['location'] = 'All';

			}
		}else{
			$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$this->locationid));

		}




		if($sade_itemsid):
			$this->data['items_name']=$this->general->get_tbl_data('itli_itemname','itli_itemslist',array('itli_itemlistid'=>$sade_itemsid));
		else:
			$this->data['items_name'] = 'All';
		endif;



		if(!empty($this->data['get_item_wise'])){
			$template=$this->load->view('test/v_items_wise_report_list', $this->data,true);
		}else{
			$template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
		}

		return $template;
	}else{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}
}
public function department_wise_report_data(){
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$this->data['excel_url'] = "issue_consumption/test/generate_department_wise_report_excel";
		$this->data['pdf_url'] = "issue_consumption/test/generate_department_wise_report_pdf";

		$this->data['report_title'] ="Issue VS Expenses Report According To Department";


		$frmDate=$this->input->post('fromdate');
		$toDate=$this->input->post('todate');
		$locationid = $this->input->post('locationid');
		$sama_depid = $this->input->post('depid');

		$this->data['get_department_wise'] = $this->test_mdl->get_expenses_issue('department_wise');


		if($this->location_ismain=='Y'){
			if($locationid){
				$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
			}else{
				$this->data['location'] = 'All';

			}
		}else{
			$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$this->locationid));

		}


		if($sama_depid):
			$this->data['department']=$this->general->get_tbl_data('dept_depname','dept_department',array('dept_depid'=>$sama_depid));
		else:
			$this->data['department'] = 'All';
		endif;



		if(!empty($this->data['get_department_wise'])){
			$template=$this->load->view('test/v_departmant_wise_report_list', $this->data,true);
		}else{
			$template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
		}

		return $template;
	}else{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}
}
public function date_wise_report_data(){
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$this->data['excel_url'] = "issue_consumption/test/generate_date_wise_report_excel";
		$this->data['pdf_url'] = "issue_consumption/test/generate_date_wise_report_pdf";

		$this->data['report_title'] ="Issue VS Expenses Report According To Date";


		$frmDate=$this->input->post('fromdate');
		$toDate=$this->input->post('todate');
		$locationid = $this->input->post('locationid');



		$this->data['get_date_wise'] = $this->test_mdl->get_expenses_issue('date_wise');


		if($this->location_ismain=='Y'){
			if($locationid){
				$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
			}else{
				$this->data['location'] = 'All';

			}
		}else{
			$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$this->locationid));

		}


		if(!empty($this->data['get_date_wise'])){
			$template=$this->load->view('test/v_date_wise_report_list', $this->data,true);
		}else{
			$template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
		}

		return $template;
	}else{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}
}


public function generate_issue_expenses_report_pdf()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$html = $this->issue_expenses_report_data();

		$filename = 'issue_expenses_'. date('Y_m_d_H_i_s') . '_.pdf'; 
            $pdfsize = 'A4-L'; //A4-L for landscape
            //if save and download with default filename, send $filename as parameter
            $this->general->generate_pdf($html,false,$pdfsize);
            
            exit();
        }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }

    public function generate_category_wise_report_pdf()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		$html = $this->category_wise_report_data();

    		$filename = 'category_wise_report_'. date('Y_m_d_H_i_s') . '_.pdf'; 
            $pdfsize = 'A4-L'; //A4-L for landscape
            //if save and download with default filename, send $filename as parameter
            $this->general->generate_pdf($html,false,$pdfsize);
            
            exit();
        }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }
    public function generate_item_wise_report_pdf()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		$html = $this->item_wise_report_data();

    		$filename = 'item_wise_report_'. date('Y_m_d_H_i_s') . '_.pdf'; 
            $pdfsize = 'A4-L'; //A4-L for landscape
            //if save and download with default filename, send $filename as parameter
            $this->general->generate_pdf($html,false,$pdfsize);
            
            exit();
        }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }
    public function generate_department_wise_report_pdf()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		$html = $this->department_wise_report_data();

    		$filename = 'department_wise_report_'. date('Y_m_d_H_i_s') . '_.pdf'; 
            $pdfsize = 'A4-L'; //A4-L for landscape
            //if save and download with default filename, send $filename as parameter
            $this->general->generate_pdf($html,false,$pdfsize);
            
            exit();
        }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }
    public function generate_date_wise_report_pdf()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		$html = $this->date_wise_report_data();

    		$filename = 'date_wise_report_'. date('Y_m_d_H_i_s') . '_.pdf'; 
            $pdfsize = 'A4-L'; //A4-L for landscape
            //if save and download with default filename, send $filename as parameter
            $this->general->generate_pdf($html,false,$pdfsize);
            
            exit();
        }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }

    public function generate_issue_expenses_report_excel()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		header("Content-Type: application/xls");    
    		header("Content-Disposition: attachment; filename=issue_expenses_".date('Y_m_d_H_i').".xls");  
    		header("Pragma: no-cache"); 
    		header("Expires: 0");

    		$response = $this->issue_expenses_report_data();
    		if($response){
    			echo $response; 
    		}
    		return false;
    	}else{
    		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
    		exit;
    	}
    }

    public function generate_category_wise_report_excel()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		header("Content-Type: application/xls");    
    		header("Content-Disposition: attachment; filename=category_wise_report_".date('Y_m_d_H_i').".xls");  
    		header("Pragma: no-cache"); 
    		header("Expires: 0");

    		$response = $this->category_wise_report_data();
    		if($response){
    			echo $response; 
    		}
    		return false;
    	}else{
    		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
    		exit;
    	}
    }
    public function generate_item_wise_report_excel()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		header("Content-Type: application/xls");    
    		header("Content-Disposition: attachment; filename=item_wise_report_".date('Y_m_d_H_i').".xls");  
    		header("Pragma: no-cache"); 
    		header("Expires: 0");

    		$response = $this->item_wise_report_data();
    		if($response){
    			echo $response; 
    		}
    		return false;
    	}else{
    		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
    		exit;
    	}
    }
    public function generate_department_wise_report_excel()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		header("Content-Type: application/xls");    
    		header("Content-Disposition: attachment; filename=department_wise_report_".date('Y_m_d_H_i').".xls");  
    		header("Pragma: no-cache"); 
    		header("Expires: 0");

    		$response = $this->department_wise_report_data();
    		if($response){
    			echo $response; 
    		}
    		return false;
    	}else{
    		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
    		exit;
    	}
    }
    public function generate_date_wise_report_excel()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		header("Content-Type: application/xls");    
    		header("Content-Disposition: attachment; filename=date_wise_report_".date('Y_m_d_H_i').".xls");  
    		header("Pragma: no-cache"); 
    		header("Expires: 0");

    		$response = $this->date_wise_report_data();
    		if($response){
    			echo $response; 
    		}
    		return false;
    	}else{
    		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
    		exit;
    	}
    }
  public function item_map_search()
	{
	$this->data['item_name']=$this->test_mdl->get_all_itemtest_name_distinct_itemtest();
	// ?echo "<pre>"; Print_r($this->data['item_name']);die;
   $this->data['tab_type']='search_details';
	$this->data['apptype'] = '';
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
	->build('test/v_test_common', $this->data);
}

	
 public function search_test_item()
    {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   		//  if(MODULES_VIEW=='N')
		// {		
 		// 		print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
		// 	exit;
		// }

	      	$html = $this->get_search_item();
		  	if($html)
		  	{
		  		$template=$html;
		  	}
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }
      public function search_item_list_excel()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    	error_reporting(E_ALL);
    	header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename = test_item_list_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");	      
      	$response = $this->get_search_item();
      	//print_r($response);die;
    	echo $response;
    	 }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }
    public function search_item_list_pdf()
   	{  
   		error_reporting(E_ALL);
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		    $html = $this->get_search_item();

	        $filename = 'item_list_'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4-L'; //A4-L for landscape
	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,false,$pdfsize);
	        exit();
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }

 public function get_search_item()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    	{
   	        $this->data['excel_url'] = "issue_consumption/test/search_item_list_excel";
			$this->data['pdf_url'] = "issue_consumption/test/search_item_list_pdf";
			$this->data['report_title'] = "Report";
   
	        $this->data['frmDate']=!empty($this->input->post('frmDate'))?$this->input->post('frmDate'):CURMONTH_DAY1;
            $this->data['toDate']=!empty($this->input->post('toDate'))?$this->input->post('toDate'):DISPLAY_DATE;
           

	      	$srchcol = "";
   
	  		
	  		$this->data['item_name']=$this->test_mdl->get_test_map_list_data(false,false,false,false,false,'distinct',false);
	  		// echo"<pre>";print_r($this->data['item_name']);die;


		    if($this->data['item_name'])
		    {
		    	$html=$this->load->view('test/v_test_item_search_details',$this->data,true);
		    }
		    else
		    {
		        $html='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
		    }

		    return $html;
    	}
    	else
    	{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }
    public function item_map_department_wise_search()
	{

		// if($this->location_ismain=='Y'){
		// 	$this->data['department']=$this->test_mdl->get_test_map_list_data_department(false,false,false,false,false,false,'distinct1');
		// // }else{
		
		// $this->data['department']=$this->test_mdl->get_test_map_list_data_department(array('tema_apidipid'=>$this->deptid),false,false,false,false,false,'distinct1');
	// }

		// $this->data['department']=$this->general->get_tbl_data('*','apde_apidepartment',array('apde_invdepid !='=>'NULL'));
		if($this->session->userdata(USER_GROUPCODE)=='SA'){

			$this->data['department']=$this->general->get_tbl_data('*','apde_apidepartment',array('apde_invdepid !='=>'NULL'));

		}else{
			$this->data['department']=$this->general->get_tbl_data('*','apde_apidepartment',array('apde_invdepid !='=>'NULL','apde_invdepid'=>$this->deptid));

		}
	

	// echo $this->db->last_query();die;
	$this->data['test_item_data']=$this->test_mdl->get_test_map_list_data_department(false,false,false,false,false,'distinct',false);
	// echo $this->db->last_query();die;
	$this->data['invitem_name_data']=$this->test_mdl->get_test_map_list_data_department(false,false,false,false,false,false,false,'distinct2');

   $this->data['tab_type']='search_details_department_wise';
	$this->data['apptype'] = '';
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
	->build('test/v_test_common', $this->data);
}
 public function search_test_item_department_wise()
    {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   		//  if(MODULES_VIEW=='N')
		// {		
 		// 		print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
		// 	exit;
		// }
	      	$html = $this->get_search_item_dept();
		  	if($html)
		  	{
		  		$template=$html;
		  	}
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }
      public function search_depart_wise_list_excel()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    	error_reporting(E_ALL);
    	header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename = dep_wise_item_list_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");	      
      	$response = $this->get_search_item_dept();
      	//print_r($response);die;
    	echo $response;
    	 }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }
    public function search_depart_wise_list_pdf()
   	{  
   		error_reporting(E_ALL);
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		    $html = $this->get_search_item_dept();

	        $filename = 'dep_wise_list_'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4-L'; //A4-L for landscape
	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,false,$pdfsize);
	        exit();
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }
  public function get_search_item_dept()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    	{
    		$this->data['excel_url'] = "issue_consumption/test/search_depart_wise_list_excel";
			$this->data['pdf_url'] = "issue_consumption/test/search_depart_wise_list_pdf";
			$this->data['report_title'] = "Report";

  
	        $this->data['frmDate']=!empty($this->input->post('frmDate'))?$this->input->post('frmDate'):CURMONTH_DAY1;
            $this->data['toDate']=!empty($this->input->post('toDate'))?$this->input->post('toDate'):DISPLAY_DATE;
            $this->data['testitem_name'] = !empty($this->input->post('testitem_name'))?$this->input->post('testitem_name'):'';
             $this->data['invitem_name'] = !empty($this->input->post('invitem_name'))?$this->input->post('invitem_name'):'';
            //   print_r( $this->data['testitem_name']);
            // print_r( $this->data['invitem_name']);die;
              $depid=$this->data['apidepid'] = !empty($this->input->post('tema_apidepid'))?$this->input->post('tema_apidepid'):'';

   
	  		
	  		// if(!empty($dipid)){
	  		// 	$this->data['dept_data']=$this->test_mdl->get_test_map_list_data_department(array('tema_apidepid'=>$dipid),false,false,false,false,false,'distinct1',false);
	  		// }else{
	  			// $this->data['dept_data']=$this->test_mdl->get_test_map_list_data_department(false,false,false,false,false,false,'distinct1',false);
              if($depid==''){
              	 	$this->data['dept_data']=$this->general->get_tbl_data('*','apde_apidepartment',array('apde_invdepid !='=>'NULL' ));

              }else{
             
              	$this->data['dept_data']=$this->general->get_tbl_data('*','apde_apidepartment',array('apde_invdepid !='=>'NULL' ,'apde_invdepid'=>$depid));

              }
              

	  		// }
	  		// print_r($this->data['dept_data']);die;


		    if(!empty($this->data['dept_data']))
		    {
		    	$html=$this->load->view('test/v_deparement_wise_item_test_details',$this->data,true);
		    }
		    else
		    {
		        $html='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
		    }

		    return $html;
    	}
    	else
    	{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }
     public function get_test_item_list(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id=$this->input->post('apidepid');
            // print_r($id);die;

            if(!empty($id))

            {

           
            $this->data['test_item_data']=$this->test_mdl->get_test_map_list_data_department(array('tema_apidepid'=>$id),false,false,false,false,'distinct',false);


           // echo $this->db->last_query();

           //  die();

            // echo "<pre>";

            // print_r($this->data['test_item_data']);die;

            if(!empty($this->data['test_item_data']))

                {

                echo json_encode($this->data['test_item_data']);

                }

            else

                {

                    echo json_encode(array());

                }

            }

            else

            {

                echo json_encode('');

            }

        }

        else

        {

        print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

            exit;

        }

    }
      public function get_item_list(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id=$this->input->post('testitemid');
            // print_r($id);die;

            if(!empty($id))

            {

           
            $this->data['invitem_name_data']=$this->test_mdl->get_test_map_list_data_department(array('tv.tema_testnameid'=>$id),false,false,false,false,false,false,'distinct2');



           // echo $this->db->last_query();

           //  die();

            // echo "<pre>";

             // print_r($this->data['invitem_name_data']);die;

            if(!empty($this->data['invitem_name_data']))

                {

                echo json_encode($this->data['invitem_name_data']);

                }

            else

                {

                    echo json_encode(array());

                }

            }

            else

            {

                echo json_encode('');

            }

        }

        else

        {

        print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

            exit;

        }

    }
  public function test_stock_department()
	{
		



		if($this->session->userdata(USER_GROUPCODE)=='SA'){

			$this->data['department']=$this->general->get_tbl_data('*','apde_apidepartment',array('apde_invdepid !='=>'NULL'));

		}else{
			$this->data['department']=$this->general->get_tbl_data('*','apde_apidepartment',array('apde_invdepid !='=>'NULL','apde_invdepid'=>$this->deptid));

		}
		$this->data['items_name']=$this->general->get_tbl_data('itli_itemname,itli_itemlistid','itli_itemslist',false);

	 // echo "<pre>";print_r($this->data['department']);die;
		
		$this->data['tab_type']='test_item_stock';
		$this->data['apptype'] = '';
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
		->build('test/v_test_common', $this->data);
	}
public function department_wise_stock()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(MODULES_VIEW=='N')
		{

			print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
			exit;
		}

		$template = $this->department_wise_stock_data();


		if(!empty($template))
		{
			print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','template'=>$template)));
			exit;
		}
		else{
			print_r(json_encode(array('status'=>'success','message'=>'No Record Found!!')));
			exit;
		}
	}else{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}  
}
public function department_wise_stock_data(){
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	   $this->data['excel_url'] = "issue_consumption/test/generate_department_wise_stock_excel";
		$this->data['pdf_url'] = "issue_consumption/test/generate_department_wise_stock_pdf";

		$this->data['report_title'] ="Test Reagent Stock Report According To Department";

		

		$locationid = $this->input->post('locationid');
		$this->data['fromDate']=$fromDate=$this->input->post('fromdate');
		$this->data['toDate']=$toDate=$this->input->post('todate');
		$this->data['depid']=$sama_depid = $this->input->post('depid');
		$this->data['itemid']=$itemid = $this->input->post('itemid');
		  // print_r($this->data['itemid']);die;

		// $this->data['get_department_wise'] = $this->test_mdl->item_stock_department();
		$this->data['get_department_wise']=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$this->deptid));

		$this->data['invitem_name_data']=$this->test_mdl->get_test_map_list_data_department(false,false,false,false,false,false,false,'distinct2');
		  

		// if($this->location_ismain=='Y'){
		// 	if($locationid){
		// 		$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
		// 	}else{
		// 		$this->data['location'] = 'All';

		// 	}
		// }else{
		// 	$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$this->locationid));

		// }


		if($sama_depid):
			$this->data['department']=$this->general->get_tbl_data('dept_depname','dept_department',array('dept_depid'=>$sama_depid));
		else:
			$this->data['department'] = 'All';
		endif;



		if(!empty($this->data['get_department_wise'])){
			$template=$this->load->view('test/v_departmant_wise_stock_list', $this->data,true);
		}else{
			$template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
		}

		return $template;
	}else{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}
}

public function generate_department_wise_stock_pdf()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		$html = $this->department_wise_stock_data();

    		$filename = 'department_wise_stock_'. date('Y_m_d_H_i_s') . '_.pdf'; 
            $pdfsize = 'A4-L'; //A4-L for landscape
            //if save and download with default filename, send $filename as parameter
            $this->general->generate_pdf($html,false,$pdfsize);
            
            exit();
        }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }
   public function generate_department_wise_stock_excel()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		header("Content-Type: application/xls");    
    		header("Content-Disposition: attachment; filename=department_wise_stock_".date('Y_m_d_H_i').".xls");  
    		header("Pragma: no-cache"); 
    		header("Expires: 0");

    		$response = $this->department_wise_stock_data();
    		if($response){
    			echo $response; 
    		}
    		return false;
    	}else{
    		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
    		exit;
    	}
    }
    public function get_test_item_list_inventory(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id=$this->input->post('apidepid');
             // print_r($id);die;

            if(!empty($id))

            {

           
            $this->data['test_item_data']=$this->test_mdl->get_test_map_list_data_department(array('tv.tema_invdepid'=>$id),false,false,false,false,false,false,'distinct2');



           // echo $this->db->last_query();

           //  die();

            // echo "<pre>";

            // print_r($this->data['test_item_data']);die;

            if(!empty($this->data['test_item_data']))

                {

                echo json_encode($this->data['test_item_data']);

                }

            else

                {

                    echo json_encode(array());

                }

            }

            else

            {

                echo json_encode('');

            }

        }

        else

        {

        print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

            exit;

        }

    }


    //for  department stock

	public function stock_list($type=false)
	{
		


		if($this->session->userdata(USER_GROUPCODE)=='SA'){

			$this->data['department']=$this->general->get_tbl_data('*','apde_apidepartment',array('apde_invdepid !='=>'NULL'));

		}else{
			$this->data['department']=$this->general->get_tbl_data('*','apde_apidepartment',array('apde_invdepid !='=>'NULL','apde_invdepid'=>$this->deptid));

		}
		$this->data['items_name']=$this->general->get_tbl_data('itli_itemname,itli_itemlistid','itli_itemslist',false);

	 // echo "<pre>";print_r($this->data['department']);die;
		
		$this->data['tab_type']='stock_list';
		$this->data['apptype'] = '';
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
		->build('test/v_test_common', $this->data);
	}

    public function reagent_stock_list()
	{

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
	  	$i = 0;
	  	
	  	$frmDate = !empty($this->input->post('frmDate'))?$this->input->post('frmDate'):CURDATE_NP;
	  	$toDate = !empty($this->input->post('toDate'))?$this->input->post('toDate'):CURDATE_NP;;
	  	
	  	$data = $this->test_mdl->get_reagent_department_stock_lists();
	  	// echo "<pre>";print_r($data);die();

		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);

		  	foreach($data as $row)
		    {	
		    	if(ITEM_DISPLAY_TYPE=='NP'){
                	$itli_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
                }else{ 
                    $itli_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
                }

	

		    	$remarks = $row->stockrmk;
		    	if($remarks == 'Zero'){
		    		$statusClass = 'danger';
		    		$statusName = 'Out of Stock';
		    	}else if($remarks == 'Limited'){
		    		$statusClass = 'warning';
		    		$statusName = 'Limited';
		    	}else if($remarks == 'Stock'){
		    		$statusClass = 'success';
		    		$statusName = 'Available';
		    	}else{
		    		$statusClass = '';
		    		$statusName = '';
		    	}
		    	 $exp_kit=$row->rec_qty-$row->avl_item_stock;

		    	$array[$i]["statusClass"] = $statusClass;
		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]['itli_itemname'] = $itli_itemname;
		   		$array[$i]['itli_itemcode'] = $row->itli_itemcode;
		   		$array[$i]['dept_depname'] = $row->dept_depname;
		   		
		   		$array[$i]['test_qty'] = $row->test_qty;
		   		$array[$i]['remaing_test'] = $row->lab_stock_qty;
		   		$array[$i]['exp_qty'] = $row->rec_cnt;
		   		$array[$i]['rec_qty'] = $row->rec_qty;
		   		$array[$i]['exp_kit'] = $exp_kit;
		   		$array[$i]['remaining_stock'] = $row->avl_item_stock;
		   		
			    $i++;
		    }
		    // echo "<pre>";print_r($array);die;
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function get_reagent_stock_count_total()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		  // print_r($this->input->post()); die();
		  $frmDfrme = !empty($this->input->post('frmDate'))?$this->input->post('frmDate'):CURDATE_NP;
		   !empty($this->input->post('frmDate'))?$this->input->post('frmDate'):CURDATE_NP;!empty($this->input->post('frmdate'))?$this->input->post('frmdate'):CURDATE_NP;
        	$toDate = !empty($this->input->post('todate'))?$this->input->post('todate'):CURDATE_NP;

        	$locationid = !empty($this->input->post('locationid'))?$this->input->post('locationid'):$this->session->userdata(LOCATION_ID);

        	if($this->session->userdata(USER_GROUPCODE)=='SA'){
				
                  $dep = "";
			}else{
				$dep = "WHERE depid = $this->depid";

			}
			$this->data['department_stock_count'] = $this->home_mdl->get_stock_count_department($dep);

		    // echo $this->db->last_query();
		    // die();
		    print_r(json_encode(array('status'=>'success','status_count'=>$status_count)));
		}
	}
   

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */