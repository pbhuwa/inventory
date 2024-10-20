    <div class="row wb_form">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title">
                    <?php echo (ORGANIZATION_NAME == 'IMCWORLD') ? $this->lang->line('purchase_entry_purchase_summary_purchase_cancel_purchase_return') : $this->lang->line('direct_purchase_entry_direct_purchase_summary_direct_purchase_cancel_direct_purchase_return'); ?>
                </h3>
                <div class="ov_report_tabs pad-5 tabbable">
                    <div class="dropdown-tabs">
                        <div class="mobile-tabs">
                            <a href="#" class="tabs-dropdown_toogle">
                                <i class="fa fa-bar"></i>
                                <i class="fa fa-bar"></i>
                                <i class="fa fa-bar"></i>
                            </a>
                        </div>

                        <?php $this->load->view('common/v_common_tab_header'); ?>
                    </div>
                </div>
                <div class="ov_report_tabs page-tabs margin-top-150 pad-5 tabbable">
                    <?php if ($direct_purchase == 'purchase_direct_entry') : ?>
                        <div id="dtl_rpt" class="tab-pane fade in  <?php if ($direct_purchase == 'purchase_direct_entry') echo "active"; ?>">
                            <div id="FormDiv_directpurchase" class="formdiv frm_bdy">
                                <?php

                                // if (defined('DIRECT_PURCHASE_LISE')) :
                                //     if (DIRECT_PURCHASE_LISE == 'DEFAULT') {
                                //         $this->load->view('purchase/v_direct_purchase_form');
                                //     } else {
                                //         $this->load->view('purchase/' . REPORT_SUFFIX . '/v_direct_purchase_form');
                                //     }
                                // else :
                                //     $this->load->view('purchase/v_direct_purchase_form');
                                // endif;
                                // echo ORGANIZATION_NAME;
                                // die();

                                if (ORGANIZATION_NAME == 'KU') {
                                    $this->load->view('purchase/ku/v_direct_purchase_form');
                                } 
                                else if(ORGANIZATION_NAME == 'ARMY') {

                                    $this->load->view('purchase/army/v_direct_purchase_form');
                                }
                                else {
                                    $this->load->view('purchase/v_direct_purchase_form');
                                }

                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($direct_purchase == 'direct_purchase_summary') : ?>
                        <div id="dtl_supplier" class="tab-pane fade in <?php if ($direct_purchase == 'direct_purchase_summary') echo "active"; ?>">
                            <div id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <?php
                                // echo DIRECT_PURCHASE_LISE;
                                // die();
                                if (defined('DIRECT_PURCHASE_LISE')) :
                                    if (DIRECT_PURCHASE_LISE == 'DEFAULT') {
                                        $this->load->view('purchase/v_direct_purchase_book');
                                    } else {
                                        $this->load->view('purchase/' . REPORT_SUFFIX . '/v_direct_purchase_book');
                                    }
                                else :
                                    $this->load->view('purchase/v_direct_purchase_book');
                                endif;
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($direct_purchase == 'purchase_order_details') : ?>
                        <div id="dtl_supplier" class="tab-pane fade in <?php if ($direct_purchase == 'purchase_order_details') echo "active"; ?>">
                            <div id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <!-- );?> -->
                                <?php $this->load->view('purchase_order_details/v_purchase_order_details'); ?>
                            </div>

                        </div>
                    <?php endif; ?>

                    <?php if ($direct_purchase == 'direct_purchase_cancel') : ?>
                        <div id="dtl_supplier" class="tab-pane fade in <?php if ($direct_purchase == 'direct_purchase_cancel') echo "active"; ?>">
                            <div id="FormDiv_mrnbook_cancel" class="formdiv frm_bdy">
                                <?php $this->load->view('purchase/v_direct_purchase_cancel'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($direct_purchase == 'direct_return_details') : ?>
                        <div id="dtl_rpt" class="tab-pane fade in  <?php if ($direct_purchase == 'direct_return_details') echo "active"; ?>">
                            <div id="FormDiv_purchase_analysis" class="formdiv frm_bdy">

                                <?php $this->load->view('purchase_return/v_purchase_return_details_lists'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($direct_purchase == 'direct_purchase_return') : ?>
                        <div id="dtl_rpt" class="tab-pane fade in  <?php if ($direct_purchase == 'direct_purchase_return') echo "active"; ?>">
                            <div id="FormDiv_purchase_analysis" class="formdiv frm_bdy">

                                <?php $this->load->view('purchase_return/v_purchase_return_form'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($direct_purchase == 'direct_purchase_from_req') : ?>
                        <div id="dtl_rpt" class="tab-pane fade in  <?php if ($direct_purchase == 'direct_purchase_from_req') echo "active"; ?>">
                            <div id="FormDiv_direct_purchase_req" class="formdiv frm_bdy">

                                <?php $this->load->view('purchase/v_direct_purchase_test'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>