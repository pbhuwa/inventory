 <div class="assest-form">
     <form id="FormleaseAssets" class="form-material" method="post"  action="<?php echo base_url('ams/assets/save_lease_assets'); ?>" data-reloadurl='<?php echo base_url('ams/assets/assets_entry/reload'); ?>' >
    <div class="white-box pad-5 assets-title" style="border-color:silver">
        <h4>Lease Information</h4>
        <?php
        // if(!empty($lease_data_rec)):
        // echo "<pre>";
        // print_r($lease_data_rec);

        // endif;

         ?>
            <input type="hidden" name="lede_assetid" value="<?php echo !empty($assets_data[0]->asen_asenid)?$assets_data[0]->asen_asenid:''; ?>" />
            <input type="hidden" name="lema_leasemasterid" value="<?php echo !empty($lease_data_rec[0]->lema_leasemasterid)?$lease_data_rec[0]->lema_leasemasterid:''; ?>">
            <input type="hidden" name="lede_leasedetailid" value="<?php echo !empty($lease_data_rec[0]->lede_leasedetailid)?$lease_data_rec[0]->lede_leasedetailid:''; ?>">
            <div class="row">
                  <div class="col-md-3">
                  
                        <input type="checkbox" name="asen_isleased_assets" value="Y" id="isassetslead" checked="checked"> Assets is Leased
                        
                    </div>

                     <div class="col-md-3">
                       <?php $lema_companyid =!empty($lease_data_rec[0]->lema_companyid)?$lease_data_rec[0]->lema_companyid:''; ?>
                        <label>Lease Company<span class="required">*</span>: </label>
                         <select class="form-control required_field isleased" name="lema_companyid">
                            <option value="">---Select---</option>
                            <?php 
                                if(!empty($lease_company)): 
                                    foreach ($lease_company as $klc => $lcom):
                                ?>
                             <option value="<?php echo $lcom->leco_leasecompanyid ?>" <?php if($lema_companyid==$lcom->leco_leasecompanyid): echo "selected=selected"; endif; ?>><?php echo $lcom->leco_companyname ?></option>
                         <?php endforeach; endif; ?>
                         </select>
                        
                    </div>
                        <div class="col-md-3">
                        <?php $lema_contractno =!empty($lease_data_rec[0]->lema_contractno)?$lease_data_rec[0]->lema_contractno:''; ?>
                        <label>Lease Contract No<span class="required">*</span>: </label>
                        <input type="text" class="form-control required_field isleased" name="lema_contractno" value="<?php echo $lema_contractno; ?>">
                        </div>
                      
                      <div class="col-md-3">
                        <?php
                        if(DEFAULT_DATEPICKER=='NP'){
                             $lema_startdate =!empty($lease_data_rec[0]->lema_startdatebs)?$lease_data_rec[0]->lema_startdatebs:DISPLAY_DATE;
                        } else{
                             $lema_startdate =!empty($lease_data_rec[0]->lema_startdatead)?$lease_data_rec[0]->lema_startdatead:DISPLAY_DATE;
                        } 
                        ?>
                        <label>Lease Start Date<span class="required">*</span>: </label>
                        <input type="text" class="form-control required_field isleased <?php echo DATEPICKER_CLASS;?> date"  name="lema_startdate" id="lema_startdate" value="<?php echo $lema_startdate; ?>">
                    </div>

                    <div class="col-md-3">
                         <?php
                        if(DEFAULT_DATEPICKER=='NP'){
                             $lema_enddate =!empty($lease_data_rec[0]->lema_enddatebs)?$lease_data_rec[0]->lema_enddatebs:DISPLAY_DATE;
                        } else{
                             $lema_enddate =!empty($lease_data_rec[0]->lema_enddatead)?$lease_data_rec[0]->lema_enddatead:DISPLAY_DATE;
                        } 
                        ?>
                        <label>Lease End Date<span class="required"></span>: </label>
                        <input type="text" class="form-control required_field isleased <?php echo DATEPICKER_CLASS;?> date" name="lema_enddate" id="lema_enddate" value="<?php echo $lema_enddate ; ?>">
                    </div>
                    <?php $lede_initcost =!empty($lease_data_rec[0]->lede_initcost)?$lease_data_rec[0]->lede_initcost:''; ?>

                      <div class="col-md-3">
                        <label>Initial Cost<span class="required">*</span>: </label>
                        <input type="text" class="form-control float required_field isleased" name="lede_initcost" value="<?php echo $lede_initcost; ?>">
                    </div>
                    <div class="col-md-3">
                          <?php $lede_rental_amt =!empty($lease_data_rec[0]->lede_rental_amt)?$lease_data_rec[0]->lede_rental_amt:''; ?>
                        <label>Rental Amount<span class="required">*</span>: </label>
                        <input type="text" class="form-control float required_field isleased " name="lede_rental_amt" value="<?php echo $lede_rental_amt; ?>">
                    </div>

                    <div class="col-md-3">
                        <?php $lede_frequencyid =!empty($lease_data_rec[0]->lede_frequencyid)?$lease_data_rec[0]->lede_frequencyid:''; ?>
                        <label>Rental Frequency<span class="required">*</span>: </label>
                        <select name="lede_frequencyid" class="form-control required_field isleased">
                            <option value="">---Select---</option>
                            <?php
                            if(!empty($frequency)):
                                foreach ($frequency as $kf => $fre):
                            ?>
                            <option value="<?php echo $fre->frty_frtyid ?>" <?php if($lede_frequencyid==$fre->frty_frtyid): echo "selected=selected"; endif; ?>><?php echo $fre->frty_name; ?></option>
                            <?php
                           endforeach;
                            endif;
                             ?>
                        </select>
                    </div>

                    <!-- <div class="col-md-12">
                        <label>Attachment:</label>
                        <br>
                        <table>
                            <tbody id="leaseAttachment">
                             <tr>
                                <td><input type="file" name="lema_attachment[]" class="isleased"></td><td></td>
                            </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                <td></td><td><a href="javascript:void(0)" class="btn btn-sm btn-primary btnleaseAttachment"><i class="fa fa-plus" aria-hidden="true"></i></a></td></tr>
                            </tfoot>
                           

                        </table>
                        
                    </div> -->
                    <div class="col-md-4">
                        <label>Attachments</label>
                        <div class="dis_tab">
                            <input type="file" id="lema_attachment" name="lema_attachment[]"/>
                            <input type="hidden" name="lema_attach[]">
                            <a href="javascript:void(0)" class="btn btn-info table-cell width_30" id="addAttachments">+</a>
                        </div>
                        <div class="addAttachmentRow">
                            <?php 

                            $leaseAttachments = !empty($lease_data_rec[0]->lema_attachment)?$lease_data_rec[0]->lema_attachment:'';
                            if($leaseAttachments):
                            $attach = explode(', ',$leaseAttachments);
                            $download = "";
                                if($attach):
                                    foreach($attach as $key=>$value){
                                        $download .= "<a href='".base_url().LEASE_ATTACHMENT_PATH.'/'.$value."' target='_blank'>Download</a>&nbsp;&nbsp;&nbsp;";
                                        }
                                endif;
                            echo $download;
                            endif;
                            ?>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <?php $lema_remarks=!empty($lease_data_rec[0]->lema_remarks)?$lease_data_rec[0]->lema_remarks:''; ?>
                       <label><?php echo $this->lang->line('remarks'); ?></label>
                        <textarea class="form-control isleased" name="lema_remarks"><?php echo $lema_remarks; ?></textarea>
                    
                </div>
                <div class="col-md-12">
                <button type="submit" class="btn btn-info  save isleased" id="btnSubmitLeaseEntry" data-operation='save' ><?php echo !empty($lease_data_rec)?'Update & New':'Save & New'; ?></button>

                <button type="submit" class="btn btn-info  save isleased"  id="btnleaseasset_continue" data-operation='continue' data-isactive='Y' ><?php echo !empty($lease_data_rec)?'Update & Continue':'Save & Continue'; ?></button>
                    </div>
            </div>

 
     </div>
 </form>
</div>

<script type="text/javascript">
    $('#locationid').addClass('required_field');
</script>

<script type="text/javascript">
    // $(document).off('click','.btnleaseAttachment');
    // $(document).on('click','.btnleaseAttachment',function(e){
    //     var temp='';
    //     temp='<tr><td><input type="file" name="lema_attachment[]"></td><td><a href="javascript:void(0)" class="btnremove_attch"><i class="fa fa-times" aria-hidden="true"></i></a></td></tr>';
    //     $('#leaseAttachment').append(temp);
    // })

    //  $(document).off('click','.btnremove_attch');
    //     $(document).on('click','.btnremove_attch',function(e){
    //         $(this).parent().parent().remove();
    //     })

    $(document).off('click','#addAttachments');
        $(document).on('click','#addAttachments',function(){
            $(".addAttachmentRow").append('<div class="dis_tab mtop_5"><input type="file" name="lema_attachment[]" "/><input type="hidden" name="lema_attach[]"><a class="btn btn-danger table-cell width_30 btnminus"><span class="fa fa-trash"></span></a></div>');
        });
    
        $(document).off('click','.btnminus');
        $(document).on('click','.btnminus',function(){
            $(this).closest('div').remove();
        });

    $(document).off('click','#isassetslead');
    $(document).on('click','#isassetslead',function(e){
        if ($('#isassetslead').is(":checked"))
        {
          $(".isleased").attr("disabled", false);
        }else{
            $(".isleased").attr("disabled", true);
        }
    });
</script>
