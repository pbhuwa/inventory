<style>

    .mcolor{

        background: #FF8C00 !important;

    }

</style>

<div class="form-group white-box pad-5 bg-gray">

    <div class="row">

        <div class="col-sm-4 col-xs-6">

            <label>Fiscal Year</label>: 

            <span> <?php echo !empty($assets_repair_work_order_master[0]->rewm_fiscalyrs)?$assets_repair_work_order_master[0]->rewm_fiscalyrs:''; ?></span>

        </div>

        <div class="col-sm-4 col-xs-6">

            <label>Repair Request No</label>: 

            <span> <?php echo !empty($assets_repair_work_order_master[0]->rewm_repairrequestno)?$assets_repair_work_order_master[0]->rewm_repairrequestno:''; ?></span>

        </div>

        

        <div class="col-sm-4 col-xs-6">

            <label for="example-text">Work Order No</label> : 

            <span><?php echo !empty($assets_repair_work_order_master[0]->rewm_orderno)?$assets_repair_work_order_master[0]->rewm_orderno:'0'; ?></span>

        </div>

        

        <div class="col-sm-4 col-xs-6">

            <label for="example-text">Requested Date</label>: 

            <span class="inline_block">

            <b><?php echo !empty($assets_repair_work_order_master[0]->rewm_repairorderdatebs)?$assets_repair_work_order_master[0]->rewm_repairorderdatebs:''; ?></b> BS -- <b><?php echo !empty($assets_repair_work_order_master[0]->rewm_repairorderdatead)?$assets_repair_work_order_master[0]->rewm_repairorderdatead:''; ?></b> AD

            </span>

        </div>



        <div class="col-sm-4 col-xs-6">

            <label for="example-text">Requested By</label>: 

            <span class="inline_block">

            <b><?php echo !empty($assets_repair_work_order_master[0]->rewm_requestby)?$assets_repair_work_order_master[0]->rewm_requestby:''; ?></b> 

            </span>

        </div>



           

        

       

         <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('location'); ?> </label>:

           <?php 

                $loca_name=!empty($assets_repair_work_order_master[0]->loca_name)?$assets_repair_work_order_master[0]->loca_name:'';

                echo $loca_name;

            ?>

        </div>

        <div class="col-sm-12">

            <label>Remarks</label>

            <?php echo !empty($assets_repair_work_order_master[0]->rewm_remark)?$assets_repair_work_order_master[0]->rewm_remark:'';  ?>

        </div>

        

        <div class="btn-group pull-right">

            <button class="btn btn-success PrintThisNow ReprintThis" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('ams/repair_request/reprint_repair_request') ?>" data-viewdiv="FormDiv_Reprint" data-id="<?php echo !empty($assets_repair_work_order_master[0]->rerm_repairrequestmasterid)?$assets_repair_work_order_master[0]->rerm_repairrequestmasterid:''; ?>">

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

                        <th width="15%">Estimated Cost</th>
                        <th width="15%">Prev Repair Count</th>
                        <th width="15%">Prev Repair Cost</th>
                        <th width="15%">Prev Repair Date(BS)</th>

                        <th width="25%"><?php echo $this->lang->line('remarks'); ?></th>

                    </tr>

                </thead>

                

                <tbody id="purchaseDataBody">

                    <?php 


                        if(!empty($assets_repair_work_order_detail)) { 

                            $grandtotal=0;

                            foreach ($assets_repair_work_order_detail as $key => $rrl) 

                            { 

                    ?>

                    <tr class="orderrow" id="orderrow_<?php echo $key+1 ?>" data-id='<?php echo $key+1 ?>'>

                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $rrl->asen_assetcode ?></td>
                        <td><?php echo $rrl->asen_desc ?></td>
                        <td><?php echo $rrl->rewd_problem ?></td>
                        <td><?php echo $rrl->rewd_estimated_cost ?></td>
                        <td><?php echo $rrl->rewd_prevrepaircount ?></td>
                        <td><?php echo $rrl->rewd_prevrepaircost ?></td>
                        <td><?php echo $rrl->rewd_prerepairdatebs ?></td>
                        <td><?php echo $rrl->rewd_remarks; ?></td>

                    </tr>

               <?php } ?>

                </tbody>

                    <tfoot>

                        <tr>

                    <th  colspan="6">

                        <h5 align="right" colspan="8" style="color: #333; padding-top: 0px; font-size: 12px;"><strong>Estimated Cost:</strong> <span><?php echo !empty($assets_repair_work_order_detail[0]->rewd_estmateed_cost) ? $assets_repair_work_order_detail[0]->rewd_estmateed_cost:'';  ?></span></h5>

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