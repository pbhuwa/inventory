<?php //echo"<pre>"; print_r($department);print_r($store_type);die; 
if($type == "transfer"){  
?>
<div class="col-md-2 col-sm-4 col-xs-12">
    <label for="example-text"> Select Store :<span class="required">*</span>:</label>
    <select name="store_id" class="form-control select2" id="storeid">
        <option value="">---All---</option>
        <?php
        if($store_type):
        foreach ($store_type as $km => $st):
        ?>
        <option value="<?php echo $st->eqty_equipmenttypeid; ?>"><?php echo $st->eqty_equipmenttype; ?></option>
        <?php
        endforeach;
        endif;
        ?>
    </select>
</div>
<?php } if($type == "issue"){ ?>
<div class="col-md-2 col-sm-4 col-xs-12">
    <label for="example-text"> Select Department :<span class="required">*</span>:</label>
    <select name="depid" class="form-control select2" id="depid">
        <option value="">---All---</option>
        <?php
        if($department):
        foreach ($department as $km => $dt):
        ?>
        <option value="<?php echo $dt->dept_depid; ?>"><?php echo $dt->dept_depname; ?></option>
        <?php
        endforeach;
        endif;
        ?>
    </select>
</div>
<?php } ?>