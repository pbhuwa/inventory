<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Manufacturers extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('manufacturers_mdl');
		$this->load->Model('distributors_mdl');
		$this->load->Model('service_techs_mdl');
	}

	public function index()
	{
		//$this->data['manufacturers_list']=$this->manufacturers_mdl->get_all_manufacturers();
		$this->data['country_list']=$this->general->get_tbl_data('*','coun_country',false,'coun_countryname',$order_by='ASC');
		$this->data['service_techlist']=$this->service_techs_mdl->get_all_service_techs();
		$this->data['distributor_list']=$this->distributors_mdl->get_distributor_list();

		// echo '<pre>';print_r($this->data['manufacturers_list']); die();

		$this->data['editurl']=base_url().'biomedical/manufacturers/editmanufacturers';
		$this->data['deleteurl']=base_url().'biomedical/manufacturers/deletemanufacturers';
		$this->data['listurl']=base_url().'biomedical/manufacturers/list_manufacturers';
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
			->build('manufacturers/v_manufacturers', $this->data);
	}
	public function list_manufacturers()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_VIEW=='N')
			{
			$this->general->permission_denial_message();
			exit;
			}
			$this->data=array();
			$template=$this->load->view('manufacturers/v_manufacturers_list',$this->data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function form_manufacturers()
	{
		$this->data['country_list']=$this->general->get_tbl_data('*','coun_country',false,'coun_countryname',$order_by='ASC');
		$this->data['service_techlist']=$this->service_techs_mdl->get_all_service_techs();
		$this->data['distributor_list']=$this->distributors_mdl->get_distributor_list();
		$this->load->view('manufacturers/v_manufacturersform',$this->data);
	}
	
    public function get_all_manufacturers($result=false,$org_id=false)
	{  

        $this->data['result']=$result;
        $this->data['org_id']=$org_id;
		$this->load->view('manufacturers/v_manufacturers_list', $this->data);
	}
	public function save_manufacturers()
	{   
		// echo '<pre>';
		// print_r($this->input->post());
		// die();
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			// if($this->input->post('id'))
			// {
			// 	if(MODULES_UPDATE=='N')
			// 	{
			// 	$this->general->permission_denial_message();
			// 	exit;
			// 	}
			// }
			// else
			// {
			// 	if(MODULES_INSERT=='N')
			// 	{
			// 	$this->general->permission_denial_message();
			// 	exit;
			// 	}
			// }
			$id = $this->input->post('id');
			if($id)
			{
				$this->data['manufacturers_data']=$this->manufacturers_mdl->get_all_manufacturers(array('manu_manlistid'=>$id));
				// echo "<pre>";
				// print_r($this->data['dept_data']);
				// die();
				if($this->data['manufacturers_data'])
				{
					$dep_date=$this->data['manufacturers_data'][0]->manu_postdatead;
					$dep_time=$this->data['manufacturers_data'][0]->manu_posttime;
					$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
					$usergroup=$this->session->userdata(USER_GROUPCODE);
					
					if($editstatus==0 && $usergroup!='SA' )
					{
						$this->general->disabled_edit_message();

					}

				}
			}

			 $this->form_validation->set_rules($this->manufacturers_mdl->validate_settings_manufacturers);
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->manufacturers_mdl->manufacturers_save();
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


	public function editmanufacturers()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_UPDATE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}

			$id=$this->input->post('id');
		
			$this->data['manufacturers_data']=$this->manufacturers_mdl->get_all_manufacturers(array('manu_manlistid'=>$id));
			$this->data['manufacturers_list']=$this->manufacturers_mdl->get_all_manufacturers();
			$this->data['country_list']=$this->general->get_tbl_data('*','coun_country',false,'coun_countryname',$order_by='ASC');
			$this->data['service_techlist']=$this->service_techs_mdl->get_all_service_techs();
			$this->data['distributor_list'] = $this->distributors_mdl->get_distributor_list();
			// echo "<pre>";
			// print_r($this->data['service_techlist']);
			// die();
			if($this->data['manufacturers_data'])
		{
			$dep_date=$this->data['manufacturers_data'][0]->manu_postdatead;
			$dep_time=$this->data['manufacturers_data'][0]->manu_posttime;
			$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
			// echo $editstatus;
			// die();
			$this->data['edit_status']=$editstatus;

		}
			$tempform = $this->load->view('manufacturers/v_manufacturersform',$this->data,true);
			// echo $tempform;
			// die();
			if(!empty($this->data['manufacturers_data']))
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

	public function deletemanufacturers()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_DELETE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}

			$id=$this->input->post('id');
			$trans=$this->manufacturers_mdl->remove_manufacturers();
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

	public function view_manufacturers()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$this->data=array();
		$id = $this->input->post('id');

		$this->data['manufacturers_data']=$this->manufacturers_mdl->get_all_manufacturers_view(array('manu_manlistid'=>$id));
		//echo "<pre>"; print_r($this->data['manufacturers_data']);die;
		$tempform=$this->load->view('manufacturers/v_manufacturers_view',$this->data,true);
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

	public function manufactures_list($result=false,$orgid=false)
	{
		//echo MODULES_VIEW;die;
		
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		}

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		if($orgid){
			$org_id=$orgid;
		}
		else
		{
			$org_id = $this->session->userdata(ORG_ID); 
		}
		if($useraccess == 'B')
		{
			if($orgid)
			{
				$srchcol=array('manu_orgid'=>$org_id);
			}
			else
			{
				$srchcol='';
			}

			$this->data = $this->manufacturers_mdl->get_manufacturers_list($srchcol);
		}else{
			$cond = array('manu_orgid'=>$org_id);
			$this->data = $this->manufacturers_mdl->get_manufacturers_list($cond);
		}
		//print_r($org_id);die;
		if($result == 'cur') {
			$cond=array('manu_postdatead'=>date("Y/m/d"), 'manu_orgid'=>$org_id);
			$this->data = $this->manufacturers_mdl->get_manufacturers_list($cond);
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
		   
			    $array[$i]["manu_manlistid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->manu_manlistid.'>'.$row->manu_manlistid.'</a>';
			    $array[$i]["manlst"] = $row->manu_manlst;
			    $array[$i]["address1"] = $row->manu_address1;
			    $array[$i]["phone1"] = $row->manu_phone1;
			    $array[$i]["email"] = $row->manu_email;
			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->manu_manlistid.' data-displaydiv="Distributer" data-viewurl='.base_url('biomedical/manufacturers/view_manufacturers').' class="view" data-heading="View Manufacturer"  ><i class="fa fa-eye" aria-hidden="true" ></i></a>&nbsp;<a href="javascript:void(0)" data-id='.$row->manu_manlistid.' data-displaydiv="Manufacture" data-viewurl='.base_url('biomedical/manufacturers/editmanufacturers').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>
			        <a href="javascript:void(0)" data-id='.$row->manu_manlistid.' data-tableid='.($i+1).' data-deleteurl='. base_url('biomedical/manufacturers/deletemanufacturers') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>
			    ';
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}


public function exists_manufacturers()
	{
		$manu_manlst=$this->input->post('manu_manlst');
		$id=$this->input->post('id');
		$eqpcode=$this->manufacturers_mdl->check_exit_manafacture_for_other($manu_manlst,$id);
		// print_r($eqpcode);
		// die();
		// echo $this->db->last_query();
		// die();
		if($eqpcode)
		{
			$this->form_validation->set_message('exists_manufacturers', 'Already Exit Manufacture!!');
			return false;
		}
		else
		{
			return true;
			
		}
}
public function manufacturer_popup()
{
	// echo "test";
	// die();
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$this->data['country_list']=$this->general->get_tbl_data('*','coun_country',false,'coun_countryname',$order_by='ASC');
		$this->data['service_techlist']=$this->service_techs_mdl->get_all_service_techs();
		$this->data['distributor_list']=$this->distributors_mdl->get_distributor_list();

		// echo '<pre>';print_r($this->data['manufacturers_list']); die();

		$this->data['editurl']=base_url().'biomedical/manufacturers/editmanufacturers';
		$this->data['deleteurl']=base_url().'biomedical/manufacturers/deletemanufacturers';
		$this->data['listurl']=base_url().'biomedical/manufacturers/list_manufacturers';
	 	$tempform='';

	 	$tempform .=$this->load->view('manufacturers/v_manufacturersform',$this->data,true);

	 	//$tempform .=$this->load->view('designation/v_designation_list',$this->data,true);
	 	// echo $tempform;
	 	// die();
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
public function manufacturer_reload()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$manufacturers=$this->manufacturers_mdl->get_all_manufacturers();
			$tempform='';

			if($manufacturers):

            foreach ($manufacturers as $ku => $cat):
            	//
 			$tempform.='<option value="'.$cat->manu_manlistid.'">'.$cat->manu_manlst.'</option>';
             
            endforeach;
          endif;
   
          echo json_encode($tempform);
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

}