<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Fuel extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->Model('fuel_mdl');
	}

	public function index()
	{
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		$this->data['fuel_list']=$this->general->get_tbl_data('*','futy_fueltype',false,'futy_typeid','DESC');
		$this->data['month']=$this->general->get_tbl_data('*','mona_monthname',false,'mona_monthid','ASC');
		$last_id=$this->general->get_tbl_data('fuel_fuelcoupenid','fuel_fuelcoupen',false,'fuel_fuelcoupenid','DESC');
		$this->data['next_id'] = !empty($last_id[0]->fuel_fuelcoupenid)?$last_id[0]->fuel_fuelcoupenid:'';
		// print_r($this->data['next_id']);die;
		$seo_data='';
		$this->data['tab_type']="entry";
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
		->build('v_fuel', $this->data);
	}

	public function save_fuel()
	{
		// print_r($this->input->post());
		// die();
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			try {
				$this->form_validation->set_rules($this->fuel_mdl->validate_settings_fuel_list);
				
				if($this->form_validation->run()==TRUE)
				{
					$trans = $this->fuel_mdl->fuel_save();
					

					if($trans)
					{
						print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
						exit;
					}
					else
					{
						print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
						exit;
					}
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
					exit;
				}
			} 
			catch (Exception $e) 
			{
				
				print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
			}
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}
	public function form_fuel()
	{
		$this->load->view('v_fuel');
		
	}

	public function get_coupen_generate()
	{
		try{
			$id = $this->input->post('id');
			 // print_r($id);die;

			$this->data['details'] = $this->fuel_mdl->get_fuel_details(array('fude_fuelcoupenid'=>$id),false,false,false,false);
			  // print_r($this->data['details']);die;

			$tempform=$this->load->view('fuel/v_coupen_generate',$this->data,true);

			if($this->data['details'])
			{
				print_r(json_encode(array('status'=>'success','message'=>'Success','tempform'=>$tempform)));
				exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Error')));
				exit;
			}

		}catch(Exception $e){
			throw $e;
		}
	}
	
	public function user_assign_popup(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {


			$id=$this->input->post('id');
			$this->data['staff_all'] =$this->general->get_tbl_data('*','stin_staffinfo',false,'stin_staffinfoid','ASC');

			$this->data['fuel_data'] = $this->fuel_mdl->get_fuel_details(array('fude_fuelcoupendetailsid'=>$id),false,false,false,false);
			$staffid=$this->data['fuel_data'][0]->fude_staffid;

			$this->data['staff_data']=$this->fuel_mdl->get_all_staff_manager(array('stin_staffinfoid'=>$staffid));
			
			$this->data['Cur_staff_data'] = $this->fuel_mdl->get_fuel_details(array('fude_staffid'=>$staffid),false,1,false,false);
			$this->data['pre_staff_data']=$this->fuel_mdl->get_fuel_details(array('fude_staffid'=>$staffid),false,false,'fude_fuelcoupendetailsid','DESC');

			$tempform=$this->load->view('fuel/v_coupen_assign_staff',$this->data,true);
		// echo $tempform;
		// die();
			if(!empty($this->data['fuel_data']))
			{
				print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$tempform)));
				exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Unable to view!!')));
				exit;
			}
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}

	}

	public function coupen_assigned()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$staffid = $this->input->post('fude_staffid');
			if($staffid=='')
			{
				print_r(json_encode(array('status'=>'error','message'=>'You Need to Select Atleast One staff !!! ')));
				exit;
			}

			$trans  = $this->fuel_mdl->assign_coupen_update();
			if($trans)
			{
				print_r(json_encode(array('status'=>'success','message'=>'Coupen Assigned Successfully')));
				exit;
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Record Save failed')));
				exit;
			}
		}else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}
	public function list()
	{
		
		
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		$this->data['fuel_list']=$this->general->get_tbl_data('*','futy_fueltype',false,'futy_typeid','DESC');
		$this->data['month']=$this->general->get_tbl_data('*','mona_monthname',false,'mona_monthid','ASC');
		$last_id=$this->general->get_tbl_data('fuel_fuelcoupenid','fuel_fuelcoupen',false,'fuel_fuelcoupenid','DESC');
		$this->data['next_id'] = !empty($last_id[0]->fuel_fuelcoupenid)?$last_id[0]->fuel_fuelcoupenid:'';
		// print_r($this->data['next_id']);die;
		$seo_data='';
		$this->data['tab_type']="list";
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
		->build('v_list', $this->data);
	}
	public function get_fuel_coupen_list_details(){

		$data = $this->fuel_mdl->get_all_coupen_details_list();
		    // echo "<pre>"; print_r($data); die();
		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);
		foreach($data as $row)
		{
			if($row->fude_isassigned=='Y'){
				$status='Y';
			}else{
				$status='N';
			}

			$array[$i]["sno"] = $i+1;
			$array[$i]["coupenno"] = $row->fude_coupenno;
			$array[$i]["type"] = $row->futy_name;
			$array[$i]["month"] = $row->mona_namenp;
			$array[$i]["fyear"] = $row->fuel_fyear;
			$array[$i]["validdate"] = $row->fuel_expdatebs;
			$array[$i]["staffname"] = $row->stin_fname.'  '.$row->stin_lname;
			$array[$i]["isassigned"] = $status;

			$view = '<a href="javascript:void(0)" data-id='.$row->fude_fuelcoupendetailsid.' data-displaydiv="FormAssign" data-viewurl='.base_url('fuel/fuel/user_assign_popup/').' class="view  btn-xxs" data-heading="Assigned Coupen " ><i class="fa fa-eye" aria-hidden="true" ></i></a>';

			$entry = '<a href="javascript:void(0)" data-id='.$row->fude_fuelcoupendetailsid.' data-displaydiv="FormAssign" data-viewurl='.base_url('fuel/fuel/coupen_entery_popup/').' class="view  btn-xxs" data-heading="Coupen Entry " ><i class="fa fa-book" aria-hidden="true" ></i></a>';

			if($row->fude_isassigned=='Y'){
				$array[$i]["action"]=$view.'|'.$entry;
			}
			else{
				$array[$i]["action"]=$view;

			}

			$i++;

		}
		echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}
	public function staffDetails()

	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST')

		{
			$id=$this->input->post('staffid');

			$this->data['staff_data']=$this->fuel_mdl->get_all_staff_manager(array('stin_staffinfoid'=>$id));
			$this->data['Cur_staff_data'] = $this->fuel_mdl->get_fuel_details(array('fude_staffid'=>$id),false,1,false,false);
			$this->data['pre_staff_data']=$this->fuel_mdl->get_fuel_details(array('fude_staffid'=>$id),false,false,'fude_fuelcoupendetailsid','DESC');

			$tempform='';
			$tempform .=$this->load->view('fuel/v_staff_details',$this->data,true);
			$tempform .=$this->load->view('fuel/v_staff_history',$this->data,true);

			if(!empty($this->data['staff_data']))
			{

				print_r(json_encode(array('status'=>'success','message'=>'You Can View','tempform'=>$tempform)));

				exit;

			}

			else{

				print_r(json_encode(array('status'=>'error','message'=>'')));

				exit;

			}

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

			exit;

		}
	}
	public function coupen_print()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				if($id)
				{ 
					$this->data['details'] = $this->fuel_mdl->get_fuel_details(array('fude_fuelcoupendetailsid'=>$id),false,false,false,false);
			 // echo"<pre>";print_r($this->data['details']);die;

					$template=$this->load->view('fuel/v_fuel_coupen_print',$this->data,true);


					if($this->data['details']>0)
					{
						print_r(json_encode(array('status'=>'success','message'=>'','tempform'=>$template)));
						exit;
					}
					else{
						print_r(json_encode(array('status'=>'error','message'=>'')));
						exit;
					}
					print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','tempform'=>$template)));
					exit;	
				}
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
			}
		}else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}
	public function fuel_coupen_entry()
	{
		
		
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		$this->data['fuel_list']=$this->general->get_tbl_data('*','futy_fueltype',false,'futy_typeid','DESC');
		$this->data['month']=$this->general->get_tbl_data('*','mona_monthname',false,'mona_monthid','ASC');
		$this->data['staff_all'] =$this->general->get_tbl_data('*','stin_staffinfo',false,'stin_staffinfoid','ASC');
		$this->data['unit']=$this->general->get_tbl_data('*','unit_unit',array('unit_isactive'=>'Y'));
		$seo_data='';
		$this->data['tab_type']="Coupen_entry";
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
		->build('v_entry_coupen', $this->data);
	}
	public function form_coupen_entry(){
		$this->load->view('v_entry_coupen');

	}
	public function save_Coupen()
	{
		// print_r($this->input->post());
		// die();
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			try {
				$this->form_validation->set_rules($this->fuel_mdl->validate_settings_fuel_list);
				
				if($this->form_validation->run()==TRUE)
				{
					$trans = $this->fuel_mdl->coupen_save();
					

					if($trans)
					{
						print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
						exit;
					}
					else
					{
						print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
						exit;
					}
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
					exit;
				}
			} 
			catch (Exception $e) 
			{
				
				print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
			}
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}
	public function coupen_entery_popup(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {


			$id=$this->input->post('id');

			$this->data['staff_all'] =$this->general->get_tbl_data('*','stin_staffinfo',false,'stin_staffinfoid','ASC');

			$this->data['fuel_data'] = $this->fuel_mdl->get_fuel_details(array('fude_fuelcoupendetailsid'=>$id),false,false,false,false);
			$staffid=$this->data['fuel_data'][0]->fude_staffid;

			$this->data['staff_data']=$this->fuel_mdl->get_all_staff_manager(array('stin_staffinfoid'=>$staffid));
			
			$this->data['Cur_staff_data'] = $this->fuel_mdl->get_fuel_details(array('fude_staffid'=>$staffid),false,1,false,false);
			$this->data['pre_staff_data']=$this->fuel_mdl->get_fuel_details(array('fude_staffid'=>$staffid),false,false,'fude_fuelcoupendetailsid','DESC');

			$tempform=$this->load->view('fuel/v_coupen_entry',$this->data,true);
		// echo $tempform;
		// die();
			if(!empty($this->data['fuel_data']))
			{
				print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$tempform)));
				exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Unable to view!!')));
				exit;
			}
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}

	}

	
}
/* End of file welcome.php */
				/* Location: ./application/controllers/welcome.php */