<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_detail extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('purchase_detail_mdl');
		
	}

	public function index()
	{ 
		$this->data['store_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');

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
		// 	->build('purchase_detail/v_purchase_detail', $this->data);
		$this->data['tab_type']='purchase_details';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('pending_order_detail/v_pending_common', $this->data);
	}

	public function purchase_detail_list()
	{
			if(MODULES_VIEW=='N')
				{
				$array=array();
				 // $this->general->permission_denial_message();
				 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
				exit;
				}
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			}
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
			
	  	$i = 0;
	  	$data = $this->purchase_detail_mdl->get_purchase_detail_list();
	  	// echo"<pre>";print_r($data);die;
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
		   		$array[$i]['date'] = $row->recm_receiveddatebs;
		   		$array[$i]['inv_no'] = $row->recm_invoiceno;
		   		$array[$i]['bill_no'] = $row->recm_supplierbillno;
		   		$array[$i]['item_code'] = $row->itli_itemcode;
		   		$array[$i]['item_name'] = $req_itemname;
		   		$array[$i]['mat_type'] = $row->materialtypename;
		   		$array[$i]['category'] = $row->categoryname;
		   		$array[$i]['supplier'] = $row->dist_distributor;
		   		$array[$i]['order_no'] = $row->recm_purchaseorderno;
		   		$array[$i]['qty'] = $row->recd_purchasedqty;
		   		$array[$i]['unit'] = $row->unit_unitname;
		   		$array[$i]['rate'] = $row->recd_unitprice; 
		   		$array[$i]['discount_pc'] = $row->recd_discountpc;
		   		$array[$i]['vat_pc'] = $row->recd_vatpc;
		   		$array[$i]['net_rate'] = $row->netrate;
		   		$array[$i]['net_amt'] = $row->recd_amount;
		   		$array[$i]['desc'] = $row->itli_remarks;
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function generate_pdfList()
    {
	    $html  = $this->purchase_report_common();
      	$filename = 'pending_order_detail_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; 
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();

    }

    public function exportToExcelList()
    {
	    header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=pending_order_detail_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
       	$html  = $this->purchase_report_common();
        if($html)
        {
       		echo $html;
       	}
    }

    public function purchase_report_common()
    {
    	$this->data['excel_url'] = "purchase_receive/demand_report/exportToExcelList";
		$this->data['pdf_url'] = "purchase_receive/demand_report/generate_pdfList";
		$this->data['report_title'] = $this->lang->line('purchase_detail');

		$this->data['searchResult'] = $this->purchase_detail_mdl->get_purchase_detail_list();

		unset($this->data['searchResult']["totalfilteredrecs"]);
		unset($this->data['searchResult']["totalrecs"]);
		//$html = $this->load->view('pending_order_detail/v_pending_order_detail_pdf', $this->data, true);
		$html = $this->load->view('purchase_detail/v_purchase_detail_list_download', $this->data, true);
        return $html;
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */