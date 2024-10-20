<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Approved extends CI_Controller

{

	function __construct()

	{

			

		parent::__construct();

		$this->load->Model('approved_mdl');

		

	}



	public function index()

    {

    // echo "hello";
    // die;
		//$this->data['approved_all'] = $this->approved_mdl->get_all_approved();



		$this->data['editurl']=base_url().'stock_inventory/approved/editapproved';

		$this->data['deleteurl']=base_url().'stock_inventory/approved/deleteapproved';

		 $this->data['listurl']=base_url().'stock_inventory/approved/list_of_approved';

	//	$this->data['approved']=$this->general->get_tbl_data('*','appr_approved',false,'appr_approvedid','ASC');



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

			->build('approved/v_approved', $this->data);

	}

	public function form_approved()
{
	
		 $this->data['editurl']=base_url().'stock_inventory/approved/editapproved';
		 $this->data['deleteurl']=base_url().'stock_inventory/approved/deleteapproved';
		 $this->data['listurl']=base_url().'stock_inventory/approved/list_of_approved';

	     $this->load->view('approved/v_approved_form',$this->data);
}

	public function save_approved()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		try {

			$id=$this->input->post('id');

			// if($id)

			// {

			// $this->form_validation->set_rules($this->staff_manager_mdl->validate_settings_menu_edit);

			// }

			// else

			// {

			$this->form_validation->set_rules($this->approved_mdl->validate_settings_approved);

			// }

			

			  if($this->form_validation->run()==TRUE)

			 {



        	 $trans = $this->approved_mdl->save_approved();

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







	



	public function list_of_approved()

	{





		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_VIEW=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}



			$data=array();

			$data['approved_data']=$this->general->get_tbl_data('*','appr_approved',false,'appr_approvedid','ASC');	

			$template=$this->load->view('approved/v_approved_list',$data,true);

			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

	   		 exit;	

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}

	}



	public function editdeapproved()

	{   



		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_UPDATE=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}
   
		    $id=$this->input->post('id');

		    $this->data['approved_data']=$this->general->get_tbl_data('*','appr_approved',array('appr_approvedid'=>$id),false,'false');

		// echo "<pre>";print_r($this->data['approved_data']);die;

			$tempform = $this->load->view('approved/v_approved_form',$this->data,true);

	

			if(!empty($this->data['approved_data']))

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



	public function deletedeapproved()

    {

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_DELETE=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}



			$id=$this->input->post('id');





			$trans=$this->approved_mdl->remove_approved();

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



	





public function get_approved_list()

	{

		if(MODULES_VIEW=='N')

			{

			    $array["appr_approvedname"] = '';
			    $array["action"] = '';

			    

                echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));

                exit;

			}

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);

		$orgid = $this->session->userdata(ORG_ID);

		/*if($useraccess == 'B')

		{	

			$data = $this->approved_mdl->get_dmaster_list();//echo "<pre>"; print_r($data); die();

		}

		else{

			$data = $this->approved_mdl->get_dmaster_list(array('appr_approvedid'=>$orgid));

		}*/

		 $data = $this->approved_mdl->get_approved_list();



		 //echo "<pre>";print_r($data);die;



	  	$i = 0;

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);

		$totalrecs = $data["totalrecs"];



	    unset($data["totalfilteredrecs"]);

	  	unset($data["totalrecs"]);

	  	//echo "<pre>";print_r($data);die;

	  

		  	foreach($data as $row)

		    {

		   

			    $array[$i]["appr_approvedid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->appr_approvedid.'>'.$row->appr_approvedid.'</a>';

			    

			       $array[$i]["appr_approvedname"] = $row->appr_approvedname;

			    			    

			     $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->appr_approvedid.' data-displaydiv="approved" data-viewurl='.base_url('stock_inventory/approved/editdeapproved').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a> |

			    <a href="javascript:void(0)" data-id='.$row->appr_approvedid.' data-tableid='.($i+1).' data-deleteurl='. base_url('stock_inventory/approved/deletedeapproved') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>';

			     

			    $i++;

		        //(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');

		    }

		    //echo "<pre>";print_r($array);die;

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}
public function exists_approvedname()

    {

        $budgetname=$this->input->post('appr_approvedname');

        $id=$this->input->post('id');

        $budgetnamechk=$this->approved_mdl->check_exist_approved_for_other($budgetname,$id);

        if($budgetnamechk)

        {

            $this->form_validation->set_message('exists_approvedname', 'Already Exist approved Name !!');

            return false;

        }

        else

        {

            return true;

        }

    }

      public function form_approved_popup()

    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $this->data['editurl']=base_url().'stock_inventory/approved/editapproved';

		 $this->data['deleteurl']=base_url().'stock_inventory/approved/deleteapproved';

		 $this->data['listurl']=base_url().'stock_inventory/approved/list_of_approved';

         $this->data['frompopup']="Y";

        //  $this->data['organization_all']=$this->organization_mdl->get_all_organization();

        // $this->data['org_type']=$this->org_setup_mdl->get_all_org_setup(); 

        // $this->data['branch_all']=$this->branch_mdl->get_all_branch(); 

	   // $this->data['approved_data']=$this->approved_mdl->get_approved_list();

        $this->data['reload_script']=true;



        $tempform=$this->load->view('approved/v_approved_form',$this->data,true);



        // echo "<pre>";print_r($this->data['customer_supplier_data']); die();



        // echo $tempform;



        // die();





         print_r(json_encode(array('status'=>'success','message'=>'You Can edit','tempform'=>$tempform)));



                exit;





    }

    else

    {

            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));



            exit;

    }

}
public function get_approved()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
		 
		$this->data['approved_list']=$this->approved_mdl->get_approved_list();
			

		unset($this->data['approved_list']["totalfilteredrecs"]);
	  	unset($this->data['approved_list']["totalrecs"]);
		 	// echo $this->db->last_query();
		 	// die();
		 	// echo "<pre>";
		 	// print_r($this->data['country_list']);die;
	  	// echo "<pre>";
		 	// print_r($this->data['approved_list']);die;
		 echo json_encode($this->data['approved_list']);
		 	

		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
}

}



/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */