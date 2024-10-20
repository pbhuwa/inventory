<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Issue_return_analysis extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('issue_return_analysis_mdl');
	}
	public function index()
	{ 
		$this->data['store_type']=$this->general->get_tbl_data('*','store',false,'st_store_id','ASC');
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

		$this->data['issue_report'] = "Issue_return_analysis";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('issue_report/v_issue_report', $this->data);

		/*$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('issue_return_analysis/v_issue_return_analysis_report', $this->data);*/
	}

	public function search_issue_return_list()
		{
			
			if(MODULES_VIEW=='N')
				{
				$array=array();
				 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
				exit;
				}
			
			
			$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		  	$i = 0;
		  	//echo"<pre>";print_r($this->input->get());die;
		  	$data = $this->issue_return_analysis_mdl->get_issue_analysis_lists();
		  	//echo"<pre>";print_r($data);die;
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
			   		$array[$i]['maty_material'] = $row->maty_material;
			   		$array[$i]['sub_category'] = $row->eqca_category;
			   		$array[$i]['dept_depname'] = $row->dept_depname;
			   		$array[$i]['rema_returndatebs'] = $row->rema_returndatebs;
			   		$array[$i]['invoiceno_1'] = $row->invoiceno_1;
			   		$array[$i]['rede_qty'] = $row->rede_qty;
			   		$array[$i]['rede_unitprice'] = $row->rede_unitprice;
			   		$array[$i]['amount'] = $row->amount;
			   		$array[$i]['rede_controlno'] = $row->rede_controlno;
			   		$array[$i]['rede_invoiceno'] = $row->rede_invoiceno;
				    $i++;
			    }
	        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
		}
		

	public function exportToExcel(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=issue_return_analysis_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        $data = $this->issue_return_analysis_mdl->get_issue_analysis_lists();
        $this->data['searchResult'] = $this->issue_return_analysis_mdl->get_issue_analysis_lists();
        //print_r($this->data['searchResult']);die;
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $response = $this->load->view('issue_return_analysis/v_issue_return_download', $this->data, true);


        echo $response;
    }
    public function generate_pdf()
    {
    	$this->data['searchResult'] = $this->issue_return_analysis_mdl->get_issue_analysis_lists();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        //pdf generation
        $html = $this->load->view('issue_return_analysis/v_issue_return_download', $this->data, true);
      	$filename = 'issue_return_analysis_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */