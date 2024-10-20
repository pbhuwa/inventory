<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Faq_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='facq_faqcategory';
        $this->table1='fali_faqlist';
	}
    public $validate_settings_faq_category = array(
        array('field' => 'facq_catname', 'label'=>'Category Name','rules'=>'trim|required|xss_clean'),
        array('field' => 'facq_catnamenp', 'label'=>'Category Name in Nepali','rules'=>'trim|required|xss_clean'),
       
    );
    public $validate_settings_faq_list = array(
        array('field' => 'fali_title', 'label'=>'FAQ Tite','rules'=>'trim|required|xss_clean'),
        array('field' => 'fali_titlenp', 'label'=>'FAQ Titee in Nepali','rules'=>'trim|required|xss_clean'),
    );
    public $validate_settings_faq = array(
        array('field' => 'pama_fname', 'label'=>'First Name','rules'=>'trim|required|xss_clean|min_length[3]'),
        array('field' => 'pama_lname', 'label'=>'Last Name','rules'=>'trim|required|xss_clean|min_length[3]'),
        array('field' => 'pama_gender', 'label'=>'Gender','rules'=>'trim|required|xss_clean'),
        array('field' => 'pama_age', 'label'=>'Age','rules'=>'trim|required|xss_clean|min_length[1]'),
        array('field' => 'pama_maritalstatus', 'label'=>'Marital Status','rules'=>'trim|required|xss_clean'),
        array('field' => 'pama_countryid', 'label'=>'Country','rules'=>'trim|required|xss_clean'),
        array('field' => 'pama_districtid', 'label'=>'District','rules'=>'trim|required|xss_clean')
    );
    public function get_faq_cat_list($srch=false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
          $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("fc.facq_catname like  '%".$get['sSearch_1']."%'  ");
        }

      if(!empty($get['sSearch_2'])){
            $this->db->where("fc.facq_catnamenp like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("fc.facq_isactive like  '%".$get['sSearch_3']."%'  ");
        }


    

      $resltrpt=$this->db->select("COUNT(*) as cnt")
                ->from('facq_faqcategory fc')
                ->get()
                ->row();

        // echo $this->db->last_query();die(); 
        $totalfilteredrecs=$resltrpt->cnt; 

        $order_by = 'fc.facq_catname';
        $order = 'asc';
        if($this->input->get('sSortDir_0'))
        {
          $order = $this->input->get('sSortDir_0');
        }
  
        $where='';
        $order_by = 'fc.facq_catname';
        if($this->input->get('iSortCol_0')==1)
          $order_by = 'fc.facq_catname';
        if($this->input->get('iSortCol_0')==2)
          $order_by = 'fc.facq_catnamenp';
               
        
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
            $this->db->where("fc.facq_catname like  '%".$get['sSearch_1']."%'  ");
        }

       if(!empty($get['sSearch_2'])){
            $this->db->where("fc.facq_catnamenp like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("fc.facq_isactive like  '%".$get['sSearch_3']."%'  ");
        }
        
      $this->db->select('fc.*');
      $this->db->from('facq_faqcategory fc');
      
      // $order='asc';
      $this->db->order_by($order_by,$order);
      if($limit && $limit>0)
      {  
          $this->db->limit($limit,$offset);
      }
    
      if($srch)
      {
        $this->db->where($srch);
      }
      
       $nquery=$this->db->get();
       /*echo $this->db->last_query();
       die();*/
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


  public function remove_faq_cat()
  {
    $id=$this->input->post('id');
    if($id)
    {
      $this->general->save_log($this->table,'faca_faqcatid',$id,$postdata=array(),'Delete');
      $this->db->delete('facq_faqcategory',array('faca_faqcatid'=>$id));
      $rowaffected=$this->db->affected_rows();
      if($rowaffected)
      {
        return $rowaffected;
      }
      return false;
    }
    return false;
  }

  public function get_all_faq_cat_list($srchcol=false,$limit=false,$offset=false,$order_by=false,$order='ASC')
  {
    $this->db->select('fc.*');
    $this->db->from('facq_faqcategory fc');
    if($srchcol)
    {
      $this->db->where($srchcol);
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
    if ($query->num_rows() > 0) 
    {
      $data=$query->result();   
      return $data;   
    }   
    return false;
  }

  public function get_all_faq($id=false,$search=false)
  {
   $this->db->select('* ');
    $this->db->from('facq_faqcategory fa');

    if($id)
    {
      $this->db->where($id);
    }
    if($search)
    {
      $this->db->where($search);
    }
    

    $query = $this->db->get();

    if ($query->num_rows() > 0)
    {
     return $data=$query->result();
    } 
    return false;
  }

  public function get_all_faq_list($id=false)
  {
    $this->db->select('f.*,fc.facq_catname as catname,fc.faca_faqcatid');
    $this->db->from('fali_faqlist f');
    if($id)
    {
      $this->db->where('f.fali_catid',$id);
    }
    $this->db->join('facq_faqcategory fc','fc.faca_faqcatid=f.fali_catid','left');
    //$this->db->order_by("f.display_order", "ASC");    

    $query = $this->db->get();

    if ($query->num_rows() > 0)
    {
     return $data=$query->result('array');
    } 
    return false;
  }


  public function faq_cat_save()
  {
    $postdata=$this->input->post();
    $id=$this->input->post('id');
    unset($postdata['id']);
    if($id)
    {  
      $postdata['facq_modefieddatead']=CURDATE_EN;
      $postdata['facq_modefieddatebs']=CURDATE_NP;
      $postdata['facq_modefiedtime']=date('H:i:s');
        if(!empty($postdata))
        {
            $this->general->save_log($this->table,'faca_faqcatid',$id,$postdata,'Update');
            $this->db->update($this->table,$postdata,array('faca_faqcatid'=>$id));
            //echo $this->db->last_query();die;
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
    $postdata['facq_postdatead']=CURDATE_EN;
    $postdata['facq_postdatebs']=CURDATE_NP;
    $postdata['facq_posttime']=date('H:i:s');
    $postdata['facq_postmac']=$this->general->get_Mac_Address();
    $postdata['facq_postip']=$this->general->get_real_ipaddr();
    $postdata['facq_postby']=$this->session->userdata(USER_ID);
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

  }

    public function faq_list_save(){
        $postdata=$this->input->post();
        $id=$this->input->post('id');
        unset($postdata['id']);

        // echo "<pre>";
        // print_r($postdata);
        // die();

        if($id){
            if(!empty($postdata)){
                // $this->general->save_log($this->table1,'fali_faqlistid',$id,$postdata,'Update');
                $this->db->update($this->table1,$postdata,array('fali_faqlistid'=>$id));

                // echo $this->db->last_query();
                // die();

                $rowaffected=$this->db->affected_rows();
                
                if($rowaffected){
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
            $postdata['fali_postdatead']=CURDATE_EN;
            $postdata['fali_postdatebs']=CURDATE_NP;
            $postdata['fali_posttime']=date('H:i:s');
            $postdata['fali_postmac']=$this->general->get_Mac_Address();
            $postdata['fali_postip']=$this->general->get_real_ipaddr();
            $postdata['fali_postby']=$this->session->userdata(USER_ID);

            if(!empty($postdata)){
                $this->db->insert($this->table1,$postdata);
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
    }


public function get_list_faq($srch=false)
  {
      $get = $_GET;
        foreach ($get as $key => $value) {
          $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("mt.maty_material like  '%".$get['sSearch_1']."%'  ");
        }

      if(!empty($get['sSearch_2'])){
            $this->db->where("fc.facq_catname like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("it.itli_itemcode like  '%".$get['sSearch_3']."%'  ");
        }

      if(!empty($get['sSearch_4'])){
            $this->db->where("it.itli_itemname like  '%".$get['sSearch_4']."%' OR it.itli_itemnamenp like  '%".$get['sSearch_4']."%'    ");
        }

         if(!empty($get['sSearch_5'])){
            $this->db->where("it.itli_itemname like  '%".$get['sSearch_5']."%' OR it.itli_itemnamenp like  '%".$get['sSearch_5']."%'    ");
        }
        
      if(!empty($get['sSearch_6'])){
            $this->db->where("it.itli_purchaserate like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            //$this->db->where("it.itli_purchaserate like  '%".$get['sSearch_7']."%'  ");
          $this->db->where("u.unit_unitname like  '%".$get['sSearch_7']."%'  ");
        }
       if(!empty($get['sSearch_8'])){
            $this->db->where("et.eqty_equipmenttype like  '%".$get['sSearch_8']."%'  ");
        }

    
        //echo "Her to echo";
      $resltrpt=$this->db->select("COUNT(*) as cnt")
                ->from('fali_faqlist fc')
                ->join('facq_faqcategory fq','fq.faca_faqcatid=fc.fali_catid','left')
                ->get()
                ->row();
        //echo $this->db->last_query();die(); 
        $totalfilteredrecs=$resltrpt->cnt;
        $order_by = 'fc.fali_title';
        $order = 'asc';
        if($this->input->get('sSortDir_0'))
        {
          $order = $this->input->get('sSortDir_0');
        }
  
        $where='';
        if($this->input->get('iSortCol_0')==1)
          $order_by = 'mt.maty_material';
        if($this->input->get('iSortCol_0')==2)
          //$order_by = 'fc.eqca_code';
          $order_by = 'fc.fali_title';
        
        else if($this->input->get('iSortCol_0')==3)
          $order_by = 'it.itli_itemcode';
        else if($this->input->get('iSortCol_0')==4)
          $order_by = 'it.itli_itemname ';
          else if($this->input->get('iSortCol_0')==5)
          $order_by = 'it.itli_itemnamenp ';
          else if($this->input->get('iSortCol_0')==7)
          $order_by = 'u.unit_unitname';
        else if($this->input->get('iSortCol_0')==8)
          $order_by = 'et.eqty_equipmenttype';
       
       
        
        $totalrecs='';
      
        $get = $_GET;
 
        foreach ($get as $key => $value) {
          $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
      
        if(!empty($_GET["iDisplayLength"])){
           $limit = $_GET['iDisplayLength'];
           $offset = $_GET["iDisplayStart"];
        }

      
          if(!empty($get['sSearch_1'])){
            $this->db->where("mt.maty_material like  '%".$get['sSearch_1']."%'  ");
        }

       if(!empty($get['sSearch_2'])){
            $this->db->where("fc.fali_title like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("it.itli_itemcode like  '%".$get['sSearch_3']."%'  ");
        }

       if(!empty($get['sSearch_4'])){
            $this->db->where("it.itli_itemname like  '%".$get['sSearch_4']."%' OR it.itli_itemnamenp like  '%".$get['sSearch_4']."%'    ");
        }

         if(!empty($get['sSearch_5'])){
            $this->db->where("it.itli_itemname like  '%".$get['sSearch_5']."%' OR it.itli_itemnamenp like  '%".$get['sSearch_5']."%'    ");
        }
        
       if(!empty($get['sSearch_6'])){
            $this->db->where("it.itli_purchaserate like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            //$this->db->where("it.itli_purchaserate like  '%".$get['sSearch_7']."%'  ");
          $this->db->where("u.unit_unitname like  '%".$get['sSearch_7']."%'  ");
        }
       if(!empty($get['sSearch_8'])){
            $this->db->where("et.eqty_equipmenttype like  '%".$get['sSearch_8']."%'  ");
        }

      $this->db->select('fc.fali_faqlistid,fc.fali_catid,fc.fali_title,fc.fali_titlenp,fc.fali_description,fc.fali_descriptionnp,fq.facq_catname');
      $this->db->from('fali_faqlist fc');
      $this->db->join('facq_faqcategory fq','fq.faca_faqcatid=fc.fali_catid','left');
      //$this->db->order_by($order_by,$order);
     
    
      if($srch)
      {
        $this->db->where($srch);
      }
      
       $nquery=$this->db->get();
       // echo $this->db->last_query();
       // die();
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


 public function get_faq_list($srchcol=false,$limit=false,$offset=false,$order_by=false,$order='ASC')
  {
    $this->db->select('fc.*');
    $this->db->from('fali_faqlist fc');
    if($srchcol)
    {
      $this->db->where($srchcol);
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
    if ($query->num_rows() > 0) 
    {
      $data=$query->result();   
      return $data;   
    }   
    return false;
  }



public function remove_faq()
  {
    $id=$this->input->post('id');
    // print_r($id);
    // die();

    if($id)
    {
      //$this->general->save_log($this->table,'fali_faqlistid',$id,$postdata=array(),'Delete');

       $this->db->where('fali_faqlistid', $id);
      $this->db->delete('fali_faqlist'); 


      // $this->db->delete('fali_faqlist',array('fali_faqlistid'=>$id));
      $rowaffected=$this->db->affected_rows();
      if($rowaffected)
      {
        return $rowaffected;
      }
      return false;
    }
    return false;
  }



}