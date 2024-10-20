
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
                     <?php $this->load->view('common/v_common_tab_header'); ?>
        </div>
    </div>

     <div class="ov_report_tabs page-tabs pad-5 margin-top-170 tabbable">
             <?php if($tab_type=='assets_report'): ?>      
                            <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='assets_report') echo "active"; ?>">
                                <div  id="FormDiv_stockreqform" class="formdiv frm_bdy">
                                    <?php 
                                    if(ORGANIZATION_NAME=='KU'){
                                        $this->load->view('assets_report/assets_report_pages/ku/v_assets_report_mainpages');
                                    }
                                    else if(ORGANIZATION_NAME=='ARMY'){
                                         $this->load->view('assets_report/assets_report_pages/ku/v_assets_report_mainpages');
                                    }
                                    else{
                                    $this->load->view('assets_report/assets_report_pages/v_assets_report_mainpages');    
                                    }

                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>

                          <?php if($tab_type=='assets_handover'): ?>      
                            <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='assets_handover') echo "active"; ?>">
                                <div  id="FormDiv_stockreqform" class="formdiv frm_bdy">
                                    <?php 
                                    if(ORGANIZATION_NAME=='KU'){
                                        $this->load->view('assets_report/assets_report_pages/ku/v_assets_handover_mainpages');
                                    }else{
                                    $this->load->view('assets_report/assets_report_pages/v_assets_report_mainpages');    
                                    }

                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>

                          <?php if($tab_type=='assets_handover_summary'): ?>      
                            <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='assets_handover_summary') echo "active"; ?>">
                                <div  id="FormDiv_stockreqform" class="formdiv frm_bdy">
                                    <?php 
                                    if(ORGANIZATION_NAME=='KU'){
                                        $this->load->view('assets_report/assets_report_pages/ku/v_assets_handover_summary');
                                    }else{
                                    $this->load->view('assets_report/assets_report_pages/v_assets_handover_summary');    
                                    }

                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
            <?php if($tab_type=='assets_register'): ?>      
                <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='assets_register') echo "active"; ?>">
                    <div  id="FormDiv_stockreqform" class="formdiv frm_bdy">
                        <?php $this->load->view('assets_report/v_assets_register_search');?>
                    </div>
                </div>
            <?php endif; ?>

            
           <?php if($tab_type=='assets_ledger'): ?>      
                <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='assets_ledger') echo "active"; ?>">
                    <div  id="FormDiv_stockreqform" class="formdiv frm_bdy">
                        <?php $this->load->view('assets_report/v_assets_ledger_search');?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($tab_type=='fix_assets'): ?>      
                <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='fix_assets') echo "active"; ?>">
                    <div  id="FormDiv_stockreqform" class="formdiv frm_bdy">
                        <?php $this->load->view('assets_report/v_assets_fix_search');?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        </div>
        </div>
        </div>
        </div>

        
    <div class="clearfix"></div>