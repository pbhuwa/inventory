<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pavement_type extends CI_Controller

{

	function __construct()

	{

			

		parent::__construct();

		$this->load->Model('pavement_mdl');
		$this->locationid = $this->session->userdata(LOCATION_ID);
     	$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);

		

	}



	public function index()

    {

		$this->data['editurl']=base_url().'settings/pavement_type/editpavement';

		$this->data['deleteurl']=base_url().'settings/pavement_type/deletepavement';

		 $this->data['listurl']=base_url().'settings/pavement_type/list_of_pavement';

		$this->data['pavement_type']=$this->general->get_tbl_data('*','paty_pavementtype',false,'paty_id','ASC');



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

			->build('pavements/v_pavement_masterlist', $this->data);

	}

	public function save_pavement()

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


			$this->form_validation->set_rules($this->pavement_mdl->validate_settings_pavement);

		
			  if($this->form_validation->run()==TRUE)

			 {

        	 $trans = $this->pavement_mdl->save_pavement();

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
		$this->data['editurl']=base_url().'settings/pavement_type/editpavement';
		$this->data['deleteurl']=base_url().'settings/pavement_type/deletepavement';
		$this->data['listurl']=base_url().'settings/pavement_type/list_of_pavement';
		$this->data['pavement_type']=$this->general->get_tbl_data('*','paty_pavementtype',false,'paty_id','ASC');
		$this->data['breadcrumb']='Settings/pavement Type';
		$this->data['modal'] = '';
		$this->load->view('pavements/v_pavement_listform',$this->data);
	}


	public function list_of_pavement()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_VIEW=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}



			$data=array();

			$data['pavement_type']=$this->general->get_tbl_data('*','paty_pavementtype',false,'paty_id','ASC');	

			$template=$this->load->view('pavements/v_pavement_lists',$data,true);

			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

	   		 exit;	

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}

	}



	public function editdepavement()

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

		$this->data['pavement_data']=$this->general->get_tbl_data('*','paty_pavementtype',array('paty_id'=>$id),'paty_id','ASC');

	

			$tempform = $this->load->view('pavements/v_pavement_listform',$this->data,true);


			if(!empty($this->data['pavement_data']))

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



	public function deletedepavement()

    {

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_DELETE=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}



			$id=$this->input->post('id');





			$trans=$this->pavement_mdl->remove_pavement();

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



public function get_pavement_list()

	{

		if(MODULES_VIEW=='N')

			{

			  	$array["pavementtypeid"] ='';

			    $array["pavement"] = '';
			    $array["pavement_isactive"] ='';
			    $array["action"] = '';

			    

                echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));

                exit;

			}

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);

		$orgid = $this->session->userdata(ORG_ID);

		if($this->location_ismain=='Y')
			{
				$data = $this->pavement_mdl->get_dmaster_list();
			}
			else{
				$data = $this->pavement_mdl->get_dmaster_list(array('maty_locationid'=>$this->locationid));
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

		   

			    $array[$i]["pavementtypeid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->paty_id.'>'.$row->paty_id.'</a>';

			    

			    $array[$i]["pavement"] = $row->paty_name;
			    $array[$i]["paty_isactive"] = $row->paty_isactive;

			    			    

			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->paty_id.' data-displaydiv="pavements" data-viewurl='.base_url('settings/pavement_type/editdepavement').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>

			    <a href="javascript:void(0)" data-id='.$row->paty_id.' data-tableid='.($i+1).' data-deleteurl='. base_url('settings/pavement_type/deletedepavement') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>';

			     

			    $i++;
   

		    }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}
	public function exists_pavementtype()

    {

        $pavementtype=$this->input->post('paty_name');

        $id=$this->input->post('id');

        $pavementtypechk=$this->pavement_mdl->check_exist_pavement_for_other($pavementtype,$id);

        if($pavementtypechk)

        {

            $this->form_validation->set_message('exists_pavementtype', 'Already Exist pavement Type !!');

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