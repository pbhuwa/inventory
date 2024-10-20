<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Permission extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('permission_mdl');
		$this->load->Model('department_mdl');
		$this->load->Model('group_mdl');
		$this->load->Model('menu_mdl');
		$this->orgid=$this->session->userdata(ORG_ID);
		$this->locationid = $this->session->userdata(LOCATION_ID);
     	$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
		
		
	}
	
	

	public function index()
	{
		
		$locationid = $this->session->userdata(LOCATION_ID);
		$location_ismain = $this->session->userdata(ISMAIN_LOCATION);
		// echo $location_ismain;
		// die();
		if($location_ismain == 'Y')
		{
			$this->data['group_all']=$this->group_mdl->get_all_group();
			$this->data['location_all'] =$this->general->get_tbl_data('*','loca_location',false,'loca_locationid','ASC');

		}else{
			// echo $this->db->last_query();
			// die();
			$this->data['group_all']=$this->group_mdl->get_all_group(array('usgr_locationid'=>$locationid));
			$this->data['location_all'] =$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$locationid),'loca_locationid','ASC');

		}
		$this->data['location_ismain']=$location_ismain;
		$this->data['current_location']=$locationid;
		
		
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
			->build('permission/v_permission_main_new', $this->data);
	}



	

	
	public function save_per()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$id=$this->input->post('id');
			
            $trans = $this->permission_mdl->save_perm();
            if($trans)
            {
            	 echo "Record Saved Successfully";
            }
            else
            {
            	echo "Operation Unsuccessful";
            }
           
        } catch (Exception $e) {
          
           echo $e->getMessage();
        }
    }
 else
    {
    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
    }

}


public function save_permission()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$id=$this->input->post('id');
			
            $trans = $this->permission_mdl->save_all_permission();
            $rslt= $this->general->select_menu_link_from_db();
			if(!empty($rslt)){
				$this->general->generate_menu_link('update');	
			}else{
				$this->general->generate_menu_link();	
			}
					
            if($trans){
			print_r(json_encode(array('status'=>'success','message'=>'Saved Success!!')));
       		 exit;	
		}
		else{
			print_r(json_encode(array('status'=>'error','message'=>'Operation Fail!!')));
       		 exit;	
		}
           
        } catch (Exception $e) {
          
           echo $e->getMessage();
        }
    }
 else
    {
    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
    }

}


public function update_per_operation()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$id=$this->input->post('id');
			
            $trans = $this->permission_mdl->update_perm();
            // echo $this->db->last_query();
            // die();
            if($trans)
            {
            	 echo "Record Saved Successfully";
            }
            else
            {
            	echo "Operation Unsuccessful";
            }
           
        } catch (Exception $e) {
          
           echo $e->getMessage();
        }
    }
 else
    {
    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
    }

}
   public function get_actual_form(){
			// error_reporting(0);
	$modid=$this->input->post('modid');
	$this->data['menu_list_all']=$this->general->get_menu(array('modu_parentmodule'=>'0'));
	if($modid)
	{
		$this->data['menu_list']=$this->general->get_menu(array('modu_parentmodule'=>$modid));
	}
	else
	{
		$this->data['menu_list']=$this->general->get_menu(array('modu_parentmodule'=>'0'));
	}
	$this->data['group_all']=$this->group_mdl->get_all_group();
	$data=$this->permission_mdl->gets_permission();
			// echo "<pre>";
			// print_r($this->data['menu_list']);
			// die();
	$p=array();
	if(count($data))
	{
		foreach($data as $d){
			if(!isset($p[$d->mope_moduleid]) || !is_array($p[$d->mope_moduleid]))
				$p[$d->mope_moduleid]=array();
			
			$p[$d->mope_moduleid][$d->mope_usergroupid]=$d->mope_hasaccess;
		}
	}
	$this->data['p']=$p;
	$this->load->view('permission/v_permission_form', $this->data);
	
	}

	public function module_form()
	{
		$this->data['groupid']=$this->input->post('grpid');
		// echo $this->data['groupid'];
		// die();
		$this->load->view('permission/v_permission_form_new', $this->data);
	}

	public function form_permission()
	{
		$locationid = $this->session->userdata(LOCATION_ID);
		$location_ismain = $this->session->userdata(ISMAIN_LOCATION);
		if($location_ismain == 'Y')
		{
			$this->data['group_all']=$this->group_mdl->get_all_group(array('usgr_orgid'=>$this->orgid));
			$this->data['location_all'] =$this->general->get_tbl_data('*','loca_location',false,'loca_locationid','ASC');

		}else{
			// echo $this->db->last_query();
			// die();
			$this->data['group_all']=$this->group_mdl->get_all_group(array('usgr_locationid'=>$locationid));
			$this->data['location_all'] =$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$locationid),'loca_locationid','ASC');

		}
		$this->data['location_ismain']=$location_ismain;
		$this->data['current_location']=$locationid;

		$this->load->view('permission/v_permission_main_form', $this->data);
	}

	public function copy_permission()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// echo "test";
			// die();
			$this->data['group_id']=$this->input->post('id');
			if($this->location_ismain == 'Y')
			{
				$this->data['group_all']=$this->group_mdl->get_all_group();
				$this->data['location_all'] =$this->general->get_tbl_data('*','loca_location',false,'loca_locationid','ASC');

			}else{
				// echo $this->db->last_query();
				// die();
				$this->data['group_all']=$this->group_mdl->get_all_group(array('usgr_locationid'=>$this->locationid));
				$this->data['location_all'] =$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$this->locationid),'loca_locationid','ASC');

			}

			$this->data['location_ismain']=$this->location_ismain;
			$this->data['current_location']=$this->locationid;
			

			$this->data['org_list']=$this->general->get_tbl_data('*','orga_organization',array('orga_isactive'=>'Y'),'orga_orgid','ASC');
			// $this->load->view('group/v_groupform',$this->data);
			$tempform=$this->load->view('group/v_groupform_clone',$this->data,true);
		
			if(!empty($tempform))
			{
					print_r(json_encode(array('status'=>'success','message'=>'You Can edit','tempform'=>$tempform)));
	            	exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Unable to Edit!!')));
	            	exit;
			}

		}
 	else{
    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
	}

		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */