 <div class="assest-form">
<div class="white-box pad-5 assets-title" style="border-color:silver">
    <h4>Preventive Maintanance Information</h4>
    <form id="FormPMAssets" class="form-material" method="post"  action="<?php echo base_url('ams/assets/save_pmrecord_assets'); ?>" >
    <input type="hidden" name="pmam_assetid" value="<?php echo !empty($assets_data[0]->asen_asenid)?$assets_data[0]->asen_asenid:''; ?>" />
    <input type="hidden" name="pmam_pmamcmasterid" value="<?php echo !empty($pm_record_master[0]->pmam_pmamcmasterid)?$pm_record_master[0]->pmam_pmamcmasterid:''; ?>" />
    <input type="hidden" name="pmam_pmamtype" value="PM">
          <div class="row">
            <div class="col-md-3">
                    <?php 
                    $pmam_contractorid=!empty($pm_record_master[0]->pmam_contractorid)?$pm_record_master[0]->pmam_contractorid:'';
                     ?>
                    <label>PM Company<span class="required">*</span>: </label>
                     <select class="form-control required_field " name="pmam_contractorid">
                        <option value="">---Select---</option>
                        <?php 
                            if(!empty($distributors)): 
                                foreach ($distributors as $kic => $dst):
                            ?>
                         <option value="<?php echo $dst->dist_distributorid ?>" <?php if($pmam_contractorid==$dst->dist_distributorid) echo "selected=selected"; ?>><?php echo $dst->dist_distributor ?></option>
                     <?php endforeach; endif; ?>
                     </select>
                    
                </div>
                  <?php
                    if(DEFAULT_DATEPICKER=='NP'){
                         $pmam_startdate =!empty($pm_record_master[0]->pmam_startdatebs)?$pm_record_master[0]->pmam_startdatebs:DISPLAY_DATE;
                    } else{
                         $pmam_startdate =!empty($pm_record_master[0]->pmam_startdate)?$pm_record_master[0]->pmam_startdate:DISPLAY_DATE;
                    } 
                    ?>
                
                <div class="col-md-3">
                    <label>PM Start Date<span class="required">*</span>: </label>
                    <input type="text" class="form-control required_field  <?php echo DATEPICKER_CLASS;?> date"  name="pmam_startdate" id="pmstartdate" value="<?php echo $pmam_startdate; ?>">
                </div>

                 <div class="col-md-3">
                    <?php 
                    $pmam_frequencyid=!empty($pm_record_master[0]->pmam_frequencyid)?$pm_record_master[0]->pmam_frequencyid:'';
                     ?>
                    <label>PM Frequency<span class="required">*</span>: </label>
                    <select name="pmam_frequencyid" id="pmfrequency" class="form-control required_field ">
                        <option value="">---Select---</option>
                        <?php
                        if(!empty($frequency)):
                            foreach ($frequency as $kf => $fre):
                        ?>
                        <option value="<?php echo $fre->frty_frtyid ?>" <?php if($pmam_frequencyid==$fre->frty_frtyid) echo "selected=selected"; ?>><?php echo $fre->frty_name; ?></option>
                        <?php
                       endforeach;
                        endif;
                         ?>
                    </select>
                </div>
                 <div class="col-md-2">
                     <?php 
                    $pmam_noofyear=!empty($pm_record_master[0]->pmam_noofyear)?$pm_record_master[0]->pmam_noofyear:'1';
                     ?>
                      <label>No.of Year<span class="required">*</span>: </label>
                      <input type="text" name="pmam_noofyear" class="form-control required_field numberic" value="<?php echo $pmam_noofyear; ?>" id="no_of_year">
                 </div>
                 <div class="col-md-1">
                    <?php if(empty($pm_record_master)): ?>
                    <label>&nbsp;</label>
                    <a href="javascript:void(0)" class="btn btn-sm btn-warning btn_generatepm">Generate</a>
                <?php endif; ?>
                 </div>
                 <div class="col-md-12">
                     <div id="generate_pmtable">
                         <?php if(!empty($pm_record_detail)): ?>
                           <table class="table table-border table-striped table-site-detail dataTable"><thead><tr><th width="5%">S.n</th><th width="15%">Start Date</th><th width="20%">Remarks</th><th width="15%">Next Date</th></tr></thead>
                            <?php foreach ($pm_record_detail as $kprd => $prec):
                              ?>
                              <tr>
                                  <td><?php echo $kprd+1 ?></td>
                                  <td><?php 
                                  if(DEFAULT_DATEPICKER=='NP'){
                                    echo $prec->pmad_datebs;
                                  }else{
                                    echo $prec->pmad_datead;
                                  }
                                  ?></td>
                                   <td></td>
                                  <td>
                                      <?php 
                                  if(DEFAULT_DATEPICKER=='NP'){
                                    echo $prec->pmad_upcomingdatebs;
                                  }else{
                                    echo $prec->pmad_upcomingdatead;
                                  }
                                  ?>
                                  </td>
                                 
                              </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php endif; ?>
                     </div>
                 </div>
                
                <!-- <div class="col-md-12">
                    <label>Attachment:</label>
                    <br>
                    <table>
                        <tbody id="pmAttachment">
                         <tr>
                            <td><input type="file" name="pmam_attachement[]" class=""></td><td></td>
                        </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                            <td></td><td><a href="javascript:void(0)" class="btn btn-sm btn-primary btnpmAttachment"><i class="fa fa-plus" aria-hidden="true"></i></a></td></tr>
                        </tfoot>      
                    </table>
                </div> -->
                <div class="col-md-4">
                  <label>Attachments</label>
                  <div class="dis_tab">
                      <input type="file" id="pmam_attachement" name="pmam_attachement[]"/>
                      <input type="hidden" name="pmam_attach[]">
                      <a href="javascript:void(0)" class="btn btn-info table-cell width_30" id="addAttachments">+</a>
                  </div>
                  <div class="addAttachmentRow">
                      <?php 

                      $maintananceAttachments = !empty($pm_record_master[0]->pmam_attachement)?$pm_record_master[0]->pmam_attachement:'';
                      if($maintananceAttachments):
                      $attach = explode(', ',$maintananceAttachments);
                      $download = "";
                        if($attach):
                            foreach($attach as $key=>$value){
                                $download .= "<a href='".base_url().MAINTENANCE_ATTACHMENT_PATH.'/'.$value."' target='_blank'>Download</a>&nbsp;&nbsp;&nbsp;";
                                }
                        endif;
                      echo $download;
                      endif;
                      ?>
                  </div>
                </div>

                <div class="col-md-12">
                    <?php 
                    $pmam_remarks=!empty($pm_record_master[0]->pmam_remarks)?$pm_record_master[0]->pmam_remarks:'';
                     ?>
                   <label><?php echo $this->lang->line('remarks'); ?></label>
                    <textarea class="form-control " name="pmam_remarks" value="<?php echo $pmam_remarks; ?>"></textarea> 
                </div>
            <div class="col-md-12">
          <button type="submit" class="btn btn-info  save " data-operation='update' id="btnpmasset" >Save</button>
                </div>
        <div class="col-sm-12">
        <div  class="alert-success success"></div>
        <div class="alert-danger error"></div>
        </div>
        </div>
    </form>
 </div>

<div class="white-box pad-5 assets-title" style="border-color:silver">
        <form id="FormleaseAssets" class="form-material" method="post"  action="<?php echo base_url('ams/assets/save_pmrecord_assets'); ?>" >
        <h4>AMC Information</h4>
            <input type="hidden" name="pmam_assetid" value="<?php echo !empty($assets_data[0]->asen_asenid)?$assets_data[0]->asen_asenid:''; ?>" />
            <input type="hidden" name="pmam_pmamcmasterid" value="<?php echo !empty($assets_amc_data[0]->pmam_pmamcmasterid)?$assets_amc_data[0]->pmam_pmamcmasterid:''; ?>" />
              <input type="hidden" name="pmam_pmamtype" value="AMC">
            <div class="row">
                <?php 
                $pmam_contractorid=!empty($assets_amc_data[0]->pmam_contractorid)?$assets_amc_data[0]->pmam_contractorid:'';
                ?>
                     <div class="col-md-3">
                        <label>AMC Contractor<span class="required">*</span>: </label>
                         <select class="form-control required_field " name="pmam_contractorid">
                            <option value="">---Select---</option>
                            <?php 
                                if(!empty($distributors)): 
                                    foreach ($distributors as $kic => $dst):
                                ?>
                             <option value="<?php echo $dst->dist_distributorid ?>" <?php if($pmam_contractorid==$dst->dist_distributorid) echo "selected=selected"; ?>><?php echo $dst->dist_distributor ?></option>
                         <?php endforeach; endif; ?>
                         </select>
                        
                    </div>

                     <?php
                        if(DEFAULT_DATEPICKER=='NP'){
                             $pmam_startdate =!empty($assets_amc_data[0]->pmam_startdatebs)?$assets_amc_data[0]->pmam_startdatebs:DISPLAY_DATE;
                        } else{
                             $pmam_startdate =!empty($assets_amc_data[0]->pmam_startdate)?$assets_amc_data[0]->pmam_startdate:DISPLAY_DATE;
                        } 
                     ?>
                    <div class="col-md-3">
                        <label>AMC Start Date<span class="required">*</span>: </label>
                        <input type="text" class="form-control required_field  <?php echo DATEPICKER_CLASS;?> date"  name="asin_startdate" id="pmstartdate" value="<?php echo $pmam_startdate; ?>">
                    </div>
                   
                     <div class="col-md-3">
                    <?php 
                    $lede_frequencyid=!empty($assets_amc_data[0]->lede_frequencyid)?$assets_amc_data[0]->lede_frequencyid:'';
                    ?>
                        <label>AMC Frequency<span class="required">*</span>: </label>
                        <select name="lede_frequencyid" class="form-control required_field ">
                            <option value="">---Select---</option>
                            <?php
                            if(!empty($frequency)):
                                foreach ($frequency as $kf => $fre):
                            ?>
                            <option value="<?php echo $fre->frty_frtyid ?>" <?php if( $lede_frequencyid==$fre->frty_frtyid) echo "selected=selected"; ?> ><?php echo $fre->frty_name; ?></option>
                            <?php
                           endforeach;
                            endif;
                             ?>
                        </select>
                    </div>

                    
                    <div class="col-md-12">
                        <label>Attachment:</label>
                        <br>
                        <table>
                            <tbody id="amcAttachment">
                             <tr>
                                <td><input type="file" name="pmam_attachement[]" class=""></td><td></td>
                            </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                <td></td><td><a href="javascript:void(0)" class="btn btn-sm btn-primary btnamcAttachment"><i class="fa fa-plus" aria-hidden="true"></i></a></td></tr>
                            </tfoot>
                           

                        </table>
                        
                    </div>
                    <!-- <div class="col-md-4">
                      <label>Attachments</label>
                      <div class="dis_tab">
                          <input type="file" id="pmam_attachement" name="pmam_attachement[]"/>
                          <input type="hidden" name="pmam_attach[]">
                          <a href="javascript:void(0)" class="btn btn-info table-cell width_30" id="addAttachments">+</a>
                      </div>
                      <div class="addAttachmentRow">
                          <?php 

                          $maintananceAttachments = !empty($assets_amc_data[0]->pmam_attachement)?$assets_amc_data[0]->pmam_attachement:'';
                          if($maintananceAttachments):
                          $attach = explode(', ',$maintananceAttachments);
                          $download = "";
                            if($attach):
                                foreach($attach as $key=>$value){
                                    $download .= "<a href='".base_url().MAINTENANCE_ATTACHMENT_PATH.'/'.$value."' target='_blank'>Download</a>&nbsp;&nbsp;&nbsp;";
                                    }
                            endif;
                          echo $download;
                          endif;
                          ?>
                      </div>
                    </div> -->


                      <div class="col-md-12">
                        <?php 
                        $pmam_remarks=!empty($assets_amc_data[0]->pmam_remarks)?$assets_amc_data[0]->pmam_remarks:'';
                         ?>
                       <label><?php echo $this->lang->line('remarks'); ?></label>
                        <textarea class="form-control " name="pmam_remarks" value="<?php echo $pmam_remarks; ?>"></textarea> 
                    </div>
                <div class="col-md-12">
                <div class="col-md-12">
              <button type="submit" class="btn btn-info  save " data-operation='update' id="btnleaseasset" >Save</button>
                    </div>
                    </div>
            </div>
        </form>
 
     </div>
</div>

<script type="text/javascript">
    $('#locationid').addClass('required_field');
</script>

<script type="text/javascript">
        // $(document).off('click','.btnpmAttachment');
        // $(document).on('click','.btnpmAttachment',function(e){
        //     var temp='';
        //     temp='<tr><td><input type="file" name="lema_attachment[]"></td><td><a href="javascript:void(0)" class="btnremove_pmattch"><i class="fa fa-times" aria-hidden="true"></i></a></td></tr>';
        //     $('#pmAttachment').append(temp);
        // })

        // $(document).off('click','.btnremove_pmattch');
        // $(document).on('click','.btnremove_pmattch',function(e){
        //     $(this).parent().parent().remove();
        // })

        // $(document).off('click','.btnamcAttachment');
        // $(document).on('click','.btnamcAttachment',function(e){
        //     var temp='';
        //     temp='<tr><td><input type="file" name="lema_attachment[]"></td><td><a href="javascript:void(0)" class="btnremove_amcattch"><i class="fa fa-times" aria-hidden="true"></i></a></td></tr>';
        //     $('#amcAttachment').append(temp);
        // })

        //  $(document).off('click','.btnremove_amcattch');
        //  $(document).on('click','.btnremove_amcattch',function(e){
        //      $(this).parent().parent().remove();
        //     })
  $(document).off('click','#addAttachments');
  $(document).on('click','#addAttachments',function(){
      $(".addAttachmentRow").append('<div class="dis_tab mtop_5"><input type="file" name="pmam_attachement[]" "/><input type="hidden" name="pmam_attach[]"><a class="btn btn-danger table-cell width_30 btnminus"><span class="fa fa-trash"></span></a></div>');
  });

  $(document).off('click','.btnminus');
  $(document).on('click','.btnminus',function(){
      $(this).closest('div').remove();
  });


</script>

<script type="text/javascript">
    $(document).off('click','.btn_generatepm');
    $(document).on('click','.btn_generatepm',function(e){
        var startdate=$('#pmstartdate').val();
        var pmfrequency=$('#pmfrequency').val();
        var no_of_year =$('#no_of_year').val();
        if(pmfrequency==null || pmfrequency=='' ){
            alert('Frequency field is required');
            $('#pmfrequency').focus();
            return false;
        }

         var submitUrl = base_url+'ams/assets/generate_pmtable';
         var submitData = {startdate:startdate,pmfrequency:pmfrequency,no_of_year:no_of_year};
            beforeSend= $('.overlay').modal('show');
            ajaxPostSubmit(submitUrl, submitData,beforeSend='',onSuccess);
            function onSuccess(response){
                data = jQuery.parseJSON(response);
                if(data.status == 'success'){
                   $('#generate_pmtable').html(data.template);

                }else{
                     $('#generate_pmtable').html('');
                }
                $('.overlay').modal('hide');
            }
    });
</script>
