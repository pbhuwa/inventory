<script src="<?php echo base_url().PLUGIN_DIR ?>highcharts/highcharts.js"></script>
<script src="<?php echo base_url().PLUGIN_DIR ?>highcharts/exporting.js"></script>
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
                if($useraccess=='S')
                {
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
                }
                else if($useraccess=='B')
                {   
                    $this->load->view('v_bio_medical_dashboard');
                    $this->load->view('v_assets_dashboard');
                } 
                ?>
            <div class="white-box displaydetail" >   
            </div>
           <!--  <div class="wb_form">
                <div class="white-box">
                    <h3 class="box-title">REQUISTION REQUEST</h3>
                    <div class="pad-5">
                        <div class="table-responsive">
                            <table id="pmalert"  class="table table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th width="5%">S.n.</th>
                                        <th width="10%">Req No</th>
                                        <th width="15%">Date (AD)</th>
                                        <th width="15%">Date (BS)</th>
                                        <th width="15%">Dept.</th>
                                        <th width="15%">Request</th>
                                        <th width="5%"></th>
                                        <th width="20%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> -->
           <!--  <div class="wb_form">
                <div class="white-box">
                    <h3 class="box-title">Warrenty Alert</h3>
                    <div class="pad-5">
                        <div class="table-responsive">
                            <table id="warrentyalert"  class="table table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th width="5%">S.n.</th>
                                        <th width="10%">Equp No</th>
                                        <th width="10%">Description</th>
                                        <th width="15%">Department</th>
                                        <th width="15%">Risk</th>
                                        <th width="15%">End. War.(AD)</th>
                                        <th width="15%">End. War.(BS)</th>
                                        <th width="20%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        
        <div class="col-sm-6">
        <?php $this->load->view('v_contract_assets');?>
       </div>
       <div class="col-sm-6">
        <?php $this->load->view('v_amc_list'); ?>
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
<script type="text/javascript">
 $(document).on('click', '.commentRefresh', function() {
  var tableid=$(this).data('tableid');
               var dtablelist = $('#'+tableid).dataTable();       
            dtablelist.fnDraw();
        });
</script>



