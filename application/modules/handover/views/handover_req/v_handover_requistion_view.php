  <div class="list_c2 label_mw125">
    <div class="form-group row resp_xs">
      <div class="white-box pad-5">
        <div class="row">
          <div class="col-sm-4 col-xs-6">
            <label><?php echo $this->lang->line('requisition_no'); ?></label>: 
            <?php echo !empty($requistion_data[0]->harm_handoverreqno)?$requistion_data[0]->harm_handoverreqno:''; ?>
          </div>
          <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('manual_no'); ?></label>: 
            <?php echo !empty($requistion_data[0]->harm_manualno)?$requistion_data[0]->harm_manualno:''; ?>
          </div>
          <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('date'); ?></label>: 
            <span class="inline_block">
              <?php echo !empty($requistion_data[0]->harm_reqdatebs)?$requistion_data[0]->harm_reqdatebs:''; ?>(BS), <?php echo !empty($requistion_data[0]->harm_reqdatead)?$requistion_data[0]->harm_reqdatead:''; ?>(AD)
            </span>
          </div>
          <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('req_from_branch'); ?></label>: 
            <?php 
            echo !empty($requistion_data[0]->fromloc)?$requistion_data[0]->fromloc:'';
            ?>
          </div>
          
          <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('req_from_department'); ?></label> : 
            <?php echo !empty($requistion_data[0]->fromdepname)?$requistion_data[0]->fromdepname:'';
            ?>
          </div>
          <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('to_branch'); ?></label>: 
            <?php 
            
            echo !empty($requistion_data[0]->toloc)?$requistion_data[0]->toloc:'';
            
            ?>
          </div>

          <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('requisited_by'); ?> </label>: 
            <?php 
            $reqby=!empty($requistion_data[0]->harm_requestedby)?$requistion_data[0]->harm_requestedby:'';
            echo $reqby;
            ?>
          </div>

          <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('status'); ?> </label>: 
            
            <?php 
            $approved_status=!empty($requistion_data[0]->harm_approved)?$requistion_data[0]->harm_approved:'';
            if($approved_status==1)
            {
              echo "<span class='approved badge badge-sm badge-success'>Approved</span>"; 
            }
            else if($approved_status==2)
            {
              echo "<span class='n_approved badge badge-sm badge-info'>Unapproved</span>";
            }
            else if($approved_status==3)
            {
              echo "<span class='cancel badge badge-sm badge-danger'>Canceled</span>";
            }
            else if($approved_status==4)
            {
              echo "<span class='cancel badge badge-sm badge-success'>Verified</span>";
            }
            else
            {
              echo "<span class='pending badge badge-sm badge-warning'>Pending</span>";
            }
            ?>
          </div> 
        </div>
      </div>
      <div class="clearfix"></div> 
      <?php if($req_detail_list) { ?>
        <table style="width:100%;" class="table dataTable con_ttl dt_alt purs_table">
          <thead>
            <tr>
              <th width="5%"><?php echo $this->lang->line('sn'); ?> </th>
              <th width="10%"><?php echo $this->lang->line('item_code'); ?>   </th>
              <th width="30%"><?php echo $this->lang->line('item_name'); ?>   </th>
              <th width="5%"><?php echo $this->lang->line('unit'); ?>   </th>
              <th width="5%"><?php echo $this->lang->line('qty'); ?>   </th>
              <th width="10%"><?php echo $this->lang->line('rem_qty'); ?>  </th>
              <th width="5%"><?php echo $this->lang->line('stock_quantity'); ?> </th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($req_detail_list as $key => $value) { ?>
              <tr>
                <td><?php echo $key+1; ?></td>
                <td><?php echo $value->itli_itemcode ?></td>
                <td><?php echo $value->itli_itemname ?></td>
                <td><?php echo $value->unit_unitname ?></td>
                <td><?php echo $value->hard_qty ?></td>
                <td><?php echo $value->hard_remqty ?></td>
                <td><?php echo $value->hard_qtyinstock ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } ?>
      <div class="clearfix"></div>
      <br>
      <div class="list_c2 label_mw125">
        <form id="FormChangeStatus" action="<?php echo base_url('handover/handover_req/change_status_handover');?>" method="POST">
          <input type="hidden" name="masterid" value="<?php echo !empty($requistion_data[0]->harm_handovermasterid)?$requistion_data[0]->harm_handovermasterid:'';  ?>">
          <div class="form-group">
            <div class="col-ms-12">
              <div class="row">
                   <div class="col-sm-3">
                        <?php
                            if(defined('TWO_LEVEL_APPROVAL')):
                                if(TWO_LEVEL_APPROVAL == 'Y'):
                                    if($approved_status != 1 && $approved_status != 4){
                        ?>
                            <div class="col-sm-12">
                                <label for="example-text"><?php echo $this->lang->line('verified'); ?>  : </label>
                                <input type="radio" class="mbtm_13 cancel" name="approve_status"  value="1" id="verified">
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
                                <input type="radio" class="mbtm_13 cancel" name="approve_status"  value="2">
                            </div> 
                        <?php
                                    endif;
                                else if($approved_status != 1):
                        ?>
                            <div class="col-sm-12">
                                <label for="example-text"><?php echo $this->lang->line('approved'); ?>  : </label>
                                <input type="radio" class="mbtm_13 cancel" name="approve_status"  value="2">
                            </div> 
                        <?php 
                                endif;
                            endif;
                        ?>
                        <?php 
                          if($approved_status == 1 && $approved_status!=2) { ?>
                        <div class="col-sm-12">
                            <label for="example-text"><?php echo $this->lang->line('unapproved'); ?> : </label>
                            <input type="radio" class="mbtm_13 cancel" name="approve_status" value="3">
                        </div>
                        <?php } if($approved_status!=3) { ?>
                        <div class="col-sm-12">
                            <label for="example-text"><?php echo $this->lang->line('canceled'); ?>  : </label>
                            <input type="radio" class="mbtm_13 cancel" name="approve_status"  value="4" id="cancel">
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
                    <textarea rows="3" cols="70" name="harm_unapprovedreason"></textarea>
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
    </div>  
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