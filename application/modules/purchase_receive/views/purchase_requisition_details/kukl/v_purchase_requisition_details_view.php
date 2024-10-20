<?php
    $account_user_group = array('AO','AV');
?>
<div class="form-group white-box pad-5">
    <div class="row">
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('requisition_no'); ?> : </label>
            <?php echo !empty($requisition_details[0]->pure_reqno)?$requisition_details[0]->pure_reqno:''; ?>
        </div>
        
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('requisition_date'); ?>  (AD) : </label><?php echo !empty($requisition_details[0]->pure_reqdatead)?$requisition_details[0]->pure_reqdatead:''; ?>
        </div>
        
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('requisition_date'); ?>  (BS) : </label><?php echo !empty($requisition_details[0]->pure_reqdatebs)?$requisition_details[0]->pure_reqdatebs:''; ?>
        </div>
        
        <div class="col-md-3 col-sm-4">
            <?php $time=!empty($requisition_details[0]->pure_posttime)?$requisition_details[0]->pure_posttime:''; //print_r($datedb);die;?>
              <label for="example-text"><?php echo $this->lang->line('requisition_time'); ?> : </label>
            <?php echo $time;?>
        </div>
        
        <div class="clearfix"></div>
        
        <div class="col-md-3 col-sm-4">
            <label for=""><?php echo $this->lang->line('item_types'); ?> : </label>
            <?php $storeid = !empty($requisition_details[0]->pure_itemstypeid)?$requisition_details[0]->pure_itemstypeid:''; $store = $this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$storeid ),'eqty_equipmenttypeid','DESC');
            echo !empty($store[0]->eqty_equipmenttype)?$store[0]->eqty_equipmenttype:''; ?>
        </div>

        <div class="col-md-3 col-sm-4">
            <?php $locaname=!empty($requisition_details[0]->loca_name)?$requisition_details[0]->loca_name:''; //print_r($datedb);die;?>
            <label for="example-text"><?php echo $this->lang->line('requisition_time'); ?> : </label>
            <?php echo $locaname;?>
        </div> 
     <!--    <div class="col-md-3 col-sm-4">
            <?php $requisitionno=!empty($requisition_details[0]->puor_orderno)?$requisition_details[0]->puor_orderno:''; ?>
            <label for="example-text">Order Number <span class="required">*</span>:</label>
            <?php echo $requisitionno; ?>
        </div>
        <div class="col-md-3 col-sm-4">
          <label for="example-text">Delivery Site : </label> 
           <?php $dsite=!empty($requisition_details[0]->puor_deliverysite)?$requisition_details[0]->puor_deliverysite:''; ?><?php echo $dsite; ?>
          <span class="errmsg"></span>
        </div>
        <div class="col-md-3 col-sm-4">
            <?php $puor_requno=!empty($requisition_details[0]->puor_requno)?$requisition_details[0]->puor_requno:''; ?>
            <label for="example-text">Requistion Number : </label>
            <?php echo $puor_requno; ?>
          <span class="errmsg"></span>
        </div> -->
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> : </label>
            <?php echo !empty($requisition_details[0]->pure_fyear)?$requisition_details[0]->pure_fyear:''; ?>
        </div>
        
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('requisited_by'); ?> : </label>
            <?php echo !empty($requisition_details[0]->pure_appliedby)?$requisition_details[0]->pure_appliedby:''; ?>
        </div> 
        
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('status'); ?> : </label>
          
              <span><?php 
            $approved_status=!empty($requisition_details[0]->pure_isapproved)?$requisition_details[0]->pure_isapproved:'';
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
                $work_description=!empty($requisition_details[0]->rema_workdesc)?$requisition_details[0]->rema_workdesc:'';
                echo $work_description;
            ?>
        </div>
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('work_place'); ?> </label>:
           <?php 
                $workplace=!empty($requisition_details[0]->rema_workplace)?$requisition_details[0]->rema_workplace:'';
                echo $workplace;
            ?>
        </div>
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('remarks'); ?> </label>:
           <?php 
                $work_remask=!empty($requisition_details[0]->rema_remarks)?$requisition_details[0]->rema_remarks:'';
                echo $work_remask;
            ?>
        </div>

       
    </div>
    
    <div class="btn-group pull-right">
        <?php   
            if($requisition_details[0]->pure_isapproved !='C'){ ?>
                <button class="btn btn-success PrintThisNow ReprintThis pull-right" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('/purchase_receive/purchase_requisition/purchase_requisition_reprint') ?>" data-viewdiv="FormDiv_Reprint" data-id="<?php echo !empty($requisition_details[0]->pure_purchasereqid)?$requisition_details[0]->pure_purchasereqid:''; ?>">
                    <?php echo $this->lang->line('print'); ?>
                </button>
        <?php 
            } 
        ?>
    </div>

    <div class="clearfix"></div>
</div>

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
                    <th width="8%"> <?php echo $this->lang->line('rate'); ?> </th> 
                    <th width="8%"> <?php echo $this->lang->line('total_amt'); ?> </th> 
                    <th width="8%"> <?php echo $this->lang->line('estimate_cost'); ?> </th> 
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

                          <!--   <?php
                               if($odr->purd_proceedorder != 'Y'):
                            ?>
                            <input type="checkbox" name="itemsid[]" value="<?php echo !empty($odr->purd_itemsid)?$odr->purd_itemsid:'';?>" class="itemcheck <?php echo $budget_class;?> <?php echo 'material_type_'.$mat->maty_materialtypeid; ?>" />
                            <?php
                                endif;
                            ?> -->
                        </td>
                    <?php endif; ?>
                    <td>
                         <?php echo $key+1; ?>
                    </td>
                    <td>
                        <span class="<?php echo !empty($budgetClass)?$budgetClass:''; ?>">
                        <?php echo !empty($odr->itli_itemcode)?$odr->itli_itemcode:'';?>
                        </span> 
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
                    </td>
                    <td>
                        <?php echo !empty($odr->purd_rate)?number_format($odr->purd_rate,2):'0.00';?> 
                    </td>
                    <td>
                        <?php echo !empty($odr->purd_totalamt)?number_format($odr->purd_totalamt,2):'0.00';?> 
                    </td>
                    <td>
                        <?php echo !empty($odr->purd_estimatetotal)?number_format($odr->purd_estimatetotal,2):'0.00';?> 
                    </td>
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
                        <?php echo !empty($odr->rmd_remarks)?$odr->rmd_remarks:'';?>
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
                    $pure_status = !empty($requisition_details[0]->pure_status)?$requisition_details[0]->pure_status:'';

                    if($pure_status != 'D'):
                ?>

                <tr class="orderrow" id="orderrow_1" data-id='1'>
                    <!-- <tr> -->
                        <td colspan="11">
                        <?php
                        if($mat->maty_materialtypeid == '1'):
                            if($count != '0' && $approved_status != 'P'):
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
                        else: // else for material type
                        ?>
                        <?php 
                            $account_verification = !empty($requisition_details[0]->pure_accountverify)?$requisition_details[0]->pure_accountverify:'0'; 
                            $account_verification_div_id = $account_verification+1;

                            $previous_account_verification_flow = !empty($requisition_details[0]->pure_verifyflow)?$requisition_details[0]->pure_verifyflow:'';
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
                              <tbody id="processCapitalPurchaseDiv" style="display: none;">
                                <tr>
                                    <td colspan="12">
                                        <div class="">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-info proceed_to_purchase_order" id="proceed_to_purchase_order_capital" data-materialtype="<?php echo $mat->maty_materialtypeid; ?>">Proceed to Purchase Order (Capital)</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
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
                <tr>
                    <td colspan="11" style="padding:15px 5px;">
                        <span class="alert alert-danger">This request has been declined.</span>
                    </td>
                </tr>
                <?php endif; ?>

            <?php
                endforeach; // end mat_type
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
            <?php echo !empty($requisition_details[0]->pure_estimateamt)?$requisition_details[0]->pure_estimateamt:'0.00'; ?>
        </div>
    </div>
</div>
<?php
  endif; // end if mat type
?>

<div class="col-sm-12">
  <div  class="alert-success successDiv"></div>
  <div class="alert-danger errorDiv"></div>
</div>
<div id="FormDiv_Reprint" class="printTable"></div>

<script type="text/javascript">
    $(document).off('click','.btnredirect');
    $(document).on('click','.btnredirect',function(){
        var pure_id=$(this).data('id');
        var url=$(this).data('viewurl');
        var redirecturl=url;
        $.redirectPost(redirecturl, {pure_id:pure_id });
    })
</script>