<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Material_type extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('equipment_mdl');
		
	}

	public function index()
    {

		//$this->data['equipment_all'] = $this->equipment_mdl->get_all_equipment();

		$this->data['editurl']=base_url().'biomedical/equipments/editmaterial';
		$this->data['deleteurl']=base_url().'biomedical/equipments/deletematerial';
		$this->data['listurl']=base_url().'biomedical/equipments/list_of_material';
		$this->data['material_type']=$this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','ASC');
		// echo "<pre>";
		// print_r($this->data['equipment_all']);
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
			->build('materials/v_material_masterlist', $this->data);
	}

	public function save_equipment()
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
			if($id)
			{
					$this->data['eqli_data']=$this->equipment_mdl->get_all_equipment(array('eq.eqli_equipmentlistid'=>$id));
				// echo "<pre>";
				// print_r($data['dept_data']);
				// die();
			if($this->data['eqli_data'])
			{
				$dep_date=$this->data['eqli_data'][0]->eqli_postdatead;
				$dep_time=$this->data['eqli_data'][0]->eqli_posttime;
				$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
				$usergroup=$this->session->userdata(USER_GROUPCODE);
				
				if($editstatus==0 && $usergroup!='SA' )
				{
					   $this->general->disabled_edit_message();

				}

			}
			}
		
			
			$this->form_validation->set_rules($this->equipment_mdl->validate_settings_equipment);
			
			
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->equipment_mdl->save_equipment();
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
	public function form_equipment()
		{
			$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
			$this->load->view('equipment_lists/v_equipment_listsform',$this->data);
		}

	public function get_equipments_from_eqtypeid()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$eqtypeid=$this->input->post('eqtypeid');
			if(!empty($eqtypeid))
		 	{
		 	
		 	$this->data['eqtype']=$this->equipment_mdl->get_all_equipment(array('eq.eqli_equipmenttypeid'=>$eqtypeid));
		 	// echo $this->db->last_query();
		 	// die();
		 	// echo "<pre>";
		 	// print_r($this->data['eqtype']);die;
		 	echo json_encode($this->data['eqtype']);
		 	}
		 	else
		 	{
		 		echo json_encode(array());
		 	}

		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}


	public function get_equipments_code()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$equipment=$this->input->post('equipment');
			if(!empty($equipment))
		 	{
		 		$wordcount=str_word_count($equipment);
		 		if($wordcount==1)
		 		{
		 			$eqcode= strtoupper(substr($equipment, 0, 3));
		 		}
		 		if($wordcount==2)
		 		{
		 			$stringarray= explode(' ', $equipment);
		 			// print_r($stringarray);
		 			$str1= strtoupper(substr($stringarray[0], 0, 2));
		 			$str2= strtoupper(substr($stringarray[1], 0, 1));
		 			$eqcode= $str1.$str2;	
		 		}
		 		if($wordcount==3)
		 		{
		 			$stringarray= explode(' ', $equipment);
		 			// print_r($stringarray);
		 			$str1= strtoupper(substr($stringarray[0], 0, 1));
		 			$str2= strtoupper(substr($stringarray[1], 0, 1));
		 			$str3= strtoupper(substr($stringarray[2], 0, 1));

		 			$eqcode= $str1.$str2.$str3;	
		 		}

		 		if($wordcount==4)
		 		{
		 			$stringarray= explode(' ', $equipment);
		 			// print_r($stringarray);
		 			$str1= strtoupper(substr($stringarray[0], 0, 1));
		 			$str2= strtoupper(substr($stringarray[1], 0, 1));
		 			$str3= strtoupper(substr($stringarray[2], 0, 1));
		 			$str4= strtoupper(substr($stringarray[3], 0, 1));

		 			$eqcode= $str1.$str2.$str3;	
		 		}
		 		

		 		
		 	
		 	
		 	echo json_encode($eqcode);
		 	}
		 	else
		 	{
		 		echo json_encode(array());
		 	}

		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}


	public function list_of_equipment()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_VIEW=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			$data=array();
			$template=$this->load->view('equipment_lists/v_equipment_lists_list',$data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function editdeequipment()
	{   

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_UPDATE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			$id=$this->input->post('id');
		$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
			$this->data['eqli_data']=$this->equipment_mdl->get_all_equipment(array('eq.eqli_equipmentlistid'=>$id));
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
			$tempform = $this->load->view('equipment_lists/v_equipment_listsform',$this->data,true);
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

	public function deletedeequipment()
    {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_DELETE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}

			$id=$this->input->post('id');


			$trans=$this->equipment_mdl->remove_equipment();
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

	

		

	public function get_equipment_list()
	{
		if(MODULES_VIEW=='N')
			{
			  	$array["equipmentlistid"] ='';
			    $array["description"] = '';
			    $array["equ_code"] =''; '';
			    $array["equipmenttype"] = '';
			    $array["comment"] = '';
			    $array["eqli_postdate"] = '';
                $array["action"]='';
                echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));
                exit;
			}
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		$orgid = $this->session->userdata(ORG_ID);
		if($useraccess == 'B')
		{	
			$data = $this->equipment_mdl->get_dequipment_list();//echo "<pre>"; print_r($data); die();
		}
		else{
			$data = $this->equipment_mdl->get_dequipment_list(array('eqli_orgid'=>$orgid));
		}
		 
	  	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  
		  	foreach($data as $row)
		    {
		   
			    $array[$i]["equipmentlistid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->eqli_equipmentlistid.'>'.$row->eqli_equipmentlistid.'</a>';
			    $array[$i]["description"] = $row->eqli_description;
			    $array[$i]["equ_code"] = $row->eqli_code;
			      $array[$i]["equipmenttype"] = $row->eqty_equipmenttype;
			    
			    $array[$i]["comment"] = $row->eqli_comment;
			    if(DEFAULT_DATEPICKER=='NP') {
			    	$array[$i]["eqli_postdate"] = $row->eqli_postdatebs;
                                
	            }else{
	            	$array[$i]["eqli_postdate"] = $row->eqli_postdatead;
                };
			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->eqli_equipmentlistid.' data-displaydiv="equipments" data-viewurl='.base_url('biomedical/equipments/editdeequipment').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>
			    <a href="javascript:void(0)" data-id='.$row->eqli_equipmentlistid.' data-tableid='.($i+1).' data-deleteurl='. base_url('biomedical/equipments/deletedeequipment') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>
			    ';
			     
			    $i++;
		        //(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

public function exists_equipcode()
	{
		$eqli_code=$this->input->post('eqli_code');
		$id=$this->input->post('id');
		$eqpcode=$this->equipment_mdl->check_exit_equipment_for_other($eqli_code,$id);
		// print_r($eqpcode);
		// die();
		// echo $this->db->last_query();
		// die();
		if($eqpcode)
		{
			$this->form_validation->set_message('exists_equipcode', 'Already Equipment Code!!');
			return false;
		}
		else
		{
			return true;
			
		}
}

public function exists_equipdesc()
	{
		$eqli_description=$this->input->post('eqli_description');
		$id=$this->input->post('id');
		$eqdesc=$this->equipment_mdl->check_exit_equipment_desc_for_other($eqli_description,$id);
		// print_r($eqdesc);
		// die();
		// echo $this->db->last_query();
		// die();
		if($eqdesc)
		{
			$this->form_validation->set_message('exists_equipdesc', 'Already Equipment Description!!');
			return false;
		}
		else
		{
			return true;
			
		}
}

public function equipment_cat()
{
	 	$this->data['editurl']=base_url().'biomedical/equipments/edit_equip_cat';
		$this->data['deleteurl']=base_url().'biomedical/equipments/delete_equip_cat';
		$this->data['listurl']=base_url().'biomedical/equipments/list_of_equip_cat';
		$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		$this->data['equipmnt_category']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_category','ASC');
		// echo "<pre>";
		// print_r($this->data['equipment_all']);
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
			->build('equipment_category/v_equipment_category', $this->data);
}	


public function save_equipment_cat()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {

			// echo MODULES_INSERT;
			// die();
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
			if($id)
			{
					$this->data['eqli_data']=$this->equipment_mdl->get_all_equipment(array('eq.eqli_equipmentlistid'=>$id));
				// echo "<pre>";
				// print_r($data['dept_data']);
				// die();
			if($this->data['eqli_data'])
			{
				$dep_date=$this->data['eqli_data'][0]->eqli_postdatead;
				$dep_time=$this->data['eqli_data'][0]->eqli_posttime;
				$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
				$usergroup=$this->session->userdata(USER_GROUPCODE);
				
				if($editstatus==0 && $usergroup!='SA' )
				{
					   $this->general->disabled_edit_message();

				}

			}
			}
		
			
			$this->form_validation->set_rules($this->equipment_mdl->validate_settings_equipment_cat);
			
			
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->equipment_mdl->save_equipment_cat();
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



	public function get_equipment_cat_list()
	{
		if(MODULES_VIEW=='N')
			{
			  	$array=array();
                echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));
                exit;
			}
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		$orgid = $this->session->userdata(ORG_ID);
		if($useraccess == 'B')
		{	
			$data = $this->equipment_mdl->get_equipment_cat_list();//echo "<pre>"; print_r($data); die();
		}
		else{
			$data = $this->equipment_mdl->get_equipment_cat_list(array('ec.eqca_equiptypeid'=>$orgid));
		}
		 // echo "<pre>";
		 // print_r($data);
		 // die();


	  	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  
		  	foreach($data as $row)
		    {
		   
			    $array[$i]["eqca_equipmentcategoryid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->eqca_equipmentcategoryid.'>'.$row->eqca_equipmentcategoryid.'</a>';
			    $array[$i]["eqca_category"] = $row->eqca_category;
			    $array[$i]["eqca_code"] = $row->eqca_code;
			    $array[$i]["eqty_equipmenttype"] = $row->eqty_equipmenttype;
			    $array[$i]["parent_cat"] = $row->parent_cat;
			    
			   
			    if(DEFAULT_DATEPICKER=='NP') {
			    	$array[$i]["eqli_postdate"] = $row->eqca_postdatebs;
                                
	            }else{
	            	$array[$i]["eqli_postdate"] = $row->eqca_postdatead;
                };
			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->eqca_equipmentcategoryid.' data-displaydiv="equipments" data-viewurl='.base_url('biomedical/equipments/edit_equip_cat').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>
			    <a href="javascript:void(0)" data-id='.$row->eqca_equipmentcategoryid.' data-tableid='.($i+1).' data-deleteurl='. base_url('biomedical/equipments/delete_equip_cat') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>
			    ';
			     
			    $i++;
		        //(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}


public function form_equipment_category()
{
	$this->data['editurl']=base_url().'biomedical/equipments/edit_equip_cat';
		$this->data['deleteurl']=base_url().'biomedical/equipments/delete_equip_cat';
		$this->data['listurl']=base_url().'biomedical/equipments/list_of_equip_cat';
		$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		$this->data['equipmnt_category']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_category','ASC');
	 $this->load->view('equipment_category/v_equipment_categoryform',$this->data);
}


public function list_of_equip_cat()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_VIEW=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			$data=array();
			$template=$this->load->view('equipment_category/v_equipment_category_list',$data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}


	public function edit_equip_cat()
	{   

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_UPDATE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			$id=$this->input->post('id');
			$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
			$this->data['eqli_data']=$this->equipment_mdl->get_all_equipment(array('eq.eqli_equipmentlistid'=>$id));
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
			$tempform = $this->load->view('eequipment_category/v_equipment_categoryform',$this->data,true);
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


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */