 <div class="assest-form">

     <form id="FormAssets" class="form-material" method="post"  action="<?php echo base_url('ams/assets/save_assets'); ?>" data-reloadurl='<?php echo base_url('ams/assets/assets_entry/reload'); ?>'>

    <div class="white-box pad-5 assets-title" style="border-color:silver">

        <h4>Basic Information</h4>

            <input type="hidden" name="id" value="<?php echo !empty($assets_data[0]->asen_asenid)?$assets_data[0]->asen_asenid:''; ?>" />



            <div class="row">

                 <div class="col-md-3">

                

                        <label>Asset Category<span class="required">*</span>:</label>

                        <?php 

                            $assettype=!empty($assets_data[0]->asen_assettype)?$assets_data[0]->asen_assettype:'';

                        ?>
                        <?php 
                        if(!empty($assettype)): 
                            $ass_id="assettypeid";
                            ?>

                        <?php else: $ass_id="assettypeid"; endif; ?>
                            <select class="form-control changedropdown required_field " name="asen_assettype" id="<?php echo $ass_id; ?>" data-targetdd="assets_desc" data-url='<?php echo base_url('ams/assets/get_assets_details');?>'>

                                <option value="">---select---</option>

                                <?php 

                                    if($material):

                                        foreach ($material as $kcl => $mat):

                                ?>

                                <option value="<?php echo $mat->eqca_equipmentcategoryid; ?>" 

                                    <?php if($assettype==$mat->eqca_equipmentcategoryid) echo "selected=selected"; ?>>

                                     <?php echo $mat->eqca_category; ?>

                                    

                                </option>



                        <?php

                                    endforeach;

                                endif;

                        ?>

                            </select>

                   

                </div>

                  <div class="col-md-3">

                        <?php $sel_assets_description=!empty($assets_data[0]->asen_description)?$assets_data[0]->asen_description:''; 

                        // echo $sel_assets_description;

                        // die();

                        ?>

                        <label>Parent Assets<span class="required"></span>: </label>

                        <select name="asen_description" class="form-control select2 " id="assets_desc">

                            <option value="">---select---</option>

                            <?php 

                            if(!empty($ass_type_list)):

                                foreach ($ass_type_list as $akl => $atypel):

                                ?>

                                <option value="<?php echo $atypel->itli_itemlistid; ?>" <?php if($sel_assets_description==$atypel->itli_itemlistid) echo "selected=selected"; ?> >

                                    <?php echo $atypel->itli_itemcode.' | '.$atypel->itli_itemname; ?>

                                </option>

                                <?php

                            endforeach;

                            endif;

                            ?>

                        </select>

                    </div>



                 <div class="col-md-3">

                <?php $asen_desc=!empty($assets_data[0]->asen_desc)?$assets_data[0]->asen_desc:''; ?>

                    <label><?php echo $this->lang->line('assets_description'); ?><span class="required">*</span>: </label>

                    <input type="text" class="form-control required_field" name="asen_desc" id="asen_desc" value="<?php echo $asen_desc; ?>" >

                </div>

              



                 

              



                <div class="col-md-3">

                  

                        <label><?php echo $this->lang->line('assets_code'); ?><span class="required">*</span>: </label>



                        <?php 

                        if(!empty($assets_data)){

                             $dis= ""; 

                         }else{

                            $dis='';

                         }

                      

                         ?>

                        <input type="text" name="asen_assetcode"  class="form-control required_field" id="asen_assetcode" placeholder="<?php echo $this->lang->line('assets_code'); ?>" value="<?php echo !empty($assets_data[0]->asen_assetcode)?$assets_data[0]->asen_assetcode:''; ?>" <?php if(!empty($assets_data)) echo "readonly" ?> <?php echo $dis; ?> >

                  

                </div>



                 <div class="col-md-3">

                  

                        <label><?php echo $this->lang->line('assets_manual_code'); ?><span class="required">*</span>: </label>

                    

                        <input type="text" name="asen_assestmanualcode"  class="form-control" id="asen_assestmanualcode" placeholder="<?php echo $this->lang->line('assets_manual_code'); ?>" value="<?php echo !empty($assets_data[0]->asen_assestmanualcode)?$assets_data[0]->asen_assestmanualcode:''; ?>">

                    </div>



                  <div class="col-md-3">

                   

                        <label><?php echo $this->lang->line('brand'); ?>:</label>

                        <input type="text" name="asen_brand" class="form-control" placeholder="<?php echo $this->lang->line('brand'); ?>" value="<?php echo !empty($assets_data[0]->asen_brand)?$assets_data[0]->asen_brand:''; ?>">

                    </div>

             

               <div class="col-md-3">

                  

                        <label>Make:</label>

                        <input type="text" name="asen_make" class="form-control" placeholder="Make" value="<?php echo !empty($assets_data[0]->asen_make)?$assets_data[0]->asen_make:''; ?>">

                  

                </div>



                <div class="col-md-3">

                  

                        <label><?php echo $this->lang->line('model_no'); ?>:</label>

                        <input type="text" name="asen_modelno" class="form-control" placeholder="<?php echo $this->lang->line('model_no'); ?>" value="<?php echo !empty($assets_data[0]->asen_modelno)?$assets_data[0]->asen_modelno:''; ?>">

                  

                </div>



                <div class="col-md-3">

                    

                        <label><?php echo $this->lang->line('serial_no'); ?>:</label>

                        <input type="text" name="asen_serialno" class="form-control" placeholder="<?php echo $this->lang->line('serial_no'); ?>" value="<?php echo !empty($assets_data[0]->asen_serialno)?$assets_data[0]->asen_serialno:''; ?>">

                   

                </div>

               

                <div class="col-md-3">

                   

                        <label><?php echo $this->lang->line('status'); ?> <span class="required">*</span>:</label>

                        <?php 

                            $db_asen_status=!empty($assets_data[0]->asen_status)?$assets_data[0]->asen_status:'';

                        ?>

                        <select class="form-control required_field" name="asen_status">

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



                <div class="col-md-3">

                   

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

                

                <div class="col-md-12">

                   

                        <label>Accessories</label>

                        <textarea class="form-control" name="asen_accessories" value=""><?php echo !empty($assets_data[0]->asen_accessories)?$assets_data[0]->asen_accessories:''; ?></textarea>

                    

                </div>



                <div class="col-md-12">

                   

                        <label><?php echo $this->lang->line('remarks'); ?></label>

                        <textarea class="form-control" name="asen_remarks" value=""><?php echo !empty($assets_data[0]->asen_remarks)?$assets_data[0]->asen_remarks:''; ?></textarea>

                    

                </div>



                <?php

                /*

                    if(!empty($assets_data)):

                ?>

                <div class="col-md-12" style="margin-top: 10px;">

                    <label>Barcode:</label><br/>

                    <a href="javascript:void(0)" class="btnBarcode" data-id="<?php echo !empty($assets_data[0]->asen_asenid)?$assets_data[0]->asen_asenid:''; ?>" title="Barcode" ><i class="fa fa-barcode" aria-hidden="true" style="visibility: hidden;"></i></a>

                    <div class="showBarcode" style="float: left;"></div>

                </div>

                <?php

                    endif; */

                ?>

            

            </div>



 

     </div>



            <!-- End Asset Entry -->

    <div class="white-box pad-5 assets-title" style="border-color:silver">

         

                <h4><?php echo $this->lang->line('finance'); ?></h4>

                <div class="row">

                    <div class="col-md-3">

                        

                            <label><?php echo $this->lang->line('depreciation_method'); ?>:</label>

                            <?php 

                                $db_asen_depreciation=!empty($assets_data[0]->asen_depreciation)?$assets_data[0]->asen_depreciation:'';

                                // echo DEP_METHOD;



                                if(defined('DEP_METHOD')):

                                    $depmethoid=DEP_METHOD;

                                else:

                                    $depmethoid=0;

                                endif;

                                // echo $depmethoid;

                            ?>

                            <select class="form-control" id="dep_method" name="asen_depreciation" class="required_field">

                                <?php 

                                    if($depreciation):

                                        foreach ($depreciation as $kcl => $dep):

                                ?>

                                <option value="<?php echo $dep->dety_depreciationid; ?>" <?php if($db_asen_depreciation==$dep->dety_depreciationid || $dep->dety_depreciationid==$depmethoid ) echo "selected=selected"; ?>> <?php echo $dep->dety_depreciation; ?></option>

                                <?php

                                        endforeach;

                                    endif;

                                ?>

                            </select>

                       

                    </div>

                      <div class="col-md-3">

                        <?php 

                        if(DEFAULT_DATEPICKER=='NP'){

                            $depreciation_start=!empty($assets_data[0]->asen_depreciationstartdatebs)?$assets_data[0]->asen_depreciationstartdatebs:DISPLAY_DATE;

                        }else{

                             $depreciation_start=!empty($assets_data[0]->asen_depreciationstartdatead)?$assets_data[0]->asen_depreciationstartdatead:DISPLAY_DATE;

                        }

                        ?>

                        <label>Depreciation Start <span class="required">*</span>:</label>

                         <input type="text" name="asen_depreciationstart" id="asen_depreciationstart" class="form-control <?php echo DATEPICKER_CLASS;?> date" placeholder="YYYY/MM/DD" value="<?php echo $depreciation_start; ?>">

                      </div>

                    <div class="col-md-3">

                       

                            <label><?php echo $this->lang->line('purchase_rate'); ?> <span class="required">*</span>:</label>

                            <input type="text" name="asen_purchaserate" id="asen_purchaserate" class="form-control float" placeholder="<?php echo $this->lang->line('purchase_rate'); ?>" value="<?php echo !empty($assets_data[0]->asen_purchaserate)?$assets_data[0]->asen_purchaserate:'0.00'; ?>">

                 

                    </div>

                  

                    <div class="col-md-3">

                       

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



                   

                        <div class="col-md-3 StraightLineDiv" style="display: none">

                            <label> Salvage value :</label>

                              <input type="text" name="asen_scrapvalue" class="form-control required_field float replicate_data" id="asen_scrapvalue" value="<?php echo !empty($assets_data[0]->asen_scrapvalue)?$assets_data[0]->asen_scrapvalue:'0.00'; ?>" >

                        </div>

                        

                        <div class="col-md-3 StraightLineDiv" style="display: none">

                            <label>Usedful Life:</label>

                               <input type="number" name="asen_expectedlife" class=" required_field form-control float replicate_data" id="asen_expectedlife" value="<?php echo !empty($assets_data[0]->asen_expectedlife)?$assets_data[0]->asen_expectedlife:'0.00'; ?>">

                        </div>

                 



                    <div class="col-md-3">

                        <?php

                                if(DEFAULT_DATEPICKER == 'NP'){

                                    $service_start_date = !empty($assets_data[0]->asen_inservicedatebs)?$assets_data[0]->asen_inservicedatebs:DISPLAY_DATE;

                                }else{

                                    $service_start_date = !empty($assets_data[0]->asen_inservicedatead)?$assets_data[0]->asen_inservicedatead:DISPLAY_DATE;

                                }

                            ?>



                            <label>Service Start Date:</label>

                            <input type="text" name="asen_inservicedate" class="form-control <?php echo DATEPICKER_CLASS;?> date" placeholder="<?php echo $this->lang->line('service'); ?>" id="asen_inservicedate" value="<?php echo $service_start_date; ?>">

                        

                    </div>



                     <div class="col-md-3">

                         <?php

                                if(DEFAULT_DATEPICKER == 'NP'){

                                    $warrenty_start_date = !empty($assets_data[0]->asen_warrentystartdatebs)?$assets_data[0]->asen_warrentystartdatebs:DISPLAY_DATE;

                                }else{

                                    $warrenty_start_date = !empty($assets_data[0]->asen_warrentystartdatead)?$assets_data[0]->asen_warrentystartdatead:DISPLAY_DATE;

                                }

                            ?>

                       

                            <label>Warrenty Start Date:</label>

                            <input type="text" name="asen_warrentystartdate" class="form-control <?php echo DATEPICKER_CLASS;?> date" placeholder="Warrenty Start Date" id="asen_warrentystartdate" value="<?php echo DISPLAY_DATE ?>">

                       

                    </div>



                    <div class="col-md-3">

                         <?php

                                if(DEFAULT_DATEPICKER == 'NP'){

                                    $asen_warrentydate = !empty($assets_data[0]->asen_warrentydatebs)?$assets_data[0]->asen_warrentydatebs:DISPLAY_DATE;

                                }else{

                                    $asen_warrentydate = !empty($assets_data[0]->asen_warrentydatead)?$assets_data[0]->asen_warrentydatead:DISPLAY_DATE;

                                }

                            ?>

                       

                            <label>Warrenty End Date:</label>

                            <input type="text" name="asen_warrentydate" class="form-control <?php echo DATEPICKER_CLASS;?> date" placeholder="Warrenty End Date" id="asen_warrentydate" value="<?php echo $asen_warrentydate ?>">

                       

                    </div>

                    <div class="clearfix"></div>



                   <!--  <div class="col-md-3" id="dep_formula">

                        <label>&nbsp;</label>

                        <a href="javascript:void(0)" style="margin-top: 15px" class="btn btn-sm btn-default pull-right" id="btndepcal">Calculate Dep</a>

                    </div> -->



                    <!-- <div class="col-md-8"><label>Attachement:</label> -->

                   <!--  <input type="file" name="asen_attachment[]"> -->

            <!-- <table>

                <tbody id="pmAttachment">

                 <tr>

                    <td><input type="file" name="asen_attachment[]" class=""></td><td></td>

                </tr>

                </tbody>

                <tfoot>

                    <tr>

                    <td></td><td><a href="javascript:void(0)" class="btn btn-sm btn-primary btnattestAttachment"><i class="fa fa-plus" aria-hidden="true"></i></a></td></tr>

                </tfoot>



        </table> -->

        <div class="col-md-4">

            <label>Attachments</label>

            <div class="dis_tab">

                <input type="file" id="asen_attachment" name="asen_attachment[]"/>

                <input type="hidden" name="asen_attach[]">

                <a href="javascript:void(0)" class="btn btn-info table-cell width_30" id="addAttachments">+</a>

            </div>

            <div class="addAttachmentRow">

                <?php 



                $assetsAttachments = !empty($assets_data[0]->asen_attachment)?$assets_data[0]->asen_attachment:'';

                if($assetsAttachments):

                $attach = explode(', ',$assetsAttachments);

                $download = "";

                if($attach):

                    foreach($attach as $key=>$value){

                        $download .= "<a href='".base_url().ASSETS_ATTACHMENT_PATH.'/'.$value."' target='_blank'>Download</a>&nbsp;&nbsp;&nbsp;";

                        }

                endif;

                echo $download;

            endif;

                ?>

            </div>

        </div>

  

        <div class="col-md-12">

            

            <button type="submit" class="btn btn-info  save" id="btnSubmitEntry" data-operation='save' ><?php echo !empty($assets_data)?'Update & New':'Save & New'; ?></button>

             <button type="submit" class="btn btn-info  save"  id="btnSubmitEntryContinue" data-operation='continue' data-isactive='Y'><?php echo !empty($assets_data)?'Update & Continue':'Save & Continue'; ?></button>

            </div>

        </div>



            <div class="alert-success success"></div>

            <div class="alert-danger error"></div>

       

    </div>

    </form>

</div>









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
                   $("#assets_desc").select2("val", "");
                   // $('#asen_desc').val('');
                   //   $('#asen_assetcode').val('');
                    var datas = response.data;

                    var opteq='';

                    opteq='<option value="">---select---</option>';

                    $.each(datas,function(i,k)

                    {

                      opteq += '<option value='+k.itli_itemlistid+'>'+k.itli_itemcode+'  |  '+k.itli_itemname+ '</option>';

                    });

                   

                }else{

                     $("#assets_desc").select2("val", "");
                    // $('#asen_desc').val('');
                    //  $('#asen_assetcode').val('');
                    opteq='<option value="">---select---</option>';

                    


                }

                $('#assets_desc').html(opteq);

            }

        });

    });

</script>



<script type="text/javascript">

    $(document).off('change','#assets_desc');

    $(document).off('change','#assets_desc',function(){

        var asset_desc_id = $('#assets_desc').val();

        var asset_desc_name = $('#assets_desc').find('option:selected').text();

        var item_desc='';

        // alert(asset_desc_id);

        var submitUrl = base_url+'ams/assets/get_asset_code';

        var submitData = {asset_desc_id:asset_desc_id, asset_desc_name:asset_desc_name};

        beforeSend= $('.overlay').modal('show');

        ajaxPostSubmit(submitUrl, submitData,beforeSend='',onSuccess);

        function onSuccess(response){

            data = jQuery.parseJSON(response);



            if(data.status == 'success'){

                new_asset_code = data.asset_code;

                item_desc=data.item_description;

                $('#asen_assetcode').val(new_asset_code);

                $('#asen_desc').val(item_desc);

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

            $('#btndepcal').click();



            var deptype = $('#dep_type').val();

            

        },500);

    </script>

<?php

    endif;

?>



 <script type="text/javascript">

    $("#asen_deppercentage").bind("blur", function(e) {

     var percentage= $('#asen_deppercentage').val();

     if(percentage)

      {

        asen_deppercentage=(parseFloat(percentage)/100).toFixed(5);

       

      }

       $('#asen_deppercentage').val(asen_deppercentage);



    

});

</script>



<script type="text/javascript">

    $(document).off('click','#btndepcal');

    $(document).on('click','#btndepcal',function(e){

        var dep_method=$('#dep_method').val();

        var asen_purchaserate=$('#asen_purchaserate').val();

        var asen_salvageval=$('#asen_salvageval').val();

        var asen_expectedlife=$('#asen_expectedlife').val();

        var asen_purchasedate=$('#asen_purchasedate').val();

        var asen_inservicedate=$('#asen_inservicedate').val();

        if(asen_purchaserate==''){

            $('#asen_purchaserate').focus();

            return false;

        }

        if(asen_salvageval==''){

            $('#asen_salvageval').focus();

            return false;

        }

        if(asen_expectedlife==''){

            $('#asen_expectedlife').focus();

            return false;

        }

         if(asen_purchasedate==''){

            $('#asen_purchasedate').focus();

            return false;

        }

        if(asen_inservicedate==''){

            $('#asen_inservicedate').focus();

            return false;

        }



    var submitUrl = base_url+'ams/assets/get_live_dep_calculation';

     var submitData = {dep_method:dep_method,asen_purchasedate:asen_purchasedate,asen_inservicedate:asen_inservicedate, asen_purchaserate:asen_purchaserate,asen_salvageval:asen_salvageval,asen_expectedlife:asen_expectedlife};

        beforeSend= $('.overlay').modal('show');

        ajaxPostSubmit(submitUrl, submitData,beforeSend='',onSuccess);

        function onSuccess(response){

            data = jQuery.parseJSON(response);

            if(data.status == 'success'){

               $('#displayReportDiv').html(data.template);



            }else{

                 $('#displayReportDiv').html('');

            }

            $('.overlay').modal('hide');

        }



    });

</script>





<script type="text/javascript">

    $(document).off('change','#dep_method');

    $(document).on('change','#dep_method',function(){

        var dep_method = $(this).val();

        // alert(dep_method);



        if(dep_method == '1'){

            $('.StraightLineDiv').show();

            $('.replicate_data').addClass('required_field');

        }else{

             $('.StraightLineDiv').hide();

              $('.replicate_data').removeClass('required_field');

            

        }

    });

</script>



<script type="text/javascript">

     $('#dep_method').change();



// $(document).off('click','.btnattestAttachment');

// $(document).on('click','.btnattestAttachment',function(e){

//     var temp='';

//     temp='<tr><td><input type="file" name="asen_attachment[]"></td><td><a href="javascript:void(0)" class="btnremove_assetsattch"><i class="fa fa-times" aria-hidden="true"></i></a></td></tr>';

//     $('#pmAttachment').append(temp);

// })



$(document).off('click','#addAttachments');

        $(document).on('click','#addAttachments',function(){

            $(".addAttachmentRow").append('<div class="dis_tab mtop_5"><input type="file" name="asen_attachment[]" "/><input type="hidden" name="asen_attach[]"><a class="btn btn-danger table-cell width_30 btnminus"><span class="fa fa-trash"></span></a></div>');

        });

    

        $(document).off('click','.btnminus');

        $(document).on('click','.btnminus',function(){

            $(this).closest('div').remove();

        });



$(document).off('click','.btnremove_assetsattch');

$(document).on('click','.btnremove_assetsattch',function(e){

    $(this).parent().parent().remove();

})

</script>







