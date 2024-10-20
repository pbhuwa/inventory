<div class="list_c2 label_mw125">
    <form id="FormChangeStatus" action="<?php echo base_url('ams/workorder/change_status'); ?>" method="POST">
        <input type="hidden" name="masterid" value="<?php echo !empty($work_order_master[0]->woma_womasterid) ? $work_order_master[0]->woma_womasterid : '';  ?>">
        <?php
        $workorderstatus = !empty($work_order_master[0]->woma_workorderstatus) ? $work_order_master[0]->woma_workorderstatus : ''; ?>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="work-order" data-toggle="tab" href="#work_order" role="tab" aria-controls="work_order" aria-selected="true">Work Order</a>
            <a class="nav-item nav-link" id="measure-tab" data-toggle="tab" href="#work_measure" role="tab" aria-controls="work_measure" aria-selected="false">Measurement</a>
            <a class="nav-item nav-link" id="contract-bill-tab" data-toggle="tab" href="#contract-bill" role="tab" aria-controls="contract-bill" aria-selected="false">Contract Bill</a>
            <a class="nav-item nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false">Payment</a>
            <a class="nav-item nav-link" id="completion-tab" data-toggle="tab" href="#completion" role="tab" aria-controls="completion" aria-selected="false">Completion Certificate</a>
        </div>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="work_order" role="tabpanel" aria-labelledby="work-order">
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

                            <?php

                            endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="work_measure" role="tabpanel" aria-labelledby="measure-tab">
                <?php

                if ($workorderstatus == 'WO') :

                ?>

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

                        <input type="file" name="woma_measurementamount">

                    </div>



                <?php

                endif; ?>
            </div>
            <div class="tab-pane fade" id="contract-bill" role="tabpanel" aria-labelledby="contract-bill-tab">...</div>
            <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">...</div>
            <div class="tab-pane fade" id="completion" role="tabpanel" aria-labelledby="completion-tab">...</div>
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
</form>
</div>



<script type="text/javascript">
    $(document).off('change', '#isworkorder');

    $(document).on('change', '#isworkorder', function(e) {

        var isval = $(this).val();

        if (isval == 'Y') {

            $('.displayblock').show();

        } else {

            $('.hide').show();

        }

    });
</script>

<script type="text/javascript">
    $('.nepdatepicker').nepaliDatePicker({

        npdMonth: true,

        npdYear: true,

    });
</script>