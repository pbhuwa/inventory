<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stock_check extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('stock_check_mdl');
		    $this->locationid=$this->session->userdata(LOCATION_ID);
    $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		
	}

	public function index()
	{ 
		$this->data['store_type']=$this->general->get_tbl_data('eqty_equipmenttypeid,eqty_equipmenttype','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		$this->data['stock_check'] = 'check';
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
			->build('stock_check/v_stock_check', $this->data);
	}

	public function stock_check_list()
	{
		if(MODULES_VIEW=='N')
			{
			$array=array();
			 // $this->general->permission_denial_message();
			echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
			}
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		}
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
			
	  	$i = 0;
	  	if($this->location_ismain=='Y'){
	  		  	$data = $this->stock_check_mdl->get_stock_check_list();
	  	}
       else{  
	     $data = $this->stock_check_mdl->get_stock_check_list(array('itli_locationid',$this->locationid));
	 }
	  

		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {	
		    	if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($row->itemnamenp)?$row->itemnamenp:$row->itemname;
                }else{ 
                    $req_itemname = !empty($row->itemname)?$row->itemname:'';
                }
                
		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]['viewurl']=base_url().'/stock_inventory/stock_check/load_stock_check';
		   		$array[$i]["prime_id"] = $row->itemid;
		   		$array[$i]['itemcode'] = $row->itemcode;
		   		$array[$i]['itemname'] = $req_itemname;
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function exportToExcel(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_check_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        
        $data = $this->stock_check_mdl->get_stock_check_list();
        $this->data['searchResult'] = $this->stock_check_mdl->get_stock_check_list();

        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
        
        $array = array();

        $response = $this->load->view('stock_check/v_stock_check_download', $this->data, true);

        echo $response;
    }

    public function generate_pdf()
    {
        $this->data['searchResult'] = $this->stock_check_mdl->get_stock_check_list();
        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();

        ini_set('memory_limit', '256M');
        $html = $this->load->view('stock_check/v_stock_check_download', $this->data, true);
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
        $output = 'stock_check_'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }

    public function load_stock_check()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {	
				$id = $this->input->post('id');

				// echo $id;
				// die();
				$this->data['stock_check']= $this->stock_check_mdl->get_stock_check_by_id(array('mtd.trde_itemsid'=>$id));

				$tempform=$this->load->view('stock_check/v_stock_check_modal',$this->data,true);

				if(!empty($tempform))
				{
						print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$tempform)));
		            	exit;
				}
				else{
					print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));
		            	exit;
				}
			}
			catch (Exception $e) {
				print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
			}
		}else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}

	public function stock_till_date()
	{ 
		$this->data['store_type']=$this->general->get_tbl_data('eqty_equipmenttypeid,eqty_equipmenttype','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');

		$this->data['stock_check'] = 'till_date';
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
			->build('stock_check/v_stock_check', $this->data);
	}
	public function change_data()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{	
        	$id = $this->input->post('id');
	      	$this->data['purchase']=$this->stock_check_mdl->get_changedata(array('clsm_departmentid'=>$id));
	      	
	        $template='';
		   
		    $template=$this->load->view('till_date/v_till_date_range',$this->data,true);
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}
	public function change_data_summary()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{	
        	$id = $this->input->post('id');$order ="clsm_fromdatebs";
	      	$this->data['purchase']=$this->stock_check_mdl->get_changedata(array('clsm_departmentid'=>$id),$order);
	      	
	        $template='';
		   
		    $template=$this->load->view('till_date/v_till_date_range_summary',$this->data,true);
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}
	/* Stock Till Date Begins */
	public function stock_till_date_search()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{	
			if(MODULES_VIEW=='N')
			{
				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}
        	$html=$this->stock_till_date_common();
        	if($html){
        		$template=$html;
        	}
	        // echo $temp; die();
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}
	public function stock_till_date_common()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			$this->data['excel_url'] = "stock_inventory/stock_check/excel_tilldate";
			$this->data['pdf_url'] = "stock_inventory/stock_check/tilldate_pdf";

			$this->data['report_title'] = $this->lang->line('stock_till_date');

			$trma_todepartmentid = $this->input->post('eqty_equipmenttypeid')?$this->input->post('eqty_equipmenttypeid'):$this->input->post('store_id');
        	// $masterid = $this->input->post('clsm_csmasterid');

        	$date_range = $this->input->post('clsm_csmasterid');

			$split_date_range = explode(':', $date_range);

			$masterid = !empty($split_date_range[0])?$split_date_range[0]:'';
			$date_range = !empty($split_date_range[1])?$split_date_range[1]:'';

			if($date_range){
				$this->data['todate'] = !empty($date_range)?$date_range:'';
			}

        	$locationid = $this->input->post('locationid');
        	$srchcol=$srchcol1=$srchcol2=$srchcol3=array();
        	if($masterid)
        	{
        		$srchcol1 = array('cd.csde_csmamasterid'=>$masterid);
        	}
        	if($trma_todepartmentid)
        	{
        		$srchcol2 = array('et.eqty_equipmenttypeid'=>$trma_todepartmentid);
        		$this->data['store_type']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$trma_todepartmentid));
        	}
        	else{
        		$this->data['store_type'] = 'All';
        	}
        	if($locationid)
        	{
        		$srchcol3 = array('mt.maty_locationid'=>$locationid);
        		$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
        	}else{
        		$this->data['location'] = 'All';
        	}

        	$srchcol = array_merge($srchcol1,$srchcol2,$srchcol3);

	      	$this->data['purchase']=$this->stock_check_mdl->get_stock_till_date_search($srchcol);
	      	
	      	$this->data['equipmenttype']=$this->general->get_tbl_data('maty_material','maty_materialtype',array('maty_materialtypeid'=>$trma_todepartmentid),'maty_materialtypeid','DESC');

	      	//echo"<pre>";print_r($this->data['equipmenttype']);die;
	        $html='';
		    if($this->data['purchase'])
		    {
		    	$html=$this->load->view('till_date/v_till_date_report',$this->data,true);
		    }
		    else
		    {
		        $html='<span class="col-sm-12 alert alert-danger text-center" style="margin-top: -10px;">No Record Found!!!</span>';
		    }
		}else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
        return $html;
	}
	public function excel_tilldate()
	{	
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	//echo"<pre>"; print_r($this->input->post());die;
		header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=tilldate_excel_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
            
	        $response = $this->stock_till_date_common();
        echo $response;
        }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}
	public function tilldate_pdf()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	      	$html = $this->stock_till_date_common();

	        $filename = 'tilldate_'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4'; 
	        $this->general->generate_pdf($html,false,$pdfsize);
	        exit();
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}
	/*stock till date ends */
	public function stock_till_date_summary()
	{ 
		$this->data['store_type']=$this->general->get_tbl_data('eqty_equipmenttype,eqty_equipmenttypeid','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		$this->data['stock_check'] = 'summary';
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
			->build('stock_check/v_stock_check', $this->data);
	}
	/* stock till date summary search starts*/
	public function stock_till_date_summary_search()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
		if(MODULES_VIEW=='N')
			{
				
 				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}	
			$html=$this->till_date_common();
			if($html){
        	$template=$html;
        	}
	        // echo $temp; die();
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}
	public function till_date_common()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{	
			$this->data['excel_url'] = "stock_inventory/stock_check/excel_tilldate_summary";
			$this->data['pdf_url'] = "stock_inventory/stock_check/tilldate_summary_pdf";
			$this->data['report_title'] = $this->lang->line('stock_summary');

			$trma_todepartmentid = $this->input->post('eqty_equipmenttypeid')?$this->input->post('eqty_equipmenttypeid'):$this->input->post('store_id');
        	
			$date_range = $this->input->post('clsm_csmasterid');

			$split_date_range = explode(':', $date_range);

			$masterid = !empty($split_date_range[0])?$split_date_range[0]:'';
			$date_range = !empty($split_date_range[1])?$split_date_range[1]:'';

			if($date_range){
				$date_split = explode('-', $date_range);
				$this->data['fromdate'] = !empty($date_split[0])?$date_split[0]:'';
				$this->data['todate'] = !empty($date_split[1])?$date_split[1]:'';
			}

        	$locationid = $this->input->post('locationid');

        	$srchcol=$srchcol1=$srchcol2=$srchcol3=array();
        	if($masterid)
        	{
        		$srchcol1 = array('cd.csde_csmamasterid'=>$masterid);
        	}

        	if($trma_todepartmentid)
        	{
        		$srchcol2 = array('et.eqty_equipmenttypeid'=>$trma_todepartmentid);
        		$this->data['store_type']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$trma_todepartmentid));
        	}
        	else{
        		$this->data['store_type'] = 'All';
        	}

        	if($locationid)
        	{
        		$srchcol3 = array('mt.maty_locationid'=>$locationid);
        		$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
        	}else{
        		$this->data['location'] = 'All';
        	}

        	$srchcol = array_merge($srchcol1,$srchcol2,$srchcol3);

	      	$this->data['purchase']=$this->stock_check_mdl->get_stock_till_date_search($srchcol, 'summary');
	      	
	      	$this->data['equipmenttype']=$this->general->get_tbl_data('maty_material','maty_materialtype',array('maty_materialtypeid'=>$trma_todepartmentid),'maty_materialtypeid','DESC');

	      	
	        $html='';
		    if($this->data['purchase'])
		    {
		    	$html=$this->load->view('till_date/v_till_date_report_summary',$this->data,true);
		    }
		    else
		    {
		        $html='<span class="col-sm-12 alert alert-danger text-center" style="margin-top: -10px;">No Record Found!!!</span>';
		    }
		 }else{
    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
    	exit;
        }
        return $html;
	}
	public function excel_tilldate_summary()
	{	//echo"<pre>"; print_r($this->input->post());die;
		header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=tilldate_summary_excel_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        
	        $response = $this->till_date_common();
        echo $response;
	}
	public function tilldate_summary_pdf()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	      	$html = $this->till_date_common();

	        $filename = 'summary_'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4'; 
	        $this->general->generate_pdf($html,false,$pdfsize);
	        exit();
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}
	/* stock till date summary ends*/
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */