<form method="post" id="FormPurchase" action="<?php echo base_url('biomedical/risk_value/save_risk_value'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/risk_value/form_risk_value'); ?>'>
    <input type="hidden" name="id" value="<?php echo!empty($risk_data[0]->riva_riskid)?$risk_data[0]->riva_riskid:'';  ?>">
    <div class="form-group resp_xs">
      <div class="col-sm-6 col-xs-6">
         <label for="example-text">Risk Year <span class="required">*</span>:
            </label>
               <input type="text"  name="riva_year" id="riva_year" class="form-control number change" placeholder="Risk Year" value="<?php echo !empty($risk_data[0]->riva_year)?$risk_data[0]->riva_year:''; ?>"  autofocus="true">
               <span>Eg.1,2,3</span>

        </div>
         <div class="col-sm-6 col-xs-6">
         <label for="example-text">Risk Type <span class="required">*</span> :
            </label>
              <select name="riva_risktype" class="form-control change" id="riva_risktype">
                <?php 
                  if (!empty($risk_data[0]->riva_risktype))
                      {
                        $risktypeid=$risk_data[0]->riva_risktype;
                ?>
                <option value="<?php echo $risktypeid;?>">
                  <?php
                    if ($risktypeid==1)
                    echo "Annual";
                    else if ($risktypeid==2)
                      echo "Semi-Annual";
                    else if ($risktypeid==3)
                      echo "Quarter";
                    else if ($risktypeid==4)
                      echo "Monthly";
                  ?>
                  <?php
                    }
                  ?>
                <option value="">---select---</option>
                <option value="1">Annual</option>
                <option value="2">Semi-Annual</option>
                <option value="3">Quarter</option>
                <option value="4">Monthly</option>
                
              </select>

        </div>
        <div class="clearfix"></div>

        <div class="col-sm-6 col-xs-6">
         <label for="example-text">Risk<span class="required">*</span> :</label>
               <input type="text"  name="riva_risk" id="riva_risk" class="form-control" placeholder="Risk Value" value="<?php echo !empty($risk_data[0]->riva_risk)?$risk_data[0]->riva_risk:''; ?>" readonly >

        </div>

         <div class="col-sm-6 col-xs-6">
         <label for="example-text">Risk Count :
            </label>
               <input type="text"  name="riva_riskcount" id="riva_riskcount" class="form-control number change" placeholder="Risk Count" value="<?php echo !empty($risk_data[0]->riva_riskcount)?$risk_data[0]->riva_riskcount:''; ?>" readonly >

        </div>
        <div class="clearfix"></div>
          <div class="col-sm-6 col-xs-6">
         <label for="example-text">Total Times <span class="required">*</span> :
            </label>
               <input type="text"  name="riva_times" id="riva_times" class="form-control number" placeholder="Times" value="<?php echo !empty($risk_data[0]->riva_times)?$risk_data[0]->riva_times:''; ?>" readonly >

        </div>
        <div class="clearfix"></div>
        <div class="col-sm-12">
         <label for="example-text">Comments <span class="required">*</span> :
            </label>
         
            <textarea name="riva_comments" class="form-control" placeholder="Comments" style="height: 50px;"><?php echo !empty($risk_data[0]->riva_comments)?$risk_data[0]->riva_comments:''; ?></textarea>
             
        </div>
    </div>

    <?php 
        $add_edit_status=!empty($edit_status)?$edit_status:0;
        $usergroup=$this->session->userdata(USER_GROUPCODE);
        // echo $add_edit_status;
        if((empty($risk_data)) || (!empty($risk_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>
        <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($risk_data)?'update':'save' ?>' id="btnDeptment" ><?php echo !empty($risk_data)?'Update':'Save' ?></button>
          <?php
           endif; ?>
       <div  class=" alert-success success"></div>
      <div class=" alert-danger error"></div>
</form>

<script type="text/javascript">
   $(document).on('keyup change' ,'.change',function()
      {
//         riva_year
// riva_risktype

// riva_riskcount
// riva_times
        var riva_year=$('#riva_year').val();
        var risk_gen='';
        var risk_time_gen=0;
        var times=0;

        var riva_risktype=$('#riva_risktype').val();
        var risktyp=$('#riva_risktype').find(":selected").text();
        if(riva_risktype==1)
        {
          risk_time_gen=1;
          risk_gen=riva_year+'Y '+'Annual';

        }
         if(riva_risktype==2)
        {
          risk_time_gen=2;
          risk_gen=riva_year+'Y '+'Semi-annual';
        }
         if(riva_risktype==3)
        {
          risk_time_gen=4;
           risk_gen=riva_year+'Y '+'Quater';
        }
         if(riva_risktype==4)
        {
          risk_time_gen=12;
          risk_gen=riva_year+'Y '+'Monthly';
        }

        // var riva_risk=$('#Times').find(":selected").text();
        // alert(Times);
        var riva_riskcount=$('#riva_riskcount').val(risk_time_gen);
        // alert(riva_year);
        // alert(riva_risktype);
        // alert(riva_riskcount);
        if(riva_year)
        { 
          times=riva_year*risk_time_gen;
        }
        $('#riva_risk').val(risk_gen);
        $('#riva_times').val(times);
        
        

        // $('#medAdvice').val(medDose+' '+medUnit+' X '+medTime+' Times a '+medPer+' ('+Times+') X '+medDay);

      });
</script>