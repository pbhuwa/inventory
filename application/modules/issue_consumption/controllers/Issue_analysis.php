<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Issue_analysis extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('issue_analysis_mdl');
	}
	public function index()
	{
		$this->data['materialstypecategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		$this->data['materialstype']=$this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','DESC');
		$this->data['items']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');

		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');



		$this->data['user']=$this->general->get_tbl_data('*','usma_usermain',false,'usma_userid','DESC');
		$this->data['department']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
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
		
		$this->data['issue_report'] = "issuereport";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('issue_report/v_issue_report', $this->data);
	}
	public function item_return()
	{
		$this->data['issue_report'] = "itemReturn";
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
			->build('issue_report/v_issue_report', $this->data);
	}



	public function issue_itemwise()
	{
		$this->data['issue_report'] = "issueItemwise";
		$this->data['materialstypecategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		$this->data['materialstype']=$this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','DESC');
		$this->data['items']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		$this->data['user']=$this->general->get_tbl_data('*','usma_usermain',false,'usma_userid','DESC');
		$this->data['department']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
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
			->build('issue_report/v_issue_report', $this->data);
	}

	public function issue_report_department()
	{
		$this->data['issue_report'] = "issue_report_department";
		$this->data['materialstypecategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		$this->data['materialstype']=$this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','DESC');
		$this->data['items']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		$this->data['user']=$this->general->get_tbl_data('*','usma_usermain',false,'usma_userid','DESC');
		$this->data['department']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
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
			->build('issue_report/v_issue_report', $this->data);
	}

	//issue analysis
	public function search_issue_analysis()
	{	
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			if(MODULES_VIEW=='N')
			{
				
 				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}

			$html = $this->get_issue_analysis_data();
		  	if($html)
		  	{
		  		$template=$html;
		  	}

	        // echo $temp; die();
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function search_issue_analysis_pdf()
	{    //echo "call";die;
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$html = $this->get_issue_analysis_data();

	        $filename = 'issue_analysis_'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4'; //A4-L for landscape
	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,false,$pdfsize);
	        exit();
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function search_issue_analysis_excel()
	{
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=issue_analysis_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        
        $response = $this->get_issue_analysis_data();
        if($response){
        	echo $response;	
        }
        return false;
	}

	public function get_issue_analysis_data(){
		$this->data['excel_url'] = "issue_consumption/issue_analysis/search_issue_analysis_excel";
		$this->data['pdf_url'] = "issue_consumption/issue_analysis/search_issue_analysis_pdf";
		$this->data['report_title'] = $this->lang->line('issue_analysis_report');

		$store_id = $this->input->post('store_id');
      	$depid = $this->input->post('depid');
      	$material_type = $this->input->post('maty_materialtypeid');
      	$usma_userid = $this->input->post('usma_userid');
      	$summary = $this->input->post('summary');
      	$item = $this->input->post('item');
      	$storeid = $this->input->post('store_id');
      	$locationid=$this->input->post('locationid');
      	$catid = $this->input->post('catid');
      	
      	$this->data['fromdate'] = $this->input->post('fromdate');
        $this->data['todate'] = $this->input->post('todate');

      	$this->data['issue_report']=$this->issue_analysis_mdl->get_issue_analysis_report();

      	if($storeid):
    		$this->data['store_type']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$storeid));
    	else:
    		$this->data['store_type'] = 'All';
    	endif;

    	if($depid):
			$this->data['department']=$this->general->get_tbl_data('dept_depname','dept_department',array('dept_depid'=>$depid));
		else:
			$this->data['department'] = 'All';
		endif;

		if($catid):
			$this->data['eq_category']=$this->general->get_tbl_data('eqca_category','eqca_equipmentcategory',array('eqca_equipmentcategoryid'=>$catid));
		else:
			$this->data['eq_category'] = 'All';
		endif;

		if($locationid):
			$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
		else:
			$this->data['location'] = 'All';
		endif;
      	
      	if($this->data['issue_report']){
      		$html = $this->load->view('issue_report/v_issue_report_temp',$this->data,true);
      	}else{
      		$html ='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
      	}
      	return $html;
	}
    //issue analysis end
    //issue_report_department_wise start
    public function search_issue_wise_department()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		if(MODULES_VIEW=='N')
			{
				
 				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}
	      	$html = $this->get_search_issue_wise_department_data();
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

    public function search_issue_wise_department_pdf()
    {   error_reporting(E_ALL);
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		    $html = $this->get_search_issue_wise_department_data();

	        $filename = 'issue_categories_'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4-L'; //A4-L for landscape
	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,false,$pdfsize);
	        exit();
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }
    public function search_issue_wise_department_excel()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    	error_reporting(E_ALL);
    	header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=all_purchase_item_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");	      
      	$response = $this->get_search_issue_wise_department_data();
      	print_r($response);die;
    	echo $response;
    	 }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }
    public function get_search_issue_wise_department_data(){
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		$this->data['excel_url'] = "issue_consumption/issue_analysis/search_issue_wise_department_excel";
			$this->data['pdf_url'] = "issue_consumption/issue_analysis/search_issue_wise_department_pdf";
			$this->data['report_title'] = $this->lang->line('issue_analysis_report');

    		$depid = $this->input->post('depid');
	      	$materialtypeid = $this->input->post('maty_materialtypeid');
	      	$locationid = $this->input->post('locationid');
	      	
	      	$srchcol = "";
      		
	      	if($depid)
	      	{
	      		$srchcol = ('AND dept_depid = ' .$depid);
	      	}
	      	$this->data['fromdate'] = $this->input->post('fromdate');
            $this->data['todate'] = $this->input->post('todate');
           // $this->data['locationid'] = $this->input->post('locationid');
            $exp="2";

	      	$this->data['issue_report']=$this->issue_analysis_mdl->get_issue_analysis_department($srchcol,false);

	      	$this->data['nonexp_issue_report']=$this->issue_analysis_mdl->get_issue_analysis_department($srchcol,$exp);
	      	//echo"<pre>";print_r($this->data['nonexp_issue_report']);die;

	      	if($locationid):
				$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
			else:
				$this->data['location'] = 'All';
			endif;

			if($depid):
				$this->data['department']=$this->general->get_tbl_data('dept_depname','dept_department',array('dept_depid'=>$depid));
			else:
				$this->data['department'] = 'All';
			endif;

		    if($this->data['issue_report'])
		    {
		    	$html=$this->load->view('issue_report/v_issue_category_wise_temp',$this->data,true);
		    }
		    else
		    {
		        $html='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
		    }

		    return $html;
    	}else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }
    /* issue_report_department_wise end */
    public function search_issue_wise_item()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		if(MODULES_VIEW=='N')
			{
				
 				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}

	  
	        $html = $this->search_issue_wise_item_common();
	        // echo $html; die;
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
    public function search_issue_wise_item_common()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    	$this->data['excel_url'] = "issue_consumption/issue_analysis/search_issue_wise_item_Excel";
		$this->data['pdf_url'] = "issue_consumption/issue_analysis/search_issue_wise_item_pdf";
		$this->data['report_title'] =$this->lang->line('item_wise_issue');
    	
		$category = $this->input->post('maty_materialtypeid')?$this->input->post('maty_materialtypeid'):$this->input->post('materialtype');
      	if($category):
      	
    		$this->data['materialtype']=$this->general->get_tbl_data('maty_material,maty_materialtypeid','maty_materialtype',array('maty_materialtypeid'=>$category),'maty_materialtypeid','DESC');
    	
    	else:
    		$this->data['materialtype'] = 'All';
    	endif;

    	// $mat_typeid = $this->input->post('maty_materialtypeid');
    	// $this->mattypeid=$mat_typeid;
	    //   	//echo"<pre>";print_r($this->input->post());die;
	    //   	$srchcol = "";
	    //   	if($mat_typeid)
	    //   	{
	    //   		$srchcol = ('AND itli_materialtypeid = ' .$mat_typeid);
	    //   		//secho $srchcol; die;
	    //   	}
	      	$this->data['fromdate'] = $this->input->post('fromdate');
            $this->data['todate'] = $this->input->post('todate');
           
            // echo "<pre>";
            // print_r($this->data['department_data']);
            // die();

            $this->data['department_data']=$this->issue_analysis_mdl->issue_item_wise_data(false,'dist');
           	
           	// echo $this->db->last_query();
           	// die();

	      	$locationid=$this->input->post('locationid');
			if($locationid):
			$this->data['location']=$this->general->get_tbl_data('loca_locationid,loca_name','loca_location',array('loca_locationid'=>$locationid));
		else:
			$this->data['location'] = 'All';
		endif;
	      	//echo $this->db->last_query(); die;
	      	//echo"<pre>";print_r($this->data['issue_report']);die;
	        $html='';//echo"<pre>"; print_r($this->data['item_report']);die;
		    if($this->data['department_data'])
		    {
		    	$html=$this->load->view('issue_report/v_isue_item_wise_temp',$this->data,true);
		    }
		    else
		    {
		        $html='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
		    }
		    return $html;
		 }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }
    public function search_issue_wise_item_pdf()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    	   
	        //pdf generation
	        $html = $this->search_issue_wise_item_common();  

	        // echo $html;
	        // die();
	        $filename = 'issue_itemwise_'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4-L'; //A4-L for landscape
	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,false,$pdfsize);

	        exit();
	      	}else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }


    }
    public function search_issue_wise_item_Excel()
    { 
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    	error_reporting(E_ALL);
    	header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=all_purchase_item_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");	      
      	$response = $this->search_issue_wise_item_common();
      	print_r($response);die;
    	echo $response;
    	 }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }

    }
    /* issue return start */
    public function search_return_item()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    	{

			if(MODULES_VIEW=='N')
			{
				
 				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}

	  
    		$html = $this->search_return_item_common();
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
    public function search_return_item_common(){
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    	$this->data['excel_url'] = "issue_consumption/issue_analysis/search_return_item_Excel";
		$this->data['pdf_url'] = "issue_consumption/issue_analysis/search_return_item_pdf";
		$this->data['report_title'] = $this->lang->line('item_return');
		$locationid=$this->input->post('locationid');
		$this->data['fromdate'] = $this->input->post('fromdate');
            $this->data['todate'] = $this->input->post('todate');
		if($locationid):
			$this->data['location']=$this->general->get_tbl_data('loca_locationid,loca_name','loca_location',array('loca_locationid'=>$locationid));
		else:
			$this->data['location'] = 'All';
		endif;
			$this->data['issue_return']=$this->issue_analysis_mdl->issue_item_return_data();
		    if($this->data['issue_return'])
		    {
		    	$html=$this->load->view('issue_report/v_isue_item_return_temp',$this->data,true);
		    }
		    else
		    {
		        $html='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
		    }
		    return $html;
		}else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }
	
    public function search_return_item_pdf()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	    $html = $this->search_return_item_common();
        $filename = 'return_item_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
        }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }
    public function search_return_item_Excel()
    { 
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    	error_reporting(E_ALL);
    	header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=return_item_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
	   $response=$this->search_return_item_common();
      	print_r($response);die;
    	echo $response;
    	}else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }
    /* issue return end */
    public function category_wise_issue_analysis_excel()
    { 
    	error_reporting(E_ALL);
    	header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=category_wise_issue_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
    	error_reporting(E_ALL);
	    $depid = $this->input->post('departmentid');
	      	//echo"<pre>";print_r($this->input->post());die;
	      	$srchcol = "";
	      	if($depid)
	      	{
	      		$srchcol = ('AND dept_depid = ' .$depid);
	      	}
	      	$this->data['fromdate'] = $this->input->post('fromdate');
            $this->data['todate'] = $this->input->post('todate');
            $exp="2";
            //echo"<pre>";print_r($depid);die;
	      	$this->data['issue_report']=$this->issue_analysis_mdl->get_issue_analysis_department($srchcol,false);
	      	$this->data['nonexp_issue_report']=$this->issue_analysis_mdl->get_issue_analysis_department($srchcol,$exp);
	    $response = $this->load->view('issue_report/v_issue_category_wise_temp', $this->data, true);
	    print_r($response);die;
    	echo $response;
    }

}