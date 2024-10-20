<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Closing_stock extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('closing_stock_mdl');
		$this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
	}
	public function index()
	{  
		$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
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
			->build('closing_stock/v_closing_stock', $this->data);
	}
	public function generate_closing_stock()
	{
		$this->data['tab_type'] = 'closingdata';
		$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
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
			->build('closing_stock/v_closing_stock', $this->data);
	}
	public function lists()
	{
		$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		$this->data['closing_details']=$this->general->get_tbl_data('*','clsm_closingstockmaster',false,'clsm_csmasterid','ASC');
		$this->data['tab_type'] = 'lists';
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
			->build('closing_stock/v_closing_stock', $this->data);
	}


	public function save_genreating_stock()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			if($this->input->post('id'))
				{
					if(MODULES_UPDATE=='N')
					{
						$this->general->permission_denial_message();
						exit;
					}
				}
				else
				{
					if(MODULES_INSERT=='N')
					{
						$this->general->permission_denial_message();
						exit;
					}
				}

			try {
				$trans = $this->closing_stock_mdl->generate_closing_stock_record();
				//echo"<pre>";print_r($trans);die;
				if($trans)
				{
					print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
				exit;
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>'Record Save Unsuccessfully')));
					exit;
				}
			} catch (Exception $e) {
			
				print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
			}
		}else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}
	// public function list_stocktransfer()
	// {
	// 	if ($_SERVER['REQUEST_METHOD'] === 'POST')
		 //        {
		 //            $id=$this->input->post('id');
		 //            $this->data['closing_details']=$this->general->get_tbl_data('*','csde_closingstockdetail',false,'eqty_equipmenttypeid','ASC');
		 //            $tempform='';
		 //            $tempform =$this->load->view('',$this->data,true);
		 //            if(!empty($this->data['staff_data']))
		 //            {
		 //            	print_r(json_encode(array('status'=>'success','message'=>'You Can View','tempform'=>$tempform)));

		 //            	exit;

		 //            }

		 //            else{

		 //            print_r(json_encode(array('status'=>'error','message'=>'')));

		 //            exit;

		 //            }

		 //            }

		 //            else

		 //            {

		 //            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

		 //            exit;

		 //            }

	// }

	public function closing_stock_lists()
	{   
		// echo MODULES_VIEW;
		// die();

		if(MODULES_VIEW=='N')
			{
			$array=array();
			 // $this->general->permission_denial_message();
			 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
			}

		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	  	$i = 0;
        $data = $this->closing_stock_mdl->get_closing_details_data();

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
    			$array[$i]["csde_purchasedqty"]=!empty($row->csde_purchasedqty)?$row->csde_purchasedqty:'';
    	 		$array[$i]["csde_purchasedvalue"]=!empty($row->csde_purchasedvalue)?$row->csde_purchasedvalue:'';
	    	 	$array[$i]["csde_preturnvalue"]=!empty($row->csde_preturnvalue)?$row->csde_preturnvalue:'';
	    	 	$array[$i]["unit_unitname"]=!empty($row->unit_unitname)?$row->unit_unitname:'';
	    	 	$array[$i]["eqty_equipmenttype"]=!empty($row->eqty_equipmenttype)?$row->eqty_equipmenttype:'';
	    	 	$array[$i]["itli_itemname"]=$req_itemname;
	    	 	$array[$i]["itli_itemcode"]=!empty($row->itli_itemcode)?$row->itli_itemcode:'';
	    	 	$array[$i]["csde_soldqty"]=!empty($row->csde_soldqty)?$row->csde_soldqty:'';
	    	 	$array[$i]["csde_soldvalue"]=!empty($row->csde_soldvalue)?$row->csde_soldvalue:'';
	    	 	$array[$i]["csde_soldpurvalue"]=!empty($row->csde_soldpurvalue)?$row->csde_soldpurvalue:'';
	    	 	$array[$i]["csde_sreturnqty"]=!empty($row->csde_sreturnqty)?$row->csde_sreturnqty:'';
	    	 	$array[$i]["csde_sreturnvalue"]=!empty($row->csde_sreturnvalue)?$row->csde_sreturnvalue:'';
	    	 	$array[$i]["csde_sreturnpvalue"]=!empty($row->csde_sreturnpvalue)?$row->csde_sreturnpvalue:'';
	    	 	$array[$i]["csde_stockqty"]=!empty($row->csde_stockqty)?$row->csde_stockqty:'';
	    	 	$array[$i]["csde_stockvalue"]=!empty($row->csde_stockvalue)?$row->csde_stockvalue:'';
	    	 	$array[$i]["csde_issueqty"]=!empty($row->csde_issueqty)?$row->csde_issueqty:'';
	    	 	$array[$i]["csde_issueamount"]=!empty($row->csde_issueamount)?$row->csde_issueamount:'';
	    	 	$array[$i]["csde_receivedqty"]=!empty($row->csde_receivedqty)?$row->csde_receivedqty:'';
	    	 	$array[$i]["csde_receivedamnt"]=!empty($row->csde_receivedamnt)?$row->csde_receivedamnt:'';
	    	 	$array[$i]["csde_openingqty"]=!empty($row->csde_openingqty)?$row->csde_openingqty:'';
	    	 	$array[$i]["csde_openingamt"]=!empty($row->csde_openingamt)?$row->csde_openingamt:'';
	    	 	$array[$i]["csde_curopeningqty"]=!empty($row->csde_curopeningqty)?$row->csde_curopeningqty:'';
	    	 	$array[$i]["csde_curopeningamt"]=!empty($row->csde_curopeningamt)?$row->csde_curopeningamt:'';
	    	 	$array[$i]["csde_transactionqty"]=!empty($row->csde_transactionqty)?$row->csde_transactionqty:'';
	    	 	$array[$i]["csde_transactionvalue"]=!empty($row->csde_transactionvalue)?$row->csde_transactionvalue:'';
	    	 	$array[$i]["csde_adjqty"]=!empty($row->csde_adjqty)?$row->csde_adjqty:'';
	    	 	$array[$i]["csde_adjvalue"]=!empty($row->csde_adjvalue)?$row->csde_adjvalue:'';
	    	 	$array[$i]["csde_mtdqty"]=!empty($row->csde_mtdqty)?$row->csde_mtdqty:'';
	    	 	$array[$i]["csde_conqty"]=!empty($row->csde_conqty)?$row->csde_conqty:'';
	    	 	$array[$i]["csde_convalue"]=!empty($row->csde_convalue)?$row->csde_convalue:'';
	    	 	$array[$i]["csde_incconqty"]=!empty($row->csde_incconqty)?$row->csde_incconqty:'';
	    	 	$array[$i]["csde_returnqty"]=!empty($row->csde_returnqty)?$row->csde_returnqty:'';
				$array[$i]["purd_qty"]=!empty($row->purd_qty)?$row->purd_qty:'';
    	 		$array[$i]["clsm_username"]=!empty($row->clsm_username)?$row->clsm_username:'';
    	 		$array[$i]["csde_incconvalue"]=!empty($row->csde_incconvalue)?$row->csde_incconvalue:'';
    	 		$array[$i]["csde_mtdvalue"]=!empty($row->csde_mtdvalue)?$row->csde_mtdvalue:'';
    	 		$array[$i]["csde_challanqty"]=!empty($row->csde_challanqty)?$row->csde_challanqty:'';
				$i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}


	public function closing_stock_details_pdf()
    {
    	if($this->location_ismain=='Y'){
    		$this->data['searchResult'] = $this->closing_stock_mdl->get_closing_data_pdf();
    	}else{
    		$this->data['searchResult'] = $this->closing_stock_mdl->get_closing_data_pdf(array('csde_locationid'=>$this->locationid));
    		// print_r($this->data['searchResult']);
    		// die();
    	}
         
        $html = $this->load->view('closing_stock/v_closing_stock_download', $this->data, true);
        //echo"<pre>"; print_r($html);die;
      	$filename = 'closing_stock_summary_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
         exit();
    }
}