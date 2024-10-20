<form method="post" id="FormMenu" action="<?php echo base_url('stock_inventory/challan/save_challan'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('stock_inventory/challan/form_challan'); ?>'>
    <input type="hidden" name="id" value="<?php echo!empty($challan_data[0]->chma_challanmasterid)?$challan_data[0]->chma_challanmasterid:'';  ?>">
    <div class="white-box bg-gray col_btm_gap">
        
        <div class="form-group">
            <div class="col-md-4">
                <label for="example-text"><?php echo $this->lang->line('challan_receive_no'); ?>: <span class="required">*</span>:</label>
                <input type="text" class="form-control" name="chma_receiveno" id="txtchallanCode">
            </div>

            <div class="col-md-4"> 
                <label for="example-text"><?php echo $this->lang->line('supplier'); ?>: <span class="required">*</span>:</label>
                <select name="chma_supplierid" class="form-control select2" id="deptsubcategory">
                    <option value="">---select---</option>
                    <?php
                        if($subcategory):
                            foreach ($subcategory as $km => $mat):
                    ?> 
                        <!-- subcategory id -->  
                        <option value="<?php echo $mat->eqca_equipmentcategoryid; ?>"><?php echo $mat->eqca_category; ?></option>
                    <?php 
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>

            <div class="col-md-4">
                <label for="example-text"> Ch.Receive Date:<span class="required">*</span>:</label>
                <input type="text" name="chma_receivedatebs" class="form-control <?php echo DATEPICKER_CLASS; ?>"  placeholder="" value="<?php echo DISPLAY_DATE; ?>" id="receivw_date">
            </div>
        </div>

        <div class="clear-fix"></div>

        <div class="form-group">
            <div class="col-md-4">
                <label for="example-text">Sup.Challan NO.: <span class="required">*</span>:</label>
                <input type="text" class="form-control" name="chma_suchallanno" id="txtchallanCode">
            </div>

            <div class="col-md-4">
                <label for="example-text">Sup.Challan Date :</label>
                <input type="text" name="chma_suchalandatebs" class="form-control <?php echo DATEPICKER_CLASS; ?>"  placeholder="" value="<?php echo DISPLAY_DATE; ?>" id="challan_date">
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table style="width:100%;" class="table purs_table">
            <thead>
                <tr>
                    <th width="5%"> S.No. </th>
                    <th width="10%"> Item Code  </th>
                    <th width="25%"> Item Name </th>
                    <th width="10%"> Unit  </th>
                    <th width="8%"> Quantity </th>
                    <th width="10%"> Rate </th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody id="purchaseBody">
                <tr class="directrow" id="directrow_1" data-id='1'>
                    <td>
                          <input type="text" class="form-control sno" id="s_no_1" value="1" readonly/>
                    </td>
                    <td> 
                        <input type="text" class="form-control float trde_mtmid calculateamt" id="trde_mtmid_1" name="trde_mtmid[]"  data-id='1'> 
                    </td>
                    <td>                             
                        <select name="trde_itemsid[]" class="form-control rede_itemsid  calculateamt" id="trde_itemsid_1" >
                            <option value="">---Select---</option>
                            <?php if($item_all):
                            foreach ($item_all as $key => $itm):?>
                            <option value="<?php echo $itm->itli_itemlistid; ?>"><?php echo $itm->itli_itemname; ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </td>
                    <td> 
                            <input type="text" class="form-control float trde_unitpercase calculateamt trde_unitpercase" name="trde_unitpercase[]"   id="trde_unitpercase_1" data-id='1' readonly /> 
                    </td>
                    <td> 
                            <input type="text" class="form-control float trde_issueqty calculateamt trde_issueqty" name="trde_issueqty[]"   id="trde_issueqty_1" data-id='1' > 
                    </td>
                    <td> 
                            <input type="text" class="form-control float trde_unitprice calculateamt trde_unitprice" name="trde_unitprice[]"   id="trde_unitprice_1" data-id='1' > 
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-primary btnAdd" data-id="1"  id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                    </td>
                </tr>    
            </tbody>
        </table>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($menu_data)?'update':'save' ?>' id="btnSubmit">
                <?php echo !empty($menu_data)?'Update':'Save' ?>
            </button>
        </div>

        <div class="col-sm-12">
            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $('.engdatepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });
    $('.nepdatepicker').nepaliDatePicker();
</script>

<script type="text/javascript">
    $(document).off('click','.btnAdd');
    $(document).on('click','.btnAdd',function(){
        var id=$(this).data('id');
        var itemid=$('#trde_itemsid_'+id).val();
        var qty=$('#trde_unitpercase_'+id).val();
        var rate=$('#rede_qty_'+id).val();
        var trplusOne = $('.directrow').length+1;
        var template='';
        template='<tr class="directrow" id="directrow_'+trplusOne+'" data-id="'+trplusOne+'"><td><input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/></td><td><input type="text" class="form-control float trde_mtmid calculateamt" id="trde_mtmid_'+trplusOne+'" name="trde_mtmid[]"  data-id='+trplusOne+'></td><td><select name="trde_itemsid[]" class="form-control trde_itemsid calculateamt" id="trde_itemsid_'+trplusOne+'" ><option value="">---Select---</option><?php if($item_all):
                foreach ($item_all as $key => $itm):?> <option value="<?php echo $itm->itli_itemlistid; ?>"><?php echo $itm->itli_itemname; ?></option> <?php endforeach; endif; ?></select></td><td><input type="text" class="form-control float trde_unitpercase calculateamt" name="trde_unitpercase[]" id="trde_unitpercase_'+trplusOne+'" data-id="'+trplusOne+'"></td><td><input type="text" class="form-control float trde_issueqty calculateamt trde_issueqty" name="trde_issueqty[]"  id="trde_issueqty_'+trplusOne+'" data-id="'+trplusOne+'" ></td><td> <input type="text" class="form-control float trde_unitprice calculateamt trde_unitprice" name="trde_unitprice[]" id="trde_unitprice_'+trplusOne+'"></td><td><a href="javascript:void(0)" class="btn btn-primary btnAdd" data-id="'+trplusOne+'"  id="addOrder_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-plus" aria-hidden="true"></i></span></a></td></tr>';
         $('#addOrder_'+id).removeClass('btn btn-primary btnAdd').addClass('btn btn-danger btnRemove');
         $('#btnChange_'+id).html('<i class="fa fa-trash-o" aria-hidden="true"></i>');
         $('#purchaseBody').append(template);
    });
    $(document).off('click','.btnRemove');
    $(document).on('click','.btnRemove',function(){
        var id=$(this).data('id');
        var whichtr = $(this).closest("tr");
        var conf = confirm('Are Your Want to Sure to remove?');
        if(conf)
        {
            var trplusOne = $('.directrow').length+1;
            whichtr.remove(); 
            
            setTimeout(function(){
                $(".directrow").each(function(i,k) {
                    var vali=i+1;
                    $(this).attr("id","directrow_"+vali);
                    $(this).attr("data-id",vali);    
                    $(this).find('.sno').attr("id","s_no_"+vali);
                    $(this).find('.sno').attr("value",vali);
                    $(this).find('.orma_itemid').attr("id","orma_itemid_"+vali);
                    $(this).find('.orma_qty').attr("id","orma_qty_"+vali);
                    $(this).find('.orma_qty').attr("data-id",vali);
                    $(this).find('.orma_unitprice').attr("id","orma_unitprice_"+vali);
                    $(this).find('.orma_unitprice').attr("data-id",vali);
                    $(this).find('.totalamount').attr("id","totalamount_"+vali);
                    $(this).find('.totalamount').attr("data-id",vali);
                    $(this).find('.btnAdd').attr("id","addOrder_"+vali);
                    $(this).find('.btnAdd').attr("data-id",vali);
                    $(this).find('.btnRemove').attr("id","addOrder_"+vali);
                    $(this).find('.btnRemove').attr("data-id",vali);
                    $(this).find('.btnChange').attr("id","btnChange_"+vali);
                });
            },600);
        }
    });
</script>