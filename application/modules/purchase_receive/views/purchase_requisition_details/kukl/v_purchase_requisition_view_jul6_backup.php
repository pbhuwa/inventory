<?php
    $account_user_group = array('AO','AV');

    $show_estimate_amt_group = array('PR','SA');
?>
<div class="form-group white-box pad-5">
    <div class="row">
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('requisition_no'); ?> : </label>
            <?php echo !empty($requistion_data[0]->pure_reqno)?$requistion_data[0]->pure_reqno:''; ?>
        </div>
        
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('requisition_date'); ?>  (AD) : </label><?php echo !empty($requistion_data[0]->pure_reqdatead)?$requistion_data[0]->pure_reqdatead:''; ?>
        </div>
        
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('requisition_date'); ?>  (BS) : </label><?php echo !empty($requistion_data[0]->pure_reqdatebs)?$requistion_data[0]->pure_reqdatebs:''; ?>
        </div>
        
        <div class="col-md-3 col-sm-4">
            <?php $time=!empty($requistion_data[0]->pure_posttime)?$requistion_data[0]->pure_posttime:''; //print_r($datedb);die;?>
              <label for="example-text"><?php echo $this->lang->line('requisition_time'); ?> : </label>
            <?php echo $time;?>
        </div>
        
        <div class="clearfix"></div>
        
        <div class="col-md-3 col-sm-4">
            <label for=""><?php echo $this->lang->line('item_types'); ?> : </label>
            <?php $storeid = !empty($requistion_data[0]->pure_itemstypeid)?$requistion_data[0]->pure_itemstypeid:''; $store = $this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$storeid ),'eqty_equipmenttypeid','DESC');
            echo !empty($store[0]->eqty_equipmenttype)?$store[0]->eqty_equipmenttype:''; ?>
        </div>

        <div class="col-md-3 col-sm-4">
            <?php $locaname=!empty($requistion_data[0]->loca_name)?$requistion_data[0]->loca_name:''; //print_r($datedb);die;?>
            <label for="example-text"><?php echo $this->lang->line('requisition_time'); ?> : </label>
            <?php echo $locaname;?>
        </div> 
     <!--    <div class="col-md-3 col-sm-4">
            <?php $requisitionno=!empty($requistion_data[0]->puor_orderno)?$requistion_data[0]->puor_orderno:''; ?>
            <label for="example-text">Order Number <span class="required">*</span>:</label>
            <?php echo $requisitionno; ?>
        </div>
        <div class="col-md-3 col-sm-4">
          <label for="example-text">Delivery Site : </label> 
           <?php $dsite=!empty($requistion_data[0]->puor_deliverysite)?$requistion_data[0]->puor_deliverysite:''; ?><?php echo $dsite; ?>
          <span class="errmsg"></span>
        </div>
        <div class="col-md-3 col-sm-4">
            <?php $puor_requno=!empty($requistion_data[0]->puor_requno)?$requistion_data[0]->puor_requno:''; ?>
            <label for="example-text">Requistion Number : </label>
            <?php echo $puor_requno; ?>
          <span class="errmsg"></span>
        </div> -->
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> : </label>
            <?php echo !empty($requistion_data[0]->pure_fyear)?$requistion_data[0]->pure_fyear:''; ?>
        </div>
        
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('requisited_by'); ?> : </label>
            <?php echo !empty($requistion_data[0]->pure_appliedby)?$requistion_data[0]->pure_appliedby:''; ?>
        </div> 
        
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('status'); ?> : </label>
          
              <span><?php 
            $approved_status=!empty($requistion_data[0]->pure_isapproved)?$requistion_data[0]->pure_isapproved:'';

            $purchase_proceed_log_status = !empty($requistion_data[0]->prlm_status)?$requistion_data[0]->prlm_status:'';
            // if($approved_status=='Y')
            // {
            //   echo "<span class='approved badge badge-sm badge-success'>Approved</span>"; 
            // }
            // else 
            // {
            //    echo "<span class='pending badge badge-sm badge-warning'>Pending</span>";
            // }
            
            if($approved_status=='Y')
            {
                echo "<span class='approved badge badge-sm badge-success'>Approved</span>"; 
            }
            else if($approved_status == 'C'){
                echo "<span class='approved badge badge-sm badge-danger'>Cancel</span>"; 
            }
            else if($approved_status == 'R'){
                echo "<span class='approved badge badge-sm badge-danger'>Rejected</span>";
            }
            else if($approved_status == 'P'){
                echo "<span class='approved badge badge-sm badge-warning'>Proceed to Purchase Order</span>";
            }
            else if($approved_status == 'V'){
                echo "<span class='approved badge badge-sm badge-info'>Verified</span>";
            }
            else
            {
                echo "<span class='pending badge badge-sm badge-warning'>Pending</span>";
            }
            ?>
          </span>
        </div> 
         <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('work_description'); ?> </label>:
            <?php 
                $work_description=!empty($requistion_data[0]->rema_workdesc)?$requistion_data[0]->rema_workdesc:'';
                echo $work_description;
            ?>
        </div>
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('work_place'); ?> </label>:
            <?php 
                $workplace=!empty($requistion_data[0]->rema_workplace)?$requistion_data[0]->rema_workplace:'';
                echo $workplace;
            ?>
        </div>
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('remarks'); ?> </label>:
            <?php 
                $work_remask=!empty($requistion_data[0]->rema_remarks)?$requistion_data[0]->rema_remarks:'';
                echo $work_remask;
            ?>
        </div>

       
    </div>



    <div class="clearfix"></div>
</div>

<?php
    if(in_array($this->usergroup, $account_user_group)):
 ?>
 <div>
    <?php
        if(in_array($this->usergroup, array('AO','AV'))):
    ?>
    <a href="javascript:void(0)" class="btnSelectNotAvailable btn btn-xs btn-danger">Select Unavailable Budget</a>
    <?php
        endif;
    ?>

    <a href="javascript:void(0)" class="btnSelectAvailable btn btn-xs btn-success">Select Available Budget</a>
 </div>
 <?php
    endif;
 ?>

<?php
    if(!empty($mat_type)):
?>
<div class="form-group">
    <div class="row">
        <div class="table-responsive col-sm-12">
            <table style="width:100%;" class="table purs_table dataTable con_ttl">
                <thead>
                    <tr>
                        <?php
                            if(in_array($this->usergroup, $account_user_group)):
                        ?>
                        <th  width="2%"></th>
                        <?php endif; ?>
                        <th width="2%"> <?php echo $this->lang->line('sn'); ?> </th>
                        <th width="6%"> <?php echo $this->lang->line('item_code'); ?></th>
                        <th width="20%"> <?php echo $this->lang->line('item_name'); ?></th>
                        <th width="8%"> <?php echo $this->lang->line('unit'); ?> </th>
                        <th width="8%"> <?php echo $this->lang->line('stock_quantity'); ?> </th>
                        <th width="8%"> <?php echo $this->lang->line('qty'); ?> </th> 
                    
                        <?php
                            if(in_array($this->usergroup, $account_user_group)):
                        ?>
                        <th width="8%">Prov. Qty</th> 
                        <?php
                            endif;
                        ?>
                        <th width="8%"> <?php echo $this->lang->line('rate'); ?> </th> 
                        <th width="8%"> <?php echo $this->lang->line('total_amt'); ?> </th> 
                        <?php
                            if(in_array($this->usergroup, $show_estimate_amt_group)):
                        ?>
                        <th width="10%"><?php echo $this->lang->line('estimate_cost'); ?>  </th>
                        <?php
                            endif;
                        ?>

                        <?php
                            if($this->usergroup == 'IT' || $this->usergroup == 'PR' || $this->usergroup == 'DS'):
                        ?>
                        <th width="15%"><?php echo $this->lang->line('it_recommend'); ?></th>
                        <th width="10%"><?php //echo $this->lang->line('it_comment'); ?> IT Remarks</th>
                        <?php
                            endif;
                        ?>
                        <th width="15%"><?php echo $this->lang->line('remarks'); ?></th>
                        <?php
                            if(in_array($this->usergroup, $account_user_group)):
                        ?>
                            <!--     <th width="5%"><?php echo $this->lang->line('available_budget'); ?> </th>
                        <th width="5%"><?php echo $this->lang->line('budget_status'); ?> </th> -->
                        <?php
                            endif;
                        ?>
                    </tr>
                </thead>
                
                <tbody id="purchaseDataBody">
                <?php 
                    $id = $this->input->post('id');
                    $count = 0;
                    foreach ($mat_type as $km => $mat):
                        $purchase_req_master = $this->purchase_requisition_mdl->get_purchase_requisition_master_data(array('pure_purchasereqid'=>$id, 'prlm_mattypeid'=>$mat->maty_materialtypeid));

                        $purchase_requisition = $this->purchase_requisition_mdl->get_purchase_requisition_data(array('rd.purd_reqid'=>$id, 'itli_materialtypeid'=>$mat->maty_materialtypeid));

                        if(!empty($purchase_requisition)){
                            $count = count($purchase_requisition);  
                        }else{
                            $count = 0;  
                        }
                ?>
                <tr class="orderrow" id="orderrow_1" data-id='1'>
                    <?php if($count <> '0'): ?>
                    <tr>
                        <td colspan="11">
                            <strong><?php echo $mat->maty_material; ?></strong>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php

                        if(!empty($purchase_requisition)):
                   
                            foreach ($purchase_requisition as $key => $odr) 
                            {
                                if(ITEM_DISPLAY_TYPE=='NP'){
                                    $req_itemname = !empty($odr->itli_itemnamenp)?$odr->itli_itemnamenp:$odr->itli_itemname;
                                }else{ 
                                    $req_itemname = !empty($odr->itli_itemname)?$odr->itli_itemname:'';
                                }
                    ?>
            
                    <?php
                        if(in_array($this->usergroup, $account_user_group)):
                    ?>
                        <td>
                            <?php
                                $budget_status = !empty($odr->budget_status)?$odr->budget_status:'';
                                if($budget_status == 'Y'){
                                    $budget_class = "budgetavailable";
                                    $budgetClass = "";
                                }else{
                                    $budget_class = "budgetnotavailable";
                                    $budgetClass = "text-danger";
                                }
                            ?>

                            <?php
                               if($odr->purd_proceedorder != 'Y'):
                            ?>
                            <input type="checkbox" name="itemsid[]" value="<?php echo !empty($odr->purd_itemsid)?$odr->purd_itemsid:'';?>" class="itemcheck <?php echo $budget_class;?> <?php echo 'material_type_'.$mat->maty_materialtypeid; ?> items_id" />
                            <?php
                                endif;
                            ?>

                        </td>
                    <?php endif; ?>
                    <td>
                         <?php echo $key+1; ?>
                    </td>
                    <td>
                        <span class="<?php echo !empty($budgetClass)?$budgetClass:''; ?>">
                        <?php echo !empty($odr->itli_itemcode)?$odr->itli_itemcode:'';?>
                        </span> 
                        <input type="hidden" name="itemsid[]" value="<?php echo !empty($odr->purd_itemsid)?$odr->purd_itemsid:'';?>" class="itemcheck <?php echo 'material_type_'.$mat->maty_materialtypeid; ?> items_id" />
                    </td>
                    <td>
                        <span class="<?php echo !empty($budgetClass)?$budgetClass:''; ?>">
                        <?php echo $req_itemname;?> 
                        </span>
                    </td>
                    <td>
                        <?php echo !empty($odr->unit_unitname)?$odr->unit_unitname:'';?> 
                       
                    </td>
                    <td>
                        <?php echo !empty($odr->purd_stock)?$odr->purd_stock:'';?>
                    </td>
                    <td>
                        <?php echo !empty($odr->purd_qty)?$odr->purd_qty:'';?>
                        <input type="hidden" class="cur_qty" value="<?php echo !empty($odr->purd_qty)?$odr->purd_qty:'';?>" />
                    </td>

                    <?php
                        if($requistion_data[0]->pure_isqtyupdate == 'Y'){
                            $qtyupdate_readonly = 'readonly="readonly"';
                        }else{
                            $qtyupdate_readonly = "";
                        }
                        if(in_array($this->usergroup, $account_user_group)):
                    ?>
                    <td>
                        <input type="text" class="form-control float prov_qty arrow_keypress" data-fieldid="prov_qty" value="<?php echo !empty($odr->purd_qty)?$odr->purd_qty:'';?>" id="prov_qty_<?php echo $key+1; ?>" data-id='<?php echo $key+1; ?>' <?php echo $qtyupdate_readonly; ?>/>
                    </td>
                    <?php
                        endif;
                    ?>

                    <td>
                        <?php echo !empty($odr->purd_rate)?number_format($odr->purd_rate,2):'0.00';?> 
                    </td>
                    <td>
                        <?php echo !empty($odr->purd_totalamt)?number_format($odr->purd_totalamt,2):'0.00';?> 
                    </td>

                    <?php
                        if(in_array($this->usergroup, $show_estimate_amt_group)):
                            ?>
                            <td>
                                <?php
                                $readonly = '';

                                if(!empty($odr->purd_estimatecost) || $approved_status == 'Y'):
                                    $readonly = 'readonly';
                                endif;
                                ?>
                                <?php
                                    // echo !empty($ord->purd_estimatecost)?$ord->purd_estimatecost:0;
                                    // echo $approved_status; 
                                ?>
                                <input type="text" value="<?php echo !empty($odr->purd_estimatecost)?$odr->purd_estimatecost:0; ?>" class="form-control estimate_cost arrow_keypress float" data-fieldid="estimate_cost" id="estimate_cost_<?php echo $key+1; ?>" data-id='<?php echo $key+1; ?>' <?php echo $readonly; ?>/>
                            </td>
                            <?php
                        endif;
                    ?>
               <!--      <td>
                        <?php echo !empty($odr->purd_estimatecost)?number_format($odr->purd_estimatecost,2):'0.00';?> 
                    </td> -->
                       <!-- IT start -->
                        <?php
                            if($this->usergroup == 'IT' || $this->usergroup == 'PR' || $this->usergroup == 'DS'):
                        ?>
                        <th width="15%">
                           <?php 
                              $it_recommend_val = $odr->rede_itrecommend; 
                              if($it_recommend_val == '1'){
                                 echo "Recommended";
                              }
                              if($it_recommend_val == '2'){
                                 echo "Not Recommended";
                              }
                              if($it_recommend_val == '3'){
                                 echo "Partial";
                              }

                           ?>   
                        </th>
                        <th width="10%">
                           <?php echo $odr->rede_itcomment; ?>
                        </th>
                        <?php
                            endif;
                        ?>
                        <!-- IT end -->
                    <td>
                        <?php echo !empty($odr->purd_remarks)?$odr->purd_remarks:'';?>
                    </td>
                    <?php
                    if(in_array($this->usergroup, $account_user_group)):
                    ?>
                    
                    <?php
                    endif;
                    ?>
                </tr>
                <?php } 
                endif;
                ?>

                <?php
                    $pure_status = !empty($requistion_data[0]->pure_status)?$requistion_data[0]->pure_status:'';

                    if($pure_status != 'D'):
                ?>

                <tr class="orderrow" id="orderrow_1" data-id='1'>
                    <!-- <tr> -->
                        <td colspan="11">
                        <?php
                        if($mat->maty_materialtypeid == '1'):
                            if($count != '0' && empty($purchase_proceed_log_status)):
                        ?>
                            <tr id="processPurchaseDiv" style="display: none;">
                                <td colspan="12">
                                    <div class="">
                                        <a href="javascript:void(0)" class="btn btn-sm btn-info proceed_to_purchase_order" id="proceed_to_purchase_order" data-materialtype = "<?php echo $mat->maty_materialtypeid; ?>">Proceed to Purchase Order</a>
                                     </div>
                                </td>
                            </tr> 
                        <?php
                                endif; // end count 0
                        ?>
                        <tr >
                            <td colspan="12">
                        <div class="purchase_process_buttons">
     <div class="btn-group pull-left">
        <?php  
            // to verify by branch manager 
          $view_order_approval_button_group = array('BM','SA');
          
          if(in_array($this->usergroup, $view_order_approval_button_group)):
            if($purchase_proceed_log_status=='S'){ ?>
            <a href="javascript:void(0)" class="btn btn-primary btnPurchaseApproval" data-val="M" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>" style="margin-right:5px;">Approve</a>

            <a href="javascript:void(0)" class="btn btn-danger btnPurchaseApproval" data-val="R" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>" style="margin-right:5px;">Reject</a>
        <?php
            }
          endif; 
        ?>

        <?php   
            // to verify by procurement supervisor
          $view_proc_supervisor_button_group = array('PS','SA');
          
          if(in_array($this->usergroup, $view_proc_supervisor_button_group)):
            if($purchase_proceed_log_status=='M'){ ?>
            <a href="javascript:void(0)" class="btn btn-primary btnPurchaseApproval" data-val="D" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>" style="margin-right:5px;">Approve</a>

            <a href="javascript:void(0)" class="btn btn-danger btnPurchaseApproval" data-val="R" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>" style="margin-right:5px;">Reject</a>
        <?php
            }
          endif; 
        ?>

        <?php   
            // to verify by procurement head
          $view_proc_head_button_group = array('PH','SA');
          
          if(in_array($this->usergroup, $view_proc_head_button_group)):
            if($purchase_proceed_log_status=='D'){ ?>
            <a href="javascript:void(0)" class="btn btn-primary btnPurchaseApproval" data-val="Y" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>" style="margin-right:5px;">Approve</a>

            <a href="javascript:void(0)" class="btn btn-danger btnPurchaseApproval" data-val="R" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>" style="margin-right:5px;">Reject</a>
        <?php
            }
          endif; 
        ?>

        <?php   
          $view_order_button_group = array('PR','SA');
          
          if(in_array($this->usergroup, $view_order_button_group)):
            //if($requistion_data[0]->pure_isapproved=='P'){ 
            if($purchase_proceed_log_status =='P'){ 
            ?>
            <a href="javascript:void(0)" class="btn btn-primary btnPurchaseApproval" data-val="S" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>">Send For Approval</a> &nbsp;
          
          <?php
            }
          endif; 
        ?>
    </div>


    <div class="btn-group pull-left">
        <?php
            if(in_array($this->usergroup, $view_order_button_group)):
                if($purchase_proceed_log_status=='Y'){ ?>
                    <hr/>
                    <strong>Select Purchase Type: </strong><br/>
                    <input type="radio" name="select_purchase_type" id="type_order" class="select_purchase_type" data-pur_type="type_order" data-mat_type="1"/>Purchase Order &nbsp;&nbsp;&nbsp;
                    <input type="radio" name="select_purchase_type" id="type_tender" class="select_purchase_type" data-pur_type="type_tender"  data-mat_type="1"/>Tender &nbsp;&nbsp;&nbsp;
                    <input type="radio" name="select_purchase_type" id="type_direct" class="select_purchase_type" data-pur_type="type_direct" data-mat_type="1" />Direct Purchase


                    <div class="div_order_1" style="display: none;">
                        <button style="margin-right: 5px;" class="btn btn-success btnredirect" data-print="print" data-viewurl="<?php echo base_url('/purchase_receive/purchase_order') ?>"  data-id="<?php echo !empty($requistion_data[0]->pure_reqno)?$requistion_data[0]->pure_reqno:''; ?>" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>">
                            <?php echo $this->lang->line('order'); ?>
                        </button>
                    </div>

                    <div class="div_tender_1" style="display: none;">
                        <button style="margin-right: 5px;" class="btn btn-success btnredirect" data-print="print" data-viewurl="<?php echo base_url('/purchase_receive/tender') ?>"  data-id="<?php echo !empty($requistion_data[0]->pure_reqno)?$requistion_data[0]->pure_reqno:''; ?>" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>">
                            <?php echo $this->lang->line('tender'); ?>
                        </button>
                    </div>

                    <div class="div_direct_1" style="display: none;">
                        <button style="margin-right: 5px;" class="btn btn-success btnredirect" data-print="print" data-viewurl="<?php echo base_url('/purchase_receive/direct_purchase') ?>"  data-id="<?php echo !empty($requistion_data[0]->pure_reqno)?$requistion_data[0]->pure_reqno:''; ?>" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>">
                            <?php echo $this->lang->line('direct_purchase'); ?>
                        </button>
                    </div>

                

        <?php
                }
            endif; 
        ?>
    </div>
</div>
</td>
</tr>

                        <?php
                        else: // else for material type
                        ?>
                        <?php 
                            $account_verification = !empty($requistion_data[0]->pure_accountverify)?$requistion_data[0]->pure_accountverify:'0'; 
                            $account_verification_div_id = $account_verification+1;

                            $previous_account_verification_flow = !empty($requistion_data[0]->pure_verifyflow)?$requistion_data[0]->pure_verifyflow:'';
                        ?>
                            <?php if($count != '' && empty($account_verification) && $previous_account_verification_flow == "F" && $this->usergroup == 'AO'): ?>

                            <tbody id="nextAccountDiv" style="display: none;">
                                <tr>
                                    <td colspan="12">
                                        <div id="">
                                            <span>
                                                Remarks (कैफियत):
                                                <input type="text" id="account_verifcation_comment" class="form-control" placeholder="Please write your verification comment" /> <br/>
                                                <a href="javascript:void(0)" data-status="A" class="btn btn-sm btn-primary" id="procced_to_next_accountant">
                                                    Proceed Ahead
                                                </a>
                                                <a href="javascript:void(0)" data-status="D" class="btn btn-sm btn-danger accountDeclineBtn">
                                                    Decline
                                                </a>
                                                <input type="hidden" value="<?php echo $account_verification; ?>" id="last_verification_level" />
                                                <!-- <input type="hidden" value="<?php //echo $account_verification_div_id; ?>" id="account_verification_level" /> -->
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>

                            <?php elseif($count != '' && $account_verification == "0" && $previous_account_verification_flow == 'B' && $this->usergroup == 'AO'): ?> 
                                <?php
                                    if(empty($purchase_proceed_log_status)):
                                ?>
                              <tbody id="processCapitalPurchaseDiv" style="display: none;">
                                <tr>
                                    <td colspan="12">
                                        <div class="">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-info proceed_to_purchase_order" id="proceed_to_purchase_order_capital" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>">Proceed to Purchase Order (Capital)</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <?php
                                endif;
                            ?>
                            <?php endif;?>

                            <?php
                                // if($count != '' && !empty($account_verification) && $account_verification >= '1' && $account_verification < '5' && $this->usergroup == 'AV'):
                                if($count != '' && !empty($account_verification && $this->usergroup == 'AV' && $account_verification == $user_accountlvl)):
                            ?>
                            <tbody id="nextAccountDiv" style="display: none;">
                                <tr>
                                    <td colspan="12">
                                        <div id="">
                                            <span>
                                                Remarks (कैफियत):
                                                <input type="text" id="account_verifcation_comment" class="form-control" placeholder="Please write your verification comment" /> <br/>

                                                <div class="row">
                                                  <!--   <div class="col-md-3">
                                                        <label>
                                                            Select Forward/Backward Verifier:
                                                        </label><br/>
                                                        <input type="radio" name="verifyflow" /> Forward
                                                        <input type="radio" name="verifyflow" /> Backward
                                                    </div> -->

                                                    <div class="col-sm-3">
                                                        <label>Next Verifier:</label>
                                                        <select id="acount_verifier" class="form-control">
                                                        <option value="0">Select Next Verifier or Continue</option>
                                                        <?php

                                                            if(!empty($account_verifier_list)):
                                                                foreach($account_verifier_list as $key=>$data):
                                                        ?>
                                                        
                                                            <option value="<?php echo $data->usma_userid.'|'.$data->usma_accountlvl;?>"><?php echo $data->usma_username; ?></option>
                                                       
                                                        <?php
                                                                endforeach;
                                                            endif;
                                                        ?>
                                                        </select>

                                                    </div>
                                                </div>

                                                <br/>
                                                <a href="javascript:void(0)" data-status="A" class="btn btn-sm btn-primary accountVerficationBtn">
                                                    Approve
                                                </a>
                                                <a href="javascript:void(0)" data-status="D" class="btn btn-sm btn-danger accountDeclineBtn">
                                                    Decline
                                                </a>
                                                <!-- <input type="hidden" value="<?php echo $account_verification_div_id; ?>" id="account_verification_level" /> -->
                                                <input type="hidden" value="<?php echo $account_verification; ?>" id="last_verification_level" />

                                                <input type="hidden" value="<?php echo $previous_account_verification_flow; ?>" id="previous_account_verification_flow" />
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <?php
                                else:
                            ?>
                            <div class="text-info">
                                <?php
                                    if($mat->maty_materialtypeid == '2'):
                                        if($count != '' && $account_verification == "0" && $previous_account_verification_flow == 'B'):
                                ?>
                                    <span class="text-success">
                                        Request verification has been completed from all level.
                                    </span>

                                    <div class="purchase_process_buttons">
     <div class="btn-group pull-left">
        <?php  
            // to verify by branch manager 
          $view_order_approval_button_group = array('BM','SA');
          
          if(in_array($this->usergroup, $view_order_approval_button_group)):
            if($purchase_proceed_log_status=='S'){ ?>
            <a href="javascript:void(0)" class="btn btn-primary btnPurchaseApproval" data-val="M" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>" style="margin-right:5px;">Approve</a>

            <a href="javascript:void(0)" class="btn btn-danger btnPurchaseApproval" data-val="R" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>" style="margin-right:5px;">Reject</a>
        <?php
            }
          endif; 
        ?>

        <?php   
            // to verify by procurement supervisor
          $view_proc_supervisor_button_group = array('PS','SA');
          
          if(in_array($this->usergroup, $view_proc_supervisor_button_group)):
            if($purchase_proceed_log_status=='M'){ ?>
            <a href="javascript:void(0)" class="btn btn-primary btnPurchaseApproval" data-val="D" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>" style="margin-right:5px;">Approve</a>

            <a href="javascript:void(0)" class="btn btn-danger btnPurchaseApproval" data-val="R" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>" style="margin-right:5px;">Reject</a>
        <?php
            }
          endif; 
        ?>

        <?php   
            // to verify by procurement head
          $view_proc_head_button_group = array('PH','SA');
          
          if(in_array($this->usergroup, $view_proc_head_button_group)):
            if($purchase_proceed_log_status=='D'){ ?>
            <a href="javascript:void(0)" class="btn btn-primary btnPurchaseApproval" data-val="Y" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>" style="margin-right:5px;">Approve</a>

            <a href="javascript:void(0)" class="btn btn-danger btnPurchaseApproval" data-val="R" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>" style="margin-right:5px;">Reject</a>
        <?php
            }
          endif; 
        ?>

        <?php   
          $view_order_button_group = array('PR','SA');
          
          if(in_array($this->usergroup, $view_order_button_group)):
            if($purchase_proceed_log_status=='P'){ ?>
            <a href="javascript:void(0)" class="btn btn-primary btnPurchaseApproval" data-val="S" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>">Send For Approval (Capital)</a> &nbsp;
          
          <?php
            }
          endif; 
        ?>
    </div>


    <div class="btn-group pull-left">
        <?php
            if(in_array($this->usergroup, $view_order_button_group)):
                if($purchase_proceed_log_status=='Y'){ ?>
                    <hr/>
                    <strong>Select Purchase Type: </strong><br/>
                    <input type="radio" name="select_purchase_type" id="type_order" class="select_purchase_type" data-pur_type="type_order" data-mat_type="2"/>Purchase Order &nbsp;&nbsp;&nbsp;
                    <input type="radio" name="select_purchase_type" id="type_tender" class="select_purchase_type" data-pur_type="type_tender" data-mat_type="2" />Tender &nbsp;&nbsp;&nbsp;
                    <input type="radio" name="select_purchase_type" id="type_direct" class="select_purchase_type" data-pur_type="type_direct" data-mat_type="2" />Direct Purchase


                    <div class="div_order_2" style="display: none;">
                        <button style="margin-right: 5px;" class="btn btn-success btnredirect" data-print="print" data-viewurl="<?php echo base_url('/purchase_receive/purchase_order') ?>"  data-id="<?php echo !empty($requistion_data[0]->pure_reqno)?$requistion_data[0]->pure_reqno:''; ?>" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>">
                            <?php echo $this->lang->line('order'); ?>
                        </button>
                    </div>

                    <div class="div_tender_2" style="display: none;">
                        <button style="margin-right: 5px;" class="btn btn-success btnredirect" data-print="print" data-viewurl="<?php echo base_url('/purchase_receive/tender') ?>"  data-id="<?php echo !empty($requistion_data[0]->pure_reqno)?$requistion_data[0]->pure_reqno:''; ?>" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>">
                            <?php echo $this->lang->line('tender'); ?>
                        </button>
                    </div>

                    <div class="div_direct_2" style="display: none;">
                        <button style="margin-right: 5px;" class="btn btn-success btnredirect" data-print="print" data-viewurl="<?php echo base_url('/purchase_receive/direct_purchase') ?>"  data-id="<?php echo !empty($requistion_data[0]->pure_reqno)?$requistion_data[0]->pure_reqno:''; ?>" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>">
                            <?php echo $this->lang->line('direct_purchase'); ?>
                        </button>
                    </div>

                

        <?php
                }
            endif; 
        ?>
    </div>
</div>
                                <?php
                                    else:
                                ?>
                                    Currently on verification level <?php echo $account_verification; ?>
                                <?php
                                        endif;
                                    endif;
                                ?>
                            </div>
                            <?php
                                endif;
                            ?>
                    
                        <?php
                      endif;
                      ?>
                       </td>
                    <!-- </tr> -->
                </tr>
                <?php else:?>
                
                <?php endif; ?>

            <?php
                endforeach; // end mat_type
            ?>

        <?php 
            if($pure_status == 'D'):
        ?>
        <tr>
            <td colspan="11" style="padding:15px 5px;">
                <span class="alert alert-danger">This request has been declined.</span>
            </td>
        </tr>
        <?php
            endif;
        ?>

        </tbody>

        <tfoot>
           <tr id="processdiv" style="display: none;">
              <td colspan="12">
                 <div class="">

                    <a href="javascript:void(0)" class="btn btn-sm btn-success" id="notify_budget_unavailable">Notify Budget Unavailable</a>
                 </div>
              </td>
           </tr>

<!--            <tr id="processPurchaseDiv" style="display: none;">
              <td colspan="12">
                 <div class="">
                    <a href="javascript:void(0)" class="btn btn-sm btn-success" id="proceed_to_purchase_order">Proceed to Purchase Order</a>
                 </div>
              </td>
           </tr>  -->

        </tfoot>

        </table>
        <table style="width:100%;" class="table purs_table dataTable con_ttl">
            <tbody>
        <?php
            if(!empty($accountant_verification_history)):
        ?>
            <tr >
                <td colspan="12">
                    <strong>Accountant Verification History</strong>
                </td>
            </tr>
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Comment</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Action By</th>
                </tr>
            </thead>
        <?php
                foreach($accountant_verification_history as $akey=>$ahistory):
        ?>
                <tr>
                    <td>
                        <?php echo $akey+1;?>
                    </td>
                    <td>
                        <?php echo $ahistory->aclo_comment;?>
                    </td>
                    <td>
                        <?php echo (DEFAULT_DATEPICKER == 'NP')?$ahistory->aclo_actiondatebs:$ahistory->aclo_actiondatead;?>
                    </td>
                    <td>
                        <?php echo $ahistory->aclo_actiontime;?>
                    </td>
                    <td>
                        <?php echo $ahistory->usma_fullname;?>
                    </td>
                </tr>
        <?php
                endforeach;
            endif;
        ?>
         </tbody>
     </table>
        </div>
    </div>

    <div class="row">
       <div class="pull-right">
            <label for="example-text"><?php echo $this->lang->line('estimated_total_amount'); ?> : </label>
            <input type="text" id="estimated_total_amount" value="<?php echo !empty($requistion_data[0]->pure_estimateamt)?$requistion_data[0]->pure_estimateamt:'0.00'; ?>" readonly/>
            
        </div>
    </div>
</div>
<?php
  endif; // end if mat type
?>

<?php
if(empty($requistion_data[0]->pure_estimateamt)):
    if(in_array($this->usergroup, $show_estimate_amt_group)):
        ?>
        <a id="btnEstimateAmt" href="javascript:void(0)" class="btn btn-primary">Save Estimate Amount</a>
        <?php
    endif;
endif;
?>

<?php
    // echo $requistion_data[0]->pure_isapproved;
    // echo $requistion_data[0]->pure_isqtyupdate;
    // seen by accountant only after status verified by procurement
    if($requistion_data[0]->pure_isapproved == 'V'):
        if(empty($requistion_data[0]->pure_isqtyupdate) || $requistion_data[0]->pure_isqtyupdate != 'Y'):
            if(in_array($this->usergroup, $account_user_group)):
                ?>
                <a id="btnProcQty" href="javascript:void(0)" class="btn btn-primary">Save Qty To Provide</a>
                <?php
            endif;
        elseif($requistion_data[0]->pure_isqtyupdate == 'Y'):
            ?>
            <div class="text-info">Quanity to provide was updated.</div>
            <?php
        endif;
    endif;
?>

<div class="col-sm-12">
  <div  class="alert-success successDiv"></div>
  <div class="alert-danger errorDiv"></div>
</div>

<div class="col-sm-12">
    <div class="row">
    <?php
        $req_masterid = !empty($requistion_data[0]->pure_reqmasterid)?$requistion_data[0]->pure_reqmasterid:'';

        $reqno = !empty($requistion_data[0]->pure_streqno)?$requistion_data[0]->pure_streqno:'';

        $remafyear = !empty($requistion_data[0]->pure_fyear)?$requistion_data[0]->pure_fyear:'';

        $history_data = $this->general->get_history_data($req_masterid, $reqno, $remafyear,'desc'); 

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

<div id="FormDiv_Reprint" class="printTable"></div>

<style>
    .showCancel { display: none;}
    .showUnapproved { display: none;}
</style>

<script type="text/javascript">
    $(document).off('click','.btnredirect');
    $(document).on('click','.btnredirect',function(){
        var pure_id=$(this).data('id');
        var mat_type_id=$(this).data('materialtype');
        var url=$(this).data('viewurl');
        var redirecturl=url;
        $.redirectPost(redirecturl, {pure_id:pure_id, mat_type_id:mat_type_id });
    })
</script>

<script type="text/javascript">
    $(document).off('click','.btnSelectNotAvailable');
    $(document).on('click','.btnSelectNotAvailable',function(e){
      $(this).toggleClass("select");  
      var curclassname=this.className;
      
      if (curclassname.indexOf('select') > -1) {
         $(".budgetnotavailable").each(function() {
            this.checked=true;
         });
         
         $(".budgetavailable").each(function() {
            this.checked=false;
         });

         var available_count = $('.budgetnotavailable').length;

         if(available_count > 0){
            $('#processdiv').show();
            $('.btnSelectNotAvailable').text('Unselect Unavailable Budget');
         }

         // $('#processdiv').show();
         $('#processPurchaseDiv').hide();
         $('#processCapitalPurchaseDiv').hide();
         $('#nextAccountDiv').hide();
          $('#nextAccountCommentDiv').hide();
      } else {
         $(".budgetnotavailable").each(function() {
            this.checked=false;
         });
         $('#processdiv').hide();
         $('.btnSelectNotAvailable').text('Select Unavailable Budget');
      }
    });

    $(document).off('click','.btnSelectAvailable');
    $(document).on('click','.btnSelectAvailable',function(e){
      $(this).toggleClass("select");  
      var curclassname=this.className;
      
      if (curclassname.indexOf('select') > -1) {
         $(".budgetavailable").each(function() {
            this.checked=true;
         });
         
         $(".budgetnotavailable").each(function() {
            this.checked=false;
         });
         
         var available_count = $('.budgetavailable').length;

         if(available_count > 0){
            $('#processPurchaseDiv').show();
            $('#processCapitalPurchaseDiv').show();
            $('#nextAccountDiv').show();
            $('#nextAccountCommentDiv').show();
            $('.btnSelectAvailable').text('Unselect Available Budget');
         }
         $('#processdiv').hide();
         
      } else {
         $(".budgetavailable").each(function() {
            this.checked=false;
         });
         $('#processPurchaseDiv').hide();
         $('#processCapitalPurchaseDiv').hide();
         $('#nextAccountDiv').hide();
         $('#nextAccountCommentDiv').hide();
         $('.btnSelectAvailable').text('Select Available Budget');
      }
    });
</script>

<script>
    $(document).off('click','.proceed_to_purchase_order');
    $(document).on('click','.proceed_to_purchase_order', function(){
      // var req_no=$('#req_no').val();
      // var fyear=$('#fyear').val();
      var masterid = '<?php echo !empty($requistion_data[0]->pure_purchasereqid)?$requistion_data[0]->pure_purchasereqid:'';  ?>';
      var streqno = '<?php echo !empty($requistion_data[0]->pure_streqno)?$requistion_data[0]->pure_streqno:'';  ?>';

      var materialtype = $(this).data('materialtype');

      var itemlist = [];
      $.each($("input.material_type_"+materialtype+"[name='itemsid[]']:checked"), function(){            
         itemlist.push($(this).val());
      });

      // console.log(itemlist);
      // return false;

      var submitData = {masterid:masterid, itemlist:itemlist, streqno:streqno, materialtype:materialtype};

      var submitUrl = base_url+'purchase_receive/purchase_requisition/proceed_to_purchase_order';

      beforeSend= $('.overlay').modal('show');

      ajaxPostSubmit(submitUrl, submitData, beforeSend='',onSuccess);

      function onSuccess(response){
         data = jQuery.parseJSON(response);   

         if(data.status=='success'){
            $('.successDiv').addClass('alert').html(data.message);
            $('.successDiv').show();
         }else{
            $('.errorDiv').addClass('alert').html(data.message);
            $('.errorDiv').show();
         }
         $('.overlay').modal('hide');
         setTimeout(function(){
            $('#myView').modal('hide');
            $( "#searchByDate" ).trigger("click");
         },1000); 
      }
   });
</script>

<script>
    $(document).off('click','#notify_budget_unavailable');
    $(document).on('click','#notify_budget_unavailable', function(){
      // var req_no=$('#req_no').val();
      // var fyear=$('#fyear').val();
      var masterid = '<?php echo !empty($requistion_data[0]->pure_purchasereqid)?$requistion_data[0]->pure_purchasereqid:'';  ?>';
      var req_no = '<?php echo !empty($requistion_data[0]->pure_streqno)?$requistion_data[0]->pure_streqno:'';  ?>';
      var fyear = '<?php echo !empty($requistion_data[0]->pure_fyear)?$requistion_data[0]->pure_fyear:'';  ?>';
      var itemlist = [];
      $.each($("input[name='itemsid[]']:checked"), function(){            
         itemlist.push($(this).val());
      });

      var submitData = { masterid:masterid, itemlist:itemlist, req_no:req_no, fyear:fyear };

      var submitUrl = base_url+'purchase_receive/purchase_requisition/notify_budget_unavailable';

      beforeSend= $('.overlay').modal('show');

      ajaxPostSubmit(submitUrl, submitData, beforeSend='',onSuccess);

      function onSuccess(response){
         data = jQuery.parseJSON(response);   

         if(data.status=='success'){
            $('.successDiv').addClass('alert').html(data.message);
            $('.successDiv').show();
         }else{
            $('.errorDiv').addClass('alert').html(data.message);
            $('.errorDiv').show();
         }
         $('.overlay').modal('hide');
         setTimeout(function(){
            $('#myView').modal('hide');
            $( "#searchByDate" ).trigger("click");
         },1000); 
      }
   });
</script>

<script type="text/javascript">
  $(document).off('click','.btnPurchaseApproval');
  $(document).on('click','.btnPurchaseApproval',function(){

    var approve_status = $(this).data('val');

    var masterid = '<?php echo !empty($requistion_data[0]->pure_purchasereqid)?$requistion_data[0]->pure_purchasereqid:'';  ?>';
    var req_no = '<?php echo !empty($requistion_data[0]->pure_streqno)?$requistion_data[0]->pure_streqno:'';  ?>';

    var materialtype = $(this).data('materialtype');

    var itemlist = [];
      $.each($("input.material_type_"+materialtype+"[name='itemsid[]']"), function(){            
         itemlist.push($(this).val());
      });

    var submitData = { masterid:masterid, req_no:req_no, approve_status:approve_status, materialtype:materialtype, itemlist:itemlist };

    var submitUrl = base_url+'purchase_receive/purchase_requisition/send_to_purchase_order_approval';

    beforeSend= $('.overlay').modal('show');

    ajaxPostSubmit(submitUrl, submitData, beforeSend='',onSuccess);

    // alert('test');

    function onSuccess(response){
       data = jQuery.parseJSON(response);   

       if(data.status=='success'){
          $('.successDiv').addClass('alert').html(data.message);
          $('.successDiv').show();
       }else{
          $('.errorDiv').addClass('alert').html(data.message);
          $('.errorDiv').show();
       }
       $('.overlay').modal('hide');
       setTimeout(function(){
          $('#myView').modal('hide');
          $( "#searchByDate" ).trigger("click");
       },1000); 
    }
  });
</script>

<script>
    $(document).off('click','#procced_to_next_accountant');
    $(document).on('click','#procced_to_next_accountant',function(){
        // var nextid = $(this).data('nextid');

        // $('#nextAccountDiv'+nextid).show();

        var account_verification_comment = $('#account_verifcation_comment').val();
        // var account_verification_status = $(this).data('status');
        // var account_verification_level = $('#account_verification_level').val();
        var account_verification_level = 1;

        var masterid = '<?php echo !empty($requistion_data[0]->pure_purchasereqid)?$requistion_data[0]->pure_purchasereqid:'';  ?>';
        var req_no = '<?php echo !empty($requistion_data[0]->pure_streqno)?$requistion_data[0]->pure_streqno:'';  ?>';

        var submitData = { masterid:masterid, req_no:req_no, account_verification_level:account_verification_level, account_verification_comment:account_verification_comment };

        var submitUrl = base_url+'purchase_receive/purchase_requisition/procced_to_next_accountant';

        beforeSend= $('.overlay').modal('show');

        ajaxPostSubmit(submitUrl, submitData, beforeSend='',onSuccess);

        // alert('test');

        function onSuccess(response){
           data = jQuery.parseJSON(response);   

           if(data.status=='success'){
              $('.successDiv').addClass('alert').html(data.message);
              $('.successDiv').show();
           }else{
              $('.errorDiv').addClass('alert').html(data.message);
              $('.errorDiv').show();
           }
           $('.overlay').modal('hide');
           setTimeout(function(){
              $('#myView').modal('hide');
              $( "#searchByDate" ).trigger("click");
           },1000); 
        }

    });

    $(document).off('click', '.accountVerficationBtn');
    $(document).on('click', '.accountVerficationBtn',function(){
        var account_verifcation_comment = $('#account_verifcation_comment').val();

        if(account_verifcation_comment == ''){
            $('.errorDiv').addClass('alert').html('Please enter a comment');
            return false;
        }
        var account_verification_status = $(this).data('status');
        // var account_verification_level = $('#account_verification_level').val();
        var last_verification_level = $('#last_verification_level').val();
        var previous_account_verification_flow = $('#previous_account_verification_flow').val();

        var account_verifier = $('#acount_verifier').val();

        var masterid = '<?php echo !empty($requistion_data[0]->pure_purchasereqid)?$requistion_data[0]->pure_purchasereqid:'';  ?>';
        var req_no = '<?php echo !empty($requistion_data[0]->pure_streqno)?$requistion_data[0]->pure_streqno:'';  ?>';

        var submitData = { masterid:masterid, req_no:req_no, account_verifcation_comment:account_verifcation_comment, account_verification_status:account_verification_status, account_verifier:account_verifier, last_verification_level:last_verification_level, previous_account_verification_flow:previous_account_verification_flow };

        var submitUrl = base_url+'purchase_receive/purchase_requisition/procced_to_next_accountant_verifier';

        beforeSend= $('.overlay').modal('show');

        ajaxPostSubmit(submitUrl, submitData, beforeSend='',onSuccess);

        // alert('test');

        function onSuccess(response){
           data = jQuery.parseJSON(response);   

           if(data.status=='success'){
              $('.successDiv').addClass('alert').html(data.message);
              $('.successDiv').show();
           }else{
              $('.errorDiv').addClass('alert').html(data.message);
              $('.errorDiv').show();
           }
           $('.overlay').modal('hide');
           setTimeout(function(){
              $('#myView').modal('hide');
              $( "#searchByDate" ).trigger("click");
           },1000); 
        }
    });

    $(document).off('click','.accountDeclineBtn');
    $(document).on('click','.accountDeclineBtn',function(){
        // var nextid = $(this).data('nextid');

        // $('#nextAccountDiv'+nextid).show();

        var account_verification_comment = $('#account_verifcation_comment').val();
        // var account_verification_status = $(this).data('status');
        // var account_verification_level = $('#account_verification_level').val();

        var account_status = 'D';

        var masterid = '<?php echo !empty($requistion_data[0]->pure_purchasereqid)?$requistion_data[0]->pure_purchasereqid:'';  ?>';
        var req_no = '<?php echo !empty($requistion_data[0]->pure_streqno)?$requistion_data[0]->pure_streqno:'';  ?>';

        var submitData = { masterid:masterid, req_no:req_no, account_status:account_status, account_verification_comment:account_verification_comment };

        var submitUrl = base_url+'purchase_receive/purchase_requisition/procced_to_next_accountant';

        beforeSend= $('.overlay').modal('show');

        ajaxPostSubmit(submitUrl, submitData, beforeSend='',onSuccess);

        // alert('test');

        function onSuccess(response){
           data = jQuery.parseJSON(response);   

           if(data.status=='success'){
              $('.successDiv').addClass('alert').html(data.message);
              $('.successDiv').show();
           }else{
              $('.errorDiv').addClass('alert').html(data.message);
              $('.errorDiv').show();
           }
           $('.overlay').modal('hide');
           setTimeout(function(){
              $('#myView').modal('hide');
              $( "#searchByDate" ).trigger("click");
           },1000); 
        }

    });
</script>


<script type="text/javascript">
    // estimate cost
    $(document).off('click','#btnEstimateAmt');
    $(document).on('click','#btnEstimateAmt',function(){
        var all_estimate_cost = [];
        var all_items_id = [];

        $('.estimate_cost').each(function(){
            all_estimate_cost.push($(this).val());
        });

        $(".items_id").each(function() {
            all_items_id.push($(this).val());
        });

        var total_estimate_cost = $('#estimated_total_amount').val();

        var masterid = '<?php echo !empty($requistion_data[0]->pure_purchasereqid)?$requistion_data[0]->pure_purchasereqid:'';  ?>';

        var streqno = '<?php echo !empty($requistion_data[0]->pure_streqno)?$requistion_data[0]->pure_streqno:'';  ?>';

        var submitData = { all_estimate_cost:all_estimate_cost, total_estimate_cost:total_estimate_cost, masterid:masterid, all_items_id: all_items_id, streqno:streqno };

        var submitUrl = base_url+'purchase_receive/purchase_requisition/update_estimate_amount';

        beforeSend= $('.overlay').modal('show');

        ajaxPostSubmit(submitUrl, submitData, beforeSend='',onSuccess);

        function onSuccess(response){
            data = jQuery.parseJSON(response);   

            if(data.status=='success'){
                $('.successDiv').addClass('alert').html(data.message);
                $('.successDiv').show();
            }else{
                $('.errorDiv').addClass('alert').html(data.message);
                $('.errorDiv').show();
            }
            $('.overlay').modal('hide');
            setTimeout(function(){
                $('#myView').modal('hide');
                $( "#searchByDate" ).trigger("click");
            },1000);

        }

    });

    // qty to provide
    $(document).off('click','#btnProcQty');
    $(document).on('click','#btnProcQty',function(){
        var all_prov_qty = [];
        var all_cur_qty = [];
        var all_items_id = [];

        $('.prov_qty').each(function(){
            all_prov_qty.push($(this).val());
        });

        $('.cur_qty').each(function(){
            all_cur_qty.push($(this).val());
        });

        $(".items_id").each(function() {
            all_items_id.push($(this).val());
        });

        var total_estimate_cost = $('#estimated_total_amount').val();

        var masterid = '<?php echo !empty($requistion_data[0]->pure_purchasereqid)?$requistion_data[0]->pure_purchasereqid:'';  ?>';

        var streqno = '<?php echo !empty($requistion_data[0]->pure_streqno)?$requistion_data[0]->pure_streqno:'';  ?>';

        var fyear = '<?php echo !empty($requistion_data[0]->pure_fyear)?$requistion_data[0]->pure_fyear:'';  ?>';

        var submitData = { all_prov_qty:all_prov_qty, all_cur_qty:all_cur_qty, total_estimate_cost:total_estimate_cost, masterid:masterid, all_items_id: all_items_id, streqno:streqno, fyear:fyear };

        var submitUrl = base_url+'purchase_receive/purchase_requisition/update_qty_to_provide';

        beforeSend= $('.overlay').modal('show');

        ajaxPostSubmit(submitUrl, submitData, beforeSend='',onSuccess);

        function onSuccess(response){
            data = jQuery.parseJSON(response);   

            if(data.status=='success'){
                $('.successDiv').addClass('alert').html(data.message);
                $('.successDiv').show();
            }else{
                $('.errorDiv').addClass('alert').html(data.message);
                $('.errorDiv').show();
            }
            $('.overlay').modal('hide');
            setTimeout(function(){
                $('#myView').modal('hide');
                $( "#searchByDate" ).trigger("click");
            },1000);

        }

    });


    <?php
    if($approved_status <> 'Y'):
        ?>
        $(document).off('change keyup','.estimate_cost');
        $(document).on('change keyup','.estimate_cost',function(){
            // alert ('tesdr');
            var estimate_total = 0;

            var valid_estimate_total = 0;

            $('.estimate_cost').each(function(){
                valid_cost = checkValidValue($(this).val());
                estimate_total += parseFloat(valid_cost);
                valid_estimate_total = checkValidValue(estimate_total);
            });

            setTimeout(function(){
                $('#estimated_total_amount').val(valid_estimate_total.toFixed(2));
            }, 100);

        });
        <?php
    endif;
    ?>
</script>

<script> 
    $(document).off('click','.cancel');
    $(document).on('click','.cancel',function(){
        var status = $('form input[type=radio]:checked').val();
        if(status == 'N')
        {
            $('.showUnapproved').show();  
        }else{
            $('.showUnapproved').hide();  
        }
        if(status == 'C')
        {
            $('.showCancel').show();
        }else{
            $('.showCancel').hide();  
        }
    })
</script>

<script>
    $(document).off('click','.select_purchase_type');
    $(document).on('click','.select_purchase_type',function(){
        var pur_type = $(this).data('pur_type');
        var mat_type = $(this).data('mat_type');

        if(pur_type == 'type_order'){
            $('.div_order_'+mat_type).show();
            $('.div_tender_'+mat_type).hide();
            $('.div_direct_'+mat_type).hide();
        }else if(pur_type == 'type_tender'){
            $('.div_order_'+mat_type).hide();
            $('.div_tender_'+mat_type).show();
            $('.div_direct_'+mat_type).hide();
        }else if(pur_type == 'type_direct'){
            $('.div_order_'+mat_type).hide();
            $('.div_tender_'+mat_type).hide();
            $('.div_direct_'+mat_type).show();
        }
    });
</script>