<?php if (isset($tab_type))
{
    $this->load->view('assets/v_assets_common');
}?>
<form action="" method="post" id="Comments" class="mbtm_10" style="margin-top: 15px;">
    <div class="row">
    <div class="col-md-2 col-sm-3 col-xs-3 mtop_5 ">
        <label for="example-text"><?php echo $this->lang->line('assets_id'); ?>: </label>
    </div>
    <div class="col-sm-8 col-sm-6 col-xs-6">
        <input type="text" id="id" autocomplete="off" name="asen_asenid" value="" class="form-control searchText " placeholder="<?php echo $this->lang->line('assets_id'); ?>" data-srchurl="<?php echo base_url(); ?>/ams/assets/list_of_assets_inv">
        <div class="DisplayBlock" id="DisplayBlock_id"></div>

        </div>

    <div class="col-md-2 col-sm-3 col-xs-3">
        <div>
            <button type="button" id="searchComments" data-viewurl='<?php echo base_url('ams/Assets/get_assets_details') ?>' class="btn btn-success btnEdit mtop_0" data-displaydiv='Comments'>Search</button>
        </div>
    </div>
  </div>
</form>


   <div id="FormDiv_Comments" class="search_form_comments">

    </div>
  

  <div class="clearfix"></div>
</div>
</div>
</div>
</div>
</div>
</div>
