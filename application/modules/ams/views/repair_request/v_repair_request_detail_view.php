<style>

    .mcolor{

        background: #FF8C00 !important;

    }

</style>

<div class="form-group white-box pad-5 bg-gray">

    <div class="row">

        <div class="col-sm-4 col-xs-6">

            <label>Fiscal Year</label>: 

            <span> <?php echo !empty($assets_repair_request_master[0]->rerm_fiscalyrs)?$assets_repair_request_master[0]->rerm_fiscalyrs:''; ?></span>

        </div>

        <div class="col-sm-4 col-xs-6">

            <label>Repair Request No</label>: 

            <span> <?php echo !empty($assets_repair_request_master[0]->rerm_requestno)?$assets_repair_request_master[0]->rerm_requestno:''; ?></span>

        </div>

        

        <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('manual_no'); ?></label> : 

            <span><?php echo !empty($assets_repair_request_master[0]->rerm_manualno)?$assets_repair_request_master[0]->rerm_manualno:'0'; ?></span>

        </div>

        

        <div class="col-sm-4 col-xs-6">

            <label for="example-text">Requested Date</label>: 

            <span class="inline_block">

            <b><?php echo !empty($assets_repair_request_master[0]->rerm_requestdatebs)?$assets_repair_request_master[0]->rerm_requestdatebs:''; ?></b> BS -- <b><?php echo !empty($assets_repair_request_master[0]->rerm_requestdatead)?$assets_repair_request_master[0]->rerm_requestdatead:''; ?></b> AD

            </span>

        </div>



        <div class="col-sm-4 col-xs-6">

            <label for="example-text">Requested By</label>: 

            <span class="inline_block">

            <b><?php echo !empty($assets_repair_request_master[0]->rerm_requestby)?$assets_repair_request_master[0]->rerm_requestby:''; ?></b> 

            </span>

        </div>



           <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('status'); ?> </label>: 

            <span>

                <?php 

                    $approved_status=!empty($assets_repair_request_master[0]->rerm_approved)?$assets_repair_request_master[0]->rerm_approved:'';

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

            <label for="example-text"><?php echo $this->lang->line('location'); ?> </label>:

           <?php 

                $loca_name=!empty($assets_repair_request_master[0]->loca_name)?$assets_repair_request_master[0]->loca_name:'';

                echo $loca_name;

            ?>

        </div>

        <div class="col-sm-12">

            <label>Remarks</label>

            <?php echo !empty($assets_repair_request_master[0]->rerm_remark)?$assets_repair_request_master[0]->rerm_remark:'';  ?>

        </div>

        

        <div class="btn-group pull-right">

            <button class="btn btn-success PrintThisNow ReprintThis" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('ams/repair_request/reprint_repair_request') ?>" data-viewdiv="FormDiv_Reprint" data-id="<?php echo !empty($assets_repair_request_master[0]->rerm_repairrequestmasterid)?$assets_repair_request_master[0]->rerm_repairrequestmasterid:''; ?>">

               Reprint

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

                        <th width="20%">Asset Code</th>

                        <th width="25%">Descrition</th>

                        <th width="15%">Problem</th>

                        <th width="15%">Repair Status</th>

                        <th width="25%"><?php echo $this->lang->line('remarks'); ?></th>

                    </tr>

                </thead>

                

                <tbody id="purchaseDataBody">

                    <?php 

                    // echo "<pre>";

                    // print_r($stock_requisition);

                    // die();

                        if(!empty($assets_repair_request_detail)) { 

                            $grandtotal=0;

                            foreach ($assets_repair_request_detail as $key => $rrl) 

                            { 

                               //WR=Wait for Repair,RS=Repair Starting,RC=Repair Completed,UR=Unrepaired

                            $repaire_status=$rrl->rerd_repairedstatus;

                            if($repaire_status=='WR'){

                                $rstatus='Wait For Repair';

                            }else if ($repaire_status=='WR') {

                                 $rstatus='Repair Starting';

                            }

                            else if ($repaire_status=='RC') {

                                 $rstatus='Repair Completed';

                            }

                            else if ($repaire_status=='UR') {

                                 $rstatus='Unrepaired';

                            }

                    ?>

                    <tr class="orderrow" id="orderrow_<?php echo $key+1 ?>" data-id='<?php echo $key+1 ?>'>

                        <td><?php echo $key+1; ?></td>

                        <td><?php echo $rrl->asen_assetcode ?></td>

                        <td><?php echo $rrl->asen_desc ?></td>

                        <td><?php echo $rrl->rerd_problem ?></td>

                       <!--  <td align="right">

                        <input type="text" name="" value="<?php echo "0.00" ?>">

                        </td>

                        <td align="right"><input type="text" name="" value=""></td> -->

                        <td><?php echo $rstatus; ?></td>

                        <td><?php echo $rrl->rerd_remark; ?></td>

                    </tr>

               <?php } ?>

                </tbody>

                    <tfoot>

                        <tr>

                    <th  colspan="6">

                        <h5 align="right" colspan="8" style="color: #333; padding-top: 0px; font-size: 12px;"><strong>Estimated Cost:</strong> <span><?php echo !empty($assets_repair_request_master[0]->rerm_estmatecost) ? $assets_repair_request_master[0]->rerm_estmatecost:'';  ?></span></h5>

                        <td align="right" style="color: #333; padding-top: 22px; font-size: 13px;"><strong>

                           </strong>

                        </td>

                    </th>

                </tr>

              

            </tfoot>

        <?php } ?>

                

            </table>

        </div>

    </div>

</div>

<div id="FormDiv_Reprint" class="printTable"></div>    