<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Department_issue extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('department_issue_mdl');
		$this->load->Model('settings/department_mdl');
		$this->load->Model('stock_inventory/item_mdl');
	}
	public function index()
	{
		
		$this->data['department_all']=$this->department_mdl->get_all_department();
		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype');
		
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
		
		$this->data['tab_type']='department_issue';
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('issue/v_new_issue', $this->data);
	}
	public function department_wise_stock_detail_list()
	{
		if(MODULES_VIEW=='N')
			{
				$array=array();

				// $this->general->permission_denial_message();
				 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
				exit;
			}

		
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
		}
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
	  	$i = 0;
	  	$frmdate=$this->input->get('frmDate')?$this->input->get('frmDate'):CURMONTH_DAY1;
	  	$todate=$this->input->get('toDate')?$this->input->get('toDate'):DISPLAY_DATE;
	  	$locationid=$this->input->get('locationid')?$this->input->get('locationid'):0;
	  	$storeid=$this->input->get('store_id')?$this->input->get('store_id'):0;
	  	//this is not working in where condition in details 
	  	$store_id=$this->input->get('store_id')?$this->input->get('store_id'):'';

	  	$deptquery='';
	  	//$this->data['location']=$this->general->get_tbl_data('*','loca_location',false,'loca_locationid','ASC');
	  	$this->data['department_all']=$this->department_mdl->get_all_department();

	  	// echo"<pre>";print_r($this->data['department_all']);die;
	  	$i=1;

	  	foreach ($this->data['department_all'] as $key => $dep) {
	  		$deptquery .='depwiseitem_issue(sade_itemsid,'.$dep->dept_depid.', '.$locationid.','.$storeid.',"'.$frmdate.'" ,"'.$todate.'") as dep'.$dep->dept_depid.',';
	  		
	  
	  	}
		$deptquery = rtrim($deptquery,','); 
		// echo $deptquery;
		// die();
	  	$data = $this->department_issue_mdl->get_department_wise_lists($deptquery);
	  	//echo"<pre>";print_r($data);die;
	  	// echo $this->db->last_query();die();
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0)?($data["totalfilteredrecs"]):$data["totalrecs"];
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  		// foreach ($this->data['location'] as $key => $locat) {
	  	$i=0;
			  	foreach($data as $row)
			    {	
			   		// $array[$i]["sn"] = $i+1;
			   		$array[$i]["code"] = $row->itli_itemcode;
			   		$array[$i]["name"] = $row->itli_itemname;
			   		// $array[$i]['sade_unitrate'] =$row->sade_unitrate;
			   		$sum =0;
			   		foreach ($this->data['department_all'] as $key => $dpt) {
			   			$rwdep=('dep'.$dpt->dept_depid);
			   			// $rwtotal=('issuetotal'.$dpt->dept_depid);
			   			$rwtotal='';
				   		//$array[$i]['dep'.$locat->dept_depid] = !empty(number_format($row->{$rwdep}))?number_format($row->{$rwdep}):'';
						$totaliss=  !empty(number_format($row->{$rwdep}))?number_format($row->{$rwdep}):'';

						// $totaliss=0;
				   		$array[$i]['dep'.$dpt->dept_depid]=$totaliss;
				   		// $stotal=$row->{$rwtotal};
				   		$sum+= $totaliss;
				   		// $sum=0;
				   	}
				   	// $array[$i]['total'] = '<a data-toggle="tooltip" style="color: green;">'.number_format($sum,2).'</a>' ;

				   	$array[$i]['total'] ='<a href="javascript:void(0)" data-fromdate='.$frmdate.' data-todate='.$todate.' data-locationid='.$row->sade_locationid.' data-store_id="'.$store_id.'" data-departmentid='.$row->sade_itemsid.' data-id='.$row->sade_itemsid.' data-displaydiv="IssueDetails" data-viewurl='.base_url('issue_consumption/department_issue/view_department_wise_issue').' class="view" data-heading="Total Department Issue" title="Total Department Issue">'.$sum.'</a>';
			   		$i++;
				   
			    }
			
			    // print_r(json_encode($array));
			    // die();

			   
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function view_department_wise_issue()
	{ 
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$itemsid = $this->input->post('id');
				if($itemsid)
				{   //echo"<pre>"; print_r($this->input->post());die;
					$this->data['department']=$this->department_issue_mdl->distinct_department();
					$this->data['details_requisition_department'] = $this->department_issue_mdl->get_department_wise_issue(array('sade_iscancel'=>'N'));
					//echo $this->db->last_query();
					//echo"<pre>";print_r($this->data['department']);die();
					$template=$this->load->view('department_issue/v_department_issue_popup',$this->data,true);
					
					//$template=$this->load->view('stock/v_stock_requistion_details',$this->data,true);
					if($this->data['details_requisition_department']>0)
					{
						print_r(json_encode(array('status'=>'success','message'=>'','tempform'=>$template)));
		            	exit;
					}
					else{
						print_r(json_encode(array('status'=>'error','message'=>'No Record Found')));
			            	exit;
					}
						print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','tempform'=>$template)));
			   			exit;	
				}
			}
		 	else
		    {
		    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		            exit;
		    }
	    }else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}
}