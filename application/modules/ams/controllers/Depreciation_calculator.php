<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Depreciation_calculator extends CI_Controller 
{

	function __construct() 
	{
		parent::__construct();
			$this->load->model('assets_deprecation_mdl');
			$this->load->Model('settings/department_mdl','department_mdl');
			$this->load->Model('biomedical/bio_medical_mdl');
			$this->load->Model('biomedical/manufacturers_mdl');
			$this->load->Model('biomedical/equipment_mdl');
			$this->load->library('zend');
			$this->zend->load('Zend/Barcode');
			$this->load->library('ciqrcode');
			$this->deptemp='';
	}
	
	
	public function index()
	{	
		$this->data['assets_data']=$this->assets_deprecation_mdl->get_all_assets();
		$this->data['depreciation']=$this->assets_deprecation_mdl->get_depreciation();

		$this->page_title='Bulk Assets';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('depreciation_calculator/v_depreciation_calculator', $this->data);
	}


	public function st_dep_calc()
	{
		
		$postdata=($this->input->post());

		$start_date=$postdata['dep_life_start'];

		$start_date_exploded= explode('/', $start_date);
		$year=$start_date_exploded[0];
		$month=$start_date_exploded[1];
		$days=$start_date_exploded[2];

		$principal=($postdata['dep_purchase_cost']);	//P
		$salvage_value=($postdata['dep_salvage_cost']);	//s

		if($principal<$salvage_value)
		{
			$template="";
			print_r(json_encode(array('status'=>'error','message'=>'Principal Amount cannot be less than Salvage Value!!','template'=>$template)));
			return false;
		}

		$useful_life=$postdata['dep_life'];	
		if ($useful_life<=0)
		{
			$template="";
			print_r(json_encode(array('status'=>'error','message'=>'useful life cannot be zero or empty!!','template'=>$template)));
			return false;
		}

		$this->common_principal=$principal;
		
		$this->common_month=$month;
		$this->common_year=$year;	
		$this->common_date=$start_date;		//t
		
		$template=$this->assets_deprecation_mdl->depr_calc_straight_line_partial($principal,0,$salvage_value,$useful_life);

		print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	}

	public function ddb_dep_calc()
	{
		$postdata=($this->input->post());

		$start_date=$postdata['dep_life_start'];
			$start_date_exploded= explode('/', $start_date);
			$year=$start_date_exploded[0];
			$month=$start_date_exploded[1];
			$days=$start_date_exploded[2];

		$this->common_month=$month;
		$this->common_year=$year;	
		$this->common_date=$start_date;	

		$principal=($postdata['dep_purchase_cost']);	//P
		$this->common_salvage_value=($postdata['dep_salvage_cost']);	//s
		$useful_life=$postdata['dep_life'];	//t
		if ($useful_life<=0)
		{
			$template="";
			print_r(json_encode(array('status'=>'error','message'=>'useful life cannot be zero or empty!!','template'=>$template)));
			return false;
		}
		
		$rate=(200/$useful_life)/100; //depr_rate=(100%/useful_life)*2

		$template=$this->assets_deprecation_mdl->depr_calc_double_decl_partial($principal,$rate,$useful_life,0,0);

		print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	}

	public function up_dep_calc()
	{
		$postdata=($this->input->post());

		$start_date=$postdata['dep_life_start'];
			$start_date_exploded= explode('/', $start_date);
			$year=$start_date_exploded[0];
			$month=$start_date_exploded[1];
			$days=$start_date_exploded[2];

		$this->common_month=$month;
		$this->common_year=$year;	
		$this->common_date=$start_date;	

		$principal=($postdata['dep_purchase_cost']);	//P
		$this->common_salvage_value=($postdata['dep_salvage_cost']);	//s

		$principal_amt=$principal-$this->common_salvage_value;
		$useful_life=$postdata['dep_life'];	//t


		$units_of_production=$postdata['unit'];
		
		$template=$this->assets_deprecation_mdl->depr_calc_units_of_production_method($principal_amt,$principal,0,$units_of_production,$useful_life);
		if($template==TRUE)
		print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
		else			
		print_r(json_encode(array('status'=>'error','message'=>'Error Calculating Depreciation!!','template'=>$template)));
	}

	public function soy_dep_calc()
	{	
		$postdata=($this->input->post());

		$start_date=$postdata['dep_life_start'];
			$start_date_exploded= explode('/', $start_date);
			$year=$start_date_exploded[0];
			$month=$start_date_exploded[1];
			$days=$start_date_exploded[2];

		$this->common_month=$month;
		$this->common_year=$year;	
		$this->common_date=$start_date;	

		$principal_amt=($postdata['dep_purchase_cost']);	//P
		$salvage_value=($postdata['dep_salvage_cost']);	//s
		$depreciable_principal_amt=($principal_amt - $salvage_value);	//depreciation base principal
		$useful_life=$postdata['dep_life'];	//t	

		$template=$this->assets_deprecation_mdl->depr_calc_soy_method_partial($useful_life,$depreciable_principal_amt,$principal_amt,1);
		print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
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


	

	public function assets_search()
	{
		$this->data['status']=$this->assets_deprecation_mdl->get_status();
		$this->data['condition']=$this->assets_deprecation_mdl->get_condition();
		$this->data['material']=$this->assets_deprecation_mdl->get_material();

		$this->data['depreciation']=$this->assets_deprecation_mdl->get_depreciation();
		$this->data['manufacturers']=$this->manufacturers_mdl->get_all_manufacturers();

        $this->data['tab_type']="a";

		$this->page_title='Assets Search';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('assets/v_assets_search', $this->data);
		
	}
	
	
	public function search_assets()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   	
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
   
	  		$this->data['assets_report']=$this->assets_deprecation_mdl->get_assets_list_data();

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
			 	
			 	$this->data['eqtype']=$this->assets_deprecation_mdl->get_assets(array('eq.itli_catid'=>$eqtypeid));
			
			 	echo json_encode($this->data['eqtype']);
			}
			else{
			 	echo json_encode(array());
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