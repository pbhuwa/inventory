<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Received_items extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		 $this->load->Model('received_items_mdl');
			$this->load->Model('new_issue_mdl');
		$this->username = $this->session->userdata(USER_NAME);
		$this->storeid = $this->session->userdata(STORE_ID);
		$this->locationid=$this->session->userdata(LOCATION_ID);
		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		
	}

	public function index()
	{   
		
	    $frmDate = CURMONTH_DAY1;
    	$toDate = CURDATE_NP;
    	$cur_fiscalyear = CUR_FISCALYEAR;
    	$this->data['fiscalyear'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
    	$this->data['department']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		 // $this->data['status_count'] = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >='=>$frmDate, 'rema_reqdatebs <='=>$toDate));
   if(ORGANIZATION_NAME == 'KUKL'){
		$cond='';

		if($frmDate){
			    $cond .=" WHERE rema_returndatebs >='".$frmDate."'";
		}
		if($toDate){
				$cond .=" AND rema_returndatebs <='".$toDate."'";
		}else{
			$cond .=" AND rema_returndatebs <='".$frmDate."'";
		}
		
		$cond2='';

		if($frmDate){
			    $cond2 .=" WHERE sama_billdatebs >='".$frmDate."'";
		}
		if($toDate){
				$cond2 .=" AND sama_billdatebs <='".$toDate."'";
		}else{
			$cond2 .=" AND sama_billdatebs <='".$frmDate."'";
		}


	$this->data['status_count'] = $this->received_items_mdl->getColorStatusCountreceived($cond2);
	
     }else{
     	$cond='';

		if($frmDate){
			    $cond .=" WHERE rema_returndatebs >='".$frmDate."'";
		}
		if($toDate){
				$cond .=" AND rema_returndatebs <='".$toDate."'";
		}else{
			$cond .=" AND rema_returndatebs <='".$frmDate."'";
		}
		
		$cond2='';

		if($frmDate){
			    $cond2 .=" WHERE sama_billdatebs >='".$frmDate."'";
		}
		if($toDate){
				$cond2 .=" AND sama_billdatebs <='".$toDate."'";
		}else{
			$cond2 .=" AND sama_billdatebs <='".$frmDate."'";
		}
		$this->data['status_count'] = $this->received_items_mdl->getColorStatusCountreceived($cond2);
	// 	echo "<pre>";
	// print_r($this->data['status_count']);
	// die();
		// echo $this->db->last_query();
		// die();
	}

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
			->build('received_items/v_received_list', $this->data);
	}


public function received_book_list()
	{	
		// echo "test";
		// die();

		// if(MODULES_VIEW=='N')
		// {
		// 	$array=array();
		//  	// $this->general->permission_denial_message();
		//  	echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
		// 	exit;
		// }

	
		$apptype = $this->input->get('apptype');
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	  	$i = 0;

	  	
		 if($apptype == 'received' || empty($apptype)){
	  		$data = $this->received_items_mdl->get_received_book_list(array('sama_st'=>'N'));
	  		// echo "<pre>";
	  		// print_r($data);
	  		// die();
	  	}
	  	 else if($apptype == 'receivedreturn' || empty($apptype)){
	  		$data = $this->received_items_mdl->get_received_book_list(array('sama_st'=>'C'));
	  		// echo "<pre>";
	  		// print_r($data);
	  		// die();
	  	}
	  	else{
	  		$data = $this->received_items_mdl->get_received_book_list(array('sama_st'=>'C'));
     //        echo "<pre>";
	  		// print_r($data);
	  		// die();
	  	}
	  	// echo $this->db->last_query();
	  	// die();
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  	$view_heading_var=$this->lang->line('issue_requisition_details');
	  	if($apptype == 'receivedreturn' || $apptype =='received' || empty($apptype) ){
	  		foreach($data as $row)
			{
				// echo "<pre>";
				// print_r($row);
				// die();
				$postdatead=$row->sama_postdatead;
				$posttime=$row->sama_posttime;
				$editstatus=$this->general->compute_data_for_edit($postdatead,$posttime);                         
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
			 	$array[$i]["totalamount"]=round($row->totalamt,2);
			 	$array[$i]['item_count']=' <a href="javascript:void(0)" data-id='.$row->sama_salemasterid.' data-invoiceno='.$row->sama_invoiceno.' data-fyear='.$row->sama_fyear.' data-displaydiv="IssueDetails" data-viewurl='.base_url('issue_consumption/new_issue/issue_details_views').' class="view btn-primary badge" data-heading='.$this->lang->line('issue_details').' title=View '.$this->lang->line('issue_details').'>'.$row->totcnt.'</a>';
			 	$array[$i]["receivedby"]=$row->sama_receivedby;
			 	$array[$i]["username"]=$row->sama_username;
			 	$array[$i]["requisitionno"]='<a href="javascript:void(0)" data-id='.$row->sama_requisitionno.' data-fyear='.$row->sama_fyear.' data-displaydiv="orderDetails" data-viewurl='.base_url('issue_consumption/new_issue/issue_requisition_views_details').' class="view  btn-xxs" data-heading="'.$view_heading_var.'">'.$row->sama_requisitionno.'</a>';
		 		$array[$i]["billtime"]=$row->sama_billtime;
		 		$array[$i]["billno"]=$row->sama_billno;
		 		$array[$i]["fyear"]=$row->sama_fyear;

		 		if($apptype == 'received' || empty($apptype)):
		 			if($row->sama_receivedstatus=='RC'):
		 				$array[$i]["action"]='<a href="javascript:void(0)" class="btn btn-sm btn-warning view" data-id='.$row->sama_salemasterid.' data-invoiceno='.$row->sama_invoiceno.' data-fyear='.$row->sama_fyear.'  data-displaydiv="orderDetails" data-viewurl='.base_url('issue_consumption/received_items/view_change_received_status').' data-heading="Conform Received Items " ><i class="fa fa-check-square-o" aria-hidden="true"></i> Check</a>';
		 			else:
		 				$array[$i]["action"]="";
		 			endif;
		 				
		 		else:
		 			$array[$i]["action"] = "";
		 		endif;

				$i++;
			}
	  	}
	  	else if($apptype == 'issuereturn' || $apptype == 'returncancel'){
	  		foreach($data as $row):
	  			$appclass='';
		    	$approved=$row->rema_st;
		    	if($approved=='C')
		    	{
		    		$appclass='returncancel';
		    	}else{
		    		$appclass='issuereturn';
		    	}

		    	$array[$i]["approvedclass"] = $appclass;
		  		$array[$i]['salemasterid']=$row->rema_returnmasterid;
			 	$array[$i]["invoiceno"]=$row->rema_receiveno;
			 	$array[$i]["billdatebs"]=$row->rema_returndatebs;
				$array[$i]["billdatead"]=$row->rema_returndatead;
			 	$array[$i]["depname"]=$row->dept_depname;
			 	$array[$i]["totalamount"]=$row->rema_amount;
			 	$array[$i]["username"]=$row->rema_username;
			 	$array[$i]["memno"]=$row->rema_returnby;
			 	$array[$i]["fyear"]=$row->rema_fyear;
			    $array[$i]["requisitionno"]=$row->rema_invoiceno;
		 		$array[$i]["billtime"]=$row->rema_returntime;
		 		$array[$i]["billno"]=$row->rema_receiveno;	
		 		if($apptype == 'issuereturn'):
		 			$array[$i]["action"]='<a href="javascript:void(0)" data-id='.$row->rema_invoiceno.' data-date='.$row->rema_returndatebs.' data-viewurl='.base_url('issue_consumption/new_issue/issue_returncancel').' class="redirectedit btn-danger btn-xxs"><i class="fa fa-times" title="Return Cancel" aria-hidden="true" ></i></a>   <a href="javascript:void(0)" data-id='.$row->rema_returnmasterid.'  data-displaydiv="IssueDetails" data-viewurl='.base_url('issue_consumption/new_issue/issue_return_details_views').' class="view btn-primary btn-xxs" title="View" data-heading="Issue Return Details" ><i class="fa fa-eye" title="Return view" aria-hidden="true" ></i</a>
		 			';	
		 		elseif($apptype == 'returncancel'):
		 			$array[$i]["action"]="";
		 		else:
		 			$array[$i]["action"] = "";
		 		endif;

				$i++;
			endforeach;
	  	}
		echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function view_change_received_status()
	{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				$invoiceno = $this->input->post('invoiceno');
				$fyear = $this->input->post('fiscal_year');
				// echo "asd";
				// die();
				if($id)
				{ 
					$this->data['issue_master'] = $this->new_issue_mdl->get_salemaster_date_id(array('sm.sama_salemasterid'=>$id));
					// echo "<pre>";
					// print_r($this->data['issue_master']);
					// die();
					$this->data['sama_receivedstatus']='';
					if(!empty($this->data['issue_master'])){
						$this->data['sama_receivedstatus']=!empty($this->data['issue_master'][0]->sama_receivedstatus)?$this->data['issue_master'][0]->sama_receivedstatus:'';
					}

					$this->data['issue_details'] = $this->new_issue_mdl->get_issue_detail(array('sd.sade_salemasterid'=>$id));

					$this->data['all_issue_details'] = $this->new_issue_mdl->get_all_issue_details($id, $invoiceno, $fyear);
					//echo $this->db->last_query();die;
					// echo"<pre>";print_r($this->data['all_issue_details']);die();
					$template ='';
					$template .=$this->load->view('issue/v_issue_details_view',$this->data,true);
					$this->data['smid']=$id;
					$template .=$this->load->view('received_items/v_received_conform',$this->data,true);
					


				print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','tempform'=>$template)));
			   			exit;	
			   		}
			}else{
						print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
					exit;
					}
	}

	public function change_received_status(){
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$smid=$this->input->post('smid');
				$input_status=$this->input->post('inp_status');
				if($input_status=='received')
				{
					// 'RC','NR','RE','RT','CN'
					$st='AC';
				}
				else if($input_status=='not_received'){
					$st='NR';
				}
				else if($input_status=='return'){
					$st='RT';
				}
				else if($input_status=='reject'){
					$st='RE';
				}
				else
				{
					$st='RC';
				}

				if(!empty($smid)){
						$this->db->update('sama_salemaster',array('sama_receivedstatus'=>$st),array('sama_salemasterid'=>$smid));
						$rwaff=$this->db->affected_rows();
						if(!empty($rwaff)){

							if(ORGANIZATION_NAME=='KUKL'){
								$get_sama_data = $this->general->get_tbl_data('sama_postby, sama_receivedby, sama_requisitionno','sama_salemaster',array('sama_salemasterid'=>$smid));
								
								$issue_by = !empty($get_sama_data[0]->sama_postby)?$get_sama_data[0]->sama_postby:'';
								$received_by = !empty($get_sama_data[0]->sama_receivedby)?$get_sama_data[0]->sama_receivedby:'';
								$requisitionno = !empty($get_sama_data[0]->sama_requisitionno)?$get_sama_data[0]->sama_requisitionno:'';

								$mess_userid = $issue_by; // message to storekeeper who issued this demand

								// print_r($issue_by);print_r($rema_reqno);die;

								// SEND MESSAGE TO STORE
								$msg_params = array(
						            	'DEMAND_NO' => $requisitionno,
						            	'TO_USERID' => $issue_by,
						            	'RECEIVED_BY' => $received_by
						            );
						        $this->general->send_message_params('change_received_status', $msg_params);
							}

							print_r(json_encode(array('status'=>'success','message'=>'Operation Successfully !!')));
							exit;
						}
						else
						{
								print_r(json_encode(array('status'=>'error','message'=>'Operation Fail !!')));
							exit;
						}

				}
			}else{
						print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
					exit;
					}
	}

		public function issue_summary()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$frmdate=$this->input->post('frmdate');
			$todate=$this->input->post('todate');
			$cond2='';

		if($frmdate){
			    $cond2 .=" WHERE sama_billdatebs >='".$frmdate."'";
		}
		if($todate){
				$cond2 .=" AND sama_billdatebs <='".$todate."'";
		}else{
			$cond2 .=" AND sama_billdatebs <='".$frmdate."'";
		}
		$status_count = $this->received_items_mdl->getColorStatusCountreceived($cond2);
			// echo $this->db->last_query();

			// die();
			$count = array();
		foreach ($status_count as $key => $status) {
			if($status->coco_statusname == 'received'){
				$count['received'] = $status->issuestatuscount;
			}else if($status->coco_statusname == 'receivedreturn'){
				$count['received_return'] = $status->issuestatuscount;

			}
		}

			print_r(json_encode(array('status' => 'success', 'status_count' => $count)));
		}
	}


	public function generate_pdfList()

	{

		$page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}

		$apptype = $this->input->get('apptype');

		 if($apptype == 'received' || empty($apptype)){
	  		$this->data['searchResult'] = $this->received_items_mdl->get_received_book_list(array('sama_st'=>'N'));
	  	}
	  	 else if($apptype == 'receivedreturn' || empty($apptype)){
	  		$this->data['searchResult'] = $this->received_items_mdl->get_received_book_list(array('sama_st'=>'C'));
	  		
	  	}
	  	else{
	  		$this->data['searchResult'] = $this->received_items_mdl->get_received_book_list(array('sama_st'=>'C'));
   
	  	}

		unset($this->data['searchResult']['totalfilteredrecs']);

		unset($this->data['searchResult']['totalrecs']);

		 

		$html = $this->load->view('received_items/v_received_list_download', $this->data, true);
   //          echo "<pre>";
			// print_r($html);
			// die();
		

		$this->general->generate_pdf($html, '', $page_size);
		  exit;
	}


	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */