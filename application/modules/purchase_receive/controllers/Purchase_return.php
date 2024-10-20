<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_return extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('purchase_return_mdl');
		$this->load->Model('receive_against_order_mdl');
		$this->locationid=$this->session->userdata(LOCATION_ID);
		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
	}
	public function index()
	{   
		$this->data['purchase_type'] = '';
		$this->data['current_tab']='purchase_return';
		$this->data['store_type'] = $this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttype','ASC');
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','ASC');
		$this->data['default_storeid']=$this->session->userdata(STORE_ID);
		$this->data['return_no'] = $this->generate_returnno();
		$this->data['supplier_all'] = $this->general->get_tbl_data('dist_distributorid,dist_distributor','dist_distributors',false,'dist_distributor','ASC');
		// echo "<pre>";
		// print_r($this->data['supplier_all']);
		// die();
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
			->build('purchase_return/v_common_purchase_return_tab', $this->data);
	}

	public function direct()
	{   
		$this->data['purchase_type'] = 'direct';
		$this->data['current_tab']='direct_purchase_return';
		$this->data['direct_purchase'] = 'direct_purchase_return';
		$this->data['store_type'] = $this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttype','ASC');
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','ASC');
		$this->data['default_storeid']=$this->session->userdata(STORE_ID);
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributor','ASC');
		$this->data['return_no'] = $this->generate_returnno();
		// echo "<pre>";
		// echo $this->data['default_storeid'];
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
			->build('purchase/v_direct_purchase_common_tab', $this->data);
	}

	public function form_purchase_return($purchase_type = false)
	{   
		if($purchase_type == 'direct'){
			$this->data['purchase_type'] = 'direct';
			$this->data['current_tab']='direct_purchase_return';
		}else{
			$this->data['purchase_type'] = '';
			$this->data['current_tab']='purchase_return';
		}
		
		$this->data['store_type'] = $this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttype','ASC');
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','ASC');
		$this->data['default_storeid']=$this->session->userdata(STORE_ID);
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributor','ASC');
		$this->data['return_no'] = $this->generate_returnno();
		// echo "<pre>";
		// echo $this->data['default_storeid'];
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
		$this->load->view('purchase_return/v_purchase_return_form',$this->data);
	}

	public function orderlist($invoiceno = false)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			// if(MODULES_VIEW=='N')
			// {
 		// 		print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
			// 	exit;
			// }
			// $input_locationid = $this->input->post('locationid');

			$fiscalyrs=$this->input->post('fiscal_year');
			$storeid=$this->input->post('storeid');

				//  if($this->location_ismain=='Y')
	   //      	{
		  //           if($input_locationid)
		  //           {
		  //               $locationid = $input_locationid;
		  //           }
	   //      	}	
		  //       else
		  //       { 
		  //       	$locationid = $this->locationid;
		  //       }


			// $locationid=!empty($this->input->post('locationid'))?$this->input->post('locationid'):$this->locationid;

			if($invoiceno){
				$search_no = $this->input->post('invoiceno');
				$this->data['received_data']=$this->purchase_return_mdl->get_received_master_by_order_no(array('rm.recm_invoiceno'=>$search_no,'rm.recm_fyear'=>$fiscalyrs,'rm.recm_storeid'=>$storeid,'rm.recm_purchaseorderno'=>0));
				$error_field = 'Receipt No.';

			}else{
				$search_no=$this->input->post('orderno');
				$this->data['received_data']=$this->purchase_return_mdl->get_received_master_by_order_no(array('rm.recm_purchaseorderno'=>$search_no,'rm.recm_fyear'=>$fiscalyrs,'rm.recm_storeid'=>$storeid));
				$error_field = 'Order No.';
			}

			// 	echo "<pre>";
			// echo $this->db->last_query();
			// die();
			
			// echo "<pre>";
			// echo $this->db->last_query();
			// die();

			// echo "<pre>";
			// print_r($this->data['received_data']);
			// die();
			if(empty($search_no)){
				print_r(json_encode(array('status'=>'error','message'=>'Order no. can not be empty. Please enter valid order no.')));
				exit;
			}


			if(empty($this->data['received_data']))
			{
				print_r(json_encode(array('status'=>'error','message'=>$error_field.' '.$search_no .' can not be returned!!')));
				exit;	
			}


			
			$this->data['received_data_detail']=array();
			$tempform='';
			if($this->data['received_data'])
			{
				$received_masterid=$this->data['received_data'][0]->recm_receivedmasterid;
				$this->data['received_data_detail']=$this->receive_against_order_mdl->get_received_detail_by_order_no(array('rd.recd_receivedmasterid'=>$received_masterid));

				// echo "<pre>";
				// print_r($this->data['received_data_detail']);
				// die();
			$tempform=$this->load->view('purchase_return/v_received_item_detail_list',$this->data,true);
				
			

			}
			print_r(json_encode(array('status'=>'success','order_data'=>$this->data['received_data'],'tempform'=>$tempform,'message'=>'Selected Successfully')));
			exit;	

		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}
	
	public function save_purchase_return($purchase_type = false)
	{
		// echo MODULES_INSERT;die;
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
				if($this->input->post('id'))
				{
					if(MODULES_UPDATE=='N')
					{
					$this->general->permission_denial_message();
					exit;
					}
				}
				else
				{
					if(MODULES_INSERT=='N')
					{
					$this->general->permission_denial_message();
					exit;
					}
				}

				// print_r($purchase_type);die();
				$this->form_validation->set_rules($this->purchase_return_mdl->validate_purchase_return);
				if($this->form_validation->run()==TRUE)
				{
					if($purchase_type == 'direct'){
						$trans = $this->purchase_return_mdl->save_direct_purchase_return();	
					}else{
						$trans = $this->purchase_return_mdl->save_purchase_return();
					}
					
					if($trans)
					{
						print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
						exit;
					}
					else
					{
						print_r(json_encode(array('status'=>'error','message'=>'Operation Failed.')));
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

	public function generate_returnno()
	{
	  	$curmnth=CURMONTH;
	  	if($curmnth==1)
	  	{
	  		$prefix='A';
	  	}
	  	if($curmnth==2)
	  	{
	  		$prefix='B';
	  	}
	  	if($curmnth==3)
	  	{
	  		$prefix='C';
	  	}
	  	if($curmnth==4)
	  	{
	  		$prefix='D';
	  	}
	  	if($curmnth==5)
	  	{
	  		$prefix='E';
	  	}
	  	if($curmnth==6)
	  	{
	  		$prefix='F';
	  	}
	  	if($curmnth==7)
	  	{
	  		$prefix='G';
	  	}
	  	if($curmnth==8)
	  	{
	  		$prefix='H';
	  	}
	  	if($curmnth==9)
	  	{
	  		$prefix='I';
	  	}
	  	if($curmnth==10)
	  	{
	  		$prefix='J';
	  	}
	  	if($curmnth==11)
	  	{
	  		$prefix='K';
	  	}
	  	if($curmnth==12)
	  	{
	  		$prefix='L';
	  	}

	  	$this->db->select('purr_invoiceno');
	  	$this->db->from('purr_purchasereturn');
	  	$this->db->where('purr_invoiceno LIKE '.'"%'.RETURN_NO_PREFIX.$prefix.'%"');
	  	$this->db->limit(1);
	  	$this->db->order_by('purr_invoiceno','DESC');
	  	$query = $this->db->get();
	        // echo $this->db->last_query(); die();
	  	$invoiceno=1;
	  	$dbinvoiceno='';
	        if ($query->num_rows() > 0) 
	        {
	            $dbinvoiceno=$query->row()->purr_invoiceno;         
	        }
	        if(!empty($dbinvoiceno))
	        {
	        	  $invoiceno=$this->general->stringseperator($dbinvoiceno,'number');
	        }

	    

	      $nw_invoice = str_pad($invoiceno + 1, RETURN_NO_LENGTH, 0, STR_PAD_LEFT);
	      return RETURN_NO_PREFIX.$prefix.$nw_invoice;
    }

    public function purchase_return_item_list()
	{
		
		$this->data['store_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		// echo "<pre>"; print_r($this->data['store_type']); die;

		$this->data['tab_type']='list';
		$this->data['current_tab']='purchase_return_list';
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
			->build('purchase_return/v_common_purchase_return_tab', $this->data);
	}

	public function get_purchase_return_item_list(){
		if(MODULES_VIEW=='N')
		{
			$array=array();
		 	// $this->general->permission_denial_message();
		 	echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
		}
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
			
	  	$i = 0;
	  	$data = $this->purchase_return_mdl->get_purchase_return_item_list();
	  	// echo "<pre>";
	  	// print_r($data);
	  	// die();
	  	// echo "<pre>";
	  	// echo $this->db->last_query();
	  	// die();
	  	 //echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {	
		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]['purr_returndatebs'] = $row->purr_returndatebs;
		   		$array[$i]['purr_returndatead'] = $row->purr_returndatead;
		   		$array[$i]['purr_fyear'] = $row->purr_fyear;
		   		$array[$i]['purr_invoiceno'] = $row->purr_invoiceno;
		   		$array[$i]['purr_returnno'] = $row->purr_returnno;
		   		$array[$i]['purr_receiptno'] = $row->purr_receiptno;
		   		$array[$i]['dist_distributor'] = $row->dist_distributor;
		   		$array[$i]['purr_discount'] = $row->purr_discount;
		   		$array[$i]['purr_vatamount'] = $row->purr_vatamount;
		   		$array[$i]['purr_returnamount'] = $row->purr_returnamount;
		   		$array[$i]['purr_returnby'] = $row->purr_returnby;
		   		$disp_var=$this->lang->line('receive_ordered_items_detail');
		   		$array[$i]['action'] = "";
		   		// $array[$i]['action'] = '<a href="javascript:void(0)" data-id='.$row->recm_receivedmasterid.' data-displaydiv="" data-viewurl='.base_url('purchase_receive/receive_against_order/direct_purchase_details').' class="view" data-heading="'.$disp_var.'"><i class="fa fa-eye" title="Return" aria-hidden="true" ></i></a>';
		   		//$array[$i]['cancel_all'] = ''; purchase_receive/direct_purchase/direct_purchase_details
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function purchase_return_item_detail_list()
	{
		
		$this->data['store_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		// echo "<pre>"; print_r($this->data['store_type']); die;

		$this->data['tab_type']='list';
		$this->data['current_tab']='purchase_return_detail_list';
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
			->build('purchase_return/v_common_purchase_return_tab', $this->data);
	}

	public function get_purchase_return_item_detail_list(){
		if(MODULES_VIEW=='N')
		{
			$array=array();
		 	// $this->general->permission_denial_message();
		 	echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
		}
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
			
	  	$i = 0;
	  	$data = $this->purchase_return_mdl->get_purchase_return_item_detail_list();
	  	// echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {	
		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]['purr_returndatebs'] = $row->purr_returndatebs;
		   		$array[$i]['purr_returndatead'] = $row->purr_returndatead;
		   		$array[$i]['purr_fyear'] = $row->purr_fyear;
		   		$array[$i]['dist_distributor'] = $row->dist_distributor;
		   		$array[$i]['purr_invoiceno'] = $row->purr_invoiceno;
		   		$array[$i]['purr_returnno'] = $row->purr_returnno;
		   		$array[$i]['purr_receiptno'] = $row->purr_receiptno;
		   		$array[$i]['itli_itemname'] = $row->itli_itemname;
		   		$array[$i]['recd_discountpc'] = $row->recd_discountpc;
		   		$array[$i]['recd_vatpc'] = $row->recd_vatpc;
		   		$array[$i]['prde_cc'] = $row->prde_cc;
		   		$array[$i]['prde_amount'] = $row->prde_amount;
		   		$disp_var=$this->lang->line('receive_ordered_items_detail');
		   		$array[$i]['action'] = "";
		   		// $array[$i]['action'] = '<a href="javascript:void(0)" data-id='.$row->recm_receivedmasterid.' data-displaydiv="" data-viewurl='.base_url('purchase_receive/receive_against_order/direct_purchase_details').' class="view" data-heading="'.$disp_var.'"><i class="fa fa-eye" title="Return" aria-hidden="true" ></i></a>';
		   		//$array[$i]['cancel_all'] = ''; purchase_receive/direct_purchase/direct_purchase_details
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

		public function generate_pdfDetails()
    {
    	 $page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}
        $this->data['searchResult'] = $this->purchase_return_mdl->get_purchase_return_item_list();
        // echo "<pre>";
        // print_r( $this->data['searchResult']);
        // die();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $html = $this->load->view('purchase_return/v_purchase_return_detail_download', $this->data, true);
      	$filename = 'direct_purchase_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false, $pdfsize, $page_size);
        exit();
    }

    public function exportToExcelDetails(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=all_purchase_item_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        $data = $this->purchase_return_mdl->get_purchase_return_item_list();
        $this->data['searchResult'] = $this->purchase_return_mdl->get_purchase_return_item_list();
        //print_r($this->data['searchResult']);die;
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $response = $this->load->view('purchase_return/v_purchase_return_detail_download', $this->data, true);


        echo $response;
    }

    public function generate_pdfsDetails()
    {
    	$page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}
    	
        $this->data['searchResult'] = $this->purchase_return_mdl->get_purchase_return_item_detail_list();
        // echo "<pre>";
        // print_r( $this->data['searchResult']);
        // die();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $html = $this->load->view('purchase_return/v_purchase_return_details_download', $this->data, true);
      	$filename = 'direct_purchase_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize, $page_size);
        exit();
    }

    public function exportToExcelsDetails(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=all_purchase_item_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        $data = $this->purchase_return_mdl->get_purchase_return_item_detail_list();
        $this->data['searchResult'] = $this->purchase_return_mdl->get_purchase_return_item_detail_list();
        //print_r($this->data['searchResult']);die;
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $response = $this->load->view('purchase_return/v_purchase_return_details_download', $this->data, true);


        echo $response;
    }



    
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */