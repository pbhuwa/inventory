<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Quotation_analysis extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('analysis_mdl');
		
	}
	public function index()
	{ 
		$this->data['fiscal_year'] = $this->general->getFiscalYear();

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

		$this->data['current_stock']="quotation_analysis";
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('quotation/v_common_quotation_tab', $this->data);
	}

	public function analysis_list()
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
	  	$data = $this->analysis_mdl->get_analysis_list();
	  	//echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		$approvedList = $this->analysis_mdl->get_tender_approved();

        if(!empty($approvedList)){
            foreach($approvedList as $list){
                $approvedlistArray[] = $list->teap_qdetailid;
            }
        }
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {	
		    	if(in_array($row->qude_quotationdetailid, $approvedlistArray)){
                	$array[$i]['DT_RowClass'] = 'approved';
            	}
		   		$array[$i]["qdetailid"] = $row->qude_quotationdetailid;
		   		$array[$i]["itemsid"] = $row->itli_itemlistid;
		   		$array[$i]["code"] = $row->itli_itemcode;
		   		$array[$i]["itemsname"] = $row->itli_itemname;
		   		$array[$i]["supplier"] = $row->supp_suppliername;
		   		if(DEFAULT_DATEPICKER == 'NP'){
		   			$array[$i]["quot_date"] = $row->quma_quotationdatebs;	
		   		}else{
		   			$array[$i]["quot_date"] = $row->quma_quotationdatead;
		   		}
			    $array[$i]["quot_no"] = $row->quma_quotationnumber;
			    $array[$i]["rate"] = $row->qude_rate;
			    $array[$i]["dis"] = $row->qude_discountpc;
			    $array[$i]["vat"] = $row->qude_vatpc;
			    $array[$i]["netrate"] = $row->qude_netrate;
			    $array[$i]["remarks"] = $row->qude_remarks;
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function approve_quotation(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try{
			$approve = $this->analysis_mdl->approve_quotation();	
			
			if($approve){
				print_r(json_encode(array('status'=>'success','message'=>'Item Approved Successfully')));
				exit;
			}else{
				print_r(json_encode(array('status'=>'error','message'=>'Operation Failed.')));
				exit;
			}
		}catch(Exception $e){
			print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
		}
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}

	public function undo_approve_quotation(){
		try{
			$undo_approve = $this->analysis_mdl->undo_approve_quotation();	
			
			if($undo_approve){
				print_r(json_encode(array('status'=>'success','message'=>'Undo Action Completed Successfully')));
				exit;
			}else{
				print_r(json_encode(array('status'=>'error','message'=>'Operation Failed.')));
				exit;
			}
		}catch(Exception $e){
			print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
		}
	}

	public function exportToExcel(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=quotation_analysis_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        
        $data = $this->analysis_mdl->get_analysis_list();
        
        $array = array();
        unset($data["totalfilteredrecs"]);
        unset($data["totalrecs"]);

        $response = '<table border="1">';
        $response .= '<tr><th colspan="11"><center>Quotation Analysis</center></th></tr>';
        $response .= '<tr><th>S. No.</th><th>Code</th><th>Items Name</th><th>Supplier</th><th>Quot. Date</th><th>Quot. No.</th><th>Rate</th><th>Dis %</th><th>VAT %</th><th>Net Rate</th><th>Remarks</th></tr>';

        $i=1;
        $iDisplayStart = !empty($_GET['iDisplayStart'])?$_GET['iDisplayStart']:0;
        foreach($data as $row){
            $sno = $iDisplayStart + $i;   
            $qdetailid = $row->qude_quotationdetailid;
	   		$itemsid = $row->itli_itemlistid;
	   		$code = $row->itli_itemcode;
	   		$itemsname = $row->itli_itemname;
	   		$supplier = $row->supp_suppliername;
	   		if(DEFAULT_DATEPICKER == 'NP'){
	   			$quot_date = $row->quma_quotationdatebs;	
	   		}else{
	   			$quot_date = $row->quma_quotationdatead;
	   		}
		    $quot_no = $row->quma_quotationnumber;
		    $rate = $row->qude_rate;
		    $dis = $row->qude_discountpc;
		    $vat = $row->qude_vatpc;
		    $netrate = $row->qude_netrate;
		    $remarks = $row->qude_remarks;

            $response .= '<tr><td>'.$sno.'</td><td>'.$code.'</td><td>'.$itemsname.'</td><td>'.$supplier.'</td><td>'.$quot_date.'</td><td>'.$quot_no.'</td><td>'.$rate.'</td><td>'.$dis.'</td><td>'.$vat.'</td><td>'.$netrate.'</td><td>'.$remarks.'</td></tr>';
            $i++;
        }
        
        $response .= '</table>';


        echo $response;
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */