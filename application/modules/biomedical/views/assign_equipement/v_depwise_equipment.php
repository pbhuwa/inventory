<div class="mtop_5">

<?php $ismultiple=!empty($is_multiple)?$is_multiple:'N'; ?>

<h3 class="box-title">Equipments List</h3>
<div class="">
    <table class="table table-border table-striped table-site-detail dataTable no-marg full_width">
        <thead>
            <tr>
    	        <?php if($ismultiple=='N'): ?>
                    <th width="5%" class="chkbox_align"><input type="checkbox" class="chkboxall" value="0"><span></span></th>
                <?php endif; ?>
                <th width="10%">Equip.Key</th>
                <th width="15%">Description</th>
                <th width="20%">Department</th>
                <th width="10%">Room</th>
                <th width="10%">Model No.</th>
                <th width="10%">Serial No.</th>
                <th width="20%">Distributor</th>
                <th width="10%">Manufa.</th> 
                <?php if($ismultiple=='N'): ?><th width="10%">Action</th><?php endif; ?>
            </tr>
        </thead>
        <tbody>
        	<?php if($equipment_list):
        	foreach ($equipment_list as $ke => $eqli):?>
        	<tr id="list_<?php echo $eqli->bmin_equipid; ?>">
                <?php if($ismultiple=='N'): ?><td><input type="checkbox" name="equipid[]" value="<?php echo $eqli->bmin_equipid; ?>" class="chkboxval" ></td><?php endif; ?>
        		<td><?php echo $eqli->bmin_equipmentkey; ?></td>
        		<td><?php echo $eqli->eqli_description; ?></td>
        		<td><?php echo $eqli->dein_department; ?></td>
        		<td><?php echo $eqli->rode_roomname; ?></td>
                <td><?php echo $eqli->bmin_modelno; ?></td>
                <td><?php echo $eqli->bmin_serialno; ?></td>
                <td><?php echo $eqli->dist_distributor; ?></td>
        		<td><?php echo $eqli->manu_manlst; ?></td>
                 <?php if($ismultiple=='N'): ?>
                       <td class="text-center"><a href="javascript:void(0)" class="btn btn-success btn-sm btnAssign" data-equipid="<?php echo $eqli->bmin_equipid; ?>"  data-departmentid="<?php echo $eqli->bmin_departmentid; ?>" data-roomid="<?php echo $eqli->bmin_roomid; ?>">Assign</a></td>
                <?php endif; ?>
            </tr>
        <?php  endforeach;  endif;?>
        </tbody>
    </table>
</div>
    <?php 
    if($ismultiple=='N'):
        if(!empty($equipment_list)):
     ?>
    <div class="pad-top-5">

        <table>
            <tr><td><button class="btn btn-sm btn-success btnMultipleAssign" data-departmentid='<?php echo !empty($depid)?$depid:''; ?>'>Multiple Assign</button></td></tr>
        </table>
    </div>
<?php endif; endif; ?>

</div>

<script type="text/javascript">
    // $('.dataTable').dataTable();
</script>