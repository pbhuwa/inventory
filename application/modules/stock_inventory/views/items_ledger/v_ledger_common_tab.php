<div class="row wb_form">
	<div class="col-sm-12">
		<div class="white-box">
			<h3 class="box-title"><?php echo $this->lang->line('items_ledger'); ?></h3>
			<div  id="FormDiv_item" class="formdiv frm_bdy issue_cons">
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
                </div>

                <div class="ov_report_tabs pad-5 page-tabs margin-top-250 tabbable">
                    <?php if($current_tab=='item_ledger'): ?>      
                    <div id="dtl_rpt" class="tab-pane fade in  <?php if($current_tab=='item_ledger') echo "active"; ?>">
                        <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <?php
                    if(defined('ITEM_LEDGER_REPORT_TYPE')):
                        if(ITEM_LEDGER_REPORT_TYPE == 'DEFAULT'){
                            $this->load->view('items_ledger/v_item_ledger');
                        }else{
                            
                               $this->load->view('items_ledger/'.REPORT_SUFFIX.'/v_item_ledger'); 
                            }
                            
                        
                    else:
                        $this->load->view('items_ledger/v_item_ledger');
                    endif;
                    ?>

                           
                        </div>
                    </div>
                    <?php endif; ?> 

                    <?php if($current_tab=='items_ledger_report'): ?>      
                    <div id="dtl_rpt" class="tab-pane fade in  <?php if($current_tab=='items_ledger_report') echo "active"; ?>">
                        <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <?php $this->load->view('items_ledger/v_items_ledger_form');?>
                        </div>
                    </div>
                    <?php endif; ?> 
                    <?php if($current_tab=='items_ledger_bulk_report'): ?>      
                    <div id="dtl_rpt" class="tab-pane fade in  <?php if($current_tab=='items_ledger_bulk_report') echo "active"; ?>">
                        <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <?php $this->load->view('items_ledger/v_items_ledger_bulk_form');?>
                        </div>
                    </div>
                    <?php endif; ?> 

                    <?php if($current_tab=='expendable_nonexp_items_ledger_report'): ?>      
                    <div id="dtl_rpt" class="tab-pane fade in  <?php if($current_tab=='expendable_nonexp_items_ledger_report') echo "active"; ?>">
                        <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <?php $this->load->view('items_ledger/v_expendable_items_ledger_form');?>
                        </div>
                    </div>
                    <?php endif; ?> 

                    <?php if($current_tab=='items_ledger_report_i'): ?>      
                    <div id="dtl_rpt" class="tab-pane fade in  <?php if($current_tab=='items_ledger_report_i') echo "active"; ?>">
                        <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <?php $this->load->view('items_ledger/v_items_ledger_typei_form');?>
                        </div>
                    </div>
                    <?php endif; ?> 
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div id="itemWiseReport">
		</div>
	</div>
</div>
	
<script type="text/javascript">
	$(".nav-pills a").click(function(){
     	$(this).tab('show');
 	});
</script>