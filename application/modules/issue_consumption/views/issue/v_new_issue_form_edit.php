<style>
    .purs_table tbody tr td{
        border: none;
        vertical-align: center;
    }
</style>
<form method="post" id="FormIssueNew" action="<?php echo base_url('issue_consumption/new_issue/save_new_issue'); ?>" data-reloadurl="<?php echo base_url('issue_consumption/new_issue/form_new_issue_edit');?>" class="form-material form-horizontal form">

    <input type="hidden" name="id" value="<?php echo !empty($issue_master[0]->sama_salemasterid)?$issue_master[0]->sama_salemasterid:'';  ?>">

    <div id="issueDetails">
        <div class="form-group">
            <div class="col-md-3 col-sm-4">
        <label for="example-text"><?php echo $this->lang->line('department'); ?> <span class="required">*</span>:</label>
        <?php 
        $departmentid=!empty($issue_master[0]->sama_depid)?$issue_master[0]->sama_depid:''; 
        // echo $departmentid;
        // die();
        ?>
        <select id="depnme" name="sama_depid"  class="form-control required_field"  >
            <option value="">---select---</option>
            <?php 
                if($depatrment):
                    foreach ($depatrment as $km => $dep):
            ?>
             <option value="<?php echo $dep->dept_depid; ?>"  <?php if($departmentid==$dep->dept_depid) echo "selected=selected"; ?>><?php echo $dep->dept_depname; ?></option>
            <?php
                    endforeach;
                endif;
            ?>
        </select>
        
    </div>
     <?php //echo $this->general->location_option(3,'sama_locationid','sama_locationid',false,'To'); ?>
    <div class="col-md-3 col-sm-4">
        <?php $sama_fyear = !empty($issue_master[0]->sama_fyear)?$issue_master[0]->sama_fyear:CUR_FISCALYEAR; ?>
        <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?><span class="required">*</span> :</label>

       <select name="sama_fyear" class="form-control required_field" id="fyear" >
           <?php
             if($fiscal_year): 
             foreach ($fiscal_year as $kf => $fyrs):
             ?>
            <option value="<?php echo $fyrs->fiye_name; ?>" <?php if($sama_fyear==$fyrs->fiye_name) echo "selected=selected"; ?> ><?php echo $fyrs->fiye_name; ?></option>
         <?php endforeach; endif; ?>
       </select>
    </div>

    <div class="col-md-3 col-sm-4">
        <?php if(!empty($reqno)){
            $sama_reqnodb = !empty($reqno)?$reqno:'';
        }else{
            $sama_reqnodb = !empty($issue_master[0]->sama_requisitionno)?$issue_master[0]->sama_requisitionno:'';
        }
         ?>
        <label for="example-text"><?php echo $this->lang->line('req_no'); ?> <span class="required">*</span>:</label>
        <div class="dis_tab">
            <input type="text" class="form-control reqno send_after_stop number enterinput required_field " name="sama_requisitionno"  value="<?php echo $sama_reqnodb; ?>" placeholder="Enter Demand No." id="req_no" data-targetbtn="SrchReq" autocomplete="off" autofocus="on" readonly>
            <?php if(empty($issue_master)): ?>
            <a href="javascript:void(0)" class="table-cell width_30 btn btn-success"  id="SrchReq"><i class="fa fa-search"></i></a>&nbsp;
            <a href="javascript:void(0)"  data-id="0" data-fyear="<?php echo CUR_FISCALYEAR;?>" data-displaydiv="Issue" data-viewurl="<?php echo base_url() ?>stock_inventory/stock_requisition/load_requisition" class="view table-cell width_30 btn btn-success" data-heading="<?php echo $this->lang->line('load_requisition')?>" id="reqload" ><i class="fa fa-upload"></i></a>
        <?php endif; ?>
        </div>
    </div>
</div>

<div class="clearfix"></div>
     <div class="form-group">

    <div class="col-md-3 col-sm-4">
        <?php
            if(DEFAULT_DATEPICKER == 'NP'){
                $sama_billdate = !empty($issue_master[0]->sama_billdatebs)?$issue_master[0]->sama_billdatebs:DISPLAY_DATE;
                $sama_reqdate=!empty($issue_master[0]->sama_requisitiondatebs)?$issue_master[0]->sama_requisitiondatebs:''; 
            }else{
                $sama_billdate = !empty($issue_master[0]->sama_billdatead)?$issue_master[0]->sama_billdatead:DISPLAY_DATE;
                 $sama_reqdate=!empty($issue_master[0]->sama_requisitiondatead)?$issue_master[0]->sama_requisitiondatead:''; 
            } 
        ?>
        <label for="example-text"><?php echo $this->lang->line('issue_date'); ?><span class="required">*</span> :</label>
        <input type="text" class="form-control required_field <?php echo DATEPICKER_CLASS; ?>" name="issue_date" value="<?php echo $sama_billdate; ?>" id="issuedate" placeholder="YYYY/MM/DD ">
    </div>

    <div class="col-md-3 col-sm-4">
        <label for="example-text"><?php echo $this->lang->line('requisition_date'); ?><span class="required">*</span>  :</label>
        <input type="text" class="form-control required_field" name="requisition_date" value="<?php echo $sama_reqdate; ?>"  readonly placeholder="Enter Requisition Date" id="requisition_date">
    </div>

    <div class="col-md-3 col-sm-4">
        <?php $sama_invoiceno=!empty($issue_master[0]->sama_invoiceno)?$issue_master[0]->sama_invoiceno:''; ?>
        <label for="example-text"><?php echo $this->lang->line('issue_no'); ?> :</label>
        <input type="text" class="form-control" name="sama_invoiceno" id="issue_no"  value="<?php echo !empty($sama_invoiceno)?$sama_invoiceno:$issue_no; ?>" placeholder="Enter Issue Number" readonly>
    </div>

    <div class="col-md-3 col-sm-4">
        <?php $sama_receivedby=!empty($issue_master[0]->sama_receivedby)?$issue_master[0]->sama_receivedby:''; ?>
        <label for="example-text"><?php echo $this->lang->line('received_by'); ?> :</label>
        <input type="text" class="form-control" name="sama_receivedby" value="<?php echo $sama_receivedby; ?>" placeholder="Enter Received By" id="receive_by">
    </div>
    <?php 
    $is_handover = !empty($issue_master[0]->sama_ishandover) ? $issue_master[0]->sama_ishandover : "";
    if($is_handover == 'Y'):
    ?>
    <input type="hidden" name="handover" value="Y">
    <?php endif; ?>
   
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
                     <th scope="col" width="10%"> <?php echo $this->lang->line('avl_iss_qtys'); ?></th>
                    <th scope="col" width="10%"> <?php echo $this->lang->line('qty'); ?> </th>
                    
                    <th scope="col" width="15%"> <?php echo $this->lang->line('remarks'); ?></th>
                    <th><?php echo $this->lang->line('action'); ?></th>
                </tr>
            </thead>
                <tbody id="orderBody">
                    
                        <?php 
                        $i=1; 
                        if(!empty($issue_details)):
                        foreach ($issue_details as $key => $isu) { 
                            $stockqty =$isu->stockqty;
                            $remqty=!empty($isu->rede_remqty)?$isu->rede_remqty:0;
                            $isqty=$isu->sade_qty;
                            // echo ORGANIZATION_NAME;
                            // die(); 
                            if(ORGANIZATION_NAME=='NPHL'){
                               $avlqty=$stockqty+$isqty; 
                           }else{
                                 $avlqty=$remqty+$isqty;
                           }
                           
                            ?>
                        <tr class="orderrow" id="orderrow_1" data-id='<?php echo $i; ?>'>
                        <td data-label="S.No."><?php echo $i; ?></td>
                        <input type="hidden" name="sade_saledetailid[]" value="<?php echo $isu->sade_saledetailid ?>">
                         <input type="hidden" name="sade_mattransdetailid[]" value="<?php echo $isu->sade_mattransdetailid ?>">
                          <input type="hidden" name="sade_reqdetailid[]" value="<?php echo $isu->sade_reqdetailid ?>">
                         
                        <td data-label="Items Code"> 
                            <input type="hidden" class="itemsid" id="itemsid_<?php echo $i; ?>" name="sade_itemsid[]" data-id="<?php echo $i; ?>" value="<?php echo $isu->sade_itemsid; ?>">

                            <input type="text" class="form-control float rede_code " id="rede_code_<?php echo $i; ?>" name="rede_code[]" value="<?php echo $isu->itli_itemcode;?>" data-id='<?php echo $i; ?>' readonly> 
                        </td>
                        <td data-label="Items Name">                             
                             <input type="text" class="form-control itemname" id="rede_code_1" name="sade_itemsname[]" value="<?php echo $isu->itli_itemname;?>" data-id='<?php echo $i; ?>' readonly> 
                        </td>
                        <td data-label="Unit"> 
                                <input type="text" class="form-control unit" name="unit[]" value="<?php echo $isu->unit_unitname;?>"  id="rede_unit_<?php echo $i; ?>" data-id='<?php echo $i; ?>' readonly > 
                        </td>
                        <td data-label="Volume"> 
                                <input type="text" class="form-control" name="volume[]" value=""  id="volume_<?php echo $i; ?>" data-id='<?php echo $i; ?>' > 
                        </td>
                         <td data-label="Stock Qty.">
                            <input type="text" class="form-control stockqty" id="stockqty_<?php echo $i; ?>" name="stockqty[]" value="<?php echo $stockqty; ?>"  data-id='<?php echo $i; ?>' disabled="disabled">  
                        </td>
                          <td data-label="Aailable Qty.">
                            <input type="text" class="form-control avlqty" id="avlqty_<?php echo $i; ?>" name="avlqty[]" value="<?php echo $avlqty; ?>"  data-id='<?php echo $i; ?>' disabled="disabled">  
                        </td>
                        <td data-label="Qty."> 
                             <input type="hidden" class="form-control required_field cur_issue_qty" id="cur_issue_qty_<?php echo $i; ?>" name="" value="<?php echo $isu->sade_qty ?>"  data-id='<?php echo $i; ?>' > 

                                <input type="text" class="form-control required_field sade_qty float arrow_keypress" id="sade_qty_<?php echo $i; ?>" name="sade_qty[]" value="<?php echo $isu->sade_qty ?>"  data-id='<?php echo $i; ?>' data-fieldid="sade_qty" > 
                        </td>
                        <td>
                            <input type="text" class="form-control remarks arrow_keypress" id="rede_remarks_<?php echo $i; ?>" name="sade_remarks[]" value="<?php echo $isu->sade_remarks ?>"  data-id='<?php echo $i; ?>' data-fieldid="remarks"  >  
                        </td>
                      
                            <td data-label="Action">
                                <a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="<?php echo $i; ?>" id="addRequistion_<?php echo $i; ?>"><span class="btnChange" id="btnChange_<?php echo $i; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>
                            
                        </td>

                    <?php $i++;
                        } endif;?>
                    </tr> 
                   
                </tbody>
        </table>
    </div>
    </div>
</div>

<div class="form-group">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="example-text"><?php echo $this->lang->line('notes_if_any'); ?>: </label>
        <input type="text" name="sama_remarks" class="form-control"  placeholder="Enter Notes (If any)" value="<?php echo !empty($issue_master[0]->sama_remarks)?$issue_master[0]->sama_remarks:''; ?>" id="sama_remarks">
        <span class="errmsg"></span>
    </div>
</div>

<div class="clearfix"></div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
        <?php 
          $save_var=$this->lang->line('save');
                $update_var=$this->lang->line('update');

                // $update_var:$save_var;
        ?>
            <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($issue_master)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($issue_master)?$update_var:$save_var; ?></button>
            <button type="submit" class="btn btn-info savePrint" data-operation='<?php echo !empty($issue_master)?'update':'save ' ?>' id="btnSubmit" data-print="print"><?php echo !empty($issue_master)?'Update & Print':$this->lang->line('save_and_print') ?></button>
        </div>
          <div class="col-sm-12">
            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
          </div>
    </div>
    <div id="Printable" class="print_report_section printTable"></div>
</form> 

<script type="text/javascript">
    $.fn.pressEnter = function(fn) {  
    return this.each(function() {  
        $(this).bind('enterPress', fn);
        $(this).keyup(function(e){
            if(e.keyCode == 13)
            {
              $(this).trigger("enterPress");
            }
        })
    });  
 }; 

$(document).off('change','#depnme');
$(document).on('change','#depnme',function()
{
    var heading=$('.view').data('heading');
    // $('#reqload').removeAttr('data-heading');
    // alert(heading);

    var depid= $(this).val();
    var depname='';
    // var depname=$(this).text();
    var depname=$("#depnme option:selected").text();

    $('#depname').val(depname);
    // alert(depname);
    var new_heading='Load Requisition'+'-'+depname;

    // console.log(depid);
    $('#reqload').attr('data-id',depid);
    $('#reqload').data('id',depid);

    $('#reqload').attr('data-heading',new_heading);
    $('#reqload').data('heading',new_heading);
    
   // var depid= $(this).val();
   // $('.view').removeAttr('data-id');
   // setTimeout(function(){
   //      $('#reqload').data('id',depid);
   // },2000);
   
})

</script>

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

     function getPendingList(req_masterid, main_form=false){
            if(main_form == 'main_form'){
                var submiturl = base_url+'stock_inventory/stock_requisition/load_pendinglist/new_issue_pending_list';
                var displaydiv = '#DisplayPendingList'; 
            }else{
                var submiturl = base_url+'stock_inventory/stock_requisition/load_pendinglist';
                var displaydiv = '#pendingListBox';
            }
            
            $.ajax({
                type: "POST",
                url: submiturl,
                data: {req_masterid : req_masterid},
                beforeSend: function (){
                    // $('.overlay').modal('show');
                },
                success: function(jsons){
                    var data = jQuery.parseJSON(jsons);
                    // console.log(data);
                    if(main_form == 'main_form'){
                        if(data.status == 'success'){
                            if(data.isempty == 'empty'){
                                alert('Pending list is empty. Please try again.');
                                   $('#requisition_date').val('');
                                   $('#receive_by').val(''); 
                                   $('#depnme').select2("val",'');
                                   $('#pendinglist').html('');
                                   $('#stock_limit').html(0);
                                return false;
                            }else{
                                $(displaydiv).empty().html(data.tempform);
                            }
                        }
                    }else{
                        if(data.status == 'success'){
                            $(displaydiv).empty().html(data.tempform);
                        }
                    }
                    
                    // $('.overlay').modal('hide');
                }
            });
        }

function blink_text() {
    $('.blink').fadeOut(100);
    $('.blink').fadeIn(1000);
}

function ajax_search_requistion()
{
    var req_no=$('#req_no').val();
    var fyear=$('#fyear').val();
    var submitdata = {req_no:req_no,fyear:fyear};
    var submiturl = base_url+'issue_consumption/new_issue/issuelist_by_req_no';
        beforeSend= $('.overlay').modal('show');
        ajaxPostSubmit(submiturl,submitdata,beforeSend='',onSuccess);
    function onSuccess(jsons){
        data = jQuery.parseJSON(jsons);
        // console.log(data);
        $('#ndp-nepali-box').hide();
        if(data.status=='success')
        {
            // console.log(data.req_data);
            var reqdata=data.req_data;
            $('#requisition_date').val(reqdata.req_date);
            $('#receive_by').val(reqdata.reqby);
            $('#depnme').select2("val", reqdata.fromdepid);
            $('#depnme').val(reqdata.fromdepid);
            
            getPendingList(data.masterid,'main_form');
            setTimeout(function(){
            var limstk_cnt=$('.limited_stock').length;
            $('#stock_limit').html(limstk_cnt);
        },1500);
        } 
        else{
            alert(data.message);
            $('#requisition_date').val('');
            $('#receive_by').val('');
            $('#depnme').select2("val",'');
            $('#depnme').val("");
            $('#pendinglist').html('');
            $('#stock_limit').html(0);
            // return false;
        } 
        $('.overlay').modal('hide');

        }
    }
   $('.send_after_stop').donetyping(function(){
   // ajax_search_requistion();
});
setInterval(blink_text, 3000);
</script>
<script type="text/javascript">
    $(document).off('click','#SrchReq');
    $(document).on('click','#SrchReq',function(){
    ajax_search_requistion();
    });
    
</script>

<?php if(!empty($reqno))
    {
      ?>
    <script>
        $(document).ready(function(){
            // $('.view').trigger("click");
           // $(this).trigger("enterKey");
           $('#SrchReq').click();
       });
        
    </script>
<?php } ?>

<script>
    $(document).off('change','#fyear');
    $(document).on('change','#fyear',function(){
        var fyear = $('#fyear').val();
        $('#reqload').attr('data-fyear',fyear);
    });
</script>

<script type="text/javascript">
    $(document).off('keyup','.sade_qty');
    $(document).on('keyup','.sade_qty',function(e){
        var rowid = $(this).data('id');
        var sade_qty = $('#sade_qty_'+rowid).val();
        if(sade_qty==NaN || sade_qty =='')
        {
            sade_qty=0;
        }
        var qtyinstock = $('#stockqty_'+rowid).val();
        var avlqty=$('#avlqty_'+rowid).val();
        var cur_issue_qty=$('#cur_issue_qty_'+rowid).val();
        // console.log('rowid :'+rowid);
        // console.log('sade_qty :'+sade_qty);
        // console.log('qtyinstock :'+qtyinstock);
        sade_qty = parseInt(sade_qty);
        qtyinstock = parseInt(qtyinstock);
        avlqty=parseInt(avlqty);
        var iss_avlqty= qtyinstock+parseInt(cur_issue_qty);
        // alert(iss_avlqty);
        // return false;
        if(sade_qty > iss_avlqty){
           alert('Issue Qty should not exceed stock qty. Please check it.');
           $('#sade_qty_'+rowid).val(cur_issue_qty);
           $('#sade_qty_'+rowid).focus().select();
           return false;  
        }

        if(sade_qty > avlqty){
            alert('Issue Qty should not exceed Req. qty. Please check it.');
            $('#sade_qty_'+rowid).val(avlqty);
            return false;
        }

    });

</script>