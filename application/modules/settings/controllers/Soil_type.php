<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Soil_type extends CI_Controller

{

	function __construct()

	{

			

		parent::__construct();

		$this->load->Model('soil_mdl');
		$this->locationid = $this->session->userdata(LOCATION_ID);
     	$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);

		

	}



	public function index()

    {

		$this->data['editurl']=base_url().'settings/soil_type/editsoil';

		$this->data['deleteurl']=base_url().'settings/soil_type/deletesoil';

		 $this->data['listurl']=base_url().'settings/soil_type/list_of_soil';

		$this->data['soil_type']=$this->general->get_tbl_data('*','soty_soiltype',false,'soty_id','ASC');



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

			->build('soils/v_soil_masterlist', $this->data);

	}

	public function save_soil()

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


			$this->form_validation->set_rules($this->soil_mdl->validate_settings_soil);

		
			  if($this->form_validation->run()==TRUE)

			 {

        	 $trans = $this->soil_mdl->save_soil();

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
		$this->data['editurl']=base_url().'settings/soil_type/editsoil';
		$this->data['deleteurl']=base_url().'settings/soil_type/deletesoil';
		$this->data['listurl']=base_url().'settings/soil_type/list_of_soil';
		$this->data['soil_type']=$this->general->get_tbl_data('*','soty_soiltype',false,'soty_id','ASC');
		$this->data['breadcrumb']='Settings/soil Type';
		$this->data['modal'] = '';
		$this->load->view('soils/v_soil_listform',$this->data);
	}


	public function list_of_soil()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_VIEW=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}



			$data=array();

			$data['soil_type']=$this->general->get_tbl_data('*','soty_soiltype',false,'soty_id','ASC');	

			$template=$this->load->view('soils/v_soil_lists',$data,true);

			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

	   		 exit;	

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}

	}



	public function editdesoil()

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

		$this->data['soil_data']=$this->general->get_tbl_data('*','soty_soiltype',array('soty_id'=>$id),'soty_id','ASC');

	

			$tempform = $this->load->view('soils/v_soil_listform',$this->data,true);


			if(!empty($this->data['soil_data']))

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



	public function deletedesoil()

    {

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_DELETE=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}



			$id=$this->input->post('id');





			$trans=$this->soil_mdl->remove_soil();

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



public function get_soil_list()

	{

		if(MODULES_VIEW=='N')

			{

			  	$array["soiltypeid"] ='';

			    $array["soil"] = '';
			    $array["soil_isactive"] ='';
			    $array["action"] = '';

			    

                echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));

                exit;

			}

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);

		$orgid = $this->session->userdata(ORG_ID);

		if($this->location_ismain=='Y')
			{
				$data = $this->soil_mdl->get_dmaster_list();
			}
			else{
				$data = $this->soil_mdl->get_dmaster_list(array('maty_locationid'=>$this->locationid));
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

		   

			    $array[$i]["soiltypeid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->soty_id.'>'.$row->soty_id.'</a>';

			    

			    $array[$i]["soil"] = $row->soty_type;
			    $array[$i]["soty_isactive"] = $row->soty_isactive;

			    			    

			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->soty_id.' data-displaydiv="soils" data-viewurl='.base_url('settings/soil_type/editdesoil').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>

			    <a href="javascript:void(0)" data-id='.$row->soty_id.' data-tableid='.($i+1).' data-deleteurl='. base_url('settings/soil_type/deletedesoil') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>';

			     

			    $i++;
   

		    }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}
	public function exists_soiltype()

    {

        $soiltype=$this->input->post('soty_type');

        $id=$this->input->post('id');

        $soiltypechk=$this->soil_mdl->check_exist_soil_for_other($soiltype,$id);

        if($soiltypechk)

        {

            $this->form_validation->set_message('exists_soiltype', 'Already Exist soil Type !!');

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