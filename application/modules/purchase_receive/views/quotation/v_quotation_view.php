<div class="form-group pad-5 white-box bg-gray clearfix">
    <!-- <div class="form-border clearfix"> -->
     <div class="col-md-3">
        <label><?php echo $this->lang->line('supplier_name'); ?>:</label>
        <span><?php echo !empty($req_master[0]->supp_suppliername)?$req_master[0]->supp_suppliername:'';  ?></span>
    </div>

    <div class="col-md-3">
        <label><?php echo $this->lang->line('quotation_date'); ?>:</label>
         <span><?php if(DEFAULT_DATEPICKER=='NP'){
             echo $req_master[0]->quma_quotationdatebs;
         } else {
            echo $req_master[0]->quma_quotationdatead;
         } ?></span>
    </div>
   
     <div class="col-md-3">
        <label><?php echo $this->lang->line('supplier_quotation_date'); ?>:</label>
          <span><?php if(DEFAULT_DATEPICKER=='NP'){
             echo $req_master[0]->quma_supplierquotationdatebs;
         } else {
            echo $req_master[0]->quma_supplierquotationdatead;
         } ?></span>
    </div>
      <div class="col-md-3">
        <label><?php echo $this->lang->line('quotation_no'); ?>:</label>
         <span><?php echo  !empty($req_master[0]->quma_quotationnumber)?$req_master[0]->quma_quotationnumber:''; ?></span>
    </div>
      <div class="col-md-3">
        <label><?php echo $this->lang->line('supplier_quotation_no'); ?>:</label>
         <span><?php echo  !empty($req_master[0]->quma_supplierquotationnumber)?$req_master[0]->quma_supplierquotationnumber:''; ?></span>
    </div>
      <div class="col-md-3">
        <label><?php echo $this->lang->line('location'); ?>:</label>
         <span><?php echo  !empty($req_master[0]->loca_name)?$req_master[0]->loca_name:''; ?></span>
    </div>
    <div class="col-md-3">
        <label><?php echo $this->lang->line('valid_till'); ?>:</label>
       <span><?php if(DEFAULT_DATEPICKER=='NP'){
             echo $req_master[0]->quma_expdatebs;
         } else {
            echo $req_master[0]->quma_expdatead;
         } ?>
         </span>
    </div>
</div>
<!-- </div> -->
<div class="clearfix"></div> 
<div class="data-table">
    <?php if($req_detail_list) 
    { 
      ?>
        <table style="width:100%;" class="table dataTable con_ttl dt_alt purs_table">
            <thead>
                <tr>
                    <th width="5%"> <?php echo $this->lang->line('sn'); ?> </th>
                    <th width="10%"> <?php echo $this->lang->line('item_code'); ?> </th>
                    <th width="30%"> <?php echo $this->lang->line('item_name'); ?> </th>
                    <th width="5%"> <?php echo $this->lang->line('unit'); ?></th>
                    <th width="5%"> <?php echo $this->lang->line('qty'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('rate'); ?> </th>
                    <th width="10%"> <?php echo $this->lang->line('discount_percentage'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('vat'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('net_rate'); ?> </th>
                  
                </tr>
            </thead>
            <tbody>
              <?php foreach ($req_detail_list as $key => $value) {
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
                <td><?php echo $value->qude_qty ?></td>
                <td><?php echo $value->qude_rate ?></td>
                <td><?php echo $value->qude_discountpc ?></td>
                <td><?php echo $value->qude_vatpc ?></td>
                <td><?php echo $value->qude_netrate ?></td>
              </tr>
              <?php } ?>

              <tr class="table-footer">
             
                <td colspan="8">
                        <span style="float: right">
                        <label><?php echo $this->lang->line('sub_total'); ?></label>
                        </span>
                    </td>
                    <td colspan="2">
                      <?php echo number_format($req_master[0]->quma_amount,2)?>
                    </td>

              </tr>
                <tr class="table-footer">
             
                <td colspan="8">
                        <span style="float: right">
                        <label><?php echo $this->lang->line('discount'); ?></label>
                        </span>
                    </td>
                    <td colspan="2">
                      <?php echo number_format($req_master[0]->quma_discount,2)?>
                    </td>

              </tr>
                <tr class="table-footer">
             
                <td colspan="8">
                        <span style="float: right">
                        <label><?php echo $this->lang->line('tax'); ?></label>
                        </span>
                    </td>
                    <td colspan="2">
                      <?php echo number_format($req_master[0]->quma_vat,2)?>
                    </td>

              </tr>
              <tr class="table-footer">
             
                <td colspan="8">
                        <span style="float: right">
                        <label><?php echo $this->lang->line('grand_total'); ?></label>
                        </span>
                    </td>
                    <td colspan="2">
                      <?php echo number_format($req_master[0]->quma_totalamount,2)?>
                    </td>

              </tr>
            </tbody>
          </table>
          <div class="form-group">
              <div class="col-md-12 col-sm-12">
                  <label for="quma_remarks"><?php echo $this->lang->line('remarks'); ?>:</label>
                 <span>
                   <?php echo !empty($req_master[0]->quma_remarks)?$req_master[0]->quma_remarks:''; ?>
                 </span>
              </div>
          </div>
    <?php } ?>
    </div>
<div class="clearfix"></div>