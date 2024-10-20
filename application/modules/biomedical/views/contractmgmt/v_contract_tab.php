<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('contractor_management'); ?></h3>

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
                   <!--  <div class="self-tabs">
                <ul class="nav nav-tabs form-tabs">
                    <li class="tab-selector <?php if($tab_type=='form') echo 'active';?>">
                        <a href="<?php echo base_url('biomedical/contractmanagement'); ?>" <?php if($tab_type=='form') echo' aria-expanded="true"';?>" >New Contract</a>
                    </li>
                    <li class="tab-selector <?php if($tab_type=='list') echo 'active';?>">
                        <a href="<?php echo base_url('biomedical/contractmanagement/Contractor_list'); ?>">List Contract</a>
                    </li>
                       <li class="tab-selector <?php if($tab_type=='report') echo 'active';?>">
                        <a href="<?php echo base_url('biomedical/contractmanagement/reports'); ?>">Report</a>
                    </li>
                     <li class="tab-selector <?php if($tab_type=='renew') echo 'active';?>">
                        <a href="<?php echo base_url('biomedical/contractmanagement/contract_renewal'); ?>">Renew Contract</a>
                    </li>
                  
                </ul>
            </div> -->
        </div>
    </div>
    <div class="ov_report_tabs page-tabs pad-5 margin-top-30 tabbable">
                 <?php if($tab_type=='form'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='form') echo "active"; ?>">
                <div  id="FormDiv_contractmgmt" class="formdiv frm_bdy">
                    <?php $this->load->view('contractmgmt/v_contractmgmtform');?>  
                </div>
            </div>
            <?php endif; ?>
                 <?php if($tab_type=='list'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='list') echo "active"; ?>">
                <div  id="FormDiv_contractmgmt" class="formdiv frm_bdy">
                    <?php $this->load->view('contractmgmt/v_contractmgmt_list');?>
                </div>
            </div>
            <?php endif; ?>
               <?php if($tab_type=='report'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='report') echo "active"; ?>">
                <div  id="FormDiv_contractmgmt" class="formdiv frm_bdy">
                    <?php $this->load->view('contractmgmt/v_contractreport');?>
                </div>
            </div>
            <?php endif; ?>
               <?php if($tab_type=='renew'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='renew') echo "active"; ?>">
                <div  id="FormDiv_contractmgmt" class="formdiv frm_bdy">
                    <?php $this->load->view('contractmgmt/v_contractrenewal');?>
                </div>
            </div>
            <?php endif; ?>

          

        </div>
    </div>
 </div>
</div>