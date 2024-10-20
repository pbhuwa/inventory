<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Equipments extends CI_Controller

{

	function __construct()

	{

			

		parent::__construct();

		$this->load->Model('equipment_mdl');

		$this->locationid = $this->session->userdata(LOCATION_ID);

     	$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);



		

	}



	public function index()

    {



		//$this->data['equipment_all'] = $this->equipment_mdl->get_all_equipment();



		$this->data['editurl']=base_url().'biomedical/equipments/editdeequipment';

		$this->data['deleteurl']=base_url().'biomedical/equipments/deletedeequipment';

		$this->data['listurl']=base_url().'biomedical/equipments/list_of_equipment';

		$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');

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

			->build('equipment_lists/v_equipment_lists', $this->data);

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



		public function check_for_incharge()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$department_id=$this->input->post('depid');

			#select from staff where dept id='' and position_name='incharge';

			$eqcode=$this->equipment_mdl->check_for_available_incharge($department_id);

			

			// print_r($eqcode);

			// die();

		 		

		 	// echo json_encode($eqcode);

		 	echo (json_encode(array('datas'=>$eqcode,'status'=>'success')));

		 	exit;

		 	}

		 	

		

		else

		{

		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}

	}





	public function get_category_code()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$equipment=$this->input->post('equipment');

			if(!empty($equipment))

		 	{

		 		$wordcount=str_word_count($equipment);

		 		// echo $wordcount;



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



		 		if($wordcount>3)

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



	public function equipment_reload()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			//$material_typeid = $this->input->post('material_typeid');



			// $subcategory=$this->equipment_mdl->get_all_equipment_cat(array('eqca_equiptypeid'=>$material_typeid));

			$subcategory=$this->equipment_mdl->get_all_equipment_cat();

			$tempform='';

			$tempform.='<select name="itli_catid" class="form-control select2" id="item_catid" >';

			$tempform.='<option value="">---select---</option>';

			 if($subcategory):



            foreach ($subcategory as $km => $cat):

 			$tempform.='<option value="'.$cat->eqca_equipmentcategoryid.'">'.$cat->eqca_category.'</option>';

             

            endforeach;

          endif;

          $tempform.='</select>';

          echo json_encode($tempform);

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}

	}





	public function brand_reload()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$subunit=$this->equipment_mdl->get_all_brand();

			$tempform='';

			$tempform.='<select name="itli_branid" class="form-control select2" id="item_branid" >';

			 $tempform.='<option value="">---select---</option>';

			 if($subunit):



            foreach ($subunit as $ku => $cat):

            	//

 			$tempform.='<option value="'.$cat->bran_brandid.'">'.$cat->bran_name.'</option>';

             

            endforeach;

          endif;

          $tempform.='</select>';

          echo json_encode($tempform);

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}

	}





	public function designation_reload()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$subdesignation=$this->equipment_mdl->get_all_designation();

			$tempform='';

			$tempform.='<select name="usma_desiid" class="form-control select2" id="usma_desiid" >';

			 $tempform.='<option value="">---select---</option>';

			 if($subdesignation):



            foreach ($subdesignation as $ku => $desi):

            	//

 			$tempform.='<option value="'.$desi->desi_designationid.'">'.$desi->desi_designationname.'</option>';

             

            endforeach;

          endif;

          $tempform.='</select>';

          echo json_encode($tempform);

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}

	}



	public function unit_reload()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$subunit=$this->equipment_mdl->get_all_units();

			$tempform='';

			$tempform.='<select name="itli_unitid" class="form-control select2" id="item_unitid" >';

			 $tempform.='<option value="">---select---</option>';

			 if($subunit):



            foreach ($subunit as $ku => $cat):

            	//

 			$tempform.='<option value="'.$cat->unit_unitid.'">'.$cat->unit_unitname.'</option>';

             

            endforeach;

          endif;

          $tempform.='</select>';

          echo json_encode($tempform);

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



		public function delete_equip_cat()

    {

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_DELETE=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}



			$id=$this->input->post('id');





			$trans=$this->equipment_mdl->delete_equipmentcategory();

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

			  	$array=array();

                echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));

                exit;

			}

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);



		$orgid = $this->session->userdata(ORG_ID);

		/*if($useraccess == 'B')

		{	

			$data = $this->equipment_mdl->get_dequipment_list();//echo "<pre>"; print_r($data); die();

		}

		else{

			$data = $this->equipment_mdl->get_dequipment_list(array('eqli_orgid'=>$orgid));

		}*/

		if($useraccess == 'B' || 'S')

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

			      $array[$i]["equipmenttype"] = $row->eqty_equipmenttype;

			    $array[$i]["equ_code"] = $row->eqli_code;

			    $array[$i]["description"] = $row->eqli_description;

			    

			    $array[$i]["comment"] = $row->eqli_comment;

			    if(DEFAULT_DATEPICKER=='NP') 

			    {

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



public function equipment_cat($reload=false)

{

	 	$this->data['editurl']=base_url().'biomedical/equipments/edit_equip_cat';

		$this->data['deleteurl']=base_url().'biomedical/equipments/delete_equip_cat';

		$this->data['listurl']=base_url().'biomedical/equipments/list_of_equip_cat';

		$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');

		$this->data['material_type']=$this->general->get_tbl_data('*','maty_materialtype',array('maty_isactive'=>'Y'));

		$this->data['equipmnt_category']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_category','ASC');

		// echo "<pre>";

		// print_r($this->data['equipment_all']);

		// die();

		if($reload=='reload'){

			 if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='army'){

                $this->load->view('equipment_category/'.REPORT_SUFFIX.'/v_equipment_categoryform',$this->data) ;

            }else{

            $this->load->view('equipment_category/v_equipment_categoryform',$this->data) ;    

            }



		}else{

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

		

}	





public function equipment_cat_popup()

{

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$this->data['savelist']='savelist';

	 	$this->data['editurl']=base_url().'biomedical/equipments/edit_equip_cat';

		$this->data['deleteurl']=base_url().'biomedical/equipments/delete_equip_cat';

		$this->data['listurl']=base_url().'biomedical/equipments/list_of_equip_cat';

		$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');

		$this->data['equipmnt_category']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_category','ASC');

		$this->data['material_type']=$this->general->get_tbl_data('*','maty_materialtype',array('maty_isactive'=>'Y'));

	 	$tempform='';

	 	if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='army'){

	 			 	$tempform .=$this->load->view('equipment_category/'.REPORT_SUFFIX.'/v_equipment_categoryform',$this->data,true);

	 			 	$tempform .=$this->load->view('equipment_category/'.REPORT_SUFFIX.'/v_equipment_category_list',$this->data,true);



	 	}else{

	 	$tempform .=$this->load->view('equipment_category/v_equipment_categoryform',$this->data,true);

	 	$tempform .=$this->load->view('equipment_category/v_equipment_category_list',$this->data,true);



	 	}



	 	

	 	// echo $tempform;

	 	// die();

		if(!empty($tempform))

		{

			print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$tempform)));

        	exit;

		}

		else{

		print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));

        	exit;

		}

         

	 }



	 else

	    {

	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	            exit;

	    }



}













public function equipment_unit_popup()

{

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$this->data['savelist']='savelist';

	 	$this->data['editurl']=base_url().'biomedical/equipments/edit_equip_cat';

		$this->data['deleteurl']=base_url().'biomedical/equipments/delete_equip_cat';

		$this->data['listurl']=base_url().'biomedical/equipments/list_of_equip_cat';



		// $this->data['editurl']=base_url().'settings/units/editunits';

		// $this->data['deleteurl']=base_url().'settings/units/deleteunits';

		// $this->data['listurl']=base_url().'settings/units/listunits';



		$this->data['unit']=$this->general->get_tbl_data('*','unit_unit',false,'unit_unitname','ASC');

		

	 	$tempform='';



	 	$tempform .=$this->load->view('units/v_units_form',$this->data,true);



	 	$tempform .=$this->load->view('units/v_units_list',$this->data,true);

	 	// echo $tempform;

	 	// die();

		if(!empty($tempform))

		{

			print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$tempform)));

        	exit;

		}

		else{

		print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));

        	exit;

		}

         

	 }



	 else

	    {

	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	            exit;

	    }



}	



public function form_units()

	{





	     

        $this->data['units_all']=$this->units_mdl->get_all_units();



		$this->load->view('units/v_units_form',$this->data);

	}







public function listunits()

{

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {



				$this->data['units_all']=$this->units_mdl->get_all_units();



			$template=$this->load->view('units/v_units_list',$this->data,true);



			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));



	   		 exit;	



			}



			else



			{



			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));



	        exit;



			}

}









public function save_units()

{





		if ($_SERVER['REQUEST_METHOD'] === 'POST') 

		{





			try

			{





				$id=$this->input->post('id');





				// if($id)





				// {





				// $this->form_validation->set_rules($this->units_mdl->validate_settings_menu_edit);





				// }





				// else





				// {





				$this->form_validation->set_rules($this->units_mdl->validate_settings_units);





				// }





			





			  	if($this->form_validation->run()==TRUE)

			 	{



            	$trans = $this->units_mdl->units_save();

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



        	}

        	catch (Exception $e)

        	{

            print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));

        	}





    		}





	 		else





    		{





    		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));





            exit;





    		}

}



public function editunits()

{





	if ($_SERVER['REQUEST_METHOD'] === 'POST') {





		$id=$this->input->post('id');





		$this->data['units_all']=$this->units_mdl->get_all_units();





	





		$this->data['units_data']=$this->units_mdl->get_all_units(array('unit_unitid'=>$id));





		// echo "<pre>";





		// print_r($this->data['units_all']);





		// die();





		$tempform=$this->load->view('units/v_units_form',$this->data,true);





		// echo $tempform;





		// die();





		if(!empty($this->data['units_data']))





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



public function deleteunits()

{





	if ($_SERVER['REQUEST_METHOD'] === 'POST') {





		$id=$this->input->post('id');





		





		$trans=$this->units_mdl->remove_units();





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

}

public function exists_unitname()

{





		$unitsname=$this->input->post('unit_unitname');





		$id=$this->input->post('id');





		$unitsnamechk=$this->units_mdl->check_exist_unitname_for_other($unitsname,$id);





		if($unitsnamechk)





		{





			$this->form_validation->set_message('exists_unitname', 'Already Exist modulekey!');





			return false;











		}





		else





		{





			return true;





		}

}



// public function form_units()

// 	{





	     

//         $this->data['units_all']=$this->units_mdl->get_all_units();



// 		$this->load->view('units/v_units_form',$this->data);

// 	}







// public function listunits()

// {

// 			if ($_SERVER['REQUEST_METHOD'] === 'POST') {



// 				$this->data['units_all']=$this->units_mdl->get_all_units();



// 			$template=$this->load->view('units/v_units_list',$this->data,true);



// 			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));



// 	   		 exit;	



// 			}



// 			else



// 			{



// 			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));



// 	        exit;



// 			}

// }









// public function save_units()

// {





// 		if ($_SERVER['REQUEST_METHOD'] === 'POST') 

// 		{





// 			try

// 			{





// 				$id=$this->input->post('id');





// 				// if($id)





// 				// {





// 				// $this->form_validation->set_rules($this->units_mdl->validate_settings_menu_edit);





// 				// }





// 				// else





// 				// {





// 				$this->form_validation->set_rules($this->units_mdl->validate_settings_units);





// 				// }





			





// 			  	if($this->form_validation->run()==TRUE)

// 			 	{



//             	$trans = $this->units_mdl->units_save();

//             	if($trans)

//             	{

//             	  print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));

//             	exit;

//             	}

//             	else

//            	 	{

//             	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));

//             	exit;

//             	}

//         		}

//         	else

// 			{

// 			print_r(json_encode(array('status'=>'error','message'=>validation_errors())));

// 				exit;

// 			}



//         	}

//         	catch (Exception $e)

//         	{

//             print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));

//         	}





//     		}





// 	 		else





//     		{





//     		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));





//             exit;





//     		}

// }



// public function editunits()

// {





// 	if ($_SERVER['REQUEST_METHOD'] === 'POST') {





// 		$id=$this->input->post('id');





// 		$this->data['units_all']=$this->units_mdl->get_all_units();





	





// 		$this->data['units_data']=$this->units_mdl->get_all_units(array('unit_unitid'=>$id));





// 		// echo "<pre>";





// 		// print_r($this->data['units_all']);





// 		// die();





// 		$tempform=$this->load->view('units/v_units_form',$this->data,true);





// 		// echo $tempform;





// 		// die();





// 		if(!empty($this->data['units_data']))





// 		{





// 				print_r(json_encode(array('status'=>'success','message'=>'You Can edit','tempform'=>$tempform)));





//             	exit;





// 		}





// 		else{





// 			print_r(json_encode(array('status'=>'error','message'=>'Unable to Edit!!')));





//             	exit;





// 		}





// 	}





// 	else





// 	{





// 	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));





//         exit;





// 	}

// }



// public function deleteunits()

// {





// 	if ($_SERVER['REQUEST_METHOD'] === 'POST') {





// 		$id=$this->input->post('id');





		





// 		$trans=$this->units_mdl->remove_units();





// 		if($trans)





// 		{





// 			print_r(json_encode(array('status'=>'success','message'=>'Successfully Deleted!!')));





//        		 exit;	





// 		}





// 		else





// 		{





// 			print_r(json_encode(array('status'=>'error','message'=>'Error while deleting!!')));





//        		 exit;	





// 		}











// 	}

// }

// public function exists_unitname()

// {





// 		$unitsname=$this->input->post('unit_unitname');





// 		$id=$this->input->post('id');





// 		$unitsnamechk=$this->units_mdl->check_exist_unitname_for_other($unitsname,$id);





// 		if($unitsnamechk)





// 		{





// 			$this->form_validation->set_message('exists_unitname', 'Already Exist modulekey!');





// 			return false;











// 		}





// 		else





// 		{





// 			return true;





// 		}

// }

public function units_list()

{ 

       $data = $this->units_mdl->get_all_units_list();

	  	$i = 0;

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);

		//print_r($filtereddata);die;

		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);

	  	unset($data["totalrecs"]);

		  	foreach($data as $row)



            



		    {  



			    $array[$i]["unit_unitid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->unit_unitid.'>'.$row->unit_unitid.'</a>';			 

			    $array[$i]["unit_unitname"] = $row->unit_unitname;    			   

			    $array[$i]["unit_postdatebs"] = $row->unit_postdatebs;

			    if($row->unit_isactive=='Y') $status="Active"; else  $status= "Inactive";

			    $array[$i]["unit_isactive"] = $status;

			 



				$array[$i]["action"] ='<a href="javascript:void(0)" 

				data-id='.$row->unit_unitid.' data-displaydiv="units"

				data-editurl='.base_url('settings/units/edit_units').' class="btnEdit" ><i 

				class="fa fa-edit" aria-hidden="true" ></i></a>|





				<a href="javascript:void(0)"  data-id='.$row->unit_unitid.' data-tableid='.($i+1).' 

				data-deleteurl='. base_url('settings/units/deleteunits') .' 

				class="btnDelete"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>

				';

			

			    $i++;

		        //(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');

		    }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

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

			$this->data['eqli_data']=$this->equipment_mdl->get_all_equipment_cat(array('ec.eqca_equipmentcategoryid'=>$id));

				// echo "<pre>";

				// print_r($this->data['eqli_data']);

				// die();

			if($this->data['eqli_data'])

				{

				$dep_date=$this->data['eqli_data'][0]->eqca_postdatead;

				$dep_time=$this->data['eqli_data'][0]->eqca_posttime;

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





public function exists_eqcategory()

	{

		$eqli_cat=$this->input->post('eqca_category');

		$id=$this->input->post('id');

		$eqpcode=$this->equipment_mdl->check_exit_category_for_other($eqli_cat,$id);

		// print_r($eqpcode);

		// die();

		// echo $this->db->last_query();

		// die();

		if($eqpcode)

		{

			$this->form_validation->set_message('exists_eqcategory', 'Already Exit Item Category !!');

			return false;

		}

		else

		{

			return true;

			

		}

}



public function exists_eqcategory_code()

	{

		$eqca_code=$this->input->post('eqca_code');

		$id=$this->input->post('id');

		$eqpcode=$this->equipment_mdl->check_exit_category_code_for_other($eqca_code,$id);

		// print_r($eqpcode);

		// die();

		// echo $this->db->last_query();

		// die();

		if($eqpcode)

		{

			$this->form_validation->set_message('exists_eqcategory_code', 'Already Exit Item Category Code !!');

			return false;

		}

		else

		{

			return true;

			

		}

}







	public function get_equipment_cat_list()

	{

		// if(MODULES_VIEW=='N')

		// 	{

		// 	  	$array=array();

  //               echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));

  //               exit;

		// 	}

		if(MODULES_VIEW=='N')

		{

			 $array["eqca_equipmentcategoryid"]='';

			 $array["eqca_category"] ='';

			 $array["eqca_code"]='';

			 $array["eqty_equipmenttype"]='';

			 $array["parent_cat"]='';

			 $array["eqli_postdate"] ='';

			 $array["eqli_postdate"]='';

             $array["action"]='';

			  echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));

                exit;

		}

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);

		$orgid = $this->session->userdata(ORG_ID);

		// if($useraccess == 'B')

		// {	

		// 	$data = $this->equipment_mdl->get_equipment_cat_list();//echo "<pre>"; print_r($data); die();

		// }

		// else{

		// 	$data = $this->equipment_mdl->get_equipment_cat_list(array('ec.eqca_equiptypeid'=>$orgid));

		// }

		if($this->location_ismain == 'Y'){

			

			if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='PU'){

				$data = $this->equipment_mdl->get_equipment_cat_list_ku();

			}else{

				$data = $this->equipment_mdl->get_equipment_cat_list();

			}

		}

		else{

		if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='PU'){

				$data = $this->equipment_mdl->get_equipment_cat_list_ku();

				// $data = $this->equipment_mdl->get_equipment_cat_list_ku(array('ec.eqca_locationid'=>$this->locationid));

			}else{

				$data = $this->equipment_mdl->get_equipment_cat_list(array('ec.eqca_locationid'=>$this->locationid));

			}

		}

		 // echo "<pre>";

		 // print_r($data);

		 // die();

		// echo $this->db->last_query();

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

			    $array[$i]["isitdep"] = $row->isitdep;

			    $array[$i]["isnonexp"] = $row->eqca_isnonexp;

			    $array[$i]["mattype"]=!empty($row->maty_material)?$row->maty_material:'';

			    

			   

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

			if(ORGANIZATION_NAME=='KU'){

				$template=$this->load->view('equipment_category/'.REPORT_SUFFIX.'/v_equipment_category_list',$data,true);

			}else{

				$template=$this->load->view('equipment_category/v_equipment_category_list',$data,true);

			}

			

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

			$this->data['eqli_data']=$this->equipment_mdl->get_all_equipment_cat(array('ec.eqca_equipmentcategoryid'=>$id));

			$this->data['equipmnt_category']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','ASC');

			$this->data['material_type']=$this->general->get_tbl_data('*','maty_materialtype',array('maty_isactive'=>'Y'));

			// echo "<pre>";

			// print_r($this->data['eqli_data']);

			// die();

		if($this->data['eqli_data'])

		{

			$dep_date=$this->data['eqli_data'][0]->eqca_postdatead;

			$dep_time=$this->data['eqli_data'][0]->eqca_posttime;

			$editstatus='';

			if(!empty($dep_date) && !empty($dep_time) ){

					$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);

			}

		

			// echo $editstatus;

			// die();

			$this->data['edit_status']=$editstatus;



		}

		 if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='army'){

                $tempform = $this->load->view('equipment_category/'.REPORT_SUFFIX.'/v_equipment_categoryform',$this->data,true) ;

            }else{

            $tempform =$this->load->view('equipment_category/v_equipment_categoryform',$this->data,true) ;    

            }



			

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



	public function generate_items_category_list_excel(){

		header("Content-Type: application/xls");    

        header("Content-Disposition: attachment; filename=items_category_list_".date('Y_m_d_H_i').".xls");  

        header("Pragma: no-cache"); 

        header("Expires: 0");

        

        $data = $this->equipment_mdl->get_equipment_cat_list();

        $this->data['searchResult'] = $this->equipment_mdl->get_equipment_cat_list();

        

        $array = array();



     	$this->data['iDisplayStart'] = !empty($_GET['iDisplayStart'])?$_GET['iDisplayStart']:0;



		unset($this->data['searchResult']["totalfilteredrecs"]);

        unset($this->data['searchResult']["totalrecs"]);



        $response = $this->load->view('equipment_category/v_equipment_category_download', $this->data, true);



        echo $response;

	}





}



/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */