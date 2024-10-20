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
      	$this->data['eqca_category']=$this->general->get_tbl_data('*','eqca_equipmentcategory',array('eqca_equiptypeid'=>'2'));
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
				$response .= "<tr><td><input type='checkbox' id='equipid_$eq->asen_assetcode' data-key=".$eq->asen_assetcode." /></td><td>".$eq->asen_assetcode."</td><td>".$eq->eqli_description."</td><td>".$eq->asen_supplier."</td><td>".$eq->bmin_modelno."</td><td>".$eq->bmin_serialno."</td></tr>";
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


	// public function assets_entry()
	// {	
	// 	$id=$this->input->post('id');
		
	// 	$this->data['status']=$this->assets_mdl->get_status();
	// 	$this->data['condition']=$this->assets_mdl->get_condition();
	// 	$this->data['material']=$this->assets_mdl->get_assets_category();
	// 	$this->data['depreciation']=$this->assets_mdl->get_depreciation();
	// 	$this->data['manufacturers']=$this->manufacturers_mdl->get_all_manufacturers();
	// 	$this->data['distributors']=$this->distributors_mdl->get_distributor_list();
	// 	$this->data['assets_data']=$this->assets_mdl->get_all_assets(array('asen_asenid'=>$id));

	// 	$this->data['tab_type']="entry1";

	// 	$this->session->unset_userdata('id');
	// 	$this->page_title='Assets Assets';
	// 	$this->template
	// 		->set_layout('general')
	// 		->enable_parser(FALSE)
	// 		->title($this->page_title)
	// 		->build('assets/v_assets_main', $this->data);
	// }

		public function assets_entry()
	{	
		$id=$this->input->post('id');
		
		$this->data['status']=$this->assets_mdl->get_status();
		$this->data['condition']=$this->assets_mdl->get_condition();
		$this->data['material']=$this->assets_mdl->get_assets_category();
		$this->data['depreciation']=$this->assets_mdl->get_depreciation();
		$this->data['manufacturers']=$this->manufacturers_mdl->get_all_manufacturers();
		$this->data['distributors']=$this->distributors_mdl->get_distributor_list();
		$this->data['assets_data']=$this->assets_mdl->get_all_assets(array('asen_asenid'=>$id));

		$this->data['tab_type']="entry1";

		$this->session->unset_userdata('id');
		$this->page_title='Assets Assets';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('assets/v_assets_main', $this->data);
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

				$id=$this->input->post('id');
			
				if($id){
					$this->data['assets_data']=$this->assets_mdl->get_all_assets(array('asen_asenid'=>$id));
				}
		
			
				$this->form_validation->set_rules($this->assets_mdl->validate_settings_assets);
			
			
			  	if($this->form_validation->run()==TRUE)
			 	{
			 		$trans = $this->assets_mdl->save_assets();
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

	public function list_of_assets($result=false,$org_id=false)
	{
		$this->data['tab_type']='list1';
		$this->page_title='Assets List';

		$this->data['material']=$this->assets_mdl->get_assets_category();
		//echo '<pre>';print_r($this->data['material']);

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('assets/v_assets_list', $this->data);
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
	

		$data = $this->assets_mdl->get_all_assets_list();
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
			    $array[$i]["description"] = $row->itli_itemname;
			    $array[$i]["model_no"] = $row->asen_modelno;
			    $array[$i]["serial_no"] = $row->asen_serialno;
			    $array[$i]["status"] = $row->asst_statusname;
			    $array[$i]["condition"] = $row->asco_conditionname;
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


			  
			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->asen_asenid.' data-displaydiv="equipments" data-viewurl='.base_url('ams/assets/assets_entry').' class="btnredirect"><i class="fa fa-edit" aria-hidden="true" ></i></a> | 
			    	<a href="javascript:void(0)" data-id='.$row->asen_asenid.' data-tableid='.($i+1).' data-deleteurl='.base_url('ams/assets/assets_delete') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a> | 
			    	<a href="javascript:void(0)" data-id='.$row->asen_asenid.' data-displaydiv="equipments" data-viewurl='.base_url('/ams/assets/assets_details').' class="view" data-heading="Asset Details"><i class="fa fa-eye" aria-hidden="true" ></i></a>';
			     
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
        $this->data['searchResult'] = $this->assets_mdl->get_all_assets_list();

        // echo "<pre>";
        // print_r( $this->data['searchResult']);
        // die();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $html = $this->load->view('assets/v_assets_list_download', $this->data, true);
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

        $this->data['searchResult'] = $this->assets_mdl->get_all_assets_list();
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('assets/v_assets_list_download', $this->data, true);

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

		$this->data['depreciation']=$this->assets_mdl->get_depreciation();
		$this->data['manufacturers']=$this->manufacturers_mdl->get_all_manufacturers();
		$this->data['distributors']=$this->distributors_mdl->get_distributor_list();

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
			$this->data['report_title'] = "Assets List";

    		$assettype = $this->input->post('asen_assettype');
	      	$manufacture = $this->input->post('asen_manufacture');
	      	$status = $this->input->post('asen_status');
	      	$condition = $this->input->post('asen_condition');
	      	$depreciation = $this->input->post('asen_depreciation');

	      	$srchcol = "";
   
	  		$this->data['assets_report']=$this->assets_mdl->get_assets_list_data();

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
			// die();

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
    			
    			$break_asset_desc = explode('|',$asset_desc_name);

    			$get_asset_name = trim($break_asset_desc[1]);

    			$asset_name = preg_replace("/[^a-z\s]/i", "", $get_asset_name);
    			$asset_name = preg_replace("/\s\s+/", " ", $asset_name);

    			if(!empty($asset_name))
		 		{
		 			$wordcount=str_word_count($asset_name);

		 			// print_r('wc'.$wordcount);
		 			// die();

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

			 		$itemlist = $this->general->get_tbl_data('itli_maxval','itli_itemslist',false,'itli_itemlistid','ASC');

			 		$maxval = !empty($itemlist[0]->itli_maxval)?$itemlist[0]->itli_maxval:0;

			 		$plusone = $maxval + 1;

			 		if(AUTO_ASSET_CODE == '0'){

			 		}else{
			 			if(AUTO_ASSET_CODE == '1')
						{
							$format=$asset_code.'-'.$plusone.'-'.date('Y');
						}
						if(AUTO_ASSET_CODE == '2')
						{
							$format=$asset_code.'-'.$plusone;
						}
						if(AUTO_ASSET_CODE == '3')
						{
							$format=$plusone;
						}
			 		}

		 			print_r(json_encode(array('status'=>'success','asset_code'=>$format,  'message'=>'Successfully Created!!')));
		       		exit;	
		 		}
	    	}catch(Exception $e){
	    		throw $e;
	    	}
    	}else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
		}
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

    



//depreciation methods
	public function get_st_line_depr()
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

			$this->data['eqli_data'] = $this->assets_mdl->get_all_assets(array('ae.asen_asenid'=>$equid_key));

			$this->data['depreciation']=$this->assets_mdl->get_depreciation();
			 $template='';

			if($this->data['eqli_data'])
			{
			$equid=$this->data['eqli_data'][0]->asen_asenid;
			$orgid = $this->session->userdata(ORG_ID);


			$this->data['equip_comment'] = $this->assets_mdl->get_assets_comment(array('ec.eqco_orgid'=>$orgid,'ec.eqco_eqid'=>$equid));

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
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */