<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Non_moving_items extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('non_moving_items_mdl');
		$this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		
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
		// 	->build('non_moving_items/v_non_moving_items', $this->data);
		
		$this->data['transfer_analysis'] = 'non_moving_items';
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('transfer_analysis/v_current_stock_details_main', $this->data);
	}

	public function non_moving_items_list()
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
	  	if($this->location_ismain=='Y'){
	  		$data = $this->non_moving_items_mdl->get_non_moving_items_list();

	  	}else{
	  		$data = $this->non_moving_items_mdl->get_non_moving_items_list(array('itli_locationid'=>$this->locationid));

	  	}
	  	
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
		   		// $array[$i]['viewurl']=base_url().'/stock_inventory/non_moving_items/load_non_moving_items';
		   		// $array[$i]["prime_id"] = $row->itemid;
		   		$array[$i]['itemcode'] = $row->itemcode;
		   		$array[$i]['itemname'] = $req_itemname;
		   		$array[$i]['stockqty'] = $row->stockqty;
		   		$array[$i]['totalamount'] = $row->totalamount;
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function exportToExcel(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=non_moving_items_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        
        $this->data['fromdate'] = !empty($_GET['frmDate'])?$_GET['frmDate']:CURDATE_NP;
        $this->data['todate'] = !empty($_GET['toDate'])?$_GET['toDate']:CURDATE_NP;

        if($this->location_ismain=='Y'){
        	 $data = $this->non_moving_items_mdl->get_non_moving_items_list();
        $this->data['searchResult'] = $this->non_moving_items_mdl->get_non_moving_items_list();
    }else{
    	 $data = $this->non_moving_items_mdl->get_non_moving_items_list();
        $this->data['searchResult'] = $this->non_moving_items_mdl->get_non_moving_items_list(array('itli_locationid'=>$this->locationid));
    }
        
       

        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
        
        $array = array();

        $response = $this->load->view('non_moving_items/v_non_moving_items_download', $this->data, true);

        echo $response;
    }

    public function generate_pdf()
    {
    	$this->data['fromdate'] = !empty($_GET['frmDate'])?$_GET['frmDate']:CURDATE_NP;
        $this->data['todate'] = !empty($_GET['toDate'])?$_GET['toDate']:CURDATE_NP;

        if($this->location_ismain=='Y'){
        	$this->data['searchResult'] = $this->non_moving_items_mdl->get_non_moving_items_list();
        }else{
        	$this->data['searchResult'] = $this->non_moving_items_mdl->get_non_moving_items_list(array('itli_locationid'=>$this->locationid));
        }

        
        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);

        $this->load->library('pdf');
        $mpdf = $this->pdf->load();

        ini_set('memory_limit', '256M');
        $html = $this->load->view('non_moving_items/v_non_moving_items_download', $this->data, true);
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
        $output = 'non_moving_items_'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }

    public function load_non_moving_items()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {	
				$id = $this->input->post('id');

				// echo $id;
				// die();
				$this->data['non_moving_items']= $this->non_moving_items_mdl->get_non_moving_items_by_id(array('mtd.trde_itemsid'=>$id));

				$tempform=$this->load->view('non_moving_items/v_non_moving_items_modal',$this->data,true);

				if(!empty($tempform))
				{
						print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$tempform)));
		            	exit;
				}
				else{
					print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));
		            	exit;
				}
			}
			catch (Exception $e) {
				print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
			}
		}else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */