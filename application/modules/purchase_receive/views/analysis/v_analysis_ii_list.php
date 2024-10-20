

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
<script type="text/javascript">
$(document).ready(function() {
    var frmDate = $('#frmDate').val();
    var toDate = $('#toDate').val();
    
    var searchByFiscalYear = $('#searchByFiscalYear').val();

    var dataurl = base_url + "purchase_receive/quotation_analysis/analysis_list"+ '/second';
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
