<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asset_status extends CI_Controller

{

	function __construct()

	{

		parent::__construct();

		$this->load->Model('buildingtype_mdl');
		$this->locationid = $this->session->userdata(LOCATION_ID);
     	$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);	

	}



	public function index()

    {
    	echo "string";
    	die();

		$this->data['editurl']=base_url().'settings/asset_status/editvalve';

		$this->data['deleteurl']=base_url().'settings/asset_status/deletevalve';

		 $this->data['listurl']=base_url().'settings/asset_status/list_of_valve';

		$this->data['assetstatus']=$this->general->get_tbl_data('*','asst_assetstatus',false,'asst_asstid','ASC');
            


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

			->build('assetstatus/v_assetstatus_masterlist', $this->data);

	}

	public function save_valve()

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


			$this->form_validation->set_rules($this->buildingtype_mdl->validate_settings_valve);

		
			  if($this->form_validation->run()==TRUE)

			 {

        	 $trans = $this->buildingtype_mdl->save_valve();

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
		$this->data['editurl']=base_url().'settings/assetstatus/editvalve';
		$this->data['deleteurl']=base_url().'settings/assetstatus/deletevalve';
		$this->data['listurl']=base_url().'settings/assetstatus/list_of_valve';
		$this->data['assetstatus']=$this->general->get_tbl_data('*','asst_assetstatus',false,'asst_asstid','ASC');
		$this->data['breadcrumb']='Settings/valve Type';
		$this->data['modal'] = '';
		$this->load->view('assetstatus/v_assetstatus_listform',$this->data);
	}


	public function list_of_valve()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_VIEW=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}



			$data=array();

			$data['assetstatus']=$this->general->get_tbl_data('*','asst_assetstatus',false,'asst_asstid','ASC');	
			$template=$this->load->view('assetstatus/v_assetstatus_lists',$data,true);

			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

	   		 exit;	

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}

	}



	public function editdevalve()

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

		$this->data['valve_data']=$this->general->get_tbl_data('*','asst_assetstatus',array('asst_asstid'=>$id),'asst_asstid','ASC');

	

			$tempform = $this->load->view('assetstatus/v_assetstatus_listform',$this->data,true);


			if(!empty($this->data['valve_data']))

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



	public function deletedevalve()

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



public function get_valve_list()

	{

		if(MODULES_VIEW=='N')

			{

			  	$array["valvetypeid"] ='';

			    $array["valve"] = '';
			    $array["valve_isactive"] ='';
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

		   

			    $array[$i]["valvetypeid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->asst_asstid.'>'.$row->asst_asstid.'</a>';

			    

			    $array[$i]["asty"] = $row->asst_statusname;
			    $array[$i]["asty_code"] = $row->asst_code;
			    $array[$i]["asty_isactive"] = $row->asst_isactive;

			    			    

			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->asst_asstid.' data-displaydiv="valves" data-viewurl='.base_url('settings/asset_status/editdevalve').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>

			    <a href="javascript:void(0)" data-id='.$row->asst_asstid.' data-tableid='.($i+1).' data-deleteurl='. base_url('settings/asset_status/deletedevalve') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>';

			     

			    $i++;
   

		    }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}
	public function exists_valvetype()

    {

        $valvetype=$this->input->post('asst_statusname');

        $id=$this->input->post('id');

        $valvetypechk=$this->buildingtype_mdl->check_exist_valve_for_other($valvetype,$id);

        if($valvetypechk)

        {

            $this->form_validation->set_message('exists_valvetype', 'Already Exist valve Type !!');

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
