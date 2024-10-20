<!-- 
  <style>
        .table-striped tbody tr.handover td{
            color:#FF8C00;
        }
        .table-striped tbody tr.received td{
         color:#0ab960;
        }
       .index_chart li div.handover
        {
        background-color:#FF8C00;
         }
       
       .index_chart li div.received
        {
        background-color:#0ab960;
         }
     </style> -->
     <!-- <h3 class="box-title">Issue Book List </h3> -->
     <?php 
// $color_codeclass=$this->general->get_color_code('*','coco_colorcode',array('coco_isactive'=>'Y','coco_listname'=>'req_demandsummary','coco_isallorg'=>'Y'));
     foreach ($status_count as $key => $color) 
    // print_r($color_codeclass);die;
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
        </style>
        <?php
    } 
    ?>

    <div class="searchWrapper">
     
        <div class="">
            <form class="col-sm-8">
                <?php echo $this->general->location_option(2,'to_branch'); ?>
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

            <div class="col-sm-4">
                <div class="white-box pad-5 noborder">
                    <ul class="index_chart">
                       <?php
                       if(!empty($status_count)):
                        foreach ($status_count as $key => $color):

                          ?>

                          <li>
                            <div class="<?php echo $color->coco_statusname; ?>"></div><a href="javascript:void(0)" data-approvedtype='<?php echo $color->coco_statusname; ?>' class="approvetype"> <?php echo $color->coco_displaystatus; ?></a> 
                            <span id="<?php echo $color->coco_statusname; ?>"><?php echo !empty($color->statuscount)?$color->statuscount:'';?>
                            
                        </span>
                    </li>
                <?php endforeach;
            endif; ?>
            
            
            
            
            <div class="clearfix"></div>
            
        </ul>
    </div>
</div>
<div class="pull-right" style="margin-top:15px;">
    <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="handover/handover_issue/handover_issue_summary_list" data-location="handover/handover_issue/exportToExcelReqlist" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

    <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="handover/handover_issue/handover_issue_summary_list" data-location="handover/handover_issue/generate_pdfReqlist" data-tableid="#myTable"><i class="fa fa-print"></i></a>
</div>
</div>

<div class="clear"></div>
</div>
<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped">
            <thead>
                <tr class="tr_issue">
                  <th width="3%"><?php echo $this->lang->line('sn'); ?></th>
                  <th width="5%"><?php echo $this->lang->line('handover_issue_no'); ?></th>
                  <th width="5%">Hand. Req.NO</th>
                  <th width="8%" ><?php echo $this->lang->line('date').'('.$this->lang->line('ad').')'; ?></th>
                  <th width="8%" ><?php echo $this->lang->line('date').'('.$this->lang->line('bs').')'; ?></th>
                  <th width="6%">Is Received?</th>
                  <th width="7%">Handover To</th>
                  <th width="7%">Handover Time</th>
                  <th width="6%"><?php echo $this->lang->line('fiscal_year'); ?> </th>
                  <th width="7%"><?php echo $this->lang->line('action'); ?></th>
              </tr>
              
          </thead>
          <tbody>
          </tbody>
      </table>
  </div>
</div>
<div id="FormDiv_issueReprint" class=" newPrintSection printTable"></div>


<script type="text/javascript">
    $(document).ready(function(){
        var frmDate=$('#frmDate').val();
        var toDate=$('#toDate').val();
        var locationid=$('#locationid').val();
        var apptype= $(this).data('approvedtype');
        var apptype='';
        var dataurl = base_url+"handover/handover_issue/handover_issue_summary_list";
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
            { "data": "sno"},
            { "data": "handover_no" },
            { "data": "handover_req_no" },
            { "data": "date_ad"},
            { "data": "date_bs" },
            { "data": "haov_isreceived" },
            { "data": "handover_to" },
            { "data": "time" },
            { "data": "fyear" },
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
    { type: "text" },
    { type: "text" },
    { type: "text" },
    { type: "text" },
    { type: null },
    ]
});

var otherlinkdata=base_url+'handover/handover_issue/handover_issue_summary';

var otherdata=get_other_ajax_data(otherlinkdata,frmDate,toDate,false,locationid);

$(document).off('change','#searchByType')
$(document).on('click', '#searchByDate', function() {
    frmDate = $('#frmDate').val();
    toDate = $('#toDate').val();
    locationid=$('#locationid').val();
    dtablelist.fnDraw();
        // get_other_ajax_data(otherlinkdata,frmDate,toDate,false,locationid);  
    });


$(document).off('click','.approvetype');
$(document).on('click','.approvetype',function(){
 apptype= $(this).data('approvedtype');
        // alert(apptype);
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();  
        locationid=$('#locationid').val();
        dtablelist.fnDraw();  
         // get_other_ajax_data(otherlinkdata,frmDate,toDate,apptype);   
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

                var handover=0;
                var received=0;
                
                // console.log(data);
                $('#handover').html('');
                $('#return').html('');
                
                if(data.status=='success'){
                    handoverdata=data.status_count;
                    

                    // console.log(handoverdata);
                    // console.log(handoverdata[0].cancel)
                    handover=handoverdata[0].handover;
                    received=handoverdata[0].received;
                    
                }
                $('#handover').html(handover);
                $('#received').html(received);
                
                return false;
                // handoverdata=data.status_count;
                //    $.each(handoverdata,function(i,k){
                //      var k.haov_statusname=0;
                //      $('#'+k.haov_statusname).html('');
                //        if(data.status=='success'){
                //         k.haov_statusname=handoverdata[0]. k.haov_statusname;
                //        }
                //          $('#'+k.haov_statusname).html( k.haov_statusname);

                //  });
                
            }   
        });
}
});
</script>