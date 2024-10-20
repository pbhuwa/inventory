
<form action="" method="post" id="depChange" class="mbtm_10">
    <div class="row">
    <div class="col-md-2 col-sm-3 mtop_5 ">
        <label for="example-text">Equipment ID: </label>
    </div>
    <div class="col-md-8 col-sm-6">
        <input type="text" id="id" autocomplete="off" name="equid" value="" class="form-control searchText" placeholder="Enter Equipment ID" data-srchurl="<?php echo base_url(); ?>/biomedical/bio_medical_inventory/list_of_equipment_inv">
        <div class="DisplayBlock" id="DisplayBlock_id"></div>

        </div>

    <!-- </div> -->
    <div class="col-md-2 col-sm-3">
        <div>
            <button type="button" id="searchPmdata" data-viewurl='<?php echo base_url('biomedical/dep_change/get_equdatadetail_depchange') ?>' class="btn btn-success btnEdit mtop_0 againSearch" data-displaydiv='depChange'>Search</button>
        </div>
    </div>
  </div>
</form>


  <div class="clearfix"></div>
    <div class="">
        <div id="FormDiv_depChange" class="search_pm_data">
        </div>
    </div>

  <div class="clearfix"></div>


  <div  class="text-success success"></div>
 <div class="text-danger error"></div>
</form>

<script type="text/javascript">

  $(document).on('change','#equid',function(){
    var equid=$(this).val();
    var action=base_url+'biomedical/pm_data/get_equdata'
    // alert(equid);
    $.ajax({
      type: "POST",
      url: action,
      data:{equid:equid},
       dataType: 'json',
      success: function(datas) //we're calling the response json array 'cities'
      {
        // console.log(datas);
         // data = jQuery.parseJSON(datas);
        console.log(datas);  
        if(datas.status=='success')
        {  
          var description = datas.eqli_data[0].bmin_descriptionid;
          var department = datas.eqli_data[0].bmin_comments;
          var riskid = datas.eqli_data[0].bmin_riskid;

          $('#description').val(description);
          $('#department').val(department);
          if(riskid)
          {
            $('#risk_id').val(riskid);
          }
          else
          {
            $('#risk_id').val(0);
          }
        } 
        else
        {
          $('#description').val('');
          $('#department').val('');
          $('#risk_id').val('');
        }
      }
    });
  })
</script>
