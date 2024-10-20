<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Access_log extends CI_Controller {

	function __construct() {
		parent::__construct();
			$this->load->model('access_log_mdl');
	}
	
	
	public function index()
	{
		
		$frmdatedb=CURDATE_EN;
		$todatedb=CURDATE_EN;
		$srch=array('loac_logindatead>='=>$frmdatedb,'loac_logindatead<='=>$todatedb);

		$this->data['access_log_list']=$this->access_log_mdl->get_access_log_rec($srch);
		$this->data['table_list']=$this->access_log_mdl->get_table_list();
		// echo "<pre>";
		// print_r($this->data['table_list']);
		// die();
		$this->page_title='Services';
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('access_log/access_log_list', $this->data);
			

	}



public function generate_report_access_log()
{
	 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   //      echo "<pre>"; 
	 	// print_r($this->input->post());
	 	// die();
	 	//$tablename=$this->input->post('tablename');

	 	//$tablename='';
	 	$fromDate=$this->input->post('fromDate');
	 	$toDate=$this->input->post('toDate');

	 	if(DEFAULT_DATEPICKER=='NP')
			{
				$frmdatedb=$this->general->NepToEngDateConv($fromDate);
				$todatedb=$this->general->NepToEngDateConv($toDate);

			}
			else{
				$frmdatedb=$fromDate;
				$todatedb=$toDate;
			}

	 	if(empty($fromDate) && empty($toDate))
	 	{
	 		$srch='';
	 	}
	 	else if( !empty($fromDate) && !empty($toDate))
	 	{
	 		
			$srch=array('loac_logindatebs>='=>$fromDate,'loac_logindatebs<='=>$toDate);
	 	}

	 	// else if(!empty($tablename) && !empty($fromDate) && !empty($toDate))
	 	// {
	 		
			// $srch=array('loac_logindatead>='=>$frmdatedb,'loac_logindatead<='=>$todatedb,'colt_tablename'=>$tablename);
	 	// }

	 	else
	 	{
	 		$srch='';
	 	}
	 	

	 	//print_r($srch) ;die;

       $this->data['audit_list']=$this->access_log_mdl->get_access_log_rec($srch);
      //echo "<pre>";print_r($this->data['audit_list']);die;
      // echo $this->db->last_query();
      // die();

        $template='';
        $template=$this->load->view('access_log/access_log_list',$this->data,true);

         // echo $temp; die();
         print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
          exit;
      }
      else{
          print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
          exit;
      }
}


public function access_details_lists()
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
				// $this->general->permission_denial_message();
				 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
				exit;
			}
		}
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	  	
	  	$data = $this->access_log_mdl->get_access_details_list();
	  	// echo $this->db->last_query();die();
	 	//echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  	$i=0;
		  	foreach($data as $row)
		    {
			    // $array[$i]["rede_reqdetailid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->rede_reqdetailid.'>'.$row->rede_reqdetailid.'</a>';
			    //$array[$i]["sn"]=$i;
		    	$array[$i]["login_date_bs"] = $row->loac_logindatebs;
			   	$array[$i]["login_date_ad"] = $row->loac_logindatead;
			    $array[$i]["login_time"] = $row->loac_logintime;
			    $array[$i]["username"] = $row->loac_loginusername;
			    $array[$i]["login_ip"] = $row->loac_loginip;
			    $array[$i]["login_isvalidlogin"] = $row->loac_isvalidlogin;
			    
			  
			    $i++;
		    }
		    //echo"<pre>";print_r($data);die;
		    $get = $_GET;
		    //print_r($array);die;
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
}

public function exportToExcelAccessDetails()
    {
    	header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_requisition_details".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->access_log_mdl->get_access_details_list();

        $this->data['searchResult'] = $this->access_log_mdl->get_access_details_list();
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('access_log/v_access_log_report_download', $this->data, true);


        echo $response;
    }


    public function generate_pdfAccess_details()
    {
        $this->data['searchResult'] = $this->access_log_mdl->get_access_details_list();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        //echo"<pre>";print_r($this->data['searchResult']);die;
        ini_set('memory_limit', '256M');
        $html = $this->load->view('access_log/v_access_log_report_download', $this->data, true);
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
        $output = 'stock_requisition_details'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }

	
		
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */