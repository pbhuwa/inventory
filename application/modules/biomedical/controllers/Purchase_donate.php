<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_donate extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('purchase_donate_mdl');
		
	}

	public function index()
    {

		// $this->data['purchase_donate_all'] = $this->purchase_donate_mdl->get_all_purchase_donate();

		$this->data['editurl'] = base_url().'biomedical/purchase_donate/editpurchase_donate';
		$this->data['deleteurl'] = base_url().'biomedical/purchase_donate/deletepurchase_donate';
		$this->data['listurl']=base_url().'biomedical/purchase_donate/list_purchase_donate';
		// echo "<pre>";
		// print_r($this->input->post());
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
			->build('purchase_donate/v_purchase_donate', $this->data);
	}

	public function list_purchase_donate()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(MODULES_VIEW=='N')
			{
			$this->general->permission_denial_message();
			exit;
			}	
			$data=array();
			$template=$this->load->view('purchase_donate/v_purchase_donate_list',$data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function save_purchase_donate()
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

			$id=$this->input->post('id');
			
			$this->form_validation->set_rules($this->purchase_donate_mdl->validate_purchase_donate);
			
			
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->purchase_donate_mdl->save_purchase_donate();
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
	public function form_purchase_donate()
		{
			$this->load->view('purchase_donate/v_purchasedonateform');
		}

	public function editpurchase_donate()
	{   
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_UPDATE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}

			$id=$this->input->post('id');
		
			$data['pudo_data']=$this->purchase_donate_mdl->get_all_purchase_donate(array('ds.pudo_purdonatedid'=>$id));
			// echo "<pre>";
			// print_r($data['pudo_data']);
			// die();
			$tempform = $this->load->view('purchase_donate/v_purchasedonateform',$data,true);
			// echo $tempform;
			// die();
			if(!empty($data['pudo_data']))
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

	public function deletepurchase_donate()
    {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_DELETE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}

			$id=$this->input->post('id');
			$trans=$this->purchase_donate_mdl->remove_purchase_donate();
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


    public function get_purchasedonate()
    {
    	if(MODULES_VIEW=='N')
			{
				$array["pudo_purdonatedid"] ='';
				$array["purdonated"]='';
				$array["postdatebs"]='';
				$array["action"] ='';
 				echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));
                exit;
			}

    	$data = $this->purchase_donate_mdl->get_purchasedonate_list();
    	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  	foreach($data as $row)
		    {
			    $array[$i]["pudo_purdonatedid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->pudo_purdonatedid.'>'.$row->pudo_purdonatedid.'</a>';
			    $array[$i]["purdonated"] = $row->pudo_purdonated;
			    $array[$i]["postdatebs"] = $row->pudo_postdatebs;
			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->pudo_purdonatedid.' data-displaydiv="purchase_donate" data-viewurl='.base_url('biomedical/purchase_donate/editpurchase_donate').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>&nbsp;
			    	<a href="javascript:void(0)" data-id='.$row->pudo_purdonatedid.' data-tableid='.($i+1).' data-deleteurl='. base_url('biomedical/purchase_donate/deletepurchase_donate') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>
			    ';
			    
			    $i++;
		        //(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */