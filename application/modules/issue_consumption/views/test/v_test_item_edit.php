<div class="assest-form">
   <form id="FormTestitem" class="form-material" method="post" id="btnDeptment" action="<?php echo base_url('issue_consumption/test/save_item_map'); ?>" data-reloadurl='<?php echo base_url('issue_consumption/test/test_itemlist'); ?>' data-isredirect='Y'>
    <!-- item test Start -->
    <input type="hidden" name="tena_id" value="<?php echo !empty($test_itemdata[0]->tena_id)?$test_itemdata[0]->tena_id:''; ?>" />
    <input type="hidden" name="tena_mid" value="<?php echo !empty($test_itemdata[0]->tena_mid)?$test_itemdata[0]->tena_mid:''; ?>" />
      <input type="hidden" name="tena_apidepid"  value="<?php echo !empty($test_itemdata[0]->tena_apidepid)?$test_itemdata[0]->tena_apidepid:''; ?>"/>
      <input type="hidden" name="tena_apidepname"  value="<?php echo !empty($test_itemdata[0]->apde_departmentname)?$test_itemdata[0]->apde_departmentname:''; ?>"/>
      <input type="hidden" name="tena_invdepid"  value="<?php echo !empty($test_itemdata[0]->apde_invdepid)?$test_itemdata[0]->apde_invdepid:''; ?>"/>
    <div class="white-box pad-5 assets-title" style="border-color:silver">
      <h4>Test Item Details</h4>


      <div class="row">
        <div class="col-md-4">
         <div class="form-group">
            <label><?php echo $this->lang->line('test_item_id'); ?>: </label>
            <?php echo !empty($test_itemdata[0]->tena_mid)?$test_itemdata[0]->tena_mid:''; ?>
        </div>
    </div>
    <div class="col-md-4">
     <div class="form-group">
        <label><?php echo $this->lang->line('item_code'); ?>: </label>
        <?php echo !empty($test_itemdata[0]->tena_code)?$test_itemdata[0]->tena_code:''; ?>
    </div>
</div>
<div class="col-md-4">
 <div class="form-group">
    <label><?php echo $this->lang->line('item_name'); ?>: </label>
    <?php echo !empty($test_itemdata[0]->tena_name)?$test_itemdata[0]->tena_name:''; ?>
</div>
</div>


<div class="col-md-4">
    <div class="form-group">
        <label><?php echo $this->lang->line('status'); ?> :</label>
        <?php 
        $db_asen_status=!empty($test_itemdata[0]->tena_isactive)?$test_itemdata[0]->tena_isactive:'';
        if($db_asen_status=='1'){
            $status="Active";
        } else {
            $status="InActive";
        }
        echo $status;
        ?>
    </div>
</div>
<div class="col-md-4">
    <label for="example-text">Post Date(AD)</label>:
    <?php echo !empty($test_itemdata[0]->tena_postdatead)?$test_itemdata[0]->tena_postdatead:'' ?>
</div>
<div class="col-md-4">
    <label for="example-text">Post Date(BS)</label>:
    <?php echo !empty($test_itemdata[0]->tena_postdatebs)?$test_itemdata[0]->tena_postdatebs:'' ?>
</div>
</div>
</div>

<div class="form-group">
    <div class="table-responsive col-sm-12">
        <table style="width:100%;" class="table dataTable dt_alt purs_table res_vert_table">
            <thead>
                <tr>
                    <th scope="col" width="5%"> <?php echo $this->lang->line('sn'); ?>. </th>
                    <th scope="col" width="10%"> <?php echo $this->lang->line('code'); ?>  </th>
                    <th scope="col" width="25%"> <?php echo $this->lang->line('particular'); ?> </th>
                    <th scope="col" width="5%"> <?php echo $this->lang->line('unit'); ?>  </th>
                    <th scope="col" width="15%">Amount </th>
                    
                    <th scope="col" width="15%">Min Test Count</th>
                    <th scope="col" width="15%"> Max Test Count </th>
                    <th scope="col" width="5%"> <?php echo $this->lang->line('action'); ?></th>
                </tr>
            </thead>
            <tbody id="orderBody">
                <?php
                $j = 1;
                if(!empty($itemmap_data)):   
                    foreach ($itemmap_data as $item_key => $item_value):
                        ?>
                        <tr class="orderrow" id="orderrow_<?php echo !empty($item_value->tema_testmapid)?$item_value->tema_testmapid:''; ?>" data-id='<?php echo $j; ?>'>
                            <td data-label="S.No.">
                                <input type="text" class="form-control sno" id="s_no_<?php echo $j;?>" value="<?php echo $j;?>" readonly/>
                                <input type="hidden" name="tema_testmapid[]" class="reqdetailid" id="reqdetailid_<?php echo $j;?>" value="<?php echo !empty($item_value->tema_testmapid)?$item_value->tema_testmapid:''; ?>"/>
                                <input type="hidden" name="tema_mid[]" class="reqdetailid" id="reqdetailid_<?php echo $j;?>" value="<?php echo !empty($item_value->tema_mid)?$item_value->tema_mid:''; ?>"/>

                                
                            </td>
                            <td data-label="Code">
                                <div class="dis_tab"> 
                                    <input type="text" class="form-control itemcode enterinput" id="itemcode_<?php echo $j; ?>" name="tema_code[]"  data-id='<?php echo $j; ?>' data-targetbtn='view' value="<?php echo !empty($item_value->itli_itemcode)?$item_value->itli_itemcode:''; ?>" readonly />
                                    <input type="hidden" class="itemid" name="tema_invitemid[]" data-id='<?php echo $j; ?>' value="<?php echo !empty($item_value->tema_invitemid)?$item_value->tema_invitemid:''; ?>" id='itemid_<?php echo $j; ?>'>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading='<?php echo $this->lang->line('list_of_items'); ?>' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition'); ?>' data-id='<?php echo $j; ?>' id='view_<?php echo $j; ?>'><strong>...</strong></a>
                                </div> 
                            </td>
                            <td data-label="Particular">  
                               <?php
                               if(ITEM_DISPLAY_TYPE=='NP'){
                                $item_name = !empty($item_value->itli_itemnamenp)?$item_value->itli_itemnamenp:$item_value->itli_itemname;
                            }else{ 
                                $item_name = !empty($item_value->itli_itemname)?$item_value->itli_itemname:'';
                            }?>
                            <input type="text" class="form-control itemname" id="itemname_<?php echo $j; ?>" data-id='<?php echo $j; ?>' value="<?php echo !empty( $item_name)? $item_name:''; ?>" readonly> 
                        </td>
                         <!-- <td data-label="Unit"> 
                                <input type="text" class="form-control float tema_unit calculateamt" id="tema_unit_<?php echo $j;?>" data-id='<?php echo $j;?>' value="<?php echo !empty($req_value->unit_unitname)?$req_value->unit_unitname:''; ?>"> 
                                <input type="hidden" class="unitid" name="tema_unit[]" id="unitid_<?php echo $j;?>" data-id='<?php echo $j;?>' value="<?php echo !empty($req_value->tema_unit)?$req_value->tema_unit:''; ?>"/>
                            </td> -->
                         <td data-label="Perml"> 
                            <input type="text" class="form-control  tema_unit jump_to_add " id="tema_unit_1" name="tema_unit[]"  value="<?php echo !empty($item_value->tema_unit)?$item_value->tema_unit:''; ?>" data-id='1'> 
                        </td>
                        <td data-label="Perml"> 
                            <input type="text" class="form-control  tema_perml jump_to_add " id="tema_perml_1" name="tema_perml[]"  value="<?php echo !empty($item_value->tema_perml)?$item_value->tema_perml:''; ?>" data-id='1'> 
                        </td>
                       
                        <td data-label="MinTestCount"> 
                            <input type="text" class="form-control  tema_mintestcount jump_to_add " id="tema_mintestcount_1" name="tema_mintestcount[]" value="<?php echo !empty($item_value->tema_mintestcount)?$item_value->tema_mintestcount:''; ?>"  data-id='1'> 
                        </td>
                        <td data-label="MaxTestCount"> 
                            <input type="text" class="form-control  tema_maxtestcount jump_to_add " id="tema_maxtestcount_1" name="tema_maxtestcount[]" value="<?php echo !empty($item_value->tema_maxtestcount)?$item_value->tema_maxtestcount:''; ?>"  data-id='1'> 
                        </td>
                        <td data-label="Action">
                            <div class="actionDiv acDiv2" id="acDiv2_<?php echo $j;?>"></div>

                            <?php
                            if(count($itemmap_data) > 1):
                                ?>
                                <a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="<?php echo $j;?>"  id="addRequistion_<?php echo $j;?>"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>
                                <?php
                            endif;
                            ?>
                            
                        </td>
                    </tr>
                    <?php 
                    $j++;
                endforeach; 
            else:
                ?>
                <tr class="orderrow" id="orderrow_1" data-id='1'>
                    <td data-label="S.No.">
                        <input type="text" class="form-control sno" id="s_no_1" value="1" readonly/>
                        
                    </td>
                    <td data-label="Code">
                        <div class="dis_tab"> 
                            <input type="text" class="form-control itemcode enterinput" id="itemcode_1" name="tema_code[]"  data-id='1' data-targetbtn='view' value="">
                            <input type="hidden" class="itemid" name="tema_invitemid[]" data-id='1' value="" id="itemid_1">
                            <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition'); ?>' data-id='1' id="view_1"><strong>...</strong></a>

                        </div> 
                    </td>
                    <td data-label="Particular">  
                        <input type="text" class="form-control itemname"  id="itemname_1" name=""  data-id='1' readonly> 
                    </td>
                     <!-- <td data-label="Unit"> 
                                <input type="text" value="" class="form-control float tema_unit calculateamt" id="tema_unit_1" data-id='1' readonly="true"> 
                                <input type="hidden" class="unitid" name="tema_unit[]" id="unitid_1" data-id='1'/>
                    </td> -->
                     <td data-label="Perml"> 
                        <input type="text" class="form-control  tema_unit jump_to_add " id="tema_unit_1" name="tema_unit[]"  data-id='1'> 
                    </td>
                    <td data-label="Perml"> 
                        <input type="text" class="form-control  tema_perml jump_to_add " id="tema_perml_1" name="tema_perml[]"  data-id='1'> 
                    </td>
                    
                    <td data-label="MinTestCount"> 
                        <input type="text" class="form-control  tema_mintestcount jump_to_add " id="tema_mintestcount_1" name="tema_mintestcount[]"  data-id='1'> 
                    </td>
                    <td data-label="MaxTestCount"> 
                        <input type="text" class="form-control  tema_maxtestcount jump_to_add " id="tema_maxtestcount_1" name="tema_maxtestcount[]"  data-id='1'> 
                    </td>
                    <td data-label="Action">
                     <div class="actionDiv acDiv2" id="acDiv2_1"></div>
                 </td>
             </tr>
         <?php endif; ?>
         

     </tbody>
     <tbody>
        <tr class="resp_table_breaker">
            <td colspan="9">
                <a href="javascript:void(0)" class="btn btn-primary btnAdd pull-right" data-id="1"  id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                <div class="clearfix"></div>
            </td>
        </tr>
    </tbody>

</table>
<div id="Printable" class="print_report_section printTable">

</div>
</div> <!-- end table responsive -->
</div>
<div class="form-group">
    <div class="col-md-12">
        <button type="submit" class="btn btn-info save"  id="btnDeptment"  >Save</button>

    </div>
    <div class="col-sm-12">
        <div  class="alert-success success"></div>
        <div class="alert-danger error"></div>
    </div>
</div>
</form>

</div>

<script type="text/javascript">
   $(document).off('click','.btnAdd');
   $(document).on('click','.btnAdd',function(){
    var id=$(this).data('id');
    var itemid=$('#itemid_'+id).val();
    var qty=$('#qtyinstock_'+id).val();
        // var rate=$('#rede_qty_'+id).val();
        var rates=$('#unitprice_'+id).val();
        var trplusOne = $('.orderrow').length+1;
        var trpluOne = $('.orderrow').length;
        var itemid=$('#itemid_'+id).val(); 
        var code=$('#itemname_'+trplusOne).val(); 
        // alert(itemid);
        var newitemid=$('#itemid_'+trpluOne).val();
          // var reqqty=$('#rede_qty_'+trpluOne).val();
         // var reqrate=$('#unitprice_'+trpluOne).val();


         if(newitemid=='')
         {
            $('#itemcode_'+trpluOne).focus();
            return false;
        }
        //   if(reqqty==0 || reqqty=='' || reqqty==null )
        // {
        //     $('#rede_qty_'+trpluOne).focus();
        //     return false;
        // }


        var storeid= $("#rema_reqtodepid option:selected").val();
        // alert(storeid);
        setTimeout(function(){
            $('.btnitem').attr('data-storeid',storeid);
            $('.btnitem').data('storeid',storeid);
        },500);     
        


        if(trplusOne==2)
        {
          $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');
      }
      var template='';
      template='<tr class="orderrow" id="orderrow_'+trplusOne+'" data-id="'+trplusOne+'"><td data-label="S.No."><input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/></td><td data-label="Code"> <div class="dis_tab"> <input type="text" class="form-control itemcode enterinput " id="itemcode_'+trplusOne+'" name="tema_code[]" data-id="'+trplusOne+'" data-targetbtn="view" readonly /> <input type="hidden" class="itemid" name="tema_invitemid[]" data-id="'+trplusOne+'" id="itemid_'+trplusOne+'" > <input type="hidden" name="rede_qtyinstock[]" data-id="'+trplusOne+'" class="qtyinstock" id="qtyinstock_'+trplusOne+'" /> <input type="hidden" name="tema_unitprice[]" data-id="'+trplusOne+'" class="unitprice" id="unitprice_'+trplusOne+'" /><a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading="Item List" data-viewurl="<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition'); ?>" data-id="'+trplusOne+'" id="view_'+trplusOne+'"><strong>...</strong></a></div></td><td data-label="Particular"> <input type="text" class="form-control itemname" id="itemname_'+trplusOne+'" name="" data-id="'+trplusOne+'" readonly></td><td data-label="Perml"><input type="text" class="form-control " name="tema_unit[]" id="tema_unit_'+trplusOne+'" data-id='+trplusOne+' ></td><td data-label="Perml"><input type="text" class="form-control float tema_perml calculateamt" name="tema_perml[]" id="tema_perml_'+trplusOne+'" data-id='+trplusOne+' ></td><td data-label="MinTestCount"> <input type="text" class="form-control  tema_mintestcount jump_to_add " id="tema_mintestcount_'+trplusOne+'" name="tema_mintestcount[]"  data-id="'+trplusOne+'"> </td><td data-label="MaxTestCount"> <input type="text" class="form-control  tema_maxtestcount jump_to_add " id="tema_maxtestcount_'+trplusOne+'" name="tema_maxtestcount[]"  data-id="'+trplusOne+'"> </td><td data-label="Action"> <div class="actionDiv acDiv2" id="acDiv2_'+trplusOne+'"><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div></td></tr>';
      
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
                $(this).find('.itemcode').attr("id","itemcode_"+vali);
                $(this).find('.itemcode').attr("data-id",vali);
                $(this).find('.reqdetailid').attr("id","reqdetailid_"+vali);
                $(this).find('.reqdetailid').attr("data-id",vali);
                $(this).find('.qtyinstock').attr("id","qtyinstock_"+vali);
                $(this).find('.qtyinstock').attr("data-id",vali);
                $(this).find('.itemid').attr("id","itemid_"+vali);
                $(this).find('.itemid').attr("data-id",vali);
                $(this).find('.itemname').attr("id","itemname_"+vali);
                $(this).find('.itemname').attr("data-id",vali);
                $(this).find('.view').attr("id","view_"+vali);
                $(this).find('.view').attr("data-id",vali);
                // $(this).find('.unitprice').attr("id","unitprice_"+vali);
                // $(this).find('.unitprice').attr("data-id",vali);
                $(this).find('.tema_unit').attr("id","tema_unit_"+vali);
                $(this).find('.tema_unit').attr("data-id",vali);
                $(this).find('.unitid').attr("id","unitid_"+vali);
                $(this).find('.unitid').attr("data-id",vali);
                // $(this).find('.rede_qty').attr("id","rede_qty_"+vali);
                // $(this).find('.rede_qty').attr("data-id",vali);
                // $(this).find('.rede_remarks').attr("id","rede_remarks_"+vali);
                // $(this).find('.rede_remarks').attr("data-id",vali);
                $(this).find('.tema_perml').attr("id","tema_perml_"+vali);
                $(this).find('.tema_perml').attr("data-id",vali);
                 $(this).find('.tema_unit').attr("id","tema_unit_"+vali);
                $(this).find('.tema_unit').attr("data-id",vali);
                $(this).find('.tema_mintestcount').attr("id","tema_mintestcount_"+vali);
                $(this).find('.tema_mintestcount').attr("data-id",vali);
                $(this).find('.tema_maxtestcount').attr("id","tema_maxtestcount_"+vali);
                $(this).find('.tema_maxtestcount').attr("data-id",vali);


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
   $(document).off('click','.itemDetail');
   $(document).on('click','.itemDetail',function(){
    var rowno=$(this).data('rowno');

    var rate=$(this).data('rate');
    var itemcode=$(this).data('itemcode');
    var itemname=$(this).data('itemname_display');

    var itemid=$(this).data('itemid');
    var stockqty=$(this).data('issueqty');
    var unitname=$(this).data('unitname');
    var purrate=$(this).data('purrate');
    var unitid=$(this).data('unitid');
    $('#itemcode_'+rowno).val(itemcode);
       // $('#itemcode_'+rowno).val(itemcode);
       $('#itemid_'+rowno).val(itemid);
       $('#itemname_'+rowno).val(itemname);
       // $('#itemstock_'+rowno).val(stockqty);
        $('#tema_unit_'+rowno).val(unitname);
       // $('#qtyinstock_'+rowno).val(stockqty);
       // $('#unitprice_'+rowno).val(purrate);
       $('#unitid_'+rowno).val(unitid);
       $('#myView').modal('hide');
       $('#rede_qty_'+rowno).focus();
       return false;
   })
</script>

<script>
    $(document).off('click','.chooseReqType');
    $(document).on('click','.chooseReqType',function(){
        var reqType = $(this).data('reqtype');
        // alert(reqType);
        var submitdata = {type:reqType};
        var submiturl = base_url+'issue_consumption/stock_requisition/get_dept_list';
        
        ajaxPostSubmit(submiturl, submitdata, beforeSend, onSuccess);

        function beforeSend(){
                // $('.overlay').modal('show');
            };

            function onSuccess(jsons){
                data = jQuery.parseJSON(jsons);
                if(data.type=='transfer'){
                    $('#rema_reqfromdepid').empty().html(data.from_depid).select2().trigger('change');
                    $('#hide').hide();

                }else{
                    $('#rema_reqfromdepid').empty().html(data.from_depid).trigger('change');
                    $('#hide').show();
                }

                $('#rema_reqtodepid').empty().html(data.to_depid).trigger('change');
            };
        });

    $(document).off('change','.getReqNo');
    $(document).on('change','.getReqNo',function(){
        var reqType = $('input[name=rema_isdep]:checked').data('reqtype');
        // alert(reqType);

        var todepid = $(this).val();
        // alert(todepid);
        var submitdata = {depid:todepid, type:reqType};
        var submiturl = base_url+'issue_consumption/stock_requisition/get_req_no';

        ajaxPostSubmit(submiturl,submitdata,beforeSend,onSuccess);

        function beforeSend(){
                // $('.overlay').modal('show');
            };

            function onSuccess(jsons){
                data = jQuery.parseJSON(jsons);

                setTimeout(function(){
                    $('#rema_reqno').empty().val(data.reqno);
                },1000);

            }
        });
    </script>

    <script>
        $(document).off('click','#checkApproval');
        $(document).on('click','#checkApproval',function(){
            var check = $('#checkApproval').prop('checked');
            if(check == true){
                var conf = confirm('Do you want to approve this requisition?');
                if(conf){
                    var checkStatus = $('#checkApproval:checked').length;
                // alert(checkStatus);
                if(checkStatus == '1'){
                    $('.approvalForm').show();
                }
            }
        }else{
            $('.approvalForm').hide();
        }
    });

</script>

<?php
if(empty($itemmap_data)):
    ?>
    <script type="text/javascript">

        $(document).ready(function(){
            var deptypeid='<?php echo $rema_isdep ?>';
            if(deptypeid=='N')
            {
                $('#chooseReqtypeTran').click();
            }
            else
            {
                $('#chooseReqtypeIss').click();
            }
    //         setTimeout(function(){

    // },500);  
           // $('.getReqNo').change();
       })
   </script>
   <?php
endif;
?>

<script type="text/javascript">

    $(document).off('change','#rema_reqtodepid');
    $(document).on('change','#rema_reqtodepid',function()
    {

    // alert(storeid);
    var storeid='';
    var reqType = $("input[name='rema_isdep']:checked"). val();

    // alert(reqType);
    if(reqType=='Y')
    {
     var depname=$("#rema_reqtodepid option:selected").text();
     storeid= $("#rema_reqtodepid option:selected").val();
 }
 else
 {
    var depname=$("#rema_reqfromdepid option:selected").text();
    storeid=$("#rema_reqfromdepid option:selected").val();
}



    // 

    $('.btnitem').attr('data-storeid',storeid);
    $('.btnitem').data('storeid',storeid);


})

</script>

<script>
    $(document).ready(function(){
        var storeid= $("#rema_reqtodepid option:selected").val();
        // alert(storeid);
        $('.btnitem').attr('data-storeid',storeid);
        $('.btnitem').data('storeid',storeid);
    });
</script>

