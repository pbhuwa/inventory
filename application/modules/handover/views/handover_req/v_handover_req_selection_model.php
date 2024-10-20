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

<div class="white-box pad-5">
    <div class="list_c2 label_mw125">
        <div class="form-group row resp_xs">
            <div class="col-md-12 col-xs-12" style="max-height: 200px; overflow-y: auto;">
                <table class="table table-striped dt_alt dataTable serverDatatable" id="myitemListTable" tabindex="1" data-tableid="#myitemListTable" data-type="<?php echo $this->input->post('type');?>">
                    <thead>
                        <tr>
                            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('req_no'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('manual_no'); ?></th>
                            <th width="15%"><?php echo $this->lang->line('date'); ?></th>
                            
                            <th width="20%"><?php echo $this->lang->line('from_branch'); ?></th>
                            <th width="20%"><?php echo $this->lang->line('to_branch'); ?></th>
                            <?php
                            
                            $dynamicColumns = '[{"data": null},{"data": "req_no"},{"data": "manual_no"},{"data": "req_datebs"},{"data": "req_depname" },{"data": "req_reqby" }]';
                            $columnsize = '5';
                            ?>
                            <th width="20%"><?php echo $this->lang->line('department_name'); ?></th>
                            
                            <th width="20%"><?php echo $this->lang->line('requisition'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="white-box pad-5" id="pendingListBox">
    <?php
    if(defined('HANDOVER_LAYOUT_TYPE')):
        if(HANDOVER_LAYOUT_TYPE == 'DEFAULT'){
          $this->load->view('handover/handover_req/v_requisition_pendinglist_modal');
      }else{

         $this->load->view('handover/handover_req/'.REPORT_SUFFIX.'/v_requisition_pendinglist_modal');
     }
 else:

  $this->load->view('handover/handover_req/v_requisition_pendinglist_modal');
endif;


?>
</div>
<?php  $transfertype =  $this->input->post('type'); 
//echo $transfertype; die; ?>
<script type="text/javascript">
    $(document).ready(function(){
        var frmDate=$('#frmDate').val();
        var toDate=$('#toDate').val();

        var fyear = $('#fyear').val();

        var transfer = $('.serverDatatable').data('type');
        
        var tableid = $('.serverDatatable').data('tableid');

        var firstTR = $(tableid+' tbody tr:first');
        firstTR.addClass('selected');

        var selectedTR = $('.serverDatatable').find('.selected');

        setTimeout(function(){
            var prime_id = $('.serverDatatable').find('.selected').data('masterid');
            getPendingList(prime_id);
        },1000);

        var dataurl = base_url+"stock_inventory/stock_requisition/get_stock_requisition_list" + "/"+ transfer;
        // alert('test');

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
            aoData.push({ "name": "fyear", "value": fyear });
        },
        "fnRowCallback" : function(nRow, aData, iDisplayIndex){
            var oSettings = dtablelist.fnSettings();
            $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
            return nRow;
        },
        "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
            var masterid = aData.req_masterid;
            var reqno = aData.req_no;
            var manualno = aData.manual_no;
            var req_date = aData.req_datebs;
            var req_depname = aData.req_depname;
            var req_depid = aData.req_depid;
            var req_reqby = aData.reqby;
            var req_fromstore = aData.fromstore;
            var req_tostore = aData.tostore;

            var oSettings = dtablelist.fnSettings();
            var tblid = oSettings._iDisplayStart+iDisplayIndex +1;
            var tbl_id = iDisplayIndex + 1;

            $(nRow).attr('id', 'listid_'+tblid);

            $(nRow).attr('data-rowid',tbl_id);

            $(nRow).attr('data-masterid',masterid);
            $(nRow).attr('data-reqno',reqno);
            $(nRow).attr('data-manualno',manualno);
            $(nRow).attr('data-req_date',req_date);
            $(nRow).attr('data-depname',req_depname);
            $(nRow).attr('data-depid',req_depid);
            $(nRow).attr('data-reqby',req_reqby);
            $(nRow).attr('data-fromstore',req_fromstore);
            $(nRow).attr('data-tostore',req_tostore);


                // $(nRow).addClass('itemDetail');
            },
        }).columnFilter(
        {
            sPlaceHolder: "head:after",
            aoColumns: [ { type: null },
            { type: "text"},
            { type: "text" },
            { type: "text" },
            { type: "text" },
            { type: null },
            ]
        });

        
        

        $.singleDoubleClick = function(singleClk, doubleClk) {
            return (function() {
                var alreadyclicked = false;
                var alreadyclickedTimeout;

                return function(e) {
                    if (alreadyclicked) {
                        // double
                        req_masterid = $(this).data('masterid');
                        req_reqno = $(this).data('reqno');
                        tran = $('.serverDatatable').data('type');
                        // console.log(req_masterid);

                        var req_manualno = $(this).data('manualno');
                        var req_date = $(this).data('req_date');
                        var req_depname = $(this).data('depname');
                        var req_depid = $(this).data('depid');
                        var req_depname = $(this).data('depname');
                        var req_reqby = $(this).data('reqby');
                        var req_fromstore = $(this).data('fromstore');
                        var req_tostore = $(this).data('tostore');
                        $('#myView').modal('hide');

                        $('input#req_no').val(req_reqno);

                        $('input#requisition_date').val(req_date);

                        $('#depnme').val(req_depid).trigger('change');

                        $('#frmstore').val(req_fromstore).trigger('change');
                        $('#tostore').val(req_tostore).trigger('change');

                        // $('input#issue_no').val(req_manualno);

                        $('input#receive_by').val(req_reqby);

                        $('input#depname').val(req_depname);
                        $('input#masterid').val(req_masterid);

                        getPendingList(req_masterid, 'main_form',tran);
                        // getPendingList(req_masterid, 'main_form');

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

                        req_masterid = $(this).data('masterid');
                        // console.log(req_masterid);

                        getPendingList(req_masterid);
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

            // console.log(rowid);

            var keypressed = event.keyCode;
            // console.log(keypressed);
            if(keypressed == '40' && rowid < numTR){
                selectedTR.removeClass('selected');
                nextTR = selectedTR.next('tr');

                nextTR.addClass('selected');
                req_masterid = nextTR.data('masterid');
                setTimeout(function(){
                    nextTR.focus();
                    getPendingList(req_masterid);
                }, 100);
            }

            if(keypressed == '38' && rowid != '1'){
                selectedTR.removeClass('selected');
                prevTR = selectedTR.prev('tr');

                prevTR.addClass('selected');
                req_masterid = prevTR.data('masterid');
                setTimeout(function(){
                    prevTR.focus();
                    getPendingList(req_masterid);
                    $('tr[id= listid_'+rowid+']').focus();

                }, 100);
            }

            if(keypressed == '13'){
                req_masterid = selectedTR.data('masterid');
                req_reqno = selectedTR.data('reqno');
                tran = $('.serverDatatable').data('type');
                var req_manualno = selectedTR.data('manualno');
                var req_date = selectedTR.data('req_date');
                var req_depname = selectedTR.data('depname');
                var req_depid = selectedTR.data('depid');
                var req_depname = selectedTR.data('depname');
                var req_reqby = selectedTR.data('reqby');
                var req_fromstore = selectedTR.data('fromstore');
                var req_tostore = selectedTR.data('tostore');
                //console.log(tran);
                // alert(tran);
                $('#myView').modal('hide');

                $('input#req_no').val(req_reqno);

                $('input#requisition_date').val(req_date);

                $('#depnme').val(req_depid).trigger('change');

                // $('input#issue_no').val(req_manualno);
                $('#frmstore').val(req_fromstore).trigger('change');
                $('#tostore').val(req_tostore).trigger('change');
                $('input#receive_by').val(req_reqby);

                $('input#depname').val(req_depname);
                $('input#masterid').val(req_masterid);

                //getPendingList(req_masterid, 'main_form');
                getPendingList(req_masterid, 'main_form',tran);

            }

            // console.log(req_masterid);
            // getPendingList(req_masterid);       
        });
    });

</script>

