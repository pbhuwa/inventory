<div class="list_c2 label_mw125">
    <?php
    $masterid = !empty($work_order_master[0]->woma_womasterid) ? $work_order_master[0]->woma_womasterid : '';
    $workorderstatus = !empty($work_order_master[0]->woma_workorderstatus) ? $work_order_master[0]->woma_workorderstatus : '';
    ?>
    <!-- <form id="FormChangeStatus" action="<?php //echo base_url('ams/workorder/change_status'); 
                                                ?>" method="POST">
        <input type="hidden" name="masterid" value="<?php //echo $masterid;  
                                                    ?>"> -->
    <ul class="nav nav-tabs form-tabs" id="nav-tab" role="tablist">
        <li class="tab-selector active"><a class="nav-item nav-link active" id="work-order" data-toggle="tab" href="#work_order" role="tab" aria-controls="work_order" aria-selected="true">Work Order</a></li>
        <li class="tab-selector"><a class="nav-item nav-link" id="measure-tab" data-toggle="tab" href="#work_measure" role="tab" aria-controls="work_measure" aria-selected="false">Measurement</a></li>
        <li class="tab-selector"><a class="nav-item nav-link" id="contract-bill-tab" data-toggle="tab" href="#contract-bill" role="tab" aria-controls="contract-bill" aria-selected="false">Contract Bill</a></li>
        <li class="tab-selector"><a class="nav-item nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false">Payment</a></li>
        <li class="tab-selector"><a class="nav-item nav-link" id="completion-tab" data-toggle="tab" href="#completion" role="tab" aria-controls="completion" aria-selected="false">Completion Certificate</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="work_order" role="tabpanel" aria-labelledby="work-order">
            <form id="FormChangeStatus" action="<?php echo base_url('ams/workorder/change_status'); ?>" method="POST">
                <input type="hidden" name="masterid" value="<?php echo $masterid;  ?>">
                <div class="form-group">
                    <div class="col-ms-12">
                        <div class="row">

                            <?php if ($workorderstatus == 'ES') : ?>

                                <div class="col-sm-2">

                                    <label>Is Work Order?</label>

                                    <select name="woma_isworkorder" class="form-control" id="isworkorder">

                                        <option value="N">No</option>

                                        <option value="Y">Yes</option>

                                    </select>

                                </div>

                                <?php

                                if (DEFAULT_DATEPICKER == 'NP') {

                                    $work_orderdate = !empty($work_order_master[0]->woma_wodatebs) ? $work_order_master[0]->woma_wodatebs : DISPLAY_DATE;
                                } else {

                                    $work_orderdate = !empty($work_order_master[0]->woma_wodatead) ? $work_order_master[0]->woma_wodatead : DISPLAY_DATE;
                                }

                                ?>

                                <div class="col-sm-2 displayblock" style="display: none">

                                    <label>Order Date :</label>

                                    <input type="text" name="wodate" class="form-control required_field <?php echo DATEPICKER_CLASS; ?>" id="wodate" value="<?php echo $work_orderdate; ?>">

                                </div>

                                <div class="col-sm-2 displayblock" style="display: none">

                                    <label>Date to be completed: </label>

                                    <input type="text" name="woma_tobecomdate" class="form-control required_field <?php echo DATEPICKER_CLASS; ?>" id="woma_tobecomdate" value="<?php echo $work_orderdate; ?>">

                                </div>

                                <input type="hidden" name="woma_workorderstatus" value="WO">

                                <div class="col-sm-2 displayblock" style="display: none">

                                    <label>Work Order Attachment</label>

                                    <input type="file" name="work_order_attachment">

                                </div>
                                <div class="col-sm-2">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-info  save" id="btnSaveWorkorder" enctype="multipart/form-data" accept-charset="utf-8" data-isdismiss="Y" data-isrefresh="Y"><?php echo $this->lang->line('save'); ?></button>
                                </div>
                                <div class="col-sm-12">
                                    <div class="alert-success success"></div>
                                    <div class="alert-danger error"></div>
                                </div>

                            <?php

                            endif; ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="tab-pane fade" id="work_measure" role="tabpanel" aria-labelledby="measure-tab">
            <?php

            if ($workorderstatus == 'WO') :

            ?>
                <form id="FormChangeStatusToMeasurement" action="<?php echo base_url('ams/workorder/change_status'); ?>" method="POST">
                    <input type="hidden" name="masterid" value="<?php echo $masterid;  ?>">
                    <input type="hidden" name="woma_workorderstatus" value="M">
                    <div class="form-group">
                        <div class="col-ms-12">
                            <div class="row">

                                <div class="col-sm-2">

                                    <label><strong>Measurement</strong></label>

                                </div>

                                <div class="col-sm-2">

                                    <label>Date</label>

                                    <?php

                                    if (DEFAULT_DATEPICKER == 'NP') {

                                        $measurement_date = !empty($work_order_master[0]->woma_measurementdatebs) ? $work_order_master[0]->woma_measurementdatebs : DISPLAY_DATE;
                                    } else {

                                        $measurement_date = !empty($work_order_master[0]->woma_measurementdatead) ? $work_order_master[0]->woma_measurementdatead : DISPLAY_DATE;
                                    }

                                    ?>

                                    <input type="text" name="measurementdate" class="form-control required_field <?php echo DATEPICKER_CLASS; ?>" id="measurementdate" value="<?php echo $measurement_date; ?>">

                                </div>

                                <div class="col-sm-2">

                                    <label>Amount</label>

                                    <?php $measurement_amt = !empty($work_order_master[0]->woma_measurementamount) ? $work_order_master[0]->woma_measurementamount : '0.00'; ?>

                                    <input type="text" name="woma_measurementamount" class="form-control float " id="woma_measurementamount" value="<?php echo $measurement_amt; ?>">

                                </div>

                                <div class="col-sm-2 ">

                                    <label>Attachment</label>

                                    <input type="file" name="woma_measurementattachment">

                                </div>
                                <div class="col-sm-2">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-info  save" id="btnSaveWorkorder" enctype="multipart/form-data" accept-charset="utf-8" data-isdismiss="Y" data-isrefresh="Y"><?php echo $this->lang->line('save'); ?></button>
                                </div>
                                <div class="col-sm-12">
                                    <div class="alert-success success"></div>
                                    <div class="alert-danger error"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            <?php
            endif; ?>
        </div>
        <div class="tab-pane fade" id="contract-bill" role="tabpanel" aria-labelledby="contract-bill-tab">
            <?php

            if ($workorderstatus == 'WO') :

            ?>
                <form id="FormWorkOrderContractBill" action="<?php echo base_url('ams/workorder/workorder_bill_and_payment'); ?>" method="POST">
                    <input type="hidden" name="masterid" value="<?php echo $masterid;  ?>">
                    <input type="hidden" name="workorder_type" value="CB">
                    <div class="form-group">
                        <div class="col-ms-12">
                            <div class="row">

                                <div class="col-sm-2">

                                    <label><strong>Contract Bill</strong></label>

                                </div>

                                <div class="col-sm-2">

                                    <label>Bill Date</label>
                                    <input type="text" name="contractbilldate" class="form-control required_field <?php echo DATEPICKER_CLASS; ?>" id="contractbilldate" value="<?php echo DISPLAY_DATE; ?>">

                                </div>

                                <div class="col-sm-2">

                                    <label>Bill Amount Without Vat</label>
                                    <input type="text" name="wocb_amtwithoutvat" class="form-control float " id="wocb_amtwithoutvat" value="0.00">

                                </div>

                                <div class="col-sm-2">
                                    <label>Bill Amount With Vat</label>
                                    <input type="text" name="wocb_amtwithvat" class="form-control float " id="wocb_amtwithvat" value="0.00">
                                </div>

                                <div class="col-sm-2 ">
                                    <label>Attachment</label>
                                    <input type="file" name="wocb_contractbillattachment">
                                </div>

                                <div class="col-sm-2">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-info  save" id="btnSaveWorkorder" enctype="multipart/form-data" accept-charset="utf-8" data-isdismiss="Y" data-isrefresh="Y"><?php echo $this->lang->line('save'); ?></button>
                                </div>
                                <div class="col-sm-12">
                                    <div class="alert-success success"></div>
                                    <div class="alert-danger error"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php if ($contractbill_list) : ?>
                    <div class="table-responsive ">
                        <table class="table table-sm dataTable">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Bill Date (B.S)</th>
                                    <th>Bill Date (A.D)</th>
                                    <th>Amount Without VAT</th>
                                    <th>Amount With VAT</th>
                                    <th>Attachment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contractbill_list as $key => $cbl) : ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $cbl->wocb_billdatebs ?></td>
                                        <td><?= $cbl->wocb_billdatead ?></td>
                                        <td><?= $cbl->wocb_amtwithoutvat ?></td>
                                        <td><?= $cbl->wocb_amtwithvat ?></td>
                                        <?php if (!empty($cbl->wocb_contractbillattachment)) : ?>
                                            <td><a href="<?= base_url(PROJECT_BILL_ATTACHMENT_PATH . '/' . $cbl->wocb_contractbillattachment); ?>"><?= $cbl->wocb_contractbillattachment ?></a></td>
                                        <?php else : ?>
                                            <td></td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            <?php

            endif; ?>

        </div>
        <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
            <?php

            if ($workorderstatus == 'WO') :

            ?>
                <form id="FormWorkOrderPayment" action="<?php echo base_url('ams/workorder/workorder_bill_and_payment'); ?>" method="POST">
                    <input type="hidden" name="masterid" value="<?php echo $masterid;  ?>">
                    <input type="hidden" name="workorder_type" value="PB">
                    <div class="form-group">
                        <div class="col-ms-12">
                            <div class="row">

                                <div class="col-sm-2">

                                    <label><strong>Payment</strong></label>

                                </div>

                                <div class="col-sm-2">
                                    <label>Date</label>
                                    <input type="text" name="paymentdate" class="form-control required_field <?php echo DATEPICKER_CLASS; ?>" id="paymentdate" value="<?php echo DISPLAY_DATE; ?>">
                                </div>

                                <div class="col-sm-2">
                                    <label>Payment Amount</label>
                                    <input type="text" name="wopa_paymentamt" class="form-control float " id="wopa_paymentamt" value="0.00">
                                </div>

                                <div class="col-sm-2">
                                    <label>Cheque No</label>
                                    <input type="text" name="wopa_chequeno" class="form-control float " id="wopa_chequeno" value="">
                                </div>
                                <div class="col-sm-2 ">
                                    <label>Attachment</label>
                                    <input type="file" name="wopa_paymentattachment">
                                </div>
                                <div class="col-sm-2">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-info  save" id="btnSaveWorkorder" enctype="multipart/form-data" accept-charset="utf-8" data-isdismiss="Y" data-isrefresh="Y"><?php echo $this->lang->line('save'); ?></button>
                                </div>
                                <div class="col-sm-12">
                                    <div class="alert-success success"></div>
                                    <div class="alert-danger error"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php if ($payment_list) : ?>
                    <div class="table-responsive ">
                        <table class="table table-sm dataTable">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Payment Date (B.S)</th>
                                    <th>Payment Date (A.D)</th>
                                    <th>Payment Amount</th>
                                    <th>cheque No</th>
                                    <th>Attachment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($payment_list as $key => $pl) : ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $pl->wopa_paymentdatebs ?></td>
                                        <td><?= $pl->wopa_paymentdatead ?></td>
                                        <td><?= $pl->wopa_paymentamt ?></td>
                                        <td><?= $pl->wopa_chequeno ?></td>
                                        <?php if (!empty($pl->wopa_paymentattachment)) : ?>
                                            <td><a href="<?= base_url(PROJECT_BILL_ATTACHMENT_PATH . '/' . $pl->wopa_paymentattachment); ?>"><?= $pl->wopa_paymentattachment ?></a></td>
                                        <?php else : ?>
                                            <td></td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            <?php

            endif; ?>
        </div>
        <div class="tab-pane fade" id="completion" role="tabpanel" aria-labelledby="completion-tab">
            <?php

            if ($workorderstatus == 'WO') :

            ?>
                <form id="FormChangeStatusToCompletion" action="<?php echo base_url('ams/workorder/change_status'); ?>" method="POST">
                    <input type="hidden" name="masterid" value="<?php echo $masterid;  ?>">
                    <input type="hidden" name="woma_workorderstatus" value="WC">
                    <div class="form-group">
                        <div class="col-ms-12">
                            <div class="row">

                                <div class="col-sm-2">

                                    <label><strong>Completion Certificate</strong></label>

                                </div>

                                <div class="col-sm-2">

                                    <label>Completion Date</label>

                                    <?php

                                    if (DEFAULT_DATEPICKER == 'NP') {
                                        $completion_date = !empty($work_order_master[0]->woma_completiondatebs) ? $work_order_master[0]->woma_completiondatebs : DISPLAY_DATE;
                                    } else {
                                        $completion_date = !empty($work_order_master[0]->woma_completiondatead) ? $work_order_master[0]->woma_completiondatead : DISPLAY_DATE;
                                    }
                                    ?>

                                    <input type="text" name="completiondate" class="form-control required_field <?php echo DATEPICKER_CLASS; ?>" id="completiondate" value="<?php echo $completion_date; ?>">

                                </div>

                                <div class="col-sm-2">
                                    <label>Civil Amount</label>
                                    <?php $civil_amt = !empty($work_order_master[0]->woma_civilamt) ? $work_order_master[0]->woma_civilamt : '0.00'; ?>
                                    <input type="text" name="woma_civilamt" class="form-control float " id="woma_civilamt" value="<?php echo $civil_amt; ?>">

                                </div>
                                <div class="col-sm-2">

                                    <label>Material Amount</label>

                                    <?php $material_amt = !empty($work_order_master[0]->woma_materialamt) ? $work_order_master[0]->woma_materialamt : '0.00'; ?>

                                    <input type="text" name="woma_materialamt" class="form-control float " id="woma_materialamt" value="<?php echo $material_amt; ?>">

                                </div>
                                <div class="col-sm-2">

                                    <label>Advertisement Amount</label>

                                    <?php $advertisement_amt = !empty($work_order_master[0]->woma_advertisementamt) ? $work_order_master[0]->woma_advertisementamt : '0.00'; ?>

                                    <input type="text" name="woma_advertisementamt" class="form-control float " id="woma_advertisementamt" value="<?php echo $advertisement_amt; ?>">

                                </div>
                                <div class="col-sm-2">

                                    <label>Other Amount</label>
                                    <?php $other_id = !empty($work_order_master[0]->woma_otheramt) ? $work_order_master[0]->woma_otheramt : '0.00'; ?>
                                    <input type="text" name="woma_otheramt" class="form-control float " id="woma_otheramt" value="<?php echo $other_id; ?>">

                                </div>
                                <div class="col-sm-2">
                                    <label>Total Amount</label>
                                    <?php $completion_total_amt = !empty($work_order_master[0]->woma_completion_totalamt) ? $work_order_master[0]->woma_completion_totalamt : '0.00'; ?>
                                    <input type="text" name="woma_completion_totalamt" class="form-control float " id="woma_completion_totalamt" value="<?php echo $completion_total_amt; ?>">
                                </div>
                                <div class="col-sm-2 ">
                                    <label>Attachment</label>
                                    <input type="file" name="woma_completionattachment">
                                </div>
                                <div class="col-sm-2">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-info  save" id="btnSaveWorkorder" enctype="multipart/form-data" accept-charset="utf-8" data-isdismiss="Y" data-isrefresh="Y"><?php echo $this->lang->line('save'); ?></button>
                                </div>
                                <div class="col-sm-12">
                                    <div class="alert-success success"></div>
                                    <div class="alert-danger error"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            <?php

            endif; ?>

        </div>
    </div>
    <!-- </div>
</div>
</form> -->
</div>

<!-- 
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script> -->
<script type="text/javascript">
    $(document).off('change', '#isworkorder');

    $(document).on('change', '#isworkorder', function(e) {

        var isval = $(this).val();

        if (isval == 'Y') {

            $('.displayblock').show();

        } else {

            $('.displayblock').hide();

        }

    });

    $(document).off('click', '#nav-tab>li>a');

    $(document).on('click', '#nav-tab>li>a', function(e) {
        var link = $(this).attr('href');
        $(link).addClass('active show');
        $(link).siblings().removeClass('active show');
        $(link).siblings().css('display', 'none');
    });
</script>

<script type="text/javascript">
    $('.nepdatepicker').nepaliDatePicker({

        npdMonth: true,

        npdYear: true,

    });
</script>