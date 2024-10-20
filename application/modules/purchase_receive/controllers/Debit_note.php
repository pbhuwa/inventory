<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Debit_note extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('debit_note_mdl');
	}

	public function index()
	{ 
		$this->data['store_type']=$this->general->get_tbl_data('*','store',false,'st_store_id','ASC');
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
			->build('debit_note/v_debit_note', $this->data);
	}

	public function debit_order_list()
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
	  	$data = $this->debit_note_mdl->get_debit_note_list();
	  	//echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  	foreach($data as $row)
	    {	
	    	// d.dist_distributor,p.,p.,p.purr_returnno,p.purr_returnby,p.purr_purchasereturnid,p.purr_receivedby,p.purr_returntime,p.purr_st,p.purr_returnamount,p.purr_discount,p.purr_vatamount, (p.purr_returnamount - p.purr_discount + p.purr_vatamount) as netamount

	   		$array[$i]["sno"] = $i+1;
	   		$array[$i]['purr_returnno'] = $row->purr_returnno;
	   		$array[$i]['purr_returndatebs'] = $row->purr_returndatebs;
	   		$array[$i]['dist_distributor'] = $row->dist_distributor;
	   		$array[$i]['purr_vatamount'] = $row->purr_vatamount;
	   		$array[$i]['purr_discount'] = $row->purr_discount;
	   		$array[$i]['purr_returnamount'] = $row->purr_returnamount;
	   		$array[$i]['purr_returnby'] = $row->purr_returnby;
		   	$array[$i]['netamount'] = $row->netamount;
		   	$array[$i]['purr_returntime'] = $row->purr_returntime;
	   		
		    $i++;
	    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function exportToExcel(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=cancel_order_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->debit_note_mdl->get_debit_note_list();

        $this->data['searchResult'] = $this->debit_note_mdl->get_debit_note_list();
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('debit_note/v_debit_note_download', $this->data, true);


        echo $response;
    }

    public function generate_pdf()
    {
        $this->data['searchResult'] = $this->debit_note_mdl->get_debit_note_list();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        //echo"<pre>";print_r($this->data['searchResult']);die;
        ini_set('memory_limit', '256M');
        $html = $this->load->view('debit_note/v_debit_note_download', $this->data, true);
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
        $output = 'cancel_order_'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */