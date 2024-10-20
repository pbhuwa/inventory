<?php 
if($org_id=='2'){
    $this->load->view('common/v_assets_detail');
}else{
    $this->load->view('common/amc_equipment_detail');
}
?>
<form method="post" id="Formamcdata" action="<?php echo base_url('biomedical/amc_data/save_amc_data'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/amc_data/form_amc_data'); ?>' enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo !empty($pmdata[0]->riva_riskid)?$pmdata[0]->riva_riskid:'';  ?>">
    <input type="hidden" name="amctableid" value="<?php echo !empty($pmdata[0]->amta_amctableid)?$pmdata[0]->amta_amctableid:''; ?>">
    <div class="clearfix"></div>
    <div class="clearfix"></div>
    <div class="amc_data_body">
        <div id="FormDiv_PmData" class="search_amc_data">
        </div>
    </div>
    <div class="clearfix"></div>
    <div  class="waves-effect waves-light m-r-10 text-success success"></div>
    <div class="waves-effect waves-light m-r-10 text-danger error"></div>
</form>
<div class="form-group">
  <div class="col-md-4 col-sm-6 col-xs-6">
      <label for="example-text"><?php echo $this->lang->line('amc_contractor'); ?>: </label>

      <?php 
      $amta_amccontractorid=!empty($equip_data[0]->amta_amccontractorid)?$equip_data[0]->amta_amccontractorid:'';
      // echo $deptype;die();
      ?>

      <select name="amta_amccontractorid" class="form-control " >
        <option value="">---select---</option>

        <?php if($distributor_list):
            foreach ($distributor_list as $kdl => $distrubutor):?>

                <option value="<?php echo $distrubutor->dist_distributorid; ?>" <?php if($amta_amccontractorid==$distrubutor->dist_distributorid) echo 'selected=selected'; ?>><?php echo $distrubutor->dist_distributor; ?></option>

            <?php endforeach; endif; ?>
        </select>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-6">
      <label for="example-text"><?php echo $this->lang->line('number_of_visit_plans'); ?>: </label></br>
      <input type="number" class="form-control" name="amta_visitplans" id="noofvisiter_id">
  </div>
</div>


<div class="form-group">
    <div class="table-responsive">
        <table class="table table-border table-striped table-site-detail dataTable">
            <thead>
                <tr>
                    <th width="15%"><?php echo $this->lang->line('amc_date_BS'); ?></th>
                    <th colspan="3" width="30%" ><?php echo $this->lang->line('remarks');?></th>
                    <th width="15%"><?php echo $this->lang->line('end_date'); ?></th>
                    <th width="20%"><?php echo $this->lang->line('upload_excel_file'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('status'); ?></th>
                    <th width="10%"<?php echo $this->lang->line('action'); ?>></th>
                </tr>
            </thead>

            <tbody>
                <?php
                $curdate = CURDATE_EN;
                $pmid = !empty($pmdata[0]->amta_amctableid)?$pmdata[0]->amta_amctableid:'';
                if(!empty($pmdata)){
                    ?>
                    <tr class="projectrow" id="projectrow_1" data-id="1">
                        <td>
                            <input type="text" id="amta_amcdatebs_1" name="amta_amcdate[]" class="form-control date <?php echo DATEPICKER_CLASS; ?> amta_amcdate" value="<?php echo CURDATE_NP; ?>" >
                            <span class="errmsg"></span>
                        </td>
                        <td colspan="3"><input type="text" id="amta_remarks_1" name="amta_remarks[]" value="<?php echo !empty($pmdata[0]->amta_remarks)?$pmdata[0]->amta_remarks:''; ?>" class="form-control amta_remarks" ></td>
                        <td>
                            <input type="text" id="amta_amcenddatebs_1" name="amta_amcenddate[]" class="form-control date <?php echo DATEPICKER_CLASS; ?> amta_amcenddate" value="<?php echo CURDATE_NP; ?>" >
                            <span class="errmsg"></span>
                        </td>
                        <td>
                            <input type="file" id="amta_amcfile_1" name="amta_amcfile[]" class="form-control amta_amcfile">
                            <span class="errmsg"></span>
                        </td>
                        <td></td>


                        <td><div class="actionDiv" id="acDiv2_1"></div></td>
                    </tr>
                    <?php if($pmdata):?>
                        <tbody id="addPM"></tbody>
                    <?php endif; ?>
                    <tr> <td colspan="8"><a href="javascript:void(0)" class="add btn btn-success pull-right"><i class="fa fa-plus-square-o "></i></a></td></tr>


                </tbody>

                <tr>
                    <td >   
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($pmdata)?'update':'save' ?>'><?php echo !empty($pmdata)?'Save':'' ?></button>
                    </td>
                </tr>
                <thead>
                    <tr>
                        <th><?php echo $this->lang->line('amc_history'); ?>: </th>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('amc_date_AD'); ?> </th>
                        <th><?php echo $this->lang->line('amc_date_BS'); ?> </th>
                        <th><?php echo $this->lang->line('remarks'); ?></th>
                        <th><?php echo $this->lang->line('status'); ?></th>
                        <th><?php echo $this->lang->line('download_file'); ?></th>
                        <th><?php echo $this->lang->line('is_comp'); ?></th>
                        <th><?php echo $this->lang->line('action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $j=1;
                    foreach($pmdata as $data){ 
                        $newDate = !empty($data->amta_isamccompleted)?$data->amta_isamccompleted:'';
                        if($newDate == '1'){
                            $style = "color:#d00";
                            $status = "Completed";
                            $display = "display:none;";
                        }else{
                            $style = "color:#0f0";
                            $status = "Available";
                            $display = "display:inline-block;";
                        }
                        $amctableid = !empty($data->amta_amctableid)?$data->amta_amctableid:'';
                //$amctableid = !empty($data->amta_ispmcompleted)?$data->amta_ispmcompleted:'';
                        ?>
                        <tr id="listid_<?php echo $amctableid; ?>">
                            <td>
                                <?php echo !empty($data->amta_amcdatead)?$data->amta_amcdatead:'';?>
                            </td>
                            <td>
                                <?php echo !empty($data->amta_amcdatebs)?$data->amta_amcdatebs:'';?>
                            </td>
                            <td>
                                <?php echo !empty($data->amta_remarks)?$data->amta_remarks:'';?>
                            </td>
                            <td style="<?php echo $style; ?>"><?php echo $status; ?></td>
                            <td>
                               <?php if(!empty($data->amta_amcfile)): ?>
                                  <a  href="<?php echo base_url().AMC_UPLOAD_PATH.'/'?><?php echo !empty($data->amta_amcfile)?$data->amta_amcfile:'';?>" target="_blank" ><i class="fa fa-download" aria-hidden="true"  ></i></a>
                                  <?php else: echo "File Not Uploaded";?>
                                  <?php endif; ?>
                              </td>

                              <td>
                                <?php 
                                $ispmcomplete=!empty($data->amta_isamccompleted)?$data->amta_isamccompleted:'0';
                                $completedatead=!empty($data->amta_completedatead)?$data->amta_completedatead:'';
                                $completedatebs=!empty($data->amta_completedatebs)?$data->amta_completedatebs:'';
                                if(DEFAULT_DATEPICKER=='NP')
                                {
                                    $compdate=$completedatebs;
                                }
                                else
                                {
                                    $compdate=$completedatead;
                                }

                                if($ispmcomplete=='1'):
                                    echo '<label class="label label-success">Yes</label>';
                                    echo '<br>'.$compdate;
                                else:
                                    echo '<label class="label label-danger">No</label>';
                                endif;

                                ?>
                            </td>


                            <td><a href="javascript:void(0)" class="text-danger btnDelete" data-id="<?php echo $amctableid; ?>" data-deleteurl="<?php echo base_url('biomedical/amc_data/deleteamc_data');?>"><i class="fa fa-minus-square-o "></i></a>&nbsp;&nbsp;&nbsp;
                                <a href="javascript:void(0)" class="btnEditAMC" style="<?php echo $display;?>"  data-editid="<?php echo $amctableid; ?>"><i class="fa fa-edit" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;
                                <?php if($org_id=='2'){ ?>
                                    <a href="javascript:void(0)" class="isCompleteAMC" style="<?php echo $display;?>"  data-equipid="<?php echo !empty($eqli_data[0]->asen_asenid)?$eqli_data[0]->asen_asenid:'';?>" data-pmtaid="<?php echo $amctableid; ?>"><?php if($data->amta_isamccompleted == 0){ echo "Is Completed";}?></a>
                                <?php }else{ ?>
                                    <a href="javascript:void(0)" class="isCompleteAMC" style="<?php echo $display;?>"  data-equipid="<?php echo !empty($eqli_data[0]->bmin_equipid)?$eqli_data[0]->bmin_equipid:'';?>" data-pmtaid="<?php echo $amctableid; ?>"><?php if($data->amta_isamccompleted == 0){ echo "Is Completed";}?></a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                        $j++;
                    }
                }
                else{
                    $count = !empty($eqli_data[0]->riva_year)?$eqli_data[0]->riva_year:1;
                    $times=!empty($eqli_data[0]->riva_riskcount)?$eqli_data[0]->riva_riskcount:1;
                    $type=!empty($eqli_data[0]->riva_risktype)?$eqli_data[0]->riva_risktype:1;
                    $newDate = !empty($eqli_data[0]->bmin_endwarrantydatead)?$eqli_data[0]->bmin_endwarrantydatead:date('Y/m/d');
                    // echo $newDate;
                    if( $type==1)
                    {
                        $addmonth='+12 months';
                    }
                    if( $type==2)
                    {
                        $addmonth='+6 months';
                    }
                    if( $type==3)
                    {
                        $addmonth='+3 months';
                    }
                    if( $type==4)
                    {
                        $addmonth='+1 months';
                    }

                    $z=1;
                    for($i = 1; $i<=$count; $i++):
                       for($j = 1; $j<=$times; $j++):
                        $newDate = strtotime("$addmonth", strtotime($newDate)); 
                        $newDate = date('Y/m/d',$newDate);
                        if($newDate < $curdate){
                          $style = "color:#d00";
                          $status = "Expired";
                      }else{
                          $style = "color:#0f0";
                          $status = "Available";
                      }
                      $nth=$z.'th';
                      if($z==1)
                      {
                        $nth='1st';
                    }
                    if($z==2)
                    {
                        $nth='2nd';
                    }
                    if($z==3)
                    {
                        $nth='3rd';
                    }


                    $remarks=$nth. ' AMC';
                    ?>
                    <tr class="projectrow" id="projectrow_1" data-id="1">
                      <td>
                        <input type="text" id="amta_amcdatebs_1" name="amta_amcdate[]" class="form-control date <?php echo DATEPICKER_CLASS; ?> amta_amcdate" value="<?php echo CURDATE_NP; ?>" >
                        <span class="errmsg"></span>
                    </td>
                    <td colspan="3"><input type="text" id="amta_remarks_1" name="amta_remarks[]" value="" class="form-control amta_remarks" ></td>
                    <td>
                        <input type="text" id="amta_amcenddatebs_1" name="amta_amcenddate[]" class="form-control date <?php echo DATEPICKER_CLASS; ?> amta_amcenddate" value="<?php echo CURDATE_NP; ?>" >
                        <span class="errmsg"></span>
                    </td>
                    <td>
                        <input type="file" id="amta_amcfile_1" name="amta_amcfile[]" class="form-control amta_amcfile">
                        <span class="errmsg"></span>
                    </td>
                    <td></td>

                    
                    <td><div class="actionDiv" id="acDiv2_1"></div></td>
                </tr>
                <tbody id="addPM"></tbody>
                <tr> <td colspan="8"><a href="javascript:void(0)" class="add btn btn-success pull-right"><i class="fa fa-plus-square-o "></i></a></td></tr>
           
    
    <?php
    $z++; 
endfor;

endfor;
?>
</tbody>

<tbody>
               <!--  <tr>
                    <td>
                        <input type="hidden" id="amta_amcdatebs" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo $this->general->EngToNepDateConv($newDate); ?>">
                    </td>
                    <td colspan="3">
                        <input type="hidden" id="amta_remarks" value="" class="form-control">
                    </td>
                    <td>
                        <input type="hidden" id="amta_amcenddatebs" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo $this->general->EngToNepDateConv($newDate); ?>">
                    </td>
                   
                     <td>
                    <input type="file" id="amta_amcfile" name="amta_amcfile[]" class="form-control">
                    <span class="errmsg"></span>
                </td>
                <!-- <td></td>
                    <td><a href="javascript:void(0)" class="add btn btn-success"><i class="fa fa-plus-square-o "></i></a></td>
                -->
            </tr> 
        </tbody>
        <tbody id="addPM"></tbody>
        <tbody> 
            <tr>
                <td >   
                    <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($pmdata)?'update':'save' ?>'><?php echo !empty($pmdata)?'Update':'Save' ?></button>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
</div>
</div>
<div class="form-group">
    <div class="white-box">
        <h3 class="box-title"><?php echo $this->lang->line('comment_history'); ?></h3>
        <div class="table-responsive">
            <table id="" class="table flatTable tcTable compact_Table" >
                <thead>
                  <tr>
                      <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                      <th width="10%"><?php echo $this->lang->line('amc_date_AD'); ?></th>
                      <th width="10%"><?php echo $this->lang->line('amc_date_BS'); ?></th>
                      <th width="40%"><?php echo $this->lang->line('comments'); ?> </th>
                      <th width="25%"><?php echo $this->lang->line('comment_by'); ?></th>
                      <th width="10%"><?php echo $this->lang->line('status'); ?> </th>
                      <th width="5%"><?php echo $this->lang->line('action'); ?> </th>

                  </tr>
              </thead>
              <tbody>
                 <?php
                 if($equip_comment):
                    $i=1;
                    foreach ($equip_comment as $kc => $com):
                            // if($com->eqco_comment_status == 1)
                            // {
                            //     $penf = "Active"; 
                            //     $class='label-success';
                            // }
                            // else{ 
                            //     $penf = "Pending"; 
                            //     $class='label-danger';
                            // }
                       if($com->eqco_comment_status == 0)
                       {
                        $penf = "Pending"; 
                        $class='label-danger';
                    }
                    if($com->eqco_comment_status == 1){ 
                        $penf = "Completed"; 
                        $class='label-success';
                    }
                    if($com->eqco_comment_status == 2){ 
                        $penf = "Seen"; 
                        $class='label-info';
                    }
                    ?>
                    <tr id="listid_<?php echo $com->eqco_equipmentcommentid; ?>">
                      <td><?php echo $i; ?></td>
                      <td><?php echo $com->eqco_postdatead; ?></td>
                      <td><?php echo $com->eqco_postdatebs; ?></td>
                      <td><?php echo $com->eqco_comment; ?></td>
                      <td><?php echo $com->usma_fullname; ?></td>
                      <td><a href="javascript:void(0)" class=" label <?php echo $class; ?> btn-xs"><?php echo $penf  ?> </a></td>
                      <td>
                        <!--   <a href="javascript:void(0)"  title="Edit" data-id='<?php echo $com->eqco_equipmentcommentid; ?>' data-viewurl='<?php echo base_url('biomedical/bio_medical_inventory/edit_biomedical_comments') ?>'  class="btnEdit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> -->
                        <a href="javascript:void(0)" title="Cancel" data-id='<?php echo $com->eqco_equipmentcommentid; ?>' class="btnDelete" data-deleteurl="<?php echo base_url('biomedical/amc_data/deleteamc_data');?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                    </td>
                </tr>
                <?php
                $i++;
            endforeach;
        else:
            ?>
            <tr>
              <td colspan="6"><p class="text-danger text-center">Record Empty!!</p></td>
          </tr>
          <?php
      endif;
      ?>
  </tbody>
</table>
</div>
</div>

<div class="white-box">
    <h3 class="box-title"><?php echo $this->lang->line('repair_request_history'); ?></h3>
    <div class="table-responsive">
        <table id="" class="table flatTable tcTable compact_Table" >
            <thead>
              <tr>
                <th width="5%"><?php echo $this->lang->line('id'); ?></th>
                <th width="10%"><?php echo $this->lang->line('amc_date_AD'); ?></th>
                <th width="10%"><?php echo $this->lang->line('amc_date_BS'); ?></th>
                <th width="10%"><?php echo $this->lang->line('department'); ?></th>
                <th width="10%"><?php echo $this->lang->line('equipment_code'); ?></th>
                <th width="20%"><?php echo $this->lang->line('problem'); ?></th>
                <th width="20%"><?php echo $this->lang->line('action_taken'); ?></th>
                <th width="15%"><?php echo $this->lang->line('status'); ?></th>
                <th width="15%"><?php echo $this->lang->line('action'); ?></th>
            </tr>
        </thead>
        <tbody>
         <?php
         if($repair_comment):
            $i=1;
            foreach ($repair_comment as $kc => $com):
                if($com->rere_status == 1)
                {
                    $penf = "Completed"; 
                    $class='label-success';
                }
                else{ 
                    $penf = "Not Completed"; 
                    $class='label-danger';
                }
                ?>
                <tr id="listid_<?php echo $com->rere_repairrequestid; ?>">
                  <td><?php echo $i; ?></td>
                  <td><?php echo $com->rere_postdatead; ?></td>
                  <td><?php echo $com->rere_postdatebs; ?></td>
                  <td><?php echo $com->dein_department; ?></td>
                  <td><?php echo $com->bmin_equipmentkey; ?></td>
                  <td><?php echo $com->rere_problem; ?></td>
                  <td><?php echo $com->rere_action; ?></td>
                  <td><a href="javascript:void(0)" class=" label <?php echo $class; ?> btn-xs"><?php echo $penf  ?> </a></td>
                  <td>
                    <!--   <a href="javascript:void(0)"  title="Edit" data-id='<?php echo $com->rere_repairrequestid; ?>' data-viewurl='<?php echo base_url('biomedical/bio_medical_inventory/edit_biomedical_comments') ?>'  class="btnEdit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> -->
                    <a href="javascript:void(0)" title="Cancel" data-id='<?php echo $com->rere_repairrequestid; ?>' class="btnDelete" data-deleteurl="<?php echo base_url('biomedical/repair_request_info/delete_repairrequest');?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                </td>
            </tr>
            <?php
            $i++;
        endforeach;
    else:
        ?>
        <tr>
          <td colspan="6"><p class="text-danger text-center">Record Empty!!</p></td>
      </tr>
      <?php
  endif;
  ?>
</tbody>
</table>
</div>
</div>
</div>

<?php
   // $this->load->view('v_amc_editmodal');
?>

<!--   <div  class="waves-effect waves-light m-r-10 text-success success"></div>
    <div class="waves-effect waves-light m-r-10 text-danger error"></div>
    </form>
-->
<?php $this->load->view('biomedical/amc_data/v_amc_editmodal');
$this->load->view('biomedical/amc_data/v_amccompletedmodal');
?>
<script type="text/javascript">
    // $('.engdatepicker').datepicker({
    //   format: 'yyyy/mm/dd',
    //   autoclose: true
    // });
    
    // $('.nepdatepicker').nepaliDatePicker();
</script>
<script type="text/javascript">
    $(document).off('click','.add');
    $(document).on('click','.add',function(){

      // var trCount = $('tbody#addPM tr').length+2;
      var orderlen = $('.projectrow').length;
      var trCount = orderlen+1;
      if(trCount==2){
        $('.actionDiv').html('<a class="btnminus btn btn-danger" href="javascript:void(0)"><i class="fa fa-minus-square-o "></i></a>');
    }
    $('#addPM').append(
        '<tr class="projectrow" id="projectrow_' + trCount + '" data-id="' + trCount +
        '"><td><input type="text" name="amta_amcdate[]" class="form-control <?php echo DATEPICKER_CLASS; ?> amta_amcdate" id="amta_amcdatebs_'+trCount+'" value="<?php echo CURDATE_NP; ?>"/></td><td colspan="3"><input type="text" name="amta_remarks[]" class="form-control amta_remarks" id="amta_remarks_'+trCount+'" value=""/></td><td><input type="text" name="amta_amcenddate[]" class="form-control <?php echo DATEPICKER_CLASS; ?> amta_amcenddate" id="amta_amcenddatebs_'+trCount+'" value="<?php echo CURDATE_NP; ?>"/></td> <td><input type="file" name="amta_amcfile[]" class="form-control amta_amcfile" id="amta_amcfile_'+trCount+'"  value=""/></td><td>&nbsp;</td><td><a class="btnminus btn btn-danger" href="javascript:void(0)"><i class="fa fa-minus-square-o "></i></a></td></tr>'
        );
    $('#amta_remarks').val("");
});

    $(document).off('click', '.btnminus');
    $(document).on('click', '.btnminus', function() {
     var id = $(this).data('id');
     var whichtr = $(this).closest("tr");
     var conf = confirm('Are Your Want to Sure to remove?');
     if (conf) {

        var trplusOne = $('.projectrow').length + 1;
       whichtr.remove();

       setTimeout(function() {
         $(".projectrow").each(function(i, k) {
           var vali = i + 1;
           $(this).attr("id", "projectrow_" + vali);
           $(this).attr("data-id", vali);
           $(this).find('.amta_amcdate').attr("id", "amta_amcdate_" + vali);
           $(this).find('.amta_amcdate').attr("data-id", vali);
           $(this).find('.amta_remarks').attr("id", "amta_remarks_" + vali);
           $(this).find('.amta_remarks').attr("data-id", vali);
           $(this).find('.amta_amcenddate').attr("id", "amta_amcenddate_" + vali);
           $(this).find('.amta_amcenddate').attr("data-id", vali);
           $(this).find('.amta_amcfile').attr("id", "amta_amcfile_" + vali);
           $(this).find('.amta_amcfile').attr("data-id", vali);
       });
     }, 600);
       setTimeout(function() {
         // var trlength = $('.projectrow').length;
          var orderlen = $('.projectrow').length;
          // var trCount = orderlen+1;
               // alert(trlength);
               if (orderlen == 1) {
                 $('#acDiv2_1').html('');
             }
         }, 800);

   }
});

</script>
<script type="text/javascript">
    $(document).off('keyup','#noofvisiter_id');
    $(document).on('keyup','#noofvisiter_id',function(){
     // $("#addPM").on('click','.btnminus',function(){
     //    $(this).closest('tr').remove();
     //  });

      // var trCount = $('tbody#addPM tr').length+1;
      var orderlen = $('.projectrow').length;
      var trCount = orderlen+1;
      if(trCount==2){
        $('.actionDiv').html('<a class="btnminus btn btn-danger" href="javascript:void(0)"><i class="fa fa-minus-square-o "></i></a>');
    }

    var noofvisitor=$(this).val();
    if(noofvisitor >= 1){
       $('.actionDiv').html('<a class="btnminus btn btn-danger" href="javascript:void(0)"><i class="fa fa-minus-square-o "></i></a>');

   }
   if(noofvisitor == ''){
       $('#addPM').empty();

       $('.actionDiv').html('');
   }else{
      var input_field='<tr class="projectrow" id="projectrow_' + trCount + '" data-id="' + trCount +
      '"><td><input type="text" name="amta_amcdate[]" class="form-control <?php echo DATEPICKER_CLASS; ?> amta_amcdate" id="amta_amcdatebs_'+trCount+'" value="<?php echo CURDATE_NP; ?>"/></td><td colspan="3"><input type="text" name="amta_remarks[]" class="form-control amta_remarks " id="amta_remarks_'+trCount+'" value=""/></td><td><input type="text" name="amta_amcenddate[]" class="form-control <?php echo DATEPICKER_CLASS; ?> amta_amcenddate" id="amta_amcenddatebs_'+trCount+'" value="<?php echo CURDATE_NP; ?>"/></td> <td><input type="file" name="amta_amcfile[]" class="form-control amta_amcfile" id="amta_amcfile_'+trCount+'"  value=""/></td><td>&nbsp;</td><td><a class="btnminus btn btn-danger" href="javascript:void(0)"><i class="fa fa-minus-square-o "></i></a></td></tr>';

      for(i=1;i<noofvisitor;i++)
      {
        $('#addPM').append(input_field);
    }
}

$('#amta_remarks').val("");
});
    //  $(document).off('click','.btnminus');
    // $(document).on('click','.btnminus',function(){
    // var conf = confirm('Are Your Want to Sure to remove?');
    //  if (conf){
    // $(this).closest('tr').remove();
    
    //   setTimeout(function() {
    //     var trCount = $('tbody#addPM tr').length+1;
    //            // alert(trlength);
    //            if (trCount == 1) {
    //              $('.actionDiv').html('');
    //            }
    //          }, 800);

    //    }


    // });
</script>

<script type="text/javascript">
    $(document).off('click','.savePmCompleted');
    $(document).on('click','.savePmCompleted',function(){
        var formid=$('.save').closest('form').attr('id');
        alert(formid);
    });

    $(document).off('click','.btnEditAMC');
    $(document).on('click','.btnEditAMC',function(){
           //alert('hello'); 
           var id = $(this).data('editid');
           var mdatead = $.trim($(this).closest("tr").find('td:eq(0)').text());
           var mdatebs = $.trim($(this).closest("tr").find('td:eq(1)').text());
           var default_date='<?php echo DEFAULT_DATEPICKER; ?>';


           var mremarks = $.trim($(this).closest("tr").find('td:eq(2)').text());
           $('#modal_editid').val(id);
           if(default_date=='NP')
           {
               $('#modal_pmdatebs').val(mdatebs);
           }
           else
           {
               $('#modal_pmdatebs').val(mdatead);
           }

           $('#modal_remarks').val(mremarks);
           $('#myModal2').modal({
              show: true
          });
       });
   </script>

   <script>
    $(document).off('click','.nepdatepicker');
    $(document).on('click','.nepdatepicker',function(){
        $('.nepdatepicker').nepaliDatePicker();
    });
</script>

<script type="text/javascript">
  $(document).off('click','.isCompleteAMC');
  $(document).on('click','.isCompleteAMC',function(){
    $('#amcCompletedModal').modal('show');
    var equipid = $(this).data('equipid'); 
    var pmtaid = $(this).data('pmtaid');
      // alert(equipid);
      // return false;
      $('#equiPid').val(equipid);
      $('#pmtatable').val(pmtaid);
      $.ajax({
        type: "POST",
        url: base_url + 'biomedical/amc_data/get_amc_data_detail',
        data:{equipid:equipid, pmtaid:pmtaid},
        dataType: 'html',
        success: function(data) {
            datas = jQuery.parseJSON(data);   
            if(datas.status=='success') {

              $('#equipmentdetail').html(datas.template);
          }
      }
  })
  })
</script>
