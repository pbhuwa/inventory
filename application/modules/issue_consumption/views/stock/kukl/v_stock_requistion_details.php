<style>

    .mcolor{

        background: #FF8C00 !important;

    }

</style>

<?php 

    $it_view_group = array('IT','PR','DS','SK','SI','SA');

    $recommend_status = !empty($stock_requisition_details[0]->rema_recommendstatus)?$stock_requisition_details[0]->rema_recommendstatus:''; 

    $it_recommend_status = !empty($stock_requisition_details[0]->rema_itstatus)?$stock_requisition_details[0]->rema_itstatus:''; 

    $it_status_readonly = 'readonly="readonly"';

    $it_status_disabled = 'disabled="disabled"';

    if($it_recommend_status == 1){

        $it_status_readonly = '';

        $it_status_disabled = '';

    }

    $rema_reqmasterid = !empty($stock_requisition_details[0]->rema_reqmasterid)?$stock_requisition_details[0]->rema_reqmasterid:'';

    $rema_reqby = !empty($stock_requisition_details[0]->rema_reqby)?$stock_requisition_details[0]->rema_reqby:'';

    $rema_fyear = !empty($stock_requisition_details[0]->rema_fyear)?$stock_requisition_details[0]->rema_fyear:'';

    $rema_reqno = !empty($stock_requisition_details[0]->rema_reqno)?$stock_requisition_details[0]->rema_reqno:'';
    $rema_reqto = !empty($stock_requisition_details[0]->rema_reqto)?$stock_requisition_details[0]->rema_reqto:'';

$req_to_name='';
if(!empty($rema_reqto)){
    $reqto_result=$this->db->select('usma_fullname')->from('usma_usermain')->where_in('usma_userid',$rema_reqto)->get()->result();
    if(!empty($reqto_result)){
        foreach ($reqto_result as $krq => $ruser) {
            $req_to_name .= $ruser->usma_fullname.',';
        }
    }
    $req_to_name =rtrim($req_to_name, ',');
}

?>

<div class="form-group white-box pad-5 bg-gray">

    <div class="row">

        <div class="col-sm-4 col-xs-6">

            <label><?php echo $this->lang->line('requisition_no'); ?></label>: 

            <span> <?php echo $rema_reqno; ?></span>

        </div>

        <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('manual_no'); ?></label> : 

            <span><?php echo !empty($stock_requisition_details[0]->rema_manualno)?$stock_requisition_details[0]->rema_manualno:'0'; ?></span>

        </div>

        <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('req_date'); ?></label>: 

            <span class="inline_block">

                <b><?php echo !empty($stock_requisition_details[0]->rema_reqdatebs)?$stock_requisition_details[0]->rema_reqdatebs:''; ?></b> BS -- <b><?php echo !empty($stock_requisition_details[0]->rema_reqdatead)?$stock_requisition_details[0]->rema_reqdatead:''; ?></b> AD

            </span>

        </div>

        <div class="col-sm-4 col-xs-6">

            <label for="example-text">From</label>: 

            <span>

                <?php 

                $isdep=!empty($stock_requisition_details[0]->rema_isdep)?$stock_requisition_details[0]->rema_isdep:'';

                if($isdep=='Y')

                {

                    echo !empty($stock_requisition_details[0]->fromdepname)?$stock_requisition_details[0]->fromdepname:'';

                }

                else

                {

                    echo !empty($stock_requisition_details[0]->fromdep_transfer)?$stock_requisition_details[0]->fromdep_transfer:'';

                }

                ?>

            </span>

        </div>

        <div class="col-sm-4 col-xs-6">

            <label for="example-text">Requested To </label> : 

            <span> <?php echo $req_to_name;

            ?></span>

        </div>

  <!--       <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('is_issue'); ?> </label>: 

            <span><?php echo $isdep=!empty($isdep)?$isdep:''; ?></span>

        </div> -->

        <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('requisited_by'); ?> </label>: 

            <span><?php 

            $reqby=$rema_reqby;

            echo $reqby;

            ?></span>

        </div>

        <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> </label>:

            <?php 

            $remafyear=$rema_fyear;

            echo $remafyear;

            ?>

        </div>

        <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('location'); ?> </label>:

            <?php 

            $loca_name=!empty($stock_requisition_details[0]->locationname)?$stock_requisition_details[0]->locationname:'';

            echo $loca_name;

            ?>

        </div>

        <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('work_description'); ?> </label>:

            <?php 

            $work_description=!empty($stock_requisition_details[0]->rema_workdesc)?$stock_requisition_details[0]->rema_workdesc:'';

            echo $work_description;

            ?>

        </div>

        <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('work_place'); ?> </label>:

            <?php 

            $workplace=!empty($stock_requisition_details[0]->rema_workplace)?$stock_requisition_details[0]->rema_workplace:'';

            echo $workplace;

            ?>

        </div>

        <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('full_remarks'); ?> </label>:

            <?php 

            $work_remask=!empty($stock_requisition_details[0]->rema_remarks)?$stock_requisition_details[0]->rema_remarks:'';

            echo $work_remask;

            ?>

        </div>

        <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('status'); ?> </label>: 

            <span>

                <?php 

                $approved_status=!empty($stock_requisition_details[0]->rema_approved)?$stock_requisition_details[0]->rema_approved:'';

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

                    echo "<span class='cancel badge badge-sm badge-info'>Verified</span>";

                }

                else

                {

                    echo "<span class='pending badge badge-sm badge-warning'>Pending</span>";

                }

                ?>

            </span>

        </div> 

        <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('item_remarks'); ?> </label>:

            <?php 

                if(!empty($mat_type)){

                    foreach ($mat_type as $km => $mat){

                        $stock_requisition= $this->stock_requisition_mdl->get_requisition_details_data(array('rd.rede_reqmasterid'=>$rede_reqmasterid,'it.itli_materialtypeid'=>$mat->maty_materialtypeid, 'rd.rede_isdelete' => 'N'),$store_id);

                        if($stock_requisition)

                        {

                            $remarks='';

                            foreach ($stock_requisition as $km => $det) {

                                $remarks.= !empty($det->rede_remarks) ? $det->rede_remarks.' , ' : '';   

                            }
                            $remarks = substr($remarks,0,-2); 
                            echo $remarks; 

                        }

                    }

                }

            ?>

        </div>

        <div class="btn-group pull-right">

            <?php

                if(ORGANIZATION_NAME == 'KUKL'):

            ?>

            <button class="btn btn-info" id="btnHistory" data-actionurl="<?php echo base_url('/issue_consumption/stock_requisition/stock_requisition_reprint') ?>" data-id="<?php echo $rema_reqmasterid; ?>" data-reqno="<?php echo $rema_reqno;?>" data-fyear="<?php echo $rema_fyear ?>" data-heading="History">

               History

            </button>

            <?php

                endif;

            ?>

            <button class="btn btn-success PrintThisNow ReprintThis" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('/issue_consumption/stock_requisition/stock_requisition_reprint') ?>" data-viewdiv="FormDiv_Reprint" data-id="<?php echo $rema_reqmasterid; ?>" data-breakpage="true">

                <?php echo $this->lang->line('print'); ?>

            </button>

        </div>

    </div>

</div> 

<div class="form-group">

    <div class="row">

        <div class="table-responsive col-sm-12">

            <table style="width:100%;" class="table purs_table dataTable con_ttl">

                <thead>

                    <tr>

                        <th width="5%"><?php echo $this->lang->line('sn'); ?> </th>

                        <th width="8%"><?php echo $this->lang->line('item_code'); ?> </th>

                        <th width="15%"><?php echo $this->lang->line('item_name'); ?> </th>

                        <th width="5%"><?php echo $this->lang->line('unit'); ?> </th>

                        <th width="4%"><?php echo $this->lang->line('req_qty'); ?> </th>

                        <th width="4%"><?php echo $this->lang->line('rem_qty'); ?> </th>

                        <th width="4%"><?php echo $this->lang->line('recommend_qty'); ?> </th>

                        <?php

                            if($this->usergroup != 'IT'):

                        ?>

                            <th width="5%"><?php echo $this->lang->line('rate'); ?></th>

                            <th width="5%"><?php echo $this->lang->line('total_amt'); ?></th>

                        <?php

                            endif;

                        ?>

                        <?php

                            if(in_array($this->usergroup, $it_view_group)):

                                ?>

                                <th width="10%"><?php echo $this->lang->line('it_recommend'); ?></th>

                                <th width="10%"><?php echo $this->lang->line('it_remarks'); ?></th>

                                <?php

                            endif;

                        ?>

                        <th width="10%"><?php echo $this->lang->line('remarks'); ?></th> 

                    </tr>

                </thead> 

                <tbody>

                    <?php

                        if(!empty($mat_type)):

                    // echo "<pre>";

                    // print_r($mat_type);

                    // die();

                        $i = 1;

                        foreach ($mat_type as $km => $mat):

                         if($this->usergroup == 'IT'){

                            $stock_requisition= $this->stock_requisition_mdl->get_requisition_details_data(array('rd.rede_reqmasterid'=>$rede_reqmasterid,'it.itli_materialtypeid'=>$mat->maty_materialtypeid, 'rd.rede_isdelete' => 'N', 'ec.eqca_isitdep'=>'Y'),$store_id);

                        }else{

                           $stock_requisition= $this->stock_requisition_mdl->get_requisition_details_data(array('rd.rede_reqmasterid'=>$rede_reqmasterid,'it.itli_materialtypeid'=>$mat->maty_materialtypeid, 'rd.rede_isdelete' => 'N'),$store_id);

                       }

                    // echo $this->db->last_query();

                    // die();

                        if(!empty($stock_requisition)) { 

                    ?>

                        <tr>

                           <td colspan="9">

                            <strong><?php echo $mat->maty_material; ?></strong>

                        </td>

                    </tr>

                    <?php

                        $grandtotal=0;

                        $j = 1;

                        foreach ($stock_requisition as $key => $odr){ 

                            if(ITEM_DISPLAY_TYPE=='NP'){

                                $req_itemname = !empty($odr->itli_itemnamenp)?$odr->itli_itemnamenp:$odr->itli_itemname;

                            }else{ 

                                $req_itemname = !empty($odr->itli_itemname)?$odr->itli_itemname:'';

                            }

                    ?> 

                        <tr class="orderrow <?php 

                        if($odr->cur_stock_qty < $odr->itli_maxlimit && ($this->session->userdata(USER_GROUPCODE) == 'SI'))

                        { 

                            // if($odr->cur_stock_qty == 0)

                            // {

                            //     echo "danger";

                            // }else{

                            //     echo "warning"; 

                            // }

                            if($odr->cur_stock_qty <= '0.00'):

                            echo "danger";

                            elseif($odr->rede_remqty > $odr->cur_stock_qty):

                            echo "danger";

                            elseif($odr->rede_remqty <= $odr->cur_stock_qty):

                            echo "";

                            else:

                            echo "";

                            endif;

                        } ?>" id="orderrow_1" data-id='1'>

                        <td><?php echo $key+1; ?></td>

                        <td><?php echo $odr->itli_itemcode ?></td>

                        <td><?php echo $req_itemname ?></td>

                        <td><?php echo $odr->unit_unitname ?></td>

                        <td align="right"><?php echo sprintf('%g',$odr->rede_qty); ?></td>

                        <td align="right"><?php echo sprintf('%g',$odr->rede_remqty); ?></td>

                        <td align="right">

                            <?php $rec_qty= !empty($odr->rede_recommendqty)?$odr->rede_recommendqty:0; 
                            echo sprintf('%g',$rec_qty); 

                            ?>

                            <input type="hidden" name="recommend_qty[]" class="recommend_qty" value="<?php echo sprintf('%g',$rec_qty); ?>" />

                            <input type="hidden" value="<?php echo $odr->rede_itemsid; ?>" name="items_id[]" class="items_id" />

                        </td>

                        <?php

                        if($this->usergroup != 'IT'):

                            ?>

                            <td align="right"><?php echo $odr->rede_unitprice ?></td>

                            <td align="right">
                                <?php 
                                $total_amount = !empty($odr->total_estimate_amount) ? $odr->total_estimate_amount : $odr->rede_totalamt;  
                                echo number_format($total_amount,2)

                                ?>        
                            </td>

                            <?php

                        endif;

                        ?>

                        <!-- IT start -->

                        <?php

                        if(in_array($this->usergroup, $it_view_group)):

                            ?>

                            <td width="15%">

                             <?php 

                             $it_recommend_val = $odr->rede_itrecommend; 

                             if($it_recommend_val == '1'){

                               echo "Recommended";

                           }

                           if($it_recommend_val == '2'){

                               echo "Not Recommended";

                           }

                           if($it_recommend_val == '3'){

                               echo "Partial";

                           }

                           ?>   

                       </td>

                       <td width="10%">

                         <?php echo $odr->rede_itcomment; ?>

                     </td>

                     <?php

                 endif;

                 ?>

                 <!-- IT end -->

                   <!--      <?php

                            if($this->usergroup == 'PR'):

                        ?>

                        <td>

                            <?php

                                echo ($odr->rede_itrecommend == '1')?'Recommend':'';

                                echo ($odr->rede_itrecommend == '2')?'Not Recommend':'';

                                echo ($odr->rede_itrecommend == '3')?'Partial':'';

                            ?>

                        </td>

                        <td>

                            <?php echo $odr->rede_itcomment;?>

                        </td>

                        <?php

                            endif;

                            ?> -->

                           <td align="right"><?php echo $odr->rede_remarks ?></td>

                        </tr>

                        <?php

                        $grandtotal +=$total_amount; 

                        $j++;

                    } 

                } 

                ?>

                <?php

                    // echo "<pre>";

                    // print_r($stock_requisition);

                    // die();

                $i++;

            endforeach;

        endif;

        ?>

            </tbody>

        <?php

        if(in_array($this->usergroup, array('SA','AO'))):

            ?>

            <tfoot>

                <tr>

                    <th colspan="8">

                        <h5 align="right" style="color: #333; padding-top: 0px; font-size: 12px;"><strong><?php echo $this->lang->line('estimate_cost') ;?>:</strong></h5>

                    </th>

                    <th align="right" style="color: #333; padding-top: 22px; font-size: 13px;"><strong>

                            <?php echo !empty($grandtotal)?number_format($grandtotal,2):0; ?></strong>

                        </th>

                    <!-- <th></th>

                    <th></th> -->

                </tr>

                <tr>

                    <td colspan="9"><strong><?php echo $this->lang->line('in_words'); ?>: <?php echo !empty($grandtotal)?$this->general->number_to_word($grandtotal):''; ?></strong></td>

                </tr>

            </tfoot>

            <?php

        endif;

        ?>

    </table>

</div>

</div>

</div>

<?php

    $userid=$this->session->userdata(USER_ID);

    $postid= !empty($stock_requisition_details[0]->rema_postby)?$stock_requisition_details[0]->rema_postby:'';

    if($this->session->userdata(USER_GROUPCODE) == 'DM' || $userid == $postid):

        if(!empty($recommend_status) && ($recommend_status != 'A' && $recommend_status != 'D')):

            ?>

            <div class="col-sm-12">

                <label>Choose Recommendation</label>

                <br/>

                <input type="radio" class="mbtm_13 recommendation" name="recommendation" value="A" id="accept">

                Accept

                <input type="radio" class="mbtm_13 recommendation" name="recommendation" value="D" id="decline">

                Decline

                <br/>

                <a id="btnAcceptRecommend" href="javascript:void(0)" class="btn btn-primary">

                Save</a>

            </div>  

        <?php

        endif;

    endif;

?>

<!-- demand confirm start -->

<?php 

    $rema_received=!empty($stock_requisition_details[0]->rema_received)?$stock_requisition_details[0]->rema_received:'';

    if (!empty($is_issued)) {

        if($userid== $postid ){ 

            if($rema_received == '0' ){ ?>

            <div class="col-sm-12">

                <label>The demanded item has been issued. Please confirm it.</label>

                <br/>

                <button style="margin-right: 5px;" class="btn btn-success btnConfirmreceive" data-print="print" data-viewurl="<?php echo base_url('/issue_consumption/stock_requisition/confirm_demand_item_receive') ?>"  data-id="<?php echo $rema_reqno; ?>" data-type='Confirm'  data-fyear="<?php echo $rema_fyear; ?>">

                    Confirm

                </button>

            <?php }else ?>

            <?php {?>

                <span  class="text-success">Issue of demanded item has been confirmed.</span>

            </div>  

      <?php  } }  } ?>

<!-- demand confirm end -->

<div class="col-sm-12">

    <div  class="alert-success success"></div>

    <div class="alert-danger error"></div>

</div>

<div id="FormDiv_Reprint" class="printTable"></div> 

<script type="text/javascript">

    $(document).off('click','#btnAcceptRecommend');

    $(document).on('click','#btnAcceptRecommend',function(){

        var all_recommend_qty = [];

        var all_items_id = [];

        $(".recommend_qty").each(function() {

            all_recommend_qty.push($(this).val());

        });

        $(".items_id").each(function() {

            all_items_id.push($(this).val());

        });

        var recommendation_status = $('.recommendation:checked').val();

        var rema_reqmasterid = '<?php echo $rema_reqmasterid;  ?>';

        var rema_reqno = '<?php echo $rema_reqno;  ?>';

        var submitData = {all_recommend_qty:all_recommend_qty, all_items_id:all_items_id, rema_reqmasterid: rema_reqmasterid, recommendation_status:recommendation_status, rema_reqno:rema_reqno };

        beforeSend= $('.overlay').modal('show');

        var submitUrl = base_url+'issue_consumption/stock_requisition/verify_recommend_qty';

        ajaxPostSubmit(submitUrl, submitData, beforeSend='',onSuccess);

        function onSuccess(response){

            data = jQuery.parseJSON(response);   

            if(data.status=='success'){

                $('.success').html(data.message);

                $('.success').show();

            }else{

                $('.error').html(data.message);

                $('.error').show();

            }

            $('.overlay').modal('hide');

            setTimeout(function(){

                $('#myView').modal('hide');

            },1000);

        }

    });

</script>

<script>

    $(document).off('click','.btnConfirmreceive');

    $(document).on('click','.btnConfirmreceive',function(){

        // alert('afsdfsa');

        var id=$(this).data('id');

        var type=$(this).data('type');

        var url=$(this).data('viewurl');

        var fiscal_year = $(this).data('fyear');

        var conf = confirm('Are You Want to Sure to ' +type+' Item?');

        if(conf){

            $.ajax({

                type: "POST",

                url: url,

                data:{id:id,fiscal_year:fiscal_year},

                dataType: 'html',

                beforeSend: function() {

                    $('.overlay').modal('show');

                },

                success: function(jsons){

                    data = jQuery.parseJSON(jsons);   

                    if(data.status=='success'){

                        $('.success').html(data.message);

                        $('.success').show();

                    }else{

                        $('.error').html(data.message);

                        $('.error').show();

                    }

                    $('.overlay').modal('hide');

                    setTimeout(function(){

                        $('.success').hide();

                    },1000);

                }

            })

        }

    });

    $(document).off('click','#btnHistory');

   $(document).on('click','#btnHistory',function(e){

      var id=$(this).data('id');

      var reqno = $(this).data('reqno');

      var fyear = $(this).data('fyear');

      // console.log(itemlist);

      var action=base_url+'issue_consumption/stock_requisition/check_history';

      var heading=$(this).data('heading');

      $('#myView2').modal('show');

      $('#MdlLabel2').html(heading);

      // return false;

      $.ajax({

         type: "POST",

         url: action,

         data:{id:id, reqno:reqno, fyear:fyear},

         dataType: 'html',

         beforeSend: function() {

            $('.overlay').modal('show');

         },

         success: function(jsons) 

         {

            data = jQuery.parseJSON(jsons);   

         // alert(data.status);

            if(data.status=='success'){

               console.log(data.tempform);

               $('.displyblock2').html(data.tempform);

            }  

            else{

               alert(data.message);

            }

            $('.overlay').modal('hide');

         }

      });

      return false;

   })

</script>