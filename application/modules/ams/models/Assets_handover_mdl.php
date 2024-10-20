<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Assets_handover_mdl extends CI_Model 
{
	public function __construct() 
	{

		   // parent::__construct();
		   //  $this->userid = $this->session->userdata(USER_ID);
     //    $this->username = $this->session->userdata(USER_NAME);
     //    $this->curtime = $this->general->get_currenttime();
     //    $this->mac = $this->general->get_Mac_Address();
     //    $this->ip = $this->general->get_real_ipaddr();
     //    $this->locationid=$this->session->userdata(LOCATION_ID);
     //    $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
     //    $this->orgid=$this->session->userdata(ORG_ID);
	}    

	public function save_handover_record(){
	  $ashm_fyear=$this->input->post('ashm_fyear');
    $fromstaffid=$this->input->post('handoverfromstaffid');
    $assetsid=$this->input->post('asen_asenid');
    $refno=$this->input->post('ashm_refno');
    $handoverdate=$this->input->post('ashm_handoverdate');
    $tostaffid=$this->input->post('handoverstaffid');
    $remarks=$this->input->post('remarks');
    $refno=$this->get_handover_refno();
    try {
    	$this->db->trans_start();
      if(DEFAULT_DATEPICKER=='NP'){   
        $handover_dateNp = $handoverdate;
        $handover_dateEn = $this->general->NepToEngDateConv($handoverdate);
        }
      else{
        $handover_dateEn = $handoverdate;
        $handover_dateNp = $this->general->EngtoNepDateConv($handoverdate);
      }
      $staff_name_fromstaffid=$this->general->get_tbl_data('stin_fname,stin_lname,stin_mname', 'stin_staffinfo',array('stin_staffinfoid'=>$fromstaffid));

      // echo "<pre>";
      // print_r($staff_name_fromstaffid);
      // die();
      $ashm_fromstaffname='';
      $ashm_tostaffname='';

      if(!empty($staff_name_fromstaffid)){
        $ashm_fromstaffname=$staff_name_fromstaffid[0]->stin_fname.' '.$staff_name_fromstaffid[0]->stin_mname.' '.$staff_name_fromstaffid[0]->stin_lname;
      }

      $staff_name_tostaffid=$this->general->get_tbl_data('stin_fname,stin_lname,stin_mname', 'stin_staffinfo',array('stin_staffinfoid'=>$tostaffid));
      if(!empty($staff_name_tostaffid)){
        $ashm_tostaffname=$staff_name_tostaffid[0]->stin_fname.' '.$staff_name_tostaffid[0]->stin_mname.' '.$staff_name_tostaffid[0]->stin_lname;
      }
      
      $assets_cnt=0;
      if(!empty($assetsid) && is_array($assetsid)){
        $assets_cnt=sizeof($assetsid);
      } 

      $masterarray=array(
        'ashm_fyear' =>$ashm_fyear,
        'ashm_refno' =>$refno,
        'ashm_handoverdatead' =>$handover_dateEn,
        'ashm_handoverdatebs'=>$handover_dateNp,
        'ashm_fromstaffid'=>$fromstaffid,
        'ashm_fromstaffname'=>$ashm_fromstaffname,
        'ashm_tostaffname'=>$ashm_tostaffname,
        'ashm_tostaffid'=>$tostaffid,
        'ashm_assetcount'=> $assets_cnt,
        'ashm_status'=>'O',
        'ashm_remarks'=>$remarks,
        'ashm_postdatead'=>CURDATE_EN,
        'ashm_postdatebs'=>CURDATE_NP,
        'ashm_posttime'=>$this->curtime,
        'ashm_postby'=>$this->userid,
        'ashm_postip'=>$this->ip,
        'ashm_postmac'=>$this->mac,
        'ashm_locationid'=>$this->locationid,
        'ashm_orgid'=>$this->orgid

      );

      $assestArr=array();
      $assetsid_arr=array();
      $lastinsertid=0;
      if(!empty($masterarray)){
        $this->db->insert('ashm_assethandovermaster',$masterarray);
        $insertid=$this->db->insert_id();
        $lastinsertid=$insertid;
          if(!empty($assetsid)){
            foreach ($assetsid as $ka => $ass) {
              $assetsid_arr[]=!empty($assetsid[$ka])?$assetsid[$ka]:'0';
              $assestArr[]=
              array(
              'ashd_assethandovermasterid' =>$insertid,
              'ashd_assetsid'         =>!empty($assetsid[$ka])?$assetsid[$ka]:'0',
              'ashd_handoverdatead'   =>$handover_dateEn,
              'ashd_handoverdatebs'   =>$handover_dateNp,
              'ashd_status'           =>'O',
              'ashd_postdatead'       =>CURDATE_EN,
              'ashd_postdatebs'       =>CURDATE_NP,
              'ashd_posttime'         =>$this->curtime,
              'ashd_postby'           =>$this->userid,
              'ashd_postip'           =>$this->ip,
              'ashd_postmac'          =>$this->mac,
              'ashd_locationid'       =>$this->locationid,
              'ashd_orgid'            =>$this->orgid

              );
            }
          }
          if(!empty($assestArr)){
            if( $this->db->insert_batch('ashd_assethandoverdetail',$assestArr)){
              $update_record_arr=array();
              $assets_record_result=$this->db->select('ashd_assetsid')
                              ->from('ashd_assethandoverdetail')
                              ->where('ashd_assethandovermasterid',$insertid)
                              ->get()
                              ->result();
              if(!empty($assets_record_result)){
                foreach ($assets_record_result as $karr => $drdata) {
                  $update_record_arr[]=array(
                      'asen_asenid'=>$drdata->ashd_assetsid,
                      'asen_staffid'=>$tostaffid
                  );
                }

                if(!empty($update_record_arr)){
                  $this->db->where('asen_staffid',$fromstaffid);
                  $this->db->update_batch('asen_assetentry',$update_record_arr, 'asen_asenid'); 
                }
              }

              // $update_arr=array('asen_staffid'=>$tostaffid);
              // $this->db->where_in('asen_asenid',$assetsid_arr);
              // $this->db->where('asen_staffid',$fromstaffid);
              // $this->db->update('asen_assetentry',$update_arr);

            }
         

           

          }
      }
      	
		  if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
             $this->db->trans_commit();
            return $lastinsertid;
        }
			return false;
    }
      catch (Exception $e) {
		$this->db->trans_rollback();
  		print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
	}
}


public function get_handover_master_data($srchcol=false)
{

        try{

            $this->db->select('shm.ashm_id,shm.ashm_fyear,shm.ashm_refno,shm.ashm_handoverdatead,shm.ashm_handoverdatebs,shm.ashm_fromstaffid,shm.ashm_tostaffid,ashm_fromstaffname,ashm_tostaffname,ashm_assetcount,ashm_remarks');
            $this->db->from('ashm_assethandovermaster shm');

            if(!empty($srchcol)){
              $this->db->where($srchcol);  
            }
            
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }

            return false;

        }catch(Exception $e){

            throw $e;

        }
}

public function get_handover_detail_data($srchcol=false)
{

        try{

          $this->db->select('shd.ashd_assetsid,ae.asen_assetcode,ae.asen_desc,ae.asen_purchaserate,ae.asen_purchasedatebs, il.itli_itemname,dt.dist_distributor,ec.eqca_category,sc.loca_name as schoolname,as.asst_statusname,ac.asco_conditionname,dp.dept_depname,dtfp.dept_depname depparent');
          $this->db->from('ashd_assethandoverdetail shd');
          $this->db->join('asen_assetentry ae','ae.asen_asenid=shd.ashd_assetsid');
             $this->db->join('asst_assetstatus as','as.asst_asstid=ae.asen_status','LEFT');
          $this->db->join('asco_condition ac','ac.asco_ascoid=ae.asen_condition','LEFT');
          $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=ae.asen_assettype','LEFT');
          $this->db->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT');
          $this->db->join('dist_distributors dt','dt.dist_distributorid=ae.asen_distributor','LEFT');
          $this->db->join('dept_department dp','dp.dept_depid=ae.asen_depid','LEFT');
          $this->db->join('dept_department dtfp','dtfp.dept_depid=dp.dept_parentdepid','LEFT');
          $this->db->join('loca_location sc','sc.loca_locationid=ae.asen_schoolid','LEFT');

          if(!empty($srchcol)){
            $this->db->where($srchcol);  
          }
            
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }

            return false;

        }catch(Exception $e){

            throw $e;

        }
}

public function get_handover_refno(){
    $this->db->select('MAX(ashm_refno) as ashm_refno');
    $this->db->from('ashm_assethandovermaster');
    $this->db->where('ashm_locationid',$this->locationid);
    $result=$this->db->get()->row();
    if(!empty($result)){
      return $result->ashm_refno+1;
    }
    return 1;
}

   public function get_assets_hanover_record($cond = false)
    {

        $get = $_GET;
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');
        $handoverfrom_staffid=$this->input->get('handoverfrom_staffid');
        $handoverto_staffid=$this->input->get('handoverto_staffid');
        $filtertype=$this->input->get('filtertype');
        $refno=$this->input->get('refno');
      
        $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

        }



        if( $filtertype=='range'){
             if(!empty(($frmDate && $toDate))){
            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('ahm.ashm_handoverdatebs >=',$frmDate);

                $this->db->where('ahm.ashm_handoverdatebs <=',$toDate);    

            }else{

                $this->db->where('ahm.ashm_handoverdatead >=',$frmDate);

                $this->db->where('ahm.ashm_handoverdatead <=',$toDate);

            }

         }
        }

        if(!empty($handoverfrom_staffid)){
          $this->db->where('ahm.ashm_fromstaffid',$handoverfrom_staffid);
        }
        if(!empty($handoverto_staffid)){
          $this->db->where('ahm.ashm_tostaffid',$handoverto_staffid);
        }

         if(!empty($refno)){
          $this->db->where('ahm.ashm_refno',$refno);
        }
       

      
    

        if(!empty($get['sSearch_1'])){
            $this->db->where("ashm_fyear like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("ashm_refno like  '%".$get['sSearch_2']."%'  ");

        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("ashm_handoverdatead like  '%".$get['sSearch_3']."%'  ");

        }


        if(!empty($get['sSearch_4'])){
            $this->db->where("ashm_handoverdatebs like  '%".$get['sSearch_4']."%'  ");

        }


        if(!empty($get['sSearch_5'])){
            $this->db->where("ashm_fromstaffname like  '%".$get['sSearch_5']."%'  ");

        }

       
        if(!empty($get['sSearch_6'])){
            $this->db->where("ashm_tostaffname like  '%".$get['sSearch_6']."%'  ");

        }

      

          if($cond) {

          $this->db->where($cond);

        }

       //  



        $resltrpt=$this->db->select("COUNT('*') as cnt")

                    ->from('ashm_assethandovermaster ahm')
                    ->where('ahm.ashm_status','O')

                    ->get()->row();

        //echo $this->db->last_query();die(); 

         $totalfilteredrecs=0;

         if(!empty($resltrpt)){

            $totalfilteredrecs=$resltrpt->cnt;      

         }

        

        $order_by = 'ashm_id';

        $order = 'desc';

        if($this->input->get('sSortDir_0'))

        {

                $order = $this->input->get('sSortDir_0');

        }

  

        $where='';

        if($this->input->get('iSortCol_0')==0)
            $order_by = 'ashm_id';

        else if($this->input->get('iSortCol_0')==1)
            $order_by = 'ashm_fyear';

        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'ashm_refno';

        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'ashm_handoverdatead';

        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'ashm_handoverdatebs';

        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'ashm_fromstaffname';


        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'ashm_tostaffname';
       
        else if($this->input->get('iSortCol_0')==8)
        $order_by = 'ashm_postdatead';

       
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



       
        if( $filtertype=='range'){
             if(!empty(($frmDate && $toDate))){
            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('ahm.ashm_handoverdatebs >=',$frmDate);

                $this->db->where('ahm.ashm_handoverdatebs <=',$toDate);    

            }else{

                $this->db->where('ahm.ashm_handoverdatead >=',$frmDate);

                $this->db->where('ahm.ashm_handoverdatead <=',$toDate);

            }

         }
        }

        if(!empty($handoverfrom_staffid)){
          $this->db->where('ahm.ashm_fromstaffid',$handoverfrom_staffid);
        }
        if(!empty($handoverto_staffid)){
          $this->db->where('ahm.ashm_tostaffid',$handoverto_staffid);
        }

         if(!empty($refno)){
          $this->db->where('ahm.ashm_refno',$refno);
        }
       
        

        if(!empty($get['sSearch_1'])){
            $this->db->where("ashm_fyear like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("ashm_refno like  '%".$get['sSearch_2']."%'  ");

        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("ashm_handoverdatead like  '%".$get['sSearch_3']."%'  ");

        }


        if(!empty($get['sSearch_4'])){
            $this->db->where("ashm_handoverdatebs like  '%".$get['sSearch_4']."%'  ");

        }


        if(!empty($get['sSearch_5'])){
            $this->db->where("ashm_fromstaffname like  '%".$get['sSearch_5']."%'  ");

        }

       
        if(!empty($get['sSearch_6'])){
            $this->db->where("ashm_tostaffname like  '%".$get['sSearch_6']."%'  ");

        }
        
        if($cond) {
          $this->db->where($cond);

        }

        $this->db->select("ashm_id,
                        ashm_fyear,
                        ashm_refno,
                        ashm_handoverdatead,
                        ashm_handoverdatebs,
                        ashm_fromstaffid,
                        ashm_tostaffid,
                        ashm_fromstaffname,
                        ashm_tostaffname,
                        ashm_assetcount,
                        ashm_remarks,
                        ashm_postdatead,
                        ashm_postdatebs")
       ->from('ashm_assethandovermaster ahm');
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

