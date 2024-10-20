    <div class="row">
       
            <div class="white-box">
                <form id="FormConstant" action="<?php echo base_url('settings/system_setting/update_constant'); ?>"  method="post" >
                <h3 class="box-title">Constant List <a href="javascript:void(0)" class="pull-right btn btn-sm btn-success btnRefresh no-pos" ><i class="fa fa-refresh" aria-hidden="true"></i></a></h3>
                <div class="table-responsive dtable_pad scroll " >
                    <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
                    <div id="TableDiv">           
                    <?php echo $this->load->view('v_system_list'); ?>
                </div>
            </div>
                <button type="submit" class="btn btn-info  save" data-operation='<?php echo 'update' ?>' id="btn_constant" >Update</button>
                </form>
                
            </div>
       
    </div>
                   
                    

