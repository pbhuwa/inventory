 <style>
        .purs_table tbody tr td{
            border: none;
            vertical-align: center;
        }
    </style>
        <div class="form-group">
            <div class="col-md-3 col-sm-6 col-xs-6">
              <label for="example-text">Requisition Date  : </label>
              <?php echo !empty($purchase_requisition[0]->rema_reqdatead)?$purchase_requisition[0]->rema_reqdatead:DISPLAY_DATE; ?>
            </div>
            <div class="col-md-3">
                <?php $reorderlevel=!empty($purchase_requisition[0]->rema_reqby)?$purchase_requisition[0]->rema_reqby:''; ?>
                <label for="example-text">Requested By :</label>
                <?php echo $reorderlevel; ?>
            </div>
            <div class="col-md-3">
                <?php $depid=!empty($purchase_requisition[0]->eqty_equipmenttype)?$purchase_requisition[0]->eqty_equipmenttype:''; ?>
                <label for="example-text">Item Types <span class="required"></span>:</label>
                <?php echo $depid; ?>
            </div>
            <div class="col-md-3">
                <?php 
                 $itemcode=!empty($purchase_requisition[0]->pure_reqno)?$purchase_requisition[0]->pure_reqno:$reqno[0]->id; ?>
                <label for="example-text">Requisition No <span class="required"></span>:</label>
                <?php echo $itemcode; ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-3">
                <label for="example-text">Requested To :</label>
                <?php $unitid=!empty($purchase_requisition[0]->pure_request_to)?$purchase_requisition[0]->pure_request_to:''; ?>
                <?php echo $unitid ; ?>
            </div>
            <div class="col-md-3">
                <label for="example-text">Is Approved  : </label><br>
                <?php $rema_storeid=!empty($purchase_requisition[0]->pure_isapproved)?$purchase_requisition[0]->pure_isapproved:''; ?>
             <?php echo $rema_storeid;?>
            </div>
            
        </div>
        <div class="clearfix"></div>
        <div class="form-group">
            <div class="table-responsive">
                <table style="width:100%;" class="table dataTable dt_alt purs_table">
                    <thead>
                        <tr>
                            <th width="5%"> S.No. </th>
                            <th width="10%"> Item Code  </th>
                            <th width="10%"> Item Name </th>
                            <th width="10%"> Stock </th>
                            <th width="15%"> Unit  </th>
                            <th width="15%"> Quantity </th>
                            <th width="15%"> Remarks </th>
                            <th width="15%"> Required Date </th>
                        </tr>
                    </thead>
                        <tbody id="orderBody"><?php if($purchase_requisition):
                             foreach ($purchase_requisition as $key => $preq) { ?>
                            <tr class="orderrow" id="orderrow_1" data-id='1'>
                                
                             	<td>
                                    <input type="text" class="form-control sno" id="s_no_1" value="<?php echo $key +1;?>" readonly/>
                                </td>
                                <td> 
                                    <input type="text" class="form-control float rede_code calculateamt" id="rede_code_1" name="rede_code[]"  data-id='1' value="<?php echo $preq->purd_budcode;?>" disabled> 
                                </td>
                                <td> 
                                	<input type="text" class="form-control float rede_code calculateamt" id="rede_code_1" name="rede_code[]"  data-id='1' value="<?php echo $preq->itli_itemname;?>" disabled> 
                                </td>
                                <td> 
                                    <input type="text" class="form-control float rede_unit calculateamt stock" name="stock[]"   id="stock_1" data-id='1'  value="<?php echo $preq->purd_stock;?>"disabled> 
                                </td>
                                <td> 
                                        <input type="text" class="form-control float rede_unit calculateamt rede_unit" name="rede_unit[]"   id="rede_unit_1" data-id='1'value="<?php echo $preq->purd_unit;?>"disabled> 
                                </td>
                                <td> 
                                        <input type="text" class="form-control float rede_qty calculateamt rede_qty" name="rede_qty[]"   id="rede_qty_1" data-id='1' value="<?php echo $preq->purd_qty;?>"disabled> 
                                </td>
                                <td> 
                                        <input type="text" class="form-control  rede_remarks " id="rede_remarks_1" name="rede_remarks[]"  data-id='1' value="<?php echo $preq->purd_remarks;?>"disabled >
                                </td>
                                <td>
                                	<input type="text" class="form-control  rede_remarks " id="rede_remarks_1" name="rede_remarks[]"  data-id='1' value="<?php echo $preq->purd_postdatead;?>"disabled> 
                                    
                                </td>
                            
                            </tr>   <?php }  endif; ?> 
                       </tbody>
            </table>
            <div id="Printable" class="print_report_section printTable">
                
            </div>
            </div>
        </div>
        <div class="form-group">
              <div class="col-sm-12">
                <div  class="alert-success success"></div>
                <div class="alert-danger error"></div>
              </div>
        </div>
