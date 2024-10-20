<div class="form-group white-box pad-5 bg-gray">
    <div class="row">
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('invoice_no'); ?> : </label>
             <span> <?php echo !empty($issue_master[0]->sama_invoiceno)?$issue_master[0]->sama_invoiceno:''; ?></span>
        </div>
    

          <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('item_name'); ?> : </label>
            <span><?php echo !empty($issue_master[0]->itli_itemname)?$issue_master[0]->itli_itemname:''; ?></span>
        </div>

          <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('unit'); ?> : </label>
            <span><?php echo !empty($issue_master[0]->unit_unitname)?$issue_master[0]->unit_unitname:''; ?></span>
        </div>

  <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('received_qty'); ?> : </label>
            <span><?php echo !empty($issue_master[0]->sade_qty)?$issue_master[0]->sade_qty:'0'; ?></span>
        </div>

  <div class="col-md-3 col-sm-4">

            <label for="example-text"><?php echo $this->lang->line('expenses_qty'); ?> : </label>
            <span><?php echo !empty($test_count[0]->exp)?$test_count[0]->exp:'0'; ?></span>
        </div>

  <div class="col-md-3 col-sm-4">
    <?php $receivedqty=$issue_master[0]->sade_qty;
    $expensesqty=$test_count[0]->exp;
    $remainingqty=$receivedqty - $expensesqty;?>
            <label for="example-text"><?php echo $this->lang->line('remaining_qty'); ?> : </label>
            <span><?php echo !empty($remainingqty)?$remainingqty:'0'; ?></span>
        </div>

        <div class="clearfix"></div>
       
          <div class="col-md-3 col-sm-4">
            <?php $loc_name=!empty($issue_master[0]->sama_depname)?$issue_master[0]->sama_depname:''; ?>
            <label for="example-text"><?php echo $this->lang->line('department'); ?> :</label>
            <span><?php echo $loc_name; ?></span>
        </div>
      
    </div>
  
    <div class="clearfix"></div>
</div>

<div class="form-group">
   <form method="post" id="FormBrand" action="<?php echo base_url('issue_consumption/test/save_teststock'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('issue_consumption/test/view_details'); ?>'>
    <input type="hidden" name="test_salemasterid" value="<?php echo!empty($issue_master[0]->sade_salemasterid)?$issue_master[0]->sade_salemasterid:'';  ?>">
     <input type="hidden" name="test_itemid" value="<?php echo!empty($issue_master[0]->sade_itemsid)?$issue_master[0]->sade_itemsid:'';  ?>">
      <input type="hidden" name="test_saledetailid" value="<?php echo!empty($issue_master[0]->sade_saledetailid)?$issue_master[0]->sade_saledetailid:'';  ?>">
    <div class="form-group resp_xs">
        <div class="col-md-3">
                <?php
                    if(DEFAULT_DATEPICKER == 'NP'){
                        $exp_date = !empty($issue_master[0]->test_expensesdatebs)?$issue_master[0]->test_expensesdatebs:DISPLAY_DATE;
                    }else{
                        $exp_date = !empty($issue_master[0]->test_expensesdatead)?$issue_master[0]->test_expensesdatead:DISPLAY_DATE;
                    }
                ?>
                <label for="example-text"><?php echo $this->lang->line('date'); ?>: </label>
                <input type="text" name="test_expensesdate" class="form-control <?php echo DATEPICKER_CLASS; ?> date" id="test_expensesdate"  placeholder="Expenses Date" value="<?php echo $exp_date; ?>" >
                <span class="errmsg"></span>
            </div>

      
        <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('expenses_qty'); ?> <span class="required">*</span>:</label>
            <input type="text" id="test_expensesqty" name="test_expensesqty" class="form-control float required_field expqty" placeholder="Expenses Qty" value="">
             <input type="hidden" id="rem_qty" name="" class="form-control float required_field" placeholder="" value="<?php echo !empty($remainingqty)?$remainingqty:'0'; ?>">
        </div>
        <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('remarks'); ?> :
            </label>
            <input type="text" id="test_remarks" name="test_remarks" class="form-control" placeholder="Remarks" value="" >
        </div>
    </div>
    <?php
    $add_edit_status=!empty($edit_status)?$edit_status:0;
    $usergroup=$this->session->userdata(USER_GROUPCODE);
    // echo $add_edit_status;
    if((empty($dept_data)) || (!empty($dept_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>

    <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>
  


    <button type="submit" class="btn btn-info  <?php $savelist=!empty($is_savelist)?'Y':'N';if($savelist=='Y') echo 'savelist'; else echo 'savelist'; ?>" data-operation='<?php echo !empty($dept_data)?'update':'save' ?>' id="btnDeptment"  data-isdismiss="Y" ><?php echo $save_var ; ?></button>



    <?php
    endif; ?>
    <div  class="alert-success success"></div>
    <div class="alert-danger error"></div>
</form>
</div>

<div id="FormDiv_Reprint" class="printTable"></div>
<script>
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
        url:  base_url+'/issue_consumption/new_issue/reprint_issue_details',
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
</script>
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
})
</script>


<script type="text/javascript">
    $(document).off('keyup change','.expqty');
    $(document).on('keyup change','.expqty',function(){
     var expqty = $('#test_expensesqty').val();
     var valid_expqty = checkValidValue(expqty);
     var reme_qty = $('#rem_qty').val();
     var valid_rem_qty = checkValidValue(reme_qty);
     if(valid_expqty > valid_rem_qty){
        alert('Expenses qty can not be greater than Remaining qty');
    $('#test_expensesqty').val(valid_rem_qty);
    }
    });
</script>
