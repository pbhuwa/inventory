
<form action="" method="post" id="Comments" class="mbtm_10">
    <div class="row">
    <div class="col-md-2 col-sm-3 col-xs-3 mtop_5 ">
        <label for="example-text">Equipment ID: </label>
    </div>
    <div class="col-sm-8 col-sm-6 col-xs-6">
        <input type="text" id="id" autocomplete="off" name="euipid" value="" class="form-control searchText" placeholder="Enter Equipment ID" data-srchurl="<?php echo base_url(); ?>/biomedical/bio_medical_inventory/list_of_equipment_inv">
        <div class="DisplayBlock" id="DisplayBlock_id"></div>

        </div>

    <div class="col-md-2 col-sm-3 col-xs-3">
        <div>
            <button type="button" id="searchComments" data-viewurl='<?php echo base_url('biomedical/bio_medical_inventory/get_biomedical_details') ?>' class="btn btn-success btnEdit mtop_0 againSearch" data-displaydiv='Comments'>Search</button>
        </div>
    </div>
  </div>
</form>


   <div id="FormDiv_Comments" class="search_form_comments">

    </div>
  

  <div class="clearfix"></div>
</div>
</div>