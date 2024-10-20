
    <div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
                <h3 class="box-title">Purchase Requisition | Purchase Requisition Book       |  Purchase Requisition Detail | Pending Requisition</h3>
            <div class="ov_report_tabs pad-5 tabbable">
                <ul class="nav nav-tabs form-tabs hidden-xs">
                    <li class="tab-selector <?php if($current_tab=='entry') echo 'active';?>"><a href="<?php echo base_url('purchase_receive/purchase_requisition'); ?>" <?php if($current_tab=='entry') echo' aria-expanded="true"';?>" >Purchase Requisition</a></li>
                     
                     <li class="tab-selector <?php if($current_tab=='pur_req_book') echo 'active';?>"><a href="<?php echo base_url('purchase_receive/purchase_requisition/pur_req_book'); ?>">Purchase Requisition Book</a></li>

                    <li class="tab-selector <?php if($current_tab=='detail_list') echo 'active';?>"><a href="<?php echo base_url('purchase_receive/quotation_analysis'); ?>" <?php if($current_tab=='detail_list') echo' aria-expanded="true"';?>" >Purchase Requisition Detail</a></li>

                    <li class="tab-selector <?php if($current_tab=='pending_requision') echo 'active';?>"><a href="<?php echo base_url('purchase_receive/pending_requisition'); ?>" <?php if($current_tab=='pending_requision') echo' aria-expanded="true"';?>" >Pending Requisition Detail</a></li>
                     
                </ul>
            </div>
        <div class="ov_report_tabs pad-5 tabbable">
            <?php if($current_tab=='entry'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($current_tab=='entry') echo "active"; ?>">
                    <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                   <?php $this->load->view('purchase/v_purchase_requisition_form');?>
                    </div>
            </div>
            <?php endif; ?>
                 <?php if($current_tab=='pur_req_book'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_tab=='pur_req_book') echo "active"; ?>">
                    <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <?php $this->load->view('purchase/v_purchase_requisition_book');?>
                        </div>
            </div>
            <?php endif; ?>
        </div>

                </div>
    </div>
</div>


