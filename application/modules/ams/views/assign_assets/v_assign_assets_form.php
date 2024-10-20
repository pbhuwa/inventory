<div class="row">
    <div class="form-group">
        <div class="col-md-4 col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('assets_type'); ?><span class="required">*</span>:</label>
            <?php $totem= (isset($this->data))?$this->data:'';?>
            <?php 
                $assettype=!empty($assets_data[0]->asen_assettype)?$assets_data[0]->asen_assettype:'';
            ?>
            <select class="form-control select2" name="asen_assettype" id="departwithequip">
                <option value="">---select---</option>
                <?php 
                    if (isset($material)):
                        foreach ($material as $kcl => $mat):
                ?>
                <option value="<?php echo $mat->eqca_equipmentcategoryid; ?>" <?php if($assettype==$mat->eqca_equipmentcategoryid) echo "selected=selected"; ?>>
                    <?php echo $mat->eqca_category; ?>
                </option>
                <?php
                        endforeach;
                    endif;
                ?>
                <?php    
                    $mat2=$this->general->get_tbl_data('*','eqca_equipmentcategory ec',false,false,false);
                    if($mat2):
                        foreach ($mat2 as $kcl => $mat):
                ?>
                <option value="<?php echo $mat->eqca_equipmentcategoryid; ?>" <?php if($totem==$mat->eqca_category) echo "selected=selected"; ?>> 
                    <?php echo $mat->eqca_category; ?>
                </option>
                <?php
                        endforeach;
                    endif;
                ?>
            </select>
        </div>

        <div class="col-md-2">
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="form-group" id="equipment_list">
</div>