<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order_detail extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('order_detail_mdl');
		
	}

	public function index()
	{ 
		$this->data['store_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');

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
		// $this->template
		// 	->set_layout('general')
		// 	->enable_parser(FALSE)
		// 	->title($this->page_title)
		// 	->build('order_detail/v_order_detail', $this->data);
		$this->data['tab_type']='order_detail';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('pending_order_detail/v_pending_common', $this->data);
	}

	public function order_detail_list()
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
	  	$data = $this->order_detail_mdl->get_order_detail_list();
	  	// echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {	
		    	if(ITEM_DISPLAY_TYPE=='NP'){
                	$rec_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
                }else{ 
                    $rec_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
                }

		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]["itemscode"] = $row->itli_itemcode;
		   		$array[$i]["itemsname"] = $rec_itemname;
		   		$array[$i]["supp_suppliername"] = $row->dist_distributor;
			    $array[$i]["puor_purchaseorderdate"] = $row->puor_orderdatebs;
			    $array[$i]["puor_purchaseorderno"] = $row->puor_orderno;
			    $array[$i]["pude_quantity"] = sprintf('%g',$row->pude_quantity);
			    $array[$i]["pude_rate"] = $row->pude_rate;
			    $array[$i]["pude_remarks"] = $row->pude_remarks;
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function exportToExcel()
	{
		/*
		        header("Content-Type: application/xls");    
		        header("Content-Disposition: attachment; filename=order_detail_".date('Y_m_d_H_i').".xls");  
		        header("Pragma: no-cache"); 
		        header("Expires: 0");
		        
		        $data = $this->order_detail_mdl->get_order_detail_list();
		        
		        $array = array();
		        unset($data["totalfilteredrecs"]);
		        unset($data["totalrecs"]);

		        $response = '<table border="1">';
		        $response .= '<tr><th colspan="7"><center>Order Detail</center></th></tr>';
		        $response .= '<tr><th>S.No.</th><th>Items Code</th><th>Items Name</th><th>Supplier</th><th>Order Date</th><th>Order No.</th><th>Quantity</th><th>Rate</th><th>Remarks</th></tr>';

		        $i=1;
		        $iDisplayStart = !empty($_GET['iDisplayStart'])?$_GET['iDisplayStart']:0;
		        foreach($data as $row){

		            $sno = $iDisplayStart + $i; 
			   		$itli_itemcode = $row->itli_itemcode;
			   		$itli_itemname = $row->itli_itemname;
			   		$supp_suppliername = $row->supp_suppliername;
			   		$puor_datebs = $row->puor_orderdatebs;
				    $puor_no = $row->puor_orderno;
				    $pude_quantity = $row->pude_quantity;
				    $pude_rate = $row->pude_rate;
				    $pude_remarks = $row->pude_remarks;

		            $response .= '<tr><td>'.$sno.'</td><td>'.$itli_itemcode.'</td><td>'.$itli_itemname.'</td><td>'.$supp_suppliername.'</td><td>'.$puor_datebs.'</td><td>'.$puor_no.'</td><td>'.$pude_quantity.'</td><td>'.$pude_rate.'</td><td>'.$pude_remarks.'</td></tr>';
		            $i++;
		        }
		        
		        $response .= '</table>';

		        echo $response;
		*/
		header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=pending_order_detail_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
       	$html  = $this->order_detail_common();
        if($html)
        {
       		echo $html;
       	}
    }

    public function generate_pdf()
    {
		    /*
		        $this->data['searchResult'] = $this->order_detail_mdl->get_order_detail_list();
		        $this->load->library('pdf');
		        $mpdf = $this->pdf->load();
		        
		        ini_set('memory_limit', '256M');
		        $html = $this->load->view('order_detail/v_order_detail_pdf', $this->data, true);
		        
		        $mpdf = new mPDF('','A4','',''); 

		        if(PDF_IMAGEATEXT == '3')
		        {
		            $mpdf->SetWatermarkImage(WATER_MARK_IMAGE);
		            $mpdf->showWatermarkImage = true;
		            $mpdf->showWatermarkText = true;  
		            $mpdf->SetWatermarkText(ORGA_NAME);
		        }
		        if(PDF_IMAGEATEXT == '1')
		        {
		            $mpdf->SetWatermarkImage(WATER_MARK_IMAGE);
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
		        

		        $output = 'order_detail_'.date('Y_m_d_H_i').'.pdf';
		        $mpdf->Output();
		        exit();
			*/ 
         $html  = $this->order_detail_common();
      	$filename = 'pending_order_detail_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; 
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
  	}

   public function order_detail_common()
    {
    	$this->data['excel_url'] = "purchase_receive/order_detail/exportToExcel";
		$this->data['pdf_url'] = "purchase_receive/order_detail/generate_pdf";
		$this->data['report_title'] = $this->lang->line('order_detail');

		// $this->data['searchResult'] = $this->demand_report_mdl->get_demand_report_list();
		$this->data['searchResult'] = $this->order_detail_mdl->get_order_detail_list();

		unset($this->data['searchResult']["totalfilteredrecs"]);
		unset($this->data['searchResult']["totalrecs"]);
		
		$html = $this->load->view('order_detail/v_order_detail_pdf', $this->data, true);
        return $html;
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */