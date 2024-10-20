<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_requisition_details extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('purchase_requisition_details_mdl');
		$this->mattypeid = $this->session->userdata(USER_MAT_TYPEID);
	}

	public function index()
	{ 
		if(!empty($this->mattypeid))
		{
			$srchmat=array('maty_materialtypeid'=>$this->mattypeid,'maty_isactive'=>'Y');
		}else{
			$srchmat=array('maty_isactive'=>'Y');
		}
		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material','maty_materialtype',$srchmat,'maty_materialtypeid','ASC');

		// echo '<pre>';
		// print_r($this->data['material_type']);
		// die();

		$this->data['current_tab']='detail_list';
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
			->build('purchase/v_purchse_requisition', $this->data);
			//->build('purchase_requisition_details/v_purchase_requisition_details', $this->data);
	}

	public function purchase_requisition_details_list()
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
	  	$data = $this->purchase_requisition_details_mdl->get_purchase_requisition_details_list();
	  	// echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {	
		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]['reqno'] = $row->reqno;
		   		$array[$i]['reqdatebs'] = $row->reqdatebs;
		   		$array[$i]['requser'] = $row->requser;
		   		$array[$i]['unit'] = $row->unit;
		   		$array[$i]['itemname'] = $row->itemname;
		   		$array[$i]['qty'] = $row->qty;
		   		$array[$i]['materialname'] = $row->materialname;
		   		$array[$i]['category'] = $row->category;
		   		$array[$i]['status'] = $row->status;
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function exportToExcel(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=purchase_requisition_details_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->purchase_requisition_details_mdl->get_purchase_requisition_details_list();

        $this->data['searchResult'] = $this->purchase_requisition_details_mdl->get_purchase_requisition_details_list();
        
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $response = $this->load->view('purchase_requisition_details/v_purchase_requisition_details_download', $this->data, true);


        echo $response;
    }

    public function generate_pdf()
    {
    	$page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}

        $this->data['searchResult'] = $this->purchase_requisition_details_mdl->get_purchase_requisition_details_list();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $this->load->library('pdf');

        $mpdf = $this->pdf->load();
        // echo"<pre>";print_r($this->data['searchResult']);die;
        ini_set('memory_limit', '256M');

        $html = $this->load->view('purchase_requisition_details/v_purchase_requisition_details_download', $this->data, true);
        $mpdf = new mPDF('c', 'A4-L');


         $this->general->generate_pdf($html, '', $page_size);
         
        if(PDF_IMAGEATEXT == '3')
        {
            $mpdf->SetWatermarkImage('https://xelwel.com.np/biomedical/assets/template/images/xelwel.png');
            $mpdf->showWatermarkImage = true;
            $mpdf->showWatermarkText = true;  
            $mpdf->SetWatermarkText(ORGA_NAME);
        }
        if(PDF_IMAGEATEXT == '1')
        {
            $mpdf->SetWatermarkImage('https://xelwel.com.np/biomedical/assets/template/images/xelwel.png');
            $mpdf->showWatermarkImage = true;
        } 
        if(PDF_IMAGEATEXT == '2')
        {
            $mpdf->showWatermarkText = true;  
            $mpdf->SetWatermarkText(ORGA_NAME);
        }


        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html);
        $output = 'purchase_requisition_details_'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */