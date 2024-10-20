<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Assign_assets extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('Assign_assets_mdl');
		$this->load->Model('Assets_mdl');


		// $this->load->Model('equipment_mdl');
		// $this->load->Model('bio_medical_mdl');
		// $this->load->Model('repair_request_info_mdl');
		//  $this->load->Model('purchase_donate_mdl');
		// $this->load->Model('settings/department_mdl','department_mdl');
		
	}

	public function index()
    {

    	$org_id = $this->session->userdata(ORG_ID); 

		//$this->data['material']=$this->Assets_mdl->get_all_assets();
		$this->data['material']=$this->Assets_mdl->get_assets_category();
		//echo "<pre>";print_r($this->data['material']);die;
		$seo_data='';
		if($seo_data)
		{
			$this->page_title = $seo_data->page_title;
			$this->data['meta_keys']= $seo_data->meta_key;
			$this->data['meta_desc']= $seo_data->meta_description;
		}
		else
		{
		    $this->page_title = ORGA_NAME;
		    $this->data['meta_keys']= ORGA_NAME;
		    $this->data['meta_desc']= ORGA_NAME;
		}
		
		$this->data['tab_type']='assign';


		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('assign_assets/v_assign_assets', $this->data);
	}

	public function get_assets_desc_from_assets_type()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    	{
    		$tempform='';
    		$id=$this->input->post('assetsid');

			if(!empty($id))
		 	{
		 	$this->load->model('assets_mdl');
		 	$assets_desc_list=$this->assets_mdl->get_assets(array('eq.itli_catid'=>$id));


		 	// echo "<pre>";
		 	// print_r($assets_desc_list);
		 	// die();

		 	if($id)
		 	{
		 		$srch=array('asen_assettype'=>$id);	
		 	}
		 	$srch="asen_assettype=$id AND ae.asen_asenid NOT IN( SELECT eqas_equipid FROM xw_eqas_equipmentassign WHERE eqas_orgid='2')";

		 	$this->data['assets_list']=$this->assets_mdl->get_assets_list_data($srch);

		 	// echo $this->db->last_query();
		 	// die();
		 	// echo "<pre>";
		 	// print_r($this->data['assets_list']);
		 	// die();
		 	$this->data['assetsid']=$id;
		 	$assets_dec_template='';
		 	if(!empty($assets_desc_list))
		 	{
		 		$assets_dec_template='<option value="">---select---</option>';
		 		foreach ($assets_desc_list as $kr => $list):
		 		$assets_dec_template.='<option value="'.$list->itli_itemlistid.'">'.$list->itli_itemname.'</option>';	
		 		endforeach;
		 		
		 	}
		 	$tempform=$this->load->view('assign_assets/v_descwise_assets',$this->data,true);
		 	
		 	print_r(json_encode(array('status'=>'success','tempform'=>$tempform,'room_template'=>$assets_dec_template,'message'=>'Can perform operation')));
	        exit;
	    }
	 }
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
    }

	public function get_assets_detail()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
		$this->load->model('biomedical/Staff_info_mdl');
		// $this->load->Model('Assets_mdl');

		$this->data=array();
		$id = $this->input->post('assetsid');
		$depid=$this->input->post('assetstypeid');
		$roomid=$this->input->post('assetsdesid');
		$tempform='';
		$this->data['is_multiple']='N';

		// if(!empty($depid) && empty($roomid))
		// {
			$same_srch=array('stin_departmentid'=>$depid,'stin_jobstatus'=>'1');
			$diff_srch=array('stin_departmentid !='=>$depid,'stin_jobstatus'=>'1');
		// }
		// else if(!empty($depid) && !empty($roomid))
		// {
			// $srch=array('stin_departmentid'=>$depid,'stin_roomid'=>$roomid);
		// }
		// $this->data['equipid']=$id;
		$this->data['assets_data']=$this->Assets_mdl->get_assets_list_data(array('asen_asenid'=>$id));
		$this->data['assetsid']=$id;


		$this->data['department_staff_list']=$this->Staff_info_mdl->get_all_staff_info();
		// echo "<pre>";print_r($this->data['department_staff_list']);die;


		$this->data['same_department_staff_list']=$this->Staff_info_mdl->get_all_staff_info($same_srch);

		
		$this->data['different_department_staff_list']=$this->Staff_info_mdl->get_all_staff_info($diff_srch);
		// echo "<pre>";print_r($this->data['biomedical_data']);die;
		$tempform.=$this->load->view('assign_assets/v_assets_detail_view',$this->data,true);

		$tempform.=$this->load->view('assign_assets/v_assign_staff',$this->data,true);
		if(!empty($tempform))
			{
					print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$tempform)));
	            	exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));
	            	exit;
			}
		}

		 else
	    {
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	            exit;
	    }
	}

	public function assets_assign_multiple()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$this->load->model('biomedical/Staff_info_mdl');
		$this->data=array();
		$id = $this->input->post('id');
		$depid=$this->input->post('depid');
		$tempform='';
		$ids=implode(',', $id);

		
		// echo "<pre>";
		// print_r($id);
		// print_r($depid);

		// die();


		$this->data['assets_list']=$this->Assets_mdl->get_assets_list_data("asen_asenid IN ($ids)");
		// echo $this->db->last_query();
		// die();
		// echo "<prE>";
		// print_r($this->data['assets_list']);
		// die();

		$same_srch=array('stin_departmentid'=>$depid,'stin_jobstatus'=>'1');
		$diff_srch=array('stin_departmentid !='=>$depid,'stin_jobstatus'=>'1');
		$this->data['assetsid']=$ids;
		$this->data['same_department_staff_list']=$this->Staff_info_mdl->get_all_staff_info($same_srch);
		$this->data['different_department_staff_list']=$this->Staff_info_mdl->get_all_staff_info($diff_srch);
		$this->data['is_multiple']='Y';
		$tempform.=$this->load->view('assign_assets/v_descwise_assets',$this->data,true);
		$tempform.=$this->load->view('assign_assets/v_assign_staff',$this->data,true);


		if(!empty($tempform))
			{
					print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$tempform)));
	            	exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));
	            	exit;
			}
		}

		 else
	    {
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	            exit;
	    }
	}

	public function get_staff()
	{
		
		// $this->data['department_staff_list']=$this->Staff_info_mdl->get_all_staff_info();	

		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			$this->load->model('biomedical/Staff_info_mdl');

				$staffcode=$this->input->post('staffcode');
				if(!empty($staffcode))
				{
				 	
				 	$this->data['department_staff_list']=$this->Staff_info_mdl->get_all_staff_info(array('st.stin_code'=>$staffcode));
				 	// echo $this->db->last_query();
				 	// die();
				 	// echo "<pre>"; print_r($this->data['department_staff_list']);die;
				 	echo json_encode($this->data['department_staff_list']);
				}
				else{
				 	echo json_encode(array());
				}
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
			}

		// echo "<pre>";
		// print_r($this->data['department_staff_list']);
		// die();
	}

	public function save_assets_assign()
	{

		// echo "Check Save";
		// die();



		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
			{
			$postdata=$this->input->post();
			// echo "<pre>";
			// print_r($postdata);
			// die();


			 $trans = $this->Assign_assets_mdl->assign_assets_save();
            if($trans)
            {
            	print_r(json_encode(array('status'=>'success','message'=>'Assign Successfully!!')));
            	exit;
            }
            else
            {
            	 print_r(json_encode(array('status'=>'error','message'=>'Assingn Unsuccessfully!!')));
            	exit;
            }
		}
		else
	    {
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation!!')));
	            exit;
	    }
	}

	public function assign_assets_list($result=false,$orgid=false)
	{
		// echo "Check Hello";
		// die();

		if(MODULES_VIEW=='N')
			{
			 	$array['equipkey'] = '';
			 	$array['assign_to'] = '';
			 	$array['assign_by'] = '';
			 	$array['assign_date'] = '';
			 	$array['depname'] = '';
			 	$array['roomname'] = '';
			 	$array['action'] = '';
			   
			 // $this->general->permission_denial_message();
			 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
			}
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		}

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		if($orgid){
			$org_id=$orgid;
		}
		else
		{
			$org_id = $this->session->userdata(ORG_ID); 

			// print_r($org_id);
			// die();
		}
		if($useraccess == 'B')
		{
			if($orgid)
			{
				$srchcol=array('eqas_orgid'=>$org_id);
			}
			else
			{
				$srchcol='';
			}

			$this->data = $this->Assign_assets_mdl->get_assign_assets($srchcol);
		}

		else
		{
			$cond = array('eqas_orgid'=>$org_id);
			$this->data = $this->Assign_assets_mdl->get_assign_assets($cond);

			// echo "<pre>";
			// print_r($this->data);
			// die();
		}
		// print_r($org_id);die;

		if($result == 'cur') {
			$cond=array('eqas_assigndatead'=>date("Y/m/d"), 'eqas_orgid'=>$org_id);
			$this->data = $this->Assign_assets_mdl->get_assign_assets($cond);
			//echo "<pre>";print_r($this->data);die();
		}
		
	  	$i = 0;
		$array = array();
		$filtereddata = ($this->data["totalfilteredrecs"]>0?$this->data["totalfilteredrecs"]:$this->data["totalrecs"]);
		$totalrecs = $this->data["totalrecs"];

	    unset($this->data["totalfilteredrecs"]);
	  	unset($this->data["totalrecs"]);
	  
		  	foreach($this->data as $row)
		    {
		   
			    $array[$i]["equipkey"] = '<a href="javascript:void(0)" class="patlist" data-equipid='.$row->asen_assetcode.'>'.$row->asen_assetcode.'</a>';
			    $array[$i]["assign_to"] = $row->stin_fname.' '.$row->stin_lname;
			    $array[$i]["assign_by"] = $row->usma_username;
			    if(DEFAULT_DATEPICKER=='NP')
			    {
			    	 $array[$i]["assign_date"] = $row->eqas_postdatebs;
			    }
			    else
			    {
			    	  $array[$i]["assign_date"] = $row->eqas_postdatead;	
			    }
			    $array[$i]["depname"] = $row->eqca_category;
			    $array[$i]["roomname"] = $row->itli_itemname;
			    $array[$i]["action"]='';
			    // $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->eqas_equipmentassignid.' data-displaydiv="Distributer" data-viewurl='.base_url('biomedical/manufacturers/view_manufacturers').' class="view" ><i class="fa fa-eye" aria-hidden="true" ></i></a>			    ';
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}



}