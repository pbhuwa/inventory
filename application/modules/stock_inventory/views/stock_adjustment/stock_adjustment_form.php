 <style>
        .purs_table tbody tr td{
            border: none;
            vertical-align: center;
        }
    </style>
<form method="post" id="Formstockadjustment" action="<?php echo base_url('stock_inventory/stock_adjustment/save_stock_adjustment'); ?>" data-reloadurl="<?php echo base_url('stock_inventory/stock_adjustment/form_stock_adjustment');?>" class="form-material form-horizontal form" >
        <div class="form-group">
            <div class="col-md-3 col-sm-4">
                
                <label for="example-text"><?php echo $this->lang->line('date'); ?> <span class="required">*</span>:</label>
                <input type="text" class="form-control <?php echo DATEPICKER_CLASS; ?>" name="stma_stockdate"  value="<?php echo DISPLAY_DATE; ?>" placeholder="Stock Date" id="stma_stockdate">
            </div>
            <div class="col-md-3 col-sm-4">
              <label for="example-text"><?php echo $this->lang->line('store'); ?> <span class="required">*</span>: </label><br>
               <select name="stma_counterid" class="form-control select2" id="frmstore" >
            <?php
             if($equipmnt_type): 
             foreach ($equipmnt_type as $ket => $etype):
             ?>
            <option value="<?php echo $etype->eqty_equipmenttypeid; ?>" ><?php echo $etype->eqty_equipmenttype; ?></option>
         <?php endforeach;
          endif; ?>
                </select>
              
            </div>
            <div class="col-md-4 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('adjustment_name'); ?> <span class="required">*</span>:</label>
                <input type="text" class="form-control required_field" name="stma_remarks"  value="" placeholder="Adjustment Name">                                    
            </div>
           
        </div>
      
        <div class="form-group">
            <div class="col-md-12">
              <?php
              $update_var= $this->lang->line('update'); 
              $save_var= $this->lang->line('save'); 
              ?>
                <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($adjustment_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($adjustment_data)?$update_var:$save_var ?></button> 
            </div>
              <div class="col-sm-12">
                <div  class="alert-success success"></div>
                <div class="alert-danger error"></div>
              </div>
        </div>
         <div class="clearfix"></div>
    </form>


<script type="text/javascript">
 $(document).on('click','.itemDetail',function(){
    var rowno=$(this).data('rowno');
    var unit=$(this).data('unit');
    var rate=$(this).data('rate');
    var itemcode=$(this).data('itemcode');
    var itemname=$(this).data('itemname');
    var itemid=$(this).data('itemid');
    var stockqty=$(this).data('stockqty');

    $('#itemcode_'+rowno).val(itemcode);
    $('#itemid_'+rowno).val(itemid);
    $('#itemname_'+rowno).val(itemname);
    $('#itemunit_'+rowno).val(unit);
    $('#itemrate_'+rowno).val(rate);
    $('#itemstock_'+rowno).val(stockqty);
    $('#myView').modal('hide');
    $('#itemqty_'+rowno).focus();

 })

</script>

<script type="text/javascript">
     $(document).off('click','.btnAddReq');
    $(document).on('click','.btnAddReq',function(){
         var id=$(this).data('id');
        var trplusOne = $('.reqtr').length+1;
        // alert(trplusOne);
        if(trplusOne==2)
        {

            $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');
        }
        var tempform='';
    var tempform =' <tr class="reqtr" id="reqtr_'+trplusOne+'" data-id="'+trplusOne+'"><td><input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/></td><td><div class="dis_tab"><input type="text" class="form-control icode " id="itemcode_'+trplusOne+'" name="itemcode[]"  data-id="'+trplusOne+'"><input type="hidden" name="itemid[]" data-id="'+trplusOne+'" value="<?php ?>" id="itemid_'+trplusOne+'"><a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading="Item List" data-viewurl="<?php echo base_url("stock_inventory/item/list_item_with_stock"); ?>" data-id="'+trplusOne+'"><strong>...</strong></a></div></td><td><input type="text" class="form-control" id="itemname_'+trplusOne+'" name="itemname[]"  data-id="'+trplusOne+'"></td><td><input type="text" class="form-control" name="itemunit[]"   id="itemunit_'+trplusOne+'" data-id="'+trplusOne+'"  ></td><td> <input type="text" class="form-control" name="reorderlvl[]"   id="reorderlvl_'+trplusOne+'" data-id="'+trplusOne+'" readonly="true" ></td><td><input type="text" class="form-control number" name="itemstock[]"   id="itemstock_'+trplusOne+'" data-id="'+trplusOne+'" readonly="true" ></td><td><input type="text" class="form-control number calculateamt " id="itemqty_'+trplusOne+'" name="itemqty[]"  data-id="'+trplusOne+'"></td><td><input type="text" class="form-control float calculateamt" id="itemrate_'+trplusOne+'" name="itemrate[]"  data-id="'+trplusOne+'"></td><td><input type="text" class="form-control calculateamt " id="totalamt_'+trplusOne+'" name="totalamt[]"  data-id="'+trplusOne+'"></td><td><input type="text" class="form-control" id="bugetcode_'+trplusOne+'" name="bugetcode[]"  data-id="'+trplusOne+'"></td><td><input type="text" class="form-control " id="remarks_'+trplusOne+'" name="remarks[]"  data-id="'+trplusOne+'"></td><td> <div class="actionDiv"><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div></td></tr>';

    $('#orderBody').append(tempform);
    })

    $(document).off('click','.btnRemove');
    $(document).on('click','.btnRemove',function(){
        var id=$(this).data('id');
         var whichtr = $(this).closest("tr");
         var conf = confirm('Are You Want to Sure to remove?');
          if(conf)
          {
             var trplusOne = $('.reqtr').length+1;
             if(trplusOne==3)
             {
                $('.acDiv2').html('');
             }
             whichtr.remove(); 
            setTimeout(function(){
                  $(".reqtr").each(function(i,k) {
                    var vali=i+1;
                    $(this).attr("id","reqtr_"+vali);
                    $(this).attr("data-id",vali);    
                    $(this).find('.sno').attr("id","s_no_"+vali);
                    $(this).find('.sno').attr("value",vali);
                    $(this).find('.itemcode').attr("id","itemcode_"+vali);
                    $(this).find('.itemid').attr("id","orma_qty_"+vali);
                    $(this).find('.itemid').attr("data-id",vali);
                    $(this).find('.itemname').attr("id","itemname_"+vali);
                    $(this).find('.itemname').attr("data-id",vali);
                    $(this).find('.itemunit').attr("id","itemunit_"+vali);
                    $(this).find('.itemunit').attr("data-id",vali);
                    $(this).find('.reorderlvl').attr("id","reorderlvl_"+vali);
                    $(this).find('.reorderlvl').attr("data-id",vali);
                    $(this).find('.itemstock').attr("id","itemstock_"+vali);
                    $(this).find('.itemstock').attr("data-id",vali);
                    $(this).find('.itemqty').attr("id","itemqty_"+vali);
                    $(this).find('.itemqty').attr("data-id",vali);
                    $(this).find('.itemrate').attr("id","itemrate_"+vali);
                    $(this).find('.itemrate').attr("data-id",vali);
                    $(this).find('.totalamt').attr("id","totalamt_"+vali);
                    $(this).find('.totalamt').attr("data-id",vali);
                    $(this).find('.bugetcode').attr("id","bugetcode_"+vali);
                    $(this).find('.bugetcode').attr("data-id",vali);
                    $(this).find('.remarks').attr("id","remarks_"+vali);
                    $(this).find('.remarks').attr("data-id",vali);
                    $(this).find('.btnAddReq').attr("id","addRequistion_"+vali);
                    $(this).find('.btnAddReq').attr("data-id",vali);
                    $(this).find('.btnRemove').attr("id","addRequistion_"+vali);
                    $(this).find('.btnRemove').attr("data-id",vali);
                    $(this).find('.btnChange').attr("id","btnChange_"+vali);
            });
              },600);
          }
     });
</script>

<script type="text/javascript">
    $(document).on('keyup change','.calculateamt',function()
    {
        var did=$(this).data('id');
        var qty=$('#itemqty_'+did).val();
        var irate=$('#itemrate_'+did).val();
        var totalamt=qty*irate;
        $('#totalamt_'+did).val(totalamt);
    })


    
</script>


