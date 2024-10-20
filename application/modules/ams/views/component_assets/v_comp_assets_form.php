 <form id="FormAssets" class="form-material" method="post" id="btnDeptment" action="<?php echo base_url('ams/assets/save_component_assets'); ?>" data-reloadurl='<?php echo base_url('ams/assets/component_assets_entry/reload'); ?>'>
    <div class="white-box pad-5 assets-title" style="border-color:silver">
        <h4><?php echo $this->lang->line('assets_information'); ?></h4>

      
            <input type="hidden" name="id" value="<?php echo !empty($assets_data[0]->asen_asenid)?$assets_data[0]->asen_asenid:''; ?>" />
            <?php 
             $dis_field='';
            /*if(!empty($assets_data)): 
                $dis_field='disabled=disabled';
              else:
                $dis_field='';
              endif;
              */
              ?>
            <div class="row">
                 <div class="col-md-3">
                
                        <label>Network Components<span class="required">*</span>:</label>
                        <?php 
                        $last_sel_comp_typeid=!empty($last_component_typeid)?$last_component_typeid:'';
                            $comopnenttypeid=!empty($assets_data[0]->asen_component_typeid)?$assets_data[0]->asen_component_typeid:$last_sel_comp_typeid;
                        ?>
                            <select class="form-control required_field " name="asen_component_typeid" id="component_typeid" <?php echo $dis_field ?>>
                                <option value="">---select---</option>
                                <?php 
                                    if($network_component_list):
                                        foreach ($network_component_list as $kcl => $nc):
                                ?>
                                <option value="<?php echo $nc->coty_id; ?>" <?php if($comopnenttypeid==$nc->coty_id) echo "selected=selected"; ?>> <?php echo $nc->coty_name; ?></option>

                        <?php
                                    endforeach;
                                endif;
                        ?>
                            </select>
                   
                
                
            </div>
             <div class="col-md-3">
                     <?php 
                      $last_sel_assettypeid=!empty($last_assettypeid)?$last_assettypeid:'';

                        $assettypeid=!empty($assets_data[0]->asen_assettypeid)?$assets_data[0]->asen_assettypeid:$last_sel_assettypeid;
                        ?>
                     <label>Assets Type<span class="required">*</span>:</label>
                     <select class="form-control required_field" name="asen_assettypeid"<?php echo $dis_field ?> >
                         <option value="">---select---</option>
                         <?php 
                                    if($assettype_list):
                                        foreach ($assettype_list as $ka => $al):
                                ?>
                                <option value="<?php echo $al->asty_astyid; ?>" <?php if($assettypeid==$al->asty_astyid) echo "selected=selected"; ?>> <?php echo $al->asty_typename; ?></option>

                        <?php
                                    endforeach;
                                endif;
                        ?>
                     </select>
                 </div> 

                   <?php 
                      $last_sel_locationid=!empty($last_locationid)?$last_locationid:'';
                       
                       $sel_location=!empty($assets_data[0]->asen_locationid)?$assets_data[0]->asen_locationid:$last_sel_assettypeid;
                       // echo $sel_location;
                       // die();

                   echo $this->general->location_option(3,'asen_locationid','locationid',$sel_location); ?>
             </div>
              <div id="comtype">
                  
              </div>

              <div class="row" id="saveDiv" style="display: none">
                   <div class="col-md-12">
                     <button type="submit" class="btn btn-info  save" id="btnSubmitEntry" data-operation='save' ><?php echo !empty($assets_data)?'Update & New':'Save & New'; ?></button>
             <button type="submit" class="btn btn-info  save"  id="btnSubmitEntryContinue" data-operation='continue' data-isactive='Y'><?php echo !empty($assets_data)?'Update & Continue':'Save & Continue'; ?></button>
                    </div>
                <div class="alert-success success"></div>
                <div class="alert-danger error"></div>
              </div>
</div>
</form>


<script type="text/javascript">

  $('#locationid').addClass('required_field');

    $(document).off('change','#component_typeid');
    $(document).on('change','#component_typeid',function(e){
    var ctype=$(this).val();
    var branchid=$('#locationid').val();
    var action=base_url+'ams/assets/get_assets_component_from';
    // alert(depid);
    if(ctype!=''){
      $('#saveDiv').show();
    }else{
      $('#saveDiv').hide();
    }
    $('.error').html('');
    $.ajax({
        type: "POST",
        url: action,
        data:{ctype:ctype,branchid:branchid},
        dataType: 'json',
        success: function(response) {
            if(response.status == 'success'){
                $('#saveDiv').show();
                $('#comtype').html(response.template);
            }else{
                 $('#saveDiv').hide();
                $('#comtype').html('');
                $('.error').html(response.message);
            }
           
        }
    });

    });
    $(document).off('change','#locationid');
    $(document).on('change','#locationid',function(e){
        $('#component_typeid').change();
    });
</script>
<?php if(!empty($comopnenttypeid)): ?>
<script type="text/javascript">
    $('#component_typeid').change();
</script>
<?php endif; ?>

