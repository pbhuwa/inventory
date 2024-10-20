<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Receiver_wise_issue_details extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('receiver_wise_issue_details_mdl');
	}
	public function index()
	{ 
		$this->data['store_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		$this->data['maty_materialtype']=$this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','ASC');
		$this->data['department']=$this->general->get_tbl_data('*','dept_department',array('dept_parentdepid'=>0),'dept_depid','ASC');
		$this->data['eqcaequipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'','ASC');
		//$this->data['received'] = $this->db->receiver_wise_issue_details_mdl->get_received_data();
		
		$this->data['current_stock']='summary';
		$seo_data='';
		if($seo_data)
		{	//set SEO data
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
		/*		
			$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			// ->build('receiver_wise_issue_details/v_receiver_wise_issue_details', $this->data);
			 ->build('receiver_wise_issue/v_receiver_wise_issue_details', $this->data);
		*/
		$this->data['issue_report'] = "Receiver_wise_Issue";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('issue_report/v_issue_report', $this->data);
	}

	public function current_stock_details()
	{
		$this->data['store_type']=$this->general->get_tbl_data('*','store',false,'st_store_id','ASC');
		$this->data['current_stock']='detail';

		$seo_data='';
		if($seo_data)
		{	//set SEO data
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
			->build('receiver_wise_issue_details/v_current_stock_report', $this->data);
	}
	public function search_current_stock_details_list()
		{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_VIEW=='N')
				{
				$array=array();
				 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
				exit;
				}
			}
			
			$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		  	$i = 0;
		  	//echo"<pre>";print_r($this->input->get());die;
		  	$data = $this->current_stock_mdl->get_current_stock_lists();
		  	//echo"<pre>";print_r($data);die;
			$array = array();
			$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
			$totalrecs = $data["totalrecs"];

		    unset($data["totalfilteredrecs"]);
		  	unset($data["totalrecs"]);

			  	foreach($data as $row)
			    {	
			   		$array[$i]["sno"] = $i+1;
			   		$array[$i]['itli_itemcode'] = $row->itli_itemcode;
			   		$array[$i]['itli_itemname'] = $row->itli_itemname;
			   		$array[$i]['eqca_category'] = $row->eqca_category;
			   		$array[$i]['maty_material'] = $row->maty_material;
			   			$array[$i]['itli_maxlimit'] = $row->itli_maxlimit;
			   		$array[$i]['itli_reorderlevel'] = $row->itli_reorderlevel;
			   		$array[$i]['atstock'] = $row->atstock;
			   		$array[$i]['trde_unitprice'] = $row->trde_unitprice;
			   		$array[$i]['unit_unitname'] = $row->unit_unitname;
			   		$array[$i]['batchno'] = $row->batchno;
			   		$array[$i]['trde_expdatebs'] = $row->trde_expdatebs;
			   		$array[$i]['amount'] = $row->amount;
			   		
				    $i++;
			    }
	        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
		}
		

	public function search_current_stock_list()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(MODULES_VIEW=='N')
			{
			$array["dist_distributorid"]='';
			$array["distributor"]='';
			$array["countryname"]='';
			$array["city"]='';
			$array["address1"]='';
			$array["action"]='';
			 // $this->general->permission_denial_message();
			 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
			}
		}
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
	  	$i = 0;
	  	$data = $this->current_stock_mdl->get_current_stock_lists();
	  	//echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);

		  	foreach($data as $row)
		    {	
		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]['itli_itemcode'] = $row->itli_itemcode;
		   		$array[$i]['itli_itemname'] = $row->itli_itemname;
		   		$array[$i]['eqca_category'] = $row->eqca_category;
		   		$array[$i]['maty_material'] = $row->maty_material;
		   		$array[$i]['itli_maxlimit'] = $row->itli_maxlimit;
		   		$array[$i]['itli_reorderlevel'] = $row->itli_reorderlevel;
		   		$array[$i]['atstock'] = $row->atstock;
		   		$array[$i]['trde_unitprice'] = $row->trde_unitprice;
		   		$array[$i]['unit_unitname'] = $row->unit_unitname;
		   		$array[$i]['amount'] = $row->amount;
		   		
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	
	public function exportToExcel($details=false){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=all_purchase_item_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        $data = $this->current_stock_mdl->get_current_stock_lists();
        $this->data['pdf_details'] = $details;
        $this->data['searchResult'] = $this->current_stock_mdl->get_current_stock_lists();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('receiver_wise_issue_details/v_current_stock_details_download', $this->data, true);
        echo $response;
    }
    public function generate_details_pdf($details=false)
    {	
    	unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $this->data['searchResult'] = $this->current_stock_mdl->get_current_stock_lists();
        
        $this->data['pdf_details'] = $details;

        //pdf generation
        $html = $this->load->view('receiver_wise_issue_details/v_current_stock_details_download', $this->data, true);
        $filename = 'all_purchase_item_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
    }

    public function get_receiver_wise_issue_details(){
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	    	
	    	$template = $this->get_receiver_wise_issue_details_data();
		
			print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
    }

    public function generate_pdf()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	        $html = $this->get_receiver_wise_issue_details_data();

	        $filename = 'receiver_wise_issue_details_'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4-L'; //for landscape
	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,false,$pdfsize);
	        
	        exit();
    	}else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function generate_excel()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	        header("Content-Type: application/xls");    
	        header("Content-Disposition: attachment; filename=receiver_wise_issue_details_".date('Y_m_d_H_i').".xls");  
	        header("Pragma: no-cache"); 
	        header("Expires: 0");
	        
	        $response = $this->get_receiver_wise_issue_details_data();
	        if($response){
	        	echo $response;	
	        }
	        return false;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function get_receiver_wise_issue_details_data()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			
			$this->data['excel_url'] = "issue_consumption/receiver_wise_issue_details/generate_excel";
			$this->data['pdf_url'] = "issue_consumption/receiver_wise_issue_details/generate_pdf";
			$this->data['report_title'] = $this->lang->line('category_wise_issue').' ('.$this->lang->line('receivewise').')';

			$this->data['fromdate'] = $this->input->post('fromdate');
	        $this->data['todate'] = $this->input->post('todate');

	        $storeid = $this->input->post('store_id');
	        $material_type = $this->input->post('materialtypeid');
	        $depid = $this->input->post('depid');
	        $catid = $this->input->post('catid');
	        $locationid = $this->input->post('locationid');

			$this->data['search_data_issue']=$this->receiver_wise_issue_details_mdl->get_receiver_wise_issue_details();

			$this->data['search_data_return']=$this->receiver_wise_issue_details_mdl->get_receiver_wise_return_details();

			if($storeid):
	    		$this->data['store_type']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$storeid));
	    	else:
	    		$this->data['store_type'] = 'All';
	    	endif;

	    	if($material_type):
	    		$this->data['materialtype']=$this->general->get_tbl_data('maty_material','maty_materialtype',array('maty_materialtypeid'=>$material_type));
	    	else:
	    		$this->data['materialtype'] = 'All';
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

			if($this->data['search_data_issue'] || $this->data['search_data_return']){
				$template = $this->load->view('receiver_wise_issue/v_receiver_wise_issue_details_report', $this->data, true);
			}else{
				$template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
			}
	        return $template;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
