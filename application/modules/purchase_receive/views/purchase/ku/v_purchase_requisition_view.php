<div class="list_c2 label_mw125">
    <div class="form-group row resp_xs">
        <div class="white-box pad-5">
            <div class="row">
                <div class="col-sm-4 col-xs-6">
                    <label><?php echo $this->lang->line('requisition_no'); ?></label>: 
                    <?php echo !empty($requistion_data[0]->pure_reqno)?$requistion_data[0]->pure_reqno:''; ?>
                </div>
                
                <div class="col-sm-4 col-xs-6">
                    <label for="example-text"><?php echo $this->lang->line('date'); ?></label>: 
                    <span class="inline_block">
                        <?php 
                            echo !empty($requistion_data[0]->pure_reqdatebs)?$requistion_data[0]->pure_reqdatebs:''; 
                        ?>(BS), 
                        <?php 
                            echo !empty($requistion_data[0]->pure_reqdatead)?$requistion_data[0]->pure_reqdatead:''; 
                        ?>(AD)
                    </span>
                </div>

                <div class="col-sm-4 col-xs-6">
                    <label><?php echo $this->lang->line('fiscal_year'); ?></label>: 
                    <?php echo !empty($requistion_data[0]->pure_fyear)?$requistion_data[0]->pure_fyear:''; ?>
                </div>

                <div class="col-sm-4 col-xs-6">
                    <label for="example-text"><?php echo $this->lang->line('requisited_by'); ?> </label> : 
                    <?php 
                        echo !empty($requistion_data[0]->pure_requser)?$requistion_data[0]->pure_requser:'';
                    ?>
                </div>
                 <div class="col-sm-4 col-xs-6">
                    <label for="example-text"><?php echo $this->lang->line('location'); ?> </label> : 
                    <?php 
                        echo !empty($requistion_data[0]->loca_name)?$requistion_data[0]->loca_name:'';
                    ?>
                </div>

                <div class="col-sm-4 col-xs-6">
                    <label for="example-text"><?php echo $this->lang->line('status'); ?> </label>: 
                    <?php 
                        $approved_status = !empty($requistion_data[0]->pure_isapproved)?$requistion_data[0]->pure_isapproved:'';

                        $approve_remarks = !empty($requistion_data[0]->pure_approveremarks)?$requistion_data[0]->pure_approveremarks:'';


                        if($approved_status=='Y')
                        {
                            echo "<span class='approved badge badge-sm badge-success'>Approved</span>"; 
                        }
                        else if($approved_status == 'C'){
                            echo "<span class='approved badge badge-sm badge-danger'>Cancel</span>"; 
                        }
                        else
                        {
                            echo "<span class='pending badge badge-sm badge-warning'>Pending</span>";
                        }
                    ?>
                </div>

                <div class="clearfix"></div>

                <?php
                    if($approved_status == 'Y'):
                ?>
                <div class="col-sm-4 col-xs-6">
                    <label for="approved_by">
                        <?php echo $this->lang->line('approved_by'); ?>
                    </label> :
                    <?php 
                        echo !empty($requistion_data[0]->pure_approvaluser)?$requistion_data[0]->pure_approvaluser:'';
                    ?>
                </div>

                <div class="col-sm-4 col-xs-6">
                    <label for="approved_by">
                        <?php echo $this->lang->line('approved_date'); ?>
                    </label> :
                    <?php 
                        echo !empty($requistion_data[0]->pure_approveddatead)?$requistion_data[0]->pure_approveddatead.' (AD) ':'';
                        echo !empty($requistion_data[0]->pure_approveddatebs)?$requistion_data[0]->pure_approveddatebs.' (BS)':'';
                    ?>
                </div>
                <?php
                    endif;
                ?>

                <?php
                    if($approved_status == 'C'){
                ?>
                <div class="col-sm-4 col-xs-6">
                    <label for="approved_by">
                        <?php echo $this->lang->line('cancel_by'); ?>
                    </label> :
                    <?php 
                        echo !empty($requistion_data[0]->pure_approvaluser)?$requistion_data[0]->pure_approvaluser:'';
                    ?>
                </div>

                <div class="col-sm-4 col-xs-6">
                    <label for="approved_by">
                        <?php echo $this->lang->line('cancel_date'); ?>
                    </label> :
                    <?php 
                        echo !empty($requistion_data[0]->pure_approveddatead)?$requistion_data[0]->pure_approveddatead:'';
                    ?>
                </div>

                <div class="col-sm-4 col-xs-6">
                    <label for="approved_by">
                        <?php echo $this->lang->line('cancel_reason'); ?>
                    </label> :
                    <?php 
                        echo !empty($requistion_data[0]->pure_approveremarks)?$requistion_data[0]->pure_approveremarks:'';
                    ?>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
        
        <div class="clearfix"></div> 
        
        <?php 
            if($req_detail_list) { 
        ?>
            <table style="width:100%;" class="table dataTable con_ttl dt_alt purs_table">
                <thead>
                    <tr>
                        <th width="5%"><?php echo $this->lang->line('sn'); ?> </th>
                        <th width="10%"><?php echo $this->lang->line('item_code'); ?>   </th>
                        <th width="30%"><?php echo $this->lang->line('item_name'); ?>   </th>
                        <th width="5%"><?php echo $this->lang->line('unit'); ?>   </th>
                        <th width="5%"><?php echo $this->lang->line('qty'); ?>   </th>
                        <th width="10%"><?php echo $this->lang->line('rate'); ?>  </th> </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($req_detail_list as $key => $value) { ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $value->itli_itemcode ?></td>
                        <td><?php echo $value->itli_itemname ?></td>
                        <td><?php echo $value->unit_unitname ?></td>
                        <td><?php echo $value->purd_qty ?></td>
                        <td><?php echo $value->purd_rate ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
        
        <div class="clearfix"></div>
        <br>
        
        <?php
            if($approved_status != 'C'):
        ?>
        <div class="list_c2 label_mw125">
            <form id="FormChangeStatus" action="<?php echo base_url('purchase_receive/purchase_requisition/change_status');?>" method="POST">
                <input type="hidden" name="masterid" value="<?php echo !empty($requistion_data[0]->pure_purchasereqid)?$requistion_data[0]->pure_purchasereqid:'';  ?>">
                <div class="form-group">
                    <div class="row">
                       
                        <div class="col-sm-3">
                            <?php 
                                if(defined('TWO_LEVEL_APPROVAL')):
                                    if(TWO_LEVEL_APPROVAL == 'Y'):
                                        if($approved_status!='V' && $approved_status != 'Y'){  
                            ?>
                                <div class="col-sm-12">
                                    <label for="example-text"><?php echo $this->lang->line('verified'); ?>  : </label>
                                    <input type="radio" class="mbtm_13 cancel" name="pure_isapproved"  value="V">
                                </div> 
                            <?php 
                                        }
                                    endif;
                                endif;
                            ?>

                            <?php 
                                 if(defined('TWO_LEVEL_APPROVAL')):
                                    if(TWO_LEVEL_APPROVAL == 'Y'):
                                        if($approved_status =='V' && $approved_status!='Y'):  
                            ?>
                                <div class="col-sm-12">
                                    <label for="example-text"><?php echo $this->lang->line('approved'); ?>  : </label>
                                    <input type="radio" class="mbtm_13 cancel" name="pure_isapproved"  value="Y">
                                </div> 
                            <?php 
                                        endif;
                            ?>
                            <?php
                              else:
                            ?>
                                <div class="col-sm-12">
                                    <label for="example-text"><?php echo $this->lang->line('approved'); ?>  : </label>
                                    <input type="radio" class="mbtm_13 cancel" name="pure_isapproved"  value="Y">
                                </div> 
                            <?php
                                    endif;
                                endif;
                            ?>
                            <?php
                                if($approved_status!='C') { ?>
                                    <div class="col-sm-12">
                                        <label for="example-text"><?php echo $this->lang->line('cancel'); ?> : </label>
                                        <input type="radio" class="mbtm_13 cancel" name="pure_isapproved" value="C">
                                    </div>
                            <?php 
                                } 
                            ?>
                        </div>
                        
                        <div class="col-sm-9">
                            <div class="col-md-6 showCancel" id="cancelReason">
                                <label for="example-text"><?php echo $this->lang->line('cancel_reason'); ?>: </label><br>
                                <textarea rows="3" cols="70" name="approve_remarks"></textarea>
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
            </form>
        </div>
        <?php
            endif;
        ?>
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
        if(status == 'N')
        {
            $('.showUnapproved').show();  
        }else{
            $('.showUnapproved').hide();  
        }
        if(status == 'C')
        {
            $('.showCancel').show();
        }else{
            $('.showCancel').hide();  
        }
    })
</script>