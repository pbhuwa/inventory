<style>
    .purs_table tbody tr td{
        border: none;
        vertical-align: center;
    }
</style>

<?php
$id = !empty($handover_req_data[0]->harm_reqmasterid)?$handover_req_data[0]->harm_reqmasterid:'';

    $this->usergroup = $this->session->userdata(USER_GROUPCODE);
    $this->username = $this->session->userdata(USER_NAME);

    if($this->usergroup == 'DM'):
        $readonly = 'readonly';
    else:
        $readonly = '';
    endif;
?>
<form method="post" id="FormStockRequisition" action="<?php echo base_url('handover/handover_req_direct/save_handover_requisition'); ?>" class="form-material form-horizontal form" data-reloadurl="<?php echo base_url('handover/handover_req_direct/form_handover_requisition'.'/entry'); ?>">

    <input type="hidden" name="id" value="<?php echo !empty($handover_req_data[0]->harm_reqmasterid)?$handover_req_data[0]->harm_reqmasterid:'';  ?>">
        <div class="form-group">
            <div class="col-md-3">
                <?php $harm_handoverreqno=!empty($handover_req_data[0]->harm_handoverreqno)?$handover_req_data[0]->harm_handoverreqno:''; ?>
                <label for="example-text"><?php echo $this->lang->line('handover_req_no'); ?> <span class="required">*</span>:</label>
                <input type="text" class="form-control required_field" name="harm_handoverreqno" id="harm_handoverreqno" value="<?php echo  !empty($harm_handoverreqno)?$harm_handoverreqno:$requisition_no;?>" readonly />
            </div> 
          

            <div class="col-md-3">
                <?php $harm_manualno=!empty($handover_req_data[0]->harm_manualno)?$handover_req_data[0]->harm_manualno:0; ?>
                <label for="example-text"><?php echo $this->lang->line('manual_no'); ?>  :</label>
                <input type="text" class="form-control" name="harm_manualno" value="<?php echo $harm_manualno; ?>" placeholder="Enter Manual Number">
            </div>

            <div class="col-md-3">
                <?php
                    if(DEFAULT_DATEPICKER == 'NP'){
                        $req_date = !empty($handover_req_data[0]->harm_reqdatebs)?$handover_req_data[0]->harm_reqdatebs:DISPLAY_DATE;
                    }else{
                        $req_date = !empty($handover_req_data[0]->harm_reqdatead)?$handover_req_data[0]->harm_reqdatead:DISPLAY_DATE;
                    }
                ?>
                <label for="example-text"><?php echo $this->lang->line('date'); ?>: </label>
                <input type="text" name="harm_reqdate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Handover Requisition Date" value="<?php echo $req_date; ?>" id="requisitionDate">
                <span class="errmsg"></span>
            </div>
            
            <div class="col-md-3">
                <?php $remareqby = !empty($handover_req_data[0]->harm_requestedby)?$handover_req_data[0]->harm_requestedby:$this->username; ?>
                <label for="example-text"><?php echo $this->lang->line('requested_by'); ?><span class="required">*</span> :</label>
                
                <input type="text" id="id" autocomplete="off" name="harm_requestedby" value="<?php echo $remareqby; ?>" class="form-control" placeholder="Requested By" />

            </div>
            <div class="col-md-3">
                <?php 
                    $locid=!empty($handover_req_data[0]->harm_fromlocationid)?$handover_req_data[0]->harm_fromlocationid:''; 
                ?>
                <label for="example-text"><?php echo $this->lang->line('from'); ?> <span class="required">*</span>:</label>
                <div class="dis_tab">
                <select name="harm_fromlocationid" id="harm_fromlocationid" class="form-control required_field select2" >
                    <option value="">---select---</option>
                    <?php
                        if($location):
                            foreach ($location as $km => $loc):
                    ?>
                     <option value="<?php echo $loc->loca_locationid; ?>"  <?php if($locid==$loc->loca_locationid) echo "selected=selected"; ?>><?php echo $loc->loca_name; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
                
       
              </div>
            </div>


             <div class="col-md-3">
                <label for="example-text"><?php echo $this->lang->line('to'); ?> :</label>
                <?php 
                    
                    $to_loc = !empty($handover_req_data[0]->harm_fromlocationid)?$handover_req_data[0]->harm_fromlocationid:'';
                ?>
          

                    <select name="harm_tolocationid" id="harm_tolocationid" class="form-control required_field select2" >
                     <option value="">---select---</option>
                    <?php
                        if($location):
                            foreach ($location as $km => $loc):
                    ?>
                     <option value="<?php echo $loc->loca_locationid; ?>"  <?php if($to_loc==$loc->loca_locationid) echo "selected=selected"; ?>><?php echo $loc->loca_name; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div> 
         
           
        </div>
        <div class="clearfix"></div>

        <?php 
            if(!empty($handover_req_data)):
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
                             <th scope="col" width="5%"> <?php echo $this->lang->line('stock_qty'); ?>  </th>
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
                            if(!empty($handover_req_data)):   
                            foreach ($handover_req_data as $req_key => $req_value):
                        ?>
                        <tr class="orderrow" id="orderrow_<?php echo !empty($req_value->hard_handoverdetailid)?$req_value->hard_handoverdetailid:''; ?>" data-id='<?php echo $j; ?>'>
                            <td data-label="S.No.">
                                <input type="text" class="form-control sno" id="s_no_<?php echo $j;?>" value="<?php echo $j;?>" readonly/>
                                <input type="hidden" name="hard_handoverdetailid[]" class="reqdetailid" id="reqdetailid_<?php echo $j;?>" value="<?php echo !empty($req_value->hard_handoverdetailid)?$req_value->hard_handoverdetailid:''; ?>"/>
                            </td>
                            <td data-label="Code">
                                <div class="dis_tab"> 
                                    <input type="text" class="form-control itemcode enterinput" id="itemcode_<?php echo $j; ?>" name="hard_code[]"  data-id='<?php echo $j; ?>' data-targetbtn='view' value="<?php echo !empty($req_value->itli_itemcode)?$req_value->itli_itemcode:''; ?>" readonly />
                                    <input type="hidden" class="itemid" name="hard_itemsid[]" data-id='<?php echo $j; ?>' value="<?php echo !empty($req_value->hard_itemsid)?$req_value->hard_itemsid:''; ?>" id='itemid_<?php echo $j; ?>'>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading='<?php echo $this->lang->line('list_of_items'); ?>' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition'); ?>' data-id='<?php echo $j; ?>' id='view_<?php echo $j; ?>'><strong>...</strong></a>&nbsp;
                                
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

                              <td data-label="Stock Quantity"> 
                                <input type="text" name="hard_qtyinstock[]" class="form-control float hard_qtyinstock calculateamt" id="hard_qtyinstock_<?php echo $j;?>" data-id='<?php echo $j;?>' value="--" readonly> 
                             
                            </td>
                            <td data-label="Req. Quantity"> 
                                <input type="text" class="form-control float hard_qty calamt hard_qty arrow_keypress" name="hard_qty[]"data-fieldid="hard_qty" id="hard_qty_<?php echo $j;?>" data-id='<?php echo $j;?>' value="<?php echo !empty($req_value->hard_qty)?$req_value->hard_qty:''; ?>"/ > 
                            </td>
                            <td>

                                <input type="text" class="form-control float hard_unitprice calamt arrow_keypress" name="hard_unitprice[]" data-fieldid="hard_unitprice" id="hard_unitprice_<?php echo $j;?>" data-id='<?php echo $j;?>' value="--" readonly="true"> 
                 

                               
                            </td>
                             <td>
                                <?php $subtotal = ($req_value->hard_qty)*($req_value->itli_purchaserate); ?>
                                <input type="text" name="hard_totalamt[]" class="form-control eachtotalamt" value="0.00"  id="hard_totalamt_<?php echo $req_key+1; ?>" readonly="true"> 
                            </td>
                            <td data-label="Remarks">
                                <input type="text" class="form-control  hard_remarks jump_to_add" id="hard_remarks_<?php echo $j;?>" name="hard_remarks[]" data-id='<?php echo $j;?>'  value="<?php echo !empty($req_value->hard_remarks)?$req_value->hard_remarks:''; ?>" /> 
                            </td>
                            <td data-label="Action">
                                <div class="actionDiv acDiv2" id="acDiv2_<?php echo $j;?>"></div>

                                <?php
                                    if(count($handover_req_data) > 1):
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
                             <td data-label="Stock Quantity"> 
                                <input type="text" class="form-control float hard_qtyinstock calculateamt" name="hard_qtyinstock[]" id="hard_qtyinstock_<?php echo $j;?>" data-id='<?php echo $j;?>' value="<?php echo !empty($req_value->hard_qtyinstock)?$req_value->hard_qtyinstock:''; ?>" readonly="true"> 
                             
                            </td>
                            <td data-label="Req. Quantity"> 
                                <input type="text" class="form-control float hard_qty calamt hard_qty  arrow_keypress" name="hard_qty[]" data-fieldid="hard_qty"   id="hard_qty_1" data-id='1' > 
                            </td>
                              <td>

                               <input type="text" class="form-control hard_unitprice float calamt arrow_keypress" name="hard_unitprice[]" data-fieldid="hard_unitprice" id="hard_unitprice_1" value="0"  data-id='1' placeholder="Rate" <?php echo $readonly; ?> />
                            
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
                            <td colspan="9">
                               
                            </td>
                            <td>
                                 <a href="javascript:void(0)" class="btn btn-primary btnAdd pull-right" data-id="1"  id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                                <div class="clearfix"></div>
                            </td>
                        </tr>
                    </tbody>
                        
                </table>
                    <div class="roi_footer">
                 
                        <div class="col-sm-4">
                             <?php $rema_remarks=!empty($handover_req_data[0]->rema_remarks)?$handover_req_data[0]->rema_remarks:''; ?>

                            <div>
                                <label for=""><?php echo $this->lang->line('remarks'); ?> : </label>
                                <textarea name="rema_remarks" class="form-control" rows="4" placeholder=""><?php echo $rema_remarks;?></textarea>
                            </div>
                            
                        
                        </div>
                    </div>
                        
                   
                </div> 
                <div id="Printable" class="print_report_section printTable">
                
                </div>
            </div> <!-- end table responsive -->
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($handover_req_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($handover_req_data)?'Update':$this->lang->line('save');  ?></button>
             
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


        var storeid= $("#harm_tolocationid option:selected").val();
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
        template='<tr class="orderrow" id="orderrow_'+trplusOne+'" data-id="'+trplusOne+'"><td data-label="S.No."><input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/></td><td data-label="Code"> <div class="dis_tab"> <input type="text" class="form-control itemcode enterinput " id="itemcode_'+trplusOne+'" name="hard_code[]" data-id="'+trplusOne+'" data-targetbtn="view" readonly /> <input type="hidden" class="itemid" name="hard_itemsid[]" data-id="'+trplusOne+'" id="itemid_'+trplusOne+'" > <input type="hidden" data-id="'+trplusOne+'" class="qtyinstock" id="qtyinstock_'+trplusOne+'" /> <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading="List of Item" data-viewurl="<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition '); ?>" data-id="'+trplusOne+'" id="view_'+trplusOne+'" ><strong>...</strong></a>&nbsp </div></td><td data-label="Particular"><input type="hidden" class="eachsubtotal" name="eachsubtotal[]" id="eachsubtotal_'+trplusOne+'" > <input type="text" class="form-control itemname" id="itemname_'+trplusOne+'" name="" data-id="'+trplusOne+'" readonly></td><td data-label="Unit"><input type="text" class="form-control float hard_unit calculateamt" name="" id="hard_unit_'+trplusOne+'" data-id="'+trplusOne+'" > <input type="hidden" class="unitid" name="hard_unit[]" id="unitid_'+trplusOne+'" data-id="'+trplusOne+'"/></td> <td data-label="Req. Quantity "><input type="text" class="form-control float hard_qtyinstock calculateamt" name="hard_qtyinstock[]" id="hard_qtyinstock_'+trplusOne+'" data-id="'+trplusOne+'" readonly /> </td><td data-label="Req. Quantity"><input type="text" class="form-control float hard_qty calamt arrow_keypress" data-fieldid="hard_qty" name="hard_qty[]" id="hard_qty_'+trplusOne+'" data-id='+trplusOne+' value="0" ></td><td> <input type="text" class="form-control float hard_unitprice calamt arrow_keypress" name="hard_unitprice[]" data-fieldid="hard_unitprice"  id="hard_unitprice_'+trplusOne+'" value="" data-id="'+trplusOne+'" placeholder=""readonly="true"></td> </td> <td><input type="text" name="hard_totalamt[]" class="form-control eachtotalamt" value="0" readonly="true" id="hard_totalamt_'+trplusOne+'"> </td><td data-label="Remarks"> <input type="text" class="form-control  hard_remarks jump_to_add " id="hard_remarks_'+trplusOne+'" name="hard_remarks[]"  data-id="'+trplusOne+'"> </td><td data-label="Action"> <div class="actionDiv acDiv2" id="acDiv2_'+trplusOne+'"><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div></td></tr>';
        
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
        $('#hard_qtyinstock_'+rowno).val(stockqty);
        $('#unitid_'+rowno).val(unitid);
        $('#unitamtid_'+rowno).val(unitamtid);
        $('#hard_unitprice_'+rowno).val(hard_unitprice);
        $('#myView').modal('hide');
        $('#hard_qty_'+rowno).focus().select();
        
        $('.calamt').change();
        return false;
    })
</script>




<script type="text/javascript">
    
$(document).off('change','#harm_tolocationid');
$(document).on('change','#harm_tolocationid',function()
{
    
    // alert(storeid);
    var storeid='';
    var reqType = $("input[name='rema_isdep']:checked"). val();

    // alert(reqType);
    if(reqType=='Y')
    {
         var depname=$("#harm_tolocationid option:selected").text();
         storeid= $("#harm_tolocationid option:selected").val();
    }
    else
    {
        var depname=$("#harm_fromlocationid option:selected").text();
        storeid=$("#harm_fromlocationid option:selected").val();
    }



    // 
   
    $('.btnitem').attr('data-storeid',storeid);
    $('.btnitem').data('storeid',storeid);


})

</script>

<script>
    $(document).ready(function(){
        var storeid= $("#harm_tolocationid option:selected").val();
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
        var totalamt=parseFloat(qty)*parseFloat(rate);


        var valid_totalamt = checkValidValue(totalamt);
        $('#hard_totalamt_'+id).val(valid_totalamt.toFixed(2));
      

      
      var stotal=0;
     
      var eachsubtotal=0;
    
        $(".eachtotalamt").each(function() {
                stotal += parseFloat($(this).val());
            });


          eachsubtotal=parseFloat(eachsubtotal);

        $('#subtotalamt').val(eachsubtotal.toFixed(2));
        $('#totalamount').val(stotal.toFixed(2));
        $('.extra').change();

    })
</script>

<?php
    if(!empty($load_select2)):
        if($load_select2 == 'Y'):
?>
<script type="text/javascript">
    $('.select2').select2();
</script>
<?php
        endif;
    endif;
?>