<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pending_requisition extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->model('pending_requisition_mdl');
		
	}

	public function index()
	{ 
		$this->data['current_tab']='pending_requisition';
		$seo_data='';
		if($seo_data)
		{
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
		echo "under maintenance";
		// $this->template
		// 	->set_layout('general')
		// 	->enable_parser(FALSE)
		// 	->title($this->page_title)
		// 	->build('purchase/v_purchse_requisition', $this->data);
	}


	public function pending_requision_list()
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
	  	$data = $this->pending_requisition_mdl->get_pending_requision();
	  	//echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		  	{ 
			    $array[$i]["sno"] = $i+1;
    			$array[$i]["pure_reqno"]=!empty($row->pure_reqno)?$row->pure_reqno:'';
    	 		$array[$i]["pure_reqdatebs"]=!empty($row->pure_reqdatebs)?$row->pure_reqdatebs:'';
	    	 	$array[$i]["itli_itemcode"]=!empty($row->itli_itemcode)?$row->itli_itemcode:'';
	    	 	$array[$i]["itli_itemname"]=!empty($row->itli_itemname)?$row->itli_itemname:'';
	    	 	$array[$i]["unit_unitname"]=!empty($row->unit_unitname)?$row->unit_unitname:'';
				$array[$i]["purd_qty"]=!empty($row->purd_qty)?$row->purd_qty:'';
    	 		//$array[$i]["redt_remaqty"]=!empty($row->redt_remaqty)?$row->redt_remaqty:'';
    	 		$array[$i]["eqty_equipmenttype"]=!empty($row->eqty_equipmenttype)?$row->eqty_equipmenttype:'';
	    	 	
				$i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function exportToExcel(){
		        header("Content-Type: application/xls");    
		        header("Content-Disposition: attachment; filename=all_purchase_item_".date('Y_m_d_H_i').".xls");  
		        header("Pragma: no-cache"); 
		        header("Expires: 0");

		        $data =  $this->pending_requisition_mdl->get_pending_requision();

		        $this->data['searchResult'] =$this->pending_requisition_mdl->get_pending_requision();
		        
		        unset($this->data['searchResult']['totalfilteredrecs']);
		        unset($this->data['searchResult']['totalrecs']);

		        $response = $this->load->view('pending_requision/v_pending_requision_download', $this->data, true);


		        echo $response;
    }

    public function generate_pdf()
	{
        $this->data['searchResult'] =$this->pending_requisition_mdl->get_pending_requision();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        //echo"<pre>";print_r($this->data['searchResult']);die;
        ini_set('memory_limit', '256M');

        $html = $this->load->view('pending_requision/v_pending_requision_download', $this->data, true);
      


        $mpdf = new mPDF('c', 'A4-L'); 
        $mpdf->SetWatermarkImage(PDF_WATERMARK);

          $mpdf = new mPDF('utf-8', 'A4-L');
        $mpdf->SetAutoFont(AUTOFONT_ALL);
        $mpdf->showWatermarkImage = true;
        $mpdf->showWatermarkText = true; 
        $mpdf->SetWatermarkText(ORGA_NAME);
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html);
        $output = 'all_purchase_item_'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }
}