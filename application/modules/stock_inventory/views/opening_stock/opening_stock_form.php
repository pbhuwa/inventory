<style>
.purs_table tbody tr td{
border: none;
vertical-align: center;
}
</style>
<form method="post" id="FormOpeningStock" action="<?php echo base_url('stock_inventory/opening_stock/save_opening_stock'); ?>" data-reloadurl="<?php echo base_url('stock_inventory/opening_stock/form_opening_stock');?>" class="form-material form-horizontal form" >
    <input type="hidden" name="id" value="<?php echo !empty($opening_data->trde_trdeid)?$opening_data->trde_trdeid:'';?>">
    <div class="stockData"></div>
    <div class="form-group">
        <div class="col-md-3 col-sm-4">
            <label><?php echo $this->lang->line('store'); ?><span class="required">*</span>:</label>
            <?php $depid=!empty($opening_data->storeid)?$opening_data->storeid:''; ?>
            <select class="form-control storeChange" name="storeid" autofocus="true" id="storeId">
                <?php
                if($equipmnt_type):
                foreach ($equipmnt_type as $ket => $etype):
                ?>
                <option value="<?php echo $etype->eqty_equipmenttypeid; ?>"  <?php if($depid==$etype->eqty_equipmenttypeid) echo "selected=selected"; ?> ><?php echo $etype->eqty_equipmenttype; ?></option>
                <?php endforeach; endif; ?>
            </select>
        </div>
        <div class="col-md-3 col-sm-4">
            <label><?php echo $this->lang->line('opening_stock_of_the_year'); ?></label>
            <?php $fyear=!empty($opening_data->trma_fyear)?$opening_data->trma_fyear:'I';
             ?>
            <select class="form-control storeChange" name="opstockyr"  id="fiscalYear">
                <?php
                if($fiscal_year):
                foreach ($fiscal_year as $kf => $fyrs):
                ?>
                <option value="<?php echo $fyrs->fiye_name; ?>" <?php
                    if($fyear == 'I'){
                        if($fyrs->fiye_status==$fyear)
                        echo "selected=selected";
                    }else{ 
                        if($fyrs->fiye_name==$fyear)
                            { echo "selected=selected" ;
                        }
                    } ; ?>><?php echo $fyrs->fiye_name; ?></option>
                <?php endforeach; endif; ?>
            </select>
        </div>
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('date'); ?> <span class="required">*</span>: </label><br>
             <?php $trdepostdatebs =!empty($opening_data->trde_postdatebs)?$opening_data->trde_postdatebs:DISPLAY_DATE; ?>
            <input type="text" class="form-control <?php echo DATEPICKER_CLASS; ?>" name="stockopendate"  value="<?php  echo $trdepostdatebs;?>" placeholder="Date" id="stockopendate">
            
        </div>
    </div>
    <?php if($opening_data){ ?>
    <div class="form-group">
        <div class="col-md-3 col-sm-4">
            <label><?php echo $this->lang->line('item_name'); ?>:<span class="required">*</span>:</label>
            <div class="dis_tab">
                <?php $itemsid=!empty($opening_data->trde_itemsid)?$opening_data->trde_itemsid:''; ?>
                <?php $itliitemname=!empty($opening_data->itli_itemname)?$opening_data->itli_itemname:''; ?>
                <input type="text"  name="itemname" id="itemname" class="form-control required_field enterinput"value="<?php echo $itliitemname ?>">
                <input type="hidden"  name="itemid" id="itemid" class="form-control" value="<?php echo $itemsid ?>">
                <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock'); ?>' data-id='1' id="view_1"><strong>...</strong></a>
            </div>
        </div>
        <div class="col-md-3 col-sm-4">
            <label><?php echo $this->lang->line('purchase_rate'); ?> <span class="required">*</span>:</label>
            <?php $trdeselprice=!empty($opening_data->trde_unitprice)?$opening_data->trde_unitprice:'0'; ?>
            <input type="text"  name="purrate" id="purrate" class="form-control float" value="<?php echo $trdeselprice ?>">
        </div>
        <div class="col-md-3 col-sm-4">
            <label>Expiry Date :</label>
            
            <?php $trdeexpdatebs=!empty($opening_data->trde_expdatebs)?$opening_data->trde_expdatebs:''; ?>
            <input type="text"  name="expdateup" id="expdate"  class="form-control <?php echo DATEPICKER_CLASS; ?> " value="<?php echo $trdeexpdatebs ?>">
        </div>
        <div class="col-md-3 col-sm-4">
            <label><?php echo $this->lang->line('opening_stock'); ?> <span class="required">*</span>:</label>
            <div class="dis_tab">
                <?php $trdenewissueqty=!empty($opening_data->trde_issueqty)?$opening_data->trde_issueqty:''; ?>
                <input type="text"  name="openstockqty" class="form-control number" value="<?php echo round($trdenewissueqty,0); ?>">
                <span id="unit" class="btn btn-sm table-cell width_30"></span>
            </div>
        </div>

          <div class="col-md-3 col-sm-4">
            <label>Unused Stock <span class="required">*</span>:</label>
            <div class="dis_tab">
                <?php $unusedstock=!empty($opening_data->trde_unusedqty)?$opening_data->trde_unusedqty:''; ?>
                <input type="text"  name="unused_stockqty" class="form-control number" value="<?php echo round($unusedstock,0); ?>">
                <span id="unit" class="btn btn-sm table-cell width_30"></span>
            </div>
        </div>
        <div class="col-md-3 col-sm-4">
            <label><?php echo $this->lang->line('description'); ?></label> 
            <?php $trdedescription=!empty($opening_data->trde_description)?$opening_data->trde_description:''; ?>
            
            <input type="text"  name="description" class="form-control" value="<?php echo $trdedescription ?>">
        </div>
        <div class="col-md-3 col-sm-4">
            <label><?php echo $this->lang->line('remarks'); ?></label>
             <?php $trderemarks=!empty($opening_data->trde_remarks)?$opening_data->trde_remarks:''; ?>
            <input type="text"  name="remarks" class="form-control" value="<?php echo $trderemarks ?>">
        </div>
    </div> 
<?php }else{ ?>
    <div class="form-group">
            <div class="table-responsive col-sm-12">
                <table style="width:100%;" class="table purs_table dataTable">
                    <thead>
                        <tr>
                            <th width="2%"><?php echo $this->lang->line('sn'); ?></th>
                            <th width="8%"><?php echo $this->lang->line('item_code'); ?> </th>
                            <th width="18%"><?php echo $this->lang->line('item_name'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('purchase_rate'); ?></th>
                            <th width="8%"><?php echo $this->lang->line('unit'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('opening_stock'); ?></th>
                             <th width="10%">Unused Stock</th>
                            <th width="8%"><?php echo $this->lang->line('expiry_date'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('description'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('remarks'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('action'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="purchaseDataBody">
                        <tr class="orderrow" id="orderrow_1" data-id='1'>
                            <td>
                                <input type="text" class="form-control sno" id="s_no_1" value="1" readonly/>
                            </td>
                            <td>
                                <div class="dis_tab"> 
                                    <input type="text" class="form-control itemcode enterinput " id="puit_barcode_1" name="puit_barcode[]"  data-id='1' data-targetbtn='view' placeholder="Item Code">
                                    <input type="hidden" class="qude_itemsid" name="itemid[]" data-id='1' value="" id="itemid_1">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_normal'); ?>' data-id='1' id="view_1"><strong>...</strong></a>
                                </div>
                            </td>
                            <td>  
                                <input type="text" class="form-control itemname" id="itemname_1" name="itemname[]"  data-id='1' placeholder="Item name">
                                <input type="hidden" class="eachsubtotal" name="eachsubtotal[]" id="eachsubtotal_1" >
                                <input type="hidden" name="disamt[]" value="" id="disamt_1" class="disamt calamt"> 
                            <input type="hidden" name="vatamt[]" value="" id="vatamt_1" class="vatamt">
                            </td>
                            <td>
                                <input type="text" class="form-control float calamt" name="purrate[]" id="purrate_1" value="0"  data-id='1' placeholder="Purchase Rate">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="unit[]" id="unit_1" value="0"  data-id='1' placeholder="Unit">
                            </td>
                            <td>
                                <input type="text" class="form-control float calamt openingstock" name="openstockqty[]" id="openstockqty_1" value="0"  data-id='1' placeholder="Opening Stock">
                            </td>
                             <td>
                                <input type="text" class="form-control float calamt unusedstock" name="unused_stockqty[]" id="unused_stockqty_1" value="0"  data-id='1' placeholder="Unused Stock">
                            </td>

                            <td><input type="text" class="form-control <?php echo DATEPICKER_CLASS; ?>" name="expdate[]" id="expiry_date_1"  data-id='1' placeholder="Exp Date"> </td>
                           
                            <td>
                                <input type="text" class="form-control" name="description[]" value="" data-id='1' placeholder="Description"> 
                            </td>
                             <td>
                                <input type="text" class="form-control" name="remarks[]" value="" data-id='1' placeholder="Remarks"> 
                            </td>
                            <td>
                                <div class="actionDiv acDiv2"></div>
                            </td>
                        </tr>
                    </tbody>
                    <tr>
                        <td colspan="15">
                            <a href="javascript:void(0)" class="btn btn-primary btnAdd1 pull-right" data-id="1"  id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                        </td>
                    </tr>
                </table>          
            </div>
    </div>
    <?php } ?>
    <div class="form-group">
        <div class="col-md-12">
            <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($opening_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($opening_data)?'Update':'Save' ?></button>
        </div>
        <div class="col-sm-12">
            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
        </div>
    </div>
    <div class="clearfix"></div>
</form>
<script type="text/javascript">
     $(document).off('click','.btnAdd1');
    $(document).on('click','.btnAdd1',function(){
        var productcontent=$('#puit_barcode_1').html();
        var id = $(this).data('id');
        var barcode = $('#itemname_'+id).val();
        var product = $('#itemid_'+id).val();
        var rate = $('#purrate__'+id).val();
        if(product=='' || product==null )
        {
            $('#itemid_'+id).select2('open');
            $('#puit_barcode_'+id).focus();
            return false;
        }
        var orderlen=$('.orderrow').length;
        var newitemid=$('#itemid_'+orderlen).val();
        if(newitemid=='')
        {
            $('#puit_barcode_'+orderlen).focus();
            return false;
        }

        var trplusOne = orderlen+1;
        if(trplusOne==2)
        {
            $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');
        }
        var templat='';
        templat='<tr class="orderrow" id="orderrow_'+trplusOne+'" data-id="'+trplusOne+'"><td> <input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/></td><td> <div class="dis_tab"> <input type="text" class="form-control itemcode enterinput " id="puit_barcode_'+trplusOne+'" name="puit_barcode[]" data-id="'+trplusOne+'" data-targetbtn="view" placeholder="Item Code"> <input type="hidden" class="qude_itemsid" name="itemid[]" data-id="'+trplusOne+'" value="" id="itemid_'+trplusOne+'"><a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading="Item List" data-viewurl="<?php echo base_url('stock_inventory/item/list_item_normal'); ?>" data-id="'+trplusOne+'" id="view_'+trplusOne+'"><strong>...</strong></a> </div></td><td> <input type="text" class="form-control itemname" id="itemname_'+trplusOne+'" name="itemname[]" data-id="'+trplusOne+'" placeholder="Item name"> <input type="hidden" class="eachsubtotal" name="eachsubtotal[]" id="eachsubtotal_'+trplusOne+'"> <input type="hidden" name="disamt[]" value="" id="disamt_'+trplusOne+'" class="disamt calamt"> <input type="hidden" name="vatamt[]" value="" id="vatamt_'+trplusOne+'" class="vatamt"></td><td> <input type="text" class="form-control float calamt" name="purrate[]" id="purrate_'+trplusOne+'" value="0" data-id="'+trplusOne+'" placeholder="Purchase Rate"></td> <td> <input type="text" class="form-control" name="unit[]" id="unit_'+trplusOne+'" value="0" data-id="'+trplusOne+'" placeholder="Unit"> </td><td> <input type="text" class="form-control float calamt openingstock" name="openstockqty[]" id="openstockqty_'+trplusOne+'" value="0" data-id="'+trplusOne+'" placeholder="Opening Stock Qty"></td> <td><input type="text" class="form-control float calamt unusedstock" name="unused_stockqty[]" id="unused_stockqty_'+trplusOne+'" value="0"  data-id="'+trplusOne+'" placeholder="Unused Stock"></td><td> <input type="text" class="form-control <?php echo DATEPICKER_CLASS; ?>" name="expdate[]" id="expiry_date_'+trplusOne+'" data-id="'+trplusOne+'" placeholder="Exp Date"> </td><td> <input type="text" class="form-control" name="description[]" value="" data-id="'+trplusOne+'" placeholder="Description"></td><td> <input type="text" class="form-control" name="remarks[]" value="" data-id="'+trplusOne+'" placeholder="Remarks"></td><td><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a> <div class="actionDiv"></div></td></tr>';
        // console.log(templat);
        $('#purchaseDataBody').append(templat);
        $('.btnTemp').hide();
        $('.nepdatepicker').nepaliDatePicker({
          npdMonth: true,
          npdYear: true,
        });
    });
        //remove product rows
        $(document).off('click','.btnRemove');
        $(document).on('click','.btnRemove',function(){
        var id=$(this).data('id');
        var whichtr = $(this).closest("tr");
        
        var conf = confirm('Are Your Want to Sure to remove?');
        if(conf){
            $('#orderrow_'+id).fadeOut(1000, function(){
            $('#orderrow_'+id).remove();
            
                setTimeout(function(){
                $(".orderrow").each(function(i,k) {
                var vali=i+1;
                $(this).attr("id","orderrow_"+vali);
                $(this).attr("data-id",vali);
                $(this).find('.sno').attr("id","s_no_"+vali);
                $(this).find('.sno').attr("value",vali);
                //batch_no
                $(this).find('.itemname').attr("id","itemname_"+vali);
                $(this).find('.puit_barcode').attr("data-id",vali);
                $(this).find('.itemcode').attr("id","itemcode_"+vali);
                $(this).find('.puit_productid').attr("data-id",vali);
                $(this).find('.puit_unitid').attr("id","puit_unitid_"+vali);
                $(this).find('.puit_unitid').attr("data-id",vali);
                $(this).find('.puit_qty').attr("id","puit_qty_"+vali);
                $(this).find('.puit_qty').attr("data-id",vali);
                $(this).find('.puit_unitprice').attr("id","puit_unitprice_"+vali);
                $(this).find('.puit_unitprice').attr("data-id",vali);
                $(this).find('.puit_taxid').attr("id","puit_taxid_"+vali);
                $(this).find('.puit_taxid').attr("data-id",vali);
                $(this).find('.totalamount').attr("id","totalamount_"+vali);
                $(this).find('.totalamount').attr("data-id",vali);
                $(this).find('.btnAdd').attr("id","addOrder_"+vali);
                $(this).find('.btnAdd').attr("data-id",vali);
                $(this).find('.btnChange').attr("id","btnChange_"+vali);
                });
                },1500);
                
            });
        }
    });

    $(document).off('click','.itemDetail');
    $(document).on('click','.itemDetail',function(){
    var rowno=$(this).data('rowno');
    var rate=$(this).data('rate');
    var itemcode=$(this).data('itemcode');
    var itemname=$(this).data('itemname');
    var itemname_display=$(this).data('itemname_display');

    var itemid=$(this).data('itemid');
    var stockqty=$(this).data('stockqty');
    var matdetailid=$(this).data('mattransdetailid');
    var controlno=$(this).data('controlno');
    var unit=$(this).data('unit');
    var purchaserate=$(this).data('purchaserate');

    $('#purrate_'+rowno).val(rate); 
    $('#unit_'+rowno).val(unit); 
    $('#puit_barcode_'+rowno).val(itemcode);
    $('#itemid_'+rowno).val(itemid);
    // $('#itemname_'+rowno).val(itemname);
    $('#itemname_'+rowno).val(itemname_display);
    $('#openstockqty_'+rowno).focus();
    $('#itemstock_'+rowno).val(stockqty);
    $('#matdetailid_'+rowno).val(matdetailid);
    $('#controlno_'+rowno).val(controlno);
    $('#myView').modal('hide');
    $('#batch_no_'+rowno).focus();
    $('.calamt').change();
})


  $(document).off('keyup','.unusedstock');
  $(document).on('keyup','.unusedstock',function(e){
    var did=$(this).data('id');
    var openingstock_val=$('#openstockqty_'+did).val();
    var un_usedstock=$(this).val();
    if(parseFloat(un_usedstock)>parseFloat(openingstock_val)){
        alert('Unused Stock is not greater than opening stock');
         $(this).val(0);
        return false;
    }
    });

 

</script>


