<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Moving_analysis extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('moving_analysis_mdl');
		$this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		
	}

	public function index()
	{ 
		$itemlist = $this->data['items_list']=$this->moving_analysis_mdl->get_items_list();

		$issue_list = $this->data['issue_list']=$this->moving_analysis_mdl->get_issue_list();

        $moving_type = $this->general->get_tbl_data('*','moty_movingtype',false,'moty_movingtypeid','ASC');
        
        $fast_qty = !empty($moving_type[0]->moty_qty)?$moving_type[0]->moty_qty:'';
        $medium_qty = !empty($moving_type[1]->moty_qty)?$moving_type[1]->moty_qty:'';
        $slow_qty = !empty($moving_type[2]->moty_qty)?$moving_type[2]->moty_qty:'';
        $non_qty = !empty($moving_type[3]->moty_qty)?$moving_type[3]->moty_qty:'';

        $value_type = $this->general->get_tbl_data('*','vaty_valuetype',false,'vaty_valuetypeid','ASC');

		$high_value = 	!empty($value_type[0]->vaty_amount)?$value_type[0]->vaty_amount:'';
        $medium_value = 	!empty($value_type[1]->vaty_amount)?$value_type[1]->vaty_amount:'';
        $low_value = 	!empty($value_type[2]->vaty_amount)?$value_type[2]->vaty_amount:'';
        $issue_list_array=array();
        if(!empty($issue_list)):
		foreach($issue_list as $key=>$issue){
			$total_issue_qty = $issue->total_issue_qty;
			$salesrate = $issue->salesrate;

			if($total_issue_qty >= $fast_qty){
	            $moving_type_name = "FAST MOVING";
	        }else if(($total_issue_qty >= $medium_qty) && ($total_issue_qty < $fast_qty)){
	            $moving_type_name = "MEDIUM MOVING";
	        }else if(($total_issue_qty >= $slow_qty) && ($total_issue_qty < $medium_qty)){
	            $moving_type_name = "SLOW MOVING";
	        }else if(($total_issue_qty >= $non_qty) && ($total_issue_qty < $slow_qty)){
	            $moving_type_name = "SLOW MOVING";
	        }else{
	            $moving_type_name = "";
	        }

	        if($salesrate >= $high_value){
	        	$value_type_name = "HIGH VALUE";
	        }else if(($salesrate >= $medium_value) && ($salesrate < $high_value)){
	        	$value_type_name = "MEDIUM VALUE";
	        }else if(($salesrate >= $low_value) && ($salesrate < $medium_value)){
	        	$value_type_name = "LOW VALUE";
	        }else{
	        	$value_type_name = "";
	        }

			$issue_list_array[] = array(
								'itli_itemlistid'=>$issue->itli_itemlistid,
								'itli_itemcode'=>$issue->itli_itemcode,
								'itli_itemname'=>$issue->itli_itemname,
								'eqca_category'=>$issue->eqca_category,
								'issuedqty'=>$issue->issuedqty,
								'returnqty'=>$issue->returnqty,
								'issueamt'=>$issue->issueamt,
								'returnamt'=>$issue->returnamt,
								'total_issue_qty'=>$issue->total_issue_qty,
								'salesrate' =>$issue->salesrate,
								'moving_type'=>$moving_type_name,
								'value_type'=>$value_type_name,
							);
		}
	endif;

		$this->data['issue_list_array'] = $issue_list_array; 
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

		// $this->template
		// 	->set_layout('general')
		// 	->enable_parser(FALSE)
		// 	->title($this->page_title)
		// 	->build('moving_analysis/v_moving_analysis', $this->data);

		$this->data['transfer_analysis'] = 'moving_analysis';
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('transfer_analysis/v_current_stock_details_main', $this->data);
	}

	public function moving_analysis_list()
    {
    	$moving_type = $this->general->get_tbl_data('*','moty_movingtype',false,'moty_movingtypeid','ASC');

        $fast_qty = !empty($moving_type[0]->moty_qty)?$moving_type[0]->moty_qty:'';
        $medium_qty = !empty($moving_type[1]->moty_qty)?$moving_type[1]->moty_qty:'';
        $slow_qty = !empty($moving_type[2]->moty_qty)?$moving_type[2]->moty_qty:'';
        $non_qty = !empty($moving_type[3]->moty_qty)?$moving_type[3]->moty_qty:'';

        $value_type = $this->general->get_tbl_data('*','vaty_valuetype',false,'vaty_valuetypeid','ASC');

		$high_value = !empty($value_type[0]->vaty_amount)?$value_type[0]->vaty_amount:'';
        $medium_value = !empty($value_type[1]->vaty_amount)?$value_type[1]->vaty_amount:'';
        $low_value = !empty($value_type[2]->vaty_amount)?$value_type[2]->vaty_amount:'';
        
        
            if (MODULES_VIEW == 'N') {
                $array=array();
                // $this->general->permission_denial_message();
                echo json_encode(array(
                    "recordsFiltered" => 0,
                    "recordsTotal" => 0,
                    "data" => $array
                ));
                exit;
            }

        $useraccess   = $this->session->userdata(USER_ACCESS_TYPE);
        $i            = 0;

         //if($this->location_ismain=='Y'){
        	 $data             = $this->moving_analysis_mdl->get_moving_analysis_list();
        	//}else{
        	 //	 $data         = $this->moving_analysis_mdl->get_moving_analysis_list(array('itli_locationid'=>$this->locationid));
        	     // echo "<pre>";print_r($data);
        	     // die();
        	// }
       
        //echo "<pre>";print_r($data);
        $array        = array();
        $filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
        $totalrecs    = $data["totalrecs"];
        unset($data["totalfilteredrecs"]);
        unset($data["totalrecs"]);

        // echo "<pre>";
        // print_r($data);
        // die();

        foreach ($data as $row) 
        {
        	if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
                }else{ 
                    $req_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
                }
        	
        	$total_issue_qty = $row->total_issue_qty;
			$salesrate = $row->salesrate;

			if($total_issue_qty >= $fast_qty){
	            $moving_type_name = "FAST MOVING";
	        }else if(($total_issue_qty >= $medium_qty) && ($total_issue_qty < $fast_qty)){
	            $moving_type_name = "MEDIUM MOVING";
	        }else if(($total_issue_qty >= $slow_qty) && ($total_issue_qty < $medium_qty)){
	            $moving_type_name = "SLOW MOVING";
	        }else if(($total_issue_qty >= $non_qty) && ($total_issue_qty < $slow_qty)){
	            $moving_type_name = "SLOW MOVING";
	        }else{
	            $moving_type_name = "";
	        }

	        if($salesrate >= $high_value){
	        	$value_type_name = "HIGH VALUE";
	        }else if(($salesrate >= $medium_value) && ($salesrate < $high_value)){
	        	$value_type_name = "MEDIUM VALUE";
	        }else if(($salesrate >= $low_value) && ($salesrate < $medium_value)){
	        	$value_type_name = "LOW VALUE";
	        }else{
	        	$value_type_name = "";
	        }

            $array[$i]["sno"]      = $i + 1;
            // $array[$i]['viewurl']  = base_url() . '/stock_inventory/moving_analysis/load_moving_analysis';
            // $array[$i]["prime_id"] = $row->itemid;

            $array[$i]['itli_itemlistid'] = $row->itli_itemlistid;
            $array[$i]['itli_itemcode'] = $row->itli_itemcode;
            $array[$i]['itli_itemname'] = $req_itemname;
            $array[$i]["eqca_category"] = $row->eqca_category;
            $array[$i]['issuedqty'] = $row->issuedqty;
            $array[$i]['returnqty'] = $row->returnqty;
            $array[$i]['issueamt'] = $row->issueamt;
            $array[$i]['returnamt'] = $row->returnamt;
            $array[$i]['total_issue_qty'] = $row->total_issue_qty;
            $array[$i]['salesrate'] = $row->salesrate;
            $array[$i]['moving_type'] = $moving_type_name;
            $array[$i]['value_type'] = $value_type_name;
            $i++;
        }
        echo json_encode(array(
            "recordsFiltered" => $filtereddata,
            "recordsTotal" => $totalrecs,
            "data" => $array
        ));
    }


    public function generate_pdf()
    {
    	$this->data['fromdate'] = !empty($_GET['frmDate'])?$_GET['frmDate']:CURDATE_NP;
        $this->data['todate'] = !empty($_GET['toDate'])?$_GET['toDate']:CURDATE_NP;

        if($this->location_ismain=='Y'){
        	$this->data['searchResult'] = $this->moving_analysis_mdl->get_moving_analysis_list();
        }else{
        	$this->data['searchResult'] = $this->moving_analysis_mdl->get_moving_analysis_list(array('itli_locationid'=>$this->locationid));
        }

        
        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);

        $this->load->library('pdf');
        $mpdf = $this->pdf->load();

        ini_set('memory_limit', '256M');
        $html = $this->load->view('moving_analysis/v_moving_analysis_download', $this->data, true);
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
        $output = 'moving_analysis_'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }

    public function exportToExcel(){
    	// echo "test";
    	// die();
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=moving_analysis_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        
        $this->data['fromdate'] = !empty($_GET['frmDate'])?$_GET['frmDate']:CURDATE_NP;
        $this->data['todate'] = !empty($_GET['toDate'])?$_GET['toDate']:CURDATE_NP;

        if($this->location_ismain=='Y'){
        	// echo "test";
        	// die();
     //  $data = $this->moving_analysis_mdl->get_moving_analysis_list();
        	// echo "<pre>";
        	// print_r($data);
        	// die();
        $this->data['searchResult'] = $this->moving_analysis_mdl->get_moving_analysis_list();
    //         echo "<pre>";
    // print_r($this->data['searchResult']	);
    // die();
    }else{
    	 $data = $this->moving_analysis_mdl->get_moving_analysis_list();
        $this->data['searchResult'] = $this->moving_analysis_mdl->get_moving_analysis_list(array('itli_locationid'=>$this->locationid));
    }

        
       

        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
        
        $array = array();

        $response = $this->load->view('moving_analysis/v_moving_analysis_download', $this->data, true);

        echo $response;
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */