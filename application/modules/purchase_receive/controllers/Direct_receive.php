<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Direct_receive extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('direct_receive_mdl');
		$this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		
	}
	public function index()
	{  
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		// $this->data['depatrment']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		$this->data['location']=$this->general->get_tbl_data('*','loca_location',false,'loca_locationid','DESC');
		$this->data['last_receiveno'] = $this->general->getLastNo('trma_issueno','trma_transactionmain',array('trma_transactiontype'=>'D.RECEIVE'));
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');

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
			->build('direct_receive/v_direct_receive_main', $this->data);
	}

	public function form_direct_receive()
	{  
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		// $this->data['depatrment']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		$this->data['location']=$this->general->get_tbl_data('*','loca_location',false,'loca_locationid','DESC');
		$this->data['last_receiveno'] = $this->general->getLastNo('trma_issueno','trma_transactionmain',array('trma_transactiontype'=>'D.RECEIVE'));
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');

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
		
		$this->load->view('direct_receive/v_direct_receive_form',$this->data);
		// $this->load->view('purchase_receive/v_direct_receive_form',$this->data);
	}
	

	public function book()
	{
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
			->build('direct_receive/v_direct_receive_main', $this->data);
	}
	public function save_direct()
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

			$this->form_validation->set_rules($this->direct_receive_mdl->validate_settings_stock_requisition);
			if($this->form_validation->run()==TRUE)
			{
				$trans = $this->direct_receive_mdl->stock_requisition_save();
				if($trans)
				{
					print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
					exit;
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>'Record Save Successfully')));
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
		}else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}

	public function direct_receive_lists()
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
	  	$data = $this->direct_receive_mdl->get_direct_list();
	  	//echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {
			    $array[$i]["rema_reqmasterid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->rema_reqmasterid.'>'.$row->rema_reqmasterid.'</a>';
			    $array[$i]["reqno"] = $row->rema_reqno;
			   	//$array[$i]["level"] = $row->rema_reqno;
			    $array[$i]["manualno"] = $row->rema_manualno;
			    $array[$i]["fromdep"] = $row->fromdep; 
			    $array[$i]["todep"] = $row->todep;
			    $array[$i]["postdatead"] = $row->rema_postdatead;
			    $array[$i]["postdatebs"] = $row->rema_postdatebs;
			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->rema_reqmasterid.' data-displaydiv="chalanDetails" data-viewurl='.base_url('issue_consumption/challan/details_chalan_views/').' class="view" data-heading="View Order Details"  ><i class="fa fa-eye" aria-hidden="true" ></i></a>';
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */