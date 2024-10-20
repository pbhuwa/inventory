<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Received_items_mdl extends CI_Model

{

	public function __construct()

	{

	parent::__construct();

		$this->sama_masterTable='sama_salemaster';

		$this->sade_detailTable='sade_saledetail'; 

		$this->tran_masterTable='trma_transactionmain';

		$this->tran_detailsTable='trde_transactiondetail';

		$this->rede_detailTable='rede_reqdetail'; 

		$this->rema_masterTable = 'rema_reqmaster';



		$this->curtime = $this->general->get_currenttime();

		$this->userid = $this->session->userdata(USER_ID);

		$this->username = $this->session->userdata(USER_NAME);

		$this->userdepid = $this->session->userdata(USER_DEPT); //storeid

		$this->storeid = $this->session->userdata(STORE_ID);

		$this->mac = $this->general->get_Mac_Address();

		$this->ip = $this->general->get_real_ipaddr();

		$this->locationid=$this->session->userdata(LOCATION_ID);

		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);

		$this->orgid=$this->session->userdata(ORG_ID);

		// echo $this->orgid;

		// die();

	}

	



public function getColorStatusCountreceived($srchcol = false){

    $con1='';

		 if($srchcol){

		    if($this->location_ismain=='Y'){

		       $con1= $srchcol;

		   }else{

		     

		     $con1.= $srchcol;

		     $con1.=" AND sama_locationid ='".$this->locationid."'";

		 }

		 }else{

		     $con1='';

		 }



$sql="SELECT * FROM

     xw_coco_colorcode cc

    LEFT JOIN (

     SELECT

         sm.sama_st,

         COUNT('*') AS issuestatuscount

     FROM

         xw_sama_salemaster sm
         INNER JOIN xw_rema_reqmaster rm on (rm.rema_reqno=sm.sama_requisitionno AND sm.sama_fyear =rm.rema_fyear ) 


			

     ".$con1."
     AND rm.rema_postby = $this->userid

     GROUP BY

         sm.sama_st

    ) X ON X.sama_st = cc.coco_statusval

    WHERE

     cc.coco_listname = 'received_summarylist'

    AND cc.coco_statusval <> ''

    AND cc.coco_isactive = 'Y'";

            

         $query = $this->db->query($sql);

         // echo $this->db->last_query();

         // die();

         return $query->result();  

    }



    public function get_received_book_list(){

    	$frmDate=$this->input->get('frmDate');

		$toDate=$this->input->get('toDate');





		$get = $_GET;

		foreach ($get as $key => $value) {

			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

		}

	   

		$cond ='';

		if(!empty($get['sSearch_1'])){

			$cond .= " AND sama_billdatebs like  '%".$get['sSearch_1']."%' ";

		}

		if(!empty($get['sSearch_2'])){

			$cond .= " AND sama_billdatead like  '%".$get['sSearch_2']."%' ";

		}

		 if(!empty($get['sSearch_3'])){

			$cond .= " AND sama_invoiceno like  '%".$get['sSearch_3']."%' ";

		}

		if(!empty($get['sSearch_4'])){

			$cond .= " AND sama_depname like  '%".$get['sSearch_4']."%' ";

		}

			if(!empty($get['sSearch_7'])){

		

			$cond .= " AND sama_username like  '%".$get['sSearch_7']."%' ";

		}

		

			if(!empty($get['sSearch_8'])){

		

			$cond .= " AND sama_receivedby like  '%".$get['sSearch_8']."%' ";

		}



		if(!empty($get['sSearch_9'])){



			$cond .= " AND sama_requisitionno like  '%".$get['sSearch_9']."%' ";

		}

		if(!empty($get['sSearch_10'])){

					

					$cond .= " AND sama_billtime like  '%".$get['sSearch_10']."%' ";

		 }

		  if(!empty($get['sSearch_11'])){

					

					$cond .= " AND sama_fyear like  '%".$get['sSearch_11']."%' ";

		 }





		// if($cond) {

		//   $this->db->where($cond);

		// }

	    $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

	  

	   

		if(!empty(($frmDate && $toDate)))

        {

            if(DEFAULT_DATEPICKER == 'NP'){  

                  $cond .=" AND sama_billdatebs >='".$frmDate."'";

                  $cond .=" AND sama_billdatebs <='".$toDate."'";

            }else{

                  $cond .=" AND sama_billdatead >='".$frmDate."'";

                  $cond .=" AND sama_billdatead <='".$toDate."'";

            }

        }



       

         if($this->location_ismain=='Y')

          {

            if(!empty($input_locationid))

            {

            	 $cond .=" AND sama_locationid ='".$input_locationid."'";

                

            }else{

            	 $cond .=" AND sama_locationid ='".$this->locationid."'";

            }

          } 

          else{

          	 $cond .=" AND sama_locationid ='".$this->locationid."'";

         }

      

		// $resltrpt=$this->db->select("COUNT(*) as cnt")

		// 			->from('sama_salemaster rn')

		// 			->get()

		// 			->row();

         $resltrpt=$this->db->query("SELECT COUNT('*') as cnt FROM (SELECT sama_salemasterid, totcnt,totalamt , sama_depid,sama_billdatead,sama_locationid, sama_billdatebs, sama_duedatead, sama_duedatebs, sama_soldby, sama_discount, sama_taxrate, sama_vat, sama_totalamount, sama_username, sama_lastchangedate, sama_orderno, sama_challanno, sama_billno, sama_payment, sama_status, sama_fyear, sama_st, sama_stdatebs, sama_stdatead, sama_stdepid, sama_stusername, sama_stshiftid, dept_depname, sama_depname, sama_invoiceno, sama_billtime, sama_receivedby, sama_manualbillno, sama_receivedstatus,sama_requisitionno,sama_postdatebs,sama_postdatead,sama_posttime

		 	FROM xw_sama_salemaster sm INNER JOIN

			xw_rema_reqmaster rm on (rm.rema_reqno=sm.sama_requisitionno AND sm.sama_fyear =rm.rema_fyear ) 

			LEFT JOIN xw_vw_issue_summary vis on vis.sade_salemasterid=sm.sama_salemasterid

			LEFT JOIN xw_dept_department dp on dp.dept_depid=sm.sama_depid 

			WHERE rm.rema_postby = $this->userid $cond ) X 

			")->row();



         // echo "<pre>";

         // print_r($resltrpt);

         // die();



		// echo $this->db->last_query();die(); 

		$totalfilteredrecs=($resltrpt->cnt); 

		$order_by = 'sama_salemasterid';

		$order = 'desc';

		if($this->input->get('sSortDir_0'))

		{

				$order = $this->input->get('sSortDir_0');

		}

  

		$where='';

		if($this->input->get('iSortCol_0')==1)

			$order_by = 'sama_billdatebs';

		else  if($this->input->get('iSortCol_0')==2)

			$order_by = 'sama_billdatead';

	    else  if($this->input->get('iSortCol_0')==3)

			$order_by = 'sama_invoiceno';

		

		else if($this->input->get('iSortCol_0')==4)

			$order_by = 'sama_depname';

		else if($this->input->get('iSortCol_0')==5)

			$order_by = 'totalamt';

		else if($this->input->get('iSortCol_0')==6)

			$order_by = 'totcnt';

			else if($this->input->get('iSortCol_0')==7)

			$order_by = 'sama_username';

		else if($this->input->get('iSortCol_0')==8)

			$order_by = 'sama_receivedby';

		 else if($this->input->get('iSortCol_0')==9)

			$order_by = 'sama_requisitionno';

		 else if($this->input->get('iSortCol_0')==10)

			$order_by = 'sama_billtime';

		 else if($this->input->get('iSortCol_0')==11)

			$order_by = 'sama_fyear';

		$totalrecs='';

		$limit = 15;

		$offset = 1;

		$get = $_GET;

 

		foreach ($get as $key => $value) {

			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

		}

		// echo $this->db->last_query();

	 //  die;

	  

		if(!empty($_GET["iDisplayLength"])){

		   $limit = $_GET['iDisplayLength'];

		   $offset = $_GET["iDisplayStart"];

		}



		

		

		if(!empty($get['sSearch_1'])){



			$cond .= " AND sama_billdatebs like  '%".$get['sSearch_1']."%' ";

		}

		if(!empty($get['sSearch_2'])){



			$cond .= " AND sama_billdatead like  '%".$get['sSearch_2']."%' ";

		}

		 if(!empty($get['sSearch_3'])){

			$cond .= " AND sama_invoiceno like  '%".$get['sSearch_3']."%' ";

		}

		if(!empty($get['sSearch_4'])){

		

			$cond .= " AND sama_depname like  '%".$get['sSearch_4']."%' ";

		}

		if(!empty($get['sSearch_7'])){

		

			$cond .= " AND sama_username like  '%".$get['sSearch_7']."%' ";

		}

		

		if(!empty($get['sSearch_8'])){

		

			$cond .= " AND sama_receivedby like  '%".$get['sSearch_8']."%' ";

		}



		if(!empty($get['sSearch_9'])){



			$cond .= " AND sama_requisitionno like  '%".$get['sSearch_9']."%' ";

		}

		 

		if(!empty($get['sSearch_10'])){

					

					$cond .= " AND sama_billtime like  '%".$get['sSearch_10']."%' ";

		 }

		  if(!empty($get['sSearch_11'])){

					

					$cond .= " AND sama_fyear like  '%".$get['sSearch_11']."%' ";

		 }

        

		$result=$this->db->query("SELECT sama_salemasterid,totcnt, totalamt, sama_depid, sama_billdatead, sama_locationid, sama_billdatebs, sama_duedatead, sama_duedatebs, sama_soldby, sama_discount, sama_taxrate, sama_vat, sama_totalamount, sama_username, sama_lastchangedate, sama_orderno, sama_challanno, sama_billno, sama_payment, sama_status, sama_fyear, sama_st, sama_stdatebs, sama_stdatead, sama_stdepid, sama_stusername, sama_stshiftid, dept_depname, sama_depname, sama_invoiceno, sama_billtime, sama_receivedby, sama_manualbillno, sama_receivedstatus,sama_requisitionno,sama_postdatebs,sama_postdatead,sama_posttime

		 	FROM xw_sama_salemaster sm

		 	INNER JOIN xw_rema_reqmaster rm on (rm.rema_reqno=sm.sama_requisitionno AND sm.sama_fyear =rm.rema_fyear ) 

			LEFT JOIN xw_vw_issue_summary vis on vis.sade_salemasterid=sm.sama_salemasterid

			LEFT JOIN xw_dept_department dp on dp.dept_depid=sm.sama_depid 

			WHERE rm.rema_postby = $this->userid  $cond  limit $limit offset $offset ");

		   $nquery=$result->result();

		   // echo $this->db->last_query();
		   // die();

		 	if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {

		        $totalrecs = sizeof($nquery);

		    }





	   if(is_array($nquery) && sizeof($nquery)>0){

		  $ndata=$nquery;

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