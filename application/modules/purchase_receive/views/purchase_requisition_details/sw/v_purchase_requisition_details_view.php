<div class="form-group white-box pad-5">
        <div class="row">
        <div class="col-md-3 col-sm-4">
          
            <label for="example-text"><?php echo $this->lang->line('requisition_no'); ?> : </label>
              <?php echo !empty($requisition_details[0]->pure_reqno)?$requisition_details[0]->pure_reqno:''; ?>
        </div>
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('requisition_date'); ?>  (AD) : </label><?php echo !empty($requisition_details[0]->pure_reqdatead)?$requisition_details[0]->pure_reqdatead:''; ?>
        </div>
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('requisition_date'); ?>  (BS) : </label><?php echo !empty($requisition_details[0]->pure_reqdatebs)?$requisition_details[0]->pure_reqdatebs:''; ?>
        </div>
        <div class="col-md-3 col-sm-4">
            <?php $time=!empty($requisition_details[0]->pure_posttime)?$requisition_details[0]->pure_posttime:''; //print_r($datedb);die;?>
              <label for="example-text"><?php echo $this->lang->line('requisition_time'); ?> : </label>
            <?php echo $time;?>
        </div>
        <div class="clearfix"></div>
         <div class="col-md-3 col-sm-4">
            <label for=""><?php echo $this->lang->line('item_types'); ?> : </label>
             <?php $storeid = !empty($requisition_details[0]->pure_itemstypeid)?$requisition_details[0]->pure_itemstypeid:''; $store = $this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$storeid ),'eqty_equipmenttypeid','DESC');
             echo !empty($store[0]->eqty_equipmenttype)?$store[0]->eqty_equipmenttype:''; ?>
        </div>
        <div class="col-md-3 col-sm-4">
            <?php $locaname=!empty($requisition_details[0]->loca_name)?$requisition_details[0]->loca_name:''; //print_r($datedb);die;?>
              <label for="example-text"><?php echo $this->lang->line('requisition_time'); ?> : </label>
            <?php echo $locaname;?>
        </div> 
     <!--    <div class="col-md-3 col-sm-4">
            <?php $requisitionno=!empty($requisition_details[0]->puor_orderno)?$requisition_details[0]->puor_orderno:''; ?>
            <label for="example-text">Order Number <span class="required">*</span>:</label>
            <?php echo $requisitionno; ?>
        </div>
        <div class="col-md-3 col-sm-4">
          <label for="example-text">Delivery Site : </label> 
           <?php $dsite=!empty($requisition_details[0]->puor_deliverysite)?$requisition_details[0]->puor_deliverysite:''; ?><?php echo $dsite; ?>
          <span class="errmsg"></span>
        </div>
        <div class="col-md-3 col-sm-4">
            <?php $puor_requno=!empty($requisition_details[0]->puor_requno)?$requisition_details[0]->puor_requno:''; ?>
            <label for="example-text">Requistion Number : </label>
            <?php echo $puor_requno; ?>
          <span class="errmsg"></span>
        </div> -->
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> : </label>
            <?php echo !empty($requisition_details[0]->pure_fyear)?$requisition_details[0]->pure_fyear:''; ?>
        </div>
     <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('requisited_by'); ?> : </label>
            <?php echo !empty($requisition_details[0]->pure_appliedby)?$requisition_details[0]->pure_appliedby:''; ?>
        </div> 
           <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('status'); ?> : </label>
          
              <span><?php 
            $approved_status=!empty($requisition_details[0]->pure_isapproved)?$requisition_details[0]->pure_isapproved:'';
            // if($approved_status=='Y')
            // {
            //   echo "<span class='approved badge badge-sm badge-success'>Approved</span>"; 
            // }
            // else 
            // {
            //    echo "<span class='pending badge badge-sm badge-warning'>Pending</span>";
            // }
            

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
          </span>
        </div> 
    </div>
 <div class="btn-group pull-right">
    <?php   if($requisition_details[0]->pure_isapproved=='Y'){ ?>
      <button style="margin-right: 5px;" class="btn btn-success btnredirect" data-print="print" data-viewurl="<?php echo base_url('/purchase_receive/purchase_order') ?>"  data-id="<?php echo !empty($requisition_details[0]->pure_purchasereqid)?$requisition_details[0]->pure_purchasereqid:''; ?>"><?php echo $this->lang->line('order'); ?></button>
      <?php     } ?>

       <?php   if($requisition_details[0]->pure_isapproved !='C'){ ?>
    <button class="btn btn-success PrintThisNow ReprintThis pull-right" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('/purchase_receive/purchase_requisition/purchase_requisition_reprint') ?>" data-viewdiv="FormDiv_Reprint" data-id="<?php echo !empty($requisition_details[0]->pure_purchasereqid)?$requisition_details[0]->pure_purchasereqid:''; ?>"><?php echo $this->lang->line('reprint'); ?></button>
    <?php } ?>
</div>
    <div class="clearfix"></div>
</div>
<div class="form-group">
    <div class="row">
    <div class="table-responsive col-sm-12">
        <table style="width:100%;" class="table purs_table dataTable con_ttl">
            <thead>
                <tr>
                    <th width="2%"> <?php echo $this->lang->line('sn'); ?> </th>
                    <th width="6%"> <?php echo $this->lang->line('item_code'); ?></th>
                    <th width="20%"> <?php echo $this->lang->line('item_name'); ?></th>
                    <th width="8%"> <?php echo $this->lang->line('unit'); ?> </th>
                    <th width="8%"> <?php echo $this->lang->line('stock_quantity'); ?> </th>
                    <th width="8%"> <?php echo $this->lang->line('qty'); ?> </th> 
                    <th width="15%"><?php echo $this->lang->line('remarks'); ?></th>
                </tr>
            </thead>
            <tbody id="purchaseDataBody">
            <?php if($purchase_requisition) { 
                foreach ($purchase_requisition as $key => $odr) 
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
                        <?php echo !empty($odr->itli_itemcode)?$odr->itli_itemcode:'';?> 
                    </td>
                    <td>
                        <?php echo $req_itemname;?> 
                    </td>
                    <td>
                        <?php echo !empty($odr->unit_unitname)?$odr->unit_unitname:'';?> 
                       
                    </td>
                    <td>
                        <?php echo !empty($odr->purd_stock)?sprintf('%g',$odr->purd_stock):'';?>
                    </td>
                    <td>
                        <?php echo !empty($odr->purd_qty)?sprintf('%g',$odr->purd_qty):'';?> 
                    </td>
                    <td>
                        <?php echo !empty($odr->purd_remarks)?$odr->purd_remarks:'';?>
                    </td>
                </tr>
                <?php } } ?>
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
        $.redirectPost(redirecturl, {masterid:id });
    })
</script>