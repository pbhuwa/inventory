<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Building_type extends CI_Controller

{

	function __construct()

	{

		parent::__construct();

		$this->load->Model('buildingtype_mdl');
		$this->locationid = $this->session->userdata(LOCATION_ID);
     	$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
     	$this->orgid = $this->session->userdata(ORG_ID);
     	$this->curtime=$this->general->get_currenttime();
     	
        $this->userid=$this->session->userdata(USER_ID);
        $this->mac=$this->general->get_Mac_Address();
        $this->ip=$this->general->get_real_ipaddr();
			

	}



	public function index()

    {
    	// echo "string";
    	// die();

		$this->data['editurl']=base_url().'settings/building_type/editbuild';

		$this->data['deleteurl']=base_url().'settings/building_type/deletebuild';

		 $this->data['listurl']=base_url().'settings/building_type/list_of_build';

		$this->data['buildingtype']=$this->general->get_tbl_data('*','buty_buildingtype',false,'buty_butyid','ASC');
            


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

			->build('buildingtype/v_building_masterlist', $this->data);

	}

	public function save_build()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		try {
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

			$id=$this->input->post('id');


			$this->form_validation->set_rules($this->buildingtype_mdl->validate_settings_build);

		
			  if($this->form_validation->run()==TRUE)

			 {

        	 $trans = $this->buildingtype_mdl->save_build();

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


	public function form_view_masterlist()
	{
		$this->data['editurl']=base_url().'settings/building_type/editbuild';
		$this->data['deleteurl']=base_url().'settings/building_type/deletebuild';
		$this->data['listurl']=base_url().'settings/building_type/list_of_build';
		$this->data['buildingtype']=$this->general->get_tbl_data('*','buty_buildingtype',false,'buty_butyid','ASC');
		$this->data['breadcrumb']='Settings/Build Type';
		$this->data['modal'] = '';
		$this->load->view('buildingtype/v_building_listform',$this->data);
	}


	public function list_of_build()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_VIEW=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}
			$data=array();

			$data['buildingtype']=$this->general->get_tbl_data('*','buty_buildingtype',false,'buty_butyid','ASC');	
			$template=$this->load->view('buildingtype/v_building_lists',$data,true);

			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

	   		 exit;	

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}

	}



	public function editbuild()
	{   

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_UPDATE=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}

			$id=$this->input->post('id');
			//  "hi";
			// echo $id;
			// die();

		$this->data['build_data']=$this->general->get_tbl_data('*','buty_buildingtype',array('buty_butyid'=>$id),'buty_butyid','ASC');

	

			$tempform = $this->load->view('buildingtype/v_building_listform',$this->data,true);


			if(!empty($this->data['build_data']))

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



	public function deletebuild()
    {

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_DELETE=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}

			$id=$this->input->post('id');

			$trans=$this->buildingtype_mdl->remove_valve();

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



public function get_build_list()

	{

		if(MODULES_VIEW=='N')

			{

			  	$array["buty_butyid"] ='';
			    $array["buty_name"] = '';
			    $array['buty_code'] = '';
			    $array["buty_isactive"] ='';
			    $array["action"] = '';

			    

                echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));

                exit;

			}

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);

		$orgid = $this->session->userdata(ORG_ID);

		if($this->location_ismain=='Y')
			{
				$data = $this->buildingtype_mdl->get_dmaster_list();
			}
			else{
				$data = $this->buildingtype_mdl->get_dmaster_list(array('maty_locationid'=>$this->locationid));
			}


	  	$i = 0;

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);

		$totalrecs = $data["totalrecs"];



	    unset($data["totalfilteredrecs"]);

	  	unset($data["totalrecs"]);
	  	//echo "<pre>";print_r($data);die;

		  	foreach($data as $row)
		    { 

			    $array[$i]["buty_butyid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->buty_butyid.'>'.$row->buty_butyid.'</a>';
			    $array[$i]["buty"] = $row->buty_name;
			    $array[$i]["buty_code"] = $row->buty_code;
			    $array[$i]["buty_isactive"] = $row->buty_isactive;

			    			    

			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->buty_butyid.' data-displaydiv="valves" data-viewurl='.base_url('settings/building_type/editbuild').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>

			    <a href="javascript:void(0)" data-id='.$row->buty_butyid.' data-tableid='.($i+1).' data-deleteurl='. base_url('settings/building_type/deletebuild') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>';

			     

			    $i++;
   

		    }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}
	public function exists_buildtype()

    {

        $buildtype=$this->input->post('asst_statusname');

        $id=$this->input->post('id');

        $buildtypechk=$this->buildingtype_mdl->check_exist_build_for_other($buildtype,$id);

        if($buildtypechk)

        {

            $this->form_validation->set_message('exists_buildtype', 'Already Exist Building Type !!');

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
