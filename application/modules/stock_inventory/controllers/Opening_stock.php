<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Opening_stock extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('opening_stock_mdl');
		$this->load->Model('stock_inventory/item_mdl');
		$this->locationid = $this->session->userdata(LOCATION_ID);
     	$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
     	$this->postid=$this->general->get_real_ipaddr();
		$this->postmac=$this->general->get_Mac_Address();
		$this->userid=$this->session->userdata(USER_ID);
		$this->orgid=$this->session->userdata(ORG_ID);
     	$this->load->library('excel');

	}
	public function index()
	{ 	
		$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','desc');
		$this->data['curtab']="opening_stock";
		$this->data['opening_data']='';
		$id = $this->input->post('id');
		if($id)
		{
			$this->data['opening_data'] = $this->opening_stock_mdl->selected_opening_stock(array('trde_trdeid'=>$id));
			//echo "<pre>"; print_r($this->data['opening_data']);die;
		}
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
			->build('opening_stock/opening_stock_main', $this->data);
	}
	public function opening_lists()
	{
		$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','desc');
		$this->data['curtab']="opening_lists";
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
			->build('opening_stock/opening_stock_main', $this->data);
	}
	public function check_stock_data()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$fiscalYear=$this->input->post('fiscalYear');
		$storeId=$this->input->post('storeId');
		$this->data['mastdetails']=$this->general->get_tbl_data('*','trma_transactionmain',array('trma_fyear'=>$fiscalYear,'trma_todepartmentid'=>$storeId,'trma_transactiontype'=>"OPENING"),'trma_todepartmentid','ASC');
		//echo "<pre>";print_r($this->data['req_detail_list']);die();
		$tempform='';
		$tempform=$this->load->view('opening_stock/v_opening_stock_view',$this->data,true);
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
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}

	public function opening_stock_list()
	{
// $postdata=$this->input->post('eqid');
// print_r($postdata);die;
		
		if(MODULES_VIEW=='N')
			{
			$array=array();
			 // $this->general->permission_denial_message();
			 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
			}
	
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	  	$i = 0;

	  	$data = $this->opening_stock_mdl->get_opening_stock_list();
	  	// echo "<pre>";print_r($data);die;
	  

		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];


	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		foreach($data as $row)
		 {
		 	$tid=$i+1;
		 	if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
                }else{ 
                    $req_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
                }
			$array[$i]["mattransmasterid"]=$row->trma_trmaid;
            $array[$i]["material"]=$row->maty_material;
            $array[$i]["category"]=$row->eqca_category;
            $array[$i]["itemcode"]=$row->itli_itemcode;
            $array[$i]["itemname"]=ucfirst($req_itemname);
            $array[$i]["itemsid"]=$row->trde_itemsid;
            $array[$i]["controlno"]=$row->trde_controlno;
            $array[$i]["expdatead"]=$row->trde_expdatead;
            $array[$i]["expdatebs"]=$row->trde_expdatebs;
            $array[$i]["unitprice"]=$row->trde_unitprice;
            $array[$i]["requiredqty"]=sprintf('%g',$row->trde_requiredqty);
            $array[$i]["issueqty"]=sprintf('%g',$row->trde_issueqty);
            $array[$i]["unused_qty"]=sprintf('%g',$row->trde_unusedqty);
            $array[$i]["total_stockqty"]=$row->trde_issueqty+$row->trde_unusedqty;
            $array[$i]["amount"]=number_format(sprintf('%g',$row->amount),2);
            $array[$i]["transactiondatead"]=$row->trde_transactiondatead;
            $array[$i]["transactiondatebs"]=$row->trde_transactiondatebs;
            if(DEFAULT_DATEPICKER=='NP')
            {
            	$array[$i]["transactiondate"]=$row->trde_transactiondatebs;
        	}
	        else
	        {
	        	$array[$i]["transactiondate"]=$row->trde_transactiondatead;
	        }

            $array[$i]["mattransdetailid"]=$row->trde_trdeid;
            $array[$i]["transactiontype"]=$row->trma_transactiontype;
            $array[$i]["todepartmentid"]=$row->trma_todepartmentid;
            $array[$i]["transtime"]=$row->trde_transtime;
            $array[$i]["remarks"]=$row->trde_remarks;
            $array[$i]["fyear"]=$row->trma_fyear;
            $array[$i]["fromdepartmentid"]=$row->trma_fromdepartmentid;

            if(MODULES_UPDATE=='Y'){

            $editbtn='<a href="javascript:void(0)" data-detailid='.$row->trde_trdeid.' data-id='.$row->trde_trdeid.' data-displaydiv="openingstock" data-viewurl='.base_url('stock_inventory/opening_stock').' class="redirectedit btn-info btn-xxs" data-heading="View Stock Requisition" title="Edit"  ><i class="fa fa-edit" aria-hidden="true" ></i></a>';
        }else{
        	$editbtn='';
        }

        if(MODULES_DELETE=='Y'){


           $deletebtn= '<a href="javascript:void(0)" data-tableid="'.$tid.'" data-id='.$row->trde_trdeid.'  data-deleteurl='.base_url('stock_inventory/opening_stock/delete_opening_stock').' class="btnDeleteServer btn-delete btn-xxs "><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
       }else{
       	$deletebtn='';
       }

            $array[$i]["action"]=$editbtn.''.$deletebtn;				   
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
		// public function FunctionName()
		// {
		// 	
		// }


	public function delete_opening_stock()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_DELETE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			$id=$this->input->post('id');
			$trans = $this->opening_stock_mdl->remove_opening_stock();
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


	public function exportToExcel(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=opening_stock_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        if($this->location_ismain=='Y'){
        	 $data = $this->opening_stock_mdl->get_opening_stock_list();
        $this->data['searchResult'] = $this->opening_stock_mdl->get_opening_stock_list();
    }else{
    	 $data = $this->opening_stock_mdl->get_opening_stock_list(array('itli_locationid'=>$this->locationid));
        $this->data['searchResult'] = $this->opening_stock_mdl->get_opening_stock_list(array('itli_locationid'=>$this->locationid));
    }
       
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
	    $response = $this->load->view('opening_stock/v_opening_stock_download', $this->data, true);
        echo $response;
    }

    public function save_opening_stock()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {

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
			//echo "<pre>";print_r($this->input->post());die();
			// if($id)
			// {
			// 		$this->data['item_data']=$this->opening_stock_mdl->get_all_itemlist(array('it.itli_itemlistid'=>$id));
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
			$id=$this->input->post('id');	
			$this->form_validation->set_rules($this->opening_stock_mdl->validate_settings_open_stock);
			// }
			
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->opening_stock_mdl->opening_stock_save();
            if($trans)
            {
            	
            	  print_r(json_encode(array('status'=>'success','message'=>'Record Saved Successfully')));
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

	  public function form_opening_stock()
	  {
	  		$this->data['opening_data']='';
	  	    $this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
			$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','desc');

			$this->load->view('opening_stock/opening_stock_form',$this->data);

	  }

  	public function exists_reqno()
	{
		$requ_requno=$this->input->post('requ_requno');
		$id=$this->input->post('id');
		$reqdata=$this->opening_stock_mdl->check_exist_requision_no($requ_requno,$id);
		if($reqdata)
		{
			$this->form_validation->set_message('exists_reqno', 'Requisition ID already exist!!');
			return false;

		}
		else
		{
			return true;
		}
	}
	public function generate_pdf()
    {

    	  $this->data['searchResult'] = $this->opening_stock_mdl->get_opening_stock_list();	
    	
      
      
        ini_set('memory_limit', '256M');
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $html = $this->load->view('opening_stock/v_opening_stock_download', $this->data, true);
      
		$filename = 'closing_stock_' . date('Y_m_d_H_i_s') . '_.pdf';
    $pdfsize = 'A4-L'; //A4-L for landscape
    //if save and download with default filename, send $filename as parameter
    $this->general->generate_pdf($html, false, $pdfsize);

            exit();

        $mpdf->Output();
        exit();
    }


    public function excel_import($reload=false){
    	$this->data['equipmnt_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','desc');
		$this->data['material_type']=$this->general->get_tbl_data('*','maty_materialtype');
    	$this->data['curtab']="opening_stock_excel";
		$this->data['opening_data']='';
		
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
			->build('opening_stock/opening_stock_main', $this->data);
    }

    public function save_opening_stock_excel(){
    	
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
			$locationid=$this->input->post('locationid');
			$storeid=$this->input->post('storeid');
			$opstockyr=$this->input->post('opstockyr');
			$stockopendate=$this->input->post('stockopendate');

			if(!empty($_FILES["exceldata"]["name"])){
				$path = $_FILES["exceldata"]["tmp_name"];
				$object = PHPExcel_IOFactory::load($path);
				$sheet = $object->getSheet(0); 
				$highestRow = $sheet->getHighestRow(); 
				$highestColumn = $sheet->getHighestColumn();
				$headingArray = $sheet->rangeToArray('A1:' . $highestColumn . 1,NULL,TRUE,FALSE);
				$headings=$headingArray[0];
				$column_count=sizeof($headings);
					for ($row = 2; $row <= $highestRow; $row++){ 
					$rowDataArray = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
					$rowData[]=$rowDataArray[0];
					}

					for($i=0;$i<$column_count;$i++){
						$arrhead1=str_replace("_id/","_id_",$headings[$i]);
						$arrheading1=str_replace("/","",$arrhead1);
						$arrheading[]=str_replace("__","_",str_replace("___","_",$arrheading1));
					 }
						$j=0;
						foreach( $arrheading as $element ) {  
						    $arhead[$j] = strtolower($element); 
						    $j++; 
						}

						$arrheading_final=array_unique(array_filter($arhead));

					
						foreach ($arrheading_final as $key => $afinal) {
							$arfinal[]=$afinal;
						}
						$column_count=0;
						if(is_array($arfinal)){
							$column_count=sizeof($arfinal);
						}

						$arrData=array();
						for($j=0;$j<count($rowData);$j++){
							$arr_imp ='';
							for($i=0;$i<$column_count;$i++){
								$arr[$arfinal[$i]] = !empty($rowData[$j][$i])?$rowData[$j][$i]:'';
							}
							$arrData[]= $arr;
						}
						if(!empty($arrData)){
								// echo "<pre>";
								// print_r($arrData);
								// die();
							// echo $arrData[0]['item_category'];
							// die();
							// $i=0;
							$size_of_array = sizeof($arrData);
							for($i=0;$i<$size_of_array; $i++) {
							$finalarr[]=array(
								'sn'=>$arrData[$i]['sn'],
								'item_category'=>$arrData[$i]['item_category'],
								'item_name'=>$arrData[$i]['item_name'],
								'unit'=>$arrData[$i]['unit'],
								'stock'=>$arrData[$i]['stock'],
								'rate'=>$arrData[$i]['rate'],
								'amount'=>$arrData[$i]['amount'],
								'opstockyr'=>$opstockyr,
								'storeid'=>$storeid,
								'locationid'=>$locationid,
								'postdatead'=>CURDATE_EN,
								'postdatebs'=>CURDATE_NP,
								'posttime'=>date('H:i:s')
								);
							
							}
							$this->db->trans_start();
							if($finalarr){
								$this->db->query("TRUNCATE TABLE xw_opening_stock_excel");
								$this->db->insert_batch('opening_stock_excel',$finalarr);
								$this->manage_opening_stock_data_replace_with_id();
								$this->process_opening_stock();
								$this->db->trans_commit();
								print_r(json_encode(array('status'=>'success','message'=>'Successfully Uploaded !!')));
								exit;
							}
							$this->db->trans_rollback();
								print_r(json_encode(array('status'=>'success','message'=>'Successfully Uploaded !!')));
								exit;
						}


					}
			} catch (Exception $e) {
			          $this->db->trans_rollback();
			            print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
			        }
				    }
				 		else
				    		{
				    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				            exit;
				    }
    }

    public function manage_opening_stock_data_replace_with_id(){
    	$materialtypeid=$this->input->post('materialtypeid');
    	$storeid=$this->input->post('storeid');

		$this->db->select('DISTINCT(unit) as unit');
    	$this->db->from('opening_stock_excel');
    	$unit_result=$this->db->get()->result();
    	if($unit_result){
    		// echo "<pre>";
    		// print_r($cat_result);
    		// die();
    		foreach ($unit_result as $ku => $urslt) {
    				$this->db->select('unit_unitid,unit_unitname');
    				$this->db->from('unit_unit');
    				$this->db->where('unit_unitname',$urslt->unit);
    				$prev_db_unit=$this->db->get()->row();
    				if(!empty($prev_db_unit)){
    					$this->db->update('opening_stock_excel',array('unit_id'=>$prev_db_unit->unit_unitid),array('unit'=>$urslt->unit));
    				}else{
    					$postdata_unit['unit_unitname']=$urslt->unit;
    					$postdata_unit['unit_isactive']='Y';
    					$postdata_unit['unit_postdatead']=CURDATE_EN;
						$postdata_unit['unit_postdatebs']=CURDATE_NP;
						$postdata_unit['unit_posttime']=$this->general->get_currenttime();
						$postdata_unit['unit_postby']=$this->userid;
						$postdata_unit['unit_orgid']=$this->orgid;
						$postdata_unit['unit_postip']=$this->postid;
						$postdata_unit['unit_postmac']=$this->postmac;
						$postdata_unit['unit_locationid']= $this->locationid;
						if(!empty($postdata_unit)){
							$this->db->insert('unit_unit',$postdata_unit);
							$last_unit_id=$this->db->insert_id();	
							if($last_unit_id){
									$this->db->update('opening_stock_excel',array('unit_id'=>$last_unit_id),array('unit'=>$urslt->unit));
							}
						}
    					
    				}
    		}

    	}


    	$this->db->select('DISTINCT(item_category) as itemcat');
    	$this->db->from('opening_stock_excel');
    	$cat_result=$this->db->get()->result();
    	if($cat_result){
    		// echo "<pre>";
    		// print_r($cat_result);
    		// die();
    		foreach ($cat_result as $kcr => $cresult) {
    			$this->db->select('eqca_equipmentcategoryid,eqca_code,eqca_category');
    				$this->db->from('eqca_equipmentcategory');
    				$this->db->where('eqca_category',$cresult->itemcat);
    				$prev_db_cat=$this->db->get()->row();
    				if(!empty($prev_db_cat)){
    					$this->db->update('opening_stock_excel',array('item_categoryid'=>$prev_db_cat->eqca_equipmentcategoryid),array('item_category'=>$prev_db_cat->eqca_category));

    				}else{
    					$postdata_itemcat['eqca_equiptypeid']='1';
    					$postdata_itemcat['eqca_code']=$this->get_item_category_code_generate($cresult->itemcat);
    					$postdata_itemcat['eqca_category']=$cresult->itemcat;
    					$postdata_itemcat['eqca_postdatead']=CURDATE_EN;
						$postdata_itemcat['eqca_postdatebs']=CURDATE_NP;
						$postdata_itemcat['eqca_posttime']=$this->general->get_currenttime();
						$postdata_itemcat['eqca_postby']=$this->userid;
						$postdata_itemcat['eqca_orgid']=$this->orgid;
						$postdata_itemcat['eqca_postip']=$this->postid;
						$postdata_itemcat['eqca_postmac']=$this->postmac;
						$postdata_itemcat['eqca_locationid']= $this->locationid;
						if(!empty($postdata_itemcat)){
							$this->db->insert('eqca_equipmentcategory',$postdata_itemcat);
							$last_category_id=$this->db->insert_id();	
							if($last_category_id){
									$this->db->update('opening_stock_excel',array('item_categoryid'=>$last_category_id),array('item_category'=>$cresult->itemcat));
							}
						}
    					
    				}
    		}

    	}

    	$this->db->select('DISTINCT(item_name) as itemname,rate,item_categoryid,unit_id');
    	$this->db->from('opening_stock_excel');
    	$item_name=$this->db->get()->result();
    	if($item_name){
    		foreach ($item_name as $kn => $iname) {
    			$this->db->select('itli_itemlistid,itli_itemcode,itli_itemname,itli_catid');
    				$this->db->from('itli_itemslist');
    				$this->db->where('itli_itemname',$iname->itemname);
    				$prev_db_item=$this->db->get()->row();
    				if(!empty($prev_db_item)){
    					$this->db->update('opening_stock_excel',array('item_id'=>$prev_db_item->itli_itemlistid),array('item_name'=>$iname->itemname));
    				}else{
    					$itemdata=$this->item_mdl->get_all_itemlist(array('itli_catid'=>$iname->item_categoryid),1,0,'itli_itemlistid','DESC');
    						$equ_cat_data=$this->general->get_tbl_data('eqca_code','eqca_equipmentcategory',array('eqca_equipmentcategoryid'=>$iname->item_categoryid));
   							$eqcode=$equ_cat_data[0]->eqca_code;

		 			 		if($itemdata)
					 		{	

		 					
					 			$itemcode=$itemdata[0]->itli_itemcode;
					 			$codearr=$this->general->stringseperator($itemcode,'number');
					 			$item_string = str_pad($codearr + 1, ITEM_CODE_NO_LENGTH, 0, STR_PAD_LEFT);
								// die();
								$itmcode = $eqcode . $item_string;

					 			// $itmcode=$eqcode.($codearr+1);
					 			// die();
					 		}
					 		else
					 		{
					 			$itmcode = $eqcode . str_pad(0 + 1, ITEM_CODE_NO_LENGTH, 0, STR_PAD_LEFT);
					 		}

					 		

							$postdata_item['itli_materialtypeid']=$materialtypeid;
					 		$postdata_item['itli_catid']=$iname->item_categoryid;
					 		$postdata_item['itli_itemcode']=$itmcode;
					 		$postdata_item['itli_itemname']=$iname->itemname;
					 		$postdata_item['itli_purchaserate']=$iname->rate;
					 		$postdata_item['itli_active']='Y';
					 		$postdata_item['itli_typeid']=$storeid;
					 		$postdata_item['itli_unitid']=$iname->unit_id;
					 		$postdata_item['itli_postdatead']=CURDATE_EN;
						    $postdata_item['itli_postdatebs']=CURDATE_NP;
						    $postdata_item['itli_posttime']=date('H:i:s');
						    $postdata_item['itli_postby']=$this->userid;
						    $postdata_item['itli_postip']=$this->postid;
						    $postdata_item['itli_postmac']=$this->postmac;
						    $postdata_item['itli_orgid']=$this->orgid;
						    $postdata_item['itli_locationid']= $this->locationid;
						    if(!empty($postdata_item)){
						    	$this->db->insert('itli_itemslist',$postdata_item);
						    	$last_item_id=$this->db->insert_id();	
						    	if($last_item_id){
						    		$this->db->update('opening_stock_excel',array('item_id'=>$last_item_id),array('item_name'=>$iname->itemname));
						    	}

						    }

    				}
    	}

    }
 }


public function process_opening_stock(){
	$locationid=$this->input->post('locationid');
	$storeid=$this->input->post('storeid');
	$opstockyr=$this->input->post('opstockyr');
	$stockopendate=$this->input->post('stockopendate');


	$op_yrs_arr=explode('/', $opstockyr);
	$yr1=$op_yrs_arr[0];
	$yr2=$op_yrs_arr[1];
	$stock_openingdatenp='2'.$yr1.'/04'.'/01';
	$stock_openingdateen=$this->general->NepToEngDateConv($stock_openingdatenp);
		
	$this->db->select('*');
	$this->db->from('opening_stock_excel');
	$op_stock_result=$this->db->get()->result();
	// echo "<pre>";
	// print_r($op_stock_result);
	// die();
	if(!empty($op_stock_result)){
		 	$postdata['trma_transactiondatead']=$stock_openingdateen;
            $postdata['trma_transactiondatebs']=$stock_openingdatenp;
            $postdata['trma_receiveddatead']=$stock_openingdateen;
            $postdata['trma_receiveddatebs']=$stock_openingdatenp;
            $postdata['trma_transactiontype']='OPENING';
            $postdata['trma_fromdepartmentid']= $storeid;
            $postdata['trma_todepartmentid']= $storeid;
            $postdata['trma_fromby']=$this->session->userdata(USER_NAME);
            $postdata['trma_toby']=$this->session->userdata(USER_NAME);
            $postdata['trma_issueno']='';
            $postdata['trma_status']='O';
            $postdata['trma_sysdate']=CURDATE_EN;
            $postdata['trma_received']=1;
            $postdata['trma_fyear']=$opstockyr;
            $postdata['trma_sttransfer']='N';
            $postdata['trma_postdatead']=CURDATE_EN;
            $postdata['trma_postdatebs']=CURDATE_NP;
            $postdata['trma_posttime']=$this->general->get_currenttime();
            $postdata['trma_postby']=$this->session->userdata(USER_ID);
            $postdata['trma_postip']=$this->general->get_real_ipaddr();
            $postdata['trma_postmac']=$this->general->get_Mac_Address();
            $postdata['trma_locationid']=$locationid;
            $postdata['trma_orgid']=$this->orgid;
        	

        	if(!empty($postdata)){
            $this->db->insert('trma_transactionmain',$postdata);
            $insertid=$this->db->insert_id();
            			foreach ($op_stock_result as $kor => $rslt) {
				$openingStock[] = array(
                                'trde_trmaid'=>$insertid,
                                'trde_transactiondatead'=>$stock_openingdateen,
                                'trde_transactiondatebs'=>$stock_openingdatenp,
                                'trde_itemsid'=>!empty($rslt->item_id)?$rslt->item_id:'',
                                'trde_transactiontype'=>"OPENING",
                                'trde_status'=>'O',
                                'trde_sysdate'=>CURDATE_EN,
                                'trde_requiredqty'=>!empty($rslt->stock)?$rslt->stock:'0.00',
                                'trde_issueqty'=>!empty($rslt->stock)?$rslt->stock:'0.00',
                                'trde_newissueqty'=>!empty($rslt->stock)?$rslt->stock:'0.00',
                                'trde_transtime'=>date('H:i:s'),
                                'trde_unitprice'=>!empty($rslt->rate)?$rslt->rate:'0.00',
                                'trde_selprice'=>!empty($rslt->rate)?$rslt->rate:'',
                                'trde_remarks'=>!empty($rslt->item_name)?$rslt->item_name:'',
                                'trde_description'=>!empty($rslt->item_name)?$rslt->item_name:'',
                                'trde_totalvalue'=>!empty($rslt->amount)?$rslt->amount:'0.00',
                                'trde_postdatebs'=>CURDATE_NP,
                                'trde_postdatead'=>CURDATE_EN,
                                'trde_postip'=>$this->postid,
                                'trde_postmac'=>$this->postmac,
                                'trde_posttime'=>date('H:i:s'),
                                'trde_postby'=>$this->userid,
                                'trde_locationid'=>$locationid,
                                'trde_orgid'=>$this->orgid
                                );
                }
                if(!empty($openingStock))
                {   //echo"<pre>";print_r($openingStock);die;
                    $this->db->insert_batch('trde_transactiondetail',$openingStock);
                }
			}
		}	
}


    public function get_item_category_code_generate($catname){

    	if(!empty($catname))
		 	{
		 		$wordcount=str_word_count($catname);
		 		// echo $wordcount;

		 		if($wordcount==1)
		 		{
		 			$eqcode= strtoupper(substr($catname, 0, 3));
		 		}
		 		if($wordcount==2)
		 		{
		 			$stringarray= explode(' ', $catname);
		 			// print_r($stringarray);
		 			$str1= strtoupper(substr($stringarray[0], 0, 2));
		 			$str2= strtoupper(substr($stringarray[1], 0, 1));
		 			$eqcode= $str1.$str2;	
		 		}
		 		if($wordcount==3)
		 		{
		 			$stringarray= explode(' ', $catname);
		 			// print_r($stringarray);
		 			$str1= strtoupper(substr($stringarray[0], 0, 1));
		 			$str2= strtoupper(substr($stringarray[1], 0, 1));
		 			$str3= strtoupper(substr($stringarray[2], 0, 1));

		 			$eqcode= $str1.$str2.$str3;	
		 		}

		 		if($wordcount>3)
		 		{
		 			$stringarray= explode(' ', $catname);
		 			// print_r($stringarray);
		 			$str1= strtoupper(substr($stringarray[0], 0, 1));
		 			$str2= strtoupper(substr($stringarray[1], 0, 1));
		 			$str3= strtoupper(substr($stringarray[2], 0, 1));
		 			$str4= strtoupper(substr($stringarray[3], 0, 1));

		 			$eqcode= $str1.$str2.$str3;	
		 		}
		 		return $eqcode;
    }
    return false;
	
}
}