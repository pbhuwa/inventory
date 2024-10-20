<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_order_aging extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('purchase_order_aging_mdl');
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
		$this->data['current_tab']='purchase_order_aging';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			// ->build('purchase_order_aging/v_purchase_order_aging_main', $this->data);
			->build('purchase_order/v_common_purchaseorder_tab', $this->data);
	}
	

	public function purchase_order_aging_list()
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
		$currentdatebs=CURDATE_NP;
		$currentdatead=CURDATE_EN;
		$get = $_GET;
		$frmdate=!empty($get['frmDate'])?$get['frmDate']:'';

	  	$i = 0;
	  	$data = $this->purchase_order_aging_mdl->get_purchase_order_aging_list();
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
		    	$array[$i]['zero_to_15']='';
		    	$array[$i]['15_to_30']='';
		    	$array[$i]['30_to_45']='';
		    	$array[$i]['45_to_more']='';


		    	$array[$i]['zero_to_15']=$this->purchase_order_aging_mdl->get_deleverydate_by_supplierid($row->suppliderid,$frmdate,0,15);
		    	// echo $this->db->last_query();

		    	$array[$i]['15_to_30']=$this->purchase_order_aging_mdl->get_deleverydate_by_supplierid($row->suppliderid,$frmdate,15,30);
		    	// echo $this->db->last_query();

		    	$array[$i]['30_to_45']=$this->purchase_order_aging_mdl->get_deleverydate_by_supplierid($row->suppliderid,$frmdate,30,45);
		    	$array[$i]['45_to_more']=$this->purchase_order_aging_mdl->get_deleverydate_by_supplierid($row->suppliderid,$frmdate,45,0);

		    	
		    	
		    	// echo $days,',';
		    	// echo '-----';
		  //   	$array[$i]['zero_to_15']='';
		  //   	$array[$i]['15_to_30']='';
		  //   	$array[$i]['30_to_45']='';
		  //   	$array[$i]['45_to_more']='';

		  //   	switch ($days) {
				//     case ($days>0 && $days<=15):
				//        $array[$i]['zero_to_15']=$this->purchase_order_aging_mdl->get_orderno($row->puor_supplierid);
				//         break;
				//     case ($days>15 && $days<=30):
				//        $array[$i]['15_to_30']=$this->purchase_order_aging_mdl->get_orderno($row->puor_supplierid);
				//         break;
				//     case ($days>30 && $days<=45):
				//          $array[$i]['30_to_45']=$this->purchase_order_aging_mdl->get_orderno($row->puor_supplierid);
				//         break;
				//     default:
				//       $array[$i]['45_to_more']=$this->purchase_order_aging_mdl->get_orderno($row->puor_supplierid);
				// }
		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]['supplier_name'] = $row->dist_distributor;
		   		
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function date_different($date1,$date2)
	{
		$days=strtotime($date1)-strtotime($date2);
		if($days>0)
		{
			$result=floor($days/86400);
			return $result;	
		}
	}
	public function exportToExcel(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=pending_order_detail_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        
        $data = $this->purchase_order_aging_mdl->get_purchase_order_aging_list();
        $this->data['searchResult'] = $this->purchase_order_aging_mdl->get_purchase_order_aging_list();
        
        $array = array();
        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
        $response = $this->load->view('purchase_order_aging/v_purchase_order_aging_download', $this->data, true);

        echo $response;
    }

    public function generate_pdf()
    {	
        $this->data['searchResult'] = $this->purchase_order_aging_mdl->get_purchase_order_aging_list();

        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
        
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        //echo"<pre>"; print_r($this->data['searchResult']);die;
        ini_set('memory_limit', '256M');
        $html = $this->load->view('purchase_order_aging/v_purchase_order_aging_download', $this->data, true);
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
        $output = 'purchase_order_aging'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */