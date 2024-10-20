<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assets_deprecation_mdl extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		$this->table='asen_assetentry';
		$this->locationid=$this->session->userdata(LOCATION_ID);
		$this->deptemp='';
		$this->deptemp_st_count=0;
		$this->deptemp_ddb_count=0;
		$this->deptemp_uop_count=0;
		$this->deptemp_soy_count=0;
	}

	public $validate_settings_assets = array( 
		array('field' => 'asen_assetcode', 'label' => 'Assest Code', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'asen_assettype', 'label' => 'Assests Type', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'asen_description', 'label' => 'Assests Description', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'asen_status', 'label' => 'Assests Status', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'asen_condition', 'label' => 'Assests Condition', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'asen_purchaserate', 'label' => 'Assests Purchase Rate', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'asen_marketvalue', 'label' => 'Assests Market Value', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'asen_scrapvalue', 'label' => 'Assests Scrap Value', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'asen_expectedlife', 'label' => 'Assests Expected Life', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'asen_recoveryperiod', 'label' => 'Assests Revovery Period', 'rules' => 'trim|required|xss_clean'),
       );  
/*
	public function get_status($srchcol=false)
	{
		$this->db->select('*');
		$this->db->from('asst_assetstatus');
	    		
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}

	public function get_condition($srchcol=false)
	{
		$this->db->select('*');
		$this->db->from('asco_condition');
	    		
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}


	public function get_material($srchcol=false)
	{
		$this->db->select('*');
		$this->db->from('eqca_equipmentcategory ec');
		$this->db->where('ec.eqca_equiptypeid','2');
	    $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=ec.eqca_equiptypeid','LEFT');
		
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}


	public function get_depreciation($srchcol=false)
	{
		$this->db->select('*');
		$this->db->from('dety_depreciation');
	    		
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}

	public function save_assets()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');

		$asen_purchasedate=$this->input->post('asen_purchasedate');
		$asen_warrentydate=$this->input->post('asen_warrentydate');
		$asen_inservicedate=$this->input->post('asen_inservicedate');

		unset($postdata['asen_purchasedate']);
		unset($postdata['asen_warrentydate']);
		unset($postdata['asen_inservicedate']);

		if(DEFAULT_DATEPICKER=='NP')
		{   
			$asen_purchasedateNp = $asen_purchasedate;
			$asen_purchasedateEn = $this->general->NepToEngDateConv($asen_purchasedate);
			$asen_warrentydateNp = $asen_warrentydate;
			$asen_warrentydateEn = $this->general->NepToEngDateConv($asen_warrentydate);
			$asen_inservicedateNp = $asen_inservicedate;
			$asen_inservicedateEn = $this->general->NepToEngDateConv($asen_inservicedate);
		}
		else
		{
			$asen_purchasedateEn = $asen_purchasedate;
			$asen_purchasedateNp = $this->general->EngtoNepDateConv($asen_purchasedate);
			$asen_warrentydateEn = $asen_warrentydate;
			$asen_warrentydateNp = $this->general->EngtoNepDateConv($asen_warrentydate);
			$asen_inservicedateEn = $asen_inservicedate;
			$asen_inservicedateNp = $this->general->EngtoNepDateConv($asen_inservicedate);
		}

		$postid=$this->general->get_real_ipaddr();
		$postmac=$this->general->get_Mac_Address();
		unset($postdata['id']);
	
		if($id)
		{
			$this->db->trans_start();
			$postdata['asen_purchasedatebs']=$asen_purchasedateNp;
			$postdata['asen_purchasedatead']=$asen_purchasedateEn;
			$postdata['asen_warrentydatebs']=$asen_warrentydateNp;
			$postdata['asen_warrentydatead']=$asen_warrentydateEn;
			$postdata['asen_inservicedatebs']=$asen_inservicedateNp;
			$postdata['asen_inservicedatead']=$asen_inservicedateEn;

			$postdata['asen_modifydatead']=CURDATE_EN;
			$postdata['asen_modifydatebs']=CURDATE_NP;
			$postdata['asen_modifytime']=$this->general->get_currenttime();
			$postdata['asen_modifyby']=$this->session->userdata(USER_ID);
			$postdata['asen_modifyip']=$postid;
			$postdata['asen_modifymac']=$postmac;
			$postdata['asen_locationid']=$this->session->userdata(LOCATION_ID);
			$postdata['asen_orgid']=$this->session->userdata(ORG_ID);
			
			if(!empty($postdata))
			{
				 //$this->general->save_log($this->table,'asen_asenid',$id,$postdata,'Update');
				$this->db->update($this->table,$postdata,array('asen_asenid'=>$id));
				
			} 

			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
				{
				        $this->db->trans_rollback();
				        return false;
				}
				else
				{
				        $this->db->trans_commit();
				        return true;
				}
		}
		else
		{
			$postdata['asen_purchasedatebs']=$asen_purchasedateNp;
			$postdata['asen_purchasedatead']=$asen_purchasedateEn;
			$postdata['asen_warrentydatebs']=$asen_warrentydateNp;
			$postdata['asen_warrentydatead']=$asen_warrentydateEn;
			$postdata['asen_inservicedatebs']=$asen_inservicedateNp;
			$postdata['asen_inservicedatead']=$asen_inservicedateEn;
			$postdata['asen_postdatead']=CURDATE_EN;
			$postdata['asen_postdatebs']=CURDATE_NP;
			$postdata['asen_posttime']=$this->general->get_currenttime();
			$postdata['asen_postby']=$this->session->userdata(USER_ID);
			$postdata['asen_postip']=$postid;
			$postdata['asen_postmac']=$postmac;
			$postdata['asen_locationid']=$this->session->userdata(LOCATION_ID);
			$postdata['asen_orgid']=$this->session->userdata(ORG_ID);



			// echo "<pre>";
			// print_r($postdata);
			// die();
			$this->db->trans_start();
			if(!empty($postdata))
			{
				$this->db->insert($this->table,$postdata);
			}
			$insert_id = $this->db->insert_id();

			$asen_descid =$this->input->post('asen_description');
            $this->db->set('itli_maxval', 'itli_maxval+1', FALSE);
            $this->db->where('itli_itemlistid', $asen_descid);
            $this->db->update('itli_itemslist');     	
			
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
				{
				        $this->db->trans_rollback();
				        return false;
				}
				else
				{
				        $this->db->trans_commit();
				        return true;
				}
			}
			return false;
	}
	
	public function get_all_assets_list()
	{  	
		$get = $_GET;
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}

       	if(!empty($get['sSearch_0'])){
            $this->db->where("assets_code like  '%".$get['sSearch_0']."%'  ");
        }
		if(!empty($get['sSearch_1'])){
            $this->db->where("assets_type like  '%".$get['sSearch_1']."%'  ");
        }
       	if(!empty($get['sSearch_2'])){
            $this->db->where("model_no like  '%".$get['sSearch_2']."%'  ");
        }
      	if(!empty($get['sSearch_3'])){
            $this->db->where("serial_no like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("status like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("condition like  '%".$get['sSearch_5']."%'  ");
        }

      	$resltrpt=$this->db->select("COUNT(*) as cnt")
      					 ->from('asen_assetentry')
      					->get()
      					->row();
	    // echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = '';
      	$order = 'desc';
      	if($this->input->get('sSortDir_0'))
  		{
  			$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'assets_code';
        if($this->input->get('iSortCol_0')==1)
        	$order_by = 'assets_type';
        
      	else if($this->input->get('iSortCol_0')==2)
        	$order_by = 'model_no';
      	else if($this->input->get('iSortCol_0')==3)
       		$order_by = 'serial_no';
       		else if($this->input->get('iSortCol_0')==4)
      	 	$order_by = 'status';
       	else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'condition';
      	
      	$totalrecs='';
      	$limit = 15;
      	$offset = 1;
      	$get = $_GET;
 
	    foreach ($get as $key => $value) {
	        $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
	    }
      
        if(!empty($_GET["iDisplayLength"])){
           $limit = $_GET['iDisplayLength'];
           $offset = $_GET["iDisplayStart"];
        }

        if(!empty($get['sSearch_0'])){
            $this->db->where("assets_code like  '%".$get['sSearch_0']."%'  ");
        }
		if(!empty($get['sSearch_1'])){
            $this->db->where("assets_type like  '%".$get['sSearch_1']."%'  ");
        }
       	if(!empty($get['sSearch_2'])){
            $this->db->where("model_no like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("serial_no like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("status like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("condition like  '%".$get['sSearch_5']."%'  ");
        }
       
        $this->db->select('*');
	    $this->db->from('asen_assetentry ae');
	    $this->db->join('asst_assetstatus as','as.asst_asstid=ae.asen_status','LEFT');
	    $this->db->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT');
	    $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT');
	     $this->db->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT');

	    //$this->db->order_by($order_by,$order);
        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }
        
       	$nquery=$this->db->get();
       	$num_row=$nquery->num_rows();
        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = sizeof($nquery);
        }

       	if($num_row>0){
          $ndata=$nquery->result();
          $ndata['totalrecs'] = $totalrecs;
          $ndata['totalfilteredrecs'] = $totalfilteredrecs;
        } 
        else
        {
            $ndata=array();
            $ndata['totalrecs'] = 0;
            $ndata['totalfilteredrecs'] = 0;
        }
	  	// echo $this->db->last_query();die();
	  	return $ndata;
	}

	public function get_all_assets($srstinl=false,$limit=false,$offset=false,$order_by=false,$order=false)
	{
		$this->db->select('*');
	    $this->db->from('asen_assetentry ae');
	    $this->db->join('asst_assetstatus as','as.asst_asstid=ae.asen_status','LEFT');
	    $this->db->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT');
	    $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT');
	    $this->db->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT');
		if($srstinl)
		{
			$this->db->where($srstinl);
		}
		if($limit && $limit>0)
	    {
	        $this->db->limit($limit);
	    }
	    if($offset)
	    {
	        $this->db->offset($offset);
	    }
	    if($order_by)
	    {
	        $this->db->order_by($order_by,$order);
	 	}

		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}

*/	
	public function get_all_assets($srstinl=false,$limit=false,$offset=false,$order_by=false,$order=false,$groupby=false)
	{
		$fromdate=$this->input->post('fromdate');
   	 	$todate=$this->input->post('todate');
    	$srchdate=$this->input->post('date');
    	$srchtxt= $this->input->post('srchtext');
    	$srchdec= $this->input->post('srchdec');


		$this->db->select('*');
	    $this->db->from('asen_assetentry ae');
	    $this->db->join('asst_assetstatus as','as.asst_asstid=ae.asen_status','LEFT');
	    $this->db->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT');
	    $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT');
	    $this->db->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT');
	    $this->db->join('manu_manufacturers ma','ma.manu_manlistid=ae.asen_manufacture','LEFT');


		if($srstinl)
		{
			$this->db->where($srstinl);
		}

		if($srchtxt)
      {
         $this->db->where("ae.asen_assetcode like  '%".$srchtxt."%'  ");
      }

      if($srchdec)
      {
         $this->db->where("il.itli_itemname like  '%".$srchdec."%'  ");
      }

		if($limit && $limit>0)
	    {
	        $this->db->limit($limit);
	    }
	    if($offset)
	    {
	        $this->db->offset($offset);
	    }
	    if($order_by)
	    {
	        $this->db->order_by($order_by,$order);
	 	}
	 	$this->db->set_dbprefix('');

	 	 if($groupby)
      {
        $this->db->group_by($groupby);
      }
      $this->db->set_dbprefix('xw_');

		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}

	public function get_depreciation($srchcol=false)
	{
		$this->db->select('*');
		$this->db->from('dety_depreciation');
	    		
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}

	public function depreciation_calc_straight_line($depval,$principal_amount=false,$i=0,$useful_life)
	{
		if ($i==0)
		{
			$this->deptemp=$this->depr_st_line_heading();
		}


		$pamt_val=$principal_amount-$depval;
		$accumulated_depr_value=$i*$depval;
		
		$datas=array('current_p_value' => $pamt_val,'depreciated_value'=>$depval );
		return $this->deptemp;	
	}

	

	public function st_line_dep_amount($depreciation_value,$principal,$i,$month,$useful_life)
	{
		$depr_amount=0;
		$useful_months_in_a_year=(12-$month)+1;
		if($i==0)
		 	$depr_amount=($depreciation_value*($useful_months_in_a_year)/12);
		else if($i>0 && $i<($useful_life))
			$depr_amount=$depreciation_value;
		else if($i==$useful_life)
			$depr_amount=($depreciation_value*(12-$useful_months_in_a_year)/12);

		return round($depr_amount,0);
	}

	public function depr_st_line_initial_value($depreciation_value,$principal,$i,$useful_life,$month)
	{
		if($i<=$useful_life-1)
		return ($principal-$depreciation_value);
	}

	public function depr_st_line_final_value($depreciation_value,$principal,$i,$month,$useful_life)
	{
		$final_value=0;
		if($i==0)
		 	$final_value=($principal-($depreciation_value*$month/12));
		else if($i>0 && $i<=($useful_life-2))
			$final_value=$principal-$depreciation_value;
		else if($i==$useful_life-1)
			$final_value=($principal-($depreciation_value*(12-$month)/12));

		return round($final_value,2);
	}

	public function depr_st_line_heading()
	{
		$this->deptemp='';
		$this->deptemp.='<table class="table table-striped tblDpr" style="border:0px"';
			$this->deptemp.='<tr>';
			$this->deptemp.='<th style="text-align:center">Start Date</th>';
			$this->deptemp.='<th style="text-align:center">Initial Book Value</th>';
			$this->deptemp.='<th style="text-align:center">Depreciation Value</th>';
			$this->deptemp.='<th style="text-align:center">Accumulative Depreciation Value</th>';
			$this->deptemp.='<th style="text-align:center">End Date</th>';
			$this->deptemp.='<th style="text-align:center">Value After Depreciation</th>';
			$this->deptemp.='</tr>';

			return $this->deptemp;
	}

	public function depr_calc_ddb_method($useful_life,$principal_amount=false,$rate,$i=0)
	{
		if ($this->deptemp_ddb_count==0)
		{
			$this->deptemp.='<table class="table table-striped tblDpr" style="border:0px"';
			$this->deptemp.='<tr>';
			$this->deptemp.='<th style="text-align:center">Start Date</th>';
			$this->deptemp.='<th style="text-align:center">Initial Book Value</th>';
			$this->deptemp.='<th style="text-align:center">Rate of Depreciation</th>';
			$this->deptemp.='<th style="text-align:center">Depreciation Amount</th>';
			$this->deptemp.='<th style="text-align:center">End Date</th>';
			$this->deptemp.='<th style="text-align:center">Value After Depreciation</th>';
			$this->deptemp.='</tr>';
			$this->deptemp_ddb_count=1;
		}

		//$j=$i;

		$depr_amount=$principal_amount*$rate;
		$pamt_val=$principal_amount-$depr_amount;
		$this->deptemp.='<tr>';
		if($i<=$useful_life)
		{
		 	$this->deptemp.='<td>(left blank)</td>';
		 	$this->deptemp.='<td style="text-align:center">'.number_format($principal_amount,2).'</td>';
		 	$this->deptemp.='<td style="text-align:center">'.number_format(($rate*100),2).'%</td>';
		 	$this->deptemp.='<td style="text-align:center">'.number_format($depr_amount,2).'</td>';
		 	$this->deptemp.='<td style="text-align:center">(left blank)</td>';
		 	$this->deptemp.='<td style="text-align:center">'.number_format($pamt_val,2).'</td>';
		 
		 	$this->depr_calc_ddb_method($useful_life,$pamt_val,$rate,$i+1); 
		}
		else
		{
			$this->deptemp.='';
		}
		
		$this->deptemp.='</tr>';
		return $this->deptemp;	
	}

	

	public function depr_calc_units_of_production_method($init_p_value=1,$principal_amt,$unit_counter=0,$unit,$useful_life,$i=0)
	{
		if ($this->deptemp_uop_count==0)
		{
			$this->deptemp.='<table class="table table-striped tblDpr" style="border:0px"';
			$this->deptemp.='<tr>';
			$this->deptemp.='<th style="text-align:center">Start Date</th>';
			$this->deptemp.='<th style="text-align:center">Initial Book Value</th>';
			$this->deptemp.='<th style="text-align:center">Unit Produced</th>';
			$this->deptemp.='<th style="text-align:center">End Date</th>';
			$this->deptemp.='<th style="text-align:center">Depreciation Value</th>';
			$this->deptemp.='<th style="text-align:center">Value After Depreciation</th>';
			$this->deptemp.='</tr>';
			$this->deptemp_uop_count=1;
		}
		
		$total_unit=array_sum($unit);
		if ($total_unit<=0)
			return false;


			 
			

		$this->deptemp.='<tr>';
		
		if ($unit_counter<=$useful_life-1)
		{
			$unit_of_that_season=$unit[$unit_counter];
			$depr_for_that_season=($unit_of_that_season/$total_unit)*($init_p_value);	
			$value_after_depr=$principal_amt-$depr_for_that_season;

			if ($i==0)
			 {
			 	$this->deptemp.='<td style="text-align:center">'.$this->common_date.'</td>';
			 }
			 else
			 {
			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i).'/04/01</td>';
			 }	
		
			$this->deptemp.='<td style="text-align:center">'.number_format($principal_amt,2).'</td>';
			$this->deptemp.='<td style="text-align:center">'.number_format($unit_of_that_season).'</td>';
			
			if ($i==$useful_life-1)
			 {
			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i+1).'/'.$this->common_month.'/01</td>';
			
			 }
			 
			 else
			 {

			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i+1).'/03/31</td>';
			 }

			$this->deptemp.='<td style="text-align:center">'.number_format($depr_for_that_season,2).'</td>';
			$this->deptemp.='<td style="text-align:center">'.number_format($value_after_depr,2).'</td>';
			$this->depr_calc_units_of_production_method($init_p_value,$value_after_depr,$unit_counter+1,$unit,$useful_life,$i+1);
		}
		else
		{
				$this->deptemp.='';
		}

		$this->deptemp.='</tr>';
		$this->deptemp.='</table>';

		return $this->deptemp;	
	}
	
	public function depr_calc_soy_method_partial($useful_life,$principal,$current_principal_val,$i=0)
	{
		$effective_principal=0;
		$useful_years_list=range(1, $useful_life); // uyl[0] => 1,uyl[1] => 2 and so on...
		$useful_years_sum=array_sum($useful_years_list);

		//display initial headings of table
		if ($this->deptemp_soy_count==0)
		{
			$this->deptemp.='<table class="table table-striped tblDpr" style="border:0px"';
			$this->deptemp.='<tr>';
			$this->deptemp.='<th style="text-align:center">Start Date</th>';
			$this->deptemp.='<th style="text-align:center">Initial Book Value</th>';
			$this->deptemp.='<th style="text-align:center">Years of Usefulness</th>';
			$this->deptemp.='<th style="text-align:center">Depreciation Amount</th>';
			$this->deptemp.='<th style="text-align:center">End Date</th>';
			$this->deptemp.='<th style="text-align:center">Value After Depreciation</th>';
			$this->deptemp.='</tr>';

			$this->deptemp_soy_count=1;
		}
		$this->deptemp.='<tr>';
		
		$current_useful_life=$useful_life-$i+1;	
		$depr_for_any_season=(($useful_life-$i+1)/$useful_years_sum)*$principal;	

		// $value_after_depr=$current_principal_val-$depr_for_any_season;
		$value_after_depr=0;
		$depr_for_mid_season=0;
		
		//business logic for depreciation	
		if ($this->common_month<=3) 
		{
			
			$month_count=4-$this->common_month;
				
			$depr_for_first_season=($month_count/12)*$depr_for_any_season;
			
			$useful_year_for_previous_season=$useful_life-$i+2;
			$partial_dep_from_prev_season=((12-$month_count)/12)* ($useful_year_for_previous_season/($useful_years_sum)) *$principal;
			
			$useful_year_for_this_season=$useful_life-$i+1;
			$partial_dep_for_this_season=($month_count/12)*($useful_year_for_this_season/$useful_years_sum)*$principal;

			$depr_for_mid_season=$partial_dep_from_prev_season+$partial_dep_for_this_season;
			
		}

		else if ($this->common_month==4) 
		{
			$depr_for_first_season=$depr_for_any_season;
			$depr_for_last_season=$depr_for_any_season;
		}

		else if($this->common_month>4 && $this->common_month<=12)
		{

			$month_count=(12-$this->common_month+4);
			$depr_for_any_season=(($useful_life-$i+1)/$useful_years_sum)*$principal;	
			
			$depr_for_first_season=($month_count/12)*$depr_for_any_season;
			
			$useful_year_for_previous_season=$useful_life-$i+2;
			$partial_dep_from_prev_season=((12-$month_count)/12)* ($useful_year_for_previous_season/($useful_years_sum)) *$principal;
			
			$useful_year_for_this_season=$useful_life-$i+1;
			$partial_dep_for_this_season=($month_count/12)*($useful_year_for_this_season/$useful_years_sum)*$principal;

			$depr_for_mid_season=$partial_dep_from_prev_season+$partial_dep_for_this_season;
		}
		//business logic for depreciation end	

		//Display
		if ($this->common_month<=3)
		{
			if ($i<=$useful_life+1)
			{
			//start date		
			 if ($i==1)
			 {
			 	$this->deptemp.='<td style="text-align:center">'.$this->common_year.'/'.$this->common_month.'/01</td>';
			 }
			 else if ($i==2) 
			 {
			  $this->deptemp.='<td style="text-align:center">'.$this->common_year.'/04/01</td>';
			 }
			 else
			 {
			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i-2).'/04/01</td>';
			 }

			 //current book value or principal
			 $this->deptemp.='<td style="text-align:center">'.number_format($current_principal_val,2).'</td>';
			 
			 //useful life
			 if($i==1 || $i==$useful_life+1)
			 	$this->deptemp.='<td style="text-align:center">'.number_format($current_useful_life).' (partial)</td>';
			 else
			 	$this->deptemp.='<td style="text-align:center">'.number_format($current_useful_life).'</td>';
			
			//depreciation amount
			 if($i==1) 	
			 	$this->deptemp.='<td style="text-align:center">'.number_format($depr_for_first_season,2).'</td>';
			 else if($i>1 && $i<=$useful_life+1)
			 	$this->deptemp.='<td style="text-align:center">'.number_format($depr_for_mid_season,2).'</td>';
 			 else
			 	$this->deptemp.='<td style="text-align:center">'.number_format($depr_for_last_season,2).'</td>';
			
			//end date
			 if ($i==1)
			 {
			 	$this->deptemp.='<td style="text-align:center">'.$this->common_year.'/03/31</td>';
			 }
			 else if ($i==2 || $i<$useful_life+1) 
			 {
			  $this->deptemp.='<td style="text-align:center">'.($this->common_year+$i-1).'/03/31</td>';
			 }
			 else
			 {
			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i-1).'/'.$this->common_month.'/01</td>';
			 }

			//value after depreciation
			 if ($i==1)
			 {
			 	$effective_principal=$current_principal_val-$depr_for_first_season;
			 	$this->deptemp.='<td style="text-align:center">'.number_format($effective_principal,2).'</td>';
			 }
			 else if ($i==2 || $i<=$useful_life+1) 
			 {
			 	$effective_principal=$current_principal_val-$depr_for_mid_season;
			  $this->deptemp.='<td style="text-align:center">'.number_format($effective_principal,2).'</td>';
			 }
			
			//next iteration 
			 $this->depr_calc_soy_method_partial($useful_life,$principal,$effective_principal,$i+1);
			}	
			else
			{
				$this->deptemp.='';
			}
		}
		
		else if ($this->common_month==4) 
		{
			if ($i<=$useful_life)
			{
			$value_after_depr=$current_principal_val-$depr_for_any_season;	
			 if ($i==0)
			 {
			 	$this->deptemp.='<td style="text-align:center">'.$this->common_year.'/'.$this->common_month.'/01</td>';
			 }
			 else
			 {
			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i).'/04/01</td>';
			 }
				$this->deptemp.='<td style="text-align:center">'.number_format($current_principal_val,2).'</td>';
				$this->deptemp.='<td style="text-align:center">'.number_format($current_useful_life+1).'</td>';
				$this->deptemp.='<td style="text-align:center">'.number_format($depr_for_any_season,2).'</td>';
				$this->deptemp.='<td style="text-align:center">(left blank)</td>';
				$this->deptemp.='<td style="text-align:center">'.number_format($value_after_depr,2).'</td>';
				$this->depr_calc_soy_method_partial($useful_life,$principal,$value_after_depr,$i+1);
			}

			else
			{
					$this->deptemp.='';
			}	
		}

		else
		{
			if ($i<=$useful_life+1)
			{		
			 if ($i==1) 
			 {
				$this->deptemp.='<td style="text-align:center">'.$this->common_year.'/'.$this->common_month.'/01</td>';
			 }

			 else
			 {
				$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i-1).'/04/01</td>';
			 }

			//current principal
			 $this->deptemp.='<td style="text-align:center">'.number_format($current_principal_val,2).'</td>';

			//useful life
			 if($i==1 || $i==$useful_life+1)
			 $this->deptemp.='<td style="text-align:center">'.number_format($current_useful_life).' (partial)</td>';
			else
			 $this->deptemp.='<td style="text-align:center">'.number_format($current_useful_life).'</td>';

			//depreciation amount
			 if($i==1) 	
			 	$this->deptemp.='<td style="text-align:center">'.number_format($depr_for_first_season,2).'</td>';
			 else if($i>1 && $i<=$useful_life+1)
			 	$this->deptemp.='<td style="text-align:center">'.number_format($depr_for_mid_season,2).'</td>';
 			 else
			 	$this->deptemp.='<td style="text-align:center">'.number_format($depr_for_last_season,2).'</td>';

			//end date
			  if ($i==1)
			 {
			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+1).'/03/31</td>';
			 }
			 else if ($i==2 || $i<$useful_life+1) 
			 {
			  $this->deptemp.='<td style="text-align:center">'.($this->common_year+$i).'/03/31</td>';
			 }
			 else
			 {
			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i-1).'/'.$this->common_month.'/01</td>';
			 }

			//value after depreciation
			  if ($i==1)
			 {
			 	$effective_principal=$current_principal_val-$depr_for_first_season;
			 	$this->deptemp.='<td style="text-align:center">'.number_format($effective_principal,2).'</td>';
			 }
			 else if ($i==2 || $i<=$useful_life+1) 
			 {
			 	$effective_principal=$current_principal_val-$depr_for_mid_season;
			  $this->deptemp.='<td style="text-align:center">'.number_format($effective_principal,2).'</td>';
			 }

			//next iteration
			 $this->depr_calc_soy_method_partial($useful_life,$principal,$effective_principal,$i+1);
			}	
			else
			{
				$this->deptemp.='';
			}		
		}	
			
		$this->deptemp.='</tr>';
		$this->deptemp.='</table>';
		//display end		
		return $this->deptemp;
	}


	public function depr_calc_straight_line_partial($principal,$pamt=0,$salvage_value,$useful_life,$i=0,$accdepprev=0)
	{
		$acc_dep=$accdepprev;
			/* setting header for depreciation for the first time */
		if ($this->deptemp_st_count==0)
		{
			$this->deptemp.='<table class="table table-striped tblDpr" style="border:0px"';
			$this->deptemp.='<tr>';
			$this->deptemp.='<th style="text-align:center">Start Date</th>';
			$this->deptemp.='<th style="text-align:center">Initial Book Value</th>';
			$this->deptemp.='<th style="text-align:center">Depreciation Value</th>';
			$this->deptemp.='<th style="text-align:center">Accumulative Depreciation Value</th>';
			$this->deptemp.='<th style="text-align:center">End Date</th>';
			$this->deptemp.='<th style="text-align:center">Value After Depreciation</th>';
			$this->deptemp.='</tr>';

			$this->deptemp_st_count=1;
		}
			$j=$i;

			$this->deptemp.='<tr>';
			$common_dep=($this->common_principal-$salvage_value)/$useful_life;//dep_formula
			
			$salvage_value=$salvage_value;
			
			/* calculating partial depreciation for months */
			if($this->common_month<=3)
			{
				$for_year1_dep_amt=((4-$this->common_month)/12)*$common_dep;
				$for_yearLast_dep_amt=(12-(4-$this->common_month))/12*$common_dep;				
			}
			elseif ($this->common_month==4) 
			{
				$for_year1_dep_amt=$common_dep;
				$for_yearLast_dep_amt=$common_dep;
			}
			else
			{
				$for_year1_dep_amt=(((12-$this->common_month+3)+1)/12)*$common_dep;
				$for_yearLast_dep_amt=(12-((12-$this->common_month+3)+1))/12*$common_dep;				
			}	

			$pamt_val_common=$principal-$common_dep;//principal_after_depreciation
			
			/* calculating accumulated depreciation */
			if($accdepprev==0)
			{
				$acc_dep=$for_year1_dep_amt;
				$depreciation_value=$for_year1_dep_amt;
				$pamt_val=$principal-$for_year1_dep_amt;
			}
			
			else if($i<$useful_life && $i>0)
			{
				$depreciation_value=$common_dep;
				$acc_dep +=$common_dep ;
				$for_yearLast_dep_amt=$common_dep;
				$pamt_val=$pamt_val_common;
			}
			else if($i==$useful_life)
			{
			$acc_dep=$acc_dep+$for_yearLast_dep_amt;
			$depreciation_value=$for_yearLast_dep_amt;
			$pamt_val=$principal-$for_yearLast_dep_amt;

			}
			
		if($principal<=0 || $principal<=$salvage_value)
		{
			$this->deptemp.='</tr>';
			return $this->deptemp;	
		}

		if($i<=$useful_life)
		{
			if ($this->common_month<=3)
			{
			 if ($i==0)
			 {
			 	$this->deptemp.='<td style="text-align:center">'.$this->common_year.'/'.$this->common_month.'/01</td>';
			 }
			 elseif ($i==1) 
			 {
			 	$this->deptemp.='<td style="text-align:center">'.$this->common_year.'/04/01</td>';
			 }
			 else
			 {
			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i-1).'/04/01</td>';
			 }	
			 
			 $this->deptemp.='<td style="text-align:center">'.number_format($principal,2).'</td>';
			 $this->deptemp.='<td style="text-align:center">'.number_format($depreciation_value,2).'</td>';
			 $this->deptemp.='<td style="text-align:center">'.number_format($acc_dep,2).'</td>';
			 
			 if ($i==0) 
			 {
			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year).'/03/31</td>';
			 }
			 else if ($i==$useful_life)
			 {
			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i).'/'.$this->common_month.'/01</td>';
			
			 }
			 else
			 {

			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i).'/03/31</td>';
			 }
			 $this->deptemp.='<td style="text-align:center">'.number_format($pamt_val,2).'</td>';
			 $this->depr_calc_straight_line_partial($pamt_val,$principal,$salvage_value,$useful_life,$j+1,$acc_dep);
			}

			else
			{
				if ($i==0)
			 {
			 	$this->deptemp.='<td style="text-align:center">'.$this->common_date.'</td>';
			 }
			 else
			 {
			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i).'/04/01</td>';
			 }	
			 
			 $this->deptemp.='<td style="text-align:center">'.number_format($principal,2).'</td>';
			 $this->deptemp.='<td style="text-align:center">'.number_format($depreciation_value,2).'</td>';
			 $this->deptemp.='<td style="text-align:center">'.number_format($acc_dep,2).'</td>';
			 if ($i==$useful_life)
			 {
			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i+1).'/'.$this->common_month.'/01</td>';
			
			 }
			 
			 else
			 {

			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i+1).'/03/31</td>';
			 }
			 $this->deptemp.='<td style="text-align:center">'.number_format($pamt_val,2).'</td>';
			 $this->depr_calc_straight_line_partial($pamt_val,$principal,$salvage_value,$useful_life,$j+1,$acc_dep);
			}
			
		}

		else
		{
			$this->deptemp.='';
		}

		
		$this->deptemp.='</tr>';
		return $this->deptemp;	
	}


	
	public function depr_calc_double_decl_partial($principal,$rate,$useful_life,$i=0,$accum_dep=0)
	{
		$acc_dep=$accum_dep;
			/* setting header for depreciation for the first time */
		if ($this->deptemp_st_count==0)
		{
			$this->deptemp.='<table class="table table-striped tblDpr" style="border:0px"';
			$this->deptemp.='<tr>';
			$this->deptemp.='<th style="text-align:center">Start Date</th>';
			$this->deptemp.='<th style="text-align:center">Initial Book Value</th>';
			$this->deptemp.='<th style="text-align:center">Depreciation Value</th>';
			$this->deptemp.='<th style="text-align:center">Accumulative Depreciation Value</th>';
			$this->deptemp.='<th style="text-align:center">End Date</th>';
			$this->deptemp.='<th style="text-align:center">Value After Depreciation</th>';
			$this->deptemp.='</tr>';


			$this->deptemp_st_count=1;
		}
			$j=$i;
			$this->deptemp.='<tr>';
		/*	
			$current_depreciation_value=current_principal*rate;
			current_end_book=current_principal-$current_depreciation_value; 
		*/	
			$common_dep=($principal)*$rate;
			//$pamt_val_common=$principal-$common_dep;

		/*Calculation for month-wise partial depreciation*/

			if($this->common_month<=3)
			{
				$initial_month_count=(4-$this->common_month);//1,2,3
				$for_year1_dep_amt=($initial_month_count/12)*$common_dep;
				$for_yearLast_dep_amt=((12-$initial_month_count)/12)*$common_dep;
			}
			elseif ($this->common_month==4) 
			{
				$for_year1_dep_amt=$common_dep;
				$for_yearLast_dep_amt=$common_dep;
			}
			else
			{
				$initial_month_count=((12-$this->common_month)+4);
				$for_year1_dep_amt=($initial_month_count/12)*$common_dep;
				$for_yearLast_dep_amt=((12-$initial_month_count)/12)*$common_dep;
			}	
		/*Calculation for month-wise partial depreciation ends*/

		/*business logic for depreciation*/
			if($i==0)
			{
				$depreciation_value=$for_year1_dep_amt;
				$acc_dep=$depreciation_value;
				$pamt_val=$principal-$for_year1_dep_amt;
			}
			else if($i<$useful_life && $i>0)
			{
				$depreciation_value=$common_dep;
				$acc_dep =$acc_dep+$depreciation_value ;
				$pamt_val=$principal-$common_dep;
			}
			else if($i==$useful_life)
			{
			// $depreciation_value=$for_yearLast_dep_amt;
				
				//echo 'the value at last iteration is'.$principal.'  '.$rate;die;3268, 25%
			$depreciation_value=$for_yearLast_dep_amt;
			$acc_dep=$acc_dep+$depreciation_value;
			$pamt_val=$principal-$depreciation_value;

			}
			if($principal<=0)
			{
				$this->deptemp.='</tr>';
				return $this->deptemp;	
			}
		/*business logic for depreciation.. ends*/

		/*displaying the depreciation*/
			
			
			if ($this->common_month<=3)
			{
				if($i<=$useful_life)
				{
				 if ($i==0)
				 {
				 	$this->deptemp.='<td style="text-align:center">'.$this->common_year.'/'.$this->common_month.'/01</td>';
				 }
				 elseif ($i==1) 
				 {
				 	$this->deptemp.='<td style="text-align:center">'.$this->common_year.'/04/01</td>';
				 }
				 else
				 {
				 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i-1).'/04/01</td>';
				 }	
				 
				 $this->deptemp.='<td style="text-align:center">'.number_format($principal,2).'</td>';


				 $this->deptemp.='<td style="text-align:center">'.number_format($depreciation_value,2).'</td>';
				 $this->deptemp.='<td style="text-align:center">'.number_format($acc_dep,2).'</td>';
				 
				 if ($i==0) 
				 {
				 	$this->deptemp.='<td style="text-align:center">'.($this->common_year).'/03/31</td>';
				 }
				 else if ($i==$useful_life)
				 {
				 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i).'/'.$this->common_month.'/01</td>';
				
				 }
				 else
				 {

				 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i).'/03/31</td>';
				 }
				 $this->deptemp.='<td style="text-align:center">'.number_format($pamt_val,2).'</td>';
				 $this->depr_calc_double_decl_partial($pamt_val,$rate,$useful_life,$j+1,$acc_dep);
				}

				else
				{
					$this->deptemp.='';
				}
			}

			else if ($this->common_month==4)
			{
				if($i<$useful_life)
				{
				 if ($i==0)
				 {
				 	$this->deptemp.='<td style="text-align:center">'.$this->common_year.'/'.$this->common_month.'/01</td>';
				 }
				 
				 else
				 {
				 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i).'/04/01</td>';
				 }	
				 
				 $this->deptemp.='<td style="text-align:center">'.number_format($principal,2).'</td>';


				 $this->deptemp.='<td style="text-align:center">'.number_format($depreciation_value,2).'</td>';
				 $this->deptemp.='<td style="text-align:center">'.number_format($acc_dep,2).'</td>';
				 
				 if ($i==0) 
				 {
				 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+1).'/03/31</td>';
				 }
				 else if ($i==$useful_life)
				 {
				 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i).'/'.$this->common_month.'/01</td>';
				
				 }
				 else
				 {

				 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i).'/03/31</td>';
				 }
				 $this->deptemp.='<td style="text-align:center">'.number_format($pamt_val,2).'</td>';
				 $this->depr_calc_double_decl_partial($pamt_val,$rate,$useful_life,$j+1,$acc_dep);
				}
				else
				{
					$this->deptemp.='';
				}
			}

			else
			{
				if($i<=$useful_life)
				{
					if ($i==0)
				 {
				 	$this->deptemp.='<td style="text-align:center">'.$this->common_date.'</td>';
				 }
				 else
				 {
				 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i).'/04/01</td>';
				 }	
				 
				 $this->deptemp.='<td style="text-align:center">'.number_format($principal,2).'</td>';
				 $this->deptemp.='<td style="text-align:center">'.number_format($depreciation_value,2).'</td>';
				 $this->deptemp.='<td style="text-align:center">'.number_format($acc_dep,2).'</td>';
				 if ($i==$useful_life)
				 {
				 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i+1).'/'.$this->common_month.'/01</td>';
				
				 }
				 
				 else
				 {

				 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i+1).'/03/31</td>';
				 }
				 $this->deptemp.='<td style="text-align:center">'.number_format($pamt_val,2).'</td>';
				 $this->depr_calc_double_decl_partial($pamt_val,$rate,$useful_life,$j+1,$acc_dep);
				}

				else
				{
					$this->deptemp.='';
				}
				
			}

			
		/*displaying the depreciation...ends*/
		
		$this->deptemp.='</tr>';
		return $this->deptemp;	
	}



	public function delete_assets()
	{
		$id=$this->input->post('id');
		if($id)
		{
			 //$this->general->save_log($this->table,'eqli_equipmentlistid',$id,$postdata=array(),'Delete');
			$this->db->delete('asen_assetentry',array('asen_asenid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}

 	public function get_column_wise_report($table1,$table2=false,$where=false,$select,$join=false,$jointype='INNER',$group_by,$order_by=false,$order='ASC')	
	{
		$this->db->select($select);
		$this->db->from($table1);
		if($table2){
		    if($join)
		    {
		        $this->db->join($table2,$join,$jointype);    
		    }
		}

		$this->db->group_by($group_by);
		if($where)
		{
		    $this->db->where($where);
		}
		if($order_by)
		{
		    $this->db->order_by($order_by,$order);
		}
		$qry=$this->db->get();
		    
	    if($qry->num_rows()>0)
	    {
	      return $qry->result();
	    }
	    return false;
  	}



	public function in_warrenty()
	{
		$this->db->select('count(*) as cnt');
		$this->db->from('asen_assetentry ae');
		$this->db->where('ae.asen_warrentydatebs >',CURDATE_NP);

		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}



	public function out_warrenty()
	{
		$this->db->select('count(*) as cnt');
		$this->db->from('asen_assetentry ae');
		$this->db->where('ae.asen_warrentydatebs <',CURDATE_NP);

		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}



	public function get_assets_list_data($srch=false,$limit=false,$offset=false,$order_by=false,$order=false)
	{
		$assettype = $this->input->post('asen_assettype');
      	$manufacture = $this->input->post('asen_manufacture');
      	$status = $this->input->post('asen_status');
      	$condition = $this->input->post('asen_condition');
      	$depreciation = $this->input->post('asen_depreciation');

		$this->db->select('*');
	    $this->db->from('asen_assetentry ae');
	    $this->db->join('asst_assetstatus as','as.asst_asstid=ae.asen_status','LEFT');
	    $this->db->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT');
	    $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT');
	    $this->db->join('manu_manufacturers ma','ma.manu_manlistid=ae.asen_manufacture','LEFT');
	    $this->db->join('dety_depreciation de','de.dety_depreciationid=ae.asen_depreciation','LEFT');
	    $this->db->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT');

	    if($srch)
      	{
         	$this->db->where($srch); 
      	}

	    if($assettype)
     	{
         	$this->db->where('ae.asen_assettype',$assettype);
     	}

		if($manufacture)
		{
			$this->db->where('ae.asen_manufacture',$manufacture);
		}

		if($status)
		{
			$this->db->where('ae.asen_status',$status);
		}

		if($condition)
		{
			$this->db->where('ae.asen_condition',$condition);
		}
		if($depreciation)
		{
			$this->db->where('ae.asen_depreciation',$depreciation);
		}

		if($limit && $limit>0)
	    {
	        $this->db->limit($limit);
	    }
	    if($offset)
	    {
	        $this->db->offset($offset);
	    }
	    if($order_by)
	    {
	        $this->db->order_by($order_by,$order);
	 	}

		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}


	public function get_assets($srchcol=false)
	{
		$this->db->select('eq.*, as.*');
		$this->db->from('itli_itemslist eq');
		$this->db->join('asen_assetentry as','as.asen_description = eq.itli_itemlistid');
	   // $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=eq.eqli_equipmenttypeid','LEFT');
		
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}

	public function get_assets_comment($srchcol = false){
	    $this->db->select('ec.*,um.usma_fullname');
	    $this->db->from('eqco_equipmentcomment ec');
	    $this->db->join('usma_usermain um','um.usma_userid=ec.eqco_postby','LEFT');
    	if($srchcol){
      		$this->db->where($srchcol);
    	}	
    	$this->db->order_by('eqco_equipmentcommentid','DESC');
    	$qry=$this->db->get();
  	
  		// echo $this->db->last_query();
		// die();
    
	    if($qry->num_rows()>0)
	    {
	    	return $qry->result();
	    }
	    return false;
  	}

	public function calculate_st_line_depr($depval,$principal_amount=false,$i=0,$useful_life, $pur_year, $pur_month, $pur_day)
	{
		if ($this->deptemp_st_count==0)
		{
			$this->deptemp.='<table class="table table-striped tblDpr" style="border:0px"';
			$this->deptemp.='<tr>';
			$this->deptemp.='<th style="text-align:center">Start Date</th>';
			$this->deptemp.='<th style="text-align:center">Initial Book Value</th>';
			$this->deptemp.='<th style="text-align:center">Depreciation Value</th>';
			$this->deptemp.='<th style="text-align:center">Accumulative Depreciation Value</th>';
			$this->deptemp.='<th style="text-align:center">End Date</th>';
			$this->deptemp.='<th style="text-align:center">Value After Depreciation</th>';
			$this->deptemp.='</tr>';

			$this->deptemp_st_count=1;
		}
		$j=$i;
		$this->deptemp.='<tr>';

		$start_year = $pur_year.'/04/01';
		$end_year = $pur_year.'/03/31';

		$pamt_val=$principal_amount-$depval;
		$acc_dep=$i*$depval;
		if($i<=$useful_life)
		{
		 	$this->deptemp.='<td style="text-align:center">'.$start_year.'</td>';
		 	$this->deptemp.='<td style="text-align:center">'.number_format($principal_amount,2).'</td>';
		 	$this->deptemp.='<td style="text-align:center">'.number_format($depval,2).'</td>';
		 	$this->deptemp.='<td style="text-align:center">'.number_format($acc_dep,2).'</td>';
		 	$this->deptemp.='<td style="text-align:center">'.$end_year.'</td>';
		 	$this->deptemp.='<td style="text-align:center">'.number_format($pamt_val,2).'</td>';
		 	$this->calculate_st_line_depr($depval,$pamt_val,$j+1,$useful_life,$pur_year+1,0,0);
		}
		else
		{
			$this->deptemp.='';
		}

		
		$this->deptemp.='</tr>';
		return $this->deptemp;	
	}


	public function calculate_partial_st_line_depr($depval,$principal_amount=false,$i=0,$useful_life, $pur_year, $pur_month, $pur_day)
	{
		if ($this->deptemp_st_count==0)
		{
			$this->deptemp.='<table class="table table-striped tblDpr" style="border:0px"';
			$this->deptemp.='<tr>';
			$this->deptemp.='<th style="text-align:center">Start Date</th>';
			$this->deptemp.='<th style="text-align:center">Initial Book Value</th>';
			$this->deptemp.='<th style="text-align:center">Depreciation Value</th>';
			$this->deptemp.='<th style="text-align:center">Accumulative Depreciation Value</th>';
			$this->deptemp.='<th style="text-align:center">End Date</th>';
			$this->deptemp.='<th style="text-align:center">Value After Depreciation</th>';
			$this->deptemp.='</tr>';

			$this->deptemp_st_count=1;
		}
		$j=$i;
		$this->deptemp.='<tr>';

		$start_year = $pur_year.'/04/01';
		$end_year = $pur_year.'/03/31';

		$pamt_val=$principal_amount-$depval;
		$acc_dep=$i*$depval;
		if($i<=$useful_life)
		{
		 $this->deptemp.='<td style="text-align:center">'.$start_year.'</td>';
		 $this->deptemp.='<td style="text-align:center">'.number_format($principal_amount,2).'</td>';
		 $this->deptemp.='<td style="text-align:center">'.number_format($depval,2).'</td>';
		 $this->deptemp.='<td style="text-align:center">'.number_format($acc_dep,2).'</td>';
		 $this->deptemp.='<td style="text-align:center">'.$end_year.'</td>';
		 $this->deptemp.='<td style="text-align:center">'.number_format($pamt_val,2).'</td>';
		 $this->calculate_st_line_depr($depval,$pamt_val,$j+1,$useful_life,$pur_year+1,0,0);
		}
		else
		{
			$this->deptemp.='';
		}

		$this->deptemp.='</tr>';
		return $this->deptemp;	
	}


	public function ddm_depr_calculation($principal,$pamt=0,$salvage_value,$useful_life,$i=0,$accdepprev=0)
	{
		$acc_dep=$accdepprev;
			/* setting header for depreciation for the first time */
		if ($this->deptemp_st_count==0)
		{
			$this->deptemp.='<table class="table table-striped tblDpr" style="border:0px"';
			$this->deptemp.='<tr>';
			$this->deptemp.='<th style="text-align:center">Start Date</th>';
			$this->deptemp.='<th style="text-align:center">Initial Book Value</th>';
			$this->deptemp.='<th style="text-align:center">Depreciation Value</th>';
			$this->deptemp.='<th style="text-align:center">Accumulative Depreciation Value</th>';
			$this->deptemp.='<th style="text-align:center">End Date</th>';
			$this->deptemp.='<th style="text-align:center">Value After Depreciation</th>';
			$this->deptemp.='</tr>';

			$this->deptemp_st_count=1;
		}
			$j=$i;

			$this->deptemp.='<tr>';
			$common_dep=($this->common_principal-$salvage_value)/$useful_life;//dep_formula
			
			$salvage_value=$salvage_value;
			
			/* calculating partial depreciation for months */
			if($this->common_month<=3)
			{
				$for_year1_dep_amt=((4-$this->common_month)/12)*$common_dep;
				$for_yearLast_dep_amt=(12-(4-$this->common_month))/12*$common_dep;				
			}
			elseif ($this->common_month==4) 
			{
				$for_year1_dep_amt=$common_dep;
				$for_yearLast_dep_amt=$common_dep;
			}
			else
			{
				$for_year1_dep_amt=(((12-$this->common_month+3)+1)/12)*$common_dep;
				$for_yearLast_dep_amt=(12-((12-$this->common_month+3)+1))/12*$common_dep;				
			}	

			$pamt_val_common=$principal-$common_dep;//principal_after_depreciation
			
			/* calculating accumulated depreciation */
			if($accdepprev==0)
			{
				$acc_dep=$for_year1_dep_amt;
				$depreciation_value=$for_year1_dep_amt;
				$pamt_val=$principal-$for_year1_dep_amt;
			}
			
			else if($i<$useful_life && $i>0)
			{
				$depreciation_value=$common_dep;
				$acc_dep +=$common_dep ;
				$for_yearLast_dep_amt=$common_dep;
				$pamt_val=$pamt_val_common;
			}
			else if($i==$useful_life)
			{
			$acc_dep=$acc_dep+$for_yearLast_dep_amt;
			$depreciation_value=$for_yearLast_dep_amt;
			$pamt_val=$principal-$for_yearLast_dep_amt;

			}
			
		if($principal<=0 || $principal<=$salvage_value)
		{
			$this->deptemp.='</tr>';
			return $this->deptemp;	
		}

		if($i<=$useful_life)
		{
			if ($this->common_month<=3)
			{
			 if ($i==0)
			 {
			 	$this->deptemp.='<td style="text-align:center">'.$this->common_year.'/'.$this->common_month.'/01</td>';
			 }
			 elseif ($i==1) 
			 {
			 	$this->deptemp.='<td style="text-align:center">'.$this->common_year.'/04/01</td>';
			 }
			 else
			 {
			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i-1).'/04/01</td>';
			 }	
			 
			 $this->deptemp.='<td style="text-align:center">'.number_format($principal,2).'</td>';
			 $this->deptemp.='<td style="text-align:center">'.number_format($depreciation_value,2).'</td>';
			 $this->deptemp.='<td style="text-align:center">'.number_format($acc_dep,2).'</td>';
			 
			 if ($i==0) 
			 {
			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year).'/03/31</td>';
			 }
			 else if ($i==$useful_life)
			 {
			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i).'/'.$this->common_month.'/01</td>';
			
			 }
			 else
			 {

			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i).'/03/31</td>';
			 }
			 $this->deptemp.='<td style="text-align:center">'.number_format($pamt_val,2).'</td>';
			 $this->depr_calc_straight_line_partial($pamt_val,$principal,$salvage_value,$useful_life,$j+1,$acc_dep);
			}

			else
			{
				if ($i==0)
			 {
			 	$this->deptemp.='<td style="text-align:center">'.$this->common_date.'</td>';
			 }
			 else
			 {
			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i).'/04/01</td>';
			 }	
			 
			 $this->deptemp.='<td style="text-align:center">'.number_format($principal,2).'</td>';
			 $this->deptemp.='<td style="text-align:center">'.number_format($depreciation_value,2).'</td>';
			 $this->deptemp.='<td style="text-align:center">'.number_format($acc_dep,2).'</td>';
			 if ($i==$useful_life)
			 {
			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i+1).'/'.$this->common_month.'/01</td>';
			
			 }
			 
			 else
			 {

			 	$this->deptemp.='<td style="text-align:center">'.($this->common_year+$i+1).'/03/31</td>';
			 }
			 $this->deptemp.='<td style="text-align:center">'.number_format($pamt_val,2).'</td>';
			 $this->depr_calc_straight_line_partial($pamt_val,$principal,$salvage_value,$useful_life,$j+1,$acc_dep);
			}
			
		}

		else
		{
			$this->deptemp.='';
		}

		
		$this->deptemp.='</tr>';
		return $this->deptemp;	
	}


	public function ddm_depr_calculation_new($firstcall=false,$assid,$purrate,$purdate,$deprate,$prvyrsaccdep=false,$status=false){
		$purchase_date= explode('/', $purdate);
		$year=$purchase_date[0];
		$month=$purchase_date[1];
		$days=$purchase_date[2];
		$next_yrs=$year+1;
		$prev_yrs=$year-1;

		if($month>=4 && $month<=12)
		{
			$fyrs=substr($year, 1).'/'.substr($next_yrs,2);
		}
		elseif($month>=1 && $month<=4)
		{
			$fyrs=substr($prev_yrs,1).'/'.substr($year,2);
		}

		/* setting header for depreciation for the first time */
		if ($this->deptemp_st_count==0)
		{
			$this->deptemp.='<table class="table table-striped tblDpr" style="border:0px"';
			$this->deptemp.='<tr>';
			$this->deptemp.='<th style="text-align:center">Start Date</th>';
			$this->deptemp.='<th style="text-align:center">Initial Book Value</th>';
			$this->deptemp.='<th style="text-align:center">Depreciation Value</th>';
			$this->deptemp.='<th style="text-align:center">Accumulative Depreciation Value</th>';
			$this->deptemp.='<th style="text-align:center">End Date</th>';
			$this->deptemp.='<th style="text-align:center">Value After Depreciation</th>';
			$this->deptemp.='</tr>';

			$this->deptemp_st_count=1;
		}

		$this->deptemp.='<tr>';


		// if($principal<=0 || $principal<=$salvage_value)
		// {
		// 	$this->deptemp.='</tr>';
		// 	return $this->deptemp;	
		// }


		if($firstcall==true)
		{


			if($month>=4 && $month <=9)
			{
				$mnthrate=3/3;
			}
			if($month>=10 && $month <=12)
			{
				$mnthrate=2/3;
			}

			if($month>=1 && $month <=3)
			{
				$mnthrate=1/3;
			}

			$dete_accmulateval=$purrate*($deprate/100)*$mnthrate;	
			$prev_yrs_acc_dep=0;
			$totaldeptilldateval=$dete_accmulateval+$prev_yrs_acc_dep;
			$netvalue=$purrate-$totaldeptilldateval;
			$prevyrsaccdep=$dete_accmulateval;


			 if(!empty($tempDepArray))
			 {
			 	// $this->db->insert('dete_depreciationtemp',$tempDepArray);
			 	$this->deptemp.= '<td style="text-align:center">'.$purdate.'</td>';
			 	$this->deptemp.= '<td style="text-align:center">'.$totaldeptilldateval.'</td>';
			 	$this->deptemp.= '<td style="text-align:center">'.$netvalue.'</td>';
			 	$this->deptemp.= '<td style="text-align:center">'.$prevyrsaccdep.'</td>';
			 	$this->deptemp.= '<td style="text-align:center">'.$dete_accmulateval.'</td>';
			 }

			 $this->deptemp.='</tr>';
			 $this->ddm_depr_calculation(false,$assid,$netvalue,$purdate,$deprate,$prevyrsaccdep,'go');
		}else{
			$dete_accmulateval=$purrate*($deprate/100);	
			$prev_yrs_acc_dep=$dete_accmulateval;
			$totaldeptilldateval=$prvyrsaccdep+$prev_yrs_acc_dep;
			$netvalue=$purrate-$dete_accmulateval;

			$check_orginal_n_prevaccdep=$this->orginalcost-$prvyrsaccdep;
		

			$new_netval=round($netvalue,2);


			if((float)$new_netval=='0.00')
			{
				$stus='stop';
			}
			else
			{
				$stus='go';
			}

			//
			// $tempDepArray = array();

			if(!empty($tempDepArray))
			 {
			 	// $this->db->insert('dete_depreciationtemp',$tempDepArray);
			 	$this->deptemp.= '<td style="text-align:center">'.$purdate.'</td>';
			 	$this->deptemp.= '<td style="text-align:center">'.$totaldeptilldateval.'</td>';
			 	$this->deptemp.= '<td style="text-align:center">'.$netvalue.'</td>';
			 	$this->deptemp.= '<td style="text-align:center">'.$prevyrsaccdep.'</td>';
			 	$this->deptemp.= '<td style="text-align:center">'.$dete_accmulateval.'</td>';
			 }


			if($stus=='go')
			{
				if(!empty($tempDepArray))
			 	{
			 		if(!empty($tempDepArray))
					 {
					 	// $this->db->insert('dete_depreciationtemp',$tempDepArray);
					 	$this->deptemp.= '<td style="text-align:center">'.$purdate.'</td>';
					 	$this->deptemp.= '<td style="text-align:center">'.$totaldeptilldateval.'</td>';
					 	$this->deptemp.= '<td style="text-align:center">'.$netvalue.'</td>';
					 	$this->deptemp.= '<td style="text-align:center">'.$prevyrsaccdep.'</td>';
					 	$this->deptemp.= '<td style="text-align:center">'.$dete_accmulateval.'</td>';
					 }

			 		$this->deptemp.='</tr>';	
			 	}

			 	$this->ddm_depr_calculation(false,$assid,$netvalue,$purdate,$deprate,$totaldeptilldateval,$stus); 
			}else{
				$tempDepArray = array();

				if(!empty($tempDepArray)){
					//

					$this->deptemp.='</tr>';
					return $this->deptemp;	
				}
			}
		}
	}

}
