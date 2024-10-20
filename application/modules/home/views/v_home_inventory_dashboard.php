<script src="<?php echo base_url().PLUGIN_DIR ?>highcharts/highcharts.js"></script>
<script src="<?php echo base_url().PLUGIN_DIR ?>highcharts/exporting.js"></script>

<div style="text-align: center;">
    Dear <?php echo $this->session->userdata(USER_NAME); ?>, 
    Welcome To Dashboard

   <p>You are at Dashboard of <?php if(defined('ORGNAME')) echo ORGNAME;  ?> Inventory Management System</p>

</div>
<div class="date-section">
           <div class="white-box">
             <form action="" method="post">
               <div class="row">
                 <div class="col-md-5">
                   <div class="form-group">
                   
                     <input type="text" name="fromDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" placeholder="From" id="fromdate" value="<?php echo !empty($this->input->post('fromDate'))?$this->input->post('fromDate'):CURMONTH_DAY1; ?>" autocomplete="off">
                   </div>
                 </div>
                 <div class="col-md-5">
                   <div class="form-group">
                     <div class="form-group">
                     
                       <input type="text" name="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" placeholder="To" id="todate" value="<?php echo !empty($this->input->post('toDate'))?$this->input->post('toDate'):DISPLAY_DATE; ?>" autocomplete="off">
                     </div>
                   </div>
                 </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <button type="submit" class="table-cell width_30 btn btn-success"><i class="fa fa-search"></i></button>
                    </div>
                </div>
               </div>
             </form>
           </div>
          </div>
<div class="bio_dash">
    <div class="row">
        <div class="col-sm-12">
            <?php 
                $useraccess= $this->session->userdata(USER_ACCESS_TYPE);
                $orgid= $this->session->userdata(ORG_ID);
                
                    if($orgid==1)
                    {
                            $this->load->view('v_bio_medical_dashboard');
                    }
                    if($orgid==2)
                    {
                        $this->load->view('v_assets_dashboard');
                    }
                    if($orgid==3)
                    {
                     
                        $this->load->view('v_stock_dashboard');
                    }
               
               
                ?>
            <div class="white-box displaydetail" >   
            </div>
        </div>

    </div>
    </div>
</div>
<script type="text/javascript">
     $( function() {
    $( ".datepicker" ).datepicker();
    $( ".datepicker1" ).datepicker();
    });
      
</script>