<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pending_order_detail extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('pending_order_detail_mdl');
		
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
		$this->data['tab_type']='pending_order_detail';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('pending_order_detail/v_pending_common', $this->data);
	}

	public function pending_order_detail_form()
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

		$this->data['tab_type']='pending_order_detail';

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('pending_order_detail/v_pending_order_detail', $this->data);
	}

	public function pending_order_detail_list()
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
	  	$data = $this->pending_order_detail_mdl->get_pending_order_detail_list();

	  	// echo "<pre>";
	  	// print_r($data);
	  	// die();

		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {	
		    	if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($row->itemnamenp)?$row->itemnamenp:$row->itemname;
                }else{ 
                    $req_itemname = !empty($row->itemname)?$row->itemname:'';
                }
		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]['suppliers'] = $row->suppliername;
		   		$array[$i]['order_no'] = $row->orderno;
		   		$array[$i]['code'] = $row->itemcode;
		   		$array[$i]['name'] = $req_itemname;
		   		$array[$i]['order_qty'] = $row->quantity;
		   		$array[$i]['rem_qty'] = $row->remquantity;
		   		$array[$i]['rate'] = $row->rate;
		   		$array[$i]['vat_pc'] = $row->vat;
		   		$array[$i]['discount_pc'] = $row->discount;
		   		$array[$i]['amt'] = $row->purchaseamount;
		   		$array[$i]['order_date'] = $row->orderdate;
		   		$array[$i]['delivery_date'] = $row->deliverydate;
		   		$array[$i]['approved'] = $row->approvedby;
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function pending_order_common()
	{
		$this->data['excel_url'] = "purchase_receive/pending_order_detail/exportToExcel";
		$this->data['pdf_url'] = "purchase_receive/pending_order_detail/generate_pdf";
		$this->data['report_title'] = $this->lang->line('pending_order_detail');
		$this->data['searchResult'] = $this->pending_order_detail_mdl->get_pending_order_detail_list();
		unset($this->data['searchResult']["totalfilteredrecs"]);
		unset($this->data['searchResult']["totalrecs"]);
		$html = $this->load->view('pending_order_detail/v_pending_order_detail_pdf', $this->data, true);
        return $html;
	}
	public function exportToExcel(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=pending_order_detail_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
       	$html  = $this->pending_order_common();
        if($html)
        {
       		echo $html;
       	}
    }
    public function generate_pdf()
    { 	
    	$html  = $this->pending_order_common();
      	$filename = 'pending_order_detail_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */