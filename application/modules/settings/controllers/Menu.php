<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('menu_mdl');
		
		
	}
	
	

	public function index()
	{
		
		

		// $this->data['menu_list']=$this->general->get_menu();
		// $this->data['menu_list']=$this->menu_mdl->menu_adjacency(0, 0, 0, 0);
		// echo "<pre>";
		// echo $this->data['menu_list'];
		// die();
	
		$this->data['menu_all']=$this->menu_mdl->get_all_menu(array('m.modu_orgid'=>$this->session->userdata(ORG_ID)));
		
		$this->data['editurl']=base_url().'settings/menu/editmenu';
		$this->data['deleteurl']=base_url().'settings/menu/deletemenu';
		$this->data['listurl']=base_url().'settings/menu/listmeu';
		
		
		// echo "<pre>";
		// print_r($this->data['menu_all']);
		// die();
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
			->build('menu/v_menu', $this->data);
	}

	public function form_menu()
	{
		$this->data['menu_list']=$this->general->get_menu(array('modu_orgid'=>$this->session->userdata(ORG_ID)));
		$this->load->view('menu/v_menuform',$this->data);
	}

	public function save_menu()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$id=$this->input->post('id');
			if($id)
			{
					$this->data['menu_data']=$this->menu_mdl->get_all_menu(array('m.modu_moduleid'=>$id));
				// echo "<pre>";
				// print_r($data['dept_data']);
				// die();
			if($this->data['menu_data'])
			{
				$dep_date=$this->data['menu_data'][0]->modu_postdatead;
				$dep_time=$this->data['menu_data'][0]->modu_posttime;
				$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
				$usergroup=$this->session->userdata(USER_GROUPCODE);
				
				if($editstatus==0 && $usergroup!='SA' )
				{
					   $this->general->disabled_edit_message();

				}

			}
			}
			$this->form_validation->set_rules($this->menu_mdl->validate_settings_menu);
			// }
			
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->menu_mdl->menu_save();
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


public function editmenu()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		
    			if(MODULES_UPDATE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
		$id=$this->input->post('id');
		$this->data['is_copy']='';
		if(!empty($id)){
			$iscopy = strpos($id, 'copy');
			if($iscopy==true){
				$this->data['is_copy']='copy';
			}
		}
		$this->data['menu_list']=$this->general->get_menu(array('modu_orgid'=>$this->session->userdata(ORG_ID)));
	
		$this->data['menu_data']=$this->menu_mdl->get_all_menu(array('m.modu_moduleid'=>$id));
		// echo "<pre>";
		// print_r($this->data['menu_all']);
		// die();

		if($this->data['menu_data'])
		{
			$dep_date=$this->data['menu_data'][0]->modu_postdatead;
			$dep_time=$this->data['menu_data'][0]->modu_posttime;
			$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
			// echo $editstatus;
			// die();
			$this->data['edit_status']=$editstatus;

		}
		$tempform=$this->load->view('menu/v_menuform',$this->data,true);
		// echo $tempform;
		// die();
		if(!empty($this->data['menu_data']))
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

public function deletemenu()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		if(MODULES_DELETE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
		$id=$this->input->post('id');
		$submenu=$this->menu_mdl->get_all_menu(array('m.modu_parentmodule'=>$id));
		if($submenu)
		{
			print_r(json_encode(array('status'=>'error','message'=>'You cannot delete this menu !!')));
       		 exit;	
		}

		$trans=$this->menu_mdl->remove_menu();
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

	public function listmeu()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$data['menu_all']=$this->menu_mdl->get_all_menu(array('m.modu_orgid'=>$this->session->userdata(ORG_ID)));
			$template=$this->load->view('menu/v_menu_list',$data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}
	

	public function exists_modulekey()
	{
		$module_key=$this->input->post('modu_modulekey');
		$id=$this->input->post('id');
		$modulekey=$this->menu_mdl->check_exist_module_for_other($module_key,$id);
		if($modulekey)
		{
			$this->form_validation->set_message('exists_modulekey', 'Already Exist modulekey!');
			return false;

		}
		else
		{
						return true;
		}
	}


	public function menu_order()
	{
		$this->data['menus']=$this->menu_mdl->getAllMenusOrder();

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
			->build('menu/v_menu_order', $this->data);


	}

	public function ajax_order(){
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
				$this->menu_mdl->updateAllMenusOrder();
				return true;
			else :
				echo "Cann't Update";
				// $this->view->render('error/index');
			endif;
		}

	

		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */