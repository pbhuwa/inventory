<style>
    .ov_report_dtl .ov_lst_ttl { font-size:12px; margin-bottom: 5px; padding-bottom: 5px; border-bottom: 1px solid #efefef; }
    .ov_report_dtl .pm_data_tbl { width:100%; margin-bottom:10px; }
    .ov_report_dtl .pm_data_tbl td, .ov_report_dtl .pm_data_tbl td b { font-size:12px; }
    .ov_report_dtl .count { background-color:#e3e3e3; font-size:12px; padding:2px 5px; }
    
    table.ov_report_tbl { border-left:1px solid #e3e3e3; border-top:1px solid #e3e3e3; border-collapse:collapse; margin-bottom:10px; }
    table.ov_report_tbl thead th { text-align:left; background-color:#e3e3e3; padding:2px; font-size:12px; }
    table.ov_report_tbl tbody td { font-size:12px; border-right:1px solid #e3e3e3; border-bottom:1px solid #e3e3e3; line-height:13px; padding:2px; }
    .search_pm_data ul.pm_data li label{
        width: 150px;
    }
    .search_pm_data ul.pm_data li{
        font-size: 13px;
        line-height: 17px;
        display:table;
        width:100%;
    }
    .search_pm_data ul.pm_data li label, .search_pm_data ul.pm_data li span{ display:table-cell; vertical-align: top; padding:4px 0; }
    .search_pm_data ul.pm_data { padding:5px 7px; }
    #barcodePrint{
        position: absolute;top: 0;right: 5px;    background-color: #03a9f3; border: 1px solid #03a9f3; color:#fff;
    }

    .ov_report_tabs #tab_selector { margin-bottom:5px; }

    .ov_report_tabs #tab_selector {
        border: none;
        background-color: #00663f;
        background: -webkit-linear-gradient(#00b588, #017558);
        background: -o-linear-gradient(#00b588, #017558);
        background: -moz-linear-gradient(#00b588, #017558);
        background: linear-gradient(#00b588, #017558);
        color: #fff;
    }
    .ov_report_tabs #tab_selector option {
        color: #444;
    }

    @media only screen and (max-width:991px) { 
        .ov_report_tabs ul.nav-tabs li a { font-size:12px; padding:10px; }
    }
    @media only screen and (max-width:767px) {
        .ov_report_tabs ul.nav-tabs li a { font-size: 12px; padding: 10px 29px; }
    }
    @media only screen and (max-width:667px) {
        .ov_report_tabs ul.nav-tabs li { width:33.33333333%; }
        .ov_report_tabs ul.nav-tabs li a { padding:10px; text-align:center; }
        .search_pm_data ul.pm_data li.eqp_cod label, .search_pm_data ul.pm_data li.eqp_cod span { display:block; }
    }
    @media only screen and (max-width:414px) {
        .ov_report_tabs ul.nav-tabs li { width:50%; }
        .search_pm_data ul.pm_data { column-count: 1; }
    }
</style>

<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('purchase_analysis'); ?></h3>
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
                                <li class="tab-selector <?php if($pur_analysis=='pur_mrn') echo 'active';?>">
                                    <a href="<?php echo base_url('purchase_receive/purchase_analysis/'); ?>" <?php if($pur_analysis=='pur_mrn') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('purchase_mrn'); ?></a>
                                </li>
                                
                                <li class="tab-selector <?php if($pur_analysis=='pur_return') echo 'active';?>">
                                    <a href="<?php echo base_url('purchase_receive/purchase_analysis/index/pur_return'); ?>"><?php echo $this->lang->line('purchase_return'); ?> </a>
                                </li>
                                
                                <li class="tab-selector <?php if($pur_analysis=='pur_by_date') echo 'active';?>">
                                    <a href="<?php echo base_url('purchase_receive/purchase_analysis/index/pur_by_date'); ?>"><?php echo $this->lang->line('purchase_by_date'); ?> </a>
                                </li>
                                
                                <li class="tab-selector <?php if($pur_analysis=='pur_by_supp') echo 'active';?>">
                                    <a href="<?php echo base_url('purchase_receive/purchase_analysis/index/pur_by_supp'); ?>"><?php echo $this->lang->line('purchase_by_supplier'); ?> </a>
                                </li>
                                
                                <li class="tab-selector <?php if($pur_analysis=='pur_by_item') echo 'active';?>">
                                    <a href="<?php echo base_url('purchase_receive/purchase_analysis/index/pur_by_item'); ?>"><?php echo $this->lang->line('purchase_by_item'); ?> </a>
                                </li>
                                
                                 <li class="tab-selector <?php if($pur_analysis=='pur_expiry_list') echo 'active';?>">
                                    <a href="<?php echo base_url('purchase_receive/purchase_analysis/index/pur_expiry_list'); ?>"><?php echo $this->lang->line('expiry_list'); ?> </a>
                                </li>
                                 
                                <li class="tab-selector <?php if($pur_analysis=='pur_summary') echo 'active';?>">
                                    <a href="<?php echo base_url('purchase_receive/purchase_analysis/index/pur_summary'); ?>"><?php echo $this->lang->line('purchase_summary'); ?></a>
                                </li>
                            </ul>
                        </div> -->
                    </div>
                </div>
                
                <div class="ov_report_tabs page-tabs margin-top-270 pad-5 tabbable">
                    <?php if($pur_analysis=='pur_mrn'): ?>      
                        <div id="dtl_rpt" class="tab-pane fade in  <?php if($pur_analysis=='pur_mrn') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <?php $this->load->view('purchase_analysis/v_purchase_analysis_mrn_form');?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($pur_analysis=='pur_return'): ?>         
                        <div id="dtl_supplier" class="tab-pane fade in <?php if($pur_analysis=='pur_return') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <?php $this->load->view('purchase_analysis/v_purchase_analysis_purchase_return_form');?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($pur_analysis=='pur_by_date'): ?>         
                        <div id="dtl_supplier" class="tab-pane fade in <?php if($pur_analysis=='pur_by_date') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <?php $this->load->view('purchase_analysis/v_purchase_analysis_by_date_form');?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($pur_analysis=='pur_by_supp'): ?>         
                        <div id="dtl_supplier" class="tab-pane fade in <?php if($pur_analysis=='pur_by_supp') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <?php $this->load->view('purchase_analysis/v_purchase_analysis_by_supplier_form');?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($pur_analysis=='pur_by_item'): ?>         
                        <div id="dtl_supplier" class="tab-pane fade in <?php if($pur_analysis=='pur_by_item') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <?php $this->load->view('purchase_analysis/v_purchase_analysis_by_item_form');?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($pur_analysis=='pur_expiry_list'): ?>         
                        <div id="dtl_supplier" class="tab-pane fade in <?php if($pur_analysis=='pur_expiry_list') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <?php $this->load->view('purchase_analysis/v_purchase_analysis_mrn_form');?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($pur_analysis=='pur_credit'): ?>         
                        <div id="dtl_supplier" class="tab-pane fade in <?php if($pur_analysis=='pur_summary') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <?php $this->load->view('purchase_analysis/v_purchase_analysis_credit_form');?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($pur_analysis=='pur_summary'): ?>         
                        <div id="dtl_supplier" class="tab-pane fade in <?php if($pur_analysis=='pur_summary') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <?php $this->load->view('purchase_analysis/v_purchase_analysis_form');?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>