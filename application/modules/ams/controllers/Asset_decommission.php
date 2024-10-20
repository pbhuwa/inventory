<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asset_decommission extends CI_Controller 
{

	function __construct() 
	{
		parent::__construct();
			$this->load->model('assets_mdl');
			$this->load->model('assets_decommision_mdl');
			$this->load->Model('settings/department_mdl','department_mdl');
			$this->load->Model('biomedical/bio_medical_mdl');
			$this->load->Model('biomedical/manufacturers_mdl');
			$this->load->Model('biomedical/equipment_mdl');
	}
	public function index()
    {
		$this->page_title='Bio-medical Assets Decommission';
	 	$this->data['breadcrumb']='';
	 	$this->data['tab_type']='dec';
    	$this->template
				->set_layout('general')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('assets_decommission/v_assets_decommission',$this->data);
    }

    public function get_dec_assets_details()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$this->data['listurl']=base_url().'assets/asset_decommission/reload_decom';
			$this->data['tab_type']='dec';

			$equid_key = $this->input->post('id');
			
			$this->data['eqli_data'] = $this->assets_mdl->get_all_assets(array('ae.asen_assetcode'=>$equid_key));

			if($this->data['eqli_data'])
			{
			$equid=$this->data['eqli_data'][0]->asen_asenid;
			$orgid = $this->session->userdata(ORG_ID);

			$this->data['equip_comment'] = $this->assets_mdl->get_assets_comment(array('ec.eqco_orgid'=>$orgid));
			// print_r($this->data['equip_comment']);
			// die();
			$this->data['method']=$this->assets_decommision_mdl->get_method();
			$this->data['decom_data']=$this->assets_decommision_mdl->get_decommission_list();
			//echo "<pre>"; print_r($this->data['decom_data']); die;

			$template=$this->load->view('assets_decommission/v_assets_decommission_form',$this->data,true);
			 // echo $template;
			 // die();

			print_r(json_encode(array('status'=>'success','tempform'=>$template,  'message'=>'Successfully Selected!!')));
		       		exit;	
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>'No record Found!!')));
		       		exit;	
				}
		}else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
    }

	public function save_decommission()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id=$this->input->post('id');
			try {
				if($id)
				{
					$this->data['decom_data']=$this->assets_decommision_mdl->get_decommission_list(array('de.deeq_decommissionid'=>$id));
					// echo "<pre>";
					// print_r($data['dept_data']);
					// die();
					if($this->data['decom_data'])
					{
						$p_date=$this->data['decom_data'][0]->itli_postdatead;
						$p_time=$this->data['decom_data'][0]->itli_posttime;
						$editstatus=$this->general->compute_data_for_edit($p_date,$p_time);
						$usergroup=$this->session->userdata(USER_GROUPCODE);
				
						if($editstatus==0 && $usergroup!='SA' )
						{
					   		$this->general->disabled_edit_message();

						}
					}
				}
			
					$trans = $this->assets_decommision_mdl->save_decommission();
            		if($trans)
            		{
            	  		print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
            			exit;
            		}
            		else
            		{
            	 		print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
            			exit;
            		}
        		
        	} catch (Exception $e) {
          		print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
        	}
    	}
 		else
    	{
    		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
    	}
	}

	public function reload_decom()
	{
		$this->data['decom_data']=$this->assets_decommision_mdl->get_decommission_list();

		$template=$this->load->view('assets_decommission/v_decommission_list',$this->data,true);

		print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

   		 exit;
	}

	public function decommission_delete()
    {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
			$id=$this->input->post('id');


			$trans=$this->assets_decommision_mdl->delete_decommission();
			if($trans)
			{
				print_r(json_encode(array('status'=>'success','message'=>'Successfully Deleted!!')));
	       		 exit;	
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Error while deleting!!')));
	       		 exit;	
			}

		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function generate_pdfDirect()
    {
        $this->data['searchResult'] = $this->assets_decommision_mdl->get_decommission_from_inventory();

        // echo "<pre>";
        // print_r( $this->data['searchResult']);
        // die();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $html = $this->load->view('assets_decommission/v_assets_decommission_list_download', $this->data, true);
      	$filename = 'direct_purchase_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
    }

public function exportToExcelDirect()
    {
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=assets_list".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->assets_decommision_mdl->get_decommission_from_inventory();

        $this->data['searchResult'] = $this->assets_decommision_mdl->get_decommission_from_inventory();
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('assets_decommission/v_assets_decommission_list_download', $this->data, true);

        echo $response;
    }


	public function decommission_from_inventory(){	
		if(MODULES_VIEW=='N')
		{
			$array=array();

			// $this->general->permission_denial_message();
			 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
		}
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	  	$i = 0;
	  	$data = $this->assets_decommision_mdl->get_decommission_from_inventory();
	  	// echo $this->db->last_query();die();
	 	//echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {
		    	$array[$i]["asen_assetcode"] = $row->asen_assetcode;
		    	$array[$i]["deeq_postdatead"] = $row->deeq_postdatead;
		    	$array[$i]["deeq_postdatebs"] = $row->deeq_postdatebs;
			   	$array[$i]["deeq_posttime"] = $row->deeq_posttime;
			   	$array[$i]["deeq_reason"]=$row->deeq_reason;
			    $array[$i]["deme_decomname"] = $row->deme_decomname;
			    $array[$i]["deeq_disposition"] = $row->deeq_disposition;
			    $array[$i]["action"] = '<a href="javascript:void(0)" data-id='.$row->deeq_decommissionid.' data-displaydiv="" data-viewurl='.base_url('ams/asset_insurance/delete_asset_insurance').' class="btnDelete" data-heading="'.$row->asen_assetcode.'" data-id="'.$row->deeq_decommissionid.'"><i class="fa fa-trash" title="Delete" aria-hidden="true" ></i></a>';
			  
			    $i++;
		    }
		    //echo"<pre>";print_r($data);die;
		    $get = $_GET;
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}


}