<form method="post" id="FormTransferAssets" action="<?php echo base_url('ams/assets_transfer/save_asset_transfer'); ?>" class="form-material form-horizontal form" data-reloadurl="<?php echo base_url('ams/assets_transfer/index/reload'); ?>">
    <input type="hidden" name="id" value="<?php echo !empty($transfer_data_rec[0]->astm_assettransfermasterid)?$transfer_data_rec[0]->astm_assettransfermasterid:'';  ?>">
     <div class="form-group">
        <div class="col-md-3">
          <label>Fiscal Year:<span class="required">*</span></label>
          <?php $astm_fiscalyrs=!empty($transfer_data_rec[0]->astm_fiscalyrs)?$transfer_data_rec[0]->astm_fiscalyrs:CUR_FISCALYEAR; ?>
          <select name="astm_fiscalyrs" class="form-control" id="astm_fiscalyrs">
            <?php
            if($fiscal_year):
              foreach ($fiscal_year as $ks => $fyrs):
                ?>
                <option value="<?php echo $fyrs->fiye_name; ?>" <?php if($astm_fiscalyrs==$fyrs->fiye_name) echo "selected=selected"; ?>><?php echo $fyrs->fiye_name; ?></option>
                <?php
              endforeach;
            endif;
            ?>
          </select>
        </div>

        <div class="col-md-3">
            <label>Transfer No.<span class="required">*</span>:</label>
            <?php $trno=!empty($transfer_data_rec[0]->astm_transferno)?$transfer_data_rec[0]->astm_transferno:$transfer_code ?>
            <input type="text" name="astm_transferno" class="form-control" id="transferno" value="<?php echo $trno; ?>">
        </div>

        <div class="col-md-3">
           <?php $manualno=!empty($transfer_data_rec[0]->astm_manualno)?$transfer_data_rec[0]->astm_manualno:'' ?>
            <label>Manual No.:</label>
            <input type="text" name="astm_manualno" class="form-control" id="manualno" value="<?php echo $manualno; ?>">
        </div>

          <div class="col-md-3">
             <?php $transfertypeid=!empty($transfer_data_rec[0]->astm_transfertypeid)?$transfer_data_rec[0]->astm_transfertypeid:'' ?>
                <label>Transfer Type<span class="required">*</span>:</label>
                <select name="astm_transfertypeid" id="transfertypeid" class="form-control">
                    <option value="D" <?php if($transfertypeid=='D') echo "selected=selected"; ?>>Department</option>
                    <option value="B" <?php if($transfertypeid=='B') echo "selected=selected"; ?>>Branch</option>
                    
                </select>
            </div>
          <div class="departmentWrapper" >
            <div class="col-md-3">
                <label>Department From:</label>
                <select name="fromdepid" class="form-control select2 depselect" id="fromdepid">
                <option value="">--Select--</option>
                <?php
                 if(!empty($department_list)):
                  foreach ($department_list as $ks => $dlist):
                    ?>
                    <option value="<?php echo $dlist->dept_depid; ?>"><?php echo $dlist->dept_depname; ?></option>
                    <?php
                  endforeach;
                endif;
                ?>
            </select>
            </div>
            <div class="col-md-3">
                <label>Department To:</label>
                <select name="todepid" class="form-control select2 depselect" id="todepid">
            <option value="">--Select--</option>
            <?php
            if(!empty($department_list)):
              foreach ($department_list as $ks => $dlist):
                ?>
                <option value="<?php echo $dlist->dept_depid; ?>"><?php echo $dlist->dept_depname; ?></option>
                <?php
              endforeach;
            endif;
            ?>
          </select>
            </div>
        </div>
         <div class="branchWrapper" style="display:none">
          <?php echo $this->general->location_option(3,'locationfrom','locationfrom',false,'From'); ?>
          <?php echo $this->general->location_option(3,'locationto','locationto',false,'To'); ?>
        </div>
        
    <div class="col-md-3">
      <label>Date:</label>
      <?php
          if(DEFAULT_DATEPICKER == 'NP'){
              $transferdate = !empty($transfer_data_rec[0]->astm_transferdatebs)?$transfer_data_rec[0]->astm_transferdatebs:DISPLAY_DATE;
          }else{
              $transferdate = !empty($transfer_data_rec[0]->astm_transferdatead)?$transfer_data_rec[0]->astm_transferdatead:DISPLAY_DATE;
          }
     ?>

        <input type="text" id="frmDate" name="transferdate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo $transferdate; ?>"/>
    </div>
    
   <div class="clearfix"></div>

        
   <div class="form-group">
            <div class="table-responsive col-sm-12">
                <table style="width:100%;" class="table dataTable dt_alt purs_table res_vert_table">
                    <thead>
                        <tr>
                            <th scope="col" width="5%"> <?php echo $this->lang->line('sn'); ?>. </th>
                            <th scope="col" width="15%">Assets Code </th>
                            <th scope="col" width="20%">Description</th>
                            <th scope="col" width="5%">Original Cost.  </th>
                            <th scope="col" width="10%">Current Cost. </th>
                            <th scope="col" width="20%"><?php echo $this->lang->line('remarks'); ?> </th>
                            <th scope="col" width="5%"> <?php echo $this->lang->line('action'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="orderBody">
                        <tr class="orderrow" id="orderrow_1" data-id='1'>
                            <td data-label="S.No.">
                                <input type="text" class="form-control sno" id="s_no_1" value="1" readonly/>
                            </td>
                            <td data-label="Code">
                                <div class="dis_tab"> 
                                    <input type="text" class="form-control assetscode enterinput" id="assetscode_1" name="assets_code[]"  data-id='1' data-targetbtn='view' value="">
                                    <input type="hidden" class="assetsid" name="assetid[]" data-id='1' value="" id="assetsid_1">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading='<?php echo $this->lang->line('list_of_items'); ?>' data-viewurl='<?php echo base_url('/ams/assets/list_of_assets_popup'); ?>' data-id='1' id="view_1"><strong>...</strong></a>&nbsp;
                                </div> 
                            </td>
                            <td data-label="Description">  
                                <input type="text" class="form-control assets_desc"  id="assets_desc_1" name="assets_desc[]"  data-id='1' readonly> 
                            </td>
                            
                            <td data-label="Orginal. Value"> 
                                <input type="text" class="form-control float calculateamt assets_orginalval" name="assets_orginalval[]"   id="assets_orginalval_1" data-id='1' > 
                            </td>
                             <td data-label="Current Val"> 
                                <input type="text" class="form-control float calculateamt assets_currentval" name="assets_currentval[]"   id="assets_currentval_1" data-id='1' > 
                            </td>
                            
                            <td data-label="Remarks"> 
                                <input type="text" class="form-control  remarks jump_to_add " id="remarks_1" name="remarks[]"  data-id='1'> 
                            </td>
                            <td data-label="Action">
                                 <div class="actionDiv acDiv2" id="acDiv2_1"></div>
                            </td>
                        </tr>
                  
                        
                    </tbody>
                    <tbody>
                        <tr class="resp_table_breaker">
                            <td colspan="7">
                                <a href="javascript:void(0)" class="btn btn-primary btnAdd pull-right" data-id="1"  id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                                <div class="clearfix"></div>
                            </td>
                        </tr>
                    </tbody>
                   
                        
                </table>
                <div id="Printable" class="print_report_section printTable">
                
                </div>
            </div> <!-- end table responsive -->
        </div>
        <div class="form-group">
       
            <div class="col-md-6">
              <?php $fullremarks=!empty($transfer_data_rec[0]->astm_remarks)?$transfer_data_rec[0]->astm_remarks:''; ?>
              <label>Full Remarks</label>
              <textarea name="fullremarks" class="form-control" width="100%"><?php echo $fullremarks; ?></textarea>
            </div>
         
        </div>
       
        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($transfer_data_rec)?'update':'save' ?>' id="btnSubmitsave" ><?php echo !empty($transfer_data_rec)?'Update':$this->lang->line('save');  ?></button>
                <button type="submit" class="btn btn-info savePrint" data-operation='<?php echo !empty($transfer_data_rec)?'update':'save ' ?>' id="btnSubmitPrint" data-print="print"><?php echo !empty($transfer_data_rec)?'Update & Print':$this->lang->line('save_and_print') ?></button>
            </div>
            <div class="col-sm-12">
                <div  class="alert-success success"></div>
                <div class="alert-danger error"></div>
            </div>
        </div>
</div>
</form>


<script type="text/javascript">
    $(document).off('change','#transfertypeid');
    $(document).on('change','#transfertypeid',function(){
        var search_date_val = $(this).val();

        if(search_date_val == 'D'){
            $('.branchWrapper').hide();
        }else{
            $('.branchWrapper').show();
        }

        if(search_date_val == 'B'){
            $('.departmentWrapper').hide();
        }else{
            $('.departmentWrapper').show();
        }
    });
</script>
<script type="text/javascript">
   $(document).off('click','.btnAdd');
    $(document).on('click','.btnAdd',function(){
        var id=$(this).data('id');
        
        var trpluOne = $('.orderrow').length;
        var trplusOne = $('.orderrow').length+1;
       
         var assetsid=$('#assetsid_'+trpluOne).val();
         var salesval=$('#assets_salesval_'+trpluOne).val();
         // alert(assetsid);
         // return false;
         if(assetsid==''){
            $('#assetscode_'+trpluOne).focus();
            return false;
        }
        if(salesval==''){
            $('#assets_salesval_'+trpluOne).focus();
            return false;
        }
      
        if(trplusOne==2)
        {
            $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');
        }
        var template='';
        
        template='<tr class="orderrow" id="orderrow_'+trplusOne+'" data-id='+trplusOne+'><td data-label="S.No."> <input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'"  readonly/></td><td data-label="Code"><div class="dis_tab"> <input type="text" class="form-control assetscode enterinput" id="assetscode_'+trplusOne+'"  name="assets_code[]" data-id="'+trplusOne+'" data-targetbtn="view" value=""> <input type="hidden" class="assetsid" name="assetid[]" data-id="'+trplusOne+'" value="" id="assetsid_'+trplusOne+'" > <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading="Assets List" data-viewurl="<?php echo base_url("/ams/assets/list_of_assets_popup"); ?>" data-id="'+trplusOne+'" id="view_"'+trplusOne+'" ><strong>...</strong></a>&nbsp;</div></td><td data-label="Description"> <input type="text" class="form-control assets_desc" id="assets_desc_'+trplusOne+'"  name="assets_desc[]" data-id='+trplusOne+'" readonly></td><td data-label="Orginal. Value"> <input type="text" class="form-control float calculateamt assets_orginalval" name="assets_orginalval[]" id="assets_orginalval_'+trplusOne+'" data-id="'+trplusOne+'" ></td><td data-label="Current Val"> <input type="text" class="form-control float calculateamt assets_currentval" name="assets_currentval[]" id="assets_currentval_'+trplusOne+'"  data-id="'+trplusOne+'" ></td><td data-label="Remarks"> <input type="text" class="form-control remarks jump_to_add " id="remarks_'+trplusOne+'"  name="remarks[]" data-id="'+trplusOne+'"></td><td data-label="Action"> <div class="actionDiv acDiv2" id="acDiv2_'+trplusOne+'"><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div></td></tr>';

        $('#itemcode_'+trplusOne).focus();
        $('#orderBody').append(template);
    });
    $(document).off('click','.btnRemove');
    $(document).on('click','.btnRemove',function(){
        var id=$(this).data('id');
         var whichtr = $(this).closest("tr");
         var conf = confirm('Are Your Want to Sure to remove?');
          if(conf)
          {
           

             var trplusOne = $('.orderrow').length+1;
             // console.log(trplusOne);
             // $('#orderrow_'+id).fadeOut(500, function(){ 
             // $('#orderrow_'+id).remove();
             //  });

             whichtr.remove(); 
            //  for (var i = 0; i < trplusOne; i++) {
            //   $('#s_no_'+i).val(i);
            // }
            setTimeout(function(){
                  $(".orderrow").each(function(i,k) {
                    var vali=i+1;
                    $(this).attr("id","orderrow_"+vali);
                    $(this).attr("data-id",vali);    
                    $(this).find('.sno').attr("id","s_no_"+vali);
                    $(this).find('.sno').attr("value",vali);
                    $(this).find('.assetscode').attr("id","assetscode_"+vali);
                    $(this).find('.assetscode').attr("data-id",vali);
                    $(this).find('.assetsid').attr("id","assetsid_"+vali);
                    $(this).find('.assetsid').attr("data-id",vali);
                    $(this).find('.assets_desc').attr("id","assets_desc_"+vali);
                    $(this).find('.assets_desc').attr("data-id",vali);
                    $(this).find('.view').attr("id","view_"+vali);
                    $(this).find('.view').attr("data-id",vali);
                    $(this).find('.assets_orginalval').attr("id","assets_orginalval_"+vali);
                    $(this).find('.assets_orginalval').attr("data-id",vali);
                    $(this).find('.assets_currentval').attr("id","assets_currentval_"+vali);
                    $(this).find('.assets_currentval').attr("data-id",vali);
                    $(this).find('.last_dep_date').attr("id","last_dep_date_"+vali);
                    $(this).find('.last_dep_date').attr("data-id",vali);
                    $(this).find('.assets_salesval').attr("id","assets_salesval_"+vali);
                    $(this).find('.assets_salesval').attr("data-id",vali);
                    $(this).find('.remarks').attr("id","remarks_"+vali);
                    $(this).find('.remarks').attr("data-id",vali);
                    $(this).find('.acDiv2').attr("id","acDiv2_"+vali);
                    // $(this).find('.acDiv2').attr("data-id",vali);
                    $(this).find('.btnAdd').attr("id","addOrder_"+vali);
                    $(this).find('.btnAdd').attr("data-id",vali);
                    $(this).find('.btnRemove').attr("id","addOrder_"+vali);
                    $(this).find('.btnRemove').attr("data-id",vali);
                    $(this).find('.btnChange').attr("id","btnChange_"+vali);
            });
              },600);
                    setTimeout(function(){
                    var trlength = $('.orderrow').length;
                        // alert(trlength);
                             if(trlength==1)
                             {
                                 $('#acDiv2_1').html('');
                             }
                         },800);
                     $('.assets_orginalval').change();
                    $('.assets_currentval').change();
                    $('.assets_salesval').change();

         

          }
     });

  $(document).off('click','.itemDetail');
    $(document).on('click','.itemDetail',function(){
        var rowno=$(this).data('rowno');
        var rate=$(this).data('rate');
        var asen_assetcode=$(this).data('asen_assetcode');
        var asen_desc=$(this).data('asen_desc');
        var asen_asenid=$(this).data('asen_asenid');
        var purrate=$(this).data('purrate');
        
        var last_depnetval=$(this).data('last_depnetval');

        $('#assetsid_'+rowno).val(asen_asenid);
        $('#assetscode_'+rowno).val(asen_assetcode);
        $('#assets_desc_'+rowno).val(asen_desc);
        $('#assets_orginalval_'+rowno).val(purrate);
        $('#assets_currentval_'+rowno).val(last_depnetval);
        $('#myView').modal('hide');
        $('#remarks_'+rowno).focus();
        $('.assets_orginalval').change();
        $('.assets_currentval').change();
        return false;
    })

    $(document).off('change','.depselect');
    $(document).on('change','.depselect',function(e){
      var fromdepid =$('#fromdepid').val();
      var todepid=$('#fromdepid').val();
      if(fromdepid==todepid){
        alert('Same Department Couldnot accepted!!');
        return false;
      }

    })
    $(document).off('change','.depselect');
    $(document).on('change','.depselect',function(e){
      var fromdepid =$('#fromdepid').val();
      var todepid=$('#todepid').val();
      if(fromdepid==todepid){
        alert('Same Department Couldnot accepted!!');
        return false;
      }
       $('#todepid').focus();
    })


    $(document).off('change','#locationfrom,#locationto');
    $(document).on('change','#locationfrom,#locationto',function(e){
      var locationfrom =$('#locationfrom').val();
      var locationto=$('#locationto').val();
      if(locationfrom==locationto){
        alert('Same Branch Couldnot accepted!!');
        return false;
      }
      $('#locationto').focus();
    })

</script>
