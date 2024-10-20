<!-- <style type="text/css">
    table.dataTable tbody tr.selected {
        background-color: #B0BED9;
    }
    table.dataTable tbody tr.active {
        background-color: #B0BED9 !important;
    }
    table.dataTable tbody tr.billentry  {
        color: #28a745 !important;
    }
    table.dataTable tbody tr.pending  {
        color: #ffc107 !important;
    }
    table.dataTable tbody tr.complete {
        color: #28a745 !important;
    }
    .width-300{
      width: 300px;
    }
    .margin-0{
      margin: 0px !important;
    }
    .index_chart li div.complete{ background-color: #28a745 !important; }
    .index_chart li div.pending{ background-color: #ffc107 !important; }
</style> -->
<?php 
foreach ($status_count as $key => $color) 
{
    $statusname=$color->coco_statusname;
    $colors=$color->coco_color;
    $bgcolor=$color->coco_bgcolor;
    ?>
    <style>
        .table-striped tbody tr.<?php echo $statusname;?> td{
            color:<?php echo $colors;  ?>;
        }
       .index_chart li div.<?php echo $statusname; ?>
        {
        background-color:<?php echo $bgcolor; ?>
         }
            .white-box.noborder ul li.<?php echo $statusname; ?>{
            background-color:<?php echo $bgcolor; ?>
        }
    #<?php echo $statusname;?>
    { margin-left: 6px; }
   
    </style>
    <?php
  } 
?>

    <div class="searchWrapper">
   <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="issue_consumption/challan/chalan_lists" data-location="issue_consumption/challan/exportToExcelChallanDetails" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="issue_consumption/challan/chalan_lists" data-location="issue_consumption/challan/generate_pdfChallanDetails" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>

    <div class="row">
       <form class="col-sm-12">
             <?php echo $this->general->location_option(2,'locationid'); ?>
            <div class="col-md-2">
                <label><?php echo $this->lang->line('from_date'); ?></label>
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
            </div>
             <div class="col-md-2">
                <label><?php echo $this->lang->line('to_date'); ?></label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
            </div>

            <div class="col-md-2">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
            <div class="sm-clear"></div>
        </form> 
 
        <div class="col-sm-12">
            <div class="white-box pad-5 noborder">      
                   <ul class="index_chart purchasedOrderUl">
            <?php 
                    if(!empty($status_count)):
                        foreach ($status_count as $key => $color):
                          ?>
                    <li  class="<?php echo $color->coco_statusname; ?>">
                            <a href="javascript:void(0)" data-approvedtype='<?php echo $color->coco_statusname; ?>' class="approvetype">
                                <em class="<?php echo $color->coco_statusname; ?>"></em>
                             <?php echo $color->coco_displaystatus; ?> 
                            <span id="<?php echo $color->coco_statusname; ?>"><?php echo !empty($color->statuscount)?$color->statuscount:'';?>
                            </span>
                        </a> 
                        </li>
                <?php endforeach;
            endif; ?>
            <div class="clearfix"></div>
        </ul> 
            </div>
        </div>
    </div>

    <div class="clear"></div>
</div>
    <div class="table-responsive margin-0">
        <table id="myTable" class="table table-striped">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('fiscal_year'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('order_no'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('order_date').' '.$this->lang->line('ad'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('order_date').' '.$this->lang->line('bs'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('challan_number'); ?></th>
                    <th width="15%"><?php echo $this->lang->line('supplier_name'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('challan_receive_no'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('challan_rcv_date_ad'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('challan_rcv_date_bs'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('sup_challan_no'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('supplier_challan_date'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('action'); ?> </th>
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
     var locationid=$('#locationid').val();
    var toDate=$('#toDate').val();
    var dataurl = base_url+"issue_consumption/challan/chalan_lists";
    var apptype='';
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
        "aTargets": [ 0, 8]
      }
      ],      
      "aoColumns": [
      { "data": null},
      { "data": "fyear"},
      { "data": "purchase_order_no"},
      { "data": "purchase_date_ad"},
      { "data": "purchase_date_bs"},
      { "data": "challannumber"},
       { "data": "supplier"},
       { "data": "challanrecno" },
       { "data": "receivedatead" },
       { "data": "receivedatebs" }, 
       { "data": "suchallanno" },
       { "data": "suchalandatebs" },
       { "data": "action" }
      ],
      "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
        aoData.push({ "name": "locationid", "value": locationid });
        aoData.push({ "name": "apptype", "value": apptype });
      },
      "fnRowCallback" : function(nRow, aData, iDisplayIndex){
            var oSettings = dtablelist.fnSettings();
            $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
            return nRow;
        },
        "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
            var appclass=aData.billentryclass;
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
      { type: "text" },
      { type: "text" },
      { type: "text" },
      { type: "text" },
      { type: "text" },
      { type: "text" },
      { type: null },
     
      ]
    });
    var otherlinkdata=base_url+'issue_consumption/challan/chalan_status';
    var otherdata=get_other_ajax_data(otherlinkdata,frmDate,toDate);
    $(document).off('change','#searchByType')
    $(document).on('click', '#searchByDate', function() {
        apptype= $(this).data('approvedtype');
        frmDate = $('#frmDate').val();
        toDate = $('#toDate').val();
        locationid=$('#locationid').val();
        dtablelist.fnDraw();
        get_other_ajax_data(otherlinkdata,frmDate,toDate,false,locationid);  
    });
    $(document).off('click','.approvetype');
    $(document).on('click','.approvetype',function(){
        apptype= $(this).data('approvedtype'); //alert(apptype);
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();
        locationid=$('#locationid').val();   
        type=$('#searchByType').val(); 
        dtablelist.fnDraw();
      });
      function get_other_ajax_data(action,frmdate=false,todate=false,apptype=false,locid=false){
        var returndata=[];   
        $.ajax({
            type: "POST",
            url: action,
            // data:$('form#'+formid).serialize(),
            dataType: 'html',
            data:{frmdate:frmdate,todate:todate,apptype:apptype,locid:locid} ,
            success: function(jsons) //we're calling the response json array 'cities'
            {
                // console.log(jsons);
                data = jQuery.parseJSON(jsons);  
                var pending=0;
                var complete=0;
                // console.log(data);
                $('#pending').html('');
                $('#complete').html('');
                if(data.status=='success'){
                    challandata=data.status_count;
                    complet=challandata[0].complete;
                    pending=challandata[0].pending;
                }
                $('#complete').html(complet);
                $('#pending').html(pending);
                return false;
            }   
        });
    }
});
</script>
