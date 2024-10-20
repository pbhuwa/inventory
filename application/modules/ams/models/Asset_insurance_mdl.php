<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asset_insurance_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='asin_assetinsurance';
		$this->curtime=$this->general->get_currenttime();
        $this->userid=$this->session->userdata(USER_ID);
        $this->username = $this->session->userdata(USER_NAME);
        $this->depid = $this->session->userdata(USER_DEPT);
        $this->storeid = $this->session->userdata(STORE_ID);
        $this->mac=$this->general->get_Mac_Address();
        $this->ip=$this->general->get_real_ipaddr();
        $this->locationid=$this->session->userdata(LOCATION_ID);
	}

	public $validate_settings_asset_insurance = array(               
         array('field' => 'asin_companyid', 'label' => 'Insurance Company ', 'rules' => 'trim|required|xss_clean'),
         array('field' => 'asin_typeid', 'label' => 'Insurance Type ', 'rules' => 'trim|required|xss_clean'),
          array('field' => 'asin_renewalperiod', 'label' => 'Renewal Period', 'rules' => 'trim|required|xss_clean'),
       );
	
	public function asset_insurance_save()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		unset($postdata['id']);
		$asset_id=$this->input->post('amta_equipid');
		unset($postdata['amta_equipid']);

		if($id)
		{
		$postdata['asin_modifydatead']=CURDATE_EN;
		$postdata['asin_modifydatebs']=CURDATE_NP;
		$postdata['asin_modifytime']=date('H:i:s');
		$postdata['asin_modifyby']=$this->session->userdata(USER_ID);
		$postdata['asin_modifyip']=$this->general->get_real_ipaddr();
		$postdata['asin_modifymac']=$this->general->get_Mac_Address();
		if(!empty($postdata))
		{
			$this->db->update($this->table,$postdata,array('asin_asinid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			else
			{
				return false;
			}
		}
	}
		else
		{
		$postdata['asin_assetid']=$asset_id;
		$postdata['asin_postdatead']=CURDATE_EN;
		$postdata['asin_postdatebs']=CURDATE_NP;
		$postdata['asin_posttime']=date('H:i:s');
		$postdata['asin_postby']=$this->session->userdata(USER_ID);
		$postdata['asin_orgid']=$this->session->userdata(ORG_ID);
		$postdata['asin_postip']=$this->general->get_real_ipaddr();
		$postdata['asin_postmac']=$this->general->get_Mac_Address();
		$postdata['asin_locationid']=$this->session->userdata(LOCATION_ID);
		
		// echo "<pre>";
		// print_r($postdata);
		// die();

		if(!empty($postdata))
		{
			$this->db->insert($this->table,$postdata);
			$insertid=$this->db->insert_id();
			if($insertid)
			{
				return $insertid;
			}
			else
			{
				return false;
			}
		}
	}
		
		return false;

	}

	public function get_all_asset_insurance($srorgal=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$this->input->post();
		$this->db->select('*,i.inty_name,p.peri_name,a.asen_assetcode,ic.inco_name');
		$this->db->from('asin_assetinsurance as');
		$this->db->join('inty_insurancetype i','i.inty_intyid = as.asin_typeid');
		$this->db->join('peri_period p','p.peri_periid = as.asin_renewalperiod');
		$this->db->join('asen_assetentry a','a.asen_asenid = as.asin_assetid');
		$this->db->join('inco_insurancecompany ic','ic.inco_id = as.asin_companyid');


		if($srorgal)
		{
			$this->db->where($srorgal);
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

	public function remove_asset_insurance()
	{
		$id=$this->input->post('id');
		if($id)
		{
			$this->db->delete($this->table,array('asin_asinid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}



	public function check_exist_asin_name_for_other($asin_name = false, $id = false){
		$data = array();
		if($asin_name)
		{
				$this->db->where('asin_companyid',$asin_name);
		}
		if($id)
		{
			$this->db->where('asin_asinid!=',$id);
		}

		$query = $this->db->get($this->table);
		// echo $this->db->last_query();
		// die();

		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
	}

//for server model

	public function get_itemslist_from_inventory($cond = false)
    {
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("asen_assetcode like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("inco_name like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("inty_name like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("peri_name like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
        	$this->db->where("asin_insuranceamount like '%".$get['sSearch_5']."%' ");
        }

        if(!empty($get['sSearch_6'])){
            $this->db->where("asin_startdatead like  '%".$get['sSearch_6']."%'  ");
        }

        if(!empty($get['sSearch_7'])){
            $this->db->where("asin_enddatead like  '%".$get['sSearch_7']."%'  ");
        }
        //   if(!empty($get['sSearch_8'])){
        //     $this->db->where("asin_policyno like  '%".$get['sSearch_8']."%'  ");
        // }

        // if(!empty($get['sSearch_7'])){
        //     $this->db->where("asin_insurancerate like  '%".$get['sSearch_7']."%'  ");
        // }

        // if(!empty($get['sSearch_8'])){
        //     $this->db->where("dist_distributor like  '%".$get['sSearch_8']."%'  ");
        // }

        // if($cond) {
        //   $this->db->where($cond);
        // }
        // $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
          
        if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('as.asin_startdatead >=',$frmDate);
                $this->db->where('as.asin_startdatead <=',$toDate);    
            }else{
                $this->db->where('as.asin_startdatead >=',$frmDate);
                $this->db->where('as.asin_startdatead <=',$toDate);
            }
        }
     //     if($this->location_ismain=='Y')
     //    {
     //        if($input_locationid)
     //        {
     //            $this->db->where('tf.tfma_locationid',$input_locationid);
     //        }
     //    }
     //    else
     //    {
     //        $this->db->where('tf.tfma_locationid',$this->locationid);
     //    }
    	
    	// $where = "(trma_transactiontype = 'OPENING' or trma_transactiontype = 'PURCHASE' or trma_transactiontype = 'D.RECEIVE')";
        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    //->from('sama_salemaster rn')
                    ->from('asin_assetinsurance as')
					->join('inty_insurancetype i','i.inty_intyid = as.asin_typeid','LEFT')
					->join('peri_period p','p.peri_periid = as.asin_renewalperiod','LEFT')
					->join('asen_assetentry a','a.asen_asenid = as.asin_assetid','LEFT')
					->join('inco_insurancecompany ic','ic.inco_id = as.asin_companyid','LEFT')
                   // ->where('asin_typeid','1')
                
                    ->get()
                    ->row();

        //echo $this->db->last_query();die(); 
        $totalfilteredrecs=($resltrpt->cnt); 
        $order_by = 'asin_asinid';
        $order = 'desc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
        $where='';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'asen_assetcode';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'inco_name';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'inty_name';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'peri_name';
        else if($this->input->get('iSortCol_0')==5)
        	$order_by='asin_insuranceamount';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'asin_startdatead';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'asin_enddatead';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'asin_insurancerate';
         // else if($this->input->get('iSortCol_0')==9)
         //    $order_by = 'asin_policyno';
        // else if($this->input->get('iSortCol_0')==8)
        //     $order_by = 'dist_distributor';
        // else if($this->input->get('iSortCol_0')==9)
        //     $order_by = 'trde_requiredqty';
        // else if($this->input->get('iSortCol_0')==10)
        //     $order_by = 'trde_selprice';
        // else if($this->input->get('iSortCol_0')==11)
        //     $order_by = 'recm_amount';
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

       if(!empty($get['sSearch_1'])){
            $this->db->where("asen_assetcode like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("inco_name like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("inty_name like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("peri_name like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
        	$this->db->where("asin_insuranceamount like '%".$get['sSearch_5']."%' ");
        }

        if(!empty($get['sSearch_6'])){
            $this->db->where("asin_startdatead like  '%".$get['sSearch_6']."%'  ");
        }

        if(!empty($get['sSearch_7'])){
            $this->db->where("asin_enddatead like  '%".$get['sSearch_7']."%'  ");
        }
        // if(!empty($get['sSearch_8'])){
        //     $this->db->where("asin_policyno like  '%".$get['sSearch_8']."%'  ");
        // }

        
        if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('as.asin_startdatead >=',$frmDate);
                $this->db->where('as.asin_startdatead <=',$toDate);    
            }else{
                $this->db->where('as.asin_startdatead >=',$frmDate);
                $this->db->where('as.asin_startdatead <=',$toDate);
            }
        }
        // if($cond) {
        //   $this->db->where($cond);
        // }
        // if($this->location_ismain=='Y')
        // {
        //     if($input_locationid)
        //     {
        //         $this->db->where('tf.tfma_locationid',$input_locationid);
        //     }
        // }
        // else
        // {
        //     $this->db->where('tf.tfma_locationid',$this->locationid);
        // }
    
        $this->db->select('as.asin_insurancerate,as.asin_enddatead,as.asin_startdatead,i.inty_name,p.peri_name,ic.inco_name,a.asen_assetcode,as.asin_asinid,as.asin_insuranceamount');
        $this->db->from('asin_assetinsurance as');
		$this->db->join('inty_insurancetype i','i.inty_intyid = as.asin_typeid','LEFT');
		$this->db->join('peri_period p','p.peri_periid = as.asin_renewalperiod','LEFT');
		$this->db->join('asen_assetentry a','a.asen_asenid = as.asin_assetid','LEFT');
		$this->db->join('inco_insurancecompany ic','ic.inco_id = as.asin_companyid','LEFT');
       //$this->db->where('asin_typeid',1);
       // $this->db->where('trma_isassetsync ',NULL);
        // $where = "(trma_transactiontype = 'OPENING' or trma_transactiontype = 'PURCHASE' or trma_transactiontype = 'D.RECEIVE')";

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

         // echo $this->db->last_query();die();

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
        return $ndata;
	}


}