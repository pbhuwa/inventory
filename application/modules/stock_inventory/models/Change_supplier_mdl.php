<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Change_supplier_mdl extends CI_Model 
{
  public function __construct() 
  {
    parent::__construct();
     $this->chma_masterTable='chma_challanmaster';
    $this->chde_detailTable='chde_challandetails'; 
     }
  public $validate_settings_change_supplier = array( 
     array('field' => 'purchase_date', 'label' => 'Purchase Date', 'rules' => 'trim|required|xss_clean'),
     array('field' => 'supplierid', 'label' => 'Supplier', 'rules' => 'trim|required|xss_clean'),
      array('field' => 'billdate', 'label' => 'Supplier Bill Date', 'rules' => 'trim|required|xss_clean'),
    
       ); 
  public function change_supplier_save()
  {
    try{
      // $postdata=$this->input->post();
      // echo "<pre>";
      // print_r($postdata);
      // die();
      $invoiceno=$this->input->post('receipt_no');
      $fiscal_yrs=$this->input->post('fiscal_yrs');
      $purchase_date=$this->input->post('purchase_date');
      $supplierid=$this->input->post('supplierid');
      if(DEFAULT_DATEPICKER=='NP')
      {
        $purchase_dateNp=$purchase_date;
        $purchase_dateEn=$this->general->NepToEngDateConv($purchase_date);
      }
      else
      {
        $chderdateEn=$purchase_date;
        $chderdateNp=$this->general->EngToNepDateConv($purchase_date);
      }
      $billdate=$this->input->post('billdate');
      if(DEFAULT_DATEPICKER=='NP')
      {
        $billdateNp=$billdate;
        $billdateEn=$this->general->NepToEngDateConv($billdate);
      }
      else
      {
        $billdateEn=$billdate;
        $billdateNp=$this->general->EngToNepDateConv($billdate);
      }
       $this->db->trans_start();
          $this->db->where(array('recm_invoiceno'=>$invoiceno,'recm_fyear'=>$fiscal_yrs));
       $this->db->update('recm_receivedmaster',array('recm_receiveddatead'=>$purchase_dateEn,'recm_receiveddatebs'=>$purchase_dateNp,'recm_supbilldatenp'=>$billdateNp,'recm_supbilldatead'=>$billdateEn,'recm_supplierid'=>$supplierid));
    
       // echo $this->db->last_query();
       // die();

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
          return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }catch(Exception $e){
      throw $e;
    }
  }

public function invoice_no_check()
{
  $invoice_no=$this->input->post('receipt_no');
  $fiscalyrs=$this->input->post('fiscal_yrs');
  $this->db->select('recm_receiveddatebs,recm_supplierid,recm_fyear, recm_purchaseordermasterid');
  $this->db->from('recm_receivedmaster');
  $this->db->where(array('recm_fyear'=> $fiscalyrs,'recm_invoiceno'=>$invoice_no));
  $query = $this->db->get();
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