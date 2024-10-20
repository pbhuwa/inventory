<style>
    .modal table.dataTable{
        margin-bottom: 20px;
    }
</style>
<?php
    if(!empty($challans)):
        foreach($challans as $key=>$cdata):
        $challanmasterid = $cdata->chma_challanmasterid;
?>
    <div>
        <div class="form-group white-box pad-5 bg-gray clearfix">
            <div class="col-md-3">
                <label><?php echo $this->lang->line('order_no'); ?> : </label>
                <span> <?php echo !empty($challans[0]->chma_puorid)?$challans[0]->chma_puorid:'';  ?></span>
            </div>

            <div class="col-md-3">
                <label><?php echo $this->lang->line('fiscal_year'); ?>:</label>
                <span>
                    <?php 
                        echo $challans[0]->chma_fyear;
                    ?>
                </span>
            </div>

            <div class="col-md-3">
                <label>Challan Receive No. : </label>
                <span> <?php echo !empty($cdata->chma_challanrecno)?$cdata->chma_challanrecno:''; ?></span>
            </div>


            <div class="col-md-3">
                <label>Challan Receive Date : </label>
                <span>
                <?php 
                    if(DEFAULT_DATEPICKER=='NP'){
                        echo $cdata->chma_receivedatebs;
                    } else {
                        echo $cdata->chma_receivedatead;
                    } 
                ?>
                </span>
            </div>

            <div class="col-md-3">
                <label>Supplier Challan No. : </label>
                <span> <?php echo !empty($cdata->chma_suchallanno)?$cdata->chma_suchallanno:'';?></span>
            </div>


            <div class="col-md-3">
                <label>Supplier Challan Date : </label>
                <span>
                <?php 
                    if(DEFAULT_DATEPICKER=='NP'){
                        echo $cdata->chma_challanrecdatebs;
                    } else {
                        echo $cdata->chma_challanrecdatead;
                    } 
                ?>
                </span>
            </div>
            
            <div class="margin-top-25"></div>

            <div class="col-md-6">
                <label><?php echo $this->lang->line('supplier_name'); ?> : </label>
                <span><?php echo  !empty($challans[0]->dist_distributor)?$challans[0]->dist_distributor:''; ?></span>
            </div>
            
            <button class="btn btn-success PrintThisNow ReprintThis pull-right" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('/issue_consumption/challan/reprint_challan_details') ?>" data-viewdiv="FormDiv_Reprint" data-id="<?php echo !empty($cdata->chma_challanmasterid)?$cdata->chma_challanmasterid:''; ?>"><?php echo $this->lang->line('reprint'); ?></button>
        </div>
    </div>

    <div class="clearfix"></div> 
    <div class="data-table" style="margin-top: 0px;">
        <?php
            $chalan_details = $this->challan_mdl->chalandetails(array('chma_challanmasterid'=>$challanmasterid)); 

            if($chalan_details) { ?>
                <table style="width:100%;" class="table dataTable con_ttl dt_alt purs_table">
                    <thead>
                        <tr>
                            <th width="5%"> <?php echo $this->lang->line('sn'); ?> </th>
                            <th width="10%"> <?php echo $this->lang->line('item_code'); ?> </th>
                            <th width="30%"> <?php echo $this->lang->line('item_name'); ?> </th>
                            <th width="5%"> <?php echo $this->lang->line('unit'); ?></th>
                            <th width="5%"> <?php echo $this->lang->line('qty'); ?></th>
                            <th>Sup Challan No</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    <?php if($chalan_details){  //echo"<pre>"; print_r($chalan_details);die;
                        foreach ($chalan_details as $key => $value) 
                        {
                            if(ITEM_DISPLAY_TYPE=='NP'){
                            $req_itemname = !empty($value->itli_itemnamenp)?$value->itli_itemnamenp:$value->itli_itemname;
                        }else{ 
                            $req_itemname = !empty($value->itli_itemname)?$value->itli_itemname:'';
                        }
                         ?>
                        <tr>
                            <td><?php echo $key+1; ?></td>
                            <td><?php echo $value->itli_itemcode; ?></td>
                            <td><?php echo $req_itemname; ?></td>
                            <td></td>
                            <td><?php echo $value->chde_qty; ?></td>
                            <td><?php echo $value->chma_challanrecno; ?></td>
                            <td><?php echo $value->chde_remarks; ?></td>
                        </tr> 
                        <?php } } ?>
                    </tbody>
                </table>
            <?php } ?>
    </div>
    <div class="clearfix"></div>

    <?php
        endforeach;
    endif;
    ?>

<div id="FormDiv_Reprint" class="printTable"></div> 