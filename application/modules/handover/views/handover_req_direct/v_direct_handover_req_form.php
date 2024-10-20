 <style>
    .purs_table tbody tr td{
        border: none;
        vertical-align: center;
    }
</style>
<?php
$id = !empty($handover_data[0]->harm_handovermasterid)?$handover_data[0]->harm_handovermasterid:'';
?>
<form method="post" id="FormHandoverRequisition" action="<?php echo base_url('handover/handover_req_direct/save_handover_direct'); ?>" class="form-material form-horizontal form" data-reloadurl="<?php echo base_url('handover/handover_req_direct/form_handover_requisition'); ?>">
    <input type="hidden" name="id" value="<?php echo !empty($handover_data[0]->harm_handovermasterid)?$handover_data[0]->harm_handovermasterid:'';  ?>">

    <div class="form-group">
        <div class="col-md-3 col-sm-4">
            <?php 
            $handoverno=!empty($handover_data[0]->harm_handoverreqno)?$handover_data[0]->harm_handoverreqno:''; ?>
            <label for="example-text"><?php echo $this->lang->line('handover_req_no'); ?><span class="required">*</span>:</label>
            <input type="text" class="form-control" name="harm_handoverreqno"  value="<?php echo !empty($handoverno)?$handoverno:$handover_number; ?>" placeholder="Enter Requisition Number" readonly>
        </div>
        <input type="hidden" name="harm_tolocationid" value="1">
        <?php 
       
        echo $this->general->location_option(3,'harm_fromlocationid','harm_fromlocationid',false,'From',false); ?>
         
        <div class="col-md-3 col-sm-4">
            <?php $depid=!empty($handover_data[0]->fromdepname)?$handover_data[0]->fromdepname:''; ?>
            <label for="example-text"><?php echo $this->lang->line('from_department'); ?> <span class="required">*</span>:</label>
            <div class="dis_tab">
                <select name="harm_fromdepid" id="harm_fromdepid" class="form-control required_field select2" >
                    <option value="">---select---</option>
                    <?php
                    if($department):
                        foreach ($department as $km => $dep):
                            ?>
                            <option value="<?php echo $dep->dept_depid; ?>"  <?php if($depid==$dep->dept_depname) echo "selected=selected"; ?>><?php echo $dep->dept_depname; ?></option>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </select>
                
                <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 refresh_element" data-targetid="harm_fromdepid" data-viewurl="<?php echo base_url('settings/department/department_reload'); ?>"><i class="fa fa-refresh"></i></a>

                <a href="javascript:void(0)" id="hide" name="hide" class="table-cell frm_add_btn width_30 view" data-heading='Department Entry' data-viewurl='<?php echo base_url('settings/department/department_entry/modal'); ?>'><i class="fa fa-plus"></i></a>
            </div>
        </div>
            <div class="col-md-3 col-sm-4">
            <?php $harm_fyear = !empty($handover_data[0]->harm_fyear)?$handover_data[0]->harm_fyear:CUR_FISCALYEAR; ?>
            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?><span class="required">*</span> :</label>
            <!--  <input type="text" class="form-control" name="harm_fyear" id="fiscal_year" value="<?php echo $harm_fyear; ?>" placeholder="Fiscal Year" > -->
            <select name="harm_fyear" class="form-control required_field" id="fyear">
             <?php
             if($fiscal_year): 
               foreach ($fiscal_year as $kf => $fyrs):
                   ?>
                   <option value="<?php echo $fyrs->fiye_name; ?>" <?php if($fyrs->fiye_status=='I') echo "selected=selected"; ?> ><?php echo $fyrs->fiye_name; ?></option>
               <?php endforeach; endif; ?>
           </select>
       </div>
         <?php //echo $this->general->location_option(3,'harm_tolocationid','harm_tolocationid',false,'To'); ?>
        <div class="clearfix"></div>

        <div class="col-md-3">
            <?php $harm_manualno=!empty($handover_data[0]->harm_manualno)?$handover_data[0]->harm_manualno:0; ?>
            <label for="example-text"><?php echo $this->lang->line('manual_no'); ?>  :</label>
            <input type="text" class="form-control" name="harm_manualno" value="<?php echo $harm_manualno; ?>" placeholder="Enter Manual Number">
        </div>
       

        <div class="col-md-3">
            <?php
            if(DEFAULT_DATEPICKER == 'NP'){
                $req_date = !empty($handover_data[0]->harm_handoverdatebs)?$handover_data[0]->harm_handoverdatebs:DISPLAY_DATE;
            }else{
                $req_date = !empty($handover_data[0]->harm_handoverdatead)?$handover_data[0]->harm_handoverdatead:DISPLAY_DATE;
            }
            ?>
            <label for="example-text"><?php echo $this->lang->line('handover_req_date'); ?>: </label>
            <input type="text" name="harm_reqdate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Requisition Date" value="<?php echo $req_date; ?>" id="requisitionDate">
            <span class="errmsg"></span>
        </div>
        
        <div class="col-md-3">
            <?php $remareqby = !empty($handover_data[0]->harm_requestedby)?$handover_data[0]->harm_requestedby:$this->session->userdata(USER_NAME); ?>
            <label for="example-text"><?php echo $this->lang->line('requested_by'); ?><span class="required">*</span> :</label>
            <!--           <input type="text" class="form-control required_field" name="harm_requestedby" value="<?php echo $remareqby; ?>" placeholder="Requested By" autocomplete="off" autofocus="on"> -->
            <input type="text" id="id" autocomplete="off" name="harm_requestedby" value="<?php echo $remareqby; ?>" class="form-control searchText" placeholder="Requested By" data-srchurl="<?php echo base_url(); ?>handover/handover_req/list_of_reqby">
            <div class="DisplayBlock" id="DisplayBlock_id"></div>
        </div>
        
    
        <div class="col-md-3 col-sm-4" style="display:none;">
                <label for="example-text"><?php echo $this->lang->line('choose'); ?>   : </label><br>


             
                <input type="hidden" class="mbtm_13 chooseReqType" name="harm_ishandover" data-reqtype="issue" value="Y"  id="chooseReqtypeIss" >
            </div>

       

       <div class="col-md-3">
        
       </div> 
   </div>
   <div class="clearfix"></div>

   <?php 
   if(!empty($handover_data)):
    ?>
    <?php
endif;
?>

<div class="form-group">
    <div class="table-responsive col-sm-12">
        <table style="width:100%;" class="table dataTable dt_alt purs_table res_vert_table">
            <thead>
                <tr>
                    <th scope="col" width="5%"> <?php echo $this->lang->line('sn'); ?>. </th>
                    <th scope="col" width="10%"> <?php echo $this->lang->line('code'); ?>  </th>
                    <th scope="col" width="15%"> <?php echo $this->lang->line('particular'); ?> </th>
                    <th scope="col" width="5%"> <?php echo $this->lang->line('unit'); ?>  </th>
                    <th scope="col" width="5%"> <?php echo $this->lang->line('req_qty'); ?> </th>
                    <th scope="col" width="5%"> <?php echo $this->lang->line('rate'); ?>  </th>
                    <th scope="col" width="5%"> <?php echo $this->lang->line('amount'); ?>  </th>
                    <th scope="col" width="10%"><?php echo $this->lang->line('remarks'); ?> </th>
                    <th scope="col" width="5%"> <?php echo $this->lang->line('action'); ?></th>
                </tr>
            </thead>
            <tbody id="orderBody">
                <?php
                $j = 1;
                if(!empty($handover_data)):   
                    foreach ($handover_data as $req_key => $req_value):
                        ?>
                        <tr class="orderrow" id="orderrow_<?php echo !empty($req_value->hard_handoverdetailid)?$req_value->hard_handoverdetailid:''; ?>" data-id='<?php echo $j; ?>'>
                            <td data-label="S.No.">
                                <input type="text" class="form-control sno" id="s_no_<?php echo $j;?>" value="<?php echo $j;?>" readonly/>
                                <input type="hidden" name="hard_handoverdetailid[]" class="reqdetailid" id="reqdetailid_<?php echo $j;?>" value="<?php echo !empty($req_value->hard_handoverdetailid)?$req_value->hard_handoverdetailid:''; ?>"/>
                                <input type="hidden" name="hard_qtyinstock[]"  data-id='<?php echo $j; ?>' class="qtyinstock" id="qtyinstock_<?php echo $j; ?>" value=""/>
                            </td>
                            <td data-label="Code">
                                <div class="dis_tab"> 
                                    <input type="text" class="form-control itemcode enterinput" id="itemcode_<?php echo $j; ?>" name="hard_code[]"  data-id='<?php echo $j; ?>' data-targetbtn='view' value="<?php echo !empty($req_value->itli_itemcode)?$req_value->itli_itemcode:''; ?>" readonly />
                                    <input type="hidden" class="itemid" name="hard_itemsid[]" data-id='<?php echo $j; ?>' value="<?php echo !empty($req_value->hard_itemsid)?$req_value->hard_itemsid:''; ?>" id='itemid_<?php echo $j; ?>'>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading='<?php echo $this->lang->line('list_of_items'); ?>' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition'); ?>' data-id='<?php echo $j; ?>' id='view_<?php echo $j; ?>'><strong>...</strong></a>&nbsp;
                                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view">+</a>
                                </div> 
                            </td>
                            <td data-label="Particular">  
                                <?php
                                if(ITEM_DISPLAY_TYPE=='NP'){
                                    $req_itemname = !empty($req_value->itli_itemnamenp)?$req_value->itli_itemnamenp:$req_value->itli_itemname;
                                }else{ 
                                    $req_itemname = !empty($req_value->itli_itemname)?$req_value->itli_itemname:'';
                                }?>
                                <input type="text" class="form-control itemname" id="itemname_<?php echo $j; ?>" data-id='<?php echo $j; ?>' value="<?php echo !empty( $req_itemname)? $req_itemname:''; ?>" readonly> 

                                <input type="hidden" class="eachsubtotal" name="eachsubtotal[]" id="eachsubtotal_<?php echo $req_key+1; ?>" >
                            </td>
                            <td data-label="Unit"> 
                                <input type="text" class="form-control float hard_unit calculateamt" id="hard_unit_<?php echo $j;?>" data-id='<?php echo $j;?>' value="<?php echo !empty($req_value->unit_unitname)?$req_value->unit_unitname:''; ?>"> 
                                <input type="hidden" class="unitid" name="hard_unit[]" id="unitid_<?php echo $j;?>" data-id='<?php echo $j;?>' value="<?php echo !empty($req_value->hard_unit)?$req_value->hard_unit:''; ?>"/>
                            </td>
                            <td data-label="Req. Quantity"> 
                                <input type="text" class="form-control float hard_qty calamt hard_qty required_field arrow_keypress" name="hard_qty[]"data-fieldid="hard_qty" id="hard_qty_<?php echo $j;?>" data-id='<?php echo $j;?>' value="<?php echo !empty($req_value->hard_qty)?$req_value->hard_qty:''; ?>"/ > 
                            </td>
                            <td>

                               <input type="text" class="form-control float hard_unitprice calamt arrow_keypress" name="hard_unitprice[]" data-fieldid="hard_unitprice" id="hard_unitprice_<?php echo $j;?>" data-id='<?php echo $j;?>' value="<?php echo !empty($req_value->itli_purchaserate)?$req_value->itli_purchaserate:''; ?>" readonly="true"> 
                               <!-- <input type="hidden" class="unitamtid" name="hard_unitprice[]" id="unitamtid_<?php echo $j;?>" data-id='<?php echo $j;?>' value="<?php echo !empty($req_value->hard_unitprice)?$req_value->hard_unitprice:''; ?>"id='unitamtid_<?php echo $j; ?> ' /> -->

                               
                           </td>
                           <td>
                            <?php $subtotal = ($req_value->hard_qty)*($req_value->itli_purchaserate); ?>
                            <input type="text" name="hard_totalamt[]" class="form-control eachtotalamt" value="<?php echo !empty($subtotal)?$subtotal:'0'; ?>"  id="hard_totalamt_<?php echo $req_key+1; ?>" readonly="true"> 
                        </td>
                        <td data-label="Remarks">
                            <input type="text" class="form-control  hard_remarks jump_to_add" id="hard_remarks_<?php echo $j;?>" name="hard_remarks[]" data-id='<?php echo $j;?>'  value="<?php echo !empty($req_value->hard_remarks)?$req_value->hard_remarks:''; ?>" /> 
                        </td>
                        <td data-label="Action">
                            <div class="actionDiv acDiv2" id="acDiv2_<?php echo $j;?>"></div>

                            <?php
                            if(count($handover_data) > 1):
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
                            <input type="text" class="form-control itemcode enterinput" id="itemcode_1" name="hard_code[]"  data-id='1' data-targetbtn='view' value="">
                            <input type="hidden" class="itemid" name="hard_itemsid[]" data-id='1' value="" id="itemid_1">
                            <input type="hidden" name="hard_qtyinstock[]" data-id='1' class="qtyinstock" id="qtyinstock_1" value=""/>

                            <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading='<?php echo $this->lang->line('list_of_items'); ?>' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition'); ?>' data-id='1' id="view_1"><strong>...</strong></a>&nbsp;
                            <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='<?php echo $this->lang->line('item_entry'); ?>' data-viewurl='<?php echo base_url('stock_inventory/item/item_entry/modal'); ?>' data-id='1' id="view_1">+</a>
                        </div> 
                    </td>
                    <td data-label="Particular">  
                        <input type="text" class="form-control itemname"  id="itemname_1" name=""  data-id='1' readonly> 
                        <input type="hidden" class="eachsubtotal" name="eachsubtotal[]" id="eachsubtotal_1" >
                    </td>
                    <td data-label="Unit"> 
                        <input type="text" value="" class="form-control float hard_unit calculateamt" id="hard_unit_1" data-id='1' readonly="true"> 
                        <input type="hidden" class="unitid" name="hard_unit[]" id="unitid_1" data-id='1'/>
                    </td>
                    <td data-label="Req. Quantity"> 
                        <input type="text" class="form-control float hard_qty calamt hard_qty required_field  arrow_keypress" name="hard_qty[]" data-fieldid="hard_qty"   id="hard_qty_1" data-id='1' > 
                    </td>
                    <td>

                     <input type="text" class="form-control hard_unitprice float calamt arrow_keypress" name="hard_unitprice[]" data-fieldid="hard_unitprice" id="hard_unitprice_1" value="0"  data-id='1' placeholder="Rate">
                     <!--  <input type="hidden" class="form-control unitamtid float" name="hard_unitprice[]" id="unitamtid_1" value="0"  data-id='1' placeholder="Rate"> -->
                 </td>
                 <td>
                    <input type="text" name="hard_totalamt[]" class="form-control eachtotalamt" value="0"  id="hard_totalamt_1" readonly="true"> 
                </td>
                <td data-label="Remarks"> 
                    <input type="text" class="form-control  hard_remarks jump_to_add " id="hard_remarks_1" name="hard_remarks[]"  data-id='1'> 
                </td>
                <td data-label="Action">
                   <div class="actionDiv acDiv2" id="acDiv2_1"></div>
               </td>
           </tr>
       <?php endif; ?> 
       
   </tbody>
   <tbody>
    <tr class="resp_table_breaker">
        <td colspan="8">
         
        </td>
        <td>
           <a href="javascript:void(0)" class="btn btn-primary btnAdd pull-right" data-id="1"  id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>
           <div class="clearfix"></div>
       </td>
   </tr>
</tbody>

</table>
<div class="roi_footer">
    <div class="row">
        <div class="col-sm-4">
          
            <div>
                <label for=""><?php echo $this->lang->line('remarks'); ?> : </label>
                <textarea name="harm_remarks" class="form-control" rows="4" placeholder=""><?php echo !empty($handover_data[0]->harm_remarks)?$handover_data[0]->harm_remarks:'';  ?></textarea>
            </div>
            
            
        </div>
        <div class="col-sm-6 pull-right">
          
                <ul>
                                   <!--   <li>
                                        <label><?php //echo $this->lang->line('sub_total'); ?></label>
                                        <input type="text" class="form-control float" name="subtotalamt" id="subtotalamt" value=""  />
                                    </li> -->

                                    <!-- <li>
                                        <label>Estimated Cost </label>
                                        <input type="text" class="form-control float" name="totalamount" id="totalamount" value="<?php  echo !empty($handover_data[0]->harm_estimatecost)?$handover_data[0]->harm_estimatecost:'';   ?>" readonly="true" />
                                    </li>
 -->
                                    
                              <!--   <li>
                                    <label><?php //echo $this->lang->line('clearance_amt'); ?></label>
                                    <input type="text" class="form-control extra" name="clearanceamt" id="clearanceamt">
                                </li> -->
                            </ul>
                       
                    </div>
                </div> 
            </div> 
            <div id="Printable" class="print_report_section printTable">
                
            </div>
        </div> <!-- end table responsive -->
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($handover_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($handover_data)?'Update':$this->lang->line('save');  ?></button>
            <button type="submit" class="btn btn-info savePrint" data-operation='<?php echo !empty($handover_data)?'update':'save ' ?>' id="btnSubmit" data-print="print"><?php echo !empty($handover_data)?'Update & Print':$this->lang->line('save_and_print') ?></button>
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
    var itemid=$('#itemid_'+id).val();
    var qty=$('#qtyinstock_'+id).val();
    var rate=$('#hard_qty_'+id).val();
    var rates = $('#hard_unitprice_'+id).val();
    var trplusOne = $('.orderrow').length+1;
    var trpluOne = $('.orderrow').length;
    var itemid=$('#itemid_'+id).val(); 
    var code=$('#itemname_'+trplusOne).val(); 
        // alert(itemid);
        var newitemid=$('#itemid_'+trpluOne).val();
        var reqqty=$('#hard_qty_'+trpluOne).val();
        

        if(newitemid=='')
        {
            $('#itemcode_'+trpluOne).focus();
            return false;
        }
        if(reqqty==0 || reqqty=='' || reqqty==null )
        {
            $('#hard_qty_'+trpluOne).focus();
            return false;
        }
        if(rates=='' || rates==null )
        {
            $('#hard_unitprice_'+id).focus();
            return false;
        }


        var storeid= $("#harm_reqtodepid option:selected").val();
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
        template='<tr class="orderrow" id="orderrow_'+trplusOne+'" data-id="'+trplusOne+'"><td data-label="S.No."><input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/></td><td data-label="Code"> <div class="dis_tab"> <input type="text" class="form-control itemcode enterinput " id="itemcode_'+trplusOne+'" name="hard_code[]" data-id="'+trplusOne+'" data-targetbtn="view" readonly /> <input type="hidden" class="itemid" name="hard_itemsid[]" data-id="'+trplusOne+'" id="itemid_'+trplusOne+'" > <input type="hidden" name="hard_qtyinstock[]" data-id="'+trplusOne+'" class="qtyinstock" id="qtyinstock_'+trplusOne+'" /> <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading="List of Item" data-viewurl="<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition '); ?>" data-id="'+trplusOne+'" id="view_'+trplusOne+'" ><strong>...</strong></a>&nbsp<a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading="Item Entry" data-viewurl="<?php echo base_url('stock_inventory/item/item_entry/modal'); ?>" data-storeid='+storeid+' data-id="'+trplusOne+'" id="view_'+trplusOne+'">+</a></div></td><td data-label="Particular"><input type="hidden" class="eachsubtotal" name="eachsubtotal[]" id="eachsubtotal_'+trplusOne+'" > <input type="text" class="form-control itemname" id="itemname_'+trplusOne+'" name="" data-id="'+trplusOne+'" readonly></td><td data-label="Unit"><input type="text" class="form-control float hard_unit calculateamt" name="" id="hard_unit_'+trplusOne+'" data-id="'+trplusOne+'" > <input type="hidden" class="unitid" name="hard_unit[]" id="unitid_'+trplusOne+'" data-id="'+trplusOne+'"/></td><td data-label="Req. Quantity"><input type="text" class="form-control float hard_qty calamt arrow_keypress required_field" data-fieldid="hard_qty" name="hard_qty[]" id="hard_qty_'+trplusOne+'" data-id='+trplusOne+' value="0" ></td><td> <input type="text" class="form-control float hard_unitprice calamt arrow_keypress" name="hard_unitprice[]" data-fieldid="hard_unitprice"  id="hard_unitprice_'+trplusOne+'" value="" data-id="'+trplusOne+'" placeholder=""readonly="true"></td> </td> <td><input type="text" name="hard_totalamt[]" class="form-control eachtotalamt" value="0" readonly="true" id="hard_totalamt_'+trplusOne+'"> </td><td data-label="Remarks"> <input type="text" class="form-control  hard_remarks jump_to_add " id="hard_remarks_'+trplusOne+'" name="hard_remarks[]"  data-id="'+trplusOne+'"> </td><td data-label="Action"> <div class="actionDiv acDiv2" id="acDiv2_'+trplusOne+'"><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div></td></tr>';
         // $('#addOrder_'+id).removeClass('btn btn-primary btnAdd').addClass('btn btn-danger btnRemove');
         // $('#btnChange_'+id).html('<i class="fa fa-trash-o" aria-hidden="true"></i>');
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
                $(this).find('.hard_unit').attr("id","hard_unit_"+vali);
                $(this).find('.hard_unit').attr("data-id",vali);
                $(this).find('.unitid').attr("id","unitid_"+vali);
                $(this).find('.unitid').attr("data-id",vali);

                $(this).find('.unitamtid').attr("id","unitamtid_"+vali);
                $(this).find('.unitamtid').attr("data-id",vali);

                $(this).find('.hard_qty').attr("id","hard_qty_"+vali);
                $(this).find('.hard_qty').attr("data-id",vali);
                $(this).find('.hard_remarks').attr("id","hard_remarks_"+vali);
                $(this).find('.hard_remarks').attr("data-id",vali);
                $(this).find('.acDiv2').attr("id","acDiv2_"+vali);

                $(this).find('.eachsubtotal').attr("id","eachsubtotal_"+vali);
                $(this).find('.eachsubtotal').attr("data-id",vali);

                $(this).find('.eachtotalamt').attr("id","hard_totalamt_"+vali);
                $(this).find('.eachtotalamt').attr("data-id",vali);

                $(this).find('.totalamount').attr("id","totalamount_"+vali);
                $(this).find('.totalamount').attr("data-id",vali);

                $(this).find('.hard_unitprice').attr("id","hard_unitprice_"+vali);
                $(this).find('.hard_unitprice').attr("data-id",vali);
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
    var unitid=$(this).data('unitid');
    var unitamtid=$(this).data('unitamtid');
    var hard_unitprice=$(this).data('purrate');
    $('#itemcode_'+rowno).val(itemcode);
       // $('#itemcode_'+rowno).val(itemcode);
       $('#itemid_'+rowno).val(itemid);
       $('#itemname_'+rowno).val(itemname);
       $('#itemstock_'+rowno).val(stockqty);
       $('#hard_unit_'+rowno).val(unitname);
       $('#qtyinstock_'+rowno).val(stockqty);
       $('#unitid_'+rowno).val(unitid);
       $('#unitamtid_'+rowno).val(unitamtid);
       $('#hard_unitprice_'+rowno).val(hard_unitprice);
       $('#myView').modal('hide');
       $('#hard_qty_'+rowno).focus().select();
       $('.calamt').change();
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
                    $('#harm_reqfromdepid').empty().html(data.from_depid).select2().trigger('change');
                    $('#hide').hide();

                }else{
                    $('#harm_reqfromdepid').empty().html(data.from_depid).trigger('change');
                    $('#hide').show();
                }
                
                $('#harm_reqtodepid').empty().html(data.to_depid).trigger('change');
            };
        });

    $(document).off('change','.getReqNo');
    $(document).on('change','.getReqNo',function(){
        var reqType = $('input[name=harm_isdep]:checked').data('reqtype');
        // alert(reqType);

        var todepid = $(this).val();
         alert(todepid);
        var submitdata = {depid:todepid, type:reqType};
        var submiturl = base_url+'issue_consumption/stock_requisition/get_req_no';

        ajaxPostSubmit(submiturl,submitdata,beforeSend,onSuccess);

        function beforeSend(){
                // $('.overlay').modal('show');
            };

            function onSuccess(jsons){
                data = jQuery.parseJSON(jsons);

                setTimeout(function(){
                    $('#harm_reqno').empty().val(data.reqno);
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
if(empty($handover_data)):
    ?>
    <script type="text/javascript">
        
        $(document).ready(function(){
            var deptypeid='<?php echo !empty($harm_isdep)?$harm_isdep:''; ?>';
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
    
    $(document).off('change','#harm_reqtodepid');
    $(document).on('change','#harm_reqtodepid',function()
    {
        
    // alert(storeid);
    var storeid='';
    var reqType = $("input[name='harm_isdep']:checked"). val();

    // alert(reqType);
    if(reqType=='Y')
    {
       var depname=$("#harm_reqtodepid option:selected").text();
       storeid= $("#harm_reqtodepid option:selected").val();
   }
   else
   {
    var depname=$("#harm_reqfromdepid option:selected").text();
    storeid=$("#harm_reqfromdepid option:selected").val();
}



    // 
    
    $('.btnitem').attr('data-storeid',storeid);
    $('.btnitem').data('storeid',storeid);


})

</script>

<script>
    $(document).ready(function(){
        var storeid= $("#harm_reqtodepid option:selected").val();
        // alert(storeid);
        $('.btnitem').attr('data-storeid',storeid);
        $('.btnitem').data('storeid',storeid);
    });
</script>


<script>
    
    $(document).off('keyup change','.calamt');
    $(document).on('keyup change','.calamt',function(){
        var id=$(this).data('id');
        var qty=$('#hard_qty_'+id).val();
        if(qty ==null || qty==' ')
        {
            qty=0;
        }
        var rate=$('#hard_unitprice_'+id).val();
        if(rate ==null || rate==' ')
        {
            rate=0;
        }

        
        var hard_totalamt=0;
        var hard_qty=parseFloat(qty)*parseFloat(rate);
        $('#hard_totalamt_'+id).val(hard_qty);
        // if(rate>0)
        // {
        //     $('#free_'+id).val(0);
        // }
//console.log(hard_qty);




        // $('#totalamt_1').val(500);
        
        var stotal=0;
        
        var eachsubtotal=0;
        
        $(".eachtotalamt").each(function() {
            stotal += parseFloat($(this).val());
        });


        eachsubtotal=parseFloat(eachsubtotal);
        
          // stotal=parseFloat(stotal)+parseFloat(eachcctotal);
          


          $('#subtotalamt').val(eachsubtotal.toFixed(2));
          $('#totalamount').val(stotal.toFixed(2));
          $('.extra').change();

      })
  </script>


