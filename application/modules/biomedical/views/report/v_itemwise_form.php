<form method="post" id="reportOverview" action="" class="form-material form-horizontal form mbtm_0" data-reloadurl='<?php echo base_url('settings/scheme/form_scheme'); ?>'>
      <div class="form-group mbtm_0">
        <div class="col-md-1 mtop_5">
            <label for="example-text">Equipment ID: </label>
          </div>
          <div class="col-sm-6">
            <?php 
              $uri_eqkey = !empty($this->uri->segment('4'))?$this->uri->segment('4'):'';
              $equipkey=!empty($this->input->post('equipkey'))?$this->input->post('equipkey'):$uri_eqkey; ?>
              <div class="input-group">
                <input type="text" id="id" name="equid" value="<?php echo!empty($id)?$id:$equipkey;?>" class="form-control searchText" placeholder="Enter Equipment ID" data-srchurl="<?php echo base_url(); ?>/biomedical/bio_medical_inventory/list_of_equipment_inv">
                <span class="input-group-btn">
                  <button type="button" id="searchPmdata" data-viewurl='<?php echo base_url('biomedical/reports/get_overview_reoprt') ?>' class="btn btn-success btnEdit mtop_0" data-displaydiv='PmData'>Search</button>
                </span>
              </div>
              <div class="DisplayBlock" id="DisplayBlock_id"></div>
          </div>
      </div>
      </div>
      <div class="clearfix"></div>
      
       <div id="ResponseSuccess" class="waves-effect waves-light m-r-Y0 text-success"></div>
    <div id="ResponseError" class="waves-effect waves-light m-r-Y0 text-danger"></div>
</form>

<?php 
if(!empty($equipkey)):
?>
<script type="text/javascript">
 setTimeout(function(){
  $('#searchPmdata').click();
 },500);
</script>

<?php
endif;
 ?>