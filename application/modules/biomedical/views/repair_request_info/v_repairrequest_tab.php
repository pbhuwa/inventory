

<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <?php $org_id=$this->session->userdata(ORG_ID);
            if($org_id=='2'){ ?>
                <h3 class="box-title">Assets Repair Request</h3>
                <?php }else{ ?>
                <h3 class="box-title">Equipment Repair Request</h3>
                <?php } ?>

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
                <ul class="nav nav-tabs form-tabs">
                    <li class="tab-selector <?php if($rr_data=='rrinfo') echo 'active';?>">
                        <a href="<?php echo base_url('biomedical/repair_request_info'); ?>" <?php if($rr_data=='rrinfo') echo' aria-expanded="true"';?>" >Repair Request Information</a>
                    </li>
                    <li class="tab-selector <?php if($rr_data=='rrcompleted') echo 'active';?>">
                        <a href="<?php echo base_url('/biomedical/repair_request_info/rr_completed_data'); ?>">Repair Request Completed</a>
                    </li>
                    <li class="tab-selector <?php if($rr_data=='assistance') echo 'active';?>">
                        <a href="<?php echo base_url('/biomedical/repair_request_info/assistance_data'); ?>">Assistance</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </div>
    <div class="ov_report_tabs page-tabs pad-5 margin-top-30 tabbable">
                 <?php if($rr_data=='rrinfo'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($rr_data=='rrinfo') echo "active"; ?>">
                        <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <?php $this->load->view('biomedical/repair_request_info/v_repairrequest_list');?>  
                        </div>
            </div>
            <?php endif; ?>
                 <?php if($rr_data=='rrcompleted'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($rr_data=='rrcompleted') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('biomedical/repair_request_info/v_repairrequest_list');?>
                </div>
                  
            </div>
            <?php endif; ?>
            <?php if($rr_data=='assistance'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($rr_data=='assistance') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('biomedical/repair_request_info/v_assistance');?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>



                    


                    


                    



                    

