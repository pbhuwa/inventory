<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Material_type extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('Material_mdl');
		
	}

	public function index()
    {

		//$this->data['material_all'] = $this->material_mdl->get_all_material();

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
			$id=$this->input->post('id');
			// if($id)
			// {
			// $this->form_validation->set_rules($this->staff_manager_mdl->validate_settings_menu_edit);
			// }
			// else
			// {
			$this->form_validation->set_rules($this->material_mdl->validate_settings_material);
			// }
			
			  if($this->form_validation->run()==TRUE)
			 {

        	 $trans = $this->material_mdl->save_material();
            if($trans)
            {
            	  print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
            	exit;
            }
            else
            {
            	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
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
		$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_materialtype',false,'eqty_materialtypeid','ASC');
			$this->data['eqli_data']=$this->material_mdl->get_all_material(array('eq.eqli_materiallistid'=>$id));
			// echo "<pre>";
			// print_r($data['eqli_data']);
			// die();
		if($this->data['eqli_data'])
		{
			$dep_date=$this->data['eqli_data'][0]->eqli_postdatead;
			$dep_time=$this->data['eqli_data'][0]->eqli_posttime;
			$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
			// echo $editstatus;
			// die();
			$this->data['edit_status']=$editstatus;

		}
			$tempform = $this->load->view('material_lists/v_material_listsform',$this->data,true);
			// echo $tempform;
			// die();
			if(!empty($this->data['eqli_data']))
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


			$trans=$this->material_mdl->remove_material();
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
			    
                echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));
                exit;
			}
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		$orgid = $this->session->userdata(ORG_ID);
		if($useraccess == 'B')
		{	
			$data = $this->material_mdl->get_dmaster_list();//echo "<pre>"; print_r($data); die();
		}
		else{
			$data = $this->material_mdl->get_dmaster_list(array('maty_materialtypeid'=>$orgid));
		}
		 
	  	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  
		  	foreach($data as $row)
		    {
		   
			    $array[$i]["materialtypeid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->maty_materialtypeid.'>'.$row->maty_materialtypeid.'</a>';
			    $array[$i]["material"] = $row->maty_material;
			    
			    
			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->eqli_materialtypeid.' data-displaydiv="materials" data-viewurl='.base_url('stock_inventory/Material_type/editdematerial').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>
			    <a href="javascript:void(0)" data-id='.$row->maty_materialtypeid.' data-tableid='.($i+1).' data-deleteurl='. base_url('stock_inventory/Material_type/deletedematerial') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>';
			     
			    $i++;
		        //(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

// public function exists_equipcode()
// 	{
// 		$eqli_code=$this->input->post('eqli_code');
// 		$id=$this->input->post('id');
// 		$eqpcode=$this->material_mdl->check_exit_material_for_other($eqli_code,$id);
// 		// print_r($eqpcode);
// 		// die();
// 		// echo $this->db->last_query();
// 		// die();
// 		if($eqpcode)
// 		{
// 			$this->form_validation->set_message('exists_equipcode', 'Already material Code!!');
// 			return false;
// 		}
// 		else
// 		{
// 			return true;
			
// 		}
// }

// public function exists_equipdesc()
// 	{
// 		$eqli_description=$this->input->post('eqli_description');
// 		$id=$this->input->post('id');
// 		$eqdesc=$this->material_mdl->check_exit_material_desc_for_other($eqli_description,$id);
// 		// print_r($eqdesc);
// 		// die();
// 		// echo $this->db->last_query();
// 		// die();
// 		if($eqdesc)
// 		{
// 			$this->form_validation->set_message('exists_equipdesc', 'Already material Description!!');
// 			return false;
// 		}
// 		else
// 		{
// 			return true;
			
// 		}
// }

// public function material_cat()
// 	{
// 	 	$this->data['editurl']=base_url().'biomedical/materials/edit_equip_cat';
// 		$this->data['deleteurl']=base_url().'biomedical/materials/delete_equip_cat';
// 		$this->data['listurl']=base_url().'biomedical/materials/list_of_equip_cat';
// 		$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_materialtype',false,'eqty_materialtypeid','ASC');
// 		$this->data['equipmnt_category']=$this->general->get_tbl_data('*','eqca_materialcategory',false,'eqca_category','ASC');
// 		// echo "<pre>";
// 		// print_r($this->data['material_all']);
// 		// die();
// 		$seo_data='';
// 		if($seo_data)
// 		{
// 			//set SEO data
// 			$this->page_title = $seo_data->page_title;
// 			$this->data['meta_keys']= $seo_data->meta_key;
// 			$this->data['meta_desc']= $seo_data->meta_description;
// 		}
// 		else
// 		{
// 			//set SEO data
// 		    $this->page_title = ORGA_NAME;
// 		    $this->data['meta_keys']= ORGA_NAME;
// 		    $this->data['meta_desc']= ORGA_NAME;
// 		}

// 		$this->template
// 			->set_layout('general')
// 			->enable_parser(FALSE)
// 			->title($this->page_title)
// 			->build('material_category/v_material_category', $this->data);
// }	


// public function save_material_cat()
// 	{
// 		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// 		try {

// 			// echo MODULES_INSERT;
// 			// die();
// 			if($this->input->post('id'))
// 			{
// 				if(MODULES_UPDATE=='N')
// 				{
// 				$this->general->permission_denial_message();
// 				exit;
// 				}
// 			}
// 			else
// 			{
// 				if(MODULES_INSERT=='N')
// 				{
// 				$this->general->permission_denial_message();
// 				exit;
// 				}
// 			}

// 			$id=$this->input->post('id');
// 			if($id)
// 			{
// 					$this->data['eqli_data']=$this->material_mdl->get_all_material(array('eq.eqli_materiallistid'=>$id));
// 				// echo "<pre>";
// 				// print_r($data['dept_data']);
// 				// die();
// 			if($this->data['eqli_data'])
// 			{
// 				$dep_date=$this->data['eqli_data'][0]->eqli_postdatead;
// 				$dep_time=$this->data['eqli_data'][0]->eqli_posttime;
// 				$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
// 				$usergroup=$this->session->userdata(USER_GROUPCODE);
				
// 				if($editstatus==0 && $usergroup!='SA' )
// 				{
// 					   $this->general->disabled_edit_message();

// 				}

// 			}
// 			}
		
			
// 			$this->form_validation->set_rules($this->material_mdl->validate_settings_material_cat);
			
			
// 			  if($this->form_validation->run()==TRUE)
// 			 {

//             $trans = $this->material_mdl->save_material_cat();
//             if($trans)
//             {
//             	  print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
//             	exit;
//             }
//             else
//             {
//             	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
//             	exit;
//             }
//         }
//         else
// 		{
// 			print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
// 				exit;
// 		}
           
//         } catch (Exception $e) {
          
//             print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
//         }
//     }
// 	 else
// 	    {
// 	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
// 	            exit;
// 	    }
// 	}



// 	public function get_material_cat_list()
// 	{
// 		if(MODULES_VIEW=='N')
// 			{
// 			  	$array=array();
//                 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));
//                 exit;
// 			}
// 		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
// 		$orgid = $this->session->userdata(ORG_ID);
// 		if($useraccess == 'B')
// 		{	
// 			$data = $this->material_mdl->get_material_cat_list();//echo "<pre>"; print_r($data); die();
// 		}
// 		else{
// 			$data = $this->material_mdl->get_material_cat_list(array('ec.eqca_equiptypeid'=>$orgid));
// 		}
// 		 // echo "<pre>";
// 		 // print_r($data);
// 		 // die();


// 	  	$i = 0;
// 		$array = array();
// 		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
// 		$totalrecs = $data["totalrecs"];

// 	    unset($data["totalfilteredrecs"]);
// 	  	unset($data["totalrecs"]);
	  
// 		  	foreach($data as $row)
// 		    {
		   
// 			    $array[$i]["eqca_materialcategoryid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->eqca_materialcategoryid.'>'.$row->eqca_materialcategoryid.'</a>';
// 			    $array[$i]["eqca_category"] = $row->eqca_category;
// 			    $array[$i]["eqca_code"] = $row->eqca_code;
// 			    $array[$i]["eqty_materialtype"] = $row->eqty_materialtype;
// 			    $array[$i]["parent_cat"] = $row->parent_cat;
			    
			   
// 			    if(DEFAULT_DATEPICKER=='NP') {
// 			    	$array[$i]["eqli_postdate"] = $row->eqca_postdatebs;
                                
// 	            }else{
// 	            	$array[$i]["eqli_postdate"] = $row->eqca_postdatead;
//                 };
// 			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->eqca_materialcategoryid.' data-displaydiv="materials" data-viewurl='.base_url('biomedical/materials/edit_equip_cat').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>
// 			    <a href="javascript:void(0)" data-id='.$row->eqca_materialcategoryid.' data-tableid='.($i+1).' data-deleteurl='. base_url('biomedical/materials/delete_equip_cat') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>
// 			    ';
			     
// 			    $i++;
// 		        //(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');
// 		    }
//         echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
// 	}


// public function form_material_category()
// {
// 	$this->data['editurl']=base_url().'biomedical/materials/edit_equip_cat';
// 		$this->data['deleteurl']=base_url().'biomedical/materials/delete_equip_cat';
// 		$this->data['listurl']=base_url().'biomedical/materials/list_of_equip_cat';
// 		$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_materialtype',false,'eqty_materialtypeid','ASC');
// 		$this->data['equipmnt_category']=$this->general->get_tbl_data('*','eqca_materialcategory',false,'eqca_category','ASC');
// 	 $this->load->view('material_category/v_material_categoryform',$this->data);
// }


// public function list_of_material_cat()
// 	{
// 		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// 			if(MODULES_VIEW=='N')
// 				{
// 				$this->general->permission_denial_message();
// 				exit;
// 				}
// 			$data=array();
// 			$template=$this->load->view('material_category/v_material_category_list',$data,true);
// 			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
// 	   		 exit;	
// 		}
// 		else
// 		{
// 			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
// 	        exit;
// 		}
// 	}


// 	public function edit_equip_cat()
// 	{   

// 		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// 			if(MODULES_UPDATE=='N')
// 				{
// 				$this->general->permission_denial_message();
// 				exit;
// 				}
// 			$id=$this->input->post('id');
// 			$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_materialtype',false,'eqty_materialtypeid','ASC');
// 			$this->data['eqli_data']=$this->material_mdl->get_all_material(array('eq.eqli_materiallistid'=>$id));
// 			// echo "<pre>";
// 			// print_r($data['eqli_data']);
// 			// die();
// 		if($this->data['eqli_data'])
// 		{
// 			$dep_date=$this->data['eqli_data'][0]->eqli_postdatead;
// 			$dep_time=$this->data['eqli_data'][0]->eqli_posttime;
// 			$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
// 			// echo $editstatus;
// 			// die();
// 			$this->data['edit_status']=$editstatus;

// 		}
// 			$tempform = $this->load->view('ematerial_category/v_material_categoryform',$this->data,true);
// 			// echo $tempform;
// 			// die();
// 			if(!empty($this->data['eqli_data']))
// 			{
// 					print_r(json_encode(array('status'=>'success','message'=>'You Can edit','tempform'=>$tempform)));
// 	            	exit;
// 			}
// 			else{
// 				print_r(json_encode(array('status'=>'error','message'=>'Unable to Edit!!')));
// 	            	exit;
// 			}
// 		}
// 		else
// 		{
// 		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
// 	        exit;
// 		}

// 	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */