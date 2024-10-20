
<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('challan_form'); ?></h3>
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
            <?php if($tab_type=='entry'): ?>      
                <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='entry') echo "active"; ?>">
                    <div  id="FormDiv_stockreqform" class="formdiv frm_bdy">
                        <?php $this->load->view('challan/v_challan_form_new'); ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if($tab_type=='list'): ?>         
                <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='list') echo "active"; ?>">
                    <div  id="FormDiv_stockreqlist" class="formdiv frm_bdy">
                     
                         <?php
                    if(defined('CHALLAN_LIST')):
                        if(CHALLAN_LIST == 'DEFAULT'){
                            $this->load->view('challan/v_challan_list');
                        }else{
                                $this->load->view('challan/'.REPORT_SUFFIX.'/v_challan_list');
                          }
                        else:
                        $this->load->view('challan/v_challan_list');
                      endif;
                    ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if($tab_type=='bill_entry'): ?>         
                <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='bill_entry') echo "active"; ?>">
                    <div  id="FormDiv_stockreqlist" class="formdiv frm_bdy">
                        <?php $this->load->view('challan/v_challan_bill_entry');?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if($tab_type=='bill_entry_list'): ?>         
                <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='bill_entry_list') echo "active"; ?>">
                    <div  id="FormDiv_stockreqlist" class="formdiv frm_bdy">
                        <?php $this->load->view('challan/v_challan_bill_entry_list');?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
</div>
</div>



                    

