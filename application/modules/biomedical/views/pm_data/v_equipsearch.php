<form action="" method="post" id="PmdataForm" class="mbtm_10">
  <div class="row">
    <div class="col-md-2 mtop_5 ">
      <label for="example-text">Equipment ID: </label>
    </div>
    <div class="col-sm-4">
      <input type="text" id="id" name="equid" value="" class="form-control number" placeholder="Enter Equipment ID">
    </div>
    <div class="col-md-4">
      <div>
        <button type="button" id="searchPmdata" data-viewurl='<?php echo base_url('biomedical/pm_data/get_equdata') ?>' class="btn btn-success btnEdit mtop_0" data-displaydiv='PmdataForm'>Search</button>
      </div>
    </div>
  </div>
</form>

<div class="clearfix"></div>