<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title">
                <?php echo $this->lang->line('purchase_requisition_purchase_requisition_book_purchase_requisition_detail'); ?>
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
                     
                            </ul>
                        </div> 
                    </div>
                </div>
                <div class="ov_report_tabs page-tabs margin-top-140 pad-5 tabbable">
                    <?php if($current_tab=='entry'): ?>      
                        <div id="dtl_rpt" class="tab-pane fade in  <?php if($current_tab=='entry') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                             <?php 
                                if(ORGANIZATION_NAME == 'KUKL'){
                                    $this->load->view('purchase/'.REPORT_SUFFIX.'/v_purchase_requisition_form');
                                }else{

                            if(defined('PURCHASE_REQ_FORM')):
                               if(PURCHASE_REQ_FORM == 'DEFAULT'){
                                 $this->load->view('purchase/v_purchase_requisition_form');
                                    }else{
                                        $this->load->view('purchase/'.REPORT_SUFFIX.'/v_purchase_requisition_form');
                                    }
                                else:
                                     $this->load->view('purchase/v_purchase_requisition_form');
                                endif;


                                   
                                }
                             ?>
                         </div>
                     </div>
                 <?php endif; ?>
                 <?php if($current_tab=='pur_req_book'): ?>         
                    <div id="dtl_supplier" class="tab-pane fade in <?php if($current_tab=='pur_req_book') echo "active"; ?>">
                        <div  id="FormDiv_purchase_requisition_analysis" class="formdiv frm_bdy">
                            <?php //$this->load->view('purchase/v_purchase_requisition_list');?>
                            <?php
                            if(defined('PURCHASE_REQ_LIST')):
                               if(PURCHASE_REQ_LIST == 'DEFAULT'){
                                $this->load->view('purchase/v_purchase_requisition_list');
                            }else{
                                $this->load->view('purchase/'.REPORT_SUFFIX.'/v_purchase_requisition_list');
                            }
                        else:
                            $this->load->view('purchase/v_purchase_requisition_list');
                        endif;
                        ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($current_tab=='detail_list'): ?>         
                <div id="dtl_supplier" class="tab-pane fade in <?php if($current_tab=='detail_list') echo "active"; ?>">
                    <div  id="FormDiv_purchase_requisition_analysis" class="formdiv frm_bdy">
                        <?php 
                        // $this->load->view('purchase/v_purchase_requisition_details_lists');
                        ?>
                        <?php
                            if(defined('PURCHASE_REQ_LIST')):
                               if(PURCHASE_REQ_LIST == 'DEFAULT'){
                                $this->load->view('purchase/v_purchase_requisition_details_lists');
                            }else{
                                $this->load->view('purchase/'.REPORT_SUFFIX.'/v_purchase_requisition_details_lists');
                            }
                        else:
                            $this->load->view('purchase/v_purchase_requisition_details_lists');
                        endif;
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
</div>


