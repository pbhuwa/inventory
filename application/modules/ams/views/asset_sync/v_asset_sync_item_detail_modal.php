<?php

    $total_qty = !empty($item_details[0]->trde_requiredqty)?(int)$item_details[0]->trde_requiredqty:0;

    $itemcode = !empty($item_details[0]->itli_itemcode)?$item_details[0]->itli_itemcode:'';

    $itemsid = !empty($item_details[0]->itli_itemlistid)?$item_details[0]->itli_itemlistid:'';

    $itemname = !empty($item_details[0]->itli_itemname)?$item_details[0]->itli_itemname:'';

    $item_desc=!empty($item_details[0]->recd_description)?$item_details[0]->recd_description:'';

    $itemname_np = !empty($item_details[0]->itli_itemnamenp)?$item_details[0]->itli_itemnamenp:'';

    $unitprice = !empty($item_details[0]->trde_unitprice)?$item_details[0]->trde_unitprice:0;

    $unit_qty = !empty($item_details[0]->trde_requiredqty)?$item_details[0]->trde_requiredqty:0;



    $supplier = !empty($item_details[0]->dist_distributor)?$item_details[0]->dist_distributor:'';

    $supplierid = !empty($item_details[0]->trde_supplierid)?$item_details[0]->trde_supplierid:'';

    $category = !empty($item_details[0]->eqca_category)?$item_details[0]->eqca_category:'';

    $budget_head = !empty($item_details[0]->budg_budgetname)?$item_details[0]->budg_budgetname:'';

       $budgetheadid = !empty($item_details[0]->recm_budgetid)?$item_details[0]->recm_budgetid:'';

    $catid = !empty($item_details[0]->itli_catid)?$item_details[0]->itli_catid:'';

    $trdeid = !empty($item_details[0]->trde_trdeid)?$item_details[0]->trde_trdeid:'';

    $trmaid = !empty($item_details[0]->trde_mtdid)?$item_details[0]->trde_mtdid:'';

    $schoolid=!empty($item_details[0]->recm_school)?$item_details[0]->recm_school:'';

    $supplier_billno=!empty($item_details[0]->recm_supplierbillno)?$item_details[0]->recm_supplierbillno:'';

 



    if(DEFAULT_DATEPICKER == 'NP'){

        $receive_date = !empty($item_details[0]->recm_receiveddatebs)?$item_details[0]->recm_receiveddatebs:'';

    }else{

        $receive_date = !empty($item_details[0]->recm_receiveddatead)?$item_details[0]->recm_receiveddatead:'';

    }

     if(DEFAULT_DATEPICKER == 'NP'){

        $service_date = !empty($item_details[0]->sama_billdatebs)?$item_details[0]->sama_billdatebs:'';

    }else{

        $service_date = !empty($item_details[0]->sama_billdatead)?$item_details[0]->sama_billdatead:'';

    }

?>

<div class="white-box">

    <h3 class="box-title">Asset Sync</h3>



    <div class="white-box pad-5 clearfix">



        <div id="FormDiv_PmData" class="search_pm_data">

            <ul class="pm_data pad-5 pm_data_body rowtype">

                <li class="col-sm-4">

                    <label><?php echo $this->lang->line('item_code'); ?>: </label>

                    <?php echo $itemcode;?>

                </li>

                <li class="col-sm-4">

                    <label><?php echo $this->lang->line('item_name'); ?>: </label>

                    <?php echo $itemname; ?>

                </li>

               



                <li class="col-sm-4">

                    <label><?php echo $this->lang->line('supplier'); ?>: </label>

                    <?php echo $supplier;?>

                </li>

                  <li class="col-sm-4">

                    <label><?php echo $this->lang->line('purchase_date'); ?>: </label>

                    <?php echo $receive_date;?>

                </li>



                <li class="col-sm-4">

                    <label>Unit Price: </label>

                    <?php echo $unitprice;?>

                </li>

                  <li class="col-sm-4">

                    <label>Purchase Qty: </label>

                    <?php echo $unit_qty;?>

                </li>

               

                <li class="col-sm-4">

                    <label><?php echo $this->lang->line('category'); ?>: </label>

                    <?php echo $category;?>

                </li>

                 <li class="col-sm-4">

                    <label>Budget Head: </label>

                    <?php echo $budget_head;?>

                </li>

                

              

                <li class="col-sm-4">

                    <label>Received By</label>

                      <?php echo !empty($item_details[0]->recm_receivedby)?$item_details[0]->recm_receivedby:'';?>

                </li>

                 <?php $remark=!empty($item_details[0]->recm_remarks)?$item_details[0]->recm_remarks:'';?>

                <?php if(!empty($remark)): ?>

                <li class="col-sm-4">

                <?php echo $remark; ?>    

                </li>

                <?php endif; ?>

                <li class="col-sm-4">

                    <a href="javascript:void(0)" data-id="<?php echo $item_details[0]->recm_receivedmasterid ?>" data-displaydiv="" data-viewurl="<?php echo base_url() ?>purchase_receive/receive_against_order/direct_purchase_details" class="view btn-warning btn-xxs sm-pd" data-heading="Receive Ordered Items Detail">View Invoice</a>

                </li>

                

            </ul>

        </div>



        <div class="clear"></div>



        <h5><strong>Update Asset Information</strong></h5>

        <form class="form-material" method="post" id="asset_sync" action="<?php echo base_url('ams/asset_sync/save_asset_sync'); ?>" data-reloadurl='<?php echo base_url('ams/asset_sync'); ?>' data-isredirect='true'>



                <input type="hidden" name="asen_assettype" value="<?php echo $catid; ?>">

                <input type="hidden" name="asen_description" value="<?php echo $itemsid; ?>" >

                <input type="hidden" name="asen_desc" value="<?php echo !empty($item_desc)?$item_desc:$itemname; ?>" />

                <input type="hidden" name="asen_purchasedate" id="asen_purchasedate" value="<?php echo $receive_date; ?>" >

                <input type="hidden" name="asen_inservicedate" id="asen_inservicedate" value="<?php echo $service_date; ?>" >

                <input type="hidden" name="asen_purchaserate" id="asen_purchaserate" value="<?php echo $unitprice; ?>" >

                <input type="hidden" name="unit_qty" id="unit_qty" value="<?php echo $unit_qty; ?>">

                <input type="hidden" name="asen_distributor" value="<?php echo $supplierid; ?>" >

                <input type="hidden" name="trmaid" value="<?php echo $trmaid; ?>" >

                <input type="hidden" name="trdeid" value="<?php echo $trdeid; ?>" >

                <input type="hidden" name="schoolid" value="<?php echo $schoolid; ?>" >

                <input type="hidden" name="asen_staffid" value="  <?php echo !empty($item_details[0]->recm_receivedstaffid)?$item_details[0]->recm_receivedstaffid:'';?>" >

                <input type="hidden" name="asen_budgetid" value="<?php echo $budgetheadid ?>">

                <input type="hidden" name="asen_supplierbillno" value="<?php echo $supplier_billno; ?>">



                 

              





         <div class="form-group white-box bg-gray pad-5 clearfix">

                <div class="col-md-12">

                    <h5>Common Asset Value</h5>

                </div>



                <div class="col-md-3">

                    <div class="">

                        <label>Depreciation Method:</label>

                        <?php 

                            $db_asen_depreciation=!empty($assets_data[0]->asen_depreciation)?$assets_data[0]->asen_depreciation:DEP_METHOD;

                        ?>

                        <select class="form-control required_field" id="dep_type" name="asen_depreciation">

                            <option value="0">---select---</option>

                            <?php 

                                if(!empty($depreciation)):

                                    foreach ($depreciation as $kcl => $dep):

                                        // $is_active=$dep->

                            ?>

                            <option value="<?php echo $dep->dety_depreciationid; ?>" <?php if($db_asen_depreciation==$dep->dety_depreciationid) echo "selected=selected"; ?>> <?php echo $dep->dety_depreciation; ?></option>

                            <?php

                                    endforeach;

                                endif;

                            ?>

                        </select>

                    </div>

                </div>

                <div class="col-md-3">

                    <label>Depreciation Rate (%):</label>

                     <input type="text" name="asen_deppercentage" class="form-control float" value="<?php echo !empty($item_details[0]->eqca_deprate)?$item_details[0]->eqca_deprate:'0.00'; ?>" readonly>

                </div>

                



                <div class="col-md-12">

                    <div id="unit_of_dep_fields"></div>

                </div>

            </div>



        <?php

        // echo $asset_code;

        // die();

                $asscode_array = explode('-',$asset_code);

                //     // echo "<pre>";

                //     // print_r($asset_code_break);

                //     // die();

                //     $asset_code_1 = $asset_code_break[0];

                //     $asset_code_2 = $asset_code_break[1];

                //     $asset_code_3 = $asset_code_break[2];

          if(is_array($asscode_array) && !empty($asscode_array)){

                        $sizeofassets=sizeof($asscode_array);

            }else{

                $sizeofassets=0;

            }

            $numberfilter=$asscode_array[$sizeofassets-2];

             $new_ass_code_arr_str='';

            if(!empty($asscode_array)){

                for ($i=0; $i <$sizeofassets-2 ; $i++) { 

                    $new_ass_code_arr_str .= $asscode_array[$i].'-';

                }

            }

           

           // echo $new_ass_code_arr_str;

           // die();



            for($j=1; $j<=$unit_qty;$j++):

        ?>

        <div class="form-group white-box bg-gray pad-5 clearfix">

        <div class="col-md-12">

                    <div class="">

                        <h5><label><u><?php echo $itemname.'-'.$j;?></u></label></h5>

                    </div>

                </div>



                <?php

                   

            $length_of_number_filter=strlen($numberfilter);

            $increment_assets_number=$numberfilter+($j-1);



            $final_number_gen=str_pad($increment_assets_number, $length_of_number_filter, 0, STR_PAD_LEFT);

           

            $final_assets_code=$new_ass_code_arr_str.$final_number_gen;

            $new_asset_code = $final_assets_code;

            if(!empty($asscode_array[2])){

                 $new_asset_code = $final_assets_code.'-'.$asscode_array[2];

            }



                    // $new_asset_code = $asset_code_1.'-'.($asset_code_2+$i-1).'-'.$asset_code_3;

                ?>



                <div class="col-md-3">

                   <div class="">

                        <label>Asset Code <span class="required">*</span>: </label>

                       

                        <input type="text" name="asen_assetcode[]"  class="form-control required_field" id="asen_assetcode" placeholder="" value="<?php echo $new_asset_code; ?>" readonly >

                    </div>

                </div>



                <div class="col-md-3">

                    <div class="">

                        <label>Manufacturer</label>

                        <?php 

                            $db_asen_manufacture=!empty($assets_data[0]->asen_manufacture)?$assets_data[0]->asen_manufacture:'';

                        ?>

                        <div class="d-flex">

                        <select class="form-control replicate_data" name="asen_manufacture[]" id="asen_manufacture_<?php echo $j;?>" data-id="asen_manufacture" data-rowid = "<?php echo $j;?>">

                            <option value="">---select---</option>

                            <?php 

                                if(!empty($manufacturers)):

                                    foreach ($manufacturers as $kcl => $manu):

                            ?>

                            <option value="<?php echo $manu->manu_manlistid; ?>" <?php if($db_asen_manufacture==$manu->manu_manlistid) echo "selected=selected"; ?>> <?php echo $manu->manu_manlst; ?></option>

                            <?php

                                    endforeach;

                                endif;

                            ?>

                        </select>



               <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 refresh_element" data-targetid='asen_manufacture' data-viewurl='<?php echo base_url('biomedical/manufacturers/manufacturer_reload/'); ?>' ><i class="fa fa-refresh"></i></a>





      <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 view" data-viewurl='<?php echo base_url('biomedical/manufacturers/manufacturer_popup'); ?>' data-heading=" Manufacturer Entry" ><i class="fa fa-plus"></i></a></div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="">

                        <label>Brand</label>

                        <?php 

                            $db_asen_brand=!empty($assets_data[0]->asen_brand)?$assets_data[0]->asen_brand:'';

                        ?>

                        <div class="d-flex">

                        <select class="form-control replicate_data" name="asen_brand[]" id="asen_brand_<?php echo $j;?>" data-id="asen_brand" data-rowid = "<?php echo $j;?>">

                            <option value="">---select---</option>

                            <?php 

                                if(!empty($brand_all)):

                                    foreach ($brand_all as $kcl => $brand):

                            ?>

                            <option value="<?php echo $brand->bran_name; ?>" <?php if($db_asen_brand==$brand->bran_brandid) echo "selected=selected"; ?>> <?php echo $brand->bran_name; ?></option>

                            <?php

                                    endforeach;

                                endif;

                            ?>

                        </select>



               <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 refresh_element" data-targetid='asen_brand' data-viewurl='<?php echo base_url('settings/Brand/brand_reload/'); ?>' ><i class="fa fa-refresh"></i></a>





      <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 view" data-viewurl='<?php echo base_url('settings/Brand/brand_popup'); ?>' data-heading=" Brand Entry" ><i class="fa fa-plus"></i></a></div>

                    </div>

                </div>





        

                   <div class="col-md-3">

                    <div class="">

                         <?php $depid= !empty($item_details[0]->recm_departmentid)?$item_details[0]->recm_departmentid:'';?>

                        <label>Department:</label>

                        <div class="d-flex">

                          <!--   <input type="hidden" name="asen_depid[]" value="<?php echo $depid; ?>"> -->

                        <select class="form-control replicate_data" name="asen_depid[]"  id="asen_depid_<?php echo $j;?>"  data-id="asen_depid" data-rowid = "<?php echo $j;?>" >



                            <option value="0">---select---</option>

                            <?php 

                                if(!empty($departments)):

                                    foreach ($departments as $kcl => $dep):

                            ?>

                            <option value="<?php echo $dep->dept_depid; ?>" <?php if($depid==$dep->dept_depid) echo "selected=selected"; ?> > <?php echo $dep->dept_depname; ?></option>

                            <?php

                                    endforeach;

                                endif;

                            ?>

                        </select>

                         

                     </div>

                    </div>

                </div>

                

                <div class="clearfix " style="margin-bottom: 15px"></div>



                <div class="col-md-3">

                    <div class="">

                        <label>Model No:</label>

                        <input type="text" name="asen_modelno[]" class=" form-control replicate_data" placeholder="" value="" id="asen_modelno_<?php echo $j;?>" data-id="asen_modelno" data-rowid = "<?php echo $j;?>">

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="">

                        <label>Serial No:</label>

                        <input type="text" name="asen_serialno[]" class="form-control" placeholder="" value="" id="asen_serialno_<?php echo $j;?>" data-id="asen_serialno" data-rowid = "<?php echo $j;?>">

                    </div>

                </div>

               

                <div class="">

                    <div class="col-md-3">

                        <div class="">

                            <label>Warranty End:</label>

                            <input type="text" name="asen_warrentydate[]" class="form-control <?php echo DATEPICKER_CLASS;?> date replicate_data" placeholder=""value="<?php echo !empty($assets_data[0]->asen_warrentydate)?$assets_data[0]->asen_warrentydate:DISPLAY_DATE; ?>" id="asen_warrentydate_<?php echo $j;?>" data-id="asen_warrentydate" data-rowid = "<?php echo $j;?>">

                        </div>

                    </div>

                  



                    <div class="col-md-3">

                        <div class="">

                            <label>Remarks:</label>

                            <textarea class="form-control" name="asen_remarks[]" value=""><?php echo !empty($dep_remarks)?$dep_remarks:''; ?></textarea>

                        </div>

                    </div>

            <div class="StraightLineDiv" style="display: none"> 

                <div class="col-md-3">

                    <label> Salvage value :</label>

                      <input type="text" name="asen_scrapvalue[]" class="form-control  float replicate_data" id="asen_scrapvalue_<?php echo $j;?>" data-id="asen_scrapvalue" data-rowid = "<?php echo $j;?>" >

                </div>

                

                <div class="col-md-3">

                    <label>Usedful Life:</label>

                       <input type="number" name="asen_expectedlife[]" class="  form-control float replicate_data" id="asen_expectedlife_<?php echo $j;?>" data-id="asen_expectedlife" data-rowid = "<?php echo $j;?>">

                </div>

            </div>



                    <div class="col-md-12">

                        <div id="unit_of_dep_fields"></div>

                    </div>

                </div>



            

           

        </div>

        <?php

            endfor;

        ?>

        <div id="Printable" class="print_report_section printTable">

                

        </div>

        <div class="col-md-12">

            <div  class="alert-success success"></div>

            <div class="alert-danger error"></div>



            <div class="" style="margin-top: 20px;">

                <button type="submit" class="btn btn-info save" data-operation="save" id="asset_sync" style="margin-top: 0px;">Save</button>

                &nbsp;

                <button type="submit" class="btn btn-info savePrint" data-operation='save' id="btnSubmit" data-print="print">Save and Print</button>

            </div>

        </div>

        <div class="clear"></div>

        </form>



    </div>

</div>



<script type="text/javascript">





    $(document).off('change keyup','.replicate_data');

    $(document).on('change keyup','.replicate_data',function(){

        var row_count = $(this).data('rowid');

        // alert(row_count);

        // return false;

        var id = $(this).data('id');



        if(row_count == '1'){

            var row_data = $(this).val();

            

            $('[id^="'+id+'_"]').each(function(index, e) {

                var id_index = index+2;

                if($(e).val() == row_data){

                    $('#'+id+'_'+id_index).val(row_data).trigger('change');  

                }

            });

        }else{

            return false;

        }

    });



</script>

<script type="text/javascript">

    $(document).off('change','#dep_type');

    $(document).on('change','#dep_type',function(){

        var dep_type = $(this).val();

        // alert(dep_type);



        if(dep_type == '1'){

           

            $('.StraightLineDiv').show();

        }else{

             $('.StraightLineDiv').hide();

            

        }

    });

</script>

<?php if($db_asen_depreciation=='1'): ?>

<script type="text/javascript">

     $('.StraightLineDiv').show();

</script>

<?php endif; ?>