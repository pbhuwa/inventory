<div class="row">
        <div class="col-sm-4">
            <div class="white-box">
                <h3 class="box-title"><?php echo $this->lang->line('lease_company_setup'); ?></h3>
                 <div id="FormDiv" class="formdiv frm_bdy">
                <?php $this->load->view('lease_company/v_lease_company_form') ;?>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
             <a href="javascript:void(0)" class="pull-right btn btn-sm btn-success btnRefresh"><i class="fa fa-refresh" aria-hidden="true"></i></a>
              <div class="white-box">
                <h3 class="box-title"><?php echo $this->lang->line('list_of_lease_company'); ?></h3>
                <div class="table-responsive dtable_pad scroll">
                    <input type="hidden" id="EditUrl" value="<?php echo $editurl; ?>" >
                    <input type="hidden" id="DeleteUrl" value="<?php echo $deleteurl; ?>" >
                    <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
                    <div id="TableDiv">
                         <?php $this->load->view('lease_company/v_lease_company_list') ;?>
                    </div>
                </div>
            </div>

          
        </div>
    </div>
</div>
</div>
                   
                    

