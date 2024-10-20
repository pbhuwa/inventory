<?php
   $this->usergroup = $this->session->userdata(USER_GROUPCODE);

   $stock_view_group = array('SI','SK','SA');

   $approved_status=!empty($requistion_data[0]->rema_approved)?$requistion_data[0]->rema_approved:'';
?>

<?php
            if(in_array($this->usergroup, $stock_view_group)):
         ?>
         <div>
            <a href="javascript:void(0)" class="btnSelectNotAvailable btn btn-xs btn-danger">Select Unavailable Stock</a>

            <a href="javascript:void(0)" class="btnSelectAvailable btn btn-xs btn-success">Select Available Stock</a>
         </div>
         <?php
            endif;
         ?>

      <?php 
         if(!empty($req_detail_list)) { 
      ?>
         <table style="width:100%;" class="table dataTable con_ttl dt_alt purs_table">
            <thead>
               <tr>
                  <?php
                     if(in_array($this->usergroup, $stock_view_group)):
                  ?>
                  <!-- <th width="2%"><input type="checkbox" class="checkall"><?php echo $this->lang->line('all'); ?> </th> -->

                  <th width="2%"></th>
                  <?php
                     endif;
                  ?>

                  <th width="5%"><?php echo $this->lang->line('sn'); ?> </th>
                  <th width="8%"><?php echo $this->lang->line('item_code'); ?>   </th>
                  <th width="20%"><?php echo $this->lang->line('item_name'); ?>   </th>
                  <th width="5%"><?php echo $this->lang->line('unit'); ?>   </th>
                  <th width="5%"><?php echo $this->lang->line('qty'); ?>   </th>
                  <th width="5%"><?php echo $this->lang->line('rem_qty'); ?>  </th>

                  <?php
                     //show stock quantity only to store incharge
                     if(in_array($this->usergroup, $stock_view_group)):
                  ?>
                     <th width="5%"><?php echo $this->lang->line('stock_quantity'); ?> </th>
                  <?php
                     endif;
                  ?>

                  <?php
                     // option for branch manager to recommend qty
                     if($this->usergroup == 'DS'):
                       ?>
                       <th width="5%"><?php echo $this->lang->line('recommend_qty'); ?> </th>
                  <?php
                     endif;
                  ?>

                  <th width="5%"><?php echo $this->lang->line('rate'); ?> </th>
                  <th width="5%"><?php echo $this->lang->line('total_amount'); ?> </th>
                       
                  <?php
                     if($this->usergroup == 'AO'):
                  ?>
                     <th width="5%"><?php echo $this->lang->line('available_budget'); ?> </th>
                     <th width="5%"><?php echo $this->lang->line('budget_status'); ?> </th>
                  <?php
                     endif;
                  ?>
               </tr>
            </thead>
            
            <tbody>
               <?php foreach ($req_detail_list as $key => $value) { ?>
               <tr class="orderrow <?php 
                  if($this->usergroup == 'SI' || $this->usergroup == 'SK')
                  { 
                     // if($value->cur_stock_qty == 0)
                     // {
                     //    echo "danger";
                     // }else{
                     //    echo "warning"; 
                     // }
                     if($value->cur_stock_qty <= '0.00'):
                        echo "danger";
                     elseif($value->rede_remqty > $value->cur_stock_qty):
                        echo "danger";
                     elseif($value->rede_remqty <= $value->cur_stock_qty):
                       echo "";
                     else:
                        echo "";
                     endif;
                  } ?>">

                  <?php
                     if(in_array($this->usergroup, $stock_view_group)):
                  ?>
                  <td> 
                     <?php
                        if($value->cur_stock_qty <= '0.00'):
                           // $stock_class = 'stockzero';
                           $stock_class = 'stocknotavailable';
                        elseif($value->rede_remqty > $value->cur_stock_qty):
                           $stock_class = 'stocknotavailable';
                        elseif($value->rede_remqty <= $value->cur_stock_qty):
                           $stock_class = 'stockavailable';
                        else:
                           $stock_class = '';
                        endif;
                     ?>
                     <?php 
                        if($value->rede_proceedissue != 'Y' && $value->rede_proceedpurchase != 'Y'):?>
                        <input type="checkbox" name="itemsid[]" value="<?php echo $value->rede_itemsid; ?>" class="itemcheck <?php echo $stock_class; ?>" data-itemcode="<?php echo $value->itli_itemcode ?>" data-itemname="<?php echo $value->itli_itemname ?>" data-unitname="<?php echo $value->unit_unitname ?>" data-qty="<?php echo $value->rede_qty ?>" data-remqty="<?php echo $value->rede_remqty ?>" data-unitprice="<?php echo number_format($value->rede_unitprice,2) ?>" data-totalamt="<?php echo number_format($value->rede_totalamt,2) ?>" />
                     <?php 
                        endif;
                     ?>
                  </td>
                  <?php
                     endif;
                  ?>

                  <td><?php echo $key+1; ?></td>
                  <td><?php echo $value->itli_itemcode ?></td>
                  <td><?php echo $value->itli_itemname ?></td>
                  <td><?php echo $value->unit_unitname ?></td>
                  <td><?php echo $value->rede_qty ?></td>
                  <td><?php echo $value->rede_remqty ?></td>
                  
                  <?php
                     if(in_array($this->usergroup, $stock_view_group)):
                  ?>
                  <td><?php echo $value->cur_stock_qty ?></td>
                  <?php
                     endif;
                  ?>
                 
                  <?php
                     if($this->usergroup == 'DS'):
                  ?>
                  <td>
                     <?php
                        $readonly = '';
         
                        if(!empty($value->rede_recommendqty) || !empty($approved_status)):
                           $readonly = 'readonly';
                        endif;
                     ?>
                     <input type="text" name="recommend_qty[]" class="form-control float recommend_qty" value="<?php echo !empty($value->rede_recommendqty)?$value->rede_recommendqty:$value->rede_remqty; ?>" name="items_id[]" <?php echo $readonly; ?> />
                     <input type="hidden" value="<?php echo $value->rede_itemsid; ?>" name="items_id[]" class="items_id" />
                  </td>
                  <?php
                     endif;
                  ?>
                
                  <td><?php echo number_format($value->rede_unitprice,2) ?></td>
                  <td><?php echo number_format($value->rede_totalamt,2) ?></td>
                  <?php
                     if($this->usergroup == 'AO'):
                  ?>
                  <td><?php echo number_format($value->budg_availableamt,2) ?></td>
                  <td>
                     <?php 
                        if($value->budget_status == 'Y'):
                     ?>
                     <span class="badge badge-sm badge-success">Available</span>
                     <?php
                        else:
                     ?>
                     <span class="badge badge-sm badge-danger">Not Available</span>
                     <?php endif; ?>
                  </td>
                  <?php
                     endif;
                  ?>
               </tr>
               <?php } ?>
            </tbody>
            
            <tfoot>
               <tr id="processdiv" style="display: none;">
                  <td colspan="12">
                     <div class="">

                        <?php
                           $handover_cur_status = !empty($handover_status[0]->harm_currentstatus)?$handover_status[0]->harm_currentstatus:'';

                           if($handover_cur_status == 'R'):
                        ?>
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger" id="process_procurement">Process To Procurement</a>
                        <?php
                           else:
                        ?>
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="central_request">Request To Central Office</a>
                        <?php
                           endif;
                        ?>
                     </div>
                  </td>
               </tr>

               <tr id="processIssueDiv" style="display: none;">
                  <td colspan="12">
                     <div class="">
                        <a href="javascript:void(0)" class="btn btn-sm btn-success" id="proceed_to_issue">Proceed to Issue</a>
                     </div>
                  </td>
               </tr> 

            </tfoot>
         </table>
      <?php } ?>