<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mrn_book extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('mrn_book_mdl');
		
	}
	public function index()
	{ 
		$this->data['mrn_type']='all';
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
			->build('mrn_book/v_mrn_book_main', $this->data);
	}

	public function mrn_book_list()
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
		  	$data = $this->mrn_book_mdl->get_purchase_mrn_list();
		  	// echo"<pre>";print_r($data);die;

			$array = array();
			$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
			$totalrecs = $data["totalrecs"];


		    unset($data["totalfilteredrecs"]);
		  	unset($data["totalrecs"]);
			foreach($data as $row)
			 {
		    	$array[$i]["viewurl"]=base_url().'purchase_receive/order_check/order_check_list_individual';
		    	 	$array[$i]["invoiceno"]=$row->recm_invoiceno;
					$array[$i]["receiveddatebs"]=$row->recm_receiveddatebs;
					$array[$i]["receiveddatead"]=$row->recm_receiveddatead;
					$array[$i]["purchaseorderno"]=$row->recm_purchaseorderno;
					$array[$i]["supplierbillno"]=$row->recm_supplierbillno;
					if(DEFAULT_DATEPICKER=='NP')
					{
						$array[$i]["supbilldatebs"]=$row->recm_supbilldatebs;
					}else
					{
						$array[$i]["supbilldatebs"]=$row->recm_supbilldatead;
					}
					$array[$i]["distributor"]=$row->dist_distributor;
					$array[$i]["amount"]=$row->recm_amount;
					$array[$i]["discount"]=$row->recm_discount;
					$array[$i]["taxamount"]=$row->recm_taxamount;
					$array[$i]["cleranceamount"]=$row->recm_clearanceamount;
					$array[$i]["enteredby"]=$row->usma_username;			   
			    $i++;
			}
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function mrn_book_lists_common()
	{
		$data = $this->mrn_book_mdl->get_purchase_mrn_list();
        $this->data['searchResult'] = $this->mrn_book_mdl->get_purchase_mrn_list();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $html = $this->load->view('mrn_book/v_mrn_book_download', $this->data, true);
        return $html;
	}
	public function exportToExcel(){
	        header("Content-Type: application/xls");    
	        header("Content-Disposition: attachment; filename=mrn_book_lists_".date('Y_m_d_H_i').".xls");  
	        header("Pragma: no-cache"); 
	        header("Expires: 0");
	        $response = $this->mrn_book_lists_common();
	        echo $response;
    }

    public function generate_pdf()
    {
        $html = $this->mrn_book_lists_common();
        $filename = 'mrn_details_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4'; //A4-L for landscape //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
    }
	/*
		Mrn book list supplier Start
	*/
	public function mrn_book_list_supplier()
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
	  	$data = $this->mrn_book_mdl->get_purchase_mrn_supplierwise_list();
	  	// echo $this->db->last_query();
	  	// echo"<pre>";print_r($data);die;

		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];


	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {
		    	$array[$i]["viewurl"]=base_url().'purchase_receive/order_check/order_check_list_individual';
				$array[$i]["distributor"]=$row->dist_distributor;
				$array[$i]["amount"]=round($row->amount,2);
				$array[$i]["discount"]=round($row->discount,2);
				$array[$i]["vat"]=round($row->vat,2);
				$array[$i]["netamount"]=round($row->netamount,2);
			   
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function supplierwise_mrn()
	{   
		// if(MODULES_VIEW=='N')
		// 	{
		// 	$array=array();
		// 	 // $this->general->permission_denial_message();
		// 	 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
		// 	exit;
		// 	}
		$this->data['mrn_type']='supplierwise';
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
			->build('mrn_book/v_mrn_book_main', $this->data);
	}
	public function supplier_common()
	{
		$this->data['searchResult'] = $this->mrn_book_mdl->get_purchase_mrn_supplierwise_list();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $html = $this->load->view('mrn_book/v_mrn_book_list_supplier_download', $this->data, true);
        return $html;
	}
	public function exportToExcelSupplierwise(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=Supplier_summary_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        $html = $this->supplier_common();
        if($html){
        	echo $html;
        }
        //$data = $this->mrn_book_mdl->get_purchase_mrn_supplierwise_list();
    }
    public function generateSupplierwisePdf()
    {
    	 $page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}

        $html = $this->supplier_common();
        $filename = 'Supplier_summary_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4'; //A4-L for landscape //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false, $pdfsize, $page_size);
        exit();
    }
    /*
		Mrn book list supplier Start
	*/
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */