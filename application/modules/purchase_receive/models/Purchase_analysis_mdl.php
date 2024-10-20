<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_analysis_mdl extends CI_Model 
{
    public function __construct() 
    {
        parent::__construct();
             $this->locationid = $this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
    }
   
    public function get_mrn_purchase_analysis($srchcol=false,$limit=false,$offset=false,$order_by=false,$order='ASC')
    {
        $frmDate=$this->input->post('fromdate');
        $toDate=$this->input->post('todate');
        
        $this->db->select('rm.recm_purchaseorderno,rm.recm_receiveddatebs,rm.recm_receiveddatead,rm.recm_invoiceno,rm.recm_supbilldatead,rm.recm_supbilldatebs,rm.recm_supplierbillno,rm.recm_amount,rm.recm_discount,rm.recm_taxamount,rm.recm_clearanceamount,rm.recm_supplierid,d.dist_distributor,rm.recm_enteredby, rm.recm_postusername');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('dist_distributors d', 'd.dist_distributorid=rm.recm_supplierid');
        $this->db->where(array('rm.recm_status <>'=>'M'));
        if($frmDate && $toDate)
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where(array('rm.recm_receiveddatebs >='=>$frmDate,'rm.recm_receiveddatebs <='=>$toDate));
            }else{
                $this->db->where(array('rm.recm_receiveddatead >='=>$frmDate,'rm.recm_receiveddatead <='=>$toDate));
            }
        }
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
        $qry=$this->db->get();
        // echo $this->db->last_query();die();
      
        if($qry->num_rows()>0)
        {
            return $qry->result();
        }
        return false;
    }

    public function get_mrn_supplier_info()
    {
        $frmDate=$this->input->post('fromdate');
        $toDate=$this->input->post('todate');
        $locationid = $this->input->post('locationid');
        $supplierid = $this->input->post('supplierid');

        $this->db->select('DISTINCT(recm_supplierid) supplierid, d.dist_distributor');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('dist_distributors d', 'd.dist_distributorid=rm.recm_supplierid');
        $this->db->where(array('rm.recm_status <>'=>'M'));
        if($frmDate && $toDate)
        {
            if(DEFAULT_DATEPICKER=='NP')
            {
                $this->db->where(array('rm.recm_receiveddatebs >='=>$frmDate,'rm.recm_receiveddatebs <='=>$toDate)); 
            }
            else
            {
                $this->db->where(array('rm.recm_receiveddatead >='=>$frmDate,'rm.recm_receiveddatead <='=>$toDate)); 
            }
        }
        if($locationid){
            $this->db->where('rm.recm_locationid',$locationid);
        }
        if($supplierid){
            $this->db->where('rm.recm_supplierid',$supplierid);
        }
        $this->db->order_by('d.dist_distributor','ASC');
         
        $qry=$this->db->get();
        // echo $this->db->last_query();die(); 
        if($qry->num_rows()>0)
        {
            return $qry->result();
        }
        return false;
    }

    public function get_mrn_return_analysis($srchcol=false,$limit=false,$offset=false,$order_by=false,$order='ASC')
    {
        $frmDate=$this->input->post('fromdate');
        $toDate=$this->input->post('todate');
        
        $this->db->select('pr.purr_returnno, pr.purr_returndatebs, pr.purr_returndatead,pr.purr_invoiceno,pr.purr_returnamount,pr.purr_discount, pr.purr_vatamount,pr.purr_supplierid,pr.purr_operator,d.dist_distributor');
        $this->db->from('purr_purchasereturn pr');
        $this->db->join('dist_distributors d', 'd.dist_distributorid=pr.purr_supplierid');
        if($frmDate && $toDate)
        {   
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where(array('pr.purr_returndatebs >='=>$frmDate,'pr.purr_returndatebs <='=>$toDate)); 
            }else{
                $this->db->where(array('pr.purr_returndatead >='=>$frmDate,'pr.purr_returndatead <='=>$toDate)); 
            }
        }
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
        $qry=$this->db->get();
        // echo $this->db->last_query();die();
      
        if($qry->num_rows()>0)
        {
            return $qry->result();
        }
        return false;
    }
    
    public function get_purchase_analysis_purchase_return($srchcol=false,$limit=false,$offset=false,$order_by=false,$order='ASC')
    {
        $frmDate = $this->input->post('fromdate');
        $toDate = $this->input->post('todate');

        $locationid = $this->input->post('locationid');
        $supplierid = $this->input->post('supplierid');
        
        $this->db->select('pr.*,d.dist_distributor');
        $this->db->from('purr_purchasereturn pr');
        $this->db->join('dist_distributors d', 'd.dist_distributorid=pr.purr_supplierid');
        $this->db->where(array('pr.purr_st '=>'N'));
        if($frmDate && $toDate)
        {
            if(DEFAULT_DATEPICKER=='NP')
            {
                $this->db->where(array('pr.purr_returndatebs >='=>$frmDate,'pr.purr_returndatebs <='=>$toDate)); 
            }
            else
            {
                $this->db->where(array('pr.purr_returndatead >='=>$frmDate,'pr.purr_returndatead <='=>$toDate));           
            }
        }

        if($locationid){
            $this->db->where('pr.purr_locationid',$locationid);
        }

        if($supplierid){
            $this->db->where('pr.purr_supplierid',$supplierid);
        }

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
         
        $qry=$this->db->get();
        // echo $this->db->last_query();die(); 
        if($qry->num_rows()>0)
        {
            return $qry->result();
        }
        return false;
    }
     
    public function get_item_cat_info($type = false)
    {
        $frmDate=$this->input->post('fromdate');
        $toDate=$this->input->post('todate');

        $locationid = $this->input->post('locationid');
        $supplierid = $this->input->post('supplierid');
        $itemid = $this->input->post('itemid');

        $this->db->select("DISTINCT(ec.eqca_equipmentcategoryid),(ec.eqca_category) eqca_category, rd.recd_itemsid as itemsid, il.itli_itemname, il.itli_itemnamenp, recm_receiveddatebs, recm_supplierid, dist_distributor, recm_invoiceno");
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('recd_receiveddetail rd', 'rd.recd_receivedmasterid = rm.recm_receivedmasterid','LEFT');

        $this->db->join('itli_itemslist il', 'il.itli_itemlistid=rd.recd_itemsid','LEFT');
        $this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid=il.itli_catid','LEFT');

        $this->db->join('dist_distributors d', 'd.dist_distributorid=rm.recm_supplierid','LEFT'); 
    
        // $this->db->where('ec.eqca_equipmentcategoryid IS NOT NULL');
        $this->db->where(array('rm.recm_status <>'=>'M'));

        if($frmDate && $toDate)
        {
            if(DEFAULT_DATEPICKER=='NP')
            {
                $this->db->where(array('rm.recm_receiveddatebs >='=>$frmDate,'rm.recm_receiveddatebs <='=>$toDate)); 
            }
            else
            {
                $this->db->where(array('rm.recm_receiveddatead >='=>$frmDate,'rm.recm_receiveddatead <='=>$toDate)); 
            }
        }
        if($this->location_ismain=='Y'){
            if(!empty($locationid)){
                    $this->db->where('rm.recm_locationid',$locationid);
                }

        }else{
             $this->db->where('rm.recm_locationid',$this->locationid);

        }
        

        if($supplierid){
            $this->db->where('rm.recm_supplierid',$supplierid);
        }

        if($itemid){
            $this->db->where('rd.recd_itemsid',$itemid);
        }

        if($type == 'supplier_wise'){
            $this->db->group_by('recm_supplierid');
            $this->db->order_by('dist_distributor','ASC');
        }else if($type == 'date_wise'){
            $this->db->group_by('recm_receiveddatebs');
            $this->db->order_by('rm.recm_receiveddatebs','ASC');
        }else if($type == 'item_wise'){
            $this->db->group_by('itli_itemname');
            $this->db->order_by('il.itli_itemname','ASC');
        }else if($type == 'category_wise'){
            $this->db->group_by('eqca_equipmentcategoryid');
            $this->db->order_by('ec.eqca_equipmentcategoryid','ASC');
        }else{
            $this->db->order_by('ec.eqca_equipmentcategoryid','ASC');
        }
         
        $qry=$this->db->get();
        // echo $this->db->last_query();die();
        if($qry->num_rows()>0)
        {
            return $qry->result();
        }
        return false;
    }

    public function get_stock_data(){
        $frmDate=$this->input->post('fromdate');
        $toDate=$this->input->post('todate');

        $locationid = $this->input->post('locationid');
        $supplierid = $this->input->post('supplierid');
        $itemid = $this->input->post('itemid');

        $stock_query = "select sum(trde_requiredqty) as stockqty from xw_trde_transactiondetail WHERE trde_itemsid = '$itemid' AND trde_transactiondatebs <= '$frmDate'";
        $query = $this->db->query($stock_query);

        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }

    public function get_purchase_by_date($srchcol=false,$limit=false,$offset=false,$order_by=false,$order='ASC')
    {
       
        $frmDate=$this->input->post('fromdate');
        $toDate=$this->input->post('todate');
        $supplierid = $this->input->post('supplierid');
        
        $this->db->select('rm.recm_purchaseorderno,rm.recm_receiveddatebs,rm.recm_receiveddatead,rm.recm_invoiceno,rm.recm_supbilldatead,rm.recm_supbilldatebs,rm.recm_supplierbillno,rm.recm_amount,rm.recm_discount,rm.recm_taxamount,rm.recm_clearanceamount,rm.recm_supplierid,d.dist_distributor,rm.recm_enteredby, rm.recm_postusername, rd.recd_itemsid, rd.recd_purchasedqty,rd.recd_unitprice, rd.recd_location, rd.recd_discountpc,rd.recd_discountamt, rd.recd_vatpc,rd.recd_vatamt, rd.recd_amount, d.dist_distributor,il.itli_itemname,il.itli_itemnamenp');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('recd_receiveddetail rd', 'rd.recd_receivedmasterid=rm.recm_receivedmasterid','LEFT');
        $this->db->join('dist_distributors d', 'd.dist_distributorid=rm.recm_supplierid');
        $this->db->join('itli_itemslist il', 'il.itli_itemlistid=rd.recd_itemsid','LEFT');
        $this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid=il.itli_catid','LEFT');
        // $this->db->where('ec.eqca_equipmentcategoryid IS NOT NULL');
        $this->db->where(array('rm.recm_status <>'=>'M'));
        
        if($frmDate && $toDate)
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where(array('rm.recm_receiveddatebs >='=>$frmDate,'rm.recm_receiveddatebs <='=>$toDate)); 
            }else{
                $this->db->where(array('rm.recm_receiveddatead >='=>$frmDate,'rm.recm_receiveddatead <='=>$toDate));
            }
        }

        if($supplierid){
            $this->db->where('rm.recm_supplierid',$supplierid);
        }
        
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
        $qry=$this->db->get();
        //echo $this->db->last_query();die();
      
        if($qry->num_rows()>0)
        {
            return $qry->result();
        }
        return false;
    }

    public function get_purchase_by_item($srchcol=false,$limit=false,$offset=false,$order_by=false,$order='ASC')
    {
       
        $frmDate=$this->input->post('fromdate');
        $toDate=$this->input->post('todate');
        
        $this->db->select('rm.recm_purchaseorderno,rm.recm_receiveddatebs,rm.recm_receiveddatead,rm.recm_invoiceno,rm.recm_supbilldatead,rm.recm_supbilldatebs,rm.recm_supplierbillno,rm.recm_amount,rm.recm_discount,rm.recm_taxamount,rm.recm_clearanceamount,rm.recm_supplierid,d.dist_distributor,rm.recm_enteredby, rd.recd_itemsid, rd.recd_purchasedqty,rd.recd_unitprice, rd.recd_location, rd.recd_discountpc,rd.recd_discountamt, rd.recd_vatpc,rd.recd_vatamt, rd.recd_amount, d.dist_distributor,il.itli_itemname,il.itli_itemnamenp');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('recd_receiveddetail rd', 'rd.recd_receivedmasterid=rm.recm_receivedmasterid','LEFT');
        $this->db->join('dist_distributors d', 'd.dist_distributorid=rm.recm_supplierid');
        $this->db->join('itli_itemslist il', 'il.itli_itemlistid=rd.recd_itemsid','LEFT');
        $this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid=il.itli_catid','LEFT');
        // $this->db->where('ec.eqca_equipmentcategoryid IS NOT NULL');
        $this->db->where(array('rm.recm_status <>'=>'M'));
        
        if($frmDate && $toDate)
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where(array('rm.recm_receiveddatebs >='=>$frmDate,'rm.recm_receiveddatebs <='=>$toDate)); 
            }else{
                $this->db->where(array('rm.recm_receiveddatead >='=>$frmDate,'rm.recm_receiveddatead <='=>$toDate));
            }
        }
        
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
        $qry=$this->db->get();
        //echo $this->db->last_query();die();
      
        if($qry->num_rows()>0)
        {
            return $qry->result();
        }
        return false;
    }

    public function get_purchase_analysis($srchcol=false,$limit=false,$offset=false,$order_by=false,$order='ASC')
    {
        $frmDate=$this->input->post('fromdate');
        $toDate=$this->input->post('todate');
        
        $this->db->select('rm.recm_purchaseorderno,rm.recm_receiveddatebs,rm.recm_receiveddatead,rm.recm_invoiceno,rm.recm_supbilldatead,rm.recm_supbilldatebs,rm.recm_supplierbillno, sum(rm.recm_amount) as total_amount, rm.recm_amount, sum(rm.recm_discount) as total_discount, rm.recm_discount, sum(rm.recm_taxamount) as total_tax, rm.recm_taxamount, sum(rm.recm_clearanceamount) as total_camount, rm.recm_clearanceamount,rm.recm_supplierid,d.dist_distributor,rm.recm_enteredby, rm.recm_postusername');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('dist_distributors d', 'd.dist_distributorid=rm.recm_supplierid');
        $this->db->where(array('rm.recm_status <>'=>'M'));
        if($frmDate && $toDate)
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where(array('rm.recm_receiveddatebs >='=>$frmDate,'rm.recm_receiveddatebs <='=>$toDate));
            }else{
                $this->db->where(array('rm.recm_receiveddatead >='=>$frmDate,'rm.recm_receiveddatead <='=>$toDate));
            }
        }
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
        $qry=$this->db->get();
        // echo $this->db->last_query();die();
      
        if($qry->num_rows()>0)
        {
            return $qry->result();
        }
        return false;
    }

    public function get_purchase_summary($type = false, $srchcol=false)
    {
        $frmDate=$this->input->post('fromdate');
        $toDate=$this->input->post('todate');
        
        $this->db->select('rd.recd_itemsid, il.itli_catid, ec.eqca_category, ec.eqca_equipmentcategoryid, sum(rd.recd_purchasedqty) as total_qty, il.itli_itemname, rm.recm_purchaseorderno,rm.recm_receiveddatebs,rm.recm_receiveddatead,rm.recm_invoiceno,rm.recm_supbilldatead,rm.recm_supbilldatebs,rm.recm_supplierbillno, sum(rm.recm_amount) as total_amount, rm.recm_amount, sum(rm.recm_discount) as total_discount, rm.recm_discount, sum(rm.recm_taxamount) as total_tax, rm.recm_taxamount, sum(rm.recm_clearanceamount) as total_camount, rm.recm_clearanceamount,rm.recm_supplierid,d.dist_distributor, rm.recm_postusername');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('recd_receiveddetail rd','rd.recd_receivedmasterid = rm.recm_receivedmasterid','LEFT');
        $this->db->join('itli_itemslist il', 'il.itli_itemlistid=rd.recd_itemsid','LEFT');
        $this->db->join('dist_distributors d', 'd.dist_distributorid=rm.recm_supplierid','LEFT');
        $this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid=il.itli_catid','LEFT');
        $this->db->where(array('rm.recm_status <>'=>'M'));
        if($frmDate && $toDate)
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where(array('rm.recm_receiveddatebs >='=>$frmDate,'rm.recm_receiveddatebs <='=>$toDate));
            }else{
                $this->db->where(array('rm.recm_receiveddatead >='=>$frmDate,'rm.recm_receiveddatead <='=>$toDate));
            }
        }
        if($srchcol)
        {
            $this->db->where($srchcol); 
        }

        if($type == 'supplier_wise'){
            $this->db->group_by('rm.recm_supplierid');    
        }else if($type == 'date_wise'){
            $this->db->group_by('rm.recm_receiveddatebs');
        }else if($type == 'item_wise'){
            $this->db->group_by('rd.recd_itemsid');
            $this->db->group_by('rd.recd_unitprice');
        }else if($type == 'category_wise'){
            $this->db->group_by('ec.eqca_equipmentcategoryid');
        }
        
        $qry=$this->db->get();
        // echo $this->db->last_query();die();

      
        if($qry->num_rows()>0)
        {
            return $qry->result();
        }
        return false;
    }
}