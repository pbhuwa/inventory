<div class="white-box">

   <label class="dttable_ttl box-title">

      <center>Repair Request Entry</center>

   </label>

</div>

 <form method="post" id="FormRepairRequest" action="<?php echo base_url('ams/repair_request/save_repair_request'); ?>" class="form-material form-horizontal form" data-reloadurl="<?php echo base_url('ams/repair_request/index/reload'); ?>">

<div class="searchWrapper">

   <div class="form-group">

    <input type="hidden" name="id" value="<?php echo !empty($request_master[0]->rerm_repairrequestmasterid)?$request_master[0]->rerm_repairrequestmasterid:'';  ?>">

         <div class="col-md-3">

            <label><?php echo $this->lang->line('fiscal_year'); ?><span class="required">*</span></label>

            <select name="rerm_fiscalyrs" class="form-control required_field"  id="rerm_fiscalyrs">

               <?php

              if($fiscal_year):

                $fyear = !empty($request_master[0]->rerm_fiscalyrs)?$request_master[0]->rerm_fiscalyrs:''; 

                foreach ($fiscal_year as $ks => $not):

                  ?>

               <option value="<?php echo $not->fiye_name; ?>" <?php echo $fyear==$not->fiye_name ?"selected=selected" :'';?> ><?php echo $not->fiye_name; ?></option>

               <?php

                  endforeach;

                  endif;

                  ?>

            </select>

         </div>

         <div class="col-md-3">

          <?php 

          $requestno=!empty($request_master[0]->rerm_requestno)?$request_master[0]->rerm_requestno:$request_no;

           ?>

            <label>Request No.<span class="required">*</span>:</label>

            <input type="text" name="rerm_requestno" class="form-control required_field" id="rerm_requestno" value="<?php echo $requestno; ?>" readonly>

         </div>

         <div class="col-md-3">

           <?php 

          $manualcode=!empty($request_master[0]->rerm_manualno)?$request_master[0]->rerm_manualno:'';

           ?>

            <label>Manual No.:</label>

            <input type="text" name="rerm_manualno" class="form-control" id="rerm_manualno" value="<?php echo $manualcode; ?>">

         </div>

         <div class="col-md-3">

           <?php

                if(DEFAULT_DATEPICKER == 'NP'){

                    $request_date = !empty($request_master[0]->rerm_requestdatebs)?$request_master[0]->rerm_requestdatebs:DISPLAY_DATE;

                }else{

                    $request_date = !empty($request_master[0]->rerm_requestdatead)?$request_master[0]->rerm_requestdatead:DISPLAY_DATE;

                }

            ?>

            <label>Date <span class="required">*</span>:</label>

            <input type="text" name="rerm_requestdate" class="form-control required_field <?php echo DATEPICKER_CLASS; ?>" id="request_date" value="<?php echo $request_date; ?>"/>

         </div>

         <div class="col-md-3">

          <?php 

          $reqdepid=!empty($request_master[0]->rerm_reqdepid)?$request_master[0]->rerm_reqdepid:'';

           ?>

            <label>Department <span class="required">*</span>:</label>

            <select name="rerm_reqdepid" class="form-control select2 required_field" id="rerm_reqdepid">

               <option value="">---Select---</option>

               <?php

                  if($department_list):

                    foreach ($department_list as $ks => $dep):

                      ?>

               <option value="<?php echo $dep->dept_depid; ?>" <?php if($reqdepid==$dep->dept_depid) echo "selected=selected" ?>><?php echo $dep->dept_depname; ?></option>

               <?php

                  endforeach;

                  endif;

                  ?>

            </select>

         </div>

         <div class="col-md-3">

            <?php 

          $requestby=!empty($request_master[0]->rerm_requestby)?$request_master[0]->rerm_requestby:'';

           ?>

            <label>Requested By: <span class="required">*</span></label>

            <input type="text" name="rerm_requestby" class="form-control required_field" id="rerm_requestby" value="<?php echo $requestby; ?>" >

         </div>

         <div class="sm-clear"></div>

      

   </div>

   <div class="form-group">

      <div class="table-responsive col-sm-12">

         <table style="width:100%;" class="table dataTable dt_alt purs_table res_vert_table">

            <thead>
             <tr>
              <th scope="col" width="5%"> <?php echo $this->lang->line('sn'); ?>.</th>
              <th scope="col" width="15%">Assets Code </th>
              <th scope="col" width="20%">Description</th>
              <th scope="col" width="25%">Problem</th>
              <th scope="col" width="10%">Estimated Cost</th>
              <th scope="col" width="25%">Remarks</th>
              <th scope="col" width="5%"> <?php echo $this->lang->line('action'); ?></th>
             </tr>
            </thead>

            <tbody id="orderBody">

              <?php 
                $i=1;
                if (count($request_detail)): 
                foreach ($request_detail as $key => $detail):
              ?>
               <tr class="orderrow" id="orderrow_<?=$i?>" data-id="<?=$i?>">
                <input type="hidden" name="request_detail_id[]" value="<?php echo !empty($detail->rerd_repairrequestdetailid) ? $detail->rerd_repairrequestdetailid : ''; ?>">

                  <td data-label="S.No.">
                     <input type="text" class="form-control sno" id="s_no_<?=$i?>" value="<?=$i?>" readonly/>
                  </td>

                  <td data-label="Code">
                     <div class="dis_tab"> 
                        <input type="text" class="form-control assetscode enterinput" id="assetscode_<?=$i?>" name="assets_code[]"  data-id="<?=$i?>" data-targetbtn='view' value="<?php echo !empty($detail->rerd_assetcode)?$detail->rerd_assetcode:''; ?>">
                        <input type="hidden" class="assetsid" name="asdd_assetid[]" data-id="<?=$i?>" value="<?php echo !empty($detail->rerd_assetsid)?$detail->rerd_assetsid:''; ?>" id="assetsid_<?=$i?>">
                        <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading='<?php echo $this->lang->line('list_of_items'); ?>' data-viewurl='<?php echo base_url('/ams/assets/list_of_assets_popup'); ?>' data-id="<?=$i?>" id="view_<?=$i?>"><strong>...</strong></a>&nbsp;
                     </div>
                  </td>

                  <td data-label="Description">  
                     <input type="text" class="form-control assets_desc"  id="assets_desc_<?=$i?>" name="assets_desc[]"  data-id="<?=$i?>" value="<?php echo !empty($detail->rerd_assetsdesc)?$detail->rerd_assetsdesc:''; ?>" readonly> 
                  </td>
                  <td data-label="Problem"> 
                     <input type="text" class="form-control required_field  problem jump_to_add " id="problem_<?=$i?>" name="problem[]"  data-id="<?=$i?>" value="<?php echo !empty($detail->rerd_problem)?$detail->rerd_problem:''; ?>"> 
                  </td> 
                  <td data-label="Estimate cost"> 
                     <input type="text" class="form-control required_field  estimated_cost float" id="estimated_cost_<?=$i?>" name="estimated_cost[]"  data-id="<?=$i?>" value="<?php echo !empty($detail->rerd_estimateamt)?$detail->rerd_estimateamt:''; ?>"> 
                  </td>
                  <td data-label="Remarks"> 
                     <input type="text" class="form-control remarks" id="remarks_<?=$i?>" name="remarks[]"  data-id="<?=$i?>" value="<?php echo !empty($detail->rerd_remark)?$detail->rerd_remark:''; ?>"> 
                  </td>
                  <td data-label="Action">
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger btnRemove" id="btnRemove_<?=$i?>" data-id="<?=$i?>">
                    <i class="fa fa-remove"></i>
                    </a>
                  </td>
               </tr>

             <?php $i++; endforeach; else: ?>


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
                  <td data-label="Problem"> 

                     <input type="text" class="form-control required_field  problem jump_to_add " id="problem_1" name="problem[]"  data-id='1'> 

                  </td> 
                  <td data-label="Estimate cost"> 

                     <input type="text" class="form-control required_field  estimated_cost float" id="estimated_cost_1" name="estimated_cost[]"  data-id='1'> 

                  </td>
                  <td data-label="Remarks"> 
                     <input type="text" class="form-control remarks" id="remarks_1" name="remarks[]"  data-id='1'> 
                  </td>
                  <td data-label="Action">
                     <div class="actionDiv acDiv2" id="acDiv2_1"></div>
                  </td>
               </tr>
             <?php endif; ?>
            </tbody>

            <tbody>

               <tr class="resp_table_breaker">

                  <td colspan="7">

                     <a href="javascript:void(0)" class="btn btn-primary btnAdd pull-right" data-id="<?=$i?>"  id="addOrder_<?=$i?>"><span class="btnChange" id="btnChange_<?=$i?>"><i class="fa fa-plus" aria-hidden="true"></i></span></a>

                     <div class="clearfix"></div>

                  </td>

               </tr>

            </tbody>

            <tfoot>

              <tr>

               <td colspan="3">

                <?php 

                $fullremarks=!empty($request_master[0]->rerm_remark)?$request_master[0]->rerm_remark:'';

                 ?>

                  <label>Remarks</label>

                  <textarea name="full_remarks" class="form-control"><?php echo $fullremarks; ?></textarea>

               </td>
               <td class="pull-right">
                 <label>Total Estimate</label>
                 <input type="text" name="total_estimate" class="form-control float" id="total_estimate" value="<?php echo !empty($request_master[0]->rerm_estmatecost)? $request_master[0]->rerm_estmatecost :''; ?>">
               </td>

            </tr>

            </tfoot>

         </table>

         <div id="Printable" class="print_report_section printTable">

         </div>

      </div>

      <!-- end table responsive -->

   </div>

    <div class="form-group">

      <div class="col-md-12">

         <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($request_master)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($request_master)?'Update':$this->lang->line('save');  ?></button>

            <button type="submit" class="btn btn-info savePrint" data-operation='<?php echo !empty($request_master)?'update':'save ' ?>' id="btnSubmit" data-print="print"><?php echo !empty($request_master)?'Update & Print':$this->lang->line('save_and_print') ?></button>

      </div>

      <div class="col-sm-12">

         <div  class="alert-success success"></div>

         <div class="alert-danger error"></div>

      </div>

   </div>

   <div class="clearfix"></div>

   <div class="clearfix"></div>

  </form>

</div>

<script type="text/javascript">

   $(document).off('click','.btnAdd');

    $(document).on('click','.btnAdd',function(){

        var id=$(this).data('id');

        

        var trpluOne = $('.orderrow').length;

        var trplusOne = $('.orderrow').length+1;

       

         var assetsid=$('#assetsid_'+trpluOne).val();



         if(assetsid==''){

            $('#assetscode_'+trpluOne).focus();

            return false;

        }

        if(trplusOne==2)

        {

        $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');

        }

        var template='';

        

        template='<tr class="orderrow" id="orderrow_'+trplusOne+'" data-id='+trplusOne+'><td data-label="S.No."> <input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'"  readonly/></td><td data-label="Code"><div class="dis_tab"> <input type="text" class="form-control assetscode enterinput" id="assetscode_'+trplusOne+'"  name="assets_code[]" data-id="'+trplusOne+'" data-targetbtn="view" value=""> <input type="hidden" class="assetsid" name="asdd_assetid[]" data-id="'+trplusOne+'" value="" id="assetsid_'+trplusOne+'" > <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading="Assets List" data-viewurl="<?php echo base_url("/ams/assets/list_of_assets_popup"); ?>" data-id="'+trplusOne+'" id="view_"'+trplusOne+'" ><strong>...</strong></a>&nbsp;</div></td><td data-label="Description"> <input type="text" class="form-control assets_desc" id="assets_desc_'+trplusOne+'"  name="assets_desc[]" data-id='+trplusOne+'" readonly></td></td><td data-label="Problem"> <input type="text" class="form-control required_field problem jump_to_add " id="problem_'+trplusOne+'"  name="problem[]" data-id="'+trplusOne+'"></td><td data-label="Estimate cost"> <input type="text" class="form-control required_field  estimated_cost" id="estimated_cost_'+trplusOne+'" name="estimated_cost[]"  data-id="'+trplusOne+'"></td><td data-label="Remarks"><input type="text" class="form-control remarks" id="remarks_'+trplusOne+'" name="remarks[]"  data-id="'+trplusOne+'"></td><td data-label="Action"> <div class="actionDiv acDiv2" id="acDiv2_'+trplusOne+'"><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div></td></tr>';

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

                    $(this).find('.problem').attr("id","problem_"+vali);

                    $(this).find('.problem').attr("data-id",vali);

                    $(this).find('.estimated_cost').attr("id","estimated_cost"+vali);

                    $(this).find('.estimated_cost').attr("data-id",vali);

                    $(this).find('.remarks').attr("id","remarks"+vali);

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

        $('#myView').modal('hide');

        $('#problem_'+rowno).focus().select();

        return false;

    })

    $(document).off('keyup change','.estimated_cost');
    $(document).on('keyup change','.estimated_cost',function(){
      let total_estimate = 0;
      $(".estimated_cost").each(function () {
        total_estimate += parseFloat($(this).val());
      })
      if (total_estimate) {
        $('#total_estimate').val(total_estimate.toFixed(2));
      }else{
        $('#total_estimate').val(0);
      }

    });

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