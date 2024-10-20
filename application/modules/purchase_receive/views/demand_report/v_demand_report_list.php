<?php $this->load->view('demand_report/v_demand_report_type'); ?>

<div class="clearfix"></div>

<div class="pad-5 mtop_10">
    <!-- <h3 class="box-title">Demand Report List</h3> -->
    <div class="table-responsive">
        <table id="myTable" class="table table-striped ">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('items_id'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
                    <th width="20%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('demand_quantity'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('stock_quantity'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('diff'); ?></th>
                </tr>
            </thead>
            <tbody>
                      
            </tbody>
        </table>
    </div>
</div>

<div class="clearfix"></div>

<div class="col-sm-12">
    <div  class="alert-success success"></div>
    <div class="alert-danger error"></div>
</div>

<div id="myModal1" class="modal fade harmismodal001 modal-md" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><h4>Please leave a remark for undo.</h4></h4>
            </div>
                
            <div class="modal-body autoResizeBody">
                <form id="remarksModalForm" action="<?php echo base_url('purchase_receive/quotation_analysis/undo_approve_quotation'); ?>" method="POST">
                    <label>Remarks</label>
                    <input type="hidden" id="modal_qdetailid" name="qdetailid"/>
                    <input type="text" id="remarks" name="remarks" />
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

        var searchByStore = '';
        var above_maxlimit = '';
        var below_reorder = '';

        var dataurl = base_url + "purchase_receive/demand_report/demand_report_list";
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
                "aTargets": [0, 6]
            }],
            "aoColumns": [
                { "data": "sno" },
                { "data": "itemsid" },
                { "data": "itemscode" },
                { "data": "itemsname" },
                { "data": "demandqty" },
                { "data": "stockqty" },
                { "data": "diff" }
            ],
            "fnServerParams": function(aoData) {
                    aoData.push({"name": "frmDate","value": frmDate});
                    aoData.push({"name": "toDate","value": toDate});
                    aoData.push({"name": "searchByStore","value": searchByStore});
                    aoData.push({"name": "above_maxlimit","value": above_maxlimit});
                    aoData.push({"name": "below_reorder","value": below_reorder});
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
                { type: null },
                { type: null },
                { type: null },
            ]
        });

        $(document).on('change', '#searchByStore', function() {
            searchByStore = $('#searchByStore').val();
            dtablelist.fnDraw();
        });

        $(document).on('change', '#below_reorder', function() {
            below_reorder = $('#below_reorder').val();
            dtablelist.fnDraw();
        });

        $(document).on('change', '#above_maxlimit', function() {
            above_maxlimit = $('#above_maxlimit').val();
            dtablelist.fnDraw();
        });

        $(document).off('click','#excel');
        $(document).on('click','#excel',function(){
            searchByStore = $('#searchByStore').val();
            above_maxlimit = $('#above_maxlimit').val();
            below_reorder = $('#below_reorder').val();

            var redirecturl=base_url+'purchase_receive/demand_report/exportToExcel';
            $.redirectPost(redirecturl, {searchByStore:searchByStore, below_reorder:below_reorder, above_maxlimit:above_maxlimit});
        });

        $(document).off('click','.btn_pdf');
        $(document).on('click','.btn_pdf',function(){
            searchByStore = $('#searchByStore').val();
            above_maxlimit = $('#above_maxlimit').val();
            below_reorder = $('#below_reorder').val();

             var redirecturl=base_url+'purchase_receive/demand_report/generate_pdf';
            $.redirectPost(redirecturl, {searchByStore:searchByStore, below_reorder:below_reorder, above_maxlimit:above_maxlimit});
        });
    });
</script>

