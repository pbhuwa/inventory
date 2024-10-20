<style type="text/css">
    table.dataTable tbody tr.pending {
        color: #ff8000;
    }
    table.dataTable tbody tr.complete  {
        color: #33b384 !important;
    }
    table.dataTable tbody tr.partialcomplete {
        color: #0174DF !important;
    }

    #partialcomplete{ margin-left: 6px; }
    #complete{ margin-left: 6px; }
    #pending{ margin-left: 6px; }
    #issuereturn{ margin-left: 6px; }
    .index_chart li div.complete {
        background-color: #33b384;
    }
    .index_chart li div.partialcomplete {
        background-color: #0174DF;
    }

    /* table.dataTable tbody tr.returncancel {
        color: #FF8000 !important;
    }*/
</style>
<div class="white-box">
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="purchase_receive/purchase_order/search_allpurchase_item_list" data-location="purchase_receive/purchase_order/exportToExcel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="purchase_receive/purchase_order/search_allpurchase_item_list" data-location="purchase_receive/purchase_order/generate_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    <div class="sm-clear"></div>
    <div class="white-box pad-5">
        <form class="col-sm-8">
            <div class="col-md-2">
                <label><?php echo $this->lang->line('from_date'); ?></label>
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
            </div>
            <div class="col-md-2">
                <label><?php echo $this->lang->line('to_date'); ?></label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
            </div>
            <div class="col-md-4">
                <label><?php echo $this->lang->line('supplier_wise'); ?> :</label>
                
                  <select name="supplier" class="form-control select2" id="supplier">
                <option value="">---select---</option>
                <?php
                    if(!empty($distributor)):
                        foreach ($distributor as $km => $sup):
                ?>
                 <option value="<?php echo $sup->dist_distributorid; ?>" ><?php echo $sup->dist_distributor; ?></option>
                <?php
                        endforeach;
                    endif;
                ?>
            </select>
            </div>
           <!--  <div class="col-md-4">
                <label>Item Wise :</label>
                <select name="item" class="form-control select2" id="item">
                    <option value="">-------------- All --------------</option>
                    <?php
                        if($item_all):  
                            foreach ($item_all as $km => $sup):
                    ?>
                    <option value="<?php echo $sup->itli_itemlistid; ?>"><?php echo $sup->itli_itemname; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div> -->
            <div class="col-md-2">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
        <ul class="index_chart purchasedOrderUl">
            <li>
                <div class="pending"></div> <a href="javascript:void(0)" data-approvedtype='pending' class="approvetype"><?php echo $this->lang->line('pending'); ?> </a>
                <span id="pending"> <?php echo !empty($status_count[0]->pending)?$status_count[0]->pending:'';?></span>
            </li>
            <li>
                <div class="complete"></div><a href="javascript:void(0)" data-approvedtype='complete' class="approvetype"> <?php echo $this->lang->line('completetly_received'); ?></a> 
                <span id="complete"> <?php echo !empty($status_count[0]->complete)?$status_count[0]->complete:'';?></span>
            </li>
            <li>
                <div class="partialcomplete"></div> <a href="javascript:void(0)" data-approvedtype='partialcomplete' class="approvetype"> <?php echo $this->lang->line('partially_received'); ?></a>
                <span id="partialcomplete"> <?php echo !empty($status_count[0]->partialcomplete)?$status_count[0]->partialcomplete:'';?></span>
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
                            <th width="5%"><?php echo $this->lang->line('order_no'); ?></th>
                             <th width="5%"><?php echo $this->lang->line('fiscal_year'); ?></th>
                            <th width="8%"><?php echo $this->lang->line('order_date'); ?>(<?php echo $this->lang->line('ad'); ?>) </th>
                            <th width="8%"><?php echo $this->lang->line('order_date'); ?>(<?php echo $this->lang->line('bs'); ?>)</th>
                            <th width="8%"><?php echo $this->lang->line('delivery_date'); ?>(<?php echo $this->lang->line('ad'); ?>)</th>
                            <th width="8%"><?php echo $this->lang->line('delivery_date'); ?>(<?php echo $this->lang->line('bs'); ?>)</th>
                            <th width="18%"><?php echo $this->lang->line('delivery_site'); ?></th>
                            <th width="8%"><?php echo $this->lang->line('supplier_name'); ?></th> 
                            <th width="10%"><?php echo $this->lang->line('order_amount'); ?></th>
                            <th width="8%"><?php echo $this->lang->line('req_no'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('approved'); ?></th>
                            <th width="8%"><?php echo $this->lang->line('action'); ?></th>
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
            alert('tes');  var frmDate=$('#frmDate').val();
        var toDate=$('#toDate').val();
        var supplier = $('#supplier').val();
        var item = $('#item').val();
        var apptype='';
        // var rslt='<?php echo !empty($result)?$result:''; ?>';
        // var orgid='<?php echo !empty($org_id)?$org_id:''; ?>';
        //var dataurl = base_url+"biomedical/purchase_receive/analysis_ii_list/"+rslt+'/'+orgid;
        var dataurl = base_url+"purchase_receive/purchase_order/purchase_order_book_list";
        var message='';
        var showview='<?php echo MODULES_VIEW; ?>';
        //alert(showview);
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
        "aTargets": [ 0,11,12]
        }
        ],
        "aoColumns": [
        { "data": "puor_purchaseordermasterid" },
        { "data": "orderno" },
         { "data": "fyear" },
         { "data": "puor_orderdatead" },
        { "data": "puor_orderdatebs" },
        { "data": "puor_deliverydatead" },
        { "data": "puor_deliverydatebs" },
        { "data": "puor_deliverysite" },
        { "data": "supplier" },
        { "data": "totalamount" },
        { "data": "requno" },
        { "data": "puor_approvedby" },
        { "data": "action" }
       
        
        ],
        "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
        aoData.push({ "name": "apptype", "value": apptype });
        aoData.push({ "name": "supplier", "value": supplier });

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
        var otherlinkdata=base_url+'purchase_receive/purchase_order/purchased_summary';

        var otherdata=get_other_ajax_data(otherlinkdata,frmDate,toDate);

        $(document).off('change','#searchByType')
        $(document).on('click', '#searchByDate', function() {
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
            supplier = $('#supplier').val();
            item = $('#item').val();
            dtablelist.fnDraw();
            get_other_ajax_data(otherlinkdata,frmDate,toDate,supplier,item);  
        });
        $(document).off('click','.approvetype');
        $(document).on('click','.approvetype',function(){
            supplier = $('#supplier').val();
            item = $('#item').val();
            apptype= $(this).data('approvedtype');
            // alert(apptype);
            if(apptype == 'cancel' || apptype == 'issue' || !apptype){
                $('.tr_return').hide();
                $('.tr_issue').show();
            }else if(apptype == 'issuereturn' || apptype == 'returncancel'){
                $('.tr_return').show();
                $('.tr_issue').hide();
            }
            frmDate=$('#frmDate').val();
            toDate=$('#toDate').val();  
            type=$('#searchByType').val(); 
            dtablelist.fnDraw();  
            get_other_ajax_data(otherlinkdata,frmDate,apptype,type,supplier,item);   
        });

        function get_other_ajax_data(action,frmdate=false,todate=false,othertype=false){
            var returndata=[];   
            $.ajax({
                type: "POST",
                url: action,
                // data:$('form#'+formid).serialize(),
                dataType: 'html',
                data:{frmdate:frmdate,todate:todate,othertype:othertype} ,
                success: function(jsons) //we're calling the response json array 'cities'
                {
                    // console.log(jsons);
                    data = jQuery.parseJSON(jsons);  
                    var pending=0;
                    var partialcomplete=0;
                    var complete=0;
                    // console.log(data);
                    $('#partialcomplete').html('');
                    $('#pending').html('');
                    $('#complete').html('');
                    if(data.status=='success'){
                        issuedata=data.status_count;

                        // console.log(issuedata);
                        // console.log(issuedata[0].cancel)
                        partialcomplete=issuedata[0].partialcomplete;
                        pending=issuedata[0].pending;
                        complete=issuedata[0].complete;        
                    }
                    $('#partialcomplete').html(partialcomplete);
                    $('#pending').html(pending);
                    $('#complete').html(complete);

                    return false;
                }   
            });
        }
    });
</script>