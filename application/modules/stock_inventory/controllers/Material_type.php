<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Material_type extends CI_Controller

{

	function __construct()

	{

			

		parent::__construct();

		$this->load->Model('Material_mdl');
		$this->locationid = $this->session->userdata(LOCATION_ID);
     	$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);

		

	}



	public function index()

    {

		$this->data['editurl']=base_url().'stock_inventory/Material_type/editmaterial';

		$this->data['deleteurl']=base_url().'stock_inventory/Material_type/deletematerial';

		 $this->data['listurl']=base_url().'stock_inventory/Material_type/list_of_material';

		$this->data['material_type']=$this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','ASC');



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

			->build('materials/v_material_masterlist', $this->data);

	}

	public function save_material()

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


			$this->form_validation->set_rules($this->Material_mdl->validate_settings_material);

		
			  if($this->form_validation->run()==TRUE)

			 {

        	 $trans = $this->Material_mdl->save_material();

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
		$this->data['editurl']=base_url().'stock_inventory/Material_type/editmaterial';
		$this->data['deleteurl']=base_url().'stock_inventory/Material_type/deletematerial';
		$this->data['listurl']=base_url().'stock_inventory/Material_type/list_of_material';
		$this->data['material_type']=$this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','ASC');
		$this->data['breadcrumb']='Stock Inventory/Material Type';
		$this->data['modal'] = '';
		$this->load->view('materials/v_material_listform',$this->data);
	}


	public function list_of_material()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_VIEW=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}



			$data=array();

			$data['material_type']=$this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','ASC');	

			$template=$this->load->view('materials/v_material_lists',$data,true);

			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

	   		 exit;	

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}

	}



	public function editdematerial()

	{   



		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_UPDATE=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}

			$id=$this->input->post('id');

		$this->data['material_data']=$this->general->get_tbl_data('*','maty_materialtype',array('maty_materialtypeid'=>$id),'maty_materialtypeid','ASC');

	

			$tempform = $this->load->view('materials/v_material_listform',$this->data,true);


			if(!empty($this->data['material_data']))

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



	public function deletedematerial()

    {

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_DELETE=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}



			$id=$this->input->post('id');





			$trans=$this->Material_mdl->remove_material();

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



public function get_material_list()

	{

		if(MODULES_VIEW=='N')

			{

			  	$array["materialtypeid"] ='';

			    $array["material"] = '';
			    $array["maty_isactive"] = '';

			    $array["action"] = '';

			    

                echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));

                exit;

			}

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);

		$orgid = $this->session->userdata(ORG_ID);

		if($this->location_ismain=='Y')
			{
				$data = $this->Material_mdl->get_dmaster_list();
			}
			else{
				$data = $this->Material_mdl->get_dmaster_list(array('maty_locationid'=>$this->locationid));
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
			    $array[$i]["materialtypeid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->maty_materialtypeid.'>'.$row->maty_materialtypeid.'</a>';

			    $array[$i]["material"] = $row->maty_material;
			     $array[$i]["maty_isactive"] = $row->maty_isactive;

			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->maty_materialtypeid.' data-displaydiv="materials" data-viewurl='.base_url('stock_inventory/Material_type/editdematerial').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>

			    <a href="javascript:void(0)" data-id='.$row->maty_materialtypeid.' data-tableid='.($i+1).' data-deleteurl='. base_url('stock_inventory/Material_type/deletedematerial') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>';

			    $i++;
		    }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}
	public function exists_materialtype()

    {

        $materialtype=$this->input->post('maty_material');

        $id=$this->input->post('id');

        $materialtypechk=$this->Material_mdl->check_exist_material_for_other($materialtype,$id);

        if($materialtypechk)

        {

            $this->form_validation->set_message('exists_materialtype', 'Already Exist Material Type !!');

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