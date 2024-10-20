<?php 
$this->locationid = $this->session->userdata(LOCATION_ID);
$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
?>
<div class="searchWrapper">
    <form id="auction_disposal_report_search_form">
        <div class="form-group">
            <div class="row">
                <?php echo $this->general->location_option(2, 'locationid'); ?>

                <div class="col-md-2">

                    <label for="example-text">Choose Material Type : </label><br>

                    <?php

                    $rema_mattype = !empty($req_data[0]->rema_mattypeid) ? $req_data[0]->rema_mattypeid : 1;

                    ?>

                    <select name="rema_mattypeid" id="mattypeid" class="form-control chooseMatType required_field">
                        <option value="">--All--</option>

                        <?php

                        if (!empty($material_type)) :

                            foreach ($material_type as $mat) :

                        ?>

                                <option value="<?php echo $mat->maty_materialtypeid; ?>" <?php if ($rema_mattype == $mat->maty_materialtypeid) echo "selected=selected"; ?>> <?php echo $mat->maty_material; ?></option>

                        <?php

                            endforeach;

                        endif;

                        ?>

                    </select>

                </div>

            <div class="col-md-2">
            <label for="example-text">Disposal Type:</label>
                <select name="disposal_type" id="disposal_type" class="form-control select2" >
                <option value="">---All---</option>
                <?php
                    if(!empty($disposaltype)):
                        foreach ($disposaltype as $key => $dety):
                ?>
                <option value="<?php echo $dety->dety_detyid; ?>"><?php echo $dety->dety_name; ?></option>
                <?php
                        endforeach;
                    endif;
                ?>
                </select>
            </div>

                <div class="col-md-2">
                    <label><?php echo $this->lang->line('date_search'); ?> :</label>
                    <select name="searchDateType" id="searchDateType" class="form-control">
                        <option value="date_range">By Date Range</option>
                        <option value="date_all">All</option>
                    </select>
                </div>

                <div class="dateRangeWrapper">
                    <div class="col-md-1">
                        <label><?php echo $this->lang->line('from_date'); ?> :</label>
                        <input type="text" name="frmDate" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>" />
                    </div>

                    <div class="col-md-1">
                        <label><?php echo $this->lang->line('to_date'); ?>:</label>
                        <input type="text" id="toDate" name="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>" />
                    </div>
                </div>

                <div class="col-md-2">
                    <label>Report Type</label>
                    <select name="rpt_type" class="form-control">
                        <option value="summary">Summary</option>
                        <option value="detail">Detail</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Print Orientation</label>
                    <select name="page_orientation" class="form-control">
                        <option value="P">Portrait </option>
                        <option value="L">Landscape</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="reports/AuctionDisposalReport/get_report"><?php echo $this->lang->line('search'); ?></button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="clearfix"></div>

<div id="displayReportDiv"></div>
<script type="text/javascript">
    $(document).off('change', '#searchDateType');
    $(document).on('change', '#searchDateType', function() {
        var search_date_val = $(this).val();

        if (search_date_val == 'date_all') {
            $('.dateRangeWrapper').hide();
        } else {
            $('.dateRangeWrapper').show();
        }
    });
</script>

<script type="text/javascript">
    $(document).off('change', '#schoolid');

    $(document).on('change', '#schoolid', function(e) {

        var schoolid = $(this).val();

        var submitdata = {
            schoolid: schoolid
        };

        var submiturl = base_url + 'issue_consumption/stock_requisition/get_department_by_schoolid';

        // aletr(schoolid);

        $('#departmentid').html('');

        ajaxPostSubmit(submiturl, submitdata, beforeSend, onSuccess);

        function beforeSend() {

        };

        function onSuccess(jsons) {
            data = jQuery.parseJSON(jsons);
            if (data.status == 'success') {
                $('#subdepdiv').hide();
                $('#departmentid').html(data.dept_list);
            } else {

                $('#departmentid').html(' <option value="">--All--</option>');

                $("#departmentid").select2("val", "");

                $("#subdepid").select2("val", "");
            }
        }

    });

    $(document).off('change', '#departmentid');
    $(document).on('change', '#departmentid', function(e) {
        var depid = $(this).val();
        var submitdata = {
            schoolid: depid
        };
        var submiturl = base_url + 'issue_consumption/stock_requisition/get_department_by_schoolid';
        $("#subdepid").select2("val", "");
        $('#subdepid').html('');
        ajaxPostSubmit(submiturl, submitdata, beforeSend, onSuccess);

        function beforeSend() {};

        function onSuccess(jsons) {
            data = jQuery.parseJSON(jsons);
            if (data.status == 'success') {
                $('#subdepdiv').show();
                $('#subdepid').html(data.dept_list);
            } else {
                $('#subdepdiv').hide();
                $('#subdepid').html();
            }
        }
    });
</script>

<?php
if($this->location_ismain!='Y'):
 ?>
<script type="text/javascript">
   setTimeout(function () {
      $('#schoolid').change();
    }, 500);

</script>
 <?php 
endif;
 ?>