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

       
    </div>
 <div class="btn-group pull-right">
    <?php   
      $view_order_approval_button_group = array('BM','SA');
      
      if(in_array($this->usergroup, $view_order_approval_button_group)):
        if($requisition_details[0]->pure_isapproved=='S'){ ?>
      <a href="javascript:void(0)" class="btn btn-primary btnPurchaseApproval" data-val="Y" style="margin-right:5px;">Approve</a> 
      <a href="javascript:void(0)" class="btn btn-danger btnPurchaseApproval" data-val="R" style="margin-right:5px;">Reject</a>
    <?php
        }
      endif; 
    ?>

    <?php   
      $view_order_button_group = array('PR','SA');
      
      if(in_array($this->usergroup, $view_order_button_group)):
        if($requisition_details[0]->pure_isapproved=='P'){ ?>
        <a href="javascript:void(0)" class="btn btn-primary btnPurchaseApproval" data-val="S">Send For Approval</a> &nbsp;
      
      <?php
        }
      endif; 
    ?>
    <?php
      if(in_array($this->usergroup, $view_order_button_group)):
        if($requisition_details[0]->pure_isapproved=='Y'){ ?>
      <button style="margin-right: 5px;" class="btn btn-success btnredirect" data-print="print" data-viewurl="<?php echo base_url('/purchase_receive/purchase_order') ?>"  data-id="<?php echo !empty($requisition_details[0]->pure_reqno)?$requisition_details[0]->pure_reqno:''; ?>"><?php echo $this->lang->line('order'); ?></button>
    <?php
        }
      endif; 
    ?>

       <?php   if($requisition_details[0]->pure_isapproved !='C'){ ?>
    <button class="btn btn-success PrintThisNow ReprintThis pull-right" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('/purchase_receive/purchase_requisition/purchase_requisition_reprint') ?>" data-viewdiv="FormDiv_Reprint" data-id="<?php echo !empty($requisition_details[0]->pure_purchasereqid)?$requisition_details[0]->pure_purchasereqid:''; ?>"><?php echo $this->lang->line('print'); ?></button>
    <?php } ?>
</div>
    <div class="clearfix"></div>
</div>

<?php
    if(in_array($this->usergroup, $account_user_group)):
 ?>
 <div>
    <?php
        if($this->usergroup == 'AO'):
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
                    <th width="8%"> <?php echo $this->lang->line('rate'); ?> </th> 
                    <th width="8%"> <?php echo $this->lang->line('total_amt'); ?> </th> 
                    <th width="8%"> <?php echo $this->lang->line('estimate_cost'); ?> </th> 
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
              // $req_detail_list = $this->stock_requisition_mdl->get_requisition_details_data(array('rd.rede_reqmasterid'=>$rede_reqmasterid,'rd.rede_isdelete'=>'N','it.itli_materialtypeid'=>$mat->maty_materialtypeid));
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

                    if($purchase_requisition) { 
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
                                }else{
                                    $budget_class = "budgetnotavailable";
                                }
                            ?>

                            <?php
                               if($odr->purd_proceedorder != 'Y'):
                            ?>
                            <input type="checkbox" name="itemsid[]" value="<?php echo !empty($odr->purd_itemsid)?$odr->purd_itemsid:'';?>" class="itemcheck <?php echo $budget_class;?> <?php echo 'material_type_'.$mat->maty_materialtypeid; ?>" />
                            <?php
                                endif;
                            ?>
                        </td>
                    <?php endif; ?>
                    <td>
                         <?php echo $key+1; ?>
                    </td>
                    <td>
                        <?php echo !empty($odr->itli_itemcode)?$odr->itli_itemcode:'';?> 
                    </td>
                    <td>
                        <?php echo $req_itemname;?> 
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
                        <?php echo !empty($odr->purd_estimatecost)?number_format($odr->purd_estimatecost,2):'0.00';?> 
                    </td>
                    <td>
                        <?php echo !empty($odr->purd_remarks)?$odr->purd_remarks:'';?>
                    </td>
                    <?php
                    if(in_array($this->usergroup, $account_user_group)):
                    ?>
                     <!--    <td>
                            <?php
                                $available_budget_amount = !empty($odr->budg_availableamt)?$odr->budg_availableamt:0;
                                echo number_format($available_budget_amount,2) 
                            ?>
                        </td>
                        <td>
                        <?php
                            $budget_status = !empty($odr->budget_status)?$odr->budget_status:''; 
                            if($budget_status == 'Y'):
                        ?>
                        <span class="badge badge-sm badge-success">Available</span>
                        <?php
                        else:
                        ?>
                        <span class="badge badge-sm badge-danger">Not Available</span>
                        <?php endif; ?>
                        </td> -->
                    <?php
                    endif;
                    ?>
                </tr>
                <?php } } 
                endif;
                ?>
                    <tr class="orderrow" id="orderrow_1" data-id='1'>
                      <tr>
                        <td colspan="11">
                        <?php
                        if($mat->maty_materialtypeid == '1'):
                            if($count != '0'):
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
                        ?>
                            <?php if($count != '' && $account_verification < '1'): ?>
                            <tbody id="nextAccountDiv" style="display: none;">
                                <tr>
                                    <td colspan="12">
                                        <div class="">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-info" id="procced_to_next_accountant" data-nextid="<?php echo $account_verification_div_id; ?>">Proceed Ahead (Step <?php echo $account_verification_div_id; ?>)</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <?php elseif($count != '' && $account_verification >='5'): ?> 
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
                                if($count != '' && !empty($account_verification) && $account_verification >= '1' && $account_verification < '5' && $this->usergroup == 'AV'):
                            ?>
                            <tbody id="nextAccountCommentDiv" style="display: none;">
                                <tr>
                                    <td colspan="12">
                                        <div id="">
                                            <span>
                                                Verification Comment:
                                                <input type="text" id="account_verifcation_comment" class="form-control" placeholder="Please write your verification comment" />
                                                <a href="javascript:void(0)" data-status="A" class="btn btn-sm btn-primary accountVerficationBtn">
                                                    Approve
                                                </a>
                                                <a href="javascript:void(0)" data-status="D" class="btn btn-sm btn-primary accountVerficationBtn">
                                                    Decline
                                                </a>
                                                <input type="hidden" value="<?php echo $account_verification_div_id; ?>" id="account_verification_level" />
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <?php
                                endif;
                            ?>
                    
                        <?php
                      endif;
                      ?>
                       </td>
                    </tr>
              <?php
              endforeach;
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
      var masterid = '<?php echo !empty($requisition_details[0]->pure_purchasereqid)?$requisition_details[0]->pure_purchasereqid:'';  ?>';
      var streqno = '<?php echo !empty($requisition_details[0]->pure_streqno)?$requisition_details[0]->pure_streqno:'';  ?>';

      var materialtype = $(this).data('materialtype');

      var itemlist = [];
      $.each($("input.material_type_"+materialtype+"[name='itemsid[]']:checked"), function(){            
         itemlist.push($(this).val());
      });

      // console.log(itemlist);
      // return false;

      var submitData = {masterid:masterid, itemlist:itemlist, streqno:streqno};

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
      var masterid = '<?php echo !empty($requisition_details[0]->pure_purchasereqid)?$requisition_details[0]->pure_purchasereqid:'';  ?>';
      var req_no = '<?php echo !empty($requisition_details[0]->pure_streqno)?$requisition_details[0]->pure_streqno:'';  ?>';
      var fyear = '<?php echo !empty($requisition_details[0]->pure_fyear)?$requisition_details[0]->pure_fyear:'';  ?>';
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

    var masterid = '<?php echo !empty($requisition_details[0]->pure_purchasereqid)?$requisition_details[0]->pure_purchasereqid:'';  ?>';
    var req_no = '<?php echo !empty($requisition_details[0]->pure_streqno)?$requisition_details[0]->pure_streqno:'';  ?>';

    var submitData = { masterid:masterid, req_no:req_no, approve_status:approve_status };

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

        // var account_verifcation_comment = $('#account_verifcation_comment').val();
        // var account_verification_status = $(this).data('status');
        // var account_verification_level = $('#account_verification_level').val();
        var account_verification_level = 1;

        var masterid = '<?php echo !empty($requisition_details[0]->pure_purchasereqid)?$requisition_details[0]->pure_purchasereqid:'';  ?>';
        var req_no = '<?php echo !empty($requisition_details[0]->pure_streqno)?$requisition_details[0]->pure_streqno:'';  ?>';

        var submitData = { masterid:masterid, req_no:req_no, account_verification_level:account_verification_level };

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
        var account_verification_status = $(this).data('status');
        var account_verification_level = $('#account_verification_level').val();

        var masterid = '<?php echo !empty($requisition_details[0]->pure_purchasereqid)?$requisition_details[0]->pure_purchasereqid:'';  ?>';
        var req_no = '<?php echo !empty($requisition_details[0]->pure_streqno)?$requisition_details[0]->pure_streqno:'';  ?>';

        var submitData = { masterid:masterid, req_no:req_no, account_verifcation_comment:account_verifcation_comment, account_verification_status:account_verification_status, account_verification_level:account_verification_level };

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