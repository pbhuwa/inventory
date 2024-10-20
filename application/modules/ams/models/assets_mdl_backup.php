<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assets_mdl extends CI_Model 
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
		array('field' => 'asen_assetcode', 'label' => 'Asset Code', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'asen_assettype', 'label' => 'Assets Type', 'rules' => 'trim|required|xss_clean'),
        // array('field' => 'asen_description', 'label' => 'Assets Description', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'asen_status', 'label' => 'Assets Status', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'asen_condition', 'label' => 'Assets Condition', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'asen_purchaserate', 'label' => 'Assets Purchase Rate', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'asen_marketvalue', 'label' => 'Assets Market Value', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'asen_scrapvalue', 'label' => 'Assets Scrap Value', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'asen_expectedlife', 'label' => 'Assets Expected Life', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'asen_recoveryperiod', 'label' => 'Assets Revovery Period', 'rules' => 'trim|required|xss_clean'),
       );  

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


	public function get_assets_category($srchcol=false)
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
	
	public function get_all_assets_list($cond = false){  	
		$frmDate=!empty($this->input->get('frmDate'))?$this->input->get('frmDate'):CURMONTH_DAY1;
        $toDate=!empty($this->input->get('toDate'))?$this->input->get('toDate'):DISPLAY_DATE;
        $dateSearch = $this->input->get('dateSearch');
		if($frmDate &&  $toDate)
        {
           	if(DEFAULT_DATEPICKER=='NP')
           	{
             	$this->db->where(array('asen_purchasedatebs >='=>$frmDate,'asen_purchasedatebs <='=>$toDate));
            }
            else
            {
                $this->db->where(array('asen_purchasedatead >='=>$frmDate,'asen_purchasedatead <='=>$toDate));
            }
        }
     
        if($dateSearch == "purchasedate")
        {
            if($frmDate &&  $toDate)
            {                  
                if(DEFAULT_DATEPICKER=='NP')
                {
                    $this->db->where(array('asen_purchasedatebs >='=>$frmDate,'asen_purchasedatebs <='=>$toDate));
                }
                else
                {
                    $this->db->where(array('asen_purchasedatead >='=>$frmDate,'asen_purchasedatead <='=>$toDate));
                }
            }
        }

        if($dateSearch == "inservicedate")
        {
            if($frmDate &&  $toDate)
            {
            
                if(DEFAULT_DATEPICKER=='NP')
				{
					$this->db->where(array('asen_inservicedatebs >='=>$frmDate,'asen_inservicedatebs <='=>$toDate));
				}
				else
				{
				  	$this->db->where(array('asen_inservicedatead >='=>$frmDate,'asen_inservicedatead <='=>$toDate));
				}
            }
        }

        if($dateSearch == "warrentydate")
        {
            if($frmDate &&  $toDate)
            {
            	if(DEFAULT_DATEPICKER=='NP')
                {
                 	$this->db->where(array('asen_warrentydatebs >='=>$frmDate,'asen_warrentydatebs <='=>$toDate));
                }
                else
                {
                    $this->db->where(array('asen_warrentydatead >='=>$frmDate,'asen_warrentydatead <='=>$toDate));
                }
            }
        }

		$get = $_GET;
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}

       	if(!empty($get['sSearch_0'])){
            $this->db->where("asen_assetcode like  '%".$get['sSearch_0']."%'  ");
        }
		if(!empty($get['sSearch_1'])){
            $this->db->where("ec.eqca_category like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  ");
        }
       	if(!empty($get['sSearch_3'])){
            $this->db->where("asen_modelno like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("asen_serialno like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("asst_statusname like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("asco_conditionname like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
         	if(DEFAULT_DATEPICKER=='NP')
			{
				$this->db->where("asen_purchasedatebs like  '%".$get['sSearch_7']."%'  ");
			}
			else{
				$this->db->where("asen_purchasedatead like  '%".$get['sSearch_7']."%'  ");
			}
        }

        if(!empty($get['sSearch_8'])){
         	if(DEFAULT_DATEPICKER=='NP')
			{
				$this->db->where("asen_warrentydatebs like  '%".$get['sSearch_8']."%'  ");
			}
			else{
				$this->db->where("asen_warrentydatead like  '%".$get['sSearch_8']."%'  ");
			}
        }

        if($cond) {
            $this->db->where($cond);
        }

        //  $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        // $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');


        // if($frmDate &&  $toDate){
        //     if(DEFAULT_DATEPICKER=='NP')
        //     {
        //       $this->db->where('asen_purchasedatebs >=', $frmDate);
        //       $this->db->where('asen_purchasedatebs <=', $toDate);
        //     }
        //     else
        //     {
        //       $this->db->where('asen_purchasedatead >=', $frmDate);
        //       $this->db->where('asen_purchasedatead <=', $toDate);
        //     }
        // }


      	$resltrpt=$this->db->select("asen_assetcode")
      					->from('asen_assetentry ae')
					    ->join('asst_assetstatus as','as.asst_asstid=ae.asen_status','LEFT')
					    ->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT')
					    ->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT')
					    ->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT')
					    ->join('xw_dist_distributors dt','dt.dist_distributorid=ae.asen_distributor','LEFT')
      					->get()
      					->result();
	    // echo $this->db->last_query();die(); 
      	$totalfilteredrecs=sizeof($resltrpt); 

      	$order_by = '';
      	$order = 'desc';
      	if($this->input->get('sSortDir_0'))
  		{
  			$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'asen_assetcode';
        if($this->input->get('iSortCol_0')==1)
        	$order_by = 'eqca_category';
        else if($this->input->get('iSortCol_0')==2)
        	$order_by = 'itli_itemname';
      	else if($this->input->get('iSortCol_0')==3)
        	$order_by = 'asen_modelno';
      	else if($this->input->get('iSortCol_0')==4)
       		$order_by = 'asen_serialno';
       		else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'asst_statusname';
       	else if($this->input->get('iSortCol_0')==6)
      	 	$order_by = 'asco_conditionname';

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
            $this->db->where("asen_assetcode like  '%".$get['sSearch_0']."%'  ");
        }
		if(!empty($get['sSearch_1'])){
            $this->db->where("ec.eqca_category like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  ");
        }
       	if(!empty($get['sSearch_3'])){
            $this->db->where("asen_modelno like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("asen_serialno like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("asst_statusname like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("asco_conditionname like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
         	if(DEFAULT_DATEPICKER=='NP')
			{
				$this->db->where("asen_purchasedatebs like  '%".$get['sSearch_7']."%'  ");
			}
			else{
				$this->db->where("asen_purchasedatead like  '%".$get['sSearch_7']."%'  ");
			}
        }

        if(!empty($get['sSearch_8'])){
         	if(DEFAULT_DATEPICKER=='NP')
			{
				$this->db->where("asen_warrentydatebs like  '%".$get['sSearch_8']."%'  ");
			}
			else{
				$this->db->where("asen_warrentydatead like  '%".$get['sSearch_8']."%'  ");
			}
        }

        if($cond) {
            $this->db->where($cond);
        }

        //  $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        // $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        
        // if($frmDate &&  $toDate){
        //     if(DEFAULT_DATEPICKER=='NP')
        //     {
        //       $this->db->where('asen_purchasedatebs >=', $frmDate);
        //       $this->db->where('asen_purchasedatebs <=', $toDate);
        //     }
        //     else
        //     {
        //       $this->db->where('asen_purchasedatead >=', $frmDate);
        //       $this->db->where('asen_purchasedatead <=', $toDate);
        //     }
        // }

		if($frmDate &&  $toDate)
        {
           	if(DEFAULT_DATEPICKER=='NP')
            {
            	$this->db->where(array('asen_purchasedatebs >='=>$frmDate,'asen_purchasedatebs <='=>$toDate));
            }
            else
            {
                $this->db->where(array('asen_purchasedatead >='=>$frmDate,'asen_purchasedatead <='=>$toDate));
            }
        }
     
        if($dateSearch == "purchasedate")
        {
            if($frmDate &&  $toDate)
            {                  
				if(DEFAULT_DATEPICKER=='NP')
				{
					$this->db->where(array('asen_purchasedatebs >='=>$frmDate,'asen_purchasedatebs <='=>$toDate));
				}
				else
				{
					$this->db->where(array('asen_purchasedatead >='=>$frmDate,'asen_purchasedatead <='=>$toDate));
				}
            }
            
        }
        if($dateSearch == "inservicedate")
        {
            if($frmDate &&  $toDate)
            {
				if(DEFAULT_DATEPICKER=='NP')
				{
					$this->db->where(array('asen_inservicedatebs >='=>$frmDate,'asen_inservicedatebs <='=>$toDate));
				}
				else
				{
				  	$this->db->where(array('asen_inservicedatead >='=>$frmDate,'asen_inservicedatead <='=>$toDate));
				}
            }
        }
        if($dateSearch == "warrentydate")
        {
            if($frmDate &&  $toDate)
            {
				if(DEFAULT_DATEPICKER=='NP')
				{
					$this->db->where(array('asen_warrentydatebs >='=>$frmDate,'asen_warrentydatebs <='=>$toDate));
				}
				else
				{
				  	$this->db->where(array('asen_warrentydatead >='=>$frmDate,'asen_warrentydatead <='=>$toDate));
				}
            }
        }
       
        $this->db->select('*');
	    $this->db->from('asen_assetentry ae');
	    $this->db->join('asst_assetstatus as','as.asst_asstid=ae.asen_status','LEFT');
	    $this->db->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT');
	    $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT');
	    $this->db->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT');
	    $this->db->join('xw_dist_distributors dt','dt.dist_distributorid=ae.asen_distributor','LEFT');

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

	public function depr_calc_straight_line($depval,$principal_amount=false,$i=0,$useful_life)
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

		$pamt_val=$principal_amount-$depval;
		$acc_dep=$i*$depval;
		if($i<=$useful_life)
		{
		 $this->deptemp.='<td style="text-align:center">(left blank)</td>';
		 $this->deptemp.='<td style="text-align:center">'.number_format($principal_amount,2).'</td>';
		 $this->deptemp.='<td style="text-align:center">'.number_format($depval,2).'</td>';
		 $this->deptemp.='<td style="text-align:center">'.number_format($acc_dep,2).'</td>';
		 $this->deptemp.='<td style="text-align:center">(left blank)</td>';
		 $this->deptemp.='<td style="text-align:center">'.number_format($pamt_val,2).'</td>';
		 $this->depr_calc_straight_line($depval,$pamt_val,$j+1,$useful_life);
		}
		else
		{
			$this->deptemp.='';
		}

		
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

	public function depr_calc_units_of_production_method($init_p_value=false,$principal_amt,$unit_counter=0,$unit,$useful_life)
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

			$this->deptemp.='<td style="text-align:center">(left blank)</td>';
			$this->deptemp.='<td style="text-align:center">'.number_format($principal_amt,2).'</td>';
			$this->deptemp.='<td style="text-align:center">'.number_format($unit_of_that_season).'</td>';
			$this->deptemp.='<td style="text-align:center">(left blank)</td>';
			$this->deptemp.='<td style="text-align:center">'.number_format($depr_for_that_season,2).'</td>';
			$this->deptemp.='<td style="text-align:center">'.number_format($value_after_depr,2).'</td>';
			$this->depr_calc_units_of_production_method($init_p_value,$value_after_depr,$unit_counter+1,$unit,$useful_life);
		}
		else
		{
				$this->deptemp.='';
		}

		$this->deptemp.='</tr>';
		$this->deptemp.='</table>';

		return $this->deptemp;	
	}
	
	
	public function depr_calc_soy_method($useful_life,$principal,$current_principal_val,$i=0)
	{
		$useful_years_list=range(1, $useful_life); // uyl[0] => 1,uyl[1] => 2 and so on...
		$useful_years_sum=array_sum($useful_years_list);

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
			
			$this->deptemp_soy_count=1;
		}
			
		if ($i<=$useful_life)
		{
			$current_useful_life=$useful_life-$i;
			$depr_for_that_season=(($current_useful_life+1)/$useful_years_sum)*($principal);	
			$value_after_depr=$current_principal_val-$depr_for_that_season;

			$this->deptemp.='</tr>';
			$this->deptemp.='<td>(left blank)</td>';
			$this->deptemp.='<td style="text-align:center">'.number_format($current_principal_val,2).'</td>';
			$this->deptemp.='<td style="text-align:center">'.number_format($current_useful_life+1).'</td>';
			$this->deptemp.='<td style="text-align:center">'.number_format($depr_for_that_season,2).'</td>';
			$this->deptemp.='<td style="text-align:center">(left blank)</td>';
			$this->deptemp.='<td style="text-align:center">'.number_format($value_after_depr,2).'</td>';
			$this->depr_calc_soy_method($useful_life,$principal,$value_after_depr,$i+1);
		}	
		else
		{
			$this->deptemp.='';
		}
			
		$this->deptemp.='</tr>';
		$this->deptemp.='</table>';		
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
		// $this->db->select('eq.*, as.*');
		$this->db->select('eq.*');
		$this->db->from('itli_itemslist eq');
		// $this->db->join('asen_assetentry as','as.asen_description = eq.itli_itemlistid');
		$this->db->group_by('itli_itemlistid');
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

	public function get_assets_data($srchcol=false)
	{
		$this->db->select('il.itli_itemname, as.asen_assetcode');
		$this->db->from('itli_itemslist il');
		$this->db->join('asen_assetentry as','as.asen_description = il.itli_itemlistid');
	   
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

	public function get_asset_list($cond=false)
	{
	 	$get = $_GET;
 
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
      	if(!empty($get['sSearch_0'])){
            $this->db->where("asen_asenid like  '%".$get['sSearch_0']."%' ");
        }
        if(!empty($get['sSearch_1'])){
            $this->db->where("asen_assetcode like  '%".$get['sSearch_1']."%' ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("ma.manu_manlst like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("ac.asco_conditionname like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("ae.asen_warrentydatead like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("ae.asen_warrentydatebs like  '%".$get['sSearch_6']."%'  ");
        }
     
      	if($this->session->userdata(USER_ACCESS_TYPE)=='S')
      	{
        	$this->db->where('asen_orgid',$this->session->userdata(ORG_ID));
      	}
       	if($cond) {
          	$this->db->where($cond);
        }

      	$resltrpt=$this->db->select("COUNT(*) as cnt")
            			->from('asen_assetentry ae')			    
					    ->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT')
					    ->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT')
					    ->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT')
					    ->join('manu_manufacturers ma','ma.manu_manlistid=ae.asen_manufacture','LEFT')
	    				->join('xw_dist_distributors dt','dt.dist_distributorid=ae.asen_distributor','LEFT')
						->get()
						->row();
      	
      	$totalfilteredrecs=$resltrpt->cnt;
      	// echo $totalfilteredrecs;
      	// die();

      	$order_by = 'ae.asen_asenid';
      	$order = 'desc';
  
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'ae.asen_asenid';
     	else if($this->input->get('iSortCol_0')==1)
        	$order_by = 'ae.asen_assetcode';
      	else if($this->input->get('iSortCol_0')==2)
        	$order_by = 'il.itli_itemname';
      	else if($this->input->get('iSortCol_0')==3)
       		$order_by = 'ma.manu_manlst';
      	else if($this->input->get('iSortCol_0')==4)
       		$order_by = 'ac.asco_conditionname';
   		else if($this->input->get('iSortCol_0')==5)
       		$order_by = 'asen_warrentydatead';
   		else if($this->input->get('iSortCol_0')==6)
       		$order_by = 'asen_warrentydatebs';
      
      	if($this->input->get('sSortDir_0')=='desc')
        	$order = 'desc';
      	else if($this->input->get('sSortDir_0')=='asc')
        	$order = 'asc';

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
            $this->db->where("asen_asenid like  '%".$get['sSearch_0']."%' ");
        }
        if(!empty($get['sSearch_1'])){
            $this->db->where("asen_assetcode like  '%".$get['sSearch_1']."%' ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("ma.manu_manlst like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("ac.asco_conditionname like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("ae.asen_warrentydatead like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("ae.asen_warrentydatebs like  '%".$get['sSearch_6']."%'  ");
        }
		
		$this->db->select('ae.asen_asenid, ae.asen_assetcode,	ae.asen_warrentydatead, ae.asen_brand,ae.asen_warrentydatebs, il.itli_itemname, ac.asco_conditionname, ec.eqca_category,ma.manu_manlst,dt.dist_distributor');
      	$this->db->from('asen_assetentry ae');
	    $this->db->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT');
	    $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT');
	    $this->db->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT');
	    $this->db->join('manu_manufacturers ma','ma.manu_manlistid=ae.asen_manufacture','LEFT');
	    $this->db->join('xw_dist_distributors dt','dt.dist_distributorid=ae.asen_distributor','LEFT');

       	if($this->session->userdata(USER_ACCESS_TYPE)=='S')
      	{
        	$this->db->where('asen_orgid',$this->session->userdata(ORG_ID));
      	}

        if($cond) {
          	$this->db->where($cond);
        }
        $this->db->order_by($order_by,$order);
        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }
      
       	$nquery=$this->db->get();
        //echo $this->db->last_query(); die();
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

	public function get_asset_item($cond=false)
	{
	 	$get = $_GET;
 
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
      	if(!empty($get['sSearch_0'])){
            $this->db->where("asen_asenid like  '%".$get['sSearch_0']."%' ");
        }
        if(!empty($get['sSearch_1'])){
            $this->db->where("asen_assetcode like  '%".$get['sSearch_1']."%' ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("asen_brand like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("manu_manlst like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_5']."%'  ");
        } 
     
      	if($this->session->userdata(USER_ACCESS_TYPE)=='S')
      	{
        	$this->db->where('asen_orgid',$this->session->userdata(ORG_ID));
     	}
       	if($cond) {
          	$this->db->where($cond);
        }

      	$resltrpt=$this->db->select("COUNT(*) as cnt")
            			->from('asen_assetentry ae')
					    ->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT')
					    ->join('manu_manufacturers ma','ma.manu_manlistid=ae.asen_manufacture','LEFT')
	    				->join('xw_dist_distributors dt','dt.dist_distributorid=ae.asen_distributor','LEFT')
            			->get()
            			->row();
      	
      	$totalfilteredrecs=$resltrpt->cnt;
      	// echo $totalfilteredrecs;
      	// die();

      	$order_by = 'ae.asen_asenid';
      	$order = 'desc';
  
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'ae.asen_asenid';
      	else if($this->input->get('iSortCol_0')==1)
        	$order_by = 'ae.asen_assetcode';
      	else if($this->input->get('iSortCol_0')==2)
        	$order_by = 'il.itli_itemname';
      	else if($this->input->get('iSortCol_0')==3)
       		$order_by = 'ma.manu_manlst';
      	else if($this->input->get('iSortCol_0')==4)
       		$order_by = 'ac.asco_conditionname';
   		else if($this->input->get('iSortCol_0')==5)
       		$order_by = 'asen_warrentydatead';
   		else if($this->input->get('iSortCol_0')==6)
       		$order_by = 'asen_warrentydatebs';
      
      	if($this->input->get('sSortDir_0')=='desc')
        	$order = 'desc';
      	else if($this->input->get('sSortDir_0')=='asc')
        	$order = 'asc';

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
            $this->db->where("asen_asenid like  '%".$get['sSearch_0']."%' ");
        }
        if(!empty($get['sSearch_1'])){
            $this->db->where("asen_assetcode like  '%".$get['sSearch_1']."%' ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("asen_brand like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("manu_manlst like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_5']."%'  ");
        }
		
		$this->db->select('ae.asen_asenid, ae.asen_assetcode,ae.asen_brand, il.itli_itemname,  ma.manu_manlst,dt.dist_distributor');
      	$this->db->from('asen_assetentry ae');
	    $this->db->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT');
	    $this->db->join('manu_manufacturers ma','ma.manu_manlistid=ae.asen_manufacture','LEFT');
	    $this->db->join('xw_dist_distributors dt','dt.dist_distributorid=ae.asen_distributor','LEFT');

       	if($this->session->userdata(USER_ACCESS_TYPE)=='S')
      	{
        	$this->db->where('asen_orgid',$this->session->userdata(ORG_ID));
      	}

        if($cond) {
          	$this->db->where($cond);
        }
        $this->db->order_by($order_by,$order);
        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }
      
       	$nquery=$this->db->get();
        //echo $this->db->last_query(); die();
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

	public function get_assets_detail($srch=false)
	{
		$this->db->select('ae.*, il.itli_itemname, ac.asco_conditionname, ma.manu_manlst,dt.dist_distributor,as.asst_statusname,eqca_category,dept_depname');
      	$this->db->from('asen_assetentry ae');
	    $this->db->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT');
	    $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT');
	    $this->db->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT');
	    $this->db->join('asst_assetstatus as','ae.asen_status=as.asst_asstid','LEFT');
	    $this->db->join('eqco_equipmentcomment eco','eco.eqco_eqid=ae.asen_asenid');
	    $this->db->join('eqas_equipmentassign ea','ea.eqas_equipid=eco.eqco_eqid','LEFT');
	    $this->db->join('dept_department dp','dp.dept_depid=ea.eqas_equipdepid','LEFT');
	    $this->db->join('manu_manufacturers ma','ma.manu_manlistid=ae.asen_manufacture','LEFT');
	    $this->db->join('xw_dist_distributors dt','dt.dist_distributorid=ae.asen_distributor','LEFT');
	    if($srch){
	    	$this->db->where($srch);
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
}
