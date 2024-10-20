<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title">
                <?php echo $this->lang->line('quotation_request_quotation_summary_quotation_review_approved_quotation'); ?>
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


                        <!-- <div class="self-tabs">
                            <ul class="nav nav-tabs form-tabs">
                                <?php 
                                 if($type=='Q'){
                                    $url_req=base_url('purchase_receive/quotation');
                                    $url_sum=base_url('purchase/quotation_book');
                                    $url_rev=base_url('purchase_receive/quotation_details');
                                    $url_app=base_url('purchase_receive/quotation_details/quotation_approved');
                                    $url_tab=base_url('purchase_receive/quotation/quotation_comparitive_table');
                                    $request=$this->lang->line('quotation_request');
                                    $summary=$this->lang->line('quotation_summary');
                                    $review=$this->lang->line('quotation_review');
                                    $approved=$this->lang->line('approved_quotation');
                                    $table=$this->lang->line('quotation_comparitive_table');
                                 }
                                 else
                                 {
                                    $url_req=base_url('purchase_receive/tender');
                                    $url_sum=base_url('purchase/tender');
                                    $url_rev=base_url('tender_details');
                                    $url_app=base_url('tender_approved');
                                    $url_tab=base_url('tender_comparitive_table');
                                    $request=$this->lang->line('tender_request');
                                    $summary=$this->lang->line('tender_summary');
                                    $review=$this->lang->line('tender_review');
                                    $approved=$this->lang->line('approved_tender');
                                    $table=$this->lang->line('tender_comparitive_table');
                                 }
                                ?>

                                <li class="tab-selector <?php if($current_stock=='quotation') echo 'active';?>"><a href="<?php echo $url_req ;?>" <?php if($current_stock=='quotation') echo' aria-expanded="true"';?>" > 
                                       <?php echo $request ?>
                                    </a></li>

                                <li class="tab-selector <?php if($current_stock=='quotation_book') echo 'active';?>"><a href="<?php echo $url_sum; ?>">
                                        <?php echo $summary ?>
                                    </a></li>

                                <li class="tab-selector <?php if($current_stock=='quotation_details') echo 'active';?>"><a href="<?php echo $url_rev; ?>">
                                    <?php echo $review; ?>
                                    </a></li>

                                <li class="tab-selector <?php if($current_stock=='quotation_review') echo 'active';?>"><a href="<?php echo $url_app; ?>">
                                    <?php echo $approved; ?>
                                    </a></li>
                                 <li class="tab-selector <?php if($current_stock=='quotation_comp_table') echo 'active';?>"><a href="<?php echo $url_tab ; ?>">
                                     <?php echo $table; ?>
                                    </a></li>
                            </ul>
                        </div> -->
                    </div>
                </div>

                <div class="ov_report_tabs page-tabs margin-top-165 pad-5 tabbable">
                    <?php if($current_stock=='quotation'): ?>      
                        <div id="dtl_rpt" class="tab-pane fade in  <?php if($current_stock=='quotation') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <?php $this->load->view('purchase_receive/quotation/v_quotation_form');?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($current_stock=='quotation_book'): ?>         
                        <div id="dtl_supplier" class="tab-pane fade in <?php if($current_stock=='quotation_book') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <?php $this->load->view('purchase_receive/quotation/v_quotation_book');?>
                            </div>
                        </div>
                    <?php endif; ?> 

                    <?php if($current_stock=='quotation_review'): ?>         
                        <div id="dtl_supplier" class="tab-pane fade in <?php if($current_stock=='quotation_review') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <?php $this->load->view('purchase_receive/quotation_details/v_quotation_approved');?>
                             </div>
                        </div>
                    <?php endif; ?>

                    <?php if($current_stock=='quotation_details'): ?>         
                        <div id="dtl_supplier" class="tab-pane fade in <?php if($current_stock=='quotation_details') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <?php $this->load->view('purchase_receive/quotation_details/v_quotation_details');?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($current_stock=='quotation_analysis'): ?>         
                        <div id="dtl_supplier" class="tab-pane fade in <?php if($current_stock=='quotation_analysis') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <?php $this->load->view('purchase_receive/analysis/v_quotation_analysis');?>
                            </div>
                        </div>
                    <?php endif; ?>   
                     <?php if($current_stock=='quotation_comp_table'): ?>         
                        <div id="dtl_supplier" class="tab-pane fade in <?php if($current_stock=='quotation_comp_table') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <?php $this->load->view('purchase_receive/quotation/v_compare_quotation');?>
                            </div>
                        </div>
                    <?php endif; ?>   
                </div>
            </div>
        </div>
    </div>
</div>