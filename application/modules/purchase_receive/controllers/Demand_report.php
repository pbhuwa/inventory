<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Demand_report extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('demand_report_mdl');
		
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
		// 	->build('demand_report/v_demand_report', $this->data);
		$this->data['tab_type']='demand_report';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('pending_order_detail/v_pending_common', $this->data);
	}

	public function demand_report_list()
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
	  	$data = $this->demand_report_mdl->get_demand_report_list();
	  	// echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {	
		    	if(ITEM_DISPLAY_TYPE=='NP'){
                	$rec_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
                }else{ 
                    $rec_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
                }

		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]["itemsid"] = $row->itli_itemlistid;
		   		$array[$i]["itemscode"] = $row->itli_itemcode;
		   		$array[$i]["itemsname"] = $rec_itemname;
		   		$array[$i]["demandqty"] = $row->demandqty;
			    $array[$i]["stockqty"] = $row->stockqty;
			    $array[$i]["diff"] = $row->diff;
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function exportToExcel()
	{
	    
	    header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=pending_order_detail_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
       	$html  = $this->demand_report_common();
        if($html)
        {
       		echo $html;
       	}
    }
    public function generate_pdf()
    {
        $html  = $this->demand_report_common();
      	$filename = 'pending_order_detail_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
    }

    public function demand_report_common()
    {
    	$this->data['excel_url'] = "purchase_receive/demand_report/exportToExcel";
		$this->data['pdf_url'] = "purchase_receive/demand_report/generate_pdf";
		$this->data['report_title'] = $this->lang->line('demand_report');

		$this->data['searchResult'] = $this->demand_report_mdl->get_demand_report_list();

		unset($this->data['searchResult']["totalfilteredrecs"]);
		unset($this->data['searchResult']["totalrecs"]);
		//$html = $this->load->view('pending_order_detail/v_pending_order_detail_pdf', $this->data, true);
		$html = $this->load->view('demand_report/v_demand_report_pdf', $this->data, true);
        return $html;
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */