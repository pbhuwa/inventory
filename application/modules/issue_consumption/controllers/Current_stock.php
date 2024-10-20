<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Current_stock extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('current_stock_mdl');
		$this->locationid=$this->session->userdata(LOCATION_ID);
		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
	}
	public function index()
	{ 
		$this->data['store_type']=$this->general->get_tbl_data('*','store',false,'st_store_id','ASC');
		$this->data['current_stock']='summary';
		$seo_data='';
		if($seo_data)
		{	//set SEO data
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
			->build('current_stock/v_current_stock_report', $this->data);
	}

	public function current_stock_details()
	{
		$this->data['store_type']=$this->general->get_tbl_data('*','store',false,'st_store_id','ASC');
		$this->data['current_stock']='detail';
		$seo_data='';
		if($seo_data)
		{	//set SEO data
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
			->build('current_stock/v_current_stock_report', $this->data);
	}
	public function search_current_stock_details_list()
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
				 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
				exit;
				}
			}
			
			$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		  	$i = 0;
		  	//echo"<pre>";print_r($this->input->get());die;
		  	if($this->location_ismain=='Y'){
		  		$data = $this->current_stock_mdl->get_current_stock_lists();
		  	}else{
		  		$data = $this->current_stock_mdl->get_current_stock_lists(array('itli_locationid'=>$this->locationid));
		  	}
		  	$data = $this->current_stock_mdl->get_current_stock_lists();
		  	
		  	//echo"<pre>";print_r($data);die;
			$array = array();
			$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
			$totalrecs = $data["totalrecs"];

		    unset($data["totalfilteredrecs"]);
		  	unset($data["totalrecs"]);

			  	foreach($data as $row)
			    {	
			   		$array[$i]["sno"] = $i+1;
			   		$array[$i]['itli_itemcode'] = $row->itli_itemcode;
			   		$array[$i]['itli_itemname'] = $row->itli_itemname;
			   		$array[$i]['eqca_category'] = $row->eqca_category;
			   		$array[$i]['maty_material'] = $row->maty_material;
			   			$array[$i]['itli_maxlimit'] = $row->itli_maxlimit;
			   		$array[$i]['itli_reorderlevel'] = $row->itli_reorderlevel;
			   		$array[$i]['atstock'] = $row->atstock;
			   		$array[$i]['trde_unitprice'] = $row->trde_unitprice;
			   		$array[$i]['unit_unitname'] = $row->unit_unitname;
			   		$array[$i]['batchno'] = $row->batchno;
			   		$array[$i]['trde_expdatebs'] = $row->trde_expdatebs;
			   		$array[$i]['amount'] = $row->amount;
			   		
				    $i++;
			    }
	        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
		}
		

	public function search_current_stock_list()
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

	  	if($this->location_ismain=='Y'){
	  		$data = $this->current_stock_mdl->get_current_stock_lists();
	  	}else{
	  		$data = $this->current_stock_mdl->get_current_stock_lists(array('itli_locationid'=>$this->locationid));
	  	}
	  	
	  	// echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);

		  	foreach($data as $row)
		    {	
		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]['itli_itemcode'] = $row->itli_itemcode;
		   		$array[$i]['itli_itemname'] = $row->itli_itemname;
		   		$array[$i]['eqca_category'] = $row->eqca_category;
		   		$array[$i]['maty_material'] = $row->maty_material;
		   		$array[$i]['itli_maxlimit'] = $row->itli_maxlimit;
		   		$array[$i]['itli_reorderlevel'] = $row->itli_reorderlevel;
		   		$array[$i]['atstock'] = $row->atstock;
		   		$array[$i]['trde_unitprice'] = $row->trde_unitprice;
		   		$array[$i]['unit_unitname'] = $row->unit_unitname;
		   		$array[$i]['amount'] = $row->amount;
		   		
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	
	public function exportToExcel($details=false){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=all_purchase_item_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->current_stock_mdl->get_current_stock_lists();
        $this->data['pdf_details'] = $details;
        $this->data['searchResult'] = $this->current_stock_mdl->get_current_stock_lists();
        
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $response = $this->load->view('current_stock/v_current_stock_details_download', $this->data, true);


        echo $response;
    }
    public function generate_details_pdf($details=false)
    {	
    	unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        if($this->location_ismain=='Y'){
        	 $this->data['searchResult'] = $this->current_stock_mdl->get_current_stock_lists();
        	}else{
        		 $this->data['searchResult'] = $this->current_stock_mdl->get_current_stock_lists(array('itli_locationid'=>$this->locationid));
        	}
       
        
        $this->data['pdf_details'] = $details;

        $this->load->library('pdf');

        $mpdf = $this->pdf->load();
       	//echo"<pre>";print_r($this->data['searchResult']);die;
        ini_set('memory_limit', '256M');
        
        $html = $this->load->view('current_stock/v_current_stock_details_download', $this->data, true);
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
        $output = 'all_purchase_item_'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */