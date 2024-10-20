





<div class="row">

    <div class="col-sm-12">

        <div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">

            <div class="row">

                <div class="col-sm-12">

                    <div class="panel panel-info">

                        <div class="panel panel-heading"><?php echo $this->lang->line('unit'); ?> </div>

                        <div id="FormDiv_units" class="formdiv frm_bdy panel panel-body">

                             <?php $this->load->view('units/v_units_form') ;?>

                        </div>

                    </div>

                </div>

            

                            

                <div class="col-sm-12">  

                    <a href="javascript:void(0)" class="pull-right btn btn-sm btn-success btnRefresh"><i class="fa fa-refresh" aria-hidden="true"></i></a>

                    <div class="panel panel-info">

                         <div class="panel panel-heading"><?php echo $this->lang->line('list_of_unit'); ?></div>

                          <div class="panel panel-body data_table">

                        <div class="table-responsive">

                              <input type="hidden" id="EditUrl" value="<?php echo $editurl; ?>" >

                                <input type="hidden" id="DeleteUrl" value="<?php echo $deleteurl; ?>" >

                                <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >

                                

                            <div id="TableDiv">

                               <?php echo $this->load->view('v_units_list'); ?>

                            </div>

                        </div>

                    </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>











   



                    







