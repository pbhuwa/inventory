<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Receiver_wise_issue extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('receiver_wise_issue_mdl');
	}
	public function index()
	{ 
		$this->data['store_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		$this->data['maty_materialtype']=$this->general->get_tbl_data('*','maty_materialtype',false,'maty_materialtypeid','ASC');
		$this->data['department']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','ASC');
		

		$this->data['eqcaequipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'','ASC');


		$this->data['current_stock']='summary';
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
			->build('receiver_wise_issue/v_receiver_wise_issue_details', $this->data);
	}
	public function search_receiver_wise_issue_list()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(MODULES_VIEW=='N')
			{
			$array=array();
			
			 // $this->general->permission_denial_message();
			 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
			}
		}
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
	  	$i = 0;

	  	$data = $this->receiver_wise_issue_mdl->get_receiver_wise_issue_lists();
	  	//echo"<pre>";print_r($data);die;
	  	// echo $this->db->last_query();
	  	// die();
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  	
		  	foreach($data as $row)
		    {	
		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]['itli_itemcode'] = $row->itli_itemcode;
		   		$array[$i]['itli_itemname'] = $row->itli_itemname;
		   		$array[$i]['sama_receivedby'] = $row->sama_receivedby;
		   		$array[$i]['dept_depname'] = $row->dept_depname;
		   		$array[$i]['unit_unitname'] = $row->unit_unitname;
		   		$array[$i]['issueqty'] = $row->issueqty;
		   		
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function pending_common()
	{
		$this->data['excel_url'] = "issue_consumption/report/search_categorywise_issue_excel";
		$this->data['pdf_url'] = "issue_consumption/report/search_categorywise_issue_pdf";
		unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $this->data['searchResult'] = $this->receiver_wise_issue_mdl->get_receiver_wise_issue_lists();
        $html = $this->load->view('receiver_wise_issue/v_current_stock_details_download', $this->data, true);
        return $html;
	}
	
	public function exportToExcel($details=false){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=receiver_wise_issue_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        $response = $this->pending_common();
		if($response){
        	echo $response;	
        }
        return false;
    }
    public function generate_details_pdf($details=false)
    {	
    	$html = $this->pending_common();
        $filename = 'receiver_wise_issue_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4'; //A4-L for landscape //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
    	exit();
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */