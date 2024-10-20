<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assets_decommision_mdl extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		
		

	}
	public function get_method()
	{
		$this->db->select('*');
		$this->db->from('deme_decommission');
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

	public function get_decommission_list($srch=false)
	{
		$this->db->select('de.*,dm.deme_decomname,ae.asen_assetcode');
		$this->db->from('xw_deeq_decommission_equipment de');
		$this->db->join('deme_decommission dm','dm.deme_decid=de.deeq_decid','left');
		$this->db->join('asen_assetentry ae','ae.asen_asenid = de.deeq_equipid');

		if($srch)
		{
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

	public function save_decommission($id=false)
	{
		$postdata['deeq_decid']=$this->input->post('deeq_decid');
		$postdata['deeq_reason']=$this->input->post('deeq_reason');
		$postdata['deeq_equipid']=$this->input->post('deeq_equipid');
		$postdata['deeq_disposition']=$this->input->post('deeq_disposition');
		//$postdata=$this->input->post();

		//echo "<pre>"; print_r($this->input->post()); die;
   //  	$id=$this->input->post('id');
	  //   unset($postdata['id']);
	  //   if($id)
	  //   {
	  //   $postdata['deeq_modifydatead']=CURDATE_EN;
	  //   $postdata['deeq_modifydatebs']=CURDATE_NP;
	  //   $postdata['deeq_modifytime']=date('H:i:s');
	  //   //$postdata['deeq_modifyby']=$this->session->userdata(USER_ID);
	  //   $postdata['deeq_modifyip']=$this->general->get_real_ipaddr();
	  //   $postdata['deeq_modifymac']=$this->general->get_Mac_Address();
	  //   if(!empty($postdata))
	  //   {
	  //     $this->general->save_log('xw_deeq_decommission_equipment','deeq_decommissionid',$id,$postdata,'Update');
	  //     $this->db->update('xw_deeq_decommission_equipment',$postdata,array('deeq_decommissionid'=>$id));
	  //     $rowaffected=$this->db->affected_rows();
	  //     if($rowaffected)
	  //     {
	        
	  //       return $rowaffected;
	  //     }
	  //     else
	  //     {
	  //       return false;
	  //     }
	  //   }
	  // }
	    // else
	    // {
	    $postdata['deeq_postdatead']=CURDATE_EN;
	    $postdata['deeq_postdatebs']=CURDATE_NP;
	    $postdata['deeq_posttime']=date('H:i:s');
	    $postdata['deeq_postip']=$this->general->get_real_ipaddr();
	    $postdata['deeq_postmac']=$this->general->get_Mac_Address();
	    $postdata['deeq_orgid']=$this->session->userdata(ORG_ID);
	    // echo "<pre>";
	    // print_r($postdata);
	    // die();

	    if(!empty($postdata))
	    {
	      $this->db->insert('xw_deeq_decommission_equipment',$postdata);
	      $insertid=$this->db->insert_id();
	      if($insertid)
	      {
	        return $insertid;
	      }
	      else
	      {
	        return false;
	      }
	      //unset($postdata['deeq_equipid']);
	    }
	  // }
	}

	public function delete_decommission()
		{
			$id=$this->input->post('id');
			if($id)
			{
				 //$this->general->save_log($this->table,'eqli_equipmentlistid',$id,$postdata=array(),'Delete');
				$this->db->delete('xw_deeq_decommission_equipment',array('deeq_decommissionid'=>$id));
				$rowaffected=$this->db->affected_rows();
				if($rowaffected)
				{
					return $rowaffected;
				}
				return false;
			}
			return false;
		}




		public function get_decommission_from_inventory($cond = false)
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
            $this->db->where("deeq_postdatead like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("deeq_postdatebs like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("deeq_posttime like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
        	$this->db->where("deeq_reason like '%".$get['sSearch_5']."%' ");
        }

        if(!empty($get['sSearch_6'])){
            $this->db->where("deme_decomname like  '%".$get['sSearch_6']."%'  ");
        }

        if(!empty($get['sSearch_7'])){
            $this->db->where("deeq_disposition like  '%".$get['sSearch_7']."%'  ");
        }
       
          
      // if(!empty(($frmDate && $toDate)))
        // {
        //     if(DEFAULT_DATEPICKER == 'NP'){
        //         $this->db->where('de.deeq_postdatead >=',$frmDate);
        //         $this->db->where('de.deeq_postdatead <=',$toDate);    
        //     }else{
        //         $this->db->where('de.deeq_postdatead >=',$frmDate);
        //         $this->db->where('de.deeq_postdatead <=',$toDate);
        //     }
        // }
    
        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    //->from('sama_salemaster rn')
                 //$this->db->select('de.*,dm.deme_decomname,ae.asen_assetcode');
		         ->from('xw_deeq_decommission_equipment de')
		         ->join('deme_decommission dm','dm.deme_decid=de.deeq_decid','left')
		         ->join('asen_assetentry ae','ae.asen_asenid = de.deeq_equipid','left')

     //                ->from('asin_assetinsurance as')
					// ->join('inty_insurancetype i','i.inty_intyid = as.asin_typeid','LEFT')
					// ->join('peri_period p','p.peri_periid = as.asin_renewalperiod','LEFT')
					// ->join('asen_assetentry a','a.asen_asenid = as.asin_assetid','LEFT')
					// ->join('inco_insurancecompany ic','ic.inco_id = as.asin_companyid','LEFT')
                   // ->where('asin_typeid','1')
                
                    ->get()
                    ->row();

        //echo $this->db->last_query();die(); 
        $totalfilteredrecs=($resltrpt->cnt); 
        $order_by = 'deeq_decommissionid';
        $order = 'desc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
        $where='';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'asen_assetcode';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'deeq_postdatead';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'deeq_postdatebs';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'deeq_posttime';
        else if($this->input->get('iSortCol_0')==5)
        	$order_by='deeq_reason';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'deme_decomname';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'deeq_disposition';
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
            $this->db->where("deeq_postdatead like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("deeq_postdatebs like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("deeq_posttime like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
        	$this->db->where("deeq_reason like '%".$get['sSearch_5']."%' ");
        }

        if(!empty($get['sSearch_6'])){
            $this->db->where("deme_decomname like  '%".$get['sSearch_6']."%'  ");
        }

        if(!empty($get['sSearch_7'])){
            $this->db->where("deeq_disposition like  '%".$get['sSearch_7']."%'  ");
        }
       
        // if(!empty($get['sSearch_8'])){
        //     $this->db->where("asin_policyno like  '%".$get['sSearch_8']."%'  ");
        // }

        
        // if(!empty(($frmDate && $toDate)))
        // {
        //     if(DEFAULT_DATEPICKER == 'NP'){
        //         $this->db->where('de.deeq_postdatead >=',$frmDate);
        //         $this->db->where('de.deeq_postdatead <=',$toDate);    
        //     }else{
        //         $this->db->where('de.deeq_postdatead >=',$frmDate);
        //         $this->db->where('de.deeq_postdatead <=',$toDate);
        //     }
        // }
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
    
        $this->db->select('de.deeq_postdatead,de.deeq_postdatebs,de.deeq_posttime,de.deeq_reason,de.deeq_disposition,ae.asen_assetcode,dm.deme_decomname,de.deeq_decommissionid');
        $this->db->from('xw_deeq_decommission_equipment de');
		$this->db->join('deme_decommission dm','dm.deme_decid=de.deeq_decid','LEFT');
		$this->db->join('asen_assetentry ae','ae.asen_asenid = de.deeq_equipid','LEFT');
      
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