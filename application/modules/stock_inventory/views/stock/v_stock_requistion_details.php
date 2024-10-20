    <!--  [pure_purchasereqid] => 1680
            [pure_reqdatebs] => 2075/02/11
            [pure_reqdatead] => 2018/05/25
            [pure_appliedby] => new
            [pure_requser] => new
            [pure_reqtime] => 
            [pure_requestto] => manager
                [pure_fyear] => 074/75
            [pure_costcenter] => 
            [pure_storeid] => 
                [pure_reqno] => 369
            [pure_ordered] => 
            [pure_isapproved] => Y
            [pure_approvaluser] => 
            [pure_approveddatebs] => 2075/02/11
            [pure_approveddatead] => 2018/05/25
            [pure_itemstypeid] => 1
            [pure_status] => 
            [pure_postdatetime] => 
            [pure_postmac] => 0
            [pure_postip] => 163.53.27.149
            [pure_invoicemac] => 
            [pure_invoiceip] => 
            [pure_postdatead] => 2018/05/25
            [pure_postdatebs] => 2075/02/11
                [pure_posttime] => 17:44:48
            [pure_postby] => 8
            [pure_locationid] => 1 -->
    <div class="form-group white-box pad-5">
        <div class="row">
        <div class="col-md-3 col-sm-4">
          
            <label for="example-text">Requistion No : </label>
              <?php echo !empty($requisition_details[0]->pure_reqno)?$requisition_details[0]->pure_reqno:''; ?>
        </div>
        <div class="col-md-3 col-sm-4">
            <label for="example-text">Requistion date  (AD) : </label><?php echo !empty($requisition_details[0]->pure_reqdatead)?$requisition_details[0]->pure_reqdatead:''; ?>
        </div>
        <div class="col-md-3 col-sm-4">
            <label for="example-text">Requistion date  (BS) : </label><?php echo !empty($requisition_details[0]->pure_reqdatebs)?$requisition_details[0]->pure_reqdatebs:''; ?>
        </div>
        <div class="col-md-3 col-sm-4">
            <?php $time=!empty($requisition_details[0]->pure_posttime)?$requisition_details[0]->pure_posttime:''; //print_r($datedb);die;?>
              <label for="example-text">Requistion Time : </label>
            <?php echo $time;?>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-3 col-sm-4">
            <label for="">Fiscal Year : </label>
             <?php echo !empty($requisition_details[0]->puor_isfreezer)?$requisition_details[0]->puor_isfreezer:''; ?>
        </div>
        <div class="col-md-3 col-sm-4">
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
        </div>
        <div class="col-md-3 col-sm-4">
            <label for="example-text">Fiscal Year : </label>
            <?php echo !empty($requisition_details[0]->pure_fyear)?$requisition_details[0]->pure_fyear:''; ?>
        </div>
        <div class="col-md-3 col-sm-4">
            <label for="example-text">Counter : </label>
            <?php echo !empty($requisition_details[0]->eqty_equipmenttype)?$requisition_details[0]->eqty_equipmenttype:''; ?>
        </div>
    </div>
    </div>
<!-- <div class="form-group">
    <div class="row">
    <div class="table-responsive col-sm-12">
        <table style="width:100%;" class="table purs_table dataTable con_ttl">
            <thead>
                <tr>
                    <th width="2%"> S.No. </th>
                    <th width="10%"> Item Name</th>
                    <th width="10%"> Unit </th>
                    <th width="10%"> Stock Qty </th>
                    <th width="8%"> Qty </th> 
                    <th width="8%"> Unit Price </th>
                    <th width="8%"> Select Vat(%) </th>
                    <th width="10%"> Total Amount </th>
                    <th width="5%"> Free </th>
                    <th width="10%">Tender No</th>
                    <th width="8%">Disc (%)</th>
                    <th width="10%">Remarks</th>
                </tr>
            </thead>
            <tbody id="purchaseDataBody">
            <?php if(!empty($purchase_requisition)) { 
                foreach ($purchase_requisition as $key => $odr) { ?>
                <tr class="orderrow" id="orderrow_1" data-id='1'>
                    <td>
                         <?php echo $key+1; ?>
                    </td>
                    <td>
                        <?php echo $odr->itli_itemname; ?> 
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
                        <?php $puorvat=!empty($odr->puor_vat)?$odr->puor_vat:'';?> 
                       <?php echo $puorvat;?>
                    </td>
                    <td>
                        <?php $pudeamount=!empty($odr->puor_amount)?$odr->puor_amount:'';?> 
                       <?php echo $pudeamount;?>
                    </td>
                    <td>
                        <?php $pudefree=!empty($odr->pude_free)?$odr->pude_free:'';?>
                        <?php echo $pudefree;?>
                    </td>
                    <td>
                         <?php $pudetenderno=!empty($odr->pude_tenderno)?$odr->pude_tenderno:'';?>
                        <?php echo $pudetenderno;?>
                    </td>
                    <td>
                        <?php $pudediscountpc=!empty($odr->discountpc)?$odr->pude_discount:'';?>
                        <?php echo $pudediscountpc;?>
                    </td>
                    <td>
                        <?php $puderemaks=!empty($odr->pude_remaks)?$odr->pude_remaks:'';?>
                        <?php echo $puderemaks;?>
                    </td>
                </tr>
                <?php } } ?>
        </tbody>
        </table>
        </div>
    </div>
</div> -->
