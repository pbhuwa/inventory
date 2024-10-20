 <style>
    .purs_table tbody tr td{
        border: none;
        vertical-align: center;
    }
</style>
<?php
    $id = !empty($req_wo_data[0]->woma_womasterid)?$req_wo_data[0]->woma_womasterid:'';
?>
<form method="post" id="FormWorkOrder" action="<?php echo base_url('ams/workorder/save_work_order'); ?>" class="form-material form-horizontal form" data-reloadurl="<?php echo base_url('ams/workorder/entry/reload'); ?>">
    <input type="hidden" name="id" value="<?php echo !empty($req_wo_data[0]->woma_womasterid)?$req_wo_data[0]->woma_womasterid:'';  ?>">
        <div class="form-group">
            <div class="col-md-3 col-sm-4">
        <?php $woma_fiscalyrs = !empty($req_wo_data[0]->woma_fiscalyrs)?$req_wo_data[0]->woma_fiscalyrs:CUR_FISCALYEAR; ?>
        <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?><span class="required">*</span> :</label>
       <select name="woma_fiscalyrs" class="form-control required_field" id="fyear">
           <?php
             if(!empty($fiscal_year)): 
             foreach ($fiscal_year as $kf => $fyrs):
             ?>
            <option value="<?php echo $fyrs->fiye_name; ?>" <?php if($fyrs->fiye_status=='I') echo "selected=selected"; ?> ><?php echo $fyrs->fiye_name; ?></option>
         <?php endforeach; endif; ?>
       </select>
    </div>

            <div class="col-md-3">
                <?php $woma_workorderno=!empty($req_wo_data[0]->woma_workorderno)?$req_wo_data[0]->woma_workorderno:$workorder_code; ?>
                <label for="example-text">Estimate No. <span class="required">*</span>:</label>
                <input type="text" class="form-control required_field" name="woma_workorderno" id="woma_workorderno" value="<?php echo $woma_workorderno; ?>" readonly />
            </div>
           
            

            <div class="col-md-3">
                <?php $woma_manualno=!empty($req_wo_data[0]->woma_manualno)?$req_wo_data[0]->woma_manualno:0; ?>
                <label for="example-text"><?php echo $this->lang->line('manual_no'); ?>  :</label>
                <input type="text" class="form-control" name="woma_manualno" value="<?php echo $woma_manualno; ?>" placeholder="Enter Manual Number">
            </div>

            <div class="col-md-3">
                <?php
                    if(DEFAULT_DATEPICKER == 'NP'){
                        $work_order_date = !empty($req_wo_data[0]->woma_datebs)?$req_wo_data[0]->woma_datebs:DISPLAY_DATE;
                    }else{
                        $work_order_date = !empty($req_wo_data[0]->woma_datead)?$req_wo_data[0]->woma_datead:DISPLAY_DATE;
                    }
                ?>
                <label for="example-text"><?php echo $this->lang->line('date'); ?>: </label>
                <input type="text" name="woma_date" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Requisition Date" value="<?php echo $work_order_date; ?>" id="requisitionDate">
                <span class="errmsg"></span>
            </div>

             <div class="col-md-3">
                <?php $woma_noticeno=!empty($req_wo_data[0]->woma_noticeno)?$req_wo_data[0]->woma_noticeno:0; ?>
                <label for="example-text">Notice No. :</label>
                <input type="text" class="form-control  " name="woma_noticeno" value="<?php echo $woma_noticeno; ?>" placeholder="Enter Notice Number">
            </div>
            <div class="col-md-3">
                 <?php
                    if(DEFAULT_DATEPICKER == 'NP'){
                        $notice_date = !empty($req_wo_data[0]->woma_noticedatebs)?$req_wo_data[0]->woma_noticedatebs:DISPLAY_DATE;
                    }else{
                        $notice_date = !empty($req_wo_data[0]->woma_noticedatead)?$req_wo_data[0]->woma_noticedatead:DISPLAY_DATE;
                    }
                ?>
               
                <label for="example-text">Notice Date :</label>
                <input type="text" class="form-control <?php echo DATEPICKER_CLASS; ?>" name="notice_date" value="<?php echo $notice_date; ?>" id="notice_date" placeholder="YYYY/MM/DD">
            </div>
            <div class="col-md-3 col-sm-4">
            <?php $supid=!empty($req_wo_data[0]->woma_projectid)?$req_wo_data[0]->woma_projectid:''; ?>
            <label for="example-text">Project <span class="required">*</span>:</label>
            <div class="dis_tab">
            <select name="woma_projectid" id="projectid" class="form-control select2 required_field" >
                <option value="">--select--</option>
            <?php 
            if(!empty($project_list)): 
                foreach($project_list as $pl):
            ?>
            <option value="<?php echo $pl->prin_prinid ?>"><?php echo $pl->prin_project_title ?></option> 
            <?php 
                endforeach; 
            endif; 
            ?>
            </select>

             <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 refresh_element" data-targetid="order_supplierid" data-viewurl="<?php echo base_url('biomedical/distributors/distributor_reload'); ?>"><i class="fa fa-refresh"></i></a>

               <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 view" data-heading='Supplier Entry' data-viewurl='<?php echo base_url('biomedical/distributors/supplier_entry/modal'); ?>'><i class="fa fa-plus"></i></a>
            </div>
        </div>

            <div class="col-md-3 col-sm-4">
            <?php $supid=!empty($req_wo_data[0]->woma_supplierid)?$req_wo_data[0]->woma_supplierid:''; ?>
            <label for="example-text">Contractor <span class="required">*</span>:</label>
            <div class="dis_tab">
            <select name="woma_supplierid" id="order_supplierid" class="form-control select2 required_field" >
                <option value="">---All---</option>
                <?php
                    if(!empty($distributor)):
                        foreach ($distributor as $km => $sup):
                ?>
                 <option value="<?php echo $sup->dist_distributorid; ?>" <?php if($supid==$sup->dist_distributorid) echo "selected=selected"; ?>><?php echo $sup->dist_distributor; ?></option>
                <?php
                        endforeach;
                    endif;
                ?>
            </select>

             <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 refresh_element" data-targetid="order_supplierid" data-viewurl="<?php echo base_url('biomedical/distributors/distributor_reload'); ?>"><i class="fa fa-refresh"></i></a>

               <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 view" data-heading='Supplier Entry' data-viewurl='<?php echo base_url('biomedical/distributors/supplier_entry/modal'); ?>'><i class="fa fa-plus"></i></a>
            </div>
        </div> 
        <div class="col-md-3 col-sm-4">
            <label>Site</label>
             <?php $woma_site=!empty($req_wo_data[0]->woma_site)?$req_wo_data[0]->woma_site:''; ?>
            <input type="text" name="woma_site" class="form-control" value="<?php echo $woma_site ?>">
        </div>



            
            
            

            
        </div>
        <div class="clearfix"></div>

        

        <div class="form-group">
            <div class="table-responsive col-sm-12">
                <table style="width:100%;" class="table dataTable dt_alt purs_table res_vert_table">
                    <thead>
                        <tr>
                            
                        <th scope="col" width="5%"> <?php echo $this->lang->line('sn'); ?>. </th>
                        <th>Description Type</th>
                        <th scope="col" width="25%"> Description </th>
                        <th scope="col" width="5%"> Qty</th>
                        <th scope="col" width="5%"> <?php echo $this->lang->line('unit'); ?>  </th>
                        <th scope="col" width="10%"> <?php echo $this->lang->line('rate'); ?>  </th>
                        <th scope="col" width="10%"> Total </th>
                        <th scope="col" width="15%"><?php echo $this->lang->line('remarks'); ?> </th>
                        <th scope="col" width="5%"> <?php echo $this->lang->line('action'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="orderBody">
                        
                        <tr class="orderrow" id="orderrow_1" data-id='1'>
                           
                            <td data-label="S.No.">
                                <input type="text" class="form-control sno" id="s_no_1" value="1" readonly/>
                            </td>
                             <td>
                                <select class="form-control wode_dtype" name="wode_dtype[]" id="wode_dtype_1" data-id="1">
                                <option value="SM">Supply Of Material</option>
                                <option value="CW">Civil Works</option>
                                </select>
                            </td>
                            <td data-label="Description">  
                                <input type="text" class="form-control wode_description required_field"  id="wode_description_1" name="wode_description[]"  data-id='1' > 
                            </td>
                             <td data-label="Quantity"> 
                                <input type="text" class="form-control float wode_qty calculateamt required_field" name="wode_qty[]"   id="wode_qty_1" data-id='1' > 
                            </td>
                              <td data-label="Unit"> 
                                <input type="text" value="" class="form-control wode_unit" name="wode_unit[]" id="wode_unit_1" data-id='1'> 
                            </td>

                            <td data-label="Rate"> 
                                <input type="text" class="form-control float wode_rate calculateamt wode_rate required_field" name="wode_rate[]"   id="wode_rate_1" data-id='1' > 
                            </td>
                             <td data-label="totalamt"> 
                                <input type="text" class="form-control float wode_totalamt" name="wode_totalamt[]"   id="totalamt_1" data-id='1' readonly > 
                            </td>
                            <td data-label="Remarks"> 
                                <input type="text" class="form-control  wode_remarks jump_to_add " id="wode_remarks_1" name="wode_remarks[]"  data-id='1'> 
                            </td>
                            <td data-label="Action">
                                 <div class="actionDiv acDiv2" id="acDiv2_1"></div>
                            </td>
                        </tr>
                     
                        
                    </tbody>
                    <tbody>
                        <tr class="resp_table_breaker">
                            <td colspan="9">
                                <a href="javascript:void(0)" class="btn btn-primary btnAdd pull-right" data-id="1"  id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                                <div class="clearfix"></div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <label>Remarks</label>
                                <textarea class="form-control" name="woma_remark"></textarea>
                            </td>
                            <td colspan="1">
                                <label>G.Total</label> <input type="text" class="form-control" name="gtotal" id="gtotal" readonly>
                            </td>
                        </tr>
                    </tfoot>
                        
                </table>
                <div id="Printable" class="print_report_section printTable">
                
                </div>
            </div> <!-- end table responsive -->
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($req_wo_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($req_wo_data)?'Update':$this->lang->line('save');  ?></button>
                <button type="submit" class="btn btn-info savePrint" data-operation='<?php echo !empty($req_wo_data)?'update':'save ' ?>' id="btnSubmit" data-print="print"><?php echo !empty($req_wo_data)?'Update & Print':$this->lang->line('save_and_print') ?></button>
            </div>
            <div class="col-sm-12">
                <div  class="alert-success success"></div>
                <div class="alert-danger error"></div>
            </div>
        </div>
    </form>

<script type="text/javascript">
   $(document).off('click','.btnAdd');
    $(document).on('click','.btnAdd',function(){
        var id=$(this).data('id');
       
      
        // alert(wode_qty);
        // return false;
        var rate=$('#rede_qty_'+id).val();
        var rates=$('#unitprice_'+id).val();
        var trplusOne = $('.orderrow').length+1;
        var trpluOne = $('.orderrow').length;
        var trplusTwo=trplusOne+1;
       
         var reqrate=$('#unitprice_'+trpluOne).val();
      
        var wode_description=$('#wode_description_'+trpluOne).val();
        var wode_qty=$('#wode_qty_'+trpluOne).val();
        if(wode_description=='')
        {
            $('#wode_description_'+trpluOne).focus();
            return false;
        }
          if(wode_qty==0 || wode_qty=='' || wode_qty==null )
        {
            $('#wode_qty_'+trpluOne).focus();
            return false;
        }
       var last_dtype=$('#wode_dtype_'+trpluOne).val();


     

        if(trplusOne==2)
        {
            $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');
        }
        var template='';
        template='<tr class="orderrow" id="orderrow_'+trplusOne+'" data-id='+trplusOne+'><td data-label="S.No."> <input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/></td><td><select class="form-control wode_dtype" name="wode_dtype[]" id="wode_dtype_'+trplusOne+'" data-id="'+trplusOne+'"><option value="SM">Supply Of Material</option><option value="CW">Civil Works</option></select></td><td data-label="Description"> <input type="text" class="form-control wode_description required_field" id="wode_description_'+trplusOne+'" name="wode_description[]" data-id='+trplusOne+' ></td><td data-label="Quantity"> <input type="text" class="form-control float wode_qty calculateamt required_field" name="wode_qty[]" id="wode_qty_'+trplusOne+'" data-id='+trplusOne+' ></td><td data-label="Unit" name="wode_unit[]"> <input type="text" value="" class="form-control wode_unit " id="wode_unit_'+trplusOne+'" data-id='+trplusOne+' name="wode_unit[]"></td><td data-label="Rate"> <input type="text" class="form-control float wode_rate calculateamt wode_rate required_field" name="wode_rate[]" id="wode_rate_'+trplusOne+'" data-id='+trplusOne+' ></td><td data-label="totalamt">  <input type="text" class="form-control float wode_totalamt" name="wode_totalamt[]"   id="totalamt_'+trplusOne+'" data-id="'+trplusOne+'" readonly > </td><td data-label="Remarks"> <input type="text" class="form-control wode_remarks jump_to_add " id="wode_remarks_'+trplusOne+'" name="wode_remarks[]" data-id='+trplusOne+'></td><td data-label="Action"> <div class="actionDiv acDiv2" id="acDiv2_'+trplusOne+'"><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div></td></tr>';
        
        $('#itemcode_'+trplusOne).focus();
        $('#orderBody').append(template);
        $('#wode_dtype_'+trplusOne).val(last_dtype);
         

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
            
            setTimeout(function(){
                  $(".orderrow").each(function(i,k) {
                    var vali=i+1;
                    $(this).attr("id","orderrow_"+vali);
                    $(this).attr("data-id",vali);    
                    $(this).find('.sno').attr("id","s_no_"+vali);
                    $(this).find('.sno').attr("value",vali);
                    $(this).find('.wode_description').attr("id","wode_description_"+vali);
                    $(this).find('.wode_description').attr("data-id",vali);
                  
                    $(this).find('.wode_qty').attr("id","wode_qty_"+vali);
                    $(this).find('.wode_qty').attr("data-id",vali);
                   

                    $(this).find('.wode_unit').attr("id","wode_unit_"+vali);
                    $(this).find('.wode_unit').attr("data-id",vali);
                    
                    $(this).find('.wode_rate').attr("id","wode_rate_"+vali);
                    $(this).find('.wode_rate').attr("data-id",vali);
                   
                    $(this).find('.wode_totalamt').attr("id","wode_totalamt_"+vali);
                    $(this).find('.wode_totalamt').attr("data-id",vali);
                 
                    $(this).find('.wode_remarks').attr("id","wode_remarks_"+vali);
                    $(this).find('.wode_remarks').attr("data-id",vali);
                    $(this).find('.acDiv2').attr("id","acDiv2_"+vali);
                    // $(this).find('.acDiv2').attr("data-id",vali);
                    $(this).find('.btnAdd').attr("id","addOrder_"+vali);
                    $(this).find('.btnAdd').attr("data-id",vali);
                    $(this).find('.btnRemove').attr("id","addOrder_"+vali);
                    $(this).find('.btnRemove').attr("data-id",vali);
                    $(this).find('.btnChange').attr("id","btnChange_"+vali);
            });
              },600);
                    setTimeout(function(){
                    var trlength = $('.orderrow').length;
                        // alert(trlength);
                             if(trlength==1)
                             {
                                 $('#acDiv2_1').html('');
                             }
                         },800);

         

          }
     });
    
$(document).off('keyup change','.calculateamt');
$(document).on('keyup change','.calculateamt',function(e){
    var dataid=$(this).data('id');
    var qty=$('#wode_qty_'+dataid).val();
    var rate=$('#wode_rate_'+dataid).val();
    // alert(qty);
    // alert(rate);
    if(qty=='')
        {
            qty=0;
        }
        else
        {
            qty=parseFloat(qty);
        }

    if(rate=='')
        {
            rate=0;
        }
        else
        {
            rate=parseFloat(rate);
        }

    var totalamt=qty*rate;
    // console.log(totalamt);
    $('#totalamt_'+dataid).val(totalamt.toFixed(2));
     var stotal =0.00;
    $(".wode_totalamt").each(function() {
                stotal += parseFloat($(this).val());
            });
    $('#gtotal').val(stotal.toFixed(2));

})


</script>
<?php 
if($reload=='reload'):
?>
<script type="text/javascript">
    $('.select2').select2();
    $('.nepdatepicker').nepaliDatePicker({
          npdMonth: true,
          npdYear: true,
    });
</script>
<?php
endif;
?>




