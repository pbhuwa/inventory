<?php 
if($org_id=='2'){
$this->load->view('common/v_assets_detail');
}else{
$this->load->view('common/amc_equipment_detail');
}
?>
<form method="post" id="FormAssetinsurance" action="<?php echo base_url('ams/asset_insurance/save_asset_insurance'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('ams/asset_insurance'); ?>'>

    <input type="hidden" name="id" value="<?php echo !empty($pmdata[0]->riva_riskid)?$pmdata[0]->riva_riskid:'';  ?>">
    <input type="hidden" name="amctableid" value="<?php echo !empty($pmdata[0]->amta_amctableid)?$pmdata[0]->amta_amctableid:''; ?>">

    <input type="hidden" name="id" value="<?php echo !empty($asset_insurance_data[0]->asin_asinid)?$asset_insurance_data[0]->asin_asinid:'';  ?>">

    <div class="clearfix"></div>
    <div class="clearfix"></div>
    <div class="amc_data_body">
        <div id="FormDiv_PmData" class="search_amc_data">
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- <div  class="waves-effect waves-light m-r-10 text-success success"></div>
    <div class="waves-effect waves-light m-r-10 text-danger error"></div> -->
</form>
    <div class="form-group">
        <div class="col-sm-3 col-xs-3">
            <label for="example-text"><?php echo $this->lang->line('asset_insurance_name'); ?>:
            </label>
            <?php $asinid=!empty($asset_insurance_data[0]->asin_asinid)?$asset_insurance_data[0]->asin_asinid:''; ?>
                        <select name="asin_companyid" class="form-control" autofocus="true">
                            <option value="">----select---</option>
                            <?php if($insurance_company_all):
                                foreach ($insurance_company_all as $kd => $kinsurance):?>
                            <option value="<?php echo $kinsurance->inco_id; ?>" <?php if($asinid==$kinsurance->inco_id) echo 'selected=selected'; ?> >
                                <?php echo $kinsurance->inco_name; ?>
                            </option>
                            <?php endforeach; endif; ?>
                        </select>
                        <?=form_error('asin_asinid')?>
        </div>

        <div class="col-sm-3 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('asset_insurance_type'); ?>:
                        </label>
                        <?php $asinid=!empty($asset_insurance_data[0]->asin_asinid)?$asset_insurance_data[0]->asin_asinid:''; ?>
                        <select name="asin_typeid" class="form-control" autofocus="true">
                            <option value="">----select---</option>
                            <?php if($insurance_type_all):
                                foreach ($insurance_type_all as $kd => $kinsurance):?>
                            <option value="<?php echo $kinsurance->inty_intyid; ?>" <?php if($asinid==$kinsurance->inty_intyid) echo 'selected=selected'; ?> >
                                <?php echo $kinsurance->inty_name; ?>
                            </option>
                            <?php endforeach; endif; ?>
                        </select>
                        <?=form_error('asin_asinid')?>
        </div>

        <div class="col-sm-3 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('asset_insurance_code'); ?>:
            </label>
            <input type="text" id="example-text" name="asin_code" class="form-control" placeholder="<?php echo $this->lang->line('asset_insurance_code'); ?>" value="<?php echo !empty($asset_insurance_data[0]->asin_code)?$asset_insurance_data[0]->asin_code:''; ?>">
        </div>

        <div class="col-sm-3 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('asset_insurance_policy_no'); ?>:
            </label>
            <input type="text" id="example-text" name="asin_policyno" class="form-control" placeholder="<?php echo $this->lang->line('asset_insurance_policy_no'); ?>" value="<?php echo !empty($asset_insurance_data[0]->asin_policyno)?$asset_insurance_data[0]->asin_policyno:''; ?>">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-3 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('asset_insurance_amount'); ?>:
            </label>
            <input type="text" id="example-text" name="asin_insuranceamount" class="form-control" placeholder="<?php echo $this->lang->line('asset_insurance_amount'); ?>" value="<?php echo !empty($asset_insurance_data[0]->asin_insuranceamount)?$asset_insurance_data[0]->asin_insuranceamount:''; ?>">
        </div>

        <div class="col-sm-3 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('asset_insurance_rate'); ?>:
            </label>
            <input type="text" id="example-text" name="asin_insurancerate" class="form-control" placeholder="<?php echo $this->lang->line('asset_insurance_rate'); ?>" value="<?php echo !empty($asset_insurance_data[0]->asin_insurancerate)?$asset_insurance_data[0]->asin_insurancerate:''; ?>">
        </div>

        <div class="col-sm-3 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('start_date'); ?>: </label>
            <input type="text" id="asin_startdatead" name="asin_startdatead" class="form-control <?php echo DATEPICKER_CLASS; ?>" placeholder="" value="<?php echo !empty($asset_insurance_data[0]->asin_startdatead)?$asset_insurance_data[0]->asin_startdatead:DISPLAY_DATE; ?>">
        </div>

        <div class="col-sm-3 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('end_date'); ?>: </label>
            <input type="text" id="asin_enddatead" name="asin_enddatead" class="form-control <?php echo DATEPICKER_CLASS; ?>" placeholder="" value="<?php echo !empty($asset_insurance_data[0]->asin_enddatead)?$asset_insurance_data[0]->asin_enddatead:DISPLAY_DATE; ?>">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-3 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('renewal_date'); ?>: </label>
            <input type="text" id="asin_renewaldatead" name="asin_renewaldatead" class="form-control <?php echo DATEPICKER_CLASS; ?>" placeholder="" value="<?php echo !empty($asset_insurance_data[0]->asin_renewaldatead)?$asset_insurance_data[0]->asin_renewaldatead:DISPLAY_DATE; ?>">
        </div>

        <div class="col-sm-3 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('renewal_period'); ?>:
                        </label>
                        <?php $asinid=!empty($asset_insurance_data[0]->asin_asinid)?$asset_insurance_data[0]->asin_asinid:''; ?>
                        <select name="asin_renewalperiod" class="form-control" autofocus="true">
                            <option value="">----select---</option>
                            <?php if($renewalperiod_all):
                                foreach ($renewalperiod_all as $kd => $kperiod):?>
                            <option value="<?php echo $kperiod->peri_periid; ?>" <?php if($asinid==$kperiod->peri_periid) echo 'selected=selected'; ?> >
                                <?php echo $kperiod->peri_name; ?>
                            </option>
                            <?php endforeach; endif; ?>
                        </select>
                        <?=form_error('asin_asinid')?>
        </div>

<!--         <div class="col-sm-3 col-xs-6">
            <label for="example-text"><?php //echo $this->lang->line('is_active'); ?>:
            </label>
            <?php //$is_active=!empty($asset_insurance_data[0]->asin_isactive)?$asset_insurance_data[0]->asin_isactive:''; ?>
            <input type="radio" name="asin_isactive" value="Y" <?php if($is_active=='Y')// echo "checked='checked'"; ?>>Yes
            <input type="radio" name="asin_isactive" value="N" <?php if($is_active=='N')// echo "checked=checked";?>>No
        </div> -->
    </div>

    <br>  <br>  
    <div class="form-group">
        <div class="col-sm-6">
            <?php 
                $add_edit_status=!empty($edit_status)?$edit_status:0;
                $usergroup=$this->session->userdata(USER_GROUPCODE);
                   // echo $add_edit_status;
                if((empty($asset_insurance_data)) || (!empty($asset_insurance_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>
            <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($asset_insurance_data)?'update':'save' ?>' id="btnDeptment" ><?php echo !empty($asset_insurance_data)?$this->lang->line('update'):$this->lang->line('save') ?></button>
            <?php
                endif; ?>
        </div>
        <div class="col-sm-12">
            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
        </div>
    </div>

<!-- 
<div class="form-group">
    <div class="table-responsive">
    <table class="table table-border table-striped table-site-detail dataTable">
       
        <tr>
            <td colspan="6">   
                <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($pmdata)?'update':'save' ?>'><?php echo !empty($pmdata)?'Save':'' ?></button>
            </td>
        </tr>
    </table>
    </div>
</div>  -->

<!--   <div  class="waves-effect waves-light m-r-10 text-success success"></div>
    <div class="waves-effect waves-light m-r-10 text-danger error"></div>
    </form>
    -->
<!-- ?php $this->load->view('biomedical/amc_data/v_amc_editmodal');
    $this->load->view('biomedical/amc_data/v_amccompletedmodal');
    ?> -->
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
        '<tr><td><input type="text" name="amta_amcdate[]" class="form-control <?php echo DATEPICKER_CLASS; ?>" id="amta_amcdatebs_'+trCount+'" value="'+$('#amta_amcdatebs').val()+'"/></td><td colspan="3"><input type="text" name="amta_remarks[]" class="form-control"  value="'+$('#amta_remarks').val()+'"/></td><td>&nbsp;</td><td><a class="btnminus" href="javascript:void(0)"><i class="fa fa-minus-square-o "></i></a></td></tr>'
        );
      $('#amta_remarks').val("");
    });
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
