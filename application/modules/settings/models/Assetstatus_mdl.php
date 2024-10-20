<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Assetstatus_mdl extends CI_Model 

{

	public function __construct() 

	{

		parent::__construct();

		$this->table='asst_assetstatus';
		$this->locationid=$this->session->userdata(LOCATION_ID);

	}



	public $validate_settings_valve = array( 

	  array('field' => 'asst_statusname', 'label' => 'Asset Status', 'rules' => 'trim|required|xss_clean|callback_exists_statustype'),

       );                

	



	

	public function save_equipment()

	{

		$postdata=$this->input->post();

		$id=$this->input->post('asst_asstid');

		// $postid=$this->general->get_real_ipaddr();

		// $postmac=$this->general->get_Mac_Address();

		unset($postdata['id']);
		if($id)
		{
			$this->db->trans_start();

			// $postdata['eqli_modifydatead']=CURDATE_EN;

			// $postdata['eqli_modifydatebs']=CURDATE_NP;

			// $postdata['eqli_modifytime']=$this->general->get_currenttime();

			// $postdata['eqli_modifyby']=$this->session->userdata(USER_ID);

			// $postdata['eqli_modifyip']=$postid;

			// $postdata['eqli_modifymac']=$postmac;

			if(!empty($postdata))
			{
		        $this->general->save_log($this->table,'asst_assetstatus',$id,$postdata,'Update');
		        $this->db->update($this->table,$postdata,array('asst_asstid'=>$id));
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

			// $postdata['eqli_postdatead']=CURDATE_EN;

			// $postdata['eqli_postdatebs']=CURDATE_NP;

			// $postdata['eqli_posttime']=$this->general->get_currenttime();

			// $postdata['eqli_postby']=$this->session->userdata(USER_ID);

			// $postdata['eqli_orgid']=$this->session->userdata(ORG_ID);

			// $postdata['eqli_postip']=$postid;

			// $postdata['eqli_postmac']=$postmac;

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

	public function get_all_status($srchcol=false)

	{

		$this->db->select('as.*');

		 $this->db->from('asst_assetstatus as');

		

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



	// public function get_all_status_list($srchcol=false)

	// {  

	// 	$this->db->select('as.*');

	// 	$this->db->from('asst_assetstatus as');

		

	// 	if($srchcol)

	// 	{

	// 		$this->db->where($srchcol);

	// 	}

	// 	$query = $this->db->get();

	// 	// echo $this->db->last_query();

	// 	// die();

	// 	if ($query->num_rows() > 0) 

	// 	{

	// 		$data=$query->result();		

	// 		return $data;		

	// 	}		

	// 	return false;

		

	// }



	

		public function save_status()

	{

		$postdata=$this->input->post();

		$id=$this->input->post('asst_asstid');


		$postid=$this->general->get_real_ipaddr();

		$postmac=$this->general->get_Mac_Address();

		unset($postdata['id']);

	

		if($id)

		{

			$this->db->trans_start();

			// $postdata['maty_modifydatead']=CURDATE_EN;

			// $postdata['maty_modifydatebs']=CURDATE_NP;

			// $postdata['maty_modifytime']=$this->general->get_currenttime();

			// $postdata['maty_modifyby']=$this->session->userdata(USER_ID);

			// $postdata['maty_modifyip']=$postid;

			// $postdata['maty_modifymac']=$postmac;

			

			if(!empty($postdata))

			{

				 $this->general->save_log($this->table,'asst_asstid',$id,$postdata,'Update');

				$this->db->update($this->table,$postdata,array('asst_asstid'=>$id));

				

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

		

			// $postdata['maty_postdatead']=CURDATE_EN;

			// $postdata['maty_postdatebs']=CURDATE_NP;

			// $postdata['maty_posttime']=$this->general->get_currenttime();

			// $postdata['maty_postby']=$this->session->userdata(USER_ID);

			// $postdata['maty_postip']=$postid;

			// $postdata['maty_postmac']=$postmac;
			// $postdata['maty_locationid']=$this->locationid;

			// echo "<pre>";

			// print_r($postdata);

			// die();

			$this->db->trans_start();

			if(!empty($postdata))

			{

				$this->db->insert('asst_assetstatus',$postdata);

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









	public function remove_valve()

	{

		$id=$this->input->post('id');

		if($id)

		{

			 $this->general->save_log($this->table,'asst_asstid',$id,$postdata=array(),'Delete');

			$this->db->delete($this->table,array('asst_asstid'=>$id));

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



		

public function get_dmaster_list($src=false)

	{

		$get = $_GET;
 

      	foreach ($get as $key => $value) {

        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

      	}

     	

     	if(!empty($get['sSearch_0'])){

            $this->db->where("asst_asstid like  '%".$get['sSearch_0']."%'  ");

        }



        if(!empty($get['sSearch_1'])){

            $this->db->where("asst_statusname like  '%".$get['sSearch_1']."%'  ");

        }
        if(!empty($get['sSearch_2'])){

            $this->db->where("asst_isactive like  '%".$get['sSearch_2']."%'  ");

        }



         

      	$resltrpt=$this->db->select("COUNT(*) as cnt")

      					->from('asst_assetstatus')

      					->get()

      					->row();

      	//$resltrpt=$this->db->query("SELECT COUNT(*) as cnt FROM xw_pudo_purchdonate  ")->row();

	    //echo $this->db->last_query();die(); 

      	$totalfilteredrecs=$resltrpt->cnt; 



      	$order_by = 'asst_asstid';

      	$order = 'desc';

      	if($this->input->get('sSortDir_0'))

  		{

  				$order = $this->input->get('sSortDir_0');

  		}

  

      	$where='';

      	if($this->input->get('iSortCol_0')==0)

        	$order_by = 'asst_asstid';

      	else if($this->input->get('iSortCol_0')==1)

        	$order_by = 'asst_statusname';
        else if($this->input->get('iSortCol_0')==1)

        	$order_by = 'asst_isactive';
      	

      	$totalrecs='';

      	$limit = 15;

      	$offset = 0;

      	$get = $_GET;

 

	    foreach ($get as $key => $value) {

	        $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

	    }

      

        if(!empty($_GET["iDisplayLength"])){

           $limit = $_GET['iDisplayLength'];

           $offset = $_GET["iDisplayStart"];

        }



        if(!empty($get['sSearch_0'])){

            $this->db->where("asst_asstid like  '%".$get['sSearch_0']."%'  ");

        }



        if(!empty($get['sSearch_1'])){

            $this->db->where("vaty_typw like  '%".$get['sSearch_1']."%'  ");

        }
        if(!empty($get['sSearch_2'])){

            $this->db->where("asst_isactive like  '%".$get['sSearch_2']."%'  ");

        }



        

       

        $this->db->select('*');

		$this->db->from('asst_assetstatus');

        $this->db->order_by($order_by,$order);

        if($limit && $limit>0)

        {  

            $this->db->limit($limit);

        }

        if($offset)

        {

            $this->db->offset($offset);

        }
        if($src){

        	$this->db->where($src);
        }

      

       $nquery=$this->db->get();

       $num_row=$nquery->num_rows();

        if(!empty($_GET['iDisplayLength']) && is_array($nquery)) {

          $totalrecs = sizeof( $nquery);

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

	    //echo "<pre>";print_r($ndata);die;

	    return $ndata;

	}



public function save_equipment_cat()

	{

		$postdata=$this->input->post();

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

			

			if(!empty($postdata))

			{

				 $this->general->save_log('eqca_equipmentcategory','eqca_equipmentcategoryid',$id,$postdata,'Update');

				$this->db->update('eqca_equipmentcategory',$postdata,array('eqca_equipmentcategoryid'=>$id));

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

			$postdata['eqca_postdatead']=CURDATE_EN;

			$postdata['eqca_postdatebs']=CURDATE_NP;

			$postdata['eqca_posttime']=$this->general->get_currenttime();

			$postdata['eqca_postby']=$this->session->userdata(USER_ID);

			$postdata['eqca_orgid']=$this->session->userdata(ORG_ID);

			$postdata['eqca_postip']=$postid;

			$postdata['eqca_postmac']=$postmac;

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

            $this->db->where("et.eqty_equipmenttype like  '%".$get['sSearch_1']."%'  ");

        }

		if(!empty($get['sSearch_2'])){

            $this->db->where("ec.eqca_code like  '%".$get['sSearch_2']."%'  ");

        }

       	if(!empty($get['sSearch_3'])){

            $this->db->where("ec.eqca_category like  '%".$get['sSearch_3']."%'  ");

        }

          if(!empty($get['sSearch_4'])){

            $this->db->where("pet.eqca_category like  '%".$get['sSearch_4']."%'  ");

        }

        if(!empty($get['sSearch_5'])){

            if(DEFAULT_DATEPICKER=='NP') {

			 $this->db->where("ec.eqca_postdatebs like  '%".$get['sSearch_5']."%'  ");

			}else{

				 $this->db->where("ec.eqca_postdatead like  '%".$get['sSearch_5']."%'  ");

			}  

        }

      	$resltrpt=$this->db->select("COUNT(*) as cnt")

      					 ->from('eqca_equipmentcategory ec')

	    				->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=ec.eqca_equiptypeid','LEFT')

	    				  ->join('eqca_equipmentcategory pet','ec.eqca_equipmentcategoryid=pet.eqca_parentcategoryid','LEFT')

      					->get()

      					->row();

	    //echo $this->db->last_query();die(); 

      	$totalfilteredrecs=$resltrpt->cnt; 



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

            $this->db->where("et.eqty_equipmenttype like  '%".$get['sSearch_1']."%'  ");

        }



		if(!empty($get['sSearch_2'])){

            $this->db->where("ec.eqca_code like  '%".$get['sSearch_2']."%'  ");

        }

       	if(!empty($get['sSearch_3'])){

            $this->db->where("ec.eqca_category like  '%".$get['sSearch_3']."%'  ");

        }



      

          if(!empty($get['sSearch_4'])){

            $this->db->where("pet.eqca_category like  '%".$get['sSearch_4']."%'  ");

        }

        



        if(!empty($get['sSearch_5'])){

            if(DEFAULT_DATEPICKER=='NP') {

			 $this->db->where("ec.eqca_postdatebs like  '%".$get['sSearch_5']."%'  ");

			}else{

				 $this->db->where("ec.eqca_postdatead like  '%".$get['sSearch_5']."%'  ");

			}  

        }


        $this->db->select('ec.*,et.*,pet.eqca_category as parent_cat');

	    $this->db->from('eqca_equipmentcategory ec');

	    $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=ec.eqca_equiptypeid','LEFT');

	     $this->db->join('eqca_equipmentcategory pet','ec.eqca_equipmentcategoryid=pet.eqca_parentcategoryid','LEFT');



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

        if(!empty($_GET['iDisplayLength'])) {

          $totalrecs = sizeof( $nquery);

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

	public function check_exist_status_for_other($statustype = false, $id = false){

		$data = array();



		if($statustype)

		{

			$query = $this->db->get_where($this->table,array('asst_statusname'=>$statustype,'asst_asstid !='=>$id));

		}

		else

		{

			$query = $this->db->get_where($this->table,array('asst_statusname'=>''));

		}

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