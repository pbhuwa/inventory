<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project_setup_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='prin_projectinfo';
    $this->userid = $this->session->userdata(USER_ID);
    $this->username = $this->session->userdata(USER_NAME);
    $this->curtime = $this->general->get_currenttime();
    $this->mac = $this->general->get_Mac_Address();
    $this->ip = $this->general->get_real_ipaddr();
    $this->locationid=$this->session->userdata(LOCATION_ID);
    $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
    $this->orgid=$this->session->userdata(ORG_ID);
	}

	public $validate_project_setup = array(  
	 	array('field' => 'prin_code', 'label' => 'Search And Add Data', 'rules' => 'trim|required|xss_clean'),            
        );

  public $validate_project_bill_setup = array(  
    array('field' => 'prbl_amount', 'label' => 'Search And Add Data', 'rules' => 'trim|required|xss_clean'),            
        );
	 public function project_setup_save(){
      $postdata=$this->input->post();
      // echo "<pre>";
      // print_r($postdata);
      // die();
      $prin_startdate=$this->input->post('prin_startdate');
      $prin_estenddate=$this->input->post('prin_estenddate');
      $prin_contractdate=$this->input->post('prin_contractdate');
      $prin_completion_date=$this->input->post('prin_completion_date');
      if(DEFAULT_DATEPICKER=='NP'){   
        $prin_startdateNp = $prin_startdate;
        $prin_startdateEn = $this->general->NepToEngDateConv($prin_startdate);
        $prin_estenddateNp = $prin_estenddate;
        $prin_estenddateEn = $this->general->NepToEngDateConv($prin_estenddate);
        $prin_contractdateNp = $prin_contractdate;
        $prin_contractdateEn = $this->general->NepToEngDateConv($prin_contractdate);
        $prin_completion_dateNp = $prin_completion_date;
        $prin_completion_dateEn = $this->general->NepToEngDateConv($prin_completion_date);
      }
      else{
        $prin_startdateEn = $prin_startdate;
        $prin_startdateNp = $this->general->EngtoNepDateConv($prin_startdate);
        $prin_estenddateEn = $prin_estenddate;
        $prin_estenddateNp = $this->general->EngtoNepDateConv($prin_estenddate);
        $prin_contractdateEn = $prin_contractdate;
        $prin_contractdateNp = $this->general->EngtoNepDateConv($prin_contractdate);
        $prin_completion_dateEn = $prin_completion_date;
        $prin_completion_dateNp = $this->general->EngtoNepDateConv($prin_completion_date);
      }

      $id=$this->input->post('id');
      unset($postdata['id']);
      unset($postdata['prin_startdate']);
      unset($postdata['prin_estenddate']);
      unset($postdata['prin_contractdate']);
      unset($postdata['prin_completion_date']);
      unset($postdata['operation']);
      $postdata['prin_startdatead']=$prin_startdateEn; 
      $postdata['prin_startdatebs']=$prin_startdateNp;
      $postdata['prin_estenddatead']=$prin_estenddateEn; 
      $postdata['prin_estenddatebs']=$prin_estenddateNp;
      $postdata['prin_contractdatead']=$prin_contractdateEn; 
      $postdata['prin_contractdatebs']=$prin_contractdateNp;
      $postdata['prin_complete_datead']=$prin_completion_dateEn; 
      $postdata['prin_complete_datebs']=$prin_completion_dateNp;
      $postdata['prin_postdatead']=CURDATE_EN;
      $postdata['prin_postdatebs']=CURDATE_NP;
      $postdata['prin_postby']=$this->userid;
      $postdata['prin_posttime']=$this->curtime;
      $postdata['prin_postip']=$this->ip;
      $postdata['prin_postmac']=$this->mac;
      $postdata['prin_locationid']= $this->locationid;
      $postdata['prin_orgid']=$this->orgid;


      if($id){
        $prin_complete_status=$this->input->post('prin_complete_status');
        if(!empty($postdata)){
          $this->db->update($this->table,$postdata,array('prin_prinid'=>$id));
          $rw_aff=$this->db->affected_rows();
          if(!empty($rw_aff)){
            return $id;
          }
          return false;
        }
      }
      else{
        $prin_complete_status=$this->input->post('prin_complete_status');
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
	 public function get_all_project_rec_list($cond = false){    
    $frmDate=!empty($this->input->get('frmDate'))?$this->input->get('frmDate'):CURMONTH_DAY1;
        $toDate=!empty($this->input->get('toDate'))?$this->input->get('toDate'):DISPLAY_DATE;
        $dateSearch = $this->input->get('dateSearch');
        // echo $toDate;
        // die();
           $prin_fiscalyrs = $this->input->get('prin_fiscalyrs');
           $prin_contactorid = $this->input->get('prin_contactorid');
           // $asen_description = $this->input->get('asen_description');
           $srchtext= $this->input->get('srchtext');
                   // if($dateSearch == "purchasedate")
        // {
            // if($frmDate &&  $toDate)
            // {                  
            //     if(DEFAULT_DATEPICKER=='NP')
            //     {
            //         $this->db->where(array('prin_startdatebs >='=>$frmDate,'prin_startdatebs <='=>$toDate));
            //     }
            //     else
            //     {
            //         $this->db->where(array('prin_startdatead >='=>$frmDate,'prin_startdatead <='=>$toDate));
            //     }
            // }
        // }

    //     if($dateSearch == "inservicedate")
    //     {
    //         if($frmDate &&  $toDate)
    //         {
            
    //             if(DEFAULT_DATEPICKER=='NP')
        // {
        //  $this->db->where(array('asen_inservicedatebs >='=>$frmDate,'asen_inservicedatebs <='=>$toDate));
        // }
        // else
        // {
        //    $this->db->where(array('asen_inservicedatead >='=>$frmDate,'asen_inservicedatead <='=>$toDate));
        // }
    //         }
    //     }

        // if($dateSearch == "warrentydate")
        // {
        //     if($frmDate &&  $toDate)
        //     {
        //      if(DEFAULT_DATEPICKER=='NP')
        //         {
        //            $this->db->where(array('asen_warrentydatebs >='=>$frmDate,'asen_warrentydatebs <='=>$toDate));
        //         }
        //         else
        //         {
        //             $this->db->where(array('asen_warrentydatead >='=>$frmDate,'asen_warrentydatead <='=>$toDate));
        //         }
        //     }
        // }
          if(!empty($prin_fiscalyrs)){
          $this->db->where('prin.prin_fiscalyrs',$prin_fiscalyrs);

        }
          if(!empty($prin_contactorid)){
          $this->db->where('prin.prin_contactorid',$prin_contactorid);

        }
       
     if(!empty($srchtext))
      {
          $this->db->where("prin.prin_code like  '%".$srchtext."%' || prin.prin_project_title like  '%".$srchtext."%' || prin.prin_project_desc like  '%".$srchtext."%'|| prin.prin_contractno like  '%".$srchtext."%'");
      }
    $get = $_GET;
        foreach ($get as $key => $value) {
          $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

       
    if(!empty($get['sSearch_2'])){
            $this->db->where("prin_code like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("prin_project_title like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("prin_project_desc like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("prin_startdatebs like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("prin_estenddatebs like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("prin_contractno like  '%".$get['sSearch_7']."%'  ");
        }
   //      if(!empty($get['sSearch_7'])){
   //         if(DEFAULT_DATEPICKER=='NP')
      // {
      //  $this->db->where("asen_purchasedatebs like  '%".$get['sSearch_7']."%'  ");
      // }
      // else{
      //  $this->db->where("asen_purchasedatead like  '%".$get['sSearch_7']."%'  ");
      // }
   //      }

   //      if(!empty($get['sSearch_8'])){
   //         if(DEFAULT_DATEPICKER=='NP')
      // {
      //  $this->db->where("asen_warrentydatebs like  '%".$get['sSearch_8']."%'  ");
      // }
      // else{
      //  $this->db->where("asen_warrentydatead like  '%".$get['sSearch_8']."%'  ");
      // }
   //      }
   //      if(!empty($get['sSearch_9'])){
   //          $this->db->where("asen_location like  '%".$get['sSearch_9']."%'  ");
   //      }

        if($cond) {
            $this->db->where($cond);
        }
     

        $resltrpt=$this->db->select("prin_project_title")
                ->from('prin_projectinfo prin')
              ->join('dist_distributors dist','dist.dist_distributorid = prin.prin_contactorid','LEFT')
                ->get()
                ->result();
      // echo $this->db->last_query();die(); 
        $totalfilteredrecs=sizeof($resltrpt);
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
          $order_by = 'prin_prinid';
       //  if($this->input->get('iSortCol_0')==1)
       //   $order_by = 'eqca_category';
       //  else if($this->input->get('iSortCol_0')==2)
       //   $order_by = 'itli_itemname';
        // else if($this->input->get('iSortCol_0')==3)
       //   $order_by = 'asen_modelno';
        // else if($this->input->get('iSortCol_0')==4)
       //     $order_by = 'asen_serialno';
       //     else if($this->input->get('iSortCol_0')==5)
        //    $order_by = 'asst_statusname';
       //   else if($this->input->get('iSortCol_0')==6)
        //    $order_by = 'asco_conditionname';

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
            // if($frmDate &&  $toDate)
            // {                  
            //     if(DEFAULT_DATEPICKER=='NP')
            //     {
            //         $this->db->where(array('prin_startdatebs >='=>$frmDate,'prin_startdatebs <='=>$toDate));
            //     }
            //     else
            //     {
            //         $this->db->where(array('prin_startdatead >='=>$frmDate,'prin_startdatead <='=>$toDate));
            //     }
            // }
        // }

    //     if($dateSearch == "inservicedate")
    //     {
    //         if($frmDate &&  $toDate)
    //         {
            
    //             if(DEFAULT_DATEPICKER=='NP')
        // {
        //  $this->db->where(array('asen_inservicedatebs >='=>$frmDate,'asen_inservicedatebs <='=>$toDate));
        // }
        // else
        // {
        //    $this->db->where(array('asen_inservicedatead >='=>$frmDate,'asen_inservicedatead <='=>$toDate));
        // }
    //         }
    //     }

        // if($dateSearch == "warrentydate")
        // {
        //     if($frmDate &&  $toDate)
        //     {
        //      if(DEFAULT_DATEPICKER=='NP')
        //         {
        //            $this->db->where(array('asen_warrentydatebs >='=>$frmDate,'asen_warrentydatebs <='=>$toDate));
        //         }
        //         else
        //         {
        //             $this->db->where(array('asen_warrentydatead >='=>$frmDate,'asen_warrentydatead <='=>$toDate));
        //         }
        //     }
        // }
          if(!empty($prin_fiscalyrs)){
          $this->db->where('prin.prin_fiscalyrs',$prin_fiscalyrs);

        }
          if(!empty($prin_contactorid)){
          $this->db->where('prin.prin_contactorid',$prin_contactorid);

        }
         if(!empty($srchtext)){
           $this->db->where("prin.prin_code like  '%".$srchtext."%' || prin.prin_project_title like  '%".$srchtext."%' || prin.prin_project_desc like  '%".$srchtext."%'|| prin.prin_contractno like  '%".$srchtext."%'");

        }

       
    if(!empty($get['sSearch_2'])){
            $this->db->where("prin_code like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("prin_project_title like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("prin_project_desc like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("prin_startdatebs like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("prin_estenddatebs like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
              $this->db->where("prin_contractno like  '%".$get['sSearch_7']."%'  ");
        }
   //      if(!empty($get['sSearch_7'])){
   //         if(DEFAULT_DATEPICKER=='NP')
      // {
      //  $this->db->where("asen_purchasedatebs like  '%".$get['sSearch_7']."%'  ");
      // }
      // else{
      //  $this->db->where("asen_purchasedatead like  '%".$get['sSearch_7']."%'  ");
      // }
   //      }

   //      if(!empty($get['sSearch_8'])){
   //         if(DEFAULT_DATEPICKER=='NP')
      // {
      //  $this->db->where("asen_warrentydatebs like  '%".$get['sSearch_8']."%'  ");
      // }
      // else{
      //  $this->db->where("asen_warrentydatead like  '%".$get['sSearch_8']."%'  ");
      // }
   //      }
   //      if(!empty($get['sSearch_9'])){
   //          $this->db->where("asen_location like  '%".$get['sSearch_9']."%'  ");
   //      }

        if($cond) {
            $this->db->where($cond);
        }

        $this->db->select('prin.*,dist_distributorcode,dist_distributor');
        $this->db->from('prin_projectinfo prin');
       
        $this->db->join('dist_distributors dist','dist.dist_distributorid = prin.prin_contactorid','LEFT');

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

public function project_bill_setup_save(){
      $postdata=$this->input->post();
        // echo "<pre>";
        // print_r( $postdata);
        // die();
      $prbl_billdate=$this->input->post('prbl_billdate');
      if(DEFAULT_DATEPICKER=='NP'){   
        $prbl_billdateNp = $prbl_billdate;
        $prbl_billdateEn = $this->general->NepToEngDateConv($prbl_billdate);
      }
      else{
        $prbl_billdateEn = $prbl_billdate;
        $prbl_billdateNp = $this->general->EngtoNepDateConv($prbl_billdate);
      }
      $prbl_attachment = $this->input->post('prbl_attachment');
      // echo $attachment;
      // die();
      $id=$this->input->post('id');
      unset($postdata['id']);
      unset($postdata['prbl_billdate']);
      unset($postdata['operation']);
      unset($postdata['prbl_attachment']);
      $postdata['prbl_billdatead']=$prbl_billdateEn; 
      $postdata['prbl_billdatebs']=$prbl_billdateNp;
      $postdata['prbl_attachment']=$prbl_attachment;
      $postdata['prbl_postdatead']=CURDATE_EN;
      $postdata['prbl_postdatebs']=CURDATE_NP;
      $postdata['prbl_postby']=$this->userid;
      $postdata['prbl_posttime']=$this->curtime;
      $postdata['prbl_postip']=$this->ip;
      $postdata['prbl_postmac']=$this->mac;
      $postdata['prbl_locationid']= $this->locationid;
      $postdata['prbl_orgid']=$this->orgid;
      if($id)
    {
      $this->db->trans_start();
      $postdata['prbl_modifydatead']=CURDATE_EN;
      $postdata['prbl_modifydatebs']=CURDATE_NP;
      $postdata['prbl_modifytime']=$this->general->get_currenttime();
      $postdata['prbl_modifyby']=$this->session->userdata(USER_ID);
      $postdata['prbl_modifyip']=$this->ip;
      $postdata['prbl_modifymac']=$this->mac;
      if(!empty($postdata))
      {
      $this->general->save_log('prbl_projectbill','prbl_prblid',$id,$postdata,'Update');
      $this->db->update('prbl_projectbill',$postdata,array('prbl_prblid'=>$id));
      }

      $this->db->trans_complete();
      if($this->db->trans_status() === FALSE){
          $this->db->trans_rollback();
          return false;
        }
        else{
          $this->db->trans_commit();
          return true;
        }
    }
    else{
      $imageList = '';
      // $new_image_name = $_FILES['fire_attachement']['name'];
       $_FILES['attachments']['name'] = $_FILES['prbl_attachment']['name'];
       $_FILES['attachments']['type'] = $_FILES['prbl_attachment']['type'];
             $_FILES['attachments']['tmp_name'] = $_FILES['prbl_attachment']['tmp_name'];
             $_FILES['attachments']['error'] = $_FILES['prbl_attachment']['error'];
             $_FILES['attachments']['size'] = $_FILES['prbl_attachment']['size'];


      if(!empty($_FILES)){
        $new_image_name = $_FILES['prbl_attachment']['name'];
                $imgfile=$this->doupload('attachments');
                // echo "<pre> at";
                // print_r($imgfile);
                // die();
      }else{
        $imgfile = '';
      }

      
      $postdata['prbl_attachment']=$imgfile;
      $postdata['prbl_postdatead']=CURDATE_EN;
      $postdata['prbl_postdatebs']=CURDATE_NP;
      $postdata['prbl_postby']=$this->userid;
      $postdata['prbl_posttime']=$this->curtime;
      $postdata['prbl_postip']=$this->ip;
      $postdata['prbl_postmac']=$this->mac;
      $postdata['prbl_locationid']= $this->locationid;
      $postdata['prbl_orgid']=$this->orgid;

      // echo "<pre>";

      // print_r($postdata);

      // die();
      $this->db->trans_start();
      if(!empty($postdata))
      {
       $this->db->insert('prbl_projectbill',$postdata);
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



    //   if($id){
    //     if(!empty($postdata)){
    //       $this->db->update('prbl_projectbill',$postdata,array('prbl_prblid'=>$id));
    //       $rw_aff=$this->db->affected_rows();
    //       if(!empty($rw_aff)){
    //         return $id;
    //       }
    //       return false;
    //     }
    //   }
    //   else{
    //     if(!empty($postdata)){
    //     $this->db->insert('prbl_projectbill',$postdata);
    //     $insert_id = $this->db->insert_id();
    //     if($insert_id){
    //       return $insert_id;
    //      }
    //      return false;
    //     }
    // }
}
	
  public function doupload($file) {
        
  // echo $file;
  // die();
        $config['upload_path'] = './'.PROJECT_BILL_ATTACHMENT_PATH;//define in constants
        $config['allowed_types'] = 'png|jpg|gif|jpeg|pdf|docx|doc|txt';
        $config['allowed_types'] = 'png|jpg|gif|jpeg|pdf';
        $config['encrypt_name'] = FALSE;
        $config['remove_spaces'] = TRUE;    
        $config['max_size'] = '5000000';
        $config['max_width'] = '5000';
        $config['max_height'] = '5000';
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
	
}