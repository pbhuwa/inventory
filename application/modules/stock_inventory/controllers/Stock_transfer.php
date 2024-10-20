<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stock_transfer extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('stock_transfer_mdl');
		$this->load->Model('stock_requisition_mdl');
		$this->storeid = $this->session->userdata(STORE_ID);
		$this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
	}
	public function index()
	{
		$this->data['reqno']= $this->input->post('id');
		$this->data['pending_list']='';

		$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','ASC');
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
		$this->data['tab_type']="entry";
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('stock_transfer/v_stock_transfer_main', $this->data);
	}
	public function list_stocktransfer()
	{
		
		$this->data['tab_type']='list';
		$this->data['apptype'] = '';
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','ASC');
		$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
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
		$this->data['tab_type']="list";
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('stock_transfer/v_stock_transfer_main', $this->data);
	}


	public function list_stock_transfer_details()
	{
		$this->data['tab_type']='detailslist';
		$this->data['apptype'] = '';
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','ASC');
		$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
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
		$this->data['tab_type']="detailslist";
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('stock_transfer/v_stock_transfer_main', $this->data);
	}
	public function save_stocktransfer()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
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
		try 
			{
			
				$from_store=$this->input->post('from_store');
				$to_store=$this->input->post('to_store');
				
					$this->form_validation->set_rules($this->stock_transfer_mdl->validate_settings_stock_transfer);
				if($from_store==$to_store)
				{

					// echo 'test';
					print_r(json_encode(array('status'=>'error','message'=>'Stock Transfer canot be done to same Department.')));
						exit;

					// $this->form_validation->set_message('from_store','');
					// return FALSE;
				}

				// die();
				if($this->form_validation->run()==TRUE)
				{
				//echo"<pre>";print_r($this->input->post());die;
				//echo 'aa'; die();

					//$trans = $this->stock_transfer_mdl->save_stocktransfer();
					$trans = $this->stock_transfer_mdl->save_store_transfer();
					//print_r($trans);die;
						//echo 'aa';die;
					if($trans)
					{
						if($print = "print")
						{ 
							//print_r($this->input->post());die;
							$report_data = $this->data['report_data'] = $this->input->post();
							$itemid = !empty($report_data['itemid'])?$report_data['itemid']:'';
							$from_store = !empty($report_data['from_store'])?$report_data['from_store']:'';
							$to_store = !empty($report_data['to_store'])?$report_data['to_store']:'';
							if(!empty($itemid)):
								foreach($itemid as $key=>$it):
									$itemid = !empty($report_data['itemid'][$key])?$report_data['itemid'][$key]:'';
									$unitid = !empty($report_data['rede_unit'][$key])?$report_data['rede_unit'][$key]:'';
									$this->data['item_name']=$this->general->get_tbl_data('*','itli_itemslist',array('itli_itemlistid'=>$itemid),'itli_itemlistid','DESC');
									$this->data['items']=$this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$itemid),'eqty_equipmenttypeid','DESC');
									$this->data['fromdep']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$from_store),'eqty_equipmenttypeid','ASC');
									$this->data['tostore']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$to_store),'eqty_equipmenttypeid','ASC');
								endforeach;
							endif;
							$print_report = $this->load->view('stock/v_stock_print', $this->data, true);
							//print_r($print_report);die;
						}
						print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully', 'print_report'=>$print_report)));
					exit;
					}
					else
					{
						print_r(json_encode(array('status'=>'error','message'=>'Record cannot be  Saved')));
						exit;
					}
					}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
						exit;
				}
		
			} 
			catch (Exception $e) 
			{
					print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
			}
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}
	public function form_stocktransfer()
	{
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','ASC');
		$this->load('stock_transfer/v_stock_transfer_form', $this->data);
	}
	public function requisitionNumber()
	{ 
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$req_no=$this->input->post('reqno');
			$fyear=$this->input->post('fyear');
			$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
			//echo"<pre>";print_r($this->data['req_data']);die;
			//echo $this->db->last_query();die;
			$srchcol=array('rema_reqno'=>$req_no,'rema_fyear'=>$fyear,'rema_isdep'=>'N');
		    $this->data['req_data']=$this->stock_transfer_mdl->get_req_no_list($srchcol, 'rema_reqno','desc');
			$masterid = !empty($this->data['req_data'][0]->rema_reqmasterid)?$this->data['req_data'][0]->rema_reqmasterid:'';
			$this->data['pending_list'] = $this->stock_transfer_mdl->get_req_details(array('rede_reqmasterid'=>$masterid));
			if($this->data['pending_list'])
			{   
				
				$template=$this->load->view('stock_transfer/v_stock_transfer_appendform',$this->data,true);
				print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        	exit;
			}
		    else
		    {
		        print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        	exit;
		    }
		}
	 	else
	    {
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	            exit;
	    }
	}

	public function stock_transfer_list_original()
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

	 
	  		$data = $this->stock_transfer_mdl->get_stock_transfer_list();
	  
	  	// echo "<pre>";
	  	// print_r($data);
	  	// die();
	  
	  	$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		foreach($data as $row)
		 {
 		    $array[$i]["transactiondatebs"]=$row->trma_transactiondatebs;
			$array[$i]["transactiondatead"]=$row->trma_transactiondatead;
			$array[$i]["transactiontype"]=$row->trma_transactiontype;
			$array[$i]["equipmenttype"]=$row->toStore;
			$array[$i]["fromby"]=$row->trma_fromby;
			$array[$i]["toby"]=$row->trma_toby;
			$array[$i]["issueno"]=$row->trma_issueno;
			$array[$i]["reqno"]=$row->trma_reqno;
			//$array[$i]["action"]='';				   
			$i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function stock_transfer_list()
	{

		
		if(MODULES_VIEW=='N')
			{
			$array=array();
			 // $this->general->permission_denial_message();
			 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
			}
		
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	  	$i = 0;
$data = $this->stock_transfer_mdl->get_stock_transfer_list();
	  	// if($this->location_ismain=='Y'){
	  	// 	$data = $this->stock_transfer_mdl->get_stock_transfer_list();
	  	// }else{

	  	// 	$data = $this->stock_transfer_mdl->get_stock_transfer_list(array('trma_locationid'=>$this->locationid));
	  	// }
	  	
	  
	  	// echo "<pre>";print_r($data);die;

	  	$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  
		foreach($data as $row)
		 {
			$array[$i]["req_id"]=$row->trma_trmaid;
			$array[$i]["req_no"]=$row->trma_reqno;
			$array[$i]["from_store"]=$row->fromStore;
			$array[$i]["to_store"]=$row->toStore;
			$array[$i]["dispatch_by"]=$row->trma_fromby;
 			$array[$i]["dispatch_date"]=$row->trma_transactiondatebs;
			$array[$i]["dispatch_to"]=$row->trma_toby;
			$array[$i]["transfer_number"]=$row->trma_issueno;
			$array[$i]["fiscal_year"]=$row->trma_fyear;				   
			$i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function generate_pdfTransferList()
    {
    	if($this->location_ismain=='Y'){
    		$this->data['searchResult'] = $this->stock_transfer_mdl->get_stock_transfer_list();
    	}else{
    		$this->data['searchResult'] = $this->stock_transfer_mdl->get_stock_transfer_list(array('trma_locationid'=>$this->locationid));
    	}
        
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        //echo"<pre>";print_r($this->data['searchResult']);die;
        ini_set('memory_limit', '256M');
        $html = $this->load->view('stock_transfer/v_stock_transfer_list_download', $this->data, true);
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
        $output = 'stock_transfer'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }
    public function exportToExcelTransferList(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_transfer".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->stock_transfer_mdl->get_stock_transfer_list();

        $this->data['searchResult'] = $this->stock_transfer_mdl->get_stock_transfer_list();
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('stock_transfer/v_stock_transfer_list_download', $this->data, true);


        echo $response;
    }

	public function exportToExcel(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_transfer_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        if($this->location_ismain=='Y'){
        	$data = $this->stock_transfer_mdl->get_stock_transfer_list();
        }else{
        	$data = $this->stock_transfer_mdl->get_stock_transfer_list(array('trma_locationid'=>$this->locationid));
        }
        
       	
        
        $array = array();
        unset($data["totalfilteredrecs"]);
        unset($data["totalrecs"]);
        $response = '<table border="1">';
        $response .= '<tr><th colspan="9"><center>Stock Transfer</center></th></tr>';
        $response .= '<tr><th>S.n.</th>
                    <th>Disp.Date(BS)</th>
                    <th>Disp.Date(AD)</th>
                    <th>Type</th>
                    <th>Issue To Store</th>
                    <th>Issue By</th>
                    <th>Received By</th>
                    <th> Issue No. </th>
                    <th> Requisition No. </th></tr>';

        $i=1;
        $iDisplayStart = !empty($_GET['iDisplayStart'])?$_GET['iDisplayStart']:0;
        foreach($data as $row){
            $sno = $iDisplayStart + $i; 
          	$transactiondatebs=$row->trma_transactiondatebs;
			$transactiondatead=$row->trma_transactiondatead;
			$transactiontype=$row->trma_transactiontype;
			$equipmenttype=$row->eqty_equipmenttype;
			$fromby=$row->trma_fromby;
			$toby=$row->trma_toby;
			$issueno=$row->trma_issueno;
			$reqno=$row->trma_reqno;

            $response .= '<tr><td>'.$sno.'</td><td>'.$transactiondatebs.'</td><td>'.$transactiondatead.'</td><td>'.$transactiontype.'</td><td>'.$equipmenttype.'</td><td>'.$fromby.'</td><td>'.$toby.'</td><td>'.$issueno.'</td><td>'.$reqno.'</td></tr>';
            $i++;
        }
        
        $response .= '</table>';

        echo $response;
    }


    public function get_max_issue_no()
	{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$storeid=$this->input->post('storeid');
			$issueno=$this->stock_transfer_mdl->get_max_issue_no($storeid);
			if($issueno==0)
			{
				$isuno=1;
			}
			else
			{
			$isuno=$issueno;	
			}
			echo json_encode($isuno);
		 }
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
}

	public function form_stock_transfer()
	{
		$this->data['reqno']='';
		$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
			$this->load->view('stock_transfer/v_stock_transfer_form',$this->data);
	}

	public function transferlist_by_req_no()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$req_no=$this->input->post('req_no');
			$fyear=$this->input->post('fyear');
			// $storeid=!empty($this->session->userdata(STORE_ID))?$this->session->userdata(STORE_ID):1;
			$storeid = $this->input->post('to_storeid');
			$srchcol=array('rema_reqno'=>$req_no,'rema_fyear'=>$fyear,'rema_reqtodepid'=>$storeid);
			
			$this->data['req_data']=$this->stock_requisition_mdl->get_req_no_list($srchcol, 'rema_reqno','desc');
			// echo $this->db->last_query();
			// die();
			// echo "<pre>";print_r($this->data['req_data']);die();
			$req_data=array();
			if(!empty($this->data['req_data']))
			{
				$masterid=$this->data['req_data'][0]->rema_reqmasterid;
				$isapproved=!empty($this->data['req_data'][0]->rema_approved)?$this->data['req_data'][0]->rema_approved:'0';
				// echo $isapproved;
				// die();
				if(DEFAULT_DATEPICKER=='NP')
				{
					$req_data['req_date']=$this->data['req_data'][0]->rema_reqdatebs;
				}
				else
				{
					$req_data['req_date']=$this->data['req_data'][0]->rema_reqdatead;
				}
				$req_data['fromdepid']=$this->data['req_data'][0]->rema_reqfromdepid;
				$req_data['reqby']=$this->data['req_data'][0]->rema_reqby;
				if($isapproved=='0' && empty($isapproved) )
				{
					print_r(json_encode(array('status'=>'error','message'=>'Requested requisition number is not approved !!')));
					exit;
				}
				else
				{
					print_r(json_encode(array('status'=>'success','message'=>'Data Selected  Successfully!!','masterid'=>$masterid,'req_data'=>$req_data)));
				exit;
				}
				
				
				
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Invalid Requisition Number!!!')));
							exit;
			}
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}
	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */