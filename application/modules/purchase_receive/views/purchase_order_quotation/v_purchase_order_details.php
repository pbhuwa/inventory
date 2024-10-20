    <?php  // echo "<pre>"; print_r($order_details);die; ?>
    <div class="form-group white-box pad-5 bg-gray">
        <div class="row">
        <div class="col-md-3 col-sm-4">
          
            <label for="example-text"><?php echo $this->lang->line('supplier_name'); ?> : </label>
             <span> <?php echo !empty($order_details[0]->dist_distributor)?$order_details[0]->dist_distributor:''; ?></span>
        </div>
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('item_types'); ?>  : </label>
            <span><?php echo !empty($order_details[0]->dept_depname)?$order_details[0]->dept_depname:''; ?></span>
        </div>
        <div class="col-md-3 col-sm-4">
            <?php $datedb=!empty($order_details[0]->puor_orderdatebs)?$order_details[0]->puor_orderdatebs:DISPLAY_DATE; //print_r($datedb);die;?>
        <label for="example-text"><?php echo $this->lang->line('order_date'); ?>: </label>
        <span><?php echo $datedb;?></span>
        </div>
        <div class="col-md-3 col-sm-4">
            <?php $deleverydb=!empty($order_details[0]->puor_deliverydatebs)?$order_details[0]->puor_deliverydatebs:''; //print_r($datedb);die;?>
              <label for="example-text"><?php echo $this->lang->line('delivery_date'); ?>: </label>
            <span><?php echo $deleverydb;?></span>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-3 col-sm-4">
            <label for=""><?php echo $this->lang->line('is_freeze'); ?> : </label>
             <span><?php echo !empty($order_details[0]->puor_isfreezer)?$order_details[0]->puor_isfreezer:''; ?></span>
        </div>
        <div class="col-md-3 col-sm-4">
            <?php $orderno=!empty($order_details[0]->puor_orderno)?$order_details[0]->puor_orderno:''; ?>
            <label for="example-text"><?php echo $this->lang->line('order_no'); ?> :</label>
            <span><?php echo $orderno; ?></span>
        </div>
        <div class="col-md-3 col-sm-4">
          <label for="example-text"><?php echo $this->lang->line('delivery_site'); ?> : </label> 
           <span><?php $dsite=!empty($order_details[0]->puor_deliverysite)?$order_details[0]->puor_deliverysite:''; ?><?php echo $dsite; ?></span>
          <span class="errmsg"></span>
        </div>
        <div class="col-md-3 col-sm-4">
            <?php $puor_requno=!empty($order_details[0]->puor_requno)?$order_details[0]->puor_requno:''; ?>
            <label for="example-text"><?php echo $this->lang->line('requisition_no'); ?> : </label>
            <span><?php echo $puor_requno; ?></span>
          <span class="errmsg"></span>
        </div>
        <div class="col-md-3 col-sm-4">
            
            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> : </label>
            <span><?php echo !empty($order_details[0]->puor_fyear)?$order_details[0]->puor_fyear:''; ?></span>

        </div>

        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('counter'); ?> : </label>
            <span><?php echo !empty($order_details[0]->eqty_equipmenttype)?$order_details[0]->eqty_equipmenttype:''; ?></span>
        </div>
          <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('status'); ?> : </label>
          
              <span><?php 
            $approved_status=!empty($order_details[0]->puor_status)?$order_details[0]->puor_status:'';
              $status=!empty($order_details[0]->puor_purchased)?$order_details[0]->puor_purchased:'';
            if($approved_status=='N' && $status==0)
            {
                 echo "<span class='pending badge badge-sm badge-warning'>Pending</span>";
             
            }
            else if($approved_status=='R' && $status==1)
            {
              echo "<span class='n_approved badge badge-sm badge-info'>Partial Received</span>";
            }
           
            else 
            {
                echo "<span class='approved badge badge-sm badge-success'>Completely Received</span>";
            }
          
            ?>
      
          </span>
        </div>


        <div class="btn-group pull-right" style=" margin-top: 15px;">


    <?php   if(($order_details[0]->puor_status=='N') || ($order_details[0]->puor_status=='R' && $order_details[0]->puor_purchased=='1' )){ ?>
    <button style="margin-right: 5px;" class="btn btn-success btnredirect" data-print="print" data-viewurl="<?php echo base_url('/purchase_receive/receive_against_order') ?>"  data-id="<?php echo !empty($order_details[0]->puor_orderno)?$order_details[0]->puor_orderno:''; ?>"><?php echo $this->lang->line('received'); ?></button>
    <?php   } ?>
            <button style="margin-right: 10px;" class="btn btn-success PrintThisNow ReprintThis" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('/purchase_receive/purchase_order/details_order_reprint') ?>" data-viewdiv="FormDiv_Reprint" data-id="<?php echo !empty($order_details[0]->puor_purchaseordermasterid)?$order_details[0]->puor_purchaseordermasterid:''; ?>"><?php echo $this->lang->line('reprint'); ?></button>
            </div>
    </div>
    </div>
<!--     <button class="btn btn-success PrintThisNow ReprintThis pull-right" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('/purchase_receive/purchase_order/details_order_reprint') ?>" data-viewdiv="FormDiv_Reprint" data-id="<?php echo !empty($order_details[0]->puor_purchaseordermasterid)?$order_details[0]->puor_purchaseordermasterid:''; ?>"><?php echo $this->lang->line('reprint'); ?></button> -->
    <div class="clearfix"></div>
<div class="form-group">
    <div class="row">
    <div class="table-responsive col-sm-12">
        <table style="width:100%;" class="table purs_table dataTable con_ttl">
            <thead>
                <tr>
                    <th width="2%"> <?php echo $this->lang->line('sn'); ?> </th>
                    <th width="10%"> <?php echo $this->lang->line('item_name'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('unit'); ?> </th>
                    <th width="10%"> <?php echo $this->lang->line('stock_quantity'); ?> </th>
                    <th width="8%"> <?php echo $this->lang->line('qty'); ?> </th> 
                    <th width="8%"> <?php echo $this->lang->line('unit_price'); ?> </th>
                    <th width="8%"><?php echo $this->lang->line('dis'); ?></th>
                    <th width="8%"> <?php echo $this->lang->line('select_vat'); ?>(%) </th>
                    <th width="5%"> <?php echo $this->lang->line('free'); ?> </th>
                    <th width="10%"> <?php echo $this->lang->line('total_amount'); ?> </th>
                    <th width="10%"><?php echo $this->lang->line('tender_no'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('remarks'); ?></th>
                </tr>
            </thead>
            <tbody id="purchaseDataBody">
            <?php if(!empty($order_details)) 
            { 
                foreach ($order_details as $key => $odr) 
                    { 
                        if(ITEM_DISPLAY_TYPE=='NP'){
                    $req_itemname = !empty($odr->itli_itemnamenp)?$odr->itli_itemnamenp:$odr->itli_itemname;
                }else{ 
                    $req_itemname = !empty($odr->itli_itemname)?$odr->itli_itemname:'';
                }
                        ?>
                <tr class="orderrow" id="orderrow_1" data-id='1'>
                    <td>
                         <?php echo $key+1; ?>
                    </td>
                    <td>
                        <?php echo $req_itemname; ?> 
                    </td>
                    <td>
                        <?php echo $odr->pude_unit;?>
                    </td>
                    <td>
                    <?php $stqty=!empty($odr->pude_stockqty)?$odr->pude_stockqty:'';?> 
                        <?php echo $stqty;?>
                    </td>
                    <td>
                        <?php $qty=!empty($odr->pude_quantity)?$odr->pude_quantity:'';?> 
                        <?php echo $qty;?>
                    </td>
                    <td>
                        <?php $puderate=!empty($odr->pude_rate)?$odr->pude_rate:'';?> 
                       <?php echo $puderate;?>
                    </td>
                      <td>
                        <?php $pudediscountpc=!empty($odr->pude_discount)?$odr->pude_discount:'';?>
                        <?php echo $pudediscountpc;?>
                    </td>
                    <td>
                        <?php $puorvat=!empty($odr->pude_vat)?$odr->pude_vat:'';?> 
                       <?php echo $puorvat;?>
                    </td>
                  
                   
                    <td>
                        <?php $pudefree=!empty($odr->pude_free)?$odr->pude_free:'';?>
                        <?php echo $pudefree;?>
                    </td>
                    
                    
                     <td>
                        <?php $pudeamount=!empty($odr->pude_amount)?$odr->pude_amount:'';?> 
                       <?php echo $pudeamount;?>
                    </td>
                    <td>
                         <?php $pudetenderno=!empty($odr->pude_tenderno)?$odr->pude_tenderno:'';?>
                        <?php echo $pudetenderno;?>
                    </td>
                    <td>
                        <?php $puderemaks=!empty($odr->pude_remarks)?$odr->pude_remarks:'';?>
                        <?php echo $puderemaks;?>
                    </td>
                </tr>
                <?php } } ?>
                <tr>
                    <td colspan="12" style="padding: 7px;">
                        <strong class="pull-right" ><?php echo $this->lang->line('total'); ?> : <?php $puortotal=!empty($odr->puor_amount)?$odr->puor_amount:'';?>
                        <?php echo $puortotal;?></strong>
                       
                           <span style="float: left;"> In Word:
                            <?php echo $this->general->number_to_word( $puortotal); ?>
                            </span>
                        </td>
                    
                </tr>
        </tbody>
        </table>

        </div>
    </div>
</div>
<div id="FormDiv_Reprint" class="printTable"></div>

<script type="text/javascript">
    $(document).off('click','.btnredirect');
    $(document).on('click','.btnredirect',function(){
        var id=$(this).data('id');
        var url=$(this).data('viewurl');
        var redirecturl=url;
        $.redirectPost(redirecturl, {id:id });
    })
</script>

<?php



?>