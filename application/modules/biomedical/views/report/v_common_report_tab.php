<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
        <h3 class="box-title">Reports</h3>

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
    <div class="ov_report_tabs page-tabs pad-5 margin-top-30 tabbable">
                 <?php if($tab_type=='equip_report'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='equip_report') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('report/v_equipmentwise_report');?>  
                </div>
            </div>
            <?php endif; ?>
                 <?php if($tab_type=='equ_reports'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='equ_reports') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('report/v_report');?>
                </div>
            </div>
            <?php endif; ?>
            <?php if($tab_type=='overview_report'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='overview_report') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('report/v_overview_reoport');?>
                </div>
            </div>
            <?php endif; ?>
            <?php if($tab_type=='pm_data_report'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='pm_data_report') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('report/v_pm_data_report'); ?>
                </div>
            </div>
            <?php endif; ?>
            <?php if($tab_type=='complete'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='complete') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('report/v_pm_data_report'); ?>
                </div>
            </div>
            <?php endif; ?>





                <?php if($tab_type=='rep_reports'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='rep_reports') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('report/v_pm_repair_request_report'); ?>
                </div>
            </div>
            <?php endif; ?>
                <?php if($tab_type=='summary_report'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='summary_report') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('report/v_column_wise_report'); ?>
                </div>
            </div>
            <?php endif; ?>
                <?php if($tab_type=='assign_report'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='assign_report') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('assign_equipement/v_equip_assign_report'); ?>
                </div>
            </div>
            <?php endif; ?>

                <?php if($tab_type=='handover'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='handover') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('assign_equipement/v_equip_handover_report'); ?>
                </div>
            </div>
            <?php endif; ?>   
             <?php if($tab_type=='decommission_report'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='decommission_report') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('report/v_pm_data_report'); ?>
                </div>
            </div>
         <?php endif; ?>

        </div>
    </div>
 </div>
</div>