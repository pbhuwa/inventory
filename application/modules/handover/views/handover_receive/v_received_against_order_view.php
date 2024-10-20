<div>
<div class="form-group white-box pad-5 bg-gray clearfix">
    <div class="col-md-3">
        <label><?php echo $this->lang->line('receive_no'); ?> : </label>
       <span> <?php echo !empty($direct_purchase_master[0]->orderno)?$direct_purchase_master[0]->orderno:'';  ?></span>
    </div>
    <div class="col-md-3">
        <label><?php echo $this->lang->line('received_date'); ?> : </label>
         <span>
          <?php if(DEFAULT_DATEPICKER=='NP')
          {
             echo $direct_purchase_master[0]->recm_receiveddatebs;
          } 
          else 
          {
            echo $direct_purchase_master[0]->recm_receiveddatead;
          } ?>
            
          </span>
    </div>
    <div class="col-md-3">
        <label><?php echo $this->lang->line('order_date'); ?> : </label>
          <span><?php if(DEFAULT_DATEPICKER=='NP'){
             echo $direct_purchase_master[0]->recm_purchaseorderdatebs;
         } else {
            echo $direct_purchase_master[0]->recm_purchaseorderdatead;
         } ?>
         </span>
    </div>
    <div class="col-md-3">
        <label><?php echo $this->lang->line('supplier_bill_no'); ?> :</label>
         <span><?php echo  !empty($direct_purchase_master[0]->recm_supplierbillno)?$direct_purchase_master[0]->recm_supplierbillno:''; ?></span>
    </div>
    <div class="margin-top-25"></div>
    <div class="col-md-3">
        <label><?php echo $this->lang->line('fiscal_year'); ?>:</label>
       <span><?php 
          echo $direct_purchase_master[0]->recm_fyear;
         ?></span>
    </div>
    <div class="col-md-3">
        <label><?php echo $this->lang->line('bill_date'); ?> : </label>
       <span><?php if(DEFAULT_DATEPICKER=='NP'){
             echo $direct_purchase_master[0]->recm_supbilldatebs;
         } else {
            echo $direct_purchase_master[0]->recm_supbilldatead;
         } ?>
         </span>
    </div>
     <div class="col-md-6">
        <label><?php echo $this->lang->line('supplier_name'); ?> : </label>
         <span><?php echo  !empty($direct_purchase_master[0]->dist_distributor)?$direct_purchase_master[0]->dist_distributor:''; ?></span>
    </div>
     <div class="col-md-6">
        <label><?php echo $this->lang->line('location'); ?> : </label>
         <span><?php echo  !empty($direct_purchase_master[0]->loca_name)?$direct_purchase_master[0]->loca_name:''; ?></span>
    </div>
    <button class="btn btn-success PrintThisNow ReprintThis pull-right" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('/purchase_receive/receive_against_order/receive_aginst_reprint') ?>" data-viewdiv="FormDiv_Reprint" data-id="<?php echo !empty($req_detail_list[0]->recd_receivedmasterid)?$req_detail_list[0]->recd_receivedmasterid:''; ?>"><?php echo $this->lang->line('reprint'); ?></button>
</div>
</div>
<!-- <button class="btn btn-success PrintThisNow ReprintThis pull-right" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('/purchase_receive/receive_against_order/receive_aginst_reprint') ?>" data-viewdiv="FormDiv_Reprint" data-id="<?php echo !empty($req_detail_list[0]->recd_receivedmasterid)?$req_detail_list[0]->recd_receivedmasterid:''; ?>"><?php echo $this->lang->line('reprint'); ?></button> -->

<div class="clearfix"></div> 
<div class="data-table" style="margin-top: 10px;">
    <?php if($req_detail_list) { ?>
        <table style="width:100%;" class="table dataTable con_ttl dt_alt purs_table">
            <thead>
                <tr>
                    <th width="5%"> <?php echo $this->lang->line('sn'); ?> </th>
                    <th width="10%"> <?php echo $this->lang->line('item_code'); ?> </th>
                    <th width="30%"> <?php echo $this->lang->line('item_name'); ?> </th>
                    <th width="5%"> <?php echo $this->lang->line('unit'); ?></th>
                    <th width="5%"> <?php echo $this->lang->line('qty'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('rate'); ?> </th>
                    <th width="10%"> <?php echo $this->lang->line('discountamount'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('vat_amount'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('total_amount'); ?> </th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($req_detail_list as $key => $value) 
              { 
                if(ITEM_DISPLAY_TYPE=='NP'){
                  $req_itemname = !empty($value->itli_itemnamenp)?$value->itli_itemnamenp:$value->itli_itemname;
                }else{ 
                    $req_itemname = !empty($value->itli_itemname)?$value->itli_itemname:'';
                }
               ?>
              <tr>
                <td><?php echo $key+1; ?></td>
                <td><?php echo $value->itli_itemcode ?></td>
                <td><?php echo $req_itemname ?></td>
                <td><?php echo $value->unit_unitname ?></td>
                <td><?php echo $value->recd_purchasedqty ?></td>
                <td><?php echo $value->recd_unitprice ?></td>
                <td><?php echo $value->recd_discountamt ?></td>
                <td><?php echo $value->recd_vatamt ?></td>
                <td><?php echo $value->recd_amount ?></td>
              </tr>
              <?php } ?>
              
                <tr class="table-footer">
             
                <td colspan="8">
                        <span style="float: right">
                        <label><?php echo $this->lang->line('discount'); ?></label>
                        </span>
                    </td>
                    <td colspan="2">
                      <?php echo number_format($direct_purchase_master[0]->recm_discount,2)?>
                    </td>

              </tr>
                <tr class="table-footer">
             
                <td colspan="8">
                        <span style="float: right">
                        <label><?php echo $this->lang->line('vat'); ?></label>
                        </span>
                    </td>
                    <td colspan="2">
                      <?php echo number_format($direct_purchase_master[0]->recm_taxamount,2)?>
                    </td>

              </tr>
              <tr class="table-footer">
             
                <td colspan="8">
                        <span style="float: right">
                        <label><?php echo $this->lang->line('grand_total'); ?></label>
                        </span>
                    </td>
                    <td colspan="2">
                      <?php echo number_format($direct_purchase_master[0]->recm_clearanceamount,2)?>
                    </td>

              </tr>
            </tbody>
          </table>
          <div class="form-group">
            <form class="form-material form-horizontal form">
              <div class="col-md-3 col-sm-4">
                  <label for="quma_remarks"><?php echo $this->lang->line('remarks'); ?>:</label>
                 <span>
                   <?php echo !empty($direct_purchase_master[0]->recm_remarks)?$direct_purchase_master[0]->recm_remarks:''; ?>
                 </span>
              </div>
              </form>
          </div>
          <br/>
     
            <div class="addAttachmentRow">
               <div class="col-md-12 col-sm-12">
              <label>Download Bill Attachments: </label>
              <?php 

                $contractAttachments = !empty($direct_purchase_master[0]->recm_attachments)?$direct_purchase_master[0]->recm_attachments:'';
                if($contractAttachments):
                $attach = explode(', ',$contractAttachments);
                $download = "";
                if($attach):
                    foreach($attach as $key=>$value){
                        $download .= "<a href='".base_url().RECEIVED_BILL_ATTACHMENT_PATH.'/'.$value."' target='_blank'><img src='".base_url().RECEIVED_BILL_ATTACHMENT_PATH.'/'.$value."' style='width:100px;'/><a>&nbsp;&nbsp;&nbsp;";
                        }
                endif;
                echo $download;
            endif;
              ?>
            </div>
          </div>

          <div class="form-group">
           <form method="post" id="FormReceiveOrderItem" action="<?php echo base_url('purchase_receive/receive_against_order/upload_attachment'); ?>" class="form-material form-horizontal form" data-reloadurl="<?php echo base_url('purchase_receive/receive_against_order/received_order_item_list'); ?>" enctype="multipart/form-data"  accept-charset="utf-8" >
              <input type="hidden" name="id" value="<?php echo $master_id  ?>" />
              <div class="col-md-3 col-sm-4">
                 <label>Attachments</label>
                      <div class="dis_tab">
                          <input type="file" id="recm_attachments" name="recm_attachments[]"/>
                          <input type="hidden" name="recm_attach[]">
                          <a href="javascript:void(0)" class="btn btn-info table-cell width_30" id="addAttachments">+</a>
                      </div>
                      <div class="addAttachmentRow1">
                          <?php 

                          $contractAttachments = !empty($contract_data[0]->recm_attachments)?$contract_data[0]->recm_attachments:'';
                          if($contractAttachments):
                          $attach = explode(', ',$contractAttachments);
                          $download = "";
                          if($attach):
                              foreach($attach as $key=>$value){
                                  $download .= "<a href='".base_url().RECEIVED_BILL_ATTACHMENT_PATH.'/'.$value."' target='_blank'>Download<a>&nbsp;&nbsp;&nbsp;";
                                  }
                          endif;
                          echo $download;
                      endif;
                          ?>
                      </div>
                   </div>
                 <div class="col-md-12"> 
                    <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($order_item_details)?'update':'save' ?>' id="btnSubmit" >Save</button>
                 </div>

                <div class="col-sm-12">
                    <div  class="alert-success success"></div>
                    <div class="alert-danger error"></div>
               </div>
              </form>
          </div>
          <br/>
        </div>
   </div>
    
    <?php } ?>
    </div>
<div class="clearfix"></div>
<div id="FormDiv_Reprint" class="printTable"></div> 
<script type="text/javascript">
    $(document).ready(function(){
        
        $(document).off('click','#addAttachments');
        $(document).on('click','#addAttachments',function(){
            $(".addAttachmentRow1").append('<div class="dis_tab mtop_5"><input type="file" name="recm_attachments[]" "/><input type="hidden" name="recm_attach[]"><a class="btn btn-danger table-cell width_30 btnminus"><span class="fa fa-trash"></span></a></div>');
        });
    
        $(document).off('click','.btnminus');
        $(document).on('click','.btnminus',function(){
            $(this).closest('div').remove();
        });
    });
</script>