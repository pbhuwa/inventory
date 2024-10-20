<style>
.showCancel { display: none;}
.showUnapproved { display: none;}
</style>

<?php

$assign_code_access=ACC_CODE_ASSIGN_ACCESS;

$assign_code_access_arr =explode(',', $assign_code_access);

$this->usergroup = $this->session->userdata(USER_GROUPCODE);

$stock_view_group = array('SI','SK','DS','SA');

$store_group = array('SI','SK','SA');

$it_view_group = array('IT');

$approved_status=!empty($requistion_data[0]->rema_approved)?$requistion_data[0]->rema_approved:'';

$postby = !empty($requistion_data[0]->rema_postby)?$requistion_data[0]->rema_postby:'';

$rema_reqmasterid = !empty($requistion_data[0]->rema_reqmasterid)?$requistion_data[0]->rema_reqmasterid:'';

$rema_reqby = !empty($requistion_data[0]->rema_reqby)?$requistion_data[0]->rema_reqby:'';
$rema_reqto = !empty($requistion_data[0]->rema_reqto)?$requistion_data[0]->rema_reqto:'';

$rema_fyear = !empty($requistion_data[0]->rema_fyear)?$requistion_data[0]->rema_fyear:'';

$rema_reqno = !empty($requistion_data[0]->rema_reqno)?$requistion_data[0]->rema_reqno:'';

$rema_locationid = !empty($requistion_data[0]->rema_locationid)?$requistion_data[0]->rema_locationid:'';

$it_recommend_status = !empty($requistion_data[0]->rema_itstatus)?$requistion_data[0]->rema_itstatus:''; 

$item_availability = !empty($requistion_data[0]->rema_itemavailable)?$requistion_data[0]->rema_itemavailable:'';  

$item_avialable_check = !empty($requistion_data[0]->rema_proceedpurchase)?'1':'';  

$rema_received=!empty($requistion_data[0]->rema_received)?$requistion_data[0]->rema_received:'';

$verified_for_issue = !empty($requistion_data[0]->rema_proceedissue)?$requistion_data[0]->rema_proceedissue:''; 

$it_status_readonly = 'readonly="readonly"';

$it_status_disabled = 'disabled="disabled"';

if($it_recommend_status == 1){

  $it_status_readonly = '';

  $it_status_disabled = '';

}

$bhead_data=$this->general->get_tbl_data('*','buhe_bugethead',array('buhe_isactive'=>'Y'));

                            // echo "<pre>";

                            // print_r($bhead);
$req_to_name='';
if(!empty($rema_reqto)){
    $reqto_result=$this->db->select('usma_fullname')->from('usma_usermain')->where_in('usma_userid',$rema_reqto)->get()->result();
    if(!empty($reqto_result)){
        foreach ($reqto_result as $krq => $ruser) {
            $req_to_name .= $ruser->usma_fullname.',';
        }
    }
    $req_to_name =rtrim($req_to_name, ',');
}

?>

<div class="list_c2 label_mw125">

    <div class="form-group row resp_xs">

        <div class="white-box pad-5">

            <div class="row">

                <div class="col-sm-4 col-xs-6">

                    <label><?php echo $this->lang->line('requisition_no'); ?></label>: 

                    <?php echo $reqno= $rema_reqno; ?>

                    <input type="hidden" value="<?php echo $reqno; ?>" id="req_no" >

                </div>

                <div class="col-sm-4 col-xs-6">

                    <label for="example-text"><?php echo $this->lang->line('manual_no'); ?></label>: 

                    <?php echo !empty($requistion_data[0]->rema_manualno)?$requistion_data[0]->rema_manualno:''; ?>

                </div>

                <div class="col-sm-4 col-xs-6">

                    <label for="example-text"><?php echo $this->lang->line('date'); ?></label>: 

                    <span class="inline_block">

                        <?php echo !empty($requistion_data[0]->rema_reqdatebs)?$requistion_data[0]->rema_reqdatebs:''; ?>(BS), <?php echo !empty($requistion_data[0]->rema_reqdatead)?$requistion_data[0]->rema_reqdatead:''; ?>(AD)

                    </span>

                </div>

                <div class="col-sm-4 col-xs-6">

                    <label for="example-text">From</label>: 

                    <?php 

                    $isdep=!empty($requistion_data[0]->rema_isdep)?$requistion_data[0]->rema_isdep:'';

                    if($isdep=='Y')

                    {

                        echo !empty($requistion_data[0]->fromdepname)?$requistion_data[0]->fromdepname:'';

                    }

                    else

                    {

                        echo !empty($requistion_data[0]->fromdep_transfer)?$requistion_data[0]->fromdep_transfer:'';

                    }

                    ?>

                </div>

                <div class="col-sm-4 col-xs-6">

                    <label for="example-text">Requested To </label> : 

                    <?php 

                    echo $req_to_name;

                    ?>

                </div>

                <div class="col-sm-4 col-xs-6">

                    <label for="example-text"><?php echo $this->lang->line('requisited_by'); ?> </label>: 

                    <?php 

                    $reqby=$rema_reqby;

                    echo $reqby;

                    ?>

                </div>

                <div class="col-sm-4 col-xs-6">

                    <label for="example-text"><?php echo $this->lang->line('work_description'); ?> </label>:

                    <?php 

                    $work_description=!empty($requistion_data[0]->rema_workdesc)?$requistion_data[0]->rema_workdesc:'';

                    echo $work_description;

                    ?>

                </div>

                <div class="col-sm-4 col-xs-6">

                    <label for="example-text"><?php echo $this->lang->line('work_place'); ?> </label>:

                    <?php 

                    $workplace=!empty($requistion_data[0]->rema_workplace)?$requistion_data[0]->rema_workplace:'';

                    echo $workplace;

                    ?>

                </div>

                <div class="col-sm-4 col-xs-6">

                    <label for="example-text"><?php echo $this->lang->line('full_remarks'); ?> </label>:

                    <?php 

                    $work_remask=!empty($requistion_data[0]->rema_remarks)?$requistion_data[0]->rema_remarks:'';

                    echo $work_remask;

                    ?>

                </div>

                <div class="col-sm-4 col-xs-6">

                    <label for="example-text"><?php echo $this->lang->line('status'); ?> </label>: 

                    <?php               

                    if($approved_status==1)

                    {

                        echo "<span class='approved badge badge-sm badge-success'>Approved</span>"; 

                    }

                    else if($approved_status==2)

                    {

                        echo "<span class='n_approved badge badge-sm badge-info'>Unapproved</span>";

                    }

                    else if($approved_status==3)

                    {

                        echo "<span class='cancel badge badge-sm badge-danger'>Canceled</span>";

                    }

                    else if($approved_status==4)

                    {

                        echo "<span class='cancel badge badge-sm badge-success'>Verified</span>";

                    }

                    else

                    {

                        echo "<span class='pending badge badge-sm badge-warning'>Pending</span>";

                    }

                    ?>

                </div> 

                <div class="col-sm-4 col-xs-6">

                    <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?></label>

                    <?php 

                    $fyear=$rema_fyear;

                    echo $fyear;

                    ?>

                    <input type="hidden" id="fyear" value="<?php echo $fyear; ?>">

                </div>

                <div class="col-sm-4 col-xs-6">

                    <label for="example-text"><?php echo $this->lang->line('location'); ?> </label>:

                    <?php 

                    $loca_name=!empty($requistion_data[0]->locationname)?$requistion_data[0]->locationname:'';

                    echo $loca_name;

                    ?>

                </div>

                <div class="col-sm-4 col-xs-6">

                    <label for="example-text"><?php echo $this->lang->line('item_remarks'); ?> </label>:

                    <?php 

                    if(!empty($mat_type)){

                        foreach ($mat_type as $km => $mat){

                            if($this->usergroup == 'BM'){

                                $req_detail_list = $this->stock_requisition_mdl->get_requisition_details_data(array('rd.rede_reqmasterid'=>$rede_reqmasterid,'rd.rede_isdelete'=>'N','it.itli_materialtypeid'=>$mat->maty_materialtypeid,'rd.rede_proceedissue'=>'Y'));

                            }else{

                                $req_detail_list = $this->stock_requisition_mdl->get_requisition_details_data(array('rd.rede_reqmasterid'=>$rede_reqmasterid,'rd.rede_isdelete'=>'N','it.itli_materialtypeid'=>$mat->maty_materialtypeid));

                            }

                            if(!empty($stock_requisition))

                            {

                                $remarks='';

                                foreach ($stock_requisition as $km => $det) {

                                    $remarks.=$det->rede_remarks.' , ';   

                                }

                                echo $remarks;

                            }

                        }

                    }

                    ?>

                </div>
                 <div class="btn-group pull-right">

            <?php

                if(ORGANIZATION_NAME == 'KUKL'):

            ?>

            <button class="btn btn-info" id="btnHistory" data-actionurl="<?php echo base_url('/issue_consumption/stock_requisition/stock_requisition_reprint') ?>" data-id="<?php echo $rede_reqmasterid; ?>" data-reqno="<?php echo $rema_reqno;?>" data-fyear="<?php echo $rema_fyear ?>" data-heading="History">

               History

            </button>

            <?php

                endif;

            ?>

        </div>

            </div>

        </div>

        <div class="clearfix"></div> 

        <?php

        if(in_array($this->usergroup, $store_group)):

            ?>
            <?php if($approved_status!=3 && $approved_status!=2 ): ?>
            <div>

                <a href="javascript:void(0)" class="btnSelectNotAvailable btn btn-xs btn-danger">Select Unavailable Stock</a>

                <a href="javascript:void(0)" class="btnSelectAvailable btn btn-xs btn-success">Select Available Stock</a>

                <a href="javascript:void(0)" class="btnSelectAll btn btn-xs btn-warning">Select All For Purchase</a>

            </div>

            <?php
                endif;
        endif;

        ?>

        <?php
        // echo "<pre>";
        // print_r($mat_type);
        // die();

        if(!empty($mat_type)):

            ?>

            <table style="width:100%;" class="table dataTable con_ttl dt_alt purs_table">

                <thead>

                    <tr>

                        <?php

                        if(in_array($this->usergroup, $stock_view_group)):

                            ?>

                            <!-- <th width="2%"><input type="checkbox" class="checkall"><?php echo $this->lang->line('all'); ?> </th> -->

                            <th width="2%"></th>

                            <?php

                        endif;

                        ?>

                        <th width="5%"><?php echo $this->lang->line('sn'); ?> </th>

                        <th width="8%"><?php echo $this->lang->line('item_code'); ?>   </th>

                        <th width="15%"><?php echo $this->lang->line('item_name'); ?>   </th>

                        <?php if(in_array($this->usergroup, $assign_code_access_arr)): ?>

                         <th width="20%">Acc. Code</th>

                     <?php endif; ?>
                     <?php

                        if(in_array($this->usergroup, $store_group)):

                        ?>
                        <th width="10">Acc. Code </th>
                    <?php endif; ?>

                     <th width="5%"><?php echo $this->lang->line('unit'); ?>   </th>

                     <th width="5%"><?php echo $this->lang->line('demand_quantity'); ?>   </th>

                     <th width="5%">
                           Rem. Demand Qty. 
                        <?php //echo $this->lang->line('rem_qty'); ?>  </th>

                     <?php

                        //show stock quantity only to store incharge

                     if(in_array($this->usergroup, $stock_view_group)):

                        ?>

                        <th width="5%"><?php echo $this->lang->line('current_stock'); ?> </th>

                        <?php

                    endif;

                    ?>

                    <?php

                        // option for branch manager to recommend qty

                    if($this->usergroup == 'DS'):

                        ?>

                        <th width="5%"><?php echo $this->lang->line('recommend_qty'); ?> </th>

                        <?php

                    endif;

                    ?>

                    <th width="5%"><?php echo $this->lang->line('rate'); ?> </th>

                    <th width="5%"><?php echo $this->lang->line('total_amount'); ?> </th>
                    
                    <?php

                    if($this->usergroup == 'AO'):

                        ?>

                        <th width="5%"><?php echo $this->lang->line('estimated_total_amount'); ?> </th>
                        
                        <th width="5%"><?php echo $this->lang->line('available_budget'); ?> </th>

                        <th width="5%"><?php echo $this->lang->line('budget_status'); ?> </th>

                        <?php

                    endif;

                    ?>

                    <?php

                    if(in_array($this->usergroup, $it_view_group)):

                        ?>

                        <th width="10%"><?php echo $this->lang->line('it_recommend'); ?></th>

                        <th width="10%"><?php echo $this->lang->line('it_remarks'); ?></th>

                        <?php

                    endif;

                    ?>

                    <!--  <th width="5%"><?php// echo $this->lang->line('remarks'); ?></th> -->

                </tr>

            </thead>

            <?php

            $i = 1;
            $mattype_cnt=0;
            foreach ($mat_type as $km => $mat):

                // $this->db->select('DISTINCT(itli_catid) as catid,ec.eqca_code,ec.eqca_category');

                // $this->db->from('itli_itemslist il');

                // $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=il.itli_catid','LEFT');

                // $this->db->where(array('itli_materialtypeid'=>$mat->maty_materialtypeid));
                // // $this->db->where('itli_catid is NOT NULL', NULL, false);

                // $this->db->order_by('ec.eqca_category','ASC');

                // $cat_type_result=$this->db->get()->result();

                $this->db->select('acty_id as catid, acty_accode as eqca_code, acty_acname as eqca_category');
                $this->db->from('acty_accounttype');
                $this->db->order_by('acty_acname','ASC');
                // if (!empty($bhead_data)) {
                //     $bhead_id = $bhead_data[0]->buhe_bugetheadid;
                //     $this->db->where('acty_catid',$bhead_id);
                // }
                $cat_type_result = $this->db->get()->result(); 
                    // echo $this->db->last_query();
                    // die();

                if($this->usergroup == 'BM'){

                    $req_detail_list = $this->stock_requisition_mdl->get_requisition_details_data(array('rd.rede_reqmasterid'=>$rede_reqmasterid,'rd.rede_isdelete'=>'N','it.itli_materialtypeid'=>$mat->maty_materialtypeid));

                }else if($this->usergroup == 'IT'){

                    $req_detail_list = $this->stock_requisition_mdl->get_requisition_details_data(array('rd.rede_reqmasterid'=>$rede_reqmasterid,'it.itli_materialtypeid'=>$mat->maty_materialtypeid, 'rd.rede_isdelete' => 'N', 'ec.eqca_isitdep'=>'Y'));

                }

                else{

                    $req_detail_list = $this->stock_requisition_mdl->get_requisition_details_data(array('rd.rede_reqmasterid'=>$rede_reqmasterid,'rd.rede_isdelete'=>'N','it.itli_materialtypeid'=>$mat->maty_materialtypeid));

                }

                if(!empty($req_detail_list)):
                    if($mat->maty_materialtypeid==3){
                        $mattype_cnt=1;
                    }

                    ?>

                    <tbody>

                        <tr>

                            <td colspan="3">

                                <strong><?php echo $mat->maty_material; ?></strong>

                            </td>

                            <td>

                                <?php if(in_array($this->usergroup, $assign_code_access_arr)): ?>

                                    <select name="" class="form-control bcheckall" id="cat_id_all" width="120px" data-id="cat_id">

                                        <option value="">--select--</option>

                                        <?php 

                                        if(!empty($cat_type_result)): 

                                            foreach($cat_type_result as $ctype):

                                                ?>

                                                <option value="<?php echo $ctype->catid; ?>"><?php echo "$ctype->eqca_code - $ctype->eqca_category"; ?></option>

                                                <?php

                                            endforeach;

                                        endif; ?>

                                    </select>

                                    <select name=""  class="form-control bcheckall"  id="bhead_id_all"width="120px" data-id="bhead">

                                        <option value="">--select--</option>

                                        <?php 

                                        if(!empty($bhead_data)): 

                                            foreach($bhead_data as $bh):

                                                ?>

                                                <option value="<?php echo $bh->buhe_bugetheadid; ?>"><?php echo $bh->buhe_headtitle; ?></option>

                                                <?php

                                            endforeach;

                                        endif; ?>

                                    </select>

                                <?php endif; ?>

                            </td>

                            <td colspan="5">

                            </td>

                        </tr>

                        <?php 

                        $j = 1;

                    // echo "<pre>";

                    // print_r($req_detail_list);

                    // die();

                        foreach ($req_detail_list as $key => $value) { ?>

                            <tr class="orderrow <?php 

                            if($this->usergroup == 'SI' || $this->usergroup == 'SK')

                            { 

                                // if($value->cur_stock_qty == 0)

                                // {

                                //    echo "danger";

                                // }else{

                                //    echo "warning"; 

                                // }

                                if($value->cur_stock_qty <= '0.00'):

                                echo "danger";

                                // elseif($value->rede_remqty > $value->cur_stock_qty):

                                //     echo "danger";

                                elseif($value->rede_remqty <= $value->cur_stock_qty):

                                echo "";

                                else:

                                echo "";

                                endif;

                            } ?>">

                            <?php

                            if(in_array($this->usergroup, $stock_view_group)):

                                ?>

                                <td> 

                                    <?php

                                    if($value->cur_stock_qty <= '0.00'):

                                        // $stock_class = 'stockzero';

                                        $stock_class = 'stocknotavailable';

                                    // elseif($value->rede_remqty > $value->cur_stock_qty):

                                    //     $stock_class = 'stocknotavailable';

                                    elseif($value->rede_remqty > $value->cur_stock_qty):

                                        $stock_class = 'stockavailable';

                                    elseif($value->rede_remqty <= $value->cur_stock_qty):

                                        $stock_class = 'stockavailable';

                                    else:

                                        $stock_class = '';

                                    endif;

                                    ?>

                                    <?php

                                    if($value->rede_proceedpurchase == 'Y' && $stock_class == 'stockavailable'):

                                        $item_avail_class = 'itemAvailableAfter';

                                    elseif($value->rede_proceedpurchase != 'Y' && $stock_class == 'stockavailable'):

                                        $item_avail_class = 'itemAvailableBefore';

                                    else:

                                        $item_avail_class = '';

                                    endif;

                                    ?>

                                    <?php

                                    $stk_qty = $value->cur_stock_qty;

                                    $req_qty = $value->rede_remqty;

                                    if($req_qty > $stk_qty){

                                        $my_rem_qty = $req_qty - $stk_qty;    

                                    }else{

                                        $my_rem_qty = 0;

                                    }

                                    ?>

                                    <?php 

                                    // echo $value->rede_proceedissue;

                                    // echo  $value->rede_proceedpurchase;

                                    // echo $value->rede_proceedtype;

                                    if($this->usergroup != 'DS' && in_array($this->usergroup, $store_group) == false):

                                        if(($value->rede_proceedissue != 'Y' && $value->rede_proceedpurchase != 'Y') || $value->rede_proceedtype != 'C'):

                                        // if($value->rede_proceedtype == 'C' || empty($value->rede_proceedtype)):

                                            ?>

                                            <input type="checkbox" name="itemsid[]" value="<?php echo $value->rede_itemsid; ?>" class="itemcheck <?php echo $stock_class; ?> <?php echo $item_avail_class; ?>" data-itemcode="<?php echo $value->itli_itemcode ?>" data-itemname="<?php echo $value->itli_itemname ?>" data-itemstypeid="<?php echo $mat->maty_materialtypeid ?>" data-unitname="<?php echo $value->unit_unitname ?>" data-qty="<?php echo $value->rede_qty ?>" data-remqty="<?php echo $value->rede_remqty ?>" data-unitprice="<?php echo $value->itli_purchaserate ?>" 

                                            data-stockqty="<?php echo $value->cur_stock_qty; ?>"

                                            data-totalamt="<?php echo $value->rede_totalamt; ?>" data-reqdetailid = "<?php echo $value->rede_reqdetailid;?>" data-my_rem_qty="<?php echo $my_rem_qty; ?>" data-proceedpurchase="<?php echo $value->rede_proceedpurchase; ?>" />

                                            <?php 

                                        else:

                                            echo $value->rede_proceedtype;

                                        endif;

                                    elseif(in_array($this->usergroup, $store_group)):

                                        // if($value->rede_proceedissue != 'Y'):

                                        ?>

                                        <input type="checkbox" name="itemsid[]" value="<?php echo $value->rede_itemsid; ?>" class="itemcheck <?php echo $stock_class; ?> <?php echo $item_avail_class; ?>" data-itemcode="<?php echo $value->itli_itemcode ?>" data-itemname="<?php echo $value->itli_itemname ?>" data-itemstypeid="<?php echo $mat->maty_materialtypeid ?>" data-unitname="<?php echo $value->unit_unitname ?>" data-qty="<?php echo $value->rede_qty ?>" data-remqty="<?php echo $value->rede_remqty ?>" data-unitprice="<?php echo $value->itli_purchaserate; ?>" 

                                        data-stockqty="<?php echo $value->cur_stock_qty; ?>"

                                        data-totalamt="<?php echo $value->rede_totalamt; ?>" data-reqdetailid = "<?php echo $value->rede_reqdetailid;?>" data-my_rem_qty="<?php echo $my_rem_qty; ?>" data-proceedpurchase="<?php echo $value->rede_proceedpurchase; ?>"/>

                                        <?php

                                        // endif;

                                    endif;

                                    ?>

                                </td>

                                <?php

                            endif;

                            ?>

                            <td><?php echo $key+1; ?></td>

                            <?php if($value->itli_materialtypeid==3){?>

                                <td> 

                                    <?php 

                                    if(in_array($this->usergroup, $store_group)):

                                        ?>

                                        <a href="javascript:void(0)" data-id='<?php echo  $value->rede_reqdetailid ?>' data-displaydiv="ItemDetails" data-viewurl="<?php echo base_url('issue_consumption/stock_requisition/add_item_code'); ?>" title="Add Code" class="view btn-primary btn-xxs" data-heading="Enter Item code if demanded item is identified">

                                            <i class="fa fa-plus" aria-hidden="true" ></i>

                                        </a>

                                        <?php 

                                    endif; 

                                    ?>

                                </td>

                                <td>

                                    <?php echo $value->itli_itemname.'('.$value->rede_remarks.')' ?>

                                </td>

                            <?php  }else{ ?>

                                <td><?php echo $value->itli_itemcode ?>

                                <input type="hidden" value="<?php echo $value->rede_itemsid; ?>" name="items_id[]" class="items_id" />   

                            </td>

                            <td><?php echo $value->itli_itemname ?></td>

                        <?php } ?>

                        <?php 

                        ?>

                        <?php if(in_array($this->usergroup, $assign_code_access_arr)): ?>

                            <td>

                                <?php

                                $save_cat_id=!empty($value->rede_catid)?$value->rede_catid:'';

                                  // echo $save_cat_id; 

                                if(!empty($save_cat_id)){

                                    $disabled_catid="disabled=disabled";

                                }else{

                                    $disabled_catid="";

                                }

                                ?>

                                <select name="cat_id[]" data-reqdetailid="<?php echo $value->rede_reqdetailid; ?>" id="cat_id_<?php echo $key+1; ?>"  class="form-control bcheck" width="120px" data-id="<?php echo $key+1; ?>" <?php echo $disabled_catid; ?>>

                                    <option value="">--select--</option>

                                    <?php 

                                    if(!empty($cat_type_result)): 

                                        foreach($cat_type_result as $ctype):

                                            ?>

                                            <option value="<?php echo $ctype->catid; ?>" <?php if($save_cat_id==$ctype->catid) echo "selected=selected"; ?> ><?php echo "$ctype->eqca_code - $ctype->eqca_category"; ?></option>

                                            <?php

                                        endforeach;

                                    endif; ?>

                                </select>

                                <?php $save_budgethead=!empty($value->rede_budgetheadid)?$value->rede_budgetheadid:''; 

                                if(!empty($save_budgethead)){

                                    $disabled_buhead="disabled=disabled";

                                }else{

                                    $disabled_buhead="";

                                }

                                ?>

                                <select name="bhead[]" data-reqdetailid="<?php echo $value->rede_reqdetailid; ?>" id="bhead_<?php echo $key+1; ?>" class="form-control bcheck" width="120px" data-id="<?php echo $key+1; ?>" <?php echo  $disabled_buhead; ?>>

                                    <option value="">--select--</option>

                                    <?php 

                                    if(!empty($bhead_data)): 

                                        foreach($bhead_data as $bh):

                                            ?>

                                            <option value="<?php echo $bh->buhe_bugetheadid; ?>" <?php if($save_budgethead==$bh->buhe_bugetheadid) echo "selected=selected"; ?> ><?php echo $bh->buhe_headtitle; ?></option>

                                            <?php

                                        endforeach;

                                    endif; ?>

                                </select>

                                <input type="hidden" name="isisbug_avl[]" id="isisbug_avl_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>">
                                <input type="hidden" name="api_expense_id[]" id="api_expense_id_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>">

                                <span id="savediv_<?php echo $key+1; ?>" >

                                    <?php 

                                    if($save_budgethead && $save_cat_id ): 

                                        echo '<span class="badge badge-sm badge-success">Saved</span>';

                                    else:

                                        ?>

                                        <a href="javascript:void(0)" data-reqdetailid="<?php echo $value->rede_reqdetailid; ?>" class="btn btn-sm btn-success btnsave_buget" title="Click here for Save" id="btnsave<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>"><i class="fa fa-save"></i></a>

                                    <?php endif; ?>

                                </span>

                            </td>

                        <?php endif; ?>
                        <?php

                        if(in_array($this->usergroup, $store_group)):

                        ?>
                        <td>
                     <?php

                                $save_cat_id=!empty($value->rede_catid)?$value->rede_catid:'';

                                  // echo $save_cat_id; 

                                // if(!empty($save_cat_id)){

                                //     $disabled_catid="disabled=disabled";

                                // }else{

                                    $disabled_issue_catid="";

                                // }

                                ?>

                                <select name="issue_cat_id[]" data-reqdetailid="<?php echo $value->rede_reqdetailid; ?>" id="issue_cat_id_<?php echo $value->rede_itemsid; ?>"  class="form-control" width="120px" data-id="<?php echo $key+1; ?>" <?php echo $disabled_issue_catid; ?>>

                                    <option value="">--select--</option>

                                    <?php 

                                    if(!empty($cat_type_result)): 

                                        foreach($cat_type_result as $ctype):

                                            ?>

                                            <option value="<?php echo $ctype->catid; ?>" <?php if($save_cat_id==$ctype->catid) echo "selected=selected"; ?> ><?php echo "$ctype->eqca_code - $ctype->eqca_category"; ?></option>

                                            <?php

                                        endforeach;

                                    endif; ?>

                                </select>

                                <?php $save_budgethead=!empty($value->rede_budgetheadid)?$value->rede_budgetheadid:''; 

                                // if(!empty($save_budgethead)){

                                //     $disabled_buhead="disabled=disabled";

                                // }else{

                                    $disabled_issue_buhead="";

                                // }

                                ?>

                                <select name="issue_bhead[]" data-reqdetailid="<?php echo $value->rede_reqdetailid; ?>" id="issue_bhead_<?php echo $value->rede_itemsid; ?>" class="form-control" width="120px" data-id="<?php echo $key+1; ?>" <?php echo  $disabled_issue_buhead; ?>>

                                    <option value="">--select--</option>

                                    <?php 

                                    if(!empty($bhead_data)): 

                                        foreach($bhead_data as $bh):

                                            ?>

                                            <option value="<?php echo $bh->buhe_bugetheadid; ?>" <?php if($save_budgethead==$bh->buhe_bugetheadid) echo "selected=selected"; ?> ><?php echo $bh->buhe_headtitle; ?></option>

                                            <?php

                                        endforeach;

                                    endif; ?>

                                </select>
                            </td>
                    
                <?php endif; ?>

                        <td><?php echo $value->unit_unitname ?></td>

                        <td><?php echo sprintf('%g',$value->rede_qty);  ?></td>

                        <td>

                            <?php echo  sprintf('%g',$value->rede_remqty); ?>

                        </td>

                        <?php

                        if(in_array($this->usergroup, $stock_view_group)):

                            ?>

                            <td><?php echo sprintf('%g',$value->cur_stock_qty);  ?></td>

                            <?php

                        endif;

                        ?>

                        <?php

                        if($this->usergroup == 'DS'):

                            ?>

                            <td>

                                <?php

                                $readonly = '';

                                if(!empty($value->rede_recommendqty) || !empty($approved_status)):

                                    $readonly = 'readonly';

                            endif;

                            $remqty=!empty($value->rede_recommendqty)?$value->rede_recommendqty:$value->rede_remqty; 
                            ?>
                            
                            <input type="text" name="recommend_qty[]" class="form-control float recommend_qty arrow_keypress" data-fieldid="recommend_qty" id="recommend_qty_<?php echo $key+1;?>" data-id="" value="<?php echo sprintf('%g',$remqty); ?>" <?php echo $readonly; ?> />

                        </td>

                        <?php

                    endif;

                    ?>

                    <td><?php echo number_format($value->rede_unitprice,2) ?></td>

                    <td><?php echo number_format($value->rede_totalamt,2) ?></td>

                    <?php

                    if($this->usergroup == 'AO'):

                        ?>

                        <td><?php echo number_format($value->total_estimate_amount,2) ?></td>
                        <td><span id="budget_amount_<?php echo $key + 1;?>"><?php echo number_format($value->budg_availableamt,2) ?></span></td>

                        <td>

                                <?php /*

                                if($value->budget_status == 'Y'):

                                ?>

                                    <span class="badge badge-sm badge-success">Available</span>

                                <?php

                                else:

                                ?>

                                    <span class="badge badge-sm badge-danger">Not Available</span>

                                <?php endif; */?>

                                <div id="budget_status_<?php echo $key+1;?>">

                                    <?php 

                                    $isavlbuget= !empty($value->rede_isbudgetavl)?$value->rede_isbudgetavl:'N';

                                    if($isavlbuget=='Y'){

                                        echo '<span class="badge badge-sm badge-success">Available</span>';

                                    } else if(!empty($save_cat_id) && !empty($save_budgethead) && $isavlbuget=='N'){

                                        echo '<span class="badge badge-sm badge-danger">Not Available</span>';

                                    }else{

                                        echo "";

                                    }

                                    ?>

                                </div>

                            </td>

                            <?php

                        endif;

                        ?>

                        <?php

                        if(in_array($this->usergroup, $it_view_group)):

                            ?>

                            <td>

                                <input type="radio" name="rede_itrecommend_<?php echo $i.'_'.$j;?>" class="rede_itrecommend" value="1" <?php echo ($value->rede_itrecommend == '1')?"checked":""; ?> <?php echo $it_status_disabled; ?> /><?php echo $this->lang->line('recommend'); ?> <br/>

                                <input type="radio" name="rede_itrecommend_<?php echo $i.'_'.$j;?>" class="rede_itrecommend" value="2" <?php echo ($value->rede_itrecommend == '2')?"checked":""; ?> <?php echo $it_status_disabled; ?> /><?php echo $this->lang->line('not_recommend'); ?> <br/>

                                <input type = "radio" name="rede_itrecommend_<?php echo $i.'_'.$j;?>" class="rede_itrecommend" value="3" <?php echo ($value->rede_itrecommend == '3')?"checked":""; ?> <?php echo $it_status_disabled; ?> /> <?php echo $this->lang->line('partial'); ?>

                            </td>

                            <td>

                                <input type="text" name="rede_itcomment" class="form-control rede_itcomment" value="<?php echo $value->rede_itcomment; ?>" <?php echo $it_status_readonly; ?> />

                            </td>

                            <?php

                        endif;

                        ?>

                        <!--  <td align="right"><?php echo $value->rede_remarks ?></td> -->

                    </tr>

                    <?php 

                    $j++;

                } 

                ?>

                <tr>

                    <td colspan="3"></td>

                    <td>

                     <?php if(in_array($this->usergroup, $assign_code_access_arr)): ?>

                        <a href="javascript:void(0)" class="btn btn-sm btn-success btn_save_all_acc">Save All</a> 

                    <?php endif; ?>

                </td>

                <td colspan="7"></td>

            </tr>

        </tbody>

        <?php

    endif;

    $i++;

endforeach;

endif;

?>

<?php

$handover_cur_status = !empty($handover_status[0]->harm_currentstatus)?$handover_status[0]->harm_currentstatus:'';

$rema_proceedpurchase_status = !empty($requistion_data[0]->rema_proceedpurchase)?$requistion_data[0]->rema_proceedpurchase:'';

if($handover_cur_status == 'R'){

    $handover_message = "Your request to central office has been rejected.";

    $text_class = "text-danger";

}else if($handover_cur_status == 'A'){

    $handover_message = "Your Request to central office has been accepted.";

    $text_class = "text-success";

}else{

    $handover_message = "";

    $text_class = "";

}

?>

<?php

if($rema_received != '1'):

    ?>

    <tfoot>

        <tr id="processdiv" style="display: none;">

            <td colspan="12">

                <div class="">

                    <?php

                    if($handover_cur_status == 'R' && $rema_proceedpurchase_status != 'Y'):

                        ?>

                        <a href="javascript:void(0)" class="btn btn-sm btn-danger process_procurement" id="">Process To Procurement</a>

                        <?php     

                            elseif($rema_proceedpurchase_status != 'Y'): // else handover cur status

                            $central_request_status=!empty($requistion_data[0]->rema_centralrequest)?$requistion_data[0]->rema_centralrequest:'';

                            $locationid=!empty($requistion_data[0]->rema_locationid)?$requistion_data[0]->rema_locationid:'';

                            if($central_request_status != 'Y' ){

                                ?>

                                <?php  

                                if( $this->location_ismain!='Y'){ ?>

                                    <a href="javascript:void(0)" class="btn btn-sm btn-info" id="central_request">Request To Central Office </a>

                                    <?php  

                                } 

                                ?>

                                <!--        <a href="javascript:void(0)" class="btn btn-sm btn-danger process_procurement" id="" data-proctype="D">Process To Procurement</a> -->

                                <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="btnOtherStock" data-heading="Other Branch Stock">Other Branch Stock</a>

                                <?php

                            }

                            ?>

                            <?php

                            endif;  // endif handover cur status 

                            ?>

                            <?php

                            $total_count = $items_count[0]->ttl_count;

                            $purchase_count = $items_count[0]->proceed_pur_count;

                            if($purchase_count < $total_count){

                                ?>

                                <a href="javascript:void(0)" class="btn btn-sm btn-danger process_procurement" id="" data-proctype="D">Process To Procurement</a>

                                <?php

                            }

                            ?>

                        </div>

                    </td>

                </tr>

                <?php

                $proceed_issue_id = !empty($requistion_data[0]->rema_proceedissue)?$requistion_data[0]->rema_proceedissue:'';

                ?>

                <?php

                // echo $proceed_issue_id;

                // if($proceed_issue_id != "2" && $proceed_issue_id != '1'):

                // get number of issue items

                $items_to_issue = $this->general->get_count_data('rede_proceedissue','rede_reqdetail',array('rede_reqmasterid'=>$rema_reqmasterid, 'rede_proceedissue'=>'Y'));

                // if(($items_to_issue != 0) || ($proceed_issue_id != "2" && $proceed_issue_id != '1')): 

                // echo $item_avialable_check;

                if($item_availability != '2'):

                    ?>

         <!--    <tr id="processIssueDiv" style="display: none;">

                <td colspan="12">

                    <div class="">

                        <a href="javascript:void(0)" class="btn btn-sm btn-success" id="proceed_to_issue">Verify Issue with Branch Manager</a>

                    </div>

                </td>

            </tr> -->

            <tr id="processIssueDiv" style="display: none;">

                <td colspan="12">

                    <div class="mbtm_10">

                        <div>

                            <a href="javascript:void(0)" class="btnSelectAvailableAfter btn btn-xs btn-info">Select Available Stock After Purchase</a>

                            <a href="javascript:void(0)" class="btnSelectAvailableBefore btn btn-xs btn-primary">Select Available Stock Before Purchase</a>

                        </div>

                        <br/>
                         <?php 
                        $issue_date = DISPLAY_DATE;
                        ?>
                        <div class="stock_available_before_procurement" style="display: none;">
                            <?php if($proceed_issue_id == "2"): ?>
                                <div class="d-flex dis_tab" style=" align-items: center;
                            justify-content: start;">
                                <div class="col-md-3">
                                <label for="issue_datebs_direct">Issue Date:</label> 
                                <input type="text" name="issue_date" id="issue_datebs_direct" class="form-control <?php echo DATEPICKER_CLASS;?>" maxlength="10" value="<?php echo $issue_date; ?>">
                                </div>
                                <div class="col-md-3">
                                <label>Category:</label> 
                                <select name="issue_bcat" id="issue_bcat_direct" class="form-control">
                                    <option value="">--select--</option>
                                    <?php 
                                    if(!empty($cat_type_result)): 
                                        foreach($cat_type_result as $ctype):
                                            ?>
                                            <option value="<?php echo $ctype->catid; ?>"><?php echo "$ctype->eqca_code - $ctype->eqca_category"; ?></option>
                                            <?php
                                        endforeach;
                                    endif; ?>
                                </select>
                                </div>
                                <div class="col-md-3">
                                <label>Head:</label> 
                                <select name="issue_bhead" id="issue_bhead_direct" class="form-control">
                                    <option value="">--select--</option>
                                    <?php 
                                    if(!empty($bhead_data)): 
                                        foreach($bhead_data as $bh):
                                            ?>
                                            <option value="<?php echo $bh->buhe_bugetheadid; ?>"><?php echo $bh->buhe_headtitle; ?></option>
                                            <?php
                                        endforeach;
                                    endif; ?>
                                </select>
                                </div>
                                <a href="javascript:void(0)" class="btn btn-sm btn-success" id="proceed_to_issue_items" data-type="direct">Issue</a>
                                </div>
                           
                            <?php elseif($proceed_issue_id == "3") :?>
                             <div class="">
                                <span class="text-danger">Issue Cancelled By Branch Manager</span>
                            </div>
                            <?php elseif($proceed_issue_id == "1" || empty($proceed_issue_id)) :?>
                             <div class="">
                                <span class="text-danger">Verify Issue with Branch Manager</span>
                            </div>
                            <?php endif;?>

                        </div>

                        <div class="stock_available_after_procurement" style="display: none;">

                            <a href="javascript:void(0)" class="btn btn-sm btn-success" id="inform_item_available">Inform</a>

                        </div>

                    </div>

                </td>

            </tr>

            <tr id="issueDiv" style="display:none" >
               
                <td colspan="12">
                    <?php if($proceed_issue_id == "2"): ?>
                        <div class="mbtm_10 d-flex dis_tab" style=" align-items: center;
                        justify-content: start;">
                        <div class="col-md-3">
                        <label for="issue_datebs">Issue Date:</label> 
                        <input type="text" name="issue_date" id="issue_datebs" class="form-control <?php echo DATEPICKER_CLASS;?>" value="<?php echo $issue_date; ?>" maxlength="10">
                        </div>
                        <div class="col-md-3">
                        <label>Category:</label> 
                        <select name="issue_bcat" id="issue_bcat" class="form-control">
                            <option value="">--select--</option>
                            <?php 
                            if(!empty($cat_type_result)): 
                                foreach($cat_type_result as $ctype):
                                    ?>
                                    <option value="<?php echo $ctype->catid; ?>"><?php echo "$ctype->eqca_code - $ctype->eqca_category"; ?></option>
                                    <?php
                                endforeach;
                            endif; ?>
                        </select>
                        </div>
                        <div class="col-md-3">
                        <label>Head:</label> 
                        <select name="issue_bhead" id="issue_bhead" class="form-control">
                            <option value="">--select--</option>
                            <?php 
                            if(!empty($bhead_data)): 
                                foreach($bhead_data as $bh):
                                    ?>
                                    <option value="<?php echo $bh->buhe_bugetheadid; ?>"><?php echo $bh->buhe_headtitle; ?></option>
                                    <?php
                                endforeach;
                            endif; ?>
                        </select>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-sm btn-success" id="proceed_to_issue_items">Issue</a>
                        </div>
                            
                    <?php elseif($proceed_issue_id == "3"):?>
                        <div class="mbtm_10">
                            <span class="text-danger">Issue Cancelled By Branch Manager</span>
                        </div>
                    <?php elseif($proceed_issue_id == "1" || empty($proceed_issue_id)) :?>
                     <div class="mbtm_10">
                            <span class="text-danger">Verify Issue with Branch Manager</span>
                        </div>
                    <?php endif;?>

                </td>

            </tr>

            <?php

        endif;

        ?> 

    </tfoot>

    <?php

endif;

?>

</table>

<div class="<?php echo $text_class; ?>"><?php echo $handover_message; ?></div> 

<div class="clearfix"></div>

<br>

<?php

if($this->usergroup == 'DS'):

    ?>

    <div class="">

    </div>

    <?php

            endif; // end if usergroup == DS
            if(in_array($this->usergroup,array('BM','SI','SK'))):
            ?>

            <?php

            $issue_btn_view_group = array('BM','SI','SK');

            $issue_respond_btn_view_group = array('BM');

            $proceed_issue_id = !empty($requistion_data[0]->rema_proceedissue)?$requistion_data[0]->rema_proceedissue:'';

            if(in_array($this->usergroup, $issue_respond_btn_view_group) && $proceed_issue_id == '1' ): 

                ?>

                <div class="mbtm_10">

                    <a href="javascript:void(0)" class="btn btn-sm btn-info approve_issue" data-respondtype = "approve">Approve Issue </a>

                    <a href="javascript:void(0)" class="btn btn-sm btn-danger approve_issue" data-respondtype = "decline">Decline Issue </a>

                </div>

                <?php
            
            elseif(in_array($this->usergroup, $issue_btn_view_group) && $proceed_issue_id == '1'):

                ?>

                <p class="text-info">Issue has been requested for available items.</p>

                <?php

            elseif(in_array($this->usergroup, $issue_btn_view_group) && $proceed_issue_id == '2'):

                ?>

                <p class="text-success">Issue Request has been approved for available items.</p>

                <?php

            elseif(in_array($this->usergroup, $issue_btn_view_group) && $proceed_issue_id == '3'):

                ?>

                <p class="text-danger">Issue Request has been declined for available items.</p>

                <?php

            elseif(in_array($this->usergroup, $issue_btn_view_group) && $proceed_issue_id == '4'):

                ?>

                <p class="text-info">Item has been issued to demander for available items.</p>

                <?php

            endif;
        endif;

            ?>

            <?php

            // $sama_count = $this->general->get_count_data('sama_salemasterid', 'sama_salemaster',array('sama_requisitionno'=>$rema_reqno, 'sama_fyear'=>$rema_fyear, 'sama_locationid'=>$rema_locationid));

            // if(in_array($this->usergroup, array('SI','SK')) && $proceed_issue_id == '2' && $sama_count == 0):

                ?>

                <!-- <div class="mbtm_10"> -->

                    <!--    <a href="javascript:void(0)" class="btn btn-sm btn-success issue_to_demander">Issue </a> -->

                    <!-- <button style="margin-right: 5px;" class="btn btn-success btnredirect btnissue" data-print="print" data-viewurl="<?php echo base_url('/issue_consumption/new_issue') ?>"  data-id="<?php echo $rema_reqno; ?>"> -->

                        <?php //echo $this->lang->line('issue'); ?>

                    <!-- </button >  -->

                <!-- </div> -->

                <?php

            // endif;

            ?>

            <?php

            if($this->usergroup == 'IT' & $it_recommend_status <= '1'){

                ?>

                <a id="btnSubmitITRecommend" href="javascript:void(0)" class="btn btn-info pull-right">Submit IT Recommendation </a>

                <?php

            }

            ?>

            <?php

            if($this->usergroup <> 'DM'):

                ?>

                <div class="list_c2 label_mw125">

                    <form id="FormChangeStatus" action="<?php echo base_url('issue_consumption/stock_requisition/change_status');?>" method="POST">

                        <input type="hidden" name="masterid" value="<?php echo $rema_reqmasterid;  ?>" />

                        <input type="hidden" name="reqno" value="<?php echo $rema_reqno;  ?>" />

                        <div class="form-group">

                            <div class="col-ms-12">

                                <div class="row">

                                    <?php 

                                    $recommend_status = !empty($requistion_data[0]->rema_recommendstatus)?$requistion_data[0]->rema_recommendstatus:''; 

                                    if($this->usergroup <> 'DM' && $this->usergroup == 'DS' && empty($recommend_status)):

                                        if(empty($approved_status)):

                                            ?>

                                            <div class="col-sm-12">

                                                <a id="btnRecommend" href="javascript:void(0)" class="btn btn-primary pull-right">Recommend</a>

                                            </div>

                                            <?php

                                        endif; // end if check approved status

                                    endif; // end if check group

                                    ?>

                                    <?php

                                    if(!empty($recommend_status) && ($this->usergroup == 'DS' || $this->usergroup == 

                                        'DM')):

                                        if($recommend_status == 'A'):

                                            ?>

                                            <div class="pull-right">

                                                <span class="badge badge-sm badge-success">Recommended qty was accepted.</span>

                                            </div>

                                            <?php

                                        elseif($recommend_status == 'D'):

                                            ?>

                                            <div class="pull-right">

                                                <span class="badge badge-sm badge-danger">Recommended qty was declined.</span>

                                            </div>

                                            <?php

                                        else:

                                            ?>

                                            <div class="pull-right">

                                                <span class="badge badge-sm badge-warning">Recommended qty is pending.</span>

                                            </div>

                                            <?php 

                                        endif;

                                    endif;

                                    ?>

                                    <?php

                                    $it_status = !empty($requistion_data[0]->rema_itstatus)?$requistion_data[0]->rema_itstatus:''; 

                                    if($this->usergroup == 'DS'):

                                        if($check_it_dep && $it_status == ''):

                                            ?>

                                            <div class="col-sm-12 mbtm_15">

                                                <span>If there are IT items in demand, it will be automatically proceeded to IT Department after Verification.</span>

                                                <br/>

                                                <!-- <a href="javascript:void(0)" class="btn btn-sm btn-danger" id="send_to_it_department">Send To IT Department</a> -->

                                            </div>

                                            <?php

                                        elseif($check_it_dep && $it_status == '1'):

                                            ?>

                                            <span>Request has been sent to IT department for verification.</span>

                                            <?php

                                        elseif($check_it_dep && $it_status == '2'):

                                            ?>

                                            <span>IT Department has submitted their recommendation.</span>

                                            <?php

                                        else:   

                                            ?>

                                            <?php

                                        endif;

                                    endif;

                                    ?>

                                    <?php

                                    if($check_it_dep): 

                                        ?>

                                        <input type="hidden" name="check_it_dep" value="1"/>

                                        <?php

                                    endif;

                                    ?>

                                    <div class="col-sm-3">

                                        <?php

                                        if(defined('TWO_LEVEL_APPROVAL')):

                                            if(TWO_LEVEL_APPROVAL == 'Y'):

                                    // if($check_it_dep == '0' || $it_status == '2'):

                                                if($postby != $this->userid && $approved_status != 1 && $approved_status != 4 && $approved_status != 3 ){

                                                    ?>

                                                    <div class="col-sm-12">

                                                        <label for="example-text"><?php echo $this->lang->line('verify'); ?>  : </label>

                                                        <input type="radio" class="mbtm_13 cancel" name="approve_status"  value="4" id="verified">

                                                        <?php

                                                        if($check_it_dep):

                                                            ?>

                                                            <input type="hidden" name="check_it_dep" value="1"/>

                                                            <?php

                                                        endif;

                                                        ?>

                                                    </div>

                                                    <?php

                                                }

                                            endif;

                                        endif;

                                        ?>

                                        <?php

                                        if($approved_status != '4' && $approved_status !='1'):

                                            ?>

                                            <?php 

                                            if($approved_status != 3) { ?>

                                                <div class="col-sm-12">

                                                    <label for="example-text"><?php echo $this->lang->line('canceled'); ?>  : </label>

                                                    <input type="radio" class="mbtm_13 cancel" name="approve_status"  value="3" id="cancel">

                                                </div>

                                            <?php } ?>

                                        </div>

                                        <div class="col-sm-9">

                                            <div class="col-md-6 showCancel" id="cancelReason">

                                                <label for="example-text"><?php echo $this->lang->line('cancel_reason'); ?>: </label><br>

                                                <textarea rows="3" cols="70" name="cancel_reason"></textarea>

                                            </div>

                                            <div class="col-md-6 showUnapproved" id="cancelReason">

                                                <label for="example-text"><?php echo $this->lang->line('unapproved_reason'); ?>: </label><br>

                                                <textarea rows="3" cols="70" name="rema_unapprovedreason"></textarea>

                                            </div>

                                        </div>

                                    </div>

                                    <?php

                                    if($approved_status != '3'):
                                        // if($mattype_cnt==0)
                                        ?>

                                        <div class="col-md-12">

                                            <button type="submit" class="btn btn-info  savelist" data-operation="save" id="btnDeptment" data-isdismiss="Y" data-isrefresh="Y">

                                                <?php echo $this->lang->line('verify'); ?> 

                                            </button>

                                        </div>

                                        <?php

                                    endif;

                                    ?>

                                    <?php

                                endif;

                                ?>

                                <div class="col-sm-12">

                                    <div  class="alert-success success"></div>

                                    <div class="alert-danger error"></div>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

                <?php

        endif; // end if usergrp <> DM

        ?>

    </div>  

</div>

<div class="col-sm-12">

    <div class="row">

        <?php

        $history_data = $this->general->get_history_data($rema_reqmasterid, $rema_reqno, $rema_fyear,'desc');

        $comment = !empty($history_data[0]->inst_comment)?$history_data[0]->inst_comment:'';

        $actiondatebs = !empty($history_data[0]->aclo_actiondatebs)?$history_data[0]->aclo_actiondatebs:'';

        $actiontime = !empty($history_data[0]->aclo_actiontime)?$history_data[0]->aclo_actiontime:'';

        $username = !empty($history_data[0]->usma_username)?$history_data[0]->usma_username:'';    

        ?>

        <div class="processFlowDiv" style="padding: 5px;margin-top:5px;border:1px solid #00d; color: #00d;">

            <?php

            echo "<strong>Last Action: </strong>".$comment." on ".$actiondatebs.' '.$actiontime." by ".$username;

            ?>

        </div>

    </div>

</div>

<script> 

    $(document).off('click','.cancel');

    $(document).on('click','.cancel',function(){

        var status = $('form input[type=radio]:checked').val();

        if(status == '2')

        {

            $('.showUnapproved').show();  

        }else{

            $('.showUnapproved').hide();  

        }

        if(status == '3')

        {

            $('.showCancel').show();

        }else{

            $('.showCancel').hide();  

        }

    })

</script>

<script type="text/javascript">

    $(document).off('change','.checkall');

    $(document).on('change','.checkall',function(e){

        if (this.checked) {

            $(".itemcheck").each(function() {

                this.checked=true;

            });

            $('#processdiv').show();

        } else {

            $(".itemcheck").each(function() {

                this.checked=false;

            });

            $('#processdiv').hide();

        }

    });

    // need to work out later

    $(document).off('click','.itemcheck');

    $(document).on('click','.itemcheck',function(e){

        var clsname= $(this).attr('class');

        // return false;

        if ($('.btnSelectNotAvailable').hasClass('select') || $('.btnSelectAvailable').hasClass('select')) {

            if ($(this).hasClass('stocknotavailable') && $('.btnSelectNotAvailable').hasClass('select')) {
                alert('Unable to checked when you click on unavailable Stock');
                return false;

            }else if($(this).hasClass('stockavailable') && $('.btnSelectNotAvailable').hasClass('select')){
                
                $(this).attr("checked", !$(this).attr("checked"));   

            }else{
                alert('Cannot check the item.');
                return false;                
            } 
            // if($('.itemcheck').hasClass('stockavailable') && $('.btnSelectNotAvailable').hasClass('select')){
            //     console.log('here'); 
            //     // $(this).attr("checked", !$(this).attr("checked"));   
            //     alert('Unable to checked when you click on unavailable Stock');

            //     return false;

            // } else if($('.itemcheck').hasClass('stocknotavailable') && $('.btnSelectAvailable').hasClass('select') ){

            //     alert('Unable to checked when you click on available Stock');

            //     return false;

            // }

        }else if($('.btnSelectAll').hasClass('select')){
            $(this).attr("checked", !$(this).attr("checked")); 
        }
        else{

            alert('You need to Click any one them "Available Stock" or "Unavailable Stock"');

            return false;

        }

       // if (this.checked) {

       //    this.checked=true;

       //    $('#processdiv').show();

       // } else {

       //    this.checked=false;

       //    $('#processdiv').hide();

       // }

   });

    $(document).off('click','.btnSelectNotAvailable');

    $(document).on('click','.btnSelectNotAvailable',function(e){
        $('#processdiv').hide();
        $('.btnissue').hide();
        $('#processIssueDiv').hide();
        $('#issueDiv').hide();

        $(this).toggleClass("select");  

        var curclassname=this.className;

        if (curclassname.indexOf('select') > -1) {

            $(".stocknotavailable").each(function() {

                var check_proceedpurchase = $(this).attr('data-proceedpurchase');

                if(check_proceedpurchase == 'N'){

                    this.checked=true;    

                }else{

                    this.checked=false;

                }

            });

            $(".stockavailable").each(function() {

                this.checked=false;

            });

            var available_count = $('.stocknotavailable').length;

            if(available_count > 0){

                $('#processdiv').show();

                $('.btnSelectNotAvailable').text('Unselect Unavailable Stock');

                $('.btnissue').hide();

            }

            $('.btnSelectAll').removeClass('select');
            $('.btnSelectAll').text('Select All For Purchase');

            $('.btnSelectAvailable').removeClass('select');
            $('.btnSelectAvailable').text('Select Available Stock');

            // $('#processdiv').show();

            $('#processIssueDiv').hide();

            $('#issueDiv').hide();

        } else {

            $(".stocknotavailable").each(function() {

                this.checked=false;

            });

            $('#processdiv').hide();

            $('.btnSelectNotAvailable').text('Select Unavailable Stock');

        }

    });

    $(document).off('click','.btnSelectAvailable');

    $(document).on('click','.btnSelectAvailable',function(e){
        $('#processdiv').hide();
        $('.btnissue').hide();
        $('#processIssueDiv').hide();
        $('#issueDiv').hide();

        $(this).toggleClass("select");  

        var curclassname=this.className;

        var item_avial_check = '<?php echo $item_avialable_check?>';

        if (curclassname.indexOf('select') > -1) {

            if(item_avial_check == ''){

                $(".stockavailable").each(function() {

                    this.checked=true;

                });

            }

            $(".stocknotavailable").each(function() {

                this.checked=false;

            });

            var available_count = $('.stockavailable').length;

            if(available_count > 0){

                if(item_avial_check == ''){

                    $('#issueDiv').show();

                }else{

                    $('#processIssueDiv').show();

                }

                $('.btnSelectAvailable').text('Unselect Available Stock');

                $('.btnissue').show();
                // $("#issue_datebs").datepicker();
                setTimeout(()=>{
                $('.nepdatepicker').nepaliDatePicker({
                  npdMonth: true,
                  npdYear: true,
                  npdYearCount: 10 // Options | Number of years to show
                });
                },500);

            }

            $('.btnSelectAll').removeClass('select');
            $('.btnSelectAll').text('Select All For Purchase');

            $('.btnSelectNotAvailable').removeClass('select');
            $('.btnSelectNotAvailable').text('Select Unavailable Stock');

            $('#processdiv').hide();

        } else {

            $('.btnissue').hide();

            $(".stockavailable").each(function() {

                this.checked=false;

            });

            $('#processIssueDiv').hide();

            $('#issueDiv').hide();

            $('.btnSelectAvailable').text('Select Available Stock');

        }

    });

    $(document).off('click','.btnSelectAll');

    $(document).on('click','.btnSelectAll',function(e){

        $(this).toggleClass("select");  

        var curclassname=this.className;

        if (curclassname.indexOf('select') > -1) {

            $(".stocknotavailable").each(function() {

                var check_proceedpurchase = $(this).attr('data-proceedpurchase');

                if(check_proceedpurchase == 'N'){

                    this.checked=true;    

                }else{

                    this.checked=false;

                }

            });

            let remqty = 0;
            let stock = 0;
            let qty = 0;

            $(".stockavailable").each(function() {

                qty = parseFloat($(this).data('qty'));

                remqty = parseFloat($(this).data('remqty'));

                stock = parseFloat($(this).data('stockqty'));
                // console.log(`qty: ${qty}, remqty: ${remqty}, stock: ${stock}`); 
                if (remqty > stock) {

                this.checked=true;
                }else{
                this.checked=false;

                }

            });

            $('#processdiv').show();
            $('.btnissue').hide();
            $('#processIssueDiv').hide();
            $('#issueDiv').hide();

            $('.btnSelectAvailable').removeClass('select');
            $('.btnSelectNotAvailable').removeClass('select');

            $('.btnSelectAvailable').text('Select Available Stock');
            $('.btnSelectNotAvailable').text('Select UnAvailable Stock');
            $('.btnSelectAll').text('Unselect All Items');

            // $('#processdiv').show();

        }else{
            $('.itemcheck').each(function(){
                this.checked = false;
            });
            $('.btnSelectAll').text('Select All For Purchase');
            $('#processdiv').hide();
            $('.btnissue').hide();
            $('#processIssueDiv').hide();
            $('#issueDiv').hide();
        }
    });

    $(document).off('click','#process_purchase');

    $(document).on('click','#process_purchase',function(e){

        var req_no=$('#req_no').val();

        var fyear=$('#fyear').val();

        var itemlist = [];

        $.each($("input[name='itemsid[]']:checked"), function(){            

            itemlist.push($(this).val());

        });

        var redirecturl=base_url+'purchase_receive/purchase_requisition';

        $.redirectPost(redirecturl, {itemlist:itemlist,req_no:req_no,fyear:fyear});

        return false;

    })

    $(document).off('click','#central_request');

    $(document).on('click','#central_request',function(e){

        var conf = confirm('Are You Want to Sure to Request ?');

        if(conf)

        {

            var req_no=$('#req_no').val();

            var fyear=$('#fyear').val();

            var itemlist = [];

            $.each($("input[name='itemsid[]']:checked"), function(){            

                itemlist.push($(this).val());

            });

            var request_url=base_url+'handover/handover_req/handover_request_from_branch';

            $.ajax({

                type: "POST",

                url: request_url,

                data:{itemlist:itemlist,req_no:req_no,fyear:fyear},

                dataType: 'html',

                beforeSend: function() {

                    $('.overlay').modal('show');

                },

                success: function(jsons) 

                {

                    data = jQuery.parseJSON(jsons);   

                    // alert(data.status);

                    if(data.status=='success')

                    {

                        $('.success').html(data.message);

                        $('.success').show();

                        setTimeout(function(){

                            $('#myView').modal('hide');

                        },1000); 

                    }

                    else

                    {
                        alert(data.message);
                        // return false;

                        // $('.error').html(data.message);

                        // $('.error').show();

                        // alert(data.message);

                    }

                      $('.overlay').modal('hide');

                }

            });

        }

    })

</script>

<script type="text/javascript">

    $(document).off('click','#btnRecommend');

    $(document).on('click','#btnRecommend',function(){

        var all_recommend_qty = [];

        var all_items_id = [];

        $(".recommend_qty").each(function() {

            all_recommend_qty.push($(this).val());

        });

        $(".items_id").each(function() {

            all_items_id.push($(this).val());

        });

        var rema_reqmasterid = '<?php echo $rema_reqmasterid;  ?>';

        var rema_reqno = '<?php echo $rema_reqno;  ?>';

        var submitData = {all_recommend_qty:all_recommend_qty, all_items_id:all_items_id, rema_reqmasterid: rema_reqmasterid, rema_reqno:rema_reqno };

        beforeSend= $('.overlay').modal('show');

        var submitUrl = base_url+'issue_consumption/stock_requisition/update_recommend_qty';

        ajaxPostSubmit(submitUrl, submitData, beforeSend='',onSuccess);

        function onSuccess(response){

            data = jQuery.parseJSON(response);   

            if(data.status=='success'){

                $('.success').html(data.message);

                $('.success').show();

            }else{

                $('.error').html(data.message);

                $('.error').show();

            }

            $('.overlay').modal('hide');

            setTimeout(function(){

                $('#myView').modal('hide');

            },1000); 

        }

    });

    $(document).off('click','#proceed_to_issue');

    $(document).on('click','#proceed_to_issue', function(){

        var conf = confirm('Are you sure you want to process to verified with branch manager ?');

        if(conf)

        {

            // var req_no=$('#req_no').val();

            // var fyear=$('#fyear').val();

            var rema_reqmasterid = '<?php echo $rema_reqmasterid;  ?>';

            var itemlist = [];

            $.each($("input[name='itemsid[]']:checked"), function(){            

                itemlist.push($(this).val());

            });

            var submitData = {masterid:rema_reqmasterid, itemlist:itemlist};

            var submitUrl = base_url+'issue_consumption/stock_requisition/proceed_to_issue';

            beforeSend= $('.overlay').modal('show');

            ajaxPostSubmit(submitUrl, submitData, beforeSend='',onSuccess);

            function onSuccess(response){

                data = jQuery.parseJSON(response);   

                if(data.status=='success'){

                    $('.success').html(data.message);

                    $('.success').show();

                }else{

                    $('.error').html(data.message);

                    $('.error').show();

                }

                $('.overlay').modal('hide');

                setTimeout(function(){

                    $('#myView').modal('hide');

                },1000); 

            }

        }

    });

    $(document).off('click','#proceed_to_issue_items');

    $(document).on('click','#proceed_to_issue_items', function(){

        var conf = confirm('Do you want to issue items ?');

        if(conf)

        {   
            var type = $(this).data('type');
            if (type == 'direct') {
            var rema_issuedate = $("#issue_datebs_direct").val();
            var budget_headid = $("#issue_bhead_direct").val();
            var budget_categoryid = $("#issue_bcat_direct").val();
            }else{
            var rema_issuedate = $("#issue_datebs").val();
            var budget_headid = $("#issue_bhead").val();
            var budget_categoryid = $("#issue_bcat").val();
            }

            var rema_reqmasterid = '<?php echo $rema_reqmasterid;  ?>';

            var rema_reqby = '<?php echo $rema_reqby;  ?>';

            var rema_fyear = '<?php echo $rema_fyear;  ?>';

            var rema_reqno = '<?php echo $rema_reqno;  ?>';

            var proctype = $(this).data('proctype');

            var itemlist = [];

            var itemcode = [];

            var itemname = [];

            var unitname = [];

            var qty = [];

            var remqty = [];

            var unitprice = [];

            var totalamt = [];

            var reqdetailid = [];

            var itemtypeid = [];

            var stockqty = [];

            var my_rem_qty = [];

            var issue_budgethead = [];
            var issue_category = [];

            $.each($("input[name='itemsid[]']:checked"), function(){  

                let item_id = $(this).val();          

                itemlist.push($(this).val());

                itemcode.push($(this).data('itemcode'));

                itemname.push($(this).data('itemname'));

                unitname.push($(this).data('unitname'));

                qty.push($(this).data('qty'));

                remqty.push($(this).data('remqty'));

                unitprice.push($(this).data('unitprice'));

                totalamt.push($(this).data('totalamt'));

                reqdetailid.push($(this).data('reqdetailid'));

                itemtypeid.push($(this).data('itemtypeid'));

                stockqty.push($(this).data('stockqty'));

                my_rem_qty.push($(this).data('my_rem_qty'));

                issue_budgethead.push($(`issue_bhead_${item_id}`).val());
                issue_category.push($(`issue_cat_id_${item_id}`).val());

            }); 

            var submitData = { masterid:rema_reqmasterid, itemlist:itemlist, itemcode:itemcode, itemname:itemname, unitname:unitname, qty:qty, remqty:remqty, unitprice:unitprice, totalamt:totalamt, rema_reqby:rema_reqby,  rema_fyear:rema_fyear, rema_reqno:rema_reqno, proctype:proctype, reqdetailid: reqdetailid, itemtypeid:itemtypeid, stockqty:stockqty, my_rem_qty:my_rem_qty, rema_issuedate:rema_issuedate,budget_headid:budget_headid,budget_categoryid:budget_categoryid,issue_budgethead:issue_budgethead,issue_category:issue_category};

            var submitUrl = base_url+'issue_consumption/stock_requisition/proceed_to_issue_items';

            beforeSend= $('.overlay').modal('show');

            ajaxPostSubmit(submitUrl, submitData, beforeSend='',onSuccess);

            function onSuccess(response){

                data = jQuery.parseJSON(response);   

                if(data.status=='success'){

                    $('.success').html(data.message);

                    $('.success').show();

                }else{

                    $('.error').html(data.message);

                    $('.error').show();

                }

                $('.overlay').modal('hide');

                setTimeout(function(){

                    $('#myView').modal('hide');

                },1000); 

            }

        }

    });

</script>

<script type="text/javascript">

    $(document).off('click','.process_procurement');

    $(document).on('click','.process_procurement',function(){

        var conf = confirm('Are You Want to Sure to Process to Procurement ?');

        if(conf)

        {

            var rema_reqmasterid = '<?php echo $rema_reqmasterid;  ?>';

            var rema_reqby = '<?php echo $rema_reqby;  ?>';

            var rema_fyear = '<?php echo $rema_fyear;  ?>';

            var rema_reqno = '<?php echo $rema_reqno;  ?>';

            var proctype = $(this).data('proctype');

            var itemlist = [];

            var itemcode = [];

            var itemname = [];

            var unitname = [];

            var qty = [];

            var remqty = [];

            var unitprice = [];

            var totalamt = [];

            var reqdetailid = [];

            var itemtypeid = [];

            var stockqty = [];

            $.each($("input[name='itemsid[]']:checked"), function(){            

                itemlist.push($(this).val());

                itemcode.push($(this).data('itemcode'));

                itemname.push($(this).data('itemname'));

                unitname.push($(this).data('unitname'));

                qty.push($(this).data('qty'));

                remqty.push($(this).data('remqty'));

                unitprice.push($(this).data('unitprice'));

                totalamt.push($(this).data('totalamt'));

                reqdetailid.push($(this).data('reqdetailid'));

                itemtypeid.push($(this).data('itemtypeid'));

                stockqty.push($(this).data('stockqty'));

            });

              // console.log(itemlist);

              // return false;

              var submitData = { masterid:rema_reqmasterid, itemlist:itemlist, itemcode:itemcode, itemname:itemname, unitname:unitname, qty:qty, remqty:remqty, unitprice:unitprice, totalamt:totalamt, rema_reqby:rema_reqby,  rema_fyear:rema_fyear, rema_reqno:rema_reqno, proctype:proctype, reqdetailid: reqdetailid, itemtypeid:itemtypeid, stockqty:stockqty };

              var submitUrl = base_url+'issue_consumption/stock_requisition/proceed_to_procurement';

              beforeSend= $('.overlay').modal('show');

              ajaxPostSubmit(submitUrl, submitData, beforeSend='',onSuccess);

              function onSuccess(response){

                data = jQuery.parseJSON(response);   

                if(data.status=='success'){

                    // $('.success').html(data.message);

                    // $('.success').show();
                      setTimeout(function(){

                    $('#myView').modal('hide');

                    },1000); 

                }else{

                    alert(data.message);

                    // $('.error').html(data.message);

                    // $('.error').show();

                }

                $('.overlay').modal('hide');

            }

        }

    });

</script>

<script type="text/javascript">

    $(document).off('click','#send_to_it_department');

    $(document).on('click','#send_to_it_department', function(){

        var conf = confirm('Are You Want to Sure to Request ?');

        if(conf){

            // var req_no=$('#req_no').val();

            // var fyear=$('#fyear').val();

            var rema_reqmasterid = '<?php echo $rema_reqmasterid;  ?>';

            var itemlist = [];

            $.each($("input[name='itemsid[]']:checked"), function(){            

                itemlist.push($(this).val());

            });

            var submitData = {masterid:rema_reqmasterid, itemlist:itemlist};

            var submitUrl = base_url+'issue_consumption/stock_requisition/send_to_it_department';

            beforeSend= $('.overlay').modal('show');

            ajaxPostSubmit(submitUrl, submitData, beforeSend='',onSuccess);

            function onSuccess(response){

                data = jQuery.parseJSON(response);   

                if(data.status=='success'){

                    $('.success').html(data.message);

                    $('.success').show();

                }else{

                    $('.error').html(data.message);

                    $('.error').show();

                }

                $('.overlay').modal('hide');

                setTimeout(function(){

                    $('#myView').modal('hide');

                },1000); 

            }

        }

    });

    $(document).off('click','#btnOtherStock');

    $(document).on('click','#btnOtherStock',function(e){

        var itemlist = [];

        var handovermasterid=$('#handovermasterid').val();

        $.each($("input[name='itemsid[]']:checked"), function(){            

            itemlist.push($(this).val());

        });

        // console.log(itemlist);

        var action=base_url+'stock_inventory/current_stock/itemwise_stock_summary';

        var heading=$(this).data('heading');

        $('#myView2').modal('show');

        $('#MdlLabel2').html(heading);

        // return false;

        $.ajax({

            type: "POST",

            url: action,

            data:{itemlist:itemlist,handovermasterid:handovermasterid},

            dataType: 'html',

            beforeSend: function() {

                $('.overlay').modal('show');

            },

            success: function(jsons) 

            {

                data = jQuery.parseJSON(jsons);   

                // alert(data.status);

                if(data.status=='success'){

                    console.log(data.tempform);

                    $('.displyblock2').html(data.tempform);

                }  

                else{

                    alert(data.message);

                }

                $('.overlay').modal('hide');

            }

        });

        return false;

    })

</script>

<script type="text/javascript">

    $(document).off('click','.approve_issue');

    $(document).on('click','.approve_issue',function(e){

        var rema_reqmasterid = '<?php echo $rema_reqmasterid;  ?>';

        var rema_reqby = '<?php echo $rema_reqby;  ?>';

        var rema_fyear = '<?php echo $rema_fyear;  ?>';

        var rema_reqno = '<?php echo $rema_reqno;  ?>';

        var respond_type = $(this).data('respondtype'); 

        var submitData = { masterid:rema_reqmasterid, respond_type:respond_type };

        var submitUrl = base_url+'issue_consumption/stock_requisition/respond_issue_by_branch_manager';

        beforeSend= $('.overlay').modal('show');

        ajaxPostSubmit(submitUrl, submitData, beforeSend='',onSuccess);

        function onSuccess(response){

            data = jQuery.parseJSON(response);   

            if(data.status=='success'){

                $('.success').html(data.message);

                $('.success').show();

            }else{

                $('.error').html(data.message);

                $('.error').show();

            }

            $('.overlay').modal('hide');

            setTimeout(function(){

                $('#myView').modal('hide');

            },1000); 

        }

    });

</script>

<script type="text/javascript">

    $(document).off('click','#btnSubmitITRecommend');

    $(document).on('click','#btnSubmitITRecommend',function(){

        var rede_itrecommend = [];

        var rede_itcomment = [];

        var all_items_id = [];

        $(".rede_itrecommend").each(function() {

            rede_itrecommend.push($(this).val());

        });

        $(".rede_itcomment").each(function() {

            rede_itcomment.push($(this).val());

        });

        $(".items_id").each(function() {

            all_items_id.push($(this).val());

        });

        var recommendation_status = $('.recommendation:checked').val();

        var rema_reqmasterid = '<?php echo $rema_reqmasterid;  ?>';

        var rema_reqno = '<?php echo $rema_reqno;  ?>';

        var submitData = {all_items_id:all_items_id, rede_itrecommend:rede_itrecommend, rede_itcomment:rede_itcomment, rema_reqmasterid: rema_reqmasterid, recommendation_status:recommendation_status, rema_reqno:rema_reqno };

        beforeSend= $('.overlay').modal('show');

        var submitUrl = base_url+'issue_consumption/stock_requisition/submit_it_recommendation';

        ajaxPostSubmit(submitUrl, submitData, beforeSend='',onSuccess);

        function onSuccess(response){

            data = jQuery.parseJSON(response);   

            if(data.status=='success'){

                $('.success').html(data.message);

                $('.success').show();

            }else{

                $('.error').html(data.message);

                $('.error').show();

            }

            $('.overlay').modal('hide');

            setTimeout(function(){

                $('#myView').modal('hide');

            },1000);

        }

    });

</script>

<script type="text/javascript">

    $(document).off('click','.btnSelectAvailableAfter');

    $(document).on('click','.btnSelectAvailableAfter',function(e){

        $(this).toggleClass("select");  

        var curclassname=this.className;

        if (curclassname.indexOf('select') > -1) {

            $(".itemAvailableAfter").each(function() {

                this.checked=true;

            });

            $(".itemAvailableBefore").each(function() {

                this.checked=false;

            });

            var available_count = $('.itemAvailableAfter').length;

            if(available_count > 0){

                $('.stock_available_after_procurement').show();

                $('.btnSelectAvailableAfter').text('Unselect Available Stock After Purchase');

            }

            $('.btnSelectAvailableBefore').removeClass('select');

            $('.btnSelectAvailableBefore').text('Select Available Stock Before Purchase');

            $('.stock_available_before_procurement').hide();

        } else {

            $(".itemAvailableAfter").each(function() {

                this.checked=false;

            });

            $('.stock_available_after_procurement').hide();

            $('.btnSelectAvailableAfter').text('Select Available Stock After Purchase');

        }

    });

    $(document).off('click','.btnSelectAvailableBefore');

    $(document).on('click','.btnSelectAvailableBefore',function(e){

        $(this).toggleClass("select");  

        var curclassname=this.className;

        if (curclassname.indexOf('select') > -1) {

            $(".itemAvailableBefore").each(function() {

                this.checked=true;

            });

            $(".itemAvailableAfter").each(function() {

                this.checked=false;

            });

            var available_count = $('.itemAvailableBefore').length;

            if(available_count > 0){

                $('.stock_available_before_procurement').show();

                $('.btnSelectAvailableBefore').text('Unselect Available Stock Before Purchase');

            }

            $('.btnSelectAvailableAfter').removeClass('select');

            $('.btnSelectAvailableAfter').text('Select Available Stock After Purchase');

            $('.stock_available_after_procurement').hide();

        } else {

            $(".itemAvailableBefore").each(function() {

                this.checked=false;

            });

            $('.stock_available_before_procurement').hide();

            $('.btnSelectAvailableBefore').text('Select Available Stock Before Purchase');

        }

    });

    // inform demander if stock becomes available

    $(document).off('click','#inform_item_available');

    $(document).on('click','#inform_item_available', function(){

        var conf = confirm('Do you want to inform about available items ?');

        if(conf)

        {

            var rema_reqmasterid = '<?php echo $rema_reqmasterid;  ?>';

            var rema_reqby = '<?php echo $rema_reqby;  ?>';

            var rema_fyear = '<?php echo $rema_fyear;  ?>';

            var rema_reqno = '<?php echo $rema_reqno;  ?>';

            var proctype = $(this).data('proctype');

            var itemlist = [];

            var itemcode = [];

            var itemname = [];

            var unitname = [];

            var qty = [];

            var remqty = [];

            var unitprice = [];

            var totalamt = [];

            var reqdetailid = [];

            var itemtypeid = [];

            var stockqty = [];

            $.each($("input[name='itemsid[]']:checked"), function(){            

                itemlist.push($(this).val());

                itemcode.push($(this).data('itemcode'));

                itemname.push($(this).data('itemname'));

                unitname.push($(this).data('unitname'));

                qty.push($(this).data('qty'));

                remqty.push($(this).data('remqty'));

                unitprice.push($(this).data('unitprice'));

                totalamt.push($(this).data('totalamt'));

                reqdetailid.push($(this).data('reqdetailid'));

                itemtypeid.push($(this).data('itemtypeid'));

                stockqty.push($(this).data('stockqty'));

            });

            var submitData = { masterid:rema_reqmasterid, itemlist:itemlist, itemcode:itemcode, itemname:itemname, unitname:unitname, qty:qty, remqty:remqty, unitprice:unitprice, totalamt:totalamt, rema_reqby:rema_reqby,  rema_fyear:rema_fyear, rema_reqno:rema_reqno, proctype:proctype, reqdetailid: reqdetailid, itemtypeid:itemtypeid, stockqty:stockqty };

            var submitUrl = base_url+'issue_consumption/stock_requisition/inform_item_available';

            beforeSend= $('.overlay').modal('show');

            ajaxPostSubmit(submitUrl, submitData, beforeSend='',onSuccess);

            function onSuccess(response){

                data = jQuery.parseJSON(response);   

                if(data.status=='success'){

                    $('.success').html(data.message);

                    $('.success').show();

                }else{

                    $('.error').html(data.message);

                    $('.error').show();

                }

                $('.overlay').modal('hide');

                setTimeout(function(){

                    $('#myView').modal('hide');

                },1000); 

            }

        }

    });

</script>

<script type="text/javascript">

    $(document).off('change','.bcheck');

    $(document).on('change','.bcheck',function(e){

        var id=$(this).data('id');

        var reqdid=$(this).data('reqdetailid');

        var cat_id=$('#cat_id_'+id).val();

        var bhead=$('#bhead_'+id).val();

   //       alert(id);

   // alert(bhead);

   // return false;

   var check_url=base_url+'issue_consumption/stock_requisition/check_budget_category';

   if(cat_id && bhead){

      $.ajax({

        type: "POST",

        url: check_url,

        data:{cat_id:cat_id,bhead:bhead,reqdid:reqdid},

        dataType: 'html',

        beforeSend: function() {

        },

        success: function(jsons) 

        {

            data = jQuery.parseJSON(jsons);   

                    // alert(data.status);

                    if(data.status=='success')

                    {
                        $('#budget_status_'+id).html(data.template);
                        $('#isisbug_avl_'+id).val(data.isbug_avl);
                        $('#api_expense_id_'+id).val(data.api_expense_id);
                        $('#budget_amount_'+id).html(data.budget_amount);
                    }
                    else
                    {

                        $('#budget_status_'+id).html();
                        $('#isisbug_avl_'+id).val(data.isbug_avl);
                        $('#api_expense_id_'+id).val('');
                        $('#budget_amount_'+id).html(data.budget_amount);
                    }

                }

            });  

  }

});

    $(document).off('click','.btnsave_buget');

    $(document).on('click','.btnsave_buget',function(e){

        var id=$(this).data('id');

        var reqdid=$(this).data('reqdetailid');

        var cat_id=$('#cat_id_'+id).val();

        var bhead=$('#bhead_'+id).val();

        var isbug_avl=$('#isisbug_avl_'+id).val();

        var api_expense_id=$('#api_expense_id_'+id).val();

        // alert(cat_id);

        // alert(bhead);

        // return false;

        if(cat_id==null || cat_id=='' ){

            alert('Category is requered !!');

            return false;

        }

        if(bhead==null || bhead=='' ){

            alert('Budget head is requered !! ');

            return false;

        }

        var check_url=base_url+'issue_consumption/stock_requisition/save_budget_category';

        if(cat_id && bhead){

          $.ajax({

            type: "POST",

            url: check_url,

            data:{cat_id:cat_id,bhead:bhead,reqdid:reqdid,isbug_avl:isbug_avl,api_expense_id:api_expense_id},

            dataType: 'html',

            beforeSend: function() {

            },

            success: function(jsons) 

            {

                data = jQuery.parseJSON(jsons);   

                    // alert(data.status);

                    if(data.status=='success')

                    {

                        $('#savediv_'+id).html(data.template);

                    }

                    else

                    {

                        alert(data.message);

                        return false;

                    }

                }

            });  

      }

  });

</script>

<script type="text/javascript">

    $(document).off('change','.bcheckall');

    $(document).on('change','.bcheckall',function(e){

        var cat_id_all =$('#cat_id_all').val();

        var bhead_id_all =$('#bhead_id_all').val();

    //  $('.bcheck').each(function(index, e) {

    //     $('.bcheck').val(cat_id_all).trigger('change');  

    // });

   // return false;

   var id = $(this).data('id');

   if(id=='cat_id' ){

    $('.bcheck').each(function(index, e) {

        var id_index = index+1;

        var isattr=$('#'+id+'_'+id_index).is('[disabled=disabled]');

        if(isattr==false){

            $('#'+id+'_'+id_index).val(cat_id_all).trigger('change');      

        }

    });

}

if(id=='bhead'){

    $('.bcheck').each(function(index, e) {

        var id_index = index+1;

        var isattr=$('#'+id+'_'+id_index).is('[disabled=disabled]');

        if(isattr==false){

            $('#'+id+'_'+id_index).val(bhead_id_all).trigger('change');  

        }

    });

}

})

    $(document).off('click','.btn_save_all_acc');
    $(document).on('click','.btn_save_all_acc',function(e){

        $('.btnsave_buget').click();

    });
    $(document).ready(function(){
  $('.nepdatepicker').nepaliDatePicker({
  npdMonth: true,
  npdYear: true,
  npdYearCount: 10 // Options | Number of years to show
});
})

</script>
<?php
if($this->usergroup == 'AO'):
?>
<script>
    function cancel_api_expense(ids) {
        var check_url=base_url+'issue_consumption/stock_requisition/cancel_budget_category';
        $.ajax({
            type: "POST",
            url: check_url,
            data:{api_expense_id:ids},
            dataType: 'html',
            success: function(jsons) 
            {
                data = jQuery.parseJSON(jsons);   
                console.log(data);
            }
        }); 
    }

    $("#myView").click(function(event) {
  //if you click on anything except the modal itself check for api_expense_ids.
  if (!$(event.target).closest(".modal-content, .xyz-modal-123").length) {
    let expense_ids = [];
    $('input[id^=api_expense_id_]').each(function(index, value){
        expense_ids.push($(value).val());
    });
    expense_ids = expense_ids.filter((item) => item);
    if(expense_ids.length){
        cancel_api_expense(expense_ids);
    }
    $("#myView").unbind('click');
  }
});

$('.modal-header > .close').off('click');
$('.modal-header > .close').on('click',function(){
    let expense_ids = [];
    $('input[id^=api_expense_id_]').each(function(index, value){
        expense_ids.push($(value).val());
    });
    expense_ids = expense_ids.filter((item) => item);
    if(expense_ids.length){
        cancel_api_expense(expense_ids);
    }
    console.log(expense_ids);
});
</script>
<?php endif;?>