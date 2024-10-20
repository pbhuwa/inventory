<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title">
               Requisition Upload| Correction|Supplier Entry| Correction
            </h3>

            <div class="ov_report_tabs pad-5 tabbable">
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

                       <!--  <div class="self-tabs">
                            <ul class="nav nav-tabs form-tabs">
                                <li class="tab-selector <?php if($current_tab=='req_upload_form') echo 'active';?>"><a href="<?php echo base_url('purchase_receive/req_upload'); ?>" <?php if($current_tab=='req_upload_form') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('req_upload_form'); ?></a></li>

                                <li class="tab-selector <?php if($current_tab=='supplier_rate_entry') echo 'active';?>"><a href="<?php echo base_url('purchase_receive/req_upload/supplier_rate_entry'); ?>" <?php if($current_tab=='supplier_rate_entry') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('supplier_rate_entry'); ?></a></li>

                                 <li class="tab-selector <?php if($current_tab=='compare_suplier_rate') echo 'active';?>"><a href="<?php echo base_url('purchase_receive/req_upload/compare_suplier_rate'); ?>" <?php if($current_tab=='compare_suplier_rate') echo' aria-expanded="true"';?>" >Compare Rate</a></li>
                            </ul>
                        </div> -->
                    </div>
                </div>

                <div class="ov_report_tabs page-tabs margin-top-165 pad-5 tabbable">
                    <?php if($current_tab=='req_upload_form'): ?>      
                        <div id="dtl_rpt" class="tab-pane fade in  <?php if($current_tab=='req_upload_form') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <?php $this->load->view('purchase_receive/req_upload/v_req_upload_form');?>
                            </div>
                        </div>
                    <?php endif; ?>  

                    <?php if($current_tab=='correction_upload_requistion'): ?>      
                        <div id="dtl_rpt" class="tab-pane fade in  <?php if($current_tab=='correction_upload_requistion') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <?php $this->load->view('purchase_receive/req_upload/v_req_correction_form');?>
                            </div>
                        </div>
                    <?php endif; ?>  

                    <?php if($current_tab=='supplier_rate_entry'): ?>      
                        <div id="dtl_rpt" class="tab-pane fade in  <?php if($current_tab=='supplier_rate_entry') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <?php $this->load->view('purchase_receive/req_upload/v_supplier_rate_entry_form');?>
                            </div>
                        </div>
                    <?php endif; ?>  

                    <?php if($current_tab=='upload_supplier_rate_correction'): ?>      
                        <div id="dtl_rpt" class="tab-pane fade in  <?php if($current_tab=='upload_supplier_rate_correction') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <?php $this->load->view('purchase_receive/req_upload/v_upload_supplier_rate_correction_form');?>
                            </div>
                        </div>
                    <?php endif; ?>  
                     <?php if($current_tab=='compare_suplier_rate'): ?>      
                        <div id="dtl_rpt" class="tab-pane fade in  <?php if($current_tab=='compare_suplier_rate') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <?php $this->load->view('purchase_receive/req_upload/v_compare_supplier_rate');?>
                            </div>
                        </div>
                    <?php endif; ?>  

                </div>
            </div>
        </div>
    </div>
</div>