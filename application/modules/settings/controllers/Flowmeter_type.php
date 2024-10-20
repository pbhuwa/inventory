<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flowmeter_type extends CI_Controller

{

	function __construct()

	{

			

		parent::__construct();

		$this->load->Model('flowmeter_mdl');
		$this->locationid = $this->session->userdata(LOCATION_ID);
     	$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);

		

	}



	public function index()

    {

		$this->data['editurl']=base_url().'settings/flowmeter_type/editflowmeter';

		$this->data['deleteurl']=base_url().'settings/flowmeter_type/deleteflowmeter';

		 $this->data['listurl']=base_url().'settings/flowmeter_type/list_of_flowmeter';

		$this->data['flowmeter_type']=$this->general->get_tbl_data('*','flty_flowmeterstype',false,'flty_id','ASC');



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

			->build('flowmeters/v_flowmeter_masterlist', $this->data);

	}

	public function save_flowmeter()

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


			$this->form_validation->set_rules($this->flowmeter_mdl->validate_settings_flowmeter);

		
			  if($this->form_validation->run()==TRUE)

			 {

        	 $trans = $this->flowmeter_mdl->save_flowmeter();

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
		$this->data['editurl']=base_url().'settings/flowmeter_type/editflowmeter';
		$this->data['deleteurl']=base_url().'settings/flowmeter_type/deleteflowmeter';
		$this->data['listurl']=base_url().'settings/flowmeter_type/list_of_flowmeter';
		$this->data['flowmeter_type']=$this->general->get_tbl_data('*','flty_flowmeterstype',false,'flty_id','ASC');
		$this->data['breadcrumb']='Settings/flowmeter Type';
		$this->data['modal'] = '';
		$this->load->view('flowmeters/v_flowmeter_listform',$this->data);
	}


	public function list_of_flowmeter()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_VIEW=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}



			$data=array();

			$data['flowmeter_type']=$this->general->get_tbl_data('*','flty_flowmeterstype',false,'flty_id','ASC');	

			$template=$this->load->view('flowmeters/v_flowmeter_lists',$data,true);

			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

	   		 exit;	

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}

	}



	public function editdeflowmeter()

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

		$this->data['flowmeter_data']=$this->general->get_tbl_data('*','flty_flowmeterstype',array('flty_id'=>$id),'flty_id','ASC');

	

			$tempform = $this->load->view('flowmeters/v_flowmeter_listform',$this->data,true);


			if(!empty($this->data['flowmeter_data']))

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



	public function deletedeflowmeter()

    {

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_DELETE=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}



			$id=$this->input->post('id');





			$trans=$this->flowmeter_mdl->remove_flowmeter();

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



public function get_flowmeter_list()

	{

		if(MODULES_VIEW=='N')

			{

			  	$array["flowmetertypeid"] ='';

			    $array["flowmeter"] = '';
			    $array["flowmeter_isactive"] ='';
			    $array["action"] = '';

			    

                echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));

                exit;

			}

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);

		$orgid = $this->session->userdata(ORG_ID);

		if($this->location_ismain=='Y')
			{
				$data = $this->flowmeter_mdl->get_dmaster_list();
			}
			else{
				$data = $this->flowmeter_mdl->get_dmaster_list(array('maty_locationid'=>$this->locationid));
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

		   

			    $array[$i]["flowmetertypeid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->flty_id.'>'.$row->flty_id.'</a>';

			    

			    $array[$i]["flowmeter"] = $row->flty_name;
			    $array[$i]["flty_isactive"] = $row->flty_isactive;

			    			    

			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->flty_id.' data-displaydiv="flowmeters" data-viewurl='.base_url('settings/flowmeter_type/editdeflowmeter').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>

			    <a href="javascript:void(0)" data-id='.$row->flty_id.' data-tableid='.($i+1).' data-deleteurl='. base_url('settings/flowmeter_type/deletedeflowmeter') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>';

			     

			    $i++;
   

		    }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}
	public function exists_flowmetertype()

    {

        $flowmetertype=$this->input->post('flty_name');

        $id=$this->input->post('id');

        $flowmetertypechk=$this->flowmeter_mdl->check_exist_flowmeter_for_other($flowmetertype,$id);

        if($flowmetertypechk)

        {

            $this->form_validation->set_message('exists_flowmetertype', 'Already Exist flowmeter Type !!');

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