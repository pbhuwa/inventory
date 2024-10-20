<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Distributors_mdl extends CI_Model 
{
    public function __construct() 
    {
        parent::__construct();
        $this->table='dist_distributors';
    }

    public $validate_settings_distributors = array(               
    array('field' => 'dist_distributor', 'label' => 'Distributor Name', 'rules' => 'trim|required|xss_clean|is_unique[dist_distributors.dist_distributor]'),
    array('field' => 'dist_phone1', 'label' => 'Phone 1', 'rules' => 'trim|required|xss_clean'),
    array('field' => 'dist_email', 'label' => 'Email', 'rules' => 'trim|valid_email|xss_clean'),
    array('field' => 'dist_repemail', 'label' => 'Sales Resp. Email', 'rules' => 'trim|valid_email|xss_clean'  )
    );
  public $validate_settings_users_edit = array(               
        array('field' => 'dist_distributor', 'label' => 'Supplier Name', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'dist_phone1', 'label' => 'Phone 1', 'rules' => 'trim|required|xss_clean'),
    array('field' => 'dist_email', 'label' => 'Email', 'rules' => 'trim|xss_clean'),
    array('field' => 'dist_repemail', 'label' => 'Sales Resp. Email', 'rules' => 'trim|xss_clean'  )
        );
    
    public function distributor_save()
    {
        $postdata=$this->input->post();
    $locationid=$this->session->userdata(LOCATION_ID);
        $id=$this->input->post('id');
        unset($postdata['id']);
        if($id)
        {
        $postdata['dist_modifyad']=CURDATE_EN;
        $postdata['dist_modifybs']=CURDATE_NP;
        $postdata['dist_modifytime']=$this->general->get_currenttime();
        $postdata['dist_modifyby']=$this->session->userdata(USER_ID);
        $postdata['dist_modifyip']=$this->general->get_real_ipaddr();
        $postdata['dist_modifymac']=$this->general->get_Mac_Address();
        // $postdata['dist_govtregdatebs']=$this->input->post('dist_govtregdatebs');
     //    $postdata['dist_govtregdatead']=$this->input->post('dist_govtregdatead');

      $govtregdate = $this->input->post('dist_govtregdate');

      $vatregdate = $this->input->post('dist_vatregdate');

      $postdata['dist_locationid']=$locationid;
        
        if(DEFAULT_DATEPICKER=='NP')
            {
              $postdata['dist_govtregdatebs']=$govtregdate; 
              $postdata['dist_govtregdatead']= $this->general->NepToEngDateConv($govtregdate);

              $postdata['dist_vatregdatebs']=$vatregdate; 
              $postdata['dist_vatregdatead']= $this->general->NepToEngDateConv($vatregdate);
            }
            else
            {
              $postdata['dist_govtregdatead']=$govtregdate; 
              $postdata['dist_govtregdatebs']=$this->general->EngToNepDateConv($govtregdate);

              $postdata['dist_vatregdatead']=$vatregdate; 
              $postdata['dist_vatregdatebs']= $this->general->NepToEngDateConv($vatregdate);
            }

            unset($postdata['dist_govtregdate']);
          unset($postdata['dist_vatregdate']);

        if(!empty($postdata))
        {   //echo "<pre>";print_r($postdata); die();
            $this->general->save_log($this->table,'dist_distributorid',$id,$postdata,'Update');
            $this->db->update($this->table,$postdata,array('dist_distributorid'=>$id));
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
            $postdata['dist_postdatead']=CURDATE_EN;
            $postdata['dist_postdatebs']=CURDATE_NP;
            $postdata['dist_posttime']=$this->general->get_currenttime();
            $postdata['dist_postby']=$this->session->userdata(USER_ID);
            $postdata['dist_postip']=$this->general->get_real_ipaddr();
            $postdata['dist_postmac']=$this->general->get_Mac_Address();
            $postdata['dist_orgid']=$this->session->userdata(ORG_ID);
            $postdata['dist_govtregdatebs']=$this->input->post('dist_govtregdatebs');
            $postdata['dist_govtregdatead']=$this->input->post('dist_govtregdatead');
      $postdata['dist_locationid']=$locationid;
            // echo "<pre>";print_r($postdata); die();

      $govtregdate = $this->input->post('dist_govtregdate');

      $vatregdate = $this->input->post('dist_vatregdate');

            if(DEFAULT_DATEPICKER=='NP')
            {
              $postdata['dist_govtregdatebs']=$govtregdate; 
              $postdata['dist_govtregdatead']= $this->general->NepToEngDateConv($govtregdate);

              $postdata['dist_vatregdatebs']=$vatregdate; 
              $postdata['dist_vatregdatead']= $this->general->NepToEngDateConv($vatregdate);
            }
            else
            {
              $postdata['dist_govtregdatead']=$govtregdate; 
              $postdata['dist_govtregdatebs']=$this->general->EngToNepDateConv($govtregdate);

              $postdata['dist_vatregdatead']=$vatregdate; 
              $postdata['dist_vatregdatebs']= $this->general->NepToEngDateConv($vatregdate);
            }

          unset($postdata['dist_govtregdate']);
          unset($postdata['dist_vatregdate']);

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

    public function get_distributor_list($srchcol=false,$limit=false,$offset=false,$order_by=false,$order='ASC')
    {
        $this->db->select('di.*,c.coun_countryname');
        $this->db->from('dist_distributors di');
        $this->db->join('coun_country c','c.coun_countryid=di.dist_countryid','left');

        if($srchcol)
        {
           $this->db->where($srchcol); 
        }

      if($limit){
        $this->db->limit($limit);
      }
      if($offset){
        $this->db->offset($offset);
      }

      if($order_by){
        $this->db->order_by($order_by,$order);
      }

       $qry=$this->db->get();
        // echo $this->db->last_query();
        // die();
       if($qry->num_rows()>0)
       {
        return $qry->result();
       }
       return false;
      }

    public function get_distributor($srstinl=false,$limit=false,$offset=false,$order_by=false,$order=false,$groupby=false)
    {
        $srchtxt= $this->input->post('srchtext');
        $this->db->select('*');
        $this->db->from('dist_distributors');
        // $this->db->group_by('dist_distributor');
        if($srstinl)
        {
            $this->db->where($srstinl);
        }

        if($srchtxt)
        {
            $this->db->where("dist_distributor like  '%".$srchtxt."%'  ");
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
        
        // $this->db->set_dbprefix('');

        if($groupby)
        {
            $this->db->group_by($groupby);
        }
        
        // $this->db->set_dbprefix('xw_');
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

    public function remove_distributor()
    {
        $id=$this->input->post('id');
        if($id)
        {
            $this->general->save_log($this->table,'dist_distributorid',$id,$postdata=array(),'Delete');
            $this->db->delete($this->table,array('dist_distributorid'=>$id));
            $rowaffected=$this->db->affected_rows();
            if($rowaffected)
            {
                return $rowaffected;
            }
            return false;
        }
        return false;
    }

    public function get_distributors_list($cond = false)
    {
        $get = $_GET;
 
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

      $text_srch = $get['text_srch'];
        if(!empty($get['sSearch_0'])){
            $this->db->where("lower(dist_distributorid) like  '%".trim($get['sSearch_0'])."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(dist_distributorcode) like  '%".trim($get['sSearch_1'])."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(dist_distributor) like  '%".trim($get['sSearch_2'])."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(dist_city) like  '%".trim($get['sSearch_3'])."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(dist_address1) like  '%".trim($get['sSearch_4'])."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(dist_govtregno) like  '%".trim($get['sSearch_5'])."%'  ");
        }
          if($cond) {
          $this->db->where($cond);
        }

       if(!empty($text_srch)){

            $this->db->where("dist_distributor like  '%".trim($text_srch)."%' OR dist_govtregno like  '%".trim($text_srch)."%' OR dist_phone1 like  '%".trim($text_srch)."%' OR dist_distributorcode like  '%".trim($text_srch)."%'");

        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('dist_distributors d')
                    ->join('coun_country c','c.coun_countryid=d.dist_countryid','left')
                    ->get()
                    ->row(); 
        //echo $this->db->last_query();die(); 
        $totalfilteredrecs=$resltrpt->cnt; 

        $order_by = 'dist_distributorid';
        $order = 'desc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
  
        $where='';
        if($this->input->get('iSortCol_0')==0)
            $order_by = 'dist_distributorid';
        else if($this->input->get('iSortCol_0')==1)
            $order_by = 'dist_distributor';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'coun_countryname';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'dist_city';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'dist_address1';
        
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
            $this->db->where("lower(dist_distributorid) like  '%".trim($get['sSearch_0'])."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(dist_distributorcode) like  '%".trim($get['sSearch_1'])."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(dist_distributor) like  '%".trim($get['sSearch_2'])."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(dist_city) like  '%".trim($get['sSearch_3'])."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(dist_address1) like  '%".trim($get['sSearch_4'])."%'  ");
        }
          if(!empty($get['sSearch_5'])){
            $this->db->where("lower(dist_govtregno) like  '%".trim($get['sSearch_5'])."%'  ");
        }
       //   if($this->session->userdata(USER_ACCESS_TYPE)=='S')
        // {
       //  $this->db->where('dist_orgid',$this->session->userdata(ORG_ID));
        // }

        if($cond) {
          $this->db->where($cond);
        }
         if(!empty($text_srch)){

            $this->db->where("dist_distributor like  '%".trim($text_srch)."%' OR dist_govtregno like  '%".trim($text_srch)."%' OR dist_phone1 like  '%".trim($text_srch)."%' OR dist_distributorcode like  '%".trim($text_srch)."%'");

        }

        $this->db->select('di.*,c.coun_countryname');
        $this->db->from('dist_distributors di');
        $this->db->join('coun_country c','c.coun_countryid=di.dist_countryid','left');

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

  public function check_exit_supplier_for_other($dist_distributor,$input_id)
  {
    
    $data = array();

    if($input_id)
    {
      $query = $this->db->get_where($this->table,array('dist_distributor'=>$dist_distributor,'dist_distributorid !='=>$input_id));
    }
    else
    {
      $query = $this->db->get_where($this->table,array('dist_distributor'=>$dist_distributor));
    }
    if ($query->num_rows() > 0) 
    {
      $data=$query->row();  
      return $data;     
    }
    return false;
  }
    
}