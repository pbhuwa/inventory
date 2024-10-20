


<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('assets_insurance'); ?></h3>
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
                    <li class="tab-selector <?php if($insurance=='add_insurance') echo 'active';?>">
                        <a href="<?php echo base_url('ams/asset_insurance'); ?>" <?php if($insurance=='add_insurance') echo' aria-expanded="true"';?>><?php echo $this->lang->line('asset_insurance_setup'); ?></a>
                    </li>

                   <li class="tab-selector <?php if($insurance=='summary') echo 'active';?>">
                        <a href="<?php echo base_url('ams/asset_insurance/insurance_summary'); ?>"<?php if($insurance=='summary') echo' aria-expanded="true"';?>><?php echo $this->lang->line('list_of_asset_insurance'); ?></a>
                    </li>

                   
                    
                </ul>
            </div>
        </div>
    </div>
    <div class="ov_report_tabs page-tabs pad-5 margin-top-30 tabbable">
                 <?php  if($insurance=='add_insurance'): ?>      
            <div class="tab-pane fade in  <?php if($insurance=='add_insurance') echo "active"; ?>">
                        <div id="FormDiv" class="formdiv frm_bdy">
                            <!-- <?php// $this->load->view('asset_insurance/v_asset_insurance_form');?>   -->
                            <?php $this->load->view('asset_insurance/v_form_asset_insurance');?>  

                        </div>
            </div>
            <?php endif; ?>

<?php  if($insurance=='summary'): ?>  
             <div class="tab-pane fade in  <?php if($insurance=='summary') echo "active"; ?>">
                <div class="table-responsive dtable_pad scroll">
                    <input type="hidden" id="EditUrl" value="<?php echo $editurl; ?>" >
                    <input type="hidden" id="DeleteUrl" value="<?php echo $deleteurl; ?>" >
                    <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
                   <div id="FormDiv" class="formdiv frm_bdy">
                         <?php $this->load->view('asset_insurance/v_asset_insurance_list') ;?>
                    </div>
                </div>
            </div>
            <?php endif; ?>


        </div>
    </div>
</div>
</div>








<!-- <div class="row">

        <div class="col-sm-4">
            <div class="white-box">
                <h3 class="box-title"><?php// echo $this->lang->line('asset_insurance_setup'); ?></h3>
                 <div id="FormDiv" class="formdiv frm_bdy">
                <?php// $this->load->view('asset_insurance/v_asset_insurance_form') ;?>
                </div>
            </div>
        </div>


        <div class="col-sm-8">
             <a href="javascript:void(0)" class="pull-right btn btn-sm btn-success btnRefresh"><i class="fa fa-refresh" aria-hidden="true"></i></a>
              <div class="white-box">
                <h3 class="box-title"><?php //echo $this->lang->line('list_of_asset_insurance'); ?></h3>
                <div class="table-responsive dtable_pad scroll">
                    <input type="hidden" id="EditUrl" value="<?php //echo $editurl; ?>" >
                    <input type="hidden" id="DeleteUrl" value="<?php //echo $deleteurl; ?>" >
                    <input type="hidden" id="ListUrl" value="<?php //echo $listurl; ?>" >
                    <div id="TableDiv">
                         <?php //$this->load->view('asset_insurance/v_asset_insurance_list') ;?>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
</div>  
        -->             

