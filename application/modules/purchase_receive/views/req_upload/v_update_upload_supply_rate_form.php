<style>
    .purs_table tbody tr td{
    border: none;
    vertical-align: center;
    }
</style>


<form method="post" id="formReqUpload" action="<?php echo base_url('purchase_receive/req_upload/update_supplier_rate_entry'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('/purchase_receive/req_upload/supply_rate_correction/reload'); ?>' enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo!empty($sup_rate_masterdata->urem_uremid)?$sup_rate_masterdata->urem_uremid:'';  ?>">

    <div class="form-group">
        <div class="col-md-3 col-sm-4">

            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?><span class="required">*</span>:</label>
            <br>
           <?php echo !empty($sup_rate_masterdata->urem_fyear)?$sup_rate_masterdata->urem_fyear:''; ?>
        </div>
              
         <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('upload_no'); ?><span class="required">*</span>: </label>
            <br>
            <?php echo !empty($sup_rate_masterdata->urem_uploadno)?$sup_rate_masterdata->urem_uploadno:''; ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-3 col-sm-4">
            <label for="Supplier"><?php echo $this->lang->line('supplier_name'); ?> <span class="required">*</span>:</label> 
            <br>     
         <?php echo !empty($sup_rate_masterdata->dist_distributor)?$sup_rate_masterdata->dist_distributor:''; ?>
        </div>

        <div class="col-md-3 col-sm-4">
                <?php $supplier_date=!empty($sup_rate_masterdata->urem_supplierdatebs)?$sup_rate_masterdata->urem_supplierdatebs:''; ?>
            <label for="urem_supplierdate">
                <?php echo $this->lang->line('supplier_date'); ?>
                <span class="required">*</span>:
            </label>
            <input type="text" name="supplierdate" class="form-control required_field <?php echo DATEPICKER_CLASS; ?> date" placeholder="Valid Upto" id="urem_supplierdate" value="<?php echo !empty($supplier_date)?$supplier_date:''; ?>" readonly="true">
        </div>

        <div class="col-md-3 col-sm-4">
              <?php $manual_no=!empty($sup_rate_masterdata->urem_manualno)?$sup_rate_masterdata->urem_manualno:''; ?>
            <label for="urem_manualno">
                <?php echo !empty($this->lang->line('manual_no'))?$this->lang->line('manual_no'):'Manual No.'; ?> : 
            </label>
            <input type="text" name="urem_manualno" class="form-control number" placeholder="Enter Manual Number" value="<?php echo $manual_no; ?>" id="urem_manualno" />
            <span class="errmsg"></span>
        </div>

        <div class="col-md-3 col-sm-4">
             <?php $validdate=!empty($sup_rate_masterdata->urem_validdatebs)?$sup_rate_masterdata->urem_validdatebs:''; ?>
            <label for="urem_validdate">
                <?php echo $this->lang->line('valid_till'); ?>
                <span class="required">*</span>:
            </label>
            <input type="text" name="urem_validdate" class="form-control required_field <?php echo DATEPICKER_CLASS; ?> date" placeholder="Valid Upto" id="urem_validdate" value="<?php echo !empty($validdate)?$validdate:''; ?>" readonly="true">
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group">
        <div class="col-md-6 col-sm-4">
            <?php
                $remarks = !empty($sup_rate_masterdata->urem_remarks)?$sup_rate_masterdata->urem_remarks:'';
            ?>
            <label for="urem_remarks"><?php echo $this->lang->line('remarks'); ?>:</label>
            <input type="text" name="urem_remarks" class="form-control" placeholder="Remarks" id="urem_remarks" value="<?php echo $remarks;  ?>"  />
        </div>
         <div class="col-md-2 ">
         </div>
          <div class="col-md-4 ">
           <a href="javascript:void(0)" class="btn btn-sm" id="all_amt_calculate"> All Calculate Amount </a>
         </div>

    </div>
    <div class="clearfix"></div>
   

    <div class="form-group">
        <div class="table-responsive col-sm-12">
            <div class="pad-5" id="displayDetailList">
                <table style="width:100%;" class="table purs_table dataTable">
                    <thead>
                        <tr>
                <th width="5%"> <?php echo $this->lang->line('sn'); ?> </th>
                <th width="25%"> <?php echo $this->lang->line('item_name'); ?>  </th>
                <th width="18%"> <?php echo $this->lang->line('manufacturer'); ?> </th>
                <th width="5%"><?php echo $this->lang->line('qty'); ?></th>
                <th width="8%"><?php echo $this->lang->line('size'); ?></th>
                <th width="8%"> <?php echo $this->lang->line('rate'); ?> </th>
                <th width="5%"> <?php echo $this->lang->line('vat'); ?><input type="text" class="form-control" id="allvat" value="13"> </th>
                <th width="10%"> <?php echo $this->lang->line('total_amount'); ?> </th>
                <th width="10%"> <?php echo $this->lang->line('remarks'); ?></th>
                      
            <?php if(!empty($sup_rate_detaildata)) { ?> <th width="5%"> <?php echo $this->lang->line('action'); ?> </th> <?php } ?>
            </tr>
                    </thead>

                    <tbody id="purchaseBody">
                        <?php
                        if(!empty($sup_rate_detaildata)):
                            $i=1;
                            foreach ($sup_rate_detaildata as $ksr => $ddat):
                         ?>
                         <tr>
                            <input type="hidden" name="ured_uredid[]" value="<?php echo $ddat->ured_uredid; ?>">
                            <td><?php echo $i ?></td>
                            <input type="hidden" name="ured_itemid[]" value="<?php echo $ddat->ured_itemid ?>">
                            <td><?php echo $ddat->ured_itemname ?></td>
                            <td><?php echo $ddat->ured_manufacturer ?></td>
                            <td>
                                 <input type="text" class="form-control float qty arrow_keypress calamt" id="qty_<?php echo $i; ?>" name="ured_qty[]" value="<?php echo $ddat->ured_qty ?>" data-id='<?php echo $i; ?>'>
                            </td>
                            <td>
                                    <input type="text" class="form-control  arrow_keypress size" name="ured_size[]" id="size_<?php echo $i; ?>" value="<?php echo $ddat->ured_size ?>" data-id='<?php echo $i; ?>'>
                                </td>
                            <td>
                                <input type="text" class="form-control arrow_keypress float calamt" name="ured_rate[]" id="rate_<?php echo $i; ?>" value="<?php echo sprintf('%g',$ddat->ured_rate); ?>" data-id='<?php echo $i; ?>'>
                                 </td>
                            <td>
                            <input type="text" class="form-control arrow_keypress float calamt" name="ured_vatpc[]" value="<?php echo sprintf('%g',$ddat->ured_vatpc); ?>"  id="vat_<?php echo $i; ?>" data-id='<?php echo $i; ?>'>

                              <input type="hidden" name="ured_vatamt[]" id="vatamt_<?php echo $i; ?>" value="" >
                            </td>
                           
                            <td>
                                 <input type="text" class="form-control arrow_keypress totalamount float" name="ured_totalamount[]" value="<?php echo $ddat->ured_totalamount ?>"id="totalamount_<?php echo $i; ?>" readonly data-id='<?php echo $i; ?>'>

                                </td>
                            <td><input type="text" class="form-control" name="ured_remarks[]" value="<?php echo $ddat->ured_remarks ?>" data-id='<?php echo $i; ?>'>
                              </td>
                            <td>
                                 <a href="javascript:void(0)" class="btn btn-sm btn-danger btnRemove" id="btnRemove_<?php echo $i; ?>" data-id='<?php echo $i; ?>'>
                            <i class="fa fa-remove"></i>
                        </a> 
                        <a href="javascript:void(0)" class="cal_btn" data-id='<?php echo $i; ?>' id="cal_<?php echo $i; ?>">Cal</a>

                            </td>
                         </tr>
                     <?php $i++; endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <button type="submit" class="btn btn-info  save" data-isdismiss='Y' data-closediv='displayReportDiv' data-operation='<?php echo !empty($sup_rate_masterdata)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($sup_rate_masterdata)?'Update':'Save' ?></button>
        </div>
        
        <div class="col-sm-12">
            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
        </div>
    </div>
</form>



<script>
    $(document).off('click','.btnRemove');
    $(document).on('click','.btnRemove',function(){
        var id=$(this).data('id');
        var whichtr = $(this).closest("tr");
        var conf = confirm('Are Your Want to Sure to remove?');
        if(conf){
            var trplusOne = $('.orderrow').length+1;
           
            whichtr.remove(); 
            setTimeout(function(){
                $(".orderrow").each(function(i,k) {
                    var vali=i+1;
                    $(this).attr("id","orderrow_"+vali);
                    $(this).attr("data-id",vali);    
                    $(this).find('.s_no').attr("id","s_no_"+vali);
                    $(this).find('.s_no').attr("value",vali);
                    $(this).find('.itemname').attr("id","itemname_"+vali);
                    $(this).find('.itemname').attr("data-id",vali);
                    $(this).find('.manufacturer').attr("id","manufacturer_"+vali);
                    $(this).find('.manufacturer').attr("data-id",vali);
                    $(this).find('.qty').attr("id","qty_"+vali);
                    $(this).find('.qty').attr("data-id",vali);
                     $(this).find('.size').attr("id","size_"+vali);
                    $(this).find('.size').attr("data-id",vali);

                    $(this).find('.rate').attr("id","rate_"+vali);
                    $(this).find('.rate').attr("data-id",vali);

                    $(this).find('.totalamount').attr("id","totalamount_"+vali);
                    $(this).find('.totalamount').attr("data-id",vali);

                    $(this).find('.remarks').attr("id","remarks_"+vali);
                    $(this).find('.remarks').attr("data-id",vali);

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

<script type="text/javascript">
    $(document).off('keyup change','.calamt');
    $(document).on('keyup change','.calamt',function(){
        var id = $(this).data('id');
        var rate = $('#rate_'+id).val();
        var vat =$('#vat_'+id).val();
        var qty = $('#qty_'+id).val();
        var vatamt=(vat/100)*(rate*qty);
        var total_amt = (rate*qty)+vatamt;
        $('#vatamt_'+id).val(vatamt);

        $('#totalamount_'+id).val(total_amt);
    });
</script>

<script type="text/javascript">
    $(document).off('keyup change','#allvat');
    $(document).on('keyup change','#allvat',function(e){
        var vatval=$(this).val();
        $(".vatval").each(function() { 
         $(this).val(vatval);
         // $('.calamt').change();
     });
    });

$(document).off('click','.cal_btn');
$(document).on('click','.cal_btn',function(e){
 var id = $(this).data('id');
var rate = $('#rate_'+id).val();
var vat =$('#vat_'+id).val();
var qty = $('#qty_'+id).val();
var vatamt=(vat/100)*(rate*qty);
var total_amt = (rate*qty)+vatamt;
$('#vatamt_'+id).val(vatamt.toFixed(2));

$('#totalamount_'+id).val(total_amt.toFixed(2));

})

 $(document).off('click','#all_amt_calculate');
    $(document).on('click','#all_amt_calculate',function(e){
        $('.cal_btn').click();
     });

</script>


<?php
    if(!empty($loadselect2) && $loadselect2=='yes'):
    ?>
<script type="text/javascript">
     setTimeout(function() {
          $('.select2').select2();
 }, 800);
  
</script>
<?php
    endif;
?>