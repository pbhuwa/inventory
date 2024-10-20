<div class="white-box ov_report">

  <form method="post" id="reportOverview" action="" class="form-material form-horizontal form mbtm_0" data-reloadurl='<?php echo base_url('settings/scheme/form_scheme'); ?>'>

    <div class="form-group mbtm_0">

      <div class="col-md-1 mtop_5">

        <label for="example-text">Assets Code: </label>

      </div>

      <div class="col-sm-6">

        <?php $assets_code = !empty($assets_code) ? $assets_code : '';

        ?>

        <div class="dis_tab">

          <input type="text" id="id" name="assetsid" value="<?php echo !empty($assets_code) ? $assets_code : ''; ?>" class="form-control " placeholder="Enter Assets Code">

          <span class="input-group-btn">

            <button type="button" id="searchoverviewdata" data-viewurl='<?php echo base_url('ams/assets_overview/get_overview_report') ?>' class="btn btn-success btnEdit mtop_0" data-displaydiv='assets_overviewblock'><i class="fa fa-search"></i></button>

          </span>

          <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading='<?php echo $this->lang->line('list_of_items'); ?>' data-viewurl='<?php echo base_url('/ams/assets/list_of_assets_popup'); ?>' data-id='1' id="view_1"><strong>...</strong></a>&nbsp;

        </div>
      </div>
    </div>
    <div class="clearfix"></div>

    <div id="ResponseSuccess" class="waves-effect waves-light m-r-Y0 text-success"></div>

    <div id="ResponseError" class="waves-effect waves-light m-r-Y0 text-danger"></div>
  </form>

  <div class="clearfix"></div>

  <div class="search_pm_data" id="FormDiv_assets_overviewblock"></div>

</div>

<?php

if (!empty($assets_code)) :

?>

  <script type="text/javascript">
    setTimeout(function() {

      $('#searchoverviewdata').click();

    }, 100);
  </script>

<?php

endif;

?>

<script type="text/javascript">
  $(document).off('click','.itemDetail');
  $(document).on('click','.itemDetail',function(){
    var asscode=$(this).data('asen_assetcode');
    console.log(asscode);
    // return false;
    if(asscode){
       $('#id').val(asscode);
      $('#myView').modal('hide');
      // $('#searchoverviewdata').click();
    }
   
  })
</script>