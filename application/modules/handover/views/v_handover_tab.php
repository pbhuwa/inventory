<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
           <h3 class="box-title"><?php echo $this->lang->line('handover'); ?></h3>
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
                    <?php $this->load->view('common/v_common_tab_header'); ?>
                </div>
            </div>
            <div class="ov_report_tabs page-tabs pad-5 margin-top-220 tabbable">
                <?php if($tab_type=='handover_req_entry'): ?>      
                    <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='handover_req_entry') echo "active"; ?>">
                        <div  id="FormDiv_mrnbook" class="formdiv frm_bdy">

                            <?php   
                            $this->load->view('handover/handover_req/kukl/v_handoverrequisition_form');
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($tab_type=='handover_req_summary'): ?>      
                    <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='handover_req_summary') echo "active"; ?>">
                        <div  id="FormDiv_mrnbook" class="formdiv frm_bdy">

                         <?php   
                         $this->load->view('handover/handover_req/kukl/v_handoversummary_list');
                         ?>
                     </div>
                 </div>
             <?php endif; ?>

             <?php if($tab_type=='handover_req_detail'): ?>         
                <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='handover_req_detail') echo "active"; ?>">
                  <div  id="FormDiv_mrnbook_supplier" class="formdiv frm_bdy">
                   <?php  
                   $this->load->view('handover/handover_req/kukl/v_handoverdetail_list');
                   ?>
               </div>
           </div>
       <?php endif; ?>

       <?php if($tab_type=='entry'): ?>      
        <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='entry') echo "active"; ?>">
            <div  id="FormDiv_mrnbook" class="formdiv frm_bdy">
                <?php  

                    $this->load->view('handover/handover_issue/kukl/v_handover_issue_form');

                    ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if($tab_type=='summary'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='summary') echo "active"; ?>">
                <div  id="FormDiv_mrnbook" class="formdiv frm_bdy">
                    <?php  
                    $this->load->view('handover/handover_issue/kukl/v_handver_issue_summary');
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if($tab_type=='details'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='details') echo "active"; ?>">
                <div  id="FormDiv_mrnbook" class="formdiv frm_bdy">
                    <?php  
                    $this->load->view('handover/handover_issue/kukl/v_handover_issue_detail_list');
                    ?>
                </div>
            </div>
        <?php endif; ?>

      <!--   <?php if($tab_type=='direct_entry'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='direct_entry') echo "active"; ?>">
                <div  id="FormDiv_mrnbook" class="formdiv frm_bdy">
                 <?php  $this->load->view('handover/handover_direct/v_handover_direct_entry_form');?>
             </div>
         </div>
     <?php endif; ?> -->

    <?php if($tab_type=='Direct_handover_req_entry'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='Direct_handover_req_entry') echo "active"; ?>">
                <div  id="FormDiv_mrnbook" class="formdiv frm_bdy">
                 <?php  $this->load->view('handover/handover_req_direct/v_direct_handover_req_form');?>
             </div>
         </div>
     <?php endif; ?>

 </div>
</div>
</div>
</div>