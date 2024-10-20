<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stock_adjustment extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('stock_adjustment_mdl');
		$this->locationid=$this->session->userdata(LOCATION_ID);
		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
	}
	public function index()
	{
		

        $this->data['equipmnt_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttypeid', 'ASC');
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

		$this->data['tab_selector'] = 'entry';
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			// ->build('stock_adjustment/stock_adjustment_main', $this->data);
			->build('stock_adjustment/v_stock_adjustment_common_tab', $this->data);

	}


	public function stock_adjustment_list()
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
	  		$data = $this->stock_adjustment_mdl->get_stock_adjustment_list();
	  		}else{
	  			$data = $this->stock_adjustment_mdl->get_stock_adjustment_list(array('stma_locationid'=>$this->locationid));
	  		}
	  
	  	//echo"<pre>";print_r($data);die;

		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];


	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);

		foreach($data as $row)
		 {
		    $array[$i]["stockmassterid"]=$row->stma_stockmassterid;
            $array[$i]["stockdatebs"]=$row->stma_stockdatebs;
            $array[$i]["stockdatead"]=$row->stma_stockdatead;
            $array[$i]["equipmenttype"]=$row->eqty_equipmenttype;
            $array[$i]["remarks"]=$row->stma_remarks;
            $array[$i]["operator"]=$row->stma_operator;
            $array[$i]["counterid"]=$row->stma_counterid;
            $array[$i]["viewurl"]=base_url() . '/stock_inventory/stock_adjustment/stock_adjustment_detail';
            $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function stock_adjustment_generate_pdf()
	{	
		
      	$this->data['fromdate'] = $this->input->post('fromdate');
    	$this->data['todate'] = $this->input->post('todate');

    	if($this->location_ismain=='Y'){
    		$this->data['searchResult']=$this->stock_adjustment_mdl->get_stock_adjustment_list();
    	}else{
    		$this->data['searchResult']=$this->stock_adjustment_mdl->get_stock_adjustment_list(array('stma_locationid'=>$this->locationid));
    	}
    	
    	
    	unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $stylesheet='';
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        ini_set('memory_limit', '256M');
        $html = $this->load->view('stock_adjustment/v_stock_adjustment_list_download', $this->data, true);
        $mpdf = new mPDF('c', 'A4-L'); 
        $mpdf->showWatermarkText = true;  
        $mpdf->SetWatermarkText(ORGA_NAME);
        $mpdf->SetWatermarkImage(PDF_WATERMARK);
        $mpdf = new mPDF('utf-8', 'A4-L');
        $mpdf->SetAutoFont(AUTOFONT_ALL);
        $mpdf->showWatermarkImage = true;
		$mpdf->showWatermarkImage = true;
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html);
        $output = 'stock_adjustment_list_.pdf';
        $mpdf->Output();
        exit();
	}
	public function exportToExcel(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_adjustment_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        
        if($this->location_ismain=='Y'){
        	$data = $this->stock_adjustment_mdl->get_stock_adjustment_list();
        }else{
        	$data = $this->stock_adjustment_mdl->get_stock_adjustment_list(array('stma_locationid'=>$this->locationid));
        }
        
        
        $array = array();
        unset($data["totalfilteredrecs"]);
        unset($data["totalrecs"]);
        // $response = '<table border="1px">';
        $response = '<table width="100%" style="font-size:12px;" class="format_pdf_head">';
        $response.='<tr>';
        // $response.='<td width="25%"></td>';
        $response.='<td colspan=6 style="text-align: center;"><h3 style="color:#101010;margin-bottom: 0px;"><B><span class="'.FONT_CLASS.'" >'.ORGNAMETITLE.'</span></B></h3></td>';
        // $response.='<td width="25%"></td>';
        $response.='</tr>';
        $response.='<tr>';
        // $response.='<td colspan=2 width="25%"></td>';
        $response.='<td colspan=6 style="text-align: center;"><h3 style="color:#101010;margin-bottom: 0px;"><B><span class="'.FONT_CLASS.'" >'.ORGNAME.'</span></B></h3></td>';
        // $response.='<td width="25%"></td>';
        $response.='</tr>';
        $response.='<tr>';
        // $response.='<td  width="25%"></td>';
        $response.='<td colspan=6 style="text-align: center;"><h4 style="margin:0px;">'.ORGNAMEDESC.'</h4></td>';
        $response.='<td width="15%" style="text-align:right; font-size:10px;">'.$this->lang->line('date_time').': '.CURDATE_NP.' BS,</td>';
        $response.='</tr>';
        $response.='<tr class="title_sub">';
        //$response.='<td width="25%"></td>';
        $response.='<td colspan=6 style="text-align: center;"><b><font color="black"><span class="'.FONT_CLASS.'" >'.LOCATION.'</span></font></b></td>';
        $response.='<td width="15%" style="text-align:right; font-size:10px;">'.CURDATE_EN.' AD </td>';
        $response.='</tr>';
        $response.='</table><br>';
               


        
        $response.='<table>';
        $response .= '<tr><th colspan="6"><center><u>'.$this->lang->line('stock_adjustment').'</u></center></th></tr>';
        $response.='</table><br><table>';
        $response .= '<tr><th >'.$this->lang->line('sn').'</th>
                     <th>'.$this->lang->line('stock_date_bs').'</th>
                     <th>'.$this->lang->line('stock_date_ad').'</th>
                    <th>'.$this->lang->line('counter').'</th>
                    <th>'.$this->lang->line('remarks').'</th>
                    <th>'.$this->lang->line('operator').'</th></tr>';

        $i=1;
        $iDisplayStart = !empty($_GET['iDisplayStart'])?$_GET['iDisplayStart']:0;
        foreach($data as $row){
            $sno = $iDisplayStart + $i; 
            $stockdatebs=$row->stma_stockdatebs;
            $stockdatead=$row->stma_stockdatead;
            $equipmenttype=$row->eqty_equipmenttype;
            $remarks=$row->stma_remarks;
            $operator=$row->stma_operator;
            $counterid=$row->stma_counterid;

            $response .= '<tr><td>'.$sno.'</td><td>'.$stockdatebs.'</td><td>'.$stockdatead.'</td><td>'.$equipmenttype.'</td><td>'.$operator.'</td><td>'.$operator.'</td></tr>';
            $i++;
        }
        
        $response .= '</table>';

        echo $response;
    }

    public function save_stock_adjustment()
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
			$id=$this->input->post('id');
			// if($id)
			// {
			// 		$this->data['item_data']=$this->stock_adjustment_mdl->get_all_itemlist(array('it.itli_itemlistid'=>$id));
			// 	// echo "<pre>";
			// 	// print_r($data['dept_data']);
			// 	// die();
			// if($this->data['item_data'])
			// {
			// 	$p_date=$this->data['item_data'][0]->itli_postdatead;
			// 	$p_time=$this->data['item_data'][0]->itli_posttime;
			// 	$editstatus=$this->general->compute_data_for_edit($p_date,$p_time);
			// 	$usergroup=$this->session->userdata(USER_GROUPCODE);
				
			// 	if($editstatus==0 && $usergroup!='SA' )
			// 	{
			// 		   $this->general->disabled_edit_message();

			// 	}

			// }
			// }

			$this->form_validation->set_rules($this->stock_adjustment_mdl->validate_settings_stock_adjust);
			// }
			
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->stock_adjustment_mdl->stock_adjustment_save();
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
        }
        else
		{
			print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
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

	public function form_stock_adjustment()
	{
	  	 $this->data['equipmnt_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttypeid', 'ASC');
			$this->load->view('stock_adjustment/stock_adjustment_form',$this->data);

	}

	public function form_stock_adjustment_entry()
	{
		$this->data['equipmnt_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttypeid', 'ASC');
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

		$this->data['tab_selector'] = 'entry';
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('stock_adjustment/stock_adjustment_main', $this->data);
	}

	public function stock_adjustment_detail()
	{
		if ($this->input->post('stockmassterid'))
			$masterid = $this->input->post('stockmassterid');
		else 
			$masterid='';

		if ($this->input->post('stockmassterid'))
			$this->data['masterid']=$this->input->post('stockmassterid');
		else
			$this->data['masterid']='';
		$this->data['details'] = $this->stock_adjustment_mdl->get_details_list(array('sd.stde_stockmasterid'=>$masterid));
			//echo"<pre>";print_r($this->data['details']);die;
		$this->data['equipmnt_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttypeid', 'ASC');
		$this->data['equipmnt_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttypeid', 'ASC');
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

		$this->data['tab_selector'] = 'details';
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			// ->build('stock_adjustment/stock_adjustment_detail_main', $this->data);
			->build('stock_adjustment/v_stock_adjustment_common_tab', $this->data);
	}
	public function details()
	{
				
			$masterid = $this->input->post('stockmassterid');
			$this->data['masterid']=$this->input->post('stockmassterid');
			$this->data['details'] = $this->stock_adjustment_mdl->get_details_list(array('sd.stde_stockmasterid'=>$masterid));
			//echo"<pre>";print_r($this->data['details']);die;
			$this->data['equipmnt_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttypeid', 'ASC');
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
				->build('stock_adjustment/stock_adjustment_detail_main', $this->data);
	}

	public function save_details()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_INSERT=='N')
					{
						$this->general->permission_denial_message();
						exit;
					}

			try {
				$this->form_validation->set_rules($this->stock_adjustment_mdl->validate_settings_details);
			    if($this->form_validation->run()==TRUE)
			 	{
			 		//echo"<pre>";print_r($this->input->post()); die;
            		$trans = $this->stock_adjustment_mdl->stock_details_save();
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
	       		}
        		else
				{
					print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
					exit;
				}
			} catch (Exception $e) {
          
	            print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
	        }
	    }else
	    {
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
	    }
	}
	public function stock_adjustment_details_list($mast=false)
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

	  	if($this->location_ismain=='Y'){
	  		$data = $this->stock_adjustment_mdl->get_stock_adjustment_details_list();
	  	}else{
	  		$data = $this->stock_adjustment_mdl->get_stock_adjustment_details_list(array('stde_locationid'=>$this->locationid));
	  	}
	  	
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
                
		    $array[$i]["sn"]= $i;
            $array[$i]["stde_adjustdatebs"]=$row->stde_adjustdatebs;
            $array[$i]["stde_adjustdatead"]=$row->stde_adjustdatead;
            $array[$i]["stde_postby"]=$row->stde_postby;
            $array[$i]["remarks"]=$row->stde_remarks;
            $array[$i]["itli_itemcode"]=$row->itli_itemcode;
            $array[$i]["itli_itemname"]=$req_itemname;
            $array[$i]["stde_adjustamount"]=$row->stde_adjustamount;

            $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function details_exportToExcel($mast)
	{
		header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_adjustment_details_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
      	$this->data['fromdate'] = $this->input->post('fromdate');
    	$this->data['todate'] = $this->input->post('todate');
    	$this->data['searchResult']=$this->stock_adjustment_mdl->get_stock_adjustment_details_list($mast);
        $data = $this->stock_adjustment_mdl->get_stock_adjustment_details_list($mast);
       // $this->data['categorieswise']=$this->report_issue_mdl->category_wise_report($srchcol,$groupby);
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('stock_adjustment/v_stock_adjustment_download', $this->data, true);

      
        echo $response;
	}
	public function details_generate_pdf($mast)
	{	
		unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
      	$this->data['fromdate'] = $this->input->post('fromdate');
    	$this->data['todate'] = $this->input->post('todate');
    	
    	$this->data['searchResult']=$this->stock_adjustment_mdl->get_stock_adjustment_details_list($mast);
        $stylesheet='';
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        ini_set('memory_limit', '256M');
        $html = $this->load->view('stock_adjustment/v_stock_adjustment_download', $this->data, true);
        $mpdf = new mPDF('c', 'A4-L'); 
        $mpdf->showWatermarkText = true;  
        $mpdf->SetWatermarkText(ORGA_NAME);
        $mpdf->SetWatermarkImage(PDF_WATERMARK);
        $mpdf = new mPDF('utf-8', 'A4-L');
        $mpdf->SetAutoFont(AUTOFONT_ALL);
        $mpdf->showWatermarkImage = true;
		$mpdf->showWatermarkImage = true;
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html);
        $output = 'stock_adjustment_details_.pdf';
        $mpdf->Output();
        exit();
	}
	public function formchange_stock($masterid)
	{
		$this->data['masterid']=$masterid;
		$this->data['details'] = $this->stock_adjustment_mdl->get_details_list(array('sd.stde_stockmasterid'=>$masterid));
		//echo"<pre>";print_r($this->data['details']);die;
		$this->data['equipmnt_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttypeid', 'ASC');
		//$this->load->view('stock_adjustment/stock_adjustment_detail_form', $this->data);

		$this->load->view('stock_adjustment/stock_adjustment_detail_list', $this->data);
	}
}