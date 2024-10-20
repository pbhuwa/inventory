<form method="post" id="FormCommunity" action="<?php echo base_url('settings/community/save_community'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('settings/community/form_community'); ?>'>
<input type="hidden" name="id" value="<?php echo!empty($comm_data[0]->comm_communityid)?$comm_data[0]->comm_communityid:'';  ?>">
        <div class="form-group">
            <div class="col-md-12">
             <label for="example-text">Community:</label>
                
                   <input type="text" name="comm_community" class="form-control" placeholder="Enter Community" value="<?php echo !empty($comm_data[0]->comm_community)?$comm_data[0]->comm_community:''; ?>">
            </div>
        </div>
    <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($comm_data)?'update':'save' ?>'  ><?php echo !empty($comm_data)?'Update':'Save' ?></button>
        <div id="ResponseSuccess" class="success text-success"></div>
        <div id="ResponseError" class="error text-danger"></div>
</form>