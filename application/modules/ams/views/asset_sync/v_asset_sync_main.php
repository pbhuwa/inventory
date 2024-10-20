<div class="row wb_form">

    <div class="col-sm-12">

        <div class="white-box">



            <div class="ov_report_tabs pad-5 tabbable">

                <div class="margin-bottom-30">

                    <div class="dropdown-tabs">

                        <div class="mobile-tabs">

                            <a href="#" class="tabs-dropdown_toogle">

                                <i class="fa fa-bar"></i>

                                <i class="fa fa-bar"></i>

                                <i class="fa fa-bar"></i>

                            </a>

                        </div>

                        <?php $this->load->view('common/v_common_tab_header');

                        // echo $this->db->last_query();

                        ?>

                    </div>

                </div>



                <div class="ov_report_tabs page-tabs pad-5 margin-top-170 tabbable">



                    <?php if ($tab_type == 'assets_inv_list') : ?>

                        <div id="dtl_rpt" class="tab-pane fade in  <?php if ($tab_type == 'assets_inv_list') echo "active"; ?>">

                            <div id="FormDiv_stockreqform" class="formdiv frm_bdy">

                        <?php
                            if(ORGANIZATION_NAME == 'KUKL' || ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' ){
                                    $this->load->view('asset_sync/'.REPORT_SUFFIX.'/v_asset_sync_search_form');
                                 }else{
                                    $this->load->view('asset_sync/v_asset_sync_search_form');
                                 }

                                ?>

                            </div>

                        </div>

                    <?php endif; ?>

                    <?php if ($tab_type == 'assets_synch_list') : ?>

                        <div id="dtl_rpt" class="tab-pane fade in  <?php if ($tab_type == 'assets_synch_list') echo "active"; ?>">

                            <div id="FormDiv_stockreqform" class="formdiv frm_bdy">

                                <?php $this->load->view('asset_sync/v_asset_sync_inv_list'); ?>

                            </div>

                        </div>

                    <?php endif; ?>
                    <?php if ($tab_type == 'assets_synch_summary') : ?>

                        <div id="dtl_rpt" class="tab-pane fade in  <?php if ($tab_type == 'assets_synch_summary') echo "active"; ?>">

                            <div id="FormDiv_stockreqform" class="formdiv frm_bdy">
                                <?php
                                if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='ARMY' ) {
                                    $this->load->view('asset_sync/'.REPORT_SUFFIX.'/v_asset_sync_inv_summary');
                                } else {
                                    $this->load->view('asset_sync/v_asset_sync_inv_summary');
                                }
                                ?> 


                            </div>

                        </div>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</div>





<div class="clearfix"></div>