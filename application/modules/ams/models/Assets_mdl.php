<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Assets_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='asen_assetentry';
		$this->curtime = $this->general->get_currenttime();
		$this->userid = $this->session->userdata(USER_ID);
		$this->username = $this->session->userdata(USER_NAME);
		$this->userdepid = $this->session->userdata(USER_DEPT); //storeid
		$this->mac = $this->general->get_Mac_Address();
		$this->ip = $this->general->get_real_ipaddr();
		$this->locationid=$this->session->userdata(LOCATION_ID);
		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		$this->orgid=$this->session->userdata(ORG_ID);
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
        array('field' => 'asen_depreciation', 'label' => 'Depreciation', 'rules' => 'trim|required|xss_clean'),
       );
      public  $validate_settings_assets_component = array( 
		array('field' => 'asen_assetcode', 'label' => 'Asset Code', 'rules' => 'trim|required|xss_clean'),
       );
     
       public  $validate_settings_generalassets = array( 
		array('field' => 'id', 'label' => 'Asset', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'asen_locationid', 'label' => 'Branch', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'asen_depid', 'label' => 'Department', 'rules' => 'trim|required|xss_clean'),
       );
       public  $validate_settings_pm_assets_record = array( 
       	array('field' => 'pmam_assetid', 'label' => 'Assets Name', 'rules' => 'trim|required|xss_clean'),
       	array('field' => 'pmam_startdate', 'label' => 'PM Start Date', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'pmam_frequencyid', 'label' => 'Frequency', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'pmam_noofyear', 'label' => 'No of Year', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'pmstartdate[]', 'label' => 'PM Record', 'rules' => 'trim|required|xss_clean'),
       );
        public  $validate_settings_lease_assets_record = array( 
       	array('field' => 'lede_assetid', 'label' => 'Assets Name', 'rules' => 'trim|required|xss_clean')
       );
         public  $validate_settings_insurance_assets_record = array( 
       	array('field' => 'asin_assetid', 'label' => 'Assets Name', 'rules' => 'trim|required|xss_clean')
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
	public function get_assets_type($srchcol=false)
	{
		$this->db->select('*');
		$this->db->from('asty_assettype as');
		$this->db->where('as.asty_isactive','Y');
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

		// echo "<pre>";
		// print_r($postdata);
		// die();
		$id=$this->input->post('id');
		$asen_purchasedate=$this->input->post('asen_purchasedate');
		$asen_warrentydate=$this->input->post('asen_warrentydate');
		$asen_warrentystartdate=$this->input->post('asen_warrentystartdate');
		$asen_inservicedate=$this->input->post('asen_inservicedate');
		$asen_depreciationstart=$this->input->post('asen_depreciationstart');
		unset($postdata['asen_purchasedate']);
		unset($postdata['asen_warrentystartdate']);
		unset($postdata['asen_warrentydate']);
		unset($postdata['asen_inservicedate']);
		unset($postdata['asen_depreciationstart']);
		unset($postdata['operation']);
		unset($postdata['asen_attach']);
		// unset($postdata['id']);
		$asen_purchasedate=$this->input->post('asen_purchasedate');
		if(DEFAULT_DATEPICKER=='NP')
		{   
			$asen_purchasedateNp = $asen_purchasedate;
			$asen_purchasedateEn = $this->general->NepToEngDateConv($asen_purchasedate);
			$asen_warrentystartdateNp = $asen_warrentystartdate;
			$asen_warrentystartdateEn = $this->general->NepToEngDateConv($asen_warrentystartdate);
			$asen_warrentydateNp = $asen_warrentydate;
			$asen_warrentydateEn = $this->general->NepToEngDateConv($asen_warrentydate);
			$asen_inservicedateNp = $asen_inservicedate;
			$asen_inservicedateEn = $this->general->NepToEngDateConv($asen_inservicedate);
			$asen_depreciationstartNp = $asen_depreciationstart;
			$asen_depreciationstartEn = $this->general->NepToEngDateConv($asen_depreciationstart);
		}
		else
		{
			$asen_purchasedateEn = $asen_purchasedate;
			$asen_purchasedateNp = $this->general->EngtoNepDateConv($asen_purchasedate);
			$asen_warrentystartdateEn = $asen_warrentystartdate;
			$asen_warrentystartdateNp = $this->general->EngtoNepDateConv($asen_warrentystartdate);
			$asen_warrentydateEn = $asen_warrentydate;
			$asen_warrentydateNp = $this->general->EngtoNepDateConv($asen_warrentydate);
			$asen_inservicedateEn = $asen_inservicedate;
			$asen_inservicedateNp = $this->general->EngtoNepDateConv($asen_inservicedate);
			$asen_depreciationstartEn = $asen_depreciationstart;
			$asen_depreciationstartNp = $this->general->EngtoNepDateConv($asen_depreciationstart);
}			
		$postid=$this->ip;
		$postmac=$this->general->get_Mac_Address();
		unset($postdata['id']);
		if($id)
		{
			$this->db->trans_start();
			$postdata['asen_purchasedatebs']=$asen_purchasedateNp;
			$postdata['asen_purchasedatead']=$asen_purchasedateEn;
			$postdata['asen_warrentystartdatebs']=$asen_warrentydateNp;
			$postdata['asen_warrentystartdatead']=$asen_warrentydateEn;
			$postdata['asen_warrentydatebs']=$asen_warrentydateNp;
			$postdata['asen_warrentydatead']=$asen_warrentydateEn;
			$postdata['asen_inservicedatebs']=$asen_inservicedateNp;
			$postdata['asen_inservicedatead']=$asen_inservicedateEn;
			$postdata['asen_depreciationstartdatebs']=$asen_depreciationstartNp;
			$postdata['asen_depreciationstartdatead']=$asen_depreciationstartEn;
			$postdata['asen_modifydatead']=CURDATE_EN;
			$postdata['asen_modifydatebs']=CURDATE_NP;
			$postdata['asen_modifytime']=$this->general->get_currenttime();
			$postdata['asen_modifyby']=$this->userid;
			$postdata['asen_modifyip']=$postid;
			$postdata['asen_modifymac']=$postmac;
			$postdata['asen_locationid']=$this->locationid;
			$postdata['asen_orgid']=$this->orgid;
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
			        return $id;
				}
		}
		else
		{
			$postdata =  array();
			$postdata = $this->input->post();
			$attachments = $this->input->post('asen_attach');
			$imageList = '';
			if(!empty($attachments)):
			foreach($attachments as $key=>$value):
				$_FILES['attachments']['name'] = $_FILES['asen_attachment']['name'][$key];
	            $_FILES['attachments']['type'] = $_FILES['asen_attachment']['type'][$key];
	            $_FILES['attachments']['tmp_name'] = $_FILES['asen_attachment']['tmp_name'][$key];
	            $_FILES['attachments']['error'] = $_FILES['asen_attachment']['error'][$key];
	            $_FILES['attachments']['size'] = $_FILES['asen_attachment']['size'][$key];
			if(!empty($_FILES)){
				$new_image_name = $_FILES['asen_attachment']['name'][$key];
                $imgfile=$this->doupload('attachments');
			}else{
				$imgfile = '';
			}
			$imageList .= $imgfile.', ';
			endforeach;
			endif;
			$imageName = rtrim($imageList,', ');
			$postdata['asen_attachment'] = $imageName;
			$postdata['asen_purchasedatebs']=$asen_purchasedateNp;
			$postdata['asen_purchasedatead']=$asen_purchasedateEn;
			$postdata['asen_warrentydatebs']=$asen_warrentydateNp;
			$postdata['asen_warrentydatead']=$asen_warrentydateEn;
			$postdata['asen_warrentystartdatebs']=$asen_warrentydateNp;
			$postdata['asen_warrentystartdatead']=$asen_warrentydateEn;
			$postdata['asen_inservicedatebs']=$asen_inservicedateNp;
			$postdata['asen_inservicedatead']=$asen_inservicedateEn;
			$postdata['asen_depreciationstartdatebs']=$asen_depreciationstartNp;
			$postdata['asen_depreciationstartdatead']=$asen_depreciationstartEn;
			$postdata['asen_postdatead']=CURDATE_EN;
			$postdata['asen_postdatebs']=CURDATE_NP;
			$postdata['asen_posttime']=$this->general->get_currenttime();
			$postdata['asen_postby']=$this->userid;
			$postdata['asen_postip']=$postid;
			$postdata['asen_postmac']=$postmac;
			$postdata['asen_locationid']=$this->locationid;
			$postdata['asen_orgid']=$this->orgid;
			unset($postdata['id']);
			unset($postdata['asen_purchasedate']);
			unset($postdata['asen_warrentystartdate']);
			unset($postdata['asen_warrentydate']);
			unset($postdata['asen_inservicedate']);
			unset($postdata['asen_depreciationstart']);
			unset($postdata['operation']);
			unset($postdata['asen_attach']);
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
				    return $insert_id;
				}
			}
			return false;
	}
	public function doupload($file) {
        // echo "test";
        // die();
        $config['upload_path'] = './'.ASSETS_ATTACHMENT_PATH;//define in constants
        $config['allowed_types'] = 'png|jpg|gif|jpeg|pdf';
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;    
        $config['max_size'] = '2000000';
        $config['max_width'] = '2400';
        $config['max_height'] = '1280';
        $this->upload->initialize($config);
        $this->load->library('upload', $config);
        $this->upload->do_upload($file);
        $data = $this->upload->data();
            // echo "<pre>";
            // echo "file: ";
            // print_r($file);
            // echo "<br/>";
            // echo "Data: ";
            // print_r($data);
            // exit;
        $name_array = $data['file_name'];
            // echo $name_array;
            // exit;
                // $names= implode(',', $name_array);   
            //     // return $names;   
        return $name_array;
    }
	public function save_general_assets(){
			$postdata=$this->input->post();
			$asen_manufacture_date=$this->input->post('asen_manufacture_date');
			if(DEFAULT_DATEPICKER=='NP'){   
				$asen_manufacture_dateNp = $asen_manufacture_date;
				$asen_manufacture_dateEn = $this->general->NepToEngDateConv($asen_manufacture_date);
			}
			else{
				$asen_manufacture_dateEn = $asen_manufacture_date;
				$asen_manufacture_dateNp = $this->general->EngtoNepDateConv($asen_manufacture_date);
			}
			if (ORGANIZATION_NAME == 'KU') {
				$asen_depid = $this->input->post('asen_depid');
				$received_by = $this->input->post('received_by');
				$subdepid = $this->input->post('subdepid');
				if (!empty($subdepid)) {
					$postdata['asen_depid'] = $subdepid;
				}
				$postdata['asen_schoolid'] = $postdata['asen_locationid'];
				if (!empty($received_by)) {
					$staff_info = explode('@', $received_by);
					$postdata['asen_staffid'] = $staff_info[0];
					$postdata['asen_receivedby'] = $staff_info[1];
				}
               
				unset($postdata['subdepid']); 
				unset($postdata['received_by']); 
			}

			$id=$this->input->post('id');
			unset($postdata['id']);
			unset($postdata['asen_manufacture_date']);
			unset($postdata['operation']);
			$postdata['asen_manufacture_datead']=$asen_manufacture_dateEn; 
			$postdata['asen_manufacture_datebs']=$asen_manufacture_dateNp;
			if($id){
				if(!empty($postdata)){

					$this->db->update($this->table,$postdata,array('asen_asenid'=>$id));
					$rw_aff=$this->db->affected_rows();
					$this->general->save_log($this->table,'asen_asenid',$id,$postdata,'Update General Assets');
					if(!empty($rw_aff)){
						return $id;
					}
					return false;
				}
			}
			else{
				if(!empty($postdata)){
				$this->db->insert($this->table,$postdata);
				$insert_id = $this->db->insert_id();
				if($insert_id){
					return $insert_id;
				 }
				 return false;
				}
		}
}
public function save_assets_lease_assets_record(){
	try {
			$lema_startdate=$this->input->post('lema_startdate');
			$lema_enddate=$this->input->post('lema_enddate');
			$lema_companyid=$this->input->post('lema_companyid');
			$lema_contractno=$this->input->post('lema_contractno');
			$lede_initcost=$this->input->post('lede_initcost');
			$lede_rental_amt=$this->input->post('lede_rental_amt');
			$lede_frequencyid=$this->input->post('lede_frequencyid');
			$lema_attachment=$this->input->post('lema_attachment');
			$lema_remarks=$this->input->post('lema_remarks');
			$lede_assetid=$this->input->post('lede_assetid');
			// unset($postdata['lema_attach']);
			if(DEFAULT_DATEPICKER=='NP'){   
				$lema_startdateNp = $lema_startdate;
				$lema_startdateEn = $this->general->NepToEngDateConv($lema_startdate);
				$lema_enddateNp = $lema_enddate;
				$lema_enddateEn = $this->general->NepToEngDateConv($lema_enddate);
			}
			else{
				$lema_startdateEn = $lema_startdate;
				$lema_startdateNp = $this->general->EngtoNepDateConv($lema_startdate);
				$lema_enddateEn = $lema_enddate;
				$lema_enddateNp = $this->general->EngtoNepDateConv($lema_enddate);
			}
			$id=$this->input->post('id');
			$lease_masterid=$this->input->post('lema_leasemasterid');
			$lease_detailid=$this->input->post('lede_leasedetailid');
			$postdataMaster['lema_startdatead']=$lema_startdateEn; 
			$postdataMaster['lema_startdatebs']=$lema_startdateNp;
			$postdataMaster['lema_enddatead']=$lema_enddateEn; 
			$postdataMaster['lema_enddatebs']=$lema_enddateNp;
			$postdataMaster['lema_companyid']=$lema_companyid;
			$postdataMaster['lema_contractno']=$lema_contractno;
			$postdataMaster['lema_remarks']=$lema_remarks;
			$postdatadetail['lede_initcost']=$lede_initcost;
			$postdatadetail['lede_rental_amt']=$lede_rental_amt;
			$postdatadetail['lede_frequencyid']=$lede_frequencyid;
			$postdatadetail['lede_assetid']=$lede_assetid;
			// echo $lease_masterid;
			// die();
			if(!empty($lease_masterid)){
				$postdataMaster['lema_modifydatead']=CURDATE_EN;
				$postdataMaster['lema_modifydatebs']=CURDATE_NP;
				$postdataMaster['lema_modifytime']=$this->general->get_currenttime();
				$postdataMaster['lema_modifyby']=$this->userid;
				$postdataMaster['lema_modifyip']=$this->ip;
				$postdataMaster['lema_modifymac']=$this->mac;
				// echo "<pre>";
				// print_r($postdataMaster);
				// die();
				if(!empty($postdataMaster)){
					// echo "update";
					// die();
					$this->db->update('lema_leasemaster',$postdataMaster,array('lema_leasemasterid'=>$lease_masterid));
					// echo $this->db->last_query();
					// die();
					$rw_aff=$this->db->affected_rows();
					// echo $rw_aff;
					// die();
					if(!empty($rw_aff)){
						$postdatadetail['lede_modifydatead']=CURDATE_EN;
						$postdatadetail['lede_modifydatebs']=CURDATE_NP;
						$postdatadetail['lede_modifytime']=$this->general->get_currenttime();
						$postdatadetail['lede_modifyby']=$this->userid;
						$postdatadetail['lede_modifyip']=$this->ip;
						$postdatadetail['lede_modifymac']=$this->mac;
						if(!empty($postdatadetail)){
							$this->db->update('lede_leasedetail',$postdatadetail,array('lede_leasemasterid'=>$lease_masterid,'lede_assetid'=>$lede_assetid));
						}
						return $lede_assetid;
					}
					return true;
				}
			}
			else{
			$postdata =  array();
			$postdata = $this->input->post();
			$attachments = $this->input->post('lema_attach');
			$imageList = '';
			if(!empty($attachments)):
			foreach($attachments as $key=>$value):
				$_FILES['attachments']['name'] = $_FILES['lema_attachment']['name'][$key];
	            $_FILES['attachments']['type'] = $_FILES['lema_attachment']['type'][$key];
	            $_FILES['attachments']['tmp_name'] = $_FILES['lema_attachment']['tmp_name'][$key];
	            $_FILES['attachments']['error'] = $_FILES['lema_attachment']['error'][$key];
	            $_FILES['attachments']['size'] = $_FILES['lema_attachment']['size'][$key];
			if(!empty($_FILES)){
				$new_image_name = $_FILES['lema_attachment']['name'][$key];
                $imgfile=$this->doupload_lease('attachments');
			}else{
				$imgfile = '';
			}
			$imageList .= $imgfile.', ';
			endforeach;
			endif;
			$imageName = rtrim($imageList,', ');
			$postdataMaster['lema_attachment'] = $imageName;
				$postdataMaster['lema_postdatead']=CURDATE_EN;
				$postdataMaster['lema_postdatebs']=CURDATE_NP;
				$postdataMaster['lema_posttime']=$this->general->get_currenttime();
				$postdataMaster['lema_postby']=$this->userid;
				$postdataMaster['lema_postip']=$this->ip;
				$postdataMaster['lema_postmac']=$this->mac;
				$postdataMaster['lema_locationid']=$this->locationid;
				$postdataMaster['lema_orgid']=$this->orgid;
				$postdataMaster['lema_savetype']='S';
				if(!empty($postdataMaster)){
				$this->db->insert('lema_leasemaster',$postdataMaster);
				$insert_id = $this->db->insert_id();
				if($insert_id){
					// return $insert_id;
					$postdatadetail['lede_leasemasterid']=$insert_id;
					$postdatadetail['lede_postdatead']=CURDATE_EN;
					$postdatadetail['lede_postdatebs']=CURDATE_NP;
					$postdatadetail['lede_posttime']=$this->general->get_currenttime();
					$postdatadetail['lede_postby']=$this->userid;
					$postdatadetail['lede_postip']=$this->ip;
					$postdatadetail['lede_postmac']=$this->mac;
					$postdatadetail['lede_locationid']=$this->locationid;
					$postdatadetail['lede_orgid']=$this->orgid;
					if(!empty($postdatadetail)){
						$this->db->insert('lede_leasedetail',$postdatadetail);
					}
					return $insert_id;
				 }
				}
			return false;
		}
} catch (Exception $e) {
		$this->db->trans_rollback();
  		print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
	}
}
public function save_assets_insurance_record(){
	try {
			$postdata=$this->input->post();
			$asin_startdate=$this->input->post('asin_startdate');
			$asin_enddate=$this->input->post('asin_enddate');
			$asin_assetid=$this->input->post('asin_assetid');
			$asin_asinid=$this->input->post('asin_asinid');
			if(DEFAULT_DATEPICKER=='NP'){   
				$asin_startdateNp = $asin_startdate;
				$asin_startdateEn = $this->general->NepToEngDateConv($asin_startdate);
				$asin_enddateNp = $asin_enddate;
				$asin_enddateEn = $this->general->NepToEngDateConv($asin_enddate);
			}
			else{
				$asin_startdateEn = $asin_startdate;
				$asin_startdateNp = $this->general->EngtoNepDateConv($asin_startdate);
				$asin_enddateEn = $asin_enddate;
				$asin_enddateNp = $this->general->EngtoNepDateConv($asin_enddate);
			}
			unset($postdata['asin_startdate']);
			unset($postdata['asin_enddate']);
			unset($postdata['asin_asinid']);
			unset($postdata['operation']);
			$postdata['asin_assetid']=$asin_assetid;
			$postdata['asin_startdatead']=$asin_startdateEn;
			$postdata['asin_startdatebs']=$asin_startdateNp;
			$postdata['asin_enddatead']=$asin_enddateEn;	
			$postdata['asin_enddatebs']=$asin_enddateNp;
			if(!empty($asin_asinid)){
				$postdata['asin_modifydatead']=CURDATE_EN;
				$postdata['asin_modifydatebs']=CURDATE_NP;
				$postdata['asin_modifytime']=$this->general->get_currenttime();
				$postdata['asin_modifyby']=$this->userid;
				$postdata['asin_modifyip']=$this->ip;
				$postdata['asin_modifymac']=$this->mac;
				// echo "<pre>";
				// print_r($postdata);
				// die();
				if(!empty($postdata)){
					// echo "update";
					// die();
					$this->db->update('asin_assetinsurance',$postdata,array('asin_asinid'=>$asin_asinid));
					// echo $this->db->last_query();
					// die();
					$rw_aff=$this->db->affected_rows();
						return $asin_assetid;
					}
					return true;
				}
			else{
				$postdata =  array();
				$postdata = $this->input->post();
				$attachments = $this->input->post('asin_attach');
				$imageList = '';
				if(!empty($attachments)):
				foreach($attachments as $key=>$value):
					$_FILES['attachments']['name'] = $_FILES['asin_attachment']['name'][$key];
		            $_FILES['attachments']['type'] = $_FILES['asin_attachment']['type'][$key];
		            $_FILES['attachments']['tmp_name'] = $_FILES['asin_attachment']['tmp_name'][$key];
		            $_FILES['attachments']['error'] = $_FILES['asin_attachment']['error'][$key];
		            $_FILES['attachments']['size'] = $_FILES['asin_attachment']['size'][$key];
				if(!empty($_FILES)){
					$new_image_name = $_FILES['asin_attachment']['name'][$key];
	                $imgfile=$this->doupload_insurance('attachments');
				}else{
					$imgfile = '';
				}
				$imageList .= $imgfile.', ';
				endforeach;
				endif;
				$imageName = rtrim($imageList,', ');
				$postdata['asin_attachment'] = $imageName;
				$postdata['asin_postdatead']=CURDATE_EN;
				$postdata['asin_postdatebs']=CURDATE_NP;
				$postdata['asin_posttime']=$this->general->get_currenttime();
				$postdata['asin_postby']=$this->userid;
				$postdata['asin_postip']=$this->ip;
				$postdata['asin_postmac']=$this->mac;
				$postdata['asin_locationid']=$this->locationid;
				$postdata['asin_orgid']=$this->orgid;
				unset($postdata['asin_startdate']);
				unset($postdata['asin_enddate']);
				unset($postdata['asin_asinid']);
				unset($postdata['operation']);
				unset($postdata['asin_attach']);
				if(!empty($postdata)){
				$this->db->insert('asin_assetinsurance',$postdata);
				$insert_id = $this->db->insert_id();
				return $asin_assetid;
				}
			return false;
		}
} catch (Exception $e) {
		$this->db->trans_rollback();
  		print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
	}
}
public function save_assets_pm_amc_record(){
try {
	$pmam_pmamcmasterid=$this->input->post('pmam_pmamcmasterid');
	$pmam_assetid=$this->input->post('pmam_assetid');
	$pmam_contractorid=$this->input->post('pmam_contractorid');
	$pmam_startdate=$this->input->post('pmam_startdate');
	$pmam_frequencyid=$this->input->post('pmam_frequencyid');
	$pmam_noofyear=$this->input->post('pmam_noofyear');
	$pmstartdate=$this->input->post('pmstartdate');
	$pmenddate=$this->input->post('pmenddate');
	$pmstartdate=$this->input->post('pmstartdate');
	$pmam_remarks=$this->input->post('pmam_remarks');
	$pmam_pmamtype=$this->input->post('pmam_pmamtype');
	if(DEFAULT_DATEPICKER=='NP'){   
			$pmam_startdateNp = $pmam_startdate;
			$pmam_startdateEn = $this->general->NepToEngDateConv($pmam_startdate);
		}
		else{
			$pmam_startdateEn = $pmam_startdate;
			$pmam_startdateNp = $this->general->EngtoNepDateConv($pmam_startdate);	
		}
	$postdataMaster['pmam_assetid']=$pmam_assetid;
	$postdataMaster['pmam_pmamtype']=$pmam_pmamtype;
	$postdataMaster['pmam_contractorid']=$pmam_contractorid;
	$postdataMaster['pmam_startdatead']=$pmam_startdateEn;
	$postdataMaster['pmam_startdatebs']=$pmam_startdateNp;
	$postdataMaster['pmam_frequencyid']=$pmam_frequencyid;
  	$postdataMaster['pmam_noofyear']=$pmam_noofyear;
  	$postdataMaster['pmam_remarks']=$pmam_remarks;
  	if(!empty($pmam_pmamcmasterid)){
  	}else{
  		$postdata =  array();
			$postdata = $this->input->post();
			$attachments = $this->input->post('pmam_attach');
			$imageList = '';
			if(!empty($attachments)):
			foreach($attachments as $key=>$value):
				$_FILES['attachments']['name'] = $_FILES['pmam_attachement']['name'][$key];
	            $_FILES['attachments']['type'] = $_FILES['pmam_attachement']['type'][$key];
	            $_FILES['attachments']['tmp_name'] = $_FILES['pmam_attachement']['tmp_name'][$key];
	            $_FILES['attachments']['error'] = $_FILES['pmam_attachement']['error'][$key];
	            $_FILES['attachments']['size'] = $_FILES['pmam_attachement']['size'][$key];
			if(!empty($_FILES)){
				$new_image_name = $_FILES['pmam_attachement']['name'][$key];
                $imgfile=$this->doupload_maintanance('attachments');
			}else{
				$imgfile = '';
			}
			$imageList .= $imgfile.', ';
			endforeach;
			endif;
			$imageName = rtrim($imageList,', ');
		$postdataMaster['pmam_attachement'] = $imageName;
  		$postdataMaster['pmam_postdatead']=CURDATE_EN;
		$postdataMaster['pmam_postdatebs']=CURDATE_NP;
		$postdataMaster['pmam_posttime']=$this->general->get_currenttime();
		$postdataMaster['pmam_postby']=$this->userid;
		$postdataMaster['pmam_postip']=$this->ip;
		$postdataMaster['pmam_postmac']=$this->mac;
		$postdataMaster['pmam_locationid']=$this->locationid;
		$postdataMaster['pmam_orgid']=$this->orgid;
		if(!empty($postdataMaster)){
			$this->db->insert('pmam_pmamcmaster',$postdataMaster);
			$insert_id=$this->db->insert_id();
			if(!empty($insert_id)){
				$arr_pm_rec=array();
				foreach($pmstartdate as $kpmd =>$val){
				if(DEFAULT_DATEPICKER=='NP'){   
					$pmstartdateNp = $pmstartdate[$kpmd];
					$pmstartdateEn = $this->general->NepToEngDateConv($pmstartdate[$kpmd]);
				}
				else{
					$pmstartdateEn = $pmstartdate[$kpmd];
					$pmstartdateNp = $this->general->EngtoNepDateConv($pmstartdate[$kpmd]);	
				}
				if($pmenddate[$kpmd]!='No Next'){
					if(DEFAULT_DATEPICKER=='NP'){   
					$pmenddateNp = $pmenddate[$kpmd];
					$pmenddateEn = $this->general->NepToEngDateConv($pmenddate[$kpmd]);
					}
					else{
						$pmenddateEn = $pmenddate[$kpmd];
						$pmenddateNp = $this->general->EngtoNepDateConv($pmenddate[$kpmd]);	
					}
				}else{
					$pmenddateNp = 'No Next';
					$pmenddateEn = 'No Next';
				}
					$arr_pm_rec[]=array(
						'pmad_pmamcmasterid'=>$insert_id,
						'pmad_assetid'=>$pmam_assetid,
						'pmad_datead'=>$pmstartdateEn,
						'pmad_datebs'=>$pmstartdateNp,
						'pmad_upcomingdatead'=>$pmenddateEn,
						'pmad_upcomingdatebs'=>$pmenddateNp,
						'pmad_remarks'=>'',
						'pmad_status'=>'O',
						'pmad_postdatead'=>CURDATE_EN,
						'pmad_postdatebs'=>CURDATE_NP,
						'pmad_posttime'=>$this->general->get_currenttime(),
						'pmad_postmac'=>$this->mac,
						'pmad_postip'=>$this->ip,
						'pmad_postby'=>$this->userid,
						'pmad_orgid'=>$this->orgid,
						'pmad_locationid'=>$this->locationid
					);
				}
				if(!empty($arr_pm_rec)){
					$this->db->insert_batch('pmad_pmamcdetail',$arr_pm_rec);
				}
			}
		}
		$this->db->trans_commit();
		return true;
  	}
} catch (Exception $e) {
		$this->db->trans_rollback();
  		print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
	}	
}
public function get_assets_lease_record($srchcol=false){
$this->db->select('lm.*,ld.*,lc.leco_companyname,lc.leco_company_address,ft.frty_name');
$this->db->from('lema_leasemaster lm');
$this->db->join('lede_leasedetail ld','ld.lede_leasemasterid=lm.lema_leasemasterid','INNER');
$this->db->join('leco_leasocompany lc','lc.leco_leasecompanyid=lm.lema_companyid','LEFT');
$this->db->join('frty_frequencytype ft','ft.frty_frtyid=ld.lede_frequencyid','LEF');
if(!empty($srchcol)){
	$this->db->where($srchcol);
}
$result=$this->db->get()->result();
if(!empty($result)){
	return $result;
}
return false;
}
public function get_assets_insurance_record($srchcol=false){
$this->db->select('ai.*,ic.inco_name,ic.inco_address1,ft.frty_name');
$this->db->from('asin_assetinsurance ai');
$this->db->join('inco_insurancecompany ic','ic.inco_id=ai.asin_companyid',"LEFT");
$this->db->join('frty_frequencytype ft','ft.frty_frtyid=ai.asin_frequencyid','LEF');
if(!empty($srchcol)){
	$this->db->where($srchcol);
}
$result=$this->db->get()->result();
if(!empty($result)){
	return $result;
}
return false;
}
	public function save_assets_component_entry(){
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		$asen_manufacture_date=$this->input->post('asen_manufacture_date');
		$asen_inservicedate=$this->input->post('asen_inservicedate');
		$asen_reline_date=$this->input->post('asen_reline_date');
		$asen_workcompletedate=$this->input->post('asen_workcompletedate');
		unset($postdata['asen_manufacture_date']);
		unset($postdata['asen_warrentydate']);
		unset($postdata['asen_reline_date']);
		unset($postdata['asen_inservicedate']);
		unset($postdata['asen_workcompletedate']);
		unset($postdata['operation']);
		unset($postdata['asen_images']);
		if(DEFAULT_DATEPICKER=='NP')
		{   
			$manufacture_dateNp = $asen_manufacture_date;
			$manufacture_dateEn = $this->general->NepToEngDateConv($asen_manufacture_date);
			$asen_inservicedateNp = $asen_inservicedate;
			$asen_inservicedateEn = $this->general->NepToEngDateConv($asen_inservicedate);
			$asen_reline_dateNp = $asen_reline_date;
			$asen_reline_dateEn = $this->general->NepToEngDateConv($asen_reline_date);
			$asen_workcompletedateNp = $asen_workcompletedate;
			$asen_workcompletedateEn = $this->general->NepToEngDateConv($asen_workcompletedate);
		}
		else
		{
			$manufacture_dateEn = $manufacture_date;
			$manufacture_dateNp = $this->general->EngtoNepDateConv($manufacture_date);
			$asen_inservicedateEn = $asen_inservicedate;
			$asen_inservicedateNp = $this->general->EngtoNepDateConv($asen_inservicedate);
			$asen_reline_dateEn = $asen_reline_date;
			$asen_reline_dateNp = $this->general->EngtoNepDateConv($asen_reline_date);
			$asen_workcompletedateEn = $asen_workcompletedate;
			$asen_workcompletedateNp = $this->general->EngtoNepDateConv($asen_workcompletedate);
		}
		$postid=$this->ip;
		$postmac=$this->general->get_Mac_Address();
		unset($postdata['id']);
		if($id)
		{
			$this->db->trans_start();
			$postdata['asen_manufacture_datebs']=$manufacture_dateNp;
			$postdata['asen_manufacture_datead']=$manufacture_dateEn;	
			$postdata['asen_inservicedatebs']=$asen_inservicedateNp;
			$postdata['asen_inservicedatead']=$asen_inservicedateEn;
			$postdata['asen_reline_datebs']=$asen_reline_dateNp;
			$postdata['asen_reline_datead']=$asen_reline_dateEn;
			$postdata['asen_workcompletedatebs']=$asen_workcompletedateNp;
			$postdata['asen_workcompletedatead']=$asen_workcompletedateEn;
			$postdata['asen_modifydatead']=CURDATE_EN;
			$postdata['asen_modifydatebs']=CURDATE_NP;
			$postdata['asen_modifytime']=$this->general->get_currenttime();
			$postdata['asen_modifyby']=$this->userid;
			$postdata['asen_modifyip']=$postid;
			$postdata['asen_modifymac']=$postmac;
			$postdata['asen_locationid']=$this->locationid;
			$postdata['asen_orgid']=$this->orgid;
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
			        return $id;
				}
		}
		else
		{
			$imageList = '';
		      // $new_image_name = $_FILES['fire_attachement']['name'];
		       $_FILES['attachments']['name'] = $_FILES['asen_images']['name'];
		       $_FILES['attachments']['type'] = $_FILES['asen_images']['type'];
		             $_FILES['attachments']['tmp_name'] = $_FILES['asen_images']['tmp_name'];
		             $_FILES['attachments']['error'] = $_FILES['asen_images']['error'];
		             $_FILES['attachments']['size'] = $_FILES['asen_images']['size'];
		      if(!empty($_FILES)){
		        $new_image_name = $_FILES['asen_images']['name'];
		                $imgfile=$this->doupload('attachments');
		                // echo "<pre> at";
		                // print_r($imgfile);
		                // die();
		      }else{
		        $imgfile = '';
		      }
		    $postdata['asen_images']=$imgfile;
			$postdata['asen_manufacture_datebs']=$manufacture_dateNp;
			$postdata['asen_manufacture_datead']=$manufacture_dateEn;
			$postdata['asen_inservicedatebs']=$asen_inservicedateNp;
			$postdata['asen_inservicedatead']=$asen_inservicedateEn;
			$postdata['asen_reline_datebs']=$asen_reline_dateNp;
			$postdata['asen_reline_datead']=$asen_reline_dateEn;
			$postdata['asen_workcompletedatebs']=$asen_workcompletedateNp;
			$postdata['asen_workcompletedatead']=$asen_workcompletedateEn;
			$postdata['asen_postdatead']=CURDATE_EN;
			$postdata['asen_postdatebs']=CURDATE_NP;
			$postdata['asen_posttime']=$this->general->get_currenttime();
			$postdata['asen_postby']=$this->userid;
			$postdata['asen_postip']=$postid;
			$postdata['asen_postmac']=$postmac;
			// $postdata['asen_locationid']=$this->locationid;
			$postdata['asen_orgid']=$this->orgid;
			$postdata['asen_iscomponent']='Y';
			// echo "<pre>";
			// print_r($postdata);
			// die();
			$this->db->trans_start();
			if(!empty($postdata))
			{
				$this->db->insert($this->table,$postdata);
			}
			$insert_id = $this->db->insert_id();
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
				{
				    $this->db->trans_rollback();
				    return false;
				}
				else
				{
				    $this->db->trans_commit();
				    return $insert_id;
				}
			}
			return false;
	}
	public function get_all_assets_list($cond = false){  	
		$frmDate=!empty($this->input->get('frmDate'))?$this->input->get('frmDate'):CURMONTH_DAY1;
        $toDate=!empty($this->input->get('toDate'))?$this->input->get('toDate'):DISPLAY_DATE;
        $dateSearch = $this->input->get('dateSearch');
           $asen_assettype = $this->input->get('asen_assettype');
           $asen_status = $this->input->get('asen_status');
           $asen_condition = $this->input->get('asen_condition');
           $asen_description = $this->input->get('asen_description');
           $schoolid=$this->input->get('schoolid');
           $depid = $this->input->get('depid');
            $subdepid=$this->input->get('subdepid');
           $searchtext= $this->input->get('searchtext');
           $asen_dispose=$this->input->get('asen_dispose');

           $subdeparray = array();
        
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
          if(!empty($asen_assettype)){
        	$this->db->where('ae.asen_assettype',$asen_assettype);
        }
          if(!empty($asen_status)){
        	$this->db->where('ae.asen_status',$asen_status);
        }
         if(!empty($asen_condition)){
        	$this->db->where('ae.asen_condition',$asen_condition);
        }
         if(!empty($asen_description)){
        	$this->db->where('ae.asen_description',$asen_description);
        }
        if(!empty($schoolid)){
        	$this->db->where('ae.asen_schoolid',$schoolid);
        }
        if(!empty($depid)){
        	$this->db->where('ae.asen_depid',$depid);
        }
     if(!empty($searchtext))
      {
          $this->db->where("asen_description like  '%".$searchtext."%'  ");
      }
      if(!empty($asen_dispose)){
      	$this->db->where('asen_isdispose',$asen_dispose);
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
        if(!empty($get['sSearch_9'])){
            $this->db->where("asen_location like  '%".$get['sSearch_9']."%'  ");
        }
        if($cond) {
            $this->db->where($cond);
        }
      	$resltrpt=$this->db->select("asen_assetcode")
      					->from('asen_assetentry ae')
					    ->join('asst_assetstatus as','as.asst_asstid=ae.asen_status','LEFT')
					    ->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT')
					    ->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT')
					    ->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT')
					    ->join('dist_distributors dt','dt.dist_distributorid=ae.asen_distributor','LEFT')
					    ->join('dept_department dp','dp.dept_depid=ae.asen_depid','LEFT')
      					->get()
      					->result();
	    // echo $this->db->last_query();die(); 
      	// $totalfilteredrecs=sizeof($resltrpt);
      	 if (!empty($_GET['iDisplayLength']) &&  !empty($resltrpt) && is_array($resltrpt) && sizeof($resltrpt) > 0 ) {
            $totalfilteredrecs = sizeof($resltrpt);
        }
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
          if(!empty($asen_assettype)){
        	$this->db->where('ae.asen_assettype',$asen_assettype);
        }
          if(!empty($asen_status)){
        	$this->db->where('ae.asen_status',$asen_status);
        }
         if(!empty($asen_condition)){
        	$this->db->where('ae.asen_condition',$asen_condition);
        }
         if(!empty($asen_description)){
        	$this->db->where('ae.asen_description',$asen_description);
        }
        if(!empty($schoolid)){
        	$this->db->where('ae.asen_schoolid',$schoolid);
        }
        if(!empty($depid)){
        	$this->db->where('ae.asen_depid',$depid);
        }
        if(!empty($asen_dispose)){
      	$this->db->where('asen_isdispose',$asen_dispose);
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
        if(!empty($get['sSearch_9'])){
            $this->db->where("asen_location like  '%".$get['sSearch_9']."%'  ");
        }
        if($cond) {
            $this->db->where($cond);
        }
        $this->db->select('*');
	    $this->db->from('asen_assetentry ae');
	    $this->db->join('asst_assetstatus as','as.asst_asstid=ae.asen_status','LEFT');
	    $this->db->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT');
	    $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT');
	    $this->db->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT');
	    $this->db->join('dist_distributors dt','dt.dist_distributorid=ae.asen_distributor','LEFT');
	     $this->db->join('dept_department dp','dp.dept_depid=ae.asen_depid','LEFT');
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
	public function get_all_assets_list_ku($cond = false){  	
		$frmDate=!empty($this->input->get('frmDate'))?$this->input->get('frmDate'):CURMONTH_DAY1;
	    $toDate=!empty($this->input->get('toDate'))?$this->input->get('toDate'):DISPLAY_DATE;
	    $dateSearch = $this->input->get('dateSearch');
	    $asen_assettype = $this->input->get('asen_assettype');
	    $asen_status = $this->input->get('asen_status');
	    $asen_condition = $this->input->get('asen_condition');
	    $asen_description = $this->input->get('asen_description');
    	$schoolid=!empty($this->input->get('schoolid'))?$this->input->get('schoolid'):$this->input->post('schoolid');
      	$depid = !empty($this->input->get('depid'))?$this->input->get('depid'):$this->input->post('depid');
        $subdepid=!empty($this->input->get('subdepid'))?$this->input->get('subdepid'):$this->input->post('subdepid');
  		$searchtext= $this->input->get('searchtext');
   		$asen_dispose=$this->input->get('asen_dispose');
   		$staffid=!empty($this->input->get('staffid'))?$this->input->get('staffid'):$this->input->post('staffid');
   		$asen_distributor = $this->input->get('asen_distributor');

   		$subdeparray = array();
        if ($depid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $depid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $depid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }

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
          if(!empty($asen_assettype)){
        	$this->db->where('ae.asen_assettype',$asen_assettype);
        }
          if(!empty($asen_status)){
        	$this->db->where('ae.asen_status',$asen_status);
        }
         if(!empty($asen_condition)){
        	$this->db->where('ae.asen_condition',$asen_condition);
        }
         if(!empty($asen_description)){
        	$this->db->where('ae.asen_description',$asen_description);
        }
        if(!empty($schoolid)){
        	$this->db->where('ae.asen_schoolid',$schoolid);
        }
         if(!empty($asen_distributor)){
        	$this->db->where('ae.asen_distributor',$asen_distributor);
        }

        if (!empty($depid)) {

            if (!empty($subdepid)) {
                $this->db->where("asen_depid =" . $subdepid . " ");
            } else {
                if (!empty($subdeparray)) {
                    $this->db->where_in("asen_depid", $subdeparray);
                } else {
                    $this->db->where("asen_depid =" . $depid . " ");
                }
            }
        }
		// if(!empty($subdepid)){
  //       	$depid=$subdepid;
  //       }
  //       if(!empty($depid)){
  //       	$this->db->where('ae.asen_depid',$depid);
  //       }
        // if(!empty($depid)){
        //     if(!empty($subdeparray)){
        //         $this->db->where_in('ae.asen_depid',$subdeparray);
        //     }else{
        //     $this->db->where('ae.asen_depid',$depid);    
        //     }
        // }

         if(!empty($depid)){

		    if(!empty($subdepid)){
		     	$this->db->where("asen_depid =".$subdepid." ");
		     }else{
		     	if(!empty($subdeparray)){
		     		$this->db->where_in("asen_depid",$subdeparray);
		     	}else{
		     		$this->db->where("asen_depid =".$depid." ");
		     	}
		     	
		     }
	     }
	     
     if(!empty($searchtext))
      {
          $this->db->where("asen_description like  '%".$searchtext."%'  ");
      }
      if(!empty($asen_dispose)){
      	$this->db->where('asen_isdispose',$asen_dispose);
      }
      if(!empty($staffid)){
      	$this->db->where('asen_staffid',$staffid);
      }
		$get = $_GET;
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
         if(!empty($get['sSearch_0'])){
            $this->db->where("lower(asen_assetcode) like  '%".$get['sSearch_0']."%'  ");
        }
		if(!empty($get['sSearch_1'])){
            $this->db->where("lower(ec.eqca_category) like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_2']."%'  ");
        }
       	if(!empty($get['sSearch_3'])){
            $this->db->where("lower(asen_desc) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(asen_serialno) like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(asst_statusname) like  '%".$get['sSearch_5']."%'  ");
        }
         if(!empty($get['sSearch_6'])){
            $this->db->where("lower(asen_purchasedatebs) like  '%".$get['sSearch_6']."%'  ");
        }

         if(!empty($get['sSearch_7'])){
            $this->db->where("lower(asen_purchaserate) like  '%".$get['sSearch_7']."%'  ");
        }
      
        if($cond) {
            $this->db->where($cond);
        }
      	$resltrpt=$this->db->select("COUNT('*') as cnt")
      					->from('asen_assetentry ae')
					    ->join('asst_assetstatus as','as.asst_asstid=ae.asen_status','LEFT')
					    ->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT')
					    ->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT')
					    ->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT')
					    ->join('dist_distributors dt','dt.dist_distributorid=ae.asen_distributor','LEFT')
					    ->join('dept_department dp','dp.dept_depid=ae.asen_depid','LEFT')
					    ->get()
      					->row();
      	// $totalfilteredrecs=sizeof($resltrpt);
      	 // if (!empty($_GET['iDisplayLength']) ) {
            $totalfilteredrecs = !empty($resltrpt->cnt)?$resltrpt->cnt:0;
        // }
      	
      	$get = $_GET;
	    foreach ($get as $key => $value) {
	        $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
	    }
	    	$totalrecs='';
      	$lmt=$this->input->post('limit');
      	if($lmt){
      		$limit=$lmt;
      	}else{
      	$limit = 15;	
      	}
      	
      	$offset = 0;
        if(!empty($_GET["iDisplayLength"])){
           	$limit = $_GET['iDisplayLength'];
           	$offset = $_GET["iDisplayStart"];
        }
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
        	$order_by = 'asen_desc';
      	else if($this->input->get('iSortCol_0')==4)
       		$order_by = 'asen_serialno';
       		else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'asst_statusname';
       	else if($this->input->get('iSortCol_0')==6)
      	 	$order_by = 'asen_purchasedatebs';
      	 else if($this->input->get('iSortCol_0')==7)
      	 	$order_by = 'asen_purchaserate';
      
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
          if(!empty($asen_assettype)){
        	$this->db->where('ae.asen_assettype',$asen_assettype);
        }
          if(!empty($asen_status)){
        	$this->db->where('ae.asen_status',$asen_status);
        }
         if(!empty($asen_condition)){
        	$this->db->where('ae.asen_condition',$asen_condition);
        }
         if(!empty($asen_description)){
        	$this->db->where('ae.asen_description',$asen_description);
        }
         if(!empty($asen_distributor)){
        	$this->db->where('ae.asen_distributor',$asen_distributor);
        }
        if(!empty($schoolid)){
        	$this->db->where('ae.asen_schoolid',$schoolid);
        }
      	if (!empty($depid)) {
	        if (!empty($subdepid)) {
	            $this->db->where("asen_depid =" . $subdepid . " ");
	        } else {
	            if (!empty($subdeparray)) {
	                $this->db->where_in("asen_depid", $subdeparray);
	            } else {
	                $this->db->where("asen_depid =" . $depid . " ");
	            }
	        }
        }
        if(!empty($asen_dispose)){
      	$this->db->where('asen_isdispose',$asen_dispose);
      }	
      if(!empty($staffid)){
      	$this->db->where('asen_staffid',$staffid);
      }
        if(!empty($get['sSearch_0'])){
            $this->db->where("lower(asen_assetcode) like  '%".$get['sSearch_0']."%'  ");
        }
		if(!empty($get['sSearch_1'])){
            $this->db->where("lower(ec.eqca_category) like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_2']."%'  ");
        }
       if(!empty($get['sSearch_3'])){
            $this->db->where("lower(asen_desc) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(asen_serialno) like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(asst_statusname) like  '%".$get['sSearch_5']."%'  ");
        }
         if(!empty($get['sSearch_6'])){
            $this->db->where("lower(asen_purchasedatebs) like  '%".$get['sSearch_6']."%'  ");
        }
         if(!empty($get['sSearch_7'])){
            $this->db->where("lower(asen_purchaserate) like  '%".$get['sSearch_7']."%'  ");
        }
      
        if($cond) {
            $this->db->where($cond);
        }
        $this->db->select('ae.*,il.itli_itemname,dt.dist_distributor,ec.eqca_category,sc.loca_name as schoolname,as.asst_statusname,ac.asco_conditionname,dp.dept_depname,dtfp.dept_depname depparent,stin_fname,stin_mname,stin_lname');
	    $this->db->from('asen_assetentry ae');
	    $this->db->join('asst_assetstatus as','as.asst_asstid=ae.asen_status','LEFT');
	    $this->db->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT');
	    $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT');
	    $this->db->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT');
	    $this->db->join('dist_distributors dt','dt.dist_distributorid=ae.asen_distributor','LEFT');
	     $this->db->join('dept_department dp','dp.dept_depid=ae.asen_depid','LEFT');
	      $this->db->join('dept_department dtfp','dtfp.dept_depid=dp.dept_parentdepid','LEFT');
	     $this->db->join('loca_location sc','sc.loca_locationid=ae.asen_schoolid','LEFT');

	     $this->db->join('stin_staffinfo st','st.stin_staffinfoid=ae.asen_staffid','LEFT');
	     if($order_by){
	    	$this->db->order_by($order_by,$order); 	
	     }
	    
        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }
		// $totalfilteredrecs=0;

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
    	$serialno= $this->input->post('serialno');
    	if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='ARMY') {
			$this->db->select('ae.*,il.itli_itemname,dt.dist_distributor,ec.eqca_category,sc.loca_name as schoolname,as.asst_statusname,ac.asco_conditionname,dp.dept_depname,dtfp.dept_depname depparent,stin_fname,stin_mname,stin_lname');
    	}else{

			$this->db->select('ae.*,as.asst_statusname,ac.asco_conditionname,ec.eqca_category,il.itli_itemname,ma.manu_manlst');
    	}
	  
	    $this->db->from('asen_assetentry ae');
	    $this->db->join('asst_assetstatus as','as.asst_asstid=ae.asen_status','LEFT');
	    $this->db->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT');
	    $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT');
	    $this->db->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT');
	    $this->db->join('manu_manufacturers ma','ma.manu_manlistid=ae.asen_manufacture','LEFT');
	    if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='ARMY') {
    	$this->db->join('dist_distributors dt','dt.dist_distributorid=ae.asen_distributor','LEFT');
	    $this->db->join('dept_department dp','dp.dept_depid=ae.asen_depid','LEFT');
      	$this->db->join('dept_department dtfp','dtfp.dept_depid=dp.dept_parentdepid','LEFT');
     	$this->db->join('loca_location sc','sc.loca_locationid=ae.asen_schoolid','LEFT');
     	$this->db->join('stin_staffinfo st','st.stin_staffinfoid=ae.asen_staffid','LEFT');
	    }

		if($srstinl)
		{
			$this->db->where($srstinl);
		}
		if($srchtxt)
		{
			$this->db->where("ae.asen_assetcode like  '%".$srchtxt."%' || ae.asen_description like  '%".$srchdec."%' || ae.asen_serialno like  '%".$serialno."%'");
		}
      	if($srchdec)
      	{
         	$this->db->where("ae.asen_description like  '%".$srchdec."%'  ");
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
	public function get_assets_list_data($srch=false,$limit=false,$offset=false,$order_by=false,$order=false,$is_distinct=false)
	{
		$assettype = $this->input->post('asen_assettype');
      	$manufacture = $this->input->post('asen_manufacture');
      	$status = $this->input->post('asen_status');
      	$condition = $this->input->post('asen_condition');
      	$depreciation = $this->input->post('asen_depreciation');
      	$frmDate=!empty($this->input->post('frmDate'))?$this->input->post('frmDate'):'';
        $toDate=!empty($this->input->post('toDate'))?$this->input->post('toDate'):'';
        $dateSearch = $this->input->post('dateSearch');
        $Datatype = $this->input->post('Datatype');
        $asen_assettypeid = $this->input->post('asen_assettypeid');
		$this->db->select('*','sa.asst_statusname,ac.asco_conditionname,ec.eqca_category,ma.manu_manlst,de.dety_depreciation,dis.dist_distributor,lo.loca_locationid,lo.loca_name,at.asty_typename');
	    $this->db->from('asen_assetentry ae');
	    $this->db->join('asst_assetstatus as','as.asst_asstid=ae.asen_status','LEFT');
	    $this->db->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT');
	    $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT');
	    $this->db->join('manu_manufacturers ma','ma.manu_manlistid=ae.asen_manufacture','LEFT');
	    $this->db->join('dety_depreciation de','de.dety_depreciationid=ae.asen_depreciation','LEFT');
	    $this->db->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT');
	    $this->db->join('dist_distributors dis','dis.dist_distributorid=ae.asen_distributor','LEFT');
        $this->db->join('loca_location lo','lo.loca_locationid=ae.asen_locationid','LEFT');
        $this->db->join('asty_assettype at','at.asty_astyid=ae.asen_assettypeid','LEFT');
	    if($srch)
      	{
         	$this->db->where($srch); 
      	}
      	if(!empty($frmDate &&  $toDate))
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
         if($dateSearch == "")
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
        if($Datatype)
     	{
         	$this->db->where('ae.asen_iscomponent',$Datatype);
     	}
     	 if($asen_assettypeid)
     	{
         	$this->db->where('ae.asen_assettypeid',$asen_assettypeid);
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
		// if ($query->num_rows() > 0) 
		// {
		// 	$data=$query->result();		
		// 	return $data;		
		// }
		$last_qry= $this->db->last_query();
		if($is_distinct)
		{
			$new_qry=$this->db->query("SELECT DISTINCT(eqca_category),eqca_equipmentcategoryid FROM( $last_qry )X")->result();
			return $new_qry;
		}
		else
		{
			if ($query->num_rows() > 0) 
			{
				$data=$query->result();		
				return $data;		
			}		
		}		
		return false;
	}
	public function get_assets($srchcol=false)
	{
		// $this->db->select('eq.*, as.*');
		$this->db->select('eq.*');
		$this->db->from('itli_itemslist eq');
		// $this->db->join('asen_assetentry as','as.asen_description = eq.itli_itemlistid');
		// $this->db->where('eq.itli_isnonexp','Y');
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
		$locationid=$this->input->post('locid');
		$this->db->select('as.asen_asenid,il.itli_itemname, as.asen_assetcode');
		$this->db->from('asen_assetentry as');
		$this->db->join('itli_itemslist il','as.asen_description = il.itli_itemlistid','LEFT');
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		if($locationid){
			$this->db->where('asen_locationid',$locationid);
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
	public function get_comp_asset_list($cond=false)
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
            $totalrecs = count($nquery);
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
			$asstscode=$this->input->post('id');
		$this->db->select('ae.*, il.itli_itemname, ac.asco_conditionname, ma.manu_manlst,dt.dist_distributor,as.asst_statusname,eqca_category,lo.loca_name,de.dety_depreciation,stin_fname,stin_mname,stin_lname,dp.dept_depname,dtfp.dept_depname depparen');
      	$this->db->from('asen_assetentry ae');
	    $this->db->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT');
	    $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT');
	    $this->db->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT');
	    $this->db->join('asst_assetstatus as','ae.asen_status=as.asst_asstid','LEFT');
	    $this->db->join('manu_manufacturers ma','ma.manu_manlistid=ae.asen_manufacture','LEFT');
	    $this->db->join('dist_distributors dt','dt.dist_distributorid=ae.asen_distributor','LEFT');
	    $this->db->join('loca_location lo','lo.loca_locationid=ae.asen_locationid','LEFT');
	    $this->db->join("dety_depreciation de",'de.dety_depreciationid=ae.asen_depreciation','LEFT');
  		$this->db->join('stin_staffinfo st','st.stin_staffinfoid=ae.asen_staffid','LEFT');
  		
		$this->db->join('dept_department dp','dp.dept_depid=ae.asen_depid','LEFT');
		$this->db->join('dept_department dtfp','dtfp.dept_depid=dp.dept_parentdepid','LEFT');

	    if($srch){
	    	$this->db->where($srch);
	    }
	    if($asstscode){
	    	$this->db->where("ae.asen_serialno LIKE '%".$asstscode."%' OR ae.asen_assetcode LIKE '%".$asstscode."%'" );
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
	  public function get_all_description($srstinl=false,$limit=false,$offset=false,$order_by=false,$order=false,$groupby=false)
    {
        $srchtxt= $this->input->post('srchtext');
        $this->db->select('DISTINCT(asen_description),asen_asenid');
        $this->db->from('asen_assetentry');
        $this->db->group_by('asen_description');
        if($srstinl)
        {
            $this->db->where($srstinl);
        }
        if($srchtxt)
        {
            $this->db->where("asen_description like  '%".$srchtxt."%'  ");
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
        if($groupby)
        {
            $this->db->group_by($groupby);
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
    public function assets_description($srchcol=false)
	{
		$this->db->select('ae.asen_asenid,ae.asen_description,ae.asen_assetcode,it.itli_itemlistid,it.itli_itemname');
		$this->db->from('asen_assetentry ae');
	    $this->db->join('itli_itemslist it','it.itli_itemlistid=ae.asen_description','LEFT');
	     $this->db->group_by('itli_itemname');
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
	public function get_all_comp_assets_list($cond = false){  	
		// $frmDate=!empty($this->input->get('frmDate'))?$this->input->get('frmDate'):CURMONTH_DAY1;
  //       $toDate=!empty($this->input->get('toDate'))?$this->input->get('toDate'):DISPLAY_DATE;
  //       $dateSearch = $this->input->get('dateSearch');
           $asen_component_typeid = $this->input->get('asen_component_typeid');
           $asen_jointypeid = $this->input->get('asen_jointypeid');
           $asen_pavement_typeid = $this->input->get('asen_pavement_typeid');
           $asen_soli_typeid = $this->input->get('asen_soli_typeid');
           $asen_pipe_zoneid = $this->input->get('asen_pipe_zoneid');
           // $asen_description = $this->input->get('asen_description');
           $srchtext= $this->input->get('srchtext');
        // if($dateSearch == "purchasedate")
        // {
        //     if($frmDate &&  $toDate)
        //     {                  
        //         if(DEFAULT_DATEPICKER=='NP')
        //         {
        //             $this->db->where(array('asen_purchasedatebs >='=>$frmDate,'asen_purchasedatebs <='=>$toDate));
        //         }
        //         else
        //         {
        //             $this->db->where(array('asen_purchasedatead >='=>$frmDate,'asen_purchasedatead <='=>$toDate));
        //         }
        //     }
        // }
    //     if($dateSearch == "inservicedate")
    //     {
    //         if($frmDate &&  $toDate)
    //         {
    //             if(DEFAULT_DATEPICKER=='NP')
				// {
				// 	$this->db->where(array('asen_inservicedatebs >='=>$frmDate,'asen_inservicedatebs <='=>$toDate));
				// }
				// else
				// {
				//   	$this->db->where(array('asen_inservicedatead >='=>$frmDate,'asen_inservicedatead <='=>$toDate));
				// }
    //         }
    //     }
        // if($dateSearch == "warrentydate")
        // {
        //     if($frmDate &&  $toDate)
        //     {
        //     	if(DEFAULT_DATEPICKER=='NP')
        //         {
        //          	$this->db->where(array('asen_warrentydatebs >='=>$frmDate,'asen_warrentydatebs <='=>$toDate));
        //         }
        //         else
        //         {
        //             $this->db->where(array('asen_warrentydatead >='=>$frmDate,'asen_warrentydatead <='=>$toDate));
        //         }
        //     }
        // }
          if(!empty($asen_component_typeid)){
        	$this->db->where('ae.asen_component_typeid',$asen_component_typeid);
        }
          if(!empty($asen_jointypeid)){
        	$this->db->where('ae.asen_jointypeid',$asen_jointypeid);
        }
         if(!empty($asen_pavement_typeid)){
        	$this->db->where('ae.asen_pavement_typeid',$asen_pavement_typeid);
        }
        if(!empty($asen_soli_typeid)){
        	$this->db->where('ae.asen_soli_typeid',$asen_soli_typeid);
        }
         if(!empty($asen_pipe_zoneid)){
        	$this->db->where('ae.asen_pipe_zoneid',$asen_pipe_zoneid);
        }
     //     if(!empty($asen_description)){
     //    	$this->db->where('ae.asen_description',$asen_description);
     //    }
     if(!empty($srchtext))
      {
          $this->db->where("ae.asen_assetcode like  '%".$srchtext."%' || ae.asen_ncomponentid like  '%".$srchtext."%' ");
      }
		// echo "hi";
		// die();
		$get = $_GET;
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
       	if(!empty($get['sSearch_0'])){
            $this->db->where("coty.coty_name like  '%".$get['sSearch_0']."%'  ");
        }
		if(!empty($get['sSearch_1'])){
            $this->db->where("asen_assetcode like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("asen_ncomponentid like  '%".$get['sSearch_2']."%'  ");
        }
       	if(!empty($get['sSearch_3'])){
            $this->db->where("joty.joty_name like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("paty.paty_name like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("asen_manufacture_datead like  '%".$get['sSearch_5']."%'  ");
        }
   //      if(!empty($get['sSearch_6'])){
   //          $this->db->where("asen_manufacture_datead like  '%".$get['sSearch_6']."%'  ");
   //      }
   //      if(!empty($get['sSearch_7'])){
   //       	if(DEFAULT_DATEPICKER=='NP')
			// {
			// 	$this->db->where("asen_purchasedatebs like  '%".$get['sSearch_7']."%'  ");
			// }
			// else{
			// 	$this->db->where("asen_purchasedatead like  '%".$get['sSearch_7']."%'  ");
			// }
   //      }
   //      if(!empty($get['sSearch_8'])){
   //       	if(DEFAULT_DATEPICKER=='NP')
			// {
			// 	$this->db->where("asen_warrentydatebs like  '%".$get['sSearch_8']."%'  ");
			// }
			// else{
			// 	$this->db->where("asen_warrentydatead like  '%".$get['sSearch_8']."%'  ");
			// }
   //      }
   //      if(!empty($get['sSearch_9'])){
   //          $this->db->where("asen_location like  '%".$get['sSearch_9']."%'  ");
   //      }
        if($cond) {
            $this->db->where($cond);
        }
      	$resltrpt=$this->db->select("asen_assetcode")
      					->from('asen_assetentry ae')
					    ->join('coty_componenttype coty','coty.coty_id= ae.asen_component_typeid','LEFT')
					    ->join('joty_jointype joty','joty.joty_id=ae.asen_jointypeid','LEFT')
					    ->join('soty_soiltype soty','soty.soty_id=ae.asen_soli_typeid','LEFT')
					    ->join('pizo_pipezone pizo','pizo.pizo_id=ae.asen_pipe_zoneid','LEFT')
					    ->join('paty_pavementtype paty','paty.paty_id=ae.asen_pavement_typeid','LEFT')
      					->get()
      					->result();
	    // echo $this->db->last_query();die(); 
      	// $totalfilteredrecs=sizeof($resltrpt);
      	 if (!empty($_GET['iDisplayLength']) &&  !empty($resltrpt) && is_array($resltrpt) && sizeof($resltrpt) > 0 ) {
            $totalfilteredrecs = sizeof($resltrpt);
        }
      	$order_by = '';
      	$order = 'desc';
      	if($this->input->get('sSortDir_0'))
  		{
  			$order = $this->input->get('sSortDir_0');
  		}
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'asen_assetcode';
       //  if($this->input->get('iSortCol_0')==1)
       //  	$order_by = 'eqca_category';
       //  else if($this->input->get('iSortCol_0')==2)
       //  	$order_by = 'itli_itemname';
      	// else if($this->input->get('iSortCol_0')==3)
       //  	$order_by = 'asen_modelno';
      	// else if($this->input->get('iSortCol_0')==4)
       // 		$order_by = 'asen_serialno';
       // 		else if($this->input->get('iSortCol_0')==5)
      	//  	$order_by = 'asst_statusname';
       // 	else if($this->input->get('iSortCol_0')==6)
      	//  	$order_by = 'asco_conditionname';
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
        //  if($dateSearch == "purchasedate")
        // {
        //     if($frmDate &&  $toDate)
        //     {                  
        //         if(DEFAULT_DATEPICKER=='NP')
        //         {
        //             $this->db->where(array('asen_purchasedatebs >='=>$frmDate,'asen_purchasedatebs <='=>$toDate));
        //         }
        //         else
        //         {
        //             $this->db->where(array('asen_purchasedatead >='=>$frmDate,'asen_purchasedatead <='=>$toDate));
        //         }
        //     }
        // }
    //     if($dateSearch == "inservicedate")
    //     {
    //         if($frmDate &&  $toDate)
    //         {
    //             if(DEFAULT_DATEPICKER=='NP')
				// {
				// 	$this->db->where(array('asen_inservicedatebs >='=>$frmDate,'asen_inservicedatebs <='=>$toDate));
				// }
				// else
				// {
				//   	$this->db->where(array('asen_inservicedatead >='=>$frmDate,'asen_inservicedatead <='=>$toDate));
				// }
    //         }
    //     }
        // if($dateSearch == "warrentydate")
        // {
        //     if($frmDate &&  $toDate)
        //     {
        //     	if(DEFAULT_DATEPICKER=='NP')
        //         {
        //          	$this->db->where(array('asen_warrentydatebs >='=>$frmDate,'asen_warrentydatebs <='=>$toDate));
        //         }
        //         else
        //         {
        //             $this->db->where(array('asen_warrentydatead >='=>$frmDate,'asen_warrentydatead <='=>$toDate));
        //         }
        //     }
        // }
          if(!empty($asen_component_typeid)){
        	$this->db->where('ae.asen_component_typeid',$asen_component_typeid);
        }
          if(!empty($asen_jointypeid)){
        	$this->db->where('ae.asen_jointypeid',$asen_jointypeid);
        }
         if(!empty($asen_pavement_typeid)){
        	$this->db->where('ae.asen_pavement_typeid',$asen_pavement_typeid);
        }
          if(!empty($asen_soli_typeid)){
        	$this->db->where('ae.asen_soli_typeid',$asen_soli_typeid);
        }
         if(!empty($asen_pipe_zoneid)){
        	$this->db->where('ae.asen_pipe_zoneid',$asen_pipe_zoneid);
        }
         if(!empty($srchtext)){
        	 $this->db->where("ae.asen_assetcode like  '%".$srchtext."%' || ae.asen_ncomponentid like  '%".$srchtext."%' ");
        }
        if(!empty($get['sSearch_0'])){
            $this->db->where("coty.coty_name like  '%".$get['sSearch_0']."%'  ");
        }
		if(!empty($get['sSearch_1'])){
            $this->db->where("asen_assetcode like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("asen_ncomponentid like  '%".$get['sSearch_2']."%'  ");
        }
       	if(!empty($get['sSearch_3'])){
            $this->db->where("joty.joty_name like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("paty.paty_name like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("asen_manufacture_datead like  '%".$get['sSearch_5']."%'  ");
        }
   //      if(!empty($get['sSearch_6'])){
   //          $this->db->where("asen_manufacture_datead like  '%".$get['sSearch_6']."%'  ");
   //      }
   //      if(!empty($get['sSearch_7'])){
   //       	if(DEFAULT_DATEPICKER=='NP')
			// {
			// 	$this->db->where("asen_purchasedatebs like  '%".$get['sSearch_7']."%'  ");
			// }
			// else{
			// 	$this->db->where("asen_purchasedatead like  '%".$get['sSearch_7']."%'  ");
			// }
   //      }
   //      if(!empty($get['sSearch_8'])){
   //       	if(DEFAULT_DATEPICKER=='NP')
			// {
			// 	$this->db->where("asen_warrentydatebs like  '%".$get['sSearch_8']."%'  ");
			// }
			// else{
			// 	$this->db->where("asen_warrentydatead like  '%".$get['sSearch_8']."%'  ");
			// }
   //      }
   //      if(!empty($get['sSearch_9'])){
   //          $this->db->where("asen_location like  '%".$get['sSearch_9']."%'  ");
   //      }
        if($cond) {
            $this->db->where($cond);
        }
        $this->db->select('*');
	    $this->db->from('asen_assetentry ae');
		$this->db->join('coty_componenttype coty','coty.coty_id= ae.asen_component_typeid','LEFT');
		$this->db->join('joty_jointype joty','joty.joty_id=ae.asen_jointypeid','LEFT');
		$this->db->join('soty_soiltype soty','soty.soty_id=ae.asen_soli_typeid','LEFT');
		$this->db->join('pizo_pipezone pizo','pizo.pizo_id=ae.asen_pipe_zoneid','LEFT');
		$this->db->join('paty_pavementtype paty','paty.paty_id=ae.asen_pavement_typeid','LEFT');
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
	public function get_all_comp_assets_list_summary(){
       $asen_component_typeid = $this->input->get('asen_component_typeid');
       $assettypeid = $this->input->get('assettypeid');
       $locationid = $this->input->get('asen_locationid');
       $srchtext= $this->input->get('srchtext');
      	if(!empty($asen_component_typeid)){
        	$this->db->where('ae.asen_component_typeid',$asen_component_typeid);
        }
          if(!empty($assettypeid)){
        	$this->db->where('ae.asen_assettypeid',$assettypeid);
        }
         if(!empty($asen_locationid)){
        	$this->db->where('ae.asen_locationid',$locationid);
        }
		$get = $_GET;
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
       	if(!empty($get['sSearch_0'])){
            $this->db->where("ae.asen_assetcode like  '%".$get['sSearch_0']."%'  ");
        }
		if(!empty($get['sSearch_1'])){
            $this->db->where("ae.asen_faccode like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("ae.asen_ncomponentid like  '%".$get['sSearch_2']."%'  ");
        }
		$this->db->where('asen_iscomponent','Y');
      	$resltrpt=$this->db->select("asen_assetcode")
      					->from('asen_assetentry ae')
					    ->join('loca_location loc','loc.loca_locationid=ae.asen_locationid','LEFT')
      					->get()
      					->result();
	    // echo $this->db->last_query();die(); 
      	// $totalfilteredrecs=sizeof($resltrpt);
      					$totalfilteredrecs=0;
      	 if (!empty($_GET['iDisplayLength']) &&  !empty($resltrpt) && is_array($resltrpt) && sizeof($resltrpt) > 0 ) {
            $totalfilteredrecs = sizeof($resltrpt);
        }
      	$order_by = '';
      	$order = 'desc';
      	if($this->input->get('sSortDir_0'))
  		{
  			$order = $this->input->get('sSortDir_0');
  		}
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'asen_assetcode';
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
        	if(!empty($asen_component_typeid)){
        	$this->db->where('ae.asen_component_typeid',$asen_component_typeid);
        }
          if(!empty($assettypeid)){
        	$this->db->where('ae.asen_assettypeid',$assettypeid);
        }
         if(!empty($asen_locationid)){
        	$this->db->where('ae.asen_locationid',$locationid);
        }
         if(!empty($get['sSearch_0'])){
            $this->db->where("ae.asen_assetcode like  '%".$get['sSearch_0']."%'  ");
        }
		if(!empty($get['sSearch_1'])){
            $this->db->where("ae.asen_faccode like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("ae.asen_ncomponentid like  '%".$get['sSearch_2']."%'  ");
        }
             	$this->db->where('asen_iscomponent','Y');
        $this->db->select('ae.*,loc.loca_name,loc.loca_locationid')
        ->from('asen_assetentry ae')
					    ->join('loca_location loc','loc.loca_locationid=ae.asen_locationid','LEFT');
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
	public function get_all_comp_assets($srstinl=false,$limit=false,$offset=false,$order_by=false,$order=false,$groupby=false)
	{
		$fromdate=$this->input->post('fromdate');
   	 	$todate=$this->input->post('todate');
    	$srchdate=$this->input->post('date');
    	$srchtxt= $this->input->post('srchtext');
    	$srchdec= $this->input->post('srchdec');
    	$serialno= $this->input->post('serialno');
		$this->db->select('*');
	    $this->db->from('asen_assetentry ae');
		$this->db->join('coty_componenttype coty','coty.coty_id= ae.asen_component_typeid','LEFT');
		$this->db->join('joty_jointype joty','joty.joty_id=ae.asen_jointypeid','LEFT');
		$this->db->join('soty_soiltype soty','soty.soty_id=ae.asen_soli_typeid','LEFT');
		$this->db->join('pizo_pipezone pizo','pizo.pizo_id=ae.asen_pipe_zoneid','LEFT');
		$this->db->join('paty_pavementtype paty','paty.paty_id=ae.asen_pavement_typeid','LEFT');
		if($srstinl)
		{
			$this->db->where($srstinl);
		}
		if($srchtxt)
		{
			$this->db->where("ae.asen_assetcode like  '%".$srchtxt."%' || ae.asen_description like  '%".$srchdec."%' || ae.asen_serialno like  '%".$serialno."%'");
		}
      	if($srchdec)
      	{
         	$this->db->where("ae.asen_description like  '%".$srchdec."%'  ");
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

	public function get_assets_list_popup_ku($cond = false){  	
		$totalrecs=0;
         $searchtext = $this->input->get('searchtext');
         $frombranch=$this->input->get('frombranch');
         $fromdepid=$this->input->get('fromdepid');
		$fromsubdepid=$this->input->get('fromsubdepid');
		$check_parentid=array();
		if(!empty($fromdepid)){
         	$check_parentid=$this->general->get_tbl_data('dept_depid,dept_parentdepid','dept_department',array('dept_depid'=>$fromdepid),'dept_depname','ASC');
            }
            $subdeparray=array();
            if(!empty($check_parentid)){
            $parentdepid=!empty($check_parentid[0]->dept_parentdepid)?$check_parentid[0]->dept_parentdepid:'0';
            if($parentdepid=='0'){
            $subdep_result=$this->general->get_tbl_data('dept_depid','dept_department',array('dept_parentdepid'=>$fromdepid),'dept_depname','ASC');
            if(!empty($subdep_result)){
                foreach ($subdep_result as $ksd => $dep) {
                  $subdeparray[]=$dep->dept_depid;
                }
            }
            }
        }

		$get = $_GET;
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
      	if(!empty($searchtext)){
	          $this->db->where("asen_desc LIKE  '%".$searchtext."%' OR asen_assetcode LIKE  '%".$searchtext."%' ");
	     }
	     if(!empty($frombranch)){
	     	if(ORGANIZATION_NAME=='KU'){
				$this->db->where("asen_schoolid =".$frombranch." ");
	     	}else{
	     		$this->db->where("asen_locationid =".$frombranch." ");
	     	}
	     }

	     if(!empty($fromdepid)){

		    if(!empty($fromsubdepid)){
		     	$this->db->where("asen_depid =".$fromsubdepid." ");
		     }else{
		     	if(!empty($subdeparray)){
		     		$this->db->where_in("asen_depid",$subdeparray);
		     	}else{
		     		$this->db->where("asen_depid =".$fromdepid." ");
		     	}
		     	
		     }
	     }
	    
	    if($this->location_ismain=='N')
	    {
	    	$this->db->where('asen_schoolid',$this->locationid);
	    }

       if(!empty($get['sSearch_0'])){
            $this->db->where("asen_assetcode like  '%".$get['sSearch_0']."%'  ");
        }
		if(!empty($get['sSearch_1'])){
            $this->db->where("asen_assestmanualcode like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
           $this->db->where("asen_desc like  '%".$get['sSearch_2']."%'  ");
        }
        $this->db->where("asen_isdispose",'N');

      	$resltrpt=$this->db->select("asen_assetcode")
      					->from('asen_assetentry ae')
					    ->join('asst_assetstatus as','as.asst_asstid=ae.asen_status','LEFT')
					    ->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT')
					    ->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT')
					    ->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT')
					    ->join('xw_dist_distributors dt','dt.dist_distributorid=ae.asen_distributor','LEFT')
      					->get()
      					->result();
	     if (!empty($_GET['iDisplayLength']) &&  !empty($resltrpt) && is_array($resltrpt) && sizeof($resltrpt) > 0 ) {
            $totalfilteredrecs = sizeof($resltrpt);
        }
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
        	$order_by = 'asen_assestmanualcode';
        else if($this->input->get('iSortCol_0')==2)
        	$order_by = 'asen_desc';
      	else if($this->input->get('iSortCol_0')==3)
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
	  if(!empty($searchtext))
		      {
		          $this->db->where("(asen_desc LIKE  '%".$searchtext."%' OR asen_assetcode LIKE  '%".$searchtext."%' )");
		      }
	     if(!empty($frombranch)){
     	if(ORGANIZATION_NAME=='KU'){
			$this->db->where("asen_schoolid =".$frombranch." ");
     	}else{
     		$this->db->where("asen_locationid =".$frombranch." ");
     	}
     }
        
	      if(!empty($fromdepid)){

		    if(!empty($fromsubdepid)){
		     	$this->db->where("asen_depid =".$fromsubdepid." ");
		     }else{
		     	if(!empty($subdeparray)){
		     		$this->db->where_in("asen_depid",$subdeparray);
		     	}else{
		     		$this->db->where("asen_depid =".$fromdepid." ");
		     	}
		     	
		     }
	     }
	    
        if(!empty($get['sSearch_0'])){
            $this->db->where("asen_assetcode like  '%".$get['sSearch_0']."%'  ");
        }
		if(!empty($get['sSearch_1'])){
            $this->db->where("asen_assestmanualcode like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
             $this->db->where("asen_desc like  '%".$get['sSearch_2']."%'  ");
        }
         if($this->location_ismain=='N')
	    {
	    	$this->db->where('asen_schoolid',$this->locationid);
	    }
	    
          $this->db->where("asen_isdispose",'N');
        $subqry="(SELECT  CONCAT(dete_deteid,',',dete_enddatebs,',',dete_netvalue)   FROM xw_dete_depreciationtemp dt
WHERE dt.dete_assetid=ae.asen_asenid ORDER BY dete_deteid DESC LIMIT 1 
) as last_deprec";
$subqry="0 as last_deprec";
        $this->db->select("asen_asenid,asen_assetcode, asen_manualcode, asen_serialno,
 asen_purchaserate, asen_purchasedatebs,asen_description, asen_desc,
 asen_remarks,ec.eqca_category,dp.dept_depname,$subqry,il.itli_itemname,ae.asen_staffid ,stin_fname,stin_mname,stin_lname");
	    $this->db->from('asen_assetentry ae');
	    $this->db->join('asst_assetstatus as','as.asst_asstid=ae.asen_status','LEFT');
	    $this->db->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT');
	    $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT');
	    $this->db->join('dept_department dp','dp.dept_depid=ae.asen_depid','LEFT');
	    $this->db->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT');
	    $this->db->join('dist_distributors dt','dt.dist_distributorid=ae.asen_distributor','LEFT');
	    // $this->db->join('staff dt','dt.dist_distributorid=ae.asen_distributor','LEFT');
	$this->db->join('stin_staffinfo st','st.stin_staffinfoid=ae.asen_staffid','LEFT');

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

	public function get_assets_list_popup($cond = false){  	
		$totalrecs=0;
         $searchtext = $this->input->get('searchtext');
         $frombranch=$this->input->get('frombranch');
         $fromdepid=$this->input->get('fromdepid');
		$fromsubdepid=$this->input->get('fromsubdepid');
		$check_parentid=array();
		if(!empty($fromdepid)){
         	$check_parentid=$this->general->get_tbl_data('dept_depid,dept_parentdepid','dept_department',array('dept_depid'=>$fromdepid),'dept_depname','ASC');
            }
            $subdeparray=array();
            if(!empty($check_parentid)){
            $parentdepid=!empty($check_parentid[0]->dept_parentdepid)?$check_parentid[0]->dept_parentdepid:'0';
            if($parentdepid=='0'){
            $subdep_result=$this->general->get_tbl_data('dept_depid','dept_department',array('dept_parentdepid'=>$fromdepid),'dept_depname','ASC');
            if(!empty($subdep_result)){
                foreach ($subdep_result as $ksd => $dep) {
                  $subdeparray[]=$dep->dept_depid;
                }
            }
            }
        }

		$get = $_GET;
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
      	if(!empty($searchtext)){
	          $this->db->where("asen_desc LIKE  '%".$searchtext."%' OR asen_assetcode LIKE  '%".$searchtext."%' ");
	     }
	     if(!empty($frombranch)){
	     	if(ORGANIZATION_NAME=='KU'){
				$this->db->where("asen_schoolid =".$frombranch." ");
	     	}else{
	     		$this->db->where("asen_locationid =".$frombranch." ");
	     	}
	     }

	     if(!empty($fromdepid)){

		    if(!empty($fromsubdepid)){
		     	$this->db->where("asen_depid =".$fromsubdepid." ");
		     }else{
		     	if(!empty($subdeparray)){
		     		$this->db->where_in("asen_depid",$subdeparray);
		     	}else{
		     		$this->db->where("asen_depid =".$fromdepid." ");
		     	}
		     	
		     }
	     }
	    
       if(!empty($get['sSearch_0'])){
            $this->db->where("asen_assetcode like  '%".$get['sSearch_0']."%'  ");
        }
		if(!empty($get['sSearch_1'])){
            $this->db->where("asen_assestmanualcode like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
           $this->db->where("asen_desc like  '%".$get['sSearch_2']."%'  ");
        }
        $this->db->where("asen_isdispose",'N');

      	$resltrpt=$this->db->select("asen_assetcode")
      					->from('asen_assetentry ae')
					    ->join('asst_assetstatus as','as.asst_asstid=ae.asen_status','LEFT')
					    ->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT')
					    ->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT')
					    ->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT')
					    ->join('xw_dist_distributors dt','dt.dist_distributorid=ae.asen_distributor','LEFT')
      					->get()
      					->result();
	     if (!empty($_GET['iDisplayLength']) &&  !empty($resltrpt) && is_array($resltrpt) && sizeof($resltrpt) > 0 ) {
            $totalfilteredrecs = sizeof($resltrpt);
        }
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
        	$order_by = 'asen_assestmanualcode';
        else if($this->input->get('iSortCol_0')==2)
        	$order_by = 'asen_desc';
      	else if($this->input->get('iSortCol_0')==3)
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
	  if(!empty($searchtext))
		      {
		          $this->db->where("(asen_desc LIKE  '%".$searchtext."%' OR asen_assetcode LIKE  '%".$searchtext."%' )");
		      }
	     if(!empty($frombranch)){
     	if(ORGANIZATION_NAME=='KU'){
			$this->db->where("asen_schoolid =".$frombranch." ");
     	}else{
     		$this->db->where("asen_locationid =".$frombranch." ");
     	}
     }
        
	      if(!empty($fromdepid)){

		    if(!empty($fromsubdepid)){
		     	$this->db->where("asen_depid =".$fromsubdepid." ");
		     }else{
		     	if(!empty($subdeparray)){
		     		$this->db->where_in("asen_depid",$subdeparray);
		     	}else{
		     		$this->db->where("asen_depid =".$fromdepid." ");
		     	}
		     	
		     }
	     }
	    
        if(!empty($get['sSearch_0'])){
            $this->db->where("asen_assetcode like  '%".$get['sSearch_0']."%'  ");
        }
		if(!empty($get['sSearch_1'])){
            $this->db->where("asen_assestmanualcode like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
             $this->db->where("asen_desc like  '%".$get['sSearch_2']."%'  ");
        }
          $this->db->where("asen_isdispose",'N');
        $subqry="(SELECT  CONCAT(dete_deteid,',',dete_enddatebs,',',dete_netvalue)   FROM xw_dete_depreciationtemp dt
WHERE dt.dete_assetid=ae.asen_asenid ORDER BY dete_deteid DESC LIMIT 1 
) as last_deprec";
        $this->db->select(" asen_asenid,asen_assetcode, asen_manualcode, asen_serialno,
 asen_purchaserate, asen_purchasedatebs,asen_description, asen_desc,
 asen_remarks,ec.eqca_category,dp.dept_depname,$subqry,il.itli_itemname");
	    $this->db->from('asen_assetentry ae');
	    $this->db->join('asst_assetstatus as','as.asst_asstid=ae.asen_status','LEFT');
	    $this->db->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT');
	    $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT');
	    $this->db->join('dept_department dp','dp.dept_depid=ae.asen_depid','LEFT');
	    $this->db->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT');
	    $this->db->join('dist_distributors dt','dt.dist_distributorid=ae.asen_distributor','LEFT');
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
	public function doupload_lease($file) {
        $config['upload_path'] = './'.LEASE_ATTACHMENT_PATH;//define in constants
        $config['allowed_types'] = 'png|jpg|gif|jpeg|pdf';
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;    
        $config['max_size'] = '2000000';
        $config['max_width'] = '2400';
        $config['max_height'] = '1280';
        $this->upload->initialize($config);
        $this->load->library('upload', $config);
        $this->upload->do_upload($file);
        $data = $this->upload->data();
        $name_array = $data['file_name']; 
        return $name_array;
    }
    public function doupload_insurance($file) {
        $config['upload_path'] = './'.INSURANCE_ATTACHMENT_PATH;//define in constants
        $config['allowed_types'] = 'png|jpg|gif|jpeg|pdf';
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;    
        $config['max_size'] = '2000000';
        $config['max_width'] = '2400';
        $config['max_height'] = '1280';
        $this->upload->initialize($config);
        $this->load->library('upload', $config);
        $this->upload->do_upload($file);
        $data = $this->upload->data();
        $name_array = $data['file_name']; 
        return $name_array;
    }
    public function doupload_maintanance($file) {
        $config['upload_path'] = './'.MAINTENANCE_ATTACHMENT_PATH;//define in constants
        $config['allowed_types'] = 'png|jpg|gif|jpeg|pdf';
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;    
        $config['max_size'] = '2000000';
        $config['max_width'] = '2400';
        $config['max_height'] = '1280';
        $this->upload->initialize($config);
        $this->load->library('upload', $config);
        $this->upload->do_upload($file);
        $data = $this->upload->data();
        $name_array = $data['file_name']; 
        return $name_array;
    }
}