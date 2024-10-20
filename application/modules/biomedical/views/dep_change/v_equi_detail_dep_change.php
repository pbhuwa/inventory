<ul class="pm_data pm_data_body">
     <li>
        <label>Equipment Key</label>
        <?php echo !empty($eqli_data[0]->bmin_equipmentkey)?$eqli_data[0]->bmin_equipmentkey:'';?>
    </li>

    <li>
        <input type="hidden" name="pmta_equipid" value="<?php echo !empty($eqli_data[0]->bmin_equipid)?$eqli_data[0]->bmin_equipid:'';?>">
        <label> Description</label>
        <?php echo !empty($eqli_data[0]->eqli_description)?$eqli_data[0]->eqli_description:'';?>
    </li>
    <li>
        <label>Model Number</label>
        <?php echo !empty($eqli_data[0]->bmin_modelno)?$eqli_data[0]->bmin_modelno:'';?>
    </li>
    <li>
        <label>Serial Number</label>
        <?php echo !empty($eqli_data[0]->bmin_serialno)?$eqli_data[0]->bmin_serialno:'';?>
    </li>
    
     <li>
        <label>Department</label>
        <?php echo !empty($eqli_data[0]->dein_department)?$eqli_data[0]->dein_department:'';?>
    </li>

     <li>
        <label>Room</label>
        <?php echo !empty($eqli_data[0]->rode_roomname)?$eqli_data[0]->rode_roomname:'';?>
    </li>

     <li>
        <label>Equip.Operation</label>
        <?php echo !empty($eqli_data[0]->bmin_equip_oper)?$eqli_data[0]->bmin_equip_oper:'';?>
    </li>

     <li>
        <label>Manufacturer</label>
        <?php echo !empty($eqli_data[0]->manu_manlst)?$eqli_data[0]->manu_manlst:'';?>
    </li>

     <li>
        <label>Distributers</label>
        <?php echo !empty($eqli_data[0]->dist_distributor)?$eqli_data[0]->dist_distributor:'';?>
    </li>
     <li>
        <label>AMC</label>
        <?php echo !empty($eqli_data[0]->bmin_amc)?$eqli_data[0]->bmin_amc:'';?>
    </li>
     <li>
        <label>Service St. Date</label>
        
<?php echo !empty($eqli_data[0]->bmin_servicedatead)?$eqli_data[0]->bmin_servicedatead:''; ?>(AD)/
   <?php echo !empty($eqli_data[0]->bmin_servicedatebs)?$eqli_data[0]->bmin_servicedatebs:''; ?>(BS)    

        
    </li>
    <li>
        <label>End Warr. Date</label>
        <?php echo !empty($eqli_data[0]->bmin_endwarrantydatead)?$eqli_data[0]->bmin_endwarrantydatead:'';?>(AD)/
         <?php echo !empty($eqli_data[0]->bmin_endwarrantydatebs)?$eqli_data[0]->bmin_endwarrantydatebs:''; ?>(BS)    
    </li>
   <li>
        <label>Risk Value</label>
        <?php echo !empty($eqli_data[0]->riva_risk)?$eqli_data[0]->riva_risk:'';?>
    </li>
   
    <li>
        <label> Accessories</label>
        <?php echo !empty($eqli_data[0]->bmin_accessories)?$eqli_data[0]->bmin_accessories:'';?>
    </li>
    <li>
        <label> Comments</label>
        <?php echo !empty($eqli_data[0]->bmin_comments)?$eqli_data[0]->bmin_comments:'';?>
    </li>
   
    
</ul>
<form method="post" id="Formpmdata" action="<?php echo base_url('biomedical/dep_change/save_dep_change'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/dep_change/get_dep_change_log'); ?>'>
  <input type="hidden" name="eqdc_equipid" value="<?php echo !empty($equid)?$equid:''; ?>">


    <div class="clearfix"></div>
    <div class="">
     <div class="row">
        <div class="form-group">
       <div class="col-md-3 col-sm-6 col-xs-6">
      <label for="example-text">Department <span class="required">*</span>:</label>

      <?php 
      $bmin_departmentid=!empty($equip_data[0]->bmin_departmentid)?$equip_data[0]->bmin_departmentid:'';
      // echo $deptype;
      // die();
      ?>

      <select name="eqdc_newdepid" class="form-control " id="departmentid">
        <option value="">---select---</option>

        <?php if($dep_information):
        foreach ($dep_information as $kdi => $depin):?>

        <option value="<?php echo $depin->dept_depid; ?>" <?php if($bmin_departmentid==$depin->dept_depid) echo 'selected=selected'; ?>><?php echo $depin->dept_depname; ?></option>

        <?php endforeach; endif; ?>
      </select>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6">
      <label for="example-text">Room:</label>
      <select name="eqdc_newroomid" class="form-control" id="bmin_roomid">
        <option value="">---select---</option>
      </select>
    </div>

     <div class="col-md-3 col-sm-6 col-xs-6">
      <label for="example-text">Change Date:</label>
    <input type="text" name="eqdc_date" value="<?php echo DISPLAY_DATE; ?>" class="form-control <?php echo DATEPICKER_CLASS; ?>" >
    </div>

    <div class="col-md-2">
                            <label for="">&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-info  save mtop_0" data-againsrch='Y' data-isdismiss="Y">Save</button>
                            </div>
                        </div>

        </div>
         <div class="clearfix"></div>
 <div class="form-group">
    <div  class="waves-effect waves-light m-r-10 text-success success"></div>
    <div class="waves-effect waves-light m-r-10 text-danger error"></div>
 </div>
    
    </div>
    

    
</form>


<div class="form-group">

  <div class="white-box">
     <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
   <div id="TableDiv">
       <?php echo $this->load->view('v_dep_change_log'); ?>
    </div>
  </div>

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
                            if($com->eqco_comment_status == 1)
                            {
                                $penf = "Active"; 
                                $class='label-success';
                            }
                            else{ 
                                $penf = "Pending"; 
                                $class='label-danger';
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
                      <td><?php echo !empty($com->dept_depname)?$com->dept_depname:''; ?></td>
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
                  <td colspan="9"><p class="text-danger text-center">Record Empty!!</p></td>
                </tr>
                <?php
                endif;
               ?>
            </tbody>
        </table>
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
      $("#addPM").on('click','.btnminus',function(){
        $(this).closest('tr').remove();
      });

      var trCount = $('tbody#addPM tr').length+2;
      // alert(trCount);

      $('#addPM').append(
        '<tr><td><input type="text" name="pmta_pmdate[]" class="form-control <?php echo DATEPICKER_CLASS; ?>" id="pmta_pmdatebs_'+trCount+'" value="'+$('#pmta_pmdatebs').val()+'"/></td><td><input type="text" name="pmta_remarks[]" class="form-control"  value="'+$('#pmta_remarks').val()+'"/></td><td>&nbsp;</td><td><a class="btnminus" href="javascript:void(0)"><i class="fa fa-minus-square-o "></i></a></td></tr>'
        );
      $('#pmta_remarks').val("");
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
        var mdate = $.trim($(this).closest("tr").find('td:eq(0)').text());
        var mremarks = $.trim($(this).closest("tr").find('td:eq(1)').text());
        $('#modal_editid').val(id);
        $('#modal_pmdatebs').val(mdate);
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

