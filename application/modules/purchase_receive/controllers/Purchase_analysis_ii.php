<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_analysis_ii extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->model('purchase_analysis_ii_mdl');
		
	}

	public function index()
	{ 
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributor','ASC');
		
		$this->data['mat_type_list']=$this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','DESC');
		$this->data['eqcat_all']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false);

		$this->data['pur_analysis']='summary';
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
			->build('purchase_analysis/v_purchase_analysis_ii_main', $this->data);
	}


	public function purchase_analysis_ii_summary_list()
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
	  	$data = $this->purchase_analysis_ii_mdl->get_summary_purchase_analysis_ii();
	  	//echo"<pre>";print_r($data);die;


		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {
    		$array[$i]["category"]=!empty($row->eqca_category)?$row->eqca_category:'';
    	 	$array[$i]["distributor"]=!empty($row->dist_distributor)?$row->dist_distributor:'';
    	 	$array[$i]["pvalue"]=round($row->pvalue,2);
    	 	$array[$i]["rvalue"]=round($row->rvalue,2);
    	 	$array[$i]["netvalue"]=round($row->netvalue,2);
			 $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function purchass_analysis_second_common()
	{
		$data =  $this->purchase_analysis_ii_mdl->get_summary_purchase_analysis_ii();
        $this->data['searchResult'] =$this->purchase_analysis_ii_mdl->get_summary_purchase_analysis_ii();
        //echo"<pre>"; print_r($this->data['searchResult']);die;
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $html = $this->load->view('purchase_analysis/v_purchase_analysis_ii_summary_download', $this->data, true);
        return $html;
	}

	public function exportToExcel_summary(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=all_purchase_item_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        $html = $this->purchass_analysis_second_common();
        echo $html;
    }

    public function generate_pdf_summary()
	{
        $this->data['searchResult'] =$this->purchase_analysis_ii_mdl->get_summary_purchase_analysis_ii();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $html = $this->purchass_analysis_second_common();
        $filename = 'mrn_details_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4'; //A4-L for landscape //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
    }

	public function analysis_detail()
	{
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributor','ASC');

		// echo "<pre>";
		// print_r($this->data['supplier_all']);
		// die();

		$this->data['mat_type_list']=$this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','DESC');
			$this->data['eqcat_all']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false);
		$this->data['pur_analysis']='detail';
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
			->build('purchase_analysis/v_purchase_analysis_ii_main', $this->data);

	}

    public function purchase_analysis_ii_detail_list()
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
		//echo "aa";die;
	  	$data = $this->purchase_analysis_ii_mdl->get_detail_purchase_analysis_ii();
	  	//echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {
		    	if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
                }else{ 
                    $req_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
                }
    		$array[$i]["category"]=!empty($row->eqca_category)?$row->eqca_category:'';
    	 	$array[$i]["distributor"]=!empty($row->dist_distributor)?$row->dist_distributor:'';
    	 	$array[$i]["itemcode"]=$row->itli_itemcode;
    	 	$array[$i]["itemname"]=$req_itemname;
    	 	$array[$i]["invoiceno"]=$row->recm_invoiceno;
    	 	$array[$i]["supplierbill"]=$row->recm_supplierbillno;
    	 	$array[$i]["receiveddatebs"]=$row->recm_receiveddatebs;
    	 	$array[$i]["receiveddatead"]=   $row->recm_receiveddatead;	 	
    	 	$array[$i]["purchasedqty"]= sprintf('%g',$row->recd_purchasedqty);
    	 	$array[$i]["unitprice"]=$row->recd_unitprice;
    	 	$array[$i]["discount"]=$row->recd_discountpc;
    	 	$array[$i]["vat"]= sprintf('%g',$row->recd_vatpc);
    	 	$array[$i]["net_rate"]=($row->recd_purchasedqty)*($row->recd_unitprice);
    	 	$array[$i]["net_amount"]=$row->recd_amount;

			 $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function exportToExcel(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=all_purchase_item_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->purchase_analysis_ii_mdl->get_detail_purchase_analysis_ii();

        $this->data['searchResult'] = $this->purchase_analysis_ii_mdl->get_detail_purchase_analysis_ii();
        
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $response = $this->load->view('purchase_analysis/v_purchase_analysis_ii_detail_download', $this->data, true);


        echo $response;
    }

    public function generate_pdf()
    {   
        $this->data['searchResult'] = $this->purchase_analysis_ii_mdl->get_detail_purchase_analysis_ii();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $this->load->library('pdf');

        $mpdf = $this->pdf->load();
       // echo"<pre>";print_r($this->data['searchResult']);die;
        ini_set('memory_limit', '256M');

        $html = $this->load->view('purchase_analysis/v_purchase_analysis_ii_detail_download', $this->data, true);
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

        
         $mpdf->showWatermarkText = true; 
        $organame = ORGA_NAME;
        $mpdf = new mPDF('utf-8', 'A4-L');
        $mpdf->SetAutoFont(AUTOFONT_ALL);
        $mpdf->SetWatermarkText($organame); 
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html);
        $output = 'all_purchase_item_'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }


	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */