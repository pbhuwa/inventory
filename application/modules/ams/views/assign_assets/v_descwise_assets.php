<div class="mtop_5">

<?php $ismultiple=!empty($is_multiple)?$is_multiple:'N'; ?>

<h3 class="box-title"><?php echo $this->lang->line('assets_list'); ?> </h3>
<div class="">
    <table class="table table-border table-striped table-site-detail dataTable no-marg full_width">
        <thead>
            <tr>
    	        <?php if($ismultiple=='N'): ?>
                    <th width="5%" class="chkbox_align"><input type="checkbox" class="chkboxall" value="0"><span></span></th>
                <?php endif; ?>
                <th width="10%"><?php echo $this->lang->line('assets_code'); ?></th>
                <th width="15%"><?php echo $this->lang->line('assets_type'); ?></th>
                <th width="15%"><?php echo $this->lang->line('description'); ?></th>
                <th width="10%"><?php echo $this->lang->line('model_no'); ?></th>
                <th width="10%"><?php echo $this->lang->line('serial_no'); ?></th>
                <th width="10%"><?php echo $this->lang->line('status'); ?></th>
                <th width="10%"><?php echo $this->lang->line('condition'); ?></th> 
                <?php if($ismultiple=='N'): ?><th width="10%"><?php echo $this->lang->line('action'); ?></th><?php endif; ?>
            </tr>
        </thead>
        <tbody>
        	<?php if($assets_list):
        	foreach ($assets_list as $ke => $eqli):?>
        	<tr id="list_<?php echo $eqli->asen_asenid; ?>">
                <?php if($ismultiple=='N'): ?><td><input type="checkbox" name="equipid[]" value="<?php echo $eqli->asen_asenid; ?>" class="chkboxval" ></td><?php endif; ?>
        		<td><?php echo $eqli->asen_assetcode; ?></td>
        		<td><?php echo $eqli->eqca_category; ?></td>
        		<td><?php echo $eqli->itli_itemname; ?></td>
                <td><?php echo $eqli->asen_modelno; ?></td>
                <td><?php echo $eqli->asen_serialno; ?></td>
                <td><?php echo $eqli->asst_statusname; ?></td>
        		<td><?php echo $eqli->asco_conditionname; ?></td>
                 <?php if($ismultiple=='N'): ?>
                       <td class="text-center"><a href="javascript:void(0)" class="btn btn-success btn-sm btnAssign" data-assetsid="<?php echo $eqli->asen_asenid; ?>"  data-assetstypeid="<?php echo $eqli->eqca_equiptypeid; ?>" data-assetsdesid="<?php echo $eqli->itli_itemlistid; ?>">Assign</a></td>
                <?php endif; ?>
            </tr>
        <?php  endforeach;  endif;?>
        </tbody>
    </table>
</div>
    <?php 
    if($ismultiple=='N'):
        if(!empty($assets_list)):
     ?>
    <div class="pad-top-5">

        <table>
            <tr><td><button class="btn btn-sm btn-success btnMultipleAssign" data-departmentid='<?php echo !empty($assetsid)?$assetsid:''; ?>'>Multiple Assign</button></td></tr>
        </table>
    </div>
<?php endif; endif; ?>

</div>

<script type="text/javascript">
    // $('.dataTable').dataTable();
</script>