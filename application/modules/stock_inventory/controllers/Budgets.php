<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Budgets extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->Model('budgets_mdl');
		$this->locationid = $this->session->userdata(LOCATION_ID);
     	$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
     	$this->mattypeid = $this->session->userdata(USER_MAT_TYPEID);
	}
	
	public function index()
    {
	   $srchmat = array('maty_isactive' => 'Y');
    // echo "hello";
    // die;
		//$this->data['budgets_all'] = $this->budgets_mdl->get_all_budgets();
		$this->data['editurl']=base_url().'stock_inventory/budgets/editbudgets';
		$this->data['deleteurl']=base_url().'stock_inventory/budgets/deletebudgets';
		 $this->data['listurl']=base_url().'stock_inventory/budgets/list_of_budgets';
		  $this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');
		 // print_r($this->data['material_type']);
		 // die();
	//	$this->data['budgets']=$this->general->get_tbl_data('*','budg_budgets',false,'budg_budgetid','ASC');
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
			->build('budgets/v_budgets', $this->data);
	}
	
	public function form_budgets()
	{
		 $srchmat = array('maty_isactive' => 'Y');
		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material','maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');
		 $this->data['editurl']=base_url().'stock_inventory/budgets/editbudgets';
		 $this->data['deleteurl']=base_url().'stock_inventory/budgets/deletebudgets';
		 $this->data['listurl']=base_url().'stock_inventory/budgets/list_of_budgets';
	     $this->load->view('budgets/v_budgets_form',$this->data);
	}
	
	public function save_budgets()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$id=$this->input->post('id');
			if($this->input->post('id'))
			{
				if(MODULES_UPDATE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			}
			else
			{
				if(MODULES_INSERT=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			}
			$this->form_validation->set_rules($this->budgets_mdl->validate_settings_budgets);
			  if($this->form_validation->run()==TRUE)
			 {
        	 $trans = $this->budgets_mdl->save_budgets();
            if($trans)
            {
            	  print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
            	exit;
            }
            else
            {
            	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessfully')));
            	exit;
            }
        }
        else
		{
			print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
				exit;
		}
        } catch (Exception $e) {
            print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
        }
    }
 else
    {
    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
    }
}
	
	public function list_of_budgets()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_VIEW=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			$data=array();
			$data['budgets_data']=$this->general->get_tbl_data('*','budg_budgets',false,'budg_budgetid','ASC');	
			$template=$this->load->view('budgets/v_budgets_list',$data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}
	
	public function editdebudgets()
	{   
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_UPDATE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
		    $id=$this->input->post('id');
		     $srchmat = array('maty_isactive' => 'Y');
	  		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');
		    $this->data['budgets_data']=$this->general->get_tbl_data('*','budg_budgets',array('budg_budgetid'=>$id),false,'false');
		// echo "<pre>";print_r($this->data['budgets_data']);die;
			$tempform = $this->load->view('budgets/v_budgets_form',$this->data,true);
			if(!empty($this->data['budgets_data']))
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
	
	public function deletedebudgets()
    {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_DELETE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			$id=$this->input->post('id');
			$trans=$this->budgets_mdl->remove_budgets();
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
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

public function get_budgets_list()
	{
		if(MODULES_VIEW=='N')
			{
			  	$array=array();
                echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));
                exit;
			}
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		$orgid = $this->session->userdata(ORG_ID);
		$data = $this->budgets_mdl->get_budgets_list();
		 // echo "<pre>";print_r($data);die;
	  	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  	//echo "<pre>";print_r($data);die;
	 	foreach($data as $row)
	    {
		   $array[$i]["budg_budgetname"] = $row->budg_budgetname;
	       $array[$i]["budg_code"] = "";
	       $array[$i]["maty_material"] = $row->maty_material;
	       $array[$i]["budg_budgetid"] = $row->budg_budgetid;
	       $array[$i]["is_active"] = $row->budg_isactive;
            if(MODULES_DELETE=='Y'){
		    $deletebtn= '<a href="javascript:void(0)" data-id='.$row->budg_budgetid.' data-tableid='.($i+1).' data-deleteurl='. base_url('stock_inventory/budgets/deletedebudgets') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>';	
		    }else{
		    	$deletebtn='';
		    }  
		    if(MODULES_UPDATE=='Y'){
		    $editbtn= '<a href="javascript:void(0)" data-id='.$row->budg_budgetid.' data-displaydiv="budgets" data-viewurl='.base_url('stock_inventory/budgets/editdebudgets').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>';
			}
			else{
				$editbtn='';
			}
		    $array[$i]["action"] =$editbtn.' | '.$deletebtn;
		    $i++;
		    }
        	echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

public function exists_budgetsname()
    {
        $budgetname=$this->input->post('budg_budgetname');
        $id=$this->input->post('id');
        $budgetnamechk=$this->budgets_mdl->check_exist_budgets_for_other($budgetname,$id);
        if($budgetnamechk)
        {
            $this->form_validation->set_message('exists_budgetsname', 'Already Exist Budgets Name !!');
            return false;
        }
        else
        {
            return true;
        }
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */