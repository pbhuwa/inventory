<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Treatmentplantype extends CI_Controller

{

	function __construct()

	{

		parent::__construct();

		$this->load->Model('treatmentplantype_mdl');
		$this->locationid = $this->session->userdata(LOCATION_ID);
     	$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);	

	}



	public function index()

    {
    	// echo "string";
    	// die();

		$this->data['editurl']=base_url().'settings/treatmentplantype/edittreatment';

		$this->data['deleteurl']=base_url().'settings/treatmentplantype/deletetreatment';

		 $this->data['listurl']=base_url().'settings/treatmentplantype/list_of_treatment';

		$this->data['treatmentplant']=$this->general->get_tbl_data('*','tept_treatmentplantype',false,'tept_trplid','ASC');
            


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

			->build('treatmentplantype/v_treatmentplantype_masterlist', $this->data);

	}

	public function save_treatmentplantype()

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


			$this->form_validation->set_rules($this->treatmentplantype_mdl->validate_settings_valve);

		
			  if($this->form_validation->run()==TRUE)

			 {

        	 $trans = $this->treatmentplantype_mdl->save_treatmentplantype();

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
		$this->data['editurl']=base_url().'settings/treatmentplantype/edittreatment';
		$this->data['deleteurl']=base_url().'settings/treatmentplantype/deletetreatment';
		$this->data['listurl']=base_url().'settings/treatmentplantype/list_of_treatment';
		$this->data['treatmentplan']=$this->general->get_tbl_data('*','tept_treatmentplantype',false,'tept_trplid','ASC');
		$this->data['breadcrumb']='Settings/valve Type';
		$this->data['modal'] = '';
		$this->load->view('treatmentplantype/v_treatmentplantype_listform',$this->data);
	}


	public function list_of_treatment()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_VIEW=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}



			$data=array();

			$data['treatmentplan']=$this->general->get_tbl_data('*','tept_treatmentplantype',false,'tept_trplid','ASC');	
			$template=$this->load->view('treatmentplantype/v_treatmentplantype_lists',$data,true);

			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

	   		 exit;	

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}

	}



	public function edittreatment()

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

		$this->data['treatment_data']=$this->general->get_tbl_data('*','tept_treatmentplantype',array('tept_trplid'=>$id),'tept_trplid','ASC');

	

			$tempform = $this->load->view('treatmentplantype/v_treatmentplantype_listform',$this->data,true);


			if(!empty($this->data['treatment_data']))

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



	public function deletetreatment()

    {

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_DELETE=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}

			$id=$this->input->post('id');

			$trans=$this->treatmentplantype_mdl->remove_treatment();

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



public function get_treatmentplan_list()

	{

		if(MODULES_VIEW=='N')

			{

			  	$array["tept_trplid"] ='';
                $array["tept_code"] ='';
			    $array["tept_name"] = '';
			    $array["tept_isactive"] ='';
			    $array["action"] = '';

			    

                echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));

                exit;

			}

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);

		$orgid = $this->session->userdata(ORG_ID);

		if($this->location_ismain=='Y')
			{
				$data = $this->treatmentplantype_mdl->get_dmaster_list();
			}
			else{
				$data = $this->treatmentplantype_mdl->get_dmaster_list(array('maty_locationid'=>$this->locationid));
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

		   

			    $array[$i]["tept_trplid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->tept_trplid.'>'.$row->tept_trplid.'</a>';

			    

			    $array[$i]["tept_name"] = $row->tept_name;
			    $array[$i]["tept_code"] = $row->tept_code;
			    $array[$i]["tept_isactive"] = $row->tept_isactive;

			    			    

			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->tept_trplid.' data-displaydiv="valves" data-viewurl='.base_url('settings/treatmentplantype/edittreatment').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>

			    <a href="javascript:void(0)" data-id='.$row->tept_trplid.' data-tableid='.($i+1).' data-deleteurl='. base_url('settings/treatmentplantype/deletetreatment') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>';

			     

			    $i++;
   

		    }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}
	public function exists_treatmentplantype()

    {

        $treatmentpltype=$this->input->post('tept_name');

        $id=$this->input->post('id');

        $treatmentpltypechk=$this->treatmentplantype_mdl->check_exist_treatment_for_other($treatmentpltype,$id);

        if($treatmentpltypechk)

        {

            $this->form_validation->set_message('exists_treatmentplantype', 'Already Exist Treatmentplant Type !!');

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
