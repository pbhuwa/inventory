<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_order_aging_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
       
	}
	
	public function get_purchase_order_aging_list($cond = false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
 $frmdate=!empty($get['frmDate'])?$get['frmDate']:'';

        if(!empty($get['sSearch_1'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_1']."%'  ");
        }

        if($cond) {
            $this->db->where($cond);
        }
       
        if($frmdate)
        {
            if(DEFAULT_DATEPICKER=='NP')
            {
                 $this->db->where('puor_deliverydatebs<=', $frmdate);
            }
            else
            {
                 $this->db->where('puor_deliverydatead<=', $frmdate);
            }
           
        }
   $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
        if($this->location_ismain=='Y'){
            if(!empty($locationid))
            {
                  $this->db->where('pom.puor_locationid',$locationid);
            }
         }else{
            $this->db->where('pom.puor_locationid',$this->locationid);

        }

        $resltrpt=$this->db->select("distinct(puor_supplierid) suppliderid,dist_distributor")
                    ->from('puor_purchaseordermaster pom')
                    ->join('dist_distributors ds','ds.dist_distributorid=pom.puor_supplierid','left')
                    ->where('pom.puor_purchased<>',2)
                    ->where('pom.puor_status<>','C')
                    ->group_by('ds.dist_distributorid')
                    ->get()
                    ->result();
 
        $totalfilteredrecs=sizeof($resltrpt); 
        // echo $this->db->last_query();
        // echo $totalfilteredrecs;
        // die();

        $order_by = 'dist_distributor';
        $order = 'ASC';

        if($this->input->get('sSortDir_0'))
        {
            $order = $this->input->get('sSortDir_0');
        }
  
        $where='';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'dist_distributor';
       
        
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
            $this->db->where("dist_distributor like  '%".$get['sSearch_1']."%'  ");
        }

       
        if($cond) {
          $this->db->where($cond);
        }
         if($frmdate)
        {
             if(DEFAULT_DATEPICKER=='NP')
            {
                 $this->db->where('puor_deliverydatebs<=', $frmdate);
            }
            else
            {
                 $this->db->where('puor_deliverydatead<=', $frmdate);
            }
           
        }
    if($this->location_ismain=='Y'){
            if(!empty($locationid))
            {
                  $this->db->where('pom.puor_locationid',$locationid);
            }
         }else{
            $this->db->where('pom.puor_locationid',$this->locationid);

        }


        $this->db->select('distinct(puor_supplierid) suppliderid,dist_distributor')
                    ->from('puor_purchaseordermaster pom')
                    ->join('dist_distributors ds','ds.dist_distributorid=pom.puor_supplierid ','left')
                    ->where('pom.puor_purchased<>',2)
                    ->where('pom.puor_status<>','C')
                    ->group_by('ds.dist_distributorid');

    
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

    public function date_different($date1,$date2)
    {
        $days=strtotime($date1)-strtotime($date2);
        if($days>0)
        {
            $result=floor($days/86400);
            return $result; 
        }
    }
    
    public function get_orderno($suppid)
    {
          $this->db->select('puor_orderno')
                    ->from('puor_purchaseordermaster pom')
                    ->join('dist_distributors ds','ds.dist_distributorid=pom.puor_supplierid ')
                    ->where('pom.puor_purchased<>',2)
                    ->where('pom.puor_status<>','C')   
                    ->where(array('puor_supplierid'=>$suppid)) ;
                    $nquery=$this->db->get();
                    if($nquery->num_rows()>0)
                    {
                        $arr='';
                        $orderno=$nquery->result();
                        if($orderno)
                        {
                            foreach ($orderno as $kor => $ord) {
                               $arr.=$ord->puor_orderno.',';
                            }
                            // return $arr;
                        }
                        return rtrim($arr,',');
                    }        
                    return false;
    }


    public function get_deleverydate_by_supplierid($suppid,$frmdate=false,$fromdays=false,$todays=false)
    {
        $input_fromdate=$frmdate;
        // echo $input_fromdate;
        // die();
        if($input_fromdate)
        {
             if(DEFAULT_DATEPICKER=='NP')
            {
                $ad_datefromdate=$this->general->NepToEngDateConv($input_fromdate);
            }
            else
             {
                $ad_datefromdate=$input_fromdate;
             } 

             if($fromdays)
             {
                $fromdatead=$this->general->add_date($ad_datefromdate,$fromdays,'days','-');
             }
             else
             {
                 $fromdatead=$ad_datefromdate;
             }

             if($todays)
             {
                $todatead=$this->general->add_date($ad_datefromdate,$todays,'days','-');
             }
             else
             {
                 $todatead=$ad_datefromdate;
             }
             // echo $todatead;


             if(DEFAULT_DATEPICKER=='NP')
            {
                $deliverydatefrom=$this->general->EngToNepDateConv($fromdatead);
                $deliverydateto=$this->general->EngToNepDateConv($todatead);

            }
            else
            {
                $deliverydatefrom=$fromdatead;
                $deliverydateto=$todatead;
            }
            // echo $deliverydatefrom;
            // echo $deliverydateto;
            // die();
            if($fromdays)
            {
              $this->db->where('puor_deliverydatebs<=', $deliverydatefrom);  
            }

            if($todays)
            {
                $this->db->where('puor_deliverydatebs>=', $deliverydateto);   
            }

             
                     

        }
       

          $this->db->select('puor_orderno,puor_deliverydatead,puor_deliverydatebs,puor_purchaseordermasterid')
                    ->from('puor_purchaseordermaster pom')
                    ->join('dist_distributors ds','ds.dist_distributorid=pom.puor_supplierid ')
                    ->where('pom.puor_purchased<>',2)
                    ->where('pom.puor_status<>','C')   
                    ->where(array('puor_supplierid'=>$suppid)) ;
                    
                    $nquery=$this->db->get();
                    if($nquery->num_rows()>0)
                    {
                        $arr='';
                        $orderno=$nquery->result();
                        if($orderno)
                        {
                            foreach ($orderno as $kor => $ord) {
                              $arr.='<a href="javascript:void(0)" title="BS:'.$ord->puor_deliverydatebs.' |&nbsp;AD:'.$ord->puor_deliverydatead.'" data-id='.$ord->puor_purchaseordermasterid.'  data-displaydiv="orderDetails" data-viewurl='.base_url('purchase_receive/purchase_order/details_order_views/').' class="view" data-heading="'.$this->lang->line('order_detail').'">'.$ord->puor_orderno.'</a>&nbsp;'.',';
                            }
                            // return $arr;
                        }
                        return rtrim($arr,',');
                    }        
                    return '';
    }

   
}