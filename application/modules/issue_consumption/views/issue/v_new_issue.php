<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
             <h3 class="box-title"><?php echo $this->lang->line('issue'); ?></h3>
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
                    <div class="self-tabs">
                            <?php  $this->load->view('common/v_common_tab_header'); ?>
                        
        </div>
      </div>
    </div>
    <div class="ov_report_tabs page-tabs pad-5 margin-top-220 tabbable">

        <?php if($tab_type=='entry'): ?>      
        <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='entry') echo "active"; ?>">
                <div  id="FormDiv_mrnbook" class="formdiv frm_bdy">
                    <?php
                    if(defined('NEW_ISSUE_FORM_TYPE')):
                        if(NEW_ISSUE_FORM_TYPE == 'DEFAULT'){
                            $this->load->view('issue/v_new_issue_form');
                        }else{
                            if(!empty($issue_masterid)){
                                $this->load->view('issue/'.REPORT_SUFFIX.'/v_new_issue_form_edit');
                            }else{
                               $this->load->view('issue/'.REPORT_SUFFIX.'/v_new_issue_form'); 
                            }
                            
                        }
                    else:
                        $this->load->view('issue/v_new_issue_form');
                    endif;
                    ?>
                    <?php //$this->load->view('issue/v_new_issue_form');?>
                </div>
        </div>
        <?php endif; ?>

        


      <?php if($tab_type=='handover_issue_entry'): ?>      
        <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='handover_issue_entry') echo "active"; ?>">
                <div  id="FormDiv_mrnbook" class="formdiv frm_bdy">
                    <?php $this->load->view('handover/v_handover_new_issue_form');?>
                </div>
        </div>
       <!--  <?php //endif; ?>  -->
        
          <?php elseif($tab_type=='direct_issue_entry'): ?>      
        <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='direct_issue_entry') echo "active"; ?>">
                <div  id="FormDiv_mrnbook" class="formdiv frm_bdy">
                    <?php $this->load->view('direct_issue/v_direct_new_issue_form');?>
                </div>
        </div>
        <?php endif; ?> 
        <?php if($tab_type=='edit_issue'): ?>         
        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='edit_issue') echo "active"; ?>">
              <div  id="FormDiv_mrnbook_cancel" class="formdiv frm_bdy">
                  <?php $this->load->view('issue/v_new_issue_form_edit');?>
              </div>
        </div>
        <?php endif; ?>
        <?php if($tab_type=='list'): ?>         
        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='list') echo "active"; ?>">
              <div  id="FormDiv_mrnbook_supplier" class="formdiv frm_bdy">
                     <?php
                    if(defined('NEW_ISSUE_FORM_TYPE')):
                        if(NEW_ISSUE_FORM_TYPE == 'DEFAULT'){
                            $this->load->view('issue/v_issue_book_list');
                        }else{
                                $this->load->view('issue/'.REPORT_SUFFIX.'/v_issue_book_list');
                          }
                        else:
                        $this->load->view('issue/v_issue_book_list');
                      endif;
                    ?>
                  <?php //$this->load->view('issue/v_issue_book_list');?>
              </div>
        </div>
        <?php endif; ?>

        <?php if($tab_type=='cancel'): ?>         
        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='cancel') echo "active"; ?>">
              <div  id="FormDiv_mrnbook_cancel" class="formdiv frm_bdy">
                  <?php $this->load->view('issue/v_issue_cancel');?>
              </div>
        </div>
        <?php endif; ?>
         <?php if($tab_type=='issue_edit'): ?>         
        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='issue_edit') echo "active"; ?>">
              <div  id="FormDiv_mrnbook_cancel" class="formdiv frm_bdy">
                  <?php $this->load->view('issue/v_issue_correction');?>
              </div>
        </div>
        <?php endif; ?>

        <?php if($tab_type=='return'): ?>         
        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='return') echo "active"; ?>">
              <div  id="FormDiv_mrnbook_cancel" class="formdiv frm_bdy">
                  <?php //$this->load->view('issue/v_issue_return');?>
                   <?php
                    if(defined('NEW_ISSUE_FORM_TYPE')):
                        if(NEW_ISSUE_FORM_TYPE == 'DEFAULT'){
                            $this->load->view('issue/v_issue_return');
                           }else{
                           
                               $this->load->view('issue/'.REPORT_SUFFIX.'/v_issue_return'); 
                           }
                          
                    else:
                        $this->load->view('issue/v_issue_return');
                    endif;
                    ?>
              </div>
        </div>
        <?php endif; ?>
        <?php if($tab_type == 'issuedetails'):?>
        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='issuedetails') echo "active"; ?>">
            <div  id="FormDiv_mrnbook_cancel" class="formdiv frm_bdy">
              <?php $this->load->view('issue/v_issue_details_list');?>
            </div>
        </div>
        <?php endif; ?>
        <?php if($tab_type == 'returncancel'):?>
        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='returncancel') echo "active"; ?>">
            <div  id="FormDiv_mrnbook_cancel" class="formdiv frm_bdy">
              <?php $this->load->view('issue/v_issue_returncancel');?>
            </div>
        </div>
        <?php endif; ?>
        <?php if($tab_type == 'monthlywise_item_issue'):?>
        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='monthlywise_item_issue') echo "active"; ?>">
            <div  id="FormDiv_mrnbook_cancel" class="formdiv frm_bdy">
              <?php $this->load->view('monthly_item_issue/v_monthly_item_issue');?>
            </div>
        </div>
        <?php endif; ?>

        <?php if($tab_type=='department_issue'): ?>      
        <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='department_issue') echo "active"; ?>">
                <div  id="FormDiv_mrnbook" class="formdiv frm_bdy">
                    <?php $this->load->view('department_issue/v_department_issue_main');?>
                </div>
        </div>
        <?php endif; ?>

        </div>
    </div>
</div>
</div>
</div>