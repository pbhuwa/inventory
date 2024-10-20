<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Design extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('editor');	
	}

	public function prescription_report()
	{   
		$this->load->model('nurse_triage/nurse_triage_mdl');
		if($this->session->userdata('patientid'))
		{
			$this->data['nursetriage_data'] = $this->nurse_triage_mdl->get_nursetriage_all(false,1,false,'nutr_postdatead','DESC');
        	//pp($this->data['nursetriage_data']);

		}
		else
		{
			$this->data['nursetriage_data']=array();
		}
		$this->load->view('prescription_report', $this->data);
	}
	

	public function rpt_prescription()
	{

        $this->load->library('pdf');
        $pdf = $this->pdf->load(); 
        // $stylesheet= file_get_contents(CSS_PATH.'template/report/stylereport.css');
            
        ini_set('memory_limit', '256M');
        $html = $this->load->view('design/prescription_report', $data, true);
        $pdf->WriteHTML($stylesheet, 1);
        $pdf->WriteHTML($html); 
        
        $output = 'Prescription.pdf'; 
        // $pdf->Output($output, 'D'); 
         $pdf->Output(); 
        exit();
	}

	public function patient_reg()
	{
		$this->load->library('pdf');
        $pdf = $this->pdf->load(); 
        // $stylesheet= file_get_contents(CSS_PATH.'template/report/stylereport.css');
            
        ini_set('memory_limit', '256M');
        $html = $this->load->view('design/patient_reg', $data, true);
        $pdf->WriteHTML($stylesheet, 1);
        $pdf->WriteHTML($html); 
        
        $output = 'Prescription.pdf'; 
        // $pdf->Output($output, 'D'); 
         $pdf->Output(); 
        exit();
		//$this->load->view('patient_reg');
	}

	public function report1()
	{	
		$this->load->library('pdf');
        $pdf = $this->pdf->load(); 
        // $stylesheet= file_get_contents(CSS_PATH.'template/report/stylereport.css');
            
        ini_set('memory_limit', '256M');
        $html = $this->load->view('design/v_report', $data, true);
        $pdf->WriteHTML($stylesheet, 1);
        $pdf->WriteHTML($html); 
        
        $output = 'Prescription.pdf'; 
        // $pdf->Output($output, 'D'); 
         $pdf->Output(); 
        exit();
	}
    public function dentaldesign()
    {   
        
            $this->template
                ->set_layout('general')
                ->enable_parser(FALSE)
                ->title('')
                ->build('v_dental');
        // $this->load->view('v_dental');
    }

    public function medical_history()
    {   
        
            $this->template
                ->set_layout('general')
                ->enable_parser(FALSE)
                ->title('')
                ->build('v_med_history');
    }

    public function dental_history()
    {   
        
            $this->template
                ->set_layout('general')
                ->enable_parser(FALSE)
                ->title('')
                ->build('v_dent_history');
    }
    public function repair_request()
    {   
        
            $this->template
                ->set_layout('general')
                ->enable_parser(FALSE)
                ->title('')
                ->build('v_repair_request');
    }
	
    public function repair_request_pdf()
    {   
        $this->load->library('pdf');
        $pdf = $this->pdf->load(); 
        // $stylesheet= file_get_contents(CSS_PATH.'template/report/stylereport.css');
            
        ini_set('memory_limit', '256M');
        $html = $this->load->view('design/v_repair_request', $data, true);
        $pdf->WriteHTML($stylesheet, 1);
        $pdf->WriteHTML($html); 
        
        $output = 'Prescription.pdf'; 
        // $pdf->Output($output, 'D'); 
         $pdf->Output(); 
        exit();
    }

    public function formtruma_report()
    {
        $this->template
                ->set_layout('general')
                ->enable_parser(FALSE)
                ->title('')
                ->build('formtruma_report');
    }
}

