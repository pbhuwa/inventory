<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Faq extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->Model('faq_mdl');
	}

	public function index()
	{
		$this->data['material_type']=$this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','ASC');
		$seo_data='';
		$this->data['tab_type']="entry";
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
			->build('v_faq', $this->data);
	}

	public function form_faqcategory()
	{
		$this->data=array();
		$this->data['listurl']='';
		$this->load->view('v_faq_category',$this->data);		
	}


	public function faq_category_setup()
	{  
		$this->data['tab_type']="cat_setup";
		$this->data['listurl']='';
		$this->data['item_data']='';
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
			->build('v_faq', $this->data);	
	}

	
	public function save_faq_category()
	{
		
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
		try {
				$this->form_validation->set_rules($this->faq_mdl->validate_settings_faq_category);
				
				if($this->form_validation->run()==TRUE)
				{   
					$trans = $this->faq_mdl->faq_cat_save();
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
			} 
		catch (Exception $e) 
			{
		  
			print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
			}
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
		}
	}

	public function get_faq_category_list()
	{
	 if(MODULES_VIEW=='N')
			{
				$array=array();
				echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));
				exit;
			}
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		$orgid = $this->session->userdata(ORG_ID);
		
		$data = $this->faq_mdl->get_faq_cat_list();
		//echo "<pre>"; print_r($data); die();
		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
		$lang=$this->session->userdata('lang');

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);
	  
			foreach($data as $row)
			{
				$array[$i]["facq_catname"] = $row->facq_catname;
				$array[$i]["facq_catnamenp"] = $row->facq_catnamenp;
				
			if ($row->facq_isactive=="Yes" || "Y")
				$array[$i]["facq_isactive"] = "Yes";
			else if ($row->facq_isactive=="No" || "N")
				$array[$i]["facq_isactive"] = "No";
			else
				$array[$i]["facq_isactive"]==$row->facq_isactive;
				
				$array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->faca_faqcatid.' data-displaydiv="FormFaqCategorySetup" data-viewurl='.base_url('faq/edit_faq_cat').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>
				<a href="javascript:void(0)" data-id='.$row->faca_faqcatid.' data-tableid='.($i+1).' data-deleteurl='. base_url('faq/delete_faq_cat') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>
				';
				 
				$i++;
			}
		echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}


	public function insert_faq()
	{
		$this->data['tab_type']="entry";
		$this->data['faq_list']=$this->faq_mdl->get_all_faq();
		// echo "<pre>";print_r($this->data['faq_list']);die();
		$this->page_title='FQA';
			$this->template
				->set_layout('general')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('v_faq', $this->data);
	}

	public function form_faq_list()
	{
		$this->data['faq_list']=$this->faq_mdl->get_all_faq();
		$this->load->view('v_faq_main',$this->data);
		
	}


	public function form_faq_entry()
	{
		$this->load->view('v_faq_form');
	}
	

	public function faq_list()
	{
		//$this->data['faq_data']=$this->general->get_tbl_data('*','fali_faqlist',false,'fali_faqlistid','DESC');
		$this->data['faq_data']=$this->faq_mdl->get_all_faq_list();
		// echo "<pre>";
		// print_r($this->data['faq_data']); die;
		$this->data['faq_list']=$this->faq_mdl->get_all_faq();
		// echo "<pre>";
		// print_r($this->data['faq_list']); die;
		$seo_data='';
		$this->data['tab_type']="list";
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
			->build('v_faq', $this->data);
	}




	public function edit_faq_cat()
	{   

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// if(MODULES_UPDATE=='N')
			// 	{
			// 	$this->general->permission_denial_message();
			// 	exit;
			// 	}
			$id=$this->input->post('id');
		
		
		$this->data['item_data']=$this->faq_mdl->get_all_faq_cat_list(array('faca_faqcatid'=>$id));

		// echo "<pre>";
		// print_r($this->data['item_data']);
		// die();
			
		if($this->data['item_data'])
		{
			$dep_date=$this->data['item_data'][0]->facq_postdatead;
			$dep_time=$this->data['item_data'][0]->facq_posttime;
			$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
			
			$this->data['edit_status']=$editstatus;

		}
			// $tempform = $this->load->view('v_faq_category_form',$this->data,true);
			$tempform = $this->load->view('v_faq_category',$this->data,true);
			// echo $tempform;
			// die();
			if(!empty($this->data['item_data']))
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

	public function delete_faq_cat()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_DELETE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			$id=$this->input->post('id');
			$trans = $this->faq_mdl->remove_faq_cat();
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

	public function insert_faq_list()
	{
		// print_r($this->input->post());
		// die();
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
		try {
				$this->form_validation->set_rules($this->faq_mdl->validate_settings_faq_list);
				
				if($this->form_validation->run()==TRUE)
				{
				$trans = $this->faq_mdl->faq_list_save();
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
			} 
		catch (Exception $e) 
			{
		  
			print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
			}
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
		}
	}



public function get_faq_list()
	{
	 	// if(MODULES_VIEW=='N')
		// 	{
		// 		$array=array();
		// 		echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));
		// 		exit;
		// 	}
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		$orgid = $this->session->userdata(ORG_ID);
		
		$data = $this->faq_mdl->get_list_faq();
		//echo "<pre>"; print_r($data); die();
		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
		$lang=$this->session->userdata('lang');
		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);
			foreach($data as $row)
			{
				$array[$i]["fali_catid"] = $row->facq_catname;
				
				$array[$i]["fali_title"] = $row->fali_title;
				$array[$i]["fali_titlenp"] = $row->fali_titlenp;
				$array[$i]["fali_description"] = $row->fali_description;

				$array[$i]["fali_descriptionnp"] = $row->fali_descriptionnp;
				
				$array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->fali_faqlistid.' data-displaydiv="Formfaqlist" data-viewurl='.base_url('faq/edit_faq_list').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>
				<a href="javascript:void(0)" data-id='.$row->fali_faqlistid.' data-tableid='.($i+1).' data-deleteurl='. base_url('faq/delete_faq') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>
				';
				$i++;
			}
		echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function edit_faq_list()
	{   
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// if(MODULES_UPDATE=='N')
			// 	{
			// 	$this->general->permission_denial_message();
			// 	exit;
			// 	}
			$id=$this->input->post('id');

			// echo "<pre>";
			// print_r($id);
			// die();
			$this->data['item_data']=$this->faq_mdl->get_faq_list(array('fali_faqlistid'=>$id));
			// echo "<pre>";
			// print_r($this->data['item_data']);
			// die();
			$this->data['faq_list']=$this->faq_mdl->get_all_faq();
			if($this->data['item_data'])
			{
				$dep_date=$this->data['item_data'][0]->fali_postdatead;
				$dep_time=$this->data['item_data'][0]->fali_posttime;
				$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
				// echo $editstatus;
				// die();
				$this->data['edit_status']=$editstatus;

			}
			$tempform = $this->load->view('v_faq_main',$this->data,true);
			// echo $tempform;
			// die();
			if(!empty($this->data['item_data']))
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




public function delete_faq()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// if(MODULES_DELETE=='N')
			// 	{
			// 	$this->general->permission_denial_message();
			// 	exit;
			// 	}
			$id=$this->input->post('id');
			$trans = $this->faq_mdl->remove_faq();
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


public function faq_list_pdf()
    {
        $this->data['searchResult'] = $this->faq_mdl->get_faq_list(); 

        // echo "<pre>";
        // print_r($this->data['searchResult']);
        // die();

        $html = $this->load->view('v_faq_list_downlaod', $this->data, true);
        
        //echo"<pre>"; print_r($html);die;



      	$filename = 'faq'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
         $mpdf->SetFooter(base_url().'|{PAGENO}|'); // Add a footer for good 
         exit();
    }



	
}
				/* End of file welcome.php */
				/* Location: ./application/controllers/welcome.php */