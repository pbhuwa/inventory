<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report_bio_medical_inventry extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
			 $this->load->Model('pm_data_mdl');
			// $this->load->Model('risk_value_mdl');
			// $this->load->Model('equipment_mdl');
			 $this->load->Model('bio_medical_mdl');

		
	}
	public function index()
	{   
		$this->data = array();
		$this->data['distinct_department'] = $this->bio_medical_mdl->get_biomedical_report();
		//echo"<pre>"; print_r($this->data['bioInvReport']);die;
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
			->build('bio_medical_inventory/v_report_biomedical_inventry', $this->data);
	}

	public function reportpdf()
	{
		$data['distinct_department'] = $this->bio_medical_mdl->get_biomedical_report();
		$this->load->library('pdf');
        $mpdf = $this->pdf->load(); 
        // $stylesheet= file_get_contents(CSS_PATH.'template/report/stylereport.css');
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
        ini_set('memory_limit', '256M');
        $html = $this->load->view('bio_medical_inventory/v_report_biomedical_inventry', $data, true);
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html); 
        
        $output = 'BiomedicalIventory.pdf'; 
        // $mpdf->Output($output, 'D'); 
        $mpdf->Output(); 
        exit();
	}

}