<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test_mdl extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->sama_masterTable='sama_salemaster';
		$this->sade_detailTable='sade_saledetail'; 
		$this->tran_masterTable='trma_transactionmain';
		$this->tran_detailsTable='trde_transactiondetail';
		$this->rede_detailTable='rede_reqdetail'; 
		$this->rema_masterTable = 'rema_reqmaster';
		$this->test_teststock = 'test_teststock';

		$this->curtime = $this->general->get_currenttime();
		$this->userid = $this->session->userdata(USER_ID);
		$this->username = $this->session->userdata(USER_NAME);
		$this->userdepid = $this->session->userdata(USER_DEPT); //storeid
		$this->storeid = $this->session->userdata(STORE_ID);
		$this->mac = $this->general->get_Mac_Address();
		$this->ip = $this->general->get_real_ipaddr();
		$this->locationid=$this->session->userdata(LOCATION_ID);
		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		$this->orgid=$this->session->userdata(ORG_ID);
		
	}
	

	public $validate_test_stock = array(
		array('field' => 'test_expensesqty', 'label' => 'Expenses Qty', 'rules' => 'trim|required|xss_clean'),
		// array('field' => 'test_remarks', 'label' => 'Remarks', 'rules' => 'trim|required|xss_clean'),

		
	);
	public $validate_test_item_map = array(

		array('field' => 'tema_invitemid[]', 'label' => 'Items ', 'rules' => 'trim|required|xss_clean')

	);


	public function teststock_save()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		$exptestdate=$this->input->post('test_expensesdate');
		if(DEFAULT_DATEPICKER=='NP')
		{   
			$exptestdateNp = $exptestdate;
			$exptestdateEn = $this->general->NepToEngDateConv($exptestdate);
		}
		else
		{
			$exptestdateEn = $exptestdate;
			$exptestdateNp = $this->general->EngtoNepDateConv($exptestdate);
		}
		unset($postdata['test_expensesdate']);
		unset($postdata['id']);
		if($id)
		{
			if(!empty($postdata))
			{
				$this->db->update($this->test_teststock,$postdata,array('test_id'=>$id));
				$rowaffected=$this->db->affected_rows();
				if($rowaffected)
				{
					
					return $rowaffected;
				}
				else
				{
					return false;
				}
			}
		}
		else
		{
			$postdata['test_expensesdatead']=$exptestdateEn;
			$postdata['test_expensesdatebs']=$exptestdateNp;
			$postdata['test_postdatead']=CURDATE_EN;
			$postdata['test_postdatebs']=CURDATE_NP;
			$postdata['test_posttime']=date('H:i:s');
			$postdata['test_postby']=$this->session->userdata(USER_ID);
			$postdata['test_postip']=$this->general->get_real_ipaddr();
			$postdata['test_postmac']=$this->general->get_Mac_Address();
			if(!empty($postdata))
			{
				$this->db->insert($this->test_teststock,$postdata);
				$insertid=$this->db->insert_id();
				if($insertid)
				{
					return $insertid;
				}
				else
				{
					return false;
				}
			}
		}
		
		return false;

	}
	
	public function get_issue_book_details_list($cond = false)
	{
		$depid=$this->session->userdata(USER_DEPT);
		// print_r($depid);
		// die();
		$deplist=array();
		if(!empty($depid)){
			$deplist=explode(',', $depid);
		}

		$frmDate=$this->input->get('frmDate');
		$toDate=$this->input->get('toDate');
		$sama_depid=$this->input->get('sama_depid');
		$get = $_GET;
		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}
		if(!empty(($frmDate && $toDate)))
		{
			if(DEFAULT_DATEPICKER == 'NP'){
				$this->db->where('sama_billdatebs >=',$frmDate);
				$this->db->where('sama_billdatebs <=',$toDate);    
			}else{
				$this->db->where('sama_billdatead >=',$frmDate);
				$this->db->where('sama_billdatead <=',$toDate);
			}
		}
		if(!empty($deplist)){
			$this->db->where_in("sama_depid",$deplist);
		}

		if(!empty($get['sSearch_1'])){
			$this->db->where("sama_invoiceno like  '%".$get['sSearch_1']."%'  ");
		}
		if(!empty($get['sSearch_2'])){
			$this->db->where("sama_billdatebs like  '%".$get['sSearch_2']."%'  ");
		}
		
		if(!empty($get['sSearch_3'])){
			$this->db->where("itli_itemcode like  '%".$get['sSearch_3']."%'  ");
		}
		if(!empty($get['sSearch_4'])){
			$this->db->where("itli_itemname like  '%".$get['sSearch_4']."%' OR itli_itemnamenp like  '%".$get['sSearch_4']."%' ");
		}
		if(!empty($get['sSearch_5'])){
			$this->db->where("sama_depname like  '%".$get['sSearch_5']."%'  ");
		}
		if(!empty($get['sSearch_6'])){
			$this->db->where("sade_qty like  '%".$get['sSearch_6']."%'  ");
		}
		if(!empty($get['sSearch_7'])){
			$this->db->where("sama_expenses_qty like  '%".$get['sSearch_7']."%'  ");
		}
		if(!empty($get['sSearch_8'])){
			$this->db->where("sama_remaining_qty like  '%".$get['sSearch_8']."%'  ");
		}
		

		if($cond) {
			$this->db->where($cond);
		}
		if(!empty($sama_depid)){
			$this->db->where_in("sama_depid",$sama_depid);
		}
		$input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

		if($this->location_ismain=='Y')
		{
			if($input_locationid)
			{
				$this->db->where('sd.sade_locationid',$input_locationid);
			}

		}
		else
		{
			$this->db->where('sd.sade_locationid',$this->locationid);
		}


		

		$resltrpt=$this->db->select("COUNT(*) as cnt")
		->from('sade_saledetail sd')
		->join('sama_salemaster rn','rn.sama_salemasterid = sd.sade_salemasterid','LEFT')
		->join('itli_itemslist eq','eq.itli_itemlistid = sd.sade_itemsid','LEFT')

		->get()->row();
		//echo $this->db->last_query();die(); 
		$totalfilteredrecs=($resltrpt->cnt); 
		$order_by = 'sama_requisitionno';
		$order = 'desc';
		if($this->input->get('sSortDir_0'))
		{
			$order = $this->input->get('sSortDir_0');
		}

		$where='';
		if($this->input->get('iSortCol_0')==1)
			$order_by = 'sama_invoiceno';
		else if($this->input->get('iSortCol_0')==2)
			if(DEFAULT_DATEPICKER=='NP')
			{
				$order_by = 'sama_billdatebs';
			}else{
				$order_by = 'sama_billdatead';
			}
			else if($this->input->get('iSortCol_0')==3)
				$order_by = 'itli_itemcode';
			else if($this->input->get('iSortCol_0')==4)
				$order_by = 'itli_itemname';
			else if($this->input->get('iSortCol_0')==5)
				$order_by = 'sama_depname';
			else if($this->input->get('iSortCol_0')==6)
				$order_by = 'sade_qty';
			else if($this->input->get('iSortCol_0')==7)
				$order_by = 'sama_expenses_qty';
			else if($this->input->get('iSortCol_0')==8)
				$order_by = 'sama_remaining_qty';
			else if($this->input->get('iSortCol_0')==9)
				$order_by = 'sama_billtime';
			else if($this->input->get('iSortCol_0')==10)
				$order_by = 'sade_unit';
			$totalrecs='';
			$limit = 15;
			$offset = 1;
			$get = $_GET;

			foreach ($get as $key => $value) {
				$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
			}

			if(!empty($_GET["iDisplayLength"])){
				$limit = $_GET['iDisplayLength'];
				$offset = $_GET["iDisplayStart"];
			}
			if(!empty(($frmDate && $toDate)))
			{
				if(DEFAULT_DATEPICKER == 'NP'){
					$this->db->where('sama_billdatebs >=',$frmDate);
					$this->db->where('sama_billdatebs <=',$toDate);    
				}else{
					$this->db->where('sama_billdatead >=',$frmDate);
					$this->db->where('sama_billdatead <=',$toDate);
				}
			}
			if(!empty($deplist)){
				$this->db->where_in("sama_depid",$deplist);
			}

			if(!empty($sama_depid)){
				$this->db->where_in("sama_depid",$sama_depid);
			}

			if(!empty($get['sSearch_1'])){
				$this->db->where("sama_invoiceno like  '%".$get['sSearch_1']."%'  ");
			}
			if(!empty($get['sSearch_2'])){
				if(DEFAULT_DATEPICKER=='NP')
				{
					$this->db->where("sama_billdatebs like  '%".$get['sSearch_2']."%'  ");
				}else{
					$this->db->where("sama_billdatead like  '%".$get['sSearch_2']."%'  ");
				}
			}
			if(!empty($get['sSearch_3'])){
				$this->db->where("itli_itemcode like  '%".$get['sSearch_3']."%'  ");
			}
			if(!empty($get['sSearch_4'])){
				$this->db->where("itli_itemname like  '%".$get['sSearch_4']."%' OR itli_itemnamenp like  '%".$get['sSearch_4']."%' ");
			}
			if(!empty($get['sSearch_5'])){
				$this->db->where("sama_depname like  '%".$get['sSearch_5']."%'  ");
			}
			if(!empty($get['sSearch_6'])){
				$this->db->where("sade_qty like  '%".$get['sSearch_6']."%'  ");
			}
			if(!empty($get['sSearch_7'])){
				$this->db->where("sama_expenses_qty like  '%".$get['sSearch_7']."%'  ");
			}
			if(!empty($get['sSearch_8'])){
				$this->db->where("sama_remaining_qty like  '%".$get['sSearch_8']."%'  ");
			}




			if($cond) {
				$this->db->where($cond);
			}

			if($this->location_ismain=='Y')
			{
				if($input_locationid)
				{
					$this->db->where('sd.sade_locationid',$input_locationid);
				}

			}
			else
			{
				$this->db->where('sd.sade_locationid',$this->locationid);
			}
			$sql_code_data=' (SELECT SUM(test_expensesqty) expqty from xw_test_teststock ts WHERE ts.test_itemid=sd.sade_itemsid AND ts.test_saledetailid=sd.sade_saledetailid AND ts.test_salemasterid=sd.sade_salemasterid) as expqty ';
			$this->db->select("rn.sama_st,rn.sama_billtime,sd.sade_remarks,rn.sama_salemasterid,rn.sama_invoiceno,rn.sama_billdatebs,rn.sama_billdatead,dp.dept_depname sama_depname,sd.sade_salemasterid,sd.sade_saledetailid,sd.sade_qty,sd.sade_itemsid,eq.itli_itemname,eq.itli_itemnamenp,sd.sade_itemsid,un.unit_unitname,eq.itli_itemcode,eq.itli_itemlistid, $sql_code_data ");
			$this->db->from('sade_saledetail sd');
			$this->db->join('sama_salemaster rn','rn.sama_salemasterid = sd.sade_salemasterid','LEFT');
			$this->db->join('dept_department dp','dp.dept_depid=rn.sama_depid','left');
			$this->db->join('itli_itemslist eq','eq.itli_itemlistid = sd.sade_itemsid','LEFT');
			$this->db->join('unit_unit un','un.unit_unitid = eq.itli_unitid','LEFT');


			$this->db->group_by('sade_itemsid');
		// $this->db->join('test_teststock ts','ts.test_itemid = sd.sade_itemsid','LEFT');
			$this->db->order_by($order_by,$order);
			if($limit && $limit>0)
			{  
				$this->db->limit($limit);
			}
			if($offset)
			{
				$this->db->offset($offset);
			}
			$nquery=$this->db->get();
	   // echo $this->db->last_query();
	   // die();
			$num_row=$nquery->num_rows();
			// if(!empty($_GET['iDisplayLength'])) {
			// 	$totalrecs = sizeof( $nquery);
			// }
			if (!empty($_GET['iDisplayLength']) &&  !empty($resltrpt) && is_array($resltrpt) && sizeof($resltrpt) > 0 ) {
				$totalfilteredrecs = sizeof($resltrpt);
			}


			if($num_row>0){
				$ndata=$nquery->result();
				$ndata['totalrecs'] = $totalrecs;
				$ndata['totalfilteredrecs'] = $totalfilteredrecs;
			} 
			else
			{
				$ndata=array();
				$ndata['totalrecs'] = 0;
				$ndata['totalfilteredrecs'] = 0;
			}
	//echo $this->db->last_query();die();
			return $ndata;

		}



		public function get_issue_vs_expenses_report($cond = false)
		{
			$frmDate=$this->input->get('frmDate');
			$toDate=$this->input->get('toDate');
			$department=$this->input->get('department');
			$get = $_GET;
			foreach ($get as $key => $value) {
				$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
			}
			if(!empty(($frmDate && $toDate)))
			{
				if(DEFAULT_DATEPICKER == 'NP'){
					$this->db->where('sama_billdatebs >=',$frmDate);
					$this->db->where('sama_billdatebs <=',$toDate);    
				}else{
					$this->db->where('sama_billdatead >=',$frmDate);
					$this->db->where('sama_billdatead <=',$toDate);
				}
			}
			if(!empty($get['sSearch_1'])){
				$this->db->where("sama_invoiceno like  '%".$get['sSearch_1']."%'  ");
			}
			if(!empty($get['sSearch_2'])){
				$this->db->where("sama_billdatebs like  '%".$get['sSearch_2']."%'  ");
			}

			if(!empty($get['sSearch_3'])){
				$this->db->where("itli_itemcode like  '%".$get['sSearch_3']."%'  ");
			}
			if(!empty($get['sSearch_4'])){
				$this->db->where("itli_itemname like  '%".$get['sSearch_4']."%' OR itli_itemnamenp like  '%".$get['sSearch_4']."%' ");
			}
			if(!empty($get['sSearch_5'])){
				$this->db->where("sama_depname like  '%".$get['sSearch_5']."%'  ");
			}
			if(!empty($get['sSearch_6'])){
				$this->db->where("sade_qty like  '%".$get['sSearch_6']."%'  ");
			}
			if(!empty($get['sSearch_7'])){
				$this->db->where("sama_expenses_qty like  '%".$get['sSearch_7']."%'  ");
			}
			if(!empty($get['sSearch_8'])){
				$this->db->where("sama_remaining_qty like  '%".$get['sSearch_8']."%'  ");
			}


			if($cond) {
				$this->db->where($cond);
			}
			$department = !empty($get['department'])?$get['department']:$this->input->post('department');
			$input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
			if(!empty(($department)))
			{  
            //print_r($store_id);die;
				$this->db->where('sama_depid',$department);

			}

			if($this->location_ismain=='Y')
			{
				if($input_locationid)
				{
					$this->db->where('sd.sade_locationid',$input_locationid);
				}

			}
			else
			{
				$this->db->where('sd.sade_locationid',$this->locationid);
			}




			$resltrpt=$this->db->select("COUNT(*) as cnt")
			->from('sade_saledetail sd')
			->join('sama_salemaster rn','rn.sama_salemasterid = sd.sade_salemasterid','LEFT')
			->join('itli_itemslist eq','eq.itli_itemlistid = sd.sade_itemsid','LEFT')

			->get()->row();
		//echo $this->db->last_query();die(); 
			$totalfilteredrecs=($resltrpt->cnt); 
			$order_by = 'sama_requisitionno';
			$order = 'desc';
			if($this->input->get('sSortDir_0'))
			{
				$order = $this->input->get('sSortDir_0');
			}

			$where='';
			if($this->input->get('iSortCol_0')==1)
				$order_by = 'sama_invoiceno';
			else if($this->input->get('iSortCol_0')==2)
				if(DEFAULT_DATEPICKER=='NP')
				{
					$order_by = 'sama_billdatebs';
				}else{
					$order_by = 'sama_billdatead';
				}
				else if($this->input->get('iSortCol_0')==3)
					$order_by = 'itli_itemcode';
				else if($this->input->get('iSortCol_0')==4)
					$order_by = 'itli_itemname';
				else if($this->input->get('iSortCol_0')==5)
					$order_by = 'sama_depname';
				else if($this->input->get('iSortCol_0')==6)
					$order_by = 'sade_qty';
				else if($this->input->get('iSortCol_0')==7)
					$order_by = 'sama_expenses_qty';
				else if($this->input->get('iSortCol_0')==8)
					$order_by = 'sama_remaining_qty';
				else if($this->input->get('iSortCol_0')==9)
					$order_by = 'sama_billtime';
				else if($this->input->get('iSortCol_0')==10)
					$order_by = 'sade_unit';
				$totalrecs='';
				$limit = 15;
				$offset = 1;
				$get = $_GET;

				foreach ($get as $key => $value) {
					$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
				}

				if(!empty($_GET["iDisplayLength"])){
					$limit = $_GET['iDisplayLength'];
					$offset = $_GET["iDisplayStart"];
				}
				if(!empty(($frmDate && $toDate)))
				{
					if(DEFAULT_DATEPICKER == 'NP'){
						$this->db->where('sama_billdatebs >=',$frmDate);
						$this->db->where('sama_billdatebs <=',$toDate);    
					}else{
						$this->db->where('sama_billdatead >=',$frmDate);
						$this->db->where('sama_billdatead <=',$toDate);
					}
				}

				if(!empty($get['sSearch_1'])){
					$this->db->where("sama_invoiceno like  '%".$get['sSearch_1']."%'  ");
				}
				if(!empty($get['sSearch_2'])){
					if(DEFAULT_DATEPICKER=='NP')
					{
						$this->db->where("sama_billdatebs like  '%".$get['sSearch_2']."%'  ");
					}else{
						$this->db->where("sama_billdatead like  '%".$get['sSearch_2']."%'  ");
					}
				}
				if(!empty($get['sSearch_3'])){
					$this->db->where("itli_itemcode like  '%".$get['sSearch_3']."%'  ");
				}
				if(!empty($get['sSearch_4'])){
					$this->db->where("itli_itemname like  '%".$get['sSearch_4']."%' OR itli_itemnamenp like  '%".$get['sSearch_4']."%' ");
				}
				if(!empty($get['sSearch_5'])){
					$this->db->where("sama_depname like  '%".$get['sSearch_5']."%'  ");
				}
				if(!empty($get['sSearch_6'])){
					$this->db->where("sade_qty like  '%".$get['sSearch_6']."%'  ");
				}
				if(!empty($get['sSearch_7'])){
					$this->db->where("sama_expenses_qty like  '%".$get['sSearch_7']."%'  ");
				}
				if(!empty($get['sSearch_8'])){
					$this->db->where("sama_remaining_qty like  '%".$get['sSearch_8']."%'  ");
				}




				if($cond) {
					$this->db->where($cond);
				}
				$department = !empty($get['department'])?$get['department']:$this->input->post('department');

				if($department)
				{
					$this->db->where('sama_depid',$department);
				}

				if($this->location_ismain=='Y')
				{
					if($input_locationid)
					{
						$this->db->where('sd.sade_locationid',$input_locationid);
					}

				}
				else
				{
					$this->db->where('sd.sade_locationid',$this->locationid);
				}

				$this->db->select('rn.sama_st,rn.sama_billtime,sd.sade_remarks,rn.sama_salemasterid,rn.sama_invoiceno,rn.sama_billdatebs,rn.sama_billdatead,dp.dept_depname sama_depname,sd.sade_salemasterid,sd.sade_saledetailid,sd.sade_qty,sd.sade_itemsid,eq.itli_itemname,eq.itli_itemnamenp,sd.sade_itemsid,un.unit_unitname,eq.itli_itemcode,eq.itli_itemlistid,sum(ts.test_expensesqty) as expqty');
				$this->db->from('sade_saledetail sd');
				$this->db->join('sama_salemaster rn','rn.sama_salemasterid = sd.sade_salemasterid','LEFT');
				$this->db->join('dept_department dp','dp.dept_depid=rn.sama_depid','left');
				$this->db->join('itli_itemslist eq','eq.itli_itemlistid = sd.sade_itemsid','LEFT');
				$this->db->join('unit_unit un','un.unit_unitid = eq.itli_unitid','LEFT');
				$this->db->join('test_teststock ts','ts.test_salemasterid = sd.sade_salemasterid','LEFT');

				$this->db->group_by('sade_itemsid');
		// $this->db->join('test_teststock ts','ts.test_itemid = sd.sade_itemsid','LEFT');
				$this->db->order_by($order_by,$order);
				if($limit && $limit>0)
				{  
					$this->db->limit($limit);
				}
				if($offset)
				{
					$this->db->offset($offset);
				}
				$nquery=$this->db->get();
	   // echo $this->db->last_query();
	   // die();
				$num_row=$nquery->num_rows();
				// if(!empty($_GET['iDisplayLength'])) {
				// 	$totalrecs = sizeof( $nquery);
				// }
				if (!empty($_GET['iDisplayLength']) &&  !empty($resltrpt) && is_array($resltrpt) && sizeof($resltrpt) > 0 ) {
					$totalfilteredrecs = sizeof($resltrpt);
				}


				if($num_row>0){
					$ndata=$nquery->result();
					$ndata['totalrecs'] = $totalrecs;
					$ndata['totalfilteredrecs'] = $totalfilteredrecs;
				} 
				else
				{
					$ndata=array();
					$ndata['totalrecs'] = 0;
					$ndata['totalfilteredrecs'] = 0;
				}
	//echo $this->db->last_query();die();
				return $ndata;

			}

			public function get_test_data($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
			{
				$this->db->select('sd.sade_salemasterid,sum(sd.sade_qty) as sadeqty');
				$this->db->from('sade_saledetail sd');
		// $this->db->group_by('sade_itemsid');

				if($srchcol)
				{
					$this->db->where($srchcol);
				}
				if($limit && $limit>0)
				{
					$this->db->limit($limit);
				}
				if($offset)
				{
					$this->db->offset($offset);
				}

				if($order)
				{
					$this->db->order_by($order,$order_by);
				}

				$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
				if ($query->num_rows() > 0) 
				{
					$data=$query->result();		
					return $data;		
				}		
				return false;
			}

			public function get_test_detail($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
			{
				$this->db->select('rn.sama_st,rn.sama_billtime,sd.sade_remarks,rn.sama_salemasterid,rn.sama_invoiceno,rn.sama_billdatebs,rn.sama_billdatead,dp.dept_depname sama_depname,sd.sade_salemasterid,sd.sade_saledetailid,sd.sade_qty,sd.sade_itemsid,eq.itli_itemname,eq.itli_itemnamenp,sd.sade_itemsid,un.unit_unitname,eq.itli_itemcode,eq.itli_itemlistid');
				$this->db->from('sade_saledetail sd');
				$this->db->join('sama_salemaster rn','rn.sama_salemasterid = sd.sade_salemasterid','LEFT');
				$this->db->join('dept_department dp','dp.dept_depid=rn.sama_depid','left');
				$this->db->join('itli_itemslist eq','eq.itli_itemlistid = sd.sade_itemsid','LEFT');
				$this->db->join('unit_unit un','un.unit_unitid = eq.itli_unitid','LEFT');


				if($srchcol)
				{
					$this->db->where($srchcol);
				}
				if($limit && $limit>0)
				{
					$this->db->limit($limit);
				}
				if($offset)
				{
					$this->db->offset($offset);
				}

				if($order)
				{
					$this->db->order_by($order,$order_by);
				}

				$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
				if ($query->num_rows() > 0) 
				{
					$data=$query->result();		
					return $data;		
				}		
				return false;
			}


			public function get_all_data($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
			{
				$this->db->select('*');
				$this->db->from('test_teststock ts');

				if($srchcol)
				{
					$this->db->where($srchcol);
				}
				if($limit && $limit>0)
				{
					$this->db->limit($limit);
				}
				if($offset)
				{
					$this->db->offset($offset);
				}

				if($order)
				{
					$this->db->order_by($order,$order_by);
				}

				$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
				if ($query->num_rows() > 0) 
				{
					$data=$query->result();		
					return $data;		
				}		
				return false;
			}

			public function get_all_count($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
			{


				$this->db->select('SUM(ts.test_expensesqty) as exp');
				$this->db->from('test_teststock ts');
		// $this->db->join('sade_saledetail sd','sd.sade_salemasterid = ts.test_salemasterid','LEFT');

				if($srchcol)
				{
					$this->db->where($srchcol);
				}
				if($limit && $limit>0)
				{
					$this->db->limit($limit);
				}
				if($offset)
				{
					$this->db->offset($offset);
				}

				if($order)
				{
					$this->db->order_by($order,$order_by);
				}

				$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
				if ($query->num_rows() > 0) 
				{
					$data=$query->result();		
					return $data;		
				}		
				return false;
			}


			public function get_issue_expenses()
			{
				$frmDate=$this->input->post('fromdate');
				$toDate=$this->input->post('todate');
				$locationid = $this->input->post('locationid');
				$supplierid = $this->input->post('supplierid');
				$sama_depid = $this->input->post('sama_depid');
				$sade_itemsid = $this->input->post('sade_itemsid');


				$this->db->select('rn.sama_st,rn.sama_billtime,sd.sade_remarks,rn.sama_salemasterid,rn.sama_invoiceno,rn.sama_billdatebs,rn.sama_billdatead,dp.dept_depname sama_depname,dp.dept_depid,sd.sade_salemasterid,sd.sade_saledetailid,sd.sade_qty,eq.itli_itemname,eq.itli_itemnamenp,sd.sade_itemsid,un.unit_unitname,eq.itli_itemcode,eq.itli_itemlistid,rn.sama_depid');
				$this->db->from('sade_saledetail sd');
				$this->db->join('sama_salemaster rn','rn.sama_salemasterid = sd.sade_salemasterid','LEFT');
				$this->db->join('dept_department dp','dp.dept_depid=rn.sama_depid','left');
				$this->db->join('itli_itemslist eq','eq.itli_itemlistid = sd.sade_itemsid','LEFT');
				$this->db->join('unit_unit un','un.unit_unitid = eq.itli_unitid','LEFT');

        // $this->db->where(array('rm.recm_status <>'=>'M'));
				if($frmDate && $toDate)
				{
					if(DEFAULT_DATEPICKER=='NP')
					{
						$this->db->where(array('rn.sama_requisitiondatebs >='=>$frmDate,'rn.sama_requisitiondatebs <='=>$toDate)); 
					}
					else
					{
						$this->db->where(array('rn.sama_requisitiondatead >='=>$frmDate,'rn.sama_requisitiondatead <='=>$toDate)); 
					}
				}
				if($locationid){
					$this->db->where('rn.sama_locationid',$locationid);
				}
				if($sama_depid){
					$this->db->where('rn.sama_depid',$sama_depid);
				}
				if($sade_itemsid){
					$this->db->where('sd.sade_itemsid',$sade_itemsid);
				}
				$this->db->order_by('rn.sama_salemasterid','ASC');

				$qry=$this->db->get();
        // echo $this->db->last_query();die(); 
				if($qry->num_rows()>0)
				{
					return $qry->result();
				}
				return false;
			}


			public function get_expenses_issue($type=false)
			{
				$frmDate=$this->input->post('fromdate');
				$toDate=$this->input->post('todate');
				$locationid = $this->input->post('locationid');
				$supplierid = $this->input->post('supplierid');
				$sama_depid = $this->input->post('depid');
				$sade_itemsid = $this->input->post('itemid');
				$itli_catid = $this->input->post('catid');


				$this->db->select('rn.sama_st,rn.sama_billtime,rn.sama_salemasterid,rn.sama_invoiceno,rn.sama_billdatebs,rn.sama_billdatead,sd.sade_itemsid,eq.itli_itemlistid,eq.itli_itemname,dp.dept_depname as sama_depname,rn.sama_requisitiondatebs,dp.dept_depid,rn.sama_depid,ec.eqca_category,ec.eqca_equipmentcategoryid,eq.itli_catid');
				$this->db->from('sama_salemaster rn');
				$this->db->join('sade_saledetail sd','sd.sade_salemasterid=rn.sama_salemasterid','LEFT');
				$this->db->join('itli_itemslist eq','eq.itli_itemlistid = sd.sade_itemsid','LEFT');
				$this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid = eq.itli_catid','LEFT');
				$this->db->join('dept_department dp','dp.dept_depid=rn.sama_depid','left');
		//$this->db->group_by('sama_depid');


        // $this->db->where(array('rm.recm_status <>'=>'M'));
				if($frmDate && $toDate)
				{
					if(DEFAULT_DATEPICKER=='NP')
					{
						$this->db->where(array('rn.sama_requisitiondatebs >='=>$frmDate,'rn.sama_requisitiondatebs <='=>$toDate)); 
					}
					else
					{
						$this->db->where(array('rn.sama_requisitiondatead >='=>$frmDate,'rn.sama_requisitiondatead <='=>$toDate)); 
					}
				}
				if($locationid){
					$this->db->where('rn.sama_locationid',$locationid);
				}
				if($sama_depid){
					$this->db->where('rn.sama_depid',$sama_depid);
				}

				if($sade_itemsid){
					$this->db->where('sd.sade_itemsid',$sade_itemsid);
				}

				if($itli_catid){
					$this->db->where('eq.itli_catid',$itli_catid);
				}

				if($type == 'category_wise'){
					$this->db->group_by('eqca_category');
					$this->db->order_by('ec.eqca_category','ASC');
				}else if($type == 'item_wise'){
					$this->db->group_by('itli_itemname');
					$this->db->order_by('eq.itli_itemname','ASC');
				}else if($type == 'department_wise'){
					$this->db->group_by('dept_depname');
					$this->db->order_by('dp.dept_depname','ASC');
				}else if($type == 'date_wise'){
					$this->db->group_by('sama_requisitiondatebs');
					$this->db->order_by('rn.sama_requisitiondatebs','ASC');
				}else{

				}


				$this->db->order_by('rn.sama_salemasterid','ASC');

				$qry=$this->db->get();
				echo $this->db->last_query();die(); 
				if($qry->num_rows()>0)
				{
					return $qry->result();
				}
				return false;
			}




			public function get_issue_expenses_analysis($srchcol=false,$limit=false,$offset=false,$order_by=false,$order='ASC')
			{
				$frmDate=$this->input->post('fromdate');
				$toDate=$this->input->post('todate');

				$sql_code_data=" (SELECT SUM(test_expensesqty) expqty from xw_test_teststock ts WHERE ts.test_itemid=sd.sade_itemsid AND ts.test_saledetailid=sd.sade_saledetailid AND ts.test_salemasterid=sd.sade_salemasterid) as expqty ";

				$this->db->select("rn.sama_st,rn.sama_billtime,sd.sade_remarks,rn.sama_salemasterid,rn.sama_invoiceno,rn.sama_billdatebs,rn.sama_billdatead,dp.dept_depname sama_depname,sd.sade_salemasterid,sd.sade_saledetailid,sd.sade_qty,sd.sade_itemsid,eq.itli_itemname,eq.itli_itemnamenp,rn.sama_requisitiondatebs,un.unit_unitname,eq.itli_catid,ec.eqca_category,ec.eqca_equipmentcategoryid,eq.itli_itemcode,eq.itli_itemlistid,$sql_code_data");
				$this->db->from('sade_saledetail sd');
				$this->db->join('sama_salemaster rn','rn.sama_salemasterid = sd.sade_salemasterid','LEFT');
				$this->db->join('dept_department dp','dp.dept_depid=rn.sama_depid','left');
				$this->db->join('itli_itemslist eq','eq.itli_itemlistid = sd.sade_itemsid','LEFT');
				$this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=eq.itli_catid','LEFT');
				$this->db->join('unit_unit un','un.unit_unitid = eq.itli_unitid','LEFT');
				if($frmDate && $toDate)
				{
					if(DEFAULT_DATEPICKER=='NP')
					{
						$this->db->where(array('rn.sama_requisitiondatebs >='=>$frmDate,'rn.sama_requisitiondatebs <='=>$toDate)); 
					}
					else
					{
						$this->db->where(array('rn.sama_requisitiondatead >='=>$frmDate,'rn.sama_requisitiondatead <='=>$toDate)); 
					}
				}
				if($srchcol)
				{
					$this->db->where($srchcol); 
				}

				if($limit && $limit>0)
				{
					$this->db->limit($limit);
				}

				if($offset)
				{
					$this->db->offset($offset);
				}

				if($order_by)
				{
					$this->db->order_by($order_by,$order);
				}
				$qry=$this->db->get();
        // echo $this->db->last_query();die();

				if($qry->num_rows()>0)
				{
					return $qry->result();
				}
				return false;
			}
			public function TestItemList($srchcol=false)
			{
				$get = $_GET;

				foreach ($get as $key => $value) {
					$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
				}
				if(!empty($get['sSearch_0'])){
					$this->db->where("tena_id like  '%".$get['sSearch_0']."%'  ");
				}
				if(!empty($get['sSearch_1'])){
					$this->db->where("tena_mid like  '%".$get['sSearch_1']."%'  ");
				}

				if(!empty($get['sSearch_2'])){
					$this->db->where("tena_code like  '%".$get['sSearch_2']."%'  ");
				}
				if(!empty($get['sSearch_3'])){
					$this->db->where("tena_name like  '%".$get['sSearch_3']."%'  ");
				}

				if(!empty($get['sSearch_4'])){
					$this->db->where("tena_postdatebs like  '%".$get['sSearch_4']."%'  ");
				}
				if(!empty($get['sSearch_5'])){
					$this->db->where("tena_postdatead like  '%".$get['sSearch_5']."%'  ");
				}
				if(!empty($get['sSearch_6'])){
					$this->db->where("tena_isactive like  '%".$get['sSearch_6']."%'  ");
				}

				$frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
				$toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

				if(!empty(($frmDate && $toDate)))
				{
					if(DEFAULT_DATEPICKER == 'NP'){
						$this->db->where('tt.tena_postdatebs >=',$frmDate);
						$this->db->where('tt.tena_postdatebs <=',$toDate);    
					}else{
						$this->db->where('tt.tena_postdatead >=',$frmDate);
						$this->db->where('tt.tena_postdatead <=',$toDate);
					}
				}

				if($srchcol)
				{
					$this->db->where($srchcol); 
				}



				$resltrpt=$this->db->select("COUNT(*) as cnt")
				->from('tena_testname tt')

		 // ->where(array('tt.usre_isactive'=>'1'))
				->get()
				->row(); 
      	// echo $this->db->last_query();die(); 
				$totalfilteredrecs=$resltrpt->cnt; 

				$order_by = 'tena_id';
				$order = 'desc';
				if($this->input->get('sSortDir_0'))
				{
					$order = $this->input->get('sSortDir_0');
				}

				$where='';
				if($this->input->get('iSortCol_0')==1)
					$order_by = 'tena_id';
				if($this->input->get('iSortCol_0')==2)
					$order_by = 'tena_mid';
				else if($this->input->get('iSortCol_0')==3)
					$order_by = 'tena_code';
				else if($this->input->get('iSortCol_0')==4)
					$order_by = 'tena_name';
				else if($this->input->get('iSortCol_0')==5)
					$order_by = 'tena_postdatebs';
				else if($this->input->get('iSortCol_0')==6)
					$order_by = 'tena_postdatead';
				else if($this->input->get('iSortCol_0')==7)
					$order_by = 'tena_isactive';


				$totalrecs='';
				$limit = 15;
				$offset = 1;
				$get = $_GET;

				foreach ($get as $key => $value) {
					$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
				}

				if(!empty($_GET["iDisplayLength"])){
					$limit = $_GET['iDisplayLength'];
					$offset = $_GET["iDisplayStart"];
				}

				if(!empty($get['sSearch_0'])){
					$this->db->where("tena_id like  '%".$get['sSearch_0']."%'  ");
				}
				if(!empty($get['sSearch_1'])){
					$this->db->where("tena_mid like  '%".$get['sSearch_1']."%'  ");
				}

				if(!empty($get['sSearch_2'])){
					$this->db->where("tena_code like  '%".$get['sSearch_2']."%'  ");
				}
				if(!empty($get['sSearch_3'])){
					$this->db->where("tena_name like  '%".$get['sSearch_3']."%'  ");
				}

				if(!empty($get['sSearch_4'])){
					$this->db->where("tena_postdatebs like  '%".$get['sSearch_4']."%'  ");
				}
				if(!empty($get['sSearch_5'])){
					$this->db->where("tena_postdatead like  '%".$get['sSearch_5']."%'  ");
				}
				if(!empty($get['sSearch_6'])){
					$this->db->where("tena_isactive like  '%".$get['sSearch_6']."%'  ");
				}


				if(!empty(($frmDate && $toDate)))
				{
					if(DEFAULT_DATEPICKER == 'NP'){
						$this->db->where('tt.tena_postdatebs >=',$frmDate);
						$this->db->where('tt.tena_postdatebs <=',$toDate);    
					}else{
						$this->db->where('tt.tena_postdatead >=',$frmDate);
						$this->db->where('tt.tena_postdatead <=',$toDate);
					}
				}



				$this->db->select('tt.*');
				$this->db->from('tena_testname tt');



        // $this->db->where(array('tt.usre_isactive'=>'1'));
		// $this->db->order_by('usre_isactive','desc');



				if($srchcol)
				{
					$this->db->where($srchcol); 
				}

				if($limit && $limit>0)
				{  
					$this->db->limit($limit);
				}
				if($offset)
				{
					$this->db->offset($offset);
				}

				$nquery=$this->db->get();
				$num_row=$nquery->num_rows();
				// if(!empty($_GET['iDisplayLength'])) {
				// 	$totalrecs = sizeof( $nquery);
				// }
				if (!empty($_GET['iDisplayLength']) &&  !empty($resltrpt) && is_array($resltrpt) && sizeof($resltrpt) > 0 ) {
					$totalfilteredrecs = sizeof($resltrpt);
				}


				if($num_row>0){
					$ndata=$nquery->result();
					$ndata['totalrecs'] = $totalrecs;
					$ndata['totalfilteredrecs'] = $totalfilteredrecs;
				} 
				else
				{
					$ndata=array();
					$ndata['totalrecs'] = 0;
					$ndata['totalfilteredrecs'] = 0;
				}
	      // echo $this->db->last_query();die();
				return $ndata;

			}
			
			public function get_all_item_details($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
			{


				$this->db->select('tt.*,tn.tena_mid,tn.tena_code,tn.tena_name,eq.itli_itemname,eq.itli_itemnamenp,
					eq.itli_itemcode,un.unit_unitname,tena_apidepid,tena_apidepname');
				$this->db->from('tema_testmapitem tt');
				$this->db->join('tena_testname tn','tn.tena_id = tt.tema_testnameid','LEFT');
				$this->db->join('itli_itemslist eq','eq.itli_itemlistid = tt.tema_invitemid','LEFT');
				$this->db->join('unit_unit un','un.unit_unitid = eq.itli_unitid','LEFT');

				if($srchcol)
				{
					$this->db->where($srchcol);
				}
				if($limit && $limit>0)
				{
					$this->db->limit($limit);
				}
				if($offset)
				{
					$this->db->offset($offset);
				}

				if($order)
				{
					$this->db->order_by($order,$order_by);
				}

				$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
				if ($query->num_rows() > 0) 
				{
					$data=$query->result();		
					return $data;		
				}		
				return false;
			}


			public function save_item_name_to_map(){
				try{

					$tema_testnameid = $this->input->post('tena_id');
					$tema_mid = $this->input->post('tena_mid');
					$itemsid = $this->input->post('tema_invitemid');
					$invdepid = $this->input->post('tena_invdepid');
					$tema_perml =  $this->input->post('tema_perml');
					$tema_unit =  $this->input->post('tema_unit');
					$tema_maxtestcount = $this->input->post('tema_maxtestcount');
					$tema_mintestcount = $this->input->post('tema_mintestcount');


					$tema_testmapid = $this->input->post('tema_testmapid');//detable id

					$tema_apidepid = $this->input->post('tena_apidepid');
					$tema_apidepname = $this->input->post('tena_apidepname');

					 // echo $tema_apidepid; $tema_apidepname;die;
					$this->db->trans_begin();

					if($tema_testmapid){ 
						$old_test_map_data = $this->get_all_item_details(array('tema_testnameid'=>$tema_testnameid),false,false,false,false);
						$old_item_map_array=array();
						if(!empty($old_test_map_data)){
							foreach($old_test_map_data as $key=>$value){
								$old_item_map_array[] = $value->tema_testmapid;
							}
						}

						$tema_insertid=array();
						if(!empty($itemsid)){

							foreach($itemsid as $key=>$val){

								$testmapid = !empty($tema_testmapid[$key])?$tema_testmapid[$key]:'';

								if($testmapid){
									if(in_array($testmapid, $old_item_map_array)){
										$rede_array[] = $testmapid;
									}
									$rede_update_array = array(
										'tema_testnameid'=>$tema_testnameid,
										'tema_mid'=>$tema_mid, 
										'tema_invitemid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
										'tema_perml'=> !empty($tema_perml[$key])?$tema_perml[$key]:'',
										'tema_unit'=> !empty($tema_unit[$key])?$tema_unit[$key]:'',
										'tema_mintestcount'=> !empty($tema_mintestcount[$key])?$tema_mintestcount[$key]:'',
										'tema_maxtestcount'=> !empty($tema_maxtestcount[$key])?$tema_maxtestcount[$key]:'',
										'tema_postdatead'=>CURDATE_EN,
										'tema_postdatebs'=>CURDATE_NP,
										'tema_posttime'=>$this->curtime,
										'tema_postby'=>$this->userid,
										'tema_postmac'=>$this->mac,
										'tema_postip'=>$this->ip,
										'tema_locationid'=>$this->locationid,
										'tema_depid'=>$this->userdepid,
										'tema_apidepid'=>$tema_apidepid,
										'tema_invdepid'=>$invdepid,
										'tema_apidepname'=>$tema_apidepname,
									);

									$this->db->update('tema_testmapitem', $rede_update_array,array('tema_testmapid'=>$testmapid));
								} 
								else{
									$rede_insert_array = array(
										'tema_testnameid'=>$tema_testnameid,
										'tema_mid'=>$tema_mid,
										'tema_invitemid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
										'tema_perml'=> !empty($tema_perml[$key])?$tema_perml[$key]:'',
										'tema_unit'=> !empty($tema_unit[$key])?$tema_unit[$key]:'',
										'tema_mintestcount'=> !empty($tema_mintestcount[$key])?$tema_mintestcount[$key]:'',
										'tema_maxtestcount'=> !empty($tema_maxtestcount[$key])?$tema_maxtestcount[$key]:'',
										'tema_postdatead'=>CURDATE_EN,
										'tema_postdatebs'=>CURDATE_NP,
										'tema_posttime'=>$this->curtime,
										'tema_postby'=>$this->userid,
										'tema_postmac'=>$this->mac,
										'tema_postip'=>$this->ip,
										'tema_locationid'=>$this->locationid,
										'tema_orgid'=>$this->orgid,
										'tema_depid'=>$this->userdepid,
										'tema_apidepid'=>$tema_apidepid,
										'tema_invdepid'=>$invdepid,
										'tema_apidepname'=>$tema_apidepname,
									);
									$this->db->insert('tema_testmapitem', $rede_insert_array);
									$tema_insertid[] = $this->db->insert_id();
								} 
							} 
						} 
						$old_items_list = $this->general->get_tbl_data('tema_testmapid','tema_testmapitem',array('tema_testnameid'=>$tema_testnameid));

						$old_items_array = array();
						if(!empty($old_items_list)){
							foreach($old_items_list as $key=>$value){
								$old_items_array[] = $value->tema_testmapid;
							}
						}

                // print_r($old_items_array);
                // die();

						$total_itemlist = count($old_items_list);

						$deleted_items = array();

						if($tema_insertid){
							$tema_testmapid = array_merge($tema_testmapid, $tema_insertid);
						}

						if(is_array($tema_testmapid)){
							$deleted_items = array_diff($old_items_array, $tema_testmapid);
						}

						$del_items_num = count($deleted_items);

						if(!empty($del_items_num)){
							for($i = 0; $i<$del_items_num; $i++){
								$deleted_array = array_values($deleted_items);

								foreach($deleted_array as $key=>$del){

									$this->db->where(array('tema_testmapid'=>$del));
									$this->db->delete('tema_testmapitem');
								}
							}
						}



					}
					else{
						if(!empty($itemsid)):
							foreach ($itemsid as $key => $val) {
								$TestItemArraqy[]=array( 
									'tema_testnameid'=>$tema_testnameid,
									'tema_mid'=>$tema_mid,
									'tema_invitemid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
									'tema_perml'=> !empty($tema_perml[$key])?$tema_perml[$key]:'',
									'tema_unit'=> !empty($tema_unit[$key])?$tema_unit[$key]:'',
									'tema_mintestcount'=> !empty($tema_mintestcount[$key])?$tema_mintestcount[$key]:'',
									'tema_maxtestcount'=> !empty($tema_maxtestcount[$key])?$tema_maxtestcount[$key]:'',
									'tema_postdatead'=>CURDATE_EN,
									'tema_postdatebs'=>CURDATE_NP,
									'tema_posttime'=>$this->curtime,
									'tema_postby'=>$this->userid,
									'tema_postmac'=>$this->mac,
									'tema_postip'=>$this->ip,
									'tema_locationid'=>$this->locationid,
									'tema_orgid'=>$this->orgid,
									'tema_depid'=>$this->userdepid,
									'tema_apidepid'=>$tema_apidepid,
									'tema_invdepid'=>$invdepid,
									'tema_apidepname'=>$tema_apidepname,
								);
							}
						endif;
						if(!empty($TestItemArraqy)){   
							$this->db->insert_batch('tema_testmapitem',$TestItemArraqy);
						}
					}
					$this->db->trans_complete();
					if ($this->db->trans_status() === FALSE){
						$this->db->trans_rollback();
						return false;
					}
					else{
						$this->db->trans_commit();
						if($tema_testmapid){
							return true;
						}else{
							return true;
						}
					}
				}catch(Exception $e){
					throw $e;
				}
			}
			public function get_test_map_list_data($srch=false,$limit=false,$offset=false,$order_by=false,$order=false,$is_distinct=false,$is_distinct1=false)
			{
				$tema_apidepid = $this->input->post('tema_apidepid');
				$item_name = $this->input->post('item_name');
				$frmDate=!empty($this->input->post('frmDate'))?$this->input->post('frmDate'):CURMONTH_DAY1;
				$toDate=!empty($this->input->post('toDate'))?$this->input->post('toDate'):DISPLAY_DATE;
				$this->db->select('tt.*,tn.tena_id,tn.tena_mid,tn.tena_code,tn.tena_name,eq.itli_itemname,eq.itli_itemnamenp,
					eq.itli_itemcode');
				$this->db->from('tema_testmapitem tt');
				$this->db->join('tena_testname tn','tn.tena_id = tt.tema_testnameid','LEFT');
				$this->db->join('itli_itemslist eq','eq.itli_itemlistid = tt.tema_invitemid','LEFT');
				// $this->db->join('dept_department dd','dd.dept_depid = tt.tema_depid','LEFT');

				if($srch)
				{
					$this->db->where($srch); 
				}
				if($frmDate &&  $toDate)
				{
					if(DEFAULT_DATEPICKER=='NP')
					{
						$this->db->where(array('tt.tema_postdatebs >='=>$frmDate,'tt.tema_postdatebs <='=>$toDate));
					}
					else
					{
						$this->db->where(array('tt.tema_postdatead >='=>$frmDate,'tt.tema_postdatead <='=>$toDate));
					}
				}
				if(!empty($item_name))
				{
					
					$this->db->where(array('tt.tema_testnameid'=>$item_name));
					
				}
				if(!empty($tema_apidepid))
				{
					
					$this->db->where(array('tt.tema_apidepid'=>$tema_apidepid));
					
				}
				
				
				

				if($limit && $limit>0)
				{
					$this->db->limit($limit);
				}
				if($offset)
				{
					$this->db->offset($offset);
				}
				if($order_by)
				{
					$this->db->order_by($order_by,$order);
				}

				$query = $this->db->get();

				$last_qry= $this->db->last_query();
				if($is_distinct)
				{
					$new_qry=$this->db->query("SELECT DISTINCT(tena_name),tema_testnameid FROM( $last_qry )X")->result();
					return $new_qry;
				}
				elseif($is_distinct1)
				{
					$new_qry=$this->db->query("SELECT DISTINCT(tema_apidepname),tema_apidepid FROM( $last_qry )X")->result();
					return $new_qry;
				}
				else
				{
					if ($query->num_rows() > 0) 
					{
						$data=$query->result();		
						return $data;		
					}		
				}		
				return false;
			}

			
			public function get_all_itemtest_name_distinct_itemtest($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
			{


				$this->db->select('DISTINCT(tn.tena_name) as itemname,tn.tena_id');
				$this->db->from('tena_testname tn');


				if($srchcol)
				{
					$this->db->where($srchcol);
				}
				if($limit && $limit>0)
				{
					$this->db->limit($limit);
				}
				if($offset)
				{
					$this->db->offset($offset);
				}

				if($order)
				{
					$this->db->order_by($order,$order_by);
				}

				$query = $this->db->get();

				if ($query->num_rows() > 0) 
				{
					$data=$query->result();		
					return $data;		
				}		
				return false;
			}
			public function get_test_map_list_data_department($srch=false,$limit=false,$offset=false,$order_by=false,$order=false,$is_distinct=false,$is_distinct1=false,$is_distinct2=false)
			{
				$tema_apidepid = $this->input->post('tema_apidepid');
				$testitem_name = $this->input->post('testitem_name');
				$invitem_name = $this->input->post('invitem_name');
				$frmDate=!empty($this->input->post('frmDate'))?$this->input->post('frmDate'):'';
				$toDate=!empty($this->input->post('toDate'))?$this->input->post('toDate'):'';
				$this->db->select('tv.*');
				$this->db->from('xw_vw_department_test_item_cnt tv');

				if($srch)
				{
					$this->db->where($srch); 
				}
				if($frmDate &&  $toDate)
				{
					if(DEFAULT_DATEPICKER=='NP')
					{
						$this->db->where(array('tv.telo_datadatebs >='=>$frmDate,'tv.telo_datadatebs <='=>$toDate));
					}
					else
					{
						$this->db->where(array('tv.telo_datadatead >='=>$frmDate,'tv.telo_datadatead <='=>$toDate));
					}
				}
				if(!empty($invitem_name))
				{
					
					$this->db->where(array('tv.tema_invitemid'=>$invitem_name));
					
				}
				if(!empty($tema_apidepid))
				{
					
					$this->db->where(array('tv.tema_apidepid'=>$tema_apidepid));
					
				}
				if(!empty($testitem_name))
				{
					
					$this->db->where(array('tv.telo_testname'=>$testitem_name));
					
				}

				if($limit && $limit>0)
				{
					$this->db->limit($limit);
				}
				if($offset)
				{
					$this->db->offset($offset);
				}
				if($order_by)
				{
					$this->db->order_by($order_by,$order);
				}

				$query = $this->db->get();

				$last_qry= $this->db->last_query();
				if($is_distinct)
				{
					$new_qry=$this->db->query("SELECT DISTINCT(telo_testname),telo_testid,telo_itemid,tema_testnameid FROM( $last_qry )X")->result();
					return $new_qry;
				}
				elseif($is_distinct1)
				{
					$new_qry=$this->db->query("SELECT DISTINCT(tema_apidepname),tema_apidepid,tema_invdepid FROM( $last_qry )Y")->result();
					return $new_qry;
				}
				elseif($is_distinct2)
				{
					$new_qry=$this->db->query("SELECT DISTINCT(itli_itemname),tema_invitemid,tema_invdepid FROM( $last_qry )Z")->result();
					return $new_qry;
				}
				else
				{
					if ($query->num_rows() > 0) 
					{
						$data=$query->result();		
						return $data;		
					}		
				}		
				return false;
			}
			public function get_all_department_wise_item($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false,$con1=false,$con2=false)
			{
				$this->db->select('tv.telo_testname,COUNT(telo_testname) as cnt,tv.telo_datadatebs,tv.tema_apidepid as apidepid,tv.telo_testid,tv.telo_itemid as testid,tv.tema_invitemid,tv.tema_testnameid,tv.tema_invdepid ');

				$this->db->from('vw_department_test_item_cnt tv');
				$this->db->group_by('tv.telo_testname');

				if($srchcol)
				{
					$this->db->where($srchcol);
				}

				if(!empty($con1))
				{
					$this->db->where($con1);
				}
				if(!empty($con2))
				{
					$this->db->where($con2);
				}
				if($limit && $limit>0)
				{
					$this->db->limit($limit);
				}
				if($offset)
				{
					$this->db->offset($offset);
				}

				if($order)
				{
					$this->db->order_by($order,$order_by);
				}

				$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
				if ($query->num_rows() > 0) 
				{
					$data=$query->result();		
					return $data;		
				}		
				return false;
			}

			public function get_all_department_wise_item_details($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false,$con1=false,$con2=flase)
			{
				$this->db->select('tv.telo_testname,tv.tema_apidepid,tv.telo_testid,tv.telo_itemid as testid,tv.telo_testcode,tv.tema_invitemid,tv.itli_itemname,tv.tema_unit,tv.telo_cnt,tv.tema_apidepname,tv.tema_perml,tv.tema_mintestcount,tv.tema_maxtestcount');

				$this->db->from('vw_department_test_item_cnt tv');
				

				if($srchcol)
				{
					$this->db->where($srchcol);
				}

				if(!empty($con1))
				{
					$this->db->where($con1);
				}
				if(!empty($con2))
				{
					$this->db->where($con2);
				}
				if($limit && $limit>0)
				{
					$this->db->limit($limit);
				}
				if($offset)
				{
					$this->db->offset($offset);
				}

				if($order)
				{
					$this->db->order_by($order,$order_by);
				}

				$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
				if ($query->num_rows() > 0) 
				{
					$data=$query->result();		
					return $data;		
				}		
				return false;
			}
			public function get_all_test_item_table_all($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
			{
				$this->db->select('tn.*,ad.apde_departmentname,ad.apde_invdepid');

				$this->db->from('tena_testname tn');

				$this->db->join('apde_apidepartment ad','ad.apde_appdepartmentid = tn.tena_apidepid','LEFT');

				

				if($srchcol)
				{
					$this->db->where($srchcol);
				}
				if($limit && $limit>0)
				{
					$this->db->limit($limit);
				}
				if($offset)
				{
					$this->db->offset($offset);
				}

				if($order)
				{
					$this->db->order_by($order,$order_by);
				}

				$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
				if ($query->num_rows() > 0) 
				{
					$data=$query->result();		
					return $data;		
				}		
				return false;
			}
			


	// public function item_stock_department($itemid=false,$depid=false,$fromDate=false,$toDate=false)
	// 		{
	// 			$where = "";
	// 			if($fromDate && $toDate){
	// 				if(DEFAULT_DATEPICKER=='NP')
	// 				{
	// 					$where .= "AND sama_billdatebs >= '$fromDate' AND sama_billdatebs <= '$toDate'";
	// 				}
	// 				else{
	// 					$where .= "AND sama_billdatead >= '$fromDate' AND sama_billdatead <= '$toDate'";
	// 				}
	// 			}
	// 			// $sama_depid = $this->input->post('depid');
	// 			if($depid){

	// 				$where .= " AND sama_depid = '$depid'";

	// 			}
	// 			if($itemid){
	// 				$where .= " AND sade_itemsid = '$itemid'";

	// 			}


	// 			$con = "";
	// 			if($fromDate && $toDate){
	// 				if(DEFAULT_DATEPICKER=='NP')
	// 				{
	// 					$con.= " tema_postdatebs >= '$fromDate' AND tema_postdatebs <= '$toDate'";
	// 				}
	// 				else{
	// 					$con.= " tema_postdatead >= '$fromDate' AND tema_postdatead <= '$toDate'";
	// 				}
	// 			}
	// 			if($depid){

	// 				$con.= " AND tema_invdepid = '$depid'";

	// 			}

	// 			$sql="SELECT
	// 			sade_saledetailid,
	// 			sade_salemasterid,
	// 			sade_itemsid,

	// 			tema_mintestcount,
	// 			tema_maxtestcount,
	// 			tema_perml,
	// 			sum(sade_qty) * tema_mintestcount AS issue_qty,
	// 			x.test_qty,
	// 			x.tena_mid,
	// 			x.tema_unit,
	// 			sade_unitrate,
	// 			sama_depid,
	// 			sama_receivedby,
	// 			sama_soldby,
	// 			sama_billtime,
	// 			sama_billdatebs,
	// 			sama_billdatead,
	// 			sama_depname,
	// 			sama_invoiceno,
	// 			itli_itemcode,
	// 			itli_itemname,
	// 			eqca_category
	// 			FROM
	// 			xw_sade_saledetail ss
	// 			LEFT JOIN xw_sama_salemaster sm ON sm.sama_salemasterid = ss.sade_salemasterid
	// 			LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = ss.sade_itemsid
	// 			LEFT JOIN xw_eqca_equipmentcategory eq ON eq.eqca_equipmentcategoryid = il.itli_catid
	// 			LEFT JOIN (
	// 			SELECT
	// 			tmi.tema_invitemid,
	// 			tmi.tema_mintestcount,
	// 			tmi.tema_maxtestcount,
	// 			tmi.tema_unit,
	// 			tmi.tema_perml,
	// 			tmi.tema_postdatead,
	// 			tmi.tema_postdatebs,
	// 			tena_mid,
	// 			sum(tl.telo_cnt) AS test_qty
	// 			FROM
	// 			xw_telo_testlog tl
	// 			LEFT JOIN xw_tena_testname tn ON tn.tena_mid = tl.telo_itemid
	// 			LEFT JOIN xw_tema_testmapitem tmi ON tmi.tema_mid = tl.telo_itemid
	// 			WHERE
	// 			$con
	// 			GROUP BY
	// 			tema_invitemid
	// 			) x ON x.tema_invitemid = ss.sade_itemsid
	// 			WHERE
	// 			eqca_equipmentcategoryid = 4 
	// 			$where
	// 			GROUP BY
	// 			sade_itemsid";
	// 			$query = $this->db->query($sql);
 //      // echo $this->db->last_query();
 //      // die();
	// 			return $query->result();
	// 		}





			public function get_reagent_department_stock_lists($cond= false)
			{
				$apptype = $this->input->get('apptype');
				$get = $_GET;
				foreach ($get as $key => $value) {
					$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
				}

				if(!empty($get['sSearch_1'])){
					$this->db->where("itli_itemname like  '%".$get['sSearch_1']."%'  ");
				}
				if(!empty($get['sSearch_2'])){
					$this->db->where("itli_itemcode like  '%".$get['sSearch_2']."%'   ");
				}
				if(!empty($get['sSearch_3'])){
					$this->db->where("dept_depname like  '%".$get['sSearch_3']."%'  ");
				}

				if(!empty($get['sSearch_4'])){
					$this->db->where("test_qty like  '%".$get['sSearch_5']."%'  ");
				}
				if(!empty($get['sSearch_5'])){
					$this->db->where("lab_stock_qty like  '%".$get['sSearch_5']."%'  ");
				}
				if(!empty($get['sSearch_6'])){
					$this->db->where("rec_qty like  '%".$get['sSearch_6']."%'  ");
				}
				if(!empty($get['sSearch_7'])){
					$this->db->where("rec_cnt like  '%".$get['sSearch_7']."%'  ");
				}
				if(!empty($get['sSearch_8'])){
					$this->db->where("avl_item_stock like  '%".$get['sSearch_8']."%'  ");
				}


        // if($cond) {
        //     $this->db->where($cond);
        // }

				$items = !empty($get['items'])?$get['items']:$this->input->post('items');
				$depid = !empty($get['depid'])?$get['depid']:$this->input->post('depid');


				if(!empty($depid))
				{
					$this->db->where('depid',$depid);
				}


				if(!empty($items))
				{
					$this->db->where('itemid',$items);
				}


				if($apptype == 'available'){
					$this->db->having('stockrmk','Stock');
				}else if($apptype == 'zero'){
					$this->db->having('stockrmk','Zero');
				}else if($apptype == 'limited'){
					$this->db->having('stockrmk','Limited');
				}
				$select = "it.itli_itemname,it.itli_itemname,it.itli_itemcode,dp.dept_depname,itemid,
				depid,
				SUM(mincnt) mincnt,
				SUM(maxcnt) maxcnt,
				SUM(test_qty) AS test_qty,
				SUM(rec_qty) rec_qty,
				(SUM(rec_qty) * sum(maxcnt)) AS rec_cnt,
				(
				(SUM(rec_qty) * sum(maxcnt)) - SUM(test_qty)
				) lab_stock_qty,
				(
				CASE
				WHEN (sum(maxcnt) != 0.00) THEN
				(
				(
				(SUM(rec_qty) * sum(maxcnt)) - SUM(test_qty)
				) / sum(maxcnt)
				)
				ELSE
				SUM(rec_qty)
				END
				) avl_item_stock, 
				(
				CASE WHEN((ifnull(sum(avl_item_stock),0) < 10) && (ifnull(sum(avl_item_stock),0)>0 )) THEN 'Limited'  WHEN (ifnull(sum(avl_item_stock),0)=0) THEN 'Zero' ELSE  'Stock' END ) as stockrmk";
				$resltrpt=$this->db->select($select)
				->from('xw_vw_lab_stock_rec st')
				->join('dept_department dp','dp.dept_depid=st.depid','left')

				->join('itli_itemslist it','it.itli_itemlistid = st.itemid','LEFT')
				->group_by('itemid, depid')
				->get()
				->result();
         // echo $this->db->last_query();die();
        // $totalfilteredrecs=$resltrpt->cnt;
				$totalfilteredrecs = sizeof($resltrpt); 

				$order_by = 'itemid';
				$order = 'asc';
				if($this->input->get('sSortDir_0'))
				{
					$order = $this->input->get('sSortDir_0');
				}

				$where='';
				if($this->input->get('iSortCol_0')==1)

					$order_by = 'itli_itemname';
				else if($this->input->get('iSortCol_0')==2)
					$order_by = 'itli_itemcode';
				else if($this->input->get('iSortCol_0')==3)
					$order_by = 'itli_itemname';

				else if($this->input->get('iSortCol_0')==4)
					$order_by = 'test_qty';
				else if($this->input->get('iSortCol_0')==5)
					$order_by = 'lab_stock_qty';
				else if($this->input->get('iSortCol_0')==6)
					$order_by = 'rec_qty';
				else if($this->input->get('iSortCol_0')==7)
					$order_by = 'rec_cnt';
				else if($this->input->get('iSortCol_0')==8)
					$order_by = 'avl_item_stock';

				$totalrecs='';
				$limit = 15;
				$offset = 0;
				$get = $_GET;

				foreach ($get as $key => $value) {
					$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
				}

				if(!empty($_GET["iDisplayLength"])){
					$limit = $_GET['iDisplayLength'];
					$offset = $_GET["iDisplayStart"];
				}

				if(!empty($get['sSearch_1'])){
					$this->db->where("itli_itemname like  '%".$get['sSearch_1']."%'  ");
				}
				if(!empty($get['sSearch_2'])){
					$this->db->where("itli_itemcode like  '%".$get['sSearch_2']."%'   ");
				}
				if(!empty($get['sSearch_3'])){
					$this->db->where("dept_depname like  '%".$get['sSearch_3']."%'  ");
				}

				if(!empty($get['sSearch_4'])){
					$this->db->where("test_qty like  '%".$get['sSearch_5']."%'  ");
				}
				if(!empty($get['sSearch_5'])){
					$this->db->where("lab_stock_qty like  '%".$get['sSearch_5']."%'  ");
				}
				if(!empty($get['sSearch_6'])){
					$this->db->where("rec_qty like  '%".$get['sSearch_6']."%'  ");
				}
				if(!empty($get['sSearch_7'])){
					$this->db->where("rec_cnt like  '%".$get['sSearch_7']."%'  ");
				}
				if(!empty($get['sSearch_8'])){
					$this->db->where("avl_item_stock like  '%".$get['sSearch_8']."%'  ");
				}


				$select = "
				it.itli_itemname,it.itli_itemname,it.itli_itemcode,dp.dept_depname,itemid,
				depid,
				SUM(mincnt) mincnt,
				SUM(maxcnt) maxcnt,
				SUM(test_qty) AS test_qty,
				SUM(rec_qty) rec_qty,
				(SUM(rec_qty) * sum(maxcnt)) AS rec_cnt,
				(
				(SUM(rec_qty) * sum(maxcnt)) - SUM(test_qty)
				) lab_stock_qty,
				(
				CASE
				WHEN (sum(maxcnt) != 0.00) THEN
				(
				(
				(SUM(rec_qty) * sum(maxcnt)) - SUM(test_qty)
				) / sum(maxcnt)
				)
				ELSE
				SUM(rec_qty)
				END
				) avl_item_stock,
				(
				CASE WHEN((ifnull(sum(avl_item_stock),0) < 10) && (ifnull(sum(avl_item_stock),0)>0 )) THEN 'Limited'  WHEN (ifnull(sum(avl_item_stock),0)=0) THEN 'Zero' ELSE  'Stock' END ) as stockrmk";

				$this->db->select($select);
				$this->db->from('xw_vw_lab_stock_rec st');
				$this->db->join('dept_department dp','dp.dept_depid=st.depid','left');
				$this->db->join('itli_itemslist it','it.itli_itemlistid = st.itemid','LEFT');

        // $this->db->where(array('tm.trma_received'=>'1','td.trde_status'=>'O'));
				$this->db->group_by('itemid, depid');


				if($cond) 
				{
					$this->db->where($cond);
				}


				$items = !empty($get['items'])?$get['items']:$this->input->post('items');
				$depid = !empty($get['depid'])?$get['depid']:$this->input->post('depid');


				if(!empty($depid))
				{
					$this->db->where('depid',$depid);
				}


				if(!empty($items))
				{
					$this->db->where('itemid',$items);
				}
				if($apptype == 'available'){
					$this->db->having('stockrmk','Stock');
				}else if($apptype == 'zero'){
					$this->db->having('stockrmk','Zero');
				}else if($apptype == 'limited'){
					$this->db->having('stockrmk','Limited');
				}


				$order_by = 'itemid';
				$order = 'asc';
				if($this->input->get('sSortDir_0'))
				{
					$order = $this->input->get('sSortDir_0');
				}

				$this->db->order_by($order_by,$order);



				if($limit && $limit>0)
				{  
					$this->db->limit($limit);
				}
				if($offset)
				{
					$this->db->offset($offset);
				}

        // $nquery=$this->db->query($sql);
				$nquery=$this->db->get();

        // echo $this->db->last_query();die();
				$num_row=$nquery->num_rows();
				if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
					$totalrecs = sizeof($nquery);
				}

				if($num_row>0){
					$ndata=$nquery->result();
					$ndata['totalrecs'] = $totalrecs;
					$ndata['totalfilteredrecs'] = $totalfilteredrecs;
				} 
				else
				{
					$ndata=array();
					$ndata['totalrecs'] = 0;
					$ndata['totalfilteredrecs'] = 0;
				}
         // echo $this->db->last_query();die();
				return $ndata;
			}

			public function item_stock_department($itemid=false,$depid=false)
			{
				$whr = "";
				
				
			   if($depid){
					
					$whr.= "WHERE depid = '$depid'";
					
				}
				if($itemid){
					$whr.= "AND itemid = '$itemid'";

				}


			$sql="SELECT
				`it`.`itli_itemname`,
				`it`.`itli_itemname`,
				`it`.`itli_itemcode`,
				`dp`.`dept_depname`,
				`itemid`,
				`depid`,
				SUM(mincnt) mincnt,
				SUM(maxcnt) maxcnt,
				SUM(test_qty) AS test_qty,
				SUM(rec_qty) rec_qty,
				(SUM(rec_qty) * sum(maxcnt)) AS rec_cnt,
				(
				(SUM(rec_qty) * sum(maxcnt)) - SUM(test_qty)
				) lab_stock_qty,
				(
				CASE
				WHEN (sum(maxcnt) != 0.00) THEN
				(
				(
				(SUM(rec_qty) * sum(maxcnt)) - SUM(test_qty)
				) / sum(maxcnt)
				)
				ELSE
				SUM(rec_qty)
				END
				) avl_item_stock,
				(
				CASE
				WHEN (
				(
				ifnull(sum(avl_item_stock), 0) < 10
				) && (
				ifnull(sum(avl_item_stock), 0) > 0
				)
				) THEN
				'Limited'
				WHEN (
				ifnull(sum(avl_item_stock), 0) = 0
				) THEN
				'Zero'
				ELSE
				'Stock'
				END
				) AS stockrmk
				FROM
				`xw_vw_lab_stock_rec` `st`
				LEFT JOIN `xw_dept_department` `dp` ON `dp`.`dept_depid` = `st`.`depid`
				LEFT JOIN `xw_itli_itemslist` `it` ON `it`.`itli_itemlistid` = `st`.`itemid`
				$whr
				GROUP BY
				`itemid`,
				`depid`
				ORDER BY
				`itemid` DESC
				";
				$query = $this->db->query($sql);
				// echo $this->db->last_query();
				// die();
				return $query->result();
			}

		}