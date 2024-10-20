<style type="text/css">
    table.dataTable tbody tr.directreceived {
        color: #ff8000;
    }
    table.dataTable tbody tr.cancel  {
        color: #33b384 !important;
    }
    table.dataTable tbody tr.returno {
        color: #0174DF !important;
    }

    #returno{ margin-left: 6px; }
    #cancel{ margin-left: 6px; }
    #directreceived{ margin-left: 6px; }
    #issuereturno{ margin-left: 6px; }
    .index_chart li div.cancel {
        background-color: #33b384;
    }
    .index_chart li div.returno {
        background-color: #0174DF;
    }
    .index_chart li div.directreceived {
        background-color: #ff8000;
    }
</style>
<div class="white-box">
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="purchase_receive/return_analysis/direct_purchase_details_return_list" data-location="purchase_receive/direct_purchase/exportToExcelReturn" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="purchase_receive/return_analysis/direct_purchase_details_return_list" data-location="purchase_receive/direct_purchase/generate_pdfReturn" data-tableid="#myTable"><i class="fa fa-print"></i></a>
        <div class="sm-clear"></div>
    </div>
    <div class="white-box pad-5">
        <form class="col-sm-8">

        <?php echo $this->general->location_option(2,'locationid'); ?>
           <div class="col-md-2">
                <label><?php echo $this->lang->line('date_search'); ?> :</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_range">By Date Range</option>
                    <option value="date_all">All</option>
                </select>
            </div>
             <div class="dateRangeWrapper">
            <div class="col-md-2">
                <label><?php echo $this->lang->line('from_date'); ?></label>
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
            </div>
            <div class="col-md-2">
                <label><?php echo $this->lang->line('to_date'); ?></label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
            </div>
            </div>
           <!--  <div class="col-md-4">
                <label>Supplier Wise :</label>
                <select name="supplier" class="form-control select2" id="supplier">
                    <option value="">-------------- All --------------</option>
                    <?php
                        if($supplier_all):  
                            foreach ($supplier_all as $km => $sup):
                    ?>
                    <option value="<?php echo $sup->supp_supplierid; ?>"><?php echo $sup->supp_suppliername; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div> -->

             <div class="col-md-2">
                <label>Print Orientation</label>
                <select name="page_orientation" id="page_orientation" class="form-control">
                    <option value="P">Portrait </option>
                    <option value="L">Landscape</option>
                </select>
            </div>
            <div class="col-md-2">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;">Search</a>
            </div>
        </form>
        <ul class="index_chart purchasedOrderUl">
            <li>
                <div class="directreceived"></div> <a href="javascript:void(0)" data-approvedtype='directreceived' class="approvetype"><?php echo $this->lang->line('direct_purchase'); ?> </a>
                <span id="directreceived"> <?php echo !empty($status_count[0]->directreceived)?$status_count[0]->directreceived:'';?></span>
            </li>
            <li>
                <div class="cancel"></div><a href="javascript:void(0)" data-approvedtype='cancel' class="approvetype"><?php echo $this->lang->line('canceled'); ?></a> 
                <span id="cancel"> <?php echo !empty($status_count[0]->cancel)?$status_count[0]->cancel:'';?></span>
            </li>
            <li>
                <div class="returno"></div> <a href="javascript:void(0)" data-approvedtype='returno' class="approvetype"><?php echo $this->lang->line('return'); ?> </a>
                <span id="returno"> <?php echo !empty($return_count[0]->total)?$return_count[0]->total:'';?></span>
            </li>
            <div class="clearfix"></div>
        </ul>
    </div>
    <div  id="FormDiv_orderDetails" class="formdiv frm_bdy">
        <div class="pad-5">
            <div class="table-responsive">
                <table id="myTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th width="3%"><?php echo $this->lang->line('sn'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('date'); ?></th>
                            <th width="20%"><?php echo $this->lang->line('supplier_name'); ?></th>
                            <th width="6%"><?php echo $this->lang->line('item_code'); ?></th>
                            <th width="20%"><?php echo $this->lang->line('item_name'); ?></th> 
                            <th width="5%"><?php echo $this->lang->line('qty'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('rate'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('dis'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('tax'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('amount'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('description'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
        $(document).ready(function(){
        var frmDate=$('#frmDate').val();
        var toDate=$('#toDate').val();

         var type = $('#searchByType').val();

        var searchDateType = $('#searchDateType').val();

        if (searchDateType == 'date_all') {
            frmDate = '';
            toDate = '';
        }
        var supplier = $('#supplier').val();
        var locationid = $('#locationid').val();
        var item = $('#item').val();
        var apptype='';
        var dataurl = base_url+"purchase_receive/return_analysis/direct_purchase_details_return_list";
        var message='';
        var showview='<?php echo MODULES_VIEW; ?>';
        // alert(showview);
        if(showview=='N')
        {
        message="<p class='text-danger'>Permission Denial</p>";
        }
        else
        {
        message="<p class='text-danger'>No Record Found!! </p>";
        }
        
        
        var dtablelist = $('#myTable').dataTable({
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
        "aTargets": [ 0,10 ]
        }
        ],
        "aoColumns": [
       { "data": "sno" },
        { "data": "recm_receiveddatebs" },
        // { "data": "recm_invoiceno" },
        // { "data": "orderno" },
        { "data": "dist_distributor" },
        { "data": "itli_itemcode" },
        { "data": "itli_itemname" },  
        { "data": "recd_purchasedqty" },
        { "data": "recd_unitprice" },
        //{ "data": "itli_itemlistid" },
        { "data": "recm_discount" },
        { "data": "recm_taxamount" },
        //{ "data": "recm_status" },
        { "data": "recm_amount" },
        { "data": "recd_description" },

       
        
        ],
        "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
        aoData.push({ "name": "apptype", "value": apptype });
        aoData.push({ "name": "supplier", "value": supplier });
         aoData.push({"name": "locationid","value": locationid});
          aoData.push({ "name": "type","value": type });
        },
        "fnRowCallback" : function(nRow, aData, iDisplayIndex){
        var oSettings = dtablelist.fnSettings();
        $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
        return nRow;
        },
        "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
             var appclass=aData.approvedclass;
        var oSettings = dtablelist.fnSettings();
        var tblid= oSettings._iDisplayStart+iDisplayIndex +1
        $(nRow).attr('id', 'listid_'+tblid);
        $(nRow).attr('class', appclass);
        },
        }).columnFilter(
        {
        sPlaceHolder: "head:after",
        aoColumns: [ {type: null},
        { type: "text" },
        { type: "text" },
        { type: "text" }, 
        { type: "text" },
        { type: null },
        { type: null },
        { type: null },
        { type: null },
       
        { type: null },
        { type: null },
        //{ type: null },
        ]
        });
        var otherlinkdata=base_url+'purchase_receive/return_analysis/purchased_summary';

        var otherdata=get_other_ajax_data(otherlinkdata,frmDate,toDate);

        $(document).off('change','#searchByType')
        $(document).on('click', '#searchByDate', function() {
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
            supplier = $('#supplier').val();
            locationid = $('#locationid').val();
            item = $('#item').val();
            locationid = $('#locationid').val();
             type = $('#searchByType').val();
            searchDateType = $('#searchDateType').val();

            if (searchDateType == 'date_all') {
                frmDate = '';
                toDate = '';
            }

            dtablelist.fnDraw();
            get_other_ajax_data(otherlinkdata,frmDate,toDate,false,false,locationid);
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
        
        $(document).off('click','.approvetype');
        $(document).on('click','.approvetype',function(){
            apptype= $(this).data('approvedtype');
            
            if(apptype == 'directreceived' || apptype == 'issue' || !apptype){
                $('.tr_return').hide();
                $('.tr_issue').show();
            }else if(apptype == 'returno'){
                $('.tr_return').show();
                $('.tr_issue').hide();
            }
            frmDate=$('#frmDate').val();
            toDate=$('#toDate').val();  
            type=$('#searchByType').val(); 
            locationid = $('#locationid').val(); 
            searchDateType = $('#searchDateType').val();

            if (searchDateType == 'date_all') {
                frmDate = '';
                toDate = '';
            }
            dtablelist.fnDraw();  
            get_other_ajax_data(otherlinkdata,frmDate,toDate,apptype,type,locationid);   
        });

        function get_other_ajax_data(action,frmdate=false,todate=false,apptype = false, type=false,locationid = false){
            var returndata=[];   
            $.ajax({
                type: "POST",
                url: action,
                // data:$('form#'+formid).serialize(),
                dataType: 'html',
                data:{frmdate:frmdate,todate:todate,apptype:apptype,type:type,locationid:locationid} ,
                success: function(jsons) //we're calling the response json array 'cities'
                {
                    // console.log(jsons);
                    data = jQuery.parseJSON(jsons);  
                    var directreceived=0;
                    var returno=0;
                    var cancel=0;
                    // console.log(data);
                    $('#returno').html('');
                    $('#directreceived').html('');
                    $('#cancel').html('');
                    if(data.status=='success'){
                        issuedata=data.status_count;
                        returndata=data.return_count;

                        // console.log(issuedata);
                        // console.log(issuedata[0].cancel)
                        returno=returndata[0].total;
                        directreceived=issuedata[0].directreceived;
                        cancel=issuedata[0].cancel;        
                    }
                    $('#returno').html(returno);
                    $('#directreceived').html(directreceived);
                    $('#cancel').html(cancel);

                    return false;
                }   
            });
        }
    });
</script>