<form method="post" id="FormBulkTransferAssets" action="">
     <div class="form-group">       
          <div class="col-md-3">
                <label>Transfer Type<span class="required">*</span>:</label>
                <select name="astm_transfertypeid" id="transfertypeid" class="form-control">         
                    <option value="D">Inter School</option>
                </select>

            </div>

          <div class="departmentWrapper" >
            <?php 
             $locationlist=$this->general->get_tbl_data('*','loca_location',array('loca_status'=>'O')); 
            ?>
             <div class="col-md-3">
              <label>From School</label>
            <select name="schoolid" id="from_schoolid" class="form-control">
            <?php
            // echo "<pre>";
            // print_r($locationlist);
            // die();
            if(!empty($locationlist)):
              foreach($locationlist as $loc):
              ?>
              <option value="<?php echo $loc->loca_locationid; ?>"  ><?php echo $loc->loca_name; ?></option>
              <?php
              endforeach;
            endif;
             ?>
             </select>
           </div>

            <div class="col-md-3">

                <label>Department From:</label>
                <select name="depid" class="form-control select2 depselect" id="fromdepid">
                <option value="">--Select--</option>
                <?php

                 if(!empty($department_list)):
                  foreach ($department_list as $ks => $dlist):
                    ?>
                    <option value="<?php echo $dlist->dept_depid; ?>"><?php echo $dlist->dept_depname; ?></option>
                    <?php
                  endforeach;
                endif;
                ?>
            </select>
            </div>

            <?php 

             $subdepid=''; 
             if(!empty($sub_department)):
                $displayblock='display:block';
             else:
                $displayblock='display:none';
             endif;

             ?>

            <div class="col-md-3" id="fromsubdepdiv" style="<?php echo $displayblock; ?>" >

                 <label for="example-text">From Sub Department:</label>

                  <select name="subdepid" id="from_subdepid" class="form-control" >

                    <?php if(!empty($sub_department)): ?>

                          <option value="">--All--</option>

                          <?php foreach ($sub_department as $ksd => $sdep):

                            ?>

                            <option value="<?php echo $sdep->dept_depid; ?>" <?php if($sdep->dept_depid==$subdepid) echo "selected=selected"; ?> ><?php echo $sdep->dept_depname; ?></option>

                    <?php endforeach; endif; ?>

                  </select>

            </div>
            <div class="col-md-2">            
                <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="<?php echo ('ams/assets_transfer/search_assets_record_branch_department') ?>">Search</button>        
            </div>

    </div>

   <div class="clearfix"></div>

</form>
<div id="displayReportDiv">
    
</div>
<div class="printBox">
    <div class="showPrintedArea"></div>
</div>

<script type="text/javascript">

    $(document).off('change','#transfertypeid');

    $(document).on('change','#transfertypeid',function(){

        var search_date_val = $(this).val();

        if(search_date_val == 'D'){

            $('.branchWrapper').hide();

        }else{

            $('.branchWrapper').show();

        }

        if(search_date_val == 'B'){

            $('.departmentWrapper').hide();

        }else{

            $('.departmentWrapper').show();

        }

    });

</script>

<script type="text/javascript">

   $(document).off('click','.btnAdd');
    $(document).on('click','.btnAdd',function(){
      var frmdep= $('#fromdepid').val();
      var frmsubdep= $('#from_subdepid').val();
      var depid=frmdep;
      if(frmsubdep!='' || frmsubdep!=null){
        var depid=frmsubdep;
      }
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

        template='<tr class="orderrow" id="orderrow_'+trplusOne+'" data-id='+trplusOne+'><td data-label="S.No."> <input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'"  readonly/></td><td data-label="Code"><div class="dis_tab"> <input type="text" class="form-control assetscode enterinput" id="assetscode_'+trplusOne+'"  name="assets_code[]" data-id="'+trplusOne+'" data-targetbtn="view" value=""> <input type="hidden" class="assetsid" name="assetid[]" data-id="'+trplusOne+'" value="" id="assetsid_'+trplusOne+'" > <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading="Assets List" data-viewurl="<?php echo base_url("/ams/assets/list_of_assets_popup"); ?>" data-id="'+trplusOne+'" id="view_"'+trplusOne+'" data-type="'+depid+'" ><strong>...</strong></a>&nbsp;</div></td><td data-label="Itemname"><input type="text" class="form-control itemname"  id="itemname_'+trplusOne+'" name="itemname[]"  data-id="'+trplusOne+'"  readonly></td><td data-label="Description"> <input type="text" class="form-control assets_desc" id="assets_desc_'+trplusOne+'"  name="assets_desc[]" data-id='+trplusOne+'" readonly></td><td data-label="Orginal. Value"> <input type="text" class="form-control float calculateamt assets_orginalval" name="assets_orginalval[]" id="assets_orginalval_'+trplusOne+'" data-id="'+trplusOne+'" ></td><td data-label="Current Val"><input type="hidden" class="form-control staffid" name="staffid[]"   id="staffid_'+trplusOne+'" data-id='+trplusOne+' >  <input type="text" class="form-control assets_prev_staffname" name="assets_prev_staffname[]" id="assets_prev_staffname_'+trplusOne+'"  data-id="'+trplusOne+'" ></td><td data-label="Remarks"> <input type="text" class="form-control remarks jump_to_add " id="remarks_'+trplusOne+'"  name="remarks[]" data-id="'+trplusOne+'"></td><td data-label="Action"> <div class="actionDiv acDiv2" id="acDiv2_'+trplusOne+'"><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div></td></tr>';

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

                    $(this).find('.assets_prev_staffname').attr("id","assets_prev_staffname_"+vali);

                    $(this).find('.assets_prev_staffname').attr("data-id",vali);

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

          }

     });

  $(document).off('click','.itemDetail');

    $(document).on('click','.itemDetail',function(){

        var rowno=$(this).data('rowno');

        var rate=$(this).data('rate');

        var asen_assetcode=$(this).data('asen_assetcode');
        var asen_item=$(this).data('asen_item');

        var asen_desc=$(this).data('asen_desc');

        var asen_asenid=$(this).data('asen_asenid');

        var purrate=$(this).data('purrate');

        var receiver_name=$(this).data('receiver_name');
           var staffid=$(this).data('staffid');

        $('#assetsid_'+rowno).val(asen_asenid);

        $('#assetscode_'+rowno).val(asen_assetcode);

        $('#assets_desc_'+rowno).val(asen_desc);
        $('#itemname_'+rowno).val(asen_item);

        $('#assets_orginalval_'+rowno).val(purrate);

        $('#assets_prev_staffname_'+rowno).val(receiver_name);
         $('#staffid_'+rowno).val(staffid);

        $('#myView').modal('hide');

        $('#remarks_'+rowno).focus();

        $('.assets_orginalval').change();

        return false;

    })

    // $(document).off('change','.depselect');

    // $(document).on('change','.depselect',function(e){

    //   var fromdepid =$('#fromdepid').val();

    //   var todepid=$('#todepid').val();

    //   if(fromdepid==todepid){

    //     alert('Same Department Couldnot accepted!!');

    //     return false;

    //   }

    //    $('#todepid').focus();

    // });

    $(document).off('change','#locationfrom,#locationto');

    $(document).on('change','#locationfrom,#locationto',function(e){

      var locationfrom =$('#locationfrom').val();

      var locationto=$('#locationto').val();

      if(locationfrom==locationto){

        alert('Same Branch Couldnot accepted!!');

        return false;

      }

      $('#locationto').focus();

    })

    $(document).off('change','#from_schoolid,#to_schoolid');

    $(document).on('change','#from_schoolid,#to_schoolid',function(e){

        var id = $(this).attr('id');

        var schoolid=$(this).val();

        var submitdata = {schoolid:schoolid};

        var submiturl = base_url+'issue_consumption/stock_requisition/get_department_by_schoolid';

        ajaxPostSubmit(submiturl,submitdata,beforeSend,onSuccess);

        function beforeSend(){

          };

         function onSuccess(jsons){

                    data = jQuery.parseJSON(jsons);

                    if(data.status=='success'){

                      if(id == 'from_schoolid'){

                        $('#fromsubdepdiv').hide();

                       $('#fromdepid').html(data.dept_list);     
                      }else{
                        $('#tosubdepdiv').hide();

                        $('#todepid').html(data.dept_list);
                      }

                    }

                    else{
                      if(id == 'from_schoolid'){

                        $('#fromdepid').html(' <option value="">--All--</option>');

                        $("#fromdepid").select2("val", "");

                        $("#from_subdepid").select2("val", "");
                      }else{
                        $('#todepid').html(' <option value="">--All--</option>');

                        $("#todepid").select2("val", "");

                        $("#to_subdepid").select2("val", "");
                      }

                    }
                }
    });

    $(document).off('change','#fromdepid,#todepid');

    $(document).on('change','#fromdepid,#todepid',function(e){

        var id = $(this).attr('id');

        var depid=$(this).val();

        var submitdata = {schoolid:depid};

        var submiturl = base_url+'issue_consumption/stock_requisition/get_department_by_schoolid';

        // aletr(schoolid);

         // $("#to_subdepid").select2("val", "");

         // $('#to_subdepid').html('');

         ajaxPostSubmit(submiturl,submitdata,beforeSend,onSuccess);

        function beforeSend(){

          };

         function onSuccess(jsons){

                    data = jQuery.parseJSON(jsons);

                     if(data.status=='success'){

                      if (id == 'fromdepid') {

                        $('#fromsubdepdiv').show();

                         $('#from_subdepid').html(data.dept_list);
                      }else{
                        $('#tosubdepdiv').show();

                         $('#to_subdepid').html(data.dept_list);
                      }

                     }else{
                      if (id == 'fromdepid') {
                         $('#fromsubdepdiv').hide();

                        $('#from_subdepdiv').html();

                      }else{
                        $('#tosubdepdiv').hide();

                        $('#to_subdepdiv').html();
                      }
                     }
                }
              });

</script>

<script type="text/javascript">
  $(document).off('change','#from_subdepid,#fromdepid');
  $(document).on('change','#from_subdepid,#fromdepid',function(e){
    var depid=$(this).val();
    $('.btnitem').attr('data-type',depid);
  })

</script>