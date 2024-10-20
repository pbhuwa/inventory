<div class="list_c2 label_mw125">

<div class="form-group row resp_xs">

  <div class="white-box pad-5">

    <div class="row">

      <div class="col-sm-4 col-xs-6">

        <label><?php echo $this->lang->line('requisition_no'); ?></label>: 

        <?php echo $reqno= !empty($requistion_data[0]->rema_reqno)?$requistion_data[0]->rema_reqno:''; ?>

        <input type="hidden" value="<?php echo $reqno; ?>" id="req_no" >

      </div>

      <div class="col-sm-4 col-xs-6">

        <label for="example-text"><?php echo $this->lang->line('manual_no'); ?></label>: 

        <?php echo !empty($requistion_data[0]->rema_manualno)?$requistion_data[0]->rema_manualno:''; ?>

      </div>

      <div class="col-sm-4 col-xs-6">

        <label for="example-text"><?php echo $this->lang->line('date'); ?></label>: 

        <span class="inline_block">

        <?php echo !empty($requistion_data[0]->rema_reqdatebs)?$requistion_data[0]->rema_reqdatebs:''; ?>(BS), <?php echo !empty($requistion_data[0]->rema_reqdatead)?$requistion_data[0]->rema_reqdatead:''; ?>(AD)

        </span>

      </div>

      <div class="col-sm-4 col-xs-6">

        <label for="example-text"><?php echo $this->lang->line('from_department'); ?></label>: 

        <?php 

          $isdep=!empty($requistion_data[0]->rema_isdep)?$requistion_data[0]->rema_isdep:'';

          if($isdep=='Y')

          {

            echo !empty($requistion_data[0]->fromdepname)?$requistion_data[0]->fromdepname:'';

          }

          else

          {

             echo !empty($requistion_data[0]->fromdep_transfer)?$requistion_data[0]->fromdep_transfer:'';

          }

         ?>

      </div>

      <div class="col-sm-4 col-xs-6">

        <label for="example-text"><?php echo $this->lang->line('to_department'); ?> </label> : 

        <?php echo !empty($requistion_data[0]->todepname)?$requistion_data[0]->todepname:'';

          ?>

      </div>

<!-- 

      <div class="col-sm-4 col-xs-6">

        <label for="example-text"><?php echo $this->lang->line('is_issue'); ?> </label>: 

        <?php echo $isdep=!empty($isdep)?$isdep:''; ?>

      </div> -->

      <div class="col-sm-4 col-xs-6">

        <label for="example-text"><?php echo $this->lang->line('requisited_by'); ?> </label>: 

        <?php 

          $reqby=!empty($requistion_data[0]->rema_reqby)?$requistion_data[0]->rema_reqby:'';

          echo $reqby;

          ?>

      </div>

      <div class="col-sm-4 col-xs-6">

        <label for="example-text"><?php echo $this->lang->line('status'); ?> </label>: 

        <?php 

            $approved_status=!empty($requistion_data[0]->rema_approved)?$requistion_data[0]->rema_approved:'';

            if($approved_status==1)

            {

                echo "<span class='approved badge badge-sm badge-success'>Approved</span>"; 

            }

            else if($approved_status==2)

            {

                echo "<span class='n_approved badge badge-sm badge-info'>Unapproved</span>";

            }

            else if($approved_status==3)

            {

                echo "<span class='cancel badge badge-sm badge-danger'>Canceled</span>";

            }

            else if($approved_status==4)

            {

                echo "<span class='cancel badge badge-sm badge-success'>Verified</span>";

            }

            else

            {

                echo "<span class='pending badge badge-sm badge-warning'>Pending</span>";

            }

        ?>

      </div> 

      <div class="col-sm-4 col-xs-6">

        <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?></label>

        <?php 

            $fyear=!empty($requistion_data[0]->rema_fyear)?$requistion_data[0]->rema_fyear:'';

            echo $fyear;

        ?>

        <input type="hidden" id="fyear" value="<?php echo $fyear; ?>">

      </div>

       <div class="col-sm-4 col-xs-6">

            <label>Material Type</label>:

            <?php 

            $mattypeid=!empty($requistion_data[0]->rema_mattypeid)?$requistion_data[0]->rema_mattypeid:'';

            if(!empty($mattypeid)){

                $mat_data=$this->general->get_tbl_data('maty_material','maty_materialtype',array('maty_materialtypeid'=>$mattypeid));

                if(!empty($mat_data)){

                    echo !empty($mat_data[0]->maty_material)?$mat_data[0]->maty_material:'';

                }else{

                    echo "---";

                }

            }

            ?>

         </div>

       <div class="col-sm-4 col-xs-6">

        <label for="example-text"><?php echo $this->lang->line('location'); ?> </label>:

       <?php 

            $loca_name=!empty($requistion_data[0]->locationname)?$requistion_data[0]->locationname:'';

            echo $loca_name;

        ?>

    </div>

    </div>

     <div><a href="javascript:void(0)" class="btnSelectzero">Select zero Stock</a></div>

  </div>

  <div class="clearfix"></div> 

      <?php if(!empty($req_detail_list)) { ?>

          <table style="width:100%;" class="table dataTable con_ttl dt_alt purs_table">

              <thead>

                  <tr>

                     <th width="2%"><input type="checkbox" class="checkall"><?php echo $this->lang->line('all'); ?> </th>

                      <th width="5%"><?php echo $this->lang->line('sn'); ?> </th>

                      <th width="8%"><?php echo $this->lang->line('item_code'); ?>   </th>

                      <th width="20%"><?php echo $this->lang->line('item_name'); ?>   </th>

                      <th width="5%"><?php echo $this->lang->line('unit'); ?>   </th>

                      <th width="5%">Req. <?php echo $this->lang->line('qty'); ?>   </th>

                      <th width="5%"><?php echo $this->lang->line('rem_qty'); ?>  </th>

                      <th width="5%"><?php echo $this->lang->line('stock_quantity'); ?> </th>

                       <th width="5%"><?php echo $this->lang->line('rate'); ?> </th>

                       <th width="5%"><?php echo $this->lang->line('total_amount'); ?> </th>

                       <th width="15%"><?php echo $this->lang->line('remarks'); ?> </th>
                       <th width="15%">Approved. Qty</th>

                  </tr>

              </thead>

              <tbody>

                <?php foreach ($req_detail_list as $key => $value) { ?>

               <tr class="orderrow <?php 

                    if($value->rede_qtyinstock < $value->itli_maxlimit)

                    { 

                        if($value->rede_qtyinstock == 0)

                        {
                           echo "danger"; 
                          
                        }else{

                             echo "warning";

                        }

                    } ?>">

                   <td> <input type="checkbox" name="itemsid[]" value="<?php echo $value->rede_itemsid; ?>" class="itemcheck <?php if($value->cur_stock_qty<='0.00') echo 'stockzero'?>">
                    <input type="hidden" value="<?php echo $value->rede_reqdetailid; ?>" id="reqdetailid_<?php echo $key+1; ?>" class="reqdetailid"></td>

                  <td><?php echo $key+1; ?></td>

                  <td><?php echo $value->itli_itemcode ?></td>

                  <td><?php echo $value->itli_itemname ?></td>

                  <td><?php echo $value->unit_unitname ?></td>

                  <td><input type="hidden" id="val_reqqty_<?php echo $key+1 ?>" name="" value="<?php echo $value->rede_qty; ?>"><?php echo sprintf('%g',$value->rede_qty) ?></td>

                  <td><label id="lbl_remqty_<?php echo $key+1 ?>"><?php echo sprintf('%g',$value->rede_remqty) ?></label></td>

                  <td><?php echo sprintf('%g',$value->cur_stock_qty); ?></td>

                  <td><?php echo number_format($value->rede_unitprice,2) ?></td>

                  <td><?php echo number_format($value->rede_totalamt,2) ?></td>

                <td><?php echo $value->rede_remarks; ?></td>
                <td>
                <input type="text" class="form-control number" id="app_qty_<?php echo $key+1; ?>" style="display: none;" value="<?php if(!empty($value->rede_approvedqty)) echo $value->rede_approvedqty; ?>"  ><label id="app_qty_lbl_<?php echo $key+1; ?>"><?php if(!empty($value->rede_approvedqty)) echo $value->rede_approvedqty; ?></label>
                <a href="javascript:void(0)" class="save_qpp_qty" style="display: none;" id="save_qpp_qty_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>">Save</a>&nbsp;&nbsp;
                <a href="javascript:void(0)" class="cancel_qpp_qty" style="display: none;" id="cancel_qpp_qty_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>">Cancel</a>
                <a href="javascript:void(0)" data-id="<?php echo $key+1; ?>" class="edit_app_qty" id="edit_app_qty_<?php echo $key+1; ?>">Edit</a></td>

                </tr>

                <?php } ?>

              </tbody>

              <tfoot>
              <?php
               $purchasereqid='';

            $purchasereqno='';

            if(!empty($requistion_data)){

              $reqmasterid=!empty($requistion_data[0]->rema_reqmasterid)?$requistion_data[0]->rema_reqmasterid:'';

              $chk_reqno_from_purchase=$this->general->get_tbl_data('pure_purchasereqid,pure_reqno','pure_purchaserequisition',array('pure_reqmasterid'=>$reqmasterid));

              if(!empty($chk_reqno_from_purchase)){

                $purchasereqid=!empty($chk_reqno_from_purchase[0]->pure_purchasereqid)?$chk_reqno_from_purchase[0]->pure_purchasereqid:'';

                $purchasereqno=!empty($chk_reqno_from_purchase[0]->pure_reqno)?$chk_reqno_from_purchase[0]->pure_reqno:'';

              }

            }
              
                if($purchasereqid!=''): ?>
              <tr>
                <td colspan="12">
              <label class="text-danger">Already Send to Purchase Request. Purchase Request no is <u><?php echo $purchasereqno; ?></u></label>
                </td>
              </tr>
                <?php endif; ?>

                <tr id="processdiv" style="display: none;">

                  <td colspan="12">

                    <div class="">
                       <?php if($approved_status=='1'): 

                            if($purchasereqid==''):

                            ?>

                 <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="process_purchase">Process To Purchase</a>

              <!--    <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="central_request">Request To Central Office</a> -->

                <?php 

                   endif;

                        endif; ?>

               </div>

                  </td>

                </tr>

              </tfoot>

            </table>

      <?php } ?>

  <div class="clearfix"></div>

  <br>

  <div class="list_c2 label_mw125">

    <form id="FormChangeStatus" action="<?php echo base_url('issue_consumption/stock_requisition/change_status');?>" method="POST">

        <input type="hidden" name="masterid" value="<?php echo !empty($requistion_data[0]->rema_reqmasterid)?$requistion_data[0]->rema_reqmasterid:'';  ?>">

        <div class="form-group">

            <div class="col-ms-12">

              <div class="row">

                <div class="col-sm-3">

                    <?php

                        if(defined('TWO_LEVEL_APPROVAL')):

                            if(TWO_LEVEL_APPROVAL == 'Y'):

                                if($approved_status != 1 && $approved_status != 4){

                    ?>

                        <div class="col-sm-12">

                            <label for="example-text"><?php echo $this->lang->line('verified'); ?>  : </label>

                            <input type="radio" class="mbtm_13 cancel" name="approve_status"  value="4" id="verified">

                        </div>

                    <?php

                            }

                            endif;

                        endif;

                    ?>

                     <?php

                        if(defined('TWO_LEVEL_APPROVAL')):

                            if(TWO_LEVEL_APPROVAL == 'Y')

                                if($approved_status == 4 && $approved_status != 1):

                    ?>

                        <div class="col-sm-12">

                            <label for="example-text"><?php echo $this->lang->line('approved'); ?>  : </label>

                            <input type="radio" class="mbtm_13 cancel" name="approve_status"  value="1">

                        </div> 

                    <?php

                                endif;

                            else if($approved_status != 1):

                    ?>

                        <div class="col-sm-12">

                            <label for="example-text"><?php echo $this->lang->line('approved'); ?>  : </label>

                            <input type="radio" class="mbtm_13 cancel" name="approve_status"  value="1">

                        </div> 

                    <?php 

                            endif;

                        endif;

                    ?>

                    <?php 

                      if($approved_status == 1 && $approved_status!=2) { ?>

                    <div class="col-sm-12">

                        <label for="example-text"><?php echo $this->lang->line('unapproved'); ?> : </label>

                        <input type="radio" class="mbtm_13 cancel" name="approve_status" value="2">

                    </div>

                    <?php } if($approved_status!=3) { ?>

                    <div class="col-sm-12">

                        <label for="example-text"><?php echo $this->lang->line('canceled'); ?>  : </label>

                        <input type="radio" class="mbtm_13 cancel" name="approve_status"  value="3" id="cancel">

                    </div>

                    <?php } ?>

                </div>

                <div class="col-sm-9">

                  <div class="col-md-6 showCancel" id="cancelReason">

                    <label for="example-text"><?php echo $this->lang->line('cancel_reason'); ?>: </label><br>

                    <textarea rows="3" cols="70" name="cancel_reason"></textarea>

                  </div>

                  <div class="col-md-6 showUnapproved" id="cancelReason">

                    <label for="example-text"><?php echo $this->lang->line('unapproved_reason'); ?>: </label><br>

                    <textarea rows="3" cols="70" name="rema_unapprovedreason"></textarea>

                  </div>

                </div>

              </div>

              <div class="col-md-12">

                <!-- <label>&nbsp;</label> -->

                <button type="submit" class="btn btn-info  savelist" data-operation="save" id="btnDeptment" data-isdismiss="Y" data-isrefresh="Y"><?php echo $this->lang->line('save'); ?></button>

            </div>

            <div class="col-sm-12">

            <div  class="alert-success success"></div>

            <div class="alert-danger error"></div>

            </div>

          </div>

        </div>

    </form>

</div>

</div>  

</div>

<style>

.showCancel { display: none;}

.showUnapproved { display: none;}

</style>

<script> 

$(document).off('click','.cancel');

$(document).on('click','.cancel',function(){

    var status = $('form input[type=radio]:checked').val();

    if(status == '2')

    {

        $('.showUnapproved').show();  

    }else{

        $('.showUnapproved').hide();  

    }

    if(status == '3')

    {

        $('.showCancel').show();

    }else{

        $('.showCancel').hide();  

    }

})

</script>

<script type="text/javascript">

$(document).off('change','.checkall');

$(document).on('change','.checkall',function(e){

if (this.checked) {

        $(".itemcheck").each(function() {

            this.checked=true;

        });

        $('#processdiv').show();

    } else {

        $(".itemcheck").each(function() {

            this.checked=false;

        });

         $('#processdiv').hide();

    }

});

$(document).off('change','.itemcheck');

$(document).on('change','.itemcheck',function(e){

if (this.checked) {

        this.checked=true;

        $('#processdiv').show();

      } else {

            this.checked=false;

             $('#processdiv').hide();

    }

});

$(document).off('click','.btnSelectzero');

$(document).on('click','.btnSelectzero',function(e){

 $(this).toggleClass("select");  

 var curclassname=this.className;

  if (curclassname.indexOf('select') > -1) {

    $(".stockzero").each(function() {

            this.checked=true;

        });

    $('.btnSelectzero').text('Unselect zero Stock');

     $('#processdiv').show();

    } else {

    $(".stockzero").each(function() {

            this.checked=false;

        });

     $('#processdiv').hide();

     $('.btnSelectzero').text('Select zero Stock');

  }

});

$(document).off('click','#process_purchase');

$(document).on('click','#process_purchase',function(e){

var req_no=$('#req_no').val();

var fyear=$('#fyear').val();

var itemlist = [];

$.each($("input[name='itemsid[]']:checked"), function(){            

    itemlist.push($(this).val());

});

var redirecturl=base_url+'purchase_receive/purchase_requisition';

 $.redirectPost(redirecturl, {itemlist:itemlist,req_no:req_no,fyear:fyear});

 return false;

})

$(document).off('click','#central_request');

$(document).on('click','#central_request',function(e){

var req_no=$('#req_no').val();

var fyear=$('#fyear').val();

var itemlist = [];

$.each($("input[name='itemsid[]']:checked"), function(){            

    itemlist.push($(this).val());

});

var request_url=base_url+'handover/handover_req/handover_request_from_branch';

$.ajax({

type: "POST",

url: request_url,

data:{itemlist:itemlist,req_no:req_no,fyear:fyear},

 dataType: 'html',

 beforeSend: function() {

  $('.overlay').modal('show');

},

success: function(jsons) //we're calling the response json array 'cities'

{

   data = jQuery.parseJSON(jsons);   

    // alert(data.status);

    if(data.status=='success')

    {

    }

    else

    {

      alert(data.message);

    }

     $('.overlay').modal('hide');

}

});

})

</script>

<script type="text/javascript">
$(document).off('click','.edit_app_qty');
$(document).on('click','.edit_app_qty',function(e){
var curid=$(this).data('id');
$('#app_qty_'+curid).show();
$('#save_qpp_qty_'+curid).show();
$('#cancel_qpp_qty_'+curid).show();
$('#app_qty_lbl_'+curid).hide();
$(this).hide();
});

$(document).off('click','.save_qpp_qty');
$(document).on('click','.save_qpp_qty',function(e){
var curid = $(this).data('id'); 
var apqty = parseFloat($('#app_qty_'+curid).val());
var prev_req_qty = parseFloat($('#val_reqqty_'+curid).val());
// console.log("Approved qty:",apqty,typeof apqty);
// console.log("Prev qty:",prev_req_qty, typeof prev_req_qty);
// console.log("compare",apqty > prev_req_qty);
// return false;
if(apqty ==''){
$('#app_qty_'+curid).focus();
return false;
}

if(apqty > prev_req_qty){
alert('Couldnot Approved Qty. greater than requested qty !!');
 $('#app_qty_'+curid).focus().select();
return false;
}
var reqdetaiidval=$('#reqdetailid_'+curid).val();
var request_url=base_url+'issue_consumption/stock_requisition/save_app_qty';
$.ajax({
type: "POST",
url: request_url,
data:{reqdetaiidval:reqdetaiidval,apqty:apqty},
 dataType: 'html',
 beforeSend: function() {
  $('.overlay').modal('show');

},

success: function(jsons) //we're calling the response json array 'cities'
{
   data = jQuery.parseJSON(jsons);   
    // alert(data.status);
    if(data.status=='success'){
     $('#save_qpp_qty_'+curid).hide();
     $('#cancel_qpp_qty_'+curid).hide();
     $('#app_qty_'+curid).hide();
     $('#app_qty_lbl_'+curid).show();
     $('#app_qty_lbl_'+curid).html(apqty);
      $('#lbl_remqty_'+curid).html(apqty);
     $('#app_qty_'+curid).val(apqty);
     $('#edit_app_qty_'+curid).show();

    }else{

      alert(data.message);

    }

     $('.overlay').modal('hide');

}

});

});

$(document).off('click','.cancel_qpp_qty');
$(document).on('click','.cancel_qpp_qty',function(e){
var curid=$(this).data('id'); 
$('#save_qpp_qty_'+curid).hide();
$('#cancel_qpp_qty_'+curid).hide();
$('#app_qty_'+curid).hide();
// $('#app_qty_lbl_'+curid).html(apqty);
$('#edit_app_qty_'+curid).show();
$('#app_qty_lbl_'+curid).show();

});
</script>
