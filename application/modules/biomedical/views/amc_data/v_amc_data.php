

<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <?php $org_id=$this->session->userdata(ORG_ID);
            if($org_id=='2'){ ?>
                <h3 class="box-title"><?php echo $this->lang->line('assets_amc'); ?></h3>
                <?php }else{ ?>
                <h3 class="box-title"><?php echo $this->lang->line('equipment_amc'); ?></h3>
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
                       <?php $this->load->view('common/v_common_tab_header'); ?>
                   <!--  <div class="self-tabs">
                <ul class="nav nav-tabs form-tabs">
                    <li class="tab-selector <?php if($amc_data=='addnewamc') echo 'active';?>">
                        <a href="<?php echo base_url('biomedical/amc_data'); ?>" <?php if($amc_data=='addnewamc') echo' aria-expanded="true"';?>" >Add New AMC</a>
                    </li>
                    <li class="tab-selector <?php if($amc_data=='summary') echo 'active';?>">
                        <a href="<?php echo base_url('/biomedical/amc_data/amc_summary'); ?>">AMC Summary</a>
                    </li>
                    <li class="tab-selector <?php if($amc_data=='detail') echo 'active';?>">
                        <a href="<?php echo base_url('/biomedical/amc_data/amc_detail'); ?>">AMC Detail</a>
                    </li>
                    
                </ul>
            </div> -->
        </div>
    </div>
    <div class="ov_report_tabs page-tabs pad-5 margin-top-30 tabbable">
                 <?php if($amc_data=='addnewamc'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($amc_data=='addnewamc') echo "active"; ?>">
                        <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <?php $this->load->view('biomedical/amc_data/v_amc_dataform');?>  
                        </div>
            </div>
            <?php endif; ?>
                 <?php if($amc_data=='summary'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($amc_data=='summary') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('biomedical/amc_data/v_amc_data_summary');?>
                </div>
                  
            </div>
            <?php endif; ?>
            <?php if($amc_data=='detail'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($amc_data=='detail') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('biomedical/amc_data/v_amc_data_detail');?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>



                    


                    


                    



                    

