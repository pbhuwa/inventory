<style type="text/css">
    .file {
        position: relative;
        margin-top: 25px;
    }
   
    .file label {
        background: #00653c;
        padding: 15px 20px;
        color: #fff;
        font-weight: 600;
        font-size: .9em;
        transition: all .4s;
        text-transform: capitalize;
    }
    .file input {
        position: absolute;
        display: inline-block;
        left: 0;
        top: 0;
        opacity: 0.01;
        cursor: pointer;
    }
    
    .file input:hover + label,
    
    .file input:focus + label {
        background: #34495E;
        color: #fff;
    }
    
    .assets-title h4{
        border-bottom: 1px solid #e2e2e2;
        padding-bottom: 5px;
        margin-bottom: 10px;
        padding-top: 5px;
        text-transform: capitalize;
        font-weight: 500;
        font-size: 16px;
    }
    
    .submit-btn{
        margin-top: 19px;
    }
    .assets-title + .assets-title{
        margin-top: 20px;
    }
</style>

<div class="assest-form">
     <form class="form-material" method="post" id="btnDeptment" action="<?php echo base_url('ams/assets/save_assets'); ?>" data-reloadurl='<?php echo base_url('ams/assets/form_assets'); ?>'>
    <div class="white-box pad-5 assets-title" style="border-color:silver">
        <h4><?php echo $this->lang->line('assets_information'); ?></h4>

      
            <input type="hidden" name="id" value="<?php echo!empty($assets_data[0]->asen_asenid)?$assets_data[0]->asen_asenid:''; ?>" />

            <div class="row">
                <div class="col-md-4">
                   <div class="form-group">
                        <label><?php echo $this->lang->line('assets_code'); ?><span class="required">*</span>: </label>
                        <?php
                            if(AUTO_ASSET_CODE == '0'){
                                $readonly = "";
                            }else{
                                $readonly = 'readonly';
                            }
                        ?>
                        <input type="text" name="asen_assetcode"  class="form-control" id="asen_assetcode" placeholder="<?php echo $this->lang->line('assets_code'); ?>" value="<?php echo !empty($assets_data[0]->asen_assetcode)?$assets_data[0]->asen_assetcode:''; ?>" <?php echo $readonly; ?>>
                    </div>
                </div>

                <div class="col-md-4">
                   <div class="form-group">
                        <label><?php echo $this->lang->line('assets_type'); ?><span class="required">*</span>:</label>
                        <?php 
                            $assettype=!empty($assets_data[0]->asen_assettype)?$assets_data[0]->asen_assettype:'';
                        ?>
                            <select class="form-control changedropdown" name="asen_assettype" id="assettypeid" data-targetdd="assets_desc" data-url='<?php echo base_url('ams/assets/get_assets_details');?>'>
                                <option value="">---select---</option>
                                <?php 
                                    if($material):
                                        foreach ($material as $kcl => $mat):
                                ?>
                                <option value="<?php echo $mat->eqca_equipmentcategoryid; ?>" <?php if($assettype==$mat->eqca_equipmentcategoryid) echo "selected=selected"; ?>> <?php echo $mat->eqca_category; ?></option>

                        <?php
                                    endforeach;
                                endif;
                        ?>
                            </select>
                    </div>
                </div>
               
                <div class="col-md-4">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('assets_description'); ?><span class="required">*</span>: </label>
                        <select name="asen_description" class="form-control select2" id="assets_desc">
                            <option value="">---select---</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('manufacture'); ?></label>
                        <?php 
                            $db_asen_manufacture=!empty($assets_data[0]->asen_manufacture)?$assets_data[0]->asen_manufacture:'';
                        ?>
                        <select class="form-control" name="asen_manufacture">
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
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('distributor'); ?></label>
                        <?php 
                            $db_asen_distributor=!empty($assets_data[0]->asen_distributor)?$assets_data[0]->asen_distributor:'';
                        ?>
                        <select class="form-control" name="asen_distributor">
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
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('brand'); ?>:</label>
                        <input type="text" name="asen_brand" class="form-control" placeholder="<?php echo $this->lang->line('brand'); ?>" value="<?php echo !empty($assets_data[0]->asen_brand)?$assets_data[0]->asen_brand:''; ?>">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('model_no'); ?>:</label>
                        <input type="text" name="asen_modelno" class="form-control" placeholder="<?php echo $this->lang->line('model_no'); ?>" value="<?php echo !empty($assets_data[0]->asen_modelno)?$assets_data[0]->asen_modelno:''; ?>">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('serial_no'); ?>:</label>
                        <input type="text" name="asen_serialno" class="form-control" placeholder="<?php echo $this->lang->line('serial_no'); ?>" value="<?php echo !empty($assets_data[0]->asen_serialno)?$assets_data[0]->asen_serialno:''; ?>">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('status'); ?> <span class="required">*</span>:</label>
                        <?php 
                            $db_asen_status=!empty($assets_data[0]->asen_status)?$assets_data[0]->asen_status:'';
                        ?>
                        <select class="form-control" name="asen_status">
                            <option value="">---select---</option>
                            <?php 
                                if($status):
                                    foreach ($status as $kcl => $stat):
                            ?>
                            <option value="<?php echo $stat->asst_asstid; ?>" <?php if($db_asen_status==$stat->asst_asstid) echo "selected=selected"; ?>> <?php echo $stat->asst_statusname; ?></option>
                            <?php
                                    endforeach;
                                endif;
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('condition'); ?> <span class="required">*</span>:</label>
                        <?php 
                            $db_asen_condition=!empty($assets_data[0]->asen_condition)?$assets_data[0]->asen_condition:'';
                        ?>
                        <select class="form-control" name="asen_condition">
                            <option value="">---select---</option>
                            <?php 
                                if($condition):
                                    foreach ($condition as $kcl => $cond):
                            ?>
                            <option value="<?php echo $cond->asco_ascoid; ?>" <?php if($db_asen_condition==$cond->asco_ascoid) echo "selected=selected"; ?>> <?php echo $cond->asco_conditionname; ?></option>
                            <?php
                                    endforeach;
                                endif;
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('note'); ?></label>
                        <textarea class="form-control" name="asen_notes" value=""><?php echo !empty($assets_data[0]->asen_notes)?$assets_data[0]->asen_notes:''; ?></textarea>
                    </div>
                </div>

                <?php
                    if(!empty($assets_data)):
                ?>
                <div class="col-md-12" style="margin-top: 10px;">
                    <label>Barcode:</label><br/>
                    <a href="javascript:void(0)" class="btnBarcode" data-id="<?php echo !empty($assets_data[0]->asen_asenid)?$assets_data[0]->asen_asenid:''; ?>" title="Barcode" ><i class="fa fa-barcode" aria-hidden="true" style="visibility: hidden;"></i></a>
                    <div class="showBarcode" style="float: left;"></div>
                </div>
                <?php
                    endif;
                ?>
            </div>

 
     </div>

            <!-- End Asset Entry -->
    <div class="white-box pad-5 assets-title" style="border-color:silver">
         
                <h4><?php echo $this->lang->line('finance'); ?></h4>
                <div class="row">
                   <!--  <div class="col-md-4">
                        <div class="form-group">
                            <label>Vendor:</label>
                            <input type="text" name="asen_vendor" class="form-control" placeholder="" value="<?php echo !empty($assets_data[0]->asen_vendor)?$assets_data[0]->asen_vendor:''; ?>">
                        </div>
                    </div> -->

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('purchase_rate'); ?> <span class="required">*</span>:</label>
                            <input type="text" name="asen_purchaserate" id="asen_purchaserate" class="form-control float" placeholder="<?php echo $this->lang->line('purchase_rate'); ?>" value="<?php echo !empty($assets_data[0]->asen_purchaserate)?$assets_data[0]->asen_purchaserate:''; ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('market_value'); ?><span class="required">*</span>:</label>
                            <input type="text" name="asen_marketvalue" class="form-control float" placeholder="<?php echo $this->lang->line('market_value'); ?>" value="<?php echo !empty($assets_data[0]->asen_marketvalue)?$assets_data[0]->asen_marketvalue:''; ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('scrap_value'); ?><span class="required">*</span>: </label>
                            <input type="text" name="asen_scrapvalue" id="asen_scrapvalue" class="form-control float" placeholder="<?php echo $this->lang->line('scrap_value'); ?>" value="<?php echo !empty($assets_data[0]->asen_scrapvalue)?$assets_data[0]->asen_scrapvalue:''; ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('purchase_date'); ?><span class="required">*</span>:</label>
                            <?php
                                if(DEFAULT_DATEPICKER == 'NP'){
                                    $purchase_date = !empty($assets_data[0]->asen_purchasedatebs)?$assets_data[0]->asen_purchasedatebs:DISPLAY_DATE;
                                }else{
                                    $purchase_date = !empty($assets_data[0]->asen_purchasedatead)?$assets_data[0]->asen_purchasedatead:DISPLAY_DATE;
                                }
                            ?>
                            <input type="text" name="asen_purchasedate" id="asen_purchasedate" class="form-control <?php echo DATEPICKER_CLASS;?> date" placeholder="<?php echo $this->lang->line('purchase_date'); ?>" value="<?php echo $purchase_date; ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('service'); ?>:</label>
                            <input type="text" name="asen_inservicedate" class="form-control <?php echo DATEPICKER_CLASS;?> date" placeholder="<?php echo $this->lang->line('service'); ?>" id="asen_inservicedate" value="<?php echo !empty($assets_data[0]->asen_inservicedate)?$assets_data[0]->asen_inservicedate:DISPLAY_DATE; ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('warrenty_end'); ?>:</label>
                            <input type="text" name="asen_warrentydate" class="form-control <?php echo DATEPICKER_CLASS;?> date" placeholder="<?php echo $this->lang->line('warrenty_end'); ?>" id="asen_warrentydate" value="<?php echo !empty($assets_data[0]->asen_warrentydate)?$assets_data[0]->asen_warrentydate:DISPLAY_DATE; ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('expected_assets_life'); ?><span class="required">*</span>:</label>
                            <input type="text" name="asen_expectedlife" id="asen_expectedlife" class="form-control" placeholder="<?php echo $this->lang->line('expected_assets_life'); ?>" value="<?php echo !empty($assets_data[0]->asen_expectedlife)?$assets_data[0]->asen_expectedlife:''; ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('recovery_period'); ?>(Y) <span class="required">*</span>:</label>
                            <input type="text" name="asen_recoveryperiod" id="asen_recoveryperiod" class="form-control" placeholder="<?php echo $this->lang->line('recovery_period'); ?>" value="<?php echo !empty($assets_data[0]->asen_recoveryperiod)?$assets_data[0]->asen_recoveryperiod:''; ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('depreciation_method'); ?>:</label>
                            <?php 
                                $db_asen_depreciation=!empty($assets_data[0]->asen_depreciation)?$assets_data[0]->asen_depreciation:'';
                            ?>
                            <select class="form-control" id="dep_type" name="asen_depreciation">
                                <option value="0">---select---</option>
                                <?php 
                                    if($depreciation):
                                        foreach ($depreciation as $kcl => $dep):
                                ?>
                                <option value="<?php echo $dep->dety_depreciationid; ?>" <?php if($db_asen_depreciation==$dep->dety_depreciationid) echo "selected=selected"; ?>> <?php echo $dep->dety_depreciation; ?></option>
                                <?php
                                        endforeach;
                                    endif;
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4" id="dep_formula">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('depreciation_formula'); ?></label>
                            <input type="text" name="" readonly="true" class="form-control" placeholder="<?php echo $this->lang->line('depreciation_formula'); ?>">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div id="unit_of_dep_fields" class="row"></div>
                    </div>

                    <div class="col-md-12">
                        <?php 
                            $assetsid=!empty($assets_data[0]->asen_asenid)?$assets_data[0]->asen_asenid:'';
                            if($assetsid){
                        ?>
                            <button type="submit" class="btn btn-info save" data-operation="save" id="btnDeptment"><?php echo $this->lang->line('update'); ?></button>
                        <?php } else { 
                        ?>
                            <button type="submit" class="btn btn-info save" data-operation="save" id="btnDeptment"><?php echo $this->lang->line('save'); ?></button>
                        <?php }?>
                    </div>
                </div>
                
            

            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
       
    </div>
     </form>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#dep_formula').hide();

        $('.changedropdown').change();
    
        var descid = '<?php echo $assettype=!empty($assets_data[0]->asen_description)?$assets_data[0]->asen_description:'';?>';

        console.log(descid);

        if(descid){
            setTimeout(function(){
                $("#assets_desc").val(descid).trigger('change');
            },1000);
        }
    });

    $(document).on('change','#dep_type',function(){
        var datetype=$(this).val();
         //alert(datetype);
         
        // if(datetype){
        //     $('#dep_formula').show();
        // }else
        // {
        //    $('#dep_formula').hide();
        // }
    });
</script>

<script type="text/javascript">
    $('.engdatepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });
    $('.nepdatepicker').nepaliDatePicker();
</script>

<script type="text/javascript">
    $(document).off('change','#assettypeid');
    $(document).on('change','#assettypeid',function(){
        var eqtypeid=$(this).val();
        var action=base_url+'ams/assets/get_assets_description';
        // alert(depid);
        $.ajax({
            type: "POST",
            url: action,
            data:{eqtypeid:eqtypeid},
            dataType: 'json',
            success: function(response) {
                if(response.status == 'success'){
                    var datas = response.data;
                    var opteq='';
                    opteq='<option value="">---select---</option>';
                    $.each(datas,function(i,k)
                    {
                      opteq += '<option value='+k.itli_itemlistid+'>'+k.itli_itemcode+'  |  '+k.itli_itemname+ '</option>';
                    });
                   
                }else{
                    opteq='<option value="">---select---</option>';
                }
                $('#assets_desc').html(opteq);
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).off('change','#assets_desc');
    $(document).on('change','#assets_desc',function(){
        var asset_desc_id = $('#assets_desc').val();
        var asset_desc_name = $('#assets_desc').find('option:selected').text();

        // alert(asset_desc_id);
        var submitUrl = base_url+'ams/assets/get_asset_code';
        var submitData = {asset_desc_id:asset_desc_id, asset_desc_name:asset_desc_name};
        beforeSend= $('.overlay').modal('show');
        ajaxPostSubmit(submitUrl, submitData,beforeSend='',onSuccess);
        function onSuccess(response){
            data = jQuery.parseJSON(response);

            if(data.status == 'success'){
                new_asset_code = data.asset_code;
                $('#asen_assetcode').val(new_asset_code);
            }
            $('.overlay').modal('hide');
        }
    });
</script>

<script>
    $(document).off('change','#dep_type');
    $(document).on('change','#dep_type',function(){
        var deptype = $('#dep_type').val();
        var purchase_rate = $('#asen_purchaserate').val();
        var purchase_date = $('#asen_purchasedate').val();
        var recovery_period = $('#asen_recoveryperiod').val();
        var scrap_value = $('#asen_scrapvalue').val();

        if(deptype == 3){
            $('#unit_of_dep_fields').empty();

            var input_field = '<div class="col-sm-4"><label for="">Unit of Productions :</label><input type="text" name=unit[] class="form-control" /></div>';

            for(i=1;i<=recovery_period;i++)
            {
                $('#unit_of_dep_fields').append(input_field);
            }

            return false;
        }else{
            $('#unit_of_dep_fields').empty();
        }

        if(deptype != 5){
            if(purchase_rate == '' || purchase_date == '' || recovery_period == ''){
                alert('Please enter all the required fields');
                return false;
            }
        }
       

        var submitUrl = '';
        // alert(deptype);
        if (deptype==1){
            submitUrl = base_url+'ams/assets/get_st_line_depr';
        }else if (deptype==2){
            submitUrl = base_url+'ams/assets/ddb_dep_calc';
        }else if (deptype==3){
            submitUrl = base_url+'ams/assets/up_dep_calc';
        }else if (deptype==4){
            submitUrl = base_url+'ams/assets/soy_dep_calc';
        }else if (deptype == 5){
            submitUrl = base_url+'ams/assets/get_ddm_depr';
        }else{
            return false;
        }

        var submitData = { deptype:deptype, purchase_rate:purchase_rate, purchase_date:purchase_date, recovery_period:recovery_period, scrap_value:scrap_value };

        beforeSend= $('.overlay').modal('show');
        ajaxPostSubmit(submitUrl, submitData,beforeSend='',onSuccess);

        function onSuccess(response){
            data = jQuery.parseJSON(response);   

            if(data.status=='success'){
                $('#displayReportDiv').html(data.template);
                $('#displayReportDiv').show();
            }else{
                $('#displayReportDiv').html('<span class="col-sm-6 alert alert-danger text-center">'+data.message+'</span>');
                $('#displayReportDiv').show();
                // alert(data.message);
            }
            $('.overlay').modal('hide');
        }
    });
</script>

<?php
    if(!empty($assets_data)):
?>
    <script type="text/javascript">
        setTimeout(function(){
            $('.btnBarcode').click();

            var deptype = $('#dep_type').val();

            if(deptype != '0'){
               $('#dep_type').change(); 
            }
            
        },500);
    </script>
<?php
    endif;
?>