<style type="text/css">
    .table>tbody>tr>td:not(:last-child),
    .table>tbody>tr>th {
        vertical-align: middle !important;
        white-space: normal !important;
    }
</style>

<div class="searchWrapper">
    <div class="row">
        <form class="col-sm-12">
            <?php echo $this->general->location_option(2); ?>
            <div class="col-md-2">
                <label>Date Search:</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_all">All</option>
                    <option value="date_range">By Date Range</option>
                </select>
            </div>
            <div class="dateRangeWrapper" style="display:none">
                <div class="col-md-1">
                    <label><?php echo $this->lang->line('from_date'); ?> :</label>
                    <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>" />
                </div>
                <div class="col-md-1">
                    <label><?php echo $this->lang->line('to_date'); ?>:</label>
                    <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>" />
                </div>
            </div>
            <div class="col-md-3">
                <label><?php echo $this->lang->line('received_by'); ?></label>
                <select class="form-control select2" id="received_by">
                    <option value="">All</option>
                    <?php
                    if ($staff_list) :
                        foreach ($staff_list as $ks => $staff) :
                    ?>
                            <option value="<?php echo $staff->stin_staffinfoid; ?>"><?php echo "$staff->stin_fname $staff->stin_lname"; ?></option>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <?php
                ?>
                <label for="example-text">Department <span class="required">*</span>:</label>
                <div class="dis_tab">
                    <select name="depid" id="depid" class="form-control ">
                        <option value="">--All--</option>
                        <?php if (!empty($department)) :
                            foreach ($department as $kd => $dep) :
                        ?>
                                <option value="<?php echo $dep->dept_depid ?>"><?php echo $dep->dept_depname ?></option>
                        <?php endforeach;
                        endif; ?>
                    </select>
                </div>
            </div>
            <?php
            $subdepid = '';
            if (!empty($sub_department)) :
                $displayblock = 'display:block';
            else :
                $displayblock = 'display:none';
            endif;
            ?>
            <div class="col-md-3" id="subdepdiv" style="<?php echo $displayblock; ?>">
                <label for="example-text">Sub Department:</label>
                <select name="subdepid" id="subdepid" class="form-control">
                    <?php if (!empty($sub_department)) : ?>
                        <option value="">--All--</option>
                        <?php foreach ($sub_department as $ksd => $sdep) :
                        ?>
                            <option value="<?php echo $sdep->dept_depid; ?>" <?php if ($sdep->dept_depid == $subdepid) echo "selected=selected"; ?>><?php echo $sdep->dept_depname; ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>
            <div class="col-md-2">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
            <div class="sm-clear"></div>
        </form>
    </div>
    <div class="clear"></div>
</div>
<div class="pad-5">
    <div class="table-responsive">
        <table id="assetIssueSummaryTable" class="table table-striped">
            <thead>
                <tr class="tr_issue">
                    <th width="3%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="8%" ><?php echo $this->lang->line('issue_date').'('.$this->lang->line('bs').')'; ?>
                    <th width="8%" ><?php echo $this->lang->line('issue_date').'('.$this->lang->line('ad').')'; ?>
                    <th width="5%"><?php echo $this->lang->line('issue_no'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('department'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('req_no'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('received_by'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('fiscal_year'); ?> </th>
                    <th width="10%"><?php echo $this->lang->line('action'); ?></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();
    var locationid=$('#locationid').val();
    var searchDateType = $('#searchDateType').val();
    var received_by = $('#received_by').val();
    var depid = $('#depid').val();
    if (searchDateType == 'date_all') {
        frmDate = '';
        toDate = '';
    }
   
    var dataurl = base_url+"ams/asset_issue/asset_issue_summary_list";
    var message='';
    var showview='<?php echo MODULES_VIEW; ?>';
    if(showview=='N')
    {
    message="<p class='text-danger'>Permission Denial</p>";
    }
    else
    {
    message="<p class='text-danger'>No Record Found!! </p>";
    }

    var dtablelist = $('#assetIssueSummaryTable').dataTable({
    "sPaginationType": "full_numbers"  ,
    "bSearchable": false,
    "lengthMenu": [[15, 30, 45, 60,100,200,500, -1], [15, 30, 45, 60,100,200,500, "All"]],
    'iDisplayLength': 20,
    "sDom": 'ltipr',
    "bAutoWidth":false,

    "autoWidth": true,
    "aaSorting": [[0,'desc']],
    "bProcessing":true,
    "bServerSide":true,
    "sAjaxSource":dataurl,
    "oLanguage": {
    "sEmptyTable":message
    },
    "aoColumnDefs": [
    {
    "bSortable": false,
    "aTargets": [ 0, 8]
    }
    ],
 
    "aoColumns": [
    { "data": null},
    { "data": "issuedatebs" },
    { "data": "issuedatead" },
    { "data": "issue_no"},
    { "data": "depname" },
    { "data": "reqno" },
    { "data": "received_by" },
    { "data": "fyear" },
    { "data": "action" }
    ],
    "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
        aoData.push({ "name": "locationid", "value": locationid });
        aoData.push({ "name": "depid", "value": depid });
        aoData.push({ "name": "received_by", "value": received_by });
    },
    "fnRowCallback" : function(nRow, aData, iDisplayIndex){
        var oSettings = dtablelist.fnSettings();
        $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
        return nRow;
    },
    "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
        var appclass=aData.approvedclass;
        //alert(appclass);
        var oSettings = dtablelist.fnSettings();
        var tblid = oSettings._iDisplayStart+iDisplayIndex +1
        $(nRow).attr('id', 'listid_'+tblid);
        $(nRow).attr('class', appclass);
    },
    }).columnFilter(
    {
        sPlaceHolder: "head:after",
        aoColumns: [ { type: null },
        {type: "text"},
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: null },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: null },
        ]
    });

    var otherlinkdata=base_url+'issue_consumption/new_issue/issue_summary';

    var otherdata = get_other_ajax_data(otherlinkdata,frmDate,toDate,false,locationid);

    $(document).off('change','#searchByType')
    $(document).on('click', '#searchByDate', function() {
        searchDateType = $('#searchDateType').val();
        frmDate = $('#frmDate').val();
        toDate = $('#toDate').val();
        locationid=$('#locationid').val();
        received_by = $('#received_by').val();
        depid = $('#depid').val();   
        if (searchDateType == 'date_all') {
        frmDate = '';
        toDate = '';
    }     
        dtablelist.fnDraw();
        get_other_ajax_data(otherlinkdata,frmDate,toDate,false,locationid);  
    });

     $(document).off('change', '#searchDateType');
       $(document).on('change', '#searchDateType', function() {
        var search_date_val = $(this).val();

        if (search_date_val == 'date_all') {
            $('.dateRangeWrapper').hide();
        } else {
            $('.dateRangeWrapper').show();
        }
    });

    function get_other_ajax_data(action,frmdate=false,todate=false,othertype=false,locid=false){
        var returndata=[];   
        $.ajax({
            type: "POST",
            url: action,
            // data:$('form#'+formid).serialize(),
            dataType: 'html',
            data:{frmdate:frmdate,todate:todate,othertype:othertype,locid:locid} ,
            success: function(jsons) //we're calling the response json array 'cities'
            {
                // console.log(jsons);
                data = jQuery.parseJSON(jsons);  
                var cancel=0;
                var  issuereturn=0;
                var returncancel=0;
                var cancel=0; 
                // console.log(data);
                $('#issue').html('');
                $('#cancel').html('');
                $('#issuereturn').html('');
                $('#returncancel').html('');
                // if(data.status=='success'){
                //     issuedata=data.status_count;
                //     returndata = data.return_count;

                //     // console.log(issuedata);
                //     // console.log(issuedata[0].cancel)
                //     issue=issuedata[0].issue;
                //     cancel=issuedata[0].cancel;
                //     issuereturn=returndata[0].issuereturn;
                //     returncancel=returndata[0].returncancel;        
                // }

                  if(data.status=='success'){

                    issuedata=data.status_count;

                    issue=issuedata.issue;

                    cancel=issuedata.cancel;

                    issuereturn=issuedata.issue_ret;

                    returncancel=issuedata.ret_cancel;        

                }
                $('#issue').html(issue);
                $('#cancel').html(cancel);
                $('#issuereturn').html(issuereturn);
                $('#returncancel').html(returncancel);

                return false;
            }   
        });
    }
});
</script>