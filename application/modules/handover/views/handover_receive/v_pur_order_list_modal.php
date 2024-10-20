<style type="text/css">
    table.dataTable tbody tr.selected {
        background-color: #B0BED9;
        background: -webkit-linear-gradient(#e5eeff, #d4dcea);
        background: -o-linear-gradient(#e5eeff, #d4dcea);
        background: -moz-linear-gradient(#e5eeff, #d4dcea);
        background: linear-gradient(#e5eeff, #d4dcea);
        font-weight: 600;
    }
    table.dataTable tbody tr.active {
        background-color: #B0BED9 !important;
    }
</style>

<?php
    $dynamicColumns = '[{"data": null},{"data": "order_no"},{"data": "req_no"},{"data": "date"},{"data": "suppliername"},{"data": "amount" }]';
    $columnsize = '5';
?>  

<div class="white-box pad-5">
    <div class="list_c2 label_mw125">
        <div class="form-group row resp_xs">
            <div class="col-md-12 col-xs-12" style="max-height: 200px; overflow-y: auto;">
                <table class="table table-striped dt_alt dataTable serverDatatable" id="myitemListTable" tabindex="1" data-tableid="#myitemListTable" data-type="<?php echo $this->input->post('type');?>">
                    <thead>
                        <tr>
                            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                            <th width="7%"><?php echo $this->lang->line('order_no'); ?></th>
                            <th width="7%"><?php echo $this->lang->line('req_no'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('date'); ?></th>
                            <th width="20%"><?php echo $this->lang->line('supplier_name'); ?></th>
                            <th width="15%"><?php echo $this->lang->line('total'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="white-box pad-5" id="detailListBox">
    <?php $this->load->view('receive_against_order/v_pur_order_detail_modal');?>
</div> 

<script type="text/javascript">
    $(document).ready(function(){
        var frmDate=$('#frmDate').val();
        var toDate=$('#toDate').val();

        var fiscalyear = $('#fiscalyear').val();


        var transfer = $('.serverDatatable').data('type');
        var tableid = $('.serverDatatable').data('tableid');

        var firstTR = $(tableid+' tbody tr:first');
        firstTR.addClass('selected');

        var selectedTR = $('.serverDatatable').find('.selected');

        setTimeout(function(){
            var prime_id = $('.serverDatatable').find('.selected').data('masterid');
            getDetailList(prime_id);
        },1000);

        var dataurl = base_url+"purchase_receive/receive_against_order/get_order_list_for_receive";

        var dynamicColumns = <?php echo $dynamicColumns; ?>

        var columnsize = <?php echo $columnsize; ?>

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
        
        $(tableid).on("draw.dt", function(){
            var rowsNext = $(tableid).dataTable().$("tr:first");
            rowsNext.addClass("selected");
        });
     
        var dtablelist = $(tableid).dataTable({
            "sPaginationType": "full_numbers"  ,
            "bSearchable": false,
            "lengthMenu": [[5, 30, 45, 60,100,200,500, -1], [5, 30, 45, 60,100,200,500, "All"]],
            'iDisplayLength': 5,
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
                    "aTargets": [0,columnsize]
                    }
            ], 

            "aoColumns": dynamicColumns,
      
            "fnServerParams": function (aoData) {
                aoData.push({ "name": "frmDate", "value": frmDate });
                aoData.push({ "name": "toDate", "value": toDate });
                aoData.push({ "name": "fiscalyear", "value": fiscalyear });
            },
            "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                var oSettings = dtablelist.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
                return nRow;
            },
            "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
                var masterid = aData.masterid;
                var order_no = aData.order_no;
                var req_no = aData.req_no;
                var date = aData.date;
                var suppliername = aData.suppliername;
                var amount = aData.amount;

                var oSettings = dtablelist.fnSettings();
                var tblid = oSettings._iDisplayStart+iDisplayIndex +1;
               
                var tbl_id = iDisplayIndex + 1;

                $(nRow).attr('id', 'listid_'+tblid);

                $(nRow).attr('data-rowid',tbl_id);

                $(nRow).attr('data-masterid',masterid);
                $(nRow).attr('data-order_no',order_no);
                $(nRow).attr('data-req_no',req_no);
                $(nRow).attr('data-date',date);
                $(nRow).attr('data-suppliername',suppliername);
                $(nRow).attr('data-amount',amount);

                $(nRow).addClass('itemDetail');
            },
        }).columnFilter(
        {
            sPlaceHolder: "head:after",
            aoColumns: [ { type: null },
                { type: "text"},
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
            ]
        });

        $.singleDoubleClick = function(singleClk, doubleClk) {
            return (function() {
                var alreadyclicked = false;
                var alreadyclickedTimeout;

                return function(e) {
                    if (alreadyclicked) {
                        // double
                        masterid = $(this).data('masterid');
                        tran = $('.serverDatatable').data('type'); //for transfer
                        // console.log(masterid);

                        var order_no = $(this).data('order_no');
                        var req_no = $(this).data('req_no');
                        var date = $(this).data('date');
                        var suppliername = $(this).data('suppliername');
                        var amount = $(this).data('amount');
                     
                        $('#myView').modal('hide');

                        $('input#req_no').val(req_no);

                        $('input#date').val(date);

                        $('#suppliername').val(suppliername).trigger('change');

                        $('input#orderno').val(order_no);

                        setTimeout(function(){
                            $('#btnSearchOrderno').click();
                        },100);
                        getDetailList(masterid, 'main_form');

                        //end double click 
                        
                        alreadyclicked = false;
                        alreadyclickedTimeout && clearTimeout(alreadyclickedTimeout);
                        doubleClk && doubleClk(e);
                    } else {
                        // single
                        
                        var keyPressTableList = $(tableid);
                        if ($(this).hasClass('selected')) {
                            $(this).removeClass('selected');
                        } else {
                            keyPressTableList.find('tr.selected').removeClass('selected');
                            $(this).addClass('selected');
                        }

                        masterid = $(this).data('masterid');
                        // console.log(masterid);

                        getDetailList(masterid);
                        //end single click
                        
                        alreadyclicked = true;
                        alreadyclickedTimeout = setTimeout(function() {
                            alreadyclicked = false;
                            singleClk && singleClk(e);
                        }, 500);
                    }
                }
            })();
        }

        $(document).off('click','.serverDatatable tbody tr');
        $(document).on('click', '.serverDatatable tbody tr',$.singleDoubleClick(function(e){
        //click.
            // console.log('click');
        }, function(e){
        //double click.
            // console.log('doubleclick');
        }
        ));

        $('#myView').off('keydown');
        $('#myView').on('keydown', function(event){
            selectedTR = $(tableid).find('.selected');
            var rowid = selectedTR.data('rowid');
            var numTR = $(tableid+' tr').length-1;
            // console.log('keydown'+rowid);

            var keypressed = event.keyCode;
            // console.log(keypressed);
            if(keypressed == '40' && rowid < numTR){
                selectedTR.removeClass('selected');
                nextTR = selectedTR.next('tr');

                nextTR.addClass('selected');
                masterid = nextTR.data('masterid');
                setTimeout(function(){
                    nextTR.focus();
                    getDetailList(masterid);
                }, 100);
            }

            if(keypressed == '38' && rowid != '1'){
                selectedTR.removeClass('selected');
                prevTR = selectedTR.prev('tr');

                prevTR.addClass('selected');
                masterid = prevTR.data('masterid');
                setTimeout(function(){
                    prevTR.focus();
                    getDetailList(masterid);
                    $('tr[id= listid_'+rowid+']').focus();

                }, 100);
            }

            if(keypressed == '13'){
                masterid = selectedTR.data('masterid');
                tran = $('.serverDatatable').data('type');

                var order_no = selectedTR.data('order_no');

                $('#myView').modal('hide');

                $('input#masterid').val(masterid);
                $('input#orderno').val(order_no);

                setTimeout(function(){
                    $('#btnSearchOrderno').click();
                },100);

                if(tran){
                    getDetailList(masterid, 'main_form',tran);
                }else{
                    getDetailList(masterid, 'main_form');
                }
            }

            // console.log(masterid);
            getDetailList(masterid);       
        });
    });

</script>

