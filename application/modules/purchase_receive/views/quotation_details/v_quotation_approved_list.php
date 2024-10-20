<style type="text/css">
    table.dataTable tbody tr.selected {
        background-color: #B0BED9;
    }
    table.dataTable tbody tr.active {
        background-color: #B0BED9 !important;
    }
    table.dataTable tbody tr.approved {
        color: #0ab960 !important;
    }
    table.dataTable tbody tr.cancel {
        color: #ff8c00 !important;
    }
    table.dataTable tbody tr.finalapproved {
        color: #0174DF !important;
    }
    table.dataTable tbody tr.rejected {
        color: #e65555 !important;
    }
</style>
<div class="searchWrapper">
    <div class="">
        <form>
             <input type="hidden" id="type" name="type" value="<?php echo $type ?>">
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-md-2">
                        
                        <label><?php echo $this->lang->line('supplier_name'); ?></label>
                        <select class="form-control select2" id="searchBySupplier">
                            <option value="">All</option>
                            <?php
                                if($supplier_all):
                                    foreach ($supplier_all as $ks => $supp):
                                ?>
                            <option value="<?php echo $supp->dist_distributorid; ?>"><?php echo $supp->dist_distributor; ?></option>
                            <?php
                                endforeach;
                                endif;
                                ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label><?php echo $this->lang->line('item_name'); ?></label>
                        <select class="form-control select2" id="searchByItems">
                            <option value="">All</option>
                            <?php
                                if($item_all):
                                    foreach ($item_all as $ks => $itm):
                                ?>
                            <option value="<?php echo $itm->itli_itemlistid; ?>"><?php echo $itm->itli_itemname; ?></option>
                            <?php
                                endforeach;
                                endif;
                                ?>
                        </select>
                    </div>
                     <?php 
                         if($type=='Q'){
                            $date=$this->lang->line('quotation_date');
                            $no=$this->lang->line('quotation_no');
                            $title=$this->lang->line('quotation_approved_list');
                        }else
                        {
                            $date=$this->lang->line('tender_date');
                            $no=$this->lang->line('tender_no');
                            $title=$this->lang->line('tender_approved_list');
                        }
                        ?>
                    <div class="col-md-2">
                        <label for="Supplier"><?php echo $this->lang->line('select_date_wise'); ?>: </label>
                        <select  class="form-control" id="dateSearch">
                            <option value="">---select---</option>
                            <option value="entrydate">Entry Date</option>
                            <option value="validate">Till Date</option>
                            <option value="supplierdate">Supplier Date</option>
                            <option value="quotationdate"><?php echo $date ?></option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label><?php echo $this->lang->line('from'); ?></label>
                        <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
                    </div>

                    <div class="col-md-1">
                        <label><?php echo $this->lang->line('to'); ?></label>
                        <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
                    </div>

                    <div class="col-md-2">
                <?php 
                    $fyear=!empty($this->input->post('fyear'))?$this->input->post('fyear'):'';
                ?>
                <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> <span class="required">*</span>:</label>
                <select name="fyear" class="form-control required_field select2" id="fiscalyrs" >
                    <option value="">---select---</option>
                    <?php
                        if($fiscal):

                            // echo "Check";
                            // echo "<pre>";
                            // print_r($fiscal);
                            // die();

                            foreach ($fiscal as $km => $fy):
                    ?>
                        <option value="<?php echo $fy->fiye_name; ?>" <?php if($fy->fiye_name==$fyear) echo "selected=selected"; ?>><?php echo $fy->fiye_name; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>

                    <div class="col-md-2">
                        <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
                    </div>
                    <div class="sm-clear"></div>
                </div>
                <div class="col-sm-12">
                    <div class="white-box pad-5">
                        <ul class="index_chart">
                            <li>
                                <div class="pending"></div><a href="javascript:void(0)" data-approvedtype='pending' class="approvetype"> <?php echo $this->lang->line('pending'); ?></a> 
                                <span id="pending"><?php echo !empty($status_count[0]->pending)?$status_count[0]->pending:'';?></span>
                            </li>
                            
                            <li>
                                <div class="approved"></div> <a href="javascript:void(0)" data-approvedtype='approved' class="approvetype" ><?php echo $this->lang->line('approved'); ?> </a>
                                <span id="approved"><?php echo !empty($status_count[0]->approved)?$status_count[0]->approved:'';?></span>
                            </li>
                            
                            <li>
                                <div class="n_approved"></div> <a href="javascript:void(0)" data-approvedtype='finalapproved' class="approvetype"><?php echo $this->lang->line('verified'); ?> </a>
                                <span id="finalapproved"><?php echo !empty($status_count[0]->finalapproved)?$status_count[0]->finalapproved:'';?></span>
                            </li>
                            <li>
                                <div class="cancel"></div> <a href="javascript:void(0)" data-approvedtype='rejected' class="approvetype"><?php echo $this->lang->line('rejected'); ?> </a>
                                <span id="cancel"><?php echo !empty($status_count[0]->rejected)?$status_count[0]->rejected:'';?></span>
                            </li>
                           
                            <div class="clearfix"></div>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="purchase_receive/quotation_details/quotation_details_list" data-location="purchase_receive/quotation_details/exportToExcel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="purchase_receive/quotation_details/quotation_details_list" data-location="purchase_receive/quotation_details/generate_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    <div class="clear"></div>
</div>
<div class="clearfix"></div>
<div class="pad-5 mtop_10">
    <h3 class="box-title"><?php echo $title; ?></h3>
    <div class="table-responsive">
        <table id="myTable" class="table table-striped ">
            <thead>
                <th width="2%"><?php echo $this->lang->line('sn'); ?></th>
                <th width="8%"><?php echo $this->lang->line('item_code'); ?></th>
                <th width="14%"><?php echo $this->lang->line('item_name'); ?></th>
                <th width="13%"><?php echo $this->lang->line('supplier_name'); ?></th>
                <th width="9%"><?php echo $date ?></th>
                <th width="9%"><?php echo $no; ?></th>
                <th width="8%"><?php echo $this->lang->line('rate'); ?></th>
                <th width="5%"><?php echo $this->lang->line('dis'); ?></th>
                <th width="5%"><?php echo $this->lang->line('vat'); ?></th>
                <th width="10%"><?php echo $this->lang->line('net_rate'); ?></th>
                <th width="10%"><?php echo $this->lang->line('remarks'); ?></th>
                <th width="10%"><?php echo $this->lang->line('valid_till'); ?></th>
                <th width="10%"><?php echo $this->lang->line('action'); ?></th>
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

<?php
    $apptype = $this->input->post('dashboard_data');
    if($apptype){
        $apptype = $apptype; 
    }else{
        $apptype = "";
    }
?>
<script type="text/javascript">
    function get_other_ajax_data(action,frmdate=false,todate=false,othertype=false,items=false,supplier=false)
        {
         
            var returndata=[];   
            $.ajax({
            type: "POST",
            url: action,
            // data:$('form#'+formid).serialize(),
            dataType: 'html',
            data:{frmdate:frmdate,todate:todate,othertype:othertype,items:items,supplier:supplier} ,
            success: function(jsons) //we're calling the response json array 'cities'
            {
              // console.log(jsons);
                data = jQuery.parseJSON(jsons);  
                var pending=0;
                var  approved=0;
                 var unapproved=0;
                 var rejected=0; 
                 var expired=0; 
                // console.log(data);
                    $('#pending').html('');
                    $('#approved').html('');
                    $('#unapproved').html('');
                    $('#cancel').html('');
                    $('#expired').html('');
                if(data.status=='success')
                {
                    returndata=data.status_count;
                     // console.log(returndata);
                     // console.log(returndata[0].pending)
                    pending=returndata[0].pending;
                    approved=returndata[0].approved;
                    unapproved=returndata[0].finalapproved;
                    rejected=returndata[0].rejected;        
                    expired=returndata[0].expired;        
                }
                $('#pending').html(pending);
                $('#approved').html(approved);
                $('#unapproved').html(unapproved);
                $('#cancel').html(rejected);
                $('#expired').html(expired);
                return false;
            }
        });
    }
    $(document).ready(function() {
        var frmDate = $('#frmDate').val();
        var toDate = $('#toDate').val();
        var supplier = $('#searchBySupplier').val();
        var items = $('#searchByItems').val();
        var date = $('#dateSearch').val();
        var apptype='<?php echo $apptype; ?>';
        // var  apptype= $(this).data('approvedtype');
        var type = $('#type').val();
        // var supplier = '';

        var dataurl = base_url + "purchase_receive/quotation_details/quotation_details_list";
        //var dataurl = base_url + "purchase_receive/quotation_details/quotation_details_list" + '/approvedonly';
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
                [9, 'asc']
            ],
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": dataurl,
            "oLanguage": {
                "sEmptyTable": message
            },
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 12]
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
                { "data": "tilldate" },
                { "data": "action" },
            ],
            "fnServerParams": function(aoData) {
                    aoData.push({"name": "frmDate","value": frmDate});
                    aoData.push({"name": "toDate","value": toDate});
                    aoData.push({"name": "supplier","value": supplier});
                    aoData.push({"name": "items","value": items});
                    aoData.push({"name": "date","value": date});
                    aoData.push({"name": "apptype","value": apptype});
                    aoData.push({"name": "type","value": type});

            },
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = dtablelist.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                return nRow;
            },
            "fnCreatedRow": function(nRow, aData, iDisplayIndex) {
                var oSettings = dtablelist.fnSettings();
                var tblid = oSettings._iDisplayStart + iDisplayIndex + 1
                var appclass=aData.approveclass;
                $(nRow).attr('class', appclass);
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
                { type: "text" },
                { type: null },
                { type: null },
            ]
        });
        var otherlinkdata=base_url+'purchase_receive/quotation_details/quotation_summary';
        var otherdata=get_other_ajax_data(otherlinkdata,frmDate,toDate,date,items,supplier);

        $(document).on('click', '#searchByDate', function() {
            frmDate = $('#frmDate').val();
            apptype= $(this).data('approvedtype');
            toDate = $('#toDate').val();
            supplier = $('#searchBySupplier').val();
            items = $('#searchByItems').val();
            date = $('#dateSearch').val();
            dtablelist.fnDraw();
            get_other_ajax_data(otherlinkdata,frmDate,toDate,date,items,supplier); 
        });
        $(document).off('click','.approvetype');
        $(document).on('click','.approvetype',function(){
            apptype= $(this).data('approvedtype');
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
            supplier = $('#searchBySupplier').val();
            items = $('#searchByItems').val();
            date = $('#dateSearch').val(); 
            dtablelist.fnDraw();  
        });

        $(document).on('change', '#searchBySupplier', function() {
            supplier = $('#searchBySupplier').val();
            dtablelist.fnDraw();
        });

        $(document).on('change', '#searchByItems', function() {
            items = $('#searchByItems').val();
            dtablelist.fnDraw();
        });
    });
</script>

<script type="text/javascript">
    $('.engdatepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });
    $('.nepdatepicker').nepaliDatePicker();
</script>

