<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Yearly_pmreport extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
			 $this->load->Model('pm_data_mdl');

		
	}
	public function index()
	{   
		$this->data = array();
		$this->data['pmReportByDepartment'] = $this->pm_data_mdl->get_pm_report_by_department();
		//echo"<pre>"; print_r($this->data['pmReportByDepartment']);die;
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
			->build('pm_data/v_pmreport', $this->data);
	}

	public function yerarlyreport()
	{	
		$data['pmReportByDepartment'] = $this->pm_data_mdl->get_pm_report_by_department();
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
        $html = $this->load->view('pm_data/v_pmreport', $data, true);
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html); 
        
        $output = 'yearlyPmreport.pdf'; 
        // $mpdf->Output($output, 'D'); 
         $mpdf->Output(); 
        exit();
	}

}