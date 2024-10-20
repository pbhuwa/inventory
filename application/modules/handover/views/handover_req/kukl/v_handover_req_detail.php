<?php
  $store_btn_grp = array('SI','SK','SA'); 
  $dephead_btn_grp = array('DH','SA'); 
  $bm_btn_grp = array('BM','SA'); 
?>
<style>
    .mcolor{
        background: #FF8C00 !important;
    }
</style>
<div class="form-group white-box pad-5 bg-gray">
    <input type="hidden" id="handovermasterid" value="<?php echo !empty($handovermasterid)?$handovermasterid:''; ?>">
    <div class="row">
        <div class="col-sm-4 col-xs-6">
            <label><?php echo $this->lang->line('requisition_no'); ?></label>: 
            <span> <?php echo !empty($handover_requisition_details[0]->harm_handoverreqno)?$handover_requisition_details[0]->harm_handoverreqno:''; ?></span>
        </div>
        
        <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('manual_no'); ?></label> : 
            <span><?php echo !empty($handover_requisition_details[0]->harm_manualno)?$handover_requisition_details[0]->harm_manualno:'0'; ?></span>
        </div>
        
        <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('req_date'); ?></label>: 
            <span class="inline_block">
                <b><?php echo !empty($handover_requisition_details[0]->harm_reqdatebs)?$handover_requisition_details[0]->harm_reqdatebs:''; ?></b> BS -- <b><?php echo !empty($handover_requisition_details[0]->harm_reqdatead)?$handover_requisition_details[0]->harm_reqdatead:''; ?></b> AD
            </span>
        </div>
        
        <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('req_from_branch'); ?></label>: 
            <span>
                <?php 
                echo !empty($handover_requisition_details[0]->fromloc)?$handover_requisition_details[0]->fromloc:'';
                ?>
            </span>
        </div>
        <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('req_from_department'); ?></label> : 
            <span> <?php echo !empty($handover_requisition_details[0]->fromdepname)?$handover_requisition_details[0]->fromdepname:'';
            ?></span>
        </div>
        <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('to_branch'); ?></label>: 
            <span>
                <?php 
                echo !empty($handover_requisition_details[0]->toloc)?$handover_requisition_details[0]->toloc:'';
                ?>
            </span>
        </div>

        <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('requisited_by'); ?> </label>: 
            <span><?php 
            $reqby=!empty($handover_requisition_details[0]->harm_requestedby)?$handover_requisition_details[0]->harm_requestedby:'';
            echo $reqby;
            ?></span>
        </div>

        <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('status'); ?> </label>: 
            <span>
                <?php 
                $approved_status=!empty($handover_requisition_details[0]->harm_approved)?$handover_requisition_details[0]->harm_approved:'';
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
            </span>
        </div> 
        
        <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> </label>:
            <?php 
            $remafyear=!empty($handover_requisition_details[0]->harm_fyear)?$handover_requisition_details[0]->harm_fyear:'';
            echo $remafyear;
            ?>
        </div>
        
        <div class="btn-group pull-right">
          <?php   
          if($handover_requisition_details[0]->harm_approved=='2'){ 
            ?>
            <button style="margin-right: 5px;" class="btn btn-success btnredirect" data-print="print" data-viewurl="<?php echo base_url('/handover/handover_issue') ?>"  data-id="<?php echo !empty($handover_requisition_details[0]->harm_handoverreqno)?$handover_requisition_details[0]->harm_handoverreqno:''; ?>">
             <?php echo $this->lang->line('handover'); ?>
         </button>
     <?php } ?>
   <!--   <button class="btn btn-success PrintThisNow ReprintThis" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('/handover/handover_req/handover_requisition_reprint') ?>" data-viewdiv="FormDiv_Reprint" data-id="<?php echo !empty($handover_requisition_details[0]->harm_handovermasterid)?$handover_requisition_details[0]->harm_handovermasterid:''; ?>">
        <?php echo $this->lang->line('print'); ?>
    </button> -->
</div>
</div>
</div> 

<div class="form-group">
    <div class="row">
        <div class="table-responsive col-sm-12">
          <div>
            <a href="javascript:void(0)" class="btnSelectNotAvailable btn btn-xs btn-danger">Select Unavailable Stock</a>

            <a href="javascript:void(0)" class="btnSelectAvailable btn btn-xs btn-success">Select Available Stock</a>
         </div>
            <table style="width:100%;" class="table purs_table dataTable con_ttl">
                <thead>
                    <tr>
                        <th width="2%">
                          <!-- <input type="checkbox" class="checkall"> -->
                        </th>
                        <th width="5%"><?php echo $this->lang->line('sn'); ?>  </th>
                        <th width="10%"><?php echo $this->lang->line('item_code'); ?> </th>
                        <th width="25%"><?php echo $this->lang->line('item_name'); ?> </th>
                        <th width="5%"><?php echo $this->lang->line('unit'); ?> </th>
                        <th width="5%"><?php echo $this->lang->line('req_qty'); ?> </th>
                        <th width="5%"><?php echo $this->lang->line('rem_qty'); ?> </th>
                        <th width="10%"><?php echo $this->lang->line('stock_quantity_during_req'); ?></th>
                        <th width="5%"><?php echo $this->lang->line('current_stock'); ?></th>
                        <th width="5%"><?php echo $this->lang->line('rate'); ?></th>
                        <th width="5%"><?php echo $this->lang->line('total_amt'); ?></th>
                    </tr>
                </thead>
                
                <tbody id="purchaseDataBody">
                    <?php 
                    // echo "<pre>";
                    // print_r($handover_requisition);
                    // die();
                    if(!empty($handover_requisition)) { 
                        $grandtotal=0;
                        foreach ($handover_requisition as $key => $odr) 
                        { 
                            if(ITEM_DISPLAY_TYPE=='NP'){
                                $req_itemname = !empty($odr->itli_itemnamenp)?$odr->itli_itemnamenp:$odr->itli_itemname;
                            }else{ 
                                $req_itemname = !empty($odr->itli_itemname)?$odr->itli_itemname:'';
                            }
                          ?>
                          <?php
                        if($odr->cur_stock_qty <= '0.00'):
                           // $stock_class = 'stockzero';
                           $stock_class = 'stocknotavailable';
                        elseif($odr->hard_remqty > $odr->cur_stock_qty):
                           $stock_class = 'stocknotavailable';
                        elseif($odr->hard_remqty <= $odr->cur_stock_qty):
                           $stock_class = 'stockavailable';
                        else:
                           $stock_class = '';
                        endif;
                     ?>

                            <tr class="orderrow <?php 
                            if($odr->hard_qtyinstock < $odr->cur_stock_qty)
                            { 
                                // if($odr->hard_qtyinstock == 0)
                                // {
                                    echo "";
                                    }else{
                                       echo "danger"; 
                                    // }
                                } ?>" id="orderrow_1" data-id='1'>
                                <td><input type="checkbox"  name="itemsid[]" class="itemcheck <?php echo $stock_class; ?>" value="<?php echo $odr->itli_itemlistid ?>"></td>
                                <td><?php echo $key+1; ?></td>
                                <td><?php echo $odr->itli_itemcode ?></td>
                                <td><?php echo $req_itemname ?></td>
                                <td><?php echo $odr->unit_unitname ?></td>
                                <td align="right"><?php echo $odr->hard_qty ?></td>
                                <td align="right"><?php echo $odr->hard_remqty ?></td>
                                <td align="right"><?php echo $odr->hard_qtyinstock ?></td>
                                <td align="right"><?php echo $odr->cur_stock_qty ?></td>
                                <td align="right"><?php echo $odr->hard_unitprice ?></td>
                                <td align="right"><?php echo $odr->hard_totalamt; ?></td>
                            </tr>
                            <?php
                            $grandtotal +=$odr->hard_totalamt; } 
                        } 
                        ?>
                    </tbody>

                    <?php
                     

                $handover_lvl = !empty($handover_requisition_details[0]->harm_handoverlvl)?$handover_requisition_details[0]->harm_handoverlvl:'';

                $handover_reqno = !empty($handover_requisition_details[0]->harm_handoverreqno)?$handover_requisition_details[0]->harm_handoverreqno:'';
              
                $ishandover = !empty($handover_requisition_details[0]->harm_ishandover)?$handover_requisition_details[0]->harm_ishandover:'';

                $handover_currentstatus = !empty($handover_requisition_details[0]->harm_currentstatus)?$handover_requisition_details[0]->harm_currentstatus:'';

                if($handover_currentstatus != 'R'):
              
                       if(in_array($this->usergroup, $store_btn_grp) && $handover_lvl < 1):
                    ?>
                    <tfoot>
                          <tr>
                            <th  colspan="9">
                               <div id="processdiv" style="display: none"><a href="javascript:void(0)" class="btn btn-sm btn-primary" id="btnOtherStock" data-heading='Other Branch Stock'>Other Branch Stock</a> </div>
                        
                          </th>  
                      </tr>
                      </tfoot>
                    <?php
                      endif;
                    ?>
                </table>
            </div>
             <?php // if($cstatus!='R' && $cstatus!='A'): ?>  
            <div class="col-sm-12" id="stockAvailableDiv" style="display:none;">
                <?php 
                    if(in_array($this->usergroup, $store_btn_grp) && $handover_lvl < 1):
                ?>
                    <a href="javascript:void(0)" class="btn btn-sm btn-info btnApproval" data-approval_level="1"><i class="fa fa-check"></i> Request for Approval From Department Head</a>  
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger btnreject" ><i class="fa fa-times" aria-hidden="true"></i> Reject</a>
               
                    <?php 

                    elseif(in_array($this->usergroup, $dephead_btn_grp) && $handover_lvl == '1'):
                ?>
                    <a href="javascript:void(0)" class="btn btn-sm btn-info btnApproval" data-approval_level="2"><i class="fa fa-check"></i> Request for Approval From Branch Manager</a> 
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger btnreject" ><i class="fa fa-times" aria-hidden="true"></i> Reject</a>
                <?php
                    elseif(in_array($this->usergroup, $bm_btn_grp) && $handover_lvl == '2'):
                ?>
                    <a href="javascript:void(0)" class="btn btn-sm btn-info btnaccept" ><i class="fa fa-check"></i> Approve Handover</a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger btnreject" ><i class="fa fa-times" aria-hidden="true"></i> Reject</a>
                <?php
                    elseif(in_array($this->usergroup, $store_btn_grp) && $handover_lvl == '3' & $ishandover == 'N'):
                ?>
                  <!--  <a href="javascript:void(0)" class="btn btn-sm btn-success btnredirect "><i class="fa fa-check"></i>  Handover </a> -->

                    <button style="margin-right: 5px;" class="btn btn-success btnredirect" data-print="print" data-viewurl="<?php echo base_url('/handover/handover_issue') ?>"  data-id="<?php echo $handover_reqno; ?>">
                        Handover
                    </button> 
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger btnreject" ><i class="fa fa-times" aria-hidden="true"></i> Reject</a>
                <?php
                    endif;
                ?>
           </div>

           <div class="col-sm-12" id="stockNotAvailableDiv" style="display:none;">
                <?php 
                    if(in_array($this->usergroup, $store_btn_grp) && $handover_lvl < 1):
                ?> 
                    <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="btnOtherStock" data-heading='Other Branch Stock'>Other Branch Stock</a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger btnreject" ><i class="fa fa-times" aria-hidden="true"></i> Reject</a>
                <?php
                    endif;
                ?>
           </div>

           <?php
            else:
            ?>
            <tfoot>
                <tr>
                    <th  colspan="9">
                        <span class="alert text-danger">Already Rejected</span>
                    </th>
                </tr>
            </tfoot>
            <?php
        endif;
            ?>

         <!--    <div class="col-sm-4">
            <a href="javascript:void(0)" class="btn btn-sm btn-success btnaccept "><i class="fa fa-check"></i> Accept </a>
            <a href="javascript:void(0)" class="btn btn-sm btn-danger btnreject" ><i class="fa fa-times" aria-hidden="true"></i> Reject</a>
            </div> -->
            <?php //endif; ?>
           <!--  <?php if($cstatus=='R' || $cstatus=='A'): ?>
              <?php if($cstatus=='R'): ?>
                <span class="alert text-danger">Already Rejected</span>
              <?php endif; ?>
               <?php if($cstatus=='A'): ?>
                <span class="alert text-success">Already Accepted</span>
              <?php endif; ?>
            <?php endif; ?> -->
        </div>
    </div>

    <div id="FormDiv_Reprint" class="printTable"></div>  

     <div class="col-sm-12">
    <div  class="alert-success success"></div>
    <div class="alert-danger error"></div>
</div>  

<!-- <div class="col-sm-12">
    <div class="row">
    <?php
        $req_masterid = !empty($handover_requisition_details[0]->harm_reqmasterid)?$handover_requisition_details[0]->harm_reqmasterid:'';

        $reqno = !empty($handover_requisition_details[0]->harm_reqno)?$handover_requisition_details[0]->harm_reqno:'';

        $locationid = !empty($handover_requisition_details[0]->harm_fromlocationid)?$handover_requisition_details[0]->harm_fromlocationid:'';

        echo $req_masterid;
        echo $reqno;
        echo $remafyear;

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
</div> -->

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

   $(document).off('change','.itemcheck');
   $(document).on('change','.itemcheck',function(e){
      var lencnt=$('input[name="itemsid[]"]:checked').length;
      // alert(lencnt);
      if (lencnt>0){
         $('#processdiv').show();
      }
      else
      {
         $('#processdiv').hide();
      }
   });

   $(document).off('click','.btnreject');
   $(document).on('click','.btnreject',function(e){
      var conf = confirm('Are you want to Sure to reject ?');
      var rejecturl=base_url+'handover/handover_req/handover_req_reject';
      var hmid=$('#handovermasterid').val();
      // var reject_reason=$('#reject_reason').val();
      var itemlist = [];
      $.each($("input[name='itemsid[]']:checked"), function(){            
         itemlist.push($(this).val());
      });
      if(itemlist=='')
      {
         alert('Please checked items');
         return false;
      }

      if(conf)
      {
         $.ajax({
            type: "POST",
            url: rejecturl,
            data:{hmid:hmid,itemlist:itemlist},
            dataType: 'html',
            beforeSend: function() {
               $('.overlay').modal('show');
            },
            success: function(jsons) //we're calling the response json array 'cities'
            {
               data = jQuery.parseJSON(jsons);   
               // alert(data.status);
               if(data.status=='success')
               {
                  alert(data.message);
                  $('table tbody tr').addClass('reject');
                  $('.btnreject').hide();
                  $('.btnaccept').hide();
               }
               else
               {
                  alert(data.message);
               }
               $('.overlay').modal('hide');
            }
         });
      }
   })

   $(document).off('click','.btnaccept');
   $(document).on('click','.btnaccept',function(e){
      var conf = confirm('Are you want to Sure to accept ?');
      var accept_url=base_url+'handover/handover_req/handover_req_accept';
      var hmid=$('#handovermasterid').val();
      var itemlist = [];
      $.each($("input[name='itemsid[]']:checked"), function(){            
         itemlist.push($(this).val());
      });
      if(itemlist=='')
      {
         alert('Please checked items');
         return false;
      }
      // var reject_reason=$('#reject_reason').val();
      if(conf)
      {
         $.ajax({
            type: "POST",
            url: accept_url,
            data:{hmid:hmid,itemlist:itemlist},
            dataType: 'html',
            beforeSend: function() {
               $('.overlay').modal('show');
            },
            success: function(jsons) //we're calling the response json array 'cities'
            {
               data = jQuery.parseJSON(jsons);   
               // alert(data.status);
               if(data.status=='success')
               {
                  alert(data.message);
                  $('table tbody tr').addClass('reject');
                  $('.btnreject').hide();
                  $('.btnaccept').hide();
               
               }
               else
               {
                  alert(data.message);
               }
               $('.overlay').modal('hide');
            }
         });
      }
   })

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

   $(document).off('click','.btnSelectNotAvailable');
   $(document).on('click','.btnSelectNotAvailable',function(e){
      $(this).toggleClass("select");  
      var curclassname=this.className;
      
      if (curclassname.indexOf('select') > -1) {
         $(".stocknotavailable").each(function() {
            this.checked=true;
         });
         
         $(".stockavailable").each(function() {
            this.checked=false;
         });

         var available_count = $('.stocknotavailable').length;

         if(available_count > 0){
            $('#stockNotAvailableDiv').show();
            $('.btnSelectNotAvailable').text('Unselect Unavailable Stock');
         }

         // $('#processdiv').show();
         $('#stockAvailableDiv').hide();
      } else {
         $(".stocknotavailable").each(function() {
            this.checked=false;
         });
         $('#stockNotAvailableDiv').hide();
         $('.btnSelectNotAvailable').text('Select Unavailable Stock');
      }
   });

   $(document).off('click','.btnSelectAvailable');
   $(document).on('click','.btnSelectAvailable',function(e){
      $(this).toggleClass("select");  
      var curclassname=this.className;
      
      if (curclassname.indexOf('select') > -1) {
         $(".stockavailable").each(function() {
            this.checked=true;
         });
         
         $(".stocknotavailable").each(function() {
            this.checked=false;
         });
         
         var available_count = $('.stockavailable').length;

         if(available_count > 0){
            $('#stockAvailableDiv').show();
            $('.btnSelectAvailable').text('Unselect Available Stock');
         }
         $('#stockNotAvailableDiv').hide();
         
      } else {
         $(".stockavailable").each(function() {
            this.checked=false;
         });
         $('#stockAvailableDiv').hide();
         $('.btnSelectAvailable').text('Select Available Stock');
      }
   });

   </script>

   <script type="text/javascript">
      $(document).off('click','btnApproval');
      $(document).on('click','.btnApproval', function(){
         // alert('test');
        var itemlist = [];
        $.each($("input[name='itemsid[]']:checked"), function(){            
           itemlist.push($(this).val());
        });
        if(itemlist=='')
        {
           alert('Please checked items');
           return false;
        }
         var handovermasterid = '<?php echo $handovermasterid; ?>';

         var status = $(this).data('status');

         var approval_level = $(this).data('approval_level');

         var submitData = { handovermasterid: handovermasterid, approval_level:approval_level };
         beforeSend= $('.overlay').modal('show');

         var submitUrl = base_url+'handover/handover_req/request_for_approval';

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
