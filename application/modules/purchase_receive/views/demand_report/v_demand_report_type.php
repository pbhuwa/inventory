<div class="searchWrapper">
    <div class="col-md-3">
        <form>
            <label><?php echo $this->lang->line('store'); ?></label>
            <select class="form-control searchByStore" id="searchByStore" data-searchtype="store">
                <option value="">---Select---</option>
                <?php
                    if(!empty($store_type)):
                        foreach($store_type as $store):
                ?>
                    <option value = "<?php echo $store->eqty_equipmenttypeid;?>">
                        <?php echo $store->eqty_equipmenttype;?>
                    </option>
                <?php    
                        endforeach; 
                    endif;
                ?>
            </select>
        </form>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel" id="excel"><i class="fa fa-file-excel-o"></i></a>
        <a class="btn btn-info btn_pdf" id="print" target="_blank"><i class="fa fa-print"></i></a>
    </div>

    <div class="clear"></div>

    <!-- <div class="">
        <div class="col-md-3">
            <input type="radio" name="orderlevel" id="below_reorder"> Below re-order level
        </div>
        <div class="col-md-3">
            <input type="radio" name="orderlevel" id="above_maxlimit"> Above max limit
        </div>
    </div> -->
    <div class="clear"></div>
</div>