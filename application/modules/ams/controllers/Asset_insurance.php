<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Asset_insurance extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('asset_insurance_mdl');
		$this->load->Model('assets_mdl');
		$this->load->Model('biomedical/bio_medical_mdl');
		$this->load->helper('file');
		$this->load->helper('form');
		// $this->load->Model('biomedical/equipment_mdl');
		
		
	}

	public function index()
	{
		

		$this->data['asset_insurance_all']=$this->asset_insurance_mdl->get_all_asset_insurance();
		// echo "<pre>";
		// print_r($this->data['orga_setup_all']);
		// die();
		$this->data['insurance_type_all'] =$this->general->get_tbl_data('*','inty_insurancetype',false,'inty_intyid','ASC');
		$this->data['renewalperiod_all'] =$this->general->get_tbl_data('*','peri_period',false,'peri_periid','ASC');
		$this->data['insurance_company_all'] =$this->general->get_tbl_data('*','inco_insurancecompany',false,'inco_id','ASC');
		$this->data['asset_all'] =$this->general->get_tbl_data('*','asen_assetentry',false,'asen_asenid','ASC');
		$this->data['org_id']=$this->session->userdata(ORG_ID);
		$this->data['editurl']=base_url().'ams/asset_insurance/edit_asset_insurance';
		$this->data['deleteurl']=base_url().'ams/asset_insurance/delete_asset_insurance';
		$this->data['listurl']=base_url().'ams/asset_insurance/list_asset_insurance';
		$this->data['insurance']='add_insurance';

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
			->build('asset_insurance/v_asset_insurance', $this->data);
	}



			public function insurance_summary()
    {

		// $this->data['amc_data_all'] = $this->amc_data_mdl->get_all_amc_data();
		// $this->data['risk_value_all'] = $this->risk_value_mdl->get_all_risk_value();
		// $this->data['equipment_all'] = $this->equipment_mdl->get_all_equipment();
		// $this->data['distributor_list']=$this->bio_medical_mdl->get_distributor_list();

		$this->data['insurance']='summary';
		$this->data['editurl']=base_url().'ams/asset_insurance/edit_asset_insurance';
		$this->data['deleteurl']=base_url().'ams/asset_insurance/delete_asset_insurance';
		$this->data['listurl']=base_url().'ams/asset_insurance/list_asset_insurance';
		// $this->data['insurance']='summary';
		$this->data['asset_insurance_all']=$this->asset_insurance_mdl->get_all_asset_insurance();
		// echo "<pre>"; print_r($this->data['equipment_all']); die();
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
			->build('asset_insurance/v_asset_insurance', $this->data);

}



	public function form_asset_insurance()
	{
	    
		$this->load->view('asset_insurance/v_asset_insurance_form');
	}

	public function save_asset_insurance()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$id=$this->input->post('id');
			if($id)
			{
					 $this->data['asset_insurance_data']=$this->asset_insurance_mdl->get_all_asset_insurance(array('asin_asinid'=>$id));
				// echo "<pre>";
				// print_r($data['dept_data']);
				// die();
				if($this->data['asset_insurance_data'])
				{
				$dep_date=$this->data['asset_insurance_data'][0]->asin_postdatead;
				$dep_time=$this->data['asset_insurance_data'][0]->asin_posttime;
				$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
				$usergroup=$this->session->userdata(USER_GROUPCODE);
				
				if($editstatus==0 && $usergroup!='SA' )
				{
					   $this->general->disabled_edit_message();

				}
				}
			}



			 $this->form_validation->set_rules($this->asset_insurance_mdl->validate_settings_asset_insurance);
			// $this->room_mdl->validate_ams_room();
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->asset_insurance_mdl->asset_insurance_save();
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

public function edit_asset_insurance()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$id=$this->input->post('id');
		$this->data['org_id']=$this->session->userdata(ORG_ID);
		$this->data['asset_insurance_all']=$this->asset_insurance_mdl->get_all_asset_insurance();
	
		$this->data['asset_insurance_data']=$this->asset_insurance_mdl->get_all_asset_insurance(array('asin_asinid'=>$id));
			$this->data['insurance_type_all'] =$this->general->get_tbl_data('*','inty_insurancetype',false,'inty_intyid','ASC');
		$this->data['renewalperiod_all'] =$this->general->get_tbl_data('*','peri_period',false,'peri_periid','ASC');
		$this->data['insurance_company_all'] =$this->general->get_tbl_data('*','inco_insurancecompany',false,'inco_id','ASC');
		$this->data['asset_all'] =$this->general->get_tbl_data('*','asen_assetentry',false,'asen_asenid','ASC');
		// echo "<pre>";
		// print_r($this->data['orga_setup_all']);
		// die();

		if($this->data['asset_insurance_data'])
		{
			$dep_date=$this->data['asset_insurance_data'][0]->asin_postdatead;
			$dep_time=$this->data['asset_insurance_data'][0]->asin_posttime;
			$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
			// echo $editstatus;
			// die();
			$this->data['edit_status']=$editstatus;

		}
		$tempform=$this->load->view('asset_insurance/v_form_asset_insurance',$this->data,true);
		// echo $tempform;
		// die();
		if(!empty($this->data['asset_insurance_data']))
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


public function delete_asset_insurance()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$id=$this->input->post('id');
		
		$trans=$this->asset_insurance_mdl->remove_asset_insurance();
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

public function list_asset_insurance(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$this->data['asset_insurance_all']=$this->asset_insurance_mdl->get_all_asset_insurance();
		$template=$this->load->view('asset_insurance/v_asset_insurance_list',$this->data,true);
		print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
			exit;	
	   }
	else
	{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}
}

public function generate_pdfDirect()
    {
        $this->data['searchResult'] = $this->asset_insurance_mdl->get_itemslist_from_inventory();

        // echo "<pre>";
        // print_r( $this->data['searchResult']);
        // die();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $html = $this->load->view('asset_insurance/v_asset_insurance_list_download', $this->data, true);
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

        $data = $this->asset_insurance_mdl->get_itemslist_from_inventory();

        $this->data['searchResult'] = $this->asset_insurance_mdl->get_itemslist_from_inventory();
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('asset_insurance/v_asset_insurance_list_download', $this->data, true);

        echo $response;
    }

public function exists_asin_companyid()
	{
		$asin_companyid=$this->input->post('asin_companyid');
		$id=$this->input->post('id');
		$asin_companyidchk=$this->asset_insurance_mdl->check_exist_orga_orgacompanyid_for_other($asin_companyid,$id);
		if($orga_orgacompanyidchk)
		{
			$this->form_validation->set_message('exists_asin_companyid', 'Already Exist modulekey!');
			return false;

		}
		else
		{
			return true;
		}
	}


	public function get_equdata()
	{   
		$this->data['asset_insurance_all']=$this->asset_insurance_mdl->get_all_asset_insurance();
		// echo "<pre>";
		// print_r($this->data['asset_insurance_all']);
		// die();
		$this->data['insurance_type_all'] =$this->general->get_tbl_data('*','inty_insurancetype',false,'inty_intyid','ASC');
		$this->data['renewalperiod_all'] =$this->general->get_tbl_data('*','peri_period',false,'peri_periid','ASC');
		$this->data['insurance_company_all'] =$this->general->get_tbl_data('*','inco_insurancecompany',false,'inco_id','ASC');
		$this->data['asset_all'] =$this->general->get_tbl_data('*','asen_assetentry',false,'asen_asenid','ASC');

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$equid_key=$this->input->post('id');
			//echo $equid_key; die;
			$this->data['org_id']=$org_id=$this->session->userdata(ORG_ID);
		// 	echo "<pre>";
		// print_r($org_id);
		// die();
			if($org_id=='2'){
				// echo "test";
				// die();
				$this->data['eqli_data'] = $this->assets_mdl->get_assets_detail(array('asen_assetcode'=>$equid_key));
		// 			echo "<pre>";
		// print_r($this->data['org_id']);
		// die();
			}else{
				$this->data['eqli_data'] = $this->bio_medical_mdl->get_biomedical_inventory(array('bm.bmin_equipmentkey'=>$equid_key));
			}
			
			$this->data['distributor_list']=$this->bio_medical_mdl->get_distributor_list();


			if($this->data['eqli_data'])
			{
				if($org_id=='2'){
				$equid=$this->data['eqli_data'][0]->asen_asenid;

				}else{
				$equid=$this->data['eqli_data'][0]->bmin_equipid;
				}
			$this->data['pmdata'] = $this->bio_medical_mdl->get_selected_amcdata(array('amta_equipid'=>$equid,'amta_orgid'=>$org_id));
			
			// $tempform .='';
			// $this->data['equip_comment'] = $this->bio_medical_mdl->get_equip_comment(array('ec.eqco_eqid'=>$equid,'eqco_orgid'=>$org_id));
			// $this->data['repair_comment'] = $this->repair_request_info_mdl->repair_request_info(array('r.rere_equid'=>$equid,'eqco_orgid'=>$org_id));
			}

		
			//$this->data['history'] = $this->amc_data_mdl->get_pm_report_by_department(array('amta_equipid'=>$equid));
			//echo "<pre>";print_r($this->data['pmdata']);die();
			$tempform= $this->load->view('asset_insurance/v_insurance_detail',$this->data,true);
			//$tempform= $this->load->view('amc_data/v_amc_dataform', $data, true);
			//$this->load->view('amc_data/v_amc_dataform');
			// echo $tempform;
			// die();
			if($this->data['eqli_data'])
			{
				print_r(json_encode(array('status'=>'success','tempform'=>$tempform,'message'=>'Successfully Selected!!')));
	       		exit;	
			}
			else
			{
				$tempform='<span class="col-sm-12 alert  alert-danger text-center">Record Not Found!!</span>';
				print_r(json_encode(array('status'=>'success','tempform'=>$tempform,'message'=>'Unsuccessfully Selected')));
	       		exit;	
			}
		

		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function form_insurance_data()
		{
			$this->data['org_id']=$this->session->userdata(ORG_ID);
			$this->load->view('asset_insurance/v_form_asset_insurance',$this->data);
		}

//for server
public function itemslist_from_inventory(){	
		if(MODULES_VIEW=='N')
		{
			$array=array();

			// $this->general->permission_denial_message();
			 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
		}
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	  	$i = 0;
	  	$data = $this->asset_insurance_mdl->get_itemslist_from_inventory();
	  	// echo $this->db->last_query();die();
	 	//echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {
		    	$array[$i]["asen_assetcode"] = $row->asen_assetcode;
		    	$array[$i]["inco_name"] = $row->inco_name;
		    	$array[$i]["inty_name"] = $row->inty_name;
			   	$array[$i]["peri_name"] = $row->peri_name;
			   	$array[$i]["asin_insuranceamount"]=$row->asin_insuranceamount;
			    $array[$i]["asin_startdatead"] = $row->asin_startdatead;
			    $array[$i]["asin_enddatead"] = $row->asin_enddatead;
			    $array[$i]["asin_insurancerate"] = $row->asin_insurancerate;
			   //  $array[$i]["asset_insurance_policy_no"] = $row->asset_insurance_policy_no;
			    // $array[$i]["qty"] = $row->trde_requiredqty;
			    // $array[$i]["rate"] = $row->trde_selprice;
			    // $array[$i]["amount"] = $row->recm_amount;
			    $array[$i]["action"] = '<a href="javascript:void(0)" data-id='.$row->asin_asinid.' data-displaydiv="" data-viewurl='.base_url('ams/asset_insurance/delete_asset_insurance').' class="btnDelete btn-delete btn-xxs sm-pd" data-heading="'.$row->inco_name.'" data-id="'.$row->asin_asinid.'"><i class="fa fa-trash-o" title="Delete" aria-hidden="true" ></i></a>';
			  
			    $i++;
		    }
		    //echo"<pre>";print_r($data);die;
		    $get = $_GET;
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
}

