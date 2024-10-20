<style type="text/css">
    .col-5{
        width: 20%;
        float: left;
    }
</style>
<?php
    if(DEFAULT_DATEPICKER == 'NP'){
        $startdate = !empty($contract_data[0]->coin_contractstartdatebs)?$contract_data[0]->coin_contractstartdatebs:DISPLAY_DATE;
        $enddate = !empty($contract_data[0]->coin_contractenddatebs)?$contract_data[0]->coin_contractenddatebs:DISPLAY_DATE;
    }else{
        $startdate = !empty($contract_data[0]->coin_contractstartdatead)?$contract_data[0]->coin_contractstartdatead:DISPLAY_DATE;
        $enddate = !empty($contract_data[0]->coin_contractenddatead)?$contract_data[0]->coin_contractenddatead:DISPLAY_DATE;
    }
?>
<form method="post" id="FormContract" action="<?php echo base_url('biomedical/contractmanagement/save_contractmgmt'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/contractmanagement/form_contractmgmt'); ?>' enctype="multipart/form-data" accept-charset="utf-8" class="resp_xs" >
    <input type="hidden" name="id" value="<?php echo !empty($contract_data[0]->coin_contractinformationid)?$contract_data[0]->coin_contractinformationid:'';  ?>">
    <div class="form-group">
        <div class="col-md-4">
            <label for="example-text"><?php echo $this->lang->line('contract_type'); ?> <span class="required">*</span> :</label>
            <select id="contractType" class="form-control" name="coin_contracttypeid">
            <!--     <option value="">---select---</option>
                <?php
                    if(!empty($contractType)):
                        foreach($contractType as $contract):
                    ?>
                <option value="<?php echo $contract->coty_contracttypeid; ?>"><?php echo $contract->coty_contracttype; ?></option>
                <?php
                    endforeach;
                    endif;
                    ?> -->

                <option value="2" selected>Distributor</option>
            </select>
        </div>
        <?php //echo $org_id; die; ?>
        <div class="col-md-4">
            <?php 
            $dist_id=!empty($contract_data[0]->coin_distributorid)?$contract_data[0]->coin_distributorid:''; ?>
            <span id="distributorsWrapper" style="display:none;">
                <label for="example-text"><?php echo $this->lang->line('distributors'); ?> <span class="required">*</span> :</label>
                <select class="form-control typeSelected" data-id="distributors" name="coin_distributorid">
                    <option value="">---select---</option>
                    <?php
                        if(!empty($distributors)):
                            foreach($distributors as $value):
                        ?>
                    <option value="<?php echo $value->dist_distributorid; ?>"><?php echo $value->dist_distributor; ?></option>
                    <?php
                        endforeach;
                        endif;
                        ?>
                </select>
            </span>      
        </div>
       
    </div>
    <div class="clear"></div>
    <div id="contractorInfo" class="mtop_5"></div>
    <div id="contractorForm" class="mtop_5" style="display: none;">
<div class="row" style="margin-top: 7px;">
        <div class="col-5 col-sm-6">
            <label for="example-text"><?php echo $this->lang->line('title'); ?> <span class="required">*</span>: </label>
            <input type="text" name="coin_contracttitle" class="form-control"  placeholder="Contract Title" value="<?php echo !empty($contract_data[0]->coin_contracttitle)?$contract_data[0]->coin_contracttitle:''; ?>" id="contractTitle">
        </div>
        <div class="col-5 col-sm-6">
            <label for="example-text"><?php echo $this->lang->line('start_date'); ?><span class="required">*</span>: </label>
            <input type="text" name="coin_contractstartdate" class="form-control <?php echo DATEPICKER_CLASS; ?>"  placeholder="Contract Start Date" value="<?php echo $startdate; ?>" id="ContractStartDate">
        </div>
        <div class="col-5 col-sm-6">
            <label for="example-text"><?php echo $this->lang->line('end_date'); ?><span class="required">*</span>: </label>
            <input type="text" name="coin_contractenddate" class="form-control <?php echo DATEPICKER_CLASS; ?>"  placeholder="Contract End Date"  value="<?php echo $enddate; ?>" id="ContractEndDate">
        </div>
        <!-- <div class="clear"></div> -->
        <div class="col-5 col-sm-6">
            <label for="example-text"><?php echo $this->lang->line('contract_value'); ?><span class="required">*</span>: </label>
            <input type="text" name="coin_contractvalue" class="form-control float"  placeholder="Contract Value" value="<?php echo !empty($contract_data[0]->coin_contractvalue)?$contract_data[0]->coin_contractvalue:''; ?>" id="contractValue">
        </div>
        <div class="col-5 col-sm-6">
            <label for="example-text"><?php echo $this->lang->line('renew_type'); ?> <span class="required">*</span>: </label>
            <!-- <input type="text" name="coin_renewtypeid" class="form-control"  placeholder="Contract Renew Type" value="<?php echo !empty($contract_data[0]->coin_renewtypeid)?$contract_data[0]->coin_renewtypeid:''; ?>" id="renewType"> -->
            <?php $renewtypeid=!empty($contract_data[0]->coin_renewtypeid)?$contract_data[0]->coin_renewtypeid:''; ?>
            <select name="coin_renewtypeid" class="form-control" id="renewType">
                <option value="">---Select---</option>
                <?php
                    if(!empty($renewType)):
                        foreach($renewType as $renew):
                ?>
                    <option value="<?php echo $renew->rety_renewtypeid?>" <?php if($renewtypeid==$renew->rety_renewtypeid) echo "selected=selected"; ?>><?php echo $renew->rety_renewtype;?></option>
                <?php
                        endforeach;
                    endif;
                ?>
            </select>
        </div>
    </div>
        <input type="hidden" name="coin_orgid" id="coin_orgid" value="<?php echo $org_id; ?>">
        <div class="clear"></div>
        <?php if($org_id=='2'){ 
            $this->load->view('v_contract_assets');
         }else{ ?>
    <div class="form-group">
        
            <div class="table-responsive col-sm-12">
                <table style="width:100%;" class="table purs_table dataTable">
                    <thead>
                        <tr>
                            <th width="10%">S.no</th>
                            <th width="10%">Eq.Code</th>
                            <th width="30%">Eq.Description</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="purchaseDataBody">
                        <?php $j=1;
                        if(!empty($contract_data)){ 
                            
                            foreach ($contract_data as $key => $contract) {
                              ?>
                               <?php
                   $contrt=explode(',', $contract->coin_equipid);
                   
                   $this->load->Model('bio_medical_mdl');
                    foreach($contrt as $cr){
                    $cntr=$this->bio_medical_mdl->get_eqp_from_bmin("bmin_equipid IN ($cr)");
                    //echo $this->db->last_query(); die;
                      if($cntr){ 

                      foreach ($cntr as $key => $cor) { ?>
                        <tr class="orderrow" id="orderrow_<?php echo $j;?>" data-id='<?php echo $j;?>'>
                                   
                            <td>
                                <input type="text" class="form-control sno" id="s_no_<?php echo $j;?>" value="<?php echo $j;?>" readonly/>
                        
                                 <input type="hidden" class="receiveddetailid" name="coin_equipid[]" id="equipid_<?php echo $j;?>" value="<?php echo $cor->bmin_equipid; ?>" />
                            </td>
                            <td>
                                <div class="dis_tab"> 
                                    <input type="text" class="form-control equipkey enterinput " id="equipkey_<?php echo $j;?>"  data-id='<?php echo $j;?>' data-targetbtn='view' placeholder="Eq.Code"  value="<?php echo $cor->bmin_equipmentkey; ?>" >
                                  
                                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Equipments' data-viewurl='<?php echo base_url('biomedical/bio_medical_inventory/list_of_equipment'); ?>' data-id='<?php echo $j;?>' id="view_<?php echo $j; ?>"><strong>...</strong></a>
                                </div>
                            </td>
                             <td>  
                                <input type="text" class="form-control description" id="description_<?php echo $j;?>" data-id='<?php echo $j;?>' placeholder="Eq.Description" value='<?php echo $cor->eqli_description;?>' readonly>
                              
                            </td>
                           
                            <td>
                                <div class="actionDiv acDiv2"></div>
                            </td>
                        </tr>
                         <?php } } } ?>
                        <?php
                        $j++; 
                    } }
                    else{ ?>
                        <tr class="orderrow" id="orderrow_1" data-id='1'>
                            <td>
                                <input type="text" class="form-control sno" id="s_no_1" value="1" readonly/>
                                 <input type="hidden" class="receiveddetailid" name="coin_equipid[]" id="equipid_1" value=""/>
                            </td>
                            <td>
                                <div class="dis_tab"> 
                                    <input type="text" class="form-control equipkey enterinput " id="equipkey_1"  data-id='1' data-targetbtn='view' placeholder="Eq.Code">
                                  
                                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Equipments' data-viewurl='<?php echo base_url('biomedical/bio_medical_inventory/list_of_equipment'); ?>' data-id='1' id="view_1"><strong>...</strong></a>
                                </div>
                            </td>
                             <td>  
                                <input type="text" class="form-control description" id="description_1" data-id='1' placeholder="Eq.Description" readonly>
                              
                            </td>
                            <td>
                                <div class="actionDiv acDiv2"></div>
                            </td>
                        </tr>
                      <?php } ?>
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
        <div class="clear"></div>
        <div class="row">
        <div class="col-sm-12 col-xs-12">
            <label><?php echo $this->lang->line('description'); ?> <span class="required">*</span>: </label>
            <textarea style="width: 100%" name="coin_description" placeholder="Description" class="form-control" ><?php echo !empty($contract_data[0]->coin_description)?$contract_data[0]->coin_description:''; ?></textarea>
        </div>
        </div>
        <div class="clear"></div>
        <div class="row" style="margin-top: 7px;">
        <div class="col-sm-6 col-xs-6">
            <label>Attachments</label>
            <div class="dis_tab">
                <input type="file" id="coin_attachments" name="coin_attachments[]"/>
                <input type="hidden" name="coin_attach[]">
                <a href="javascript:void(0)" class="btn btn-info table-cell width_30" id="addAttachments">+</a>
            </div>
            <div class="addAttachmentRow">
                <?php 

                $contractAttachments = !empty($contract_data[0]->coin_attachments)?$contract_data[0]->coin_attachments:'';
                if($contractAttachments):
                $attach = explode(', ',$contractAttachments);
                $download = "";
                if($attach):
                    foreach($attach as $key=>$value){
                        $download .= "<a href='".base_url().CONTRACT_ATTACHMENT_PATH.'/'.$value."' target='_blank'>Download<a>&nbsp;&nbsp;&nbsp;";
                        }
                endif;
                echo $download;
            endif;
                ?>
            </div>
        </div>
        <div class="clear"></div>
</div>
    <?php 
        $add_edit_status=!empty($edit_status)?$edit_status:0;
        $usergroup=$this->session->userdata(USER_GROUPCODE);
        // echo $add_edit_status;
        if((empty($contract_data)) || (!empty($contract_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>
        <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($contract_data)?'update':'save' ?>' id="btnDeptment" ><?php echo !empty($contract_data)?'Update':'Save' ?></button>
          <?php
           endif; ?>
    <div  class="alert-success success"></div>
    <div class="alert-danger error"></div>
    </form>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        // $(document).off('change', '#contractType');
        // $(document).on('change', '#contractType',function(){
            var contracttype = $('#contractType option:selected').val();
            var contract_url = '';
            $('#contractorInfo').hide();
            $('#contractorForm').hide();

            if(contracttype == '1'){
                $('#manufacturersWrapper').show();
                $('#distributorsWrapper').hide();
                contract_url = 'biomedical/contractmanagement/getContractTypeData/manufacturers';
            }else if(contracttype == '2'){
                $('#distributorsWrapper').show();
                $('#manufacturersWrapper').hide();
                contract_url = 'biomedical/contractmanagement/getContractTypeData/distributors';
            }else{
                $('#distributorsWrapper').hide();
                $('#manufacturersWrapper').hide();
            }      
    
            $(document).off('change','.typeSelected');
            $(document).on('change','.typeSelected', function(){
                var id = $(this).val();
    
                $.ajax({
                    type: "POST",
                    url: base_url+contract_url,
                    data: {id:id},
                    dataType: 'json',
                    beforeSend: function(){
    
                    },
                    success: function(datas){
                        console.log(datas);
                        $('#contractorInfo').show();
                        $('#contractorInfo').html(datas.tempform);
                        if(datas.tempform != ""){
                            $('#contractorForm').show();
                        }else{
                            $('#contractorForm').hide();
                        }
                    }
    
                });
            });
        });

        $(document).off('click','#addAttachments');
        $(document).on('click','#addAttachments',function(){
            $(".addAttachmentRow").append('<div class="dis_tab mtop_5"><input type="file" name="coin_attachments[]" "/><input type="hidden" name="coin_attach[]"><a class="btn btn-danger table-cell width_30 btnminus"><span class="fa fa-trash"></span></a></div>');
        });
    
        $(document).off('click','.btnminus');
        $(document).on('click','.btnminus',function(){
            $(this).closest('div').remove();
        });
     
</script>

<?php if(!empty($contract_data)): ?>
<script type="text/javascript">
    var disid='<?php echo $contract_data[0]->coin_distributorid; ?>';
    //alert('id '+disid);
    if(disid)
    {
        $('.typeSelected').val(disid);
    }
    setTimeout(function(){
        $('.typeSelected').change();
    },500);
    
</script>
<?php endif; ?>


<script type="text/javascript">
  $('.select2').select2();
</script>


<script type="text/javascript">
    $(document).off('click','.btnAdd1');
    $(document).on('click','.btnAdd1',function(){
        // alert('hello');

        var id = $(this).data('id');
        var org_id =$('#coin_orgid').val();
        //alert(org_id);
        var equipid=$('#equipid_'+id).html();
        var equipkey = $('#equipkey_'+id).val();
        var description = $('#description_'+id).val();
        // var unit = $('#puit_unitid_'+id).val();
        // var qty = $('#puit_qty_'+id).val();
        // var rate = $('#puit_unitprice_'+id).val();
        // var tax = $('#puit_taxid_'+id).val();
        if(description=='' || description==null )
        {
            $('#description_'+id).select2('open');
            $('#equipkey_'+id).focus();
            return false;
        }
        // if(qty=='' || qty==null )
        // {
        // $('#puit_qty_'+id).focus();
        // return false;
        // }
        // if(rate=='' || rate==null )
        // {
        // $('#puit_unitprice_'+id).focus();
        // return false;
        // }
        var orderlen=$('.orderrow').length;

        var newitemid=$('#equipkey_'+orderlen).val();
        if(newitemid=='')
        {
            $('#equipkey_'+orderlen).focus();
            return false;
        }

        var trplusOne = orderlen+1;
        if(trplusOne==2)
        {
            $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');
        }
        var templat='';
        if(org_id=='2'){
            templat='<tr class="orderrow" id="orderrow_'+trplusOne+'" data-id="'+trplusOne+'"> <td> <input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/> <input type="hidden" class="form-control equipid" id="equipid_'+trplusOne+'" name="coin_equipid[]" value="'+trplusOne+'" readonly/> </td><td> <div class="dis_tab"> <input type="text" class="form-control equipkey enterinput " id="equipkey_'+trplusOne+'"  data-id="'+trplusOne+'" data-targetbtn="view" placeholder="Assets Code"> <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading="Assets List" data-viewurl="<?php echo base_url('ams/assets/list_of_item'); ?>"" data-id="'+trplusOne+'" id="view_'+trplusOne+'"><strong>...</strong></a> </div></td><td><input type="text" class="form-control description enterinput " id="description_'+trplusOne+'" data-id="'+trplusOne+'" data-targetbtn="view" placeholder="Assets Description"></td><td><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div> <div class="actionDiv"></td></tr>'; 
        }else{
            templat='<tr class="orderrow" id="orderrow_'+trplusOne+'" data-id="'+trplusOne+'"> <td> <input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/> <input type="hidden" class="form-control equipid" id="equipid_'+trplusOne+'" name="coin_equipid[]" value="'+trplusOne+'" readonly/> </td><td> <div class="dis_tab"> <input type="text" class="form-control equipkey enterinput " id="equipkey_'+trplusOne+'"  data-id="'+trplusOne+'" data-targetbtn="view" placeholder="Equipment Code"> <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading="Equipments" data-viewurl="<?php echo base_url('biomedical/bio_medical_inventory/list_of_equipment'); ?>"" data-id="'+trplusOne+'" id="view_'+trplusOne+'"><strong>...</strong></a> </div></td><td><input type="text" class="form-control description enterinput " id="description_'+trplusOne+'" data-id="'+trplusOne+'" data-targetbtn="view" placeholder="Equipment Description"></td><td><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div> <div class="actionDiv"></td></tr>';
        }
        // console.log(templat);
        $('#purchaseDataBody').append(templat);
        $('.btnTemp').hide(); 
        $('.nepdatepicker').nepaliDatePicker({
          npdMonth: true,
          npdYear: true,
        });
        // getProductsByCategory();
        });
//remove
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
                    $(this).find('.equipkey').attr("id","equipkey_"+vali);
                    $(this).find('.equipkey').attr("data-id",vali);
                    $(this).find('.description').attr("id","description_"+vali);
                    $(this).find('.description').attr("data-id",vali);
                    // $(this).find('.equipid').attr("id","equipid_"+vali);
                    // $(this).find('.equipid').attr("data-id",vali);
                    $(this).find('.acDiv2').attr("id","acDiv2_"+vali);
                     $(this).find('.acDiv2').attr("data-id",vali);
                    $(this).find('.btnAdd1').attr("id","addOrder_"+vali);
                    $(this).find('.btnAdd1').attr("data-id",vali);
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
       //salert($(this).data('rowno'));
        var rowno=$(this).data('rowno');
       // alert('a'+rowno);
        var equipid=$(this).data('equipid');
        var equipkey=$(this).data('equipkey');
        var description=$(this).data('description');

       
        

        // var itemname=$(this).data('itemname');
        // var itemid=$(this).data('itemid');
        // var stockqty=$(this).data('issueqty');
        // var stqty = $(this).data('stockqty');
        // var unitname=$(this).data('unitname');
        // var unitid=$(this).data('unitid');
        $('#equipid_'+rowno).val(equipid);
        $('#equipkey_'+rowno).val(equipkey);
        //$('#equipkey_1').val(equipkey);

        $('#description_'+rowno).val(description);
        // $('#puit_unitid_'+rowno).val(unitname);
        // $('#stock_qty_'+rowno).val(stqty);
        // $('#itemstock_'+rowno).val(stockqty);
        // $('#rede_unit_'+rowno).val(unitname);
        // $('#qtyinstock_'+rowno).val(stockqty);
        // $('#unitid_'+rowno).val(unitid);
        $('#myView').modal('hide');
        $('#dis_qty_'+rowno).focus();
    })
   
</script>