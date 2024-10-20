<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
        <h3 class="box-title">Equipment Assignment / Handover</h3>

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
                        <li class="tab-selector <?php if($tab_type=='equipment_assignment') echo 'active';?>">
                            <a href="<?php echo base_url('biomedical/assign_equipement'); ?>" <?php if($tab_type=='equipment_assignment') echo' aria-expanded="true"';?>" >Assign Equipment</a>
                        </li>
                        <li class="tab-selector <?php if($tab_type=='equipment_assign_list') echo 'active';?>">
                            <a href="<?php echo base_url('biomedical/assign_equipement/assign_list_equipment'); ?>" <?php if($tab_type=='equipment_assign_list') echo' aria-expanded="true"';?>" >Assigned List</a>
                        </li>
                        <li class="tab-selector <?php if($tab_type=='equipment_handover') echo 'active';?>">
                           <!--  <a href="<?php // echo base_url('assign_equipement/handover'); ?>" <?php // if($tab_type=='equipment_handover') echo' aria-expanded="true"';?>" >Equipment Handover</a> -->
                            <a href="<?php echo base_url('biomedical/assign_equipement/handover'); ?>" <?php if($tab_type=='equipment_handover') echo' aria-expanded="true"';?>" >Equipment Handover</a>
                        </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    <div class="ov_report_tabs page-tabs pad-5 margin-top-30 tabbable">
            <?php if($tab_type=='equipment_assignment'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='equipment_assignment') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('assign_equipement/v_assign_equipement');?>  
                </div>
            </div>
            <?php endif; ?>

            <?php if($tab_type=='equipment_assign_list'): ?>    
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='equipment_assign_list') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('assign_equipement/v_assign_equipment_activity');?>  
                </div>
            </div>
            <?php endif; ?>

            <?php if($tab_type=='equipment_handover'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='equipment_handover') echo "active";?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('assign_equipement/v_handover');?>  
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
 </div>
</div>
</div>