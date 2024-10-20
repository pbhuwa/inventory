<form method="post" id="FormApproved" action="<?php echo base_url('stock_inventory/approved/save_approved'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('stock_inventory/approved/form_approved'); ?>'>

    <input type="hidden" name="id" value="<?php echo!empty($approved_data[0]->appr_approvedid)?$approved_data[0]->appr_approvedid:'';  ?>">

    <div class="form-group">

        <div class="col-md-4">

         <label for="example-text"><?php echo $this->lang->line('approved_name'); ?> <span class="required">*</span> :

            </label>

               <input type="text"  name="appr_approvedname" class="form-control" placeholder="approved Name" value="<?php echo !empty($approved_data[0]->appr_approvedname)?$approved_data[0]->appr_approvedname:''; ?>" autofocus="true">



        </div>

    </div>

        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>

    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 <?php echo !empty($frompopup)?'savelist':'save'; ?>" data-isdismiss='Y' data-operation='<?php echo !empty($approved_data)?'update':'save' ?>'><?php echo !empty($approved_data)?$update_var:$save_var; ?></button>

      

        <div id="ResponseSuccess_FormApproved"  class=" alert-success success"></div>



         <div id="ResponseError_FormApproved" class=" alert-danger error" ></div>

</form>