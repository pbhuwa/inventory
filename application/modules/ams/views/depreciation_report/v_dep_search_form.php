<form method="post" id="reportGeneration" action="" class="form-material form-horizontal form" >
    <div class="clearfix"></div>
    <div class="white-box">
        <div class="pad-10">
            <div class="form-group resp_xs">
                  <div class="col-sm-2 col-xs-6">
                        <div class="form-group">
                            <?php $this->general->location_option(12); ?>
                        </div>
                    </div>
                     <div class="col-sm-2 col-xs-6">
                        <div class="form-group">
                            <label>Depreciation Method:</label>
                            <select class="form-control" id="dep_type" name="asen_depreciation">
                                <option value="0">---select---</option>
                                <?php 
                                    if($depreciation):
                                        foreach ($depreciation as $kcl => $dep):
                                ?>
                                <option value="<?php echo $dep->dety_depreciationid; ?>" > <?php echo $dep->dety_depreciation; ?></option>
                                <?php
                                        endforeach;
                                    endif;
                                ?>
                            </select>
                        </div>
                    </div>
                <div id="datediv" style="">
                    <div class="col-sm-2 col-xs-6">
                        <div class="form-group">
                            <label>Assets Type  <span class="required">*</span>:</label>
                            <select class="form-control change_assets" name="asen_assettype" id="assettypeid"  data-srchurl='<?php echo base_url('ams/assets/get_assets_item_by_assets_type');?>' >
                                <option value="">---All---</option>
                                <?php 
                                    if($material):
                                        foreach ($material as $kcl => $mat):
                                ?>
                                <option value="<?php echo $mat->eqca_equipmentcategoryid; ?>"> <?php echo $mat->eqca_category; ?></option>
                            <?php
                                        endforeach;
                                    endif;
                            ?>
                            </select>
                        </div>
                    </div>
                     <div class="col-sm-4 col-xs-6">
                        <div class="form-group">
                            <label>Assets Items<span class="required">*</span>:</label>
                            
                            <select class="form-control" name="asen_asenid" id="assetid">
                                <option value="0">---All---</option>
                            </select>
                        </div>
                    </div>

                  
                    
                   
                </div>

                <!--  <div class="col-md-3">
                  <div id="showmore">

                  </div>
               </div> -->

                <div class="col-sm-2 col-xs-6">
                    <label for="">&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-info btnGenerate" data-type='totalgen'>Total Generate</button>
                        </div>
                         <div>
                            <button type="submit" class="btn btn-info btnGenerate" data-type='partialgen'>Partial Generate</button>
                        </div>
                </div>
                <div class="clearfix"></div>
                
                <div id="ItemRpt"></div>
                
            </div>
        </div>

        <div class="clearfix"></div>
    </div>
    <div id="ResponseSuccess" class="waves-effect waves-light m-r-Y0 text-success"></div>
    <div id="ResponseError" class="waves-effect waves-light m-r-Y0 text-danger"></div>
</form>

<script type="text/javascript">
    $(document).off('click','.btnGenerate');
    $(document).on('click','.btnGenerate',function() {
        var assettype=$('#assettypeid').val();
        var locationid=$('#locationid').val();
        var dep_type=$('#dep_type').val();
        var assetid=$('#assetid').val();
        
        var dtype=$(this).data('type');
        var action=base_url+'/ams/depreciation_reports/generate_depreciation_report';
        $.ajax({
            type: "POST",
            url: action,
            // data:$('#reportGeneration').serialize(),
            data:{asen_assettype:assettype,locationname:locationid,asen_depreciation:dep_type,asen_asenid:assetid,dtype:dtype},
            dataType: 'html',
            beforeSend: function() {
                $('#ItemRpt').html('Please Waiting ......');
            },
            success: function(jsons) 
            {
               $('#ItemRpt').html('');
                console.log(jsons);
                data = jQuery.parseJSON(jsons);   
                // alert(data.status);
                if(data.status=='success')
                {
                    // $('#Subtype').html(data.tempform);
                    // $('#ItemRpt').html(data.tempform);
                    // if(rptSelected != null){
                    //     $('#rptTypeSelect').html(rptSelected);
                    // }
                    // if(rptChecked != null){
                    //     $('#rptTypeCheck').html(rptChecked);
                    // }
                    // $('#rptType').html(reportType);
                    // $('.overlay').modal('hide');

                    $("#ResponseSuccess").css("display","block");
                    $("#ResponseSuccess" ).addClass( "alert alert-success" );
                    $("#ResponseSuccess" ).html(data.message);
                }
                else
                {
                    // alert(data.message);
                    $("#ResponseError").css("display","block");
                    $( "#ResponseError" ).addClass( "alert alert-danger" );
                    $( "#ResponseError" ).html(data.message);
                }

                setTimeout(function(){
              //remove class and html contents
                    $("#ResponseSuccess").html('');
                    $("#ResponseSuccess").css("display", "none");
                    },4000);
            }
        });
        return false;
    })
</script>

<script type="text/javascript">
$(document).off('change','.change_assets');
$(document).on('change','.change_assets',function(){
var attrid=$(this).attr('id');
var locid=$('#locationid').val();
var id=$(this).val();
var srchurl=$(this).data('srchurl');
$.ajax({
  type: "POST",
  url: srchurl,
  data:{id:id,locid:locid},
  dataType: 'html',
  beforeSend: function() {
    $('.overlay').modal('show');
  },
   success: function(jsons) 
   {
      // console.log(jsons);
      var jsondata=jQuery.parseJSON(jsons);   
      // return false;
      // console.log(jsondata.data);
      if(jsondata.status=='success')
      {
        $('#result_'+attrid).html(jsondata.template);
        $('#result_'+attrid).select2();

      }
      else
      {
        $('#result_'+attrid).html('');
      }
      
       $('.overlay').modal('hide');
    }
  })

})
</script>