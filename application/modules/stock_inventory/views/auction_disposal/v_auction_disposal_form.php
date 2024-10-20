 <style>

 .purs_table tbody tr td{

    border: none;

    vertical-align: center;

}

</style> 

<?php

$id = !empty($sales_desposal_data_rec[0]->woma_womasterid) ? $sales_desposal_data_rec[0]->woma_womasterid : '';

?>

<form method="post" id="FormsalesDesposal" action="<?php echo base_url('stock_inventory/auction_disposal/save_auction_disposal'); ?>" class="form-material form-horizontal form" data-reloadurl="<?php echo base_url('stock_inventory/auction_disposal/entry/reload'); ?>">

    <input type="hidden" name="id" value="<?php echo !empty($sales_desposal_data_rec[0]->asde_assetdesposalmasterid) ? $sales_desposal_data_rec[0]->asde_assetdesposalmasterid : ''; ?>">

    <div class="form-group">

        <div class="col-md-3 col-sm-4">

            <?php $asde_fiscalyrs = !empty($sales_desposal_data_rec[0]->asde_fiscalyrs) ? $sales_desposal_data_rec[0]->asde_fiscalyrs : CUR_FISCALYEAR;?>

            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?><span class="required">*</span> :</label>

            <select name="asde_fiscalyrs" class="form-control required_field" id="fyear">

               <?php

               if (!empty($fiscal_year)):

                foreach ($fiscal_year as $kf => $fyrs):

                    ?>

                    <option value="<?php echo $fyrs->fiye_name; ?>" <?php if ($fyrs->fiye_status == 'I') {
                        echo "selected=selected";
                    }
                ?> ><?php echo $fyrs->fiye_name; ?></option>

            <?php endforeach;endif;?>

        </select>

    </div>

    <div class="col-md-3">

        <?php $disposalno = !empty($sales_desposal_data_rec[0]->asde_disposalno) ? $sales_desposal_data_rec[0]->asde_disposalno : $disposal_code;?>

        <label for="example-text">Disposal No. <span class="required">*</span>:</label>

        <input type="text" class="form-control required_field" name="asde_disposalno" id="asde_disposalno" value="<?php echo $disposalno; ?>" readonly />

    </div>

    <div class="col-md-3">

        <?php $asde_manualno = !empty($sales_desposal_data_rec[0]->asde_manualno) ? $sales_desposal_data_rec[0]->asde_manualno : 0;?>

        <label for="example-text"><?php echo $this->lang->line('manual_no'); ?>  :</label>

        <input type="text" class="form-control" name="asde_manualno" value="<?php echo $asde_manualno; ?>" placeholder="Enter Manual Number">

    </div>

    <div class="col-md-3">

     <?php

     if (DEFAULT_DATEPICKER == 'NP') {

        $disposal_date = !empty($sales_desposal_data_rec[0]->asde_desposaldatebs) ? $sales_desposal_data_rec[0]->asde_desposaldatebs : DISPLAY_DATE;

    } else {

        $disposal_date = !empty($sales_desposal_data_rec[0]->asde_desposaldatead) ? $sales_desposal_data_rec[0]->asde_desposaldatead : DISPLAY_DATE;

    }

    ?>

    <label for="disposal_date">Disposal Date :</label>

    <input type="text" class="form-control <?php echo DATEPICKER_CLASS ?>" name="asde_desposaldate" value="<?php echo $disposal_date; ?>" placeholder="YYYY/MM/DD" id="disposal_date">

</div>

<div class="col-md-3 col-sm-4">

 <label for="example-text">Disposal Type <span class="required">*</span>:</label>

 <?php $detyid = !empty($sales_desposal_data_rec[0]->asde_desposaltypeid) ? $sales_desposal_data_rec[0]->asde_desposaltypeid : '';?>

 <select name="asde_desposaltypeid" class="form-control required_field" id="disposaltypeid">

  <option value="">---Select---</option>

  <?php

  if (!empty($desposaltype)):

    foreach ($desposaltype as $kdt => $dtype):

        ?>

        <option value="<?php echo $dtype->dety_detyid; ?>" <?php if ($dtype->dety_detyid == $detyid) {
            echo "selected=selected";
        }
    ?> data-issales="<?php echo $dtype->dety_issale; ?>" ><?php echo $dtype->dety_name; ?></option>

<?php endforeach;endif;?>

</select>

</div>

<div class="col-md-3 col-sm-4">

    <?php $cust_name = !empty($sales_desposal_data_rec[0]->asde_customer_name) ? $sales_desposal_data_rec[0]->asde_customer_name : '';?>

    <label for="example-text">Customer Name :</label>

    <input type="text" name="asde_customer_name" class="form-control" value="<?php echo $cust_name; ?>">

</div>
<div class="col-md-3">

       <div class="stock-limit white-box noborder">
                <ul class="index_chart">
                    <li style="background: darkorange;">
                        <div class="pending"></div><a href="javascript:void(0)" data-approvedtype="pending" class="stock_limit font-xs">Expendable</a> 
                    </li>
                    <li style="background: #018605;">
                       <a href="javascript:void(0)" class="zero_stk_remove font-xs">Non-Expendable</a> 
                        
                    </li>
                    <div class="clearfix"></div>
                    
                </ul>
            </div>
    </div>

   <!--  <div class="col-md-3 col-sm-4">

            <?php $sale_tax = !empty($sales_desposal_data_rec[0]->asde_sale_taxper) ? $sales_desposal_data_rec[0]->asde_sale_taxper : '';?>

            <label for="example-text">Sales Tax (%) :</label>

            <input type="text" name="asde_sale_taxper" class="form-control float" value="<?php echo $sale_tax; ?>">

        </div> -->

    </div>

    <div class="clearfix"></div>

    <div class="form-group">

        <div class="table-responsive col-sm-12">

            <table style="width:100%;" class="table dataTable dt_alt purs_table res_vert_table">

                <thead>

                    <tr>

                        <th scope="col" width="5%"> <?php echo $this->lang->line('sn'); ?>. </th>
                        <th scope="col" width="10%">Item Code </th>
                        <th scope="col" width="15%">Item Unit</th>
                        <th width="5%"><?php echo $this->lang->line('unit'); ?></th>
                        <th scope="col" width="5%">Purchase Qty</th>
                        <th scope="col" width="5%">Dep.Issued Qty </th>
                        <th scope="col" width="5%">Rem.Qty</th>
                        <th scope="col" width="5%">Auction/Disposal.Qty</th>
                        <th scope="col" width="5%">Sales Cost.</th>
                        <th scope="col" width="5%">Total Cost.</th>
                        <th scope="col" width="15%"><?php echo $this->lang->line('remarks'); ?> </th>
                        <th scope="col" width="5%"> <?php echo $this->lang->line('action'); ?></th>

                    </tr>

                </thead>

                <tbody id="orderBody">

                    <tr class="orderrow" id="orderrow_1" data-id='1'>

                        <td data-label="S.No.">

                            <input type="text" class="form-control sno" id="s_no_1" value="1" readonly/>

                        </td>

                        <td data-label="Code">

                            <div class="dis_tab">

                                <input type="text" class="form-control itemcode enterinput" id="item_code1" name="assets_code[]"  data-id='1' data-targetbtn='view' value="">

                                <input type="hidden" class="itemid" name="itemid[]" data-id='1' value="" id="itemid_1">
                                <input type="hidden" class="mattypeid" name="mattypeid[]" data-id='1' value="" id="mattypeid_1">

                                <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading='List of Items' data-viewurl='<?php echo base_url('stock_inventory/auction_disposal/item_list_record'); ?>' data-id='1' id="view_1"><strong>...</strong></a>&nbsp;

                            </div>

                        </td>

                        <td data-label="Item Name">

                            <input type="text" class="form-control itemname"  id="itemname_1" name="itemname[]"  data-id='1' readonly>

                        </td>
                        <td data-label="Unit">
                            <input type="text" class="form-control unit" name="unit[]" id="unit_1" data-id='1' readonly>
                        </td>

                        <td data-label="Purchase Qty">

                            <input type="text" class="form-control float purchaseqty" name="purchaseqty[]"   id="purchaseqty_1" data-id='1' readonly="true">

                        </td>

                        <td data-label="Dep. Issued Qty">

                            <input type="text" class="form-control float dep_issueqty" name="dep_issueqty[]"   id="dep_issueqty_1" data-id='1' readonly="true">

                        </td>

                        <td data-label="Rem. Qty">

                            <input type="text" class="form-control float remqty" name="remqty[]"   id="remqty_1" data-id='1' readonly="true">

                        </td>

                        <td data-label="Auction/Disposal Qty">

                            <input type="text" class="form-control float calculateamt auction_disposalqty required_field" name="auction_disposalqty[]"   id="auction_disposalqty_1" data-id='1' value="" >

                        </td>
                        <td data-label="Sales Cost">

                            <input type="text" class="form-control float calculateamt salecost" id="salecost_1" name="salecost[]"  data-id='1'>

                        </td>

                        <td data-label="Total Cost">

                            <input type="text" class="form-control float totalcost" id="totalcost_1" name="tcost[]"  data-id='1' readonly="true">

                        </td>

                        <td data-label="Remarks">
                            <textarea class="remarks jump_to_add" id="remarks_1" name="remarks[]"  data-id='1'></textarea>
                        </td>

                        <td data-label="Action">

                         <div class="actionDiv acDiv2" id="acDiv2_1"></div>

                     </td>

                 </tr>

             </tbody>

             <tbody>

                <tr class="resp_table_breaker">

                    <td colspan="12">

                        <a href="javascript:void(0)" class="btn btn-primary btnAdd pull-right" data-id="1"  id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>

                        <div class="clearfix"></div>

                    </td>

                </tr>

            </tbody>

            <tfoot>

                <tr>

                    <td colspan="3">&nbsp;</td>

                    <td><strong>G.Total</strong></td>

                    <td><input type="text" class="form-control" name="tot_pur_qty" id="tot_pur_qty" readonly="true"></td>

                    <td><input type="text" class="form-control" name="tot_issued_qty" id="tot_issued_qty"  readonly="true"></td>

                    <td><input type="text" class="form-control" name="tot_rem_qty" id="tot_rem_qty"  readonly="true"></td>

                    <td><input type="text" class="form-control" name="tot_auction_qty" id="tot_auction_qty"  readonly="true"></td>

                    <td></td>

                    <td colspan="2"><input type="text" class="form-control" name="tot_grand_total" id="tot_grand_total"  readonly="true"></td>
                    <td></td>

                </tr>

            </tfoot>

        </table>

        <div id="Printable" class="print_report_section printTable">

        </div>

    </div> <!-- end table responsive -->

</div>

<div class="form-group">

    <div class="row">

        <div class="col-md-12">

         <label>Full Remarks &nbsp; &nbsp;</label>

         <textarea name="full_remarks" class="form-control"></textarea>

     </div>

 </div>

</div>

<div class="form-group">

    <div class="col-md-12">

        <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($sales_desposal_data_rec) ? 'update' : 'save' ?>' id="btnSubmit" ><?php echo !empty($sales_desposal_data_rec) ? 'Update' : $this->lang->line('save'); ?></button>
         <button type="submit" class="btn btn-info savePrint" data-operation='<?php echo !empty($sales_desposal_data_rec) ? 'update' : 'save ' ?>' id="btnSubmit" data-print="print"><?php echo !empty($sales_desposal_data_rec) ? 'Update & Print' : $this->lang->line('save_and_print') ?></button>

    </div>

    <div class="col-sm-12">

        <div  class="alert-success success"></div>

        <div class="alert-danger error"></div>

    </div>

</div>

</form>

<script type="text/javascript">

    function order_item_row() {
    
     setTimeout(function(){

      $(".orderrow").each(function(i,k) {

        var vali=i+1;

        $(this).attr("id","orderrow_"+vali);

        $(this).attr("data-id",vali);

        $(this).find('.sno').attr("id","s_no_"+vali);

        $(this).find('.sno').attr("value",vali);

        $(this).find('.itemcode').attr("id","item_code"+vali);

        $(this).find('.itemcode').attr("data-id",vali);

        $(this).find('.itemid').attr("id","itemid_"+vali);

        $(this).find('.itemid').attr("data-id",vali);

        $(this).find('.itemname').attr("id","itemname_"+vali);

        $(this).find('.itemname').attr("data-id",vali);

        $(this).find('.view').attr("id","view_"+vali);

        $(this).find('.view').attr("data-id",vali);

        $(this).find('.purchaseqty').attr("id","purchaseqty_"+vali);

        $(this).find('.purchaseqty').attr("data-id",vali);

        $(this).find('.dep_issueqty').attr("id","dep_issueqty_"+vali);

        $(this).find('.dep_issueqty').attr("data-id",vali);

        $(this).find('.remqty').attr("id","remqty_"+vali);

        $(this).find('.remqty').attr("data-id",vali);

        $(this).find('.assets_salesval').attr("id","assets_salesval_"+vali);

        $(this).find('.assets_salesval').attr("data-id",vali);

        $(this).find('.remarks').attr("id","remarks_"+vali);

        $(this).find('.remarks').attr("data-id",vali);

        $(this).find('.acDiv2').attr("id","acDiv2_"+vali);

        $(this).find('.btnAdd').attr("id","addOrder_"+vali);

        $(this).find('.btnAdd').attr("data-id",vali);

        $(this).find('.btnRemove').attr("id","addOrder_"+vali);

        $(this).find('.btnRemove').attr("data-id",vali);

        $(this).find('.btnChange').attr("id","btnChange_"+vali);

    });

    },600);
 }

    $(document).off('change keyup','.purchaseqty');

    $(document).on('change keyup','.purchaseqty',function(e){

     var assetsorg_total=0;

     $(".purchaseqty").each(function() {

        assetsorg_total += parseFloat($(this).val());

    });

     assetsorg_total=parseFloat(assetsorg_total);

     $('#torginalcost').val(assetsorg_total);

 });

    $(document).off('change keyup','.dep_issueqty');

    $(document).on('change keyup','.dep_issueqty',function(e){

     var assetcurrent_total=0;

     $(".dep_issueqty").each(function() {

        assetcurrent_total += parseFloat($(this).val());

    });

     assetcurrent_total=parseFloat(assetcurrent_total);

     $('#tcurrentcost').val(assetcurrent_total);

 });

    $(document).off('change keyup','.assets_salesval');

    $(document).on('change keyup','.assets_salesval',function(e){

     var assetssales_total=0;

     $(".assets_salesval").each(function() {

        assetssales_total += parseFloat($(this).val());

    });

     assetssales_total=parseFloat(assetssales_total);

     $('#tsalescost').val(assetssales_total);

 });

</script>

<script type="text/javascript">

   $(document).off('click','.btnAdd');

   $(document).on('click','.btnAdd',function(){
    var distype=$('#disposaltypeid').val();
    var dis_or_no='';
    if(distype=='2'){
        dis_or_no='disabled';
    }else{
        dis_or_no='';
    }

    var id=$(this).data('id');

    var trpluOne = $('.orderrow').length;

    var trplusOne = $('.orderrow').length+1;

    var itemid=$('#itemid_'+trpluOne).val();

    var auctionqty=$('#auction_disposalqty_'+trpluOne).val();

         // alert(itemid);

         // return false;

         if(itemid==''){

            $('#item_code'+trpluOne).focus();

            return false;

        }

        if(auctionqty=='' || auctionqty==0){

            $('#auction_disposalqty_'+trpluOne).focus();

            return false;

        }

        if(trplusOne==2)

        {

            $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');

        }

        var template='';

        template = `<tr class="orderrow" id="orderrow_${trplusOne}" data-id='${trplusOne}'>
        <td data-label="S.No.">
            <input type="text" class="form-control sno" id="s_no_${trplusOne}" value="${trplusOne}" readonly/>
        </td>
        <td data-label="Code">
            <div class="dis_tab">
                <input type="text" class="form-control itemcode enterinput" id="item_code${trplusOne}" name="assets_code[]"  data-id='${trplusOne}' data-targetbtn='view' value="">
                <input type="hidden" class="itemid" name="itemid[]" data-id='${trplusOne}' value="" id="itemid_${trplusOne}">
                 <input type="hidden" class="mattypeid" name="mattypeid[]" data-id='${trplusOne}' value="" id="mattypeid_${trplusOne}">
                <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading='List of Items' data-viewurl='<?php echo base_url('stock_inventory/auction_disposal/item_list_record'); ?>' data-id='${trplusOne}' id="view_${trplusOne}"><strong>...</strong></a>&nbsp;
            </div>
        </td>
        <td data-label="Item Name">
            <input type="text" class="form-control itemname"  id="itemname_${trplusOne}" name="itemname[]"  data-id='${trplusOne}' readonly>
        </td>
        <td data-label="Unit">
            <input type="text" class="form-control unit" name="unit[]" id="unit_${trplusOne}" data-id='${trplusOne}' readonly>
        </td>
        <td data-label="Purchase Qty">
            <input type="text" class="form-control float purchaseqty" name="purchaseqty[]"   id="purchaseqty_${trplusOne}" data-id='${trplusOne}' readonly="true">
        </td>
        <td data-label="Dep. Issued Qty">
            <input type="text" class="form-control float dep_issueqty" name="dep_issueqty[]"   id="dep_issueqty_${trplusOne}" data-id='${trplusOne}' readonly="true">
        </td>
        <td data-label="Rem. Qty">
            <input type="text" class="form-control float remqty" name="remqty[]"   id="remqty_${trplusOne}" data-id='${trplusOne}' readonly="true">
        </td>
        <td data-label="Auction/Disposal Qty">
            <input type="text" class="form-control float calculateamt auction_disposalqty required_field" name="auction_disposalqty[]"   id="auction_disposalqty_${trplusOne}" data-id='${trplusOne}' value="" >
        </td>
        <td data-label="Sales Cost">
            <input type="text" class="form-control float calculateamt salecost" id="salecost_${trplusOne}" name="salecost[]" ${dis_or_no} data-id='${trplusOne}'>
        </td>
        <td data-label="Total Cost">
            <input type="text" class="form-control float totalcost" id="totalcost_${trplusOne}" name="tcost[]"  data-id='${trplusOne}' readonly="true">
        </td>
        <td data-label="Remarks">
            <textarea class="remarks jump_to_add" id="remarks_${trplusOne}" name="remarks[]"  data-id='${trplusOne}'></textarea>
        <td data-label="Action"> <div class="actionDiv acDiv2" id="acDiv2_${trplusOne}"><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="${trplusOne}"  id="addRequistion_${trplusOne}"><span class="btnChange" id="btnChange_${trplusOne}"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div>
        </td>
        </tr>`;

        $('#itemcode_'+trplusOne).focus();

        $('#orderBody').append(template);

    });

   $(document).off('click','.btnRemove');
   $(document).on('click','.btnRemove',function(){

    var id=$(this).data('id');

    var whichtr = $(this).closest("tr");

    var conf = confirm('Are Your Want to Sure to remove?');

    if(conf)

    {

     var trplusOne = $('.orderrow').length+1;
     whichtr.remove();
     order_item_row();
     setTimeout(function(){

        var trlength = $('.orderrow').length;
        if(trlength==1){
         $('#acDiv2_1').html('');
        }

     },800);

    $('.purchaseqty').change();
    $('.dep_issueqty').change();
    $('.remqty').change();
    $('.auction_disposalqty').change();
 }

});

   $(document).off('click','.itemDetail');
   $(document).on('click','.itemDetail',function(){
    var row_class_name = '';
    var rowno=$(this).data('rowno');
    var rate=$(this).data('rate');
    var itemcode=$(this).data('itemcode');
    var itemname=$(this).data('itemname');
    var unitname=$(this).data('unitname');
    var itemid=$(this).data('itemid');
    var mattypeid=$(this).data('mattypeid');
    var purrate=$(this).data('purrate');
    var purqty=$(this).data('purqty');
    var dep_issqty=$(this).data('dep_issqty');
    var remqty=$(this).data('remqty');
    var distype=$('#disposaltypeid').val();
    if (distype == 2 && mattypeid == 1) {
        row_class_name = 'disposal_only';
    }
    $('#orderrow_'+rowno).addClass(row_class_name);
    $('#itemid_'+rowno).val(itemid);
    $('#mattypeid_'+rowno).val(mattypeid);
    $('#item_code'+rowno).val(itemcode);
    $('#itemname_'+rowno).val(itemname);
    $('#unit_'+rowno).val(unitname);
    $('#purchaseqty_'+rowno).val(purqty);
    $('#dep_issueqty_'+rowno).val(dep_issqty);
    $('#remqty_'+rowno).val(remqty);
    $('#salecost_'+rowno).val(purrate);
    $('#myView').modal('hide');
    $('#auction_disposalqty_'+rowno).focus().select();
    $('.purchaseqty').change();
    $('.dep_issueqty').change();
    $('.remqty').change();
    return false;
});

$(document).off('keyup change','.auction_disposalqty');
$(document).on('keyup change','.auction_disposalqty',function () {
    var id = $(this).data('id');
    var mtypeid=$('#mattypeid_'+id).val();
    var auction_qty = parseFloat($(this).val());
    var item_qty = parseFloat($(`#purchaseqty_${id}`).val());
    var remqty=parseFloat($(`#remqty_${id}`).val());
    if(mtypeid==1){
        if(auction_qty > remqty){
        alert('Auction/Disposal quantity cannot be greater than purchased quantity');
        $(`#auction_disposalqty_${id}`).val(remqty);
        $(`#auction_disposalqty_${id}`).focus();
        return false;
        }
    }else{
        if(auction_qty > item_qty){
        alert('Auction/Disposal quantity cannot be greater than purchased quantity');
        $(`#auction_disposalqty_${id}`).val(item_qty);
        $(`#auction_disposalqty_${id}`).focus();
        return false;
    }
    }
   
});

$(document).off('keyup change','.calculateamt');
$(document).on('keyup change','.calculateamt',function(){
    var id = $(this).data('id');
    var qty = $(`#auction_disposalqty_${id}`).val();
    if(qty == null || qty == '')
    {
        qty=0;
    }
    var rate=$(`#salecost_${id}`).val();
    if(rate ==null || rate==' ')
    {
        rate=0;
    }

    var rede_totalamt=0;
    var totalamt=parseFloat(qty)*parseFloat(rate);

    var valid_totalamt = checkValidValue(totalamt);
    $(`#totalcost_${id}`).val(valid_totalamt.toFixed(2));
    
    var grandtotal = 0;
    var total_auction = 0;
    var total = 0;
    var qty = 0;
    $(".totalcost").each(function() {
        total = parseFloat($(this).val());
        if(!isNaN(total)){
        grandtotal += total;
        }
    });

    $(".auction_disposalqty").each(function() {
        qty = parseFloat($(this).val());
        if(!isNaN(qty)){
        total_auction += qty;
        }
    });
   
    $('#tot_auction_qty').val(total_auction.toFixed(2));
    $('#tot_grand_total').val(grandtotal.toFixed(2));

});

$(document).off('change','.purchaseqty');
$(document).on('change','.purchaseqty',function () {
    var total_purchase_qty = 0;
    $(".purchaseqty").each(function() {
        total_purchase_qty += parseFloat($(this).val());
    });
    $('#tot_pur_qty').val(total_purchase_qty.toFixed(2));

});

$(document).off('change','.dep_issueqty');
$(document).on('change','.dep_issueqty',function () {
    var tot_issued_qty = 0;
    $(".dep_issueqty").each(function() {
        tot_issued_qty += parseFloat($(this).val());
    });
    $('#tot_issued_qty').val(tot_issued_qty.toFixed(2));

});

$(document).off('change','.remqty');
$(document).on('change','.remqty',function () {
    var tot_rem_qty = 0;
    $(".remqty").each(function() {
        tot_rem_qty += parseFloat($(this).val());
    });
    $('#tot_rem_qty').val(tot_rem_qty.toFixed(2));

});

$(document).off('click','.btnitem');
$(document).on('click','.btnitem',function(e){
    var distype=$('#disposaltypeid').val();
    if(distype==''){
        alert('You need to select Disposal Type');
         setTimeout(function() {
            $('#myView').modal('hide');
        }, 1000);

        return false;
    }
});

$(document).off('change','#disposaltypeid');
$(document).on('change','#disposaltypeid',function(e){
    var distype=$(this).val();
    if(distype=='2'){
        $('.salecost').attr('disabled',true);
    }else{
        $('.salecost').attr('disabled',false);
        var cnt_disposal_only = $('.disposal_only').length;
        if(cnt_disposal_only > 0)
        {
            $('.disposal_only').fadeOut(250, function(){ 
                $('.disposal_only').remove();
            });
            order_item_row();
        }
        
    }
});

</script>