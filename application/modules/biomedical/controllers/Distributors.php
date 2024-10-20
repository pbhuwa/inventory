<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Distributors extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('distributors_mdl');
		$this->load->Model('service_techs_mdl');
		$this->locationid = $this->session->userdata(LOCATION_ID);
     	$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
	}
	
	public function index()
	{
		$this->data['distributor_list']=$this->distributors_mdl->get_distributor_list();
		$this->data['country_list']=$this->general->get_tbl_data('*','coun_country',false,'coun_countryname','ASC');
		$this->data['service_techlist']=$this->service_techs_mdl->get_all_service_techs();
			$this->data['modal'] = '';

		// echo '<pre>'; print_r($this->data['distributor_list']); die();

		$this->data['editurl']=base_url().'biomedical/distributors/editdistributors';
		$this->data['deleteurl']=base_url().'biomedical/distributors/deletedistributors';
		$this->data['listurl']=base_url().'biomedical/distributors/list_distributors';
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
			->build('distributors/v_distributors', $this->data);
	}
	public function list_distributors()
	{
		if(MODULES_VIEW=='N')
			{
			$this->general->permission_denial_message();
			exit;
			}
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
			$data=array();
			$template=$this->load->view('distributors/v_distributers_list',$data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function form_distributor()
	{
		$this->data['service_techlist']=$this->service_techs_mdl->get_all_service_techs();
		$this->data['country_list']=$this->general->get_tbl_data('*','coun_country',false,'coun_countryname','ASC');
		$this->load->view('distributors/v_distributorsform',$this->data);

	}

	public function view_distributor()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$this->data=array();
		$id = $this->input->post('id');
		$this->data['distributor_data']=$this->distributors_mdl->get_distributor_list(array('dist_distributorid'=>$id));
		//echo "<pre>";print_r($this->data['distributor_data']);die;
		$tempform=$this->load->view('distributors/v_distributors_view',$this->data,true);
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

	public function get_all_distributers($result=false,$org_id=false)
	{			
		$this->data['result']=$result;
		$this->data['org_id']=$org_id;
		$this->load->view('distributors/v_distributers_list', $this->data);
	}

	public function save_distributor()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
				$id =$this->input->post('id');
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
				if($id)
				{
					$this->data['distributor_data']=$this->distributors_mdl->get_distributor_list(array('dist_distributorid'=>$id));	// echo "<pre>";
					// print_r($data['dept_data']);
					// die();
					if($this->data['distributor_data'])
					{
						$dep_date=$this->data['distributor_data'][0]->dist_postdatead;
						$dep_time=$this->data['distributor_data'][0]->dist_posttime;
						$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
						$usergroup=$this->session->userdata(USER_GROUPCODE);
					
						if($editstatus==0 && $usergroup!='SA' )
						{
						   $this->general->disabled_edit_message();
						}
					}
				}

				if($id){
					$this->form_validation->set_rules($this->distributors_mdl->validate_settings_users_edit);	
				}else{
					$this->form_validation->set_rules($this->distributors_mdl->validate_settings_distributors);
				}
			 	
			  	if($this->form_validation->run()==TRUE)
			 	{
            		$trans = $this->distributors_mdl->distributor_save();
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

	public function editdistributors()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_UPDATE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			$id=$this->input->post('id');
			
			$this->data['distributor_data']=$this->distributors_mdl->get_distributor_list(array('dist_distributorid'=>$id));
			// echo "<pre>";
			// print_r($data['distributors_data']);
			// die();
			$this->data['country_list']=$this->general->get_tbl_data('*','coun_country',false,'coun_countryname',$order_by='ASC');
			$this->data['service_techlist']=$this->service_techs_mdl->get_all_service_techs();
			if($this->data['distributor_data'])
		{
			$dep_date=$this->data['distributor_data'][0]->dist_postdatead;
			$dep_time=$this->data['distributor_data'][0]->dist_posttime;
			$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
			// echo $editstatus;
			// die();
			$this->data['edit_status']=$editstatus;

		}

			$tempform=$this->load->view('distributors/v_distributorsform',$this->data,true);
			// echo $tempform;
			// die();
			if(!empty($this->data['distributor_data']))
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

	public function deletedistributors()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_DELETE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			$id=$this->input->post('id');
			$trans = $this->distributors_mdl->remove_distributor();
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
	
    public function distributors_list($result=false,$orgid=false)
	{
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		if($orgid){
			$org_id=$orgid;
		}
		else
		{
			$org_id = $this->session->userdata(ORG_ID); 
		}
		
		// if($useraccess == 'B')
		// {
		// 	if($orgid)
		// 	{
		// 		$srchcol=array('dist_orgid'=>$org_id);
		// 	}
		// 	else
		// 	{
		// 		$srchcol='';
		// 	}

		// 	$data = $this->distributors_mdl->get_deletedistributors_list($srchcol);
		// }else{
		// 	$data = $this->distributors_mdl->get_deletedistributors_list(array('dist_orgid'=> $org_id));
		// }	
		// if($this->location_ismain == 'Y'){
		// 	$data = $this->distributors_mdl->get_deletedistributors_list();
		// }
		// else{
		// 	$data = $this->distributors_mdl->get_deletedistributors_list(array('dist_locationid'=>$this->locationid));
		// }
		$data = $this->distributors_mdl->get_distributors_list();
        
        // echo $this->db->last_query();
        // die();
	
		if($result == 'bmin_equipid') {

			$cond = array('dist_postdatead'=>date("Y/m/d"),'dist_orgid'=>$org_id);
			$data = $this->distributors_mdl->get_distributors_list($cond);
		}
		// echo "<pre>"; print_r($data); die();
	  	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {
		   
			    $array[$i]["dist_distributorid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->dist_distributorid.'>'.$row->dist_distributorid.'</a>';
			    $array[$i]["dist_distributorcode"] = $row->dist_distributorcode;
			    $array[$i]["distributor"] = $row->dist_distributor;
			     $array[$i]["dist_phone1"] = $row->dist_phone1;
			     $array[$i]["address1"] = $row->dist_address1;
			    $array[$i]["dist_govtregno"] = $row->dist_govtregno;
			    
                 if(MODULES_DELETE=='Y')
		    	{
			     $deletebtn = '<a href="javascript:void(0)" data-id='.$row->dist_distributorid.' data-tableid='.($i+1).' data-deleteurl='. base_url('biomedical/distributors/deletedistributors') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>';
			     }
		    	else
		    	{
		    		$deletebtn='';
		    	}
                     
                if(MODULES_UPDATE=='Y')
                {

		    	$editbtn= '<a href="javascript:void(0)" data-id='.$row->dist_distributorid.' data-displaydiv="Distributer" data-viewurl='.base_url('biomedical/distributors/editdistributors').' class="btnEdit" ><i class="fa fa-edit" aria-hidden="true" ></i></a>';
		    }else{
		    	$editbtn='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		    }

			    $array[$i]["action"] = $deletebtn.' '.$editbtn.'<a href="javascript:void(0)" data-id='.$row->dist_distributorid.' data-displaydiv="Distributer" data-viewurl='.base_url('biomedical/distributors/view_distributor').' class="view" data-heading='.$this->lang->line('distributor').'> <i class="fa fa-eye" aria-hidden="true" ></i></a> ';

			    $i++;
		        //(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function supplier_entry($modal = false){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$this->data['editurl']=base_url().'biomedical/distributors/editdistributors';
		$this->data['deleteurl']=base_url().'biomedical/distributors/deletedistributors';
		$this->data['listurl']=base_url().'biomedical/distributors/list_distributors';
		$this->data['distributor_list']=$this->distributors_mdl->get_distributor_list();
		$this->data['country_list']=$this->general->get_tbl_data('*','coun_country',false,'coun_countryname','ASC');
		$this->data['service_techlist']=$this->service_techs_mdl->get_all_service_techs();

		// echo '<pre>'; print_r($this->data['distributor_list']); die();
		//for item entry from popup
		$this->data['modal'] = $modal;
		$template='';
		$template=$this->load->view('distributors/v_distributorsform',$this->data,true);
		print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template,'tempform'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}

	}

	public function distributor_reload()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$subunit=$this->distributors_mdl->get_distributor_list(array('dist_isactive'=>'Y'),false,false,'dist_distributor','ASC');
			$tempform='';

			if($subunit):

            foreach ($subunit as $ku => $cat):
            	//
 			$tempform.='<option value="'.$cat->dist_distributorid.'">'.$cat->dist_distributor.'</option>';
             
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

	 public function list_of_supplier()
	{
	    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
	    {
			try {
				$data['supplier_list'] = $this->distributors_mdl->get_distributor(false,10,false,'dist_distributorid','ASC');
				  // echo "<pre>";
				  // print_r($data);
				  // die();
				$template=$this->load->view('biomedical/distributors/v_disttemp_list',$data,true);
		        
		        if($template){
		           	print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','template'=>$template)));
		            exit;
		        }
		        else
		        {
		           	print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
		            exit;
		        }
			}
			catch (Exception $e) {
	          
	            print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
	        }
		}
		else
	    {
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	            exit;
	    }
    }
    public function exists_username()
{
		$dist_distributor=$this->input->post('dist_distributor');
		$input_id=$this->input->post('id');
		$supplier=$this->distributors_mdl->check_exit_supplier_for_other($dist_distributor,$input_id);
		if($supplier)
		{
			$this->form_validation->set_message('exists_username', 'Alreay Exit Username.');
			return false;

		}
		else
		{
			return true;
		}

}

	public function exportToExcel()
	{
		header("Content-Type: application/xls");

		header("Content-Disposition: attachment; filename=suppliers_list" . date('Y_m_d_H_i') . ".xls");

		header("Pragma: no-cache");

		header("Expires: 0");

		// $data = $this->distributors_mdl->get_distributors_list();

		$this->data['searchResult'] = $this->distributors_mdl->get_distributors_list();

		$array = array();

		unset($this->data['searchResult']['totalfilteredrecs']);

		unset($this->data['searchResult']['totalrecs']);

		$response = $this->load->view('distributors/v_distributors_download_list', $this->data, true);

		echo $response;
	}
		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */