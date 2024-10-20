    <?php
    $recommend_qty_view_group = array('SA','DM','DS');
    ?>
    <?php 
// $color_codeclass=$this->general->get_color_code('*','coco_colorcode',array('coco_isactive'=>'Y','coco_listname'=>'req_demandsummary','coco_isallorg'=>'Y'));
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
          .white-box.noborder ul li.<?php echo $statusname; ?>{
            background-color:<?php echo $bgcolor; ?>
        }
    </style>
    <?php
    } 
  ?>
   <style>
        .table-striped tbody tr.cntissue td{
            color:#373a48;
        }
          .white-box.noborder ul li.cntissue{
            background-color:#373a48;
        }
    </style>

    <div class="searchWrapper">

      <div class="row">
        <form class="col-sm-12">

          <?php echo $this->general->location_option(); ?>
          <div class="col-md-2">
            <label><?php echo $this->lang->line('from_date'); ?> :</label>
            <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
          </div>
          <div class="col-md-2">
            <label><?php echo $this->lang->line('to_date'); ?>:</label>
            <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
          </div>
          
          <div class="col-md-2">
            <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
          </div>

          <div class="sm-clear"></div>
          
          <div class="clearfix"></div>
        </form> 
        <div class="col-sm-12">
          <div class="white-box pad-5 noborder">

            <ul class="index_chart">
           <?php 
                    if(!empty($status_count)):
                        foreach ($status_count as $key => $color):

                          ?>

                     
                    <li  class="<?php echo $color->coco_statusname; ?>">
                            <!-- <div class="<?php echo $color->coco_statusname; ?>"></div> -->
                            <a href="javascript:void(0)" data-approvedtype='<?php echo $color->coco_statusname; ?>' class="approvetype">
                                <em class="<?php echo $color->coco_statusname; ?>"></em>
                             <?php echo $color->coco_displaystatus; ?> 
                            <span id="<?php echo $color->coco_statusname; ?>"><?php echo !empty($color->statuscount)?$color->statuscount:'';?>
                            </span>
                        </a> 
                            
                        </li>
                <?php endforeach;
            endif; ?>

             
                       <li  class="cntissue">
                            <!-- <div class="<?php echo $color->coco_statusname; ?>"></div> -->
                            <a href="javascript:void(0)" data-approvedtype='<?php echo $color->coco_statusname; ?>' class="approvetype">
                                <em class="cntissue"></em>
                            Total User
                            <span id="cntissue"><?php echo !empty($total_count[0]->cntissue)?$total_count[0]->cntissue:'';?></span>
                        </a> 
                            
                        </li>
              <div class="clearfix"></div>

            </ul>
            
          </div>
        </div>
      </div>

      <div class="clear"></div>
    </div>

    <div class="pad-5">
      <div class="table-responsive">
        <table id="myTable" class="table table-striped ">
          <thead>
            <tr>
             <th><?php echo $this->lang->line('sn'); ?></th>
             <th><?php echo $this->lang->line('username'); ?></th>
             <th><?php echo $this->lang->line('full_name'); ?></th>
             <th><?php echo $this->lang->line('department'); ?></th>
             <th><?php echo $this->lang->line('phone'); ?></th>
             <th>Post Date(BS)</th>
             <th>Post Date (AD)</th>
             <th>Status</th>
             <th>IsActive</th>
             <th><?php echo $this->lang->line('action'); ?></th>
           </tr>
         </thead>
         <tbody>

         </tbody>
       </table>
     </div>
   </div>
   <div class="modal fade" id="Applyresponse" role="dialog">
     <div class="modal-dialog">
      <div class="modal-content">
       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
       <div id="response_error" class="alert alert-danger" ></span>
        <div id="response_apply_success" class="alert alert-success" ></span>
        </div>
        <div class="text-right">
         <button type="button" id="btnEmailSend" class="btn btn-danger" data-dismiss="modal">Close</button>
       </div>
     </div>
   </div>
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
 function get_other_ajax_data(action,frmdate=false,todate=false,locationid=false ,departmentid=false){

  var returndata=[];   
  $.ajax({
    type: "POST",
    url: action,
            // data:$('form#'+formid).serialize(),
            dataType: 'html',
            data:{frmdate:frmdate,todate:todate,locationid:locationid,departmentid:departmentid} ,
            
            success: function(jsons) //we're calling the response json array 'cities'
            {
                // console.log(jsons);
                data = jQuery.parseJSON(jsons);

                var pending=0;
                var approved=0;
                var cancel=0;
                var cntissue=0; 
                  console.log(data);
                $('#pending').html('');
                $('#approved').html('');
                $('#cancel').html('');
                $('#cntissue').html('');

                if(data.status=='success')
                {
                  req_data=data.status_count;
                  req_total_data=data.total_count;
                    // console.log(req_data);
                    // console.log(req_data[0].pending)
                    pending=req_data[0].pending;
                    approved=req_data[0].approved;
                    cancel=req_data[0].cancel;
                    cntissue=req_total_data[0].cntissue;
                  }
                  $('#pending').html(pending);
                  $('#approved').html(approved);
                  $('#cancel').html(cancel);
                  $('#cntissue').html(cntissue);
                  return false;
                }
              });
}

$(document).ready(function(){
  var departmentid=$('#departmentid').val(); 
  var frmDate=$('#frmDate').val();
  var toDate=$('#toDate').val();
  var locationid=$('#locationid').val();

  var apptype='<?php echo $apptype; ?>';
  var dataurl = base_url+"settings/user_register/reister_user_list";
  var message='';
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
    "aTargets": [ 0,7]
  }
  ],      
  "aoColumns": [
  { "data": "sno" },
  { "data": "usre_username" },
  { "data": "usre_fullname" },
  { "data": "usre_departmentid" },
  { "data": "usre_phoneno" },
  { "data": "usre_postdatebs" },
  { "data": "usre_postdatead" },
  { "data": "status" },
  { "data": "isactive" },
  { "data": "action" }
  ],
  "fnServerParams": function (aoData) {
        // aoData.push({ "name": "frmDate", "value": frmDate });
        // aoData.push({ "name": "toDate", "value": toDate });
        aoData.push({ "name": "departmentid", "value": departmentid });
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
       var oSettings = dtablelist.fnSettings();
       var tblid= oSettings._iDisplayStart+iDisplayIndex +1

       $(nRow).attr('id', 'listid_'+tblid);
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
    { type: null },
    { type: null },
    { type: null },

    ]
  });

   var otherlinkdata=base_url+'settings/user_register/user_summary';
   var otherdata=get_other_ajax_data(otherlinkdata,frmDate,toDate,locationid);

   $(document).off('click','#searchByDate')
   $(document).on('click','#searchByDate',function(){
    frmDate=$('#frmDate').val();
    toDate=$('#toDate').val();  
    departmentid=$('#departmentid').val();
    locationid=$('#locationid').val();
    type=$('#searchByType').val(); 
    dtablelist.fnDraw();  
    get_other_ajax_data(otherlinkdata,frmDate,toDate,locationid,departmentid);   
  });


   $(document).off('click','.approvetype');
   $(document).on('click','.approvetype',function(){
    apptype= $(this).data('approvedtype');
        // alert(apptype);
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();  
        type=$('#searchByType').val();
        fiscalyear=$('#fiscalyear').val(); 
        departmentid=$('#departmentid').val();
        locationid=$('#locationid').val();
        dtablelist.fnDraw();  
        // get_other_ajax_data(otherlinkdata,frmDate,toDate,type);   
      });

 });
</script>



<script>

 $(document).off('click', '.bs_change_status');
 $(document).on('click','.bs_change_status',function(){ 
  var id=$(this).data('id');
  var current_status=$(this).data('status');
  var url=$(this).data('viewurl');

  if(current_status==1){
    var checkname='InActive';
  }
  if(current_status==0){
    var checkname='Active';
  }
  var conf = confirm('Are You Sure To '+checkname+' This User ?');
  if(conf){
    $.ajax({  
      url:url,  
      method:"post",
      data:{id:id,current_status:current_status},
      success: function(jsons)
      {
        console.log(jsons);
        data = jQuery.parseJSON(jsons);
        if(data.status=='success')
        {
         $('#Applyresponse').modal('show');
         $('#response_apply_success').html(data.message);
         window.location.reload();
       }
       else
       {
        $('#Applyresponse').modal('show');
        $('#response_error').html(data.message);
        window.location.reload();
      }
    }  
  });
  }
});
</script>
