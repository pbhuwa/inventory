 <div class="list_c2 label_mw125">

        <form id="FormChangeStatus" action="<?php echo base_url('ams/repair_work_order/change_status');?>" method="POST">

            <input type="hidden" name="masterid" value="<?php echo !empty($assets_repair_work_order_master[0]->rewm_repairordermasterid)?$assets_repair_work_order_master[0]->rewm_repairordermasterid:'';  ?>">

            <div class="form-group">

                <div class="col-ms-12">

                  <div class="row">

                    <div class="col-sm-3">

                        <?php

                        $approved_status=$assets_repair_work_order_master[0]->rerm_approved;

                            if(defined('TWO_LEVEL_APPROVAL')):

                                if(TWO_LEVEL_APPROVAL == 'Y'):

                                    if($approved_status != 1 && $approved_status != 4){

                        ?>

                            <div class="col-sm-12">

                                <label for="example-text"><?php echo $this->lang->line('verified'); ?>  : </label>

                                <input type="radio" class="mbtm_13 cancel" name="approve_status"  value="4" id="verified">

                            </div>

                        <?php

                                }

                                endif;

                            endif;

                        ?>



                         <?php

                            if(defined('TWO_LEVEL_APPROVAL')):

                                if(TWO_LEVEL_APPROVAL == 'Y')

                                    if($approved_status == 4 && $approved_status != 1):

                        ?>

                            <div class="col-sm-12">

                                <label for="example-text"><?php echo $this->lang->line('approved'); ?>  : </label>

                                <input type="radio" class="mbtm_13 cancel" name="approve_status"  value="1">

                            </div> 

                        <?php

                                    endif;

                                else if($approved_status != 1):

                        ?>

                            <div class="col-sm-12">

                                <label for="example-text"><?php echo $this->lang->line('approved'); ?>  : </label>

                                <input type="radio" class="mbtm_13 cancel" name="approve_status"  value="1">

                            </div> 

                        <?php 

                                endif;

                            endif;

                        ?>

                        <?php 

                          if($approved_status == 1 && $approved_status!=2) { ?>

                        <div class="col-sm-12">

                            <label for="example-text"><?php echo $this->lang->line('unapproved'); ?> : </label>

                            <input type="radio" class="mbtm_13 cancel" name="approve_status" value="2">

                        </div>

                        <?php } if($approved_status!=3) { ?>

                        <div class="col-sm-12">

                            <label for="example-text"><?php echo $this->lang->line('canceled'); ?>  : </label>

                            <input type="radio" class="mbtm_13 cancel" name="approve_status"  value="3" id="cancel">

                        </div>

                        <?php } ?>

                        

                    </div>

                    <div class="col-sm-9">

                      <div class="col-md-6 showCancel" id="cancelReason">

                        <label for="example-text"><?php echo $this->lang->line('cancel_reason'); ?>: </label><br>

                        <textarea rows="3" cols="70" name="cancel_reason"></textarea>

                      </div>

                      <div class="col-md-6 showUnapproved" id="cancelReason">

                        <label for="example-text"><?php echo $this->lang->line('unapproved_reason'); ?>: </label><br>

                        <textarea rows="3" cols="70" name="unapprovedreason"></textarea>

                      </div>

                    </div>

                  </div>

                   

                  

                    

                     <div class="col-md-12">

                        <!-- <label>&nbsp;</label> -->

                       <button type="submit" class="btn btn-info  savelist" data-operation="save" id="btnDeptment" data-isdismiss="Y" data-isrefresh="Y"><?php echo $this->lang->line('save'); ?></button>

                    </div>

                    <div class="col-sm-12">

                    <div  class="alert-success success"></div>

                    <div class="alert-danger error"></div>

                  </div>

              </div>

            </div>

        </form>

    </div>



    <style>

    .showCancel { display: none;}

    .showUnapproved { display: none;}

</style>

<script> 

    $(document).off('click','.cancel');

    $(document).on('click','.cancel',function(){

        var status = $('form input[type=radio]:checked').val();

        if(status == '2')

        {

            $('.showUnapproved').show();  

        }else{

            $('.showUnapproved').hide();  

        }

        if(status == '3')

        {

            $('.showCancel').show();

        }else{

            $('.showCancel').hide();  

        }

    })

</script>