<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Approved_mdl extends CI_Model 

{

	public function __construct() 

	{

		parent::__construct();

		$this->table='appr_approved';
		$this->locationid=$this->session->userdata(LOCATION_ID);

	}



	public $validate_settings_approved = array( 

	  array('field' => 'appr_approvedname', 'label' => 'approved Name ', 'rules' => 'trim|required|xss_clean|callback_exists_approvedname'),

       );                

	


// public function save_approved()

// 	{

// 		$postdata=$this->input->post();

// 		$id=$this->input->post('id');

		



// 		$postid=$this->general->get_real_ipaddr();

// 		$postmac=$this->general->get_Mac_Address();

// 		unset($postdata['id']);

	

// 		if($id)

// 		{

// 			$this->db->trans_start();

// 			$postdata['appr_modifydatead']=CURDATE_EN;

// 			$postdata['appr_modifydatebs']=CURDATE_NP;

// 			$postdata['appr_modifytime']=$this->general->get_currenttime();

// 			$postdata['appr_modifyby']=$this->session->userdata(USER_ID);

// 			$postdata['appr_modifyip']=$postid;

// 			$postdata['appr_modifymac']=$postmac;

			

// 			if(!empty($postdata))

// 			{

// 				 $this->general->save_log($this->table,'appr_approvedid',$id,$postdata,'Update');

// 				$this->db->update($this->table,$postdata,array('appr_approvedid'=>$id));

				

// 			}



// 			$this->db->trans_complete();

// 			if ($this->db->trans_status() === FALSE)

// 				{

// 				        $this->db->trans_rollback();

// 				        return false;

// 				}

// 				else

// 				{

// 				        $this->db->trans_commit();

// 				        return true;

// 				}

// 		}

// 		else

// 		{

		

// 			$postdata['appr_postdatead']=CURDATE_EN;

// 			$postdata['appr_postdatebs']=CURDATE_NP;

// 			$postdata['appr_posttime']=$this->general->get_currenttime();

// 			$postdata['appr_postby']=$this->session->userdata(USER_ID);

// 			$postdata['appr_postip']=$postid;

// 			$postdata['appr_postmac']=$postmac;
// 			//$postdata['appr_locationid']=$this->locationid;

// 			// echo "<pre>";

// 			// print_r($postdata);

// 			// die();

// 			$this->db->trans_start();

// 			if(!empty($postdata))

// 			{

// 				$this->db->insert('appr_approved',$postdata);

// 			}

				

			

// 			$this->db->trans_complete();

// 			if ($this->db->trans_status() === FALSE)

// 				{

// 				        $this->db->trans_rollback();

// 				        return false;

// 				}

// 				else

// 				{

// 				        $this->db->trans_commit();

// 				        return true;

// 				}

// 			}

// 			return false;

// 	}

public function save_approved()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		unset($postdata['id']);
		if($id)
		{
		$postdata['appr_modifydatead']=CURDATE_EN;
		$postdata['appr_modifydatebs']=CURDATE_NP;
		$postdata['appr_modifytime']=date('H:i:s');
		$postdata['appr_modifyby']=$this->session->userdata(USER_ID);
		$postdata['appr_modifyip']=$this->general->get_real_ipaddr();
		$postdata['appr_modifymac']=$this->general->get_Mac_Address();
		$postdata['appr_locationid']=$this->locationid;
		if(!empty($postdata))
		{
			$this->db->update($this->table,$postdata,array('appr_approvedid'=>$id));
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
		$postdata['appr_postdatead']=CURDATE_EN;
		$postdata['appr_postdatebs']=CURDATE_NP;
		$postdata['appr_posttime']=date('H:i:s');
		$postdata['appr_postby']=$this->session->userdata(USER_ID);
		$postdata['appr_orgid']=$this->session->userdata(ORG_ID);
		$postdata['appr_postip']=$this->general->get_real_ipaddr();
		$postdata['appr_postmac']=$this->general->get_Mac_Address();
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

	public function remove_approved()

	{

		$id=$this->input->post('id');

		if($id)

		{

			 $this->general->save_log($this->table,'appr_approvedid',$id,$postdata=array(),'Delete');

			$this->db->delete($this->table,array('appr_approvedid'=>$id));

			$rowaffected=$this->db->affected_rows();

			if($rowaffected)

			{

				return $rowaffected;

			}

			return false;

		}

		return false;

	}



	public function get_all_approved_list($srchcol = false, $order_by = false, $order = false){
		try{
			$this->db->select('*');
			$this->db->from('appr_approved');
	        $this->db->order_by($order_by,$order);
	        $query = $this->db->get();

	        if ($query->num_rows() > 0) 
			{
				$data=$query->result();	
				return $data;			
			}
			return false;
		}catch(Exception $e){
			throw $e;
		}
	}

		

public function get_approved_list()

	{

		$get = $_GET;

 

      	foreach ($get as $key => $value) {

        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

      	}

     	

     	if(!empty($get['sSearch_0'])){

            $this->db->where("appr_approvedid like  '%".$get['sSearch_0']."%'  ");

        }



        if(!empty($get['sSearch_1'])){

            $this->db->where("appr_approvedname like  '%".$get['sSearch_1']."%'  ");

        }



         

      	$resltrpt=$this->db->select("COUNT(*) as cnt")

      					->from('appr_approved')

      					->get()

      					->row();

      	//$resltrpt=$this->db->query("SELECT COUNT(*) as cnt FROM xw_pudo_purchdonate  ")->row();

	    //echo $this->db->last_query();die(); 

      	$totalfilteredrecs=$resltrpt->cnt; 



      	$order_by = 'appr_approvedid';

      	$order = 'desc';

      	if($this->input->get('sSortDir_0'))

  		{

  				$order = $this->input->get('sSortDir_0');

  		}

  

      	$where='';

      	if($this->input->get('iSortCol_0')==0)

        	$order_by = 'appr_approvedid';

      	else if($this->input->get('iSortCol_0')==1)

        	$order_by = 'appr_approvedname';

      	

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

            $this->db->where("appr_approvedid like  '%".$get['sSearch_0']."%'  ");

        }



        if(!empty($get['sSearch_1'])){

            $this->db->where("appr_approvedname like  '%".$get['sSearch_1']."%'  ");

        }



        

       

        $this->db->select('*');

		$this->db->from('appr_approved');

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

	    //echo "<pre>";print_r($ndata);die;

	    return $ndata;

	}





public function check_exist_approved_for_other($budgetname = false, $id = false){

		$data = array();



		if($budgetname)

		{

			$query = $this->db->get_where($this->table,array('appr_approvedname'=>$budgetname,'appr_approvedid !='=>$id));

		}

		else

		{

			$query = $this->db->get_where($this->table,array('appr_approvedname'=>$budgetname));

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