<?php
    $haov_handovermasterid = !empty($issue_master[0]->haov_handovermasterid)?$issue_master[0]->haov_handovermasterid:''; 
    $haov_trmaid = !empty($issue_master[0]->haov_trmaid)?$issue_master[0]->haov_trmaid:''; 

    $harm_reqno = !empty($issue_master[0]->haov_handoverreqno)?$issue_master[0]->haov_handoverreqno:'';

    $fyear = !empty($issue_master[0]->haov_fyear)?$issue_master[0]->haov_fyear:'';

    $locationid = !empty($issue_master[0]->haov_tolocationid)?$issue_master[0]->haov_tolocationid:'';
?>

<div class="form-group white-box pad-5 bg-gray">
    <div class="row">
        <div class="col-md-2 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('handover_issue_no'); ?> : </label>
            <span> <?php echo !empty($issue_master[0]->haov_handoverno)?$issue_master[0]->haov_handoverno:''; ?></span>
        </div>
        <div class="col-md-4 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('handover_issue_date'); ?> : </label>
            <span><b><?php echo !empty($issue_master[0]->haov_reqdatebs)?$issue_master[0]->haov_reqdatebs:''; ?></b> <?php echo $this->lang->line('bs'); ?> -- <b><?php echo !empty($issue_master[0]->haov_reqdatead)?$issue_master[0]->haov_reqdatead:''; ?> </b><?php echo $this->lang->line('ad'); ?></span>
        </div>
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> : </label>
            <span><?php echo !empty($issue_master[0]->haov_fyear)?$issue_master[0]->haov_fyear:''; ?></span>
        </div>
        <div class="col-md-3 col-sm-4">
            <?php $time=!empty($issue_master[0]->haov_posttime)?$issue_master[0]->haov_posttime:''; //print_r($datedb);die;?>
            <label for="example-text"><?php echo $this->lang->line('requisition_time'); ?> : </label>
            <?php echo $time;?>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-3 col-sm-4">
            <label for=""><?php echo $this->lang->line('issued_by'); ?> : </label>
            <span><?php echo !empty($issue_master[0]->fromlocation)?$issue_master[0]->fromlocation:''; ?></span>
        </div>
         <div class="col-md-3 col-sm-4">
            <?php $tolocation=!empty($issue_master[0]->tolocation)?$issue_master[0]->tolocation:''; ?>
            <label for="example-text"><?php echo $this->lang->line('to_branch'); ?> :</label>
            <span> <?php echo $tolocation; ?></span>
        </div>
       
        <div class="col-md-3 col-sm-4">
            <?php $samarequisitionno=!empty($issue_master[0]->haov_handoverreqno)?$issue_master[0]->haov_handoverreqno:''; ?>
            <label for="example-text"><?php echo $this->lang->line('handover_requisition_no'); ?> :</label>
            <span><?php echo $samarequisitionno; ?></span>
        </div>
        <div class="col-md-3 col-sm-4">
            <?php $depname=!empty($issue_master[0]->dept_depname)?$issue_master[0]->dept_depname:''; ?>
            <label for="example-text"><?php echo $this->lang->line('department_name'); ?> :</label>
            <span> <?php echo $depname; ?></span>
        </div>
       
         <div class="col-md-3 col-sm-4">
            <?php $samareceivedby=!empty($issue_master[0]->haov_receivedby)?$issue_master[0]->haov_receivedby:''; ?>
            <label for="example-text"><?php echo $this->lang->line('received_by'); ?>  : </label>
            <span><?php echo $samareceivedby; ?></span>
        </div>
       
    </div>
    <button class="btn btn-success PrintThisNow ReprintThis pull-right" id="btnPrintNowBtn" data-print="print" data-viewdiv="FormDiv_issueReprint" data-id="<?php echo !empty($issue_master[0]->haov_handovermasterid)?$issue_master[0]->haov_handovermasterid:''; ?>" data-actionurl="<?php echo base_url('handover/handover_issue/reprint_handover_details'); ?>"><?php echo $this->lang->line('print'); ?></button>
    <div class="clearfix"></div>
</div>

<div class="form-group">
    <div class="row">
        <div class="table-responsive col-sm-12">
            <table style="width:100%;" class="table purs_table dataTable con_ttl">
                <thead>
                    <tr>
                        <th width="5%"><?php echo $this->lang->line('sn'); ?> </th>
                        <th width="5%"><?php echo $this->lang->line('item_code'); ?></th>
                        <th width="15%"><?php echo $this->lang->line('item_name'); ?></th>
                        <th width="5%"><?php echo $this->lang->line('unit'); ?> </th>
                        <th width="5%">Price</th>
                        <th width="10%"><?php echo $this->lang->line('qty'); ?></th>
                        <th width="10%">Rem. Qty</th>
                        <th width="10%">Received Qty</th>
                        <th width="10%"><?php echo $this->lang->line('sub_total'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('remarks'); ?></th>

                    </tr>
                </thead>
                <tbody id="purchaseDataBody">
                    <?php 

                    if(!empty($all_issue_details)) { 
                        $gtotal=0;
                        

                        foreach ($all_issue_details as $key => $odr) 
                        { 

                            if(ITEM_DISPLAY_TYPE=='NP'){
                                $req_itemname = !empty($odr->itli_itemnamenp)?$odr->itli_itemnamenp:$odr->itli_itemname;
                            }else{ 
                                $req_itemname = !empty($odr->itli_itemname)?$odr->itli_itemname:'';
                            }

                            ?>
                            <tr class="orderrow" id="orderrow_<?php echo $key+1; ?>" data-id='<?php echo $key+1; ?>'>
                                <td>
                                 <?php echo $key+1; ?>
                             </td> 
                             <td>
                                <?php echo $odr->itli_itemcode;?>
                            </td>
                            <td>
                                <?php echo $req_itemname; ?> 
                            </td>
                            <td>
                                <?php $unit=!empty($odr->unit_unitname)?$odr->unit_unitname:'';?> 
                                <?php echo $unit;?>
                            </td>
                            <td>
                                <?php $unitprice=!empty($odr->haod_unitprice)?$odr->haod_unitprice:0;?> 
                                <?php echo $unitprice;?>
                                <input type="hidden" value="<?php echo $unitprice;?>" class="form-control unitprice" />
                            </td>

                            <td>
                                <?php $haod_qty=!empty($odr->haod_qty)?$odr->haod_qty:0;?> 
                                <?php echo $haod_qty;?>
                            </td>

                            <td>
                                <?php $haod_remqty=!empty($odr->haod_remqty)?$odr->haod_remqty:0;?> 
                                <?php echo number_format($haod_remqty,2);?>
                                <input type="hidden" value="<?php echo $haod_remqty;?>" class="form-control remain_qty" data-id="<?php echo $key+1;?>" id="remain_qty_<?php echo $key+1;?>"/>
                            </td>

                            <td>
                                <?php
                                    $haod_trdid = !empty($odr->haod_trdid)?$odr->haod_trdid:0;
                                ?>
                                <?php
                                  if($haod_remqty ==0){
                                    $readonly="readonly='readonly'";;
                                  }else{
                                    $readonly = '';
                                  }
                                ?>
                               <input type="text" value="0" class="form-control receive_qty float" data-id="<?php echo $key+1;?>" id="receive_qty_<?php echo $key+1;?>" <?php echo $readonly;?>/>
                               <input type="hidden" value="<?php echo $haod_qty;?>" class="form-control requested_qty" />
                               <input type="hidden" value="<?php echo $haod_trdid; ?>" class="form-control haod_trdid" />
                               <input type="hidden" value="<?php echo $odr->itli_itemlistid; ?>" class="form-control items_id" />
                               <input type="hidden" value="<?php echo $odr->haod_handoverdetailid; ?>" class="form-control handoverdetailid" />
                            </td>
                            <td>
                                <?php $subtotal=!empty($odr->haod_totalamt)?$odr->haod_totalamt:0;?> 
                                <?php echo $subtotal;?>
                            </td>

                            <td>
                                <?php $return_remarks=!empty($odr->return_remarks)?$odr->return_remarks:'';?>
                                <?php echo $return_remarks;?>
                            </td>
                        </tr>
                        <?php  
                        $gtotal +=$subtotal;

                        ?>
                               <?php 
                    } 
                } 
                ?>
               
                <tr>
                    <th colspan="6"><?php echo $this->lang->line('total'); ?></th>
                    <th>
                        <?php echo  !empty($gtotal)?$gtotal:'0'; ?>
                        
                    </th>
                    <th></th>

                </tr>
                  
            </tbody>
        </table>
        
        <br>
        <div class="list_c2 label_mw125">
            <?php $isreceived= !empty($issue_master[0]->haov_isreceived)?$issue_master[0]->haov_isreceived:''; ?><?php 
            if(!empty($isreceived !='Y')): ?>
          <form id="Formhandoverreceived" action="<?php echo base_url('handover/handover_issue/handover_received_save');?>" method="POST">
            <input type="hidden" name="handoverid" value="<?php echo !empty($issue_master[0]->haov_handovermasterid)?$issue_master[0]->haov_handovermasterid:'';  ?>">
            <input type="hidden" name="haov_trmaid" value="<?php echo !empty($issue_master[0]->haov_trmaid)?$issue_master[0]->haov_trmaid:'';  ?>">
            <div class="form-group">
              <div class="col-ms-12">
                <div class="row">
                    
                  <?php // echo $this->general->location_option(2,'locationid'); ?>    
                  
                    <div class="col-sm-3">
                        <label for="example-text">Receiver Name: </label>
                        <input type="text" class="form-control" name="haov_receivedby"  value="<?php echo $samareceivedby; ?>">
                    </div>

                    <div class="col-sm-3">
                        <label for="example-text">Received Date: </label>
                        <input type="text" class="form-control <?php echo DATEPICKER_CLASS; ?>" name="haov_receiveddate" id="haov_receiveddate" value="<?php echo (DEFAULT_DATEPICKER == 'NP')?CURDATE_NP:CURDATE_EN; ?>">
                    </div>                     
                  
              </div>
          </div>

      </div>
      <div class="col-md-12">
       <!--    <button type="submit" class="btn btn-info  savelist" data-operation="save" id="btnDeptment" data-isdismiss="Y" data-isrefresh="Y" data-isuserregister="Y">Receive</button> -->
      </div>
       <a id="btnReceive" href="javascript:void(0)" class="btn btn-info">Receive </a>

      <div class="col-sm-12">
          <div  class="alert-success success"></div>
          <div class="alert-danger error"></div>
      </div>
  </div>
</div>
</form>
<?php endif; ?>
</div>

</div>
</div>
</div>

<div id="reprint_received_handover" class="printTable"></div>

<div id="FormDiv_issueReprint" class="printTable"></div>

<div id="FormDiv_Reprint" class="printTable"></div>
<!-- <script>
    $(document).off('click','.ReprintThis');
    $(document).on('click','.ReprintThis',function(){
        var print =$(this).data('print');
        var iddata=$(this).data('id');
        var id=$('#id').val();
        if(iddata)
        {
          id=iddata;
      }
      else
      {
          id=id;
      }
      $.ajax({
        type: "POST",
        url:  base_url+'/handover/handover_issue/reprint_handover_details',
        data:{id:id},
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
                $('#FormDiv_Reprint').html(data.tempform);
                $('.printTable').printThis();
            }
            else
            {
              alert(data.message);
          }
          setTimeout(function(){
            $('.newPrintSection').hide();

            $('#myView').modal('hide');
        },2000);
          $('.overlay').modal('hide');
      }
  });
  })
</script> -->

<script type="text/javascript">
    $('.engdatepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });

    $(document).ready(function(){
        $('.nepdatepicker').nepaliDatePicker({
            npdMonth: true,
            npdYear: true,
            npdYearCount: 10 // Options | Number of years to show
        });
    });
</script>

<script type="text/javascript">
  $(document).off('click','#btnReceive');
  $(document).on('click','#btnReceive',function(){
    var receive_qty = [];
    var haod_trdid = [];
    var requested_qty = [];
    var handoverdetailid = [];
    var items_id = [];
    var unitprice = [];

    $(".receive_qty").each(function() {
       receive_qty.push($(this).val());
    });

    $(".requested_qty").each(function() {
       requested_qty.push($(this).val());
    });

    $(".haod_trdid").each(function() {
       haod_trdid.push($(this).val());
    });

    $(".handoverdetailid").each(function() {
       handoverdetailid.push($(this).val());
    });

    $(".items_id").each(function() {
      items_id.push($(this).val());
    });

    $(".unitprice").each(function() {
      unitprice.push($(this).val());
    });

    var haov_receivedby = $('.haov_receivedby').val();

    var haov_receiveddate = $('.haov_receiveddate').val();

    var haov_handovermasterid = '<?php echo $haov_handovermasterid;  ?>';

    var haov_trmaid = '<?php echo $haov_trmaid; ?>';

    var harm_reqno = '<?php echo $harm_reqno; ?>';

    var fyear = '<?php echo $fyear; ?>';

    var locationid = '<?php echo $locationid; ?>';

    var submitData = {haov_receivedby:haov_receivedby, haov_receiveddate:haov_receiveddate, haov_handovermasterid:haov_handovermasterid, receive_qty: receive_qty, haod_trdid:haod_trdid, haov_trmaid:haov_trmaid, harm_reqno:harm_reqno, fyear:fyear, locationid:locationid, requested_qty:requested_qty, handoverdetailid:handoverdetailid, items_id:items_id, unitprice:unitprice };

    beforeSend= $('.overlay').modal('show');
    var submitUrl = base_url+'handover/handover_issue/receive_handover_items';
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
        $('#searchByDate').click();
      },1000);
       
    }
  });
</script>

<script type="text/javascript">
  $(document).off('keyup change','.receive_qty');
  $(document).on('keyup change','.receive_qty',function(){
    var rowid = $(this).data('id');

    var receive_qty = $('#receive_qty_'+rowid).val();
    var remain_qty = $('#remain_qty_'+rowid).val();

    var new_receive_qty = checkValidValue(receive_qty);
    var new_remain_qty = checkValidValue(remain_qty);

    if(new_receive_qty > new_remain_qty){
        alert('Receive quantity can not exceed remain qty. Please check it.');
        $('#receive_qty_'+rowid).val(new_remain_qty);
        $('#receive_qty_'+rowid).select();
    }

  })
</script>