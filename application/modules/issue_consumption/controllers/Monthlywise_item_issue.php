<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Monthlywise_item_issue extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('monthlywise_item_issue_mdl');
		$this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
	
		
	}
	public function index()
	{
		// $this->monthlywise_item_issue_mdl->generate_item_wise_data();
		$this->data['tab_type']='monthlywise_item_issue';
		$seo_data='';
		$this->data['fiscalyear']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','ASC');
		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
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
			->build('issue/v_new_issue', $this->data);
			//->build('monthly_item_issue/v_monthly_item_issue', $this->data);
	}
	public function monthlywise_item_issue_lists()
	{
		/*
		 $array=array();
		 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
		 exit;
		*/

		if(MODULES_VIEW=='N')
			{
				$array=array();

				// $this->general->permission_denial_message();
				 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
				exit;
			}
  
		$store_id = !empty($get['store_id'])?$get['store_id']:0;
        $fyear = !empty($get['fiscalyear'])?$get['fiscalyear']:CUR_FISCALYEAR;
        
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->session->userdata(LOCATION_ID);
	
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
	  	$i = 0;
	  	$deptreq='';
	  	$this->data['itemlist']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','ASC');
	  	
	  	//echo "<pre>";print_r($this->data['itemlist']);die;
	  	$data = $this->monthlywise_item_issue_mdl->get_item_wise_data();
	  	
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
			  	foreach($data as $row)
			    {
			    	if(ITEM_DISPLAY_TYPE=='NP')
			    	{
                		$req_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
               		}
               		else
               		{ 
                    	$req_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
                	}
			    	$totalallloc=0;	
			   		$array[$i]["sno"] = $i+1;
			   		$array[$i]['itmsid'] = $row->sade_itemsid;
			   		$array[$i]['itemcode'] = $row->itli_itemcode;
			   		$array[$i]['itemname'] = $req_itemname;
			   		$sum_all_data=0;
			   		for ($j=1; $j <=12 ; $j++) {
			   			$rwdep=('mdrk'.$j);
			   			$monthname =$this->general->getNepaliMonth($j);
			   			$mnthr = !empty($row->{$rwdep})?$row->{$rwdep}:'';
			   			$array[$i]['mdrk'.$j] ='<a href="javascript:void(0)"  data-month='.$j.' data-locationid='.$locationid.'  data-fyear="'.$fyear.'" data-store_id='.$store_id.' data-id='.$row->sade_itemsid.' data-displaydiv="IssueDetails" data-viewurl='.base_url('issue_consumption/monthlywise_item_issue/view_monthlywise_item_issue').' class="view" data-heading="'.$this->lang->line('issue_monthly_details').' '.$monthname.'" title="'.$this->lang->line('issue_monthly_details').' '.$monthname.'">'.$mnthr.'</a>';
			   		$sum_all_data +=$mnthr;

			   		}
			   		$array[$i]['total_all']=$sum_all_data;
				   	$array[$i]['totalallloc']=$totalallloc;
				    $i++;
			    }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function view_monthlywise_item_issue()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				$mnth = $this->input->post('month');
				$locationid = $this->input->post('location');
				$fyear = $this->input->post('fiscal_year');
				if($id)
				{ 
					$this->data['details_requisition_department'] = $this->monthlywise_item_issue_mdl->get_monthlywise_item_issue(array('sade_itemsid'=>$id,'fiscalyrs'=>$fyear,'sade_locationid'=>$locationid,'mnth'=>$mnth));
					//echo $this->db->last_query(); die();
					//echo"<pre>";print_r($this->data['details_requisition_department']);die();
					$template=$this->load->view('monthly_item_issue/v_monthly_item_issue_popup',$this->data,true);
					if($this->data['details_requisition_department']>0)
					{
							print_r(json_encode(array('status'=>'success','message'=>'','tempform'=>$template)));
			            	exit;
					}
					else{
						print_r(json_encode(array('status'=>'error','message'=>'')));
			            	exit;
					}
						print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','tempform'=>$template)));
			   			exit;	
				}
			}
		 	else
		    {
		    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		            exit;
		    }
	    }else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}
	public function generate_pdfissueMonthly()
    {
        $this->data['searchResult'] = $this->monthlywise_item_issue_mdl->get_item_wise_data();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        //echo"<pre>";print_r($this->data['searchResult']);die;
        ini_set('memory_limit', '256M');
        $html = $this->load->view('monthly_item_issue/v_monthly_item_issue_download', $this->data, true);
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
        $output = 'IssueMonthlyDepartment'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }
    public function exportToExcelissueMonthly()
    {
    	header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=IssueMonthlyDepartment".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        $data = $this->monthlywise_item_issue_mdl->get_item_wise_data();
        $this->data['searchResult'] = $this->monthlywise_item_issue_mdl->get_item_wise_data();
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('monthly_item_issue/v_monthly_item_issue_download', $this->data, true);
        echo $response;
    }
}