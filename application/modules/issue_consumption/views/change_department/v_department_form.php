<form method="post" id="FormChangeDepartment" action="<?php echo base_url('issue_consumption/change_department/save_department'); ?>" data-reloadurl='<?php echo base_url('issue_consumption/change_department/change_reloadform'); ?>'  class="form-material form-horizontal form">
    <div id="itemWiseReport">
    <input type="hidden" name="id" value="<?php echo!empty($challan_data[0]->chma_challanmasterid)?$challan_data[0]->chma_challanmasterid:'';  ?>">
    <div class="form-group">
        <div class="col-md-3">
            <label for="example-text"><?php echo $this->lang->line('invoice_no'); ?> : <span class="required">*</span>:</label>
            <input type="text" class="form-control invoice_no" name="invoice_no" id="invoice_no" placeholder="Enter Invoice  No ">
        </div>
        <div class="col-md-3">
            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> : <span class="required">*</span>:</label>
            <input type="text" class="form-control" name="fiscal_year" value="073/74">
        </div>
        <div class="col-md-3">
            <label for="example-text"><?php echo $this->lang->line('new_invoice_no'); ?>: <span class="required">*</span>:</label>
            <input type="text" class="form-control" name="chma_suchallanno" id="txtchallanCode" placeholder="New Invoice No">
        </div>
        <div class="col-md-3">
            <label for="example-text"><?php echo $this->lang->line('date'); ?> :<span class="required">*</span>:</label>
            <input type="text" name="chma_receivedatebs" class="form-control <?php echo DATEPICKER_CLASS; ?>"  placeholder="" value="<?php echo DISPLAY_DATE; ?>" id="receivw_date" placeholder="Enter Challan Receive Date">
        </div>
    </div>
    <div class="clear-fix"></div>
    <div class="form-group">
        <div class="col-md-3">
            <label for="example-text"><?php echo $this->lang->line('req_no'); ?>: <span class="required">*</span>:</label>
            <input type="text" class="form-control" name="chma_suchallanno" id="txtchallanCode" placeholder=" Enter Req No">
        </div>
        <div class="col-md-3">
            <label for="example-text"><?php echo $this->lang->line('manual_no'); ?> : <span class="required">*</span>:</label>
            <input type="text" class="form-control" name="chma_suchallanno" id="txtchallanCode" placeholder=" Enter Manual No">
        </div>
        <div class="col-md-3">
            <label for="example-text"><?php echo $this->lang->line('select_actual_department'); ?>: <span class="required">*</span>:</label>
            <select name="dept_depid" class="form-control select2" id="deptsubcategory">
                <option value="">---select---</option>
                <?php
                if($department):
                foreach ($department as $km => $mat):
                ?>
                <option value="<?php echo $mat->dept_depid; ?>"><?php echo $mat->dept_depname; ?></option>
                <?php
                endforeach;
                endif;
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="example-text"><?php echo $this->lang->line('received_by'); ?> : <span class="required">*</span>:</label>
            <input type="text" class="form-control" name="chma_suchallanno" id="txtchallanCode" placeholder=" Enter Received By">
        </div>
        <div class="col-md-6">
            <label for="exampleFormControlTextarea1"><?php echo $this->lang->line('remarks'); ?></label>
            <textarea class="form-control rounded-0" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
    </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <?php
                $save_var=$this->lang->line('save');
                $update_var=$this->lang->line('search');
            ?>
            <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($menu_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($menu_data)?$update_var:$save_var; ?></button>
        </div>
        <div class="col-sm-12">
            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
        </div>
    </div>
</div>
<script>
    $(document).on('blur','.invoice_no',function(){
        var invoice_no =$("#invoice_no").val();
        var action=base_url+'issue_consumption/change_department/change_details';
        $.ajax({
            type: "POST",
               url: action,
               data:$('#FormChangeDepartment').serialize(),
               dataType: 'html',
            success: function(jsons) 
            {
                console.log(jsons);

                data = jQuery.parseJSON(jsons);
                if(data.status=='success')
                {
                    $('#itemWiseReport').html(data.tempform);
                }
                else
                {
                }
            }
        });
    });
</script>