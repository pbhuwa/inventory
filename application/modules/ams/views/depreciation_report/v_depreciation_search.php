<div class="white-box">
  <h3 class="box-title">Depreciation Report</h3>
  <div class="searchWrapper">
    <div class="pad-5">
      <form id="depreciation_search">

        <div class="form-group">

          <div class="row">

            <div class="form-group resp_xs">
             <?php $this->general->location_option(2); ?>
             <div class="col-md-2 col-sm-4">
              <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?>:<span class="required">*</span>:</label>
              <select id="fiscal_year" name="fiscal_year"  class="form-control required_field" >
                <option value="">----- All-----</option>
                <?php 
                if($fiscalyear):
                  foreach ($fiscalyear as $km => $dep):
                    ?>
                    <option value="<?php echo $dep->fiye_name; ?>" ><?php echo $dep->fiye_name; ?></option>
                    <?php
                  endforeach;
                endif;
                ?>
              </select>
            </div>

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
            <div class="col-sm-2 col-xs-6">
              <div class="form-group">
                <label>Assets Items<span class="required">*</span>:</label>

                <select class="form-control" name="asen_asenid" id="result_assettypeid">
                  <option value=" ">---All---</option>
                </select>
              </div>
            </div> 

            <div class="col-md-2">
              <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="ams/depreciation_reports/search_depreciation"><?php echo $this->lang->line('search'); ?></button>
            </div>
            <!-- <div style="margin: 10">
              <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="ams/depreciation_report/v_depreciation_list" data-location="ams/depreciation_reports/exportToExcelDirect" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

              <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="ams/depreciation_report/v_depreciation_list" data-location="ams/depreciation_reports/generate_pdfDirect" data-tableid="#myTable"><i class="fa fa-print"></i></a>
            </div> -->
          </div>
        </div>
      </form>
    </div></div>
    <div class="clearfix"></div>
    <div id="displayReportDiv"></div>
  </div>



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



