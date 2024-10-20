<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Desposal_type extends CI_Controller

{

	function __construct()

	{

		parent::__construct();

		$this->load->Model('desposal_type_mdl');
		$this->locationid = $this->session->userdata(LOCATION_ID);
     	$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);	

	}



	public function index()

    {
    	// echo "string";
    	// die();

		$this->data['editurl']=base_url().'settings/disposal_type/editdesposal';

		$this->data['deleteurl']=base_url().'settings/disposal_type/deletedesposal';

		 $this->data['listurl']=base_url().'settings/disposal_type/list_of_desposal';

		$this->data['desposaltype']=$this->general->get_tbl_data('*','dety_desposaltype',false,'dety_detyid','ASC');
            


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

			->build('desposaltype/v_desposaltype_masterlist', $this->data);

	}

	public function save_desposal()

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


			$this->form_validation->set_rules($this->desposal_type_mdl->validate_settings_valve);

		
			  if($this->form_validation->run()==TRUE)

			 {

        	 $trans = $this->desposal_type_mdl->save_desposal();

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
		$this->data['editurl']=base_url().'settings/desposal_type/editdesposal';
		$this->data['deleteurl']=base_url().'settings/desposal_type/deletedesposal';
		$this->data['listurl']=base_url().'settings/desposal_type/list_of_desposal';
		$this->data['desposaltype']=$this->general->get_tbl_data('*','dety_desposaltype',false,'dety_detyid','ASC');
		$this->data['breadcrumb']='Settings/desposal Type';
		$this->data['modal'] = '';
		$this->load->view('desposaltype/v_desposaltype_listform',$this->data);
	}


	public function list_of_desposal()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_VIEW=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}



			$data=array();

			$data['desposaltype']=$this->general->get_tbl_data('*','dety_desposaltype',false,'dety_detyid','ASC');	
			$template=$this->load->view('desposaltype/v_desposaltype_lists',$data,true);

			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

	   		 exit;	

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}

	}



	public function editdesposal()

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

		$this->data['desposal_edit_data']=$this->general->get_tbl_data('*','dety_desposaltype',array('dety_detyid'=>$id),'dety_detyid','ASC');

	

			$tempform = $this->load->view('desposaltype/v_desposaltype_listform',$this->data,true);


			if(!empty($this->data['desposal_edit_data']))

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



	public function deletedesposal()

    {

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_DELETE=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}

			$id=$this->input->post('id');

			$trans=$this->desposal_type_mdl->remove_desposal();

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



public function get_desposal_list()

	{

		if(MODULES_VIEW=='N')

			{

			  	$array["dety_detyid"] ='';
                $array["dety_code"] ='';
			    $array["dety_name"] = '';
			    $array["dety_description"] = '';
			    $array["dety_issale"] = '';
			    $array["dety_isactive"] ='';
			    $array["action"] = '';

			    

                echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));

                exit;

			}

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);

		$orgid = $this->session->userdata(ORG_ID);

		if($this->location_ismain=='Y')
			{
				$data = $this->desposal_type_mdl->get_dmaster_list();
			}
			else{
				$data = $this->desposal_type_mdl->get_dmaster_list(array('maty_locationid'=>$this->locationid));
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

		   

			    $array[$i]["dety_detyid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->dety_detyid.'>'.$row->dety_detyid.'</a>';

			    

			    $array[$i]["dety_name"] = $row->dety_name;
			    $array[$i]["dety_code"] = $row->dety_code;
			    $array[$i]["dety_description"] = $row->dety_description;
			     $array[$i]["dety_issale"] = $row->dety_issale;
			    $array[$i]["dety_isactive"] = $row->dety_isactive;

			    			    

			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->dety_detyid.' data-displaydiv="valves" data-viewurl='.base_url('settings/desposal_type/editdesposal').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>

			    <a href="javascript:void(0)" data-id='.$row->dety_detyid.' data-tableid='.($i+1).' data-deleteurl='. base_url('settings/desposal_type/deletedesposal') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>';

			     
			    $i++;
   

		    }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}
	public function exists_desposaltype()

    {

        $desposaltype=$this->input->post('dety_name');

        $id=$this->input->post('id');

        $desposaltypechk=$this->desposal_type_mdl->check_exist_status_for_other($desposaltype,$id);

        if($desposaltypechk)

        {

            $this->form_validation->set_message('exists_desposaltype', 'Already Exist valve Type !!');

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
