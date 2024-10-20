<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contractmanagement extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('contractmgmt_mdl');
		$this->load->Model('biomedical/distributors_mdl');
		$this->load->Model('biomedical/manufacturers_mdl');
		$this->load->Model('equipment_mdl');
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->helper('file');
		$this->load->helper('form');
	}

	public function index()
    {
    	$id = $this->input->post('id');
    	$this->data['contractType'] = $this->contractmgmt_mdl->get_all_contracttype();
    	//print_r($this->data['contractType']); die;
    	$this->data['distributors'] = $this->distributors_mdl->get_distributor_list();
    	$this->data['manufacturers'] = $this->manufacturers_mdl->get_all_manufacturers();
    	$this->data['renewType'] = $this->contractmgmt_mdl->get_all_renewtype();
		// $this->data['contractmgmt_all'] = $this->contractmgmt_mdl->get_all_contractmgmt();
		$org_id=$this->data['org_id']=$this->session->userdata(ORG_ID);

		// $this->data['contract_data'] = $this->contractmgmt_mdl->get_all_contractmgmt();

		$this->data['editurl'] = base_url().'biomedical/contractmanagement';
		$this->data['deleteurl'] = base_url().'biomedical/contractmanagement/deletecontractmgmt';
		$this->data['listurl']=base_url().'biomedical/contractmanagement/list_contractmgmt';
		
		if($id){
			$this->data['contract_data']=$this->contractmgmt_mdl->get_all_contractmgmt(array('coin_contractinformationid'=>$id));
			}
		
		 $this->data['equipmnt_type']=$this->equipment_mdl->get_all_equipment();
		

		// echo "<pre>";
		// print_r($this->data['equipmnt_type']);
		// die();
		  $this->data['tab_type'] = "form";
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
			->build('contractmgmt/v_contract_tab', $this->data);
	}
	public function Contractor_list()
    {
    	$this->data['contractType'] = $this->contractmgmt_mdl->get_all_contracttype();
    	$this->data['distributors'] = $this->distributors_mdl->get_distributor_list();
    	$this->data['manufacturers'] = $this->manufacturers_mdl->get_all_manufacturers();
    	$this->data['renewType'] = $this->contractmgmt_mdl->get_all_renewtype();
		// $this->data['contractmgmt_all'] = $this->contractmgmt_mdl->get_all_contractmgmt();

		// $this->data['contract_data'] = $this->contractmgmt_mdl->get_all_contractmgmt();

		$this->data['editurl'] = base_url().'biomedical/contractmanagement';
		$this->data['deleteurl'] = base_url().'biomedical/contractmanagement/deletecontractmgmt';
		$this->data['listurl']=base_url().'biomedical/contractmanagement/list_contractmgmt';
		
		 $this->data['equipmnt_type']=$this->equipment_mdl->get_all_equipment();

		// echo "<pre>";
		// print_r($this->data['equipmnt_type']);
		// die();
		  $this->data['tab_type'] = "list";
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
			->build('contractmgmt/v_contract_tab', $this->data);
	}

	public function list_contractmgmt()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(MODULES_VIEW=='N')
			{
			$this->general->permission_denial_message();
			exit;
			}	
			$data=array();
			$template=$this->load->view('contractmgmt/v_contractmgmt_list',$data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function save_contractmgmt()
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
			if($id)
			{
				$this->data['contract_data']=$this->contractmgmt_mdl->get_all_contractmgmt(array('coin_contractinformationid'=>$id));
				// echo "<pre>";
				// print_r($data['dept_data']);
				// die();
				if($this->data['contract_data'])
				{
					$dep_date=$this->data['contract_data'][0]->coin_postdatead;
					$dep_time=$this->data['contract_data'][0]->coin_posttime;
					$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
					$usergroup=$this->session->userdata(USER_GROUPCODE);
					
					if($editstatus==0 && $usergroup!='SA' )
					{
						   $this->general->disabled_edit_message();

					}
				}
			}
			
			$this->form_validation->set_rules($this->contractmgmt_mdl->validate_contractmgmt);
			
			
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->contractmgmt_mdl->save_contractmgmt();
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

	public function form_contractmgmt($id=false)
		{
			// $id=$this->input->post('id');
			$this->data['contractType'] = $this->contractmgmt_mdl->get_all_contracttype();
			$this->data['distributors'] = $this->distributors_mdl->get_distributor_list();
			$this->data['renewType'] = $this->contractmgmt_mdl->get_all_renewtype();

			$org_id=$this->data['org_id']=$this->session->userdata(ORG_ID);
			//echo $org_id; die;
			// $this->data['allcontract'] = $this->contractmgmt_mdl->get_all_contractmgmt(array('coin_contractinformationid'=>$id));
			// if($id){
			// $this->data['contract_data']=$this->contractmgmt_mdl->get_all_contractmgmt(array('coin_contractinformationid'=>$id));
			// }
			// if($this->data['contract_data'])
			// {
			// 	$dep_date=$this->data['contract_data'][0]->coin_postdatead;
			// 	$dep_time=$this->data['contract_data'][0]->coin_posttime;
			// 	$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
			// 	// echo $editstatus;
			// 	// die();
			// 	$this->data['edit_status']=$editstatus;

			// }
			// $this->load->view('contractmgmt/v_contractmgmtform',$this->data,true);
			// }else{
			$this->load->view('contractmgmt/v_contractmgmtform',$this->data);


		}

	public function editcontractmgmt()
	{   
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// if(MODULES_UPDATE=='N')
			// {
			// 	$this->general->permission_denial_message();
			// 	exit;
			// }
			$id=$this->input->post('id');
			$this->index();
			// $this->data['contractType'] = $this->contractmgmt_mdl->get_all_contracttype();
			// $this->data['distributors'] = $this->distributors_mdl->get_distributor_list();
			// $this->data['renewType'] = $this->contractmgmt_mdl->get_all_renewtype();
			// $this->data['contract_data']=$this->contractmgmt_mdl->get_all_contractmgmt(array('coin_contractinformationid'=>$id));
			// // echo "<pre>";
			// // print_r($this->data['contract_data']);
			// // die();
			// if($this->data['contract_data'])
			// {
			// 	$dep_date=$this->data['contract_data'][0]->coin_postdatead;
			// 	$dep_time=$this->data['contract_data'][0]->coin_posttime;
			// 	$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
			// 	// echo $editstatus;
			// 	// die();
			// 	$this->data['edit_status']=$editstatus;

			// }
			// $tempform = $this->load->view('contractmgmt/v_contractmgmtform',$this->data,true);
			// // echo $tempform;
			// // die();
			// if(!empty($this->data['contract_data']))
			// {
			// 		print_r(json_encode(array('status'=>'success','message'=>'You Can edit','tempform'=>$tempform)));
	  //           	exit;
			// }
			// else{
			// 	print_r(json_encode(array('status'=>'error','message'=>'Unable to Edit!!')));
	  //           	exit;
			// }
		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}

	}

	public function deletecontractmgmt()
    {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// if(MODULES_DELETE=='N')
			// 	{
			// 	$this->general->permission_denial_message();
			// 	exit;
			// 	}

			$id=$this->input->post('id');
			$trans=$this->contractmgmt_mdl->remove_contractmgmt();
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


    public function get_contractmgmt()
    {
   //  	if(MODULES_VIEW=='N')
			// {
			// 	$array["coin_contractinformationid"] ='';
			// 	$array["coin_contracttypeid"]='';
			// 	$array["coin_distributorid"]='';
			// 	$array["coin_contracttitle"]='';
			// 	$array["coin_contractstartdatead"]='';
			// 	$array["coin_contractenddatead"]='';
			// 	$array["coin_contractvalue"]='';
			// 	$array["action"] ='';
 		// 		echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));
   //              exit;
			// }
    	$org_id=$this->session->userdata(ORG_ID);
    	if($org_id){
    	$data = $this->contractmgmt_mdl->get_contractmgmt_list(array('coin_orgid'=>$org_id));

    	}else{
    	$data = $this->contractmgmt_mdl->get_contractmgmt_list();
    		
    	}

   
    	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  	foreach($data as $row)
		    {
			    $array[$i]["coin_contractinformationid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->coin_contractinformationid.'>'.$row->coin_contractinformationid.'</a>';
			    $array[$i]["contracttype"] = $row->coty_contracttype;
			    $array[$i]["distributor"] = $row->dist_distributor;
			    $array[$i]["contracttitle"] = $row->coin_contracttitle;
			    $array[$i]["contractstartdate"] = $row->coin_contractstartdatebs;
			    $array[$i]["contractenddate"] = $row->coin_contractenddatebs;
			    $array[$i]["contractvalue"] = $row->coin_contractvalue;
			    $array[$i]["action"] ='
			    	<a href="javascript:void(0)" data-id='.$row->coin_contractinformationid.' class="myModalCall" data-viewurl='.base_url('biomedical/contractmanagement/get_contractmgmt_data').' data-toggle="modal" title="Comment" class="view"><i class="fa fa-eye" aria-hidden="true"></i></a> &nbsp;
			    	<a href="javascript:void(0)" data-id='.$row->coin_contractinformationid.' data-displaydiv="contractmgmt" data-viewurl='.base_url('biomedical/contractmanagement').' class="btnredirect"><i class="fa fa-edit" aria-hidden="true" ></i></a>&nbsp;
			    	<a href="javascript:void(0)" data-id='.$row->coin_contractinformationid.' data-tableid='.($i+1).' data-deleteurl='. base_url('biomedical/contractmanagement/deletecontractmgmt') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>
			    ';
			    
			    $i++;
		        //(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
    }

    public function getContractTypeData($type = false, $renewtype = false){
    	try{
    		$data['type'] = $type;
    		$id = $this->input->post('id');
    		if($type == 'manufacturers'){
    			$data['contractorInfo'] = $this->manufacturers_mdl->get_all_manufacturers(array('manu_manlistid'=>$id));
    		}else if($type == 'distributors'){
    			$data['contractorInfo'] = $this->distributors_mdl->get_distributor_list(array('dist_distributorid'=>$id));
    		}

    		if($renewtype == 'renew'){
    			$data['contractsInfo'] = $this->contractmgmt_mdl->get_contractmgmt_data(array('coin_distributorid'=>$id));
    		}

    		$tempform = $this->load->view('contractmgmt/v_contractorinfo',$data,true);

    		if(!empty($data))
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

    public function get_contractmgmt_data(){
    	try{
    		//print_r($this->input->post()) ; die;
    		$contractid = $this->input->post('contractid');
    		$data = $this->contractmgmt_mdl->get_contractmgmt_data(array('coin_contractinformationid'=>$contractid));

    		// print_r($data);
    		// die();
    		$contractId = $data[0]->coin_contractinformationid;
    		$contractType = $data[0]->coty_contracttype;
    		$contractName = $data[0]->dist_distributor;
    		$contractTitle = $data[0]->coin_contracttitle;
    		$contractStartDate = $data[0]->coin_contractstartdatead;
    		$contractEndDate = $data[0]->coin_contractenddatead;
    		$contractValue = $data[0]->coin_contractvalue;
    		$contractDescription = $data[0]->coin_description;
    		$contractRenew = $data[0]->rety_renewtype;
    		$contractAttachments = !empty($data[0]->coin_attachments)?$data[0]->coin_attachments:'';

    		$attach = explode(', ',$contractAttachments);

    		$download = "";
    		 if(!empty($attach)):
    		foreach($attach as $key=>$value){
    			if(!empty($value)):
    				$download .= "<a href='".base_url().CONTRACT_ATTACHMENT_PATH.'/'.$value."' class='frm_add_btn' target='_blank'><i class='fa fa-download'></i><a>&nbsp;&nbsp;";
    			endif;
    		}
    		 endif;
    		// print_r($download);
    		// die();

    		if($data){
    			print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','contractId'=>$contractId,'contractType'=>$contractType,'contractName'=>$contractName,'contractTitle'=>$contractTitle,'contractStartDate'=>$contractStartDate,'contractEndDate'=>$contractEndDate, 'contractDescription'=>$contractDescription, 'contractValue'=>$contractValue, 'download'=>$download, 'contractRenew'=>$contractRenew)));
	            exit;
    		}else{
    			print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
	            exit;
    		}
    	}catch(Exception $e){
    		throw $e;
    	}
    }

    public function exists_contracttitle(){
		$contract_title=$this->input->post('coin_contracttitle');
		$id=$this->input->post('id');
		$contractTitle=$this->contractmgmt_mdl->check_exist_title_for_other($contract_title,$id);
		if($contractTitle)
		{
			$this->form_validation->set_message('exists_contracttitle', 'Contract Title Already Exists');
			return false;
		}
		else
		{
			return true;
		}
	}

    public function contract_renewal(){
    	$this->data['contractType'] = $this->contractmgmt_mdl->get_all_contracttype();
    	$this->data['distributors'] = $this->distributors_mdl->get_distributor_list();
    	$this->data['manufacturers'] = $this->manufacturers_mdl->get_all_manufacturers();
    	$this->data['renewType'] = $this->contractmgmt_mdl->get_all_renewtype();
		// $this->data['contractmgmt_all'] = $this->contractmgmt_mdl->get_all_contractmgmt();

		// $this->data['contract_data'] = $this->contractmgmt_mdl->get_all_contractmgmt();

		$this->data['editurl'] = base_url().'biomedical/contractmanagement/editcontractmgmt';
		$this->data['deleteurl'] = base_url().'biomedical/contractmanagement/deletecontractmgmt';
		$this->data['listurl']=base_url().'biomedical/contractmanagement/list_contractmgmt';
		// echo "<pre>";
		// print_r($this->input->post());
		// die();
	   $this->data['tab_type'] = "renew";
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
			->build('contractmgmt/v_contract_tab', $this->data);
    }

    public function reports(){
    	 $this->data['tab_type'] = "report";
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
        $this->data['renewType'] = $this->contractmgmt_mdl->get_all_renewtype();
        $this->data['distributors'] = $this->distributors_mdl->get_distributor_list();

        $this->template
            ->set_layout('general')
            ->enable_parser(FALSE)
            ->title($this->page_title)
            ->build('contractmgmt/v_contract_tab', $this->data);
    }

    public function  generate_report(){
       	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       		$org_id=$this->session->userdata(ORG_ID);
       		$this->data['contractmgmt_list']=$this->contractmgmt_mdl->get_contractmgmt_report($org_id);
		
        	$template='';
        	$template=$this->load->view('contractmgmt/v_contract_report_list',$this->data,true);

         	// echo $temp; die();
         	print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
          	exit;
     	}
      	else{
          	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
          	exit;
      	}
  	}

  	public function generate_pdf(){
 
		 $this->data['contractmgmt_list']=$this->contractmgmt_mdl->get_contractmgmt_list();
		//echo "<pre>"; print_r($this->data['contractmgmt_list']); die;
// $this->data['reporttype'] = $this->input->post('reportType');
// $this->data['distributortype'] = $this->input->post('distributortype');

        unset($this->data['contractmgmt_list']['totalfilteredrecs']);
        unset($this->data['contractmgmt_list']['totalrecs']);
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
       
        ini_set('memory_limit', '256M');
        $html = $this->load->view('contractmgmt/v_contract_report_list', $this->data, true);
        $mpdf = new mPDF('c', 'A4-L'); 

        if(PDF_IMAGEATEXT == '3')
        {
            $mpdf->SetWatermarkImage(PDF_WATERMARK);
            $mpdf->showWatermarkImage = true;
            $mpdf->showWatermarkText = true;  
            $mpdf->SetWatermarkText(ORGA_NAME);
        }
        if(PDF_IMAGEATEXT == '1')
        {
            $mpdf->SetWatermarkImage(PDF_WATERMARK);
            $mpdf->showWatermarkImage = true;
        } 
        if(PDF_IMAGEATEXT == '2')
        {
            $mpdf->showWatermarkText = true;  
            $mpdf->SetWatermarkText(ORGA_NAME);
        }
        $mpdf = new mPDF('utf-8', 'A4-L');
        $mpdf->SetAutoFont(AUTOFONT_ALL);
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html);
        $output = 'contract_list'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
  	}

  	public function generate_excel(){
  	
  		header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_requisition_details".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->contractmgmt_mdl->get_contractmgmt_list();

        $this->data['contractmgmt_list'] = $this->contractmgmt_mdl->get_contractmgmt_list();
        
        $array = array();
        unset($this->data['contractmgmt_list']['totalfilteredrecs']);
        unset($this->data['contractmgmt_list']['totalrecs']);
        $response = $this->load->view('contractmgmt/v_contract_report_list', $this->data, true);


        echo $response;
  	}


  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */