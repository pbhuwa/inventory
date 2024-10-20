   <form method="post" id="frm_depr_Calculator" class="form-material form-horizontal form" action="" >
      <div class="clearfix"></div>
      <div class="white-box">
         <h3 class="box-title"><?php echo $this->lang->line('depreciation_calculator_demo_test'); ?></h3>
         <div class="pad-10">
            <div class="form-group resp_xs">
               
             
              
               <div id="depdiv" style="">
                  <div class="col-sm-2 col-xs-6">
                  <label for=""><?php echo $this->lang->line('purchase_cost'); ?>:</label>
                  <input type="text" name="dep_purchase_cost" class="form-control" id="dep_purchase_cost">
                  </div>
               
                <div class="col-sm-2 col-xs-6" id="div_salv">
                  <label for=""><?php echo $this->lang->line('salvage_value'); ?>:</label>
                  <input type="text" name="dep_salvage_cost" class="form-control" id="dep_salvage_cost">
                  </div>

                     <div class="col-sm-2 col-xs-6">
                  <label for=""><?php echo $this->lang->line('useful_life_value'); ?>:</label>
                  <input type="text" name="dep_life_start" class="form-control <?php echo DATEPICKER_CLASS;?> date" placeholder="" id="dep_life_start" value="<?php echo DISPLAY_DATE; ?>">
                  </div>

                  
                   <div class="col-sm-2 col-xs-6">
                  <label for=""><?php echo $this->lang->line('useful_life'); ?>(In Years):</label>
                  <input type="text" name="dep_life" class="form-control " id="dep_life">
                  </div>

                 

                 <!--  <div class="col-sm-2 col-xs-6">
                  <label for="">Useful Life End:</label>
                  <input type="text" name="dep_life_end" class="form-control <?php echo DATEPICKER_CLASS;?> date" placeholder="" id="dep_life_end" value="<?php echo DISPLAY_DATE; ?>">
                  </div>
                -->
                  <div class="col-sm-2 col-xs-6">
                  <label for=""><?php echo $this->lang->line('depreciation_method'); ?>:</label>
                      <?php $db_asen_depreciation=!empty($assets_data[0]->asen_depreciation)?$assets_data[0]->asen_depreciation:'';
                        ?>
                   <select class="form-control" id="dep_type" name="asen_depreciation">
                     <option value="">---select---</option>

                      <?php 
                    if($depreciation):

                    foreach ($depreciation as $kcl => $dep):
                    ?>

                    <option value="<?php echo $dep->dety_depreciationid; ?>"> <?php echo $dep->dety_depreciation; ?></option>

                    <?php
                    endforeach;
                    endif;
                    ?>
                  </select>
                  </div>
               

              </div>
              

    

               <div class="col-sm-2 col-xs-6">
                  <label for="">&nbsp;</label>
                  <div>
                     <button type="submit" class="btn btn-info btnCalculate">Calculate</button>
                  </div>
               </div>
                <div class="clearfix"></div>
                
                <div id="unit_of_dep_fields"></div>
               </div>
                
               </div>
            </div>

           
            <div class="clearfix"></div>
            <div id="displayReportDiv">
  
             
            </div>
         </div>
      </div>
      <div id="ResponseSuccess" class="waves-effect waves-light m-r-Y0 text-success"></div>
      <div id="ResponseError" class="waves-effect waves-light m-r-Y0 text-danger"></div>
   </form>


<script type="text/javascript">
  $(document).ready(function(){
    $('#dep_formula').hide();

    });

 
</script>

<script type="text/javascript">
  $(document).on('click','.btnCalculate',function(){
     var datastring = $("#frm_depr_Calculator").serialize();
     
     $('#displayReportDiv').hide();

     var depType=$('#dep_type').val();
     if (depType==1)
     {
      var action=base_url+'ams/Depreciation_calculator/st_dep_calc';
     }
     else if (depType==2)
     {
      var action=base_url+'ams/Depreciation_calculator/ddb_dep_calc';
     }
     else if (depType==3)
     {
      var action=base_url+'ams/Depreciation_calculator/up_dep_calc';
     }
     else if (depType==4)
     {
      var action=base_url+'ams/Depreciation_calculator/soy_dep_calc';
     }
     $.ajax({
          type: "POST",
          url: action,
           data: datastring,
          dataType: 'html',
        success: function(datas) 
          {
            console.log(datas);
            data = jQuery.parseJSON(datas);   

                if(data.status=='success')
                {
                    $('#displayReportDiv').html(data.template);
                        $('#displayReportDiv').show();
                }
                else
                {
                   $('#displayReportDiv').html('<span class="col-sm-6 alert alert-danger text-center">'+data.message+'</span>');
                   $('#displayReportDiv').show();
                    // alert(data.message);
                }
                 $('.overlay').modal('hide');
          }
      });
     //alert ('test');
     return false;

    })
</script>

<script type="text/javascript">
    $(document).off('change','#dep_type');
    $(document).on('change','#dep_type',function(){
        $('#unit_of_dep_fields').empty();
         $('#displayReportDiv').hide();
        var dep_type = $('#dep_type').val();
        var dep_life = $('#dep_life').val();

        if(dep_type == '3')
        {
            var input_field = '<div class="col-sm-2" style="margin-top:10px;"><label for="">Unit of Productions :</label><input type="text" name=unit[] class="form-control" /></div>';

            for(i=1;i<=dep_life;i++)
            {
                $('#unit_of_dep_fields').append(input_field);
            }

        }
         if(dep_type == '2')
        {
         document.getElementById("div_salv").value = "";
         $('#div_salv').hide();
        }
        else 
        {
          $('#div_salv').show();
        }

    });
</script>

<script type="text/javascript">
      $('.engdatepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });
    $('.nepdatepicker').nepaliDatePicker();
</script>