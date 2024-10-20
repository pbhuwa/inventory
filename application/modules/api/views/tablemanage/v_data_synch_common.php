<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
             <h3 class="box-title">Report</h3>
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

        <?php if($tab_type=='data_synch'): ?>      
        <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='data_synch') echo "active"; ?>">
                <div  id="FormDiv_mrnbook" class="formdiv frm_bdy">
                    <?php $this->load->view('v_data_synch_form'); ?>
                </div>
        </div>
        <?php endif; ?>
        </div>
    </div>
</div>
</div>
</div>