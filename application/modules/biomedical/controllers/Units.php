<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Units extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->Model('units_mdl');
		
	}
	
	public function index()
	{
		
		$this->data['units_all']=$this->units_mdl->get_all_units();
// echo "<pre>";
	// print_r($this->data['units_all']);
	// die();
	$this->data['editurl']=base_url().'settings/units/editunits';
	$this->data['deleteurl']=base_url().'settings/units/deleteunits';
	$this->data['listurl']=base_url().'settings/units/listunits';
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
	->build('units/v_units', $this->data);
	}
	public function form_units()
	{
	     
	        $this->data['units_all']=$this->units_mdl->get_all_units();
	$this->load->view('units/v_units_form',$this->data);
	}
	public function listunits()
	{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$this->data['units_all']=$this->units_mdl->get_all_units();
	$template=$this->load->view('units/v_units_list',$this->data,true);
	print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	    exit;
	}
	else
	{
	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
	}
	}
	public function save_units()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
		try
		{
		$id=$this->input->post('id');
		// if($id)
		// {
		// $this->form_validation->set_rules($this->units_mdl->validate_settings_menu_edit);
		// }
		// else
		// {
		$this->form_validation->set_rules($this->units_mdl->validate_settings_units);
		// }
		
		  if($this->form_validation->run()==TRUE)
		 {
		            $trans = $this->units_mdl->units_save();
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
	public function editunits()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$id=$this->input->post('id');
		$this->data['units_all']=$this->units_mdl->get_all_units();
		
		$this->data['units_data']=$this->units_mdl->get_all_units(array('unit_unitid'=>$id));
		// echo "<pre>";
			// print_r($this->data['units_all']);
			// die();
			$tempform=$this->load->view('units/v_units_form',$this->data,true);
			// echo $tempform;
			// die();
			if(!empty($this->data['units_data']))
			{
			print_r(json_encode(array('status'=>'success','message'=>'You Can edit','tempform'=>$tempform)));
			            exit;
			}
			else{
			print_r(json_encode(array('status'=>'error','message'=>'Unable to Edit!!')));
			            exit;
			}
			}
			else
			{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			        exit;
			}
	}
	public function deleteunits()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id=$this->input->post('id');
			//print_r($id);die;
			$trans=$this->units_mdl->remove_units();
			if($trans)
			{
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Deleted!!')));
			        exit;
			}
			else
			{
			print_r(json_encode(array('status'=>'error','message'=>'Error while deleting!!')));
			        exit;
			}
		}
	}
	public function exists_unitname()
	{
		$unitsname=$this->input->post('unit_unitname');
		$id=$this->input->post('id');
		$unitsnamechk=$this->units_mdl->check_exist_unitname_for_other($unitsname,$id);
		if($unitsnamechk)
		{
		$this->form_validation->set_message('exists_unitname', 'Already Exist modulekey!');
		return false;
		}
		else
		{
		return true;
		}
	}
	public function units_list()
	{  
		$data = $this->units_mdl->get_all_units_list();
		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		//print_r($filtereddata);die;
		$totalrecs = $data["totalrecs"];
		    unset($data["totalfilteredrecs"]);
		  unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {  
			    $array[$i]["unit_unitid"] = $i; 
			    $array[$i]["unit_unitname"] = $row->unit_unitname;       
			    $array[$i]["unit_postdatebs"] = $row->unit_postdatebs;
			    if($row->unit_isactive=='Y'){ $status="Active"; }else{
			      $status= "Inactive"; }
			    $array[$i]["unit_isactive"] = $status;
			 
				 $array[$i]["action"] ='<a href="javascript:void(0)" 
				 data-id='.$row->unit_unitid.' data-displaydiv="units"
				 data-editurl='.base_url('biomedical/units/editunits').' class="btnEdit" ><i class="fa fa-edit" aria-hidden="true" ></i></a>|
				 <a href="javascript:void(0)"  data-id='.$row->unit_unitid.' data-deleteurl='. base_url('biomedical/units/deleteunits') .' class="btnDelete"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>';
			
			$i++;
		        //(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');
		    }
		    echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
}
		/* End of file welcome.php */
		/* Location: ./application/controllers/welcome.php */