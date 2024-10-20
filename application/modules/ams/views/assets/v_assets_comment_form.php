
    <div class="row">
        <div class="col-sm-6">
            <div class="white-box">
                <h3 class="box-title"><?php echo $this->lang->line('assets_comment'); ?></h3>
                <div id="FormDiv" class="formdiv frm_bdy">
              <form method="post" id="FormComments" action="<?php echo base_url('biomedical/Bio_medical_inventory/save_comment'); ?>"  class="form-material form-horizontal form">

            <div class="form-group mbtm_0">
             <?php $this->load->view('assets/assets_detail'); ?>
              <div class="clear"></div>
              <div class="col-md-12">
                <label><?php echo $this->lang->line('describe_problem'); ?><span class="required">*</span>: </label>
                <textarea style="width: 100%;height: 50px;" name="eqco_comment" class="form-control" autofocus="true"></textarea>
                <input type="hidden" value="<?php echo !empty($eqli_data[0]->asen_asenid)?$eqli_data[0]->asen_asenid:''; ?>" name="eqco_eqid" id="eqco_eqid"/>
              </div>
              <div class="col-sm-12">
                <button type="submit" class="btn btn-info save mtop_10" >Save</button>
                 <div  class="alert-success success"></div>
                 <div class="alert-danger error"></div>
              </div>
   
            </div>
          </form>
                </div>
            </div>
        </div>



        <div class="col-sm-6">
            <a href="javascript:void(0)" class="pull-right btn btn-sm btn-success btnRefresh"><i class="fa fa-refresh" aria-hidden="true"></i></a>
            <div class="white-box">
                
                <div class="table-responsive dtable_pad scroll">

<?php if (isset ($listurl))
{?>
                       <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
<?php } if(isset($deleteurl)) { ?>
                      <input type="hidden" id="DeleteUrl" value="<?php echo $deleteurl; ?>" >
<?php } ?>              
                    <div id="TableDiv">
                <?php echo $this->load->view('assets/v_comment_list');?>
                    </div>
                </div>
            </div>
        </div>
    </div>





