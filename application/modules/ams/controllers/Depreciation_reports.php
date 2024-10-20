<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set('max_execution_time', 50000);

class Depreciation_reports extends CI_Controller 

{



	function __construct() 

	{

		parent::__construct();

		

			$this->load->model('deprecation_report_mdl');

			$this->load->model('assets_mdl');





			

	}

	

	

	public function index()

	{	

		$this->data=array();

		$this->page_title='Depreciation  Reports Generate';

		$this->db->select('asen_assettype eqca_equipmentcategoryid,eqca_category,COUNT("*") as cnt');

		$this->db->from('eqca_equipmentcategory ec'); 

		$this->db->join('asen_assetentry ae','ae.asen_assettype=ec.eqca_equipmentcategoryid','INNER');

		 $this->db->where('eqca_isnonexp','Y');

		$this->db->group_by('asen_assettype');

		$this->db->having('COUNT("*")>0');

		$this->db->order_by('eqca_category','ASC');

		$mat_result=$this->db->get()->result();

		// echo $this->db->last_query();

		// die();

		$this->data['material']=$mat_result;

		

		$this->data['depreciation']=$this->assets_mdl->get_depreciation(array('dety_isactive'=>'Y'));

		// echo "<pre>";

		// print_r($this->data['material']);

		// die();



			// $this->deprecation_report_mdl->generate_diminishing_dep_report();



		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('depreciation_report/v_dep_search_form_main', $this->data);

	}



	public function dep_rpt_generate_main()

	{	

		$this->data=array();

		$this->page_title='Depreciation  Reports Generate';

		$this->db->select('asen_assettype eqca_equipmentcategoryid,eqca_category,COUNT("*") as cnt');

		$this->db->from('eqca_equipmentcategory ec'); 

		$this->db->join('asen_assetentry ae','ae.asen_assettype=ec.eqca_equipmentcategoryid','LEFT');

		 $this->db->where('eqca_isnonexp','Y');

		$this->db->group_by('asen_assettype');

		$this->db->having('COUNT("*")>0');

		$this->db->order_by('eqca_category','ASC');

		$mat_result=$this->db->get()->result();

		// echo "<pre>";

		// print_r($mat_result);

		// die();



		$this->data['material']=$mat_result;

		$this->data['depreciation']=$this->assets_mdl->get_depreciation(array('dety_isactive'=>'Y'));

		// echo "<pre>";

		// print_r($this->data['material']);

		// die();



			// $this->deprecation_report_mdl->generate_diminishing_dep_report();



		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('depreciation_report/v_dep_search_form_main', $this->data);

	}





	public function depreciation_list(){

			// echo '<pre>'; print_r($this->data['distributor_list']); die();



		 $this->data['fiscalyear']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');

			$this->db->select('*');

	    $this->db->from('eqca_equipmentcategory ec');

	    $this->db->where('eqca_isnonexp','Y');

	    $result=$this->db->get()->result();



		$this->data['material']= $result;

		$this->data['depreciation']=$this->assets_mdl->get_depreciation();

		

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

			->build('ams/depreciation_report/v_depreciation_list', $this->data);



	}



	public function generate_depreciation_report()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') 

    	{

    		$depmethodid=$this->input->post('asen_depreciation');

    		// echo $depmethodid;

    		// die();

    		if($depmethodid==1){

    			$this->data['assets_dep_report']=$this->deprecation_report_mdl->generate_diminishing_dep_report();

    		}

    		if($depmethodid==5)

    		{

    			// echo "est";

    			$this->data['assets_dep_report']=$this->deprecation_report_mdl->generate_diminishing_dep_report();

    		}

    		// else

    		// {

    		// 	$this->data['assets_dep_report']=$this->deprecation_report_mdl->generate_dep_report();

    		// }



    			print_r(json_encode(array('status'=>'success','message'=>'Operation Successful')));

		        exit;

    	}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}



	}



	public function generate_depreciation_report_main(){

		if ($_SERVER['REQUEST_METHOD'] === 'POST') 

    	{
    		if(ORGANIZATION_NAME=='KU'){
    			$this->deprecation_report_mdl->generate_diminishing_dep_report_main_ku();
    		}else{
    			$this->deprecation_report_mdl->generate_diminishing_dep_report_main();	
    		}
    		

			print_r(json_encode(array('status'=>'success','message'=>'Operation Successful')));

		        exit;

    	}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}

	}



	public function get_depreciation_list($result=false,$orgid=false){



		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);



		 $fyear = !empty($get['fiscal_year'])?$get['fiscal_year']:CUR_FISCALYEAR;



		 $asset_type = !empty($get['assettype'])?$get['assettype']:'';



		// echo "check";

		// print_r($asset_type);

		// print_r($fyear);

		// die();

		

		$data = $this->deprecation_report_mdl->get_dete_depreciation_list();



	    // echo $this->db->last_query();die();



	

		// echo "<pre>"; print_r($data); die();



	  	$i = 0;

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);

		$totalrecs = $data["totalrecs"];



	    unset($data["totalfilteredrecs"]);

	  	unset($data["totalrecs"]);

		  	foreach($data as $row)

		    {

		   

			    $array[$i]["dete_deteid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->dete_deteid.'>'.$row->dete_deteid.'</a>';

			    $array[$i]["asen_assetcode"] = $row->asen_assetcode;

			    $array[$i]["itli_itemname"] = $row->itli_itemname;

			    $array[$i]["purchasedatebs"] = $row->dete_purchasedatebs;

			    $array[$i]["startdatebs"] = $row->dete_startdatebs;

			    $array[$i]["enddatebs"] = $row->dete_enddatebs;

			    $array[$i]["originalcost"] = $row->dete_orginalcost;

			    $array[$i]["opbalance"] = $row->dete_opbalance;

			    $array[$i]["deprate"] = $row->dete_deprate;

			    $array[$i]["fiscalyrs"] = $row->dete_fiscalyrs;

			    $array[$i]["accmulateval"] = $row->dete_accmulateval;

			    $array[$i]["accmulatdepprevyrs"] = $row->dete_accmulatdepprevyrs;

			    $array[$i]["totaldeptilldateval"] = $row->dete_totaldeptilldateval;

			    $array[$i]["netvalue"] = $row->dete_netvalue;

			    $array[$i]["postdatead"] = $row->dete_postdatead;

			    $array[$i]["postdatebs"] = $row->dete_postdatebs;

			    $array[$i]["posttime"] = $row->dete_posttime;

			    $array[$i]["postip"] = $row->dete_postip;

			    $array[$i]["remarks"] = $row->remarks;			  

			    $i++;

		    }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}









public function generate_pdfDirect()

    {

    	$this->data['distinct_cat'] = $this->deprecation_report_mdl->distinct_category();



		// echo $this->db->last_query();

    	// echo "<pre>";

    	// print_r( $this->data['distinct_cat']);

        // die();





        // $this->data['searchResult'] = $this->deprecation_report_mdl->get_dete_depreciation_list();



        // echo "<pre>";

        // print_r( $this->data['searchResult']);

        // die();

        unset($this->data['searchResult']['totalfilteredrecs']);

        unset($this->data['searchResult']['totalrecs']);



        $html = $this->load->view('depreciation_report/v_depreciation_list_pdf', $this->data, true);

      	$filename = 'depreciation_report'. date('Y_m_d_H_i_s') . '_.pdf'; 

        $pdfsize = 'A4-L'; //A4-L for landscape

        //if save and download with default filename, send $filename as parameter

        $this->general->generate_pdf($html,false,$pdfsize);

        exit();

    }

	





public function exportToExcelDirect()

    {

        header("Content-Type: application/xls");    

        header("Content-Disposition: attachment; filename=depreciation_report".date('Y_m_d_H_i').".xls");  

        header("Pragma: no-cache"); 

        header("Expires: 0");



        $data = $this->deprecation_report_mdl->get_dete_depreciation_list();



        $this->data['searchResult'] = $this->deprecation_report_mdl->get_dete_depreciation_list();

        

        $array = array();

        unset($this->data['searchResult']['totalfilteredrecs']);

        unset($this->data['searchResult']['totalrecs']);

        $response = $this->load->view('depreciation_report/v_depreciation_list_pdf', $this->data, true);



        echo $response;

    }

    public function depreciation_search_report(){

			// echo '<pre>'; print_r($this->data['distributor_list']); die();



		$this->data['fiscalyear']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');

			$this->db->select('*');

	    $this->db->from('eqca_equipmentcategory ec');

	    $this->db->where('eqca_isnonexp','Y');

	    $result=$this->db->get()->result();



		$this->data['material']= $result;

		$this->data['depreciation']=$this->assets_mdl->get_depreciation();

		

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

			->build('ams/depreciation_report/v_depreciation_search', $this->data);



	}



   public function search_depreciation()

    {

     // $location=$this->input->post('locationname');

     // print_r($location);die;

    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {



	      	$html = $this->get_search_depreciation();

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



    public function search_depreciation_list_pdf()

   	{  

   		error_reporting(E_ALL);

    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		    $html = $this->get_search_depreciation();



	        $filename = 'depreciation_rpt_'. date('Y_m_d_H_i_s') . '_.pdf'; 

	        $pdfsize = 'A4-L'; 

	        $this->general->generate_pdf($html,false,$pdfsize);

	        exit();

	    }else{

        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

        	exit;

        }

    }



    public function search_depreciation_list_excel()

    {

    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    	error_reporting(E_ALL);

    	header("Content-Type: application/xls");    

        header("Content-Disposition: attachment; filename = depreciation_rpt_".date('Y_m_d_H_i').".xls");  

        header("Pragma: no-cache"); 

        header("Expires: 0");	      

      	$response = $this->get_search_depreciation();

      	//print_r($response);die;

    	echo $response;

    	 }else{

        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

        	exit;

        }

    }



    public function get_search_depreciation()

    {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') 

    	{

		$this->data['excel_url'] = "ams/depreciation_reports/search_depreciation_list_excel";

		$this->data['pdf_url'] = "ams/depreciation_reports/search_depreciation_list_pdf";

		$this->data['report_title'] = "Report";



    	$fiscal_year=$this->data['fiscal_year']=!empty($this->input->post('fiscal_year'))?$this->input->post('fiscal_year'):'';

    	$asen_assettype=!empty($this->input->post('asen_assettype'))?$this->input->post('asen_assettype'):'';

    	$asen_asenid=!empty($this->input->post('asen_asenid'))?$this->input->post('asen_asenid'):'';

    	$location=!empty($this->input->post('locationname'))?$this->input->post('locationname'):'';







    	



	     if($fiscal_year==''){

	     $this->data['depreciation_report_data']=$this->deprecation_report_mdl->distinct_fiscalyear(false,false,false,false,'ASC',false,false);

	        // print_r($this->data['depreciation_report_data']);die();

           $view=$this->load->view('ams/depreciation_report/v_depreciation_report_details_allfiscalyear',$this->data,true);

	     }else{

	     	

		   if($asen_assettype==''){

		   	$this->data['depreciation_report_data']=$this->deprecation_report_mdl->distinct_category_list(array('dete_fiscalyrs'=>$fiscal_year),false,false,false,'ASC',false,false);

		   	

		   }else{

		   

		   	$this->data['depreciation_report_data']=$this->deprecation_report_mdl->distinct_category_list(array('dete_fiscalyrs'=>$fiscal_year,'asen_assettype'=>$asen_assettype),false,false,false,'ASC',false,false);



		   }

	    	 

	     	 $view=$this->load->view('ams/depreciation_report/v_depreciation_report_details_particular_fiscalyear',$this->data,true);

	     }

	     if(empty($fiscal_year) && !empty($asen_assettype) && !empty($asen_asenid)){

    		$this->data['depreciation_report_data']=$this->deprecation_report_mdl->get_depreciation_list_data(array('dete_assetid'=>$asen_asenid),false,false,false,'ASC',false,false); 

    		$view=$this->load->view('ams/depreciation_report/v_depreciation_report_details_allfiscalyear_ind_assets',$this->data,true);

    	}



	   if($location):

			$this->data['location']=$this->general->get_tbl_data('loca_locationid,loca_name','loca_location',array('loca_locationid'=>$location));

		else:

			$this->data['location'] = 'All';

		endif;



		if($this->data['depreciation_report_data']){

		    	$html=$view;

		  }else{

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

   



    public function depreciation_summary_report(){

			// echo '<pre>'; print_r($this->data['distributor_list']); die();



		$this->data['fiscalyear']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');

		

		$this->db->select('*');

	    $this->db->from('eqca_equipmentcategory ec');

	    $this->db->where('eqca_isnonexp','Y');

	    $result=$this->db->get()->result();



		$this->data['material']= $result;

		$this->data['depreciation']=$this->assets_mdl->get_depreciation();

		

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

			->build('ams/depreciation_report/v_depreciation_summary_search_form', $this->data);



	}



	public function search_depreciation_summary()

    {

     // $location=$this->input->post('locationname');

     // print_r($location);die;

    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {



	      	$html = $this->get_search_depreciation_summary();

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





    public function get_search_depreciation_summary()

    {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') 

    	{

		$this->data['excel_url'] = "ams/depreciation_reports/search_depreciation_list_excel";

		$this->data['pdf_url'] = "ams/depreciation_reports/search_depreciation_list_pdf";

		if(empty($this->input->post('fiscal_year'))){

			print_r(json_encode(array('status'=>'error','message'=>'Fiscal Year is Requered')));

        	exit;

		}





    	$fiscal_year=$this->data['fiscal_year']=!empty($this->input->post('fiscal_year'))?$this->input->post('fiscal_year'):'';

    	$asen_assettype=!empty($this->input->post('asen_assettype'))?$this->input->post('asen_assettype'):'';

    	$asen_asenid=!empty($this->input->post('asen_asenid'))?$this->input->post('asen_asenid'):'';

    	$location=!empty($this->input->post('locationname'))?$this->input->post('locationname'):'';

    	$rpt_type=!empty($this->input->post('rpt_type'))?$this->input->post('rpt_type'):'';

    	$this->data['rpt_type']=$rpt_type;

	    if(!empty($fiscal_year)){

	    	if($rpt_type=='summary'){

				$this->data['list_rpt']=$this->deprecation_report_mdl->get_fiscalyrs_ass_cat_with_summary();

				   		$this->data['report_title']='Fix Assets List';

		    	$view=$this->load->view('ams/depreciation_report/v_depreciation_report_summary',$this->data,true);

	    	}

	    	if(($rpt_type=='detail')){

	    		$this->data['list_rpt']=$this->deprecation_report_mdl->get_fiscalyrs_ass_cat_with_summary();

	    		$this->data['report_title']='Fix Assets List';

		    	$view=$this->load->view('ams/depreciation_report/v_depreciation_report_summary',$this->data,true);

	    	}



	    }

	    // die();



	   if($location):

			$this->data['location']=$this->general->get_tbl_data('loca_locationid,loca_name','loca_location',array('loca_locationid'=>$location));

		else:

			$this->data['location'] = 'All';

		endif;



		if($this->data['list_rpt']){

		    	$html=$view;

		  }else{

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







	

}

/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */