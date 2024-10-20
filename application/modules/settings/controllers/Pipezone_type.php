<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pipezone_type extends CI_Controller

{

	function __construct()

	{

			

		parent::__construct();

		$this->load->Model('pipezone_mdl');
		$this->locationid = $this->session->userdata(LOCATION_ID);
     	$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);

		

	}



	public function index()

    {


		$this->data['editurl']=base_url().'settings/pipezone_type/editdepipezone';

		$this->data['deleteurl']=base_url().'settings/pipezone_type/deletepipezone';

		 $this->data['listurl']=base_url().'settings/pipezone_type/list_of_pipezone';

		$this->data['pipezone_type']=$this->general->get_tbl_data('*','pizo_pipezone',false,'pizo_id','ASC');
		$this->data['pipezone_cat']=$this->general->get_tbl_data('*','pizo_pipezone',array('pizo_parentid'=>'0'),'pizo_id','ASC');
		// echo "<pre>";
		// print_r($this->data['pipezone_cat']);
		// die();


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

			->build('pipezones/v_pipezone_masterlist', $this->data);

	}

	public function save_pipezone()

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


			$this->form_validation->set_rules($this->pipezone_mdl->validate_settings_pipezone);

		
			  if($this->form_validation->run()==TRUE)

			 {

        	 $trans = $this->pipezone_mdl->save_pipezone();

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
		$this->data['editurl']=base_url().'settings/pipezone_type/editdepipezone';
		$this->data['deleteurl']=base_url().'settings/pipezone_type/deletepipezone';
		$this->data['listurl']=base_url().'settings/pipezone_type/list_of_pipezone';
		$this->data['pipezone_type']=$this->general->get_tbl_data('*','pizo_pipezone',false,'pizo_id','ASC');
		$this->data['breadcrumb']='Settings/pipezone Type';
		$this->data['modal'] = '';
		$this->load->view('pipezones/v_pipezone_listform',$this->data);
	}


	public function list_of_pipezone()

	{
		$this->data['pipezone_type']=$this->general->get_tbl_data('*','pizo_pipezone',false,'pizo_id','ASC');
		$this->data['pipezone_cat']=$this->general->get_tbl_data('*','pizo_pipezone',array('pizo_parentid'=>'0'),'pizo_id','ASC');

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_VIEW=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}



			$data=array();

			$data['pipezone_type']=$this->general->get_tbl_data('*','pizo_pipezone',false,'pizo_id','ASC');	

			$template=$this->load->view('pipezones/v_pipezone_lists',$data,true);

			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

	   		 exit;	

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}

	}



	public function editdepipezone()

	{  
		$this->data['pipezone_cat']=$this->general->get_tbl_data('*','pizo_pipezone',array('pizo_parentid'=>'0'),'pizo_id','ASC');

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_UPDATE=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}

			$id=$this->input->post('id');
			// echo "hi";
			// echo $id;
			// die();

		$this->data['pipezone_data']=$this->general->get_tbl_data('*','pizo_pipezone
			',array('pizo_id'=>$id),'pizo_id','ASC');

	

			$tempform = $this->load->view('pipezones/v_pipezone_listform',$this->data,true);


			if(!empty($this->data['pipezone_data']))

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



	public function deletedepipezone()

    {

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_DELETE=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}



			$id=$this->input->post('id');





			$trans=$this->pipezone_mdl->remove_pipezone();

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



public function get_pipezone_list()
	
	{
		$this->data['pipezone_cat']=$this->general->get_tbl_data('*','pizo_pipezone',array('pizo_parentid'=>'0'),'pizo_id','ASC');
		$this->data['pipezone_data']=$this->general->get_tbl_data('*','pizo_pipezone',false,'pizo_id','ASC');
		if(MODULES_VIEW=='N')

			{

			  	$array["pipezonetypeid"] ='';

			    $array["pipezone"] = '';
			    $array["pizo_parentid"] ='';

			    $array["pipezone_isactive"] ='';
			    $array["action"] = '';

			    

                echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));

                exit;

			}

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);

		$orgid = $this->session->userdata(ORG_ID);

		if($this->location_ismain=='Y')
			{
				$data = $this->pipezone_mdl->get_dmaster_list();
			}
			else{
				$data = $this->pipezone_mdl->get_dmaster_list(array('maty_locationid'=>$this->locationid));
			}


	  	$i = 0;

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);

		$totalrecs = $data["totalrecs"];



	    unset($data["totalfilteredrecs"]);

	  	unset($data["totalrecs"]);

	  	// echo "<pre>";print_r($data);die;

	  

		  	foreach($data as $row)
		  		
		    {

		   

			    $array[$i]["pipezonetypeid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->pizo_id.'>'.$row->pizo_id.'</a>';

			    

			    $array[$i]["pipezone"] = $row->pizo_name;
				    // foreach($pipezone_cat as $cat){
				    // 	if($row->pizo_parentid == $cat->pizo_id):
				    // 		$category = 'bndf';
				    // 	endif;
				    // }
			    // if($row->pizo_parentid=='1'){
			    // 	$category= 'DMI';
			    // }
			    // $array[$i]["pizo_parentid"] = $category;
			    $array[$i]["pizo_parentid"] = $row->pizo_parentid;

			    $array[$i]["pizo_isactive"] = $row->pizo_isactive;

			    			    

			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->pizo_id.' data-displaydiv="pipezones" data-viewurl='.base_url('settings/pipezone_type/editdepipezone').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>

			    <a href="javascript:void(0)" data-id='.$row->pizo_id.' data-tableid='.($i+1).' data-deleteurl='. base_url('settings/pipezone_type/deletedepipezone') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>';

			     

			    $i++;
   

		    }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}
	public function exists_pipezonetype()

    {

        $pipezonetype=$this->input->post('pizo_name');

        $id=$this->input->post('id');

        $pipezonetypechk=$this->pipezone_mdl->check_exist_pipezone_for_other($pipezonetype,$id);

        if($pipezonetypechk)

        {

            $this->form_validation->set_message('exists_pipezonetype', 'Already Exist pipezone Type !!');

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