<style>
    .purs_table tbody tr td{
        border: none;
        vertical-align: center;
    }
</style>
<form method="post" id="AssetIssue" action="<?php echo base_url('ams/asset_issue/save_asset_issue'); ?>" data-reloadurl="<?php echo base_url('ams/asset_issue/index/reload');?>" class="form-material form-horizontal form">

    <input type="hidden" name="id" value="<?php echo !empty($new_issue[0]->sama_salemasterid)?$new_issue[0]->sama_salemasterid:'';  ?>">
    <input type="hidden" name="asim_remamasterid" value="" id="asim_remamasterid">

    <div id="issueDetails">
        <div class="form-group">
            <div class="col-md-3 col-sm-4">
        <label for="example-text"><?php echo $this->lang->line('department'); ?> <span class="required">*</span>:</label>
        <?php $department=!empty($depart)?$depart:''; ?>
        <select id="depnme" name="asim_depid"  class="form-control required_field">
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
        <input type="hidden" id="depname" name="asim_depname"/>
    </div>
    <div class="col-md-3 col-sm-4">
        <?php $sama_fyear = !empty($new_issue[0]->sama_fyear)?$new_issue[0]->sama_fyear:CUR_FISCALYEAR; ?>
        <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?><span class="required">*</span> :</label>
       <!--  <input type="text" class="form-control" name="sama_fyear" id="fiscal_year" value="<?php echo $sama_fyear; ?>" placeholder="Fiscal Year" > -->
       <select name="asim_fyear" class="form-control required_field" id="fyear">
           <?php
             if($fiscal_year): 
             foreach ($fiscal_year as $kf => $fyrs):
             ?>
            <option value="<?php echo $fyrs->fiye_name; ?>" <?php if($fyrs->fiye_status=='I') echo "selected=selected"; ?> ><?php echo $fyrs->fiye_name; ?></option>
         <?php endforeach; endif; ?>
       </select>
    </div>

    <div class="col-md-3 col-sm-4">
        <?php if($reqno){
            $sama_reqnodb = !empty($reqno)?$reqno:'';
        }else{
            $sama_reqnodb = !empty($new_issue[0]->sama_requisitionno)?$new_issue[0]->sama_requisitionno:'';
        }
         ?>
        <label for="example-text"><?php echo $this->lang->line('req_no'); ?> <span class="required">*</span>:</label>
        <div class="dis_tab">
            <input type="text" class="form-control reqno send_after_stop number enterinput required_field " name="asim_requisitionno"  value="<?php echo $sama_reqnodb; ?>" placeholder="Enter Req No." id="req_no" data-targetbtn="SrchReq" autocomplete="off" autofocus="on">
            <a href="javascript:void(0)" class="table-cell width_30 btn btn-success"  id="SrchReq"><i class="fa fa-search"></i></a>&nbsp;
            <a href="javascript:void(0)"  data-id="0" data-fyear="<?php echo CUR_FISCALYEAR;?>" data-displaydiv="Issue" data-viewurl="<?php echo base_url() ?>stock_inventory/stock_requisition/load_requisition" class="view table-cell width_30 btn btn-success" data-heading="<?php echo $this->lang->line('load_requisition')?>" id="reqload" ><i class="fa fa-upload"></i></a>
        </div>
    </div>
</div>

<div class="clearfix"></div>
     <div class="form-group">

    <div class="col-md-3 col-sm-4">
        <?php
            if(DEFAULT_DATEPICKER == 'NP'){
                $sama_billdate = !empty($new_issue[0]->sama_billdatebs)?$new_issue[0]->sama_billdatebs:DISPLAY_DATE;
                $sama_reqdate=!empty($new_issue[0]->sama_requisitiondatebs)?$new_issue[0]->sama_requisitiondatebs:''; 
            }else{
                $sama_billdate = !empty($new_issue[0]->sama_billdatead)?$new_issue[0]->sama_billdatead:DISPLAY_DATE;
                 $sama_reqdate=!empty($new_issue[0]->sama_requisitiondatead)?$new_issue[0]->sama_requisitiondatead:''; 
            } 
        ?>
        <label for="example-text"><?php echo $this->lang->line('issue_date'); ?><span class="required">*</span> :</label>
        <input type="text" class="form-control required_field <?php echo DATEPICKER_CLASS; ?>" name="issue_date" value="<?php echo $sama_billdate; ?>" id="issuedate" placeholder="YYYY/MM/DD ">
    </div>

    <div class="col-md-3 col-sm-4">
        <label for="example-text"><?php echo $this->lang->line('requisition_date'); ?><span class="required">*</span>  :</label>
        <input type="text" class="form-control required_field <?php echo DATEPICKER_CLASS; ?>" name="requisition_date" value="<?php echo $sama_reqdate; ?>"  readonly placeholder="Enter Requisition Date" id="requisition_date">
    </div>

    <div class="col-md-3 col-sm-4">
        <?php $sama_invoiceno=!empty($new_issue[0]->sama_invoiceno)?$new_issue[0]->sama_invoiceno:''; ?>
        <label for="example-text"><?php echo $this->lang->line('issue_no'); ?> :</label>
        <input type="text" class="form-control issueno_gen required_field" name="asim_issueno" id="issue_no"  value="<?php echo !empty($sama_invoiceno)?$sama_invoiceno:$issue_no; ?>" placeholder="Enter Issue Number" readonly>
    </div>

    <div class="col-md-3 col-sm-4">
        <?php $sama_receivedby=!empty($new_issue[0]->sama_receivedby)?$new_issue[0]->sama_receivedby:''; ?>
        <label for="example-text"><?php echo $this->lang->line('received_by'); ?> :</label>
        <select class="form-control select2 required_field" name="received_by" id="receive_by">
            <option value="">---select---</option>
            <?php 
                if (!empty($staff_list)):
                    foreach($staff_list as $staff):
            ?>
            <option value="<?php echo "$staff->stin_staffinfoid@$staff->stin_fname $staff->stin_lname";?>"><?php echo "$staff->stin_fname $staff->stin_lname";?></option>
            <?php
                endforeach;
            endif;
            ?>
        </select>
        <!-- <input type="text" class="form-control" name="sama_receivedby" value="<?php echo $sama_receivedby; ?>" placeholder="Enter Received By" id="receive_by"> -->
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
                    <th scope="col" width="10%"> Req.Qty </th>
                    <th scope="col" width="10%"> <?php echo $this->lang->line('rem_qty'); ?> </th>
                    <th scope="col" width="10%"> Store Qty </th>
                    <th scope="col" width="10%"> Assets </th>
                    <th scope="col" width="15%"> <?php echo $this->lang->line('remarks'); ?></th>
                </tr>
            </thead>
                <tbody id="orderBody">
                   <!--  <tr class="orderrow" id="orderrow_1" data-id='1'>
                        <?php $i=1; if($new_issue):
                        foreach ($new_issue as $key => $isu) { ?>
                            
                        <td data-label="S.No."><?php echo $i; ?></td>

                        <td data-label="Items Code"> 
                            <input type="text" class="form-control float rede_code calculateamt" id="rede_code_1" name="rede_code[]" value="<?php //echo $isu->rede_itemsid;?>" data-id='1' readonly> 
                        </td>
                        <td data-label="Items Name">                             
                             <input type="text" class="form-control float rede_code calculateamt" id="rede_code_1" name="item[]" value="<?php echo $isu->rede_itemsid;?>" data-id='1' readonly> 
                        </td>
                        <td data-label="Unit"> 
                                <input type="text" class="form-control float rede_unit calculateamt rede_unit" name="particular[]" value="<?php echo $isu->rede_itemsid;?>"  id="rede_unit_1" data-id='1' > 
                        </td>
                        <td data-label="Volume"> 
                                <input type="text" class="form-control float rede_qty rede_qty" name="unit[]" value="<?php echo $isu->rede_itemsid;?>"  id="rede_qty_1" data-id='1' > 
                        </td>
                        <td data-label="Rem. Qty."> 
                                <input type="text" class="form-control required_field" id="rede_remarks_1" name="qty[]" value="<?php echo $isu->rede_qty ?>"  data-id='1'> 
                        </td>
                        <td data-label="Stock Qty.">
                            <input type="text" class="form-control required_field" id="rede_remarks_1" name="rede_remarks[]" value="<?php echo $isu->rede_total ?>"  data-id='1'>  
                        </td>
                         <td data-label="Assets">
                            <input type="text" class="form-control required_field" id="rede_remarks_1" name="rede_remarks[]" value="<?php echo $isu->rede_total ?>"  data-id='1'>  
                        </td>
                          <td data-label="Remarks">
                            <input type="text" class="form-control required_field" id="rede_remarks_1" name="rede_remarks[]" value="<?php echo $isu->rede_total ?>"  data-id='1'>  
                        </td>

                    <?php $i++;
                        } endif;?>
                    </tr>  -->
                   
                </tbody>
        </table>
    </div>
    </div>
</div>

<div class="form-group">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="example-text"><?php echo $this->lang->line('notes_if_any'); ?>: </label>
        <input type="text" name="asim_remarks" class="form-control"  placeholder="Enter Notes (If any)" value="<?php echo !empty($new_issue[0]->sama_remarks)?$new_issue[0]->sama_remarks:''; ?>" id="sama_remarks">
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
            var submiturl = base_url+'ams/asset_issue/load_pendinglist/new_issue_pending_list';
            var displaydiv = '#DisplayPendingList';  
        }else{
            var submiturl = base_url+'ams/asset_issue/load_pendinglist';
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
                            $('.select2assets').select2();
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
    var submiturl = base_url+'ams/asset_issue/search_requisition_no_for_assets';
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
            // $('#receive_by').val(reqdata.reqby);
            $('#depnme').select2("val", reqdata.fromdepid);
            $('#depnme').val(reqdata.fromdepid);
            $('#asim_remamasterid').val(data.masterid);
            getPendingList(data.masterid,'main_form');
            setTimeout(function(){
            var limstk_cnt=$('.limited_stock').length;
            $('#stock_limit').html(limstk_cnt);
        },1500);
        } 
        else{
            alert(data.message);
            $('#asim_remamasterid').val('');
            $('#requisition_date').val('');
            // $('#receive_by').val('');
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

<?php if($reqno)
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

<script type="text/javascript">
    $(document).off('change','#fyear');
    $(document).on('change','#fyear',function(e){
        var fyrs=$(this).val();
         $('#reqload').attr('data-fyear',fyear);
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