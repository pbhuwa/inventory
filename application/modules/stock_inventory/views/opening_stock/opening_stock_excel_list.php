<style>
.purs_table tbody tr td{
border: none;
vertical-align: center;
}
</style>
<form method="post" id="FormOpeningStock" action="<?php echo base_url('stock_inventory/opening_stock/save_opening_stock_excel'); ?>" data-reloadurl="<?php echo base_url('stock_inventory/opening_stock/excel_import/reload');?>" class="form-material form-horizontal form" >
    <input type="hidden" name="id" value="<?php echo !empty($opening_data->trde_trdeid)?$opening_data->trde_trdeid:'';?>">
    <div class="stockData"></div>
    <div class="form-group">
              <?php echo $this->general->location_option(2,'locationid'); ?>

        <div class="col-md-3 col-sm-4">
            <label><?php echo $this->lang->line('store'); ?><span class="required">*</span>:</label>
            <?php $depid=!empty($opening_data->storeid)?$opening_data->storeid:''; ?>
            <select class="form-control storeChange" name="storeid" autofocus="true" id="storeId">
                <?php
                if($equipmnt_type):
                foreach ($equipmnt_type as $ket => $etype):
                ?>
                <option value="<?php echo $etype->eqty_equipmenttypeid; ?>"  <?php if($depid==$etype->eqty_equipmenttypeid) echo "selected=selected"; ?> ><?php echo $etype->eqty_equipmenttype; ?></option>
                <?php endforeach; endif; ?>
            </select>
        </div>
        <div class="col-md-3 col-sm-4">
            <label><?php echo $this->lang->line('opening_stock_of_the_year'); ?></label>
            <?php $fyear=!empty($opening_data->trma_fyear)?$opening_data->trma_fyear:'I';
             ?>
            <select class="form-control storeChange" name="opstockyr"  id="fiscalYear">
                <?php
                if($fiscal_year):
                foreach ($fiscal_year as $kf => $fyrs):
                ?>
                <option value="<?php echo $fyrs->fiye_name; ?>" <?php
                    if($fyear == 'I'){
                        if($fyrs->fiye_status==$fyear)
                        echo "selected=selected";
                    }else{ 
                        if($fyrs->fiye_name==$fyear)
                            { echo "selected=selected" ;
                        }
                    } ; ?>><?php echo $fyrs->fiye_name; ?></option>
                <?php endforeach; endif; ?>
            </select>
        </div>
      <div class="col-md-3"> 
            
            <label for="example-text"><?php echo $this->lang->line('material_type'); ?> <span class="required">*</span>:</label>
            <div class="dis_tab">
                <select name="materialtypeid" id="materialtypeid" class="form-control required_field " >
                          <option value="">---select---</option>
                          <?php
                          if($material_type):
                            foreach ($material_type as $km => $mat):
                              ?> 
                          <option value="<?php echo $mat->maty_materialtypeid; ?>" ><?php echo $mat->maty_material; ?></option>
                              <?php 
                            endforeach;
                          endif;
                           ?>
                </select>
            </div>
        </div>


    </div>
    <div class="form-group">
         <div class="col-md-3 col-sm-4">
            <label>Excel File(.xls)</label>
            <input type="file" name="exceldata">
         </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($opening_data)?'update':'save' ?>' id="btnSubmit" >Upload</button>
        </div>
        <div class="col-sm-12">
            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
        </div>
    </div>
    <div class="clearfix"></div>
</form>



