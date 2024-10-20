<form method="post" id="FormBudgets" action="<?php echo base_url('stock_inventory/budgets/save_budgets'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('stock_inventory/budgets/form_budgets'); ?>'>

    <input type="hidden" name="id" value="<?php echo!empty($budgets_data[0]->budg_budgetid)?$budgets_data[0]->budg_budgetid:'';  ?>">

    <div class="form-group">

        <div class="col-md-6">
         <label for="example-text"><?php echo $this->lang->line('budgets_code'); ?> <span class="required">*</span> :
            </label>
               <input type="text"  name="budg_code" class="form-control" placeholder="Budgets Code" value="<?php echo !empty($budgets_data[0]->budg_code)?$budgets_data[0]->budg_code:''; ?>" autofocus="true">
        </div>
          <div class="col-md-6">
         <label for="example-text"><?php echo $this->lang->line('budgets_name'); ?> <span class="required">*</span> :
            </label>
               <input type="text"  name="budg_budgetname" class="form-control" placeholder="Budgets Name" value="<?php echo !empty($budgets_data[0]->budg_budgetname)?$budgets_data[0]->budg_budgetname:''; ?>" autofocus="true">
        </div>
        <div class="col-md-6">
            <label for="example-text">Material Type : </label><br>
            <?php
            $rema_mattype = !empty($budgets_data[0]->budg_materialtypeid) ? $budgets_data[0]->budg_materialtypeid : 1;
            ?>

            
        <select name="budg_materialtypeid" id="mattypeid" class="form-control chooseMatType required_field">
                <?php
                if (!empty($material_type)) :
                    foreach ($material_type as $mat) :
                ?>
                        <option value="<?php echo $mat->maty_materialtypeid; ?>" <?php if ($rema_mattype == $mat->maty_materialtypeid) echo "selected=selected"; ?>> <?php echo $mat->maty_material; ?></option>
                <?php
                    endforeach;
                endif;
                ?>
            </select>
        </div>


         <div class="col-md-6">
             <?php $isactive=!empty($budgets_data[0]->budg_isactive)?$budgets_data[0]->budg_isactive:''; ?>
            <label>Is Active:</label>
            <select name="budg_isactive" class="form-control">
                <option value="Y" >Yes</option>
                <option value="N" <?php if($isactive=='N') echo "selected=selected"; ?>>No</option>
            </select>
        </div>
    </div>

        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>

    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($budgets_data)?'update':'save' ?>'><?php echo !empty($budgets_data)?$update_var:$save_var; ?></button>

      

       <div  class="alert-success success"></div>

        <div class="alert-danger error"></div>

</form>