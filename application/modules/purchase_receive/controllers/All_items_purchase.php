<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class All_items_purchase extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('all_items_purchase_mdl');
		
	}

	public function index()
	{ 
		$this->data['store_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');

		$seo_data='';
		if($seo_data)
		{	//set SEO data
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
			->build('all_item_purchase/v_all_itempurchase_report', $this->data);
	}

	public function search_allpurchase_item_list()
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
	  	$data = $this->all_items_purchase_mdl->get_allpurchase_item_lists();
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
                
		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]['itli_itemcode'] = $row->itli_itemcode;
		   		$array[$i]['itli_itemname'] = $req_itemname;
		   		$array[$i]['eqca_category'] = $row->eqca_category;
		   		$array[$i]['maty_material'] = $row->maty_material;
		   		$array[$i]['recd_purchasedqty'] = $row->recd_purchasedqty;
		   		$array[$i]['unit'] = $row->unit;
		   		$array[$i]['recd_amount'] = $row->recd_amount;
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function search_all_items_purchase()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	      	$this->data['fromdate'] = $this->input->post('fromdate');
            $this->data['todate'] = $this->input->post('todate');
	      	$this->data['purchase_allitem']=$this->all_items_purchase_mdl->get_allpurchase_item();
	      	//echo"<pre>";print_r($this->data['purchase_allitem']);die;
		    if($this->data['purchase_allitem'])
		    {
		    	$template=$this->load->view('all_item_purchase/v_all_item_purchase_temp',$this->data,true);
		    }
		    else
		    {
		        $template='<span class="col-sm-12 alert alert-danger text-center" style="margin-top: -25px;">No Record Found!!!</span>';
		    }
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function exportToExcel(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=all_purchase_item_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->all_items_purchase_mdl->get_allpurchase_item_lists();

        $this->data['searchResult'] = $this->all_items_purchase_mdl->get_allpurchase_item_lists();
        
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $response = $this->load->view('all_item_purchase/v_all_item_purchase_temp', $this->data, true);


        echo $response;
    }

    public function generate_pdf()
    {
        $this->data['searchResult'] = $this->all_items_purchase_mdl->get_allpurchase_item_lists();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $this->load->library('pdf');

        $mpdf = $this->pdf->load();
        //echo"<pre>";print_r($this->data['searchResult']);die;
        ini_set('memory_limit', '256M');

        $html = $this->load->view('all_item_purchase/v_all_item_purchase_temp', $this->data, true);
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
        $output = 'all_purchase_item_'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */