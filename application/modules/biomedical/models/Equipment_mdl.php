<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Equipment_mdl extends CI_Model 

{

	public function __construct() 

	{

		parent::__construct();

		$this->table='eqli_equipmentlist';

		$this->locationid=$this->session->userdata(LOCATION_ID);

	}



	public $validate_settings_equipment = array( 

	   array('field' => 'eqli_equipmenttypeid', 'label' => 'Equipment Type', 'rules' => 'trim|required|xss_clean'),

	 array('field' => 'eqli_code', 'label' => 'Equipment Code', 'rules' => 'trim|required|xss_clean|min_length[2]|callback_exists_equipcode'),

        array('field' => 'eqli_description', 'label' => 'Equipment Description', 'rules' => 'trim|required|xss_clean|callback_exists_equipdesc'),

       );                

	

	public $validate_settings_equipment_cat = array( 

	   array('field' => 'eqca_equiptypeid', 'label' => 'Equipment Type', 'rules' => 'trim|required|xss_clean'),

	    array('field' => 'eqca_category', 'label' => 'Category', 'rules' => 'trim|required|xss_clean|callback_exists_eqcategory'),

	    array('field' => 'eqca_code', 'label' => 'Code', 'rules' => 'trim|required|xss_clean|min_length[2]|callback_exists_eqcategory_code'),



       );                

	

	

	public function save_equipment()

	{

		$postdata=$this->input->post();

		$id=$this->input->post('id');

		



		$postid=$this->general->get_real_ipaddr();

		$postmac=$this->general->get_Mac_Address();

		unset($postdata['id']);

	

		if($id)

		{

			$this->db->trans_start();

			$postdata['eqli_modifydatead']=CURDATE_EN;

			$postdata['eqli_modifydatebs']=CURDATE_NP;

			$postdata['eqli_modifytime']=$this->general->get_currenttime();

			$postdata['eqli_modifyby']=$this->session->userdata(USER_ID);

			$postdata['eqli_modifyip']=$postid;

			$postdata['eqli_modifymac']=$postmac;

			

			if(!empty($postdata))

			{

				 $this->general->save_log($this->table,'eqli_equipmentlistid',$id,$postdata,'Update');

				$this->db->update($this->table,$postdata,array('eqli_equipmentlistid'=>$id));

				

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

		

			$postdata['eqli_postdatead']=CURDATE_EN;

			$postdata['eqli_postdatebs']=CURDATE_NP;

			$postdata['eqli_posttime']=$this->general->get_currenttime();

			$postdata['eqli_postby']=$this->session->userdata(USER_ID);

			$postdata['eqli_orgid']=$this->session->userdata(ORG_ID);

			$postdata['eqli_postip']=$postid;

			$postdata['eqli_postmac']=$postmac;

			$postdata['eqli_locationid']=$this->locationid;

			// echo "<pre>";

			// print_r($postdata);

			// die();

			$this->db->trans_start();

			if(!empty($postdata))

			{

				$this->db->insert($this->table,$postdata);

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





	public function get_all_equipment($srchcol=false)

	{

		$this->db->select('eq.*');

		 $this->db->from('eqli_equipmentlist eq');

	    $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=eq.eqli_equipmenttypeid','LEFT');

		

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





	public function check_for_available_incharge($department_id=false)

	{

		$this->db->select("CONCAT(sf.stin_fname,' ',sf.stin_lname) AS PersonName,(sf. stin_email) as Email");

		$this->db->from('stin_staffinfo sf');

		$this->db->join('stpo_staffposition sp','sp.stpo_staffpositionid=sf.stin_positionid','LEFT');

		$this->db->where('stin_departmentid',$department_id);

		$this->db->where('stpo_staffposition','in-charge');

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





	public function get_all_equipment_detail($srchcol=false)

	{

		$this->db->select('bm.*,eq.*');

		 $this->db->from('bmin_bmeinventory bm');

	    $this->db->join('eqli_equipmentlist eq','eq.eqli_equipmentlistid=bm.bmin_equipid','LEFT');

		

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



	public function get_all_equipment_list($srchcol=false)

	{  

		$this->db->select('ds.*');

		$this->db->from('bmin_bmeinventory ds');

		

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



	





	public function remove_equipment()

	{

		$id=$this->input->post('id');

		if($id)

		{

			 $this->general->save_log($this->table,'eqli_equipmentlistid',$id,$postdata=array(),'Delete');

			$this->db->delete($this->table,array('eqli_equipmentlistid'=>$id));

			$rowaffected=$this->db->affected_rows();

			if($rowaffected)

			{

				return $rowaffected;

			}

			return false;

		}

		return false;

	}





	public function delete_equipmentcategory()

	{

		$id=$this->input->post('id');

		if($id)

		{

			 $this->general->save_log($this->table,'eqli_equipmentlistid',$id,$postdata=array(),'Delete');

			$this->db->delete('eqca_equipmentcategory',array('eqca_equipmentcategoryid'=>$id));

			$rowaffected=$this->db->affected_rows();

			if($rowaffected)

			{

				return $rowaffected;

			}

			return false;

		}

		return false;

	}







	public function check_exit_equipment_for_other($eqcode=false,$id=false)

		{

		$data = array();



		if($id)

		{

			$query = $this->db->get_where($this->table,array('eqli_code'=>$eqcode,'eqli_equipmentlistid !='=>$id));

		}

		else

		{

			$query = $this->db->get_where($this->table,array('eqli_code'=>$eqcode));

		}

		if ($query->num_rows() > 0) 

		{

			$data=$query->row();	

			return $data;			

		}

		return false;

		}





	public function check_exit_equipment_desc_for_other($eqli_description=false,$id=false)

		{

		$data = array();



		if($id)

		{

			$query = $this->db->get_where($this->table,array('eqli_description'=>$eqli_description,'eqli_equipmentlistid !='=>$id));

		}

		else

		{

			$query = $this->db->get_where($this->table,array('eqli_description'=>$eqli_description));

		}

		if ($query->num_rows() > 0) 

		{

			$data=$query->row();	

			return $data;			

		}

		return false;

		}



public function check_exit_category_for_other($eqcat=false,$id=false)

		{

		$data = array();



		if($id)

		{

			$query = $this->db->get_where('eqca_equipmentcategory',array('eqca_category'=>$eqcat,'eqca_equipmentcategoryid !='=>$id));

		}

		else

		{

			$query = $this->db->get_where('eqca_equipmentcategory',array('eqca_category'=>$eqcat));

		}

		if ($query->num_rows() > 0) 

		{

			$data=$query->row();	

			return $data;			

		}

		return false;

		}









public function check_exit_category_code_for_other($eqcat_code=false,$id=false)

		{

		$data = array();



		if($id)

		{

			$query = $this->db->get_where('eqca_equipmentcategory',array('eqca_code'=>$eqcat_code,'eqca_equipmentcategoryid !='=>$id));

		}

		else

		{

			$query = $this->db->get_where('eqca_equipmentcategory',array('eqca_code'=>$eqcat_code));

		}

		if ($query->num_rows() > 0) 

		{

			$data=$query->row();	

			return $data;			

		}

		return false;

		}



		

		

	public function get_dequipment_list($srch=false)

	{

		$get = $_GET;

      	foreach ($get as $key => $value) {

        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

      	}



       if(!empty($get['sSearch_0'])){

            $this->db->where("lower(eqli_equipmentlistid) like  '%".$get['sSearch_0']."%'  ");

        }



		if(!empty($get['sSearch_1'])){

            $this->db->where("lower(eqty_equipmenttype) like  '%".$get['sSearch_1']."%'  ");

        }

       	if(!empty($get['sSearch_2'])){

            $this->db->where("lower(eqli_code) like  '%".$get['sSearch_2']."%'  ");

        }



      

          if(!empty($get['sSearch_3'])){

            $this->db->where("lower(eqli_description) like  '%".$get['sSearch_3']."%'  ");

        }

          if(!empty($get['sSearch_4'])){

            $this->db->where("lower(eqli_comment) like  '%".$get['sSearch_4']."%'  ");

        }



        if(!empty($get['sSearch_5'])){

            if(DEFAULT_DATEPICKER=='NP') {

			 $this->db->where("lower(eqli_postdatebs) like  '%".$get['sSearch_5']."%'  ");

			}else{

				 $this->db->where("lower(eqli_postdatead) like  '%".$get['sSearch_5']."%'  ");

			}  

        }



      	$resltrpt=$this->db->select("COUNT(*) as cnt")

      					 ->from('eqli_equipmentlist eq')

	    				->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=eq.eqli_equipmenttypeid','LEFT')

      					->get()

      					->row();

	    //echo $this->db->last_query();die(); 

      	$totalfilteredrecs=!empty($resltrpt->cnt)?$resltrpt->cnt:''; 



      	$order_by = 'eqli_equipmentlistid';

      	$order = 'desc';

      	if($this->input->get('sSortDir_0'))

  		{

  				$order = $this->input->get('sSortDir_0');

  		}

  

      	$where='';

      	if($this->input->get('iSortCol_0')==0)

        	$order_by = 'eqli_equipmentlistid';

        if($this->input->get('iSortCol_0')==1)

        	$order_by = 'eqty_equipmenttype';

        

      	else if($this->input->get('iSortCol_0')==2)

        	$order_by = 'eqli_code';

      	else if($this->input->get('iSortCol_0')==3)

       		$order_by = 'eqli_description';

       		else if($this->input->get('iSortCol_0')==4)

      	 	$order_by = 'eqli_comment';

       	else if($this->input->get('iSortCol_0')==5)

      	 	$order_by = 'eqli_postdatebs';

      	

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

            $this->db->where("lower(eqli_equipmentlistid) like  '%".$get['sSearch_0']."%'  ");

        }



		if(!empty($get['sSearch_1'])){

            $this->db->where("lower(eqty_equipmenttype) like  '%".$get['sSearch_1']."%'  ");

        }

       	if(!empty($get['sSearch_2'])){

            $this->db->where("lower(eqli_code like)  '%".$get['sSearch_2']."%'  ");

        }



      

          if(!empty($get['sSearch_3'])){

            $this->db->where("lower(eqli_description) like  '%".$get['sSearch_3']."%'  ");

        }

          if(!empty($get['sSearch_4'])){

            $this->db->where("lower(eqli_comment) like  '%".$get['sSearch_4']."%'  ");

        }



        if(!empty($get['sSearch_5'])){

            if(DEFAULT_DATEPICKER=='NP') {

			 $this->db->where("lower(eqli_postdatebs) like  '%".$get['sSearch_5']."%'  ");

			}else{

				 $this->db->where("lower(eqli_postdatead) like  '%".$get['sSearch_5']."%'  ");

			}  

        }

       

        $this->db->select('*');

	    $this->db->from('eqli_equipmentlist eq');

	    $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=eq.eqli_equipmenttypeid','LEFT');

        $this->db->order_by($order_by,$order);

        if($limit && $limit>0)

        {  

            $this->db->limit($limit);

        }

        if($offset)

        {

            $this->db->offset($offset);

        }

        if($srch)

        {

        	$this->db->where($srch);

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







	public function get_all_equipment_cat($srchcol=false)

	{

		$this->db->select('*');

		 $this->db->from('eqca_equipmentcategory ec');

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





	public function get_all_brand($srchcol=false)

	{

		$this->db->select('*');

		 $this->db->from('bran_brand ');

		

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



	public function get_all_designation($srchcol=false)

	{

		$this->db->select('*');

		 $this->db->from('desi_designation');

		

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





	public function get_all_units($srchcol=false)

	{

		$this->db->select('*');

		 $this->db->from('unit_unit uu');

	    

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







public function save_equipment_cat()

	{

		$postdata=$this->input->post();



		$isitdep=$this->input->post('eqca_isitdep');

		$isnonexp=$this->input->post('eqca_isnonexp');

		unset($postdata['eqca_isitdep']);

		unset($postdata['eqca_isnonexp']);



		

		$postdata['eqca_isitdep']=!empty($isitdep)?$isitdep:'N';

		$postdata['eqca_isnonexp']=!empty($isnonexp)?$isnonexp:'N';

		

		$id=$this->input->post('id');

		



		$postid=$this->general->get_real_ipaddr();

		$postmac=$this->general->get_Mac_Address();

		unset($postdata['id']);

	

		if($id)

		{

			$this->db->trans_start();

			$postdata['eqca_modifydatead']=CURDATE_EN;

			$postdata['eqca_modifydatebs']=CURDATE_NP;

			$postdata['eqca_modifytime']=$this->general->get_currenttime();

			$postdata['eqca_modifyby']=$this->session->userdata(USER_ID);

			$postdata['eqca_modifyip']=$postid;

			$postdata['eqca_modifymac']=$postmac;



			// echo "<pre>";

			// print_r($postdata);

			// die();

			

			if(!empty($postdata)){

			 $this->general->save_log('eqca_equipmentcategory','eqca_equipmentcategoryid',$id,$postdata,'Update');

			$this->db->update('eqca_equipmentcategory',$postdata,array('eqca_equipmentcategoryid'=>$id));

			// echo $this->db->last_query();

			// die();

				

			}



			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE){

				        $this->db->trans_rollback();

				        return false;

				}

				else{

				        $this->db->trans_commit();

				        return true;

				}

		}

		else

		{

			$postdata['eqca_postdatead']=CURDATE_EN;

			$postdata['eqca_postdatebs']=CURDATE_NP;

			$postdata['eqca_posttime']=$this->general->get_currenttime();

			$postdata['eqca_postby']=$this->session->userdata(USER_ID);

			$postdata['eqca_orgid']=$this->session->userdata(ORG_ID);

			$postdata['eqca_postip']=$postid;

			$postdata['eqca_postmac']=$postmac;

			$postdata['eqca_locationid']= $this->locationid;

			

			// echo "<pre>";

			// print_r($postdata);

			// die();

			$this->db->trans_start();

			if(!empty($postdata))

			{

				$this->db->insert('eqca_equipmentcategory',$postdata);

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





	public function get_equipment_cat_list($srch=false)

	{

		$get = $_GET;

      	foreach ($get as $key => $value) {

        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

      	}



        if(!empty($get['sSearch_1'])){

            $this->db->where("lower(et.eqty_equipmenttype) like  '%".$get['sSearch_1']."%'  ");

        }



		if(!empty($get['sSearch_2'])){

            $this->db->where("lower(ec.eqca_code) like  '%".$get['sSearch_2']."%'  ");

        }

       	if(!empty($get['sSearch_3'])){

            $this->db->where("lower(ec.eqca_category) like  '%".$get['sSearch_3']."%'  ");

        }



      

          if(!empty($get['sSearch_4'])){

            $this->db->where("lower(pet.eqca_category) like  '%".$get['sSearch_4']."%'  ");

        }

        



        if(!empty($get['sSearch_5'])){

            if(DEFAULT_DATEPICKER=='NP') {

			 $this->db->where("lower(ec.eqca_postdatebs) like  '%".$get['sSearch_5']."%'  ");

			}else{

				 $this->db->where("lower(ec.eqca_postdatead) like  '%".$get['sSearch_5']."%'  ");

			}  

        }



      	$resltrpt=$this->db->select("COUNT(*) as cnt")

      			->from('eqca_equipmentcategory ec')

	    		->join('eqca_equipmentcategory pet','pet.eqca_equipmentcategoryid=ec.eqca_parentcategoryid','LEFT')

	    		->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=ec.eqca_equiptypeid','LEFT')

      		->get()

      		->row();

	    // echo $this->db->last_query();die(); 

      	$totalfilteredrecs=!empty($resltrpt->cnt)?$resltrpt->cnt:'0';

		  
      	$order_by = 'ec.eqca_category';

      	$order = 'asc';

      	if($this->input->get('sSortDir_0'))

  		{

  				$order = $this->input->get('sSortDir_0');

  		}

  

      	$where='';

      	if($this->input->get('iSortCol_0')==1)

        	$order_by = 'et.eqty_equipmenttype';

        if($this->input->get('iSortCol_0')==2)

        	$order_by = 'ec.eqca_code';

        

      	else if($this->input->get('iSortCol_0')==3)

        	$order_by = 'ec.eqca_category';

      	else if($this->input->get('iSortCol_0')==4)

       		$order_by = 'pet.eqca_category ';

       		else if($this->input->get('iSortCol_0')==5)

      	 	$order_by = 'ec.eqca_postdatead';

       

      	

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

            $this->db->where("lower(et.eqty_equipmenttype) like  '%".$get['sSearch_1']."%'  ");

        }



		if(!empty($get['sSearch_2'])){

            $this->db->where("lower(ec.eqca_code) like  '%".$get['sSearch_2']."%'  ");

        }

       	if(!empty($get['sSearch_3'])){

            $this->db->where("lower(ec.eqca_category) like  '%".$get['sSearch_3']."%'  ");

        }



      

          if(!empty($get['sSearch_4'])){

            $this->db->where("lower(pet.eqca_category) like  '%".$get['sSearch_4']."%'  ");

        }

        



        if(!empty($get['sSearch_5'])){

            if(DEFAULT_DATEPICKER=='NP') {

			 $this->db->where("lower(ec.eqca_postdatebs) like  '%".$get['sSearch_5']."%'  ");

			}else{

				 $this->db->where("lower(ec.eqca_postdatead) like  '%".$get['sSearch_5']."%'  ");

			}  

        }



       

        $this->db->select('ec.*,et.*,ec.eqca_isitdep as isitdep,pet.eqca_category as parent_cat');

	    $this->db->from('eqca_equipmentcategory ec');

	    $this->db->join('eqca_equipmentcategory pet','pet.eqca_equipmentcategoryid=ec.eqca_parentcategoryid','LEFT');

	    $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=ec.eqca_equiptypeid','LEFT');

	     



        $this->db->order_by($order_by,$order);

        if($limit && $limit > 0)

        {  

            $this->db->limit($limit);

        }

        if($offset)

        {

            $this->db->offset($offset);

        }

        if($srch)

        {

        	$this->db->where($srch);

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



	public function get_equipment_cat_list_ku($srch=false)

	{

		$get = $_GET;

      	foreach ($get as $key => $value) {

        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

      	}



        if(!empty($get['sSearch_1'])){

            $this->db->where("lower(et.eqty_equipmenttype) like  '%".$get['sSearch_1']."%'  ");

        }



		if(!empty($get['sSearch_2'])){

            $this->db->where("lower(ec.eqca_code) like  '%".$get['sSearch_2']."%'  ");

        }

       	if(!empty($get['sSearch_3'])){

            $this->db->where("lower(ec.eqca_category) like  '%".$get['sSearch_3']."%'  ");

        }



      

          if(!empty($get['sSearch_4'])){

            $this->db->where("lower(pet.eqca_category) like  '%".$get['sSearch_4']."%'  ");

        }

        



        if(!empty($get['sSearch_5'])){

            if(DEFAULT_DATEPICKER=='NP') {

			 $this->db->where("lower(ec.eqca_postdatebs) like  '%".$get['sSearch_5']."%'  ");

			}else{

				 $this->db->where("lower(ec.eqca_postdatead) like  '%".$get['sSearch_5']."%'  ");

			}  

        }



      	$resltrpt=$this->db->select("COUNT(*) as cnt")

      			->from('eqca_equipmentcategory ec')

	    		->join('eqca_equipmentcategory pet','pet.eqca_equipmentcategoryid=ec.eqca_parentcategoryid','LEFT')

	    		->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=ec.eqca_equiptypeid','LEFT')

	    		->join('maty_materialtype mt','mt.maty_materialtypeid=ec.eqca_mattypeid','LEFT')

      		->get()

      		->row();

	    // echo $this->db->last_query();die(); 

      	$totalfilteredrecs=!empty($resltrpt->cnt)?$resltrpt->cnt:'0'; 



      	$order_by = 'ec.eqca_category';

      	$order = 'asc';

      	if($this->input->get('sSortDir_0'))

  		{

  				$order = $this->input->get('sSortDir_0');

  		}

  

      	$where='';

      	if($this->input->get('iSortCol_0')==1)

        	$order_by = 'et.eqty_equipmenttype';

        if($this->input->get('iSortCol_0')==2)

        	$order_by = 'ec.eqca_code';

        

      	else if($this->input->get('iSortCol_0')==3)

        	$order_by = 'ec.eqca_category';

      	else if($this->input->get('iSortCol_0')==4)

       		$order_by = 'pet.eqca_category ';

       		else if($this->input->get('iSortCol_0')==5)

      	 	$order_by = 'ec.eqca_postdatead';

       

      	

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

            $this->db->where("lower(et.eqty_equipmenttype) like  '%".$get['sSearch_1']."%'  ");

        }



		if(!empty($get['sSearch_2'])){

            $this->db->where("lower(ec.eqca_code) like  '%".$get['sSearch_2']."%'  ");

        }

       	if(!empty($get['sSearch_3'])){

            $this->db->where("lower(ec.eqca_category) like  '%".$get['sSearch_3']."%'  ");

        }



      

          if(!empty($get['sSearch_4'])){

            $this->db->where("lower(pet.eqca_category) like  '%".$get['sSearch_4']."%'  ");

        }

        



        if(!empty($get['sSearch_5'])){

            if(DEFAULT_DATEPICKER=='NP') {

			 $this->db->where("lower(ec.eqca_postdatebs) like  '%".$get['sSearch_5']."%'  ");

			}else{

				 $this->db->where("lower(ec.eqca_postdatead) like  '%".$get['sSearch_5']."%'  ");

			}  

        }



       

        $this->db->select('ec.*,et.*,ec.eqca_isitdep as isitdep,pet.eqca_category as parent_cat,mt.maty_material');

	    $this->db->from('eqca_equipmentcategory ec');

	    $this->db->join('eqca_equipmentcategory pet','pet.eqca_equipmentcategoryid=ec.eqca_parentcategoryid','LEFT');

	    $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=ec.eqca_equiptypeid','LEFT');

	    $this->db->join('maty_materialtype mt','mt.maty_materialtypeid=ec.eqca_mattypeid','LEFT');

	     



        $this->db->order_by($order_by,$order);

        if($limit && $limit > 0)

        {  

            $this->db->limit($limit);

        }

        if($offset)

        {

            $this->db->offset($offset);

        }

        if($srch)

        {

        	$this->db->where($srch);

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







	

}