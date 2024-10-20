<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bio_medical_inventory extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('bio_medical_mdl');
		$this->load->Model('settings/department_mdl','department_mdl');
		$this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        $this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->helper('file');
		$this->load->helper('form');
		$this->load->library('ciqrcode');
		$this->load->Model('equipment_mdl');
		$this->sess_usercode = $this->session->userdata(USER_GROUPCODE);
		$this->sess_dept = $this->session->userdata(USER_DEPT);
	// echo "<pre>";
	// 				print_r($this->session);
	// 				die();
	// echo $this->session->userdata('org_id');
	// die();
	}

	
	public function index()
	{

		// echo BIOMEDICALID;
		// die();
		
		$this->data['equipment_list']=$this->bio_medical_mdl->get_equipmentlist();
		// $this->data['dep_information']=$this->bio_medical_mdl->get_departmentinfo();
		$this->data['dep_information']=$this->department_mdl->get_all_department(array('dept_deptype'=>BIOMEDICALID));
		$this->data['riskval_list']=$this->bio_medical_mdl->get_riskvalue();
		$this->data['manufacturer_list']=$this->bio_medical_mdl->get_manufacturer();
		$this->data['distributor_list']=$this->bio_medical_mdl->get_distributor_list();
		$this->data['purchase_donate']=$this->bio_medical_mdl->get_purchase_donate_list();
		$this->data['biomedical_inv_list']=$this->bio_medical_mdl->get_biomedical_inventory();
		$this->data['currencry']=$this->general->get_tbl_data('*', 'cuty_currencytype');
	    $this->data['listurl']=base_url().'biomedical/bio_medical_inventory/list_bio_medical_inv';
	    // if()
	    $arrysrch='';
	   $this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',$arrysrch,'eqty_equipmenttypeid','ASC');
	   
	    if($this->session->userdata(USER_ACCESS_TYPE)=='S')
      	{
      	 $arrysrch=array('eqty_equipmenttypeid'=>$this->session->userdata(ORG_ID));
       	 // $this->db->where('bmin_orgid',$this->session->userdata(ORG_ID));
      	}

	   $this->data['breadcrumb']='Equipments/Equipments Setup';
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
				->build('bio_medical_inventory/v_bio_medical_inventory', $this->data);
	}

	public function form_bio_inventory()
	{
		$this->data['equipment_list']=$this->bio_medical_mdl->get_equipmentlist();
		$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		// $this->data['dep_information']=$this->department_mdl->get_all_department(array('dept_deptype'=>B
		$this->data['dep_information']=$this->department_mdl->get_all_department(array('dept_deptype'=>BIOMEDICALID));
		$this->data['riskval_list']=$this->bio_medical_mdl->get_riskvalue();
		$this->data['manufacturer_list']=$this->bio_medical_mdl->get_manufacturer();
		$this->data['distributor_list']=$this->bio_medical_mdl->get_distributor_list();
		$this->data['purchase_donate']=$this->bio_medical_mdl->get_purchase_donate_list();
		$this->data['biomedical_inv_list']=$this->bio_medical_mdl->get_biomedical_inventory();
		$this->data['currencry']=$this->general->get_tbl_data('*', 'cuty_currencytype');
		$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');

	    $this->data['listurl']=base_url().'biomedical/bio_medical_inventory/list_bio_medical_inv';
	    $this->load->view('bio_medical_inventory/v_bio_medical_inventory_form_nphl',$this->data);
			// $this->load->view('bio_medical_inventory/v_bio_medical_inventoryform',$this->data);
	}

	public function bio_medical_inventory_nphl()
	{


		$this->data['equipment_list']=$this->bio_medical_mdl->get_equipmentlist();
		// $this->data['dep_information']=$this->bio_medical_mdl->get_departmentinfo();
		$this->data['dep_information']=$this->department_mdl->get_all_department(array('dept_deptype'=>BIOMEDICALID));
		$this->data['riskval_list']=$this->bio_medical_mdl->get_riskvalue();
		$this->data['manufacturer_list']=$this->bio_medical_mdl->get_manufacturer();
		$this->data['distributor_list']=$this->bio_medical_mdl->get_distributor_list();
		$this->data['purchase_donate']=$this->bio_medical_mdl->get_purchase_donate_list();
		$this->data['biomedical_inv_list']=$this->bio_medical_mdl->get_biomedical_inventory();
		$this->data['currencry']=$this->general->get_tbl_data('*', 'cuty_currencytype');
	    $this->data['listurl']=base_url().'biomedical/bio_medical_inventory/list_bio_medical_inv';
	    // if()
	    $arrysrch='';
	   $this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',$arrysrch,'eqty_equipmenttypeid','ASC');
	   
	    if($this->session->userdata(USER_ACCESS_TYPE)=='S')
      	{
      	 $arrysrch=array('eqty_equipmenttypeid'=>$this->session->userdata(ORG_ID));
       	 // $this->db->where('bmin_orgid',$this->session->userdata(ORG_ID));
      	}

	   $this->data['breadcrumb']='Equipments/Equipments Setup';
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
				->build('bio_medical_inventory/v_bio_medical_inventory_nphl', $this->data);

	}

	public function form_bio_inventory_nphl()
	{
		
		
	    $arrysrch='';
	   $this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',$arrysrch,'eqty_equipmenttypeid','ASC');
	   
	    if($this->session->userdata(USER_ACCESS_TYPE)=='S')
      	{
      	 $arrysrch=array('eqty_equipmenttypeid'=>$this->session->userdata(ORG_ID));
       	 // $this->db->where('bmin_orgid',$this->session->userdata(ORG_ID));
      	}


		$this->data['equipment_list']=$this->bio_medical_mdl->get_equipmentlist();//binocular
		$this->data['dep_information']=$this->department_mdl->get_all_department(array('dept_deptype'=>BIOMEDICALID));//radiology
		$this->data['riskval_list']=$this->bio_medical_mdl->get_riskvalue(); //1Y Annual
		$this->data['manufacturer_list']=$this->bio_medical_mdl->get_manufacturer(); // Nikon
		$this->data['distributor_list']=$this->bio_medical_mdl->get_distributor_list(); //NEW SUPRIME SUPPLIERS
		$this->data['purchase_donate']=$this->bio_medical_mdl->get_purchase_donate_list();
		$this->data['biomedical_inv_list']=$this->bio_medical_mdl->get_biomedical_inventory();
		$this->data['currencry']=$this->general->get_tbl_data('*', 'cuty_currencytype');
		$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		

	    $this->data['listurl']=base_url().'biomedical/bio_medical_inventory/list_bio_medical_inv';
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
		// $this->load->view('bio_medical_inventory/v_bio_medical_inventoryform',$this->data);
		$this->template
				->set_layout('general')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('bio_medical_inventory/v_bio_medical_inventory_form_nphl', $this->data);
	}

	public function get_all_biomedical_inv($result=false,$org_id=false)
	{
		$this->data['result']=$result;
		$this->data['org_id']=$org_id;
		//echo $result;die();
		$this->load->view('bio_medical_inventory/v_bio_medical_list',$this->data);
	}


//For Bnc Auto generate equipment code
	public function generate_equip_code_bnc()
	{
		$eqlist=$this->bio_medical_mdl->get_equipmentlist_for_code();
		// echo "<pre>";
		// print_r($eqlist);
		// die();
		$descid=array();
		foreach ($eqlist as $ke => $eql) {
			$descid[]=$eql->bmin_descriptionid;
		}
		// echo "<pre>";
		$unique_descid=array_unique($descid);
		// die();

		foreach ($unique_descid as $kde => $desid) {
			$i=1;
			// echo $desid;
			// echo "<br>";
			echo "<pre>";
			$eqcode=$this->bio_medical_mdl->get_equipmentlist_for_code(array('bmin_descriptionid'=>$desid));
			// print_r($eqcode);
			foreach ($eqcode as $ekc => $code) {
				$bmeqid=$code->bmin_equipid;
				$depcode=$code->dept_depcode;
				$sn=$i;
				$eqcode=$code->eqli_code;
				$yrs='2018';
				echo $concate_data=$depcode.'-'.$eqcode.'-'.$sn.'-'.$yrs;
				echo "<br>";
				$this->db->update('bmin_bmeinventory',array('bmin_equipmentkey'=>$concate_data),array('bmin_equipid'=>$bmeqid));
				
				$i++;

			}

		}


	}

	public function generate_equipment_code_nphl()
	{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$depid =$this->input->post('depid');
	$desc=$this->input->post('desc');
	$departmentinfo=$this->department_mdl->get_all_department(array('dept_depid'=>$depid));
	
		$depcode='';
		$descode='';
		$max_equipment='';
		$maxno=1;
		if(!empty($departmentinfo))
		{
			$depcode=$departmentinfo[0]->dept_depcode;
		}

		$equ_description=$this->general->get_tbl_data('*','eqli_equipmentlist',array('eqli_equipmentlistid'=>$desc));
		// echo "<pre>";
		// print_r($equ_description);
		// die();
		if(!empty($equ_description))
		{
			$descode=$equ_description[0]->eqli_code;
		}

		
		// echo $concate_data;
		// die();
		// echo json_encode(value)
		$this->db->select('bmin_equipmentkey');
		$this->db->from('bmin_bmeinventory');
		// $this->db->where('bmin_departmentid',$depid);
		$this->db->where('bmin_descriptionid',$desc);
		$this->db->where('bmin_isdelete','N');
		// $this->db->order_by('bmin_equipmentkey','DESC');
		$this->db->order_by('bmin_equipid','DESC');
		$this->db->limit(1);
		$result=$this->db->get()->row();
		// echo $this->db->last_query();
		// print_r($result);
		// die();
		if($result)
		{
			$max_equipment=$result->bmin_equipmentkey;
		}
		if(!empty($max_equipment))
		{

			$max_eqArray=explode('-',$max_equipment);
			if($desc==2 || $desc==3 || $desc==1 || $desc==129 || $desc==131){
				$arry3=$max_eqArray[3];
			}else{
				$arry3=$max_eqArray[2];
			}
			
			// echo "<pre>";
			// print_r($arry3);
			// die();
			$maxno=$arry3+1;
			// $maxno=sprintf('%2f',$maxno);
			$maxno=str_pad($maxno, 3, 0, STR_PAD_LEFT);
			// echo "<pre>";
			// print_r($maxno);
			// die();

		}

		$concate_data=$depcode.'-'.$descode.'-'.$maxno;
		// echo "<pre>";
		// 	print_r($concate_data);
		// 	die();

		print_r(json_encode(array('status'=>'success','message'=>'','data'=>$concate_data)));
        exit;

   }
	else
    {
	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        exit;
    }

	}



	public function save_biomedicalinven()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
			$id = $this->input->post('id');

			$this->session->unset_userdata('bill_error');
			$this->session->unset_userdata('known_attach_error');
			$barcode='';
		try {
			$this->billattachment='';
			$this->knownattachment='';

           if($id)
			{
				$this->data['equip_data'] = $this->bio_medical_mdl->get_biomedical_inventory(array('bm.bmin_equipid'=>$id));
				// echo "<pre>";
				// print_r($data['dept_data']);
				// die();
			if($this->data['equip_data'])
			{
				$dep_date=$this->data['equip_data'][0]->bmin_postdatead;
				$dep_time=$this->data['equip_data'][0]->bmin_posttime;
				$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
				$usergroup=$this->session->userdata(USER_GROUPCODE);
				
				if($editstatus==0 && $usergroup!='SA' )
				{
					   $this->general->disabled_edit_message();

				}
			 }
			}

			$this->form_validation->set_rules($this->bio_medical_mdl->validate_settings_biomedical);
		
			if($this->form_validation->run()==TRUE )
			 {
			 	$upload_result_error=FALSE;
				if(!empty($_FILES['bmin_billattachment']['name']))
				{
				$upload_result_error=$this->bio_medical_mdl->upload_bill_attachment_images();
				// echo $upload_result_error;
				// die();
				if($upload_result_error==TRUE)
				{
					print_r(json_encode(array('status'=>'error','message'=>$this->session->userdata('bill_error'))));
					exit;
				}
				}

				if(!empty($_FILES['bmin_personattachment']['name']))
				{
				$upload_result_error_kp=$this->bio_medical_mdl->upload_known_attachment_images();
				// echo $upload_result_error;
				// die();
				if($upload_result_error_kp==TRUE)
				{
					print_r(json_encode(array('status'=>'error','message'=>$this->session->userdata('known_attach_error'))));
					exit;
				}

				}

			$trans = $this->bio_medical_mdl->biomedicalinven_save();
            if($trans)
            {
            	if($this->input->post('bmin_isprintsticker')=='Y'){
            		$this->data['equipid']=$this->input->post('bmin_equipmentkey');
            		$descid=$this->input->post('bmin_descriptionid');
            		$servicedate=$this->input->post('bmin_servicedate');

            		$equ_description=$this->general->get_tbl_data('*','eqli_equipmentlist',array('eqli_equipmentlistid'=>$descid));
            		$this->data['desc'] = $equ_description[0]->eqli_description;
            		if(DEFAULT_DATEPICKER=='NP')
				     {
			       	 	$servicedatenp=$servicedate;
			       		$servicedateen=$this->general->NepToEngDateConv($servicedate);
				      }
				      else
				      {
			        	$servicedateen=$servicedate;
			        	$servicedatenp=$this->general->EngToNepDateConv($servicedate);
				      }

		    		if(DEFAULT_DATEPICKER=='NP'){
						$this->data['servicedate']=$servicedatenp;
					}
					else{
						$this->data['servicedate']=$servicedateen;
					}
            		// echo $this->data['dep'];
            		// die();

		    		$orga = explode(" ", ORGA_NAME);
					$acronym = "";

					foreach ($orga as $org) {
					  	$acronym .= $org[0];
					}

					$equipkey = $this->data['equipid'];

					$eqID = explode('-', $equipkey);

					$eq_code = $eqID[0];
					$eq_number = $eqID[1];

					$new_equip_id = $acronym.'-'.$eq_code.'-'.$eq_number;

		    		// $this->data['new_equip_id'] = $new_equip_id;

		    		$this->data['new_equip_id'] = $equipkey;

		    		// $this->data['qr_link'] = base_url().'biomedical/reports/overview_report'.'/'.$equipkey;

		    		$this->data['qr_link'] = QRCODE_URL.'/biomedical/reports/overview_report'.'/'.$equipkey;
            	$barcode=$this->load->view('bio_medical_inventory/v_barcode',$this->data,true);	
            	}

            	  print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully','barcodeprint'=>$barcode)));
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

	public function save_biomedicalinven_nphl()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
			$id = $this->input->post('id');

			$this->session->unset_userdata('bill_error');
			$this->session->unset_userdata('known_attach_error');
			$barcode='';
		try {
			$this->billattachment='';
			$this->knownattachment='';

           if($id)
			{
				$this->data['equip_data'] = $this->bio_medical_mdl->get_biomedical_inventory(array('bm.bmin_equipid'=>$id));
				
			if($this->data['equip_data'])
			{
				$dep_date=$this->data['equip_data'][0]->bmin_postdatead;
				$dep_time=$this->data['equip_data'][0]->bmin_posttime;
				$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
				$usergroup=$this->session->userdata(USER_GROUPCODE);
				
				if($editstatus==0 && $usergroup!='SA' )
				{
					   $this->general->disabled_edit_message();

				}
			 }
			}

			$this->form_validation->set_rules($this->bio_medical_mdl->validate_settings_biomedical);
		
			if($this->form_validation->run()==TRUE )
			 {
			 	$upload_result_error=FALSE;
				if(!empty($_FILES['bmin_billattachment']['name']))
				{
				$upload_result_error=$this->bio_medical_mdl->upload_bill_attachment_images();
				// echo $upload_result_error;
				// die();
				if($upload_result_error==TRUE)
				{
					print_r(json_encode(array('status'=>'error','message'=>$this->session->userdata('bill_error'))));
					exit;
				}
				}

				if(!empty($_FILES['bmin_personattachment']['name']))
				{
				$upload_result_error_kp=$this->bio_medical_mdl->upload_known_attachment_images();
				// echo $upload_result_error;
				// die();
				if($upload_result_error_kp==TRUE)
				{
					print_r(json_encode(array('status'=>'error','message'=>$this->session->userdata('known_attach_error'))));
					exit;
				}

				}

			$trans = $this->bio_medical_mdl->biomedicalinven_save();
            if($trans)
            {
            	if($this->input->post('bmin_isprintsticker')=='Y'){
            		$this->data['equipid']=$this->input->post('bmin_equipmentkey');
            		$descid=$this->input->post('bmin_descriptionid');
            		$servicedate=$this->input->post('bmin_servicedate');

            		$equ_description=$this->general->get_tbl_data('*','eqli_equipmentlist',array('eqli_equipmentlistid'=>$descid));
            		$this->data['desc'] = $equ_description[0]->eqli_description;
            		if(DEFAULT_DATEPICKER=='NP')
				     {
			       	 	$servicedatenp=$servicedate;
			       		$servicedateen=$this->general->NepToEngDateConv($servicedate);
				      }
				      else
				      {
			        	$servicedateen=$servicedate;
			        	$servicedatenp=$this->general->EngToNepDateConv($servicedate);
				      }

		    		if(DEFAULT_DATEPICKER=='NP'){
						$this->data['servicedate']=$servicedatenp;
					}
					else{
						$this->data['servicedate']=$servicedateen;
					}
            		// echo $this->data['dep'];
            		// die();

		    		$orga = explode(" ", ORGA_NAME);
					$acronym = "";

					foreach ($orga as $org) {
					  	$acronym .= $org[0];
					}

					$equipkey = $this->data['equipid'];

					$eqID = explode('-', $equipkey);

					$eq_code = $eqID[0];
					$eq_number = $eqID[1];

					$new_equip_id = $acronym.'-'.$eq_code.'-'.$eq_number;

		    		// $this->data['new_equip_id'] = $new_equip_id;

		    		$this->data['new_equip_id'] = $equipkey;

		    		// $this->data['qr_link'] = base_url().'biomedical/reports/overview_report'.'/'.$equipkey;

		    		$this->data['qr_link'] = QRCODE_URL.'/biomedical/reports/overview_report'.'/'.$equipkey;
            	$barcode=$this->load->view('bio_medical_inventory/v_barcode',$this->data,true);	
            	}

            	  print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully','barcodeprint'=>$barcode)));
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


	public function get_data()
	{   
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = $this->input->post('euipid');

			$data['comment'] = $this->bio_medical_mdl->get_biomedical_inventory("bm.bmin_equipid = ".$id."");
			$data['equip_comment'] = $this->bio_medical_mdl->get_equip_comment($id);

			//echo "<pre>"; print_r($data['comment']);die;
			$tempform = $this->load->view('bio_medical_inventory/v_comment',$data,true);

			$commentform = $this->load->view('bio_medical_inventory/v_repaircomment',$data, true);

			if($data['comment'])
				{
					print_r(json_encode(array('status'=>'success','tempform'=>$tempform, 'commentform'=>$commentform, 'message'=>'Successfully Selected!!')));
		       		exit;	
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>'Unsuccessfully Selected')));
		       		exit;	
				}
		}else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}
	public function view_bio_medical_inventory()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$this->data=array();
		$id = $this->input->post('id');

		$this->data['biomedical_data']=$this->bio_medical_mdl->get_biomedical_inventory(array('bmin_equipid'=>$id));
		//echo "<pre>";print_r($this->data['biomedical_data']);die;
		$tempform=$this->load->view('bio_medical_inventory/v_biomedical_view',$this->data,true);
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
	public function biomedical_list($result=false,$orgid=false)
	{
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		if($orgid){
			$org_id=$orgid;
		}
		else
		{
			$org_id = $this->session->userdata(ORG_ID); 
		}
		

		if($useraccess == 'B')
		{
			if($orgid)
			{
				$srchcol=array('bmin_orgid'=>$org_id);
			}
			else
			{
				$srchcol='';
			}
			$data = $this->bio_medical_mdl->get_biomedical_inventory_list($srchcol); 
		}else{
			$data = $this->bio_medical_mdl->get_biomedical_inventory_list(array('bmin_orgid'=>$org_id));
		}
		if($result == 'bmin_equipid'){
			$cond=array('bmin_postdatead'=>date("Y/m/d"), 'bmin_orgid'=>$org_id);
			$data = $this->bio_medical_mdl->get_biomedical_inventory_list($cond);
		}
			
		
	  	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  
		  	foreach($data as $row)
		    {
		    	$depname = !empty($row->dept_depname)?$row->dept_depname:0;
		    	$equipmentdesc=$row->eqli_description;
			    $array[$i]["equipid"] = '<a href="javascript:void(0)" data-id='.$row->bmin_equipid.' data-displaydiv="searchReports" data-viewurl='.base_url('biomedical/reports/report_search').' class="patlist btnEdit" data-patientid='.$row->bmin_equipid.'>'.$row->bmin_equipid.'</a>';
			    $array[$i]["equipkey"] = $row->bmin_equipmentkey;
			    $array[$i]["description"] = $row->eqli_description;
			    $array[$i]["department"] = $row->dept_depname;
			    $array[$i]["manu_manlst"] = $row->manu_manlst;
			    $array[$i]["risk"] = $row->riva_risk;
			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->bmin_equipid.' data-displaydiv="Distributer" data-viewurl='.base_url('biomedical/bio_medical_inventory/view_bio_medical_inventory').' class="view" data-heading="View Equipment " ><i class="fa fa-eye" aria-hidden="true" ></i></a>&nbsp;<a href="javascript:void(0)" data-id='.$row->bmin_equipid.' class="myModalCall" data-toggle="modal" title="Comment"><i class="fa fa-comment-o" aria-hidden="true" ></i></a> &nbsp;
			    <a href="javascript:void(0)" data-id='.$row->bmin_equipid.' data-displaydiv="biomedicalinventory" class="btnEdit" data-viewurl='.base_url('biomedical/bio_medical_inventory/edit_biomedical_inventery').' data-displaydiv="biomedicalinventory" title="Edit"><i class="fa fa-edit" aria-hidden="true" ></i></a> &nbsp;
			    <a href="javascript:void(0)" class="btnDeleteServer" data-id='.$row->bmin_equipid.' data-tableid='.($i+1).'  data-deleteurl='.base_url('biomedical/bio_medical_inventory/delete_inventory').' title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a> &nbsp;
			    <a href="javascript:void(0)" class="btnBarcode" data-id='.$row->bmin_equipid.'  title="Barcode" ><i class="fa fa-barcode" aria-hidden="true"></i></a>';

			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function list_bio_medical_inv()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_VIEW=='N')
			{
			$this->general->permission_denial_message();
			exit;
			}

			$data=array();
			$template=$this->load->view('bio_medical_inventory/v_bio_medical_list',$data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}


	public function save_comment()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = $this->input->post('id');
		try {
			$srchcol = $this->session->userdata(USER_ID);
			$this->form_validation->set_rules($this->bio_medical_mdl->validate_settings_biomedical_comments);
		
			if($this->form_validation->run()==TRUE)
			 {
			
            $trans = $this->bio_medical_mdl->comment_save();
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
        }else
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
	public function save_maintenance ()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			$id = $this->input->post('id');
		 try 
		 {
			$srchcol = $this->session->userdata(USER_ID);
			$this->form_validation->set_rules($this->bio_medical_mdl->validate_settings_biomedical_maintenance);
		
			if($this->form_validation->run()==TRUE)
			 {
			
	            $trans = $this->bio_medical_mdl->maintenance_save();
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
	            exit;
	        }
	    }
	 	else
	    {
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	            exit;
	    }
	}
  
    public function edit_biomedical_inventery()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    			if(MODULES_UPDATE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			$id = $this->input->post('id');
	    	$this->data['equipment_list']=$this->bio_medical_mdl->get_equipmentlist();
			 $this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
			$this->data['dep_information']=$this->department_mdl->get_all_department(array('dept_deptype'=>BIOMEDICALID));
			$this->data['riskval_list']=$this->bio_medical_mdl->get_riskvalue();
			$this->data['manufacturer_list']=$this->bio_medical_mdl->get_manufacturer();
			$this->data['distributor_list']=$this->bio_medical_mdl->get_distributor_list();
			$this->data['purchase_donate']=$this->bio_medical_mdl->get_purchase_donate_list();
			$this->data['biomedical_inv_list']=$this->bio_medical_mdl->get_biomedical_inventory();
			$this->data['currencry']=$this->general->get_tbl_data('*', 'cuty_currencytype');
			$this->data['equip_data'] = $this->bio_medical_mdl->get_biomedical_inventory(array('bm.bmin_equipid'=>$id));

			//print_r($this->data['equip_data']);
			if($this->data['equip_data'])
		{
			$dep_date=$this->data['equip_data'][0]->bmin_postdatead;
			$dep_time=$this->data['equip_data'][0]->bmin_posttime;
			$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
			// echo $editstatus;
			// die();
			$this->data['edit_status']=$editstatus;

		}
		$tempform=$this->load->view('bio_medical_inventory/v_bio_medical_inventory_form_nphl',$this->data,true);
		//echo $tempform;die();
		if(!empty($this->data['equip_data']))
		{
				print_r(json_encode(array('status'=>'success','message'=>'You Can edit','tempform'=>$tempform)));
            	exit;
		}
		else{
			print_r(json_encode(array('status'=>'error','message'=>'Unable to Edit!!')));
            	exit;
		}


    	}
    }

    public function get_repair_request()
    {
    	$data = $this->bio_medical_mdl->get_repair_request_rec();
		if($result == 'bmin_equipid') {
			$cond = date("Y-m-d");
			$data = $this->bio_medical_mdl->get_repair_request_rec($cond);
		}
	  	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  
		  	foreach($data as $row)
		    {
		   
			    $array[$i]["equipid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->bmin_equipid.'>'.$row->bmin_equipid.'</a>';
			    $array[$i]["description"] = $row->eqli_description;
			    $array[$i]["department"] = $row->dein_department;
			    $array[$i]["servicedatebs"] = $row->bmin_servicedatebs;
			    $array[$i]["endwarrantydatead"] = $row->bmin_endwarrantydatead;
			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->bmin_equipid.' class="myModalCall"><i class="fa fa-comment-o" aria-hidden="true" ></i></a> &nbsp;
			    <a href="javascript:void(0)" data-id='.$row->bmin_equipid.' data-displaydiv="biomedicalinventory" class="btnEdit" data-viewurl='.base_url('biomedical/bio_medical_inventory/edit_biomedical_inventery').' data-displaydiv="biomedicalinventory"><i class="fa fa-edit" aria-hidden="true" ></i></a>';
			    // $array[$i]["edit"] ='<a href="javascript:void(0)" data-equipid='.$row->bmin_equipid.' class="myModalCall"><i class="fa fa-edit" aria-hidden="true" ></i></a>';

			    $i++;
		        //(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
    }

    public function get_barcode(){
    	$this->data['equipid'] = $this->input->post('bmin_equipmentkey');
    	$equipid=$this->input->post('equipid');
    	$this->data['servicedate']='';
    	if($equipid)
    	{
    		$equpdata=$this->bio_medical_mdl->get_biomedical_inventory(array('bmin_equipid'=>$equipid),1,false,'bm.bmin_equipid','DESC');
    		// echo '<pre>';
    		// print_r($equpdata);
    		// die();
    		$this->data['desc'] = $equpdata[0]->eqli_description;

    		$this->data['equipid']=$equpdata[0]->bmin_equipmentkey;

    		$orga = explode(" ", ORGA_NAME);
			$acronym = "";

			foreach ($orga as $org) {
			  	$acronym .= $org[0];
			}

			$equipkey = $this->data['equipid'];

			$eqID = explode('-', $equipkey);

			$eq_code = $eqID[0];
			$eq_number = $eqID[1];

			$new_equip_id = $acronym.'-'.$eq_code.'-'.$eq_number;

    		// $this->data['new_equip_id'] = $new_equip_id;

    		$this->data['new_equip_id'] = $equipkey;

    		// $this->data['qr_link'] = base_url().'biomedical/reports/overview_report'.'/'.$equipkey;

    		$this->data['qr_link'] = QRCODE_URL.'/biomedical/reports/overview_report'.'/'.$equipkey;


    		if(DEFAULT_DATEPICKER=='NP'){
				$this->data['servicedate']=$equpdata[0]->bmin_servicedatebs;
			}
			else{
				$this->data['servicedate']=$equpdata[0]->bmin_servicedatead;
			}
			    		

    	}
    	


    	$tempform=$this->load->view('bio_medical_inventory/v_barcode',$this->data,true);

    	// echo $tempform;
    	// die();

    	if(!empty($this->data['equipid']))
		{
				print_r(json_encode(array('status'=>'success','message'=>'Success','tempform'=>$tempform)));
            	exit;
		}
		else{
			print_r(json_encode(array('status'=>'error','message'=>'Error')));
            	exit;
		}

    }

    public function list_of_equipment_inv()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			
			  $data['equipment_inv_list'] = $this->bio_medical_mdl->get_biomedical_inventory(array('bmin_isunrepairable'=>'N'),10,false,'bmin_equipid','ASC');
			  // echo "<pre>";
			  // print_r($data);
			  // die();
			   $template=$this->load->view('biomedical/bio_medical_inventory/list_of_equipment_inv',$data,true);
	            if($template)
	            {
	            	  print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','template'=>$template)));
	            	exit;
	            }
	            else
	            {
	            	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
	            	exit;
	            }
		}
		catch (Exception $e) {
          
            print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
        }

		}
		else
	    {
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	            exit;
	    }
    }

    public function get_inventory_data(){
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    	try{
    		$equipid = $this->input->post('euipid');
    		$data['eqli_data'] = $this->bio_medical_mdl->get_biomedical_inventry_data(array('bmin_equipid'=>$equipid));

    		// echo "<pre>";
    		// print_r($data['eqli_data']);
    		// die();
    		$tempform='';
    		$data['equip_comment'] = $this->bio_medical_mdl->get_equip_comment(array('eqco_eqid'=>$equipid));
    		$tempformequip = $this->load->view('common/equipment_detail',$data,true);
    		$tempform = $this->load->view('biomedical/bio_medical_inventory/v_repaircomment',$data,true);

    		// echo $this->db->last_query();
    		// die();
    		$equipid = $data['eqli_data'][0]->bmin_equipid;
    		// $equipkey = $data['eqli_data'][0]->bmin_equipmentkey;
    		// $equipdesc = $data['eqli_data'][0]->eqli_description;
    		// $equipdep = $data['eqli_data'][0]->dein_department;
    		// $equipmanu = $data['eqli_data'][0]->manu_manlst;
    		// $equiprisk = $data['eqli_data'][0]->riva_risk;

    		if($data){
    			print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','equipid'=>$equipid,'tempform'=>$tempform,'tempformequip'=>$tempformequip)));
	            exit;
    		}else{
    			print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
	            exit;
    		}
    	}catch(Exception $e){
    		throw $e;
    	}
    }
     else {
    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
    }

    }

    public function delete_inventory(){
    	try{
    		if(MODULES_DELETE=='N')
			{
				$this->general->permission_denial_message();
					exit;
			}

    		$delid = $this->input->post('id');
    		
    		if($this->bio_medical_mdl->delete_inventory($delid)){
    			print_r(json_encode(array('status'=>'success', 'message'=>'Successfully Deleted')));
    			exit;
    		}else{
    			print_r(json_encode(array('status'=>'error', 'message'=>'Operation Unsuccessful')));
    			exit;
    		}
    	}catch(Exception $e){
    		throw $e;
    	}
    }

    // For inventory Comments
    public function inventory_comment()
    {
	$this->page_title='Bio-medical Inventory Repair Request';
	 $this->data['breadcrumb']='Equipments/Assign Equipments';
    	$this->template
				->set_layout('general')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('bio_medical_inventory/v_biomedical_comment',$this->data);
    }

    // For user repair request
    public function user_repair_request()
    {	
		$this->page_title='Bio-medical Inventory User Repair Request';
	 	$this->data['breadcrumb']='Equipments/User Repair Reqest';

	 	
    	$this->db->select('dp.*,lo.*');
		$this->db->from('dept_department dp');
		$this->db->join('loca_location lo', 'lo.loca_locationid=dp.dept_locationid', 'LEFT');
		$this->db->where('dept_deptype',BIOMEDICALID);
		if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
    	}
	 	$this->data['department'] = $this->db->get()->result();


    	$this->template
				->set_layout('general')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('bio_medical_inventory/v_biomedical_user_repair_request',$this->data);
    }


    public function user_repair_request_list()
    {
		$data = $this->bio_medical_mdl->get_user_repair_request_list();
		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);
		foreach($data as $row)
		{
			if($row->eqco_comment_status == 1)
			{
				$penf = "Completed"; 
				$class='label-success';
				$row_class = "bg-success text-white ";
			}

			if($row->eqco_comment_status == 2){ 
				$penf = "Seen"; 
				$class='label-info';
				$row_class = "bg-info text-white ";

			}

			if($row->eqco_comment_status == 0){ 
				$penf = "Pending"; 
				$class='label-warning';
				$row_class = "bg-warning text-white ";

			}
			if($row->eqco_comment_status == 3){ 
				$penf = "Cancelled"; 
				$class='label-danger';
				$row_class = "bg-danger text-white ";
			}
			if($row->eqco_comment_status == 4){ 
				$penf = "In Progress"; 
				$class='label-primary';
				$row_class = 'bg-primary text-white ';
			}

			$array[$i]["equipid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->eqco_equipmentcommentid.'>'.$row->eqco_equipmentcommentid.'</a>';
			
			$array[$i]["equipkey"] = '<a href="javascript:void(0)" class="overview '.$row_class.'" data-equipkey='.$row->bmin_equipmentkey.'>'.$row->bmin_equipmentkey.'</a>';
			
			$array[$i]["description"] = $row->eqli_description;
			$array[$i]["request_no"] = $row->eqco_requestno;
			$array[$i]["department"] = $row->dein_department;
			$array[$i]["comments"] = $row->eqco_comment;
			$array[$i]["commented_by"] = $row->usma_fullname;
			$array[$i]["date"] = $row->eqco_postdatead;

			$array[$i]["status"] ='<a href="javascript:void(0)" class=" label '.$class.' btn-xs">' .$penf . ' </a>';
			if($this->sess_usercode != 'SA'){
				$array[$i]["action"] = '';
			}else{

			$array[$i]["action"] ='<a href="javascript:void(0)" data-equipid='.$row->eqco_eqid.' data-statusid='.$row->eqco_comment_status.' data-id='.$row->eqco_equipmentcommentid.' class="myModalRepair"><i class="fa fa-info-circle" aria-hidden="true" ></i></a>';
			}
			$array[$i]['row_class'] = $row_class;

			$i++;
		}
		echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
    }

    public function get_biomedical_details()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$equid_key = $this->input->post('id');
			// echo $equid_key;
			// die();

			$this->data['eqli_data'] = $this->bio_medical_mdl->get_biomedical_inventory(array('bm.bmin_equipmentkey'=>$equid_key));
			if($this->data['eqli_data'])
			{
			$equid=$this->data['eqli_data'][0]->bmin_equipid;
			// echo "<pre>";
			// print_r($this->data['eqli_data']);
			// die();
			$this->data['listurl']=base_url().'biomedical/bio_medical_inventory/list_bio_comments/'.$equid;
			$this->data['deleteurl']=base_url().'biomedical/bio_medical_inventory/delete_bio_comment';

			$this->data['equip_comment'] = $this->bio_medical_mdl->get_equip_comment(array('ec.eqco_eqid'=>$equid));
			// print_r($this->data['equip_comment']);
			// die();

			$this->data['eqco_requestno'] = $this->general->generate_invoiceno('eqco_requestno','eqco_requestno','eqco_equipmentcomment',EQUIPMENT_COMMENT_NO_PREFIX,EQUIPMENT_COMMENT_NO_LENGTH,false,'eqco_locationid','eqco_equipmentcommentid DESC','M',false,'Y');

			// print_r($this->data['eqco_requestno']);
			// die();

			 $template=$this->load->view('bio_medical_inventory/v_bio_medical_comment_form',$this->data,true);
			 // echo $template;
			 // die();

			print_r(json_encode(array('status'=>'success','tempform'=>$template,  'message'=>'Successfully Selected!!')));
		       		exit;	
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>'No record Found!!')));
		       		exit;	
				}
		}else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
    }

    public function reload_comment_form($id=false)
    {
    	$this->data['eqli_data'] = $this->bio_medical_mdl->get_biomedical_inventory(array('bm.bmin_equipmentkey'=>$equid_key));
			// if($this->data['eqli_data'])
			// {
			$equid=$this->data['eqli_data'][0]->bmin_equipid;
			$this->load->view('bio_medical_inventory/v_bio_medical_comment_form',$this->data);
			// }
    }

    public function list_bio_comments($equid=false)
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   		//  		if(MODULES_VIEW=='N')
			// {
			// $this->general->permission_denial_message();
			// exit;
			// }
			$org_id=$this->session->userdata(ORG_ID);
			$this->data['equip_comment'] = $this->bio_medical_mdl->get_equip_comment(array('ec.eqco_eqid'=>$equid,'eqco_orgid'=>$org_id));
			$template=$this->load->view('bio_medical_inventory/v_bio_medical_comment_list',$this->data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
    }

  

    public function delete_bio_comment()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id=$this->input->post('id');
			$trans=$this->bio_medical_mdl->remove_bio_comment();
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

    public function get_room_from_depid()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id=$this->input->post('depid');
			if(!empty($id))
		 	{
		 	$this->load->model('settings/room_mdl');
		 	$this->data['room_list']=$this->room_mdl->get_all_room(array('rode_departmentid'=>$id));
		 	// echo $this->db->last_query();
		 	// die();
		 	// echo "<pre>";
		 	// print_r($this->data['room_list']);die;
		 	if(!empty($this->data['room_list']))
		 		{
		 		echo json_encode($this->data['room_list']);
		 		}
		 	else
		 		{
		 			echo json_encode(array());
		 		}
		 	}
		 	else
		 	{
		 		echo json_encode('');
		 	}

		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
    }

    public function get_room_with_equip_from_depid()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		$tempform='';
    		$id=$this->input->post('depid');
			if(!empty($id))
		 	{
		 	$this->load->model('settings/room_mdl');
		 	$room_list=$this->room_mdl->get_all_room(array('rode_departmentid'=>$id));
		 	if($id)
		 	{
		 		$srch=array('bmin_departmentid'=>$id);	
		 	}
		 	$srch="bmin_departmentid=$id AND bm.bmin_equipid NOT IN( SELECT eqas_equipid FROM xw_eqas_equipmentassign )";

		 	$this->data['equipment_list']=$this->bio_medical_mdl->get_biomedical_inventory($srch);

		 	// echo $this->db->last_query();
		 	// die();
		 	// echo "<pre>";
		 	// print_r($this->data['equipment_list']);
		 	// die();
		 	$this->data['depid']=$id;
		 	$rom_template='';
		 	if(!empty($room_list))
		 	{
		 		$rom_template='<option value="">---select---</option>';
		 		foreach ($room_list as $kr => $rmlist):
		 		$rom_template.='<option value="'.$rmlist->rode_roomdepartmentid.'">'.$rmlist->rode_roomname.'</option>';	
		 		endforeach;
		 		
		 	}
		 	$tempform=$this->load->view('assign_equipement/v_depwise_equipment',$this->data,true);
		 	
		 	print_r(json_encode(array('status'=>'success','tempform'=>$tempform,'room_template'=>$rom_template,'message'=>'Can perform operation')));
	        exit;
	    }
}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
   }


   public function get_equipment_with_room_and_depid()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		$tempform='';
    		$id=$this->input->post('depid');
    		$roomid=$this->input->post('roomid');
			if(!empty($id))
		 	{
		 	$this->load->model('settings/room_mdl');
		 	if($id)
		 	{
		 		$srch=array('bmin_departmentid'=>$id);	
		 	}
		 	$srch="bmin_departmentid=$id AND bm.bmin_roomid =$roomid AND bm.bmin_equipid NOT IN( SELECT eqas_equipid FROM xw_eqas_equipmentassign )";

		 	$this->data['equipment_list']=$this->bio_medical_mdl->get_biomedical_inventory($srch);

		 	
		 	$tempform=$this->load->view('assign_equipement/v_depwise_equipment',$this->data,true);
		 	
		 	print_r(json_encode(array('status'=>'success','tempform'=>$tempform,'message'=>'Can perform operation')));
	        exit;
	    }
}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
   }
   
   	public function qr_code()
   	{
   		$this->load->library('ciqrcode');

		header("Content-Type: image/png");
		$params['data'] = 'This is a text to encode become QR Code';
		$qr=$this->ciqrcode->generate($params);
		echo $qr;
		// die();
   }


   	public function get_multiple_barcode_assets(){	
   		try{
   			$keys = $this->input->post('keys');
   			// $this->data['equipmentkeylist'] = $this->bio_medical_mdl->get_equip_key(false,'5');

   			// print_r($this->data['equipmentkeylist']);
   			// die();

   			$this->data['equipmentkeylist'] = $keys;

   			// print_r($this->data['equipmentkeylist']);
   			// die();

   			$this->page_title = "Multiple Barcode Generator";


	    	$tempform=$this->load->view('bio_medical_inventory/v_multiple_barcode',$this->data,true);

	    	// echo $tempform;
	    	// die();

	    	if($this->data['equipmentkeylist'])
			{
					print_r(json_encode(array('status'=>'success','message'=>'Success','tempform'=>$tempform)));
	            	exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Error')));
	            	exit;
			}

   		}catch(Exception $e){
   			throw $e;
   		}
   	}

   	// public function barcode_generator(){
   	// 	$this->data['equipmentkeylist'] = $this->bio_medical_mdl->get_equip_key(false,'5');
   	// 	$this->page_title = "Barcode Generator";
   	// 	$this->template
				// ->set_layout('general')
				// ->enable_parser(FALSE)
				// ->title($this->page_title)
				// ->build('bio_medical_inventory/v_barcode_generator', $this->data);
   	// }

   	public function barcode_generator($status=false)
    {

      	$this->data['status']=$status;
      	$this->data['dep_information']=$this->department_mdl->get_all_department(array('dept_deptype'=>BIOMEDICALID));

      	
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
            ->build('bio_medical_inventory/v_barcode_generator', $this->data);
    }

    public function getEquipKeyByDepid(){
    	$depid = $this->input->post('depid');
    	$equipmentkeylist = $this->bio_medical_mdl->get_equip_key(array('bmin_departmentid'=>$depid));
    	$response = "";
    	$response .= "<br/><br/><div class='col-md-12 table-responsive'><table class='table table-striped dt_alt dataTable Dtable'>";
		$response .= "<thead><tr><th><input type='checkbox' id='checkall'/></th><th><strong>Equipment Key</strong></th><th><strong>Description</strong></th><th><strong>Model No.</strong></th><th><strong>Serial No.</strong></th></tr></thead><tbody>";
		if(!empty($equipmentkeylist)):
    		foreach($equipmentkeylist as $eq):
				$response .= "<tr><td><input type='checkbox' id='equipid_$eq->bmin_equipmentkey' data-key=".$eq->bmin_equipmentkey." /></td><td>".$eq->bmin_equipmentkey."</td><td>".$eq->eqli_description."</td><td>".$eq->bmin_modelno."</td><td>".$eq->bmin_serialno."</td></tr>";
			endforeach;
		endif;
		$response .= "</tbody></table></div>";

		if($response)
		{
			print_r(json_encode(array('status'=>'success','message'=>'Success','tempform'=>$response)));
            	exit;
		}
		else{
			print_r(json_encode(array('status'=>'error','message'=>'Error')));
            	exit;
		}
    }
	public function list_of_equipment()

		{

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				$this->data=array();
				//print_r($this->input->post()); die;
				//echo $this->db->last_query(); die;
				$row=$this->data['rowno']=$this->input->post('id');
				//print_r($this->data['rowno']);die;
				
				$template=$this->load->view('biomedical/bio_medical_inventory/v_equipment_popup.php',$this->data,true);

				print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template,'tempform'=>$template)));

		   		 exit;	

			}

			else

			{

				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

		        exit;

			}

		}
		

	// public function get_equipmentlist($rowno=false)
	// {
		
	// 		$data = $this->equipment_mdl->get_dequipment_list();//echo "<pre>"; 
	//   	$i = 0;
	// 	$array = array();
	// 	$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
	// 	$totalrecs = $data["totalrecs"];

	//     unset($data["totalfilteredrecs"]);
	//   	unset($data["totalrecs"]);
	  
	// 	  	foreach($data as $row)
	// 	    {
		   
	// 		    $array[$i]["equipmentlistid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->eqli_equipmentlistid.'>'.$row->eqli_equipmentlistid.'</a>';
	// 		      $array[$i]["equipmenttype"] = $row->eqty_equipmenttype;
	// 		    $array[$i]["equ_code"] = $row->eqli_code;
	// 		    $array[$i]["description"] = $row->eqli_description;
	// 		    $array[$i]["rowno"]=$rowno;
			    
	// 		    $array[$i]["comment"] = $row->eqli_comment;
	// 		    if(DEFAULT_DATEPICKER=='NP') 
	// 		    {
	// 		    	$array[$i]["eqli_postdate"] = $row->eqli_postdatebs;
                                
	//             }else{
	//             	$array[$i]["eqli_postdate"] = $row->eqli_postdatead;
 //                };
	// 		    $array[$i]["action"] =''
	// 		    ;
			     
	// 		    $i++;
	// 	        //(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');
	// 	    }
 //        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	// }

	public function get_equipmentlist($rowno=false,$orgid=false,$result=false)
	{

		if(MODULES_VIEW=='N')
			//echo MODULES_VIEW;die;
			{
			 $array["equipid"]='';
			 $array["equipkey"] ='';
			 $array["description"]=''; 
			 $array["department"]=''; 
			 $array["manu_manlst"] ='';
			 $array["risk"]='';
			 $array["action"]='';
			 // $this->general->permission_denial_message();
			 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
			}
			//print_r($rowno);die;
			// if($rowno){
			// 	echo "abc"; die;
			// }
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
		
		}
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		if($orgid){
			$org_id=$orgid;
		}
		else
		{
			$org_id = $this->session->userdata(ORG_ID); 
		}
		//echo $org_id; die;

		if($useraccess == 'B')
		{
			if($orgid)
			{
				$srchcol=array('bmin_orgid'=>$org_id);
			}
			else
			{
				$srchcol='';
			}
			$data = $this->bio_medical_mdl->get_biomedical_inventory_list($srchcol); 
		}else{
			$data = $this->bio_medical_mdl->get_biomedical_inventory_list(array('bmin_orgid'=>$org_id));
		}
		if($result == 'bmin_equipid'){
			$cond=array('bmin_postdatead'=>date("Y/m/d"), 'bmin_orgid'=>$org_id);
			$data = $this->bio_medical_mdl->get_biomedical_inventory_list($cond);
		}
			
		
	  	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  
		  	foreach($data as $row)
		    {
		    	//$depname = !empty($row->dein_department)?$row->dein_department:0;
		    	$equipmentdesc=$row->eqli_description;
			    // $array[$i]["equipid"] = '<a href="javascript:void(0)" data-id='.$row->bmin_equipid.' data-displaydiv="searchReports" data-viewurl='.base_url('biomedical/reports/report_search').' class="patlist btnEdit" data-patientid='.$row->bmin_equipid.'>'.$row->bmin_equipid.'</a>';
			     $array[$i]["rowno"]=$rowno;
			    $array[$i]["equipid"] = $row->bmin_equipid;
			    $array[$i]["equipkey"] = $row->bmin_equipmentkey;
			    $array[$i]["description"] = $row->eqli_description;
			    $array[$i]["department"] = $row->dept_depname;
			    $array[$i]["manu_manlst"] = $row->manu_manlst;
			    $array[$i]["risk"] = $row->riva_risk;
			    $array[$i]["action"] ='';

			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */