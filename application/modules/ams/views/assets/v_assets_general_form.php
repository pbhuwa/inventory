 <div class="assest-form">
     <form id="FormgeneralAssets" class="form-material" method="post"  action="<?php echo base_url('ams/assets/save_general_assets'); ?>" data-reloadurl='<?php echo base_url('ams/assets/assets_entry/reload'); ?>' >
    <div class="white-box pad-5 assets-title" style="border-color:silver">
        <h4>General Information</h4>
            <input type="hidden" name="id" value="<?php echo !empty($assets_data[0]->asen_asenid)?$assets_data[0]->asen_asenid:''; ?>" />

            <div class="row">
                    <?php 
                    $sel_locationid=!empty($assets_data[0]->asen_locationid)?$assets_data[0]->asen_locationid:'';

                    echo $this->general->location_option(3,'asen_locationid','asen_locationid',$sel_locationid); ?>
                  <div class="col-md-3">
                  <?php 
                            $db_asen_depid=!empty($assets_data[0]->asen_depid)?$assets_data[0]->asen_depid:'';
                        ?>

                        <label>Department<span class="required">*</span>: </label>
                        <select name="asen_depid" class="form-control select2 required_field">
                            <option value="">---select---</option>
                           
                            <?php 
                                if($department_list):
                                    foreach ($department_list as $kdl => $dlist):
                            ?>
                            <option value="<?php echo $dlist->dept_depid; ?>" <?php if($db_asen_depid==$dlist->dept_depid) echo "selected=selected"; ?>> <?php echo $dlist->dept_depname; ?></option>
                            <?php
                                    endforeach;
                                endif;
                            ?>
                        </select>
                    </div>

                     <div class="col-md-3">
                  
                        <label>Room<span class="required"></span>: </label>
                         <input type="text" name="asen_room" class="form-control" value="<?php echo !empty($assets_data[0]->asen_room)?$assets_data[0]->asen_room:''; ?>">
                        
                    </div>

                 <div class="col-md-3">
                   
                        <label><?php echo $this->lang->line('manufacture'); ?></label>
                        <?php 
                            $db_asen_manufacture=!empty($assets_data[0]->asen_manufacture)?$assets_data[0]->asen_manufacture:'';
                        ?>
                        <select class="form-control select2" name="asen_manufacture">
                            <option value="">---select---</option>
                            <?php 
                                if($manufacturers):
                                    foreach ($manufacturers as $kcl => $manu):
                            ?>
                            <option value="<?php echo $manu->manu_manlistid; ?>" <?php if($db_asen_manufacture==$manu->manu_manlistid) echo "selected=selected"; ?>> <?php echo $manu->manu_manlst; ?></option>
                            <?php
                                    endforeach;
                                endif;
                            ?>
                        </select>
                  
                </div>
                <div class="col-md-3">
                     <?php
                        if(DEFAULT_DATEPICKER == 'NP'){
                            $manufacture_date = !empty($assets_data[0]->asen_manufacture_datebs)?$assets_data[0]->asen_manufacture_datebs:DISPLAY_DATE;
                        }else{
                            $manufacture_date = !empty($assets_data[0]->asen_manufacture_datead)?$assets_data[0]->asen_manufacture_datead:DISPLAY_DATE;
                        }
                    ?>
                       

                    <label>Date of manufacture</label>
                    <input type="text" name="asen_manufacture_date" class="form-control <?php echo DATEPICKER_CLASS;?> date" value="<?php echo $manufacture_date;?>">
                </div>

                <div class="col-md-3">
                   
                        <label><?php echo $this->lang->line('supplier'); ?></label>
                        <?php 
                            $db_asen_distributor=!empty($assets_data[0]->asen_distributor)?$assets_data[0]->asen_distributor:'';
                        ?>
                        <select class="form-control select2" name="asen_distributor">
                            <option value="">---select---</option>
                            <?php 
                                if($distributors):
                                    foreach ($distributors as $kcl => $dist):
                            ?>
                            <option value="<?php echo $dist->dist_distributorid; ?>" <?php if($db_asen_distributor==$dist->dist_distributorid) echo "selected=selected"; ?>> <?php echo $dist->dist_distributor; ?></option>
                            <?php

                                    endforeach;
                                endif;
                            ?>
                        </select>
                    
                </div>

                <div class="col-md-12">
                   
                        <label><?php echo $this->lang->line('remarks'); ?></label>
                        <textarea class="form-control" name="asen_generalremarks" ><?php echo !empty($assets_data[0]->asen_generalremarks)?$assets_data[0]->asen_generalremarks:''; ?></textarea>
                    
                </div>
                <div class="col-md-12">
                    
                        <button type="submit" class="btn btn-info  save"  id="btnSubmitGeneralContinue" data-operation='continue' data-isactive='Y'><?php echo !empty($assets_data)?'Update & Continue':'Save & Continue'; ?></button>
                    </div>

               
            
            </div>

 
     </div>
 </form>
</div>

<script type="text/javascript">
    $('#locationid').addClass('required_field');
</script>