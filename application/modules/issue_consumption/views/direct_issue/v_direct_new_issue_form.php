<style>
    .purs_table tbody tr td{
        border: none;
        vertical-align: center;
    }
</style>

<form method="post" id="FormIssueNew" action="<?php echo base_url('issue_consumption/direct_issue/save_direct_issue'); ?>" data-reloadurl="<?php echo base_url('issue_consumption/direct_issue/form_direct_issue');?>" class="form-material form-horizontal form">

    <input type="hidden" name="id" value="<?php echo !empty($new_issue[0]->sama_salemasterid)?$new_issue[0]->sama_salemasterid:'';  ?>">

    <div id="issueDetails">
        <div class="form-group">

    <div class="col-md-3 col-sm-4">
        <label for="req_no"><?php echo $this->lang->line('req_no'); ?> <span class="required">*</span>:</label>
        <input type="text" class="form-control required_field" name="sama_requisitionno" placeholder="Enter Req. No." autocomplete="off" />
    </div>

    <div class="col-md-3 col-sm-4">
        <label for="example-text"><?php echo $this->lang->line('department'); ?> <span class="required">*</span>:</label>
        <?php $department=!empty($depart)?$depart:''; ?>
        <select id="depnme" name="sama_depid"  class="form-control required_field">
            <option value="">---select---</option>
            <?php 
                if($depatrment):
                    foreach ($depatrment as $km => $dep):
            ?>
             <option value="<?php echo $dep->dept_depid; ?>"  <?php if($department==$dep->dept_depid) echo "selected=selected"; ?>><?php echo $dep->dept_depname; ?></option>
            <?php
                    endforeach;
                endif;
            ?>
        </select>
        <input type="hidden" id="depname" name="sama_depname"/>
    </div>
    <div class="col-md-3 col-sm-4">
        <?php $sama_fyear = !empty($new_issue[0]->sama_fyear)?$new_issue[0]->sama_fyear:CUR_FISCALYEAR; ?>
        <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> <span class="required">*</span>:</label>
       <!--  <input type="text" class="form-control" name="sama_fyear" id="fiscal_year" value="<?php echo $sama_fyear; ?>" placeholder="Fiscal Year" > -->
       <select name="sama_fyear" class="form-control required_field" id="fyear">
           <?php
             if($fiscal_year): 
             foreach ($fiscal_year as $kf => $fyrs):
             ?>
            <option value="<?php echo $fyrs->fiye_name; ?>" <?php if($fyrs->fiye_status=='I') echo "selected=selected"; ?> ><?php echo $fyrs->fiye_name; ?></option>
         <?php endforeach; endif; ?>
       </select>
    </div>

    <div class="col-md-3 col-sm-4">
        <?php
            if(DEFAULT_DATEPICKER == 'NP'){
                $sama_billdate = !empty($new_issue[0]->sama_billdatebs)?$new_issue[0]->sama_billdatebs:DISPLAY_DATE;
                $sama_reqdate=!empty($new_issue[0]->sama_requisitiondatebs)?$new_issue[0]->sama_requisitiondatebs:DISPLAY_DATE; 
            }else{
                $sama_billdate = !empty($new_issue[0]->sama_billdatead)?$new_issue[0]->sama_billdatead:DISPLAY_DATE;
                 $sama_reqdate=!empty($new_issue[0]->sama_requisitiondatead)?$new_issue[0]->sama_requisitiondatead:DISPLAY_DATE; 
            } 
        ?>
        <label for="example-text"><?php echo $this->lang->line('issue_date'); ?> <span class="required">*</span>:</label>
        <input type="text" class="form-control required_field <?php echo DATEPICKER_CLASS; ?>" name="issue_date" value="<?php echo $sama_billdate; ?>" id="issuedate" placeholder="YYYY/MM/DD " autocomplete="off">
    </div>
</div>
<div class="clearfix"></div> 
<div class="form-group">
    <div class="col-md-3 col-sm-4">
        <label for="example-text"><?php echo $this->lang->line('requisition_date'); ?> <span class="required">*</span>:</label>
        <input type="text" class="form-control required_field <?php echo DATEPICKER_CLASS; ?>" name="requisition_date" value="<?php echo $sama_reqdate; ?>" placeholder="Enter Requisition Date" id="requisition_date" autocomplete="off" >
    </div>

    <div class="col-md-3 col-sm-4">
        <?php $sama_invoiceno=!empty($new_issue[0]->sama_invoiceno)?$new_issue[0]->sama_invoiceno:''; ?>
        <label for="example-text"><?php echo $this->lang->line('issue_no'); ?><span class="required">*</span> :</label>
        <input type="text" class="form-control required_field issue_no issueno_gen" name="sama_invoiceno" id="issue_no"  value="<?php echo !empty($sama_invoiceno)?$sama_invoiceno:$issue_no; ?>" placeholder="Enter Issue Number" readonly>

        <input type="text" class="form-control handover_no" name="sama_invoiceno" id="issue_no" value="<?php echo !empty($sama_invoiceno)?$sama_invoiceno:$handover_no; ?>" placeholder="Enter Handover Number" readonly style="display: none;">
    </div>

    <div class="col-md-3 col-sm-4">
        <?php $sama_receivedby=!empty($new_issue[0]->sama_receivedby)?$new_issue[0]->sama_receivedby:''; ?>
        <label for="example-text"><?php echo $this->lang->line('received_by'); ?> :</label>
        <input type="text" class="form-control" name="sama_receivedby" value="<?php echo $sama_receivedby; ?>" placeholder="Enter Received By" id="receive_by">
    </div>
    <div class="col-md-3 col-sm-4">
        <label for="handover"><?php echo $this->lang->line('handover'); ?></label><br/>
        <input type="checkbox" class="handover" name="handover" value="Y" />
    </div>
</div>

<div class="clearfix"></div> 

<div class="form-group">
    <div class="pad-5" id="DisplayPendingList">
    <div class="table-responsive">
        <table style="width:100%;" class="table purs_table dt_alt dataTable">
            <thead>
                <tr>
                    <th scope="col" width="5%"> <?php echo $this->lang->line('sn'); ?></th>
                    <th scope="col" width="10%"> <?php echo $this->lang->line('item_code'); ?>  </th>
                    <th scope="col" width="15%"><?php echo $this->lang->line('item_name'); ?> </th>
                    <th scope="col" width="10%"> <?php echo $this->lang->line('unit'); ?>  </th>
                    <th scope="col" width="10%"> <?php echo $this->lang->line('volume'); ?> </th>
                    <th scope="col" width="10%"> <?php echo $this->lang->line('stock_quantity'); ?></th>
                    <th scope="col" width="10%"> <?php echo $this->lang->line('issue_qty'); ?> </th>
                    <th scope="col" width="15%"> <?php echo $this->lang->line('remarks'); ?></th>
                     <th scope="col" width="5%"> <?php echo $this->lang->line('action'); ?></th>
                </tr>
            </thead>
            <tbody id="directIssueBody">
                <tr class="orderrow" id="orderrow_1" data-id='1'>
                    <td data-label="S.No.">
                        <input type="text" class="form-control sno" id="s_no_1" value="1" readonly/>
                    </td>
                    <td data-label="Code">
                        <div class="dis_tab"> 
                            <input type="text" class="form-control itemcode enterinput" id="itemcode_1" name="sade_code[]"  data-id='1' data-targetbtn='view' value="">
                            <input type="hidden" class="itemid" name="sade_itemsid[]" data-id='1' value="" id="itemid_1">

                            <input type="hidden" class="purchaserate" name="sade_purchaserate[]" data-id='1' value="" id="purchaserate_1">

                            <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading='<?php echo $this->lang->line('list_of_items'); ?>' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition'); ?>' data-id='1' id="view_1"><strong>...</strong></a>
                        </div> 
                    </td>

                    <td data-label="Particular">  
                        <input type="text" class="form-control itemname" id="itemname_1"  data-id='1' name="itemname[]" readonly> 
                    </td>
                    
                    <td data-label="Unit"> 
                        <input type="text" value="" class="form-control float sade_unit" id="unit_1" data-id='1' readonly="true"> 
                        <input type="hidden" class="unitid" name="sade_unit[]" id="unitid_1" data-id='1'/>
                    </td>
                    
                    <td data-label="Volume"> 
                        <input type="text" value="" class="form-control float volume" name="volume[]" id="volume_1" data-id='1' />
                    </td>
                    <td data-label="Stock Quantity"> 

                        <input type="text" name="qtyinstock[]" data-id='1' class="form-control qtyinstock" id="qtyinstock_1" value="" readonly/>
                    </td>

                    <td data-label="Req. Quantity"> 
                        <input type="text" class="form-control float required_field sade_qty" name="sade_qty[]"   id="qty_1" data-id='1' > 
                    </td>
                    
                    <td data-label="Remarks"> 
                        <input type="text" class="form-control remarks " id="remarks_1" name="sade_remarks[]" data-id='1'> 
                    </td>

                    <td>
                        <div class="actionDiv acDiv2" id="acDiv2_1" ></div>
                    </td>
                </tr>    
            </tbody>
              <tr>
                <td colspan="9">
                    <a href="javascript:void(0)" class="btn btn-primary btnAdd pull-right" data-id="1"  id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                </td>
            </tr>
        </table>
    </div>
    </div>
</div>

<div class="form-group">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="example-text"><?php echo $this->lang->line('notes_if_any'); ?>: </label>
        <input type="text" name="sama_remarks" class="form-control"  placeholder="Enter Notes (If any)" value="<?php echo !empty($new_issue[0]->sama_remarks)?$new_issue[0]->sama_remarks:''; ?>" id="sama_remarks">
        <span class="errmsg"></span>
    </div>
</div>

<div class="clearfix"></div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
        <?php 
          $save_var=$this->lang->line('save');
                $update_var=$this->lang->line('search');

                // $update_var:$save_var;
        ?>
            <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($item_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($item_data)?$update_var:$save_var; ?></button>
            <button type="submit" class="btn btn-info savePrint" data-operation='<?php echo !empty($item_data)?'update':'save ' ?>' id="btnSubmit" data-print="print"><?php echo !empty($item_data)?'Update & Print':$this->lang->line('save_and_print') ?></button>
        </div>
          <div class="col-sm-12">
            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
          </div>
    </div>
    <div id="Printable" class="print_report_section printTable"></div>
</form> 

<script>
    $(document).off('blur change','#issuedate');
    $(document).on('blur change','#issuedate',function(){
        var issuedate = $('#issuedate').val();
        var curdate = "<?php echo CURDATE_NP;?>";

        var selected_date_id = '#issuedate';
        var errorMsg = 'Issue date should not exceed current date. Please check it.';
        compare_date(issuedate, curdate, selected_date_id,errorMsg);
    });
   

    $(document).off('blur change','#requisition_date');
    $(document).on('blur change','#requisition_date',function(){
        var req_date = $('#requisition_date').val();
        var issuedate = $('#issuedate').val();

        var selected_date_id = '#requisition_date';
        var errorMsg = 'Requisition date should not exceed issue date. Please check it.';
        compare_date(req_date, issuedate, selected_date_id, errorMsg);
    });

</script>

<script type="text/javascript">
    $(document).off('click','.btnAdd');
    $(document).on('click','.btnAdd',function(){
        var id=$(this).data('id');
        var itemid = $('#itemid_'+id).val();
        var itemcode = $('#itemcode_'+id).val();
        // var itemname = $('#itemname_'+id).val();
        var itemname=$(this).data('itemname_display');

        var unit = $('#unit_'+id).val();
        var unitid = $('#unitid_'+id).val();

        var volume = $('#volume_'+id).val();

        var qtyinstock = $('#qtyinstock_'+id).val();

        var reqqty = $('#qty_'+id).val();

        var remarks = $('#remarks_'+id).val();

          var trplusOne = $('.orderrow').length+1;
        var trpluOne = $('.orderrow').length;

        var storeid = "<?php echo $this->storeid;?>";

        // alert(trplusOne);
    
       
        var newitemid=$('#itemid_'+trpluOne).val();
        if(newitemid=='')
        {
            $('#itemcode_'+trpluOne).focus();
            return false;
        }
        var newissueqty=$('#qty_'+trpluOne).val();
        if(newissueqty==0 || newissueqty=='' || newissueqty==null )
        {
            $('#qty_'+trpluOne).focus();
            return false;
        }

        if(trplusOne==2)
        {

            $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');
        }
        var template='';
        template='<tr class="orderrow" id="orderrow_'+trplusOne+'" data-id="'+trplusOne+'"><td><input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/></td><td> <div class="dis_tab"> <input type="text" class="form-control itemcode enterinput " id="itemcode_'+trplusOne+'" name="itemcode[]" data-id="'+trplusOne+'" data-targetbtn="view"> <input type="hidden" class="itemid" name="sade_itemsid[]" data-id="'+trplusOne+'" value="" id="itemid_'+trplusOne+'">  <input type="hidden" class="purchaserate" name="sade_purchaserate[]" data-id="'+trplusOne+'" value="" id="purchaserate_'+trplusOne+'">  <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading="Item List" data-viewurl="<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition'); ?>" data-id="'+trplusOne+'" data-storeid="'+storeid+'" id="view_'+trplusOne+'"><strong>...</strong></a> </div></td><td> <input type="text" class="form-control itemname" id="itemname_'+trplusOne+'" name="itemname[]" data-id="'+trplusOne+'"> </td><td><input type="text" class="form-control float unit" id="unit_'+trplusOne+'" data-id="'+trplusOne+'" readonly="true"> <input type="hidden" class="unitid" name="sade_unit[]" id="unitid_'+trplusOne+'" data-id='+trplusOne+'/> </td> <td>  <input type="text" value="" class="form-control volume" name="volume[]" id="volume_'+trplusOne+'" data-id="'+trplusOne+'" /> </td> <td><input type="text" class="form-control float qtyinstock" name="qtyinstock[]"  id="qtyinstock_'+trplusOne+'" data-id="'+trplusOne+'" readonly /></td><td> <input type="text" class="form-control float sade_qty" name="sade_qty[]" id="qty_'+trplusOne+'" data-id="'+trplusOne+'"></td><td> <input type="text" class="form-control remarks" name="sade_remarks[]" id="remarks_'+trplusOne+'"></td><td> <div class="actionDiv acDiv2 " id="acDiv2_'+trplusOne+'"><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div></td></tr>';
         // $('#addOrder_'+id).removeClass('btn btn-primary btnAdd').addClass('btn btn-danger btnRemove');
         // $('#btnChange_'+id).html('<i class="fa fa-trash-o" aria-hidden="true"></i>');
        $('#itemcode_'+trplusOne).focus();
        $('#directIssueBody').append(template);
    });
    $(document).off('click','.btnRemove');
    $(document).on('click','.btnRemove',function(){
        var id=$(this).data('id');
         var whichtr = $(this).closest("tr");
         var conf = confirm('Are Your Want to Sure to remove?');
          if(conf)
          {
             var trplusOne = $('.orderrow').length+1;
             // console.log(trplusOne);
             // $('#orderrow_'+id).fadeOut(500, function(){ 
             // $('#orderrow_'+id).remove();
             //  });
             whichtr.remove(); 
            //  for (var i = 0; i < trplusOne; i++) {
            //   $('#s_no_'+i).val(i);
            // }
            setTimeout(function(){
                  $(".orderrow").each(function(i,k) {
                    var vali=i+1;
                    $(this).attr("id","orderrow_"+vali);
                    $(this).attr("data-id",vali);    
                    $(this).find('.sno').attr("id","s_no_"+vali);
                    $(this).find('.sno').attr("value",vali);
                    
                    $(this).find('.itemid').attr("id","itemid_"+vali);
                    $(this).find('.itemid').attr("data-id",vali);

                    $(this).find('.itemcode').attr("id","itemcode_"+vali);
                    $(this).find('.itemcode').attr("data-id",vali);

                    $(this).find('.itemname').attr("id","itemname_"+vali);
                    $(this).find('.itemname').attr("data-id",vali);

                    $(this).find('.purchaserate').attr("id","purchaserate_"+vali);
                    $(this).find('.purchaserate').attr("data-id",vali);

                    $(this).find('.view').attr("id","view_"+vali);
                    $(this).find('.view').attr("data-id",vali);

                    $(this).find('.unit').attr("id","unit_"+vali);
                    $(this).find('.unit').attr("data-id",vali);

                    $(this).find('.unitid').attr("id","unitid_"+vali);
                    $(this).find('.unitid').attr("data-id",vali);

                    $(this).find('.volume').attr("id","volume_"+vali);
                    $(this).find('.volume').attr("data-id",vali);

                    $(this).find('.qtyinstock').attr("id","qtyinstock_"+vali);
                    $(this).find('.qtyinstock').attr("data-id",vali);

                    $(this).find('.qty').attr("id","qty_"+vali);
                    $(this).find('.qty').attr("data-id",vali);

                    $(this).find('.remarks').attr("id","remarks_"+vali);
                    $(this).find('.remarks').attr("data-id",vali);

                    $(this).find('.btnAdd').attr("id","addOrder_"+vali);
                    $(this).find('.btnAdd').attr("data-id",vali);
                    $(this).find('.btnRemove').attr("id","addOrder_"+vali);
                    $(this).find('.btnRemove').attr("data-id",vali);
                    $(this).find('.btnChange').attr("id","btnChange_"+vali);
                    $(this).find('.acDiv2').attr("id","acDiv2_"+vali);

            });
              },600);
            setTimeout(function(){
                    var trlength = $('.orderrow').length;
                        // alert(trlength);
                             if(trlength==1)
                             {
                                 $('#acDiv2_1').html('');
                             }
                         },800);

          }
     });
    $(document).on('click','.itemDetail',function(){
        var rowno=$(this).data('rowno');
        var rate=$(this).data('rate');
        var itemcode=$(this).data('itemcode');
        var itemname=$(this).data('itemname');
        var itemname=$(this).data('itemname_display');
        var itemid=$(this).data('itemid');
        var stockqty=$(this).data('stockqty');

        var qty_in_stock=$(this).data('issueqty');

        var purchaserate=$(this).data('purrate');

        var matdetailid=$(this).data('mattransdetailid');
        var controlno=$(this).data('controlno');
        $('#itemcode_'+rowno).val(itemcode);
        $('#itemid_'+rowno).val(itemid);
        $('#itemname_'+rowno).val(itemname);
        $('#itemstock_'+rowno).val(stockqty);
        $('#matdetailid_'+rowno).val(matdetailid);
        $('#controlno_'+rowno).val(controlno);

        $('#qtyinstock_'+rowno).val(qty_in_stock);

        $('#purchaserate_'+rowno).val(purchaserate);

        $('#myView').modal('hide');
        $('#qty_'+rowno).focus();
     })
</script>

<script type="text/javascript">
    $(document).off('change','.handover');
    $(document).on('change','.handover',function(){

        if ($('input.handover').is(':checked')) {
            $('.handover_no').prop("disabled", false).show();
            $('.issue_no').prop("disabled", true).hide();
        }else{
            $('.handover_no').prop("disabled", true).hide();
            $('.issue_no').prop("disabled", false).show();
        }
    });
</script>

<script type="text/javascript">
    $(document).on('keyup change','.sade_qty',function(){
        var id = $(this).data('id');
        var qty = $('#qty_'+id).val();
        var valid_qty = checkValidValue(qty);
        var stock_qty = $('#qtyinstock_'+id).val();
        var valid_stock_qty = checkValidValue(stock_qty);

        console.log('q'+valid_qty);
        console.log('s'+valid_stock_qty);

        if(valid_qty > valid_stock_qty){
            alert('Issue qty can not be greater than stock qty');
            $('#qty_'+id).val(valid_stock_qty);
        }
    });
</script>

<script type="text/javascript">
    $(document).off('change','#depnme');
    $(document).on('change','#depnme',function(){

        var dep_name =  $("#depnme option:selected").text();
        // alert(dep_name);
        $('#depname').val(dep_name);

       
    });
</script>

<script type="text/javascript">
    $(document).off('change','#fyear');
    $(document).on('change','#fyear',function(e){
        var fyrs=$(this).val();
        var action=base_url+'issue_consumption/direct_issue/gen_invoice';
    $.ajax({
      type: "POST",
      url: action,
      data:{fyrs:fyrs},
      dataType: 'html',
   success: function(jsons) 
   {
       data = jQuery.parseJSON(jsons);   
       if(data.status=='success'){
        $('.issueno_gen').val(data.issue_no);
        $('.handover_no').val(data.handover_no);
       }else{

       }
    }
  });
});
</script>