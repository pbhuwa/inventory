<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Receive_dispatch_analysis extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('receive_dispatch_analysis_mdl');
	}
	public function index()
	{ 	
		$this->data['material_type']=$this->general->get_tbl_data('*','maty_materialtype');
		$this->data['subcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory');
		$this->data['equipmenttype']=$this->general->get_tbl_data('*','eqty_equipmenttype');
		$this->data['items']=$this->general->get_tbl_data('*','itli_itemslist');
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
		
        $this->data['current_tab']='receive_dispatch_analysis';
        $this->template
            ->set_layout('general')
            ->enable_parser(FALSE)
            ->title($this->page_title)
            ->build('report/v_report', $this->data);
            
		// $this->template
		// 	->set_layout('general')
		// 	->enable_parser(FALSE)
		// 	->title($this->page_title)
		// 	->build('receive_dispatch/v_receive_dispatch', $this->data);
	}
	public function receive_dispatch_analysis_report()
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
		//print_r($cond);die;
	  	$data = $this->receive_dispatch_analysis_mdl->get_opening_stock_list();
	  	//echo"<pre>";print_r($data);die;
        // echo $this->db->last_query();
        // die();
        
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		foreach($data as $row)
		{
            $array[$i]["itemsid"]=$row->trde_itemsid;
            $array[$i]["category"]=$row->eqca_category;
            $array[$i]["itemcode"]=$row->itli_itemcode;
            $array[$i]["itemname"]=$row->itli_itemname; 
            $array[$i]["material"]=$row->maty_material;
            $array[$i]["unitname"]=$row->unit_unitname;
            $array[$i]["receivedqty"]=$row->receivedqty;
            $array[$i]["unitprice"]=$row->trde_unitprice;
            $array[$i]["rtotal"]=(($row->trde_unitprice) * ($row->receivedqty));
            $array[$i]["dispatch_qty"] = $row->dispatch_qty;
            $array[$i]["dispatch_rate"] = $row->dispatch_rate;
            $array[$i]["dispatchamount"] = (($row->dispatch_rate) * ($row->dispatch_qty));
            $array[$i]["dispatchlocation"] = $row->dispatchlocation;
            $array[$i]["balanceqty"] = ($row->receivedqty - $row->dispatch_qty);
            $array[$i]["balancetotal"] = number_format((($row->receivedqty - $row->dispatch_qty) * $row->dispatch_rate),2);
            //$array[$i]["balancetotal"] = (($row->receivedqty - $row->dispatch_qty) * $row->trde_unitprice);
	         	//    if(DEFAULT_DATEPICKER=='NP')
	         	//    {
	         	//    	$array[$i]["transactiondate"]=$row->trde_transactiondatebs;
	        	// }
		        // else
		        // {
		        // 	$array[$i]["transactiondate"]=$row->trde_transactiondatead;
	        // }
         	$array[$i]["remarks"]=$row->sade_remarks;
         	$i++;
		}
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function exportToExcel(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=disptch_received_report_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        $data = $this->receive_dispatch_analysis_mdl->get_opening_stock_list();
        $this->data['searchResult'] = $this->receive_dispatch_analysis_mdl->get_opening_stock_list();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
	    $response = $this->load->view('receive_dispatch/v_receive_dispatch_donload', $this->data, true);
        echo $response;
    }
	public function generate_pdf()
    {
     //    $this->data['searchResult'] = $this->receive_dispatch_analysis_mdl->get_opening_stock_list();
     //    $this->load->library('pdf');
     //    $mpdf = $this->pdf->load(); 
     //    //echo"<pre>";print_r($this->data['searchResult']);die;
     //    ini_set('memory_limit', '256M');
     //    unset($this->data['searchResult']['totalfilteredrecs']);
     //    unset($this->data['searchResult']['totalrecs']);
     //    $html = $this->load->view('receive_dispatch/v_receive_dispatch_donload', $this->data, true);
     //    $mpdf = new mPDF('c', 'A4-L'); 
	    //     // $mpdf->SetWatermarkImage(PDF_WATERMARK);
	    //     // $mpdf->showWatermarkImage = true;
     //    $mpdf->showWatermarkText = true;  
	    // $mpdf->SetWatermarkText(ORGA_NAME); 
     //    $mpdf->WriteHTML($stylesheet, 1);
     //    $mpdf->WriteHTML($html);
     //    $output = 'disptch_received_report_'.date('Y_m_d_H_i').'.pdf';
     //    $mpdf->Output();
     //    exit();

        
        $this->data['searchResult'] = $this->receive_dispatch_analysis_mdl->get_opening_stock_list();
       
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $html = $this->load->view('receive_dispatch/v_receive_dispatch_donload', $this->data, true);
        
        $output = 'disptch_received_report_'.date('Y_m_d_H_i').'.pdf';
        $this->general->generate_pdf($html, '','');
    }
}