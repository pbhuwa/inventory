<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Assets extends CI_Controller 

{



	function __construct() 

	{

		parent::__construct();

			$this->load->model('assets_mdl');

			$this->load->model('assets_deprecation_mdl');

			$this->load->Model('settings/department_mdl','department_mdl');

			$this->load->Model('biomedical/bio_medical_mdl');

			$this->load->Model('biomedical/manufacturers_mdl');

			$this->load->Model('biomedical/equipment_mdl');

			$this->load->Model('biomedical/distributors_mdl');

			$this->load->library('zend');

			$this->zend->load('Zend/Barcode');

			$this->load->library('ciqrcode');

			$this->load->library('upload');

			$this->load->library('image_lib');

			$this->load->helper('file');

			$this->load->helper('form');

	}

	

	

	public function index()

	{	

		$this->data['status']=$this->assets_mdl->get_status();

		$this->data['condition']=$this->assets_mdl->get_condition();



		$this->session->unset_userdata('patientid');

		$this->data='';

		$this->page_title='Bulk Assets';

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('bulkassets/v_assets', $this->data);

	}



	public function dep_calculator()

	{

		$this->data['assets_data']=$this->assets_mdl->get_all_assets();

		$this->data['depreciation']=$this->assets_mdl->get_depreciation();



		$this->page_title='Bulk Assets';

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('assets/v_dep_calculator', $this->data);

	}



	public function assets_barcode_generator($status=false)

    {



      	$this->data['status']=$status;

      		$this->db->select('*');

	    $this->db->from('eqca_equipmentcategory ec');

	    $this->db->where('eqca_isnonexp','Y');

	    $result=$this->db->get()->result();



		$this->data['eqca_category']= $result;

		

      	// $this->data['eqca_category']=$this->general->get_tbl_data('*','eqca_equipmentcategory',array('eqca_equiptypeid'=>'2'));

      	// echo "<pre>";

      	// print_r($this->data['eqca_category']);

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

            ->build('assets/v_assets_barcode_generator', $this->data);

    }





     public function getAssetsKeyByCatid(){

    	$catid = $this->input->post('catid');

    	$equipmentkeylist = $this->general->get_tbl_data('*','asen_assetentry',array('asen_assettype'=>$catid));

    	// echo $this->db->last_query();

    	// echo "<pre>";

    	// print_r($equipmentkeylist);

    	// die();

    	$response = "";

    	$response .= "<br/><br/><div class='col-md-12 table-responsive'><table class='table table-striped dt_alt dataTable Dtable'>";

		$response .= "<thead><tr><th><input type='checkbox' id='checkall'/></th><th><strong>Assets Code</strong></th><th><strong>Description</strong></th><th><strong>Supplier</strong></th><th><strong>Model No.</strong></th><th><strong>Serial No.</strong></th></tr></thead><tbody>";

		if(!empty($equipmentkeylist)):

    		foreach($equipmentkeylist as $eq):

				$response .= "<tr><td><input type='checkbox' id='equipid_$eq->asen_assetcode' data-key=".$eq->asen_assetcode." /></td><td>".$eq->asen_assetcode."</td><td>".$eq->asen_description."</td><td>".$eq->asen_distributor."</td><td>".$eq->asen_modelno."</td><td>".$eq->asen_serialno."</td></tr>";

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



    public function get_multiple_barcode(){	

   		try{

   			$keys = $this->input->post('keys');

   			// $this->data['equipmentkeylist'] = $this->bio_medical_mdl->get_equip_key(false,'5');

   			

   			// print_r($this->data['equipmentkeylist']);

   			// die();



   			$this->data['equipmentkeylist'] = $keys;



   			// print_r($this->data['equipmentkeylist']);

   			// die();

   				// $this->data['qr_link'] = QRCODE_URL.'/assets/reports/overview_report';



   				// echo $this->data['qr_link'];

   				// die();

   			$this->page_title = "Multiple Barcode Generator";





	    	$tempform=$this->load->view('assets/v_multiple_barcode_assets',$this->data,true);



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



   	public function get_multiple_barcode_assets()

   	{

   		try{

   			$keys = $this->input->post('keys');

   			// $this->data['equipmentkeylist'] = $this->bio_medical_mdl->get_equip_key(false,'5');



   			// print_r($this->data['equipmentkeylist']);

   			// die();



   			$this->data['equipmentkeylist'] = $keys;



   			// print_r($this->data['equipmentkeylist']);

   			// die();



   			$this->page_title = "Multiple Barcode Generator";





    	$tempform=$this->load->view('assets/v_multiple_barcode_assets',$this->data,true);



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





	public function get_purchase_item()

	{

			$this->load->model('api/api_inventory_mdl');

 			$this->data=array();

			// $this->data['purchase_item']=$this->api_inventory_mdl->get_purchasee();

			$tempform=$this->load->view('bulkassets/v_itemlist',$this->data,true);



			// echo $tempform;

			// die();

			if(!empty($tempform))

		    {

		        print_r(json_encode(array('status'=>'success','message'=>'You Can edit','tempform'=>$tempform)));

		              exit;

		    }

		    else{

		      $tempform='<span class="text-danger">Record Not Found!!</span>';

		      print_r(json_encode(array('status'=>'error','message'=>'Unable to Edit!!')));

		              exit;

		      }



			// echo "<pre>";

			// print_r($purchase_item);

			// die();

	}



	public function load_item_data()

	{

		$this->load->model('api/api_inventory_mdl');		

		$data = $this->api_inventory_mdl->get_purchase_item_list();

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

		    	$array[$i]["rec_date"] = $row->TRANSACTION_DATE;

			    $array[$i]["rec_no"] = 	 $row->RECEIVENO;

			    $array[$i]["item_code"] = $row->ITEMSCODE;

			    $array[$i]["item"] = 	$row->ITEMSNAME;

			    $array[$i]["category"] = $row->CATEGORYNAME;

			    $array[$i]["supplier"] = $row->SUPPLIER;

			    $array[$i]["qty"] = $row->REQUIRED_QTY;

			    $array[$i]["price"] = $row->UNITPRICE;

			    $array[$i]["amt"] = $row->TOTAL;

			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->MAT_TRANS_DETAILID.' data-displaydiv="assetsentry" data-viewurl='.base_url('assets_mgmt/assets/get_item_detail').' class="view" data-heading="Assets " ><i class="fa fa-eye" aria-hidden="true" ></i></a>';

			    $i++;

		      

		    }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}



	public function get_item_detail()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$this->load->model('api/api_inventory_mdl');	

		$this->data=array();

		$id = $this->input->post('id');

		$this->data['items_data']=$this->api_inventory_mdl->get_purch_item_data('AND MAT_TRANS_DETAILID='.$id);

		$this->data['dep_information']=$this->department_mdl->get_all_department(array('dept_deptype'=>BIOMEDICALID));

		$this->data['riskval_list']=$this->bio_medical_mdl->get_riskvalue();

		// echo "<pre>";print_r($this->data['items_data']);die;

		$tempform=$this->load->view('bulkassets/v_assits_view',$this->data,true);

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





	public function assets_entry($reload=false)

	{	

		$id=!empty($this->input->post('id'))?$this->input->post('id'):'';

		$param=!empty($this->input->post('param'))?$this->input->post('param'):'';

		$id=!empty($id)?$id:$param; 

		$this->data['status']=$this->assets_mdl->get_status();

		$this->data['condition']=$this->assets_mdl->get_condition();

		

		$this->db->select('*');

	    $this->db->from('eqca_equipmentcategory ec');

	    $this->db->where('eqca_isnonexp','Y');

	    $result=$this->db->get()->result();



		$this->data['material']= $result;

		$this->data['depreciation']=$this->assets_mdl->get_depreciation(array('dety_isactive'=>'Y'));

		$this->data['manufacturers']=$this->manufacturers_mdl->get_all_manufacturers();

		$this->data['distributors']=$this->general->get_tbl_data('*','dist_distributors',array('dist_isactive'=>'Y'));

		$this->data['frequency']=$this->general->get_tbl_data('*','frty_frequencytype',array('frty_isactive'=>'Y'));

		$this->data['lease_company']=$this->general->get_tbl_data('*','leco_leasocompany',array('leco_isactive'=>'Y'));

		$this->data['insurance_company']=$this->general->get_tbl_data('*','inco_insurancecompany',array('inco_isactive'=>'Y'));

		$this->data['department_list']=$this->general->get_tbl_data('*','dept_department',false);


		if($id){


			$this->data['assets_data']=$this->assets_mdl->get_all_assets(array('asen_asenid'=>$id));



			if (ORGANIZATION_NAME == 'KU') {
				$this->data['staff_list'] = $this->general->get_tbl_data('stin_staffinfoid,stin_fname,stin_mname,stin_lname', 'stin_staffinfo');

			$school_id = $this->data['assets_data'][0]->asen_schoolid;

			$dept_id =  $this->data['assets_data'][0]->asen_depid;

			if ($dept_id) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $dept_id), 'dept_depname', 'ASC');
    		}

	        if (!empty($check_parentid)) {
	            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
	            if ($parentdepid != '0') {
	            	$parent_dep_res = $this->general->get_tbl_data('dept_depid','dept_department', array('dept_depid' => $parentdepid), 'dept_depname', 'ASC');
	            	// print_r($parent_dep_res[0]->dept_depid);
	            	$this->data['parent_dep_id'] = !empty($parent_dep_res[0]->dept_depid)? $parent_dep_res[0]->dept_depid : '';

	                $this->data['sub_department'] = $this->general->get_tbl_data('dept_depid,dept_depname', 'dept_department', array('dept_parentdepid' => $parentdepid), 'dept_depname', 'ASC');
	            }
	        }

			$this->data['department_list']=$this->general->get_tbl_data('*','dept_department',array('dept_locationid'=>$school_id));  
			}

			// print_r($this->data);
			// die();

			if($this->data['assets_data']){

				$ass_type=$this->data['assets_data'][0]->asen_assettype;

				$this->data['ass_type_list']=$this->assets_mdl->get_assets(array('eq.itli_catid'=>$ass_type));

				$this->data['lease_data_rec']=$this->assets_mdl->get_assets_lease_record(array('lede_assetid'=>$id));

				$this->data['insurance_data_rec']=$this->assets_mdl->get_assets_insurance_record(array('asin_assetid'=>$id));

				$locationid=$this->session->userdata(LOCATION_ID);

				$currentfyrs=CUR_FISCALYEAR;





		$cur_fiscalyrs_invoiceno=$this->db->select('prin_code,prin_fiscalyrs')

									->from('prin_projectinfo')

									->where('prin_locationid',$locationid)

									// ->where('prin_fiscalyrs',$currentfyrs)

									->order_by('prin_fiscalyrs','DESC')

									->limit(1)

									->get()->row();



		// echo "<pre>";

		// print_r($cur_fiscalyrs_invoiceno);

		// die();



		if(!empty($cur_fiscalyrs_invoiceno)){

			$invoice_format=$cur_fiscalyrs_invoiceno->prin_code;

			

			$invoice_string=str_split($invoice_format);

			// echo "<pre>";

			// print_r($invoice_string);

			// die();

			$invoice_prefix_len=strlen(ASSET_DISPOSAL_NO_PREFIX);

			$chk_first_string_after_invoice_prefix=!empty($invoice_string[$invoice_prefix_len])?$invoice_string[$invoice_prefix_len]:'';

			// echo $chk_first_string_after_invoice_prefix;

			// die();

			if($chk_first_string_after_invoice_prefix =='0'){

				$invoice_no_prefix=ASSET_DISPOSAL_NO_PREFIX.CUR_FISCALYEAR;

			}

			else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs==$currentfyrs && $chk_first_string_after_invoice_prefix =='0' ) {

				$invoice_no_prefix=ASSET_DISPOSAL_NO_PREFIX.CUR_FISCALYEAR;

			}

			else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs!=$currentfyrs && $chk_first_string_after_invoice_prefix =='0' ) {

				$invoice_no_prefix=ASSET_DISPOSAL_NO_PREFIX.CUR_FISCALYEAR;

			}

			else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs!=$currentfyrs && $chk_first_string_after_invoice_prefix !='0' ) {

				$invoice_no_prefix=ASSET_DISPOSAL_NO_PREFIX.CUR_FISCALYEAR;

			}

			else{

				$invoice_no_prefix=ASSET_DISPOSAL_NO_PREFIX;

			}

			

		}

		else{

			$invoice_no_prefix=ASSET_DISPOSAL_NO_PREFIX.CUR_FISCALYEAR;

		}





		$this->data['disposal_code'] = $this->general->generate_invoiceno('asde_disposalno','asde_disposalno','asde_assetdesposalmaster',$invoice_no_prefix,ASSET_DISPOSAL_NO_LENGTH,false,'asde_locationid');



		$this->data['desposaltype']=$this->general->get_tbl_data('*','dety_desposaltype',array('dety_isactive'=>'Y'),'dety_detyid','ASC');

				// echo $this->db->last_query();

				// echo "<pre>";

				// print_r($this->data['lease_data_rec']);

				// die();



		$this->data['pm_record_master']=$this->general->get_tbl_data('*','pmam_pmamcmaster',array('pmam_status'=>'O','pmam_assetid'=>$id,'pmam_pmamtype'=>'PM'));

		$this->data['pm_record_detail']=array();

		if(!empty($this->data['pm_record_master'])){

			$masterid=$this->data['pm_record_master'][0]->pmam_pmamcmasterid;

			$this->data['pm_record_detail']=$this->general->get_tbl_data('*','pmad_pmamcdetail',array('pmad_status'=>'O','pmad_assetid'=>$id,'pmad_pmamcmasterid'=>$masterid));

			}



			// echo "<pre>";

			// print_r($this->data['pm_record_master']);



			// print_r($this->data['pm_record_detail']);

			// die();



		}

		}else{

			$this->data['assets_data'] = array();

		}

		if($reload=='reload'){



			$this->load->view('assets/v_assets_form',$this->data);

		}else{

			$this->data['tab_type']="entry1";

			$this->session->unset_userdata('id');

			$this->page_title='Assets Assets';

			$this->template

				->set_layout('general')

				->enable_parser(FALSE)

				->title($this->page_title)

				->build('assets/v_assets_main', $this->data);

		}

		  

		

	}





	public function component_assets_entry($reload=false){

		$id=!empty($this->input->post('id'))?$this->input->post('id'):'';

		$param=!empty($this->input->post('param'))?$this->input->post('param'):'';

		$id=!empty($id)?$id:$param;

		

		$this->data['network_component_list']=$this->general->get_tbl_data('*','coty_componenttype',array('coty_isactive'=>'Y'));

		$this->data['assettype_list']=$this->general->get_tbl_data('*','asty_assettype',array('asty_isactive'=>'Y'));

		$this->data['frequency']=$this->general->get_tbl_data('*','frty_frequencytype',array('frty_isactive'=>'Y'));

		$this->data['project_list']=$this->general->get_tbl_data('*','prin_projectinfo',false,'prin_prinid','ASC');



		

		$this->data['tab_type']="component_based_assets";

		$this->page_title='Network Component Assets';

		

	

	$this->data['network_component_typeid']='';

	if($id){

			$this->data['assets_data']=$this->assets_mdl->get_all_assets(array('asen_asenid'=>$id));

			if($this->data['assets_data']){

				$this->data['network_component_typeid']=!empty($this->data['assets_data'][0]->asen_component_typeid)?$this->data['assets_data'][0]->asen_component_typeid:'';

				$this->data['department_list']=$this->general->get_tbl_data('*','dept_department',false);

				$this->data['depreciation']=$this->assets_mdl->get_depreciation(array('dety_isactive'=>'Y'));

				$this->data['manufacturers']=$this->manufacturers_mdl->get_all_manufacturers();

				$this->data['distributors']=$this->general->get_tbl_data('*','dist_distributors',array('dist_isactive'=>'Y'));

				$this->data['frequency']=$this->general->get_tbl_data('*','frty_frequencytype',array('frty_isactive'=>'Y'));

					$this->data['project_list']=$this->general->get_tbl_data('*','prin_projectinfo',false,'prin_prinid','ASC');

				// echo "<pre>";

				// print_r($this->data['frequency']);

				// die();

				$this->data['lease_company']=$this->general->get_tbl_data('*','leco_leasocompany',array('leco_isactive'=>'Y'));

				$this->data['insurance_company']=$this->general->get_tbl_data('*','inco_insurancecompany',array('inco_isactive'=>'Y'));

				$ass_type=$this->data['assets_data'][0]->asen_assettype;

				$this->data['ass_type_list']=$this->assets_mdl->get_assets(array('eq.itli_catid'=>$ass_type));

				$this->data['lease_data_rec']=$this->assets_mdl->get_assets_lease_record(array('lede_assetid'=>$id));				

			}

		}else{

			$this->data['assets_data'] = array();

		}



		if($reload=='reload'){

			

			$last_record=$this->general->get_tbl_data('asen_asenid,asen_component_typeid,asen_assettypeid,asen_locationid','asen_assetentry',false,'asen_asenid','DESC',1);

			if(!empty($last_record)){

				$this->data['last_component_typeid']=$last_record[0]->asen_component_typeid;

				$this->data['last_assettypeid']=$last_record[0]->asen_assettypeid;

				$this->data['last_locationid']=$last_record[0]->asen_locationid;

			}

			$this->load->view('component_assets/v_comp_assets_form',$this->data);

		}else{

		

			$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('component_assets/v_comp_assets_main', $this->data);

		}



	}



	public function get_assets_component_from(){

		$ctype=$this->input->post('ctype');

		$branchid=$this->input->post('branchid');



		if(empty($branchid)){

			print_r(json_encode(array('status'=>'error','message'=>'Branch is required')));

	        	exit;

		}

		

		





		// echo $this->data['asset_code'];

		// die();



		

		$html='';

		if($ctype){

			$this->data=array();

		$this->data['manufacturers']=$this->manufacturers_mdl->get_all_manufacturers();

		$this->data['soil_type_list']=$this->general->get_tbl_data('*','soty_soiltype',array('soty_isactive'=>'Y'));

		$this->data['joint_type_list']=$this->general->get_tbl_data('*','joty_jointype',array('joty_isactive'=>'Y'));

		$this->data['material_type_list']=$this->general->get_tbl_data('*','pimt_pipematerialtype',array('pimt_isactive'=>'Y'));

		$this->data['pipe_zone_type_list']=$this->general->get_tbl_data('*','pizo_pipezone',array('pizo_isactive'=>'Y'));

		$this->data['pavement_type_list']=$this->general->get_tbl_data('*','paty_pavementtype',array('paty_isactive'=>'Y'));

		$this->data['valve_type_list']=$this->general->get_tbl_data('*','vaty_valvetype',array('vaty_isactive'=>'Y'));

		$this->data['hydrant_type_list']=$this->general->get_tbl_data('*','hyty_hydrantstype',array('hyty_isactive'=>'Y'));

		$this->data['flowmeter_type_list']=$this->general->get_tbl_data('*','flty_flowmeterstype',array('flty_isactive'=>'Y'));

		$this->data['treatmentplan_type_list']=$this->general->get_tbl_data('*','tept_treatmentplantype',array('tept_isactive'=>'Y'));

		$this->data['treatmentcomponent_list']=$this->general->get_tbl_data('*','teco_treatmentcomponent',array('teco_isactive'=>'Y'));

		$this->data['asset_status_list']=$this->general->get_tbl_data('*','asst_assetstatus',array('asst_isactive'=>'Y'));





		$comp_code='';

		$component_type=$this->general->get_tbl_data('coty_code','coty_componenttype',array('coty_id'=>$ctype));

		if(!empty($component_type)){

			$comp_code=!empty($component_type[0]->coty_code)?$component_type[0]->coty_code:'';



		}



		// echo $comp_code;

		// die();





		$this->data['asset_code'] = $this->general->generate_invoiceno('asen_assetcode','asen_assetcode','asen_assetentry',$comp_code,ASSET_CODE_NO_LENTH,false,'asen_locationid',false,false,false,'Y');

		// echo $this->data['asset_code'];

		// die();



		$branch_data=$this->general->get_tbl_data('loca_code','loca_location',array('loca_locationid'=>$branchid));

		if(!empty($branch_data)){

			$branch_code=!empty($branch_data[0]->loca_code)?$branch_data[0]->loca_code:'';



		}

		$this->data['faccode']=$branch_code;

		$currentfyrs=CUR_FISCALYEAR;

			$this->data['project_list']=$this->general->get_tbl_data('*','prin_projectinfo',array('prin_fiscalyrs'=>$currentfyrs),'prin_prinid','ASC');

			$this->data['frequency']=$this->general->get_tbl_data('*','frty_frequencytype',array('frty_isactive'=>'Y'));



		// echo $branch_code;

		// die();

		$this->data['ncomponent_code']=$branch_code.'-'.$this->data['asset_code'];



		   if($ctype=='1'){

			$html=$this->load->view('component_assets/v_comp_assets_pipe_form',$this->data,true);

		   }

		   else if($ctype=='2'){

		  	$this->data['chambertype_list']=$this->general->get_tbl_data('*','chty_chambertype',array('chty_isactive'=>'Y'));

		  	$this->data['valvesetting_list']=$this->general->get_tbl_data('*','vase_valvesetting',array('vase_isactive'=>'Y'));

			$html=$this->load->view('component_assets/v_comp_assets_valve_form',$this->data,true);

		   }

		   else if($ctype=='3'){

			$html=$this->load->view('component_assets/v_comp_assets_hydrants_form',$this->data,true);

		   }

		   else if($ctype=='4'){

			$html=$this->load->view('component_assets/v_comp_assets_flowmeters_form',$this->data,true);

		   }

		   else if($ctype=='5'){

		   		$this->data['pump_capacity_list']=$this->general->get_tbl_data('*','puca_pumpcapacity',array('puca_isactive'=>'Y'));

			$html=$this->load->view('component_assets/v_comp_assets_treatmentplan_form',$this->data,true);

		   }

		   else if($ctype=='6'){

		  

		  	$this->data['pump_type_list']=$this->general->get_tbl_data('*','pmty_pumptype',array('pmty_isactive'=>'Y'));

			$html=$this->load->view('component_assets/v_comp_assets_tubewell_form',$this->data,true);



		   }

		    else if($ctype=='7'){

    		$this->data['reserviourtype_list']=$this->general->get_tbl_data('*','rety_reserviourtype',array('rety_isactive'=>'Y'));

   			$this->data['reserviourshape_list']=$this->general->get_tbl_data('*','resh_reserviourshape',array('resh_isactive'=>'Y'));

			$html=$this->load->view('component_assets/v_comp_assets_reserviour_form',$this->data,true);

		   }

		    else if($ctype=='8'){

		    $this->data['buildingtype_list']=$this->general->get_tbl_data('*','buty_buildingtype',array('buty_isactive'=>'Y'));

    		$html=$this->load->view('component_assets/v_comp_assets_building_form',$this->data,true);

		   }

		    else if($ctype=='9'){

    		

			$html=$this->load->view('component_assets/v_comp_assets_land_form',$this->data,true);

		   }

		    else if($ctype=='10'){

    		

			$html=$this->load->view('component_assets/v_comp_assets_sewerage_form',$this->data,true);

		   }









		}

		

			if($html){

		  		$template=$html;

		  		  print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));

	        	exit;

		  	}else{

	        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        	exit;

        }

		

	}



	public function save_component_assets(){

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			try {

				$id=$this->input->post('id');

			  

				$this->form_validation->set_rules($this->assets_mdl->validate_settings_assets_component);

			  	if($this->form_validation->run()==TRUE)

			 	{

			 		$trans = $this->assets_mdl->save_assets_component_entry();

            		if($trans)

            		{

            	 	 	print_r(json_encode(array('status'=>'success','message'=>'Record Saved Successfully','param'=>$trans)));

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



	public function form_component_assets(){



	}





	public function form_assets()

	{

		$this->data['status']=$this->assets_mdl->get_status();

		$this->data['condition']=$this->assets_mdl->get_condition();

		$this->data['material']=$this->assets_mdl->get_assets_category();

		$this->data['depreciation']=$this->assets_mdl->get_depreciation();

		$this->data['manufacturers']=$this->manufacturers_mdl->get_all_manufacturers();

		$this->data['distributors']=$this->distributors_mdl->get_distributor_list();



		$this->load->view('assets/v_assets_form',$this->data);

	}



	public function save_assets()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			try {

			// if($this->input->post('id'))

			// {

			// 	if(MODULES_UPDATE=='N')

			// 	{

			// 	$this->general->permission_denial_message();

			// 	exit;

			// 	}

			// }

			// else

			// {

			// 	if(MODULES_INSERT=='N')

			// 	{

			// 	$this->general->permission_denial_message();

			// 	exit;

			// 	}

			// }

                    // $test=$this->input->post('asen_deppercentage');

        

				$id=$this->input->post('id');

				// echo "<pre>";

				// print_r($this->input->post());

				// die();

				$operation=$this->input->post('operation');



				

			  

				$this->form_validation->set_rules($this->assets_mdl->validate_settings_assets);

			

			

			  	if($this->form_validation->run()==TRUE)

			 	{

			 		$trans = $this->assets_mdl->save_assets();



            		if($trans)

            		{

            	 	 	print_r(json_encode(array('status'=>'success','message'=>'Record Saved Successfully','param'=>$trans)));

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







	public function save_general_assets(){

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			try {

				$this->form_validation->set_rules($this->assets_mdl->validate_settings_generalassets);

			

			

			  	if($this->form_validation->run()==TRUE)

			 	{

			 		$trans = $this->assets_mdl->save_general_assets();



            		if($trans){

            	 	 	print_r(json_encode(array('status'=>'success','message'=>'Record Saved Successfully','param'=>$trans)));

            			exit;

            		}

            		else{

            	 		print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));

            			exit;

            		}

        		}

        		else{

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



	public function list_of_assets($result=false,$org_id=false)

	{

	 $this->data['tab_type']='list1';

	 $this->page_title='Assets List';

	    $this->data['status']=$this->assets_mdl->get_status();

		$this->data['condition']=$this->assets_mdl->get_condition();

		$this->db->select('*');

	    $this->db->from('eqca_equipmentcategory ec');

	    $this->db->where('eqca_isnonexp','Y');

	    $result=$this->db->get()->result();



		$this->data['material']=$result;

		$this->data['manufacturers']=$this->manufacturers_mdl->get_all_manufacturers();

		$this->data['distributors']=$this->distributors_mdl->get_distributor_list();

		$this->data['descriptuon']=$this->assets_mdl->assets_description();

		$this->data['department_list']=$this->general->get_tbl_data('*','dept_department',false);

		$this->data['receiver_list']=$this->general->get_tbl_data('stin_staffinfoid,stin_fname,stin_mname,stin_lname','stin_staffinfo',false,'stin_fname','ASC');



		// echo '<pre>';print_r($this->data['department_list']);


		if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY' ){
			$view='assets/'.REPORT_SUFFIX.'/v_assets_list';
		}else{
			$view='assets/v_assets_list';
		}

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build($view, $this->data);
		

	}







	public function get_assets_list()

	{

		// if(MODULES_VIEW=='N')

		// 	{

		// 	  	$array["asen_assetcode"] ='';

		// 	    $array["asen_assettype"] = '';

		// 	    $array["asen_modelno"] =''; '';

		// 	    $array["asen_serialno"] = '';

		// 	    $array["asen_status"] = '';

		// 	    $array["asen_condition"] = '';

  		//      $array["action"]='';

  		//         echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));

  		//          exit;

		// 	}

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);

		$orgid = $this->session->userdata(ORG_ID);

	


		if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY' ){
					$data = $this->assets_mdl->get_all_assets_list_ku();

		}else{
			$data = $this->assets_mdl->get_all_assets_list();

		}

		// echo $this->db->last_query();
		// die();

		// echo "<pre>"; print_r($data); die();

 

	  	$i = 0;

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);

		$totalrecs = $data["totalrecs"];



	    unset($data["totalfilteredrecs"]);

	  	unset($data["totalrecs"]);

	  

		  	foreach($data as $row)

		    {

			    $array[$i]["assets_code"] = $row->asen_assetcode;

			    $array[$i]["assets_type"] = $row->eqca_category;

			    $array[$i]["description"] = $row->asen_desc;



			    // $array[$i]["description"] = $row->itli_itemname;

			    $array[$i]["model_no"] = $row->asen_modelno;

			    $array[$i]["serial_no"] = $row->asen_serialno;

			    $array[$i]["status"] = $row->asst_statusname;

			    $array[$i]["condition"] = $row->asco_conditionname;
			    $array[$i]["depname"] = $row->dept_depname;
			    if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY' ){
			   	 $array[$i]["school"] = !empty($row->schoolname)?$row->schoolname:'';
			   	 $parentdep=!empty($row->depparent)?$row->depparent:'';
			   	 if(!empty($parentdep)){
			   	 	 $array[$i]["depname"] = $row->depparent.'/'.$row->dept_depname;	
			   	 	}else{
			   	 		$array[$i]["depname"] = $row->dept_depname;	
			   	 	}
			   	 
			    }
			    
			    $array[$i]['itemname']=!empty($row->itli_itemname)?$row->itli_itemname:'';
			    $array[$i]['supplier']=!empty($row->dist_distributor)?$row->dist_distributor:'';
			    $fname=!empty($row->stin_fname)?$row->stin_fname:'';
			    $mname=!empty($row->stin_mname)?$row->stin_mname:'';
			    $lname=!empty($row->stin_lname)?$row->stin_lname:'';
			    $array[$i]['receiver_name']=$fname.' '.$mname.' '.$lname;
			    if(ORGANIZATION_NAME=='KU'  || ORGANIZATION_NAME=='ARMY' ){
			    	if(empty($row->asen_staffid)){
			    		$str = strtoupper($row->asen_desc);
			    		if(strpos($str, "RECEVIED BY") || strpos($str, "RECEVIED BY"))
			    		{
			    		$replace_rec_var = substr($str,strpos($str, "RECEVIED BY"), -1);
			    		$replace_rec=str_replace('RECEVIED BY', '', $replace_rec_var);
			    		$array[$i]['receiver_name']=$replace_rec;
			    		}

			    	}
			    }
			    
			   
			     if(DEFAULT_DATEPICKER=='NP')

			    {

			    	 $array[$i]["purchase_date"] = $row->asen_purchasedatebs;

			    }

			    else

			    {

			    	  $array[$i]["purchase_date"] = $row->asen_purchasedatead;	

			    }



			     if(DEFAULT_DATEPICKER=='NP')

			    {

			    	 $array[$i]["warrenty_date"] = $row->asen_warrentydatebs;

			    }

			    else

			    {

			    	  $array[$i]["warrenty_date"] = $row->asen_warrentydatead;	

			    }

			     $array[$i]["rate"] = !empty($row->asen_purchaserate)?$row->asen_purchaserate:'';

			     $array[$i]["location"] = !empty($row->asen_location)?$row->asen_location:'';


// <a href="javascript:void(0)" data-id='.$row->asen_asenid.' data-tableid='.$row->asen_asenid.' data-deleteurl='.base_url('ams/assets/assets_delete') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a> |


			  

			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->asen_asenid.' data-displaydiv="assets" data-viewurl='.base_url('ams/assets/assets_entry').' class="btnredirect"><i class="fa fa-edit" aria-hidden="true" ></i></a> | 

			    	 

			    	<a href="javascript:void(0)" data-id='.$row->asen_asenid.' data-displaydiv="assets" data-viewurl='.base_url('/ams/assets/assets_details').' class="view" data-heading="Asset Details"><i class="fa fa-eye" aria-hidden="true" ></i></a>';

			     

			    $i++;

		        //(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');

		    }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}





	public function assets_delete()

    {

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			// if(MODULES_DELETE=='N')

			// 	{

			// 	$this->general->permission_denial_message();

			// 	exit;

			// 	}



			$id=$this->input->post('id');





			$trans=$this->assets_mdl->delete_assets();

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



	public function edit_assets()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {



		    // 			if(MODULES_UPDATE=='N')

						// {

						// $this->general->permission_denial_message();

						// exit;

						// }

			$id=$this->input->post('id');



			$this->data['status']=$this->assets_mdl->get_status();

			$this->data['condition']=$this->assets_mdl->get_condition();

			$this->data['material']=$this->assets_mdl->get_assets_category();

			$this->data['depreciation']=$this->assets_mdl->get_depreciation();

			$this->data['manufacturers']=$this->manufacturers_mdl->get_all_manufacturers();

			$this->data['distributors']=$this->distributors_mdl->get_distributor_list();

			$this->data['assets_data']=$this->assets_mdl->get_all_assets(array('asen_asenid'=>$id));

			// echo "<pre>";

			// print_r($this->data['assets_data']);

			// die();

			

			$tempform=$this->load->view('assets/v_assets_form',$this->data,true);

				// echo $tempform;

				// die();

			if(!empty($this->data['assets_data']))

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



	public function generate_pdfDirect()

    {

    	if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY' )
    	{
		    $this->data['searchResult'] = $this->assets_mdl->get_all_assets_list_ku();
			// echo "string";
			// die();
		} 
		else
		{
			
          $this->data['searchResult'] = $this->assets_mdl->get_all_assets_list();

		}




        // echo "<pre>";

        // print_r( $this->data['searchResult']);

        // die();

        unset($this->data['searchResult']['totalfilteredrecs']);

        unset($this->data['searchResult']['totalrecs']);
        	$this->data['report_title']='Assets List';
        	$dateSearch=$this->input->get('dateSearch')?$this->input->get('dateSearch'):'';
        	$frmDate=$this->input->get('frmDate')?$this->input->get('frmDate'):'';
        	$toDate=$this->input->get('toDate')?$this->input->get('toDate'):'';
        	if(!empty($dateSearch)){
	    		$this->data['fromdate']= $frmDate;
	    		$this->data['todate']=$toDate;
        	}else{
        		
        	}

        if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY'  )
	        {

	        	
	        	 $html = $this->load->view('assets/'.REPORT_SUFFIX.'/v_assets_list_download', $this->data, true);

	        }
        else
	        {
	            $html = $this->load->view('assets/v_assets_list_download', $this->data, true);
		
	        }


       

      	$filename = 'direct_purchase_'. date('Y_m_d_H_i_s') . '_.pdf'; 

        $pdfsize = 'A4-L'; //A4-L for landscape

        //if save and download with default filename, send $filename as parameter

        $this->general->generate_pdf($html,false,$pdfsize);

        exit();

    }



    public function exportToExcelDirect()

    {

        header("Content-Type: application/xls");    

        header("Content-Disposition: attachment; filename=assets_list".date('Y_m_d_H_i').".xls");  

        header("Pragma: no-cache"); 

        header("Expires: 0");



        $data = $this->assets_mdl->get_all_assets_list();

if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY' )
    	{
		    $this->data['searchResult'] = $this->assets_mdl->get_all_assets_list_ku();
			// echo "string";
			// die();
		} 
		else
		{
			
          $this->data['searchResult'] = $this->assets_mdl->get_all_assets_list();

		}



        

        $array = array();

        unset($this->data['searchResult']['totalfilteredrecs']);

        unset($this->data['searchResult']['totalrecs']);

          if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY'  )
	        {

	        	
	        	 $response = $this->load->view('assets/'.REPORT_SUFFIX.'/v_assets_list_download', $this->data, true);

	        }
        else
	        {
	            $response = $this->load->view('assets/v_assets_list_download', $this->data, true);
		
	        }




        echo $response;

    }



	public function summary_report_assets()

  	{

   	 	// $depwise=$this->bio_medical_mdl->get_department_wise_report();

  	 	// $this->data['departmentwise']=$this->assets_mdl->get_column_wise_report('bmin_bmeinventory bm' ,'dept_department dp', $where=false,"bm.bmin_departmentid,COUNT('*') as cnt,dept_depname",'dp.dept_depid=bm.bmin_departmentid','INNER','bm.bmin_departmentid','dp.dept_depname','ASC');



		$this->data['conditionwise']=$this->assets_mdl->get_column_wise_report('asen_assetentry ae' ,'asco_condition ac', $where=false,"ae.asen_condition,COUNT('*') as cnt,asco_conditionname",'ac.asco_ascoid=ae.asen_condition','INNER','ae.asen_condition','ac.asco_conditionname','ASC');



   	 	$this->data['statuswise']=$this->assets_mdl->get_column_wise_report('asen_assetentry ae' ,'asst_assetstatus as', $where=false,"ae.asen_status,COUNT('*') as cnt,asst_statusname",'as.asst_asstid=ae.asen_status','INNER','ae.asen_status','as.asst_statusname','ASC');



 		$this->data['manufacture_wise']=$this->assets_mdl->get_column_wise_report('asen_assetentry ae' ,'manu_manufacturers ma', $where=false,"ae.asen_manufacture,COUNT('*') as cnt,manu_manlst",'ma.manu_manlistid=ae.asen_manufacture','INNER','ae.asen_manufacture','ma.manu_manlst','ASC');



 		$this->data['category_wise']=$this->assets_mdl->get_column_wise_report('asen_assetentry ae' ,'eqca_equipmentcategory ec', $where=false,"ae.asen_assettype,COUNT('*') as cnt,eqca_category",'ec.eqca_equipmentcategoryid=ae.asen_assettype','INNER','ae.asen_assettype','ec.eqca_category','ASC');



 		$this->data['warrenty_wise']=$this->assets_mdl->get_column_wise_report('asen_assetentry ae' ,false, $where=false,"ae.asen_warrentydatebs,COUNT('*') as cnt",false,false,'ae.asen_warrentydatebs','ae.asen_warrentydatebs','ASC');



 		$this->data['location_wise']=$this->assets_mdl->get_column_wise_report('asen_assetentry ae' ,'loca_location loc', $where=false,"ae.asen_locationid,COUNT('*') as cnt,loc.loca_name",'ae.asen_locationid=loc.loca_locationid','INNER','ae.asen_locationid','loc.loca_name','ASC');



 		// echo "<pre>";

 		// print_r($this->data['location_wise']);

 		// die();







 		$this->data['in_warrenty']=$this->assets_mdl->in_warrenty();

 		$this->data['out_warrenty']=$this->assets_mdl->out_warrenty();



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

        $this->data['tab_type']="summary_report";





        $this->template

            ->set_layout('general')

            ->enable_parser(FALSE)

            ->title($this->page_title)

           // ->build('report/v_column_wise_report', $this->data);

            ->build('assets/v_column_wise_report', $this->data);

	}



	public function assets_search()

	{

		$this->data['status']=$this->assets_mdl->get_status();

		$this->data['condition']=$this->assets_mdl->get_condition();

		$this->data['material']=$this->assets_mdl->get_assets_category();



		$this->data['depreciation']=$this->assets_mdl->get_depreciation(array('dety_isactive'=>'Y'));

		$this->data['manufacturers']=$this->manufacturers_mdl->get_all_manufacturers();

		$this->data['distributors']=$this->distributors_mdl->get_distributor_list();

		$this->data['assets_type']=$this->assets_mdl->get_assets_type();



        $this->data['tab_type']="assets_search";



		$this->page_title='Assets Search';

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('assets/v_assets_search', $this->data);

		//$this->load->view('assets/v_assets_search',$this->data);

	}

	

	// Search Assets lists

	public function search_assets()

    {

    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   		//  if(MODULES_VIEW=='N')

		// {		

 		// 		print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));

		// 	exit;

		// }



	      	$html = $this->get_search_assets();

		  	if($html)

		  	{

		  		$template=$html;

		  	}

	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));

	        exit;

	    }else{

        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

        	exit;

        }

    }



    public function search_assets_list_pdf()

   	{  

   		error_reporting(E_ALL);

    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		    $html = $this->get_search_assets();



	        $filename = 'assets_list_'. date('Y_m_d_H_i_s') . '_.pdf'; 

	        $pdfsize = 'A4-L'; //A4-L for landscape

	        //if save and download with default filename, send $filename as parameter

	        $this->general->generate_pdf($html,false,$pdfsize);

	        exit();

	    }else{

        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

        	exit;

        }

    }



    public function search_assets_list_excel()

    {

    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    	error_reporting(E_ALL);

    	header("Content-Type: application/xls");    

        header("Content-Disposition: attachment; filename = assets_list_".date('Y_m_d_H_i').".xls");  

        header("Pragma: no-cache"); 

        header("Expires: 0");	      

      	$response = $this->get_search_assets();

      	//print_r($response);die;

    	echo $response;

    	 }else{

        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

        	exit;

        }

    }



    public function get_search_assets()

    {

    	if ($_SERVER['REQUEST_METHOD'] === 'POST') 

    	{

    		$this->data['excel_url'] = "ams/assets/search_assets_list_excel";

			$this->data['pdf_url'] = "ams/assets/search_assets_list_pdf";

			$this->data['report_title'] = "Report";



    		$assettype = $this->input->post('asen_assettype');

	      	$manufacture = $this->input->post('asen_manufacture');

	      	$status = $this->input->post('asen_status');

	      	$condition = $this->input->post('asen_condition');

	      	$depreciation = $this->input->post('asen_depreciation');

	        $frmDate=!empty($this->input->post('frmDate'))?$this->input->post('frmDate'):'';

            $toDate=!empty($this->input->post('toDate'))?$this->input->post('toDate'):'';

            $dateSearch = $this->input->post('dateSearch');

            $Datatype = $this->input->post('Datatype');

             $asen_assettypeid = $this->input->post('asen_assettypeid');

            // print_r($Datetype);die;



	      	$srchcol = "";

   

	  		// $this->data['assets_report']=$this->assets_mdl->get_assets_list_data();

	  		$this->data['assets_report']=$this->assets_mdl->get_assets_list_data(false,false,false,false,false,'distinct');

	  		// print_r( $this->data['assets_report']);die;

	  		if($dateSearch==''){

	  			$this->data['datefor']="All";

	  			if(DEFAULT_DATEPICKER=='NP')

				{

					$this->data['fordate']=$frmDate;

					$this->data['todate']=$toDate;

				}

				else

				{

				  $this->data['fordate']=$frmDate;

					$this->data['todate']=$toDate;

				}



	  		}



	  		if($dateSearch=='purchasedate'){

	  			$this->data['datefor']="Purchase Date";

	  			if(DEFAULT_DATEPICKER=='NP')

				{

					$this->data['fordate']=$frmDate;

					$this->data['todate']=$toDate;

				}

				else

				{

				  $this->data['fordate']=$frmDate;

					$this->data['todate']=$toDate;

				}



	  		}

	  		if($dateSearch=='inservicedate'){

	  			$this->data['datefor']="In service Date";

	  			if(DEFAULT_DATEPICKER=='NP')

				{

					$this->data['fordate']=$frmDate;

					$this->data['todate']=$toDate;

				}

				else

				{

				  $this->data['fordate']=$frmDate;

					$this->data['todate']=$toDate;

				}

	  			

	  		}

	  		if($dateSearch=='warrentydate'){

	  			$this->data['datefor']="Warrenty Date";

	  			if(DEFAULT_DATEPICKER=='NP')

				{

					$this->data['fordate']=$frmDate;

					$this->data['todate']=$toDate;

				}

				else

				{

				   $this->data['fordate']=$frmDate;

					$this->data['todate']=$toDate;

				}

	  			

	  		}

	  		



	      	if($status):

				$this->data['status']=$this->general->get_tbl_data('asst_statusname','asst_assetstatus',array('asst_asstid'=>$status));

			else:

				$this->data['status'] = 'All';

			endif;



			if($condition):

				$this->data['condition']=$this->general->get_tbl_data('asco_conditionname','asco_condition',array('asco_ascoid'=>$condition));

			else:

				$this->data['condition'] = 'All';

			endif;



			if($manufacture):

				$this->data['manufacture']=$this->general->get_tbl_data('manu_manlst','manu_manufacturers',array('manu_manlistid'=>$manufacture));

			else:

				$this->data['manufacture'] = 'All';

			endif;



			if($assettype):

				$this->data['assettype']=$this->general->get_tbl_data('eqca_category','eqca_equipmentcategory',array('eqca_equipmentcategoryid'=>$assettype));

			else:

				$this->data['assettype'] = 'All';

			endif;



			//$html=$this->load->view('assets/v_assets_report',$this->data,true);



		    if($this->data['assets_report'])

		    {

		    	$html=$this->load->view('assets/v_assets_report',$this->data,true);

		    }

		    else

		    {

		        $html='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';

		    }



		    return $html;

    	}

    	else

    	{

        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

        	exit;

        }

    }



	public function get_assets_description()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$eqtypeid=$this->input->post('eqtypeid');



			if(!empty($eqtypeid))

			{

			 	

			 	$eqtype = $this->data['eqtype']=$this->assets_mdl->get_assets(array('eq.itli_catid'=>$eqtypeid));



			 	if(!empty($eqtype)){

			 		echo json_encode(array('status'=>'success','message'=>'Data Available','data'=>$this->data['eqtype']));	

			 	}else{

			 		echo json_encode(array('status'=>'error','message'=>'Data Not Available'));

			 	}

			}

			else{

			 	echo json_encode(array('status'=>'error','message'=>'Operation Unsuccessful!!!'));

			}

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

			exit;

		}

	}



 	// For assets Comments

    public function assets_comment()

    {

		$this->page_title='Bio-medical Inventory Comments';

	 	$this->data['breadcrumb']='';

	 	$this->data['tab_type']='c';

    	$this->template

				->set_layout('general')

				->enable_parser(FALSE)

				->title($this->page_title)

				->build('assets/v_assets_comment',$this->data);

    }



 	public function list_of_assets_inv()

	{

	    if ($_SERVER['REQUEST_METHOD'] === 'POST') 

	    {

			try {

				$data['equipment_inv_list'] = $this->assets_mdl->get_all_assets(false,10,false,'asen_asenid','ASC');

				  // echo "<pre>";

				  // print_r($data);

				  // die();

				$template=$this->load->view('ams/assets/list_of_assets_inv',$data,true);

		        

		        if($template){

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



	public function get_assets_details()

    {

    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$equid_key = $this->input->post('id');

			// echo $equid_key;

			// die();



			$this->data['eqli_data'] = $this->assets_mdl->get_all_assets(array('ae.asen_assetcode'=>$equid_key));



			// echo "Check";

			// echo "<pre>";

			// print_r($this->data['eqli_data']);

			// die();assets_details



			if($this->data['eqli_data'])

			{

			$equid=$this->data['eqli_data'][0]->asen_asenid;

			$orgid = $this->session->userdata(ORG_ID);



			// echo "<pre>";

			// print_r($this->data['eqli_data']);

			// die();

			$this->data['listurl']=base_url().'biomedical/bio_medical_inventory/list_bio_comments/'.$equid;

			$this->data['deleteurl']=base_url().'biomedical/bio_medical_inventory/delete_bio_comment';



			$this->data['equip_comment'] = $this->assets_mdl->get_assets_comment(array('ec.eqco_orgid'=>$orgid,'ec.eqco_eqid'=>$equid));

			// echo "<pre>";

			// print_r($this->data['equip_comment']);

			// die();



			 $template=$this->load->view('assets/v_assets_comment_form',$this->data,true);

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



    public function get_asset_code()

    {

    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    		try{

    			$asset_desc_id = $this->input->post('asset_desc_id');

    			$asset_desc_name = trim($this->input->post('asset_desc_name'));

    			$item_name=$this->general->get_tbl_data('itli_itemname','itli_itemslist',array('itli_itemlistid'=>$asset_desc_id),'itli_itemname','ASC');

    			$fyear=CUR_FISCALYEAR;
    			// echo "<pre>";

    			// print_r($item_name);

    			// die();

    			if($item_name){

    				$item_description=$item_name[0]->itli_itemname;

    			}else{

    				$item_description='';

    			}

    			

    			$break_asset_desc = explode('|',$asset_desc_name);



    			$get_asset_name = trim($break_asset_desc[1]);



    			$format=$this->generate_asset_code($item_description,$asset_desc_id,$fyear);

	 			print_r(json_encode(array('status'=>'success','asset_code'=>$format,'item_description'=>$item_description, 'message'=>'Successfully Created!!')));

	       		exit;	

		 		

	    	}catch(Exception $e){

	    		throw $e;

	    	}

    	}else{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

        	exit;

		}

	}





	public function generate_asset_code($asset_name, $itemid = false,$fiscalyear = false){

		$wordcount=str_word_count($asset_name);



		// print_r('wc'.$wordcount);

		// die();

		$asset_code='';

		if($wordcount==1)

		{

			$asset_code= strtoupper(substr($asset_name, 0, 3));

		}

		if($wordcount==2)

		{

			$stringarray= explode(' ', $asset_name);

			// print_r($stringarray);

			$str1= strtoupper(substr($stringarray[0], 0, 2));

			$str2= strtoupper(substr($stringarray[1], 0, 1));

			$asset_code= $str1.$str2;	

		}

		if($wordcount==3)

		{

			$stringarray= explode(' ', $asset_name);

			// print_r($stringarray);

			$str1= strtoupper(substr($stringarray[0], 0, 1));

			$str2= strtoupper(substr($stringarray[1], 0, 1));

			$str3= strtoupper(substr($stringarray[2], 0, 1));



			$asset_code= $str1.$str2.$str3;	

		}



		if($wordcount>=4)

		{

			$stringarray= explode(' ', $asset_name);

 			// print_r($stringarray);



			$str1= strtoupper(substr($stringarray[0], 0, 1));

			$str2= strtoupper(substr($stringarray[1], 0, 1));

			$str3= strtoupper(substr($stringarray[2], 0, 1));

			$str4= !empty($stringarray[3])?strtoupper(substr($stringarray[3], 0, 1)):'';



			$asset_code= $str1.$str2.$str3;	

		}



		// echo $asset_code;

		// die();



		// $asset_list = $this->general->get_tbl_data('asen_maxval','asen_assetentry',array('asen_description'=>$itemid),'asen_asenid','DESC');

		$maxval=0;

		$this->db->select('asen_assetcode');

		$this->db->from('asen_assetentry');

		$this->db->where('asen_description',$itemid);
		$this->db->where('asen_assetcode!=', '');
		$this->db->order_by('asen_asenid', 'DESC');

		$this->db->order_by('asen_assetcode','DESC');

		$this->db->limit(1);

		$rslt=$this->db->get()->row();

		// echo $this->db->last_query();

		// die();

		// print_r($rslt);
		// die();



		if (!empty($rslt)) {

			// echo "asd";

			// die();

			$assetecode = !empty($rslt->asen_assetcode) ? $rslt->asen_assetcode : '';
			// var_dump($assetecode);
			// die;

			// echo end( explode( "-", $assetecode ) );



			$asscode_array = explode('-', $assetecode);

			// if(!empty($asscode_array)){

			// 	$ass_Array1=$asscode_array[0];

			// 	$ass_Array2=$asscode_array[1];

			// }

			// $maxval=$ass_Array2;

			// if()

			if (is_array($asscode_array) && !empty($asscode_array)) {

				$sizeofassets = sizeof($asscode_array);
			} else {

				$sizeofassets = 0;
			}

			// echo $sizeofassets;

			// die();

			$numberfilter = $asscode_array[$sizeofassets - 2];

			// echo $numberfilter;

			// die();

			$length_of_number_filter = strlen($numberfilter);

			$increment_assets_number = $numberfilter + 1;



			$final_number_gen = str_pad($increment_assets_number, $length_of_number_filter, 0, STR_PAD_LEFT);

			$new_ass_code_arr_str = '';

			if (!empty($asscode_array)) {

				for ($i = 0; $i < $sizeofassets - 2; $i++) {

					$new_ass_code_arr_str .= $asscode_array[$i] . '-';
				}
			}

			$final_assets_code = $new_ass_code_arr_str . $final_number_gen;
		} else {

			$increment_assets_number = 1;





			$final_number_gen = str_pad($increment_assets_number, AUTO_ASSET_CODE_LENGTH, 0, STR_PAD_LEFT);



			// echo $final_number_gen;

			// die();
			$asset_code = preg_replace('/[^A-Za-z0-9\-]/', '', $asset_code);
			$final_assets_code = $asset_code . '-' . $final_number_gen;
		}



		// echo $final_assets_code;

		// die();



		if (!empty($fiscalyear)) {

			return $final_assets_code . '-' . $fiscalyear;
		}





		return $final_assets_code;

	}



	public function get_barcode()

	{

    	$this->data['asset_code'] = $this->input->post('asen_assetcode');

    	$asset_id=$this->input->post('asset_id');



    	$this->data['servicedate']='';

    	if($asset_id)

    	{

    		// $asset_data = $this->general->get_tbl_data('asen_description, asen_assetcode','asen_assetentry',array('asen_asenid'=>$asset_id),'asen_asenid','ASC');



    		$asset_data = $this->assets_mdl->get_assets_data(array('asen_asenid'=>$asset_id));



    		$this->data['desc'] = $asset_data[0]->itli_itemname;



    		$this->data['codename']=$asset_data[0]->asen_assetcode;



    		$orga = explode(" ", ORGA_NAME);

			$acronym = "";



			foreach ($orga as $org) {

			  	$acronym .= $org[0];

			}



			$asset_code = $this->data['codename'];



			$eqID = explode('-', $asset_code);



			$desc_name = !empty($eqID[0])?$eqID[0]:'';

			$desc_number = !empty($eqID[1])?$eqID[1]:'';



			if(!empty($desc_number)){

				$new_asset_code = $acronym.'-'.$desc_name.'-'.$desc_number;

			}else{

				$new_asset_code = $acronym.'-'.$desc_name;

			}



    		// $this->data['new_asset_code'] = $new_asset_code;



    		$this->data['new_codename'] = $asset_code;



    		$this->data['qr_link'] = QRCODE_URL.'/assets/reports/overview_report'.'/'.$asset_code;





    		if(DEFAULT_DATEPICKER=='NP'){

				$this->data['servicedate']=!empty($equpdata[0]->asen_inservicedatebs)?$equpdata[0]->asen_inservicedatebs:'';

			}

			else{

				$this->data['servicedate']=!empty($equpdata[0]->asen_inservicedatead)?$equpdata[0]->asen_inservicedatead:'';

			}    		



    	}

    	

    	//codename, new_codename, desc variables should be passed

    	$tempform=$this->load->view('common/v_barcode',$this->data,true);



    	// echo $tempform;

    	// die();



    	if(!empty($this->data['codename']))

		{

				print_r(json_encode(array('status'=>'success','message'=>'Success','tempform'=>$tempform)));

            	exit;

		}

		else{

			print_r(json_encode(array('status'=>'error','message'=>'Error')));

            	exit;

		}

    }



    

public function get_live_dep_calculation()

{

	$dep_methodid=$this->input->post('dep_method');

	if($dep_methodid==1){

		$this->get_st_line_depr();

	}



}





//depreciation methods

	public function get_st_line_depr()

	{

		

		$postdata=($this->input->post());

		// echo ORGANIZATION_NAME;

		// die();

		

		//$end_date=$postdata['dep_life_start'];

		if(ORGANIZATION_NAME=='KUKL')

		{

			$start_date=$postdata['asen_inservicedate'];



		}else{

			$start_date=$postdata['asen_purchasedate'];

			

		}



		$start_date_exploded= explode('/', $start_date);

		$year=$start_date_exploded[0];

		$month=$start_date_exploded[1];

		$days=$start_date_exploded[2];



		$principal=($postdata['asen_purchaserate']);	//P

		$salvage_value=($postdata['asen_salvageval']);	//s

		$useful_life=$postdata['asen_expectedlife'];	

		$this->common_principal=$principal;

		

		$this->common_month=$month;

		$this->common_year=$year;	

		$this->common_date=$start_date;		//t

		

		$template=$this->assets_deprecation_mdl->depr_calc_straight_line_partial($principal,0,$salvage_value,$useful_life);



		print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

	}



	public function st_dep_calc()

	{

		$principal=0;$depr_amount=0;

		

		$postdata=($this->input->post());

		$principal=($postdata['dep_purchase_cost']);

		$useful_life=$postdata['dep_life'];

		$depr_amount=(($postdata['dep_purchase_cost'])/($postdata['dep_life']));

		$template=$this->assets_mdl->depr_calc_straight_line($depr_amount,$principal,1,$useful_life);

		print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

	}



	public function ddb_dep_calc()

	{

		

		$postdata=($this->input->post());



		$start_date=$postdata['purchase_date'];

		//$end_date=$postdata['dep_life_start'];



		$start_date_exploded= explode('/', $start_date);

		$year=$start_date_exploded[0];

		$month=$start_date_exploded[1];

		$days=$start_date_exploded[2];



		$this->common_month=$month;

		$this->common_year=$year;	

		$this->common_date=$start_date;		//t



		$principal=($postdata['purchase_rate']);	//P

		$salvage_value=($postdata['scrap_value']);	//s

		$useful_life=$postdata['recovery_period'];	

		$this->common_principal=$principal;

		

		$rate=(200/$useful_life)/100;

		

		$template=$this->assets_deprecation_mdl->depr_calc_double_decl_partial($principal,$rate,$useful_life,0,0);



		print_r(json_encode(array('status'=>'success','message'=>'Successfully Calculated!!','template'=>$template)));

	}



	public function up_dep_calc()

	{		

		$postdata=($this->input->post());

		$principal=($postdata['dep_purchase_cost']);

		$useful_life=$postdata['dep_life'];



		// $template=$this->assets_mdl->depr_calc_soy_method($useful_life,$principal,$principal,1);

		$template='';

		print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

	}





	public function soy_dep_calc()

	{

		

		$postdata=($this->input->post());



		$start_date=$postdata['purchase_date'];

		//$end_date=$postdata['dep_life_start'];



		$start_date_exploded= explode('/', $start_date);

		$year=$start_date_exploded[0];

		$month=$start_date_exploded[1];

		$days=$start_date_exploded[2];



		$this->common_month=$month;

		$this->common_year=$year;	

		$this->common_date=$start_date;		//t



		

		$principal_amt=($postdata['purchase_rate']);	//P

		$salvage_value=($postdata['scrap_value']);	//s

		$depreciable_principal_amt=($principal_amt - $salvage_value);	//depreciation base principal

		$useful_life=$postdata['recovery_period'];	//t	



		$this->common_principal=$principal_amt;

		

		

		

		$template=$this->assets_deprecation_mdl->depr_calc_soy_method_partial($useful_life,$depreciable_principal_amt,$principal_amt,1);

		print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

		

	}



	public function get_ddm_depr()

	{

		

		$postdata=($this->input->post());



		$start_date=$postdata['purchase_date'];

		//$end_date=$postdata['dep_life_start'];



		$start_date_exploded= explode('/', $start_date);

		$year=$start_date_exploded[0];

		$month=$start_date_exploded[1];

		$days=$start_date_exploded[2];



		$principal=($postdata['purchase_rate']);	//P

		$salvage_value=($postdata['scrap_value']);	//s

		$useful_life=$postdata['recovery_period'];	



		$salvage_value = 100;

		$useful_life = 5;

		

		$this->common_principal=$principal;

		

		$this->common_month=$month;

		$this->common_year=$year;	

		$this->common_date=$start_date;		//t

		

		$template=$this->assets_deprecation_mdl->ddm_depr_calculation($principal,0,$salvage_value,$useful_life);



		print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

	}







	public function list_bio_comments($equid=false)

    {

			$orgid = $this->session->userdata(ORG_ID);



    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   //  		if(MODULES_VIEW=='N')

			// {

			// $this->general->permission_denial_message();

			// exit;

			// }

			$this->data['equip_comment'] = $this->assets_mdl->get_assets_comment(array('ec.eqco_eqid'=>$equid,'ec.eqco_orgid'=>$orgid));

			$template=$this->load->view('assets/v_comment_list',$this->data,true);

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







	public function assets_details()

    {

    	if ($_SERVER['REQUEST_METHOD'] === 'POST') 

    	{

			$equid_key = $this->input->post('id');


			$this->data['assets_detail'] = $this->assets_mdl->get_all_assets(array('ae.asen_asenid'=>$equid_key));
			
			
			
			$template='';



			if($this->data['assets_detail'])

			{

			$this->data['assets_data'] = $this->data['assets_detail'];
			if (ORGANIZATION_NAME == 'KU') {
				$this->data['item_details'][0] = (object) array(
					'recm_school'=>$this->data['assets_detail'][0]->asen_schoolid,
					'recm_departmentid'=>$this->data['assets_detail'][0]->asen_depid,
				);				
			}else{
				$this->data['item_details'][0] = (object) array(
					'recm_school'=>$this->data['assets_detail'][0]->asen_locationid,
					'recm_departmentid'=>$this->data['assets_detail'][0]->asen_depid,
				);	
			}
			

			$equid=$this->data['assets_detail'][0]->asen_asenid;

			$orgid = $this->session->userdata(ORG_ID);

			$template=$this->load->view('assets/v_assets_detail',$this->data,true);

			print_r(json_encode(array('status'=>'success','tempform'=>$template,  'message'=>'Successfully Selected!!')));

		    exit;	

			}

			else

			{

			print_r(json_encode(array('status'=>'error','message'=>'No record Found!!')));

       		exit;	

			}

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}

    }



	public function list_of_item()

	{



			if ($_SERVER['REQUEST_METHOD'] === 'POST') 

			{



				$this->data=array();

				//print_r($this->input->post()); die;

				//echo $this->db->last_query(); die;

				$row=$this->data['rowno']=$this->input->post('id');

				//print_r($this->data['rowno']);die;

				

				$template=$this->load->view('ams/assets/v_assets_item_popup.php',$this->data,true);



				print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template,'tempform'=>$template)));



		   		 exit;	



			}



			else



			{



				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));



		        exit;



			}



	}



	public function get_item_asset($rowno=false,$orgid=false,$result=false)

	{

		if(MODULES_VIEW=='N')

			{

			 $array["equipid"]='';

			 $array["equipkey"] ='';

			 $array["description"]=''; 

			 $array["brand"]=''; 

			 $array["manu_manlst"] ='';

			 $array["distributor"]='';

			 $array["action"]='';

			 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));	

			 exit;

			}



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

				$srchcol=array('asen_orgid'=>$org_id);

			}

			else

			{

				$srchcol='';

			}

			$data = $this->assets_mdl->get_asset_item($srchcol); 

		}else{

			$data = $this->assets_mdl->get_asset_item(array('asen_orgid'=>$org_id));

		}

		if($result == 'asen_asenid'){

			$cond=array('asen_postdatead'=>date("Y/m/d"), 'asen_orgid'=>$org_id);

			$data = $this->assets_mdl->get_asset_item($cond);

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

		    	//$equipmentdesc=$row->eqli_description;

			    // $array[$i]["equipid"] = '<a href="javascript:void(0)" data-id='.$row->bmin_equipid.' data-displaydiv="searchReports" data-viewurl='.base_url('biomedical/reports/report_search').' class="patlist btnEdit" data-patientid='.$row->bmin_equipid.'>'.$row->bmin_equipid.'</a>';

			     $array[$i]["rowno"]=$rowno;

			    $array[$i]["equipid"] = $row->asen_asenid;

			    $array[$i]["equipkey"] = $row->asen_assetcode;

			    $array[$i]["description"] = $row->itli_itemname;

			    $array[$i]["brand"] = $row->asen_brand;

			    $array[$i]["manu_manlst"] = $row->manu_manlst;

			    $array[$i]["distributor"] = $row->dist_distributor;

			    $array[$i]["action"] ='';



			    $i++;

		    }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}





public function call_for_depr_details()

{

	//when asset details is called, that asset's depreciation is shown too.

	//asset id, purchase date, purchase rate,depr type is pre-determined and sent as param.

	$depr_type='';

	$purchase_rate='';

	$purchase_date='';

	$scrap_value='';

	$useful_life='';



	if ($depr_type==1)

	{

		$this->get_st_line_depr();

	}

	else if ($depr_type==2)

	{

		$this->ddb_dep_calc();

	}

	else if ($depr_type==3)

	{

		$this->up_dep_calc();

	}

	else if ($depr_type==4)

	{

		$this->soy_dep_calc();

	}

	else

	{

		print_r(json_encode(array('status'=>'error','message'=>'Depreciation type cannot be determined!')));

	        exit;

	}

}

 public function list_of_description()

	{

	    if ($_SERVER['REQUEST_METHOD'] === 'POST') 

	    {

			try {

				$data['desc_list'] = $this->assets_mdl->get_all_description(false,10,false,'asen_asenid','ASC');

				  // echo "<pre>";

				  // print_r($data);

				  // die();

				$template=$this->load->view('ams/assets/v_list_of_description',$data,true);

		        

		        if($template){

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



    public function get_assets_item_by_assets_type()

    {

    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    		// echo "test";

    		$assets_typeid=$this->input->post('id');

    		if(!empty($assets_typeid)){

    			$srch=array('asen_assettype'=>$assets_typeid);

    		}

    		else{

    			$srch='';

    		}

    		$assets_data=$this->assets_mdl->get_assets_data($srch);

    		// echo $this->db->last_query();

    		// die();

    		$temp='';

    		if(!empty($assets_data)){

    			$temp.='<option value="0">--All--</option>';

    			foreach ($assets_data as $kd => $ass) {

    				$temp .='<option value="'.$ass->asen_asenid.'">'.$ass->asen_assetcode.' | '.$ass->itli_itemname.'</option>';

    			}

    		}

    		print_r(json_encode(array('status'=>'success','message'=>'You Can edit','template'=>$temp)));

		              exit;



	    }

	    else

	    {

	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	            exit;

	    }

    }



    public function list_of_comp_assets($result=false,$org_id=false)

	{

	 $this->data['tab_type']='list1';

	 $this->page_title='Assets List';

	 	 $this->data['network_comp']=$this->general->get_tbl_data('*','coty_componenttype',false,'coty_id','ASC');

	    $this->data['soil_type']=$this->general->get_tbl_data('*','soty_soiltype',false,'soty_id','ASC');

		$this->data['joint_type']=$this->general->get_tbl_data('*','joty_jointype',false,'joty_id','ASC');

		$this->data['pipematerial_type']=$this->general->get_tbl_data('*','pimt_pipematerialtype',false,'pimt_id','ASC');

		$this->data['pipezone_type']=$this->general->get_tbl_data('*','pizo_pipezone',false,'pizo_id','ASC');

		$this->data['pavement_type']=$this->general->get_tbl_data('*','paty_pavementtype',false,'paty_id','ASC');

		$this->data['valve_type']=$this->general->get_tbl_data('*','vaty_valvetype',false,'vaty_id','ASC');

		$this->data['hydrants_type']=$this->general->get_tbl_data('*','hyty_hydrantstype',false,'hyty_id','ASC');

		$this->data['flowmeter_type']=$this->general->get_tbl_data('*','flty_flowmeterstype',false,'flty_id','ASC');







		// echo '<pre>';print_r($this->data['description']);



		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('component_assets/v_comp_assets_list', $this->data);

	}



	public function get_comp_assets_list()

	{

		// if(MODULES_VIEW=='N')

		// 	{

		// 	  	$array["asen_assetcode"] ='';

		// 	    $array["asen_assettype"] = '';

		// 	    $array["asen_modelno"] =''; '';

		// 	    $array["asen_serialno"] = '';

		// 	    $array["asen_status"] = '';

		// 	    $array["asen_condition"] = '';

  		//      $array["action"]='';

  		//         echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));

  		//          exit;

		// 	}

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);

		$orgid = $this->session->userdata(ORG_ID);

	



		$data = $this->assets_mdl->get_all_comp_assets_list(array('asen_iscomponent'=>'Y'));

		// echo "<pre>"; print_r($data); die();

 

	  	$i = 0;

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);

		$totalrecs = $data["totalrecs"];



	    unset($data["totalfilteredrecs"]);

	  	unset($data["totalrecs"]);

	  

		  	foreach($data as $row)

		    {

			    $array[$i]["coty_name"] = $row->coty_name;

			    $array[$i]["asen_assetcode"] = $row->asen_assetcode;

			    $array[$i]["asen_ncomponentid"] = $row->asen_ncomponentid;



			    // $array[$i]["description"] = $row->itli_itemname;

			    $array[$i]["joty_name"] = $row->joty_name;

			    $array[$i]["paty_name"] = $row->paty_name;

			    $array[$i]["asen_manufacture_datead"] = $row->asen_manufacture_datead;



			    // $array[$i]["condition"] = $row->asco_conditionname;

			    //  if(DEFAULT_DATEPICKER=='NP')

			    // {

			    // 	 $array[$i]["purchase_date"] = $row->asen_purchasedatebs;

			    // }

			    // else

			    // {

			    // 	  $array[$i]["purchase_date"] = $row->asen_purchasedatead;	

			    // }



			    //  if(DEFAULT_DATEPICKER=='NP')

			    // {

			    // 	 $array[$i]["warrenty_date"] = $row->asen_warrentydatebs;

			    // }

			    // else

			    // {

			    // 	  $array[$i]["warrenty_date"] = $row->asen_warrentydatead;	

			    // }

			    //  $array[$i]["location"] = !empty($row->asen_location)?$row->asen_location:'';





			  

			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->asen_asenid.' data-displaydiv="assets" data-viewurl='.base_url('ams/assets/component_assets_entry').' class="btnredirect"><i class="fa fa-edit" aria-hidden="true" ></i></a> | 

			    	<a href="javascript:void(0)" data-id='.$row->asen_asenid.' data-tableid='.$row->asen_asenid.' data-deleteurl='.base_url('ams/assets/assets_delete') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a> | 

			    	<a href="javascript:void(0)" data-id='.$row->asen_asenid.' data-displaydiv="assets" data-viewurl='.base_url('/ams/assets/comp_assets_details').' class="view" data-heading="Asset Details"><i class="fa fa-eye" aria-hidden="true" ></i></a>';

			     

			    $i++;

		        //(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');

		    }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}





	public function get_comp_assets_list_summary()

	{

		

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);

		$orgid = $this->session->userdata(ORG_ID);

	



		$data = $this->assets_mdl->get_all_comp_assets_list_summary();

		// echo "<pre>"; print_r($data); die();

 

	  	$i = 0;

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);

		$totalrecs = $data["totalrecs"];



	    unset($data["totalfilteredrecs"]);

	  	unset($data["totalrecs"]);

	  

		  	foreach($data as $row)

		    {

			    $array[$i]["asen_assetcode"] = $row->asen_assetcode;

			    $array[$i]["asen_faccode"] = $row->asen_faccode;

			    $array[$i]["asen_ncomponentid"] = $row->asen_ncomponentid;

			    $array[$i]["loca_name"]=$row->loca_name;

			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->asen_asenid.' data-displaydiv="assets" data-viewurl='.base_url('ams/assets/assets_entry').' class="btnredirect"><i class="fa fa-edit" aria-hidden="true" ></i></a> | 

			    	<a href="javascript:void(0)" data-id='.$row->asen_asenid.' data-displaydiv="assets" data-viewurl='.base_url('/ams/assets/comp_assets_details').' class="view" data-heading="Asset Details"><i class="fa fa-eye" aria-hidden="true" ></i></a>';

			    $i++;

		    }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}



	public function comp_assets_details()

    {

    	if ($_SERVER['REQUEST_METHOD'] === 'POST') 

    	{

			// $equid_key = $this->input->post('id');

			$network_key = $this->input->post('id');

			// echo "hi";

			// echo $network_key;

			// die();



			// $this->data['eqli_data'] = $this->assets_mdl->get_all_assets(array('ae.asen_asenid'=>$equid_key));

			$this->data['assets_data'] = $this->assets_mdl->get_all_comp_assets(array('ae.asen_asenid'=>$network_key));

			

			$ctype = $this->data['assets_data'][0]->asen_component_typeid;

			// echo "hi";

			// echo $ctype;

			// die();



			// $this->data['depreciation']=$this->assets_mdl->get_depreciation();

			 $template='';



			if(!empty($this->data['assets_data']))

			{

		$this->data['manufacturers']=$this->manufacturers_mdl->get_all_manufacturers();

		$this->data['soil_type_list']=$this->general->get_tbl_data('*','soty_soiltype',array('soty_isactive'=>'Y'));

		$this->data['joint_type_list']=$this->general->get_tbl_data('*','joty_jointype',array('joty_isactive'=>'Y'));

		$this->data['material_type_list']=$this->general->get_tbl_data('*','pimt_pipematerialtype',array('pimt_isactive'=>'Y'));

		$this->data['pipe_zone_type_list']=$this->general->get_tbl_data('*','pizo_pipezone',array('pizo_isactive'=>'Y'));

		$this->data['pavement_type_list']=$this->general->get_tbl_data('*','paty_pavementtype',array('paty_isactive'=>'Y'));

		$this->data['valve_type_list']=$this->general->get_tbl_data('*','vaty_valvetype',array('vaty_isactive'=>'Y'));

		$this->data['hydrant_type_list']=$this->general->get_tbl_data('*','hyty_hydrantstype',array('hyty_isactive'=>'Y'));

		$this->data['flowmeter_type_list']=$this->general->get_tbl_data('*','flty_flowmeterstype',array('flty_isactive'=>'Y'));

		$this->data['project_list']=$this->general->get_tbl_data('*','prin_projectinfo',false,'prin_prinid','ASC');

		$this->data['frequency']=$this->general->get_tbl_data('*','frty_frequencytype',array('frty_isactive'=>'Y'));

		$this->data['treatmentcomponent_list']=$this->general->get_tbl_data('*','teco_treatmentcomponent',array('teco_isactive'=>'Y'));

		$this->data['asset_status_list']=$this->general->get_tbl_data('*','asst_assetstatus',array('asst_isactive'=>'Y'));

		$this->data['treatmentplan_type_list']=$this->general->get_tbl_data('*','tept_treatmentplantype',array('tept_isactive'=>'Y'));

		$this->data['treatmentcomponent_list']=$this->general->get_tbl_data('*','teco_treatmentcomponent',array('teco_isactive'=>'Y'));

		$this->data['buildingtype_list']=$this->general->get_tbl_data('*','buty_buildingtype',array('buty_isactive'=>'Y'));

		$this->data['asset_code'] ='';

		$this->data['faccode']	='';

		$this->data['ncomponent_code'] ='';



				if($ctype =='1'){



			 		$template=$this->load->view('component_assets/v_comp_assets_pipe_form',$this->data,true);

			 	}

			 	elseif($ctype =='2'){

			 		$this->data['chambertype_list']=$this->general->get_tbl_data('*','chty_chambertype',array('chty_isactive'=>'Y'));

		  	$this->data['valvesetting_list']=$this->general->get_tbl_data('*','vase_valvesetting',array('vase_isactive'=>'Y'));

		  	

			 		$template=$this->load->view('component_assets/v_comp_assets_valve_form',$this->data,true);

			 	}

			 	elseif($ctype =='3'){

			 		$template=$this->load->view('component_assets/v_comp_assets_hydrants_form',$this->data,true);

			 	}

			 	elseif($ctype =='4'){

			 		$template=$this->load->view('component_assets/v_comp_assets_flowmeters_form',$this->data,true);

			 	}

			 	elseif($ctype =='5'){

			 		$this->data['pump_capacity_list']=$this->general->get_tbl_data('*','puca_pumpcapacity',array('puca_isactive'=>'Y'));

			 		$template=$this->load->view('component_assets/v_comp_assets_treatmentplan_form',$this->data,true);

			 	}

			 	elseif($ctype =='6'){

			 		$this->data['pump_type_list']=$this->general->get_tbl_data('*','pmty_pumptype',array('pmty_isactive'=>'Y'));

			 		$template=$this->load->view('component_assets/v_comp_assets_tubewell_form',$this->data,true);

			 	}

			 	elseif($ctype =='7'){

			 		$this->data['reserviourtype_list']=$this->general->get_tbl_data('*','rety_reserviourtype',array('rety_isactive'=>'Y'));

   					$this->data['reserviourshape_list']=$this->general->get_tbl_data('*','resh_reserviourshape',array('resh_isactive'=>'Y'));

			 		$template=$this->load->view('component_assets/v_comp_assets_reserviour_form',$this->data,true);

			 	}

			 	elseif($ctype =='8'){

			 		$template=$this->load->view('component_assets/v_comp_assets_building_form',$this->data,true);

			 	}

			 	

			print_r(json_encode(array('status'=>'success','tempform'=>$template,  'message'=>'Successfully Selected!!')));

		       		exit;	

				}

				else

				{

					print_r(json_encode(array('status'=>'error','message'=>'No record Found!!')));

		       		exit;	

				}

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}

    }





    public function save_lease_assets()

    {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$this->form_validation->set_rules($this->assets_mdl->validate_settings_lease_assets_record);

		  	if($this->form_validation->run()==TRUE)

		 	{

		 		$trans = $this->assets_mdl->save_assets_lease_assets_record();

        		if($trans)

        		{

        	 	 	print_r(json_encode(array('status'=>'success','message'=>'Record Saved Successfully','param'=>$trans)));

            			exit;

        			

        		}else{

        			print_r(json_encode(array('status'=>'error','message'=>'Error While saving Data','param'=>$trans)));

            			exit;

        		}

		 	}

    		else

			{

				print_r(json_encode(array('status'=>'error','message'=>validation_errors())));

				exit;

			}	

	 }

	else{

    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

            exit;

    }

 }



 public function save_assets_insurance()

    {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$this->form_validation->set_rules($this->assets_mdl->validate_settings_insurance_assets_record);

		  	if($this->form_validation->run()==TRUE)

		 	{

		 		$trans = $this->assets_mdl->save_assets_insurance_record();

        		if($trans)

        		{

        	 	 	print_r(json_encode(array('status'=>'success','message'=>'Record Saved Successfully','param'=>$trans)));

            			exit;

        			

        		}else{

        			print_r(json_encode(array('status'=>'error','message'=>'Error While saving Data','param'=>$trans)));

            			exit;

        		}

		 	}

    		else

			{

				print_r(json_encode(array('status'=>'error','message'=>validation_errors())));

				exit;

			}	

	 }

	else{

    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

            exit;

    }

 }

    public function generate_pmtable()

    {

    	$startdate=$this->input->post('startdate');

		$pmfrequency=$this->input->post('pmfrequency');

		$no_of_year=$this->input->post('no_of_year');



		



		if($pmfrequency==1){

			$yearcnt=$no_of_year;

			$type="year";

		}else if($pmfrequency==2){

			$yearcnt=2*$no_of_year;

			$type="month";	

		}else if($pmfrequency==3){

			$yearcnt=4*$no_of_year;

			$type="month";

		}else if($pmfrequency==4){

			$yearcnt=12*$no_of_year;

			$type="month";



		}else if($pmfrequency==5){

			$yearcnt=52*$no_of_year;

			$type="Week";

		}

		else if($pmfrequency==6){

			$yearcnt=365*$no_of_year;

			$type="day";

		}



		$this->db->query("TRUNCATE TABLE xw_temp_pmcycle_generator");

		$this->generate_pm_cycle(1,$yearcnt,$startdate,$type);

		$tmcycle_data=$this->general->get_tbl_data('*','temp_pmcycle_generator',false,'cycle',$order_by='ASC',false,false);

		$template ='<table class="table table-border table-striped table-site-detail dataTable"><thead><tr><th width="5%">S.n</th><th width="15%">Start Date</th><th width="20%">Remarks</th><th width="15%">Next Date</th></tr></thead>';

		if(!empty($tmcycle_data)){

		

			foreach ($tmcycle_data as $ktd => $cydata) {

				$pm_number=$cydata->cycle;

					if($pm_number==1){

						$supsc='<sup>st</sup>';

					}

					else if($pm_number==2){

						$supsc='<sup>nd</sup>';

						

					}else if($pm_number==3){

						$supsc='<sup>rd</sup>';

					}else{

						$supsc='<sup>th</sup>';

					}



				 $template .='<tr><td>'.$pm_number.'</td><td><input type="text" name="pmstartdate[]" class="form-control required_field  '.DATEPICKER_CLASS.'" id="pmstartdate_'.$pm_number.'" value="'.$cydata->start_datebs.'"></td><td>'.$pm_number.$supsc.' PM</td><td><input type="text" name="pmenddate[]" class="form-control required_field  '.DATEPICKER_CLASS.'" id="pmstartdate_'.$pm_number.'" value="'.$cydata->end_datebs.'"></td></tr>';	





			}

		}

		$this->db->query("TRUNCATE TABLE xw_temp_pmcycle_generator");

		



			



			$template .='';

			

	



		print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

	   		 exit;	



    }



    public function generate_pm_cycle($startval,$no_of_cycle,$startdate,$type='year'){

    	$pmfrequency=$this->input->post('pmfrequency');

    	if($type=='year'){

    		$plusnumber=1;

    		$plusnumberOne=2;

    			

    	}

    	if($type=='month'){

    		$plusnumber=6;

    		$plusnumberOne=12;		

    	}

    	if($pmfrequency==3 && $type=='month'){

    		$plusnumber=3;

    		$plusnumberOne=6;		

    	}

    	if($pmfrequency==4 && $type=='month'){

    		$plusnumber=1;

    		$plusnumberOne=2;		

    	}



    	if($pmfrequency==5 && $type=='Week'){

    		$plusnumber=1;

    		$plusnumberOne=2;		

    	}



    	if($pmfrequency==6 && $type=='day'){

    		$plusnumber=1;

    		$plusnumberOne=2;		

    	}



   		$start_no=$startval;

   		$start_noplusone=$start_no+1;

   		$ncycle=$no_of_cycle;

   		$ncycle_minusone=$no_of_cycle-1;



   		if($start_no<=$no_of_cycle ){

   			if(DEFAULT_DATEPICKER=='NP'){

			 	$start_date=$this->general->NepToEngDateConv($startdate);

			 }else{

			 	$start_date=$startdate;

			 }



			 $nextyearen1 = date('Y/m/d', strtotime("+".$plusnumber." $type", strtotime($start_date)));

 			 $nextyearen2 = date('Y/m/d', strtotime("+".$plusnumberOne." $type", strtotime($start_date)));

   		

    	

 

		if(DEFAULT_DATEPICKER=='NP'){

		 	$nextyear1=$this->general->EngToNepDateConv($nextyearen1);

		 	$nextyear2=$this->general->EngToNepDateConv($nextyearen2);

		 }else{

		 	$nextyear1=$nextyearen1;

		 	$nextyear2=$nextyearen2;

		 }



		 if($start_no==1){

		 	$startval=$startdate;

		 	if($no_of_cycle==1){

			$endval='No Next';

		 	}else{

		 			$endval=$nextyear1;

		 	}

		 



		 }

		 else if($start_no<$no_of_cycle){

		 	$startval=$nextyear1;

		 	$endval=$nextyear2;

		 }

		 else{

		 	$startval=$nextyear1;

		 	$endval='No Next';

		 }



 		$cycle_array=array(

 			'start_datebs'=>$startval,

 			'end_datebs'=>$endval,

			'remark'=>'',

			'type'=>$type,

			'cycle'=>$start_no,

 		);

 		if(!empty($cycle_array)){

 			$this->db->insert('temp_pmcycle_generator',$cycle_array);

 		}

 		if($ncycle_minusone>0){

 		$this->generate_pm_cycle($start_noplusone,$no_of_cycle,$startval,$type);	

 		}

    	

 		 }

    }





    public function save_pmrecord_assets(){

    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {



    		$this->form_validation->set_rules($this->assets_mdl->validate_settings_pm_assets_record);

			  	if($this->form_validation->run()==TRUE)

			 	{

			 		$trans = $this->assets_mdl->save_assets_pm_amc_record();

	        		if($trans)

	        		{

	        	 	 	print_r(json_encode(array('status'=>'success','message'=>'Record Saved Successfully')));

	        			exit;

	        		}else{



	        		}

			 	}

        		else

				{

					print_r(json_encode(array('status'=>'error','message'=>validation_errors())));

					exit;

				}





			

    	}

		else

	    {

	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	            exit;

	    }

    }





    public function list_of_assets_popup(){

    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			// echo $storeid;

			// die();

			$this->unknown = 'N';



			$this->data=array();

			$this->data['rowno']=$this->input->post('id');

			$this->data['storeid']=$this->input->post('storeid');

			// if(MODULES_VIEW=='N')

			// 	{

			// 	$this->general->permission_denial_message();

			// 	exit;

			// 	}

			$template='';
			if(ORGANIZATION_NAME=='KU'){
				$template=$this->load->view('assets/ku/v_assets_list_popup_modal',$this->data,true);

			}else{
			$template=$this->load->view('assets/v_assets_list_popup_modal',$this->data,true);
	
			}
			
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template,'tempform'=>$template)));

	   		 exit;	

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}

    }





    public function get_list_of_assets_bypopup($rowno=false)
    {

    	if(ORGANIZATION_NAME=='KU'){

  		   $data = $this->assets_mdl->get_assets_list_popup_ku();

    	}else{
    	$data = $this->assets_mdl->get_assets_list_popup();

    	}

		// echo "<pre>";  print_r($data); die();

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

		    	$asen_last_deprecid='';

		    	$last_dep_date='';

		    	$last_depnetval='';

		    	

		    	$last_dep=$row->last_deprec;

		    	if(!empty($last_dep)){

		    		$last_rec_arr=explode(',', $last_dep);

		    		if(!empty($last_rec_arr)){

		    			$asen_last_deprecid=$last_rec_arr[0];

		    			$last_dep_date=$last_rec_arr[1];

		    			$last_depnetval=$last_rec_arr[2];

		    		}

		    	}



		    	$array[$i]["rowno"]=$rowno;

		    	$array[$i]["asen_asenid"] = $row->asen_asenid;

			  	$array[$i]["asen_assetcode"] = $row->asen_assetcode;
			  	$array[$i]["asen_item"] = $row->itli_itemname;

			  	if(ORGANIZATION_NAME=='KU'){
			  		$array[$i]['receiver_staffid']=$row->asen_staffid;
			  		$array[$i]['receiver_name']='';
			    	if(empty($row->asen_staffid)){
			    		$str = strtoupper($row->asen_desc);
			    		if(strpos($str, "RECEVIED BY") || strpos($str, "RECEVIED BY"))
			    		{
			    		$replace_rec_var = substr($str,strpos($str, "RECEVIED BY"), -1);
			    		$replace_rec=str_replace('RECEVIED BY', '', $replace_rec_var);
			    		$array[$i]['receiver_name']=$replace_rec;

			    		}

			    	}
			    }
			  	$array[$i]["asen_desc"] = $row->asen_desc;

			    $array[$i]["asen_assestmanualcode"] = $row->asen_manualcode;

			    $array[$i]["eqca_category"] = $row->eqca_category;

			    $array[$i]["dept_depname"] = $row->dept_depname;

			   

			    $array[$i]["asen_purchaserate"] = $row->asen_purchaserate;

			   if(DEFAULT_DATEPICKER=='NP'){

			   	$array[$i]["asen_purchasedate"] = $row->asen_purchasedatebs;

			   }else{

			   	$array[$i]["asen_purchasedate"] = $row->asen_purchasedatead;

			   }

			   $array[$i]["asen_last_depdate"]= $last_dep_date;

			   $array[$i]["asen_last_depnetval"]= $last_depnetval;

			   $array[$i]["asen_last_deprecid"]= $asen_last_deprecid;
			    $array[$i]["asen_remarks"]= $row->asen_remarks;

			    

			    $i++; 

				// endif;

		    }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

    }







}

/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */