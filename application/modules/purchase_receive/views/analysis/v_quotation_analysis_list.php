<style>
    .table-striped tbody tr.approved td{
        font-weight: bold;
        color:#f00;
    }
</style>
<div class="searchWrapper">
    <div class="col-md-3">
        <form>
            <label>Fiscal Year</label>
            <select class="form-control searchByFiscalYear" id="searchByFiscalYear" data-searchtype="fiscal">
                <?php
                    if(!empty($fiscal_year)):
                        foreach($fiscal_year as $year):
                ?>
                    <option value="<?php echo !empty($year->fiye_name)?$year->fiye_name:'';?>" <?php echo ($year->fiye_status == 'I')?'selected="selected"':''; ?>><?php echo !empty($year->fiye_name)?$year->fiye_name:'';?></option>
                <?php    
                        endforeach; 
                    endif;
                ?>
            </select>
        </form>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <button class="btn btn-info" id="approve"><i class="fa fa-check"></i> Approve</button>
        <button class="btn btn-warning" id="undoApprove"><i class="fa fa-undo"></i> Undo</button>
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="purchase_receive/quotation_analysis/analysis_list" data-location="purchase_receive/quotation_analysis/exportToExcel" data-tableid="#myTable" style="margin-top: 7px; padding:6px;"><i class="fa fa-file-excel-o"></i></a>
    </div>
</div>
<div class="col-sm-12">
    <div  class="alert-success success"></div>
    <div class="alert-danger error"></div>
</div>

<div class="clearfix"></div>
<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped ">
            <thead>
                <tr>
                    <th width="5%">S.No.</th>
                    <th width="10%">Code</th>
                    <th width="20%">Items Name</th>
                    <th width="15%">Supplier</th>
                    <th width="10%">Quot. Date</th>
                    <th width="10%">Quot. No.</th>
                    <th width="10%">Rate</th>
                    <th width="5%">Dis %</th>
                    <th width="5%">VAT %</th>
                    <th width="10%">Net Rate</th>
                    <th width="10%">Remarks</th>
                </tr>
            </thead>
            <tbody>
                      
            </tbody>
        </table>
    </div>
</div>
<div class="clearfix"></div>


<div id="myModal1" class="modal fade harmismodal001 modal-md" role="dialog">
    <div class="modal-dialog modal-400">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><h4>Please leave a remark for undo.</h4></h4>
            </div>
                
            <div class="modal-body autoResizeBody">
                <form id="remarksModalForm" action="<?php echo base_url('purchase_receive/quotation_analysis/undo_approve_quotation'); ?>" method="POST">
                    <label>Remarks</label>
                    <input type="hidden" id="modal_qdetailid" name="qdetailid"/>
                    <!-- <input type="text" id="remarks" name="remarks" /> -->
                    <textarea name="" id="remarks" cols="30" rows="3" class="form-control"></textarea>
                    <button type="submit" class="btn btn-info savelist mtop_10 closeModal" data-isdismiss="Y">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div> 

<script type="text/javascript">
  $(document).ready(function() {
    var frmDate = $('#frmDate').val();
    var toDate = $('#toDate').val();

    var searchByFiscalYear = $('#searchByFiscalYear').val();

    var dataurl = base_url + "purchase_receive/quotation_analysis/analysis_list";
    var message = '';
    var showview = '<?php echo MODULES_VIEW; ?>';
    // alert(showview);
    if (showview == 'N') {
        message = "<p class='text-danger'>Permission Denial</p>";
    } else {
        message = "<p class='text-danger'>No Record Found!! </p>";
    }



    var dtablelist = $('#myTable').dataTable({
        "sPaginationType": "full_numbers",

        "bSearchable": false,
        "lengthMenu": [
            [15, 30, 45, 60, 100, 200, 500, -1],[15, 30, 45, 60, 100, 200, 500, "All"]
        ],
        'iDisplayLength': 20,
        "sDom": 'ltipr',
        "bAutoWidth": false,

        "autoWidth": true,
        "aaSorting": [
            [0, 'desc']
        ],
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": dataurl,
        "oLanguage": {
            "sEmptyTable": message
        },
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [0, 10]
        }],
        "aoColumns": [
            { "data": "qdetailid" },
            { "data": "code" },
            { "data": "itemsname" },
            { "data": "supplier" },
            { "data": "quot_date" },
            { "data": "quot_no" },
            { "data": "rate" },
            { "data": "dis" },
            { "data": "vat" },
            { "data": "netrate" },
            { "data": "remarks" },
        ],
        "fnServerParams": function(aoData) {
                aoData.push({"name": "frmDate","value": frmDate});
                aoData.push({"name": "toDate","value": toDate});
                aoData.push({"name": "searchByFiscalYear","value": searchByFiscalYear
            });
        },
        "fnRowCallback": function(nRow, aData, iDisplayIndex) {
            var oSettings = dtablelist.fnSettings();
            $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
            return nRow;
        },
        "fnCreatedRow": function(nRow, aData, iDisplayIndex) {
            var oSettings = dtablelist.fnSettings();
            var tblid = oSettings._iDisplayStart + iDisplayIndex + 1

            $(nRow).attr('id', 'listid_' + tblid);
        },
    }).columnFilter({
        sPlaceHolder: "head:after",
        aoColumns: [
            { type: null },
            { type: "text" },
            { type: "text" },
            { type: "text" },
            { type: "text" },
            { type: "text" },
            { type: "text" },
            { type: "text" },
            { type: "text" },
            { type: "text" },
            { type: null },
        ]
    });

    //search by fiscal year
    $(document).on('change', '#searchByFiscalYear', function() {
        searchByFiscalYear = $('#searchByFiscalYear').val();
        dtablelist.fnDraw();
    });

    var qdetailid = '';
    var itemsid = '';
    var approved = 'no';
    $(document).on('click', '#myTable tbody tr', function() {
        var dtablelist = $('#myTable').dataTable();
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            qdetailid = 0;
            itemsid = 0;
        } else {
            dtablelist.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            qdetailid = dtablelist.api().row(this).data().qdetailid;
            itemsid = dtablelist.api().row(this).data().itemsid;
        }

        if ($(this).hasClass('approved')) {
            // alert('already approved');
            approved = 'yes';
        }else{
            approved = 'no';
        }
    });

    $(document).on('click', '#approve',function(){
        qdetailid = qdetailid;
        itemsid = itemsid;
        fyear = $('#searchByFiscalYear').val();

        approved = approved;

        if(qdetailid != 0 && approved != 'yes'){
            if(confirm("Do you want to approve this quotation?")){
                $.ajax({
                    type: "POST",
                    url: base_url+'purchase_receive/quotation_analysis/approve_quotation',
                    data: {qdetailid:qdetailid, itemsid:itemsid, fyear:fyear},
                    beforeSend: function() {
                        $('.overlay').modal('show');
                    },
                    success:function(jsons){
                        var data = jQuery.parseJSON(jsons);
                        if(data.status == 'success'){
                            $('.success').html(data.message);
                            $('.error').html('');
                        }else{
                            $('.success').html('');
                            $('.error').html(data.message);
                        }
                        dtablelist.fnDraw(); 
                        $('.overlay').modal('hide');
                    }
                });
            }else{
                return false;
            }
        }else{
            if(qdetailid == '0' || qdetailid == ''){
                $('.success').html('');
                $('.error').html('No items selected.');
            }
            else if(approved == 'yes'){
                $('.success').html('');
                $('.error').html('Already Approved');
            }
            return false;
        }
    });

    $(document).on('click', '#undoApprove',function(){
        qdetailid = qdetailid;
        itemsid = itemsid;
        fyear = $('#searchByFiscalYear').val();

        approved = approved;

        if(qdetailid != 0 && approved == 'yes'){
            if(confirm("Do you want to undo this approval?")){
                $('#modal_qdetailid').val(qdetailid);
                $('#myModal1').modal('show');
            }else{
                return false;
            }
        }else{
            if(qdetailid == '0' || qdetailid == ''){
                $('.success').html('');
                $('.error').html('No items selected.');
            }
            else if(approved == 'no'){
                $('.success').html('');
                $('.error').html('This item is not approved yet.');
            }
            return false;
        }
    });

    $(document).on('click','.closeModal',function(){
        setTimeout(function(){
            dtablelist.fnDraw(); 
        }, 1500);
    });
});
</script>

