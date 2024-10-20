<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title">
                <?php echo !empty($page_title) ? $page_title : ''; ?>
            </h3>
            <div id="FormDiv_syncform" class="formdiv frm_bdy">
                <?php
                $this->load->view('asset_sync/v_asset_sync_list_search_form');
                ?>
            </div>
        </div>
    </div>
</div>