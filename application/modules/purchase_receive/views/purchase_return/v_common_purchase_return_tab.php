     <div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
                <h3 class="box-title"><?php echo $this->lang->line('direct_purchase_return_purchase_return_purchase_return_summary_purchase_return_detail'); ?></h3>


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
                     <li class="tab-selector <?php if($current_tab=='direct_purchase_return') echo 'active';?>">
                        <a href="<?php echo base_url('purchase_receive/purchase_return/direct'); ?>" <?php if($current_tab=='direct_purchase_return') echo' aria-expanded="true"';?>" >Direct Purchase Return</a>
                    </li>                     <li class="tab-selector <?php if($current_tab=='purchase_return') echo 'active';?>"><a href="<?php echo base_url('purchase_receive/purchase_return'); ?>" <?php if($current_tab=='purchase_return') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('purchase_return'); ?></a></li>
                     
                    <li class="tab-selector <?php if($current_tab=='purchase_return_list') echo 'active';?>"><a href="<?php echo base_url('purchase_receive/purchase_return/purchase_return_item_list'); ?>"><?php echo $this->lang->line('purchase_return_summary'); ?> </a></li>

                    <li class="tab-selector <?php if($current_tab=='purchase_return_detail_list') echo 'active';?>"><a href="<?php echo base_url('purchase_receive/purchase_return/purchase_return_item_detail_list'); ?>" <?php if($current_tab=='purchase_return_detail_list') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('purchase_return_detail'); ?></a></li> 
                </ul>
              
            </div> -->
            </div>
            <div class="ov_report_tabs page-tabs margin-top-250 pad-5 tabbable">
           <!--  <?php if($current_tab=='direct_purchase_return'): ?>      
                <div id="dtl_rpt" class="tab-pane fade in  <?php if($current_tab=='direct_purchase_return') echo "active"; ?>">
                    <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                        
                        <?php $this->load->view('purchase_return/v_purchase_return_form');?>
                    </div>
                </div>
            <?php endif; ?> -->
            <?php if($current_tab=='purchase_return'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($current_tab=='purchase_return') echo "active"; ?>">
                        <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            
                            <?php $this->load->view('purchase_return/v_purchase_return_form');?>
                        </div>
            </div>
            <?php endif; ?>
                 <?php if($current_tab=='purchase_return_list'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_tab=='purchase_return_list') echo "active"; ?>">
                    <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <?php $this->load->view('purchase_return/v_purchase_return_lists');?>
                        </div>
                  
                    </div>
            <?php endif; ?>
             <?php if($current_tab=='purchase_return_detail_list'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_tab=='purchase_return_detail_list') echo "active"; ?>">
                    <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <!-- );?> -->
                            <?php $this->load->view('purchase_return/v_purchase_return_detail_list');?>
                        </div>
                  
                    </div>
            <?php endif; ?>
        </div>
        </div>
    </div>
</div>


            