<form method="post" id="FormManageReturn" action="<?php echo base_url('issue_consumption/manage_return/save_department'); ?>" data-reloadurl='<?php echo base_url('issue_consumption/manage_return/change_reloadform'); ?>'  class="form-material form-horizontal form">
    <input type="hidden" name="id" value="<?php echo!empty($challan_data[0]->chma_challanmasterid)?$challan_data[0]->chma_challanmasterid:'';  ?>">
    <div class="form-group">
        <div class="col-md-3">
            <label for="example-text"><?php echo $this->lang->line('return_no'); ?> : <span class="required">*</span>:</label>
            <input type="text" class="form-control invoice_no" name="invoice_no" id="invoice_no" placeholder="Enter Return  No ">
        </div>
        <div class="col-md-3">
            <label for="example-text"><?php echo $this->lang->line('new_return_no'); ?>: <span class="required">*</span>:</label>
            <input type="text" class="form-control" name="new_returnno" id="txtchallanCode" placeholder="New Return No">
        </div>
        <div class="col-md-3">
            <label for="example-text"> <?php echo $this->lang->line('return_date'); ?> :<span class="required">*</span>:</label>
            <input type="text" name="return_date" class="form-control <?php echo DATEPICKER_CLASS; ?>"  value="<?php echo DISPLAY_DATE; ?>" id="receivw_date" >
        </div>
        <div class="col-md-3">
            <label for="example-text"><?php echo $this->lang->line('new_return_date'); ?> :<span class="required">*</span>:</label>
            <input type="text" name="new_return_date" class="form-control <?php echo DATEPICKER_CLASS; ?>"  value="<?php echo DISPLAY_DATE; ?>" id="return_date" >
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
          <?php   $save_var=$this->lang->line('save');
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