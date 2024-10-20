<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Convert_items extends CI_Controller
{
	function __construct()
	{		
		parent::__construct();
		$this->load->Model('convert_items_mdl');	
	}

	public function index()
	{  
		$this->data['loadselect2']='no';

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
			->build('convert_items/v_convert_items_main', $this->data);
	}

	public function new_convert_items(){
		$this->data['loadselect2']='no';

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
			->build('convert_items/v_convert_items_form', $this->data);
	}

	public function get_parent_convert_items_list(){
		if(MODULES_VIEW=='N')
			{
				$array=array();

				// $this->general->permission_denial_message();
				 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
				exit;
			}

			try{
			$data = $this->convert_items_mdl->get_parent_convert_items_list();

			$i = 0;
			$array = array();

			$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
			$totalrecs = $data["totalrecs"];

		    unset($data["totalfilteredrecs"]);
		  	unset($data["totalrecs"]);

		  	// echo "<pre>";
		  	// print_r($data);
		  	// die();
		  	foreach($data as $key=>$row){
		  		$array[$i]['sno'] = $i;
		  		$array[$i]['prime_id'] = !empty($row->conv_convid)?$row->conv_convid:'';
		  		$array[$i]['conv_condatebs'] = !empty($row->conv_condatebs)?$row->conv_condatebs:'';
		  		$array[$i]['itli_itemcode'] = !empty($row->itli_itemcode)?$row->itli_itemcode:'';
		  		$array[$i]['itli_itemname'] = !empty($row->itli_itemname)?$row->itli_itemname:'';
		  		$array[$i]['conv_parentqty'] = !empty($row->conv_parentqty)?$row->conv_parentqty:'';
		  		$array[$i]['conv_parentrate'] = !empty($row->conv_parentrate)?$row->conv_parentrate:'';
		  		$array[$i]['amount'] = !empty($row->amount)?$row->amount:'';
		  		$array[$i]['conv_username'] = !empty($row->conv_username)?$row->conv_username:'';
		  		$i++;
		  	}

			echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

		}catch(Exception $e){
			throw $e;
		}
	}

	public function get_child_convert_items_list(){
		
		try{
			$id = $this->input->post('prime_id');

			// echo $id;
			// die();
			$data = $this->convert_items_mdl->get_child_convert_items_list(array('conv_convid'=>$id));

			// print_r($data);

			$i = 0;
			$array = array();

			$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
			$totalrecs = $data["totalrecs"];

		    unset($data["totalfilteredrecs"]);
		  	unset($data["totalrecs"]);

		  	// echo "<pre>";
		  	// print_r($data);
		  	// die();
		  	foreach($data as $key=>$row){
		  		$array[$i]['sno'] = $i;
		  		$array[$i]['itli_itemcode'] = !empty($row->itli_itemcode)?$row->itli_itemcode:'';
		  		$array[$i]['itli_itemname'] = !empty($row->itli_itemname)?$row->itli_itemname:'';
		  		$array[$i]['conv_childqty'] = !empty($row->conv_childqty)?$row->conv_childqty:'';
		  		$array[$i]['conv_childrate'] = !empty($row->conv_childrate)?$row->conv_childrate:'';
		  		$array[$i]['amount'] = !empty($row->amount)?$row->amount:'';
		  		$array[$i]['conv_factor'] = !empty($row->conv_factor)?$row->conv_factor:'';
		  		$i++;
		  	}

			echo json_encode(array("status"=>'success',"recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

		}catch(Exception $e){
			throw $e;
		}
	}

	public function get_child_convert_items_list_by_id(){
		try{
			$id = $this->input->post('prime_id');

			$this->data['child_convert_items'] = $this->convert_items_mdl->get_child_convert_items_list(array('conv_convid'=>$id));

			unset($this->data['child_convert_items']["totalfilteredrecs"]);
		  	unset($this->data['child_convert_items']["totalrecs"]);

			$tempform = $this->load->view('convert_items/v_convert_items_child_list',$this->data,true); 

			if(!empty($tempform))
			{
				print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$tempform)));
            	exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));
	            exit;
			}
		}catch(Exception $e){
			throw $e;
		}
	}

	public function load_convert_items_modal(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {	
				$id = $this->input->post('id');

				// echo $id;
				// die();
				$this->data['convert_items_data']= $this->convert_items_mdl->get_convert_items();

				$tempform=$this->load->view('convert_items/v_convert_items_form',$this->data,true);

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
			catch (Exception $e) {
				print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
			}
		}else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}

	public function save_convert_items()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$this->form_validation->set_rules($this->convert_items_mdl->validate_convert_items);

			// echo "<pre>";
			// print_r($this->form_validation->run());
			// die();
			if($this->form_validation->run()==TRUE)
			{
				$trans = $this->convert_items_mdl->save_convert_items();
				if($trans)
				{
					print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
					exit;
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>'Operation Failed.')));
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

	public function edit_convert_items()
	{
		$id=$this->input->post('id');
		$this->data['convert_items_data']=$this->convert_items_mdl->get_all_convert_items(array('quma_convert_itemsmasterid'=>$id));

		$this->data['convert_items_items']=$this->convert_items_mdl->get_all_convert_items_items(array('qude_convert_itemsmasterid'=>$id));

		$this->data['supplier_all'] = $this->general->get_tbl_data('*','supp_supplier',false,'supp_supplierid','DESC');
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['loadselect2']='yes';

		$tempform=$this->load->view('convert_items/v_convert_items_main',$this->data,true);

		if(!empty($this->data['convert_items_data']))
		{
				print_r(json_encode(array('status'=>'success','message'=>'You Can edit','tempform'=>$tempform)));
            	exit;
		}
		else{
			print_r(json_encode(array('status'=>'error','message'=>'Unable to Edit!!')));
            	exit;
		}
	
	}

	public function load_item_lists_modal($type = false)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->data=array();
			$this->data['rowno']=$type;
		
			$template=$this->load->view('convert_items/v_items_list_modal',$this->data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template,'tempform'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function get_item_list($rowno=false)
	{
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		$orgid = $this->session->userdata(ORG_ID);
		$data = $this->convert_items_mdl->item_list_tbl();
		// echo "<pre>"; print_r($data); die();
	  	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  
		  	foreach($data as $row)
		    {
		    	$array[$i]["rowno"]=$rowno;
			  	$array[$i]["itemlistid"] = $row->itli_itemlistid;
			    $array[$i]["itemcode"] = $row->itli_itemcode;
			    $array[$i]["itemname"] = $row->itli_itemname;
			    $array[$i]["issueqty"] = round($row->trde_issueqty);
			    $array[$i]["req_qty"] = "";	
			    $array[$i]["unitname"]=$row->unit_unitname;	 
			    $array[$i]["mtdid"] = $row->trde_trdeid;
			    $array[$i]["supplierid"] = $row->trde_supplierid;
			    $array[$i]["supplierbillno"] = $row->trde_supplierbillno; 
			    $array[$i]["selprice"] = $row->salesrate; 
			    $array[$i]["unitprice"] = $row->trde_unitprice; 
			    $array[$i]["mfgdatebs"] = $row->trde_mfgdatebs; 
			    $array[$i]["mfgdatead"] = $row->trde_mfgdatead; 
			    $i++;
		        //(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */