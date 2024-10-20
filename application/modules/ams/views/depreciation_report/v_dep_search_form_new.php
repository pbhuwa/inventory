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
                </div>
                <div class="form-group resp_xs">
                <div id="datediv" style="">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                           
                            <table class="table table-striped dataTable tbl_pdf">
                                <tr>
                                    <th>S.n</th>
                                    <th>Category Name</th>
                                    <th>No. Of. Asset</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                 <?php 
                                 $i=1;
                                    if($material):
                                        foreach ($material as $kcl => $mat):
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $mat->eqca_category; ?></td>
                                     <td><?php echo $mat->cnt; ?></td>
                                     <td></td>
                                     <td><a href="javascript:void(0)" class="btn btn-sm btn-primary btnGenerate" data-catid="<?php echo $mat->eqca_equipmentcategoryid; ?>">Generate</a></td>
                                </tr>
                               
                            <?php
                            $i++;
                                        endforeach;
                                    endif;
                            ?>
                            </table>
                          
                        </div>
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
        var locationid=$('#locationid').val();
        var dep_type=$('#dep_type').val();
        var asen_assettype=$(this).data('catid');
        
        var dtype=$(this).data('type');
        var action=base_url+'/ams/depreciation_reports/generate_depreciation_report_main';
        $.ajax({
            type: "POST",
            url: action,
            // data:$('#reportGeneration').serialize(),
            data:{asen_assettype:asen_assettype,locationname:locationid,asen_depreciation:dep_type,dtype:dtype},
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