<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Items_ledger extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('items_ledger_mdl');
		$this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
	}
	public function index()
	{
		$this->data['materialstypecategory']=$this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','DESC');
		$this->data['items']=$this->general->get_tbl_data('itli_itemlistid, itli_itemname, itli_itemcode','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','DESC');

		// echo "<pre>";
		// print_r($this->data['store']);
		// die();

		$this->data['equipment']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
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
		$this->data['current_tab']='item_ledger';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('items_ledger/v_ledger_common_tab', $this->data);
	}

	public function report()
	{
		$this->data['materialstypecategory']=$this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','DESC');
		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','DESC');
		$this->data['equipment']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
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
		$this->data['current_tab']='items_ledger_report';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('items_ledger/v_ledger_common_tab', $this->data);
	}

	public function type_i()
	{
		$this->data['month']=$this->general->get_tbl_data('*','mona_monthname');
      $this->data['fiscalyrs']=$this->general->getFiscalYear(false,'fiye_fiscalyear_id','DESC');
		$this->data['materialstypecategory']=$this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','DESC');
		$this->data['items']=$this->general->get_tbl_data('itli_itemlistid, itli_itemname, itli_itemcode','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','DESC');
		$this->data['equipment']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
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
		$this->data['current_tab']='items_ledger_report_i';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('items_ledger/v_ledger_common_tab', $this->data);
	}

	public function bulk_item_ledger()
	{
		$this->data['materialstypecategory']=$this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','DESC');
		$this->data['items']=$this->general->get_tbl_data('itli_itemlistid, itli_itemname, itli_itemcode','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','DESC');
		$this->data['equipment']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
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
		$this->data['current_tab']='items_ledger_bulk_report';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('items_ledger/v_ledger_common_tab', $this->data);
	}

	public function expendable_issue_report(){
		$this->data['materialstypecategory']=$this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','ASC');

		// echo "<pre>";
		// print_r($this->data);
		// die();
		
		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','DESC');
		$this->data['items']=$this->general->get_tbl_data('itli_itemlistid, itli_itemname, itli_itemcode','itli_itemslist',array('itli_materialtypeid'=>1),'itli_itemname','ASC');
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
		$this->data['current_tab']='expendable_nonexp_items_ledger_report';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('items_ledger/v_ledger_common_tab', $this->data);
	}

	//get item ledger
	public function get_items_ledger(){
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		if(MODULES_VIEW=='N')
			{
				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}

    		$this->form_validation->set_rules($this->items_ledger_mdl->validate_items_ledger);
    		if($this->form_validation->run()==TRUE){
    			$template = $this->get_items_ledger_data();
		
				print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
		        exit;
    		}else{
    			print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
				exit;
    		}
	    	
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }

    public function get_bulk_items_ledger(){
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		if(MODULES_VIEW=='N')
			{
				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}

    		$this->form_validation->set_rules($this->items_ledger_mdl->validate_items_ledger);
    		if($this->form_validation->run()==TRUE){
    			$template = $this->get_items_ledger_data();
		
				print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
		        exit;
    		}else{
    			print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
				exit;
    		}
	    	
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }

    //get direct report
	public function get_expendable_items_ledger(){
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		if(MODULES_VIEW=='N')
			{
				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}

    		$this->form_validation->set_rules($this->items_ledger_mdl->validate_items_ledger);
    		if($this->form_validation->run()==TRUE){
    			$template = $this->get_expendable_items_ledger_data();
		
				print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
		        exit;
    		}else{
    			print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
				exit;
    		}
	    	
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }

    public function items_ledger_pdf()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			error_reporting(0);
			$html = $this->get_items_ledger_data();
			// echo $html;
			// die();
			$filename = 'items_ledger_'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4-L'; //A4-L for landscape

	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,false,$pdfsize);

	        exit();
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function items_ledger_excel()
	{
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			header("Content-Type: application/xls");    
	        header("Content-Disposition: attachment; filename=items_ledger_excel_".date('Y_m_d_H_i').".xls");  
	        header("Pragma: no-cache"); 
	        header("Expires: 0");

	         $response = $this->get_items_ledger_data();
	        if($response){
	        	echo $response;	
	        }
	        return false;

	        echo $response;
	    }
	}

    public function get_items_ledger_data()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			$this->data['excel_url'] = "stock_inventory/items_ledger/items_ledger_excel";
			$this->data['pdf_url'] = "stock_inventory/items_ledger/items_ledger_pdf";
			$this->data['report_title'] ="जिन्सी सामानको खाता";;
			
			$itemid=$this->input->post('itemid');
			$locationid=$this->input->post('locationid');
			if(empty($locationid)){
				print_r(json_encode(array('status'=>'error','message'=>'Location Field is required!!')));
        	exit;
			}
			$store_id = $this->input->post('store_id');

	    	$this->data['fromdate'] = $this->input->post('fromdate');
	    	$this->data['todate'] = $this->input->post('todate'); 	
		    
		    if(ORGANIZATION_NAME=='KUKL'){
		    	$this->data['ledger_report']=$this->items_ledger_mdl->get_ledger_report_kukl();
		    	}else{
		     $this->data['ledger_report']=$this->items_ledger_mdl->get_ledger_report_new();
		     // $this->data['ledger_report']=$this->items_ledger_mdl->get_ledger_report();
		    }
		    // echo $this->db->last_query();
		    // // echo "<pre>";
		    // // print_r($this->data['ledger_report']);
		    // die();

		    if($itemid):
	    		$item_name = $this->data['item_name']=$this->general->get_tbl_data('itli_itemname, itli_itemcode,itli_unitid,itli_catid','itli_itemslist',array('itli_itemlistid'=>$itemid));
	    		// print_r($item_name);
	    		// die();
	    		$unitid = !empty($item_name[0]->itli_unitid)?$item_name[0]->itli_unitid:'';
	    		$itemcatid = !empty($item_name[0]->itli_catid)?$item_name[0]->itli_catid:'';

	    		// echo $itemcatid;
	    		// die();

	    		if($unitid){
	    			$this->data['unit_name'] = $this->general->get_tbl_data('unit_unitname','unit_unit',array('unit_unitid'=>$unitid));
	    		}else{
	    			$this->data['unit_name'] = "";
	    		}
	    		if(!empty($itemcatid)){
	    			$this->data['itemcat_name'] = $this->general->get_tbl_data('eqca_code,eqca_category','eqca_equipmentcategory',array('eqca_equipmentcategoryid'=>$itemcatid));
	    		}else{
	    			$this->data['itemcat_name'] = "";
	    		}
	    	endif;

		    if($store_id):
	    		$this->data['store_type']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$store_id));
	    	else:
	    		$this->data['store_type'] = 'All';
	    	endif;
	      	
	    	if($locationid):
				$this->data['location']=$this->general->get_tbl_data('loca_locationid,loca_name','loca_location',array('loca_locationid'=>$locationid));
			else:
				$this->data['location'] = 'All';
			endif;
	      
	    	if($this->data['ledger_report']){
	    		// echo ITEM_LEDGER_REPORT_TYPE;
	    		// die();
    		 if(defined('ITEM_LEDGER_REPORT_TYPE')):
                    if(ITEM_LEDGER_REPORT_TYPE == 'DEFAULT'){
                       $html =  $this->load->view('items_ledger/v_ledger_report_new',$this->data, true);
                       // $html =  $this->load->view('items_ledger/v_ledger_report',$this->data, true);
                    }else{
                        
                          $html =  $this->load->view('items_ledger/'.REPORT_SUFFIX.'/v_ledger_report',$this->data, true); 
                        }
                        
                else:
                   $html =  $this->load->view('items_ledger/v_ledger_report',$this->data, true);
                endif;
	    	}
	    	else
		    {
		        $html='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
		    }
		    return $html;

	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	//search using datatable

	public function search_ledger_report()
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
		  
		$data = $this->items_ledger_mdl->get_items_ledger_data();
	  	//echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		$blcamt=0;
		$blcqty=0;	  
		$blnamt=0;	
	  
		foreach($data as $row)
	  	{ 
	  		$rec_purqty = $row->rec_purqty;
			
			$issueQty = $row->issueQty;

			$blcqty +=($rec_purqty-$issueQty);

			$rec_amt = round($row->rec_amt,2);
			
			$issuAmt = round($row->issuAmt,2);

			$blcamt =($rec_amt-$issuAmt);
			// if($blcamt<0)
			// {
			// 	$blcamt=-($blcamt);
			// }

			$blnamt +=$blcamt;
		    
		    if($row->description=='Closing')
		    {
		    	$date_np='-';
		    }
		    else
		    {
		    	$date_np=$row->dates;
		    }

		    $array[$i]["sno"] = $i+1;
			$array[$i]["datesad"] = $row->datesad;
			$array[$i]["dates"] = $date_np;
			$array[$i]["description"] = $row->description;
			$array[$i]["refno"] = $row->refno;
			$array[$i]["Depname"] = $row->Depname;
			$array[$i]["rec_purqty"] = $row->rec_purqty;
			$array[$i]["rec_rate"] = round($row->rec_rate,2);
			$array[$i]["rec_amt"] = round($row->rec_amt,2);
			$array[$i]["issueQty"] = $row->issueQty;
			$array[$i]["iss_rate"] = round($row->rec_rate,2);
			$array[$i]["issuAmt"] = round($row->issuAmt,2);
			$array[$i]["bqty"] = $blcqty;
			$array[$i]["rate"] = round($row->rec_rate,2);
			$array[$i]["bamt"] = round($blnamt,2);
			$i++;
	    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function generate_pdf_items_ledger()
    {
    	
        $this->data['searchResult'] = $this->items_ledger_mdl->get_items_ledger_data();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $html = $this->load->view('items_ledger/v_items_ledger_download', $this->data, true);
      	$filename = 'items_ledger_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
    }

    public function generate_excel_items_ledger(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=items_ledger_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->items_ledger_mdl->get_items_ledger_data();

        $this->data['searchResult'] = $this->items_ledger_mdl->get_items_ledger_data();
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('items_ledger/v_items_ledger_download', $this->data, true);

        echo $response;
    }

    public function get_expendable_items_ledger_data()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			$this->data['excel_url'] = "stock_inventory/items_ledger/expendable_items_ledger_excel";
			$this->data['pdf_url'] = "stock_inventory/items_ledger/expendable_items_ledger_pdf";
			$this->data['report_title'] = $this->lang->line('ledger_report');
			
			$itemid=$this->input->post('itemid');
			$locationid=$this->input->post('locationid');
			$store_id = $this->input->post('store_id');

	    	$this->data['fromdate'] = $this->input->post('fromdate');
	    	$this->data['todate'] = $this->input->post('todate'); 	
		    
		    $this->data['ledger_report']=$this->items_ledger_mdl->get_ledger_report();

		    if($itemid):
	    		$item_name = $this->data['item_name']=$this->general->get_tbl_data('itli_itemname, itli_itemcode','itli_itemslist',array('itli_itemlistid'=>$itemid));
	    		$unitid = !empty($item_name[0]->itli_unitid)?$item_name[0]->itli_unitid:'';

	    		if($unitid){
	    			$this->data['unit_name'] = $this->general->get_tbl_data('unit_unitname',array('unit_unitid'=>$unitid));
	    		}else{
	    			$this->data['unit_name'] = "";
	    		}
	    	endif;

		    if($store_id):
	    		$this->data['store_type']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$store_id));
	    	else:
	    		$this->data['store_type'] = 'All';
	    	endif;
	      	
	    	if($locationid):
				$this->data['location']=$this->general->get_tbl_data('loca_locationid,loca_name','loca_location',array('loca_locationid'=>$locationid));
			else:
				$this->data['location'] = 'All';
			endif;
	      
	    	if($this->data['ledger_report']){
	    		$html = $this->load->view('items_ledger/v_expendable_items_ledger_report', $this->data, true);
	    	}
	    	else
		    {
		        $html='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
		    }
		    return $html;

	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function expendable_items_ledger_pdf()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$html = $this->get_expendable_items_ledger_data();

			$filename = 'expendable_items_ledger_'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4-L'; //A4-L for landscape

	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,false,$pdfsize);

	        exit();
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function expendable_items_ledger_excel()
	{
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			header("Content-Type: application/xls");    
	        header("Content-Disposition: attachment; filename=expendable_items_ledger_excel_".date('Y_m_d_H_i').".xls");  
	        header("Pragma: no-cache"); 
	        header("Expires: 0");

	         $response = $this->get_expendable_items_ledger_data();
	        if($response){
	        	echo $response;	
	        }
	        return false;

	        echo $response;
	    }
	}

	public function generate_pdf_expendable_items_ledger()
    {
    	
        $this->data['searchResult'] = $this->items_ledger_mdl->get_items_ledger_data();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $html = $this->load->view('items_ledger/v_expendable_items_ledger_download', $this->data, true);
      	$filename = 'items_ledger_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
    }

    public function generate_excel_expendable_items_ledger(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=items_ledger_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->items_ledger_mdl->get_items_ledger_data();

        $this->data['searchResult'] = $this->items_ledger_mdl->get_items_ledger_data();
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('items_ledger/v_expendable_items_ledger_download', $this->data, true);

        echo $response;
    }

    public function get_items_ledger_typei(){
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		if(MODULES_VIEW=='N')
			{
				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}

    		$this->form_validation->set_rules($this->items_ledger_mdl->validate_items_ledger_typei);
    		if($this->form_validation->run()==TRUE){
    			$template = $this->get_items_ledger_typei_data();
		
				print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
		        exit;
    		}else{
    			print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
				exit;
    		}
	    	
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }

    public function get_items_ledger_typei_data()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			$this->data['excel_url'] = "stock_inventory/items_ledger/items_ledger_excel";
			$this->data['pdf_url'] = "stock_inventory/items_ledger/items_ledger_pdf";
			$this->data['report_title'] = $this->lang->line('ledger_report');
			
			$itemid=$this->input->post('itemid');
			$locationid=$this->input->post('locationid');
			$store_id = $this->input->post('store_id');

	    	$this->data['fromdate'] = $this->input->post('fromdate');
	    	$this->data['todate'] = $this->input->post('todate'); 	
		    
		    $this->data['ledger_report']=$this->items_ledger_mdl->get_ledger_report();

		    if($itemid):
	    		$item_name = $this->data['item_name']=$this->general->get_tbl_data('itli_itemname, itli_itemcode','itli_itemslist',array('itli_itemlistid'=>$itemid));
	    		$unitid = !empty($item_name[0]->itli_unitid)?$item_name[0]->itli_unitid:'';

	    		if($unitid){
	    			$this->data['unit_name'] = $this->general->get_tbl_data('unit_unitname',array('unit_unitid'=>$unitid));
	    		}else{
	    			$this->data['unit_name'] = "";
	    		}
	    	endif;

		    if($store_id):
	    		$this->data['store_type']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$store_id));
	    	else:
	    		$this->data['store_type'] = 'All';
	    	endif;
	      	
	    	if($locationid):
				$this->data['location']=$this->general->get_tbl_data('loca_locationid,loca_name','loca_location',array('loca_locationid'=>$locationid));
			else:
				$this->data['location'] = 'All';
			endif;

			$this->data['ledger_report'] = "test";
	      
	    	if($this->data['ledger_report']){
    		 if(defined('ITEM_LEDGER_REPORT_TYPE1')):
                    if(ITEM_LEDGER_REPORT_TYPE1 == 'DEFAULT'){
                       $html =  $this->load->view('items_ledger/v_ledger_report',$this->data, true);
                    }else{
                        
                          $html =  $this->load->view('items_ledger/'.REPORT_SUFFIX.'/v_ledger_report',$this->data, true); 
                        }
                        
                else:
                   $html =  $this->load->view('items_ledger/v_ledger_report_typei',$this->data, true);
                endif;
	    	}
	    	else
		    {
		        $html='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
		    }
		    return $html;

	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}
}