<?php

$total_qty = !empty($item_details[0]->trde_requiredqty) ? (int)$item_details[0]->trde_requiredqty : 0;

$itemcode = !empty($item_details[0]->itli_itemcode) ? $item_details[0]->itli_itemcode : '';

$itemsid = !empty($item_details[0]->itli_itemlistid) ? $item_details[0]->itli_itemlistid : '';

$itemname = !empty($item_details[0]->itli_itemname) ? $item_details[0]->itli_itemname : '';

$itemname_np = !empty($item_details[0]->itli_itemnamenp) ? $item_details[0]->itli_itemnamenp : '';

$unitprice = !empty($item_details[0]->trde_unitprice) ? $item_details[0]->trde_unitprice : 0;

$unit_qty = !empty($item_details[0]->trde_requiredqty) ? $item_details[0]->trde_requiredqty : 0;



$supplier = !empty($item_details[0]->dist_distributor) ? $item_details[0]->dist_distributor : '';

$supplierid = !empty($item_details[0]->trde_supplierid) ? $item_details[0]->trde_supplierid : '';

$category = !empty($item_details[0]->eqca_category) ? $item_details[0]->eqca_category : '';

$budget_head = !empty($item_details[0]->budg_budgetname) ? $item_details[0]->budg_budgetname : '';

$budgetheadid = !empty($item_details[0]->recm_budgetid) ? $item_details[0]->recm_budgetid : '';

$catid = !empty($item_details[0]->itli_catid) ? $item_details[0]->itli_catid : '';

$trdeid = !empty($item_details[0]->trde_trdeid) ? $item_details[0]->trde_trdeid : '';

$trmaid = !empty($item_details[0]->trde_mtdid) ? $item_details[0]->trde_mtdid : '';

$schoolid = !empty($item_details[0]->recm_school) ? $item_details[0]->recm_school : '';

$supplier_billno = !empty($item_details[0]->recm_supplierbillno) ? $item_details[0]->recm_supplierbillno : '';





if (DEFAULT_DATEPICKER == 'NP') {

    $receive_date = !empty($item_details[0]->recm_receiveddatebs) ? $item_details[0]->recm_receiveddatebs : '';
} else {

    $receive_date = !empty($item_details[0]->recm_receiveddatead) ? $item_details[0]->recm_receiveddatead : '';
}

if (DEFAULT_DATEPICKER == 'NP') {

    $service_date = !empty($item_details[0]->sama_billdatebs) ? $item_details[0]->sama_billdatebs : '';
} else {

    $service_date = !empty($item_details[0]->sama_billdatead) ? $item_details[0]->sama_billdatead : '';
}

?>

<div class="white-box">

    <h3 class="box-title">Asset Sync Detail</h3>



    <div class="white-box pad-5 clearfix">



        <div id="FormDiv_PmData" class="search_pm_data">

            <ul class="pm_data pad-5 pm_data_body rowtype">

                <li class="col-sm-4">

                    <label><?php echo $this->lang->line('item_code'); ?>: </label>

                    <?php echo $itemcode; ?>

                </li>

                <li class="col-sm-4">

                    <label><?php echo $this->lang->line('item_name'); ?>: </label>

                    <?php echo $itemname; ?>

                </li>


 


                <li class="col-sm-4">

                    <label><?php echo $this->lang->line('supplier'); ?>: </label>

                    <?php echo $supplier; ?>

                </li>

                <li class="col-sm-4">

                    <label><?php echo $this->lang->line('purchase_date'); ?>: </label>

                    <?php echo $receive_date; ?>

                </li>



                <li class="col-sm-4">

                    <label>Unit Price: </label>

                    <?php echo $unitprice; ?>

                </li>

                <li class="col-sm-4">

                    <label>Purchase Qty: </label>

                    <?php echo $unit_qty; ?>

                </li>



                <li class="col-sm-4">

                    <label><?php echo $this->lang->line('category'); ?>: </label>

                    <?php echo $category; ?>

                </li>

                <li class="col-sm-4">

                    <label>Budget Head: </label>

                    <?php echo $budget_head; ?>

                </li>

                <li class="col-sm-4 col-xs-3">

                    <label>School</label>

                    <?php

                    $school_id = !empty($item_details[0]->recm_school) ? $item_details[0]->recm_school : '';

                    $school_result = $this->general->get_tbl_data('*', 'loca_location', array('loca_locationid' => $school_id), 'loca_name', 'ASC');

                    if (!empty($school_result)) {

                        echo !empty($school_result[0]->loca_name) ? $school_result[0]->loca_name : '';
                    }

                    ?>

                </li>



                <li class="col-sm-4 col-xs-3">



                    <label for="example-text">Department</label>:

                    <?php



                    $reqdepartment = !empty($item_details[0]->recm_departmentid) ? $item_details[0]->recm_departmentid : '';

                    $check_parentid = $this->general->get_tbl_data('*', 'dept_department', array('dept_depid' => $reqdepartment), 'dept_depname', 'ASC');

                    $dep_parent_dep_name = '';

                    $sub_depname = '';



                    if (!empty($check_parentid)) {

                        $dep_parentid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';

                        $dep_parent_dep_name = !empty($check_parentid[0]->dept_depname) ? $check_parentid[0]->dept_depname : '';



                        if ($dep_parentid != 0) {

                            $sub_department = $this->general->get_tbl_data('*', 'dept_department', array('dept_depid' => $dep_parentid), 'dept_depname', 'ASC');

                            if (!empty($sub_department)) {

                                $sub_depname = !empty($sub_department[0]->dept_depname) ? $sub_department[0]->dept_depname : '';
                            }
                        }
                    }



                    if (!empty($sub_depname)) {

                        echo $sub_depname . '(' . $dep_parent_dep_name . ')';

                        $dep_remarks = $sub_depname . '-' . $dep_parent_dep_name;
                    } else {

                        echo $dep_remarks = $dep_parent_dep_name;
                    }



                    ?>



                </li>



                <li class="col-sm-4">

                    <label>Received By</label>

                    <?php echo !empty($item_details[0]->recm_receivedby) ? $item_details[0]->recm_receivedby : ''; ?>

                </li>

                <?php $remark = !empty($item_details[0]->recm_remarks) ? $item_details[0]->recm_remarks : ''; ?>

                <?php if (!empty($remark)) : ?>

                    <li class="col-sm-4">

                        <?php echo $remark; ?>

                    </li>

                <?php endif; ?>

                <!-- <li class="col-sm-4">

                    <a href="javascript:void(0)" data-id="<?php echo $item_details[0]->recm_receivedmasterid ?>" data-displaydiv="" data-viewurl="<?php echo base_url() ?>purchase_receive/receive_against_order/direct_purchase_details" class="view btn-warning btn-xxs sm-pd" data-heading="Receive Ordered Items Detail">View Invoice</a>

                </li> -->
                <li class="col-sm-4">
                    <button class="btn btn-success PrintThisNow ReprintThis pull-right" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url() ?>ams/asset_sync/reprint_asset_code" data-viewdiv="AssetCode_Reprint" data-id="<?php echo $sync_id ?>">Reprint</button>
                </li>
            </ul>
        </div>
        <div class="clear"></div>
        <?php
        if (count($assets_data)) :
        ?>
            <div class="data-table" style="margin-top: 10px;"></div>
            <table class="table dataTable con_ttl dt_alt purs_table" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Asset Code</th>
                        <th>Manufacturer</th>
                        <th>Modal No</th>
                        <th>Serial No</th>
                        <th>Department</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($assets_data as $key => $asd) : ?>
                        <tr>
                            <td><?= $asd->asen_assetcode ?></td>
                            <td><?php !empty($asd->manu_manlst)?$asd->manu_manlst:''; ?></td>
                            <td><?= $asd->asen_modelno ?></td>
                            <td><?= $asd->asen_serialno ?></td>
                            <td><?= $asd->asen_depid ?></td>
                            <td><?= $asd->asen_remarks ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    </div>
<?php endif; ?>

<div id="AssetCode_Reprint" class="printTable"></div>
</div>

</div>





<script type="text/javascript">
    $(document).off('change', '#dep_type');

    $(document).on('change', '#dep_type', function() {

        var dep_type = $(this).val();

        // alert(dep_type);



        if (dep_type == '1') {



            $('.StraightLineDiv').show();

        } else {

            $('.StraightLineDiv').hide();



        }

    });
</script>