<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asset_type extends CI_Controller

{

	function __construct()

	{

			

		parent::__construct();

		$this->load->Model('assetty_mdl');
		$this->locationid = $this->session->userdata(LOCATION_ID);
		$this->orgid = $this->session->userdata(ORG_ID);

     	$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
     	$this->curtime=$this->general->get_currenttime();
        $this->userid=$this->session->userdata(USER_ID);
        $this->mac=$this->general->get_Mac_Address();
        $this->ip=$this->general->get_real_ipaddr();

		

	}



	public function index()

    {
    	// echo "string";
     //      die();

		$this->data['editurl']=base_url().'settings/asset_type/editasset';

		$this->data['deleteurl']=base_url().'settings/asset_type/deleteasset';

		 $this->data['listurl']=base_url().'settings/asset_type/list_of_asset';

		$this->data['assettype']=$this->general->get_tbl_data('*','asty_assettype',false,'asty_astyid','ASC');



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

			->build('assettype/v_assettype_masterlist', $this->data);

	}

	public function save_asset()

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


			$this->form_validation->set_rules($this->assetty_mdl->validate_settings_valve);

		
			  if($this->form_validation->run()==TRUE)

			 {

        	 $trans = $this->assetty_mdl->save_asset();

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
		$this->data['editurl']=base_url().'settings/asset_type/editasset';
		$this->data['deleteurl']=base_url().'settings/asset_type/deleteasset';
		$this->data['listurl']=base_url().'settings/asset_type/list_of_asset';
		$this->data['asset_type']=$this->general->get_tbl_data('*','asty_assettype',false,'asty_astyid','ASC');
		$this->data['breadcrumb']='Settings/Asset Type';
		$this->data['modal'] = '';
		$this->load->view('assettype/v_assettype_listform',$this->data);
	}


	public function list_of_asset()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_VIEW=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}



			$data=array();

			$data['assettype']=$this->general->get_tbl_data('*','asty_assettype',false,'asty_astyid','ASC');	
			$template=$this->load->view('assettype/v_assettype_lists',$data,true);

			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

	   		 exit;	

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}

	}



	public function editasset()

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

		$this->data['asset_data']=$this->general->get_tbl_data('*','asty_assettype',array('asty_astyid'=>$id),'asty_astyid','ASC');
		// echo "<pre>";
		// print_r($this->data['asset_data']);
		// die();

	

			$tempform = $this->load->view('assettype/v_assettype_listform',$this->data,true);


			if(!empty($this->data['asset_data']))

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



	public function deleteasset()

    {

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_DELETE=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}



			$id=$this->input->post('id');





			$trans=$this->assetty_mdl->remove_valve();

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



public function get_asset_list()

	{

		if(MODULES_VIEW=='N')

			{

			  	$array["asty_astyid"] ='';
			    $array["asty_typename"] = '';
			    $array["asty_code"] = '';
			    $array["asty_isactive"] ='';
			    $array["action"] = '';

			    

                echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));

                exit;

			}

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);

		$orgid = $this->session->userdata(ORG_ID);

		if($this->location_ismain=='Y')
			{
				$data = $this->assetty_mdl->get_dmaster_list();
			}
			else{
				$data = $this->assetty_mdl->get_dmaster_list(array('asty_locationid'=>$this->locationid));
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

		   

			    $array[$i]["asty_astyid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->asty_astyid.'>'.$row->asty_astyid.'</a>';
			    $array[$i]["asty_typename"] = $row->asty_typename;
			    $array[$i]["asty_code"] = $row->asty_code;
			    $array[$i]["asty_isactive"] = $row->asty_isactive;

			    			    

			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->asty_astyid.' data-displaydiv="assettype" data-viewurl='.base_url('settings/asset_type/editasset').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>

			    <a href="javascript:void(0)" data-id='.$row->asty_astyid.' data-tableid='.($i+1).' data-deleteurl='. base_url('settings/asset_type/deleteasset') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>';

			     

			    $i++;
   

		    }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}
	public function exists_assettype()

    {

        $valvetype=$this->input->post('asty_typename');

        $id=$this->input->post('id');

        $valvetypechk=$this->assetty_mdl->check_exist_valve_for_other($valvetype,$id);

        if($valvetypechk)

        {

            $this->form_validation->set_message('exists_assettype', 'Already Exist valve Type !!');

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