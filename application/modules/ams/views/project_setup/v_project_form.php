 <!-- <?php 
// echo "<pre>";
// echo($project_rec_data[0]->prin_complete_datebs);
// echo($project_rec_data[0]->prin_complete_datead);
// die();
?>  -->
<div class="assest-form">
   <form id="Project_Setup" class="form-material" method="post"  action="<?php echo base_url('ams/project_setup/save_project'); ?>" data-reloadurl='<?php echo base_url('ams/assets/assets_entry/reload'); ?>'>
      <div class="white-box pad-5 assets-title" style="border-color:silver">
         <h4>Basic Information</h4>
         <input type="hidden" name="id" value="<?php echo !empty($project_rec_data[0]->prin_prinid)?$project_rec_data[0]->prin_prinid:''; ?>" />
         <div class="row">
            <div class="col-md-3">
               <label>Fiscal year<span class="required">*</span>:</label>
               <?php 
                  $assettype=!empty($project_rec_data[0]->prin_fiscalyrs)?$project_rec_data[0]->prin_fiscalyrs:'';
                  ?>
                <select class="form-control required_field" name="prin_fiscalyrs">
                  <option value="">---select---</option>
                  <?php 
                     if($fiscal_year):
                         foreach ($fiscal_year as $kcl => $stat):
                     ?>
                  <option value="<?php echo $stat->fiye_fiscalyear_id; ?>" 
                    
                      <?php if($assettype==$stat->fiye_fiscalyear_id) echo "selected=selected"; ?>> 
                      <?php echo $stat->fiye_name; ?>
                    </option>
                  <?php
                     endforeach;
                     endif;
                     ?>
               </select>
            </div>
            <div class="col-md-3">
               <?php $prin_code=!empty($project_rec_data[0]->prin_code)?$project_rec_data[0]->prin_code:$project_code; ?>
               <label>Code<span class="required">*</span>: </label>
               <input type="text" class="form-control required_field" name="prin_code" id="prin_code" value="<?php echo $prin_code; ?>" >
            </div>
            <div class="col-md-3">
               <label>Project Title<span class="required">*</span>: </label>
               <input type="text" name="prin_project_title"  class="form-control required_field" id="prin_project_title" placeholder="Project Title" value="<?php echo !empty($project_rec_data[0]->prin_project_title)?$project_rec_data[0]->prin_project_title:''; ?>"  >
            </div>
            <div class="col-md-3">
               <label>Description: </label>
               <input type="text" name="prin_project_desc"  class="form-control" id="prin_project_desc" placeholder="Project Description" value="
               <?php echo !empty($project_rec_data[0]->prin_project_desc)?$project_rec_data[0]->prin_project_desc:''; ?>">
            </div>
            <div class="col-md-3">
               <?php
                  if(DEFAULT_DATEPICKER == 'NP'){
                      $service_start_date = !empty($project_rec_data[0]->prin_startdatebs)?$project_rec_data[0]->prin_startdatebs:DISPLAY_DATE;
                  }else{
                      $service_start_date = !empty($project_rec_data[0]->prin_startdatead)?$project_rec_data[0]->prin_startdatead:DISPLAY_DATE;
                  }
                  ?>
               <label>Start Date:</label>
               <input type="text" name="prin_startdate" class="form-control <?php echo DATEPICKER_CLASS;?> date" placeholder="<?php echo $this->lang->line('service'); ?>" id="prin_startdate" value="<?php echo $service_start_date; ?>">
            </div>
           <div class="col-md-3">
               <?php
                  if(DEFAULT_DATEPICKER == 'NP'){
                      $service_start_date = !empty($project_rec_data[0]->prin_estenddatebs)?$project_rec_data[0]->prin_estenddatebs:DISPLAY_DATE;
                  }else{
                      $service_start_date = !empty($project_rec_data[0]->prin_estenddatead)?$project_rec_data[0]->prin_estenddatead:DISPLAY_DATE;
                  }
                  ?>
               <label>Est. Comp. Date:</label>
               <input type="text" name="prin_estenddate" class="form-control <?php echo DATEPICKER_CLASS;?> date" placeholder="<?php echo $this->lang->line('service'); ?>" id="prin_estenddate" value="<?php echo $service_start_date; ?>">
            </div>
            <div class="col-md-3">
               <label>Contractor<span class="required">*</span>:</label>
               <?php 
                  $assettype=!empty($project_rec_data[0]->prin_contactorid)?$project_rec_data[0]->prin_contactorid:'';
                  ?>
                  
               <select class="form-control required_field" name="prin_contactorid">
                  <option value="">---select---</option>
                  <?php 
                     if($distributors):
                         foreach ($distributors as $kcl => $stat):
                     ?>
                  <option value="<?php echo $stat->dist_distributorid; ?>"
                    <?php if($assettype==$stat->dist_distributorid) echo "selected=selected"; ?>> 
                   
                    <?php echo $stat->dist_distributor; ?>

                    
                  </option>
                  <?php
                     endforeach;
                     endif;
                     ?>
               </select>
            </div>
            <div class="col-md-3">
               <label>Contractor No.<span class="required">*</span>:</label>
               <input type="text" name="prin_contractno" class="form-control" placeholder="Contractor Number" value="<?php echo !empty($project_rec_data[0]->prin_contractno)?$project_rec_data[0]->prin_contractno:''; ?>">
            </div>
            <div class="col-md-3">
                <?php
                  if(DEFAULT_DATEPICKER == 'NP'){
                      $service_start_date = !empty($project_rec_data[0]->prin_contractdatebs)?$project_rec_data[0]->prin_contractdatebs:DISPLAY_DATE;
                  }else{
                      $service_start_date = !empty($project_rec_data[0]->prin_contractdatead)?$project_rec_data[0]->prin_contractdatead:DISPLAY_DATE;
                  }
                  ?>
               <label>Contract Date:</label>
               <input type="text" name="prin_contractdate" class="form-control <?php echo DATEPICKER_CLASS;?> date" placeholder="<?php echo $this->lang->line('service'); ?>" id="prin_contractdate" value="<?php echo $service_start_date; ?>">
            </div>
            <div class="clearfix"></div>
            <div class="col-md-8">
               <label>Attachement:</label>
               <table>
                  <tbody id="pmAttachment">
                     <tr>
                        <td><input type="file" name="prin_attachment[]" class=""></td>
                        <td></td>
                     </tr>
                  </tbody>
                  <tfoot>
                     <tr>
                        <td></td>
                        <td><a href="javascript:void(0)" class="btn btn-sm btn-primary btnattestAttachment"><i class="fa fa-plus" aria-hidden="true"></i></a></td>
                     </tr>
                  </tfoot>
               </table>
            </div>
         </div>
        <?php if(!empty($project_rec_data[0])): ?>
        <div class="col-md-3">
             <label>Is project Complete? </label>
                                    
               <?php $db_status=!empty($project_rec_data[0]->prin_complete_status)?$project_rec_data[0]->prin_complete_status:''; ?>
              
              <?php
              $status= $this->input->post('prin_complete_status'); 
              $select_status=!empty($status)?$status:$db_status;
              ?>
            <input type="radio" name="prin_complete_status" value="1" id="chky" <?php if($select_status==1) echo "checked=checked"; ?> >Yes
            <input type="radio" name="prin_complete_status" value="2" id="chkn" <?php if($select_status==0 || $select_status==2 ) echo "checked=checked"; ?>  >No
         
              <?=form_error('prin_complete_status');?> 
        </div>
       
        <div class="col-md-3">
                <?php
                  if(DEFAULT_DATEPICKER == 'NP'){
                      $prin_completion_date = !empty($project_rec_data[0]->prin_complete_datebs)?$project_rec_data[0]->prin_complete_datebs:'';
                  }else{
                      $prin_completion_date = !empty($project_rec_data[0]->prin_complete_datead)?$project_rec_data[0]->prin_complete_datead:'';
                  }
                  ?>
               <label>Completion Date:</label>
               <input type="text" name="prin_completion_date" class="form-control <?php echo DATEPICKER_CLASS;?> date" placeholder="Project Completion Date" id="prin_completion_date" value="<?php echo $prin_completion_date; ?>">
        </div>

        <?php endif; ?>
        <div class="clearfix"></div>
         <button type="submit" class="btn btn-info  save" id="btnSubmitEntry" data-operation='save' ><?php echo !empty($project_rec_data)?'Update & New':'Save'; ?></button>
        <button type="submit" class="btn btn-info  savelist"  id="btnSubmitEntryClose" data-operation='save' data-isdismiss='Y'> Save & close</button>
      </div>
      <div class="alert-success success"></div>
      <div class="alert-danger error"></div>
</div>
</form>
</div>
<script type="text/javascript">
   $(document).ready(function(){
       
       $('.changedropdown').change();
   
       var descid = '<?php echo $assettype=!empty($project_rec_data[0]->asen_description)?$project_rec_data[0]->asen_description:'';?>';
   
   
      
   });
   
   $(document).on('change','#dep_type',function(){
       var datetype=$(this).val();
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
   if(!empty($project_rec_data)):
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
   
   $(document).off('click','.btnattestAttachment');
   $(document).on('click','.btnattestAttachment',function(e){
   var temp='';
   temp='<tr><td><input type="file" name="asen_attachment[]"></td><td><a href="javascript:void(0)" class="btnremove_assetsattch"><i class="fa fa-times" aria-hidden="true"></i></a></td></tr>';
   $('#pmAttachment').append(temp);
   })
   
   $(document).off('click','.btnremove_assetsattch');
   $(document).on('click','.btnremove_assetsattch',function(e){
   $(this).parent().parent().remove();
   })
</script>