<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contractmgmt_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table = 'coin_contractinformation';
		$this->postid = $this->general->get_real_ipaddr();
		$this->postmac = $this->general->get_Mac_Address();
	}

	public $validate_contractmgmt = array(               
        array('field' => 'coin_contracttypeid', 'label' => 'Contract Type', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'coin_contracttitle', 'label' => 'Contract Title', 'rules' => 'trim|required|xss_clean|min_length[3]|callback_exists_contracttitle'),
        array('field' => 'coin_contractvalue', 'label' => 'Contract Value', 'rules' => 'trim|required|xss_clean|min_length[3]'),
        array('field' => 'coin_renewtypeid', 'label' => 'Contract Type', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'coin_description', 'label' => 'Contract Description', 'rules' => 'trim|required|xss_clean'),
        );

	public function save_contractmgmt()
	{
		$postdata=$this->input->post();
		//print_r($postdata); die;
		$id=$this->input->post('id');
		$equip=$this->input->post('coin_equipid');
		 $eqid='';
        if(!empty($equip))
        {
            $eqid=implode(',', $equip);   
        }
         //print_r($eqid); die;
        
		$postdata['coin_orgid']=$this->input->post('coin_orgid');
        

		$contract_startdate = $this->input->post('coin_contractstartdate');
			$contract_enddate = $this->input->post('coin_contractenddate');
			if(DEFAULT_DATEPICKER == 'NP'){
				$postdata['coin_contractstartdatebs'] = $contract_startdate;
				$postdata['coin_contractstartdatead'] = $this->general->NepToEngDateConv($contract_startdate);
				$postdata['coin_contractenddatebs'] = $contract_enddate;
				$postdata['coin_contractenddatead'] = $this->general->NepToEngDateConv($contract_enddate);	
			}else{
				$postdata['coin_contractstartdatead'] = $contract_startdate;
				$postdata['coin_contractstartdatebs'] = $this->general->EngToNepDateConv($contract_startdate);
				$postdata['coin_contractenddatead'] = $contract_enddate;
				$postdata['coin_contractenddatebs'] = $this->general->EngToNepDateConv($contract_enddate);
			}
		unset($postdata['id']);
		unset($postdata['coin_attach']);
		unset($postdata['coin_contractstartdate']);
		unset($postdata['coin_contractenddate']);
		unset($postdata['coin_equipid']);
			// echo "<pre>";
			// print_r($id);
			// die();
		
		if($id)
		{
			$this->db->trans_start();
			$postdata['coin_equipid']=$eqid;
			$postdata['coin_modifydatead']=CURDATE_EN;
			$postdata['coin_modifydatebs']=CURDATE_NP;
			$postdata['coin_modifytime']=$this->general->get_currenttime();
			$postdata['coin_modifyby']=$this->session->userdata(USER_ID);
			$postdata['coin_modifyip']= $this->postid;
			$postdata['coin_modifymac']= $this->postmac;
			
			
			if(!empty($postdata))
			{
				$this->general->save_log($this->table,'coin_contractinformationid',$id,$postdata,'Update');
				$this->db->update($this->table,$postdata,array('coin_contractinformationid'=>$id));
				// echo $this->db->last_query();
				// die();
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
		else //no id
		{
			$postdata =  array();
			$postdata = $this->input->post();
			
			$attachments = $this->input->post('coin_attach');
			$imageList = '';

			if(!empty($attachments)):
			foreach($attachments as $key=>$value):
				$_FILES['attachments']['name'] = $_FILES['coin_attachments']['name'][$key];
	            $_FILES['attachments']['type'] = $_FILES['coin_attachments']['type'][$key];
	            $_FILES['attachments']['tmp_name'] = $_FILES['coin_attachments']['tmp_name'][$key];
	            $_FILES['attachments']['error'] = $_FILES['coin_attachments']['error'][$key];
	            $_FILES['attachments']['size'] = $_FILES['coin_attachments']['size'][$key];

			if(!empty($_FILES)){
				$new_image_name = $_FILES['coin_attachments']['name'][$key];
                $imgfile=$this->doupload('attachments');
			}else{
				$imgfile = '';
			}

			$imageList .= $imgfile.', ';
			endforeach;
			endif;
			$imageName = rtrim($imageList,', ');
			// print_r($imageName);
			// die();

			$contract_startdate = $this->input->post('coin_contractstartdate');
			$contract_enddate = $this->input->post('coin_contractenddate');
			if(DEFAULT_DATEPICKER == 'NP'){
				$postdata['coin_contractstartdatebs'] = $contract_startdate;
				$postdata['coin_contractstartdatead'] = $this->general->NepToEngDateConv($contract_startdate);
				$postdata['coin_contractenddatebs'] = $contract_enddate;
				$postdata['coin_contractenddatead'] = $this->general->NepToEngDateConv($contract_enddate);	
			}else{
				$postdata['coin_contractstartdatead'] = $contract_startdate;
				$postdata['coin_contractstartdatebs'] = $this->general->EngToNepDateConv($contract_startdate);
				$postdata['coin_contractenddatead'] = $contract_enddate;
				$postdata['coin_contractenddatebs'] = $this->general->EngToNepDateConv($contract_enddate);
			}

			$postdata['coin_equipid']=$eqid;
			$postdata['coin_attachments'] = $imageName;

			$postdata['coin_postdatead'] = CURDATE_EN;
			$postdata['coin_postdatebs'] = CURDATE_NP;
			$postdata['coin_posttime'] = $this->general->get_currenttime();
			$postdata['coin_postby'] = $this->session->userdata(USER_ID);
			$postdata['coin_postip']= $this->postid;
			$postdata['coin_postmac']=$this->postmac;
			
			unset($postdata['id']);
			unset($postdata['coin_attach']);
			unset($postdata['coin_contractstartdate']);
			unset($postdata['coin_contractenddate']);
			

			// echo "<pre>";
			// print_r($postdata);
			// die();

			$this->db->trans_start();
			if(!empty($postdata))
			{
				$this->db->insert($this->table,$postdata);
				//echo $this->db->last_query(); die;
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
			return false;
	}

	public function check_exit_username_for_other($eqli_username,$input_id)
	{
		$data = array();
		$query = $this->db->get_where($this->table,array('eqli_username'=>$eqli_username,'eqli_userid'=>$input_id));
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
	}

	public function get_contractmgmt_list($srch=false)
	{
		$get = $_GET;
 
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
     	
     	if(!empty($get['sSearch_0'])){
            $this->db->where("coin_contractinformationid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("coin_contracttypeid like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("coin_distributorid like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("coin_contracttitle like  '%".$get['sSearch_3']."%'  ");
        }
        
        if(!empty($get['sSearch_4'])){
            $this->db->where("coin_contractstartdatead like  '%".$get['sSearch_4']."%'  ");
        }
        
        if(!empty($get['sSearch_5'])){
            $this->db->where("coin_contractstartdatebs like  '%".$get['sSearch_5']."%'  ");
        }
        
        if(!empty($get['sSearch_6'])){
            $this->db->where("coin_contractvalue like  '%".$get['sSearch_6']."%'  ");
        }
         $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
         $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

         if($frmDate && $toDate){
				if(DEFAULT_DATEPICKER=='NP'){
					$this->db->where('coin_contractstartdatebs >=',$frmDate);
					$this->db->where('coin_contractenddatebs <=',$toDate);	
				}
				else{
					$this->db->where('coin_contractstartdatead >=',$frmDate);
					$this->db->where('coin_contractenddatead <=',$toDate);
				}
			}
		if($srch){
			$this->db->where($srch);
		}
        // if(!empty(($frmDate && $toDate)))
        // {
        //     if(DEFAULT_DATEPICKER == 'NP'){
        //         $this->db->where('c.coin_postdatebs >=',$frmDate);
        //         $this->db->where('c.coin_postdatebs <=',$toDate);    
        //     }else{
        //         $this->db->where('c.coin_postdatead >=',$frmDate);
        //         $this->db->where('c.coin_postdatead <=',$toDate);
        //     }
        // }
         
      	$resltrpt=$this->db->select("COUNT(*) as cnt")
      					->from('coin_contractinformation c')
      					->join('coty_contracttype ct', 'ct.coty_contracttypeid = c.coin_contracttypeid','LEFT')
      					->join('dist_distributors d','d.dist_distributorid = c.coin_distributorid','LEFT')
      					->join('rety_renewtype rw','rw.rety_renewtypeid=c.coin_renewtypeid','LEFT')
      					->get()
      					->row();
      	//$resltrpt=$this->db->query("SELECT COUNT(*) as cnt FROM xw_pudo_purchdonate  ")->row();
	    //echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = 'coin_contractinformationid';
      	$order = 'desc';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'coin_contractinformationid';
      	else if($this->input->get('iSortCol_0')==1)
        	$order_by = 'coty_contracttype';
      	else if($this->input->get('iSortCol_0')==2)
       		$order_by = 'dist_distributor';
       	else if($this->input->get('iSortCol_0')==3)
       		$order_by = 'coin_contracttitle';
       	else if($this->input->get('iSortCol_0')==4)
       		$order_by = 'coin_contractstartdatead';
       	else if($this->input->get('iSortCol_0')==5)
       		$order_by = 'coin_contractenddatead';
       	else if($this->input->get('iSortCol_0')==6)
       		$order_by = 'coin_contractvalue';
      	
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
            $this->db->where("coin_contractinformationid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("coty_contracttype like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("coin_contracttitle like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("coin_contractstartdatead like  '%".$get['sSearch_4']."%'  ");
        }

        if(!empty($get['sSearch_5'])){
            $this->db->where("coin_contractenddatead like  '%".$get['sSearch_5']."%'  ");
        }

        if(!empty($get['sSearch_6'])){
            $this->db->where("coin_contractvalue like  '%".$get['sSearch_6']."%'  ");
        }
        if($frmDate && $toDate){
				if(DEFAULT_DATEPICKER=='NP'){
					$this->db->where('coin_contractstartdatebs >=',$frmDate);
					$this->db->where('coin_contractenddatebs <=',$toDate);	
				}
				else{
					$this->db->where('coin_contractstartdatead >=',$frmDate);
					$this->db->where('coin_contractenddatead <=',$toDate);
				}
			}
       
        // if(!empty(($frmDate && $toDate)))
        // {
        //     if(DEFAULT_DATEPICKER == 'NP'){
        //         $this->db->where('c.coin_postdatebs >=',$frmDate);
        //         $this->db->where('c.coin_postdatebs <=',$toDate);    
        //     }else{
        //         $this->db->where('c.coin_postdatead >=',$frmDate);
        //         $this->db->where('c.coin_postdatead <=',$toDate);
        //     }
        // }
       
        $this->db->select('c.*, ct.coty_contracttype, d.dist_distributor,rw.rety_renewtype');
		$this->db->from('coin_contractinformation c');
		$this->db->join('coty_contracttype ct', 'ct.coty_contracttypeid = c.coin_contracttypeid','LEFT');
      	$this->db->join('dist_distributors d','d.dist_distributorid = c.coin_distributorid','LEFT');
      	$this->db->join('rety_renewtype rw','rw.rety_renewtypeid=c.coin_renewtypeid','LEFT');
        $this->db->order_by($order_by,$order);
         if($srch){
			$this->db->where($srch);
		}
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

	public function get_all_contracttype(){
		try{
			$this->db->select('*');
			$this->db->from('coty_contracttype');
			$query = $this->db->get();

			if ($query->num_rows() > 0){
				$data=$query->result();	
				return $data;			
			}
			return false;
		}catch(Exception $e){
			throw $e;
		}
	}	

	public function get_all_renewtype(){
		try{
			$this->db->select('*');
			$this->db->from('rety_renewtype');
			$query = $this->db->get();

			if ($query->num_rows() > 0){
				$data=$query->result();	
				return $data;			
			}
			return false;
		}catch(Exception $e){
			throw $e;
		}
	}

	public function get_all_contractmgmt($srchcol = false){
		try{
			$this->db->select('c.*,bm.bmin_equipmentkey,eq.eqli_description');
			$this->db->from('coin_contractinformation c');
			$this->db->join('bmin_bmeinventory bm','bm.bmin_equipid=c.coin_equipid','LEFT');
			$this->db->join('eqli_equipmentlist eq','eq.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
			if(!empty($srchcol)){
				$this->db->where($srchcol);
			}
			$query = $this->db->get();

			if ($query->num_rows() > 0){
				$data=$query->result();	
				return $data;			
			}
			return false;
		}catch(Exception $e){
			throw $e;
		}
	}

	public function get_contractmgmt_data($srchcol =  false){
		try{
			$this->db->select('c.*, ct.coty_contracttype, d.dist_distributor, r.rety_renewtype');
			$this->db->from('coin_contractinformation c');
			$this->db->join('coty_contracttype ct', 'ct.coty_contracttypeid = c.coin_contracttypeid','LEFT');
      		$this->db->join('dist_distributors d','d.dist_distributorid = c.coin_distributorid','LEFT');
      		$this->db->join('rety_renewtype r','r.rety_renewtypeid = c.coin_renewtypeid','LEFT');

      		if($srchcol){
        		$this->db->where($srchcol);
      		}

      		$qry=$this->db->get();

      		if($qry->num_rows()>0){
      			return $qry->result();
   	 		}
    		return false;
        	
		}catch(Exception $e){
			throw $e;
		}
	}

	public function get_contractmgmt_report($org_id=false){
		try{
			$rpt_type=$this->input->post('rpttype');
			$distributorid = $this->input->post('coin_distributorid');
			$fromdate = $this->input->post('fromdate');
			$todate = $this->input->post('todate');

			$this->db->select('c.*, ct.coty_contracttype, d.dist_distributor, r.rety_renewtype');
			$this->db->from('coin_contractinformation c');
			$this->db->join('coty_contracttype ct', 'ct.coty_contracttypeid = c.coin_contracttypeid','LEFT');
      		$this->db->join('dist_distributors d','d.dist_distributorid = c.coin_distributorid','LEFT');
      		$this->db->join('rety_renewtype r','r.rety_renewtypeid = c.coin_renewtypeid','LEFT');

      		if($rpt_type == 'all'){
        		$this->db->where('coin_renewtypeid !=',NULL);
      		}else{
      			$this->db->where('coin_renewtypeid',$rpt_type);
      		}

      		if($distributorid == 'all'){
      			$this->db->where('coin_renewtypeid !=',NULL);
      		}
      		else{
        		$this->db->where('coin_distributorid',$distributorid);
      		}

      		if($org_id){
      			$this->db->where('coin_orgid',$org_id);
      		}

      		if($fromdate && $todate){
				if(DEFAULT_DATEPICKER=='NP'){
					$this->db->where('coin_contractstartdatebs >=',$fromdate);
					$this->db->where('coin_contractenddatebs <=',$todate);	
				}
				else{
					$this->db->where('coin_contractstartdatead >=',$fromdate);
					$this->db->where('coin_contractenddatead <=',$todate);
				}
			}

      		$qry=$this->db->get();

      		if($qry->num_rows()>0){
      			return $qry->result();
   	 		}
    		return false;
        	
		}catch(Exception $e){
			throw $e;
		}
	}

	public function remove_contractmgmt()
	{
		$id=$this->input->post('id');
		if($id)
		{
			$this->general->save_log($this->table,'coin_contractinformationid',$id,$postdata=array(),'Delete');
			$this->db->delete($this->table,array('coin_contractinformationid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}

	public function doupload($file) {
        // echo "test";
        // die();
        $config['upload_path'] = './'.CONTRACT_ATTACHMENT_PATH;//define in constants
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

    public function check_exist_title_for_other($contract_title = false, $id = false){
		$data = array();
		if($contract_title)
		{
				$this->db->where('coin_contracttitle',$contract_title);
		}
		if($id)
		{
			$this->db->where('coin_contractinformationid!=',$id);
		}

		$query = $this->db->get("coin_contractinformation");
		// echo $this->db->last_query();
		// die();

		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
	}
}