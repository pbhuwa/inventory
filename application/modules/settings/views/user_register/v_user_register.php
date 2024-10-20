
    <div class="row">
     <!--    <div class="col-sm-12">
            <div class="white-box">
                
                <div id="FormDiv" class="formdiv frm_bdy">
               <?php //$this->load->view('settings/user_register/v_user_register_form') ;?>
                </div>
            </div>
        </div> -->

     <div class="col-sm-12">
            <a href="javascript:void(0)" class="pull-right btn btn-sm btn-success btnRefresh"><i class="fa fa-refresh" aria-hidden="true"></i></a>
            <div class="white-box">
                <h3 class="box-title">Registered Users List</h3>
                <div class="table-responsive dtable_pad scroll">
                    <div id="TableDiv">
                        <?php echo $this->load->view('v_user_register_list'); ?>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
</div>
