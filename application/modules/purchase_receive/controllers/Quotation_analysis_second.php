<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Quotation_analysis_second extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('analysis_mdl');
		
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
		$this->data['current_stock']="Quotation_analysis_second";
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			//->build('analysis/v_analysis', $this->data);
			->build('quotation/v_common_quotation_tab', $this->data);

	}

	public function analysis_ii_list()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(MODULES_VIEW=='N')
			{
			$array["dist_distributorid"]='';
			$array["distributor"]='';
			$array["countryname"]='';
			$array["city"]='';
			$array["address1"]='';
			$array["action"]='';
			 // $this->general->permission_denial_message();
			 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
			}
		}
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
			
	  	$i = 0;
	  	$data = $this->analysis_mdl->get_analysis_list();
	  	//echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		$approvedList = $this->analysis_mdl->get_tender_approved();

        if(!empty($approvedList)){
            foreach($approvedList as $list){
                $approvedlistArray[] = $list->teap_qdetailid;
            }
        }
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {	
		    	if(in_array($row->qude_quotationdetailid, $approvedlistArray)){
                	$array[$i]['DT_RowClass'] = 'approved';
            	}
		   		$array[$i]["qdetailid"] = $row->qude_quotationdetailid;
		   		$array[$i]["itemsid"] = $row->itli_itemlistid;
		   		$array[$i]["code"] = $row->itli_itemcode;
		   		$array[$i]["itemsname"] = $row->itli_itemname;
		   		$array[$i]["supplier"] = $row->supp_suppliername;
		   		if(DEFAULT_DATEPICKER == 'NP'){
		   			$array[$i]["quot_date"] = $row->quma_quotationdatebs;	
		   		}else{
		   			$array[$i]["quot_date"] = $row->quma_quotationdatead;
		   		}
			    $array[$i]["quot_no"] = $row->quma_quotationnumber;
			    $array[$i]["rate"] = $row->qude_rate;
			    $array[$i]["dis"] = $row->qude_discountpc;
			    $array[$i]["vat"] = $row->qude_vatpc;
			    $array[$i]["netrate"] = $row->qude_netrate;
			    $array[$i]["remarks"] = $row->qude_remarks;
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
					// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
					// if(MODULES_VIEW=='N')
					// 	{
					// 	$array["dist_distributorid"]='';
					// 	$array["distributor"]='';
					// 	$array["countryname"]='';
					// 	$array["city"]='';
					// 	$array["address1"]='';
					// 	$array["action"]='';
					// 	 // $this->general->permission_denial_message();
					// 	 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
					// 	exit;
					// 	}
					// }
					
					// $useraccess= $this->session->userdata(USER_ACCESS_TYPE);
					// 	// if($orgid){
					// 	// 	$org_id=$orgid;
					// 	// }
					// 	// else
					// 	// {
					// 	// 	$org_id = $this->session->userdata(ORG_ID); 
					// 	// }
						
					// 	// if($useraccess == 'B')
					// 	// {
					// 	// 	if($orgid)
					// 	// 	{
					// 	// 		$srchcol=array('dist_orgid'=>$org_id);
					// 	// 	}
					// 	// 	else
					// 	// 	{
					// 	// 		$srchcol='';
					// 	// 	}

					// 	// 	$data = $this->analysis_mdl->get_deletedistributors_list($srchcol);
					// 	// }else{
					// 	// 	$data = $this->analysis_mdl->get_deletedistributors_list(array('dist_orgid'=> $org_id));
					// 	// }	
			        
				 //        // echo $this->db->last_query();
				 //        // die();
				
					// 	// if($result == 'bmin_equipid') {

					// 	// 	$cond = array('dist_postdatead'=>date("Y/m/d"),'dist_orgid'=>$org_id);
					// 	// 	$data = $this->analysis_mdl->get_deletedistributors_list($cond);
					// 	// }
					//     // echo "<pre>"; print_r($data); die();
				 //  	$i = 0;
				 //  	$data = $this->analysis_mdl->get_analysis_list();
				 //  	//$data = $this->analysis_mdl->get_analysis_ii_list();
				 //  	//echo"<pre>";print_r($data);die;
					// $array = array();
					// $filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
					// $totalrecs = $data["totalrecs"];


				 //    unset($data["totalfilteredrecs"]);
				 //  	unset($data["totalrecs"]);
					//   	foreach($data as $row)
					//     {
					   
					// 	    $array[$i]["quma_quotation_master_id"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->quma_quotation_master_id.'>'.$row->quma_quotation_master_id.'</a>';
					// 	    $array[$i]["distributor"] = $row->dist_distributor;
					// 	    $array[$i]["rate"] = $row->qude_rate;
					// 	    $array[$i]["discount_pc"] = $row->qude_discount_pc;
					// 	    $array[$i]["vat_pc"] = $row->qude_vat_pc;
					// 	    $array[$i]["arate"] = $row->qude_arate; 
					// 	    $array[$i]["totalamount"] = $row->quma_total_mount;
					// 	    $array[$i]["amount"] = $row->amount;
					// 	    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->quma_quotation_master_id.' data-displaydiv="Distributer" data-viewurl='.base_url('biomedical/distributors/6view_distributor/').' class="view" data-heading="View Distributor"  ><i class="fa fa-eye" aria-hidden="true" ></i></a>
					// 	        <a href="javascript:void(0)" data-id='.$row->quma_quotation_master_id.' data-tableid='.($i+1).' data-deleteurl='. base_url('biomedical/distributors/#') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>
					// 	    ';
					// 	    $i++;
					//     }
			  //       echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function order_lists()
	{	$this->data['depatrment']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$order_muner = $this->input->post('order_no');
			$this->data['orderno'] =  $this->input->post('order_no');
			if($order_muner)
			{
				$this->data['order_item_details'] = $this->receive_order_model->get_selected_order();
				
				$template=$this->load->view('receive_order_item/v_receive_order_form',$this->data,true);
			// echo $template; die();
			if($this->data['order_item_details']>0)
			{
					print_r(json_encode(array('status'=>'success','message'=>'','template'=>$template)));
	            	exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'')));
	            	exit;
			}
				print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
			}
		}
	 	else
	    {
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	            exit;
	    }
	}
	public function save_receive_order_item()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$this->form_validation->set_rules($this->receive_order_model->validate_settings_receive_order_item);
			if($this->form_validation->run()==TRUE)
			{
				$trans = $this->receive_order_model->order_item_receive_save();
				if($trans)
				{
					print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
					exit;
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>'Record Save Successfully')));
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
	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */