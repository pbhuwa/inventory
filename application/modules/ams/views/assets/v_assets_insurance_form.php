 <div class="assest-form">
     <form id="FormInsuranceAssets" class="form-material" method="post"  action="<?php echo base_url('ams/assets/save_assets_insurance'); ?>" data-reloadurl='<?php echo base_url('ams/assets/assets_entry/reload'); ?>' >
    <div class="white-box pad-5 assets-title" style="border-color:silver">
        <h4>Insurance Information</h4>
            <input type="hidden" name="asin_assetid" value="<?php echo !empty($assets_data[0]->asen_asenid)?$assets_data[0]->asen_asenid:''; ?>" />
             <input type="hidden" name="asin_asinid" value="<?php echo !empty($insurance_data_rec[0]->asin_asinid)?$insurance_data_rec[0]->asin_asinid:''; ?>" />
            <div class="row">
                 
                <?php 
                $asin_companyid=!empty($insurance_data_rec[0]->asin_companyid)?$insurance_data_rec[0]->asin_companyid:''; 
                ?>
                     <div class="col-md-3">
                        <label>Insurance Company<span class="required">*</span>: </label>
                         <select class="form-control required_field " name="asin_companyid" >
                            <option value="">---Select---</option>
                            <?php 
                                if(!empty($insurance_company)): 
                                    foreach ($insurance_company as $kic => $icom):
                                ?>
                             <option value="<?php echo $icom->inco_id ?>" <?php if($asin_companyid==$icom->inco_id) echo "selected=selected"; ?>><?php echo $icom->inco_name ?></option>
                         <?php endforeach; endif; ?>
                         </select>
                        
                    </div>
                        <div class="col-md-3">
                        <?php 
                           $asin_policyno=!empty($insurance_data_rec[0]->asin_policyno)?$insurance_data_rec[0]->asin_policyno:''; 
                         ?>
                        <label>Insurance Policy Number<span class="required">*</span>: </label>
                        <input type="text" class="form-control required_field " name="asin_policyno" value="<?php echo $asin_policyno; ?>">
                        </div>
                      
                      <div class="col-md-3">
                        <?php
                        if(DEFAULT_DATEPICKER=='NP'){
                             $asin_startdate =!empty($lease_data_rec[0]->asin_startdatebs)?$lease_data_rec[0]->asin_startdatebs:DISPLAY_DATE;
                        } else{
                             $asin_startdate =!empty($lease_data_rec[0]->asin_startdatead)?$lease_data_rec[0]->asin_startdatead:DISPLAY_DATE;
                        } 
                        ?>
                        <label>Policy  Start Date<span class="required">*</span>: </label>
                        <input type="text" class="form-control required_field  <?php echo DATEPICKER_CLASS;?> date"  name="asin_startdate" id="asin_startdate" value="<?php echo $asin_startdate; ?>">
                    </div>

                    <div class="col-md-3">
                        <?php
                        if(DEFAULT_DATEPICKER=='NP'){
                             $asin_enddate =!empty($lease_data_rec[0]->asin_enddatebs)?$lease_data_rec[0]->asin_enddatebs:DISPLAY_DATE;
                        } else{
                             $asin_enddate =!empty($lease_data_rec[0]->asin_enddatead)?$lease_data_rec[0]->asin_startdatead:DISPLAY_DATE;
                        } 
                        ?>
                        <label>Policy  End Date<span class="required"></span>: </label>
                        <input type="text" class="form-control required_field  <?php echo DATEPICKER_CLASS;?> date" name="asin_enddate" id="asin_enddate" value="<?php echo $asin_enddate; ?>">
                    </div>

                      <div class="col-md-3">
                        <?php 
                           $asin_insuranceamount=!empty($insurance_data_rec[0]->asin_insuranceamount)?$insurance_data_rec[0]->asin_insuranceamount:''; 
                         ?>
                        <label>Insurance Value<span class="required">*</span>: </label>
                        <input type="text" class="form-control float required_field " name="asin_insuranceamount" value="<?php echo $asin_insuranceamount; ?>">
                    </div>

                       <div class="col-md-3">
                         <?php 
                           $asin_frequencyid=!empty($insurance_data_rec[0]->asin_frequencyid)?$insurance_data_rec[0]->asin_frequencyid:''; 
                         ?>
                        <label>Insurance Frequency<span class="required">*</span>: </label>
                        <select name="asin_frequencyid" class="form-control required_field ">
                            <option value="">---Select---</option>
                            <?php
                            if(!empty($frequency)):
                                foreach ($frequency as $kf => $fre):
                            ?>
                            <option value="<?php echo $fre->frty_frtyid ?>" <?php if($asin_frequencyid==$fre->frty_frtyid) echo "selected=selected"; ?>><?php echo $fre->frty_name; ?></option>
                            <?php
                           endforeach;
                            endif;
                             ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <?php 
                           $asin_insurancerate=!empty($insurance_data_rec[0]->asin_insurancerate)?$insurance_data_rec[0]->asin_insurancerate:''; 
                         ?>
                        <label>Payment Amount<span class="required">*</span>: </label>
                        <input type="text" class="form-control float required_field  " name="asin_insurancerate" value="<?php echo $asin_insurancerate; ?>">
                    </div>

                 

                    <!-- <div class="col-md-12">
                        <label>Attachment:</label>
                        <br>
                        <table>
                            <tbody id="insuranceAttachment">
                             <tr>
                                <td><input type="file" name="asin_attachment[]" class=""></td><td></td>
                            </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                <td></td><td><a href="javascript:void(0)" class="btn btn-sm btn-primary btninsuranceAttachment"><i class="fa fa-plus" aria-hidden="true"></i></a></td></tr>
                            </tfoot>
                           

                        </table>
                        
                    </div> -->

                    <div class="col-md-4">
                        <label>Attachments</label>
                        <div class="dis_tab">
                            <input type="file" id="asin_attachment" name="asin_attachment[]"/>
                            <input type="hidden" name="asin_attach[]">
                            <a href="javascript:void(0)" class="btn btn-info table-cell width_30" id="addAttachments">+</a>
                        </div>
                        <div class="addAttachmentRow">
                            <?php 

                            $insuranceAttachments = !empty($insurance_data_rec[0]->asin_attachment)?$insurance_data_rec[0]->asin_attachment:'';
                            if($insuranceAttachments):
                            $attach = explode(', ',$insuranceAttachments);
                            $download = "";
                                if($attach):
                                    foreach($attach as $key=>$value){
                                        $download .= "<a href='".base_url().
                                        INSURANCE_ATTACHMENT_PATH.'/'.$value."' target='_blank'>Download</a>&nbsp;&nbsp;&nbsp;";
                                        }
                                endif;
                            echo $download;
                            endif;
                            ?>
                        </div>
                    </div>

                    <div class="col-md-12">
                         <?php 
                           $asin_remarks=!empty($insurance_data_rec[0]->asin_remarks)?$insurance_data_rec[0]->asin_remarks:''; 
                         ?>
                       <label><?php echo $this->lang->line('remarks'); ?></label>
                        <textarea class="form-control " name="asin_remarks" value="<?php echo  $asin_remarks; ?>"></textarea>
                    
                </div>
                <div class="col-md-12">
                <button type="submit" class="btn btn-info  save " id="btnSubmitInsuranceEntry" data-operation='save' ><?php echo !empty($insurance_data_rec)?'Update & New':'Save & New'; ?></button>

                <button type="submit" class="btn btn-info  save "  id="btnSubmitInsuranceEntryContinue" data-operation='continue' data-isactive='Y' ><?php echo !empty($insurance_data_rec)?'Update & Continue':'Save & Continue'; ?></button>
                    </div>
            </div>

 
     </div>
 </form>
</div>

<script type="text/javascript">
    $('#locationid').addClass('required_field');
</script>

<script type="text/javascript">
    // $(document).off('click','.btninsuranceAttachment');
    // $(document).on('click','.btninsuranceAttachment',function(e){
    //     var temp='';
    //     temp='<tr><td><input type="file" name="lema_attachment[]"></td><td><a href="javascript:void(0)" class="btnremove_insuranceattch"><i class="fa fa-times" aria-hidden="true"></i></a></td></tr>';
    //     $('#insuranceAttachment').append(temp);
    // })

    //  $(document).off('click','.btnremove_insuranceattch');
    //     $(document).on('click','.btnremove_insuranceattch',function(e){
    //         $(this).parent().parent().remove();
    //     })
    $(document).off('click','#addAttachments');
        $(document).on('click','#addAttachments',function(){
            $(".addAttachmentRow").append('<div class="dis_tab mtop_5"><input type="file" name="asin_attachment[]" "/><input type="hidden" name="asin_attach[]"><a class="btn btn-danger table-cell width_30 btnminus"><span class="fa fa-trash"></span></a></div>');
        });
    
        $(document).off('click','.btnminus');
        $(document).on('click','.btnminus',function(){
            $(this).closest('div').remove();
        });


</script>
