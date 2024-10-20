<?php 
$this->load->view('common/equipment_detail');
?>
<form method="post" id="Formpmdata" action="<?php echo base_url('biomedical/pm_data/save_pm_data'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/pm_data/form_pm_data'); ?>' enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo !empty($pmdata[0]->riva_riskid)?$pmdata[0]->riva_riskid:'';  ?>">
    <input type="hidden" name="pmtableid" value="<?php echo !empty($pmdata[0]->pmta_pmtableid)?$pmdata[0]->pmta_pmtableid:''; ?>">
    <div class="clearfix"></div>
    <div class="clearfix"></div>
    <div class="pm_data_body">
        <div id="FormDiv_PmData" class="search_pm_data">
        </div>
    </div>
    <div class="clearfix"></div>
    <div  class="waves-effect waves-light m-r-10 text-success success"></div>
    <div class="waves-effect waves-light m-r-10 text-danger error"></div>
</form>
<div class="form-group">
    <div class="table-responsive">
        <table class="table table-border table-striped table-site-detail dataTable">
            <thead>
                <tr>
                    <th width="20%">PM Date</th>
                    <th colspan="3" width="25%" >Remarks</th>
                    <th width="10%">Status</th>
                    <th width="35%">File</th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
         
            <tbody>
                <?php
                $curdate = CURDATE_EN;
                $pmid = !empty($pmdata[0]->pmta_pmtableid)?$pmdata[0]->pmta_pmtableid:'';
                if(!empty($pmdata)){
                    ?>
                    <tr class="projectrow" id="projectrow_1" data-id="1">
                        <td>
                            <input type="text" name="pmta_pmdate[]" id="pmta_pmdatebs_1" class="form-control date <?php echo DATEPICKER_CLASS; ?> pmta_pmdate" value="<?php echo CURDATE_NP; ?>" >
                            <span class="errmsg"></span>
                        </td>
                        <td colspan="3"><input type="text" name="pmta_remarks[]" id="pmta_remarks_1" value="" class="form-control pmta_remarks" ></td>
                        <td>&nbsp;</td>
                        <td>
                            <input type="file" id="pmta_file_1" name="pmta_file[]" class="form-control pmta_file">

                        </td>

                        <td><div class="actionDiv" id="acDiv2_1"></div></td>
                    </tr>
                  
               
            </tbody>
   <?php if($pmdata):?>
                <tbody id="addPM"></tbody>
            <?php endif; ?>

              <tr> <td colspan="7"><a href="javascript:void(0)" class="add btn btn-success pull-right"><i class="fa fa-plus-square-o "></i></a></td></tr>

            <tr>
                <td colspan="7">   
                    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($pmdata)?'update':'save' ?>'><?php echo !empty($pmdata)?'Save':'' ?></button>
                </td>
            </tr>
            <thead>
                <tr>
                    <th colspan="7">PM History: </th>
                </tr>
                <tr>
                    <th>PM Date(AD) </th>
                    <th>PM Date(BS) </th>
                    <th>Remarks </th>
                    <th>Status </th>
                    <th>File </th>
                    <th>Is Comp. ?</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $j=1;
                foreach($pmdata as $data){ 
                    $newDate = !empty($data->pmta_pmdatead)?$data->pmta_pmdatead:'';
                    if($newDate < $curdate){
                        $style = "color:#d00";
                        $status = "Completed";
                        $display = "display:none;";
                    }else{
                        $style = "color:#0f0";
                        $status = "Available";
                        $display = "display:inline-block;";
                    }
                    $pmtableid = !empty($data->pmta_pmtableid)?$data->pmta_pmtableid:'';
                //$pmtableid = !empty($data->pmta_ispmcompleted)?$data->pmta_ispmcompleted:'';
                    ?>
                    <tr id="listid_<?php echo $pmtableid; ?>">
                        <td>
                            <?php echo !empty($data->pmta_pmdatead)?$data->pmta_pmdatead:'';?>
                        </td>
                        <td>
                            <?php echo !empty($data->pmta_pmdatebs)?$data->pmta_pmdatebs:'';?>
                        </td>
                        <td>
                            <?php echo !empty($data->pmta_remarks)?$data->pmta_remarks:'';?>
                        </td>
                        <td style="<?php echo $style; ?>"><?php echo $status; ?></td>
                        <td>
                         <?php if(!empty($data->pmta_file)): ?>
                          <a  href="<?php echo base_url().PM_UPLOAD_PATH.'/'?><?php echo !empty($data->pmta_file)?$data->pmta_file:'';?>" target="_blank" ><i class="fa fa-download" aria-hidden="true"  ></i></a>
                          <?php else: echo "File Not Uploaded";?>
                          <?php endif; ?>
                      </td>
                      <td>
                        <?php 
                        $ispmcomplete=!empty($data->pmta_ispmcompleted)?$data->pmta_ispmcompleted:'0';
                        $completedatead=!empty($data->pmta_completedatead)?$data->pmta_completedatead:'';
                        $completedatebs=!empty($data->pmta_completedatebs)?$data->pmta_completedatebs:'';
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



                    <td><a href="javascript:void(0)" class="text-danger btnDelete" data-id="<?php echo $pmtableid; ?>" data-deleteurl="<?php echo base_url('biomedical/pm_data/deletepm_data');?>"><i class="fa fa-minus-square-o "></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="javascript:void(0)" class="btnEditPM" style="<?php echo $display;?>"  data-editid="<?php echo $pmtableid; ?>"><i class="fa fa-edit" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="javascript:void(0)" class="isCompletePm" style="<?php echo $display;?>"  data-equipid="<?php echo !empty($eqli_data[0]->bmin_equipid)?$eqli_data[0]->bmin_equipid:'';?>" data-pmtaid="<?php echo $pmtableid; ?>"><?php if($data->pmta_ispmcompleted == 0){ echo "Is Completed";}?></a>
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


            $remarks=$nth. ' PM';
            ?>
            <tr class="projectrow" id="projectrow_1" data-id="1">
                <td>
                    <input type="text" name="pmta_pmdate[]" id="pmta_pmdatebs_1" class="form-control date <?php echo DATEPICKER_CLASS; ?> pmta_pmdate" value="<?php echo CURDATE_NP; ?>" >
                    <span class="errmsg"></span>
                </td>
                <td colspan="3"><input type="text" name="pmta_remarks[]" id="pmta_remarks_1" value="" class="form-control pmta_remarks" ></td>
                <td>&nbsp;</td>
                <td>
                    <input type="file" id="pmta_file_1" name="pmta_file[]" class="form-control pmta_file">

                </td>

                <td><div class="actionDiv" id="acDiv2_1"></div></td>
            </tr>
            <tbody id="addPM"></tbody>
            <tr> <td colspan="7"><a href="javascript:void(0)" class="add btn btn-success pull-right"><i class="fa fa-plus-square-o "></i></a></td></tr>
            <?php
            $z++; 
        endfor;

    endfor;
    ?>
</tbody>

<tbody>
    <tr>
                   <!--  <td>
                        <input type="hidden" id="pmta_pmdatebs_1" name="pmta_pmdatebs[]" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo $this->general->EngToNepDateConv($newDate); ?>">
                    </td>
                    <td colspan="3">
                        <input type="hidden" id="pmta_remarks_1" value=""name="pmta_remarks[]" class="form-control">
                    </td>
                    <td>&nbsp;</td>
                     <td>
                    <input type="file" id="pmta_file_1" name="pmta_file[]" class="form-control">
                    
                </td>
               
                    <td></td>
                    <td><a href="javascript:void(0)" class="add btn btn-success"><i class="fa fa-plus-square-o "></i></a></td> -->
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
        <h3 class="box-title">Comment History</h3>
        <div class="table-responsive">
            <table id="" class="table flatTable tcTable compact_Table" >
                <thead>
                  <tr>
                      <th width="5%">S.n.</th>
                      <th width="10%">Date(AD)</th>
                      <th width="10%">Date(BS)</th>
                      <th width="40%">Comments</th>
                      <th width="25%">Com. By</th>
                      <th width="10%">Status</th>
                      <th width="5%">Action</th>

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
                        <a href="javascript:void(0)" title="Cancel" data-id='<?php echo $com->eqco_equipmentcommentid; ?>' class="btnDelete" data-deleteurl="<?php echo base_url('biomedical/pm_data/deletepm_data');?>"><i class="fa fa-times" aria-hidden="true"></i></a>
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
    <h3 class="box-title">Repair Request History</h3>
    <div class="table-responsive">
        <table id="" class="table flatTable tcTable compact_Table" >
            <thead>
              <tr>
                <th width="5%">Id</th>
                <th width="10%">Date(AD)</th>
                <th width="10%">Date(BS)</th>
                <th width="10%">Dep</th>
                <th width="10%">Eq. Key</th>
                <th width="20%">Problem</th>
                <th width="20%">Action Taken</th>
                <th width="15%">Status</th>
                <th width="15%">Action</th>
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

<!--   <div  class="waves-effect waves-light m-r-10 text-success success"></div>
    <div class="waves-effect waves-light m-r-10 text-danger error"></div>
    </form>
-->
<?php $this->load->view('biomedical/pm_data/v_pm_editmodal');
$this->load->view('biomedical/pm_data/v_pmcompletedmodal');
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
       var orderlen = $('.projectrow').length;
       var trCount = orderlen+1;
// alert(trCount);
if (trCount == 2) {
 $('.actionDiv').html(
   '<a class="btnminus btn btn-danger" href="javascript:void(0)"><i class="fa fa-minus-square-o"></i></a>'
   );
}


$('#addPM').append(
    '<tr class="projectrow" id="projectrow_' + trCount + '" data-id="' + trCount +
    '"><td><input type="text" name="pmta_pmdate[]" class="form-control <?php echo DATEPICKER_CLASS; ?> pmta_pmdate" value="<?php echo CURDATE_NP; ?>" id="pmta_pmdatebs_'+trCount+'" /></td><td colspan="3"><input type="text" name="pmta_remarks[]" class="form-control pmta_remarks" id="pmta_remarks_'+trCount+'"/></td><td>&nbsp;</td><td><input type="file" name="pmta_file[]" class="form-control pmta_file" id="pmta_file_'+trCount+'"  /></td><td><a class="btnminus btn btn-danger" href="javascript:void(0)"><i class="fa fa-minus-square-o"></i></a></td></tr>'
    );
$('#pmta_remarks').val("");
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
           
           $(this).find('.pmta_pmdate').attr("id", "pmta_pmdatebs_" + vali);
           $(this).find('.pmta_pmdate').attr("data-id", vali);
           $(this).find('.pmta_remarks_').attr("id", "pmta_remarks_" + vali);
           $(this).find('.pmta_remarks_').attr("data-id", vali);
           $(this).find('.pmta_file').attr("id", "pmta_file_" + vali);
           $(this).find('.pmta_file').attr("data-id", vali);
       });
     }, 600);
       setTimeout(function() {
         var trlength = $('.projectrow').length;
               // alert(trlength);
               if (trlength == 1) {
                 $('#acDiv2_1').html('');
             }
         }, 800);

   }
});

</script>
<script type="text/javascript">
    $(document).off('click','.savePmCompleted');
    $(document).on('click','.savePmCompleted',function(){
        var formid=$('.save').closest('form').attr('id');
        alert(formid);
    })

    $(document).off('click','.btnEditPM');
    $(document).on('click','.btnEditPM',function(){
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
     $('#myModal1').modal({
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