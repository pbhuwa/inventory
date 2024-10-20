<div class="form-group white-box pad-5 bg-gray">

    <div class="row">

        <div class="col-md-2 col-sm-4">

            <label for="example-text"><?php echo $this->lang->line('invoice_no'); ?> : </label>

             <span> <?php echo !empty($issue_master[0]->sama_invoiceno)?$issue_master[0]->sama_invoiceno:''; ?></span>

        </div>

        <div class="col-md-4 col-sm-4">

            <label for="example-text"><?php echo $this->lang->line('issue_date'); ?> : </label>

            <span><b><?php echo !empty($issue_master[0]->sama_billdatebs)?$issue_master[0]->sama_billdatebs:''; ?></b> <?php echo $this->lang->line('bs'); ?> -- <b><?php echo !empty($issue_master[0]->sama_billdatead)?$issue_master[0]->sama_billdatead:''; ?> </b><?php echo $this->lang->line('ad'); ?></span>

        </div>

        <div class="col-md-3 col-sm-4">

            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> : </label>

            <span><?php echo !empty($issue_master[0]->sama_fyear)?$issue_master[0]->sama_fyear:''; ?></span>

        </div>

        <div class="col-md-3 col-sm-4">

            <?php $time=!empty($issue_master[0]->sama_billtime)?$issue_master[0]->sama_billtime:''; //print_r($datedb);die;?>

              <label for="example-text"><?php echo $this->lang->line('requisition_time'); ?> : </label>

            <?php echo $time;?>

        </div>

        <div class="clearfix"></div>

        <div class="col-md-3 col-sm-4">

            <label for=""><?php echo $this->lang->line('issued_by'); ?> : </label>

             <span><?php echo !empty($issue_master[0]->sama_username)?$issue_master[0]->sama_username:''; ?></span>

        </div>

        <div class="col-md-3 col-sm-4">

            <?php $samareceivedby=!empty($issue_master[0]->sama_receivedby)?$issue_master[0]->sama_receivedby:''; ?>

            <label for="example-text"><?php echo $this->lang->line('received_by'); ?>  : </label>

            <span><?php echo $samareceivedby; ?></span>

        </div>

        <div class="col-md-3 col-sm-4">

            <?php $samarequisitionno=!empty($issue_master[0]->sama_requisitionno)?$issue_master[0]->sama_requisitionno:''; ?>

            <label for="example-text"><?php echo $this->lang->line('requisition_no'); ?> :</label>

            <span><?php echo $samarequisitionno; ?></span>

        </div>

        <div class="col-md-3 col-sm-4">

            <?php $samabillno=!empty($issue_master[0]->sama_billno)?$issue_master[0]->sama_billno:''; ?>

            <label for="example-text"><?php echo $this->lang->line('bill_no'); ?> :</label>

           <span> <?php echo $samabillno; ?></span>

        </div>

        <?php $mattypeid=!empty($issue_master[0]->sama_mattypeid)?$issue_master[0]->sama_mattypeid:'';

        if(!empty($mattypeid)): ?>

        <div class="col-md-3 col-sm-4">

            <label>Material Type</label>

            <?php

             $mat_data=$this->general->get_tbl_data('maty_material','maty_materialtype',array('maty_materialtypeid'=>$mattypeid));

                if(!empty($mat_data)){

                    echo !empty($mat_data[0]->maty_material)?$mat_data[0]->maty_material:'';

                }else{

                    echo "---";

                }

            ?>

        </div>

    <?php endif; ?>

    </div>

    <div>

         <?php   if((!empty($issue_details[0]->itli_materialtypeid) && $issue_details[0]->itli_materialtypeid=='2')): ?>

    <button  class="btn btn-success PrintThisNow printThis pull-right" data-print="print" data-viewurl="<?php echo base_url('/issue_consumption/new_issue/varpai_issue_details') ?>"  data-id="<?php echo !empty($issue_master[0]->sama_salemasterid)?$issue_master[0]->sama_salemasterid:''; ?>">Varpai Print</button>

<?php endif;?>

</div>



<?php

    if(ORGANIZATION_NAME == 'KUKL'){

?>

<button class="btn btn-success PrintThisNow ReprintThis pull-right" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('/issue_consumption/new_issue/voucher_print') ?>" data-viewdiv="FormDiv_voucher_print" data-id="<?php echo !empty($issue_master[0]->sama_salemasterid)?$issue_master[0]->sama_salemasterid:''; ?>">Voucher</button>

<?php

    }

?>



<?php 

    $is_handover=!empty($issue_master[0]->sama_ishandover)?$issue_master[0]->sama_ishandover:''; 

    // if($is_handover == 'N'):

?>

    <button class="btn btn-success PrintThisNow ReprintThis pull-right" id="btnPrintNowBtn" data-print="print" data-id="<?php echo !empty($issue_master[0]->sama_salemasterid)?$issue_master[0]->sama_salemasterid:''; ?>"><?php echo $this->lang->line('reprint'); ?></button>

<?php  
//endif; 
?>

    <div class="clearfix"></div>

</div>



<div class="form-group">

    <div class="row">

    <div class="table-responsive col-sm-12">

        <table style="width:100%;" class="table purs_table dataTable con_ttl">

            <thead>

                <tr>

                    <th width="5%"><?php echo $this->lang->line('sn'); ?> </th>

                    <th width="5%"><?php echo $this->lang->line('item_code'); ?></th>

                    <th width="15%"><?php echo $this->lang->line('item_name'); ?></th>

                    <th width="5%"><?php echo $this->lang->line('unit'); ?> </th>

                    <th width="5%"><?php echo $this->lang->line('issue_qty_short'); ?></th>

                    <th width="5%"><?php echo $this->lang->line('issue_rate_short'); ?></th>

                    <th width="10%"><?php echo $this->lang->line('issue_value_short'); ?></th>

                    <th width="5%"><?php echo $this->lang->line('return_qty_short'); ?></th>

                     <th width="5%"><?php echo $this->lang->line('return_rate_short'); ?></th>

                    <th width="10%"><?php echo $this->lang->line('return_value_short'); ?></th>

                    <th width="5%"><?php echo $this->lang->line('balance_qty_short'); ?></th>

                    <th width="10%"><?php echo $this->lang->line('balance_total_short'); ?></th>

                    <th width="10%"><?php echo $this->lang->line('remarks'); ?></th>

                    <th width="10%"><?php echo $this->lang->line('return_remarks_short'); ?></th>

                </tr>

            </thead>

            <tbody id="purchaseDataBody">

                <?php 

                    if(!empty($all_issue_details)) { 

                        $sum_issueqty = $sum_issuevalue = 0;

                        $sumissvalue=0;

                        $sumretvalue=0;



                        foreach ($all_issue_details as $key => $odr) 

                            { 

                                if(ITEM_DISPLAY_TYPE=='NP'){

                    $req_itemname = !empty($odr->itli_itemnamenp)?$odr->itli_itemnamenp:$odr->itli_itemname;

                }else{ 

                    $req_itemname = !empty($odr->itli_itemname)?$odr->itli_itemname:'';

                }

                                

                                ?>

                <tr class="orderrow" id="orderrow_1" data-id='1'>

                    <td>

                         <?php echo $key+1; ?>

                    </td> 

                    <td>

                        <?php echo $odr->itli_itemcode;?>

                    </td>

                    <td>

                        <?php echo $req_itemname; ?> 

                    </td>

                    <td>

                        <?php $unit=!empty($odr->unit_unitname)?$odr->unit_unitname:'';?> 

                        <?php echo $unit;?>

                    </td>

                    <td>

                        <?php $issqty=!empty($odr->IssQty)?$odr->IssQty:0;?> 

                        <?php echo sprintf('%g',$issqty); ?>

                    </td>

                     <td>

                        <?php $unitrate=!empty($odr->unitrate)?$odr->unitrate:0;?> 

                        <?php echo round($unitrate,2);?>

                    </td>

                    <td>

                        <?php $issuevalue=!empty($odr->IssueValue)?$odr->IssueValue:0;?> 

                        <?php echo number_format($issuevalue,2);?>

                        <?php $sumissvalue += $issuevalue;?>

                    </td>

                    <td>

                        <?php $retqty=!empty($odr->RetQty)?$odr->RetQty:0;?> 

                        <?php echo round($retqty,2);?>

                    </td>

                    <td>

                    <?php $unitrate=!empty($odr->unitrate)?$odr->unitrate:0;?> 

                        <?php echo round($unitrate,2);?>

                    </td>

                    <td>

                        <?php $returnvalue=!empty($odr->ReturnValue)?$odr->ReturnValue:0;?> 

                        <?php echo number_format($returnvalue,2);?>

                         <?php $sumretvalue += $returnvalue;?>

                    </td>

                    <td>

                        <?php $totalqty=!empty($odr->TotalIssue)?$odr->TotalIssue:0;?> 

                        <?php echo sprintf('%g',$totalqty);?>

                    </td>

                    <td>

                        <?php $totalvalue=!empty($odr->TotalValue)?$odr->TotalValue:0;?> 

                        <?php echo sprintf('%g', $totalvalue);?>

                    </td>

                    <td>

                        <?php $issue_remarks=!empty($odr->issue_remarks)?$odr->issue_remarks:'';?>

                        <?php echo $issue_remarks;?>

                    </td>

                    <td>

                        <?php $return_remarks=!empty($odr->return_remarks)?$odr->return_remarks:'';?>

                        <?php echo $return_remarks;?>

                    </td>

                </tr>

                <?php 

                        } 

                    } 

                ?>

                <tr>

                    <th colspan="6">

                        

                    </th>

                    <th><?php echo !empty($sumissvalue)?number_format($sumissvalue,2):'0.00'; ?></th>

                    <th></th>

                    <th></th>

                    <th><?php echo !empty($sumretvalue)?number_format($sumretvalue,2):'0.00'; ?></th>

                    <th></th>

                    <th>

                        <?php

                            if(!empty($sumissvalue) && !empty($sumretvalue)):  

                                $sumbalance=$sumissvalue-$sumretvalue; 

                            else:

                                $sumbalance = '0.00';

                            endif;



                            echo !empty($sumbalance)?number_format($sumbalance,2):'0.00'; ?></th>

                    <th></th>

                    <th></th>

                </tr>

            </tbody>

        </table>

        </div>

    </div>

</div>



<div id="FormDiv_Reprint" class="printTable"></div>



<div id="FormDiv_voucher_print" class="printTable"></div> 





<script>

    $(document).off('click','.ReprintThis');

    $(document).on('click','.ReprintThis',function(){

    var print =$(this).data('print');

    var iddata=$(this).data('id');

    var id=$('#id').val();



    var action = $(this).data('actionurl');

    var showdiv = $(this).data('viewdiv');



    if(action){

        printurl = action;

        printdiv = showdiv;

    }else{

        printurl = base_url+'/issue_consumption/new_issue/reprint_issue_details';

        printdiv = 'FormDiv_Reprint';

    }



    if(iddata)

    {

      id=iddata;

    }

    else

    {

      id=id;

    }

    $.ajax({

        type: "POST",

        url:  printurl,

        data:{id:id},

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

                $('#'+printdiv).html(data.tempform);

                $('.printTable').printThis();

            }

            else

            {

              alert(data.message);

            }

            setTimeout(function(){

                $('.newPrintSection').hide();

                

                $('#myView').modal('hide');

            },2000);

            $('.overlay').modal('hide');

        }

      });

    })

</script>



<script>

    $(document).off('click','.printThis');

    $(document).on('click','.printThis',function(){

    var print =$(this).data('print');

    var iddata=$(this).data('id');

    var id=$('#id').val();

    if(iddata)

    {

      id=iddata;

    }

    else

    {

      id=id;

    }

    $.ajax({

        type: "POST",

        url:  base_url+'/issue_consumption/new_issue/varpai_issue_details',

        data:{id:id},

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

                $('#FormDiv_Reprint').html(data.tempform);

                $('.printTable').printThis();

            }

            else

            {

              alert(data.message);

            }

            setTimeout(function(){

                $('.newPrintSection').hide();

                

                $('#myView').modal('hide');

            },2000);

            $('.overlay').modal('hide');

        }

      });

    })

</script>