<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_order_details extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('purchase_order_details_mdl');
	}

	public function index()
	{ 
		$this->data['supplier']=$this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');
		$this->data['material_type']=$this->general->get_tbl_data('*','maty_materialtype',array('maty_isactive'=>'Y'),'maty_materialtypeid','ASC');

		
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

		$this->data['current_tab']='purchase_order_details';

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('purchase_order/v_common_purchaseorder_tab', $this->data);
	}

	public function purchase_order_details_list()
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
	  	$data = $this->purchase_order_details_mdl->get_purchase_order_details_list();
	  	// echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {	
		    	if(ITEM_DISPLAY_TYPE=='NP'){
                	$ord_itemname = !empty($row->itemnamenp)?$row->itemnamenp:$row->itemname;
                }else{ 
                    $ord_itemname = !empty($row->itemname)?$row->itemname:'';
                }

		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]['orderdatebs'] = $row->orderdatebs;
		   		$array[$i]['itemcode'] = $row->itemcode;
		   		$array[$i]['itemname'] = $ord_itemname;
		   		$array[$i]['materialname'] = $row->materialname;
		   		$array[$i]['category'] = $row->category;
		   		$array[$i]['suppliername'] = $row->suppliername;
		   		$array[$i]['orderno'] = $row->orderno;
		   		$array[$i]['quantity'] = sprintf('%g',$row->quantity);
		   		$array[$i]['unit'] = $row->unit;
		   		$array[$i]['rate'] = $row->rate;
		   		$array[$i]['discount'] = $row->discount;
		   		$array[$i]['vat'] = $row->vat;
		   		$array[$i]['amount'] = $row->amount;
		   		$array[$i]['remarks'] = $row->remarks;
		   		$array[$i]['requno'] = $row->requno;
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function exportToExcel(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=purchase_order_details_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->purchase_order_details_mdl->get_purchase_order_details_list();

        $this->data['searchResult'] = $this->purchase_order_details_mdl->get_purchase_order_details_list();
        
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $response = $this->load->view('purchase_order_details/v_purchase_order_details_download', $this->data, true);


        echo $response;
    }

    public function generate_pdf()
    {

    	$page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}

        $this->data['searchResult'] = $this->purchase_order_details_mdl->get_purchase_order_details_list();

         // echo "<pre>";
         // echo $this->data['searchResult'];
         // echo "</pre>";
         // die();

        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
      
        // $this->load->library('pdf');

        // $mpdf = $this->pdf->load();
        // // echo"<pre>";print_r($this->data['searchResult']);die;
        // ini_set('memory_limit', '256M');

        if(ORGANIZATION_NAME=='KU') {
    		 // echo "ku";
    		 // die();
        	$html = $this->load->view('purchase_order_details/ku/v_purchase_order_details_download', $this->data, true);
    	}
    	else
    	{

             $html = $this->load->view('purchase_order_details/v_purchase_order_details_download', $this->data, true);
       
    	}

        $output = 'purchase_order_details_'.date('Y_m_d_H_i').'.pdf';
        
        $this->general->generate_pdf($html, '' ,$page_size);
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */