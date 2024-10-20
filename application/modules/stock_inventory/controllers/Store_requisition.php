<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Store_requisition extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('store_requisition_mdl');
		$this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
	}

	
	public function index()
	{
		$reqdata=$this->general->get_tbl_data('MAX(reno_reqno)+1 as maxreqno','reno_requisitionnote',array('reno_fyear'=>CUR_FISCALYEAR),false,false);
		// echo "<prE>";
		// print_r($this->data);
		// die();
		 $this->data['req_no']=!empty($reqdata[0]->maxreqno)?$reqdata[0]->maxreqno:'1';

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
			->build('store_requisition/store_requisition_main', $this->data);
	}


	public function store_requisition_list()
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

$data = $this->store_requisition_mdl->get_store_requisition_list();
	  	// if($this->location_ismain=='Y'){
	  	// 	$data = $this->store_requisition_mdl->get_store_requisition_list();
	  	// }else{
	  	// 	$data = $this->store_requisition_mdl->get_store_requisition_list(array('reno_locationid'=>$this->locationid));
	  	// }

	  

		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];


	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		foreach($data as $row)
		 {
		    	
		    	 	$array[$i]["reqdatebs"]=$row->reno_reqdatebs;
					$array[$i]["reqdatead"]=$row->reno_reqdatead;
					$array[$i]["reqno"]=$row->reno_reqno;
					$array[$i]["reqtime"]=$row->reno_reqtime;
					$array[$i]["appliedby"]=$row->reno_appliedby;
					$array[$i]["fyear"]=$row->reno_fyear;
					$array[$i]["costcenter"]=$row->reno_costcenter;
					$array[$i]["action"]='';				   
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}


	public function exportToExcel(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_requisition_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        if($this->location_ismain=='Y'){
        	 $data = $this->store_requisition_mdl->get_store_requisition_list();
        	}else{
        		 $data = $this->store_requisition_mdl->get_store_requisition_list(array('reno_locationid'=>$this->locationid));
        	}
        
       
        
        $array = array();
        unset($data["totalfilteredrecs"]);
        unset($data["totalrecs"]);



        $response = '<table border="1">';
        $response .= '<tr><th colspan="7"><center>Store Requisition</center></th></tr>';
        $response .= '<tr><th >S.n.</th>
                    <th>Req.No</th>
                    <th>Req.Date(BS)</th>
                    <th>Req.Date(AD)</th>
                    <th>Req.Time</th>
                    <th>Req.By</th>
                    <th>F.Year</th>
                    <th>Cost Center</th></tr>';

        $i=1;
        $iDisplayStart = !empty($_GET['iDisplayStart'])?$_GET['iDisplayStart']:0;
        foreach($data as $row){
            $sno = $iDisplayStart + $i; 
            $reqdatebs = $row->reno_reqdatebs;
	   	 	$reqdatead = $row->reno_reqdatead;
	   	 	$reqno = $row->reno_reqno;
	   	 	$reqtime = $row->reno_reqtime;
	   	 	$appliedby = $row->reno_appliedby;
	   	 	$fyear = $row->reno_fyear;
	   	 	$costcenter = $row->reno_costcenter;

            $response .= '<tr><td>'.$sno.'</td><td>'.$reqno.'</td><td>'.$reqdatebs.'</td><td>'.$reqdatead.'</td><td>'.$reqtime.'</td><td>'.$appliedby.'</td><td>'.$fyear.'</td><td>'.$costcenter.'</td></tr>';
            $i++;
        }
        
        $response .= '</table>';

        echo $response;
    }
    public function generate_pdf()
    {
    	if($this->location_ismain=='Y'){
    		 $this->data['searchResult'] = $this->store_requisition_mdl->get_store_requisition_list();
    		}else{
    			 $this->data['searchResult'] = $this->store_requisition_mdl->get_store_requisition_list(array('reno_locationid'=>$this->locationid));
    		}
       
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $this->load->library('pdf');

        $mpdf = $this->pdf->load();
        // echo"<pre>";print_r($this->data['searchResult']);die;
        ini_set('memory_limit', '256M');

        $html = $this->load->view('stock_inventory/store_requisition/store_req_download', $this->data, true);
        $mpdf = new mPDF('c', 'A4-L');


        if(PDF_IMAGEATEXT == '3')
        {
            $mpdf->SetWatermarkImage(WATER_MARK_IMAGE);
            $mpdf->showWatermarkImage = true;
            $mpdf->showWatermarkText = true;  
            $mpdf->SetWatermarkText(ORGA_NAME);
        }
        if(PDF_IMAGEATEXT == '1')
        {
            $mpdf->SetWatermarkImage(WATER_MARK_IMAGE);
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
        $output = 'store_requisition_details_'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }

    public function save_requisition()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    	{
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
		try {
			$id=$this->input->post('id');
			// if($id)
			// {
			// 		$this->data['item_data']=$this->store_requisition_mdl->get_all_itemlist(array('it.itli_itemlistid'=>$id));
			// 	// echo "<pre>";
			// 	// print_r($data['dept_data']);
			// 	// die();
			// if($this->data['item_data'])
			// {
			// 	$p_date=$this->data['item_data'][0]->itli_postdatead;
			// 	$p_time=$this->data['item_data'][0]->itli_posttime;
			// 	$editstatus=$this->general->compute_data_for_edit($p_date,$p_time);
			// 	$usergroup=$this->session->userdata(USER_GROUPCODE);
				
			// 	if($editstatus==0 && $usergroup!='SA' )
			// 	{
			// 		   $this->general->disabled_edit_message();

			// 	}

			// }
			// }

			$this->form_validation->set_rules($this->store_requisition_mdl->validate_settings_requisition);
			// }
			
			if($this->form_validation->run()==TRUE)
			{
				$trans = $this->store_requisition_mdl->store_requisition_save();
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

  public function form_store_requisition()
  {
  	$reqdata=$this->general->get_tbl_data('MAX(reno_reqno)+1 as maxreqno','reno_requisitionnote',array('reno_fyear'=>CUR_FISCALYEAR),false,false);
		 $this->data['req_no']=!empty($reqdata[0]->maxreqno)?$reqdata[0]->maxreqno:'1';
		$this->load->view('store_requisition/store_requisition_form',$this->data);

  }

  public function exists_reqno()
	{
		$requ_requno=$this->input->post('requ_requno');
		$id=$this->input->post('id');
		$reqdata=$this->store_requisition_mdl->check_exist_requision_no($requ_requno,$id);
		if($reqdata)
		{
			$this->form_validation->set_message('exists_reqno', 'Requisition ID already exist!!');
			return false;

		}
		else
		{
			return true;
		}
	}
	

	
	
}