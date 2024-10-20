     <div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
                <h3 class="box-title"><?php echo $this->lang->line('purchase_order_purchase_order_summary_purchase_order_details_purchase_order_aging_cancel_order'); ?></h3>
            <div class="ov_report_tabs pad-5 tabbable r-tabs">
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
        <div class="ov_report_tabs page-tabs margin-top-250 pad-5 tabbable">
            <?php if($current_tab=='purchase_order'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($current_tab=='purchase_order') echo "active"; ?>">
                        <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            
                        <?php
                        // die();
                       
                            if(defined('PUR_OR_FORM_TYPE')):
                                if(PUR_OR_FORM_TYPE == 'DEFAULT'){
                                    $this->load->view('purchase_order/v_purchase_order_form');
                                }else{
                                    $this->load->view('purchase_order/'.REPORT_SUFFIX.'/v_purchase_order_form');
                                }
                            else:
                                $this->load->view('purchase_order/v_purchase_order_form');
                            endif;
                        ?>
                        </div>
            </div>
            <?php endif; ?>

             <?php if($current_tab=='purchase_order_no_supplier'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($current_tab=='purchase_order_no_supplier') echo "active"; ?>">
                        <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            
                        <?php
                            // echo 'asd';
                            // die();
                           $this->load->view('purchase_order/pu/v_purchase_order_form_no_supplier');
                              
                        ?>
                        </div>
            </div>
            <?php endif; ?>

                 <?php if($current_tab=='purchase_order_book'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_tab=='purchase_order_book') echo "active"; ?>">
                    <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <?php //$this->load->view('purchase_order/v_purchase_order_book_list');?>
                             <?php
                            if(defined('ORGANIZATION_NAME')):
                               if(ORGANIZATION_NAME == 'KUKL'){
                                $this->load->view('purchase_order/'.REPORT_SUFFIX.'/v_purchase_order_book_list');
                                 }
                                 else if(ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' ){
                                $this->load->view('purchase_order/'.REPORT_SUFFIX.'/v_purchase_order_book_list');
                                 }else{
                                $this->load->view('purchase_order/v_purchase_order_book_list'); 
                            }
                        else:
                            $this->load->view('purchase_order/v_purchase_order_book_list');
                        endif;
                        ?>

                        </div>
                  
                    </div>
            <?php endif; ?>
             <?php if($current_tab=='purchase_order_details'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_tab=='purchase_order_details') echo "active"; ?>">
                    <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <!-- );?> -->
                            <?php 
                             if(ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' ){
                                // $this->load->view('purchase_order_details/v_purchase_order_details');
                                 $this->load->view('purchase_order_details/'.REPORT_SUFFIX.'/v_purchase_order_details_list');
                             }
                             else{
                                $this->load->view('purchase_order_details/v_purchase_order_details_list');
                             }
                            ?>
                        </div>
                  
                    </div>
            <?php endif; ?>
             <?php if($current_tab=='purchase_order_aging'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_tab=='purchase_order_aging') echo "active"; ?>">
                    
                    <div  id="FormDiv_DirectReceive" class="formdiv frm_bdy">
                       
                        <?php $this->load->view('purchase_order_aging/v_purchase_order_aging_list');?>
                    </div>
            </div>
            <?php endif; ?>
            <?php if($current_tab=='cancel_order_list'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_tab=='cancel_order_list') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('cancel_order/v_cancel_order');?>
                </div>
            </div>
            <?php endif; ?>
            <?php if($current_tab=='cancel_order'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_tab=='cancel_order') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('cancel_order/v_cancel_order_form');?>
                </div>
            </div>
            <?php endif; ?>
             <?php if($current_tab=='purchase_order_quotation'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_tab=='purchase_order_quotation') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('purchase_order_quotation/v_purchase_order_form');?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        </div>
    </div>
</div>


            