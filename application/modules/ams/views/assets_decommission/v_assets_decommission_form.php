
<div class="row">
    <div class="col-sm-6">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('asset_decommission'); ?></h3>
            <div id="FormDiv" class="formdiv frm_bdy">
                <form method="post" id="FormComments" action="<?php echo base_url('ams/asset_decommission/save_decommission'); ?>"  class="form-material form-horizontal form">
                    <div class="form-group mbtm_0">
                        <input type="hidden" value="<?php echo !empty($eqli_data[0]->asen_asenid)?$eqli_data[0]->asen_asenid:''; ?>" name="deeq_equipid" id="eqco_eqid"/>
                        <?php $this->load->view('assets/assets_detail'); ?>
                        <div class="clear"></div>
                        <div class="col-md-12 ">
                            <label><?php echo $this->lang->line('decommission_method'); ?></label>
                            <select name="deeq_decid" class="form-control required_field select2">
                                <option value="">---select---</option>
                                <?php
                                    if($method):
                                        foreach ($method as $km => $mat):
                                ?> 
                                <option value="<?php echo $mat->deme_decid; ?>" ><?php echo $mat->deme_decomname; ?></option>
                                <?php 
                                        endforeach;
                                    endif;
                                ?>
                            </select>
                        </div>
                        
                        <div class="col-md-12">
                            <label><?php echo $this->lang->line('reason_decommission'); ?><span class="required">*</span>: </label>
                            <textarea style="width: 100%;height: 50px;" name="deeq_reason" class="form-control" autofocus="true"></textarea>
                        </div>
                       

                        <div class="col-sm-12">
                         <label><?php echo $this->lang->line('disposition_type'); ?><span class="required">*</span>: </label>
                       <input type="radio" name="deeq_disposition" value="auction/sale" id="chky"  checked ><?php echo $this->lang->line('auction_sale'); ?>
                         <input type="radio" name="deeq_disposition" value="trade-in" id="chkn" checked> <?php echo $this->lang->line('trade_in'); ?>
                         <input type="radio" name="deeq_disposition" value="donate" id="chkn" checked><?php echo $this->lang->line('donate'); ?>
                         <input type="radio" name="deeq_disposition" value="junk" id="chkn" checked  ><?php echo $this->lang->line('junk'); ?>
                        </div>
                        
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-info save mtop_10" >Save</button>
                            <div class="alert-success success"></div>
                            <div class="alert-danger error"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <a href="javascript:void(0)" class="pull-right btn btn-sm btn-success btnRefresh"><i class="fa fa-refresh" aria-hidden="true"></i></a>
        <input type="hidden" id="ListUrl" value="<?php echo base_url('/ams/asset_decommission/reload_decom'); ?>">
        <input type="hidden" id="DeleteUrl" value="<?php echo base_url('/ams/asset_decommission/decommission_delete'); ?>">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('decommission_list'); ?></h3>
            <div class="table-responsive dtable_pad scroll">
          
                <div id="TableDiv">
                <?php echo $this->load->view('assets_decommission/v_decommission_list');?>
                </div>
            </div>
        </div>
    </div>
</div>