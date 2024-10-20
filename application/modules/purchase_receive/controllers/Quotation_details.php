<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quotation_details extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();

		$this->load->Model('quotation_details_mdl');
		$this->load->Model('quotation_mdl');
	}
	public function index($type=false)
	{ 
		if($type=='quotation'){
			$vtype='Q';
		}elseif ($type=='tender') {
			$vtype='T';
		}
		$this->data['type']=$vtype;
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');

		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');

		// $this->data['fiscal_year'] = $this->general->getFiscalYear();

			$this->data['fiscal']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','ASC');

			// echo "<pre>";
			// print_r($this->data['fiscal']);
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



		$this->data['current_stock']='quotation_details';



		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			//->build('quotation_details/v_quotation_details', $this->data);

			->build('quotation/v_common_quotation_tab', $this->data);

	}

	
	public function quotation_approved($type=false)
	{
		if($type=='quotation'){
			$vtype='Q';
		}elseif ($type=='tender') {
			$vtype='T';
		}
		$this->data['type']=$vtype;
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');

		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');

		// $this->data['fiscal_year'] = $this->general->getFiscalYear();
		$this->data['fiscal']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','ASC');

		
			// echo "<pre>";
			// print_r($this->data['fiscal']);
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



		$this->data['current_stock']='quotation_review';



		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			//->build('quotation_details/v_quotation_details', $this->data);

			->build('quotation/v_common_quotation_tab', $this->data);

	}

	public function quotation_summary()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		  	//print_r($this->input->post());die();

		    $status_count = $this->quotation_details_mdl->getStatusCount();

		    // echo $this->db->last_query();

		    print_r(json_encode(array('status'=>'success','status_count'=>$status_count)));

		}

	}

	public function quotation_details_list($approvedonly =false)

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

	  	$cond = '';
	  	if(!empty($approvedonly))

	  	{

	  		$cond = array('qd.qude_approvestatus'=>"A");

	  	}
	  		
	  	$data = $this->quotation_details_mdl->get_quotation_details_list($cond);
	  	// echo $this->db->last_query();
	  	// die();
	  	// echo"<pre>";print_r($data);die;

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);

		$totalrecs = $data["totalrecs"];

		

		//'P' = 'Pending', 'RC' = received, 'RJ' =Rejected , 'FA' = 'Final Approved By Main Admin' 'A' approved

	        unset($data["totalfilteredrecs"]);

	  	    unset($data["totalrecs"]);

		  	foreach($data as $row)

		    {	
		    		if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
                }else{ 
                    $req_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
                }

		    	$appclass='';

				$approved=$row->qude_approvestatus;

		    	if($approved=='P')

		    	{

		    		$appclass='cancel';

		    	}

		    	if($approved=='A'){

		    		$appclass='approved';

		    	}

		    	if($approved=='FA'){

		    		$appclass='finalapproved';

		    	}

		    	if($approved=='RJ'){

		    		$appclass='rejected';

		    	}

		    	// $array[$i]["checkbox"]='<input type="checkbox" name="itemid[]" value="'.$row->qude_quotationdetailid.'" class="checkdtl" >';



		    	$array[$i]["approveclass"] = $appclass;

		   		$array[$i]["qdetailid"] = $row->qude_quotationdetailid;

		   		$array[$i]["itemsid"] = $row->itli_itemlistid;

		   		$array[$i]["code"] = $row->itli_itemcode;

		   		$array[$i]["itemsname"] = $req_itemname;

		   		$array[$i]["supplier"] = $row->supp_suppliername;

		   		if(DEFAULT_DATEPICKER == 'NP'){

		   			$array[$i]["quot_date"] = $row->quma_quotationdatebs;	

		   		}else{

		   			$array[$i]["quot_date"] = $row->quma_quotationdatead;

		   		}

			    $array[$i]["quot_no"] = $row->quma_quotationnumber;

			    $array[$i]["rate"] = $row->qude_rate;

			    $array[$i]["dis"] = $row->qude_discountpc;

			    $array[$i]["vat"] = $row->qude_vatpc;

			    $array[$i]["netrate"] = $row->qude_netrate;

			    $array[$i]["remarks"] = $row->quma_remarks;

			    $array[$i]["tilldate"] = $row->quma_expdatebs;

			    if($row->qude_approvestatus =="P")

			    {

			    	$headingtitle = "Quotation&nbsp;Approve";

			    }

			    elseif($row->qude_approvestatus == "A")

			    {

			    	$headingtitle = "Quotation&nbsp;Approve&nbsp;By&nbsp;Administrator";

			    }else{

			    	$headingtitle='Quotation&nbsp;Details';

				}

			    $array[$i]["action"] ='

			    <a href="javascript:void(0)" data-id="'.$row->quma_quotationmasterid.'" data-viewurl="'.base_url('purchase_receive/quotation_details/quotation_change_status').'" class="view" data-heading='.$headingtitle.' data-status="'.$row->qude_approvestatus.'"><i class="fa fa-check" title="Approve" aria-hidden="true" ></i></a>';



			    $i++;

		    }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}

	public function approved_status()

	{
		// print_r($this->input->post());die;

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				try{
					if(MODULES_APPROVE=='N')
					{
		 				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
						exit;
					}

					$this->form_validation->set_rules($this->quotation_details_mdl->validate_settings_approved_quotation);


					if($this->form_validation->run()==TRUE)
					{
						$approve = $this->quotation_details_mdl->approve_quotation_final();
						if($approve){
							print_r(json_encode(array('status'=>'success','message'=>'Item Approved Successfully')));
							exit;
						}else{
							print_r(json_encode(array('status'=>'error','message'=>'Operation Failed.')));
							exit;
						}
					}else{
						print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
						exit;
					}
				}catch(Exception $e){
					print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
				}
			}
		else{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
		}
	}

	public function quotation_change_status(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$mastid_id=$this->input->post('id');

			// $this->data['req_master'] = $this->general->get_tbl_data('*','qude_quotationdetail',array('qude_quotationdetailid'=>$mastid_id),'qude_quotationdetailid','DESC');

			$this->data['quotation_detail_list']=$this->quotation_mdl->get_all_quotation_details(array('qd.qude_quotationmasterid'=>$mastid_id));
			//echo "<pre>";print_r($this->data['req_detail_list']);die();
			$this->data['quotation_master']=$this->quotation_mdl->get_all_quotation(array('quma_quotationmasterid'=>$mastid_id));

			$tempform='';

			$tempform=$this->load->view('quotation_details/v_quotation_details_popup',$this->data,true);

			 if(!empty($tempform)){
			 	print_r(json_encode(array('status'=>'success','message'=>'View Open Success','tempform'=>$tempform)));
			 	exit;

			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));
				exit;
			}
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}

	}





	public function exportToExcel(){

        header("Content-Type: application/xls");    

        header("Content-Disposition: attachment; filename=quotation_details_".date('Y_m_d_H_i').".xls");  

        header("Pragma: no-cache"); 

        header("Expires: 0");

        $data = $this->quotation_details_mdl->get_quotation_details_list();

        $this->data['searchResult'] = $this->quotation_details_mdl->get_quotation_details_list();

 		unset($this->data['searchResult']['totalfilteredrecs']);

        unset($this->data['searchResult']['totalrecs']);

	    $response = $this->load->view('quotation_details/v_quotation_details_pdf', $this->data, true);

        echo $response;

    }

    public function generate_pdf()
	{

        $this->data['searchResult'] = $this->quotation_details_mdl->get_quotation_details_list();

        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $html = $this->load->view('quotation_details/v_quotation_details_pdf', $this->data, true);

        $filename = 'quotation_details_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);

        exit();

    }

}

/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */