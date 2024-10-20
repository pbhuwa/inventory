<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stock_verification extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('stock_verification_mdl');
		$this->load->Model('stock_requisition_mdl');
		$this->storeid = $this->session->userdata(STORE_ID);
		$this->locationid = $this->session->userdata(LOCATION_ID);
     	$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
	}


	public function index()
	{

		$this->data['department']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
			$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');

		// echo "<pre>";
		// print_r($this->data['store']);
		// die();

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
		
		$this->data['tab_type']="issue";


		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			// ->build('purchase_sale/v_purchase_sale', $this->data);
			->build('stock_verification/v_stock_verification_main', $this->data);
	}

	public function verification_purchase()
	{
		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
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
		
		$this->data['tab_type']="purchase";


		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			// ->build('purchase_sale/v_purchase_sale', $this->data);
			->build('stock_verification/v_stock_verification_main', $this->data);
	}



public function verification_stock_transfer()
	{
		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
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
		
		$this->data['tab_type']="transfer";


		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			// ->build('purchase_sale/v_purchase_sale', $this->data);
			->build('stock_verification/v_stock_verification_main', $this->data);
	}



public function verification_issue_return()
	{
			$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
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
		
		$this->data['tab_type']="issuereturn";


		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			// ->build('purchase_sale/v_purchase_sale', $this->data);
			->build('stock_verification/v_stock_verification_main', $this->data);
	}


public function verification_purchase_return()
	{
		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
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
		
		$this->data['tab_type']="purchasereturn";


		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			// ->build('purchase_sale/v_purchase_sale', $this->data);
			->build('stock_verification/v_stock_verification_main', $this->data);
	}



public function verification_stock_receive()
	{
			$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
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
		
		$this->data['tab_type']="stockreceive";


		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			// ->build('purchase_sale/v_purchase_sale', $this->data);
			->build('stock_verification/v_stock_verification_main', $this->data);
	}





public function issue_search()
{
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {


		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	  	$i = 0;
	  	$cond="";

	  	
	
		if($this->location_ismain  ==  'Y'){
				$data = $this->stock_verification_mdl->get_issue_serach();
		}
		else{
				$data = $this->stock_verification_mdl->get_issue_serach(array('sama_locationid'=>$this->locationid));
		}
  	
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
		    	if(ITEM_DISPLAY_TYPE=='NP'){
                	$rec_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
                }else{ 
                    $rec_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
                }


			   	$array[$i]["itemcode"] = $row->itli_itemcode;
			    $array[$i]["itemname"] =  $rec_itemname;
			    $array[$i]["unitname"] = $row->unit_unitname; 
			    $array[$i]["qty"] = $row->qty; 
			    $array[$i]["rate"] = number_format($row->rate,2); 

			    $array[$i]["amount"] =number_format(($row->qty*$row->rate),2); 

			   		   
			    $i++;
		    }
		   
		
		   
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
}


public function generate_issue_pdfDirect()
    {
    	if($this->location_ismain  ==  'Y'){
				$this->data['searchResult'] = $this->stock_verification_mdl->get_issue_serach();
		}
		else{
				$this->data['searchResult']= $this->stock_verification_mdl->get_issue_serach(array('itli_locationid'=>$this->locationid));
		}

        //$this->data['searchResult'] = $this->stock_verification_mdl->get_issue_serach();

        // echo "<pre>";
        // print_r( $this->data['searchResult']);
        // die();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $html = $this->load->view('stock_verification/v_issue_search_download', $this->data, true);
      	$filename = 'stock_verification_issue__'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
    }

    public function generate_issue_ExcelDirect()
    {
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_verification_issue_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

if($this->location_ismain =='Y'){
	 $data = $this->stock_verification_mdl->get_issue_serach();

        $this->data['searchResult'] = $this->stock_verification_mdl->get_issue_serach();
    }
    else{
    	$data = $this->stock_verification_mdl->get_issue_serach(array('itli_locationid'=>$this->locationid));

        $this->data['searchResult'] = $this->stock_verification_mdl->get_issue_serach(array('itli_locationid'=>$this->locationid));
    }
        
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('stock_verification/v_issue_search_download', $this->data, true);


        echo $response;
    }







public function purchase_search()
{
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	  	$i = 0;
	  	$cond="";

        if($this->location_ismain == 'Y'){
	      $data = $this->stock_verification_mdl->get_purchase_serach();

        }else{
	      $data = $this->stock_verification_mdl->get_purchase_serach(array('rm.recm_locationid'=>$this->locationid));
        } 

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

			   	$array[$i]["itemcode"] = $row->itli_itemcode;
			    $array[$i]["itemname"] = $rec_itemname;
			    $array[$i]["unitname"] = $row->unit_unitname; 
			    $array[$i]["qty"] = $row->rec_qty;
			    $array[$i]["rate"] = $row->recrate; 
			    $array[$i]["amount"] =number_format(($row->rec_qty*$row->recrate),2); 

			    $i++;
		    }
		   
		
		   
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
}


	public function generate_purchase_pdfDirect()
    {
    	if($this->location_ismain =='Y'){

    		   $this->data['searchResult'] = $this->stock_verification_mdl->get_purchase_serach();
    	}else{
    		$this->data['searchResult'] = $this->stock_verification_mdl->get_purchase_serach(array('itli_locationid'=>$this->locationid));
    	}

        

        // echo "<pre>";
        // print_r( $this->data['searchResult']);
        // die();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $html = $this->load->view('stock_verification/v_purchase_search_download', $this->data, true);
      	$filename = 'stock_verification_purchase_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
    }

    public function generate_purchase_ExcelDirect(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_verification_purchase_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        if($this->location_ismain =='Y'){

    		   $data = $this->stock_verification_mdl->get_purchase_serach();

        $this->data['searchResult'] = $this->stock_verification_mdl->get_purchase_serach();
    	}else{
    		$data = $this->stock_verification_mdl->get_purchase_serach(array('itli_locationid' =>$this->locationid));

        $this->data['searchResult'] = $this->stock_verification_mdl->get_purchase_serach(array('itli_locationid' =>$this->locationid));
    	}

        // $data = $this->stock_verification_mdl->get_purchase_serach();

        // $this->data['searchResult'] = $this->stock_verification_mdl->get_purchase_serach();
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('stock_verification/v_purchase_search_download', $this->data, true);


        echo $response;
    }


public function transfer_search()
	{
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {

		

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	  	$i = 0;
	  	$cond="";
	 //$data = $this->stock_verification_mdl->get_transfer_serach();
     // if($this->location_ismain == 'Y'){
        $data = $this->stock_verification_mdl->get_transfer_serach();

    //    }else{
	   // $data = $this->stock_verification_mdl->get_transfer_serach(array('trma_locationid'=>$this->locationid));
    //    }
  	
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
		    	if(ITEM_DISPLAY_TYPE=='NP'){
                	$rec_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
                }else{ 
                    $rec_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
                }

			   	$array[$i]["itemcode"] = $row->itli_itemcode;
			    $array[$i]["itemname"] = $rec_itemname;
			    $array[$i]["unitname"] = $row->unit_unitname; 
			    $array[$i]["qty"] = $row->rec_qty;
			    $array[$i]["rate"] = $row->recrate; 


			    $array[$i]["amount"] =number_format(($row->rec_qty*$row->recrate),2); 

			   		   
			    $i++;
		    }
		   
		
		   
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
}


public function generate_transfer_pdfDirect()
    {
    	if($this->location_ismain == 'Y'){
    		$this->data['searchResult'] = $this->stock_verification_mdl->get_transfer_serach();
    	}
    	else{
    		 $this->data['searchResult'] = $this->stock_verification_mdl->get_transfer_serach(array('itli_locationid'=>$this->locationid));
    	}
    	
       

        // echo "<pre>";
        // print_r( $this->data['searchResult']);
        // die();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $html = $this->load->view('stock_verification/v_transfer_search_download', $this->data, true);
      	$filename = 'stock_verification_transfer_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
    }

    public function generate_transfer_ExcelDirect(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_verification_transfer_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

		if($this->location_ismain=='Y'){
			$data = $this->stock_verification_mdl->get_transfer_serach();

		        $this->data['searchResult'] = $this->stock_verification_mdl->get_transfer_serach();
		}else{


		        $data = $this->stock_verification_mdl->get_transfer_serach(array('itli_locationid'=>$this->locationid));

		        $this->data['searchResult'] = $this->stock_verification_mdl->get_transfer_serach(array('itli_locationid'=>$this->locationid));
		}
       
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('stock_verification/v_transfer_search_download', $this->data, true);


        echo $response;
    }





public function issue_return_search()
	{
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {


		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	  	$i = 0;
	  	$cond="";
	
		if($this->location_ismain=='Y'){
			$data = $this->stock_verification_mdl->get_issue_return_serach();
		}else{
			$data = $this->stock_verification_mdl->get_issue_return_serach(array('rema_locationid'=>$this->locationid));

		}
  	
	  	// echo"<pre>";print_r($data);die;
	  	// echo $this->db->last_query();
	  	// die();
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

			   	$array[$i]["itemcode"] = $row->itli_itemcode;
			    $array[$i]["itemname"] = $rec_itemname;
			    $array[$i]["unitname"] = $row->unit_unitname; 
			    $array[$i]["qty"] = $row->rec_qty;
			    $array[$i]["rate"] = $row->recrate; 


			    $array[$i]["amount"] =number_format(($row->rec_qty*$row->recrate),2); 

			   		   
			    $i++;
		    }
		   
		
		   
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
}


public function generate_issue_return_pdfDirect()
    {
    		if($this->location_ismain=='Y'){
			 $this->data['searchResult'] = $this->stock_verification_mdl->get_issue_return_serach();
		}else{
			 $this->data['searchResult'] = $this->stock_verification_mdl->get_issue_return_serach(array('itli_locationid'=>$this->locationid));
			

		}
      

        // echo "<pre>";
        // print_r( $this->data['searchResult']);
        // die();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $html = $this->load->view('stock_verification/v_issue_return_search_download', $this->data, true);
      	$filename = 'stock_verification_issue_return_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
    }

    public function generate_issue_return_ExcelDirect(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_verification_issue_return_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

         if($this->location_ismain=='Y'){
         	$data = $this->stock_verification_mdl->get_issue_return_serach();

        $this->data['searchResult'] = $this->stock_verification_mdl->get_issue_return_serach();
          }else{

    	    $data = $this->stock_verification_mdl->get_issue_return_serach(array('itli_locationid'=>$this->locationid));

            $this->data['searchResult'] = $this->stock_verification_mdl->get_issue_return_serach(array('itli_locationid'=>$this->locationid));
          }
       
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('stock_verification/v_issue_return_search_download', $this->data, true);


        echo $response;
    }



public function purchase_return_search()
	{
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {

			// if(MODULES_VIEW=='N')
			// {
			// 	$array=array();
	
			// 	// $this->general->permission_denial_message();
			// 	 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			// 	exit;
			// }

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	  	$i = 0;
	  	$cond="";
	

    if($this->location_ismain == 'Y'){
    	$data = $this->stock_verification_mdl->get_purchase_return_serach();
    }else{

    	$data = $this->stock_verification_mdl->get_purchase_return_serach(array('itli_locationid'=>$this->locationid));
    }
  	
	  	// echo"<pre>";print_r($data);die;
	  	// echo $this->db->last_query();
	  	// die();
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

			   	$array[$i]["itemcode"] = $row->itli_itemcode;
			    $array[$i]["itemname"] = $rec_itemname;
			    $array[$i]["unitname"] = $row->unit_unitname; 
			    $array[$i]["qty"] = $row->rec_qty;
			    $array[$i]["rate"] = $row->recrate; 


			    $array[$i]["amount"] =number_format(($row->rec_qty*$row->recrate),2); 

			   		   
			    $i++;
		    }
		   
		
		   
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
}


public function generate_purchase_return_pdfDirect()
    {
    	if($this->location_ismain=='Y'){
    		$this->data['searchResult'] = $this->stock_verification_mdl->get_purchase_return_serach();
    	}else{
    		$this->data['searchResult'] = $this->stock_verification_mdl->get_purchase_return_serach(array('itli_locationid'=>$this->locationid));
    	}
        

        // echo "<pre>";
        // print_r( $this->data['searchResult']);
        // die();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $html = $this->load->view('stock_verification/v_purchase_return_search_download', $this->data, true);
      	$filename = 'stock_verification_purchase_return'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
    }



    public function generate_purchase_return_ExcelDirect(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_verification_purchase_return".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        if($this->location_ismain=='Y'){
        	$data = $this->stock_verification_mdl->get_purchase_return_serach();

        $this->data['searchResult'] = $this->stock_verification_mdl->get_purchase_return_serach();
        }else{

    	$data = $this->stock_verification_mdl->get_purchase_return_serach(array('itli_locationid'=>$this->locationid));

        $this->data['searchResult'] = $this->stock_verification_mdl->get_purchase_return_serach(array('itli_locationid'=>$this->locationid));
    }

        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('stock_verification/v_purchase_return_search_download', $this->data, true);


        echo $response;
    }



public function stock_receive_search()
{
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {

			// if(MODULES_VIEW=='N')
			// {
			// 	$array=array();
	
			// 	// $this->general->permission_denial_message();
			// 	 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			// 	exit;
			// }

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	  	$i = 0;
	  	$cond="";
	$data = $this->stock_verification_mdl->get_stock_receive_search();
     // if($this->location_ismain=='Y'){
     // 	$data = $this->stock_verification_mdl->get_stock_receive_search();
     // }else{
     // 	$data = $this->stock_verification_mdl->get_stock_receive_search(array('itli_locationid'=>$this->locationid));
     // }
  	
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
		    	if(ITEM_DISPLAY_TYPE=='NP'){
                	$rec_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
                }else{ 
                    $rec_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
                }
                
			   	$array[$i]["itemcode"] = $row->itli_itemcode;
			    $array[$i]["itemname"] = $rec_itemname;
			    $array[$i]["unitname"] = $row->unit_unitname; 
			    $array[$i]["qty"] = $row->rec_qty; 
			    $array[$i]["rate"] = $row->recrate; 
			    $array[$i]["amount"] =number_format(($row->rec_qty*$row->recrate),2); 

			   		   
			    $i++;
		    }
		   
		
		   
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
}


public function generate_stock_receive_pdfDirect()
    {
    	if($this->location_ismain=='Y'){
    		 $this->data['searchResult'] = $this->stock_verification_mdl->get_stock_receive_search();
    		}else{
    			 $this->data['searchResult'] = $this->stock_verification_mdl->get_stock_receive_search(array('itli_locationid'=>$this->locationid));
    		}
      

        // echo "<pre>";
        // print_r( $this->data['searchResult']);
        // die();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $html = $this->load->view('stock_verification/v_stock_receive_search_download', $this->data, true);
      	$filename = 'stock_verification_stock_receive_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
    }



    public function generate_stock_receive_ExcelDirect(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_verification_stock_receive".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        if($this->location_ismain=='Y'){
        	$data = $this->stock_verification_mdl->get_stock_receive_search();

        $this->data['searchResult'] = $this->stock_verification_mdl->get_stock_receive_search();
    }else{
    	$data = $this->stock_verification_mdl->get_stock_receive_search(array('itli_locationid'=>$this->locationid));

        $this->data['searchResult'] = $this->stock_verification_mdl->get_stock_receive_search(array('itli_locationid'=>$this->locationid));
    }

        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('stock_verification/v_stock_receive_search_download', $this->data, true);


        echo $response;
    }

}