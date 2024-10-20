<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order_check extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('order_check_mdl');
		
	}
	public function index()
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
			->build('order_check/v_order_check_main', $this->data);
	}

	public function order_check_list()
	{
		
		if(MODULES_VIEW=='N')
			{
			$array=array();
			 // $this->general->permission_denial_message();
			 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
			}
		
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	  	$i = 0;
	  	$data = $this->order_check_mdl->get_order_check_list();
	  	// echo"<pre>";print_r($data);die;

		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];


	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {
		    	$array[$i]["viewurl"]=base_url().'purchase_receive/order_check/order_check_list_individual';
			    $array[$i]["purchaseordermasterid"] = $row->puor_purchaseordermasterid;
			    $array[$i]["orderno"] = $row->puor_orderno;
			    $array[$i]["orderdatebs"] = $row->puor_orderdatebs;
			    $array[$i]["orderdatead"] = $row->puor_orderdatead;
			    $array[$i]["supplier"] = $row->dist_distributor;
			    $array[$i]["deliverysite"] = $row->puor_deliverysite;
			    $array[$i]["requno"] = $row->puor_requno;
			    $array[$i]["deliverydatebs"] = $row->puor_deliverydatebs;
			    $array[$i]["deliverydatead"] = $row->puor_deliverydatead;
			    $array[$i]["status"] = $row->puor_status;
			   
			   
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	
	public function order_check_list_individual()
	{	
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
			$purchasemasterid =  $this->input->post('id');
			if($purchasemasterid)
			{
				$this->data['indi_order'] = $this->order_check_mdl->get_indivi_order_check_list($purchasemasterid);
				// echo "<pre>";print_r($this->data['indi_order']);die();
				
				$template=$this->load->view('order_check/v_order_check_individual',$this->data,true);
			// echo $template; die();
			if($this->data['indi_order']>0)
			{
					print_r(json_encode(array('status'=>'success','message'=>'','tempform'=>$template)));
	            	exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'')));
	            	exit;
			}
				print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
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