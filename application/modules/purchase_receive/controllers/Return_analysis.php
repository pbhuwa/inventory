<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Return_analysis extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('return_analysis_mdl');
		
	}
	public function index()
	{ 
		$this->data['mrn_type']='';
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
			->build('return_analysis/v_return_analysis_main', $this->data);
	}

	public function return_analysis_list()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(MODULES_VIEW=='N')
			{
			$array=array();
			 // $this->general->permission_denial_message();
			 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
			}
		}
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	  	$i = 0;
	  	$data = $this->return_analysis_mdl->get_return_analysis_list();
	  	// echo"<pre>";print_r($data);die;

		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];


	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {
		    	$array[$i]["viewurl"]=base_url().'purchase_receive/return_analysis/return_analysis_list_individual';
			    $array[$i]["purchaseordermasterid"] = $row->puor_purchaseordermasterid;
			    $array[$i]["orderno"] = $row->puor_orderno;
			    $array[$i]["orderdatebs"] = $row->puor_orderdatebs;
			    $array[$i]["orderdatead"] = $row->puor_orderdatead;
			    $array[$i]["supplier"] = $row->dist_distributor;
			    $array[$i]["deliverysite"] = $row->puor_deliverysite;
			    $array[$i]["requno"] = $row->puor_requno;
			    $array[$i]["deliverydatebs"] = $row->puor_deliverydatebs;
			    $array[$i]["deliverydatead"] = $row->puor_deliverydatead;
			    $array[$i]["status"] = $row->puor_status;
			   
			   
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	
	public function return_analysis_list_individual()
	{	
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
			$purchasemasterid =  $this->input->post('id');
			if($purchasemasterid)
			{
				$this->data['indi_order'] = $this->return_analysis_mdl->get_indivi_return_analysis_list($purchasemasterid);
				
				$template=$this->load->view('return_analysis/v_return_analysis_individual',$this->data,true);
			// echo $template; die();
			if($this->data['indi_order']>0)
			{
					print_r(json_encode(array('status'=>'success','message'=>'','tempform'=>$template)));
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
	public function purchased_summary()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$cond = $ret_cond = '';
			$frmDate=$this->input->post('frmdate');
        	$toDate=$this->input->post('todate');

        	$locationid = !empty($this->input->post('locationid'))?$this->input->post('locationid'):0;

        	if($locationid != 'false' || $locationid != 0){
        		$where_locationid = "AND recm_locationid = '$locationid'";
        		$where_retlocationid = "AND purr_locationid = '$locationid'";
        	}else{
        		$where_locationid = "";
        		$where_retlocationid = "";
        	}

			if($frmDate && $toDate)
			{
        	    if(DEFAULT_DATEPICKER == 'NP'){
        	     	$cond=("recm_receiveddatebs BETWEEN '$frmDate' AND'$toDate' $where_locationid");
        	     	$ret_cond = ("purr_returndatebs BETWEEN '$frmDate' AND'$toDate' $where_retlocationid");
        	    }
        	    else{
        	        $cond=("recm_receiveddatead BETWEEN '$frmDate' AND'$toDate' $where_locationid");
        	        $ret_cond = ("purr_returndatead BETWEEN '$frmDate' AND'$toDate' $where_retlocationid");
        	    }
			}
	    	$status_count = $this->return_analysis_mdl->getStatusCountDetail($cond);
	    	$return_count = $this->return_analysis_mdl->getStatusCountReturn($ret_cond);
	    	//echo"<pre>"; print_r($return_count);die;
		    // echo $this->db->last_query();
		    print_r(json_encode(array('status'=>'success','status_count'=>$status_count,'return_count'=>$return_count)));
		}

	}
	public function direct_purchase_details_return_list()
	{	 
		$apptype = $this->input->get('apptype');
		if(MODULES_VIEW=='N')
		{
			$array = array();
		 	// $this->general->permission_denial_message();
		 	echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
		}
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
	  	$i = 0;$srch='';
	  	$data = $this->return_analysis_mdl->get_direct_received_return_details_list($srch);
	  	if($apptype == 'directreceived')
	  	{
	  		$srch = array('recm_purchasestatus'=>'D');
	  		$data = $this->return_analysis_mdl->get_direct_received_return_details_list($srch);
	  	}
	  	if($apptype == 'cancel')
	  	{
	  		$srch = array('recm_purchasestatus'=>'C');
	  		$data = $this->return_analysis_mdl->get_direct_received_return_details_list($srch);
	  	}
	  	if($apptype == 'returno')
	  	{
	  		// $srch = array('recm_purchasestatus'=>'R');
	  		$data = $this->return_analysis_mdl->get_purchase_return_details_list();
	  	}
	  	
	  	//echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);

	  		if($apptype == 'returno'):
	  			foreach($data as $row){
	  				if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
                }else{ 
                    $req_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
                }

	  				$appclass='returno';

	  				$array[$i]["approvedclass"] = $appclass;
	  				$array[$i]["sno"] = $i+1;
	  				$array[$i]['recm_receiveddatebs'] = $row->purr_returndatebs;
			   		$array[$i]['recm_invoiceno'] = $row->purr_invoiceno;
			   		$array[$i]['orderno'] = $row->purr_returnno;
			   		$array[$i]['dist_distributor'] = $row->dist_distributor;
			   		$array[$i]['recm_discount'] = $row->purr_discount;
			   		$array[$i]['recm_taxamount'] = $row->purr_vatamount;
			   		$array[$i]['recm_clearanceamount'] = $row->purr_returnamount;
			   		$array[$i]['recm_posttime'] = $row->purr_posttime;
				   		// $array[$i]['order_date'] = $row->orderdate;
				   		// $array[$i]['rate'] = $row->rate;
				   		// $array[$i]['vat'] = $row->vat;
			   		$array[$i]['itli_itemcode'] = $row->itli_itemcode;
			   		$array[$i]['itli_itemname'] = $req_itemname;
			   		$array[$i]['itli_itemlistid'] = $row->itli_itemlistid;
			   		$array[$i]['recd_purchasedqty'] = $row->prde_returnqty;
			   		$array[$i]['recd_unitprice'] = $row->prde_purchaserate;
			   		$array[$i]['recd_description'] = $row->prde_remarks;

				   	$array[$i]['recm_status'] = '';
			   		$array[$i]['recm_amount'] = $row->purr_returnamount;
			   		$array[$i]['action'] = '';
				    $i++;
	  			}
	  		else:
			  	foreach($data as $row)
			    {	
			    	if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
                }else{ 
                    $req_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
                }
			    	$appclass='';
			    	$approved=$row->recm_purchasestatus;
			    	if($approved=='D')
			    	{
			    		$appclass='directreceived';
			    	}
			    	if($approved=='C')
			    	{
			    		$appclass='cancel';
			    	}
			    	if($approved=='R')
			    	{
						$appclass='returno';
			    	}
			    	$array[$i]["approvedclass"] = $appclass;
			   		$array[$i]["sno"] = $i+1;
			   		$array[$i]['recm_receiveddatebs'] = $row->recm_receiveddatebs;
			   		$array[$i]['recm_invoiceno'] = $row->recm_invoiceno;
			   		$array[$i]['orderno'] = $row->orderno;
			   		$array[$i]['dist_distributor'] = $row->dist_distributor;
			   		//$array[$i]['budg_budgetname'] = $row->budg_budgetname;
			   		$array[$i]['recm_discount'] = $row->recm_discount;
			   		$array[$i]['recm_taxamount'] = $row->recm_taxamount;
			   		$array[$i]['recm_clearanceamount'] = $row->recm_clearanceamount;
			   		$array[$i]['recm_posttime'] = $row->recm_posttime;
				   		// $array[$i]['order_date'] = $row->orderdate;
				   		// $array[$i]['rate'] = $row->rate;
				   		// $array[$i]['vat'] = $row->vat;
			   		$array[$i]['itli_itemcode'] = $row->itli_itemcode;
			   		$array[$i]['itli_itemname'] = $req_itemname;
			   		$array[$i]['itli_itemlistid'] = $row->itli_itemlistid;
			   		$array[$i]['recd_purchasedqty'] = sprintf('%g',$row->recd_purchasedqty);
			   		$array[$i]['recd_unitprice'] = $row->recd_unitprice;
			   		$array[$i]['recd_description'] = $row->recd_description;

				   	$array[$i]['recm_status'] = $row->recm_status;
			   		$array[$i]['recm_amount'] = $row->recm_amount;
			   		$array[$i]['action'] = '';
				    $i++;
			    }
			endif;
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */