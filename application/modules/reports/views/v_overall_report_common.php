<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title">Overall Inventory Report</h3>
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
    <?php //echo $tab_type; die(); ?>
    <div class="ov_report_tabs page-tabs pad-5 margin-top-220 tabbable">
    <?php if($tab_type == 'demand_report'):?>
        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='demand_report') echo "active"; ?>">
            <div  id="FormDiv_demand_report" class="formdiv frm_bdy">
              <?php $this->load->view('demand_report/v_demand_report_search_form');?>
            </div>
        </div>
        <?php endif; ?>

    <?php if($tab_type == 'combine_report'):?>
        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='combine_report') echo "active"; ?>">
            <div  id="FormDiv_combine_report" class="formdiv frm_bdy">
              <?php $this->load->view('combine_report/v_combine_report_search_form');?>
            </div>
        </div>
        <?php endif; ?>

        

         <?php if($tab_type == 'purchase_order_report'):?>
        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='purchase_order_report') echo "active"; ?>">
            <div  id="FormDiv_purchase_order_report" class="formdiv frm_bdy">
              <?php $this->load->view('purchase_order_report/v_purchase_order_report_search_form');?>
            </div>
        </div>
        <?php endif; ?>

        <?php if($tab_type == 'purchase_received_report'):?>
        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='purchase_received_report') echo "active"; ?>">
            <div  id="FormDiv_purchase_received_report" class="formdiv frm_bdy">
              <?php 
              if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='PU'){
                  $this->load->view('purchase_received_report/ku/v_purchase_received_report_search_form');
              }else{
                $this->load->view('purchase_received_report/v_purchase_received_report_search_form');
              }
              
              ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if($tab_type == 'issue_report'):?>
        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='issue_report') echo "active"; ?>">
            <div  id="FormDiv_issue_report" class="formdiv frm_bdy">
                 <?php 
              if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='PU' || ORGANIZATION_NAME=='ARMY'){
                  $this->load->view('issue_report/'.REPORT_SUFFIX.'/v_issue_report_search_form');
              }else{
                $this->load->view('issue_report/v_issue_report_search_form');
              }
              
              ?>

            </div>
        </div>
        <?php endif; ?>

           <?php if($tab_type == 'stock_report'):?>
        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='stock_report') echo "active"; ?>">
            <div  id="FormDiv_stock_report" class="formdiv frm_bdy">
              <?php $this->load->view('stock_report/v_stock_report_search_form');?>
            </div>
        </div>
        <?php endif; ?>

        <?php if($tab_type == 'purchase_requisition_report'):?>
        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='purchase_requisition_report') echo "active"; ?>">
            <div  id="FormDiv_stock_report" class="formdiv frm_bdy">
              <?php $this->load->view('purchase_req_report/v_purchase_req_report_search_form');?>
            </div>
        </div>
        <?php endif; ?>

        <?php if($tab_type == 'auction_disposal_report'):?>
        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='auction_disposal_report') echo "active"; ?>">
            <div  id="FormDiv_stock_report" class="formdiv frm_bdy">
              <?php $this->load->view('auction_disposal_report/v_auction_disposal_report_search_form');?>
            </div>
        </div>
        <?php endif; ?> 
        <?php if($tab_type == 'job_head_expenses_report'):?>
        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='job_head_expenses_report') echo "active"; ?>">
            <div  id="FormDiv_stock_report" class="formdiv frm_bdy">
              <?php $this->load->view('job_head_expenses_report/v_job_head_expenses_report_search_form');?>
            </div>
        </div>
        <?php endif; ?>

        </div>
    </div>
</div>
</div>
</div>