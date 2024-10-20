<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Challan_mdl extends CI_Model 
{
  public function __construct() 
  {
    parent::__construct();
     $this->chma_masterTable='chma_challanmaster';

    $this->chde_detailTable='chde_challandetails'; 
     }

  public $validate_settings_challan = array( 
     // array('field' => 'itli_materialtypeid', 'label' => 'Material', 'rules' => 'trim|required|xss_clean'),
     //   array('field' => 'itli_catid', 'label' => 'Subcategory ', 'rules' => 'trim|required|xss_clean'),
     //   array('field' => 'itli_challanname', 'label' => 'challan Name ', 'rules' => 'trim|required|xss_clean'),
     //   array('field' => 'itli_challancode', 'label' => 'challan Code ', 'rules' => 'trim|required|xss_clean'),
     //   array('field' => 'itli_rechderlevel', 'label' => 'Record Level ', 'rules' => 'trim|numeric|xss_clean'),
     //   array('field' => 'itli_maxlimit', 'label' => 'Max Limit ', 'rules' => 'trim|numeric|xss_clean'),
     //   array('field' => 'itli_purchaserate', 'label' => 'Purchase Rate ', 'rules' => 'trim|numeric|xss_clean'),
     //   array('field' => 'itli_unitid', 'label' => 'Unit', 'rules' => 'trim|numeric|xss_clean'), 
     //   array('field' => 'itli_typeid', 'label' => 'challan Type', 'rules' => 'trim|required|xss_clean')
  
       ); 

  


  public function chder_save()

  {



    try{

      // $postdata=$this->input->post();

      // echo "<pre>";

      // print_r($postdata);

      // die();
      // $postdata=$this->input->post();

      $receivedate=$this->input->post('chma_receivedatebs');

      

      if(DEFAULT_DATEPICKER=='NP')

      {

        $chderdateNp=$receivedate;

        $chderdateEn=$this->general->NepToEngDateConv($receivedate);

      }

      else

      {

        $chderdateEn=$receivedate;

        $chderdateNp=$this->general->EngToNepDateConv($receivedate);

      }
      $challandate=$this->input->post('chma_suchalandatebs');


      if(DEFAULT_DATEPICKER=='NP')

      {

        $chderdateNp=$challandate;

        $chderdateEn=$this->general->NepToEngDateConv($challandate);

      }

      else

      {

        $chderdateEn=$challandate;

        $chderdateNp=$this->general->EngToNepDateConv($challandate);

      }

    

      $receiveno=$this->input->post('chma_receiveno');

      $supplierid = $this->input->post('chma_supplierid');

      $challanno = $this->input->post('chma_suchallanno');




      $itemid=$this->input->post('chde_itemsid');

      $qty=$this->input->post('chma_qty');

      $code=$this->input->post('chde_code');

      $remarks=$this->input->post('chde_remarks');



      $curtime=$this->general->get_currenttime();

      $userid=$this->session->userdata(USER_ID);

      $mac=$this->general->get_Mac_Address();

      $ip=$this->general->get_real_ipaddr();

      $this->db->trans_begin();



      $chderMasterArray = array(

               
                'chma_receiveno'=>$receiveno,

                'chma_supplierid'=>$supplierid,

                'chma_receivedatebs'=>$receivedate,

                'chma_suchalandatebs'=>$challandate,

                'chma_suchallanno'=>$challanno,


                      'chma_postdatead'=>CURDATE_EN,

                      'chma_postdatebs'=>CURDATE_NP,

                      'chma_posttime'=>$curtime,

                      'chma_postby'=>$userid,

                    'chma_postmac'=>$mac,

                    'chma_postip'=>$ip                      

                      );



      if(!empty($chderMasterArray))

      {

        $this->db->insert('chma_challanmaster',$chderMasterArray);

        $insertid=$this->db->insert_id();

        if($insertid)

        {

        foreach ($itemid as $key => $val) {

        $chderDetail[]=array(

                'chma_challanmasterid'=>$insertid,

             
                'chde_itemid'=> !empty($itemid[$key])?$itemid[$key]:'',

                'chde_qty'=> !empty($qty[$key])?$qty[$key]:'',

                'chde_code'=> !empty($code[$key])?$code[$key]:'',

                'chde_remarks'=> !empty($remarks[$key])?$remarks[$key]:'',

                'chde_postdatead'=>CURDATE_EN,

                      'chde_postdatebs'=>CURDATE_NP,

                      'chde_posttime'=>$curtime,

                      'chde_postby'=>$userid,

                    'chde_postmac'=>$mac,

                    'chde_postip'=>$ip ,

                    'chde_chderdatebs'=>$chderdateEn,

                    'chde_chderdatead'=> $chderdateNp,       

              );

          }

          if(!empty($chderDetail))

          {

            $this->db->insert_batch('chde_challandetails',$chderDetail);



          }



        }

      }

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
               
  
  
  
  




  

  
}