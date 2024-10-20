<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Audit_trial extends CI_Controller {

	function __construct() {
		parent::__construct();
			$this->load->model('audit_trial_mdl');
	}
	
	
	public function index()
	{
		$frmdatedb=CURDATE_EN;
		$todatedb=CURDATE_EN;
		$srch=array('colt_postdatead>='=>$frmdatedb,'colt_postdatead<='=>$todatedb);

		$this->data['audit_list']=$this->audit_trial_mdl->get_audit_trial_rec($srch);
		$this->data['table_list']=$this->audit_trial_mdl->get_table_list();
		// echo "<pre>";
		// print_r($this->data['table_list']);
		// die();
		$this->page_title='Services';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('audit_trial/audit_trial', $this->data);
	}



public function generate_report_audit_trial()
{
	 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   //      echo "<pre>"; 
	 	// print_r($this->input->post());
	 	// die();
	 	$tablename=$this->input->post('tablename');
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

	 	if(!empty($tablename) && empty($fromDate) && empty($toDate))
	 	{
	 		$srch=array('colt_tablename'=>$tablename);
	 	}
	 	else if(empty($tablename) && !empty($fromDate) && !empty($toDate))
	 	{
	 		
			$srch=array('colt_postdatead>='=>$frmdatedb,'colt_postdatead<='=>$todatedb);
	 	}

	 	else if(!empty($tablename) && !empty($fromDate) && !empty($toDate))
	 	{
	 		
			$srch=array('colt_postdatead>='=>$frmdatedb,'colt_postdatead<='=>$todatedb,'colt_tablename'=>$tablename);
	 	}

	 	else
	 	{
	 		$srch='';
	 	}
	 	



       $this->data['audit_list']=$this->audit_trial_mdl->get_audit_trial_rec($srch);
      
      // echo $this->db->last_query();
      // die();

        $template='';
        $template=$this->load->view('audit_trial/audit_trial_list',$this->data,true);

         // echo $temp; die();
         print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
          exit;
      }
      else{
          print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
          exit;
      }
}


	
		
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */