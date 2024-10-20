 <style>
    .purs_table tbody tr td{
        border: none;
        vertical-align: center;
    }
</style>
<?php
    $id = !empty($sales_desposal_data_rec[0]->woma_womasterid)?$sales_desposal_data_rec[0]->woma_womasterid:'';
?>
<form method="post" id="FormsalesDesposal" action="<?php echo base_url('ams/assets_sales_desposal/save_sales_desposal'); ?>" class="form-material form-horizontal form" data-reloadurl="<?php echo base_url('ams/assets_sales_desposal/entry/reload'); ?>">
    <input type="hidden" name="id" value="<?php echo !empty($sales_desposal_data_rec[0]->asde_assetdesposalmasterid)?$sales_desposal_data_rec[0]->asde_assetdesposalmasterid:'';  ?>">
        <div class="form-group">
            <div class="col-md-3 col-sm-4">
        <?php $asde_fiscalyrs = !empty($sales_desposal_data_rec[0]->asde_fiscalyrs)?$sales_desposal_data_rec[0]->asde_fiscalyrs:CUR_FISCALYEAR; ?>
        <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?><span class="required">*</span> :</label>
       <select name="asde_fiscalyrs" class="form-control required_field" id="fyear">
           <?php
             if(!empty($fiscal_year)): 
             foreach ($fiscal_year as $kf => $fyrs):
             ?>
            <option value="<?php echo $fyrs->fiye_name; ?>" <?php if($fyrs->fiye_status=='I') echo "selected=selected"; ?> ><?php echo $fyrs->fiye_name; ?></option>
         <?php endforeach; endif; ?>
       </select>
    </div>

            <div class="col-md-3">
                <?php $disposalno=!empty($sales_desposal_data_rec[0]->asde_disposalno)?$sales_desposal_data_rec[0]->asde_disposalno:$disposal_code; ?>
                <label for="example-text">Disposal No. <span class="required">*</span>:</label>
                <input type="text" class="form-control required_field" name="asde_disposalno" id="asde_disposalno" value="<?php echo $disposalno; ?>" readonly />
            </div>
           
            

            <div class="col-md-3">
                <?php $asde_manualno=!empty($sales_desposal_data_rec[0]->asde_manualno)?$sales_desposal_data_rec[0]->asde_manualno:0; ?>
                <label for="example-text"><?php echo $this->lang->line('manual_no'); ?>  :</label>
                <input type="text" class="form-control" name="asde_manualno" value="<?php echo $asde_manualno; ?>" placeholder="Enter Manual Number">
            </div>

            
            <div class="col-md-3">
                 <?php
                    if(DEFAULT_DATEPICKER == 'NP'){
                        $disposal_date = !empty($sales_desposal_data_rec[0]->asde_desposaldatebs)?$sales_desposal_data_rec[0]->asde_desposaldatebs:DISPLAY_DATE;
                    }else{
                        $disposal_date = !empty($sales_desposal_data_rec[0]->asde_desposaldatead)?$sales_desposal_data_rec[0]->asde_desposaldatead:DISPLAY_DATE;
                    }
                ?>
               
                <label for="example-text">Disposal Date :</label>
                <input type="text" class="form-control" name="asde_desposaldate" value="<?php echo $disposal_date; ?>" placeholder="YYYY/MM/DD">
            </div>
            <div class="col-md-3 col-sm-4">
                 <label for="example-text">Disposal Type <span class="required">*</span>:</label>
                 <?php $detyid=!empty($sales_desposal_data_rec[0]->asde_desposaltypeid)?$sales_desposal_data_rec[0]->asde_desposaltypeid:''; ?>
                  <select name="asde_desposaltypeid" class="form-control required_field" id="disposaltypeid">
                      <option value="0">---Select---</option>
           <?php
             if(!empty($desposaltype)): 
             foreach ($desposaltype as $kdt => $dtype):
             ?>
           
            <option value="<?php echo $dtype->dety_detyid; ?>" <?php if($dtype->dety_detyid==$detyid) echo "selected=selected"; ?> data-issales="<?php echo $dtype->dety_issale; ?>" ><?php echo $dtype->dety_name; ?></option>
         <?php endforeach; endif; ?>
       </select>
            </div>
    <div class="col-md-3 col-sm-4">
            <?php $cust_name=!empty($sales_desposal_data_rec[0]->asde_customer_name)?$sales_desposal_data_rec[0]->asde_customer_name:''; ?>
            <label for="example-text">Customer Name :</label>
            <input type="text" name="asde_customer_name" class="form-control" value="<?php echo $cust_name; ?>">
    </div>
    <div class="col-md-3 col-sm-4">
            <?php $sale_tax= !empty($sales_desposal_data_rec[0]->asde_sale_taxper)?$sales_desposal_data_rec[0]->asde_sale_taxper:''; ?>
            <label for="example-text">Sales Tax (%) :</label>
            <input type="text" name="asde_sale_taxper" class="form-control float" value="<?php echo $sale_tax; ?>">
    </div>
            
</div>
 <div class="clearfix"></div>
<div class="form-group">
            <div class="table-responsive col-sm-12">
                <table style="width:100%;" class="table dataTable dt_alt purs_table res_vert_table">
                    <thead>
                        <tr>
                            <th scope="col" width="5%"> <?php echo $this->lang->line('sn'); ?>. </th>
                            <th scope="col" width="20%">Assets Code </th>
                            <th scope="col" width="25%">Description</th>
                            <th scope="col" width="5%">Original Cost.  </th>
                            <th scope="col" width="10%">Current Cost. </th>
                            <th scope="col" width="10%">Last Dep. Date. </th>
                            <th scope="col" width="10%">Sales Cost. </th>
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
                                    <input type="text" class="form-control assetscode enterinput" id="assetscode_1" name="assets_code[]"  data-id='1' data-targetbtn='view' value="">
                                    <input type="hidden" class="assetsid" name="asdd_assetid[]" data-id='1' value="" id="assetsid_1">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading='<?php echo $this->lang->line('list_of_items'); ?>' data-viewurl='<?php echo base_url('/ams/assets/list_of_assets_popup'); ?>' data-id='1' id="view_1"><strong>...</strong></a>&nbsp;
                                </div> 
                            </td>
                            <td data-label="Description">  
                                <input type="text" class="form-control assets_desc"  id="assets_desc_1" name="assets_desc[]"  data-id='1' readonly> 
                            </td>
                            
                            <td data-label="Orginal. Value"> 
                                <input type="text" class="form-control float calculateamt assets_orginalval" name="assets_orginalval[]"   id="assets_orginalval_1" data-id='1' > 
                            </td>
                             <td data-label="Current Val"> 
                                <input type="text" class="form-control float calculateamt assets_currentval" name="assets_currentval[]"   id="assets_currentval_1" data-id='1' > 
                            </td>
                            <td data-label="last Dep. Date"> 
                                <input type="text" class="form-control last_dep_date" name="last_dep_date[]"   id="last_dep_date_1" data-id='1' > 
                            </td>
                            <td data-label="Sales Value"> 
                                <input type="text" class="form-control float calculateamt assets_salesval required_field" name="assets_salesval[]"   id="assets_salesval_1" data-id='1' value="0.00" > 
                            </td>
                            <td data-label="Remarks"> 
                                <input type="text" class="form-control  remarks jump_to_add " id="remarks_1" name="remarks[]"  data-id='1'> 
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
                            <td colspan="2">&nbsp;</td>
                            <td><strong>G.Total</strong></td>
                            <td><input type="text" class="form-control" name="torginalcost" id="torginalcost" readonly="true"></td>
                            <td><input type="text" class="form-control" name="tcurrentcost" id="tcurrentcost"  readonly="true"></td>
                            <td></td>
                           <td><input type="text" class="form-control" name="tsalescost" id="tsalescost"  readonly="true"></td>
                            <td></td>
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
               <textarea name="full_remarks" class="form-group"></textarea>
            </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($sales_desposal_data_rec)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($sales_desposal_data_rec)?'Update':$this->lang->line('save');  ?></button>
              
            </div>
            <div class="col-sm-12">
                <div  class="alert-success success"></div>
                <div class="alert-danger error"></div>
            </div>
        </div>
    </form>

<script type="text/javascript">

$(document).off('change keyup','.assets_orginalval');
$(document).on('change keyup','.assets_orginalval',function(e){
 var assetsorg_total=0;
    $(".assets_orginalval").each(function() {
            assetsorg_total += parseFloat($(this).val());
        });
    assetsorg_total=parseFloat(assetsorg_total);
    $('#torginalcost').val(assetsorg_total);
});

$(document).off('change keyup','.assets_currentval');
$(document).on('change keyup','.assets_currentval',function(e){
 var assetcurrent_total=0;
    $(".assets_currentval").each(function() {
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
        var id=$(this).data('id');
        
        var trpluOne = $('.orderrow').length;
        var trplusOne = $('.orderrow').length+1;
       
         var assetsid=$('#assetsid_'+trpluOne).val();
         var salesval=$('#assets_salesval_'+trpluOne).val();
         // alert(assetsid);
         // return false;
         if(assetsid==''){
            $('#assetscode_'+trpluOne).focus();
            return false;
        }
        if(salesval==''){
            $('#assets_salesval_'+trpluOne).focus();
            return false;
        }
      
        if(trplusOne==2)
        {
            $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');
        }
        var template='';
        
        template='<tr class="orderrow" id="orderrow_'+trplusOne+'" data-id='+trplusOne+'><td data-label="S.No."> <input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'"  readonly/></td><td data-label="Code"><div class="dis_tab"> <input type="text" class="form-control assetscode enterinput" id="assetscode_'+trplusOne+'"  name="assets_code[]" data-id="'+trplusOne+'" data-targetbtn="view" value=""> <input type="hidden" class="assetsid" name="asdd_assetid[]" data-id="'+trplusOne+'" value="" id="assetsid_'+trplusOne+'" > <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading="Assets List" data-viewurl="<?php echo base_url("/ams/assets/list_of_assets_popup"); ?>" data-id="'+trplusOne+'" id="view_"'+trplusOne+'" ><strong>...</strong></a>&nbsp;</div></td><td data-label="Description"> <input type="text" class="form-control assets_desc" id="assets_desc_'+trplusOne+'"  name="assets_desc[]" data-id='+trplusOne+'" readonly></td><td data-label="Orginal. Value"> <input type="text" class="form-control float calculateamt assets_orginalval" name="assets_orginalval[]" id="assets_orginalval_'+trplusOne+'" data-id="'+trplusOne+'" ></td><td data-label="Current Val"> <input type="text" class="form-control float calculateamt assets_currentval" name="assets_currentval[]" id="assets_currentval_'+trplusOne+'"  data-id="'+trplusOne+'" ></td><td data-label="last Dep. Date"> <input type="text" class="form-control last_dep_date" name="last_dep_date[]" id="last_dep_date_'+trplusOne+'"  data-id="'+trplusOne+'" ></td><td data-label="Sales Value"> <input type="text" class="required_field form-control float calculateamt assets_salesval" name="assets_salesval[]" id="assets_salesval_'+trplusOne+'" data-id="'+trplusOne+'" value="0.00"  ></td><td data-label="Remarks"> <input type="text" class="form-control remarks jump_to_add " id="remarks_'+trplusOne+'"  name="remarks[]" data-id="'+trplusOne+'"></td><td data-label="Action"> <div class="actionDiv acDiv2" id="acDiv2_'+trplusOne+'"><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div></td></tr>';

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
             // console.log(trplusOne);
             // $('#orderrow_'+id).fadeOut(500, function(){ 
             // $('#orderrow_'+id).remove();
             //  });

             whichtr.remove(); 
            //  for (var i = 0; i < trplusOne; i++) {
            //   $('#s_no_'+i).val(i);
            // }
            setTimeout(function(){
                  $(".orderrow").each(function(i,k) {
                    var vali=i+1;
                    $(this).attr("id","orderrow_"+vali);
                    $(this).attr("data-id",vali);    
                    $(this).find('.sno').attr("id","s_no_"+vali);
                    $(this).find('.sno').attr("value",vali);
                    $(this).find('.assetscode').attr("id","assetscode_"+vali);
                    $(this).find('.assetscode').attr("data-id",vali);
                    $(this).find('.assetsid').attr("id","assetsid_"+vali);
                    $(this).find('.assetsid').attr("data-id",vali);
                    $(this).find('.assets_desc').attr("id","assets_desc_"+vali);
                    $(this).find('.assets_desc').attr("data-id",vali);
                    $(this).find('.view').attr("id","view_"+vali);
                    $(this).find('.view').attr("data-id",vali);
                    $(this).find('.assets_orginalval').attr("id","assets_orginalval_"+vali);
                    $(this).find('.assets_orginalval').attr("data-id",vali);
                    $(this).find('.assets_currentval').attr("id","assets_currentval_"+vali);
                    $(this).find('.assets_currentval').attr("data-id",vali);
                    $(this).find('.last_dep_date').attr("id","last_dep_date_"+vali);
                    $(this).find('.last_dep_date').attr("data-id",vali);
                    $(this).find('.assets_salesval').attr("id","assets_salesval_"+vali);
                    $(this).find('.assets_salesval').attr("data-id",vali);
                    $(this).find('.remarks').attr("id","remarks_"+vali);
                    $(this).find('.remarks').attr("data-id",vali);
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
                     $('.assets_orginalval').change();
                    $('.assets_currentval').change();
                    $('.assets_salesval').change();

         

          }
     });
    
    $(document).off('click','.itemDetail');
    $(document).on('click','.itemDetail',function(){
        var rowno=$(this).data('rowno');
        var rate=$(this).data('rate');
        var asen_assetcode=$(this).data('asen_assetcode');
        var asen_desc=$(this).data('asen_desc');
        var asen_asenid=$(this).data('asen_asenid');
        var purrate=$(this).data('purrate');
        var last_depdate=$(this).data('last_depdate');
        var last_depnetval=$(this).data('last_depnetval');

        $('#assetsid_'+rowno).val(asen_asenid);
        $('#assetscode_'+rowno).val(asen_assetcode);
        $('#assets_desc_'+rowno).val(asen_desc);
        $('#assets_orginalval_'+rowno).val(purrate);
        $('#assets_currentval_'+rowno).val(last_depnetval);
        $('#last_dep_date_'+rowno).val(last_depdate);
        $('#myView').modal('hide');

        $('#assets_salesval_'+rowno).focus().select();
        $('.assets_orginalval').change();
        $('.assets_currentval').change();
        $('.assets_salesval').change();
        return false;
    })
</script>








