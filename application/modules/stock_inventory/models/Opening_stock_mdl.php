<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Opening_stock_mdl extends CI_Model
{
    public function __construct()
    {
    parent::__construct();
    $this->req_noteTable='reno_requisitionnote';
    $this->req_detailNoteTable='redt_reqdetailnote';
    $this->locationid=$this->session->userdata(LOCATION_ID);
    $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
    $this->orgid=$this->session->userdata(ORG_ID);
    }

    

    public $validate_settings_open_stock = array(
    array('field' => 'storeid', 'label' => 'Store', 'rules' => 'trim|required|xss_clean'),
    array('field' => 'stockopendate', 'label' => 'Opening Date', 'rules' => 'trim|required|xss_clean'),
    array('field' => 'itemid[]', 'label' => 'Item ', 'rules' => 'trim|required|xss_clean'),
    array('field' => 'openstockqty[]', 'label' => 'Opening Stock', 'rules' => 'trim|required|xss_clean|is_natural_no_zero'),
    array('field' => 'purrate[]', 'label' => 'Purchase Rate', 'rules' => 'trim|required|xss_clean'),
    );

    public function opening_stock_save()
    {   //echo "<pre>";print_r($this->input->post());die();
    try{
            $id=$this->input->post('id');
            $stockopendate =$this->input->post('stockopendate');
            if(DEFAULT_DATEPICKER=='NP')
            {
                $stockopendateNp=$stockopendate;
                $stockopendateEn=$this->general->NepToEngDateConv($stockopendate);
            }
            else
            {
                $stockopendateEn=$stockopendate;
                $stockopendateNp=$this->general->EngToNepDateConv($stockopendate);
            }
            $expdateup =$this->input->post('expdateup');
            $expdate =$this->input->post('expdate');
            if(!empty($expdate))
            {
                if(DEFAULT_DATEPICKER=='NP')
                {
                $expdateNp=$expdate;
                $expdateEn=$this->general->NepToEngDateConv($expdateup);
                }
                else
                {
                $expdateEn=$expdate;
                $expdateNp=$this->general->EngToNepDateConv($expdateup);
                }
            }
            else
            {
                $expdateEn='';
                $expdateNp='';
            }

            $storeid =$this->input->post('storeid');
            $itemname =$this->input->post('itemname');
            $itemid =$this->input->post('itemid');
            $purrate =$this->input->post('purrate');
           
            $openstockqty =$this->input->post('openstockqty');
            $description =$this->input->post('description');
            $operator =$this->input->post('operator');
            $remarks =$this->input->post('remarks');
            $opstockyr=$this->input->post('opstockyr');
            $unused_stockqty=$this->input->post('unused_stockqty');

            $curtime=$this->general->get_currenttime();
            $userid=$this->session->userdata(USER_ID);
            $username=$this->session->userdata(USER_NAME);
            $mac=$this->general->get_Mac_Address();
            $ip=$this->general->get_real_ipaddr();
            if($id){
                //echo "<pre>";print_r($this->input->post());die();
                $masteridUp = $this->general->get_tbl_data('trde_trmaid','trde_transactiondetail',array('trde_trdeid'=>$id),'trde_trmaid','ASC');
                //echo $this->db->last_query();die;

                 $unusedstock=!empty($unused_stockqty)?$unused_stockqty:'0';
                $openstockqty=!empty($openstockqty)?$openstockqty:'0';
                $cur_stock=$openstockqty-$unusedstock;

                $updateMaster = array(
                       
                        'trma_fromdepartmentid'=> $storeid,
                        'trma_todepartmentid'=> $storeid,
                        'trma_fromby'=>$userid,
                        'trma_toby'=>$username,
                        'trma_sysdate'=>CURDATE_EN,
                        'trma_fyear'=>$opstockyr,
                        'trma_modifydatead'=>CURDATE_EN,
                        'trma_modifydatebs'=>CURDATE_NP,
                        'trma_modifytime'=>$curtime,
                        'trma_modifyby'=>$userid,
                        'trma_modifyip'=>$ip,
                        'trma_modifymac'=>$mac,
                        'trma_locationid'=>$this->locationid,
                        'trma_orgid'=>$this->orgid
                                  
                    );
                if($updateMaster)
                {
                    $upmasteris = $masteridUp[0]->trde_trmaid;
                    //echo"<pre>"; print_r($updateMaster);die;
                    $this->db->update('trma_transactionmain',$updateMaster, array('trma_trmaid'=>$upmasteris));

                }
                $updateArray = array(
                    'trde_transactiondatead'=> $stockopendateEn,
                    'trde_transactiondatebs'=> $stockopendateNp,
                    'trde_expdatead'=>$expdateEn,
                    'trde_expdatebs'=>$expdateNp,
                    'trde_itemsid'=>$itemid,
                    'trde_requiredqty'=>$openstockqty,
                    'trde_issueqty'=>$cur_stock,
                    'trde_unusedqty'=>$unused_stockqty,
                    'trde_newissueqty'=>$openstockqty,
                    'trde_unitprice'=>$purrate,
                    'trde_selprice'=>$purrate,
                    'trde_description'=>$description,
                    'trde_remarks'=> $remarks,
                    'trde_modifyip'=>$ip,
                    'trde_modifymac'=>$mac,
                    'trde_modifytime'=>$curtime,
                    'trde_modifydatead'=>CURDATE_EN,
                    'trde_modifydatebs'=>CURDATE_NP,
                    'trde_modifyby'=>$userid,
                    'trde_locationid'=>$this->locationid,
                    'trde_orgid'=>$this->orgid

                );
                //echo "<pre>";print_r($updateArray);die();
                if($updateArray)
                {
                    $this->db->update('trde_transactiondetail',$updateArray, array('trde_trdeid'=>$id));
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
            }else{
                $this->db->trans_begin();
                $checkmaster_rec=$this->checkmaster_record($opstockyr,$storeid);
                if($checkmaster_rec)
                {
                    $masterid= $checkmaster_rec->trma_trmaid;
                }
                else
                {
                   $masterid= $this->insert_into_master_table();
                    // $masterid=0;
                }
                foreach ($itemid as $key => $value) {
                     $unusedstock=!empty($unused_stockqty[$key])?$unused_stockqty[$key]:'0';
                        $openstockqty=!empty($openstockqty[$key])?$openstockqty[$key]:'0';
                         $cur_stock=$openstockqty-$unusedstock;
                    $openingStock[] = array(
                       
                       
                                'trde_trmaid'=>$masterid,
                                'trde_transactiondatead'=>$stockopendateEn,
                                'trde_transactiondatebs'=>$stockopendateNp,
                                'trde_itemsid'=>!empty($itemid[$key])?$itemid[$key]:'',
                                'trde_expdatead'=>!empty($expdateEn[$key])?$expdateEn[$key]:'',
                                'trde_expdatebs'=>!empty($expdateNp[$key])?$expdateNp[$key]:'',
                                'trde_transactiontype'=>"OPENING",
                                'trde_status'=>'O',
                                'trde_sysdate'=>CURDATE_EN,
                                'trde_requiredqty'=>!empty($openstockqty[$key])?$openstockqty[$key]:'',
                                'trde_issueqty'=>$cur_stock,
                                'trde_newissueqty'=>!empty($openstockqty[$key])?$openstockqty[$key]:'',
                                'trde_unusedqty'=>$unusedstock,
                                'trde_transtime'=>$curtime,
                                'trde_unitprice'=>!empty($purrate[$key])?$purrate[$key]:'',
                                'trde_selprice'=>!empty($purrate[$key])?$purrate[$key]:'',
                                'trde_remarks'=>!empty($remarks[$key])?$remarks[$key]:'',
                                'trde_description'=>!empty($description[$key])?$description[$key]:'',
                                'trde_postdatebs'=>CURDATE_NP,
                                'trde_postdatead'=>CURDATE_EN,
                                'trde_postip'=>$ip,
                                'trde_postmac'=>$mac,
                                'trde_posttime'=>$curtime,
                                'trde_postby'=>$userid,
                                'trde_locationid'=>$this->locationid,
                                'trde_orgid'=>$this->orgid
                                );
                }
                if(!empty($openingStock))
                {   //echo"<pre>";print_r($openingStock);die;
                    $this->db->insert_batch('trde_transactiondetail',$openingStock);
                }
                foreach ($itemid  as $key => $val) {
                    $itemids = !empty($itemid[$key])?$itemid[$key]:'';
                    $unitprice = !empty($purrate[$key])?$purrate[$key]:'';
                    $this->general->compare_item_price($itemids,$unitprice);
         
                    $this->db->trans_complete();
                    if ($this->db->trans_status() === FALSE){
                        $this->db->trans_rollback();
                        trigger_error("Commit failed");
                        // return false;
                    }
                    else{
                        $this->db->trans_commit();
                        return true;
                    }
                }
            }
        }catch(Exception $e){
            throw $e;
        }
    }
    public function selected_opening_stock($cond =false)
    {    
        $data = array();
        $this->db->select('ec.eqca_category,mtd.trde_description,mtd.trde_remarks,
                        il.itli_itemcode,il.itli_itemname,mtd.trde_itemsid,mtd.trde_controlno,mtd.trde_expdatead,mtd.trde_expdatebs,mtd.trde_unitprice,
                        mtd.trde_requiredqty,mtd.trde_issueqty,(mtd.trde_requiredqty * mtd.trde_unitprice) amount,mtd.trde_transactiondatead,
                        mtd.trde_transactiondatebs,mtd.trde_trdeid,mtd.trde_transtime ,mtm.trma_trmaid,mtm.trma_fyear,mtm.trma_todepartmentid as storeid');
        $this->db->from('trde_transactiondetail mtd');
        $this->db->join('trma_transactionmain mtm','mtm.trma_trmaid=mtd.trde_trmaid','LEFT');
        $this->db->join('itli_itemslist il','il.itli_itemlistid=mtd.trde_itemsid','LEFT');
        $this->db->join('xw_eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid =il.itli_catid ','LEFT');
        $this->db->join('maty_materialtype  mt','mt.maty_materialtypeid=il.itli_materialtypeid','LEFT');
        if($cond)
        {
            $this->db->where($cond);
        }
       
        $query = $this->db->get();
        // echo $this->db->last_query();die();

        if ($query->num_rows() > 0) 
        {
            $data=$query->row();    
            return $data;           
        }
        return false;
    }

    public function get_opening_stock_list($cond = false)
    {
        $eqid=$this->input->get('eqid');
        $opstockyr=$this->input->get('opstockyr');
         if($this->location_ismain=='Y'){
          if(!empty($locationid)){
         $this->db->where('trde_locationid',$locationid);
        }
    }else{
         $this->db->where('trde_locationid',$this->locationid);
    }

        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        

       
        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(itli_itemcode) like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(maty_material) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(eqca_category) like  '%".$get['sSearch_4']."%'  ");
        }
       
          if(!empty($get['sSearch_8'])){
             if(DEFAULT_DATEPICKER=='NP')
             {
            $this->db->where("lower(trde_transactiondatebs) like  '%".$get['sSearch_8']."%'  ");
            }
            else
            {
                $this->db->where("lower(trde_transactiondatead) like  '%".$get['sSearch_8']."%'  "); 
            }
        }
      
        if(!empty($get['sSearch_9'])){
            $this->db->where("lower(trde_transtime) like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("lower(trma_fyear) like  '%".$get['sSearch_10']."%'  ");
        }
        if(!empty($get['sSearch_11'])){
            $this->db->where("lower(trma_remarks) like  '%".$get['sSearch_11']."%'  ");
        }
        if($eqid)
        {
            $this->db->where(array('trma_fromdepartmentid'=>$eqid));
        }
        if($opstockyr)
        {
            $this->db->where(array('trma_fyear'=>$opstockyr));
        }

          if($cond) {
          $this->db->where($cond);
        }
      $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
  

        $this->db->select('COUNT(*) as cnt');
        $this->db->from('trma_transactionmain mtm');
        $this->db->join('trde_transactiondetail mtd','mtd.trde_trmaid=mtm.trma_trmaid','LEFT');
        $this->db->join('itli_itemslist il','il.itli_itemlistid=mtd.trde_itemsid','LEFT');
        $this->db->join('xw_eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid =il.itli_catid ','LEFT');
        $this->db->join('maty_materialtype  mt','mt.maty_materialtypeid=il.itli_materialtypeid','LEFT');
        $this->db->where(array('mtm.trma_transactiontype'=>'OPENING'));

        $resltrpt=$this->db->get()->row();
        //echo $this->db->last_query();die(); 
        $totalfilteredrecs=($resltrpt->cnt); 
        $order_by = 'itli_itemname';
        $order = 'ASC';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
        $where='';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'itli_itemcode';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'itli_itemname';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'maty_material';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'eqca_category';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'trde_unitprice';
            
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'trde_transactiondatebs';
            else if($this->input->get('iSortCol_0')==9)
            $order_by = 'trde_transtime';
        else if($this->input->get('iSortCol_0')==10)
            $order_by = 'trma_fyear';
         else if($this->input->get('iSortCol_0')==11)
            $order_by = 'trma_remarks';
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
            $this->db->where("lower(itli_itemcode) like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(maty_material) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(eqca_category) like  '%".$get['sSearch_4']."%'  ");
        }
       
          if(!empty($get['sSearch_8'])){
             if(DEFAULT_DATEPICKER=='NP')
             {
            $this->db->where("lower(trde_transactiondatebs) like  '%".$get['sSearch_8']."%'  ");
            }
            else
            {
                $this->db->where("lower(trde_transactiondatead) like  '%".$get['sSearch_8']."%'  "); 
            }
        }
      
        if(!empty($get['sSearch_9'])){
            $this->db->where("lower(trde_transtime) like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("lower(trma_fyear) like  '%".$get['sSearch_10']."%'  ");
        }
        if(!empty($get['sSearch_11'])){
            $this->db->where("lower(trma_remarks) like  '%".$get['sSearch_11']."%'  ");
        }
          if($eqid)
        {
            $this->db->where(array('trma_fromdepartmentid'=>$eqid));
        }
        if($opstockyr)
        {
            $this->db->where(array('trma_fyear'=>$opstockyr));
        }

         $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
    if($this->location_ismain=='Y'){
          if(!empty($locationid)){
         $this->db->where('trde_locationid',$locationid);
        }
    }else{
         $this->db->where('trde_locationid',$this->locationid);
    }
    
        if($cond) {
          $this->db->where($cond);
        }
      

        $this->db->select('mtm.trma_trmaid,mt.maty_material,ec.eqca_category,
                        il.itli_itemcode,il.itli_itemname,il.itli_itemnamenp,mtd.trde_itemsid,mtd.trde_controlno,mtd.trde_expdatead,mtd.trde_expdatebs,mtd.trde_unitprice,
                        mtd.trde_requiredqty,mtd.trde_issueqty,(mtd.trde_requiredqty * mtd.trde_unitprice) amount,mtd.trde_transactiondatead,
                        mtd.trde_transactiondatebs,mtd.trde_trdeid,mtm.trma_transactiontype,mtm.trma_todepartmentid,mtm.trma_fyear,mtd.trde_remarks,
                        mtd.trde_transtime,mtm.trma_fromdepartmentid,mtm.trma_remarks,il.itli_locationid,trde_unusedqty');
        $this->db->from('trma_transactionmain mtm');
        $this->db->join('trde_transactiondetail mtd','mtd.trde_trmaid=mtm.trma_trmaid','LEFT');
        $this->db->join('itli_itemslist il','il.itli_itemlistid=mtd.trde_itemsid','LEFT');
        $this->db->join('xw_eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid =il.itli_catid ','LEFT');
        $this->db->join('maty_materialtype  mt','mt.maty_materialtypeid=il.itli_materialtypeid','LEFT');
        $this->db->where(array('mtm.trma_transactiontype'=>'OPENING'));

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

  
 public function checkmaster_record($fyear, $depid = false){
        $data = array();
        $this->db->select('*');
        $this->db->from("trma_transactionmain mtm");
        $this->db->where(array('mtm.trma_transactiontype'=>'OPENING'));
        $this->db->where(array('mtm.trma_fyear'=>$fyear));
        $this->db->where(array('mtm.trma_todepartmentid'=>$depid));

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


    public function insert_into_master_table()
    {
         $stockopendate =$this->input->post('stockopendate');
         $opstockyr=$this->input->post('opstockyr');
            if(DEFAULT_DATEPICKER=='NP')
            {
                $stockopendateNp=$stockopendate;
                $stockopendateEn=$this->general->NepToEngDateConv($stockopendate);
            }
            else
            {
                $stockopendateEn=$stockopendate;
                $stockopendateNp=$this->general->EngToNepDateConv($stockopendate);
            }
            $storeid =$this->input->post('storeid');
            $postdata['trma_transactiondatead']=$stockopendateEn;
            $postdata['trma_transactiondatebs']=$stockopendateNp;
            $postdata['trma_transactiontype']='OPENING';
            $postdata['trma_fromdepartmentid']= $storeid;
            $postdata['trma_todepartmentid']= $storeid;
            $postdata['trma_fromby']=$this->session->userdata(USER_NAME);
            $postdata['trma_toby']=$this->session->userdata(USER_NAME);
            $postdata['trma_issueno']='';
            $postdata['trma_status']='O';
            $postdata['trma_sysdate']=CURDATE_EN;
            $postdata['trma_received']=1;
            $postdata['trma_fyear']=$opstockyr;
            $postdata['trma_sttransfer']='N';
            $postdata['trma_postdatead']=CURDATE_EN;
            $postdata['trma_postdatebs']=CURDATE_NP;
            $postdata['trma_posttime']=$this->general->get_currenttime();
            $postdata['trma_postby']=$this->session->userdata(USER_ID);
            $postdata['trma_postip']=$this->general->get_real_ipaddr();
            $postdata['trma_postmac']=$this->general->get_Mac_Address();
            $postdata['trma_locationid']=$this->locationid;
            $postdata['trma_orgid']=$this->orgid;
        if(!empty($postdata))
        {
            $this->db->insert('trma_transactionmain',$postdata);
            $insertid=$this->db->insert_id();
            if($insertid)
            {
                return $insertid;
            }
            return false;
        }
        return false;

    }

    public function remove_opening_stock()
    {
    $id=$this->input->post('id');
    if($id)
    {
      $this->general->save_log('trde_transactiondetail','trde_trdeid',$id,$postdata=array(),'Delete');
      $this->db->delete('trde_transactiondetail',array('trde_trdeid'=>$id));
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